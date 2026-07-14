<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/database.php';
include_once '../objects/employee.php';

$database = new Database();
$db = $database->getConnection();

$emp = new Employee($db);

$data = json_decode(file_get_contents("php://input"));

$emp->distributor_token = $data->distributor_token;

$fun = $emp->admin_view_stock();

$num =$fun->rowCount();

//cho $num;

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
        $obj->token = $rows['product_token'];
        $obj->item_name = $rows['product_name'];
        $obj->division = $rows['product_category'];
        $pice = $rows['piece_count'];
        $obj->total_stock = $rows['stock_in_hand'];
        $sold_pieces = $rows['sold_pieces'];
        $obj->mfs = $rows['mfs'];
        
        //$obj->total_stock = $stock * $pice - $sold_pieces;


        array_push($arr,$obj);
    }
    $obj->status=true;
    $obj->message="success";
    $obj->code=200;
    $obj=$arr;
}
echo json_encode($obj);
$db = null;

?>