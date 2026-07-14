<?php

$obj = new stdClass();
include_once '../config/core_distributor.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
if ($inputData->dashboard_code == $verification_code) {
    include_once '../objects/employee_distributor.php';
    $employee = new Employee($db);
    $employee->mobileNumber = $inputData->employee_number;
    $employee->emaiId = $inputData->employee_email_id;
    //$employee->code = $inputData->employee_code;
    $employee->name       = $inputData->employee_name;
    $employee->department = $inputData->employee_department;
    $employee->distributor_token = $inputData->distributor_token;
    $employee->gender     = $inputData->gender;
    $joinDate             = $inputData->employee_joindate;
    $employee->joinDate   = date("Y-m-d", strtotime($joinDate));
    $dob                  = $inputData->employee_dob;
    $employee->dob        = date("Y-m-d", strtotime($dob));
    $employee->bloodGroup = $inputData->employee_blood_group;
    $employee->address    = $inputData->employee_address;
    $employee->street     = $inputData->employee_street;
    $employee->city       = $inputData->employee_city;
    $employee->pincode    = $inputData->employee_pincode;
    $employee->image      = $inputData->employee_image;
    $employee->proof1     = $inputData->address_proof1;
    $employee->proof2     = $inputData->address_proof2;
    $employee->proof3     = $inputData->address_proof3;
    $employee->proof4     = $inputData->address_proof4;
    $employee->proof5     = $inputData->address_proof5;
    if ($inputData->type == "AddEmployee") {
        if ($inputData->employee_department == "93402780") {
            $employees_code = token_generate("employees", "employees_code");
            $employee->code = 'DEL' . $employees_code;
        } else if ($inputData->employee_department == "45916684") {
            $employees_code = token_generate("employees", "employees_code");
            $employee->code = 'SAL' . $employees_code;
        }
        $token   = $employee->tokenGenerate();
        $employee->token  = $token;
        //                $stmt=$employee->employeeCheck();
        //                $checkMobileNo = $stmt->rowCount();
        $stmt1 = $employee->employeeEmaiIdCheck();
        $checkEmailId = $stmt1->rowCount();
        $stmt2 = $employee->employeeMobileNumberCheck();
        $checkMobileNo = $stmt2->rowCount();
        $stmt4 = $employee->employeeMobileNumber();
        $stmt5 = $employee->employeeMobileNumberSales();
        $checksalesCount = $stmt5->rowCount();
        if ($checksalesCount == 0) {
            if ($stmt4 == $inputData->employee_number) {
                $insert = $employee->addEmployee($indiaDateTime);
                $obj->code = 201;
                $obj->message = "Success";
            } else if (($checkEmailId == 0  && $checkMobileNo == 0)) {
                $insert = $employee->addEmployee($indiaDateTime);
                if ($inputData->address_proof2 != "") {
                    $employee->proofInsert($employee->token, $employee->proof2);
                }
                if ($inputData->address_proof3 != "") {
                    $employee->proofInsert($employee->token, $employee->proof3);
                }
                if ($inputData->address_proof4 != "") {
                    $employee->proofInsert($employee->token, $employee->proof4);
                }
                if ($inputData->address_proof5 != "") {
                    $employee->proofInsert($employee->token, $employee->proof5);
                }
                $obj->code = 201;
                $obj->message = "Success";
            } else {
                if ($checkEmailId != 0) {
                    $obj->code = 503;
                    $obj->message = "Email Id already exist!";
                }
                if ($checkMobileNo != 0) {
                    $obj->code = 503;
                    $obj->message = "Mobile number already exist!";
                }
                //                    if($checkEmployeeCode != 0){
                //                        $obj->code=503;
                //                        $obj->message="Employee Id already exist!"; 
                //                    } 
            }
        } else {
            $obj->code = 503;
            $obj->message = "Mobile number already exist in SalesMan!";
        }
    }
    echo json_encode($obj);
}
