<?php
include "../../config.php";
$json_input=getInputs();
$shop_id=$json_input->shop_id;
$employee_id = $json_input->employee_id;
$type = $json_input->type;
$unit_name = $json_input->unit_name;
date_default_timezone_set('Asia/Kolkata');
$indiaDateTime = date("Y-m-d");
//unit token
$unit = mysqli_query($link,"SELECT `token` FROM `units` WHERE `name`='$unit_name'");
$unitData = mysqli_fetch_array($unit);
$unit_token = $unitData['token'];

//shop_token
$shop = mysqli_query($link,"SELECT `token` FROM `shop_mapping` WHERE `shop_token`='$shop_id'");
$shopData = mysqli_fetch_array($shop);
$shop_token = $shopData['token'];

$shopVisted = mysqli_query($link,"SELECT * FROM `salesman_shop_visited` WHERE `employee_token`='$employee_id' AND  `shop_token`='$shop_token'  AND  `date`='$indiaDate' AND `status`='0'");
$count = mysqli_num_rows($shopVisted);



$obj = new stdClass;
if ($type == '1') {
    if($count==0){
    $sql = mysqli_query($link,"SELECT * FROM `orders` WHERE shop_token = '$shop_token' AND  employee_token = '$employee_id' AND date(date_time)='$indiaDate'");
    $data= mysqli_num_rows($sql);
    $row = mysqli_fetch_assoc($sql);
    $order_token = $row['token'];
    if ($data > 0) {
        $sql1 = "INSERT INTO `salesman_shop_visited`(`shop_token`, `employee_token`, `order_token`, `unit_token`, `status`,`date`) VALUES ('$shop_token','$employee_id','$order_token','$unit_token','1','$indiaDateTime')";
        if ($result1 = $link->query($sql1)) {
            $obj->status_code=200; 
            $obj->message='You Already visited the Shop';
            $obj->title='Success';
        }
    }else{
        $sql1 = "INSERT INTO `salesman_shop_visited`(`shop_token`, `employee_token`, `order_token`, `unit_token`, `status`,`date`) VALUES ('$shop_token','$employee_id','','$unit_token','0','$indiaDateTime')";
        if ($result1 = $link->query($sql1)) {
            $obj->status_code=200; 
            $obj->message='shop visited';
            $obj->title='Success';
        }
    }
}else{
    $obj->status_code=200; 
    $obj->message='You Already visited the Shop';
    $obj->title='Success';
}
}else {
        $obj->status_code=400; 
        $obj->message='Today schedule not available';
        $obj->title='failure';
    }


 echo json_encode($obj);
	
?>