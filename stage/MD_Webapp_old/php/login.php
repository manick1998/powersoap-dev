<?php

include "../config.php";

$json_input=getInputs();
$useremail = $json_input->user_email;
$userpassword = $json_input->user_password;
  
$obj = new stdClass;
$password = hash('sha512', $userpassword);
if($useremail!='' && $userpassword!=''){
$sql1 = mysqli_query($link,"SELECT * FROM `admin_login` WHERE `email`='$useremail' AND `password`='$password' AND `status`='1'");
$check_status = mysqli_num_rows($sql1);
if($check_status > 0) {
  $sql1 =mysqli_query($link,"SELECT `name`,`token` FROM `admin_login` WHERE `email`='$useremail' AND `password`='$password' AND `status`='1'");
  $row = mysqli_fetch_array($sql1);
  $obj1 = new stdclass;
  $obj1->name = $row['name'];
  $obj1->token = $row['token'];

        $obj->code=201; 
        $obj->message='Login Successfully';
        $obj->title='Success';
        $token = $row['token'];
        setcookie("token_admin_dashboard_development", $token, time() + (86400 * 30), "/");
        $obj->data = $obj1;
    }
    else {
        $obj->code=400; 
        $obj->message='Invalid Data';
        $obj->title='failure';
    }
}
else {
    $obj->code=400; 
    $obj->message='Enter Vaild Data';
    $obj->title='Failure';
}

echo json_encode($obj);
?>