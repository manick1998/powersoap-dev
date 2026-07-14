<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/database.php';
include_once '../objects/employee.php';
include_once '../config/core.php';
$data = json_decode(file_get_contents("php://input"));
date_default_timezone_set('Asia/Kolkata');
$currentDate  = date("Y-m-d H:i:s");
$database = new Database();
$db = $database->getConnection();
$emp = new Employee($db);
$obj = new stdClass;
$random_token=rand(10000000,99999999);
if ($data->type == 'admin_issue') {
     $emp->admin_token = $data->admin_token;
     $emp->admin_name = $data->admin_name;
     $emp->admin_mobilenumber = $data->admin_mobilenumber;
     $admin_departmenttoken = $data->admin_departmenttoken;
     $emp->text = $data->text;
     $emp->admin_image = $data->admin_image;
    $fun_call =  $emp->admin_add_issue($currentDate,$random_token,$admin_departmenttoken);
    $admin_token_name = $data->admin_token;
    $sql = mysqli_query($link,"SELECT `name` FROM `admin_login` WHERE token = $admin_token_name");
    $row = mysqli_fetch_assoc($sql);
    $admin_name = $row['name'];
    $emp->admin_add_issue_log($random_token,$admin_name,$admin_departmenttoken,$currentDate);
    if (!$fun_call) {
        $obj-> code ='404';
        $obj->message = 'Something went to wronge';
    }else{
        $obj-> code ='200';
        $obj->message = 'Requested Successfully';  
    }   
}elseif ($data->type == 'issue_table_data') {
    $stmt = $emp->issue_table();
    if ($stmt->rowCount()>0) {
        $table_data = $emp->issue_table_read($stmt);
        $obj-> code ='200';
        $obj->message = 'Data found Success';
        $obj->table_data = $table_data;

    }else{
        $obj-> code ='404';
        $obj->message = 'data not found';
    } 
}elseif ($data->type == 'status_change') {
    //  $emp->status_code = $data->status_code ;
     $emp->status_token = $data->status_token;
     $emp->emp_token = $data->emp_token;
     $emp->emp_name = $data->emp_name;
     $emp->depo_token = $data->depo_token;
     $emp->description = $data->description;
     $emp->status_code = $data->status_code;
    $stmt1 = $emp->status_update();
    if (!$stmt1) {
        $obj-> code ='404';
        $obj->message = 'data not updated';
    }else{
        $obj-> code ='200';
        $obj->message = 'Status Update Successfully';
        $stmt2 = $emp->support_log($currentDate);
    }

}
echo json_encode($obj);
?>