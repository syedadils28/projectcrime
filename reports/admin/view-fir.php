<?php
require_once '../includes/config.php';
$page_title = 'View FIR';
$base_url = '../';

if(isset($_GET['del'])){
    mysqli_query($con,"DELETE FROM tbl_fir WHERE id=".(int)$_GET['del']);
    header("Location: view-fir.php?msg=deleted");
    exit();
}

// Update FIR status + remark
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['fir_id'])){
    $fid=(int)$_POST['fir_id'];
    $status=mysqli_real_escape_string($con,$_POST['status']);
    $remark=mysqli_real_escape_string($con,trim($_POST['remark']));
    $pid=(int)$_POST['police_id'];
    mysqli_query($con,"UPDATE tbl_fir SET FIRStatus='$status',PoliceRemark='$remark',PoliceID=$pid WHERE id=$fid");
    header("Location: view-fir.php?msg=updated");
    exit();
}

$firs = mysqli_query($con,"SELECT f.*,u.FullName as UserName,u.Email as UserEmail,cc.CrimeCategory,ps.PoliceStationName FROM tbl_fir f LEFT JOIN tbl_user u ON f.UserID=u.id LEFT JOIN tbl_crimecategory cc ON f.CrimeCategoryID=cc.id LEFT JOIN tbl_policestation ps ON f.PoliceStationID=ps.id ORDER BY f.id DESC");
$police_list = mysqli_query($con,"SELECT id,Name,PoliceID FROM tbl_police WHERE Status=1 ORDER BY Name");

include '../includes/admin-header.php';
?>

<?php if(isset($_GET['msg'])): ?>
<div class="alert alert-success"><i class="fas fa-check-circle"></i> FIR <?php echo $_GET['msg']; ?> successfully!</div>
<?php endif; ?>

<div class="card">
  <div class="card-title-bar">
    View FIR Records
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
            <th>FIR ID</th>
            <th>Complainant</th>
            <th>Police Station</th>
            <th>Crime Category</th>
            <th>Subject</th>
            <th>Date</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php $i=1; while($row=mysqli_fetch_assoc($firs)):
            $badge = match($row['FIRStatus']){
              'Pending'=>'badge-pending','Inprogress'=>'badge-inprogress','Solved'=>'badge-solved',default=>'badge-pending'
            };
          ?>
          <tr>
            <td><?php echo $i++; ?></td>
            <td><strong>#<?php echo $row['id']; ?></strong></td>
            <td><?php echo htmlspecialchars($row['UserName']); ?></td>
            <td><?php echo htmlspecialchars($row['PoliceStationName']); ?></td>
            <td><?php echo htmlspecialchars($row['CrimeCategory']); ?></td>
            <td><?php echo htmlspecialchars(substr($row['FIRSubject'],0,30)).(strlen($row['FIRSubject'])>30?'...':''); ?></td>
            <td><?php echo date('d M Y',strtotime($row['FIRDate'])); ?></td>
            <td><span class="badge <?php echo $badge; ?>"><?php echo $row['FIRStatus']; ?></span></td>
            <td>
              <button class="btn btn-sm btn-view" onclick="openFIR(<?php echo $row['id']; ?>,'<?php echo addslashes($row['FIRStatus']); ?>','<?php echo addslashes($row['PoliceRemark']??''); ?>',<?php echo $row['PoliceID']??0; ?>)">View</button>
              <a href="view-fir.php?del=<?php echo $row['id']; ?>" class="btn btn-sm btn-delete" onclick="return confirm('Delete FIR #<?php echo $row['id']; ?>?')">Delete</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Update FIR Modal -->
<div id="firModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.4);z-index:3000;align-items:center;justify-content:center;">
  <div style="background:#fff;border-radius:4px;width:460px;box-shadow:0 4px 20px rgba(0,0,0,0.2);">
    <div style="background:#37474f;color:#fff;padding:12px 16px;font-size:14px;font-weight:500;display:flex;justify-content:space-between;">
      Update FIR Status
      <button onclick="document.getElementById('firModal').style.display='none'" style="background:none;border:none;color:#fff;cursor:pointer;font-size:16px;">&times;</button>
    </div>
    <form method="POST" style="padding:20px;">
      <input type="hidden" name="fir_id" id="fir_id">
      <div class="form-group">
        <label class="form-label">Assign Police Officer</label>
        <select name="police_id" id="fpolice" class="form-control">
          <option value="0">-- Unassigned --</option>
          <?php
          mysqli_data_seek($police_list,0);
          while($p=mysqli_fetch_assoc($police_list)):
          ?>
          <option value="<?php echo $p['id']; ?>"><?php echo htmlspecialchars($p['Name'].' ('.$p['PoliceID'].')'); ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">FIR Status</label>
        <select name="status" id="fstatus" class="form-control">
          <option value="Pending">Pending</option>
          <option value="Inprogress">Inprogress</option>
          <option value="Solved">Solved</option>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">Police Remark</label>
        <textarea name="remark" id="fremark" class="form-control" rows="3"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Update FIR</button>
    </form>
  </div>
</div>

<script>
function openFIR(id,status,remark,policeId){
  document.getElementById('fir_id').value=id;
  document.getElementById('fstatus').value=status;
  document.getElementById('fremark').value=remark;
  document.getElementById('fpolice').value=policeId;
  document.getElementById('firModal').style.display='flex';
}
</script>

<?php include '../includes/admin-footer.php'; ?>
