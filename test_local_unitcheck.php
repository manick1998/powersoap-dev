<?php
require_once '/Applications/MAMP/htdocs/powersoap_live-main/stage/API_dashboard/version1.0/config/database.php';
require_once '/Applications/MAMP/htdocs/powersoap_live-main/stage/API_dashboard/version1.0/objects/schedule_distributor.php';

$database = new Database();
$db = $database->getConnection();

$dist_token = '58502394';
$schedule = new Schedule($db);
$schedule->distributor_token = $dist_token;

echo "--- RUNNING unitCheck() LOCALLY FOR DIST: $dist_token ---\n";
$stmt = $schedule->unitCheck();
echo "Results found: " . $stmt->rowCount() . "\n";

while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "Unit: " . $row['name'] . " - Shops: " . $row['shop_count'] . " - Status: " . $row['active_status'] . "\n";
}
?>
