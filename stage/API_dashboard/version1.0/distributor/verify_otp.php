<?php
ob_start();
@session_start();
include_once '../config/core_distributor.php';
$input_data = getInputs();
date_default_timezone_set("Asia/Kolkata");
$now = date('Y-m-d H:i:s');

$emp_token = isset($input_data->emp_token) ? $input_data->emp_token : '';
$otp = isset($input_data->otp) ? $input_data->otp : '';

$obj = new stdClass;

if ($emp_token != '' && $otp != '') {
    // 1. Check for the most recent unsucessful OTP for this token
    $query = "SELECT * FROM `otp_log` WHERE `emp_token` = '$emp_token' AND `success` = 0 ORDER BY `id` DESC LIMIT 1";
    $result = mysqli_query($link, $query);

    if (mysqli_num_rows($result) == 1) {
        $row_otp = mysqli_fetch_assoc($result);
        $otp_id = $row_otp['id'];
        $db_otp = $row_otp['otp'];
        $attempts = $row_otp['attempts'];
        $expired_at = $row_otp['expired_at'];

        // 2. Check attempts
        if ($attempts >= 3) {
            $obj->status_code = 400;
            $obj->title = "Limit Exceeded";
            $obj->message = "You have exceeded the maximum number of attempts. Please try again after some time.";
        } 
        // 3. Check expiration
        else if ($now > $expired_at) {
            $obj->status_code = 400;
            $obj->title = "OTP Expired";
            $obj->message = "The OTP has expired. Please resend the OTP.";
        } 
        // 4. Validate OTP
        else {
            if ($otp == $db_otp) {
                // Success!
                mysqli_query($link, "UPDATE `otp_log` SET `success` = 1 WHERE `id` = '$otp_id'");

                // Fetch employee details to set session (same as original login.php)
                $emp_query = "SELECT `employees`.`token`, `employees`.`name`, `region`.`region_name`, `employees`.`state_id`, `employees`.`language` 
                             FROM `employees` 
                             INNER JOIN `region` ON `region`.`token`=`employees`.`region_id` 
                             WHERE `employees`.`token` = '$emp_token'";
                $emp_res = mysqli_query($link, $emp_query);
                
                if (mysqli_num_rows($emp_res) == 1) {
                    $row = mysqli_fetch_assoc($emp_res);
                    $_SESSION["distributor_token"] = $row["token"];
                    $_SESSION["name"] = $row["name"];
                    $_SESSION["region_name"] = $row["region_name"];
                    $_SESSION["state_id"] = $row["state_id"];
                    $_SESSION["language"] = $row["language"];
                    $_SESSION["verification_code"] = $verification_code;

                    $obj->status_code = 200;
                    $obj->title = "Success";
                    $obj->message = "OTP Verified Successfully. Redirecting...";
                    $obj->language = $row["language"];
                } else {
                    $obj->status_code = 400;
                    $obj->title = "Error";
                    $obj->message = "Employee details not found.";
                }
            } else {
                // Increment attempts
                $new_attempts = $attempts + 1;
                mysqli_query($link, "UPDATE `otp_log` SET `attempts` = '$new_attempts' WHERE `id` = '$otp_id'");
                
                if ($new_attempts >= 3) {
                    $obj->status_code = 400;
                    $obj->title = "Limit Exceeded";
                    $obj->message = "You have exceeded the maximum number of attempts. Please try again after some time.";
                } else {
                    $obj->status_code = 400;
                    $obj->title = "Invalid OTP";
                    $obj->message = "The OTP you entered is incorrect. Attempts left: " . (3 - $new_attempts);
                }
            }
        }
    } else {
        $obj->status_code = 400;
        $obj->title = "Error";
        $obj->message = "No active OTP session found. Please login again.";
    }
} else {
    $obj->status_code = 400;
    $obj->title = "Oops";
    $obj->message = "Missing required parameters.";
}

ob_clean();
echo json_encode($obj);
mysqli_close($link);
?>
