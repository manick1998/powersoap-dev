<?php
$obj=new stdClass();
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
include_once '../objects/adminLogin.php';
$admin = new Admin($db);
$admin->userEmail=$inputData->user_email;
$admin->userPassword=$inputData->user_password;
$stmt=$admin->employeeLoginCheck();
$checkCount = $stmt->rowCount();
if($checkCount==0){
    $stmtEmail = $admin->loginEmailCheck();
    $checkEmailCount = $stmtEmail->rowCount();
    $stmtStatus = $admin->loginStatusCheck();
    $checkStatusCount = $stmtStatus->rowCount();
    $obj->code=503;
    if($checkEmailCount==0){
        $obj->message = "Please Enter Valid Email-id";
    }else if($checkStatusCount ==0){
        $obj->message = "Your account has been blocked, Kindly contact Admin";
    }else{
        $obj->message = "Please Enter Valid Password";
    }
}else{
    $obj->code   =201;
    $token = $admin->readToken($stmt);
    setcookie("token_admin_dashboard_development", $token, time() + (86400 * 30), "/");
    $obj->message="Success";
}
echo json_encode($obj);
$db = null;

?>