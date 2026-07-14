<?php
$obj=new stdClass();
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
include_once '../objects/employee.php';
$employee = new Employee($db);
$distributor_email = $inputData->distributor_email;
$distributor_name = $inputData->distributor_name;
$distributor_mobile=$inputData->$distributor_mobile;
$distributor_password=$input->$distributor_password;
$employee->email = $distributor_email;
$employee->mobile=$distributor_mobile;
$employee->name=$distributor_name;
$employee->password   = $password;
    $update = $employee->sendOTP($mobile,$name,$email,$password);
    if($update){
        $obj->code   = 201;
        $obj->message= "Success";
    }else{
        $obj->code   = 400;
        $obj->message= "Error";
    }
echo json_encode($obj);
?>