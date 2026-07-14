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
$token                = $schedule->tokenGenerate();
$schedule->token      = $token;
$input = json_decode(file_get_contents("php://input"));


$schedule ->unitName = $input->unitName;
$schedule ->distributor_token = $input->distributor_token;
$beat_tokens = $input->beat_tokens;
$schedule->beat_tokens = $beat_tokens;

//$distributor_token = $input->distributor_token;

// echo "gen",$token;
// echo $schedule ->unitName = $input->unitName;
//echo $beat_tokens;

$check = $schedule->unit_customise($indiaDateTime,$token);
if ($check) {
    //$schedule ->distributor_token = $input->distributor_token;
    $schedule->unit_customise_mapping();  
    //echo "correct"; 
    $obj = new stdClass(); 
    $obj->code=201;
    $obj->message="Success";
}
else{
    $obj = new stdClass();
    $obj->code=401;
    $obj->message="File";
}

//     $schedule ->distributor_token = $input->distributor_token;
//     $distributor_token = $input->distributor_token;
//     $schedule->beat_tokens = $beat_tokens;
//     $beat_tokens = $input->beat_tokens;
//     foreach ($beat_tokens as $beat_token) {
//         $sql = "INSERT INTO `unit_customise_mapping`(`custom_unit_token`, `distributon_token`, `unit_token`)
//         VALUES($token,$distributor_token,$beat_token)";
//         $result = $conn->query($sql);
//         if ($result) {
//            echo "correct";
//         }
//         else{
//             echo "something is worng";
//         }
//     }


// $beat_tokens= $input->beat_tokens;
// $schedule->beat_tokens=$beat_tokens;
// echo $beat_tokens;
//$obj = new stdClass();
//$schedule->unit__custom_unit();
// $obj->code=201;
// $obj->message="Success";
echo json_encode($obj);


?>