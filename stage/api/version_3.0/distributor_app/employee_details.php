<?php
include "../../config.php";
$inputData = getInputs();
$obj_com = new stdClass;
$distributor_token = $inputData->distributor_token;
if($inputData->type == 'all_employee'){
    $employeeSql = mysqli_query($link,"SELECT `employees`.`token`,
            `employees`.`employees_code`,
            `employees`.`name`,
            `deparment`.`name` AS `deparment_name`,
            `employees`.`mobile_number`,
            `employees`.`email_id`,
            `employees`.`join_date`,
            `employees`.`dob`
            FROM `employees`
            INNER JOIN `deparment` ON `deparment`.`token`=`employees`.`deparment_token`
            WHERE `delete_status`='1' AND `employees`.`admin_distributor_token`='$distributor_token'
            ORDER BY `employees`.`id` DESC");
            $array = [];
            if(mysqli_num_rows($employeeSql) > 0){
                while ($row = mysqli_fetch_array($employeeSql)) {
                    $obj = new stdClass;
                    $obj->employee_token = (int)$row['token'];
                    $obj->employee_code  = $row['employees_code'];
                    $obj->employee_name  = $row['name'];
                    $obj->employee_deparment_name= $row['deparment_name'];
                    $obj->employee_mobile_number = $row['mobile_number'];
                    $obj->employee_email_id  = $row['email_id'];
                    $obj->employee_join_date = date("m/d/Y",strtotime($row['join_date']));
                    $obj->employee_dob       = date("m/d/Y",strtotime($row['dob']));
                    array_push($array, $obj);
                }
                $obj_com->status_code=200; 
                $obj_com->message='Employee Details';
                $obj_com->title='Success';
                $obj_com->data=$array;   
            }else{
                $obj_com->status_code=400; 
                $obj_com->message='No Employee Details';
                $obj_com->title='Oops';
            }
}else if($inputData->type == 'add_employee'){
        $password  = hash('sha512', "powersoapdist");
        $mobileNumber = $inputData->employee_number;
        $emaiId     = $inputData->employee_email_id;
        $name       = $inputData->employee_name;
        $department = $inputData->employee_department;
        $distributor_token = $inputData->distributor_token;
        $gender     = $inputData->gender;
        $joinDate   = date("Y-m-d", strtotime($inputData->employee_joindate));
        $dob        = date("Y-m-d", strtotime($inputData->employee_dob));
        $bloodGroup = $inputData->employee_blood_group;
        $address    = $inputData->employee_address;
        $street     = $inputData->employee_street;
        $city       = $inputData->employee_city;
        $pincode    = $inputData->employee_pincode;
        $image      = $inputData->employee_image;
        $proof      = $inputData->address_proof;
        $token      = genToken("token","employees");
        if($inputData->employee_department == "93402780"){
            $employees_code = genToken("employees_code","employees");
            $code = 'DEL'.$employees_code;
        }else if($inputData->employee_department == "45916684"){
            $employees_code = genToken("employees_code","employees");
            $code = 'SAL'.$employees_code;
        }
        
        $email_sql = mysqli_query($link,"SELECT `id` FROM `employees` WHERE `email_id`='$emaiId' AND `email_id` != ''");
        $checkEmailId = mysqli_num_rows($email_sql);
        $mobile_sql = mysqli_query($link,"SELECT `id` FROM `employees` WHERE `mobile_number`='$mobileNumber' AND `mobile_number` != ''");
        $checkMobileNo = mysqli_num_rows($mobile_sql);
    
        if($checkEmailId == 0 && $checkMobileNo == 0){
            $addquery = "INSERT INTO `employees` (`token`,`name`,`date_time`,`employees_code`,`email_id`,`password`,`deparment_token`,`admin_distributor_token`,`gender`,`mobile_number`,`join_date`,`dob`,`blood_group`,`address`,`street`,`city`,`pincode`,`address_proof`,`state_id`,`delete_status`,`employee_image`)VALUES('$token','$name','$indiaDateTime','$code','$emaiId','$password','$department','$distributor_token','$gender','$mobileNumber','$joinDate','$dob','$bloodGroup','$address','$street','$city','$pincode','$proof','','1','$image')";
        
            if(mysqli_query($link,$addquery)){
                $obj_com->status_code = 200; 
                $obj_com->message = 'Add Employee Successfully';
                $obj_com->title = 'Success';
            }else{
                $obj_com->status_code = 400; 
                $obj_com->message = 'Not able to add employee';
                $obj_com->title = 'Oops';
            }
        }else{
            if($checkEmailId != 0){
                $obj_com->status_code = 400; 
                $obj_com->message = 'Email Id already exist!';
                $obj_com->title = 'Oops';
            }
            if($checkMobileNo != 0){
                $obj_com->status_code = 400; 
                $obj_com->message = 'Mobile number already exist!';
                $obj_com->title = 'Oops';
            }
        }
}else if($inputData->type == 'single_employee'){
        $employee_token = $inputData->employee_token;
        $distributor_token = $inputData->distributor_token;
        $single_sql = mysqli_query($link,"SELECT `employees`.`token`,
        `employees`.`employees_code`,
        `employees`.`employee_image`,
        `employees`.`name`,
        `employees`.`gender`,
        `deparment`.`name` AS `deparment_name`,
        `employees`.`mobile_number`,
        `employees`.`email_id`,
        `employees`.`join_date`,
        `employees`.`dob`,
        `employees`.`blood_group`,
        `employees`.`address`,
        `employees`.`pincode`,
        `employees`.`street`,
        `employees`.`city`,
        `employees`.`address_proof`,
        `employees`.`block_status`
        FROM `employees`
        INNER JOIN `deparment` ON `deparment`.`token`=`employees`.`deparment_token`
        WHERE `delete_status`='1'
        AND `employees`.`token`='$employee_token' AND `employees`.`admin_distributor_token`='$distributor_token'");
        $array = [];
        if(mysqli_num_rows($single_sql) == '1'){
            while ($row = mysqli_fetch_array($single_sql)){
                $obj = new stdClass;
                $obj->employee_token = (int)$row['token'];
                $obj->block_status   = (int)$row['block_status'];
                $obj->employee_code  = $row['employees_code'];
                $obj->profile_image  = $row['employee_image'];
                $obj->employee_name  = $row['name'];
                $obj->employee_gender= ucwords(strtolower($row['gender']));
                $obj->employee_deparment_name= $row['deparment_name'];
                $obj->employee_mobile_number = $row['mobile_number'];
                $obj->employee_email_id  = $row['email_id'];
                $obj->employee_join_date = date("m/d/Y",strtotime($row['join_date']));
                $obj->employee_dob       = date("m/d/Y",strtotime($row['dob']));
                $dateOfBirth = $row['dob'];
                $diff = date_diff(date_create($dateOfBirth), date_create($indiaDate));
                $obj->employee_age          = $diff->format('%y')." age";
                $obj->employee_blood_group  = $row['blood_group'];
                $obj->employee_address_proof= $row['address_proof'];
                $obj->employee_address      = $row['address'];
                $obj->employee_street =    $row['street'];
                $obj->employee_city = $row['city'];
                $obj->employee_pincode = $row['pincode'];
                array_push($array, $obj);
          }
        $obj_com->status_code = 200; 
        $obj_com->message = 'Single Employee Data Successfully';
        $obj_com->title = 'Success';
        $obj_com->data = $array;
      }else{
        $obj_com->status_code = 400; 
        $obj_com->message = 'No Employee Data Found';
        $obj_com->title = 'Oops';   
      }   
}else if($inputData->type == 'edit_employee'){
    $mobileNumber = $inputData->employee_number;
    $distributor_token = $inputData->distributor_token;
    $token      = $inputData->employee_token;
    $name       = $inputData->employee_name;
    $emaiId     = $inputData->employee_email_id;
    $department = $inputData->employee_department;
    $gender     = $inputData->gender;
    $joinDate   = date("Y-m-d", strtotime($inputData->employee_joindate));
    $dob        = date("Y-m-d", strtotime($inputData->employee_dob));
    $bloodGroup = $inputData->employee_blood_group;
    $address    = $inputData->employee_address;
    $street     = $inputData->employee_street;
    $city       = $inputData->employee_city;
    $pincode    = $inputData->employee_pincode;
    $image      = $inputData->employee_image;
    $proof      = $inputData->address_proof;
    $email_edit_sql = mysqli_query($link,"SELECT * FROM `employees` WHERE `email_id`='$emaiId' AND `email_id` != '' AND `token` not in ('$token')");
    $checkEmailIdEdit = mysqli_num_rows($email_edit_sql);
    $mobile_edit_sql = mysqli_query($link,"SELECT * FROM `employees` WHERE `mobile_number`='$mobileNumber' AND `mobile_number` != '' AND `token` not in ('$token')");
    $checkMobileEdit = mysqli_num_rows($mobile_edit_sql);
    
    if($checkEmailIdEdit == 0 && $checkMobileEdit == 0){
         $edit_query = "UPDATE `employees` SET `name`='$name',
         `date_time`='$indiaDateTime',
         `email_id`='$emaiId',
         `deparment_token`='$department',
         `admin_distributor_token`='$distributor_token',
         `gender`='$gender',
         `mobile_number`='$mobileNumber',
         `join_date`='$joinDate',
         `dob`='$dob',
         `blood_group`='$bloodGroup',
         `address`='$address',
         `street`='$street',
         `city`='$city',
         `pincode`='$pincode',
         `address_proof`='$proof',
         `state_id`='',
         `delete_status`='1',
         `employee_image`='$image' WHERE `token`='$token'"; 
    
        if(mysqli_query($link,$edit_query)){
            $obj_com->status_code = 200; 
            $obj_com->message = 'Employee Data Updated Successfully';
            $obj_com->title = 'Success';
        }else{
            $obj_com->status_code = 400; 
            $obj_com->message = 'Employee Data Not Updated';
            $obj_com->title = 'oops';
        }
    }
}
echo json_encode($obj_com);
?>