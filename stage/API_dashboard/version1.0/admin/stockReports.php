<?php
//session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/database.php';
include_once '../objects/inventory.php';
include_once '../config/core.php';
$input_data = json_decode(file_get_contents("php://input"));
if ($input_data->dashboard_code == $verification_code) {
    $database = new Database();
    $db = $database->getConnection();
    $inventory = new Inventory($db);
    $from_date = $input_data->from_date;
    $to_date = $input_data->to_date;
    $dateQuery = "";
    if ($from_date != "" && $to_date != "") {
        $dateQuery = "AND `stock__report`.`date` BETWEEN '" . $from_date . "' AND '" . $to_date . "'";
    } else {
        $dateQuery = "AND `stock__report`.`date` = '$indiaDate'";
    }
    $inventory->dateQuery = $dateQuery;
    $stmt = $inventory->stockReports();
    $count = $stmt->rowCount();
    $obj = new stdClass;
    if ($count > 0) {
        $array = $inventory->readstockReports($stmt);
        $obj->status_code = 200;
        $obj->header = "Success";
        $obj->message = "item List";
        $obj->data = $array;
    } else {
        $obj->status_code = 400;
        $obj->header = "Oops";
        $obj->message = "item List Not Found";
    }
    echo json_encode($obj);
}
