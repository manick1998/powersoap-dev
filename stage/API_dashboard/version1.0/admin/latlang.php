<?php 

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/database.php';
include_once '../objects/employee.php';
$data = json_decode(file_get_contents("php://input"));
$database = new Database();
$db = $database->getConnection();
$emp = new Employee($db);
$obj = new stdClass;
date_default_timezone_set('Asia/Kolkata');
//$beforemin =  strtotime(-30 minutes);
$beforemin = date('Y-m-d H:i:s',strtotime('-30 minutes'));
 //echo 'beforemin',$beforemin;
$date = date('Y-m-d H:i:s',strtotime('now'));
 //echo  $date;
// Set default response
$obj->status_code = 400;
$obj->header = "Error";
$obj->message = "Invalid request type";
$obj->data = []; // Default data key

switch ($data->type) {
    case "all_sales_rep_latlong":
        $func = $emp->all_latlag($date, $beforemin);
        if ($func->rowCount() > 0) {
            $obj->status_code = 200;
            $obj->header = "Success";
            $obj->message = "Data listed";
            $obj->data = $emp->all_latlag_read($func);
        } else {
            $obj->message = "No data found";
        }
        break;

    case "particulor_rep_latlang":
        $emp->rep_schedule_token = $data->rep_schedule_token;
        $emp->rep_token = $data->rep_token;
        $stmt = $emp->particulor_rep_latlang();
        $obj->data1 = []; // Initialize specific key
        if ($stmt->rowCount() > 0) {
            $obj->status_code = 200;
            $obj->header = "Success";
            $obj->message = "rep latlang listed";
            $obj->data1 = $emp->read_particulor_rep_latlang($stmt);
        } else {
            $obj->message = "No rep latlang found";
        }
        break;

    case "shop_latlang":
        $date1 = date('Y-m-d');
        $emp->rep_token = $data->rep_token;
        $stmt1 = $emp->shops_latlang($date1);
        $obj->rep_shop_lat_data = []; // Initialize specific key
        if ($stmt1->rowCount() > 0) {
            $obj->status_code = 200;
            $obj->header = "Success";
            $obj->message = "rep shop latlang listed";
            $obj->rep_shop_lat_data = $emp->read_shops_latlang($stmt1);
        } else {
            $obj->message = "No shop latlang found";
        }
        break;

    case "particular_state_latlang":
        $emp->state_token = $data->state_token;
        $stmt_state = $emp->particulare_state_salesrep_latlang($date, $beforemin);
        $obj->stmt_state_lat_data = []; // Initialize specific key
        if ($stmt_state->rowCount() > 0) {
            $obj->status_code = 200;
            $obj->header = "Success";
            $obj->message = "particular state latlang listed";
            $obj->stmt_state_lat_data = $emp->particulare_state_salesrep_latlang_read($stmt_state);
        } else {
            $obj->message = "No state latlang found";
        }
        break;

    case "lat_lang_date_and_time":
        $emp->lat = $data->lat;
        $emp->lang = $data->lang;
        $today = date('Y-m-d');
        $stmt_lat_lang = $emp->data_latlang($today);
        $obj->read_date_lang = []; // Initialize specific key
        if ($stmt_lat_lang->rowCount() > 0) {
            $obj->status_code = 200;
            $obj->header = "Success";
            $obj->message = "particular data latlang listed";
            $obj->read_date_lang = $emp->read_date_latlang($stmt_lat_lang);
        } else {
            $obj->message = "No date latlang found";
        }
        break;

    case "rep_name":
        $emp->rep_token = $data->rep_token;
        $stmt = $emp->particulor_rep_name();
        $obj->name_data1 = []; // Initialize specific key
        if ($stmt->rowCount() > 0) {
            $obj->status_code = 200;
            $obj->header = "Success";
            $obj->message = "rep name listed";
            $obj->name_data1 = $emp->read_particulor_name($stmt);
        } else {
            $obj->message = "No rep name found";
        }
        break;
}
echo json_encode($obj);
?>