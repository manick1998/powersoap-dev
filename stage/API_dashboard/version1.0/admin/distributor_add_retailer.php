<?php

$obj=new stdClass();
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
include_once '../objects/retailer.php';
$retailer = new Retailer($db);

$distributorToken = $inputData->distributor_token;
$state_id=mysqli_query($link,"SELECT state_id from employees WHERE token='$distributorToken'");
$row22=mysqli_fetch_assoc($state_id);
$state=$row22['state_id'];
     $retailer->mobile_number = $inputData->contact_number; 
     $mobile = $inputData->contact_number; 
     $retailer->license_number = $inputData->license_number;
    $stmt=$retailer->checkRetailerMobileNumber();
    $countmobile = $stmt->rowCount();
   
    $stmt1=$retailer->checkRetailerLicenseNumber();
    $countLicense = $stmt1->rowCount(); 

    //========distributor check in shop
    $retailer->distributorToken = $inputData->distributor_token;
    $check_shop = $retailer->checkshop_distributor();
    $check_shop_count = $check_shop->rowCount();
        if ($check_shop_count == 0) {

                    if($countmobile==0 && $countLicense==0){      
                        $shop_token = token_generate("shop","token");
                        $retail_code = token_generate("shop","retail_code");
                        
                        $retailer->token = $shop_token;
                        $retailer->retail_code = $retail_code;
                        $retailer->name = $inputData->shop_name;
                        $retailer->contact_person = $inputData->contact_person;
                        $retailer->shop_type_code = $inputData->shop_type;
                        $retailer->license_image = $inputData->retailer_image;
                        $retailer->address = $inputData->shop_address;
                        $retailer->city = $inputData->shop_city;
                        $retailer->pincode = $inputData->shop_pincode;
                        $retailer->coordinates = $inputData->shop_coordinates;
                        
                        if ($retailer->addNewRetailer($indiaDateTime,$state)) {
                            $retailer->admin_token = $inputData->admin_token;
                            $retailer->shopaddNewRetailer_log($indiaDateTime);
                            $retailer->distributorToken = $inputData->distributor_token;
                            $rondam1 = token_generate("shop_mapping","token");
                             $retailer->add_shop_mapping($rondam1,$shop_token,$indiaDateTime);
                            $obj->status_code = 200;
                            $obj->header = "Success";
                            $obj->message = "Data inserted";
                            if($retailer->addNewRetailerOutstanding($rondam1,$indiaDateTime)){
                                $obj->status_code = 200;
                                $obj->header = "Success";
                                $obj->message = "Shop Added Sucessfully";
                            }else{
                                $obj->status_code = 400;
                                $obj->header = "Oops";
                                $obj->message = "No Retailer List Added in Shop List"; 
                            }
                        } 
                        else {
                            $obj->status_code = 400;
                            $obj->header = "Oops";
                            $obj->message = "No Retailer List Added";
                        }
                    }
                    else{

                        $query = mysqli_query($link,"SELECT `token` FROM `shop` WHERE `mobile_number` = $mobile");
                        $row = mysqli_fetch_array($query);
                         $shops_token = $row['token'];
                         $random_token = token_generate("shop_mapping","token");
                         $shop_mapping = $retailer->shopmapping_add_distributor($random_token,$shops_token,$indiaDateTime);
                            if ($shop_mapping) {
                                $obj->status_code = 200;
                                $obj->header = "Success";
                                $obj->message = "Shop Mapping Add successfully";
                            }else{
                                $obj->status_code = 400;
                                $obj->header = "Error";
                                $obj->message = "Shop Mapping Not Add successfully";
                            }
                        
                            // if($countmobile!=0){
                            //     $obj->status_code = 400;
                            //     $obj->header = "Oops";
                            //     $obj->message="Mobile Number already exist!";
                            // }else if($countLicense!=0){
                            //     $obj->status_code = 400;
                            //     $obj->header = "Oops";
                            //     $obj->message="License number already exist!";
                            // }
                    }
        }else{
            $obj->status_code = 400;
            $obj->header = "Oops";
            $obj->message="This shop already exist to Distributor";
        }
    echo json_encode($obj);
    $db = null;

?>