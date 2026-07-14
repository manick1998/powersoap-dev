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
$indiaDate     = date("Y-m-d");
$input_data = json_decode(file_get_contents("php://input"));
    if($input_data->dashboard_code == $verification_code){      
        $database = new Database();
        $db = $database->getConnection();
        $inventory = new Inventory($db);
        $from_date=$input_data->from_date;
        $to_date = $input_data->to_date;
        $divisionToken = $input_data->division_token;
        $divisionQuery = " ";
        if($divisionToken != ''){
            $divisionQuery = " AND  products.category_token IN ('".$divisionToken."')";
        }
        $dateQuery = "";
            if($from_date!="" && $to_date!=""){
                $dateQuery = "AND date(`orders__items`.`date_time`) BETWEEN '".$from_date."' AND '".$to_date."'";
            }else{
                $dateQuery = "AND date(`orders__items`.`date_time`) = '$indiaDate'";
            }  
        $inventory->dateQuery=$dateQuery; 
        $inventory->divisionQuery=$divisionQuery; 
        $stmt = $inventory->itemoverallReport();
        $num = $stmt->rowCount();
        $obj = new stdClass;
            if ( $num > 0 ) {
                $array = $inventory->readitemoverallReport($stmt);
                $total = $inventory->totalsales();
                $division_data = $inventory->partculoar_division_product($divisionToken);
                $stmt1 = $inventory->partculoar_division_product_read($division_data);
                $obj->status_code = 200;
                $obj->header = "Success";
                $obj->message = "item List";
                $obj->data = $array;
                $obj->total = $total;
                $obj->products = $stmt1;
            } else {
                $obj->status_code = 400;
                $obj->header = "Oops";
                $obj->message = "item List Not Found";
            }
        echo json_encode($obj);   
    }
?>
