<?php
include "../../config.php";
$json_input = getInputs();
$employee_id = $json_input->employee_id;
$shop_id = $json_input->shop_id;
// $order_id = $json_input->order_id;

date_default_timezone_set("Asia/Kolkata");
$order_date = date('Y-m-d h:i:s');



$get_distributor_token = mysqli_query($link,"SELECT `admin_distributor_token`,deparment_token FROM `employees` WHERE `token`= '$employee_id'");
   $distribut_row  = mysqli_fetch_array($get_distributor_token);
   $dist_token_value = $distribut_row['admin_distributor_token'];
   $deparment_token = $distribut_row['deparment_token'];

$obj = new stdClass;
$check = mysqli_query($link,"SELECT token FROM `orders` WHERE `shop_token` = $shop_id");
if(mysqli_num_rows($check)>0){
    
    $update_query = mysqli_query($link,"UPDATE `orders` SET `delivery`= 'Completed',delivered_on='$currnetDateTime' ,`delivery_emp_token`='$employee_id' WHERE `shop_token` = '$shop_id'");



$check_status = mysqli_query($link,"SELECT * FROM `sales__log` WHERE `distributor_token`='$dist_token_value' AND `sales_token`='$employee_id' AND  `shop_token` ='$shop_id'");
    if($row_check = mysqli_num_rows($check_status) >0){

                 $sales_update = mysqli_query($link,"UPDATE `sales__log` SET `status`='Completed'  WHERE `distributor_token` = '$dist_token_value' AND `sales_token` = '$employee_id' AND `shop_token`='$shop_id' AND `date_time` LIKE '%$indiaDate%'");
    }
        else
        {
        $sales_log = mysqli_query($link,"INSERT INTO `sales__log`(`date_time`, `distributor_token`, `sales_token`,`department`, `shop_token`, `status`) VALUES ('$currnetDateTime','$dist_token_value','$employee_id','Delivery' , '$shop_id','Completed')");
        }




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