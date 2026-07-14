<?php
//session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/database.php';
include_once '../objects/stock_order.php';
include_once '../objects/inventory.php';
include_once '../config/core_distributor.php';
$input_data = json_decode(file_get_contents("php://input"));
    if($input_data->dashboard_code == $verification_code){      
        $distributor_token = $input_data->distributor_token;
        $database = new Database();
        $db = $database->getConnection();
        $stockOrder = new StockOrder($db);
        $inventory = new Inventory($db);
        $stockOrder->distributor_token = $distributor_token;
        $stmt = $stockOrder->getDistributorStock();
        $num = $stmt->rowCount();
        $obj = new stdClass;
            if ( $num ) {
                $array = $stockOrder->viewGetDistributorStock($stmt);
                $getStmt = $inventory->getStatus();
                $data = $inventory->viewStatus($getStmt);
                $obj->status_code = 200;
                $obj->header = "Success";
                $obj->message = "Stock In Hand List";
                $obj->data = $array;
                $obj->data1 = $data;
            } else {
                $obj->status_code = 400;
                $obj->header = "Oops";
                $obj->message = "No Stock In Hand List Found";
            }
        echo json_encode($obj);   
    }
?>
