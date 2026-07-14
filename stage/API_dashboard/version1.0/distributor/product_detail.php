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

$product_token = $input_data->product_token;

$database = new Database();
$db = $database->getConnection();

$stockOrder = new StockOrder($db);
$stockOrder->product_token = $product_token;

$stmt = $stockOrder->productDetail();
$num = $stmt->rowCount();

$obj = new stdClass;
if ( $num ) {
 
    $array = $stockOrder->viewProductDetail($stmt);
    
    $obj->status_code = 200;
    $obj->header = "Success";
    $obj->message = "Product Detail Page";
    $obj->data = $array;
} else {
    $obj->status_code = 400;
    $obj->header = "Oops";
    $obj->message = "No Product Detail";
}
echo json_encode($obj);
}
?>
