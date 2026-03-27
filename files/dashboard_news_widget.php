<?php
/* ================================================================
   NEWS WIDGET — include this snippet in any dashboard file
   Shows latest 3 active news items with a "View All" link

   Usage:
     Admin dashboard:  include('news/dashboard_news_widget.php');
     Police dashboard: include('news/dashboard_news_widget.php');
     User dashboard:   include('news/dashboard_news_widget.php');

   Just include it where you want the card to appear.
================================================================ */

// Make sure $conn is already defined before this include
if (!isset($conn)) {
    die("Error: Database connection not found. Please ensure this file is included after database connection is established.");
}
$latest_news = mysqli_query($conn, "SELECT * FROM news WHERE is_active=1 ORDER BY created_at DESC LIMIT 3");
if (!$latest_news) {
    die("Query failed: " . mysqli_error($conn));
}

include('config/db.php');

?>

<!-- ===== PASTE THIS CSS IN YOUR EXISTING <style> or stylesheet ===== -->
<style>
.news-dashboard-card {
    background:#fff;
    border-radius:8px;
    padding:20px 24px;
    box-shadow:0 2px 8px rgba(0,0,0,0.07);
    margin-bottom:20px;
}
.news-dashboard-card .card-header {
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:16px;
    border-bottom:2px solid #f0f0f0;
    padding-bottom:10px;
}
.news-dashboard-card .card-header h3 {
    margin:0;
    font-size:15px;
    color:#1a2942;
    font-weight:700;
}
.news-dashboard-card .card-header a {
    font-size:12px;
    color:#007bff;
    text-decoration:none;
}
.news-item-mini {
    display:flex;
    gap:12px;
    padding:10px 0;
    border-bottom:1px solid #f4f4f4;
    align-items:flex-start;
}
.news-item-mini:last-child { border:none; }
.news-dot {
    width:10px; height:10px; border-radius:50%;
    background:#007bff; margin-top:5px; flex-shrink:0;
}
.news-dot.crime   { background:#dc3545; }
.news-dot.missing { background:#fd7e14; }
.news-dot.notice  { background:#28a745; }
.news-dot.update  { background:#6f42c1; }
.news-item-mini .ni-title {
    font-size:13px;
    font-weight:600;
    color:#222;
    margin-bottom:2px;
    line-height:1.4;
}
.news-item-mini .ni-meta {
    font-size:11px;
    color:#999;
}
.news-empty {
    color:#aaa;
    font-size:13px;
    text-align:center;
    padding:16px 0;
}
.news-badge {
    display:inline-block;
    padding:1px 8px;
    border-radius:20px;
    font-size:10px;
    font-weight:700;
    margin-right:5px;
}
.nb-general { background:#e3f2fd;color:#1565c0; }
.nb-crime   { background:#fce4ec;color:#b71c1c; }
.nb-missing { background:#fff3e0;color:#e65100; }
.nb-notice  { background:#e8f5e9;color:#2e7d32; }
.nb-update  { background:#ede7f6;color:#4527a0; }
</style>

<!-- ===== PASTE THIS HTML WHERE YOU WANT THE NEWS CARD ===== -->
<div class="news-dashboard-card">
  <div class="card-header">
    <h3>📰 Daily News</h3>
    <!-- Adjust path based on panel: user/news/all_news.php etc. -->
    <a href="news/all_news.php">View All →</a>
  </div>

  <?php if ($latest_news && mysqli_num_rows($latest_news) === 0): ?>
    <p class="news-empty">No news available at the moment.</p>
  <?php else: ?>
    <?php while ($nrow = mysqli_fetch_assoc($latest_news)):
      $cat_cls = match($nrow['category']) {
          'Crime Alert'=>'crime','Missing Person'=>'missing',
          'Notice'=>'notice','Update'=>'update',default=>'general'
      };
    ?>
    <div class="news-item-mini">
      <div class="news-dot <?= $cat_cls ?>"></div>
      <div>
        <div class="ni-title">
          <span class="news-badge nb-<?= $cat_cls ?>"><?= $nrow['category'] ?></span>
          <?= htmlspecialchars($nrow['title']) ?>
        </div>
        <div class="ni-meta">
          By <?= htmlspecialchars($nrow['posted_by_name']) ?> &bull; <?= date('d M Y', strtotime($nrow['created_at'])) ?>
        </div>
      </div>
    </div>
    <?php endwhile; ?>
  <?php endif; ?>
</div>
