<?php
require_once '../includes/config.php';
$page_title = 'Manage News';
$base_url   = '../';
$breadcrumb = [['label' => 'Daily News'], ['label' => 'Manage News']];

if (!isset($_SESSION['adminid'])) {
    header("Location: login.php");
    exit();
}

// Handle delete
if (isset($_GET['delete'])) {
    $id  = (int)$_GET['delete'];
    $res = mysqli_query($con, "SELECT image FROM news WHERE id=$id");
    if ($row = mysqli_fetch_assoc($res)) {
        if ($row['image']) {
            $imgpath = '../uploads/news/' . $row['image'];
            if (file_exists($imgpath)) unlink($imgpath);
        }
    }
    mysqli_query($con, "DELETE FROM news WHERE id=$id");
    header("Location: manage_news.php?msg=deleted");
    exit();
}

// Handle show/hide toggle
if (isset($_GET['toggle'])) {
    $id = (int)$_GET['toggle'];
    mysqli_query($con, "UPDATE news SET is_active = 1 - is_active WHERE id=$id");
    header("Location: manage_news.php");
    exit();
}

$result = mysqli_query($con, "SELECT * FROM news ORDER BY created_at DESC");

include '../includes/admin-header.php';
?>

<style>
.top-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 18px;
}
.news-table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.07);
}
.news-table th {
    background: #1a2942;
    color: #fff;
    padding: 12px 15px;
    text-align: left;
    font-size: 13px;
    font-weight: 600;
}
.news-table td {
    padding: 11px 15px;
    border-bottom: 1px solid #eee;
    font-size: 13px;
    vertical-align: top;
}
.news-table tr:last-child td { border-bottom: none; }
.news-table tr:hover td { background: #f9f9f9; }
.badge {
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    display: inline-block;
}
.badge-general { background:#e3f2fd; color:#1565c0; }
.badge-crime   { background:#fce4ec; color:#b71c1c; }
.badge-missing { background:#fff3e0; color:#e65100; }
.badge-notice  { background:#e8f5e9; color:#2e7d32; }
.badge-update  { background:#ede7f6; color:#4527a0; }
.btn-sm {
    padding: 5px 11px;
    border-radius: 5px;
    font-size: 12px;
    text-decoration: none;
    border: none;
    cursor: pointer;
    display: inline-block;
    margin: 2px 1px;
    font-weight: 500;
}
.btn-edit   { background:#ffc107; color:#000; }
.btn-delete { background:#dc3545; color:#fff; }
.btn-toggle-on  { background:#17a2b8; color:#fff; }
.btn-toggle-off { background:#6c757d; color:#fff; }
.btn-add {
    background: #28a745;
    color: #fff;
    padding: 9px 20px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
}
.alert-info {
    background: #d1ecf1; color: #0c5460;
    padding: 10px 16px; border-radius: 6px; margin-bottom: 16px;
}
.news-thumb {
    width: 50px; height: 40px;
    object-fit: cover;
    border-radius: 4px;
    border: 1px solid #eee;
}
</style>

<div class="top-bar">
    <span style="font-size:13px;color:#666;">
        Total: <strong><?= mysqli_num_rows($result) ?></strong> news item(s)
    </span>
    <a href="add_news.php" class="btn-add">+ Post News</a>
</div>

<?php if (isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
    <div class="alert-info">✅ News item deleted successfully.</div>
<?php endif; ?>

<table class="news-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Image</th>
            <th>Title &amp; Preview</th>
            <th>Category</th>
            <th>Posted By</th>
            <th>Role</th>
            <th>Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php if (mysqli_num_rows($result) === 0): ?>
        <tr>
            <td colspan="9" style="text-align:center;color:#888;padding:30px;">
                No news found. <a href="add_news.php" style="color:#007bff;">Post your first news</a>.
            </td>
        </tr>
    <?php else:
        $i = 1;
        while ($row = mysqli_fetch_assoc($result)):
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
            <td>
                <?php if ($row['image']): ?>
                    <img src="../uploads/news/<?= htmlspecialchars($row['image']) ?>"
                         class="news-thumb" alt="img">
                <?php else: ?>
                    <span style="color:#ccc;font-size:11px;">No image</span>
                <?php endif; ?>
            </td>
            <td>
                <strong><?= htmlspecialchars($row['title']) ?></strong><br>
                <small style="color:#888;">
                    <?= htmlspecialchars(mb_substr(strip_tags($row['content']), 0, 70)) ?>...
                </small>
            </td>
            <td>
                <span class="badge badge-<?= $cat_class ?>">
                    <?= htmlspecialchars($row['category']) ?>
                </span>
            </td>
            <td><?= htmlspecialchars($row['posted_by_name']) ?></td>
            <td><?= ucfirst(htmlspecialchars($row['posted_by_role'])) ?></td>
            <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>
            <td>
                <?= $row['is_active']
                    ? '<span style="color:green;font-weight:600;">● Active</span>'
                    : '<span style="color:#aaa;font-weight:600;">● Hidden</span>' ?>
            </td>
            <td>
                <a href="edit_news.php?id=<?= $row['id'] ?>" class="btn-sm btn-edit">✏ Edit</a>
                <a href="?toggle=<?= $row['id'] ?>"
                   class="btn-sm <?= $row['is_active'] ? 'btn-toggle-on' : 'btn-toggle-off' ?>">
                    <?= $row['is_active'] ? 'Hide' : 'Show' ?>
                </a>
                <a href="?delete=<?= $row['id'] ?>" class="btn-sm btn-delete"
                   onclick="return confirm('Are you sure you want to delete this news?')">
                    🗑 Delete
                </a>
            </td>
        </tr>
    <?php endwhile; endif; ?>
    </tbody>
</table>

<?php include '../includes/admin-footer.php'; ?>