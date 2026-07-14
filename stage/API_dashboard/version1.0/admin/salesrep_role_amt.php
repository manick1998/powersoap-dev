<?php
//required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/database.php';
include_once '../objects/employee.php';
$input_data = json_decode(file_get_contents("php://input"));
// if($input_data->verification_code == $verification_code){
    $database = new Database();
    $db = $database->getConnection();
    $employee = new Employee($db);
    $obj = new stdClass;
    if($input_data->type == "all_state"){
        $stmt = $employee->selectAllState();
        $count = $stmt->rowCount();
        if ($count > 0) {
            $state_data = $employee->fetchState_data($stmt);
            $obj->status_code = 200;
            $obj->header = "Success";
            $obj->message = "State List";
            $obj->data = $state_data;
        }else {
            $obj->status_code = 400;
            $obj->header = "Error";
            $obj->message = "State List not Found";
            $obj->data = [];
        }
    }else if($input_data->type =="designation") {
        $stmt = $employee->rollFunction();
        $count =$stmt->rowCount();
        if ($count > 0) {
             $roll_data = $employee->rollslist($stmt);
             $obj->status_code = 200;
             $obj->header = "Success";
             $obj->message = "rolls list"; 
             $obj->rollsdata = $roll_data;
        }else{
             $obj->status_code = 400;
             $obj->header = "Error";
             $obj->message = "rolls list data not found"; 
             $obj->rollsdata = [];
        }
     }else if($input_data->type =="addamount1") {
        $random = rand(10000000,99999999);
        $employee->state_token = $input_data->state_token;
        $employee->roles_token = $input_data->roles_token;
        $employee->alamount1 = $input_data->alamount1;
        $stmt = $employee->addroleamount($random);
        if ($stmt) {
             $obj->status_code = 200;
             $obj->header = "Success";
             $obj->message = "Data Insert Successfully"; 
        }else{
             $obj->status_code = 400;
             $obj->header = "Error";
             $obj->message = "Data Insert Not Successfully"; 
        }
     }else if($input_data->type =="addamount2") {
        $random = rand(10000000,99999999);
        $employee->state_token = $input_data->state_token;
        $employee->roles_token = $input_data->roles_token;
        $employee->alamount1 = $input_data->alamount1;
        $employee->alamount2 = $input_data->alamount2;
        $stmt = $employee->addroleamount2($random);
        if ($stmt) {
             $obj->status_code = 200;
             $obj->header = "Success";
             $obj->message = "Data Insert Successfully"; 
        }else{
             $obj->status_code = 400;
             $obj->header = "Error";
             $obj->message = "Data Insert Not Successfully"; 
        }
     }else if($input_data->type =="table_datas") {
       
        $stmt = $employee->role_table_data();
        $count =$stmt->rowCount();
        if ($count > 0) {
             $roll_amt_data = $employee->role_table_data_list($stmt);
             $obj->status_code = 200;
             $obj->header = "Success";
             $obj->message = "roles amt data founded"; 
             $obj->roll_amt_data = $roll_amt_data;
        }else{
             $obj->status_code = 400;
             $obj->header = "Error";
             $obj->message = "roles amt data not founded"; 
             $obj->roll_amt_data = [];
        }
     }else if($input_data->type =="update_addamount1") {
          // $random = rand(10000000,99999999);
          $employee->state_token = $input_data->state_token;
          $employee->roles_token = $input_data->roles_token;
          $employee->rep_al_token = $input_data->rep_al_token;
          $employee->alamount1 = $input_data->alamount1;
          // $employee->alamount2 = $input_data->alamount2;
          $stmt = $employee->updateroleamount1();
          if ($stmt) {
               $obj->status_code = 200;
               $obj->header = "Success";
               $obj->message = "Data Updated Successfully"; 
          }else{
               $obj->status_code = 400;
               $obj->header = "Error";
               $obj->message = "Data Updated Not Successfully"; 
          }
       }else if($input_data->type =="update_addamount2") {
          // $random = rand(10000000,99999999);
          $employee->state_token = $input_data->state_token;
          $employee->roles_token = $input_data->roles_token;
          $employee->rep_al_token = $input_data->rep_al_token;
          $employee->alamount1 = $input_data->alamount1;
          $employee->alamount2 = $input_data->alamount2;
          $stmt = $employee->updateroleamount2();
          if ($stmt) {
               $obj->status_code = 200;
               $obj->header = "Success";
               $obj->message = "Data Updated Successfully"; 
          }else{
               $obj->status_code = 400;
               $obj->header = "Error";
               $obj->message = "Data Updated Not Successfully"; 
          }
       }

echo json_encode($obj);
$db = null;

//}
?>