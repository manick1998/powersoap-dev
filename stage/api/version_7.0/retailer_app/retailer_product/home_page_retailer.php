<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include '../db_connection/db_conn.php';
include '../retailer_object/retailer_home_page.php';
$database = new Database();
$db = $database->getConnection();
$retailer_home_page =new home_page($db);
$input = json_decode(file_get_contents("php://input"));

$retailer_home_page->phone_number = $input->phone_number;
$result = $retailer_home_page->retailer_order_home_page();
$count = $result->rowCount();
$obj = new stdClass();
if ($count == 0) {
    $obj->status_code=400; 
    $obj->message='data not found';
}
else{
    
    $array=[];
    while ($rows = $result->fetch(PDO::FETCH_ASSOC)){
        $obj1 = new stdClass();
        $obj1->distributor_token = $rows['distributor_token'];
        $obj1->distributor_name = $rows['distributor_name'];
        $obj1->distributor_ph_number = $rows['distributor_ph_number'];
        $obj1->shop_token = $rows['shop_token'];
        $obj1->shop_name = $rows['shop_name'];
        $obj1->phone_number = $rows['phone_number'];
        $obj1->billing_amount = $rows['billing_amount'];
        $obj1->paid_amt = $rows['paid_amt'];
        $obj1->total_outstanding = $rows['total_outstanding'];
        $obj1->address = $rows['address']. $rows['city'].','.$rows['pincode'];
        array_push($array,$obj1);
    }

    
    $obj->status_code=200; 
    $obj->message='Success';
    $obj1= $array;
    $obj->data = $obj1;
   
    
}
echo json_encode($obj);
?>