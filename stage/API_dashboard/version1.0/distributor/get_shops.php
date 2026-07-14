<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/database.php';
include_once '../objects/schedule_distributor.php';
//include_once '../config/core_distributor.php';

$database = new Database();
$db = $database->getConnection();
$schedule = new Schedule($db);
$input = json_decode(file_get_contents("php://input"));
$schedule->distributor_token = $input->distributor_token;
$schedule->unit_token = $input->unit_token;
$func_call = $schedule->get_shops();
$check_count = $func_call->rowCount();
if (!$check_count) {
    echo "data not found";
}
else{
    $arr=[];
    while($rows = $func_call->fetch(PDO::FETCH_ASSOC)){
        $obj = new stdClass();
        $obj->beat_tokens = $rows['token'];
        $obj->shop_names = $rows['name'];
        $obj->shop_add = $rows['address'];
        array_push($arr,$obj);
    }
    $obj->code =200;
    $obj->message ="success";
    $obj=$arr;
}
echo json_encode($obj);
?>