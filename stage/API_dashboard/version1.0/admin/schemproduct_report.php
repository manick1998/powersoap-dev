<?php
//session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/database.php';
include_once '../objects/employee.php';
//include_once '../config/core.php';
$database = new Database();
$db = $database->getConnection();
$emp = new Employee($db);
$input_data = json_decode(file_get_contents("php://input"));
$obj = new stdClass;
if($input_data->type == "all" || $input_data->type == "datefilter"){ 
   if ($input_data->type == "datefilter") {
      $date_fillter = "AND date(sold_boxs.date_time) BETWEEN '$input_data->fromDate' AND '$input_data->toDate'";
   }else{
      $date_fillter = "";
   }  
    $stmt = $emp->all_schem_report($date_fillter);
    $check = $stmt->rowCount();  
    if ($check > 0) {
       $array = $emp->all_schem_report_read($stmt);
       $obj->status_code = 200;
       $obj->header = "Success";
       $obj->message = "Data listed"; 
       $obj->data = $array; 
    }
    else {
       $obj->status_code = 400;
       $obj->header = "Error";
       $obj->message = "Something Error"; 
       $obj->data = [];
    }
}

echo json_encode($obj);   
?>
