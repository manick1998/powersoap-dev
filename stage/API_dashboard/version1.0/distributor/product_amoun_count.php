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

$data = json_decode(file_get_contents("php://input"));

$emp->distributor_token = $data->distributor_token;
$emp->products_token = $data->products_token;

$fun = $emp->product_amoun_count();

$num =$fun->rowCount();

//echo $num;

$obj = new stdClass();

if ($num == 0) {
    // $obj->status_code = 400;
    // $obj->message ="data not found";
        echo "data not found";
}
else{
    $arr= [];
    while($rows = $fun->fetch(PDO::FETCH_ASSOC)) {
        $obj = new stdClass();
        $obj->item_name = $rows['name'];
        $obj->totel = $rows['totel'];
        // $piece_count = $rows['piece_count'];
        // $stock_in_hand = $rows['stock_in_hand'];
        // $totel_piece_count =$piece_count*$stock_in_hand;

        // $obj->totel_piece_count = $totel_piece_count;


        array_push($arr,$obj);
    }
    $obj->status=true;
    $obj->message="success";
    $obj->code=200;
    $obj=$arr;
}
echo json_encode($obj);

?>

