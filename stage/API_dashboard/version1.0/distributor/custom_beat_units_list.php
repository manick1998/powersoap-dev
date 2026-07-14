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
$obj = new stdClass();
if($input->type = 'unit_list'){
    $schedule->distributor_token = $input->distributor_token;
    $schedule->custom_beat_token = $input->custom_beat_token;
    $stmt1 = $schedule->custom_beat_units_list();
    $num = $stmt1->rowCount();
    if ($num > 0) {
        $datas = $schedule->custom_beat_units_list_data($stmt1);
        $obj->code=200;
        $obj->message="success";
        $obj->unit_data = $datas;
    }else{
        $obj->code=400;
        $obj->message="Errpr";
    }
}
echo json_encode($obj);
?>