<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/database.php';
include_once '../objects/retailer_distributor.php';
include_once '../config/core_distributor.php';
$input_data = json_decode(file_get_contents("php://input"));
    if($input_data->dashboard_code == $verification_code){
        $database = new Database();
        $db = $database->getConnection();
        $retailer = new Retailer($db);
        $obj = new stdClass;
        if($input_data->type == "All"){
            $array = $retailer->getShopType();
            $obj->status_code = 200;
            $obj->header = "Success";
            $obj->message = "Shop Type List";
            $obj->data = $array;
        }else if($input_data->type == "AddShopType"){
            $retailer->name = $input_data->shop_type;
            $token = token_generate("shop__type","token");
            $retailer->token = $token;
            $stmt=$retailer->shopTypeVerify();
            $count=$stmt->rowCount();
            if($count>0){
                $obj->status_code = 400;
                $obj->header = "Error";
                $obj->message = "Already Given Shop Type";
            }else{
                $retailer->addShopType($indiaDateTime);
              //  $retailer->addShopType_log($indiaDateTime);
                $obj->status_code = 200;
                $obj->header = "Success";
                $obj->message = "Added New Shop Type"; 
            } 
        }else if($input_data->type == "UpdateShopType"){
            $retailer->name = $input_data->shop_type;
            $retailer->token = $input_data->shop_token;
          // $retailer->admin_token = $input_data->admin_token;
            $stmt=$retailer->shopTypeVerify();
            $count=$stmt->rowCount();
            if($count>0){
                $obj->status_code = 400;
                $obj->header = "Error";
                $obj->message = "Already Given Shop Type";
            }else{
                $retailer->updateShopType($indiaDateTime);
               // $retailer->updateShopTypeLog($indiaDateTime);
                $obj->status_code = 200;
                $obj->header = "Success";
                $obj->message = "Updated Shop Type Name"; 
            }
            
        } else {
            $obj->status_code = 400;
            $obj->header = "Oops";
            $obj->message = "Provide the valid details for shop type";
        }
        echo json_encode($obj);
}

?>
