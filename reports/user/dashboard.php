<?php
require_once '../includes/config.php';
$page_title = 'Dashboard';
$base_url = '../';
$uid = $_SESSION['userid'];

$total_fir   = mysqli_fetch_row(mysqli_query($con, "SELECT COUNT(*) FROM tbl_fir WHERE UserID=$uid"))[0];
$pending_fir = mysqli_fetch_row(mysqli_query($con, "SELECT COUNT(*) FROM tbl_fir WHERE UserID=$uid AND FIRStatus='Pending'"))[0];
$solved_fir  = mysqli_fetch_row(mysqli_query($con, "SELECT COUNT(*) FROM tbl_fir WHERE UserID=$uid AND FIRStatus='Solved'"))[0];

// Fetch latest 3 news for dashboard widget
$latest_news = mysqli_query($con, "SELECT * FROM news WHERE is_active=1 ORDER BY created_at DESC LIMIT 3");

include '../includes/user-header.php';
?>

<!-- ===== STAT CARDS ===== -->
<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
  <div class="card" style="margin-bottom:0;">
    <div class="stat-card">
      <div class="stat-icon fir"><i class="fas fa-file-alt"></i></div>
      <div class="stat-info">
        <p>Total FIRs Filed</p>
        <h3><?php echo $total_fir; ?></h3>
      </div>
    </div>
    <a href="fir-history.php" class="stat-link">(View All)</a>
  </div>

  <div class="card" style="margin-bottom:0;">
    <div class="stat-card">
      <div class="stat-icon history"><i class="fas fa-clock"></i></div>
      <div class="stat-info">
        <p>Pending FIRs</p>
        <h3><?php echo $pending_fir; ?></h3>
      </div>
    </div>
    <a href="fir-history.php" class="stat-link">(View All)</a>
  </div>

  <div class="card" style="margin-bottom:0;">
    <div class="stat-card">
      <div class="stat-icon" style="background:#4CAF50;"><i class="fas fa-check-circle"></i></div>
      <div class="stat-info">
        <p>Solved FIRs</p>
        <h3><?php echo $solved_fir; ?></h3>
      </div>
    </div>
    <a href="fir-history.php" class="stat-link">(View All)</a>
  </div>

  <div class="card" style="margin-bottom:0;">
    <div class="stat-card">
      <div class="stat-icon cs"><i class="fas fa-file-invoice"></i></div>
      <div class="stat-info">
        <p>File New FIR</p>
        <h3><span style="font-size:14px;font-weight:400;">Click to file</span></h3>
      </div>
    </div>
    <a href="fir-form.php" class="stat-link">(File FIR)</a>
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
    width: 10px;
    height: 10px;
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
    margin-bottom: 2px;
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
</style>

<div class="news-widget">
  <div class="news-widget-header">
    <h3>📰 Daily News</h3>
    <a href="all_news.php">View All →</a>
  </div>

  <?php if (mysqli_num_rows($latest_news) === 0): ?>
    <p class="nw-empty">No news available at the moment.</p>
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
      <div>
        <div class="nw-title">
          <span class="nw-badge nb-<?= $cat_cls ?>"><?= $nrow['category'] ?></span>
          <?= htmlspecialchars($nrow['title']) ?>
        </div>
        <div class="nw-meta">
          By <?= htmlspecialchars($nrow['posted_by_name']) ?>
          &bull; <?= date('d M Y', strtotime($nrow['created_at'])) ?>
        </div>
      </div>
    </div>
    <?php endwhile; ?>
  <?php endif; ?>
</div>

<?php include '../includes/user-footer.php'; ?>