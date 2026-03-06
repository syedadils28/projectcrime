<?php
require_once '../includes/config.php';
$page_title = 'Search FIR';
$base_url   = '../';
$breadcrumb = [['label'=>'Search'], ['label'=>'Search FIR']];

if(!isset($_SESSION['policeid'])){ header("Location: login.php"); exit(); }
$station_id = $_SESSION['police_station'];

$results = null;
$keyword = '';
if(isset($_GET['keyword'])){
    $keyword = mysqli_real_escape_string($con, trim($_GET['keyword']));
    if(!empty($keyword)){
        $results = mysqli_query($con,"SELECT f.*,u.FullName as UserName,u.MobileNumber as UserMobile,cc.CrimeCategory FROM tbl_fir f LEFT JOIN tbl_user u ON f.UserID=u.id LEFT JOIN tbl_crimecategory cc ON f.CrimeCategoryID=cc.id WHERE f.PoliceStationID=$station_id AND (f.id LIKE '%$keyword%' OR f.FIRSubject LIKE '%$keyword%' OR u.FullName LIKE '%$keyword%' OR cc.CrimeCategory LIKE '%$keyword%') ORDER BY f.id DESC");
    }
}

include '../includes/police-header.php';
?>

<div class="card">
  <div class="card-title-bar">Search FIR Records</div>
  <div class="card-body">
    <form method="GET" style="display:flex;gap:10px;align-items:flex-end;flex-wrap:wrap;">
      <div style="flex:1;min-width:260px;max-width:420px;">
        <label class="form-label" style="font-size:12px;">Keyword (FIR ID / Subject / Complainant / Category)</label>
        <input type="text" name="keyword" class="form-control" placeholder="Search..." value="<?php echo htmlspecialchars($keyword); ?>" autofocus>
      </div>
      <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
      <?php if($keyword): ?>
        <a href="search-fir.php" class="btn btn-secondary"><i class="fas fa-redo"></i> Reset</a>
      <?php endif; ?>
    </form>
  </div>
</div>

<?php if($results !== null): ?>
<div class="card">
  <div class="card-title-bar">
    Results (<?php echo mysqli_num_rows($results); ?> found for "<?php echo htmlspecialchars($keyword); ?>")
  </div>
  <div class="card-body" style="padding:0;">
    <div class="table-wrapper">
      <table class="crms-table">
        <thead>
          <tr>
            <th class="sno">S.No</th>
            <th>FIR ID</th>
            <th>Complainant</th>
            <th>Mobile</th>
            <th>Crime Category</th>
            <th>Subject</th>
            <th>Date</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php $i=1; while($row=mysqli_fetch_assoc($results)):
            $badge = match($row['FIRStatus']){
              'Pending'    => 'badge-pending',
              'Inprogress' => 'badge-inprogress',
              'Solved'     => 'badge-solved',
              default      => 'badge-pending'
            };
          ?>
          <tr>
            <td><?php echo $i++; ?></td>
            <td><strong>#<?php echo $row['id']; ?></strong></td>
            <td><?php echo htmlspecialchars($row['UserName']); ?></td>
            <td><?php echo htmlspecialchars($row['UserMobile']); ?></td>
            <td><?php echo htmlspecialchars($row['CrimeCategory']); ?></td>
            <td style="max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><?php echo htmlspecialchars($row['FIRSubject']); ?></td>
            <td><?php echo date('d M Y',strtotime($row['FIRDate'])); ?></td>
            <td><span class="badge <?php echo $badge; ?>"><?php echo $row['FIRStatus']; ?></span></td>
            <td>
              <a href="view-fir-detail.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-edit"><i class="fas fa-edit"></i> Update</a>
            </td>
          </tr>
          <?php endwhile; ?>
          <?php if(mysqli_num_rows($results)==0): ?>
          <tr><td colspan="9" style="text-align:center;padding:20px;color:#aaa;">No FIRs found matching "<?php echo htmlspecialchars($keyword); ?>"</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php endif; ?>

<?php include '../includes/police-footer.php'; ?>
