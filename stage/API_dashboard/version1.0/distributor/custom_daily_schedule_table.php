<?php
$obj=new stdClass();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/database.php';
include_once '../objects/schedule_distributor.php';
include_once '../config/core_distributor.php';

$database = new Database();
$db = $database->getConnection();
$schedule = new Schedule($db);
$input = json_decode(file_get_contents("php://input"));
$schedule->distributor_token = $input->distributor_token;
$call_func = $schedule->custom_daily_schedule_table();
$count = $call_func->rowCount();
if($count == 0){
    $obj->code=503;
    $obj->data=[];
}else{
    $obj->code = 201;
    $obj->data = $schedule->custom_read_unit($call_func,$indiaDate);
}
echo json_encode($obj);
?>