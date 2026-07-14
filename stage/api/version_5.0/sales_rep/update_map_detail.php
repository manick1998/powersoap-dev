<?php
include "../../config.php";
$json_data = getInputs();
$employee_token = $json_data->employee_token;
$latitude = $json_data->latitude;
$longitude = $json_data->longitude;
$shop_id = $json_data->shop_id;
$current_date = $indiaDateTime;
$currnetDate =  date("Y-m-d");
$map_value = "$latitude,$longitude";


$getShopDistributor = mysqli_query($link,"SELECT `shop_mapping`.`distributor_token` FROM `shop_mapping` INNER JOIN `schedule_sales_rep` ON `shop_mapping`.`distributor_token`=`schedule_sales_rep`.`distributor_token` WHERE schedule_sales_rep.schedule_date='$currnetDate' AND `shop_mapping`.`shop_token`='$shop_id'");
$getShopDistributor_row = mysqli_fetch_array($getShopDistributor);
$shop_distributor_token = $getShopDistributor_row['distributor_token'];

$getShopMapping = mysqli_query($link,"SELECT `token` FROM `shop_mapping` WHERE `shop_token`='$shop_id' AND `distributor_token`='$shop_distributor_token'");
$getShopMapping_row = mysqli_fetch_array($getShopMapping);
$shop_mapping_token = $getShopMapping_row['token'];

if($employee_token !=''){

	$update_query = mysqli_query($link,"UPDATE `employees` set `latitude`='$latitude' ,`longitude`='$longitude' ,`last_date_time`='$current_date' WHERE `token`='$employee_token'");


   $get_distributor_token = mysqli_query($link,"SELECT `admin_distributor_token`,deparment_token FROM `employees` WHERE `token`= '$employee_token'");
   $distribut_row  = mysqli_fetch_array($get_distributor_token);
   $deparment_token = $distribut_row['deparment_token'];

   $sql1 = mysqli_query($link,"INSERT INTO `employee__map_log`( `employee_token`, `employee_cat_token`,`shop_token`, `latitude`, `longitude`, `date_time`) VALUES ('$employee_token','$deparment_token','$shop_mapping_token' ,'$latitude','$longitude','$current_date')");

   $sql2 = mysqli_query($link,"SELECT
   `coordinates`
FROM
   `shop`
WHERE
   `token` = '$shop_mapping_token'");
   $coordinate = mysqli_fetch_array($sql2);
   $coordinate_value=$coordinate["coordinates"]!=""?$coordinate["coordinates"]:0;
if($coordinate_value==0){
    $sql3 = mysqli_query($link,"UPDATE `shop` SET `coordinates`='$map_value' WHERE `token`='$shop_mapping_token'");
}
$update = mysqli_query($link,"UPDATE `live_location` set `type`=2,`latitud`='$latitude' ,`langitud`='$longitude' ,`date_time`='$current_date' WHERE `rep_token`='$employee_token' ORDER BY id DESC LIMIT 1");
}
$obj = new stdClass;
if($sql1){
    $obj->status_code=200; 
    $obj->message='map updated';
    $obj->title='Success';
    
    
} else {
    $obj->status_code=400; 
    $obj->message='map not updated';
    $obj->title='Failed';
    
}

echo json_encode($obj);



?>