<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/database.php';
include_once '../objects/employee.php';
$data = json_decode(file_get_contents("php://input"));
if (!$data) {
    $data = new stdClass();
}
$database = new Database();
$db = $database->getConnection();
$emp = new Employee($db);
$obj = new stdClass;
$region_token = isset($data->region) ? $data->region : '';
$type = isset($data->type) ? $data->type : '';

if ($type == "order_placed" || $type == "date_filter") {
    if ($region_token != '') {
        $regionQuery = "AND employees.region_id = '$region_token'";
    } else {
        $regionQuery = '';
    }
    if ($type == "date_filter") {
        $stateFilter = ($data->state == '0' || $data->state == '') ? "" : "AND employees.state_id = '$data->state'";
        $filters = "$stateFilter $regionQuery AND 
     DATE(orders.date_time) BETWEEN '$data->fromDate' AND '$data->toDate'";
    } else {
        $filters = '';
    }
    $stmt = $emp->order_count($filters);
    if ($check = $stmt->rowCount() > 0) {
        $arrays = $emp->order_count_read($stmt);
        $obj->status_code = 200;
        $obj->header = "Success";
        $obj->message = "Data listed";
        $obj->data = $arrays;
    } else {
        $obj->status_code = 400;
        $obj->header = "Error";
        $obj->message = "Something Error";
        $obj->data = [];
    }
} elseif ($type == "no_order" || $type == "non_order") {
    if ($region_token != '') {
        $regionQuery = "AND employees.region_id = '$region_token'";
    } else {
        $regionQuery = '';
    }
    if ($type == "non_order") {
        $stateFilter = ($data->state == '0' || $data->state == '') ? "" : "AND employees.state_id = '$data->state'";
        $filters = "$stateFilter $regionQuery AND 
     DATE(orders.date_time) BETWEEN '$data->fromDate' AND '$data->toDate'";
        $emp_filters = "$stateFilter $regionQuery";
    } else {
        $filters = '';
        $emp_filters = '';
    }
    $stmt = $emp->order_count($filters);
    $arrays = $emp->order_count_read($stmt);
    $arr_token = [];
    foreach ($arrays as $arrays) {
        array_push($arr_token, $arrays->distributor_token);
    }
    $stmt1 = $emp->no_order($arr_token, $emp_filters);
    $arr1 = $emp->no_order_read($stmt1);

    $obj->status_code = 200;
    $obj->header = "Success";
    $obj->message = "Data listed";
    $obj->data = $arr1;
}
echo json_encode($obj);
