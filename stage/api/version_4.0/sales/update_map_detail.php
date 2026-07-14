<?php
// ini_set('display_errors', 1);// show error reporting
//  error_reporting(E_ALL);
include "../../config.php";
$json_data = getInputs();
$employee_token = $json_data->employee_token;
$latitude = $json_data->latitude;
$longitude = $json_data->longitude;
$shop_id = $json_data->shop_id;
$current_date = $indiaDateTime;

if($employee_token !=''){

	$update_query = mysqli_query($link,"UPDATE `employees` set `latitude`='$latitude' ,`longitude`='$longitude' ,`last_date_time`='$current_date' WHERE `token`='$employee_token'");


   $get_distributor_token = mysqli_query($link,"SELECT `admin_distributor_token`,deparment_token FROM `employees` WHERE `token`= '$employee_token'");
   $distribut_row  = mysqli_fetch_array($get_distributor_token);
   $deparment_token = $distribut_row['deparment_token'];

   $sql1 = mysqli_query($link,"INSERT INTO `employee__map_log`( `employee_token`, `employee_cat_token`,`shop_token`, `latitude`, `longitude`, `date_time`) VALUES ('$employee_token','$deparment_token','$shop_id','$latitude','$longitude','$current_date')");


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