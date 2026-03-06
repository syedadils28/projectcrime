<?php
require_once '../includes/config.php';
$page_title = 'Update FIR';
$base_url   = '../';
$breadcrumb = [['label'=>'FIR','url'=>'view-fir.php'], ['label'=>'Update FIR']];

if(!isset($_SESSION['policeid'])){ header("Location: login.php"); exit(); }
$pid        = $_SESSION['policeid'];
$station_id = $_SESSION['police_station'];

$id  = (int)($_GET['id'] ?? 0);
$fir = mysqli_fetch_assoc(mysqli_query($con,
    "SELECT f.*,
            u.FullName as UserName, u.MobileNumber as UserMobile, u.Email as UserEmail,
            cc.CrimeCategory, ps.PoliceStationName
     FROM tbl_fir f
     LEFT JOIN tbl_user u         ON f.UserID = u.id
     LEFT JOIN tbl_crimecategory cc ON f.CrimeCategoryID = cc.id
     LEFT JOIN tbl_policestation ps ON f.PoliceStationID = ps.id
     WHERE f.id = $id AND f.PoliceStationID = $station_id"
));
if(!$fir){ header("Location: view-fir.php"); exit(); }

$msg = '';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $status = mysqli_real_escape_string($con, $_POST['fir_status']);
    $remark = mysqli_real_escape_string($con, trim($_POST['remark']));

    mysqli_query($con,
        "UPDATE tbl_fir
         SET FIRStatus='$status', PoliceRemark='$remark', PoliceID=$pid
         WHERE id=$id AND PoliceStationID=$station_id"
    );
    $msg = "<div class='alert alert-success'><i class='fas fa-check-circle'></i> FIR #$id updated successfully!</div>";
    // Refresh FIR data
    $fir = mysqli_fetch_assoc(mysqli_query($con,
        "SELECT f.*,
                u.FullName as UserName, u.MobileNumber as UserMobile, u.Email as UserEmail,
                cc.CrimeCategory, ps.PoliceStationName
         FROM tbl_fir f
         LEFT JOIN tbl_user u         ON f.UserID = u.id
         LEFT JOIN tbl_crimecategory cc ON f.CrimeCategoryID = cc.id
         LEFT JOIN tbl_policestation ps ON f.PoliceStationID = ps.id
         WHERE f.id = $id"
    ));
}

include '../includes/police-header.php';
?>

<?php echo $msg; ?>

