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
$employee->licenseNumber = $inputData->employee_license_number;
$employee->emaiId = $inputData->employee_email_id;

$stmt = $employee->employeeEmailCheck();
$checkCountEmail = $stmt->rowCount();
// $stmtNumber = $employee->employeeMobileNumberCheck();
// $checkCountMobileNo = $stmtNumber->rowCount();
$stmt2 = $employee->licenseNumberCheck();
$checkCountLicenseNumber = $stmt2->rowcount();

// $employee->area_token=$inputData->area_token;
// $stmt3=$employee->area_token_validation();
// $area_token_validation=$stmt3->rowcount();
// && $area_token_validation==0


if ($checkCountEmail == 0  && $checkCountLicenseNumber == 0) {
    require '../../../PHPMailer/PHPMailerAutoload.php';
    $pwd   = generatePassword(8);
    //        $check = email($inputData->employee_email_id,$pwd,$inputData->employee_name,$invoicepath);
    //        if($check){
    $password  = hash('sha512', $pwd);
    $token                = $employee->tokenGenerate();
    $employee->password   = $password;
    $employee->token      = $token;
    $employee_code = token_generate('employees', 'employees_code');
    $employee->code = "DIST" . $employee_code;
    $employee->name       = $inputData->employee_name;
    $employee->emaiId     = $inputData->employee_email_id;
    $employee->department = $inputData->employee_department;
    $joinDate             = $inputData->employee_joindate;
    $employee->joinDate   = date("Y-m-d", strtotime($joinDate));
    $employee->address    = $inputData->employee_address;
    $employee->area       = $inputData->employee_area;
    //            $employee->street     = $inputData->employee_street;
    $employee->city       = $inputData->employee_city;
    $employee->pincode    = $inputData->employee_pincode;
    $employee->division   = $inputData->employee_division;
    $employee->licenseNumber = $inputData->employee_license_number;
    $employee->employee_region = $inputData->employee_region;
    $employee->employee_state = $inputData->employee_state;
    $employee->employee_area = $inputData->employee_area;
    $employee->image      = $inputData->employee_image;
    $employee->proof1     = $inputData->address_proof1;
    $employee->proof2     = $inputData->address_proof2;
    $employee->proof3     = $inputData->address_proof3;
    $employee->proof4     = $inputData->address_proof4;
    $employee->proof5     = $inputData->address_proof5;
    $employee->admin_token     = $inputData->admin_token;
    $insert = $employee->addEmployee($indiaDateTime);

    $region_data = $employee->insertRegionWiseDistributor($indiaDateTime);
    $divisionArray   = $inputData->employee_division;
    $insert1 = $employee->addEmployee_log($indiaDateTime);
    foreach ($divisionArray as $division) {
        $employee->divisionInsert($division, $indiaDateTime);
        $employee->insertDistributorStock($division);
    }
    if ($inputData->address_proof2 != "") {
        $employee->proofInsert($token, $inputData->address_proof2);
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
    $obj->code   = 201;
    $obj->message = "Success";
    //        }else{
    //            $obj->code   = 503;
    //            $obj->message= "Issue in mailer";
    //        }  
} else {
    $obj->code = 503;
    if ($checkCountEmail != 0) {
        $obj->message = "Email Id already exist!";
        // }else if($checkCountMobileNo!=0){
        //      $obj->message="Mobile Number already exist!";
    } else if ($checkCountLicenseNumber != 0) {
        $obj->message = "GST Number already exist!";
    }
    // else if($area_token_validation!=0){
    //     $obj->message="Please Select The Area!";
    // }
}
echo json_encode($obj);
$db = null;
//}
