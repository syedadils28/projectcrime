<?php
require_once '../includes/config.php';
$page_title='Edit Criminal'; $base_url='../';
$breadcrumb=[['label'=>'Criminals'],['label'=>'View Criminals','url'=>'view-criminals.php'],['label'=>'Edit']];
if(!isset($_SESSION['policeid'])){ header("Location: login.php"); exit(); }
$pid=$_SESSION['policeid']; $station_id=$_SESSION['police_station'];
$id=(int)($_GET['id']??0);
$criminal=mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM tbl_criminal WHERE id=$id AND PoliceStationID=$station_id"));
if(!$criminal){ header("Location: view-criminals.php"); exit(); }
$categories=mysqli_query($con,"SELECT * FROM tbl_crimecategory ORDER BY CrimeCategory");
$msg='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $name=mysqli_real_escape_string($con,trim($_POST['name']));
    $address=mysqli_real_escape_string($con,trim($_POST['address']));
    $cat_id=(int)$_POST['category_id'];
    $doc=mysqli_real_escape_string($con,$_POST['date_of_crime']);
    $photo=$criminal['CriminalPhoto'];
    if(isset($_FILES['photo'])&&$_FILES['photo']['error']===0){
        $ext=strtolower(pathinfo($_FILES['photo']['name'],PATHINFO_EXTENSION));
        if(in_array($ext,['jpg','jpeg','png','gif'])){
            if($photo&&file_exists('../images/criminals/'.$photo)) unlink('../images/criminals/'.$photo);
            $photo=$id.'_p_crim.'.$ext;
            move_uploaded_file($_FILES['photo']['tmp_name'],'../images/criminals/'.$photo);
        }
    }
    mysqli_query($con,"UPDATE tbl_criminal SET CriminalName='$name',CriminalPhoto='$photo',CriminalAddress='$address',CrimeCategoryID=$cat_id,DateOfCrime='$doc' WHERE id=$id AND PoliceStationID=$station_id");
    $msg="<div class='alert alert-success'><i class='fas fa-check-circle'></i> Criminal updated successfully!</div>";
    $criminal=mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM tbl_criminal WHERE id=$id"));
}
include '../includes/police-header.php';
?>
<div class="card">
  <div class="card-title-bar">Edit Criminal Detail</div>
  <div class="card-body">
    <?php echo $msg;?>
    <form method="POST" enctype="multipart/form-data">
      <table style="width:100%;max-width:750px;border-collapse:collapse;">
        <tr><td style="padding:9px 0;width:210px;font-size:13px;color:#555;">Criminal Name <span class="req">*</span></td><td><input type="text" name="name" class="form-control" required value="<?php echo htmlspecialchars($criminal['CriminalName']);?>"></td></tr>
        <tr><td style="padding:9px 0;font-size:13px;color:#555;">Criminal Photo</td><td>
          <?php if($criminal['CriminalPhoto']&&file_exists('../images/criminals/'.$criminal['CriminalPhoto'])): ?><img src="../images/criminals/<?php echo htmlspecialchars($criminal['CriminalPhoto']);?>" style="width:65px;height:65px;object-fit:cover;border-radius:4px;margin-bottom:8px;display:block;border:2px solid #e0e0e0;"><?php endif; ?>
          <input type="file" name="photo" class="form-control" accept="image/*">
          <small style="color:#aaa;">Leave empty to keep existing photo.</small>
        </td></tr>
        <tr><td style="padding:9px 0;font-size:13px;color:#555;">Criminal Address <span class="req">*</span></td><td><textarea name="address" class="form-control" rows="3" required><?php echo htmlspecialchars($criminal['CriminalAddress']);?></textarea></td></tr>
        <tr><td style="padding:9px 0;font-size:13px;color:#555;">Crime Category <span class="req">*</span></td><td>
          <select name="category_id" class="form-control" required>
            <?php while($c=mysqli_fetch_assoc($categories)): ?><option value="<?php echo $c['id'];?>" <?php echo $criminal['CrimeCategoryID']==$c['id']?'selected':'';?>><?php echo htmlspecialchars($c['CrimeCategory']);?></option><?php endwhile;?>
          </select>
        </td></tr>
        <tr><td style="padding:9px 0;font-size:13px;color:#555;">Date of Crime <span class="req">*</span></td><td><input type="date" name="date_of_crime" class="form-control" required max="<?php echo date('Y-m-d');?>" value="<?php echo $criminal['DateOfCrime'];?>"></td></tr>
        <tr><td></td><td style="padding-top:12px;"><button type="submit" class="btn btn-primary">Update Criminal</button> <a href="view-criminals.php" class="btn btn-secondary" style="margin-left:8px;">Back</a></td></tr>
      </table>
    </form>
  </div>
</div>
<?php include '../includes/police-footer.php'; ?>
