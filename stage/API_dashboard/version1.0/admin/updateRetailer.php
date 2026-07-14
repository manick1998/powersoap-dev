<?php

$obj=new stdClass();
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
date_default_timezone_set('Asia/Kolkata');
$currentDate  = date("Y-m-d H:i:s");
//if($inputData->dashboard_code == $verification_code){
    include_once '../objects/retailer.php';
    $retailer = new Retailer($db);
    $retailer->token          = $inputData->shop_token;
    $retailer->shopName       = $inputData->shop_name;
    $retailer->contactPerson  = $inputData->contact_person;
    $retailer->contactNumber  = $inputData->contact_number;
    $retailer->shopType       = $inputData->shop_type;
    $retailer->licenseNumber  = $inputData->license_number;
    $retailer->shopAddress    = $inputData->shop_address;
    $retailer->shopCity       = $inputData->shop_city;
    $retailer->shopPincode    = $inputData->shop_pincode;
    $retailer->shopCoordinates= $inputData->shop_coordinates;
    $retailer->retailerImage  = $inputData->retailer_image;
    $retailer->old_name  = $inputData->old_name;
    $retailer->old_number  = $inputData->old_number;
    $retailer->old_licens  = $inputData->old_licens;
    $retailer->old_address  = $inputData->old_address;
    $retailer->old_city  = $inputData->old_city;
    $retailer->old_pincode  = $inputData->old_pincode;
    
    $insert = $retailer->updateRetailer();
    $retailer->admin_token  = $inputData->admin_token;
    // $retailer->updateRetailername_shopedit_log();
    $retailer->shopEditNewRetailer_log($currentDate);
   
    $obj->code = 201;
    echo json_encode($obj);
//echo "wrong";
?>