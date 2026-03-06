<?php
require_once '../includes/config.php';
$page_title = 'FIR Report';
$base_url = '../';

$from   = isset($_GET['from']) ? mysqli_real_escape_string($con,$_GET['from']) : '';
$to     = isset($_GET['to'])   ? mysqli_real_escape_string($con,$_GET['to'])   : '';
$status = isset($_GET['status']) ? mysqli_real_escape_string($con,$_GET['status']) : '';

$where=[];
if($from)   $where[]="DATE(f.FIRDate)>='$from'";
if($to)     $where[]="DATE(f.FIRDate)<='$to'";
if($status) $where[]="f.FIRStatus='$status'";
$wc = $where ? 'WHERE '.implode(' AND ',$where) : '';

$firs = mysqli_query($con,"SELECT f.*,u.FullName as UserName,cc.CrimeCategory,ps.PoliceStationName FROM tbl_fir f LEFT JOIN tbl_user u ON f.UserID=u.id LEFT JOIN tbl_crimecategory cc ON f.CrimeCategoryID=cc.id LEFT JOIN tbl_policestation ps ON f.PoliceStationID=ps.id $wc ORDER BY f.id DESC");
include '../includes/admin-header.php';
?>

<div class="card">
  <div class="card-title-bar">FIR Report Filter</div>
  <div class="card-body">
    <form method="GET" style="display:flex;gap:14px;flex-wrap:wrap;align-items:flex-end;">
      <div>
        <label class="form-label" style="font-size:12px;">From Date</label>
        <input type="date" name="from" class="form-control" style="width:160px;" value="<?php echo htmlspecialchars($from); ?>">
      </div>
      <div>
        <label class="form-label" style="font-size:12px;">To Date</label>
        <input type="date" name="to" class="form-control" style="width:160px;" value="<?php echo htmlspecialchars($to); ?>">
      </div>
      <div>
        <label class="form-label" style="font-size:12px;">Status</label>
        <select name="status" class="form-control" style="width:150px;">
          <option value="">All Status</option>
          <?php foreach(['Pending','Inprogress','Solved'] as $s): ?>
          <option value="<?php echo $s; ?>" <?php echo $status==$s?'selected':''; ?>><?php echo $s; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Filter</button>
      <a href="report-fir.php" class="btn btn-secondary btn-sm">Reset</a>
      <button type="button" onclick="window.print()" class="btn btn-info btn-sm no-print"><i class="fas fa-print"></i> Print</button>
    </form>
  </div>
</div>

<div class="card">
  <div class="card-title-bar">FIR Records (<?php echo mysqli_num_rows($firs); ?> found)</div>
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
          </tr>
        </thead>
        <tbody>
          <?php $i=1; while($row=mysqli_fetch_assoc($firs)):
            $badge=match($row['FIRStatus']){'Pending'=>'badge-pending','Inprogress'=>'badge-inprogress','Solved'=>'badge-solved',default=>'badge-pending'};
          ?>
          <tr>
            <td><?php echo $i++; ?></td>
            <td>#<?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['UserName']); ?></td>
            <td><?php echo htmlspecialchars($row['PoliceStationName']); ?></td>
            <td><?php echo htmlspecialchars($row['CrimeCategory']); ?></td>
            <td><?php echo htmlspecialchars(substr($row['FIRSubject'],0,35)); ?></td>
            <td><?php echo date('d M Y',strtotime($row['FIRDate'])); ?></td>
            <td><span class="badge <?php echo $badge; ?>"><?php echo $row['FIRStatus']; ?></span></td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include '../includes/admin-footer.php'; ?>
