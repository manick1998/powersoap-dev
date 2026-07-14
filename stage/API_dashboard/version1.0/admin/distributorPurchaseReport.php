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
    $filters = "AND products.category_token='$inputData->division' AND products.token='$inputData->product' and employees.state_id='$inputData->state' and employees.region_id='$inputData->region'  AND DATE(orders.date_time) BETWEEN '$inputData->fromDate' AND '$inputData->toDate'";
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
