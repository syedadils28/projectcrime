<?php
require_once '../includes/config.php';
$page_title = 'Edit Criminal';
$base_url = '../';
$breadcrumb = [['label'=>'View Criminals','url'=>'view-criminals.php'],['label'=>'Edit']];

$id = (int)($_GET['id']??0);
$criminal = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM tbl_criminal WHERE id=$id"));
if(!$criminal){ header("Location: view-criminals.php"); exit(); }

$msg='';
$stations   = mysqli_query($con,"SELECT * FROM tbl_policestation ORDER BY PoliceStationName");
$categories = mysqli_query($con,"SELECT * FROM tbl_crimecategory ORDER BY CrimeCategory");

if($_SERVER['REQUEST_METHOD']==='POST'){
    $name       = mysqli_real_escape_string($con,trim($_POST['name']));
    $address    = mysqli_real_escape_string($con,trim($_POST['address']));
    $cat_id     = (int)$_POST['category_id'];
    $station_id = (int)$_POST['station_id'];
    $police_id  = (int)$_POST['police_id'];
    $doc        = mysqli_real_escape_string($con,$_POST['date_of_crime']);
    $photo      = $criminal['CriminalPhoto'];

    if(isset($_FILES['photo']) && $_FILES['photo']['error']===0){
        $ext=strtolower(pathinfo($_FILES['photo']['name'],PATHINFO_EXTENSION));
        if(in_array($ext,['jpg','jpeg','png','gif'])){
            $photo=$id.'_criminal.'.$ext;
            $dir='../images/criminals/';
            if(!is_dir($dir)) mkdir($dir,0755,true);
            move_uploaded_file($_FILES['photo']['tmp_name'],$dir.$photo);
        }
    }

    mysqli_query($con,"UPDATE tbl_criminal SET CriminalName='$name',CriminalPhoto='$photo',CriminalAddress='$address',CrimeCategoryID=$cat_id,PoliceStationID=$station_id,PoliceID=$police_id,DateOfCrime='$doc' WHERE id=$id");
    $msg="<div class='alert alert-success'><i class='fas fa-check-circle'></i> Criminal updated successfully!</div>";
    $criminal = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM tbl_criminal WHERE id=$id"));
}

include '../includes/admin-header.php';
?>

<div class="card">
  <div class="card-title-bar">Edit Criminal Detail</div>
  <div class="card-body">
    <?php echo $msg; ?>
    <form method="POST" enctype="multipart/form-data">
      <table style="width:100%;max-width:750px;border-collapse:collapse;">
        <tr>
          <td style="padding:9px 0;width:200px;font-size:13px;color:#555;">Criminal Name <span class="req">*</span></td>
          <td style="padding:9px 0;"><input type="text" name="name" class="form-control" required value="<?php echo htmlspecialchars($criminal['CriminalName']); ?>"></td>
        </tr>
        <tr>
          <td style="padding:9px 0;font-size:13px;color:#555;">Criminal Photo</td>
          <td style="padding:9px 0;">
            <?php if($criminal['CriminalPhoto'] && file_exists('../images/criminals/'.$criminal['CriminalPhoto'])): ?>
              <img src="../images/criminals/<?php echo htmlspecialchars($criminal['CriminalPhoto']); ?>" style="width:60px;height:60px;object-fit:cover;border-radius:4px;margin-bottom:6px;display:block;">
            <?php endif; ?>
            <input type="file" name="photo" class="form-control" accept="image/*">
          </td>
        </tr>
        <tr>
          <td style="padding:9px 0;font-size:13px;color:#555;">Criminal Address <span class="req">*</span></td>
          <td style="padding:9px 0;"><textarea name="address" class="form-control" required rows="3"><?php echo htmlspecialchars($criminal['CriminalAddress']); ?></textarea></td>
        </tr>
        <tr>
          <td style="padding:9px 0;font-size:13px;color:#555;">Crime Category <span class="req">*</span></td>
          <td style="padding:9px 0;">
            <select name="category_id" class="form-control" required>
              <?php while($c=mysqli_fetch_assoc($categories)): ?>
              <option value="<?php echo $c['id']; ?>" <?php echo $criminal['CrimeCategoryID']==$c['id']?'selected':''; ?>><?php echo htmlspecialchars($c['CrimeCategory']); ?></option>
              <?php endwhile; ?>
            </select>
          </td>
        </tr>
        <tr>
          <td style="padding:9px 0;font-size:13px;color:#555;">Police Station <span class="req">*</span></td>
          <td style="padding:9px 0;">
            <select name="station_id" class="form-control" required onchange="loadPolice(this.value)">
              <?php while($s=mysqli_fetch_assoc($stations)): ?>
              <option value="<?php echo $s['id']; ?>" <?php echo $criminal['PoliceStationID']==$s['id']?'selected':''; ?>><?php echo htmlspecialchars($s['PoliceStationName']); ?></option>
              <?php endwhile; ?>
            </select>
          </td>
        </tr>
        <tr>
          <td style="padding:9px 0;font-size:13px;color:#555;">Police Officer <span class="req">*</span></td>
          <td style="padding:9px 0;">
            <select name="police_id" id="police_select" class="form-control" required>
              <?php
              $cops=mysqli_query($con,"SELECT id,Name,PoliceID FROM tbl_police WHERE PoliceStationID=".$criminal['PoliceStationID']." AND Status=1");
              while($cop=mysqli_fetch_assoc($cops)):
              ?>
              <option value="<?php echo $cop['id']; ?>" <?php echo $criminal['PoliceID']==$cop['id']?'selected':''; ?>><?php echo htmlspecialchars($cop['Name'].' ('.$cop['PoliceID'].')'); ?></option>
              <?php endwhile; ?>
            </select>
          </td>
        </tr>
        <tr>
          <td style="padding:9px 0;font-size:13px;color:#555;">Date of Crime <span class="req">*</span></td>
          <td style="padding:9px 0;"><input type="date" name="date_of_crime" class="form-control" required value="<?php echo $criminal['DateOfCrime']; ?>"></td>
        </tr>
        <tr>
          <td></td>
          <td style="padding-top:12px;">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="view-criminals.php" class="btn btn-secondary" style="margin-left:8px;">Back</a>
          </td>
        </tr>
      </table>
    </form>
  </div>
</div>

<script>
function loadPolice(stationId){
  fetch('ajax-get-police.php?station_id='+stationId)
    .then(r=>r.json()).then(data=>{
      var sel=document.getElementById('police_select');
      sel.innerHTML='<option value="">-- Select --</option>';
      data.forEach(function(p){ sel.innerHTML+='<option value="'+p.id+'">'+p.Name+' ('+p.PoliceID+')</option>'; });
    });
}
</script>

<?php include '../includes/admin-footer.php'; ?>
