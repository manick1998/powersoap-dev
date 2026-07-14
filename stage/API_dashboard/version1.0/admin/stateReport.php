<?php
$obj = new stdClass();
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
include_once '../objects/inventory.php';
$inventory = new inventory($db);
if ($inputData->type == "stateSales") {
    $inventory->from_date = $inputData->from_date;
    $inventory->to_date = $inputData->to_date;
    //$inventory->state = " AND employees__state.state_token IN ('81940285','49837242','73874978','19401422','54279765','25013270')";
    $stmt = $inventory->stateSales();
    $array = $inventory->readstateSales($stmt);
    $overall = $inventory->overallsalesValue();
    $obj->status_code = 200;
    $obj->header = "Success";
    $obj->message = "State Wise List";
    $obj->data = $array;
    $obj->overall = $overall;
}
echo json_encode($obj);
