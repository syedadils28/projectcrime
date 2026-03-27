<?php
// admin/news/add_news.php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}
include('../../config/db.php'); // adjust path to your DB connection

$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title    = mysqli_real_escape_string($conn, trim($_POST['title']));
    $content  = mysqli_real_escape_string($conn, trim($_POST['content']));
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $posted_by      = $_SESSION['admin_id'];
    $posted_by_name = mysqli_real_escape_string($conn, $_SESSION['admin_name'] ?? 'Admin');
    $image_name = NULL;

    // Handle optional image upload
    if (!empty($_FILES['image']['name'])) {
        $allowed = ['jpg','jpeg','png','gif','webp'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed)) {
            $image_name = time() . '_' . basename($_FILES['image']['name']);
            $upload_dir = '../../uploads/news/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
            move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $image_name);
        } else {
            $error = "Invalid image format. Use JPG, PNG, GIF or WEBP.";
        }
    }

    if (empty($error)) {
        $img_val = $image_name ? "'$image_name'" : "NULL";
        $sql = "INSERT INTO news (title, content, category, image, posted_by, posted_by_role, posted_by_name, is_active)
                VALUES ('$title', '$content', '$category', $img_val, $posted_by, 'admin', '$posted_by_name', 1)";
        if (mysqli_query($conn, $sql)) {
            $success = "News posted successfully!";
        } else {
            $error = "Database error: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Post News | Admin Panel</title>
<link rel="stylesheet" href="../../assets/css/style.css"> <!-- your existing CSS -->
<style>
.news-form-card { background:#fff; border-radius:8px; padding:30px; box-shadow:0 2px 8px rgba(0,0,0,0.08); max-width:700px; margin:30px auto; }
.form-group { margin-bottom:18px; }
.form-group label { display:block; font-weight:600; margin-bottom:6px; color:#333; }
.form-group input, .form-group select, .form-group textarea {
    width:100%; padding:10px 14px; border:1px solid #ddd; border-radius:6px; font-size:14px; box-sizing:border-box;
}
.form-group textarea { height:150px; resize:vertical; }
.btn-post { background:#007bff; color:#fff; border:none; padding:11px 28px; border-radius:6px; cursor:pointer; font-size:15px; }
.btn-post:hover { background:#0056b3; }
.alert-success { background:#d4edda; color:#155724; padding:10px 16px; border-radius:6px; margin-bottom:16px; }
.alert-error   { background:#f8d7da; color:#721c24; padding:10px 16px; border-radius:6px; margin-bottom:16px; }
</style>
</head>
<body>
<?php include('../includes/header.php'); // your existing header ?>
<?php include('../includes/sidebar.php'); // your existing sidebar ?>

<div class="main-content">
  <div class="page-header"><h2>Post Daily News</h2></div>

  <div class="news-form-card">
    <?php if ($success): ?><div class="alert-success"><?= $success ?></div><?php endif; ?>
    <?php if ($error):   ?><div class="alert-error"><?= $error ?></div><?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label>News Title *</label>
        <input type="text" name="title" placeholder="Enter news headline..." required maxlength="255">
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
        <textarea name="content" placeholder="Write full news content here..." required></textarea>
      </div>
      <div class="form-group">
        <label>Image (optional)</label>
        <input type="file" name="image" accept="image/*">
      </div>
      <button type="submit" class="btn-post">📢 Post News</button>
      &nbsp;&nbsp;<a href="manage_news.php" style="color:#666;">View All News</a>
    </form>
  </div>
</div>
</body>
</html>
