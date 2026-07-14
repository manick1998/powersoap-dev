<?php
include_once '../config/core_distributor.php';
$input_data = getInputs();
date_default_timezone_set("Asia/Kolkata");

$emp_token = isset($input_data->emp_token) ? $input_data->emp_token : '';

$obj = new stdClass;

if ($emp_token != '') {
    // Generate Static OTP
    $otp = 111111;
    $expired_at = date('Y-m-d H:i:s', strtotime('+10 minutes'));
    
    // Save OTP to table
    mysqli_query($link, "INSERT INTO `otp_log` (`emp_token`, `otp`, `expired_at`) VALUES ('$emp_token', '111111', '$expired_at')");
    
    $obj->status_code = 200;
    $obj->title = "Success";
    $obj->message = "OTP resent successfully.";
} else {
    $obj->status_code = 400;
    $obj->title = "Oops";
    $obj->message = "Missing required parameters.";
}

echo json_encode($obj);
mysqli_close($link);
?>
