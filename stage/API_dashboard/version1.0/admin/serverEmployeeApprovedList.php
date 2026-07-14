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
date_default_timezone_set('Asia/Kolkata');
$date = date('Y-m-d H:i',strtotime('now'));
if ($data->type == 'all_emp') {
    $func = $emp->serverEmployeeCheck_app();
    $check = $func->rowCount();
   if ($check > 0) {
        $fetch_data = $emp->serverReadEmployee_app($func);
        $obj->code = '200';
        $obj->message = 'data founded';
        $obj->data = $fetch_data;
   }else{
    $obj->code = '404';
    $obj->message = 'data not founded';
   }
}elseif ($data->type == 'single') {
     date_default_timezone_set('Asia/Kolkata');
     // $indiaDateTime = date("Y-m-d H:i:s");
     $indiaDate     = date("Y-m-d");
     $emp->indiaDate    = $indiaDate;
     $emp->employeeToken = $data->employee_token; 
     $stmt = $emp->employeeDetailCheckSingle_rep();
     $checkCount = $stmt->rowCount();
     // echo  $checkCount;
        if($checkCount==0){
            $obj->code=503;
            $obj->data=[];
        }else{
            $obj->code = 201;
            $obj->data = $emp->readEmployeeDetailsSingle($stmt);
        }
}elseif ($data->type == 'status_updated') {
    $emp->status_token = $data->status_token;
    $emp->distributor_token = $data->distributor_token; 
    if ($emp->status_update_rq()) {
        date_default_timezone_set('Asia/Kolkata');
        $dates = date("Y-m-d H:i:sa");
        $emp->status_update_rq_mapping($dates);
        $obj->code = 200;
        $obj->message = 'status updated successfully';
    }
    else{
        $obj->code = 400;
        $obj->message = 'status not updated successfully';
    }

}
echo json_encode($obj);
?>