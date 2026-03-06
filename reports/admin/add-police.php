<?php
require_once '../includes/config.php';
$page_title = 'Add Police';
$base_url = '../';
$breadcrumb = [['label'=>'Add'],['label'=>'Police']];

$msg='';
$stations = mysqli_query($con,"SELECT * FROM tbl_policestation ORDER BY PoliceStationName");

if($_SERVER['REQUEST_METHOD']==='POST'){
    $station_id = (int)$_POST['station_id'];
    $police_id  = mysqli_real_escape_string($con,trim($_POST['police_id']));
    $name       = mysqli_real_escape_string($con,trim($_POST['name']));
    $email      = mysqli_real_escape_string($con,trim($_POST['email']));
    $mobile     = mysqli_real_escape_string($con,trim($_POST['mobile']));
    $address    = mysqli_real_escape_string($con,trim($_POST['address']));
    $password   = md5(trim($_POST['password']));

    if(empty($police_id)||empty($name)||empty($mobile)||empty($address)||empty($_POST['password'])){
        $msg="<div class='alert alert-danger'><i class='fas fa-times-circle'></i> All required fields must be filled!</div>";
    } else {
        $chk=mysqli_fetch_row(mysqli_query($con,"SELECT id FROM tbl_police WHERE PoliceID='$police_id'"));
        if($chk){
            $msg="<div class='alert alert-danger'><i class='fas fa-times-circle'></i> Police ID already exists!</div>";
        } else {
            mysqli_query($con,"INSERT INTO tbl_police (PoliceStationID,PoliceID,Name,Email,MobileNumber,Address,Password,Status) VALUES($station_id,'$police_id','$name','$email','$mobile','$address','$password',1)");
            $msg="<div class='alert alert-success'><i class='fas fa-check-circle'></i> Police officer added successfully!</div>";
        }
    }
}

include '../includes/admin-header.php';
?>

<div class="card">
  <div class="card-title-bar">
    Add Police Detail
    <div class="card-controls">
      <button><i class="fas fa-minus"></i></button>
      <button><i class="fas fa-times"></i></button>
    </div>
  </div>
  <div class="card-body">
    <?php echo $msg; ?>
    <form method="POST" action="">
      <table style="width:100%;max-width:800px;border-collapse:collapse;">
        <tr>
          <td style="padding:8px 0;width:200px;font-size:13px;color:#555;">Police Station <span class="req">*</span></td>
          <td style="padding:8px 0;">
            <select name="station_id" class="form-control" required>
              <option value="">-- Select Police Station --</option>
              <?php while($s=mysqli_fetch_assoc($stations)): ?>
              <option value="<?php echo $s['id']; ?>" <?php echo (isset($_POST['station_id'])&&$_POST['station_id']==$s['id'])?'selected':''; ?>>
                <?php echo htmlspecialchars($s['PoliceStationName'].' - ('.$s['PoliceStationCode'].strtoupper(str_pad($s['id'],4,'0',STR_PAD_LEFT)).')'); ?>
              </option>
              <?php endwhile; ?>
            </select>
          </td>
        </tr>
        <tr>
          <td style="padding:8px 0;font-size:13px;color:#555;">Police ID <span class="req">*</span></td>
          <td style="padding:8px 0;"><input type="text" name="police_id" class="form-control" required value="<?php echo isset($_POST['police_id'])?htmlspecialchars($_POST['police_id']):''; ?>"></td>
        </tr>
        <tr>
          <td style="padding:8px 0;font-size:13px;color:#555;">Name <span class="req">*</span></td>
          <td style="padding:8px 0;"><input type="text" name="name" class="form-control" required value="<?php echo isset($_POST['name'])?htmlspecialchars($_POST['name']):''; ?>"></td>
        </tr>
        <tr>
          <td style="padding:8px 0;font-size:13px;color:#555;">Email</td>
          <td style="padding:8px 0;"><input type="email" name="email" class="form-control" value="<?php echo isset($_POST['email'])?htmlspecialchars($_POST['email']):''; ?>"></td>
        </tr>
        <tr>
          <td style="padding:8px 0;font-size:13px;color:#555;">Mobile Number <span class="req">*</span></td>
          <td style="padding:8px 0;"><input type="text" name="mobile" class="form-control" required maxlength="15" value="<?php echo isset($_POST['mobile'])?htmlspecialchars($_POST['mobile']):''; ?>"></td>
        </tr>
        <tr>
          <td style="padding:8px 0;font-size:13px;color:#555;">Address <span class="req">*</span></td>
          <td style="padding:8px 0;"><textarea name="address" class="form-control" required rows="3"><?php echo isset($_POST['address'])?htmlspecialchars($_POST['address']):''; ?></textarea></td>
        </tr>
        <tr>
          <td style="padding:8px 0;font-size:13px;color:#555;">Password <span class="req">*</span></td>
          <td style="padding:8px 0;"><input type="password" name="password" class="form-control" required></td>
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
