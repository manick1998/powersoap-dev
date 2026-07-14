<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/database.php';
include_once '../objects/stock_order.php';

$database = new Database();
$db = $database->getConnection();

$emp = new StockOrder($db);

$input = json_decode(file_get_contents("php://input"));

$emp-> stock_count = $input->stock_count;
$emp-> distributor_token = $input-> distributor_token;
$emp-> product_token = $input-> product_token;

$fun = $emp->update_pre_stock();
// $done = $fun->rowsCount();

if (!$fun) {
    echo "somethig wrong";
}
else {
    $arr= [];
    $obj = new stdClass();
    $obj->status=true;
    $obj->message="success";
    $obj->status_code=200;
    array_push($arr,$obj);
    $obj=$arr;
}
echo json_encode($obj);


?>