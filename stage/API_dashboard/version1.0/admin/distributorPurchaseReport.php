<?php
$obj = new stdClass();
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
include_once '../objects/inventory.php';
$inventory = new inventory($db);
$filters = '';
if ($inputData->type == "date_filter") {
    $filters = "AND products.category_token='$inputData->division'
     AND products.token='$inputData->product' 
     and employees.state_id='$inputData->state' 
     and employees.region_id='$inputData->region'  
     AND DATE(orders.date_time) BETWEEN '$inputData->fromDate' AND '$inputData->toDate'";
} else {
    $filters = "AND products.category_token='$inputData->division' AND products.token='$inputData->product' and employees.state_id='$inputData->state'  AND DATE(orders.date_time) BETWEEN '$inputData->fromDate' AND '$inputData->toDate'";
}
$stmt = $inventory->distributorPurchaseReport($filters);
$array = $inventory->readPurchaseReport($stmt);
$obj->status_code = 200;
$obj->header = "Success";
$obj->message = "distributor Wise List";
$obj->data = $array;

echo json_encode($obj);


// <?php
// $obj = new stdClass();
// include_once '../config/core.php';
// $inputData = getInputs();
// include_once '../config/database.php';
// $database = new Database();
// $db = $database->getConnection();
// include_once '../objects/inventory.php';
// $inventory = new inventory($db);
// $filters = '';
// if ($inputData->type == "date_filter") {
//     // echo "$inputData->fromDate  00:00:00";
//     // exit;
//     $filters = '';
//     if (!empty($inputData->fromDate) and  !empty($inputData->toDate) and  !empty($inputData->division) || !empty($inputData->product)) {
//         // echo 'check-1';
//         if ($inputData->product == 'all') {
//             $filters .= "AND products.category_token='$inputData->division' 
//             AND orders.date_time >= '$inputData->fromDate 00:00:00' 
//             AND orders.date_time <= '$inputData->toDate 23:59:59'";
//         }else{
//              $filters .= "AND products.category_token='$inputData->division' 
//             AND orders.date_time >= '$inputData->fromDate 00:00:00' 
//             AND orders.date_time <= '$inputData->toDate 23:59:59'";
//         }
       
//     }else{
//         //  echo 'check-2';
//             // $filters = "AND products.category_token='$inputData->division' 
//             // AND products.token='$inputData->product' 
//             // AND employees.state_id='$inputData->state' 
//             // AND employees.region_id='$inputData->region'  
//             // AND orders.date_time >= '$inputData->fromDate 00:00:00' 
//             // AND orders.date_time <= '$inputData->toDate 23:59:59'";
//     }
   
// } else {
//     $filters .= "AND products.category_token='$inputData->division' AND products.token='$inputData->product' and employees.state_id='$inputData->state'
//      AND orders.date_time >= '$inputData->fromDate' 
//     AND orders.date_time <= '$inputData->toDate'  ";
//     // AND DATE(orders.date_time) BETWEEN '$inputData->fromDate' AND '$inputData->toDate'";
// }
// $stmt = $inventory->distributorPurchaseReport($filters);
// $array = $inventory->readPurchaseReport($stmt);
// $obj->status_code = 200;
// $obj->header = "Success";
// $obj->message = "distributor Wise List";
// $obj->data = $array;

// echo json_encode($obj);

// // AND products.category_token='70175991' AND products.token='57532388' and employees.state_id='25013270' and employees.region_id='46646392' AND orders.date_time >= '2024-01-01 00:00:00' AND orders.date_time <= '2026-09-17 23:59:59'
  