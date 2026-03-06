<?php
require_once '../includes/config.php';
$page_title = 'Search';
$base_url   = '../';
$breadcrumb = [['label'=>'Search']];

if(!isset($_SESSION['policeid'])){ header("Location: login.php"); exit(); }
$station_id = $_SESSION['police_station'];

$results_fir  = null;
$results_crim = null;
$keyword      = '';
$search_type  = isset($_GET['type']) ? $_GET['type'] : 'both';

if(isset($_GET['keyword']) && trim($_GET['keyword'])!==''){
    $keyword = mysqli_real_escape_string($con, trim($_GET['keyword']));

    if($search_type==='fir'||$search_type==='both'){
        $results_fir = mysqli_query($con,"SELECT f.*,u.FullName as UserName,cc.CrimeCategory FROM tbl_fir f LEFT JOIN tbl_user u ON f.UserID=u.id LEFT JOIN tbl_crimecategory cc ON f.CrimeCategoryID=cc.id WHERE f.PoliceStationID=$station_id AND (f.FIRSubject LIKE '%$keyword%' OR u.FullName LIKE '%$keyword%' OR cc.CrimeCategory LIKE '%$keyword%' OR f.id LIKE '%$keyword%') ORDER BY f.id DESC");
    }
    if($search_type==='criminal'||$search_type==='both'){
        $results_crim = mysqli_query($con,"SELECT c.*,cc.CrimeCategory FROM tbl_criminal c LEFT JOIN tbl_crimecategory cc ON c.CrimeCategoryID=cc.id WHERE c.PoliceStationID=$station_id AND (c.CriminalName LIKE '%$keyword%' OR cc.CrimeCategory LIKE '%$keyword%') ORDER BY c.id DESC");
    }
}

include '../includes/police-header.php';
?>

<div class="card">
  <div class="card-title-bar">Search Records</div>
  <div class="card-body">
    <form method="GET" style="display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap;">
      <div style="flex:1;min-width:220px;">
        <label class="form-label" style="font-size:12px;">Search Keyword</label>
        <input type="text" name="keyword" class="form-control" placeholder="Name, FIR ID, category..."
               value="<?php echo htmlspecialchars($keyword); ?>">
      </div>
      <div>
        <label class="form-label" style="font-size:12px;">Search In</label>
        <select name="type" class="form-control" style="width:160px;">
          <option value="both"     <?php echo $search_type==='both'?'selected':''; ?>>Both (FIR + Criminals)</option>
          <option value="fir"      <?php echo $search_type==='fir'?'selected':''; ?>>FIR Only</option>
          <option value="criminal" <?php echo $search_type==='criminal'?'selected':''; ?>>Criminals Only</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
      <?php if($keyword): ?><a href="search.php" class="btn btn-secondary">Reset</a><?php endif; ?>
    </form>
  </div>
</div>

<?php if($results_fir !== null): ?>
<!-- FIR Results -->
<div class="card">
  <div class="card-title-bar">
    FIR Results
    <span style="font-size:12px;font-weight:400;color:#777;margin-left:8px;"><?php echo mysqli_num_rows($results_fir); ?> found</span>
  </div>
  <div class="card-body" style="padding:0;">
    <div class="table-wrapper">
      <table class="crms-table">
        <thead>
          <tr>
            <th class="sno">S.No</th>
            <th>FIR ID</th>
            <th>Complainant</th>
            <th>Crime Category</th>
            <th>Subject</th>
            <th>Date</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php $i=1; while($row=mysqli_fetch_assoc($results_fir)):
            $badge=match($row['FIRStatus']){'Pending'=>'badge-pending','Inprogress'=>'badge-inprogress','Solved'=>'badge-solved',default=>'badge-pending'};
          ?>
          <tr>
            <td><?php echo $i++; ?></td>
            <td><strong>#<?php echo $row['id']; ?></strong></td>
            <td><?php echo htmlspecialchars($row['UserName']); ?></td>
            <td><?php echo htmlspecialchars($row['CrimeCategory']); ?></td>
            <td><?php echo htmlspecialchars(substr($row['FIRSubject'],0,40)); ?></td>
            <td><?php echo date('d M Y',strtotime($row['FIRDate'])); ?></td>
            <td><span class="badge <?php echo $badge; ?>"><?php echo $row['FIRStatus']; ?></span></td>
          </tr>
          <?php endwhile; ?>
          <?php if(mysqli_num_rows($results_fir)==0): ?>
          <tr><td colspan="7" style="text-align:center;padding:20px;color:#aaa;">No FIRs found for "<?php echo htmlspecialchars($keyword); ?>"</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php endif; ?>

<?php if($results_crim !== null): ?>
<!-- Criminal Results -->
<div class="card">
  <div class="card-title-bar">
    Criminal Results
    <span style="font-size:12px;font-weight:400;color:#777;margin-left:8px;"><?php echo mysqli_num_rows($results_crim); ?> found</span>
  </div>
  <div class="card-body" style="padding:0;">
    <div class="table-wrapper">
      <table class="crms-table">
        <thead>
          <tr>
            <th class="sno">S.No</th>
            <th>Photo</th>
            <th>Criminal Name</th>
            <th>Crime Category</th>
            <th>Date of Crime</th>
          </tr>
        </thead>
        <tbody>
          <?php $i=1; while($row=mysqli_fetch_assoc($results_crim)): ?>
          <tr>
            <td><?php echo $i++; ?></td>
            <td>
              <?php if($row['CriminalPhoto'] && file_exists('../images/criminals/'.$row['CriminalPhoto'])): ?>
                <img src="../images/criminals/<?php echo htmlspecialchars($row['CriminalPhoto']); ?>" class="criminal-photo">
              <?php else: ?>
                <div style="width:40px;height:40px;border-radius:50%;background:#e0e0e0;display:flex;align-items:center;justify-content:center;color:#aaa;"><i class="fas fa-user"></i></div>
              <?php endif; ?>
            </td>
            <td><?php echo htmlspecialchars($row['CriminalName']); ?></td>
            <td><?php echo htmlspecialchars($row['CrimeCategory']); ?></td>
            <td><?php echo date('d M Y',strtotime($row['DateOfCrime'])); ?></td>
          </tr>
          <?php endwhile; ?>
          <?php if(mysqli_num_rows($results_crim)==0): ?>
          <tr><td colspan="5" style="text-align:center;padding:20px;color:#aaa;">No criminals found for "<?php echo htmlspecialchars($keyword); ?>"</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php endif; ?>

<?php include '../includes/police-footer.php'; ?>
