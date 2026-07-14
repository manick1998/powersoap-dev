<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$obj=new stdClass();
include_once '../config/core_distributor.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
if($inputData->dashboard_code == $verification_code){
    include_once '../objects/retailer_distributor.php';
    $retailer = new Retailer($db);
    $retailer->mobile_number  = $inputData->contact_number;
    $retailer->license_number  = $inputData->license_number;
    $retailer->token          = $inputData->shop_token;
    $stmt=$retailer->checkRetailerMobileNumberAlreadyExist();
    $countmobile = $stmt->rowCount();  
    $stmt1=$retailer->checkRetailerLicenseNumberAlreadyExist();
    $countLicense = $stmt1->rowCount();
    // if($countmobile == 0 && $countLicense == 0){
        $retailer->shopName       = $inputData->shop_name;
        $retailer->contactPerson  = $inputData->contact_person;
        $retailer->shopType       = $inputData->shop_type;
        $retailer->shopAddress    = $inputData->shop_address;
        $retailer->shopCity       = $inputData->shop_city;
        $retailer->shopPincode    = $inputData->shop_pincode;
        $retailer->shopCoordinates= $inputData->shop_coordinates;
        $retailer->retailerImage  = $inputData->retailer_image;
        // $retailer->distributor_token  = $inputData->distributor_token;
        $insert = $retailer->updateRetailer();
        if ($insert) {
            $obj->status_code = 200;
            $obj->header = "Success";
            $obj->message = "Sucessfully Updated";
        }else{
            $obj->status_code = 400;
            $obj->header = "Error";
            $obj->message = "something went to wrong";
        }
        
    // }else{
    //     if($countmobile!=0){
    //         $obj->status_code = 400;
    //         $obj->header = "Oops";
    //         $obj->message="Mobile Number already exist!";
       // }
        // else if($countLicense!=0){
        //     $obj->status_code = 400;
        //     $obj->header = "Oops";
        //     $obj->message="License number already exist!";
        // }
    //}
    echo json_encode($obj);
}
?>