<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include '../db_connection/db_conn.php';
include '../retailer_object/retailer_login.php';
$database = new Database();
$db = $database->getConnection();
$retailer =new retailer($db);
$input = json_decode(file_get_contents("php://input"));
$retailer->phone_number = $input->phone_number;
$retailer->distributor_token = $input->distributor_token;
$result = $retailer->distributor_orders_details();
$count = $result->rowCount();
$obj = new stdClass(); 
if ($count == 0) {
    $obj->status_code =400;
    $obj->message = 'data not found';
}
else {
    
    $array=[];
    while($rows = $result->fetch(PDO::FETCH_ASSOC)){
        $obj1 = new stdClass();
        $obj1->distributor_token = $rows['distributor_token'];
        $obj1->distributor_name = $rows['distributor_name'];
        $obj1->distributor_ph_number = $rows['distributor_ph_number'];
        $obj1->shop_token = $rows['shop_token'];
        $obj1->shop_name = $rows['shop_name'];
        $obj1->shop_mobile_number=$rows['mobile_number'];
        $obj1->items = $rows['items'];
        $obj1->orders_id = $rows['orders_id'];
        $obj1->bill_amt_val = $rows['bill_amt_val'];
        $obj1->paid_amt_val = $rows['paid_amt_val'];
        $obj1->outstanding_amount = $rows['outstanding_amount'];
        $obj1->delivery = $rows['delivery'];
        $obj1->address = $rows['address'];
        $obj1->schedule_date = $rows['schedule_date'];
        array_push($array,$obj1);
    }
    $obj->status_code = 200;
    $obj->message='success';
    $obj1 = $array;
    $obj->shopOrderHistoryData = $obj1;
    
}
echo json_encode($obj);

?>