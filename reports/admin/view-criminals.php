<?php
require_once '../includes/config.php';
$page_title = 'View Criminals';
$base_url = '../';

if(isset($_GET['del'])){
    $id=(int)$_GET['del'];
    // Delete photo
    $row=mysqli_fetch_assoc(mysqli_query($con,"SELECT CriminalPhoto FROM tbl_criminal WHERE id=$id"));
    if($row && $row['CriminalPhoto'] && file_exists('../images/criminals/'.$row['CriminalPhoto'])){
        unlink('../images/criminals/'.$row['CriminalPhoto']);
    }
    mysqli_query($con,"DELETE FROM tbl_criminal WHERE id=$id");
    header("Location: view-criminals.php?msg=deleted");
    exit();
}

$criminals = mysqli_query($con,"SELECT c.*,cc.CrimeCategory,ps.PoliceStationName,p.Name as OfficerName FROM tbl_criminal c LEFT JOIN tbl_crimecategory cc ON c.CrimeCategoryID=cc.id LEFT JOIN tbl_policestation ps ON c.PoliceStationID=ps.id LEFT JOIN tbl_police p ON c.PoliceID=p.id ORDER BY c.id DESC");
include '../includes/admin-header.php';
?>

<?php if(isset($_GET['msg'])): ?>
<div class="alert alert-success"><i class="fas fa-check-circle"></i> Record <?php echo $_GET['msg']; ?> successfully!</div>
<?php endif; ?>

<div style="margin-bottom:12px;">
  <a href="add-criminal.php" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add Criminal</a>
</div>

<div class="card">
  <div class="card-title-bar">
    View Criminals
    <div class="card-controls">
      <button><i class="fas fa-minus"></i></button>
      <button><i class="fas fa-times"></i></button>
    </div>
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
            <th>Police Station</th>
            <th>Officer</th>
            <th>Date of Crime</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php $i=1; while($row=mysqli_fetch_assoc($criminals)): ?>
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
            <td>
              <a href="edit-criminal.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-edit">Edit</a>
              <a href="view-criminals.php?del=<?php echo $row['id']; ?>" class="btn btn-sm btn-delete" onclick="return confirm('Delete?')">Delete</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include '../includes/admin-footer.php'; ?>
