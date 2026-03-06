<?php
require_once '../includes/config.php';
$page_title = 'Manage Police';
$base_url = '../';
$breadcrumb = [['label'=>'Manage'],['label'=>'Police']];

if(isset($_GET['del'])){
    $id=(int)$_GET['del'];
    mysqli_query($con,"DELETE FROM tbl_police WHERE id=$id");
    header("Location: manage-police.php?msg=deleted");
    exit();
}

if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['editid'])){
    $id=(int)$_POST['editid'];
    $name=mysqli_real_escape_string($con,trim($_POST['name']));
    $email=mysqli_real_escape_string($con,trim($_POST['email']));
    $mobile=mysqli_real_escape_string($con,trim($_POST['mobile']));
    $address=mysqli_real_escape_string($con,trim($_POST['address']));
    $status=(int)$_POST['status'];
    mysqli_query($con,"UPDATE tbl_police SET Name='$name',Email='$email',MobileNumber='$mobile',Address='$address',Status=$status WHERE id=$id");
    header("Location: manage-police.php?msg=updated");
    exit();
}

$police = mysqli_query($con,"SELECT p.*,ps.PoliceStationName FROM tbl_police p LEFT JOIN tbl_policestation ps ON p.PoliceStationID=ps.id ORDER BY p.id");
include '../includes/admin-header.php';
?>

<?php if(isset($_GET['msg'])): ?>
<div class="alert alert-success"><i class="fas fa-check-circle"></i> Record <?php echo $_GET['msg']; ?> successfully!</div>
<?php endif; ?>

<div class="card">
  <div class="card-title-bar">
    Manage Police
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
            <th>Police ID</th>
            <th>Name(s)</th>
            <th>Mobile Number</th>
            <th>Email</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php $i=1; while($row=mysqli_fetch_assoc($police)): ?>
          <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo htmlspecialchars($row['PoliceID']); ?></td>
            <td><?php echo htmlspecialchars($row['Name']); ?></td>
            <td><?php echo htmlspecialchars($row['MobileNumber']); ?></td>
            <td><?php echo htmlspecialchars($row['Email']); ?></td>
            <td>
              <button class="btn btn-sm btn-edit" onclick="openEdit(<?php echo $row['id']; ?>,'<?php echo addslashes($row['Name']); ?>','<?php echo addslashes($row['Email']); ?>','<?php echo addslashes($row['MobileNumber']); ?>','<?php echo addslashes($row['Address']); ?>',<?php echo $row['Status']; ?>)">Edit</button>
              <a href="manage-police.php?del=<?php echo $row['id']; ?>" class="btn btn-sm btn-delete" onclick="return confirm('Delete?')">Delete</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Edit Modal -->
<div id="editModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.4);z-index:3000;align-items:center;justify-content:center;">
  <div style="background:#fff;border-radius:4px;width:480px;max-height:90vh;overflow-y:auto;box-shadow:0 4px 20px rgba(0,0,0,0.2);">
    <div style="background:#37474f;color:#fff;padding:12px 16px;font-size:14px;font-weight:500;display:flex;justify-content:space-between;align-items:center;position:sticky;top:0;">
      Edit Police
      <button onclick="closeEdit()" style="background:none;border:none;color:#fff;cursor:pointer;font-size:16px;">&times;</button>
    </div>
    <form method="POST" action="" style="padding:20px;">
      <input type="hidden" name="editid" id="editid">
      <div class="form-group">
        <label class="form-label">Name <span class="req">*</span></label>
        <input type="text" name="name" id="ename" class="form-control" required>
      </div>
      <div class="form-group">
        <label class="form-label">Email</label>
        <input type="email" name="email" id="eemail" class="form-control">
      </div>
      <div class="form-group">
        <label class="form-label">Mobile Number <span class="req">*</span></label>
        <input type="text" name="mobile" id="emobile" class="form-control" required>
      </div>
      <div class="form-group">
        <label class="form-label">Address <span class="req">*</span></label>
        <textarea name="address" id="eaddress" class="form-control" required></textarea>
      </div>
      <div class="form-group">
        <label class="form-label">Status</label>
        <select name="status" id="estatus" class="form-control">
          <option value="1">Active</option>
          <option value="0">Inactive</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Update</button>
      <button type="button" onclick="closeEdit()" class="btn btn-secondary" style="margin-left:8px;">Cancel</button>
    </form>
  </div>
</div>

<script>
function openEdit(id,name,email,mobile,address,status){
  document.getElementById('editid').value=id;
  document.getElementById('ename').value=name;
  document.getElementById('eemail').value=email;
  document.getElementById('emobile').value=mobile;
  document.getElementById('eaddress').value=address;
  document.getElementById('estatus').value=status;
  document.getElementById('editModal').style.display='flex';
}
function closeEdit(){ document.getElementById('editModal').style.display='none'; }
</script>

<?php include '../includes/admin-footer.php'; ?>
