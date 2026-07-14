<?php
include "../../config.php";
$json_input = getInputs();
$employee_id = $json_input->employee_id;
$shop_id = $json_input->shop_id;
$reson = $json_input->reason;

date_default_timezone_set("Asia/Kolkata");
$order_date = date('Y-m-d h:i:s');

$order_get = mysqli_query($link,"SELECT
                        orders.token as order_id
                    FROM
                        `orders`
                    INNER JOIN shop ON shop.token = orders.shop_token WHERE orders.shop_token =$shop_id  
                    ORDER BY `orders`.`id` DESC LIMIT 1");
$order_row = mysqli_fetch_array($order_get);
 $order_val = $order_row['order_id'];

$obj = new stdClass;
if($employee_id){
    
    $insert_query = mysqli_query($link,"INSERT INTO `orders__pendingreson`( `date_time`, `order_token`, `reson`, `employee_token`) VALUES ('$order_date','$order_val','$reson','$employee_id')");



$check_status = mysqli_query($link,"SELECT 1 FROM `sales__log` WHERE `distributor_token`='$dist_token_value' AND `sales_token`='$employee_id' AND  `shop_token` ='$shop_id'");
    if($row_check = mysqli_num_rows($check_status) >0){

                 $sales_update = mysqli_query($link,"UPDATE `sales__log` SET `status`='Completed'  WHERE `distributor_token` = '$dist_token_value' AND `sales_token` = '$employee_id' AND `shop_token`='$shop_id' AND `date_time` LIKE '%$indiaDate%'");
    }
        else
        {
        $sales_log = mysqli_query($link,"INSERT INTO `sales__log`(`date_time`, `distributor_token`, `sales_token`,`department`, `shop_token`, `status`, `reason`) VALUES ('$order_date','$dist_token_value','$employee_id','Delivery' , '$shop_id','Pending' ,'$reson')");
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