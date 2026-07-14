<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config.php';
include_once '../config/core_distributor.php';

$input_data = json_decode(file_get_contents("php://input"));

if($input_data->dashboard_code == $verification_code){
    
date_default_timezone_set("Asia/Kolkata");   //India time (GMT+5:30)
$create_date = date('Y-m-d h:i:s');

$employee_token = $input_data->distributor_token;
$product_token = $input_data->product_token;
$type = $input_data->type;

$obj = new stdClass;
if($type == "UpdateMfs"){    
$mfs = $input_data->mfs;
if($mfs != '' && $mfs != 0){
    
    $result = mysqli_query($link, "SELECT `product_token`, `pro_cat_token`, `employee_token`, `stock_in_hand`, `monthly_avg`, `mfs` FROM `stock__distributor` WHERE `employee_token`= '$employee_token' AND `product_token`='$product_token'");

        if (mysqli_num_rows($result)==1) {
          $result = "UPDATE `stock__distributor` SET `mfs`='$mfs' WHERE `employee_token`= '$employee_token' AND `product_token`='$product_token'";
            
            if(mysqli_query($link, $result)){
                $obj->status_code = 200;
                $obj->title = "Success";
                $obj->message = "Updated MFS details for product";
            } else {
                $obj->status_code = 200;
                $obj->title = "Error";
                $obj->message = "Not Updated MFS details for product";
            }
        }
        else{
            $obj->status_code = 400;
            $obj->title = "Oops";
            $obj->message = "No Product found for distributor";
            }
}else{
    $obj->status_code = 400;
    $obj->title = "Oops";
    $obj->message = "Provide MFS number";
    }
}else if($type == "UpdateAog"){
    
    $aog = $input_data->aog;
    if($aog != '' && $aog != 0){

        $result = mysqli_query($link, "SELECT `product_token`, `pro_cat_token`, `employee_token`, `stock_in_hand`, `monthly_avg`, `mfs` FROM `stock__distributor` WHERE `employee_token`= '$employee_token' AND `product_token`='$product_token'");

            if (mysqli_num_rows($result)==1) {
              $result = "UPDATE `stock__distributor` SET `aog`='$aog' WHERE `employee_token`= '$employee_token' AND `product_token`='$product_token'";

                if(mysqli_query($link, $result)){
                    $obj->status_code = 200;
                    $obj->title = "Success";
                    $obj->message = "Updated AOG details for product";
                } else {
                    $obj->status_code = 200;
                    $obj->title = "Error";
                    $obj->message = "Not Updated AOG details for product";
                }
            }
            else{
                $obj->status_code = 400;
                $obj->title = "Oops";
                $obj->message = "Product Token is available more than one";
                }
    }else{
        $obj->status_code = 400;
        $obj->title = "Oops";
        $obj->message = "Provide AOG number";
        }
    
    
}else{
    $obj->status_code = 400;
    $obj->title = "Oops";
    $obj->message = "Type is not Matching MFS AOG";
}
echo json_encode($obj);
    
}
?>