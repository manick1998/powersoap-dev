<?php
// required headers
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/database.php';
include_once '../objects/retailer_distributor.php';
include_once '../config/core_distributor.php';
$input_data = json_decode(file_get_contents("php://input"));
if ($input_data->dashboard_code == $verification_code) {
    $database = new Database();
    $db = $database->getConnection();
    $retailer = new Retailer($db);
    $obj = new stdClass;
    if ($input_data->type == "All") {
        $array = $retailer->getDiscount();
        $obj->status_code = 200;
        $obj->header = "Success";
        $obj->message = "Discount List";
        $obj->data = $array;
    } else if ($input_data->type == "addDiscount") {
        $retailer->discount = $input_data->discount . '%';
        $retailer->admin_token = $input_data->admin_token;
        $token = token_generate("discount", "token");
        $retailer->token = $token;
        $stmt = $retailer->discountVerify();
        $count = $stmt->rowCount();
        if ($count > 0) {
            $obj->status_code = 400;
            $obj->header = "Error";
            $obj->message = "Already Discount Added";
        } else {
            $retailer->addDiscount($indiaDateTime);
            $obj->status_code = 200;
            $obj->header = "Success";
            $obj->message = "Added Discount";
        }
    } else if ($input_data->type == "single_division_delete") {
        $retailer->token = $input_data->discount_token;
        $retailer->admin_token = $input_data->admin_token;
        $stmt = $retailer->discountDelete();
        if ($stmt) {
            $obj->status_code = 200;
            $obj->header = "Success";
            $obj->message = "Deleted Discount";
        } else {
            $obj->status_code = 400;
            $obj->header = "Error";
            $obj->message = "Error";
        }
    }
    echo json_encode($obj);
}
