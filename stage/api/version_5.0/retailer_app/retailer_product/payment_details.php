<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
$order_token = $input->order_token;
$retailer->order_token = $input->order_token;
$result = $retailer->total_payment_details();
$count = $result->rowCount();

$obj = new stdClass();
if ($count == 0) {
    $obj->status_code = 400;
    $obj->message = 'data  not found';
}
else{
    $result1 = $retailer->payment_details($order_token);
    $count1 = $result1->rowCount();
        $array1 = [];
        $x = 1;
    while ($rows1 = $result1->fetch(PDO::FETCH_ASSOC)) {
        $obj2 = new stdClass();

        $schedule_date12 = $rows1['date_time'];
        $convert_date= date('j,M Y', strtotime($schedule_date12));
        $obj2->schedule_date = $convert_date;
        $obj2->payment_mode = $rows1['payment_mode'];
        $obj2->amount = $rows1['amount'];
        $obj2->num_of_payment = "Payment ".$x;
            array_push($array1,$obj2);
            $x++;
    }

    $array=[];
    while ($rows = $result->fetch(PDO::FETCH_ASSOC)) {
        $obj1 = new stdClass();
        $obj1->billing_amount = $rows['billing_amount'];
        $obj1->paid_amount = $rows['paid_amount'];
        $obj1->total_outstanding = $rows['total_outstanding'];
        $obj1->token = $rows['token'];
        //array_push($array,$obj1);
    }
    $obj->status_code= 200;
    $obj->message = 'success';
    //$obj1  = $array;
    $obj->total_payment_details = $obj1;
    //$obj2 = $array1;
    $obj->payment_details = $array1;
}
echo json_encode($obj);
?>