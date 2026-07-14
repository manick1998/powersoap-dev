<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/database.php';
include_once '../objects/employee.php';
$data = json_decode(file_get_contents("php://input"));
date_default_timezone_set('Asia/Kolkata');
$currentDate  = date("Y-m-d H:i:s");
$database = new Database();
$db = $database->getConnection();
$emp = new Employee($db);
$obj = new stdClass;
if ($data->type == "support_log") {
    $stmt = $emp->support_log_data();
    $read_data = $emp->support_log_data_read($stmt);
    $count = $stmt->rowCount();
    if ($count>0) {
        $obj-> code ='200';
        $obj->message = 'data founded';
        $obj->data = $read_data;
    }else{
        $obj-> code ='404';
        $obj->message = 'data not founded';
        $obj->data =[];
    }
}else if($data->type == "shop_type_log"){
    $stmt = $emp->shop_type_log_data();
    $read_data = $emp->shop_type_log_data_read($stmt);
    $count = $stmt->rowCount();
    if ($count>0) {
        $obj-> code ='200';
        $obj->message = 'data founded';
        $obj->data = $read_data;
    }else{
        $obj-> code ='404';
        $obj->message = 'data not founded';
        $obj->data =[];
    }
}else if($data->type == "shop_create_log"){
    $stmt = $emp->shop_create_log_data();
    $read_data = $emp->shop_create_log_data_read($stmt);
    $count = $stmt->rowCount();
    if ($count>0) {
        $obj-> code ='200';
        $obj->message = 'data founded';
        $obj->data = $read_data;
    }else{
        $obj-> code ='404';
        $obj->message = 'data not founded';
        $obj->data =[];
    }
}else if($data->type == "admin_stock_log"){
    $stmt = $emp->admin_stock_log_data();
    $read_data = $emp->admin_stock_log_data_read($stmt);
    $count = $stmt->rowCount();
    if ($count>0) {
        $obj-> code ='200';
        $obj->message = 'data founded';
        $obj->data = $read_data;
    }else{
        $obj-> code ='404';
        $obj->message = 'data not founded';
        $obj->data =[];
    }
}else if($data->type == "Distributor_log"){
    $stmt = $emp->Distributor_log_data();
    $read_data = $emp->Distributor_log_data_read($stmt);
    $count = $stmt->rowCount();
    if ($count>0) {
        $obj-> code ='200';
        $obj->message = 'data founded';
        $obj->data = $read_data;
    }else{
        $obj-> code ='404';
        $obj->message = 'data not founded';
        $obj->data =[];
    }
}else if($data->type == "Distributor_division_log"){
    $emp->distributor_token = $data->distributor_token;
    $stmt = $emp->Distributor_division_log_data();
    $read_data = $emp->Distributor_division_log_data_read($stmt);
    $count = $stmt->rowCount();
    if ($count>0) {
        $obj-> code ='200';
        $obj->message = 'data founded';
        $obj->data = $read_data;
    }else{
        $obj-> code ='404';
        $obj->message = 'data not founded';
        $obj->data =[];
    }
}else if($data->type == "Distributor_division_log1"){
    $emp->distributor_token = $data->distributor_token;
    $stmt = $emp->Distributor_division_log_data1();
    $read_data = $emp->Distributor_division_log_data_read1($stmt);
    $count = $stmt->rowCount();
    if ($count>0) {
        $obj-> code ='200';
        $obj->message = 'data founded';
        $obj->data = $read_data;
    }else{
        $obj-> code ='404';
        $obj->message = 'data not founded';
        $obj->data =[];
    }
}
echo json_encode($obj);
?>