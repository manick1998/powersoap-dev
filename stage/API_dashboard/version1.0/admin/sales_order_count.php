<?php

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
$region_token = $input_data->region_token;
if($input_data->type=="order_placed" || $input_data->type=="filters_date" ){ 
   if($region_token!=''){
    $regionQuery = "AND employees.region_id = '$region_token'";
   }else{
    $regionQuery='';
   }
 if($input_data->type=="filters_date"){
    $filters = "AND employees.state_id = '$input_data->state_token' $regionQuery AND 
    DATE(orders.date_time) BETWEEN '$input_data->fromDate' AND '$input_data->toDate'";
   }else{
    $filters = '';
}
$stmt = $emp->sales_order_count($filters);
if($stmt->rowCount()>0){
    $data = $emp->sales_order_count_read($stmt);
$obj->status_code = 200;
$obj->header = "Success";
$obj->message = "Data listed"; 
$obj->data=$data;
}else{
    $obj->status_code = 400;
$obj->header = "Error";
$obj->message = "Something went to wrong";
$obj->data=[]; 
}
}else if ($input_data->type == "no_order") {
    $filters = "";
    $stmt = $emp->sales_order_count($filters);
    $arrays = $emp->sales_order_count_read($stmt);
    $arr_token=[];
    foreach ($arrays as $array) {
        array_push($arr_token,$array->token);
    }
    $stmt1 = $emp->no_orderSales($arr_token);
    $arr1 = $emp->no_order_readSales($stmt1);

    $obj->status_code = 200;
    $obj->header = "Success";
    $obj->message = "Data listed"; 
    $obj->data = $arr1; 
}
   
echo json_encode($obj);   
?>
