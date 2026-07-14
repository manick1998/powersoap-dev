<?php

$obj = new stdClass();
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
// if($inputData->dashboard_code == $verification_code){
include_once '../objects/employee.php';
$employee = new Employee($db);
$employee->mobileNumber = $inputData->employee_number;
$employee->old_mobilenumber = $inputData->old_mobilenumber;
$employee->token      = $inputData->employee_token;
$employee->name       = $inputData->employee_name;
$employee->old_name       = $inputData->old_name;
$employee->emaiId     = $inputData->employee_email_id;
$employee->old_email     = $inputData->old_email;
$employee->department = $inputData->employee_department;
$joinDate             = $inputData->employee_joindate;
$employee->joinDate   = date("Y-m-d", strtotime($joinDate));
$employee->address    = $inputData->employee_address;
$employee->area    = $inputData->employee_area;
$employee->street     = $inputData->employee_street;
$employee->city       = $inputData->employee_city;
$employee->state_token = $inputData->state_token;
$employee->pincode    = $inputData->employee_pincode;
$employee->division   = $inputData->employee_division;
$employee->employee_region   = $inputData->employee_region;
$employee->employee_state   = $inputData->employee_state;
$employee->licenseNumber = $inputData->employee_license_number;
$employee->old_licens = $inputData->old_licens;
$employee->image      = $inputData->employee_image;
$employee->proof1     = $inputData->address_proof1;
$employee->proof2     = $inputData->address_proof2;
$employee->proof3     = $inputData->address_proof3;
$employee->proof4     = $inputData->address_proof4;
$employee->proof5     = $inputData->address_proof5;
$employee->admin_token     = $inputData->admin_token;
$stmt3 = $employee->employeeEmailAlreadyExist();
$checkUpdateEmailId = $stmt3->rowCount();
// $stmtNumber = $employee->employeeUpdateMobileNumberCheck();
// $checkUpdateMobileNo = $stmtNumber->rowCount();
$stmtNumber1 = $employee->employeeUpdateLicenseNumberCheck();
$checkUpdatelicenseNo = $stmtNumber1->rowCount();
if ($checkUpdateEmailId == 0  && $checkUpdatelicenseNo == 0) {
    $insert = $employee->updateEmployee($indiaDateTime);
    $existRegion = $employee->isDistributorExistInRegion();
    if ($existRegion->rowCount() > 0) {
        $update = $employee->updateRegionWiseDistributor($indiaDateTime);
        $insert = $employee->insertRegionWiseDistributor($indiaDateTime);
    }
    $divisionArray   = $inputData->employee_division;
    $olddivisionArray = $inputData->old_division;
    $employee->deleteAllDivision();
    foreach ($divisionArray as $division) {
        $stmt = $employee->employeeDivisionCheck($division);
        // $stmt = $employee->update_distributor_log($division,$indiaDateTime);
        $checkCount = $stmt->rowCount();
        if ($checkCount == 0) {
            $employee->divisionInsert($division, $indiaDateTime);
            $employee->insertDistributorStock($division);
        } else {
            $employee->divisionUpdate($division);
        }
    }
    $insert1 = $employee->editEmployee_log($indiaDateTime, $divisionArray, $olddivisionArray);
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
    // if($checkUpdateMobileNo != 0){
    //     $obj->code=503;
    //     $obj->message="Mobile Number already exist!"; 
    // }    
    if ($checkUpdatelicenseNo != 0) {
        $obj->code = 503;
        $obj->message = "GST Number already exist!";
    }
}
echo json_encode($obj);
//}
