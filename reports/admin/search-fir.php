<?php
require_once '../includes/config.php';
$page_title = 'Search FIR';
$base_url = '../';

$results = null;
$keyword = '';
if(isset($_GET['keyword'])){
    $keyword = mysqli_real_escape_string($con,trim($_GET['keyword']));
    if(!empty($keyword)){
        $results = mysqli_query($con,"SELECT f.*,u.FullName as UserName,cc.CrimeCategory,ps.PoliceStationName FROM tbl_fir f LEFT JOIN tbl_user u ON f.UserID=u.id LEFT JOIN tbl_crimecategory cc ON f.CrimeCategoryID=cc.id LEFT JOIN tbl_policestation ps ON f.PoliceStationID=ps.id WHERE f.id LIKE '%$keyword%' OR f.FIRSubject LIKE '%$keyword%' OR u.FullName LIKE '%$keyword%' OR cc.CrimeCategory LIKE '%$keyword%' ORDER BY f.id DESC");
    }
}
include '../includes/admin-header.php';
?>

<div class="card">
  <div class="card-title-bar">Search FIR</div>
  <div class="card-body">
    <form method="GET" style="display:flex;gap:10px;align-items:flex-end;">
      <div style="flex:1;max-width:400px;">
        <label class="form-label" style="font-size:12px;">Enter Keyword (FIR ID, Subject, Complainant, Category)</label>
        <input type="text" name="keyword" class="form-control" placeholder="Search..." value="<?php echo htmlspecialchars($keyword); ?>">
      </div>
      <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
      <?php if($keyword): ?><a href="search-fir.php" class="btn btn-secondary">Reset</a><?php endif; ?>
    </form>
  </div>
</div>

<?php if($results !== null): ?>
<div class="card">
  <div class="card-title-bar">Search Results (<?php echo mysqli_num_rows($results); ?> found)</div>
  <div class="card-body" style="padding:0;">
    <div class="table-wrapper">
      <table class="crms-table">
        <thead>
          <tr>
            <th class="sno">S.No</th>
            <th>FIR ID</th>
            <th>Complainant</th>
            <th>Police Station</th>
            <th>Category</th>
            <th>Subject</th>
            <th>Date</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php $i=1; while($row=mysqli_fetch_assoc($results)):
            $badge=match($row['FIRStatus']){'Pending'=>'badge-pending','Inprogress'=>'badge-inprogress','Solved'=>'badge-solved',default=>'badge-pending'};
          ?>
          <tr>
            <td><?php echo $i++; ?></td>
            <td>#<?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['UserName']); ?></td>
            <td><?php echo htmlspecialchars($row['PoliceStationName']); ?></td>
            <td><?php echo htmlspecialchars($row['CrimeCategory']); ?></td>
            <td><?php echo htmlspecialchars(substr($row['FIRSubject'],0,35)); ?></td>
            <td><?php echo date('d M Y',strtotime($row['FIRDate'])); ?></td>
            <td><span class="badge <?php echo $badge; ?>"><?php echo $row['FIRStatus']; ?></span></td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php endif; ?>

<?php include '../includes/admin-footer.php'; ?>
