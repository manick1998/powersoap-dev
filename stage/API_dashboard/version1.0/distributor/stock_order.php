<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/database.php';
include_once '../objects/stock_order.php';
include_once '../config/core_distributor.php';
$input_data = json_decode(file_get_contents("php://input"));
if($input_data->dashboard_code == $verification_code){
$distributor_token = $input_data->distributor_token;  
$database = new Database();
$db = $database->getConnection();
$stockOrder = new StockOrder($db);
$stockOrder->distributor_token = $distributor_token;   
$obj = new stdClass;   
if($input_data->type == "all_stock_order"){
        $stmt = $stockOrder->stockOrderDistributor();
        $num = $stmt->rowCount();
        if ( $num ) {
            $array = $stockOrder->viewstockOrderDistributor($stmt);
            $obj->status_code = 200;
            $obj->header = "Success";
            $obj->message = "Stock Order List";
            $obj->data = $array;
        } else {
            $obj->status_code = 400;
            $obj->header = "Oops";
            $obj->message = "No Stock Order List Found";
        }
}else if($input_data->type == "date_range"){
        $from_date            = $input_data->from_date; 
        $stockOrder->fromDate   = date("Y-m-d 00:00:00", strtotime($from_date));
        $to_date              = $input_data->to_date;
        $stockOrder->toDate     = date("Y-m-d 23:59:59", strtotime($to_date));
        $stmt=$stockOrder->stockOrderDateRange();
        $checkCount = $stmt->rowCount();
        if($checkCount == 0){ 
            $obj->status_code = 400;
            $obj->header = "Oops";
            $obj->message = "No Stock Order List Found"; 
        }else{
            $obj->status_code = 200;
            $obj->header = "Success";
            $obj->message = "Stock Order List";
            $obj->data = $stockOrder->viewstockOrderDistributor($stmt);
        }
}
echo json_encode($obj);
}
?>
