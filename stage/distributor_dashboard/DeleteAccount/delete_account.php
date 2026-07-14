<?php
session_start();
include '../../API_dashboard/version1.0/config/core_distributor.php';
$input_data = getInputs();
date_default_timezone_set("Asia/Kolkata");   
$date = date('Y-m-d h:i:s');

$user_email = $input_data->user_email;
$password = $input_data->user_password;
$user_password = hash('sha512', $password); // Hash the input password

$obj = new stdClass;

if($user_email != '' && $user_password != ''){

    $accountBlockCheck = mysqli_query($link, "SELECT `email_id`, `password`, `support_password`, `delete_status` FROM `employees` WHERE `deparment_token` = '18028120' AND `email_id` = '$user_email'");

    if(mysqli_num_rows($accountBlockCheck) == 1){
        $row = mysqli_fetch_assoc($accountBlockCheck);

        // Check if the account is already deleted
        if($row['delete_status'] == 2){
            $obj->status_code = 400;
            $obj->title = 'Account deleted';
            $obj->message = 'This account has already been deleted!';
        } else {
            if($row['password'] === $user_password || $row['support_password'] === $user_password){
                $updateStatus = mysqli_query($link, "UPDATE `employees` SET `delete_status` = '2' WHERE `email_id` = '$user_email'");

                if($updateStatus){
                    $obj->status_code = 200;
                    $obj->title = 'Success';
                    $obj->message = 'Account has been successfully deleted!';
                } else {
                    $obj->status_code = 400;
                    $obj->title = 'Error';
                    $obj->message = 'Failed to delete the account. Please try again later.';
                }
            } else {
                $obj->status_code = 400;
                $obj->title = 'Invalid credentials';
                $obj->message = 'The password you entered is incorrect.';
            }
        }
    } else {
        $obj->status_code = 404;
        $obj->title = 'Account not found';
        $obj->message = 'No account found with this email address.';
    }
} else {

    $obj->status_code = 400;
    $obj->title = "Oops";
    $obj->message = "Please enter Email address and Password!";
}

echo json_encode($obj);
$db = null;
?>
