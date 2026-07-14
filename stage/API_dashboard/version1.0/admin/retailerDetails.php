<?php

$obj=new stdClass();
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
date_default_timezone_set('Asia/Kolkata');
$currentDate  = date("Y-m-d H:i:s");
$inputData->dashboard_code = $verification_code;
// echo $inputData->dashboard_code;
// if($inputData->dashboard_code == $verification_code){
    include_once '../objects/retailer.php';
    $retailer = new Retailer($db);
    if($inputData->type == "All"){
        $array = $retailer->getShopType();
        $obj->status_code = 200;
        $obj->header = "Success";
        $obj->message = "Shop Type List";
        $obj->data = $array;
    }
    if($inputData->type == "regionToken"){
        $retailer->regionToken = $inputData->regionToken; 
        $stmt = $retailer->distributorlist();
        $data=$retailer->distributorlistfetch($stmt);
        $obj->status_code = 200;
        $obj->header = "Success";
        $obj->data = $data;
    }
    if($inputData->type=="count"){
        $stateId = $inputData->state_id;
            if($stateId != '0'){
                $stateQuery = " AND `shop`.`state_id` IN ('".$stateId."')";
            }else{
                $stateQuery = " ";
            }
        $retailer->stateQuery = $stateQuery; 
        $stmt=$retailer->retailerDetailCountCheck();
        $obj->code = 201;
        $obj->data = $stmt->rowCount();
    }else if($inputData->type=="count"){
        $stmt=$retailer->retailerDetailCheck();
        $checkCount = $stmt->rowCount();
        if($checkCount==0){
            $obj->code=503;
            $obj->data=[];
        }else{
            $obj->code = 201;
            $obj->data = $retailer->readRetailerDetails($stmt);
        }
    }else if($inputData->type == "single_retailer"){
        $_SESSION["retailer_token"] = $inputData->retailer_token;
        $_SESSION["particular_shop_redirect"] = $inputData->particular_shop_redirect;
            $retailer->token = $inputData->retailer_token;
            $data = $retailer->singleRetailer();
            $obj->code = 201;
            $obj->data = $data;
    }else if($inputData->type == "distributor_count"){
        $retailer->distributor_token = $inputData->distributor_token;
        $stmt=$retailer->distributor_retailerDetailCountCheck();
        $obj->code = 201;
        $obj->data = $stmt->rowCount();
    }else if($inputData->type == "shopStatusChange"){
        $retailer->shop_token = $inputData->shop_token;
        $retailer->reason = $inputData->reason;
        $stmt = $retailer->shopCheckToken(); 
         $checkCount = $stmt->rowCount();
            if($checkCount==1){
                $retailer->shop_show_status = $inputData->shop_show_status;
                if($retailer->shopStatusUpdate()){
                    $retailer->shop_token = $inputData->shop_token;
                    $retailer->shop_name = $inputData->shop_name;
                    $retailer->mobile_number = $inputData->mobile_number;
                    $retailer->licens_number = $inputData->licens_number;
                    $retailer->admin_token = $inputData->admin_token;
                    $retailer->address = $inputData->address;
                    $retailer->city = $inputData->city;
                    $retailer->pincode = $inputData->pincode;
                    $retailer->distributor_token = $inputData->distributor_token;
                    $retailer->shop_mapping_status = $inputData->shop_mapping_status;
                    // $retailer->inactivate_shop_log();
                    $retailer->shopInactiveNewRetailer_log($currentDate);
                    $retailer->shop_show_status = $inputData->shop_show_status;
                    $retailer->shop_mapping_status = $inputData->shop_mapping_status;
                    $retailer->shopMappingStatusUpdate();

                    $obj->status_code = 200;
                    $obj->header = "Success";
                    $obj->message = "shop status updated"; 
                }else{
                    $obj->status_code = 400;
                    $obj->header = "Error";
                    $obj->message = "shop status not updated"; 
                }
            }else{
                 $obj->status_code = 400;
                 $obj->header = "Error";
                 $obj->message = "shop token incorrect"; 
            }
         }else if($inputData->type == "remove"){
            $retailer->distributor_token = $inputData->distributor_token;
            $retailer->shop_token = $inputData->shop_token;
            if ($retailer->remeove_shop()) {
                $obj->status_code = 200;
                    $obj->header = "Success";
                    $obj->message = "shop status updated";
            }else{
                $obj->status_code = 400;
                    $obj->header = "Error";
                    $obj->message = "shop status not updated"; 
            }

         }
    echo json_encode($obj);
    // $db = null;

//}
?>
