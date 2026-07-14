<?php
$obj = new StdClass();
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
include_once '../objects/adminLogin.php';
$admin = new Admin($db);

$user_name = $inputData->user_name;
$user_email = $inputData->user_email;
$user_state = $inputData->user_state;
$checked_module = $inputData->checked_module;
$module_id = $inputData->module_id;
$currentdate = date("Y-m-d H:i:s");
$password1=date('dm',strtotime($currentdate));
$arr = explode(' ',trim($user_name));
$password2=$arr[0];
$password3=$password2.'_@'.$password1;
$password = hash('sha512', $password3);

$admin->user_name = $user_name;
$admin->user_email = $user_email;
$admin->password = $password;
$admin->user_state = $user_state;
$admin->checked_module = $checked_module;
$admin->module_id = $module_id;

$stmt = $admin->checkuser();
$count = $stmt->rowCount();

if($count == 0){
    require '../../../PHPMailer/PHPMailerAutoload.php';
    $check1 = emailSend($inputData->user_email,$password3,$inputData->user_name);
    $admin->token = token_generate('admin_login','token');
    $check = $admin->createRole();
   
    if($check){
        $admin->createRoleModules();
        $obj->code    = 201;
        $obj->message = "Role created Successfully";
    }else{
        $obj->code    = 503;
        $obj->message = "Error";
    }
}else{
    $obj->code    = 503;
    $obj->message = "Email Already exist";
}
echo json_encode($obj);
$db = null;

?>