<?php 
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/database.php';
include_once '../objects/retailer.php';
$data = json_decode(file_get_contents("php://input"));
$database = new Database();
$db = $database->getConnection();
$Retailer = new Retailer($db);
$obj = new stdClass;
date_default_timezone_set('Asia/Kolkata');
//$beforemin =  strtotime(-30 minutes);
$beforemin = date('Y-m-d H:i',strtotime('-30 minutes'));
// echo 'beforemin',$beforemin;
$date = date('Y-m-d H:i',strtotime('now'));
// echo  $date;
 if ($data->type == "all_shop") {
        $Retailer->distributor_token = $data->distributor_token;
        $stmt = $Retailer->rep_add_shops();
        if ($stmt->rowCount() > 0) {
            $shop_data = $Retailer->rep_add_shops_read($stmt);
            $obj->status_code = '200';
            $obj->message = 'data_found';
            $obj->get_shop_data = $shop_data;
        }else{
            $obj->status_code = '400';
            $obj->message = 'data not found';
        }
 }elseif ($data->type == "status_update"){
    $Retailer->shop_status = $data->shop_status;
    $Retailer->distributor_token = $data->distributor_token;
    $Retailer->shop_token = $data->shop_token;
    if ($Retailer->status_update()) {
        $obj->status_code = '200';
        $obj->message = 'updated successfully';
    } 
    else{
        $obj->status_code = '400';
        $obj->message = 'something error';
    }
 }
   
// }elseif ($data->type == "particulor_rep_latlang") {
   
// }elseif ($data->type == "shop_latlang") {
   
// }elseif($data->type == "particular_state_latlang"){
  

// }elseif($data->type == 'lat_lang_date_and_time'){
      
// }
echo json_encode($obj);
?>