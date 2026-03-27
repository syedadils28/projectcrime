<?php
require_once '../includes/config.php';
$page_title = 'Daily News';
$base_url = '../';

// Session check - using your actual session variable
if (!isset($_SESSION['userid']) && !isset($_SESSION['police_id']) && !isset($_SESSION['admin_id'])) {
    header("Location: ../signin.php");
    exit();
}

$is_police = isset($_SESSION['police_id']);
$is_admin  = isset($_SESSION['admin_id']);

// Filter by category
$cat_filter = isset($_GET['cat']) ? mysqli_real_escape_string($con, $_GET['cat']) : '';
$where = "WHERE is_active=1";
if ($cat_filter) $where .= " AND category='$cat_filter'";

$result   = mysqli_query($con, "SELECT * FROM news $where ORDER BY created_at DESC");
$categories = ['General', 'Crime Alert', 'Missing Person', 'Notice', 'Update'];

include '../includes/user-header.php';
?>

<style>
.news-filters {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 24px;
}
.filter-btn {
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-decoration: none;
    background: #f0f0f0;
    color: #555;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
}
.filter-btn.active, .filter-btn:hover {
    background: #1a2942;
    color: #fff;
}
.news-card {
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    margin-bottom: 20px;
    transition: box-shadow 0.2s;
}
.news-card:hover { box-shadow: 0 4px 18px rgba(0,0,0,0.13); }
.news-card img   { width: 100%; height: 200px; object-fit: cover; }
.news-card-body  { padding: 18px 22px; }
.news-card-title { font-size: 16px; font-weight: 700; color: #1a2942; margin-bottom: 5px; }
.news-card-meta  { font-size: 12px; color: #888; margin-bottom: 10px; }
.news-card-text  { font-size: 13px; color: #444; line-height: 1.7; }
.news-badge {
    display: inline-block;
    padding: 2px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
    margin-right: 6px;
    vertical-align: middle;
}
.nb-general { background:#e3f2fd; color:#1565c0; }
.nb-crime   { background:#fce4ec; color:#b71c1c; }
.nb-missing { background:#fff3e0; color:#e65100; }
.nb-notice  { background:#e8f5e9; color:#2e7d32; }
.nb-update  { background:#ede7f6; color:#4527a0; }
.read-more  { display:inline-block; margin-top:10px; color:#007bff; font-size:13px; text-decoration:none; }
.no-news    { text-align:center; color:#aaa; padding:60px 0; font-size:15px; }
.news-page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}
.news-page-header h2 { margin: 0; font-size: 20px; color: #1a2942; }
.btn-manage {
    background: #007bff;
    color: #fff;
    padding: 8px 18px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 13px;
}
</style>

<div class="news-page-header">
    <h2>📰 Daily News</h2>
    <?php if ($is_police): ?>
        <a href="../police/manage_news.php" class="btn-manage">+ Post / Manage My News</a>
    <?php elseif ($is_admin): ?>
        <a href="../admin/news/add_news.php" class="btn-manage">+ Post News</a>
    <?php endif; ?>
</div>

<!-- Category filters -->
<div class="news-filters">
    <a href="all_news.php" class="filter-btn <?= !$cat_filter ? 'active' : '' ?>">All</a>
    <?php foreach ($categories as $c): ?>
        <a href="?cat=<?= urlencode($c) ?>"
           class="filter-btn <?= $cat_filter === $c ? 'active' : '' ?>"><?= $c ?></a>
    <?php endforeach; ?>
</div>

<!-- News list -->
<?php if (mysqli_num_rows($result) === 0): ?>
    <div class="no-news">📭 No news available right now. Check back later.</div>
<?php else: ?>
    <?php while ($row = mysqli_fetch_assoc($result)):
        $cat_cls = match($row['category']) {
            'Crime Alert'    => 'crime',
            'Missing Person' => 'missing',
            'Notice'         => 'notice',
            'Update'         => 'update',
            default          => 'general'
        };
        $can_manage = $is_admin ||
            ($is_police && $_SESSION['police_id'] == $row['posted_by'] && $row['posted_by_role'] === 'police');
    ?>
    <div class="news-card">
        <?php if ($row['image']): ?>
            <img src="../uploads/news/<?= htmlspecialchars($row['image']) ?>" alt="news image">
        <?php endif; ?>
        <div class="news-card-body">
            <?php if ($can_manage): ?>
                <div style="float:right;">
                    <a href="<?= $is_admin ? '../admin/news/edit_news.php' : '../police/news/edit_news.php' ?>?id=<?= $row['id'] ?>"
                       style="padding:4px 10px;border-radius:4px;font-size:12px;background:#ffc107;color:#000;text-decoration:none;">Edit</a>
                    &nbsp;
                    <a href="<?= $is_admin ? '../admin/news/manage_news.php' : '../police/news/manage_news.php' ?>?delete=<?= $row['id'] ?>"
                       style="padding:4px 10px;border-radius:4px;font-size:12px;background:#dc3545;color:#fff;text-decoration:none;"
                       onclick="return confirm('Delete this news?')">Delete</a>
                </div>
            <?php endif; ?>
            <div>
                <span class="news-badge nb-<?= $cat_cls ?>"><?= $row['category'] ?></span>
                <span class="news-card-title"><?= htmlspecialchars($row['title']) ?></span>
                <div class="news-card-meta">
                    By <?= htmlspecialchars($row['posted_by_name']) ?> (<?= ucfirst($row['posted_by_role']) ?>)
                    &bull; <?= date('d M Y, h:i A', strtotime($row['created_at'])) ?>
                </div>
                <div class="news-card-text">
                    <?= nl2br(htmlspecialchars(mb_substr($row['content'], 0, 300))) ?>
                    <?= strlen($row['content']) > 300 ? '...' : '' ?>
                </div>
                <?php if (strlen($row['content']) > 300): ?>
                    <a href="view_news.php?id=<?= $row['id'] ?>" class="read-more">Read more →</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endwhile; ?>
<?php endif; ?>

<?php include '../includes/user-footer.php'; ?>