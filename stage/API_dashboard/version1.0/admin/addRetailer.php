<?php

$obj=new stdClass();
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
if($inputData->dashboard_code == $verification_code){
    include_once '../objects/retailer.php';
    $retailer = new Retailer($db);
    $token                    = $retailer->tokenGenerate();
    $retailer->token          = $token;
    $retailCode               = $retailer->codeGenerate();
    $retailer->retailCode     = $retailCode;
    $retailer->shopName       = $inputData->shop_name;
    $retailer->contactPerson  = $inputData->contact_person;
    $retailer->contactNumber  = $inputData->contact_number;
    $retailer->shopType       = $inputData->shop_type;
    $retailer->licenseNumber  = $inputData->license_number;
    $retailer->shopAddress    = $inputData->shop_address;
    $retailer->shopCity       = $inputData->shop_city;
    $retailer->shopPincode    = $inputData->shop_pincode;
    $retailer->shopCoordinates= $inputData->shop_coordinates;
    $retailer->distributor_token= $inputData->$distributor_token;
    $retailer->retailerImage  = $inputData->retailer_image;
    $insert = $retailer->addRetailer($indiaDateTime);
    $obj->code = 201;
    echo json_encode($obj);
    $db = null;
}
?>