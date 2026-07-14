<?php
session_start();
//include_once '../config.php';
include_once '../config/core_distributor.php';
$input_data = getInputs();
date_default_timezone_set("Asia/Kolkata");   //India time (GMT+5:30)
$date = date('Y-m-d h:i:s');
$user_email = isset($input_data->user_email) ? $input_data->user_email : '';
$obj = new stdClass;
if($user_email != ''){
     $result = mysqli_query($link, "SELECT `email_id`,`delete_status` FROM `employees` WHERE `deparment_token` = '18028120' AND `email_id` = '$user_email' AND `block_status` = 1");
        if (mysqli_num_rows($result)==1) {
            $row = mysqli_fetch_assoc($result); 
            if($row["delete_status"]==2){
                $obj->status_code = 400; 
                $obj->title = "Account Deleted";
                $obj->message = "This account has been deleted.";
            }   else{        
             $result12 = mysqli_query($link, "SELECT `employees`.`token`, `employees`.`name`, `employees`.`mobile_number`, `region`.`region_name`, `employees`.`state_id` FROM `employees` INNER JOIN `region` ON `region`.`token`=`employees`.`region_id` WHERE `employees`.`deparment_token` = '18028120' AND `employees`.`email_id` = '$user_email'");
            if (mysqli_num_rows($result12)==1) {
                $row = mysqli_fetch_assoc($result12);
                $emp_token = $row["token"];
                $mobile_number = $row["mobile_number"];
                
                // Mask mobile number: last 5 digits as XXXXX
                $masked_mobile = substr($mobile_number, 0, strlen($mobile_number) - 5) . "XXXXX";
                
                // Generate Static OTP
                $otp = 111111;
                $expired_at = date('Y-m-d H:i:s', strtotime('+10 minutes'));
                
                // Save OTP to table
                mysqli_query($link, "INSERT INTO `otp_log` (`emp_token`, `otp`, `expired_at`) VALUES ('$emp_token', '$otp', '$expired_at')");
                
                $obj->status_code = 202;
                $obj->title = "OTP Required";
                $obj->message = "Please enter the OTP sent to $masked_mobile";
                $obj->emp_token = $emp_token;
                $obj->mobile = $masked_mobile;
            }else{
                $obj->status_code = 400;
                $obj->title = "Oops";
                $obj->message = "Please Provide Valid Password"; 
            }
        }
    }else{
            $obj->status_code = 400;
            $obj->title = "Oops";
            $obj->message = "Please Provide Distributor EmailId";
    }
}else{
    $obj->status_code = 400;
    $obj->title = "Oops";
    $obj->message = "Please enter Email address and Password!";
    }
echo json_encode($obj);
$db = null;
?>