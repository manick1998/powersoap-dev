<?php

include "../../config.php";

$json_input=getInputs();
$mobile = $json_input->phone_number;
$password = $json_input->password;

$obj = new stdClass;

$sql1 = mysqli_query($link,"SELECT
                                *
                            FROM
                                `employees`
                            INNER JOIN deparment ON deparment.token=employees.deparment_token WHERE `mobile_number` = $mobile AND
                             block_status = '1' AND deparment.token= '45916684'");

$check_status = mysqli_num_rows($sql1);
$sql1 = mysqli_query($link,"SELECT
                                *
                            FROM
                                `employees`
                           WHERE `mobile_number` = '$mobile'  AND `password`='' AND block_status = '1'");

$password_check = mysqli_num_rows($sql1);
if($check_status  > 0) {
if($password=='sales@123' && $password_check > 0) {
    $password1 = 123;
    $password2 = 'sales';
    $password3=$password2.'@'.$password1;
    $passwords = hash('sha512', $password3);


    $update = mysqli_query($link,"UPDATE `employees` SET `password`='$passwords' WHERE `mobile_number`='$mobile'");
    $password4 = hash('sha512', $password);
    $password_check = mysqli_query($link,"SELECT `id` FROM `employees` WHERE `password`='$password4' AND `mobile_number`='$mobile'");
    $password_count = mysqli_num_rows($password_check);
    $obj_emp=new stdClass;
   if($password_count>0){
      $query = mysqli_query($link,"SELECT `id` FROM `employees` WHERE `mobile_number`='$mobile' AND `password`='$password4' AND `block_status` ='1'");
      $result = mysqli_num_rows($query);
      $sql = mysqli_query($link,"SELECT employees.`id`, employees.`token`, employees.`name`, employees.`employees_code`, employees.`deparment_token`, employees.`gender`, employees.`mobile_number`,   deparment.name as dept_name FROM `employees` INNER JOIN deparment ON deparment.token = employees.deparment_token WHERE employees.mobile_number= '$mobile' AND deparment.token= '45916684'" );
      $row = mysqli_fetch_array($sql);
              $obj_emp->id=$row['id'];
              $obj_emp->token=$row['token'];
              $obj_emp->name=$row['name'];
              $obj_emp->employees_code=$row['employees_code'];
              $obj_emp->deparment_token=$row['deparment_token'];
              $obj_emp->gender=$row['gender'];
              $obj_emp->mobile_number=$row['mobile_number'];
              // $obj_emp->region=$row['region'];
              $obj_emp->dep_name=$row['dept_name'];
      if($result > 0) {
                $obj->status_code=200; 
                $obj->message='Login successfully';
                $obj->title='Success';
                $obj->data = $obj_emp;
            }
            else {
                $obj->status_code=400; 
                $obj->message='error';
                $obj->title='failure';
            }
        }else{
            $obj->status_code=400; 
            $obj->message='Password Incorrect';
            $obj->title='Failure';
        }
        }else{
            $password4 = hash('sha512', $password);
            $password_check = mysqli_query($link,"SELECT `id` FROM `employees` WHERE `password`='$password4'");
            $password_count = mysqli_num_rows($password_check);
            $obj_emp=new stdClass;
           if($password_count>0){
              $query = mysqli_query($link,"SELECT `id` FROM `employees` WHERE `mobile_number`='$mobile' AND `password`='$password4' AND `block_status` ='1'");
              $result = mysqli_num_rows($query);
              $sql = mysqli_query($link,"SELECT employees.`id`, employees.`token`, employees.`name`, employees.`employees_code`, employees.`deparment_token`, employees.`gender`, employees.`mobile_number`,   deparment.name as dept_name FROM `employees` INNER JOIN deparment ON deparment.token = employees.deparment_token WHERE employees.mobile_number= $mobile AND deparment.token= '45916684'" );
              $row = mysqli_fetch_array($sql);
                      $obj_emp->id=$row['id'];
                      $obj_emp->token=$row['token'];
                      $obj_emp->name=$row['name'];
                      $obj_emp->employees_code=$row['employees_code'];
                      $obj_emp->deparment_token=$row['deparment_token'];
                      $obj_emp->gender=$row['gender'];
                      $obj_emp->mobile_number=$row['mobile_number'];
                      // $obj_emp->region=$row['region'];
                      $obj_emp->dep_name=$row['dept_name'];
              if($result > 0) {
                        $obj->status_code=200; 
                        $obj->message='Login successfully';
                        $obj->title='Success';
                        $obj->data = $obj_emp;
                    }
                    else {
                        $obj->status_code=400; 
                        $obj->message='error';
                        $obj->title='failure';
                    }
                }else{
                    $obj->status_code=400; 
                    $obj->message='Password Incorrect';
                    $obj->title='Failure';
                }
        }
    }else {
            $obj->status_code=400; 
            $obj->message='Mobile number not exist';
            $obj->title='Failure';
        }
        
         echo json_encode($obj);


      ?>