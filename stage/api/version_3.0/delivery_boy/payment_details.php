<?php
include "../../config.php";
$json_input = getInputs();
$employee_id = $json_input->employee_id;
$shop_id = $json_input->shop_id;
$order_id = $json_input->order_id;
$array = array();
$total = new stdClass;

$payment = mysqli_query($link,"SELECT `billing_amount`,`paid_amount`,bill_discount_amount,bill_discount_percentage,delivery FROM `orders` WHERE `token` = $order_id");
$getPaymentData = mysqli_fetch_array($payment);

 $bill_discount_amount = $getPaymentData['bill_discount_amount'];
  $bill_discount_percentage = $getPaymentData['bill_discount_percentage'];

 if($bill_discount_amount > 0) {
                $discount_amount_finall = round($bill_discount_amount);
             } elseif ($bill_discount_percentage > 0) {
                  $calculation = round($getPaymentData['billing_amount']*$bill_discount_percentage)/100;
                  $discount_amount_finall = round($calculation);
             } else {
                $discount_amount_finall = 0;
             }
             // echo $discount_amount_finall;
 $total->billing_amount = round($getPaymentData['billing_amount'] - $discount_amount_finall);
 $total->paid_amount = round($getPaymentData['paid_amount']);

 $delivery_check = $getPaymentData['delivery'];
 if($delivery_check == 'Cancelled'){
    $total->outstanding_amount = 0;//round(($getPaymentData['billing_amount']-$discount_amount_finall)-$getPaymentData['paid_amount']);

 }else {
   $total->outstanding_amount = round(($getPaymentData['billing_amount']-$discount_amount_finall)-$getPaymentData['paid_amount']);
 }
 

 
$transaction = mysqli_query($link,"SELECT `date_time`,`amount`,`payment_mode`  FROM `shop__order_transaction` WHERE `order_token` = '$order_id' ORDER BY `id` ASC  ");
$x=1;
while ($row = mysqli_fetch_array($transaction)) {
	$payment_details = new stdClass;


	$convert_date= date('j,M Y', strtotime($row['date_time']));
	$payment_details->payment ="payment".$x;
	$payment_details->date_time = $convert_date;//$row['date_time'];
	$payment_details->amount = round($row['amount']);
	$payment_details->payment_mode = $row['payment_mode'];
	array_push($array, $payment_details);
	$x++;
}

$overall = new stdClass;
$overall->amout_data = $total;
$overall->overall_payment_details = $array;

$obj = new stdClass;

if($transaction){
	$obj->status_code=200; 
    $obj->message='transaction amount found';
    $obj->title='Success';
    $obj->data = $overall;


}else {
	$obj->status_code=400; 
    $obj->message='transaction amount not found';
    $obj->title='Success';

}


 echo json_encode($obj);
?>