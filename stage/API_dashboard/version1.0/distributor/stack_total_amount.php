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
include_once '../objects/inventory.php';

$database = new Database();
$db = $database->getConnection();

$emp = new Inventory($db);
$input_data = json_decode(file_get_contents('php://input'));

$emp->distributor_token = $input_data->distributor_token;

$fun = $emp->stack_total_amount();
$count = $fun->rowCount();

if ($count == 0) {
    echo "data not found";
}
else {
    $arr=[];
    while ($rows = $fun->fetch(PDO::FETCH_ASSOC)) {
        $obj = new stdClass();
        $obj->total = $rows['total'];
        array_push($arr,$obj);
    }
    $obj->status=true;
    $obj->message="success";
    $obj->code=200;
    $obj=$arr;
}
echo json_encode($obj);




?>