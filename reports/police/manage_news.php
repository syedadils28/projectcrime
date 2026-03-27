<?php
// reports/police/manage_news.php
session_start();

if (!isset($_SESSION['policeid'])) {
    header("Location: login.php");
    exit();
}

include('../includes/config.php'); // provides $con

$police_id  = (int)$_SESSION['policeid'];
$station_id = isset($_SESSION['police_station']) ? (int)$_SESSION['police_station'] : 0;

// Handle delete — police can only delete their own news
if (isset($_GET['delete'])) {
    $id  = (int)$_GET['delete'];
    $res = mysqli_fetch_assoc(mysqli_query($con,
        "SELECT * FROM news WHERE id=$id AND posted_by=$police_id AND posted_by_role='police'"
    ));
    if ($res) {
        if ($res['image'] && file_exists('../uploads/news/' . $res['image'])) {
            unlink('../uploads/news/' . $res['image']);
        }
        mysqli_query($con, "DELETE FROM news WHERE id=$id");
    }
    header("Location: manage_news.php?msg=deleted");
    exit();
}

$success = $error = "";

// Handle post new news
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_news'])) {
    $title    = mysqli_real_escape_string($con, trim($_POST['title']));
    $content  = mysqli_real_escape_string($con, trim($_POST['content']));
    $category = mysqli_real_escape_string($con, $_POST['category']);
    $name     = mysqli_real_escape_string($con, $_SESSION['police_name'] ?? 'Police');
    $sid      = $station_id ?: 'NULL';
    $image_name = null;

    if (!empty($_FILES['image']['name'])) {
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
            $image_name = time() . '_' . basename($_FILES['image']['name']);
            $dir = '../uploads/news/';
            if (!is_dir($dir)) mkdir($dir, 0755, true);
            move_uploaded_file($_FILES['image']['tmp_name'], $dir . $image_name);
        } else {
            $error = "Invalid image format. Allowed: jpg, jpeg, png, gif, webp.";
        }
    }

    if (empty($error)) {
        $img_val = $image_name ? "'$image_name'" : "NULL";
        $sql = "INSERT INTO news (title, content, category, image, posted_by, posted_by_role, posted_by_name, station_id, is_active)
                VALUES ('$title','$content','$category',$img_val,$police_id,'police','$name',$sid,1)";
        if (mysqli_query($con, $sql)) {
            $success = "News posted successfully!";
        } else {
            $error = mysqli_error($con);
        }
    }
}

// Fetch only this officer's news
$result = mysqli_query($con,
    "SELECT * FROM news WHERE posted_by=$police_id AND posted_by_role='police' ORDER BY created_at DESC"
);

$page_title = 'Daily News';
$base_url   = '../';
$breadcrumb = [['label' => 'Daily News']];

