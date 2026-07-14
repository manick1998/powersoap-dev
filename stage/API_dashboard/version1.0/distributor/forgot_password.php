<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/employee_distributor.php';
include_once '../config/core_distributor.php';

$input_data = json_decode(file_get_contents("php://input"));

$database = new Database();
$db = $database->getConnection();
$employee = new Employee($db);

$obj = new stdClass();

if (!isset($input_data->type)) {
    $obj->status_code = 400;
    $obj->header = "Error";
    $obj->message = "Missing type parameter";
    echo json_encode($obj);
    exit;
}

if ($input_data->type == "email_id") {
    
    $employee->emaiId = $input_data->email;
    
    $stmt1 = $employee->employeeEmaiIdCheck();
    $num = $stmt1->rowCount();
    
    if ($num == 1) {
        
        // Generate 6-digit OTP
        $fourRandomDigit = mt_rand(100000, 999999);
        
        // Save OTP to employees table
        if ($employee->insertOTP($fourRandomDigit)) {
            
            // Send Email instead of SMS
            require '../../../PHPMailer/PHPMailerAutoload.php';
            
            $emailSent = email($input_data->email, $fourRandomDigit);
            
            if ($emailSent) {
                $obj->status_code = 200;
                $obj->header = "Success";
                $obj->message = "OTP sent successfully to your email";
                $obj->otp_sent = true;
            } else {
                $obj->status_code = 400;
                $obj->header = "Error";
                $obj->message = "Failed to send email. Please try again.";
            }
            
        } else {
            $obj->status_code = 400;
            $obj->header = "Error";
            $obj->message = "Failed to generate OTP";
        }
        
    } else {
        $obj->status_code = 400;
        $obj->header = "Error";
        $obj->message = "Invalid Email ID. Please enter registered email";
    }
    
} 
else if ($input_data->type == "otp_verify") {
    
    // FIX: Pass the email to the employee object so it knows which user's OTP to check
    $employee->emaiId = $input_data->email; 
    
    $employee->otp = $input_data->otp;
    $stmt = $employee->verifyOtp();
    $num = $stmt->rowCount();
    
    if ($num == 1) {
        // Clear OTP after successful verification
        $employee->insertOTP('');
        
        $obj->status_code = 200;
        $obj->header = "Success";
        $obj->message = "OTP verified successfully";
    } else {
        $obj->status_code = 400;
        $obj->header = "Error";
        $obj->message = "Invalid OTP. Please enter the correct OTP";
    }
    
} 
else if ($input_data->type == "change_password") {
    
    // FIX: Pass the email to the employee object so it knows which user's password to update
    $employee->emaiId = $input_data->email; 
    
    $employee_password = hash('sha512', $input_data->password);
    $employee->password = $employee_password;
    
    if ($employee->updateEmployeePassword()) {
        $obj->status_code = 200;
        $obj->header = "Success";
        $obj->message = "Password updated successfully";
    } else {
        $obj->status_code = 400;
        $obj->header = "Error";
        $obj->message = "Failed to update password";
    }
    
} else {
    $obj->status_code = 400;
    $obj->header = "Error";
    $obj->message = "Invalid type";
}

echo json_encode($obj);
?>