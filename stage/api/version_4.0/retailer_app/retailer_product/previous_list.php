<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
$obj = new stdClass;
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
$shop_token = $input->ShopToken;
$retailer->shop_token = $shop_token;
$result=$retailer -> orderval();
$count = $result->rowCount();

if($count>0) {
$get_token  = $result->fetch(PDO::FETCH_ASSOC);
$order_token = $get_token['token'];
$retailer->order_token =$order_token;
$previousorder =$retailer->previousOrderList();
$array = [];
while($row = $previousorder->fetch(PDO::FETCH_ASSOC)) {
    $order_details = new stdClass;
    $order_details->product_token = $row['product_token'];
    $order_details->product_name = $row['product_name'];
    $order_details->quantity = $row['quantity'];
    $order_details->units = $row['units'];
    $order_details->amount = $row['amount'];
    $order_details->piece_count = $row['piece_count'];
    array_push($array,$order_details);
        
}               
$total=$retailer ->orderTotal();
while($row = $total->fetch(PDO::FETCH_ASSOC)) {
    $amt_obj = new stdClass;
       $amt_obj->order_token = $row['order_token'];
       $amt_obj->total_amount = round($row['total_amount']);
       $amt_obj->quantity = $row['quantity'];
 }               
$order_val = new stdClass;
$order_val->order_details = $array;
$order_val->order_val = $amt_obj;
$check_data = $previousorder->rowCount();                

if($check_data > 0){
    $obj->status_code=200; 
    $obj->message='Product found';
    $obj->title='Success';
    $obj->previous_order = $order_val;
    
} 
}else {
    $obj->status_code=400; 
    $obj->message='Product not found';
    $obj->title='Success';
    
}
echo json_encode($obj);
?>