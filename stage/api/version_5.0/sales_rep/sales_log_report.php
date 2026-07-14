<?php
include "../../config.php";
$json_input = getInputs();
$employee_id = $json_input->employee_id;
$shop_id = $json_input->shop_id;
$reason = $json_input->reason;
$date = $currnetDateTime;


   $get_distributor_token = mysqli_query($link,"SELECT `admin_distributor_token` FROM `employees` WHERE `token`= '$employee_id'");
   $distribut_row  = mysqli_fetch_array($get_distributor_token);
   $dist_token_value = $distribut_row['admin_distributor_token'];


$obj = new stdClass;
$check_status = mysqli_query($link,"SELECT * FROM `sales__log` WHERE `distributor_token`='$dist_token_value' AND `sales_token`='$employee_id' AND  `shop_token` ='$shop_id'");
    if($row_check = mysqli_num_rows($check_status) == 0){

      $insert_log = mysqli_query($link,"INSERT INTO `sales__log`( `date_time`, `distributor_token`, `sales_token`, `shop_token`, `status`, `reason`) VALUES ('$date','$dist_token_value',
      	'$employee_id','$shop_id','Pending','$reason')");
      $obj->status_code=200; 
      $obj->message='Product inserted';
      $obj->title='Success';
    }
        else
        {
        $obj->status_code=400; 
      $obj->message='Already Exist';
      $obj->title='Failed';

        }


echo json_encode($obj);
  
 



?>