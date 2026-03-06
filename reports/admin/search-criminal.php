<?php
require_once '../includes/config.php';
$page_title = 'Search Criminal';
$base_url = '../';

$results = null;
$keyword = '';
if(isset($_GET['keyword'])){
    $keyword = mysqli_real_escape_string($con,trim($_GET['keyword']));
    if(!empty($keyword)){
        $results = mysqli_query($con,"SELECT c.*,cc.CrimeCategory,ps.PoliceStationName,p.Name as OfficerName FROM tbl_criminal c LEFT JOIN tbl_crimecategory cc ON c.CrimeCategoryID=cc.id LEFT JOIN tbl_policestation ps ON c.PoliceStationID=ps.id LEFT JOIN tbl_police p ON c.PoliceID=p.id WHERE c.CriminalName LIKE '%$keyword%' OR cc.CrimeCategory LIKE '%$keyword%' OR ps.PoliceStationName LIKE '%$keyword%' ORDER BY c.id DESC");
    }
}
include '../includes/admin-header.php';
?>

<div class="card">
  <div class="card-title-bar">Search Criminal</div>
  <div class="card-body">
    <form method="GET" style="display:flex;gap:10px;align-items:flex-end;">
      <div style="flex:1;max-width:400px;">
        <label class="form-label" style="font-size:12px;">Enter Keyword (Name, Crime Category, Station)</label>
        <input type="text" name="keyword" class="form-control" placeholder="Search..." value="<?php echo htmlspecialchars($keyword); ?>">
      </div>
      <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
      <?php if($keyword): ?><a href="search-criminal.php" class="btn btn-secondary">Reset</a><?php endif; ?>
    </form>
  </div>
</div>

<?php if($results !== null): ?>
<div class="card">
  <div class="card-title-bar">Search Results (<?php echo mysqli_num_rows($results); ?> found for "<?php echo htmlspecialchars($keyword); ?>")</div>
  <div class="card-body" style="padding:0;">
    <div class="table-wrapper">
      <table class="crms-table">
        <thead>
          <tr>
            <th class="sno">S.No</th>
            <th>Photo</th>
            <th>Criminal Name</th>
            <th>Crime Category</th>
            <th>Police Station</th>
            <th>Officer</th>
            <th>Date of Crime</th>
          </tr>
        </thead>
        <tbody>
          <?php $i=1; while($row=mysqli_fetch_assoc($results)): ?>
          <tr>
            <td><?php echo $i++; ?></td>
            <td>
              <?php if($row['CriminalPhoto'] && file_exists('../images/criminals/'.$row['CriminalPhoto'])): ?>
                <img src="../images/criminals/<?php echo htmlspecialchars($row['CriminalPhoto']); ?>" class="criminal-photo">
              <?php else: ?>
                <div style="width:40px;height:40px;border-radius:50%;background:#e0e0e0;display:flex;align-items:center;justify-content:center;color:#aaa;"><i class="fas fa-user"></i></div>
              <?php endif; ?>
            </td>
            <td><?php echo htmlspecialchars($row['CriminalName']); ?></td>
            <td><?php echo htmlspecialchars($row['CrimeCategory']); ?></td>
            <td><?php echo htmlspecialchars($row['PoliceStationName']); ?></td>
            <td><?php echo htmlspecialchars($row['OfficerName']); ?></td>
            <td><?php echo date('d M Y',strtotime($row['DateOfCrime'])); ?></td>
          </tr>
          <?php endwhile; ?>
          <?php if(mysqli_num_rows($results)==0): ?>
          <tr><td colspan="7" style="text-align:center;padding:20px;color:#aaa;">No criminals found matching "<?php echo htmlspecialchars($keyword); ?>"</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php endif; ?>

<?php include '../includes/admin-footer.php'; ?>
