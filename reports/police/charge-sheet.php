<?php
require_once '../includes/config.php';
$page_title = 'Charge Sheet';
$base_url   = '../';
$breadcrumb = [['label'=>'Charge Sheet']];

if(!isset($_SESSION['policeid'])){ header("Location: login.php"); exit(); }
$pid        = $_SESSION['policeid'];
$station_id = $_SESSION['police_station'];

// Delete charge sheet
if(isset($_GET['del'])){
    mysqli_query($con,"DELETE FROM tbl_chargesheet WHERE id=".(int)$_GET['del']." AND PoliceID=$pid");
    header("Location: charge-sheet.php?msg=deleted");
    exit();
}

// Add / Update charge sheet directly from this page
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['fir_id'])){
    $fid = (int)$_POST['fir_id'];
    $cs  = mysqli_real_escape_string($con, trim($_POST['chargesheet']));

    // Verify FIR belongs to this station
    $frow = mysqli_fetch_assoc(mysqli_query($con,"SELECT id,UserID FROM tbl_fir WHERE id=$fid AND PoliceStationID=$station_id"));
    if($frow && !empty($cs)){
        $uid = (int)$frow['UserID'];
        mysqli_query($con,"DELETE FROM tbl_chargesheet WHERE FIRID=$fid");
        mysqli_query($con,"INSERT INTO tbl_chargesheet (FIRID,UserID,PoliceID,ChargeSheet) VALUES($fid,$uid,$pid,'$cs')");
        header("Location: charge-sheet.php?msg=added");
        exit();
    }
}

// Fetch existing charge sheets at this station
$sheets = mysqli_query($con,"SELECT cs.*,f.FIRSubject,f.FIRStatus,u.FullName as UserName,u.MobileNumber as UserMobile FROM tbl_chargesheet cs INNER JOIN tbl_fir f ON cs.FIRID=f.id INNER JOIN tbl_user u ON cs.UserID=u.id WHERE f.PoliceStationID=$station_id ORDER BY cs.id DESC");

// FIRs without charge sheets (for the add form)
$firs_no_cs = mysqli_query($con,"SELECT f.id,f.FIRSubject,u.FullName as UserName FROM tbl_fir f LEFT JOIN tbl_user u ON f.UserID=u.id LEFT JOIN tbl_chargesheet cs ON f.id=cs.FIRID WHERE f.PoliceStationID=$station_id AND cs.id IS NULL AND f.FIRStatus IN ('Inprogress','Solved') ORDER BY f.id DESC");

include '../includes/police-header.php';
?>

<?php if(isset($_GET['msg'])): ?>
<div class="alert alert-success"><i class="fas fa-check-circle"></i> Charge sheet <?php echo $_GET['msg']; ?> successfully!</div>
<?php endif; ?>

<!-- Add New Charge Sheet Card -->
<div class="card">
  <div class="card-title-bar">
    Issue New Charge Sheet
    <div class="card-controls">
      <button onclick="this.closest('.card').querySelector('.card-body').style.display='none'"><i class="fas fa-minus"></i></button>
    </div>
  </div>
  <div class="card-body">
    <form method="POST">
      <table style="width:100%;max-width:750px;border-collapse:collapse;">
        <tr>
          <td style="padding:9px 0;width:210px;font-size:13px;color:#555;">Select FIR <span class="req">*</span></td>
          <td style="padding:9px 0;">
            <select name="fir_id" class="form-control" required>
              <option value="">-- Select FIR (Inprogress / Solved) --</option>
              <?php while($f=mysqli_fetch_assoc($firs_no_cs)): ?>
              <option value="<?php echo $f['id']; ?>">
                #<?php echo $f['id']; ?> – <?php echo htmlspecialchars($f['UserName']); ?> – <?php echo htmlspecialchars(substr($f['FIRSubject'],0,50)); ?>
              </option>
              <?php endwhile; ?>
            </select>
            <small style="color:#aaa;">Only FIRs that are Inprogress or Solved and don't yet have a charge sheet are shown.</small>
          </td>
        </tr>
        <tr>
          <td style="padding:9px 0;font-size:13px;color:#555;vertical-align:top;padding-top:13px;">Charge Sheet Detail <span class="req">*</span></td>
          <td style="padding:9px 0;">
            <textarea name="chargesheet" class="form-control" rows="5" required
                      placeholder="Enter detailed charge sheet content including charges, evidence, and observations..."></textarea>
          </td>
        </tr>
        <tr>
          <td></td>
          <td style="padding-top:12px;">
            <button type="submit" class="btn btn-primary"><i class="fas fa-file-invoice"></i> Issue Charge Sheet</button>
          </td>
        </tr>
      </table>
    </form>
  </div>
