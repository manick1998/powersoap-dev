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
        $database = new Database();
        $db = $database->getConnection();
        $inventory = new Inventory($db);
        $from_date=$input_data->fromDate;
        $to_date = $input_data->toDate;
        $state = $input_data->state_token;
        $region_token = $input_data->region_token;
        $distributor_token = $input_data->distributor_token;
        $dataQuery = "";
        if($state!='' && $region_token!='' && $distributor_token!=''){
            $dataQuery="AND `distributor`.`state_id`='".$state."' AND `distributor`.`region_id`='".$region_token."'  AND `distributor`.`token`='".$distributor_token."' ";
        }
        $dateQuery = "";
            if($from_date!="" && $to_date!=""){
                $dateQuery = "AND date(`orders__items`.`date_time`) BETWEEN '".$from_date."' AND '".$to_date."'";
            }
        $inventory->dateQuery=$dateQuery; 
        $inventory->dataQuery=$dataQuery;
        $stmt = $inventory->distributor_salesStock();
        $num = $stmt->rowCount();
        $obj = new stdClass;
            if ( $num > 0 ) {
                $array = $inventory->readdistributor_salesStock($stmt);
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
?>
