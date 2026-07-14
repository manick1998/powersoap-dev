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
    $employee->distributor_token = $inputData->distributor_token;
    //$employee->emaiId=$inputData->employee_email_id;
    $employee->token      = $inputData->employee_token;
    $employee->name       = $inputData->employee_name;
    //$employee->code       = $inputData->employee_code;
    $employee->emaiId     = $inputData->employee_email_id;
    $employee->department = $inputData->employee_department;
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
    $stmt3 = $employee->employeeUpdateEmailIdCheck();
    $checkUpdateEmailId = $stmt3->rowCount();
    //    $stmt1 = $employee->employeeUpdateEmployeeIdCheck();
    //    $checkUpdateEmployeeId = $stmt1->rowCount();
    $stmt2 = $employee->employeeMobileNumberCheck();
    $checkMobileNo = $stmt2->rowCount();
    $stmt4 = $employee->employeeMobileNumber();
    $stmt5 = $employee->employeeMobileNumberSales();
    $checksalesCount = $stmt5->rowCount();
    if ($checksalesCount == 0) {
        if ($stmt4 == $inputData->employee_number) {
            $insert = $employee->updateEmployee($indiaDateTime);
            $obj->code   = 201;
            $obj->message = "Success";
        } else if (($checkEmailId == 0  && $checkMobileNo == 0)) {
            $insert = $employee->updateEmployee($indiaDateTime);
            if ($inputData->address_proof2 != "") {
                if ($inputData->proof2_id != "") {
                    $employee->proofUpdate($inputData->address_proof2, $inputData->proof2_id);
                } else {
                    $employee->proofInsert($inputData->employee_token, $inputData->address_proof2);
                }
            }
            if ($inputData->address_proof3 != "") {
                if ($inputData->proof3_id != "") {
                    $employee->proofUpdate($inputData->address_proof3, $inputData->proof3_id);
                } else {
                    $employee->proofInsert($inputData->employee_token, $inputData->address_proof3);
                }
            }
            if ($inputData->address_proof4 != "") {
                if ($inputData->proof4_id != "") {
                    $employee->proofUpdate($inputData->address_proof4, $inputData->proof4_id);
                } else {
                    $employee->proofInsert($inputData->employee_token, $inputData->address_proof4);
                }
            }
            if ($inputData->address_proof5 != "") {
                if ($inputData->proof5_id != "") {
                    $employee->proofUpdate($inputData->address_proof5, $inputData->proof5_id);
                } else {
                    $employee->proofInsert($inputData->employee_token, $inputData->address_proof5);
                }
            }
            $obj->code   = 201;
            $obj->message = "Success";
        } else {
            if ($checkUpdateEmailId != 0) {
                $obj->code = 503;
                $obj->message = "Email Id already exist!";
            }
            //        if($checkUpdateEmployeeId != 0){
            //            $obj->code=503;
            //            $obj->message="Employee Id already exist!"; 
            //        }
            if ($checkMobileNo != 0) {
                $obj->code = 503;
                $obj->message = "Mobile number already exist!";
            }
        }
    } else {
        $obj->code = 503;
        $obj->message = "Mobile number already exist in SalesMan!";
    }
    echo json_encode($obj);
}
