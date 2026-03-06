<?php
require_once '../includes/config.php';
$page_title = 'Search Criminal';
$base_url   = '../';
$breadcrumb = [['label'=>'Search'], ['label'=>'Search Criminal']];

if(!isset($_SESSION['policeid'])){ header("Location: login.php"); exit(); }
$station_id = $_SESSION['police_station'];

$results = null;
$keyword = '';
if(isset($_GET['keyword'])){
    $keyword = mysqli_real_escape_string($con, trim($_GET['keyword']));
    if(!empty($keyword)){
        $results = mysqli_query($con,"SELECT c.*,cc.CrimeCategory FROM tbl_criminal c LEFT JOIN tbl_crimecategory cc ON c.CrimeCategoryID=cc.id WHERE c.PoliceStationID=$station_id AND (c.CriminalName LIKE '%$keyword%' OR cc.CrimeCategory LIKE '%$keyword%' OR c.CriminalAddress LIKE '%$keyword%') ORDER BY c.id DESC");
    }
}

include '../includes/police-header.php';
?>

<div class="card">
  <div class="card-title-bar">Search Criminal Records</div>
  <div class="card-body">
    <form method="GET" style="display:flex;gap:10px;align-items:flex-end;flex-wrap:wrap;">
      <div style="flex:1;min-width:260px;max-width:420px;">
        <label class="form-label" style="font-size:12px;">Keyword (Name / Crime Category / Address)</label>
        <input type="text" name="keyword" class="form-control" placeholder="Search..." value="<?php echo htmlspecialchars($keyword); ?>" autofocus>
      </div>
      <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
      <?php if($keyword): ?>
        <a href="search-criminal.php" class="btn btn-secondary"><i class="fas fa-redo"></i> Reset</a>
      <?php endif; ?>
    </form>
  </div>
</div>

<?php if($results !== null): ?>
<div class="card">
  <div class="card-title-bar">
    Search Results (<?php echo mysqli_num_rows($results); ?> found for "<?php echo htmlspecialchars($keyword); ?>")
  </div>
  <div class="card-body" style="padding:0;">
    <div class="table-wrapper">
      <table class="crms-table">
        <thead>
          <tr>
            <th class="sno">S.No</th>
            <th>Photo</th>
            <th>Criminal Name</th>
            <th>Crime Category</th>
            <th>Address</th>
            <th>Date of Crime</th>
            <th>Actions</th>
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
            <td style="max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><?php echo htmlspecialchars($row['CriminalAddress']); ?></td>
            <td><?php echo date('d M Y',strtotime($row['DateOfCrime'])); ?></td>
            <td>
              <a href="edit-criminal.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-edit"><i class="fas fa-edit"></i> Edit</a>
            </td>
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

<?php include '../includes/police-footer.php'; ?>
