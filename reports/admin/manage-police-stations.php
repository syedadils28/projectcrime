<?php
require_once '../includes/config.php';
$page_title = 'Manage Police Stations';
$base_url = '../';
$breadcrumb = [['label'=>'Manage'],['label'=>'Police']];

// Delete
if(isset($_GET['del'])){
    $id=(int)$_GET['del'];
    mysqli_query($con,"DELETE FROM tbl_policestation WHERE id=$id");
    header("Location: manage-police-stations.php?msg=deleted");
    exit();
}

// Edit
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['editid'])){
    $id=(int)$_POST['editid'];
    $name=mysqli_real_escape_string($con,trim($_POST['name']));
    $code=mysqli_real_escape_string($con,trim($_POST['code']));
    mysqli_query($con,"UPDATE tbl_policestation SET PoliceStationName='$name',PoliceStationCode='$code' WHERE id=$id");
    header("Location: manage-police-stations.php?msg=updated");
    exit();
}

$stations = mysqli_query($con,"SELECT * FROM tbl_policestation ORDER BY id");
include '../includes/admin-header.php';
?>

<?php if(isset($_GET['msg'])): ?>
<div class="alert alert-success"><i class="fas fa-check-circle"></i> Record <?php echo $_GET['msg']; ?> successfully!</div>
<?php endif; ?>

<div class="card">
  <div class="card-title-bar">
    Manage Police Stations
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
            <th>Police Station</th>
            <th>Police Station Code</th>
            <th>Creation Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php $i=1; while($row=mysqli_fetch_assoc($stations)): ?>
          <tr id="row<?php echo $row['id']; ?>">
            <td><?php echo $i++; ?></td>
            <td><?php echo htmlspecialchars($row['PoliceStationName']); ?></td>
            <td><?php echo htmlspecialchars($row['PoliceStationCode']); ?></td>
            <td><?php echo $row['CreationDate']; ?></td>
            <td>
              <button class="btn btn-sm btn-edit" onclick="openEdit(<?php echo $row['id']; ?>,'<?php echo addslashes($row['PoliceStationName']); ?>','<?php echo addslashes($row['PoliceStationCode']); ?>')">Edit</button>
              <a href="manage-police-stations.php?del=<?php echo $row['id']; ?>" class="btn btn-sm btn-delete" onclick="return confirm('Delete this station?')">Delete</a>
            </td>
          </tr>
          <?php endwhile; ?>
          <?php if(mysqli_num_rows(mysqli_query($con,"SELECT id FROM tbl_policestation"))==0): ?>
          <tr><td colspan="5" style="text-align:center;padding:20px;color:#aaa;">No records found</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Edit Modal -->
<div id="editModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.4);z-index:3000;align-items:center;justify-content:center;">
  <div style="background:#fff;border-radius:4px;width:420px;box-shadow:0 4px 20px rgba(0,0,0,0.2);">
    <div style="background:#37474f;color:#fff;padding:12px 16px;font-size:14px;font-weight:500;display:flex;justify-content:space-between;align-items:center;">
      Edit Police Station
      <button onclick="closeEdit()" style="background:none;border:none;color:#fff;cursor:pointer;font-size:16px;">&times;</button>
    </div>
    <form method="POST" action="" style="padding:20px;">
      <input type="hidden" name="editid" id="editid">
      <div class="form-group">
        <label class="form-label">Police Station Name <span class="req">*</span></label>
        <input type="text" name="name" id="editname" class="form-control" required>
      </div>
      <div class="form-group">
        <label class="form-label">Police Station Code <span class="req">*</span></label>
        <input type="text" name="code" id="editcode" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary">Update</button>
      <button type="button" onclick="closeEdit()" class="btn btn-secondary" style="margin-left:8px;">Cancel</button>
    </form>
  </div>
</div>

<script>
function openEdit(id,name,code){
  document.getElementById('editid').value=id;
  document.getElementById('editname').value=name;
  document.getElementById('editcode').value=code;
  document.getElementById('editModal').style.display='flex';
}
function closeEdit(){
  document.getElementById('editModal').style.display='none';
}
</script>

<?php include '../includes/admin-footer.php'; ?>
