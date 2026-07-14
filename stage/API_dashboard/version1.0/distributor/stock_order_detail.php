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
    $order_token = $input_data->order_token;
    $database = new Database();
    $db = $database->getConnection();
    $stockOrder = new StockOrder($db);
    $stockOrder->order_token = $order_token;
    $stmt = $stockOrder->stockOrderProductList();
    $num = $stmt->rowCount();
    $obj = new stdClass;
        if ( $num ) {
            $data = $stockOrder->viewStockOrderProductList($stmt);  
            $obj->status_code = 200;
            $obj->header = "Success";
            $obj->message = "Individual order Shop List";
            $obj->data = $data;
        } else {
            $obj->status_code = 400;
            $obj->header = "Oops";
            $obj->message = "No Individual order Shop List";
        }
    echo json_encode($obj);    
}
?>
