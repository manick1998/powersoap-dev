<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include '../db_connection/db_conn.php';
include '../retailer_object/retailer_login.php';
include '../../../config.php';

$database = new Database();
$db = $database->getConnection();
$retailer =new retailer($db);
$input = json_decode(file_get_contents("php://input"));
$mobile = $input->phone_number;
$retailer->mobile = $mobile;
$stmt=$retailer->login();
$count = $stmt->rowCount();
$obj = new stdClass();
$array =[];
if($count > 0) {
    
    $password1 = 123;
    $password2 ='shop';
    $password3=$password2.'@'.$password1;
    $password = hash('sha512', $password3);
  
    $update = mysqli_query($link,"UPDATE `shop` SET `password`='$password' WHERE `mobile_number`='$mobile'");
    $password4=$input->passwords;
    $password5 = hash('sha512', $password4);
    $password_check = mysqli_query($link,"SELECT `id` FROM `shop` WHERE `password`='$password5'");
    $password_count = mysqli_num_rows($password_check);
   if($password_count>0){
      $query = mysqli_query($link,"SELECT
      shop.`id`
  FROM
      `shop`
  INNER JOIN shop_mapping ON shop.token = shop_mapping.shop_token
  WHERE
      `mobile_number` = '$mobile' AND `password` = '$password5' AND shop_mapping.status = '1'");
      $result = mysqli_num_rows($query);
      if($result > 0){
      $query1 = mysqli_query($link,"SELECT
      COALESCE(`shop`.`token`, 0) AS `shop_token`,
      COALESCE(`shop`.`mobile_number`, 0) AS `mobile_number`
  FROM
      `shop`
  INNER JOIN shop_mapping ON shop.token = shop_mapping.shop_token
  WHERE
      `shop`.`mobile_number` = '$mobile' AND `shop`.`shop_show_status` = 'Active' AND NOT shop_mapping.status = '0'");
       $row = mysqli_fetch_array($query1);
            $obj_emp=new stdClass;
            $obj_emp->shop_token=$row['shop_token'];
            $obj_emp->mobile_number=$row['mobile_number'];
        $obj->status_code=200; 
        $obj->message='Login successfully';
        $obj->title='Success';
        $obj->data = $obj_emp;
    }
    else {
        $obj->status_code=400; 
        $obj->message='Shop Under Process';
        $obj->title='failure';
    }
}else{
    $obj->status_code=400; 
    $obj->message='Password Incorrect';
    $obj->title='Failure';
}
}
else {
    $obj->status_code=400; 
    $obj->message='Mobile number not exist';
    $obj->title='Failure';
}

 echo json_encode($obj);


?>