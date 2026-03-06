<?php
require_once '../includes/config.php';
$station_id = (int)($_GET['station_id'] ?? 0);
$result = mysqli_query($con,"SELECT id,Name,PoliceID FROM tbl_police WHERE PoliceStationID=$station_id AND Status=1 ORDER BY Name");
$data = [];
while($row = mysqli_fetch_assoc($result)) $data[] = $row;
header('Content-Type: application/json');
echo json_encode($data);
?>
