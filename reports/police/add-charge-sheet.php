<?php
require_once '../includes/config.php';
$page_title = 'Add Charge Sheet';
$base_url   = '../';
$breadcrumb = [['label'=>'Charge Sheet'], ['label'=>'Add Charge Sheet']];

if(!isset($_SESSION['policeid'])){ header("Location: login.php"); exit(); }
$pid        = $_SESSION['policeid'];
$station_id = $_SESSION['police_station'];

// Pre-fill FIR if coming from FIR detail page
$prefill_fir = (int)($_GET['fir_id'] ?? 0);

// Load FIRs at station for dropdown
$firs = mysqli_query($con,"SELECT f.id,f.FIRSubject,f.FIRStatus,u.FullName as UserName FROM tbl_fir f LEFT JOIN tbl_user u ON f.UserID=u.id WHERE f.PoliceStationID=$station_id ORDER BY f.id DESC");

$msg = '';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $fir_id = (int)$_POST['fir_id'];
    $sheet  = mysqli_real_escape_string($con, trim($_POST['charge_sheet']));

    if(!$fir_id || empty($sheet)){
        $msg = "<div class='alert alert-danger'><i class='fas fa-times-circle'></i> All fields are required!</div>";
    } else {
        // Get user ID from FIR
        $fir_row = mysqli_fetch_assoc(mysqli_query($con,"SELECT UserID FROM tbl_fir WHERE id=$fir_id AND PoliceStationID=$station_id"));
        if($fir_row){
            $uid = $fir_row['UserID'];
            mysqli_query($con,"INSERT INTO tbl_chargesheet (FIRID,UserID,PoliceID,ChargeSheet) VALUES($fir_id,$uid,$pid,'$sheet')");
            // Update FIR status to Inprogress if still Pending
            mysqli_query($con,"UPDATE tbl_fir SET FIRStatus='Inprogress',PoliceID=$pid WHERE id=$fir_id AND FIRStatus='Pending'");
            $msg = "<div class='alert alert-success'><i class='fas fa-check-circle'></i> Charge sheet added successfully!</div>";
        } else {
            $msg = "<div class='alert alert-danger'><i class='fas fa-times-circle'></i> Invalid FIR selection!</div>";
        }
    }
}

include '../includes/police-header.php';
?>

<div class="card">
  <div class="card-title-bar">
    Add Charge Sheet Detail
    <div class="card-controls"><button><i class="fas fa-minus"></i></button><button><i class="fas fa-times"></i></button></div>
  </div>
  <div class="card-body">
    <?php echo $msg; ?>
    <form method="POST">
      <table style="width:100%;max-width:800px;border-collapse:collapse;">
        <tr>
          <td style="padding:9px 0;width:200px;font-size:13px;color:#555;">Select FIR <span class="req">*</span></td>
          <td style="padding:9px 0;">
            <select name="fir_id" class="form-control" required onchange="loadFIRInfo(this.value)">
              <option value="">-- Select FIR --</option>
              <?php
              $firs_arr = [];
              while($f=mysqli_fetch_assoc($firs)){
                  $firs_arr[] = $f;
                  $sel = ($prefill_fir && $f['id']==$prefill_fir) ? 'selected' : '';
                  echo "<option value='{$f['id']}' $sel>#{$f['id']} — ".htmlspecialchars($f['FIRSubject'])." ({$f['UserName']})</option>";
              }
              ?>
            </select>
          </td>
        </tr>
        <tr id="fir_info_row" style="display:none;">
          <td style="padding:6px 0;font-size:13px;color:#777;">FIR Status</td>
          <td style="padding:6px 0;" id="fir_status_cell"></td>
        </tr>
        <tr>
          <td style="padding:9px 0;font-size:13px;color:#555;vertical-align:top;">Charge Sheet <span class="req">*</span></td>
          <td style="padding:9px 0;">
            <textarea name="charge_sheet" class="form-control" rows="8" required
              placeholder="Enter full charge sheet details including accused name, sections applicable, evidence summary, and charges..."></textarea>
            <small style="color:#888;display:block;margin-top:4px;">Include: accused details, applicable sections, evidence, arrest details, court submission notes.</small>
          </td>
        </tr>
        <tr>
          <td></td>
          <td style="padding-top:14px;">
            <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Submit Charge Sheet</button>
            <a href="view-charge-sheet.php" class="btn btn-secondary" style="margin-left:8px;">Cancel</a>
          </td>
        </tr>
      </table>
    </form>
  </div>
</div>

<script>
var firData = <?php echo json_encode($firs_arr); ?>;
function loadFIRInfo(firId){
  var row = document.getElementById('fir_info_row');
  if(!firId){ row.style.display='none'; return; }
  var fir = firData.find(function(f){ return f.id==firId; });
  if(fir){
    var badges = {'Pending':'badge-pending','Inprogress':'badge-inprogress','Solved':'badge-solved'};
    document.getElementById('fir_status_cell').innerHTML = '<span class="badge '+(badges[fir.FIRStatus]||'badge-pending')+'">'+fir.FIRStatus+'</span>';
    row.style.display = 'table-row';
  }
}
// If pre-filled
<?php if($prefill_fir): ?>
document.addEventListener('DOMContentLoaded',function(){ loadFIRInfo(<?php echo $prefill_fir; ?>); });
<?php endif; ?>
</script>

<?php include '../includes/police-footer.php'; ?>
