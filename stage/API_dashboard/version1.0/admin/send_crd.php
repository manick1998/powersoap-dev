<?php
$obj=new stdClass();
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
include_once '../objects/employee.php';
$employee = new Employee($db);
$distributor_token = $inputData->distributor_token;
$distributor_email = $inputData->distributor_email;
$distributor_name = $inputData->distributor_name;
$distributor_mobile=$inputData->distributor_mobile;
$employee->token = $distributor_token;
$employee->email = $distributor_email;
$employee->mobile=$distributor_mobile;
$employee->name=$distributor_name;
if($distributor_token != "" && $distributor_email !=""){
    require '../../../PHPMailer/PHPMailerAutoload.php';
    $pwd   = generatePassword(8);
    $check = email($inputData->distributor_email,$pwd,$inputData->distributor_name,$invoicepath,$dashboard_link);
    $password  = hash('sha512', $pwd);
    $employee->password   = $password;
    $update1=$employee->sendOTP($inputData->distributor_mobile,$inputData->distributor_name,$inputData->distributor_email,$pwd);
    $update = $employee->send_otp();
    $update = $employee->insertDistributorPassword();
     if($update){
        $obj->code   = 201;
        $obj->message= "Success";
    }else{
        $obj->code   = 400;
        $obj->message= "Error";
    }

}else{
    $obj->code   = 400;
    $obj->message= "All field are mandatroy";
}
echo json_encode($obj);
?>