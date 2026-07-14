<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/database.php';
include_once '../objects/orders.php';
include_once '../config/core_distributor.php';
$input_data = json_decode(file_get_contents("php://input"));
if($input_data->dashboard_code == $verification_code){
$distributor_token = $input_data->distributor_token;
$type = $input_data->type;
$database = new Database();
$db = $database->getConnection();
$orderList = new OrderList($db);
$obj = new stdClass;
$orderList->distributor_token = $distributor_token;
    if($type == "count"){
        $orderList->retailer_id = $input_data->retailer_token;
        $stmt = $orderList->outstandingOrderCount();
        $obj = $stmt->rowCount(); 
    }else if($type == "particular_shop_detail"){
        $orderList->shop_token = $input_data->shop_token;
        $data = $orderList->individualOutstandingShop();
        $stmt1 = $orderList->individualOutstandingShopDetail();
         $obj1 = $stmt1->rowCount();
            $data1 = $orderList->readIndividualOutstandingShopDetail($stmt1);
            $obj->status_code = 200;
            $obj->header = "Success";
            $obj->message = "Individual Order List";
            $obj->data = $data;
            $obj->data_item = $data1;

    }
echo json_encode($obj);
}            
?>
