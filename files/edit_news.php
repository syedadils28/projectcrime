<?php
// Works for both admin/news/edit_news.php AND police/news/edit_news.php
// Just change the session check below per panel

session_start();

// --- Adjust for Police Panel ---
// For police: change to $_SESSION['police_id'] and '../login.php'
$is_admin  = isset($_SESSION['admin_id']);
$is_police = isset($_SESSION['police_id']);
if (!$is_admin && !$is_police) {
    header("Location: ../../login.php");
    exit();
}

include('../../config/db.php');

$id = (int)($_GET['id'] ?? 0);
if (!$id) { header("Location: manage_news.php"); exit(); }

// Police can only edit their own news
if ($is_police) {
    $pid = (int)$_SESSION['police_id'];
    $check = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM news WHERE id=$id AND posted_by=$pid AND posted_by_role='police'"));
    if (!$check) { echo "Unauthorized."; exit(); }
}

$news = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM news WHERE id=$id"));
if (!$news) { echo "News not found."; exit(); }

$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title    = mysqli_real_escape_string($conn, trim($_POST['title']));
    $content  = mysqli_real_escape_string($conn, trim($_POST['content']));
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $image_name = $news['image'];

    if (!empty($_FILES['image']['name'])) {
        $allowed = ['jpg','jpeg','png','gif','webp'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed)) {
            // Remove old image
            if ($image_name && file_exists('../../uploads/news/' . $image_name)) {
                unlink('../../uploads/news/' . $image_name);
            }
            $image_name = time() . '_' . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], '../../uploads/news/' . $image_name);
        } else {
            $error = "Invalid image format.";
        }
    }

    if (empty($error)) {
        $img_val = $image_name ? "'$image_name'" : "NULL";
        $sql = "UPDATE news SET title='$title', content='$content', category='$category', image=$img_val WHERE id=$id";
        if (mysqli_query($conn, $sql)) {
            $success = "News updated successfully!";
            $news = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM news WHERE id=$id"));
        } else {
            $error = mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit News</title>
<link rel="stylesheet" href="../../assets/css/style.css">
<style>
.news-form-card { background:#fff; border-radius:8px; padding:30px; box-shadow:0 2px 8px rgba(0,0,0,0.08); max-width:700px; margin:30px auto; }
.form-group { margin-bottom:18px; }
.form-group label { display:block; font-weight:600; margin-bottom:6px; color:#333; }
.form-group input, .form-group select, .form-group textarea {
    width:100%; padding:10px 14px; border:1px solid #ddd; border-radius:6px; font-size:14px; box-sizing:border-box;
}
.form-group textarea { height:150px; resize:vertical; }
.btn-update { background:#007bff; color:#fff; border:none; padding:11px 28px; border-radius:6px; cursor:pointer; font-size:15px; }
.alert-success { background:#d4edda; color:#155724; padding:10px 16px; border-radius:6px; margin-bottom:16px; }
.alert-error   { background:#f8d7da; color:#721c24; padding:10px 16px; border-radius:6px; margin-bottom:16px; }
.current-img img { max-height:120px; border-radius:6px; border:1px solid #eee; margin-top:8px; }
</style>
</head>
<body>
<?php include('../includes/header.php'); ?>
<?php include('../includes/sidebar.php'); ?>

<div class="main-content">
  <div class="page-header"><h2>Edit News</h2></div>
  <div class="news-form-card">
    <?php if ($success): ?><div class="alert-success"><?= $success ?></div><?php endif; ?>
    <?php if ($error):   ?><div class="alert-error"><?= $error ?></div><?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label>Title *</label>
        <input type="text" name="title" value="<?= htmlspecialchars($news['title']) ?>" required maxlength="255">
      </div>
      <div class="form-group">
        <label>Category</label>
        <select name="category">
          <?php foreach(['General','Crime Alert','Missing Person','Notice','Update'] as $cat): ?>
          <option value="<?= $cat ?>" <?= $news['category']==$cat?'selected':'' ?>><?= $cat ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="form-group">
        <label>Content *</label>
        <textarea name="content" required><?= htmlspecialchars($news['content']) ?></textarea>
      </div>
      <div class="form-group">
        <label>Image (leave blank to keep existing)</label>
        <?php if ($news['image']): ?>
        <div class="current-img">
          <small>Current:</small><br>
          <img src="../../uploads/news/<?= htmlspecialchars($news['image']) ?>" alt="news image">
        </div>
        <?php endif; ?>
        <input type="file" name="image" accept="image/*" style="margin-top:8px;">
      </div>
      <button type="submit" class="btn-update">💾 Update News</button>
      &nbsp;&nbsp;<a href="manage_news.php" style="color:#666;">← Back</a>
    </form>
  </div>
</div>
</body>
</html>
