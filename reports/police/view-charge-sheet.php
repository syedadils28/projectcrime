<?php
require_once '../includes/config.php';
$page_title = 'View Charge Sheet';
$base_url   = '../';
$breadcrumb = [['label'=>'Charge Sheet'], ['label'=>'View Charge Sheet']];

if(!isset($_SESSION['policeid'])){ header("Location: login.php"); exit(); }
$pid        = $_SESSION['policeid'];
$station_id = $_SESSION['police_station'];

// Delete charge sheet
if(isset($_GET['del'])){
    $delid = (int)$_GET['del'];
    mysqli_query($con,"DELETE FROM tbl_chargesheet WHERE id=$delid AND PoliceID=$pid");
    header("Location: view-charge-sheet.php?msg=deleted");
    exit();
}

$sheets = mysqli_query($con,"SELECT cs.*,f.FIRSubject,f.FIRStatus,u.FullName as UserName,u.MobileNumber as UserMobile FROM tbl_chargesheet cs LEFT JOIN tbl_fir f ON cs.FIRID=f.id LEFT JOIN tbl_user u ON cs.UserID=u.id WHERE f.PoliceStationID=$station_id ORDER BY cs.id DESC");

include '../includes/police-header.php';
?>

<?php if(isset($_GET['msg'])): ?>
<div class="alert alert-success"><i class="fas fa-check-circle"></i> Charge sheet <?php echo $_GET['msg']; ?> successfully!</div>
<?php endif; ?>

<div style="margin-bottom:12px;">
  <a href="add-charge-sheet.php" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add Charge Sheet</a>
</div>

<div class="card">
  <div class="card-title-bar">
    Charge Sheet Records
    <div class="card-controls"><button><i class="fas fa-minus"></i></button><button><i class="fas fa-times"></i></button></div>
  </div>
  <div class="card-body" style="padding:0;">
    <div class="table-wrapper">
      <table class="crms-table">
        <thead>
          <tr>
            <th class="sno">S.No</th>
            <th>CS ID</th>
            <th>FIR ID</th>
            <th>FIR Subject</th>
            <th>Complainant</th>
            <th>Mobile</th>
            <th>FIR Status</th>
            <th>Date Added</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php $i=1; while($row=mysqli_fetch_assoc($sheets)):
            $badge = match($row['FIRStatus']??'Pending'){
              'Pending'    => 'badge-pending',
              'Inprogress' => 'badge-inprogress',
              'Solved'     => 'badge-solved',
              default      => 'badge-pending'
            };
          ?>
          <tr>
            <td><?php echo $i++; ?></td>
            <td><strong>#<?php echo $row['id']; ?></strong></td>
            <td><strong>#<?php echo $row['FIRID']; ?></strong></td>
            <td style="max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><?php echo htmlspecialchars($row['FIRSubject']); ?></td>
            <td><?php echo htmlspecialchars($row['UserName']); ?></td>
            <td><?php echo htmlspecialchars($row['UserMobile']); ?></td>
            <td><span class="badge <?php echo $badge; ?>"><?php echo $row['FIRStatus']; ?></span></td>
            <td><?php echo date('d M Y', strtotime($row['ChargeSheetDate'])); ?></td>
            <td style="white-space:nowrap;">
              <button class="btn btn-sm btn-view"
                onclick="openCS(<?php echo $row['id']; ?>,'<?php echo addslashes($row['FIRSubject']); ?>','<?php echo addslashes($row['ChargeSheet']); ?>','<?php echo $row['UserName']; ?>')">
                <i class="fas fa-eye"></i> View
              </button>
              <a href="view-charge-sheet.php?del=<?php echo $row['id']; ?>" class="btn btn-sm btn-delete" onclick="return confirm('Delete this charge sheet?')"><i class="fas fa-trash"></i></a>
            </td>
          </tr>
          <?php endwhile; ?>
          <?php if(mysqli_num_rows($sheets)==0): ?>
          <tr><td colspan="9" style="text-align:center;padding:20px;color:#aaa;">No charge sheets found. <a href="add-charge-sheet.php">Add one</a></td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- View Charge Sheet Modal -->
<div id="csModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.45);z-index:3000;align-items:center;justify-content:center;">
  <div style="background:#fff;border-radius:4px;width:580px;max-height:85vh;overflow-y:auto;box-shadow:0 4px 24px rgba(0,0,0,0.2);">
    <div style="background:#37474f;color:#fff;padding:13px 18px;font-size:14px;font-weight:500;display:flex;justify-content:space-between;align-items:center;position:sticky;top:0;z-index:1;">
      <span><i class="fas fa-file-invoice"></i> Charge Sheet — <span id="cs_title"></span></span>
      <div style="display:flex;gap:8px;align-items:center;">
        <button onclick="window.print()" style="background:rgba(255,255,255,0.15);border:none;color:#fff;cursor:pointer;border-radius:3px;padding:4px 10px;font-size:12px;"><i class="fas fa-print"></i> Print</button>
        <button onclick="document.getElementById('csModal').style.display='none'" style="background:none;border:none;color:#fff;cursor:pointer;font-size:18px;">&times;</button>
      </div>
    </div>
    <div style="padding:24px;" id="cs_print_area">
      <div style="border-bottom:2px solid #37474f;padding-bottom:12px;margin-bottom:16px;">
        <h3 style="font-size:16px;color:#333;margin:0 0 4px;">CHARGE SHEET</h3>
        <p style="font-size:12px;color:#888;margin:0;">Crime Record Management System</p>
      </div>
      <table style="width:100%;font-size:13.5px;border-collapse:collapse;margin-bottom:16px;">
        <tr><td style="padding:5px 0;color:#777;width:130px;">FIR Subject</td><td style="padding:5px 0;font-weight:500;" id="cs_subject"></td></tr>
        <tr><td style="padding:5px 0;color:#777;">Complainant</td><td style="padding:5px 0;" id="cs_user"></td></tr>
      </table>
      <div style="border-top:1px solid #eee;padding-top:14px;">
        <p style="font-size:12px;color:#888;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:8px;">Charge Sheet Details</p>
        <p id="cs_detail" style="font-size:13.5px;line-height:1.8;color:#444;white-space:pre-wrap;"></p>
      </div>
    </div>
  </div>
</div>

<script>
function openCS(id, subject, detail, user){
  document.getElementById('cs_title').textContent = '#' + id;
  document.getElementById('cs_subject').textContent = subject;
  document.getElementById('cs_user').textContent    = user;
  document.getElementById('cs_detail').textContent  = detail;
  document.getElementById('csModal').style.display  = 'flex';
}
</script>

<?php include '../includes/police-footer.php'; ?>
