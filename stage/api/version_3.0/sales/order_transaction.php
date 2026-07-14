
<?php
include "../../config.php";
$json_input = getInputs();
$employee_id = $json_input->employee_id;
$order_id = $json_input->order_id;
$shop_token = $json_input->shop_id;
$amount = $json_input->amount_paid;
$payment_type = $json_input->payment_type;
$indiaDateTime_Val= $indiaDateTime;



$order_select  = mysqli_query($link,"SELECT `paid_amount`,`billing_amount`,`outstanding_amount` FROM `orders` WHERE `token` = $order_id ");
if($order_select){



$get_Data = mysqli_fetch_array($order_select);
 $bill_amt = $get_Data['billing_amount'];
 $paid_amount = $get_Data['paid_amount'];
$outstanding_amount = $get_Data['outstanding_amount'];

$outstanding_amt = $outstanding_amount - $amount;

 $new_amt = $paid_amount+$amount;

if($bill_amt >= $new_amt){
	 $total_outstanding = $bill_amt - $new_amt;
$update = mysqli_query($link,"UPDATE `orders` SET `paid_amount`= '$new_amt',`outstanding_amount` = '$outstanding_amt' WHERE `token` = $order_id");
$update_shop_amt = mysqli_query($link,"UPDATE `shop__outstanding` SET `paid_amt`= '$new_amt',`total_outstanding`='$total_outstanding' WHERE `shop_token` = $shop_token");



$inser_amt = mysqli_query($link,"INSERT INTO `shop__order_transaction`( `date_time`,`order_token`, `shop_token`, `amount`, `payment_mode`, `employee_id`) VALUES ('$indiaDateTime_Val','$order_id','$shop_token','$amount','$payment_type','$employee_id')");
}
}

$obj = new stdClass;

if($inser_amt){
	$obj->status_code=200; 
    $obj->message='amount added';
    $obj->title='Success';
    
}
else {
	$obj->status_code=400; 
    $obj->message='amount not added';
    $obj->title='Failed';
}
echo json_encode($obj);
?>