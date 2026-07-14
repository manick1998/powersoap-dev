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
if ($input_data->dashboard_code == $verification_code) {
    $database = new Database();
    $db = $database->getConnection();
    $stockOrder = new StockOrder($db);
    $stockOrder->distributor_token = $input_data->distributor_token;
    $stockOrder->token = $input_data->token;
    $stmt = $stockOrder->takeOrderDistributor();
    $num = $stmt->rowCount();
    $obj = new stdClass;
    if ($num) {
        $array = $stockOrder->viewtakeOrderDistributor($stmt);
        $obj->status_code = 200;
        $obj->header = "Success";
        $obj->message = "Product List";
        $obj->data = $array;
    } else {
        $obj->status_code = 400;
        $obj->header = "Oops";
        $obj->message = "No Product List Found";
    }
    echo json_encode($obj);
}
