<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
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
    $obj = new StdClass();
    $retailer = new Retailer($db);
    $retailer->mobile_number = $input_data->contact_number; 
     $mobile = $input_data->contact_number; 
    $retailer->license_number = $input_data->license_number;    
   $stmt=$retailer->checkRetailerMobileNumber();
   $countmobile = $stmt->rowCount();  
   $stmt1=$retailer->checkRetailerLicenseNumber();
   $countLicense = $stmt1->rowCount();   

//========distributor check in shop
$retailer->distributor_token = $input_data->distributor_token;
    $check_shop = $retailer->checkshop_distributor();
        $check_shop_count = $check_shop->rowCount();
        if ($check_shop_count == 0) {
           
        


                if($countmobile==0 && $countLicense==0){  
                    $retailer->distributor_token = $input_data->distributor_token;
                    // $stmt = $retailer->isMobileNoExistUnderDistributor();
                    // $countmobile = $stmt->rowCount();
                    if($countmobile == 0){
                        $shop_token = token_generate("shop","token");
                        $retail_code = token_generate("shop","retail_code");
                        $retailer->token = $shop_token;
                        $retailer->retail_code = $retail_code;
                        $retailer->name = $input_data->shop_name;
                        $retailer->contact_person = $input_data->contact_person;
                        $retailer->shop_type_code = $input_data->shop_type;
                        $retailer->address = $input_data->shop_address;
                        $retailer->city = $input_data->shop_city;
                        $retailer->pincode = $input_data->shop_pincode;
                        $retailer->coordinates = $input_data->shop_coordinates;
                        $retailer->license_image = $input_data->retailer_image;
                        $retailer->state_token = $input_data->state_token;
                        // $retailer->slot_type = $input_data->slot_type;
                        if ($retailer->addNewRetailer($indiaDateTime)) {
                            $rondam1 = token_generate("shop_mapping","token");
                            if($retailer->addNewRetailerOutstanding($rondam1,$indiaDateTime)){
                                // $rondam1 = token_generate("shop_mapping","token");
                                $retailer->add_shop_mapping($rondam1,$shop_token,$indiaDateTime);
                                $obj->status_code = 200;
                                $obj->header = "Success";
                                $obj->message = "New Retailer Shop Page";
                            }else{
                                $obj->status_code = 400;
                                $obj->header = "Oops";
                                $obj->message = "No Retailer List Added in Shop List"; 
                            }
                        } else {
                            $obj->status_code = 400;
                            $obj->header = "Oops";
                            $obj->message = "No Retailer List Added";
                        }
                    }
                }else{
                    if ($countLicense == 0) {
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
                    }else{
                        $obj->status_code = 400;
                        $obj->header = "Oops";
                        $obj->message="License number already exist!";
                    }
                    



                    //     if($countmobile!=0){
                    //         $obj->status_code = 400;
                    //         $obj->header = "Oops";
                    //         $obj->message="Mobile Number already exist!";
                    //     }
                    //    else if($countLicense!=0){
                    //         $obj->status_code = 400;
                    //         $obj->header = "Oops";
                    //         $obj->message="License number already exist!";
                    //     }
                }
        }else{
            $obj->status_code = 400;
            $obj->header = "Oops";
            $obj->message="This shop already exist to Distributor";
        }
    echo json_encode($obj);
}
?>
