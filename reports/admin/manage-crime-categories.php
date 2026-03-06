<?php
require_once '../includes/config.php';
$page_title = 'Manage Crime Categories';
$base_url = '../';
$breadcrumb = [['label'=>'Manage'],['label'=>'Crime Category']];

if(isset($_GET['del'])){
    mysqli_query($con,"DELETE FROM tbl_crimecategory WHERE id=".(int)$_GET['del']);
    header("Location: manage-crime-categories.php?msg=deleted");
    exit();
}
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['editid'])){
    $id=(int)$_POST['editid'];
    $cat=mysqli_real_escape_string($con,trim($_POST['category']));
    mysqli_query($con,"UPDATE tbl_crimecategory SET CrimeCategory='$cat' WHERE id=$id");
    header("Location: manage-crime-categories.php?msg=updated");
    exit();
}

$cats = mysqli_query($con,"SELECT * FROM tbl_crimecategory ORDER BY id");
include '../includes/admin-header.php';
?>

<?php if(isset($_GET['msg'])): ?>
<div class="alert alert-success"><i class="fas fa-check-circle"></i> Record <?php echo $_GET['msg']; ?> successfully!</div>
<?php endif; ?>

<div class="card">
  <div class="card-title-bar">
    Manage Crime Categories
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
            <th>Crime Category</th>
            <th>Creation Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php $i=1; while($row=mysqli_fetch_assoc($cats)): ?>
          <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo htmlspecialchars($row['CrimeCategory']); ?></td>
            <td><?php echo $row['CreationDate']; ?></td>
            <td>
              <button class="btn btn-sm btn-edit" onclick="openEdit(<?php echo $row['id']; ?>,'<?php echo addslashes($row['CrimeCategory']); ?>')">Edit</button>
              <a href="manage-crime-categories.php?del=<?php echo $row['id']; ?>" class="btn btn-sm btn-delete" onclick="return confirm('Delete?')">Delete</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div id="editModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.4);z-index:3000;align-items:center;justify-content:center;">
  <div style="background:#fff;border-radius:4px;width:400px;box-shadow:0 4px 20px rgba(0,0,0,0.2);">
    <div style="background:#37474f;color:#fff;padding:12px 16px;font-size:14px;font-weight:500;display:flex;justify-content:space-between;">
      Edit Crime Category
      <button onclick="closeEdit()" style="background:none;border:none;color:#fff;cursor:pointer;font-size:16px;">&times;</button>
    </div>
    <form method="POST" style="padding:20px;">
      <input type="hidden" name="editid" id="editid">
      <div class="form-group">
        <label class="form-label">Crime Category Name <span class="req">*</span></label>
        <input type="text" name="category" id="ecat" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary">Update</button>
      <button type="button" onclick="closeEdit()" class="btn btn-secondary" style="margin-left:8px;">Cancel</button>
    </form>
  </div>
</div>
<script>
function openEdit(id,cat){
  document.getElementById('editid').value=id;
  document.getElementById('ecat').value=cat;
  document.getElementById('editModal').style.display='flex';
}
function closeEdit(){ document.getElementById('editModal').style.display='none'; }
</script>

<?php include '../includes/admin-footer.php'; ?>