include('../includes/police-header.php');
?>

  <style>
    .news-section { display:grid; grid-template-columns:1fr 1fr; gap:24px; margin-top:20px; }
    @media(max-width:768px){ .news-section{ grid-template-columns:1fr; } }
    .card-box { background:#fff; border-radius:8px; padding:24px; box-shadow:0 2px 8px rgba(0,0,0,0.07); }
    .form-group { margin-bottom:14px; }
    .form-group label { display:block; font-weight:600; margin-bottom:5px; color:#333; font-size:13px; }
    .form-group input, .form-group select, .form-group textarea {
        width:100%; padding:9px 12px; border:1px solid #ddd; border-radius:5px;
        font-size:13px; box-sizing:border-box;
    }
    .form-group textarea { height:120px; resize:vertical; }
    .btn-post { background:#007bff; color:#fff; border:none; padding:9px 22px; border-radius:5px; cursor:pointer; font-size:14px; }
    .btn-post:hover { background:#0056b3; }
    .news-item { border-bottom:1px solid #eee; padding:12px 0; }
    .news-item:last-child { border:none; }
    .news-title { font-weight:700; font-size:14px; color:#222; margin-bottom:4px; }
    .news-meta  { font-size:11px; color:#888; margin-bottom:6px; }
    .badge { padding:2px 9px; border-radius:20px; font-size:11px; font-weight:600; }
    .badge-general { background:#e3f2fd; color:#1565c0; }
    .badge-crime   { background:#fce4ec; color:#b71c1c; }
    .badge-missing { background:#fff3e0; color:#e65100; }
    .badge-notice  { background:#e8f5e9; color:#2e7d32; }
    .badge-update  { background:#ede7f6; color:#4527a0; }
    .btn-sm { padding:4px 10px; border-radius:4px; font-size:12px; text-decoration:none; border:none; cursor:pointer; margin-right:4px; display:inline-block; }
    .btn-edit   { background:#ffc107; color:#000; }
    .btn-delete { background:#dc3545; color:#fff; }
    .alert-success { background:#d4edda; color:#155724; padding:9px 14px; border-radius:5px; margin-bottom:14px; font-size:13px; }
    .alert-error   { background:#f8d7da; color:#721c24; padding:9px 14px; border-radius:5px; margin-bottom:14px; font-size:13px; }
  </style>

  <?php if ($success): ?><div class="alert-success"><?= htmlspecialchars($success) ?></div><?php endif; ?>
  <?php if ($error):   ?><div class="alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
  <?php if (isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
    <div class="alert-success">News deleted successfully.</div>
  <?php endif; ?>

  <div class="news-section">

    <!-- POST FORM -->
    <div class="card-box">
      <h3 style="margin-top:0;font-size:16px;">📢 Post News</h3>
      <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label>Title *</label>
          <input type="text" name="title" placeholder="News headline..." required maxlength="255">
        </div>
        <div class="form-group">
          <label>Category</label>
          <select name="category">
            <option value="General">General</option>
            <option value="Crime Alert">Crime Alert</option>
            <option value="Missing Person">Missing Person</option>
            <option value="Notice">Notice</option>
            <option value="Update">Update</option>
          </select>
        </div>
        <div class="form-group">
          <label>Content *</label>
          <textarea name="content" placeholder="Write news details..." required></textarea>
        </div>
        <div class="form-group">
          <label>Image (optional)</label>
          <input type="file" name="image" accept="image/*">
        </div>
        <button type="submit" name="post_news" class="btn-post">📨 Post News</button>
      </form>
    </div>

    <!-- MY NEWS LIST -->
    <div class="card-box">
      <h3 style="margin-top:0;font-size:16px;">📋 My Posted News</h3>
      <?php if (mysqli_num_rows($result) === 0): ?>
        <p style="color:#888;font-size:13px;">No news posted yet.</p>
      <?php else: ?>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
          <?php
            $cat_class = match($row['category']) {
                'Crime Alert'    => 'crime',
                'Missing Person' => 'missing',
                'Notice'         => 'notice',
                'Update'         => 'update',
                default          => 'general'
            };
          ?>
          <div class="news-item">
            <div class="news-title"><?= htmlspecialchars($row['title']) ?></div>
            <div class="news-meta">
              <span class="badge badge-<?= $cat_class ?>"><?= htmlspecialchars($row['category']) ?></span>
              &nbsp;<?= date('d M Y', strtotime($row['created_at'])) ?>
              &nbsp;<?= $row['is_active']
                ? '<span style="color:green;">● Active</span>'
                : '<span style="color:#bbb;">● Hidden</span>' ?>
            </div>
            <a href="edit_news.php?id=<?= (int)$row['id'] ?>" class="btn-sm btn-edit">✏️ Edit</a>
            <a href="?delete=<?= (int)$row['id'] ?>" class="btn-sm btn-delete"
               onclick="return confirm('Delete this news?')">🗑️ Delete</a>
          </div>
        <?php endwhile; ?>
      <?php endif; ?>
    </div>

  </div>

<?php include('../includes/police-footer.php'); ?>