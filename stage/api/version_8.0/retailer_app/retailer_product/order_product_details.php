<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

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
$retailer->order_token = $input->order_token;
$result = $retailer->order_product_details();
$count = $result->rowCount();
$obj = new stdClass();
//$new_obj = new stdClass();
if ($count == 0) {
    $obj->status_code = 400;
    $obj->message = 'data  not found';
}
else{
     
    $array=[];
    while ($rows = $result->fetch(PDO::FETCH_ASSOC)) {
        

        $obj1 = new stdClass();
        $obj2 = new stdClass();

        $obj2->shop_name = $rows['name'];
        $obj2->order_token = $rows['token'];

        $obj1->product_token = $rows['product_token'];
        $obj1->quantity = $rows['quantity'];
        $obj1->units = $rows['units'];
        $obj1->gst = $rows['gst'];
        $obj1->price_per_unit = $rows['price_per_unit'];
        $obj1->is_discount_enable = $rows['is_discount_enable'];
        $obj1->discount_value = $rows['discount_value'];
        $obj1->is_free = $rows['is_free'];
        $obj1->product_name = $rows['product_name'];
        $obj1->amount = $rows['amount'];
        $obj1->qty = $rows['qty'];

       
        
        $schedule_date12 = $rows['schedule_date'];
        $convert_date= date('j,M Y', strtotime($schedule_date12));
        $obj2->schedule_date = $convert_date;
        $obj2->delivery_status = $rows['delivery'];
        $obj2->employee_name = $rows['employee_name'];
        $obj2->delivered_on = $rows['delivered_on'];
        $obj2->order_itme = $rows['items'];
        $obj2->bill_amt_val = $rows['bill_amt_val'];
        $obj2->paid_amt_val = $rows['paid_amt_val'];
        $obj2->outstanding_amount = $rows['outstanding_amount'];
        array_push($array,$obj1); 
        
    }
        $obj->status_code= 200;
        $obj->message = 'success';
        $obj->comman_value = $obj2;
        $obj1  = $array;

        $obj->shopOrderDetailsData = $array;
       
}
echo json_encode($obj);
?>