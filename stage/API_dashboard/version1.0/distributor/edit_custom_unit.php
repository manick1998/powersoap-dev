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
include_once '../objects/schedule_distributor.php';
//include_once '../config/core_distributor.php';

$database = new Database();
$db = $database->getConnection();
$schedule = new Schedule($db);
$data = json_decode(file_get_contents("php://input"));
$obj = new stdClass();
if ($data->type = 'edit_custom_unit') {
    $schedule->custom_token = $data->custom_token;
    $fun = $schedule->edit_custom_unit();
    $count = $fun->rowCount();
    if ($count > 0 ) {
       $stmt = $schedule->edit_custom_unit_data($fun);
        $obj->status_code = 200;
         $obj->message="success";
         $obj->datas = $stmt;

    }
}
echo json_encode($obj);
?>