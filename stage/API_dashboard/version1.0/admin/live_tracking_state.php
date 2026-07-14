<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/database.php';
include_once '../objects/employee.php';
$data = json_decode(file_get_contents("php://input"));
$database = new Database();
$db = $database->getConnection();
$emp = new Employee($db);
$obj = new stdClass;

$date = date("Y-m-d");
 if ($data->type == "overall value") {
 $func = $emp->live_tracking_state($date);
 $results = $func->fetchAll(PDO::FETCH_ASSOC);
 $check = count($results);
 
 if ($check > 0) {
    $obj->status_code = 200;
    $obj->header = "Success";
    $obj->message = "Data listed"; 
    $obj->data = $emp->live_tracking_state_read_array($results); 
 }
 else {
    // Aggregates always return 1 row in MySQL, but as a safeguard:
    $obj1 = new stdClass;
    $obj1->orders_count = "0";
    $obj1->total_order_value = "0";
    $obj->status_code = 200; 
    $obj->header = "Success";
    $obj->message = "No data found, showing fallback zeros"; 
    $obj->data = [$obj1];
 }
}elseif ($data->type == "state") {
   $state =  $emp->state_data($date);
   $state_results = $state->fetchAll(PDO::FETCH_ASSOC);
   $state_check = count($state_results);
   if ($state_check > 0) {
    $obj->status_code = 200;
    $obj->header = "Success";
    $obj->message = "State Data listed"; 
    $obj->state_date = $emp->state_data_read_array($state_results); 
 }
 else {
    $obj->status_code = 200;
    $obj->header = "Success";
    $obj->message = "No State Data"; 
    $obj->state_date = [];
 }
 }elseif($data->type == 'sidebar_statedata'){
   $sidebar_statedata = $emp->sidebar_statedata();
   $sidebar_statedata_check = $sidebar_statedata->rowCount();
   if ($sidebar_statedata_check > 0) {
    $all_state_data = $emp->sidebar_statedata_read($sidebar_statedata);
    $obj->status_code = 200;
    $obj->header = "Success";
    $obj->message = "State Data listed"; 
    $obj->all_state_datas = $all_state_data; 
 }
 else {
    $obj->status_code = 400;
    $obj->header = "Error";
    $obj->message = "All State Error"; 
    $obj->all_state_datas = [];
 }
 }elseif($data->type == 'total_leave_count'){
   $leave_count = $emp->livetrackingcountLeave($date);
   $check_leave_count = $leave_count->rowCount();
   if ($check_leave_count > 0) {
    $leave = $emp->livetrackingcountLeave_read($leave_count);
    $obj->status_code = 200;
    $obj->header = "Success";
    $obj->message = "Leave Count listed"; 
    $obj->total_leave_count = $leave; 
   }else{
      $obj->status_code = 400;
      $obj->header = "Error";
      $obj->message = "Leave Count Error"; 
      $obj->total_leave_count = [];
   }
 }else if($data->type == 'particular_state_order_value'){
    $emp->state_token = $data->state_token; 
   
   $result = $emp->particular_state_order_details($date);
   $count = $result->rowCount();
   if ($count >0) {
      $stmt = $emp->particular_state_order_read($result);
      $obj->status_code = 200;
      $obj->header = "Success";
      $obj->message = "particular_state_order_read listed"; 
      $obj->particular_state_order_read = $stmt; 
   }else{
      $obj->status_code = 400;
      $obj->header = "Error";
      $obj->message = "particular_state_order_read Error"; 
      $obj->particular_state_order_read = [];
   }
 } else if ($data->type == 'total_live_info') {
    // 1. Overall live tracking state
    $func = $emp->live_tracking_state($date);
    $overall_results = $func->fetchAll(PDO::FETCH_ASSOC);
    $obj->overall_stats = count($overall_results) > 0 ? $emp->live_tracking_state_read_array($overall_results) : [];

    // 2. State data
    $state = $emp->state_data($date);
    $state_results = $state->fetchAll(PDO::FETCH_ASSOC);
    $obj->state_data = count($state_results) > 0 ? $emp->state_data_read_array($state_results) : [];

    // 3. Sidebar state data
    $sidebar_statedata = $emp->sidebar_statedata();
    if ($sidebar_statedata->rowCount() > 0) {
        $obj->sidebar_statedata = $emp->sidebar_statedata_read($sidebar_statedata);
    } else {
        $obj->sidebar_statedata = [];
    }

    // 4. Leave count
    $leave_count = $emp->livetrackingcountLeave($date);
    if ($leave_count->rowCount() > 0) {
        $obj->leave_count = $emp->livetrackingcountLeave_read($leave_count);
    } else {
        $obj->leave_count = [];
    }

    $obj->status_code = 200;
    $obj->header = "Success";
    $obj->message = "Consolidated Live Data listed";
 }

echo json_encode($obj);
$db = null;



?>