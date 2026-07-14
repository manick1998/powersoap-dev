<?php
$obj = new stdClass;
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include "../../../config.php";
include '../db_connection/db_conn.php';
include '../retailer_object/retailer_login.php';
$database = new Database();
$db = $database->getConnection();
$retailer =new retailer($db);
$input = json_decode(file_get_contents("php://input"));
$order_token = $input->order_id;
$retailer->order_token = $order_token;

$query = mysqli_query($link,"SELECT date(`date_time`)AS `date` FROM `orders` WHERE `token`='$order_token'");
$row = mysqli_fetch_array($query);
$date = $row['date'];
if($date==$indiaDate){
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
else {
    $obj->status_code=400; 
    $obj->message='Product not found';
    $obj->title='Success';
    
}
}else{
    $obj->status_code=400; 
    $obj->message='Within one day';
    $obj->title='Success';
 }
echo json_encode($obj);
?>