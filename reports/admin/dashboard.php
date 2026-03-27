<?php
require_once '../includes/config.php';
$page_title = 'Dashboard';
$base_url = '../';

$total_criminals = mysqli_fetch_row(mysqli_query($con,"SELECT COUNT(*) FROM tbl_criminal"))[0];
$total_police    = mysqli_fetch_row(mysqli_query($con,"SELECT COUNT(*) FROM tbl_police"))[0];
$total_category  = mysqli_fetch_row(mysqli_query($con,"SELECT COUNT(*) FROM tbl_crimecategory"))[0];
$total_stations  = mysqli_fetch_row(mysqli_query($con,"SELECT COUNT(*) FROM tbl_policestation"))[0];
$total_fir       = mysqli_fetch_row(mysqli_query($con,"SELECT COUNT(*) FROM tbl_fir"))[0];

// Fetch latest 3 news for widget
$latest_news = mysqli_query($con, "SELECT * FROM news WHERE is_active=1 ORDER BY created_at DESC LIMIT 3");

include '../includes/admin-header.php';
?>

<!-- ===== STAT CARDS ===== -->
<div class="dash-grid">
  <div class="card" style="margin-bottom:0;">
    <div class="stat-card">
      <div class="stat-icon teal"><i class="fas fa-users"></i></div>
      <div class="stat-info">
        <p>Total Criminals</p>
        <h3><?php echo $total_criminals; ?></h3>
      </div>
    </div>
    <a href="view-criminals.php" class="stat-link">(view all)</a>
  </div>

  <div class="card" style="margin-bottom:0;">
    <div class="stat-card">
      <div class="stat-icon red"><i class="fas fa-user-shield"></i></div>
      <div class="stat-info">
        <p>Total Police</p>
        <h3><?php echo $total_police; ?></h3>
      </div>
    </div>
    <a href="manage-police.php" class="stat-link">(View All)</a>
  </div>

  <div class="card" style="margin-bottom:0;">
    <div class="stat-card">
      <div class="stat-icon green"><i class="fas fa-file-alt"></i></div>
      <div class="stat-info">
        <p>Total Crime Categories</p>
        <h3><?php echo $total_category; ?></h3>
      </div>
    </div>
    <a href="manage-crime-categories.php" class="stat-link">(View All)</a>
  </div>

  <div class="card" style="margin-bottom:0;">
    <div class="stat-card">
      <div class="stat-icon purple"><i class="fas fa-building"></i></div>
      <div class="stat-info">
        <p>Total Police Stations</p>
        <h3><?php echo $total_stations; ?></h3>
      </div>
    </div>
    <a href="manage-police-stations.php" class="stat-link">(view all)</a>
  </div>
</div>

<div style="margin-top:20px;">
  <div class="card" style="max-width:400px;">
    <div class="stat-card">
      <div class="stat-icon purple"><i class="fas fa-file-alt"></i></div>
      <div class="stat-info">
        <p>Total FIRS</p>
        <h3><?php echo $total_fir; ?></h3>
      </div>
    </div>
    <a href="view-fir.php" class="stat-link">(View All)</a>
  </div>
</div>

<!-- ===== DAILY NEWS WIDGET ===== -->
<style>
.news-widget {
    background: #fff;
    border-radius: 8px;
    padding: 20px 24px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.07);
    margin-top: 24px;
}
.news-widget-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 2px solid #f0f0f0;
    padding-bottom: 12px;
    margin-bottom: 14px;
}
.news-widget-header h3 {
    margin: 0;
    font-size: 15px;
    color: #1a2942;
    font-weight: 700;
}
.news-widget-header a {
    font-size: 12px;
    color: #007bff;
    text-decoration: none;
}
.news-widget-header a:hover { text-decoration: underline; }
.nw-item {
    display: flex;
    gap: 12px;
    padding: 10px 0;
    border-bottom: 1px solid #f4f4f4;
    align-items: flex-start;
}
.nw-item:last-child { border: none; padding-bottom: 0; }
.nw-dot {
    width: 10px; height: 10px;
    border-radius: 50%;
    background: #007bff;
    margin-top: 4px;
    flex-shrink: 0;
}
.nw-dot.crime   { background: #dc3545; }
.nw-dot.missing { background: #fd7e14; }
.nw-dot.notice  { background: #28a745; }
.nw-dot.update  { background: #6f42c1; }
.nw-title {
    font-size: 13px;
    font-weight: 600;
    color: #222;
    margin-bottom: 3px;
    line-height: 1.4;
}
.nw-meta { font-size: 11px; color: #999; }
.nw-badge {
    display: inline-block;
    padding: 1px 8px;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 700;
    margin-right: 5px;
}
.nb-general { background:#e3f2fd; color:#1565c0; }
.nb-crime   { background:#fce4ec; color:#b71c1c; }
.nb-missing { background:#fff3e0; color:#e65100; }
.nb-notice  { background:#e8f5e9; color:#2e7d32; }
.nb-update  { background:#ede7f6; color:#4527a0; }
.nw-empty   { color: #aaa; font-size: 13px; text-align: center; padding: 16px 0; }
.nw-actions { display:flex; gap:8px; margin-top:4px; }
.nw-actions a {
    font-size: 11px;
    color: #007bff;
    text-decoration: none;
    padding: 2px 8px;
    border-radius: 4px;
    background: #e8f4fd;
}
.nw-actions a:hover { background: #007bff; color: #fff; }
.nw-actions a.del { background:#fde8e8; color:#dc3545; }
.nw-actions a.del:hover { background:#dc3545; color:#fff; }
</style>

<div class="news-widget">
  <div class="news-widget-header">
    <h3>📰 Daily News</h3>
    <div style="display:flex;gap:12px;align-items:center;">
      <a href="add_news.php">+ Post News</a>
      <a href="manage_news.php">Manage All →</a>
    </div>
  </div>

  <?php if (mysqli_num_rows($latest_news) === 0): ?>
    <p class="nw-empty">No news posted yet. <a href="add_news.php">Post your first news</a>.</p>
  <?php else: ?>
    <?php while ($nrow = mysqli_fetch_assoc($latest_news)):
      $cat_cls = match($nrow['category']) {
          'Crime Alert'    => 'crime',
          'Missing Person' => 'missing',
          'Notice'         => 'notice',
          'Update'         => 'update',
          default          => 'general'
      };
    ?>
    <div class="nw-item">
      <div class="nw-dot <?= $cat_cls ?>"></div>
      <div style="flex:1;">
        <div class="nw-title">
          <span class="nw-badge nb-<?= $cat_cls ?>"><?= $nrow['category'] ?></span>
          <?= htmlspecialchars($nrow['title']) ?>
        </div>
        <div class="nw-meta">
          By <?= htmlspecialchars($nrow['posted_by_name']) ?>
          &bull; <?= date('d M Y', strtotime($nrow['created_at'])) ?>
          &bull; <?= $nrow['is_active'] ? '<span style="color:green;">Active</span>' : '<span style="color:red;">Hidden</span>' ?>
        </div>
        <div class="nw-actions">
          <a href="edit_news.php?id=<?= $nrow['id'] ?>">✏ Edit</a>
          <a href="manage_news.php?delete=<?= $nrow['id'] ?>" class="del"
             onclick="return confirm('Delete this news?')">🗑 Delete</a>
        </div>
      </div>
    </div>
    <?php endwhile; ?>
  <?php endif; ?>
</div>

<?php include '../includes/admin-footer.php'; ?>