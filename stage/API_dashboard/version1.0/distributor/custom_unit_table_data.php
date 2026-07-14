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
include_once '../config/core_distributor.php';

$database = new Database();
$db = $database->getConnection();
$schedule = new Schedule($db);
$input = json_decode(file_get_contents("php://input"));
$obj = new stdClass();
if ($input->type = 'customize_unit_data') {
    $schedule->distributor_token = $input->distributor_token;
    $fun = $schedule->custom_unit_table_data();
    $count = $fun->rowCount();
    if ($count > 0) {
        $stmt = $schedule->custom_unit_table_data_list($fun);
        $obj->code = 201;
        $obj->message = 'success';
        $obj->datas =  $stmt;
    }else{
        $obj->code = 401;
        $obj->message = 'Error';
        $obj->datas = [];
    }
}


// if ($count == 0) {
//     echo "data not valide";
// }
// else{
    
    
// }
// $obj->status_code = 200;
//     $obj->message="success";
//     $obj=$arr;
    echo json_encode($obj);
?>