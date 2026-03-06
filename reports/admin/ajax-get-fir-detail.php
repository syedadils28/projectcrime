<?php
require_once '../includes/config.php';

// Only accessible when logged in as police
if(!isset($_SESSION['policeid'])){
    http_response_code(403);
    echo json_encode(['error'=>'Unauthorized']);
    exit();
}

$station_id = (int)$_SESSION['police_station'];
$id         = (int)($_GET['id'] ?? 0);

if(!$id){
    echo json_encode(null);
    exit();
}

// Only allow reading FIRs at the officer's station
$fir = mysqli_fetch_assoc(mysqli_query($con,
    "SELECT f.id, f.FIRSubject, f.FIRDetail, f.FIRStatus, f.FIRDate,
            u.FullName as UserName, u.MobileNumber as UserMobile,
            cc.CrimeCategory
     FROM tbl_fir f
     LEFT JOIN tbl_user u  ON f.UserID = u.id
     LEFT JOIN tbl_crimecategory cc ON f.CrimeCategoryID = cc.id
     WHERE f.id = $id AND f.PoliceStationID = $station_id"
));

header('Content-Type: application/json');
echo json_encode($fir ?: null);
?>
