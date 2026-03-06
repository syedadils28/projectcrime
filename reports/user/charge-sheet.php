<?php
require_once '../includes/config.php';
$page_title = 'Charge Sheet';
$base_url = '../';
$uid = $_SESSION['userid'];

$sheets = mysqli_query($con,"SELECT cs.*,f.FIRSubject,f.FIRStatus,p.Name as OfficerName,ps.PoliceStationName FROM tbl_chargesheet cs LEFT JOIN tbl_fir f ON cs.FIRID=f.id LEFT JOIN tbl_police p ON cs.PoliceID=p.id LEFT JOIN tbl_policestation ps ON f.PoliceStationID=ps.id WHERE cs.UserID=$uid ORDER BY cs.id DESC");
include '../includes/user-header.php';
?>

<div class="card">
  <div class="card-title-bar">
    Charge Sheet
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
            <th>Police Station</th>
            <th>Officer</th>
            <th>Charge Sheet</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <?php $i=1; while($row=mysqli_fetch_assoc($sheets)): ?>
          <tr>
            <td><?php echo $i++; ?></td>
            <td>#<?php echo $row['FIRID']; ?></td>
            <td><?php echo htmlspecialchars($row['FIRSubject']); ?></td>
            <td><?php echo htmlspecialchars($row['PoliceStationName']); ?></td>
            <td><?php echo htmlspecialchars($row['OfficerName']); ?></td>
            <td><?php echo htmlspecialchars(substr($row['ChargeSheet'],0,60)); ?>...</td>
            <td><?php echo date('d M Y',strtotime($row['ChargeSheetDate'])); ?></td>
          </tr>
          <?php endwhile; ?>
          <?php if(mysqli_num_rows($sheets)==0): ?>
          <tr><td colspan="7" style="text-align:center;padding:20px;color:#aaa;">No charge sheets available yet.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include '../includes/user-footer.php'; ?>
