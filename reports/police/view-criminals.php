<?php
require_once '../includes/config.php';
$page_title='View Criminals'; $base_url='../';
$breadcrumb=[['label'=>'Criminals'],['label'=>'View Criminals']];
if(!isset($_SESSION['policeid'])){ header("Location: login.php"); exit(); }
$station_id=$_SESSION['police_station'];
if(isset($_GET['del'])){
    $id=(int)$_GET['del'];
    $row=mysqli_fetch_assoc(mysqli_query($con,"SELECT CriminalPhoto FROM tbl_criminal WHERE id=$id AND PoliceStationID=$station_id"));
    if($row){ if($row['CriminalPhoto']&&file_exists('../images/criminals/'.$row['CriminalPhoto'])) unlink('../images/criminals/'.$row['CriminalPhoto']); mysqli_query($con,"DELETE FROM tbl_criminal WHERE id=$id AND PoliceStationID=$station_id"); header("Location: view-criminals.php?msg=deleted"); exit(); }
}
$keyword=isset($_GET['keyword'])?mysqli_real_escape_string($con,trim($_GET['keyword'])):'';
$wc=$keyword?"AND (c.CriminalName LIKE '%$keyword%' OR cc.CrimeCategory LIKE '%$keyword%')":'';
$criminals=mysqli_query($con,"SELECT c.*,cc.CrimeCategory,p.Name as OfficerName FROM tbl_criminal c LEFT JOIN tbl_crimecategory cc ON c.CrimeCategoryID=cc.id LEFT JOIN tbl_police p ON c.PoliceID=p.id WHERE c.PoliceStationID=$station_id $wc ORDER BY c.id DESC");
include '../includes/police-header.php';
?>
<?php if(isset($_GET['msg'])): ?><div class="alert alert-success"><i class="fas fa-check-circle"></i> Criminal record <?php echo $_GET['msg'];?> successfully!</div><?php endif; ?>
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;flex-wrap:wrap;gap:10px;">
  <a href="add-criminal.php" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add Criminal</a>
  <form method="GET" style="display:flex;gap:8px;">
    <input type="text" name="keyword" class="form-control" placeholder="Search by name or category..." style="width:260px;" value="<?php echo htmlspecialchars($keyword);?>">
    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i></button>
    <?php if($keyword): ?><a href="view-criminals.php" class="btn btn-secondary btn-sm">Reset</a><?php endif; ?>
  </form>
</div>
<div class="card">
  <div class="card-title-bar">Criminals at My Station<div class="card-controls"><button><i class="fas fa-minus"></i></button><button><i class="fas fa-times"></i></button></div></div>
  <div class="card-body" style="padding:0;">
    <div class="table-wrapper">
      <table class="crms-table">
        <thead><tr><th class="sno">S.No</th><th>Photo</th><th>Criminal Name</th><th>Crime Category</th><th>Address</th><th>Officer</th><th>Date of Crime</th><th>Actions</th></tr></thead>
        <tbody>
          <?php $i=1; while($row=mysqli_fetch_assoc($criminals)): ?>
          <tr>
            <td><?php echo $i++;?></td>
            <td><?php if($row['CriminalPhoto']&&file_exists('../images/criminals/'.$row['CriminalPhoto'])): ?><img src="../images/criminals/<?php echo htmlspecialchars($row['CriminalPhoto']);?>" class="criminal-photo"><?php else: ?><div style="width:40px;height:40px;border-radius:50%;background:#e0e0e0;display:flex;align-items:center;justify-content:center;color:#aaa;"><i class="fas fa-user"></i></div><?php endif; ?></td>
            <td><?php echo htmlspecialchars($row['CriminalName']);?></td>
            <td><?php echo htmlspecialchars($row['CrimeCategory']);?></td>
            <td style="max-width:160px;"><?php echo htmlspecialchars(substr($row['CriminalAddress'],0,50));?></td>
            <td><?php echo htmlspecialchars($row['OfficerName']);?></td>
            <td><?php echo date('d M Y',strtotime($row['DateOfCrime']));?></td>
            <td>
              <a href="edit-criminal.php?id=<?php echo $row['id'];?>" class="btn btn-sm btn-edit">Edit</a>
              <a href="view-criminals.php?del=<?php echo $row['id'];?>" class="btn btn-sm btn-delete" onclick="return confirm('Delete?')">Delete</a>
            </td>
          </tr>
          <?php endwhile; ?>
          <?php if(mysqli_num_rows($criminals)==0): ?><tr><td colspan="8" style="text-align:center;padding:20px;color:#aaa;"><?php echo $keyword?'No results for "'.$keyword.'".':'No criminal records at your station yet.';?></td></tr><?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php include '../includes/police-footer.php'; ?>
