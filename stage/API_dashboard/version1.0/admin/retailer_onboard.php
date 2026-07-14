<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/database.php';
include_once '../config/core.php';
include_once '../objects/retailer.php';
$data = json_decode(file_get_contents("php://input"));
$database = new Database();
$db = $database->getConnection();
$retailer = new Retailer($db);
//$emp = new Employee($db);
date_default_timezone_set('Asia/Kolkata');
$indiaDateTime = date("Y-m-d H:i:s");
$obj = new stdClass;
if ($data->type == "onboard_details") {
    $func = $retailer->onboard_retailer_details();
    $count = $func->rowCount();
    if ($count == 0) {
       $obj->status_code = '400';
       $obj->message = 'erroe';
       $obj->data = [];
    }else {
        $table_func = $retailer->onboard_retailer_details_list($func);
        $obj->status_code = '200';
        $obj->message = 'success';
        $obj->data = $table_func;
    }
}elseif ($data->type == "division") {
    $retailer->shop_token = $data->shop_token;
    $stmt = $retailer->retailer_divi_details();
    $stmt1 = $retailer->retailer_divi_address();
    $count = $stmt->rowCount();
    if ($count == 0) {
       $obj->status_code = '400';
       $obj->message = 'erroe';
       $obj->division_data = [];
       $obj->retailer_address = [];
    }else {
        $divi_func = $retailer->retailer_divi_details_list($stmt);
        $divi_func1 = $retailer->retailer_divi_address_list($stmt1);
        $obj->status_code = '200';
        $obj->message = 'success';
        $obj->division_data = $divi_func;
        $obj->retailer_address= $divi_func1;
    }
}elseif ($data->type == "request_updated") {
    $retailer->distributor_token = $data->distributor_token;
    $retailer->shop_token = $data->shop_token;
    $stmt3 = $retailer->mapping_data_checking();
    $count =  $stmt3->rowCount();
    if ($count == 0) {
        // echo 'correct';
            $shop_token =  $data->shop_token;
            $retailer->shop_token = $shop_token;
        $stmt2 = $retailer->request_updated($indiaDateTime);
        $arr_token = [];
         $result = mysqli_query($link,"SELECT shop_mapping.token FROM `shop_mapping` INNER JOIN shop ON shop.token = shop_mapping.shop_token WHERE shop_mapping.`shop_token`='$shop_token'");
         while($row = mysqli_fetch_assoc($result)){
            $token = $row['token'];
            array_push($arr_token,$token);
         }
        if($stmt2){
            $obj->status_code = 200;
            $obj->message = "Success";
            $retailer->mapping_outstanding($arr_token,$indiaDateTime);
        }else{
            $obj->status_code = 400;
            $obj->message = "oops";
        }
    }else{
       $check_datas =  $retailer->mapping_data_checking_read($stmt3);
       $obj->status_code = 400;
       $obj->message = "Distributor Already Mapping";
       $obj->check_datas = $check_datas;
    }
   
}
echo json_encode($obj);
?>