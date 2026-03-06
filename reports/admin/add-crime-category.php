<?php
require_once '../includes/config.php';
$page_title = 'Add Crime Category';
$base_url = '../';
$breadcrumb = [['label'=>'Add'],['label'=>'Crime Category']];

$msg='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $cat = mysqli_real_escape_string($con,trim($_POST['category']));
    if(!empty($cat)){
        mysqli_query($con,"INSERT INTO tbl_crimecategory (CrimeCategory) VALUES('$cat')");
        $msg="<div class='alert alert-success'><i class='fas fa-check-circle'></i> Crime category added successfully!</div>";
    } else {
        $msg="<div class='alert alert-danger'><i class='fas fa-times-circle'></i> Category name is required!</div>";
    }
}
include '../includes/admin-header.php';
?>

<div class="card">
  <div class="card-title-bar">
    Add Crime Category Detail
    <div class="card-controls">
      <button><i class="fas fa-minus"></i></button>
      <button><i class="fas fa-times"></i></button>
    </div>
  </div>
  <div class="card-body">
    <?php echo $msg; ?>
    <form method="POST" action="">
      <table style="width:100%;max-width:700px;border-collapse:collapse;">
        <tr>
          <td style="padding:8px 0;width:220px;font-size:13px;color:#555;">Crime Category Name <span class="req">*</span></td>
          <td style="padding:8px 0;"><input type="text" name="category" class="form-control" required></td>
        </tr>
        <tr>
          <td></td>
          <td style="padding-top:12px;"><button type="submit" class="btn btn-primary">Add</button></td>
        </tr>
      </table>
    </form>
  </div>
</div>

<?php include '../includes/admin-footer.php'; ?>
