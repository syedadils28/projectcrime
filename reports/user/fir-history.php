<?php
require_once '../includes/config.php';
$page_title = 'FIR History';
$base_url = '../';
$uid = $_SESSION['userid'];

$firs = mysqli_query($con,"SELECT f.*,cc.CrimeCategory,ps.PoliceStationName,p.Name as OfficerName FROM tbl_fir f LEFT JOIN tbl_crimecategory cc ON f.CrimeCategoryID=cc.id LEFT JOIN tbl_policestation ps ON f.PoliceStationID=ps.id LEFT JOIN tbl_police p ON f.PoliceID=p.id WHERE f.UserID=$uid ORDER BY f.id DESC");
include '../includes/user-header.php';
?>

<div class="card">
  <div class="card-title-bar">
    My FIR History
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
            <th>Police Station</th>
            <th>Crime Category</th>
            <th>Subject</th>
            <th>Filed Date</th>
            <th>Status</th>
            <th>Police Remark</th>
          </tr>
        </thead>
        <tbody>
          <?php $i=1; while($row=mysqli_fetch_assoc($firs)):
            $badge=match($row['FIRStatus']){'Pending'=>'badge-pending','Inprogress'=>'badge-inprogress','Solved'=>'badge-solved',default=>'badge-pending'};
          ?>
          <tr>
            <td><?php echo $i++; ?></td>
            <td><strong>#<?php echo $row['id']; ?></strong></td>
            <td><?php echo htmlspecialchars($row['PoliceStationName']); ?></td>
            <td><?php echo htmlspecialchars($row['CrimeCategory']); ?></td>
            <td><?php echo htmlspecialchars(substr($row['FIRSubject'],0,35)); ?></td>
            <td><?php echo date('d M Y',strtotime($row['FIRDate'])); ?></td>
            <td><span class="badge <?php echo $badge; ?>"><?php echo $row['FIRStatus']; ?></span></td>
            <td><?php echo $row['PoliceRemark'] ? htmlspecialchars($row['PoliceRemark']) : '<span style="color:#aaa;">-</span>'; ?></td>
          </tr>
          <?php endwhile; ?>
          <?php if(mysqli_num_rows($firs)==0): ?>
          <tr><td colspan="8" style="text-align:center;padding:20px;color:#aaa;">No FIRs filed yet. <a href="fir-form.php">File your first FIR</a></td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include '../includes/user-footer.php'; ?>
