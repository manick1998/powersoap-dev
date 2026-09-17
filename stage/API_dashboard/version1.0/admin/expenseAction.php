<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/core.php';

$input_data = json_decode(file_get_contents("php://input"));
$obj = new stdClass();

if (!isset($input_data->token) || !isset($input_data->action)) {
    $obj->status_code = 400;
    $obj->header = "Error";
    $obj->message = "Invalid request";
    echo json_encode($obj);
    exit;
}

$token = mysqli_real_escape_string($link, trim($input_data->token));
$action = strtolower(trim($input_data->action));

if ($action === 'approve') {
    $status = '1';
    $message = 'Expense approved successfully';
} else if ($action === 'reject') {
    $status = '2';
    $message = 'Expense rejected successfully';
} else {
    $obj->status_code = 400;
    $obj->header = "Error";
    $obj->message = "Invalid action";
    echo json_encode($obj);
    exit;
}

$result = mysqli_query($link, "UPDATE `sales_rep__expense__details` SET `status` = '$status' WHERE `token` = '$token'");

if ($result) {
    $obj->status_code = 200;
    $obj->header = "Success";
    $obj->message = $message;
    $obj->data = [];
} else {
    $obj->status_code = 400;
    $obj->header = "Error";
    $obj->message = "Unable to update expense status";
    $obj->data = [];
}

echo json_encode($obj);
?>
