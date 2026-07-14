<?php
echo "Step 1\n";
include_once 'stage/API_dashboard/version1.0/config/core.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Step 2\n";
include_once 'stage/API_dashboard/version1.0/config/database.php';
echo "Step 3\n";
include_once 'stage/API_dashboard/version1.0/objects/order.php';

echo "Step 4\n";
$database = new Database();
$db = $database->getConnection();
$order = new Order($db);

echo "Step 5\n";
$order->orderToken  = "21055722";
$stmt=$order->singleOrderDetail();
$checkCount = $stmt->rowCount();

if($checkCount==0){
    echo "0 rows in singleOrderDetail\n";
}else{
    echo "Rows found in singleOrderDetail. Fetching...\n";
    $data =$order->readSingleOrder($stmt,$baseUrlPath);
    echo "Result: " . json_encode($data) . "\n";
}

?>
