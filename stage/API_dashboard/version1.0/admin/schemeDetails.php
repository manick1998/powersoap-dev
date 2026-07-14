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
    if($input_data->dashboard_code == $verification_code){      
        $database = new Database();
        $db = $database->getConnection();
        $inventory = new Inventory($db);
        $stmt = $inventory->schemeList();
        $num = $stmt->rowCount();
        $obj = new stdClass;
            if ( $num > 0 ) {
                $array = $inventory->readschemeList($stmt);
                $obj->status_code = 200;
                $obj->header = "Success";
                $obj->message = "Scheme List";
                $obj->data = $array;
            } else {
                $obj->status_code = 400;
                $obj->header = "Oops";
                $obj->message = "scheme List Not Found";
            }
        echo json_encode($obj);   
    }
?>
