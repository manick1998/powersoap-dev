<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/employee.php';
$database = new Database();
$db = $database->getConnection();
$employee = new Employee($db);
$input_data = json_decode(file_get_contents("php://input"));
$employee->state_token = $input_data->state_token;

// $function_call = $employee->state_and_region();
// $count = $function_call->rowCount();
$obj = new stdClass();
if ($input_data->type = "state") {
    $stmt = $employee->state_and_region();
    if ($stmt->rowCount()>0) {
       $data1=$employee->state_and_region_read($stmt);
       $obj->code=200;
       $obj->message="success";
       $obj->area_data = $data1;
    }else {
       $obj->code=400;
       $obj->message="Data node found";
    }
    
 }

// if ($count == 0) {
//     $obj = new stdClass();
//     $obj->message = "data not found";
// }
// else{
//     $array=[];
//     while ($rows = $function_call->fetch(PDO::FETCH_ASSOC)) {

//         $obj = new stdClass();
//             $obj->state_id =  $rows['state_id'];
            
//             $obj->region_name = $rows['region_name'];
                
//             $obj->region_token = $rows['region_token'];
                
//             array_push($array,$obj);
//         }
//         $obj->status=true;
//         $obj->message="success";
//         $obj->code=200;
//         $obj=$array;
//     }
   
 echo json_encode($obj);
    


?>