</div>

<!-- Existing Charge Sheets -->
<div class="card">
  <div class="card-title-bar">
    Issued Charge Sheets
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
            <th>FIR Subject</th>
            <th>Complainant</th>
            <th>Mobile</th>
            <th>FIR Status</th>
            <th>CS Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php $i=1; while($row=mysqli_fetch_assoc($sheets)):
            $badge=match($row['FIRStatus']){'Pending'=>'badge-pending','Inprogress'=>'badge-inprogress','Solved'=>'badge-solved',default=>'badge-pending'};
          ?>
          <tr>
            <td><?php echo $i++; ?></td>
            <td><strong>#<?php echo $row['FIRID']; ?></strong></td>
            <td style="max-width:200px;"><?php echo htmlspecialchars(substr($row['FIRSubject'],0,45)); ?></td>
            <td><?php echo htmlspecialchars($row['UserName']); ?></td>
            <td><?php echo htmlspecialchars($row['UserMobile']); ?></td>
            <td><span class="badge <?php echo $badge; ?>"><?php echo $row['FIRStatus']; ?></span></td>
            <td><?php echo date('d M Y',strtotime($row['ChargeSheetDate'])); ?></td>
            <td>
              <button class="btn btn-sm btn-view"
                      onclick="viewCS('<?php echo addslashes(htmlspecialchars($row['FIRSubject'])); ?>','<?php echo addslashes(htmlspecialchars($row['ChargeSheet'])); ?>')">
                View
              </button>
              <a href="charge-sheet.php?del=<?php echo $row['id']; ?>"
                 class="btn btn-sm btn-delete"
                 onclick="return confirm('Delete this charge sheet?')">Delete</a>
            </td>
          </tr>
          <?php endwhile; ?>
          <?php if(mysqli_num_rows($sheets)==0): ?>
          <tr><td colspan="8" style="text-align:center;padding:20px;color:#aaa;">No charge sheets issued yet.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- View CS Modal -->
<div id="csModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.45);z-index:3000;align-items:center;justify-content:center;">
  <div style="background:#fff;border-radius:4px;width:540px;max-height:88vh;overflow-y:auto;box-shadow:0 6px 28px rgba(0,0,0,0.18);">
    <div style="background:#37474f;color:#fff;padding:12px 18px;font-size:14px;font-weight:500;display:flex;justify-content:space-between;position:sticky;top:0;">
      <span>Charge Sheet — <span id="cs_subject" style="font-weight:400;"></span></span>
      <button onclick="document.getElementById('csModal').style.display='none'" style="background:none;border:none;color:#fff;cursor:pointer;font-size:18px;">&times;</button>
    </div>
    <div style="padding:20px;">
      <p id="cs_body" style="font-size:13.5px;line-height:1.8;white-space:pre-wrap;color:#333;"></p>
    </div>
    <div style="padding:12px 20px;border-top:1px solid #eee;text-align:right;">
      <button onclick="window.print()" class="btn btn-info btn-sm no-print"><i class="fas fa-print"></i> Print</button>
      <button onclick="document.getElementById('csModal').style.display='none'" class="btn btn-secondary btn-sm" style="margin-left:8px;">Close</button>
    </div>
  </div>
</div>

<script>
function viewCS(subject, body){
  document.getElementById('cs_subject').textContent = subject;
  document.getElementById('cs_body').textContent    = body;
  document.getElementById('csModal').style.display  = 'flex';
}
</script>

<?php include '../includes/police-footer.php'; ?>
