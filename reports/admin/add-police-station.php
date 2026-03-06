<?php
require_once '../includes/config.php';
$page_title = 'Add Police Station';
$base_url = '../';
$breadcrumb = [['label'=>'Add'],['label'=>'Police']];

$msg='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $name = mysqli_real_escape_string($con,trim($_POST['name']));
    $code = mysqli_real_escape_string($con,trim($_POST['code']));
    if(!empty($name) && !empty($code)){
        $chk = mysqli_fetch_row(mysqli_query($con,"SELECT id FROM tbl_policestation WHERE PoliceStationCode='$code'"));
        if($chk){
            $msg="<div class='alert alert-danger'><i class='fas fa-times-circle'></i> Station code already exists!</div>";
        } else {
            mysqli_query($con,"INSERT INTO tbl_policestation (PoliceStationName,PoliceStationCode) VALUES('$name','$code')");
            $msg="<div class='alert alert-success'><i class='fas fa-check-circle'></i> Police station added successfully!</div>";
        }
    } else {
        $msg="<div class='alert alert-danger'><i class='fas fa-times-circle'></i> All fields are required!</div>";
    }
}
include '../includes/admin-header.php';
?>

<div class="card">
  <div class="card-title-bar">
    Add Police Station Detail
    <div class="card-controls">
      <button title="Minimize"><i class="fas fa-minus"></i></button>
      <button title="Close"><i class="fas fa-times"></i></button>
    </div>
  </div>
  <div class="card-body">
    <?php echo $msg; ?>
    <form method="POST" action="">
      <table style="width:100%;max-width:700px;border-collapse:collapse;">
        <tr>
          <td style="padding:8px 0;width:220px;font-size:13px;color:#555;">Police Station Name <span class="req">*</span></td>
          <td style="padding:8px 0;">
            <input type="text" name="name" class="form-control" required value="<?php echo isset($_POST['name'])?htmlspecialchars($_POST['name']):''; ?>">
          </td>
        </tr>
        <tr>
          <td style="padding:8px 0;font-size:13px;color:#555;">Police Station Code <span class="req">*</span></td>
          <td style="padding:8px 0;">
            <input type="text" name="code" class="form-control" required value="<?php echo isset($_POST['code'])?htmlspecialchars($_POST['code']):''; ?>">
          </td>
        </tr>
        <tr>
          <td></td>
          <td style="padding-top:12px;">
            <button type="submit" class="btn btn-primary">Add</button>
          </td>
        </tr>
      </table>
    </form>
  </div>
</div>

<?php include '../includes/admin-footer.php'; ?>