<!-- Two-column info grid -->
<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">

  <!-- FIR Information -->
  <div class="card" style="margin-bottom:0;">
    <div class="card-title-bar">
      <i class="fas fa-file-alt" style="color:#2196F3;margin-right:6px;"></i> FIR Information
    </div>
    <div class="card-body">
      <table style="width:100%;font-size:13.5px;border-collapse:collapse;">
        <tr>
          <td style="padding:7px 0;color:#777;width:130px;">FIR ID</td>
          <td><strong>#<?php echo $fir['id']; ?></strong></td>
        </tr>
        <tr>
          <td style="padding:7px 0;color:#777;">Crime Category</td>
          <td><?php echo htmlspecialchars($fir['CrimeCategory']); ?></td>
        </tr>
        <tr>
          <td style="padding:7px 0;color:#777;">Police Station</td>
          <td><?php echo htmlspecialchars($fir['PoliceStationName']); ?></td>
        </tr>
        <tr>
          <td style="padding:7px 0;color:#777;">Filed Date</td>
          <td><?php echo date('d M Y, H:i', strtotime($fir['FIRDate'])); ?></td>
        </tr>
        <tr>
          <td style="padding:7px 0;color:#777;">Current Status</td>
          <td>
            <?php
            $b = match($fir['FIRStatus']){
              'Pending'    => 'badge-pending',
              'Inprogress' => 'badge-inprogress',
              'Solved'     => 'badge-solved',
              default      => 'badge-pending'
            };
            ?>
            <span class="badge <?php echo $b; ?>"><?php echo $fir['FIRStatus']; ?></span>
          </td>
        </tr>
      </table>
    </div>
  </div>

  <!-- Complainant Info -->
  <div class="card" style="margin-bottom:0;">
    <div class="card-title-bar">
      <i class="fas fa-user" style="color:#4CAF50;margin-right:6px;"></i> Complainant Information
    </div>
    <div class="card-body">
      <table style="width:100%;font-size:13.5px;border-collapse:collapse;">
        <tr>
          <td style="padding:7px 0;color:#777;width:100px;">Full Name</td>
          <td><strong><?php echo htmlspecialchars($fir['UserName']); ?></strong></td>
        </tr>
        <tr>
          <td style="padding:7px 0;color:#777;">Mobile</td>
          <td><?php echo htmlspecialchars($fir['UserMobile']); ?></td>
        </tr>
        <tr>
          <td style="padding:7px 0;color:#777;">Email</td>
          <td><?php echo htmlspecialchars($fir['UserEmail']); ?></td>
        </tr>
        <?php if($fir['PoliceRemark']): ?>
        <tr>
          <td style="padding:7px 0;color:#777;vertical-align:top;">Prev. Remark</td>
          <td style="font-size:13px;color:#555;"><?php echo htmlspecialchars($fir['PoliceRemark']); ?></td>
        </tr>
        <?php endif; ?>
      </table>
    </div>
  </div>

</div>

<!-- FIR Subject & Detail -->
<div class="card">
  <div class="card-title-bar">FIR Subject &amp; Detail</div>
  <div class="card-body">
    <p style="font-size:14px;font-weight:600;color:#333;margin-bottom:10px;">
      <?php echo htmlspecialchars($fir['FIRSubject']); ?>
    </p>
    <p style="font-size:13.5px;line-height:1.8;color:#555;white-space:pre-wrap;"><?php echo htmlspecialchars($fir['FIRDetail']); ?></p>
  </div>
</div>

<!-- Update Status Form -->
<div class="card">
  <div class="card-title-bar">
    <i class="fas fa-edit" style="color:#FF9800;margin-right:6px;"></i> Update FIR Status
    <div class="card-controls">
      <button title="Minimize"><i class="fas fa-minus"></i></button>
      <button title="Close"><i class="fas fa-times"></i></button>
    </div>
  </div>
  <div class="card-body">
    <form method="POST">
      <div class="form-row">

        <div class="form-group">
          <label class="form-label">Update Status <span class="req">*</span></label>
          <select name="fir_status" class="form-control" required>
            <?php foreach(['Pending','Inprogress','Solved'] as $s): ?>
            <option value="<?php echo $s; ?>"
              <?php echo $fir['FIRStatus']===$s ? 'selected' : ''; ?>>
              <?php echo $s; ?>
            </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label">Police Remark / Investigation Note</label>
          <textarea name="remark" class="form-control" rows="3"
            placeholder="Add investigation notes, findings, or remarks..."><?php echo htmlspecialchars($fir['PoliceRemark'] ?? ''); ?></textarea>
        </div>

      </div>

      <div style="display:flex;gap:10px;flex-wrap:wrap;margin-top:6px;">
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-save"></i> Update FIR
        </button>
        <a href="add-charge-sheet.php?fir_id=<?php echo $fir['id']; ?>" class="btn btn-success">
          <i class="fas fa-file-invoice"></i> Add Charge Sheet
        </a>
        <a href="view-fir.php" class="btn btn-secondary">
          <i class="fas fa-arrow-left"></i> Back to FIRs
        </a>
        <button type="button" onclick="window.print()" class="btn btn-info no-print">
          <i class="fas fa-print"></i> Print
        </button>
      </div>
    </form>
  </div>
</div>

<?php include '../includes/police-footer.php'; ?>
