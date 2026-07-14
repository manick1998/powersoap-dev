<?php
$obj = new stdClass();
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
include_once '../objects/inventory.php';
$inventory = new inventory($db);
if ($inputData->type == "date_filter") {
    $filters = "and employees.state_id='$inputData->state' and employees.region_id='$inputData->region' and  orders.employee_token = '$inputData->distributor' AND DATE(orders.date_time) BETWEEN '$inputData->fromDate' AND '$inputData->toDate'";
    $stmt = $inventory->distributorOrderReport($filters);
    $array = $inventory->readOrderReport($stmt);
    $obj->status_code = 200;
    $obj->header = "Success";
    $obj->message = "distributor Wise List";
    $obj->data = $array;
}
echo json_encode($obj);
