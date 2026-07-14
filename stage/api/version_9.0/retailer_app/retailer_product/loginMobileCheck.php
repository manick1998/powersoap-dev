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
$mobile = $input->mobile_number;
$retailer->mobile = $mobile;
$stmt=$retailer->login();
$count = $stmt->rowCount();
$obj = new stdClass();
if($count > 0) {
    $result=mysqli_query($link,"SELECT
    COALESCE(`shop`.`token`,0) as `shop_token`,
    COALESCE(`shop`.`retail_code`,0) as `shop_code`,
    COALESCE(`shop`.`mobile_number`,0) as `mobile_number`
FROM
    `shop`
WHERE
    `shop`.`mobile_number` = '$mobile'   AND `password`!='' AND `shop`.`shop_show_status`='Active' GROUP BY `shop`.`token`");
    $count1 = mysqli_num_rows($result);
    if($count1 > 0){
        // $row1 = mysqli_fetch_array($result);
        // $obj2 = new stdClass();
        // $obj2->token = $row1['shop_token'];
        // $obj2->shop_code = $row1['shop_code'];
        // $obj2->mobile_number = $row1['mobile_number'];
        $obj->status_code=200; 
        $obj->message='Login successfully';
        $obj->title='Success';
        //$obj->data = $obj2;
}else{
        $obj->status_code=200; 
        $obj->message='Create Password';
        $obj->title='Success';
        //$obj->data = [];
 }
}else{
    $obj->status_code=400; 
    $obj->message='Dont have an account ? Register Now';
    $obj->title='Failure';
}

 echo json_encode($obj);

 ?>
