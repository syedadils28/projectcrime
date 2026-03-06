<?php
require_once '../includes/config.php';
$page_title = 'View FIR';
$base_url   = '../';
$breadcrumb = [['label'=>'FIR'], ['label'=>'View FIR']];

if(!isset($_SESSION['policeid'])){ header("Location: login.php"); exit(); }
$pid        = $_SESSION['policeid'];
$station_id = $_SESSION['police_station'];

// Filters
$status_filter = isset($_GET['status']) ? mysqli_real_escape_string($con,$_GET['status']) : '';
$mine_filter   = isset($_GET['mine'])   ? 1 : 0;

$where = ["f.PoliceStationID=$station_id"];
if($status_filter) $where[] = "f.FIRStatus='$status_filter'";
if($mine_filter)   $where[] = "f.PoliceID=$pid";
$wc = 'WHERE '.implode(' AND ',$where);

$firs = mysqli_query($con,"SELECT f.*,u.FullName as UserName,u.MobileNumber as UserMobile,cc.CrimeCategory FROM tbl_fir f LEFT JOIN tbl_user u ON f.UserID=u.id LEFT JOIN tbl_crimecategory cc ON f.CrimeCategoryID=cc.id $wc ORDER BY f.id DESC");

include '../includes/police-header.php';
?>

<!-- Filter Bar -->
<div style="display:flex;gap:8px;margin-bottom:16px;flex-wrap:wrap;">
  <a href="view-fir.php" class="btn btn-sm <?php echo !$status_filter&&!$mine_filter?'btn-primary':'btn-secondary'; ?>">All FIRs</a>
  <a href="view-fir.php?status=Pending"    class="btn btn-sm <?php echo $status_filter==='Pending'?'btn-primary':'btn-secondary'; ?>"><i class="fas fa-clock"></i> Pending</a>
  <a href="view-fir.php?status=Inprogress" class="btn btn-sm <?php echo $status_filter==='Inprogress'?'btn-primary':'btn-secondary'; ?>"><i class="fas fa-spinner"></i> In-Progress</a>
  <a href="view-fir.php?status=Solved"     class="btn btn-sm <?php echo $status_filter==='Solved'?'btn-primary':'btn-secondary'; ?>"><i class="fas fa-check"></i> Solved</a>
  <a href="view-fir.php?mine=1"            class="btn btn-sm <?php echo $mine_filter?'btn-primary':'btn-secondary'; ?>"><i class="fas fa-user-tie"></i> My FIRs</a>
</div>

<div class="card">
  <div class="card-title-bar">
    FIR Records (<?php echo mysqli_num_rows($firs); ?>)
    <div class="card-controls"><button><i class="fas fa-minus"></i></button><button><i class="fas fa-times"></i></button></div>
  </div>
  <div class="card-body" style="padding:0;">
    <div class="table-wrapper">
      <table class="crms-table">
        <thead>
          <tr>
            <th class="sno">S.No</th>
            <th>FIR ID</th>
            <th>Complainant</th>
            <th>Mobile</th>
            <th>Crime Category</th>
            <th>Subject</th>
            <th>Filed Date</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php $i=1; while($row=mysqli_fetch_assoc($firs)):
            $badge = match($row['FIRStatus']){
              'Pending'    => 'badge-pending',
              'Inprogress' => 'badge-inprogress',
              'Solved'     => 'badge-solved',
              default      => 'badge-pending'
            };
          ?>
          <tr>
            <td><?php echo $i++; ?></td>
            <td><strong>#<?php echo $row['id']; ?></strong></td>
            <td><?php echo htmlspecialchars($row['UserName']); ?></td>
            <td><?php echo htmlspecialchars($row['UserMobile']); ?></td>
            <td><?php echo htmlspecialchars($row['CrimeCategory']); ?></td>
            <td style="max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><?php echo htmlspecialchars($row['FIRSubject']); ?></td>
            <td><?php echo date('d M Y',strtotime($row['FIRDate'])); ?></td>
            <td><span class="badge <?php echo $badge; ?>"><?php echo $row['FIRStatus']; ?></span></td>
            <td style="white-space:nowrap;">
              <button class="btn btn-sm btn-view"
                onclick="openView(<?php echo $row['id']; ?>,'<?php echo addslashes($row['FIRSubject']); ?>','<?php echo addslashes($row['FIRDetail']); ?>','<?php echo $row['FIRStatus']; ?>','<?php echo addslashes($row['PoliceRemark']??''); ?>')">
                <i class="fas fa-eye"></i> View
              </button>
              <a href="view-fir-detail.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-edit">
                <i class="fas fa-edit"></i> Update
              </a>
            </td>
          </tr>
          <?php endwhile; ?>
          <?php if(mysqli_num_rows($firs)==0): ?>
          <tr><td colspan="9" style="text-align:center;padding:20px;color:#aaa;">No FIR records found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- View Modal -->
<div id="viewModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.45);z-index:3000;align-items:center;justify-content:center;">
  <div style="background:#fff;border-radius:4px;width:540px;max-height:85vh;overflow-y:auto;box-shadow:0 4px 24px rgba(0,0,0,0.2);">
    <div style="background:#37474f;color:#fff;padding:13px 18px;font-size:14px;font-weight:500;display:flex;justify-content:space-between;align-items:center;position:sticky;top:0;">
      <span><i class="fas fa-file-alt"></i> FIR Detail — <span id="mv_id"></span></span>
      <button onclick="document.getElementById('viewModal').style.display='none'" style="background:none;border:none;color:#fff;cursor:pointer;font-size:18px;">&times;</button>
    </div>
    <div style="padding:20px;">
      <table style="width:100%;font-size:13.5px;border-collapse:collapse;">
        <tr><td style="padding:8px 4px;color:#777;width:130px;vertical-align:top;">Subject</td><td style="padding:8px 4px;font-weight:500;" id="mv_subject"></td></tr>
        <tr style="border-top:1px solid #f5f5f5;"><td style="padding:8px 4px;color:#777;vertical-align:top;">Detail</td><td style="padding:8px 4px;line-height:1.6;color:#555;" id="mv_detail"></td></tr>
        <tr style="border-top:1px solid #f5f5f5;"><td style="padding:8px 4px;color:#777;">Status</td><td style="padding:8px 4px;" id="mv_status"></td></tr>
        <tr style="border-top:1px solid #f5f5f5;"><td style="padding:8px 4px;color:#777;vertical-align:top;">Police Remark</td><td style="padding:8px 4px;color:#555;" id="mv_remark"></td></tr>
      </table>
    </div>
  </div>
</div>

<script>
function openView(id,subject,detail,status,remark){
  document.getElementById('mv_id').textContent='#'+id;
  document.getElementById('mv_subject').textContent=subject;
  document.getElementById('mv_detail').textContent=detail;
  var b={'Pending':'badge-pending','Inprogress':'badge-inprogress','Solved':'badge-solved'}[status]||'badge-pending';
  document.getElementById('mv_status').innerHTML='<span class="badge '+b+'">'+status+'</span>';
  document.getElementById('mv_remark').textContent=remark||'—';
  document.getElementById('viewModal').style.display='flex';
}
</script>

<?php include '../includes/police-footer.php'; ?>
