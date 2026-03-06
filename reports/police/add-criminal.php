<?php
require_once '../includes/config.php';
$page_title = 'Add Criminal';
$base_url   = '../';
$breadcrumb = [['label'=>'Criminals'],['label'=>'Add Criminal']];
if(!isset($_SESSION['policeid'])){ header("Location: login.php"); exit(); }
$pid=$_SESSION['policeid']; $station_id=$_SESSION['police_station'];
$categories=mysqli_query($con,"SELECT * FROM tbl_crimecategory ORDER BY CrimeCategory");
$msg='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $name=mysqli_real_escape_string($con,trim($_POST['name']));
    $address=mysqli_real_escape_string($con,trim($_POST['address']));
    $cat_id=(int)$_POST['category_id'];
    $doc=mysqli_real_escape_string($con,$_POST['date_of_crime']);
    $photo='';
    if(isset($_FILES['photo'])&&$_FILES['photo']['error']===0){
        $ext=strtolower(pathinfo($_FILES['photo']['name'],PATHINFO_EXTENSION));
        if(in_array($ext,['jpg','jpeg','png','gif'])){
            $photo=time().'_p_criminal.'.$ext;
            $dir='../images/criminals/';
            if(!is_dir($dir)) mkdir($dir,0755,true);
            move_uploaded_file($_FILES['photo']['tmp_name'],$dir.$photo);
        }
    }
    if(empty($name)||empty($address)||!$cat_id||empty($doc)){
        $msg="<div class='alert alert-danger'><i class='fas fa-times-circle'></i> All required fields must be filled!</div>";
    } else {
        mysqli_query($con,"INSERT INTO tbl_criminal (CriminalName,CriminalPhoto,CriminalAddress,CrimeCategoryID,PoliceStationID,PoliceID,DateOfCrime) VALUES('$name','$photo','$address',$cat_id,$station_id,$pid,'$doc')");
        $msg="<div class='alert alert-success'><i class='fas fa-check-circle'></i> Criminal record added successfully!</div>";
    }
}
include '../includes/police-header.php';
?>
<div class="card">
  <div class="card-title-bar">Add Criminal Detail<div class="card-controls"><button><i class="fas fa-minus"></i></button><button><i class="fas fa-times"></i></button></div></div>
  <div class="card-body">
    <?php echo $msg; ?>
    <form method="POST" enctype="multipart/form-data">
      <table style="width:100%;max-width:750px;border-collapse:collapse;">
        <tr><td style="padding:9px 0;width:210px;font-size:13px;color:#555;">Criminal Name <span class="req">*</span></td><td style="padding:9px 0;"><input type="text" name="name" class="form-control" required value="<?php echo isset($_POST['name'])?htmlspecialchars($_POST['name']):'';?>"></td></tr>
        <tr><td style="padding:9px 0;font-size:13px;color:#555;">Criminal Photo</td><td style="padding:9px 0;"><input type="file" name="photo" class="form-control" accept="image/*"></td></tr>
        <tr><td style="padding:9px 0;font-size:13px;color:#555;">Criminal Address <span class="req">*</span></td><td style="padding:9px 0;"><textarea name="address" class="form-control" rows="3" required><?php echo isset($_POST['address'])?htmlspecialchars($_POST['address']):'';?></textarea></td></tr>
        <tr><td style="padding:9px 0;font-size:13px;color:#555;">Crime Category <span class="req">*</span></td><td style="padding:9px 0;">
          <select name="category_id" class="form-control" required>
            <option value="">-- Select Category --</option>
            <?php while($c=mysqli_fetch_assoc($categories)): ?>
            <option value="<?php echo $c['id'];?>" <?php echo (isset($_POST['category_id'])&&$_POST['category_id']==$c['id'])?'selected':'';?>><?php echo htmlspecialchars($c['CrimeCategory']);?></option>
            <?php endwhile; ?>
          </select>
        </td></tr>
        <tr><td style="padding:9px 0;font-size:13px;color:#555;">Police Station</td><td style="padding:9px 0;">
          <?php $srow=mysqli_fetch_assoc(mysqli_query($con,"SELECT PoliceStationName FROM tbl_policestation WHERE id=$station_id")); ?>
          <input type="text" class="form-control" value="<?php echo htmlspecialchars($srow['PoliceStationName']??'');?>" readonly style="background:#f5f5f5;">
        </td></tr>
        <tr><td style="padding:9px 0;font-size:13px;color:#555;">Date of Crime <span class="req">*</span></td><td style="padding:9px 0;"><input type="date" name="date_of_crime" class="form-control" required max="<?php echo date('Y-m-d');?>" value="<?php echo isset($_POST['date_of_crime'])?$_POST['date_of_crime']:'';?>"></td></tr>
        <tr><td></td><td style="padding-top:12px;"><button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Add Criminal</button> <a href="view-criminals.php" class="btn btn-secondary" style="margin-left:8px;">Cancel</a></td></tr>
      </table>
    </form>
  </div>
</div>
<?php include '../includes/police-footer.php'; ?>
