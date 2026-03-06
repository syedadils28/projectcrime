<?php
require_once '../includes/config.php';
$page_title = 'Add Criminal';
$base_url = '../';
$breadcrumb = [['label'=>'View Criminals','url'=>'view-criminals.php'],['label'=>'Add Criminal']];

$msg='';
$stations = mysqli_query($con,"SELECT * FROM tbl_policestation ORDER BY PoliceStationName");
$categories = mysqli_query($con,"SELECT * FROM tbl_crimecategory ORDER BY CrimeCategory");

if($_SERVER['REQUEST_METHOD']==='POST'){
    $name       = mysqli_real_escape_string($con,trim($_POST['name']));
    $address    = mysqli_real_escape_string($con,trim($_POST['address']));
    $cat_id     = (int)$_POST['category_id'];
    $station_id = (int)$_POST['station_id'];
    $police_id  = (int)$_POST['police_id'];
    $doc        = mysqli_real_escape_string($con,$_POST['date_of_crime']);

    // Photo upload
    $photo = '';
    if(isset($_FILES['photo']) && $_FILES['photo']['error']===0){
        $ext = strtolower(pathinfo($_FILES['photo']['name'],PATHINFO_EXTENSION));
        if(in_array($ext,['jpg','jpeg','png','gif'])){
            $photo = time().'_criminal.'.$ext;
            $dir = '../images/criminals/';
            if(!is_dir($dir)) mkdir($dir,0755,true);
            move_uploaded_file($_FILES['photo']['tmp_name'],$dir.$photo);
        }
    }

    if(empty($name)||empty($address)||!$cat_id||!$station_id||!$police_id||empty($doc)){
        $msg="<div class='alert alert-danger'><i class='fas fa-times-circle'></i> All required fields must be filled!</div>";
    } else {
        mysqli_query($con,"INSERT INTO tbl_criminal (CriminalName,CriminalPhoto,CriminalAddress,CrimeCategoryID,PoliceStationID,PoliceID,DateOfCrime) VALUES('$name','$photo','$address',$cat_id,$station_id,$police_id,'$doc')");
        $msg="<div class='alert alert-success'><i class='fas fa-check-circle'></i> Criminal record added successfully!</div>";
    }
}

include '../includes/admin-header.php';
?>

<div class="card">
  <div class="card-title-bar">
    Add Criminal Detail
    <div class="card-controls">
      <button><i class="fas fa-minus"></i></button>
      <button><i class="fas fa-times"></i></button>
    </div>
  </div>
  <div class="card-body">
    <?php echo $msg; ?>
    <form method="POST" enctype="multipart/form-data">
      <table style="width:100%;max-width:750px;border-collapse:collapse;">
        <tr>
          <td style="padding:9px 0;width:200px;font-size:13px;color:#555;">Criminal Name <span class="req">*</span></td>
          <td style="padding:9px 0;"><input type="text" name="name" class="form-control" required></td>
        </tr>
        <tr>
          <td style="padding:9px 0;font-size:13px;color:#555;">Criminal Photo</td>
          <td style="padding:9px 0;"><input type="file" name="photo" class="form-control" accept="image/*"></td>
        </tr>
        <tr>
          <td style="padding:9px 0;font-size:13px;color:#555;">Criminal Address <span class="req">*</span></td>
          <td style="padding:9px 0;"><textarea name="address" class="form-control" required rows="3"></textarea></td>
        </tr>
        <tr>
          <td style="padding:9px 0;font-size:13px;color:#555;">Crime Category <span class="req">*</span></td>
          <td style="padding:9px 0;">
            <select name="category_id" class="form-control" required>
              <option value="">-- Select Category --</option>
              <?php while($c=mysqli_fetch_assoc($categories)): ?>
              <option value="<?php echo $c['id']; ?>"><?php echo htmlspecialchars($c['CrimeCategory']); ?></option>
              <?php endwhile; ?>
            </select>
          </td>
        </tr>
        <tr>
          <td style="padding:9px 0;font-size:13px;color:#555;">Police Station <span class="req">*</span></td>
          <td style="padding:9px 0;">
            <select name="station_id" class="form-control" required onchange="loadPolice(this.value)">
              <option value="">-- Select Station --</option>
              <?php while($s=mysqli_fetch_assoc($stations)): ?>
              <option value="<?php echo $s['id']; ?>"><?php echo htmlspecialchars($s['PoliceStationName']); ?></option>
              <?php endwhile; ?>
            </select>
          </td>
        </tr>
        <tr>
          <td style="padding:9px 0;font-size:13px;color:#555;">Police Officer <span class="req">*</span></td>
          <td style="padding:9px 0;">
            <select name="police_id" id="police_select" class="form-control" required>
              <option value="">-- Select Station First --</option>
            </select>
          </td>
        </tr>
        <tr>
          <td style="padding:9px 0;font-size:13px;color:#555;">Date of Crime <span class="req">*</span></td>
          <td style="padding:9px 0;"><input type="date" name="date_of_crime" class="form-control" required max="<?php echo date('Y-m-d'); ?>"></td>
        </tr>
        <tr>
          <td></td>
          <td style="padding-top:12px;"><button type="submit" class="btn btn-primary">Add Criminal</button></td>
        </tr>
      </table>
    </form>
  </div>
</div>

<script>
function loadPolice(stationId){
  if(!stationId){ 
    document.getElementById('police_select').innerHTML='<option value="">-- Select Station First --</option>';
    return; 
  }
  fetch('ajax-get-police.php?station_id='+stationId)
    .then(r=>r.json())
    .then(data=>{
      var sel=document.getElementById('police_select');
      sel.innerHTML='<option value="">-- Select Officer --</option>';
      data.forEach(function(p){
        sel.innerHTML+='<option value="'+p.id+'">'+p.Name+' ('+p.PoliceID+')</option>';
      });
    });
}
</script>

<?php include '../includes/admin-footer.php'; ?>
