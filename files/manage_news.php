<?php
// admin/news/manage_news.php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}
include('../../config/db.php');

// Handle delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    // Remove image file if exists
    $res = mysqli_query($conn, "SELECT image FROM news WHERE id=$id");
    if ($row = mysqli_fetch_assoc($res)) {
        if ($row['image']) {
            $imgpath = '../../uploads/news/' . $row['image'];
            if (file_exists($imgpath)) unlink($imgpath);
        }
    }
    mysqli_query($conn, "DELETE FROM news WHERE id=$id");
    header("Location: manage_news.php?msg=deleted");
    exit();
}

// Handle toggle active
if (isset($_GET['toggle'])) {
    $id = (int)$_GET['toggle'];
    mysqli_query($conn, "UPDATE news SET is_active = 1 - is_active WHERE id=$id");
    header("Location: manage_news.php");
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM news ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage News | Admin Panel</title>
<link rel="stylesheet" href="../../assets/css/style.css">
<style>
.news-table { width:100%; border-collapse:collapse; background:#fff; border-radius:8px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.07); }
.news-table th { background:#1a2942; color:#fff; padding:12px 15px; text-align:left; font-size:13px; }
.news-table td { padding:11px 15px; border-bottom:1px solid #eee; font-size:13px; vertical-align:top; }
.news-table tr:hover td { background:#f9f9f9; }
.badge { padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600; }
.badge-general   { background:#e3f2fd; color:#1565c0; }
.badge-crime     { background:#fce4ec; color:#b71c1c; }
.badge-missing   { background:#fff3e0; color:#e65100; }
.badge-notice    { background:#e8f5e9; color:#2e7d32; }
.badge-update    { background:#ede7f6; color:#4527a0; }
.btn-sm { padding:5px 12px; border-radius:5px; font-size:12px; text-decoration:none; border:none; cursor:pointer; }
.btn-edit   { background:#ffc107; color:#000; }
.btn-delete { background:#dc3545; color:#fff; }
.btn-toggle { background:#17a2b8; color:#fff; }
.btn-add    { background:#28a745; color:#fff; padding:9px 20px; border-radius:6px; text-decoration:none; font-size:14px; }
.alert-info { background:#d1ecf1; color:#0c5460; padding:10px 16px; border-radius:6px; margin-bottom:16px; }
</style>
</head>
<body>
<?php include('../includes/header.php'); ?>
<?php include('../includes/sidebar.php'); ?>

<div class="main-content">
  <div class="page-header" style="display:flex;justify-content:space-between;align-items:center;">
    <h2>Manage Daily News</h2>
    <a href="add_news.php" class="btn-add">+ Post News</a>
  </div>

  <?php if (isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
    <div class="alert-info">News item deleted successfully.</div>
  <?php endif; ?>

  <table class="news-table">
    <thead>
      <tr>
        <th>#</th><th>Title</th><th>Category</th><th>Posted By</th><th>Role</th><th>Date</th><th>Status</th><th>Actions</th>
      </tr>
    </thead>
    <tbody>
    <?php $i=1; while ($row = mysqli_fetch_assoc($result)): ?>
      <?php
        $cat_class = match($row['category']) {
            'Crime Alert'    => 'crime',
            'Missing Person' => 'missing',
            'Notice'         => 'notice',
            'Update'         => 'update',
            default          => 'general'
        };
      ?>
      <tr>
        <td><?= $i++ ?></td>
        <td><strong><?= htmlspecialchars($row['title']) ?></strong><br>
            <small style="color:#888;"><?= mb_substr(strip_tags($row['content']),0,60) ?>...</small></td>
        <td><span class="badge badge-<?= $cat_class ?>"><?= $row['category'] ?></span></td>
        <td><?= htmlspecialchars($row['posted_by_name']) ?></td>
        <td><?= ucfirst($row['posted_by_role']) ?></td>
        <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>
        <td><?= $row['is_active'] ? '<span style="color:green;">Active</span>' : '<span style="color:red;">Hidden</span>' ?></td>
        <td>
          <a href="edit_news.php?id=<?= $row['id'] ?>" class="btn-sm btn-edit">Edit</a>
          <a href="?toggle=<?= $row['id'] ?>" class="btn-sm btn-toggle"><?= $row['is_active'] ? 'Hide' : 'Show' ?></a>
          <a href="?delete=<?= $row['id'] ?>" class="btn-sm btn-delete"
             onclick="return confirm('Delete this news?')">Delete</a>
        </td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>
