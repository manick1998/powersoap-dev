<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include '../db_connection/db_conn.php';
include "../../../config.php";
include '../retailer_object/retailer_home_page.php';
$database = new Database();
$db = $database->getConnection();
$retailer_home_page =new home_page($db);
$input = json_decode(file_get_contents("php://input"));
$token  = genToken('status_token','support_table');
$current = $indiaDateTime;


$shop_token = $input->shop_token;
$retailer_home_page->shop_token=$shop_token;
$description = $input->description;
$retailer_home_page->description = $description;
$attach = $input->attach;
$retailer_home_page->attach = $attach;

$sql = mysqli_query($link,"SELECT `name`,`mobile_number` from `shop` WHERE `token`='$shop_token'");
while($row = mysqli_fetch_array($sql)){
$name = $row['name'];
$mobile_number = $row['mobile_number'];
}
if($shop_token!=""&& $description!=""){
$insert_support = mysqli_query($link,"INSERT INTO `support_table`(
    `status_token`,
    `emp_token`,
    `name`,
    `mobile_number`,
    `deparment_token`,
    `description`,
    `attachment`,
    `status_code`,
    `date_time`
)
VALUES('$token','$shop_token','$name','$mobile_number','98765432','$description','$attach','0','$current')");
}
$obj = new stdClass;
if($insert_support){
    $obj->status_code=200; 
    $obj->message='Data Inserted';
    $obj->title='Success';
    
} else {
    $obj->status_code=400; 
    $obj->message='error';
    $obj->title='failure';
    
}



    echo json_encode($obj);
?>