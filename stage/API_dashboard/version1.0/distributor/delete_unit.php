<?php
$obj = new stdClass();
include_once '../config/core_distributor.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();

if ($inputData->dashboard_code == $verification_code) {
    include_once '../objects/schedule_distributor.php';
    $schedule = new Schedule($db);
    $schedule->token = $inputData->unit_token;
    $schedule->distributor_token = $inputData->distributor_token;

    if ($schedule->deleteUnit()) {
        $obj->code = 201;
        $obj->message = "Unit deleted successfully";
    } else {
        $obj->code = 401;
        $obj->message = "Error deleting unit";
    }
    echo json_encode($obj);
}
?>
