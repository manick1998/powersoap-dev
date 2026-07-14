<?php
include "../../config.php";
$json_input = getInputs();
$employee_id = $json_input->employee_id;
$shop_id = $json_input->shop_id;
// $order_id = $json_input->order_id;

date_default_timezone_set("Asia/Kolkata");
$order_date = date('Y-m-d h:i:s');

$obj = new stdClass;
$check = mysqli_query($link,"SELECT token FROM `orders` WHERE `shop_token` = $shop_id");
if(mysqli_num_rows($check)>0){
    
    $update_query = mysqli_query($link,"UPDATE `orders` SET `delivery`= 'Completed',delivered_on='$order_date' ,`delivery_emp_token`='$employee_id' WHERE `shop_token` = '$shop_id'");


    $obj->status_code=200; 
    $obj->message='delivered status';
    $obj->title='Success';


}else {
    $obj->status_code=400; 
    $obj->message='not delivered';
    $obj->title='Failed';
}
echo json_encode($obj);

?>