<?php
require_once '../includes/config.php';
$page_title = 'Criminal Report';
$base_url = '../';

$from = isset($_GET['from']) ? mysqli_real_escape_string($con,$_GET['from']) : '';
$to   = isset($_GET['to'])   ? mysqli_real_escape_string($con,$_GET['to'])   : '';
$cat  = isset($_GET['cat'])  ? (int)$_GET['cat'] : 0;

$where = [];
if($from) $where[] = "DATE(c.DateOfCrime) >= '$from'";
if($to)   $where[] = "DATE(c.DateOfCrime) <= '$to'";
if($cat)  $where[] = "c.CrimeCategoryID = $cat";
$wc = $where ? 'WHERE '.implode(' AND ',$where) : '';

$criminals = mysqli_query($con,"SELECT c.*,cc.CrimeCategory,ps.PoliceStationName,p.Name as OfficerName FROM tbl_criminal c LEFT JOIN tbl_crimecategory cc ON c.CrimeCategoryID=cc.id LEFT JOIN tbl_policestation ps ON c.PoliceStationID=ps.id LEFT JOIN tbl_police p ON c.PoliceID=p.id $wc ORDER BY c.id DESC");
$categories = mysqli_query($con,"SELECT * FROM tbl_crimecategory ORDER BY CrimeCategory");

include '../includes/admin-header.php';
?>

<div class="card">
  <div class="card-title-bar">Criminal Report Filter</div>
  <div class="card-body">
    <form method="GET" action="" style="display:flex;gap:14px;flex-wrap:wrap;align-items:flex-end;">
      <div>
        <label class="form-label" style="font-size:12px;">From Date</label>
        <input type="date" name="from" class="form-control" style="width:160px;" value="<?php echo htmlspecialchars($from); ?>">
      </div>
      <div>
        <label class="form-label" style="font-size:12px;">To Date</label>
        <input type="date" name="to" class="form-control" style="width:160px;" value="<?php echo htmlspecialchars($to); ?>">
      </div>
      <div>
        <label class="form-label" style="font-size:12px;">Crime Category</label>
        <select name="cat" class="form-control" style="width:180px;">
          <option value="0">All Categories</option>
          <?php while($c=mysqli_fetch_assoc($categories)): ?>
          <option value="<?php echo $c['id']; ?>" <?php echo $cat==$c['id']?'selected':''; ?>><?php echo htmlspecialchars($c['CrimeCategory']); ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Filter</button>
      <a href="report-criminals.php" class="btn btn-secondary btn-sm">Reset</a>
      <button type="button" onclick="window.print()" class="btn btn-info btn-sm no-print"><i class="fas fa-print"></i> Print</button>
    </form>
  </div>
</div>

<div class="card">
  <div class="card-title-bar">Criminal Records (<?php echo mysqli_num_rows($criminals); ?> found)</div>
  <div class="card-body" style="padding:0;">
    <div class="table-wrapper">
      <table class="crms-table">
        <thead>
          <tr>
            <th class="sno">S.No</th>
            <th>Criminal Name</th>
            <th>Crime Category</th>
            <th>Police Station</th>
            <th>Officer</th>
            <th>Date of Crime</th>
          </tr>
        </thead>
        <tbody>
          <?php $i=1; while($row=mysqli_fetch_assoc($criminals)): ?>
          <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo htmlspecialchars($row['CriminalName']); ?></td>
            <td><?php echo htmlspecialchars($row['CrimeCategory']); ?></td>
            <td><?php echo htmlspecialchars($row['PoliceStationName']); ?></td>
            <td><?php echo htmlspecialchars($row['OfficerName']); ?></td>
            <td><?php echo date('d M Y',strtotime($row['DateOfCrime'])); ?></td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include '../includes/admin-footer.php'; ?>
