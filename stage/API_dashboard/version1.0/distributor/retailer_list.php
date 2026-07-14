<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// session_start();
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/database.php';
include_once '../objects/retailer_distributor.php';
include_once '../config/core_distributor.php';
$input_data = json_decode(file_get_contents("php://input"));
if ($input_data->dashboard_code == $verification_code) {
    $distributor_token = $input_data->distributor_token;
    $database = new Database();
    $db = $database->getConnection();
    $retailer = new Retailer($db);
    $obj = new stdClass;
    $retailer->distributor_token = $distributor_token;
    if ($input_data->type == "count") {
        $stmt = $retailer->retailerDetail();
        $num = $stmt->rowCount();
        $obj->status_code = 200;
        $obj->header = "Success";
        $obj->message = "Retailer Detail Page Count";
        $obj->data = $num;
    } else if ($input_data->type == "single_retailer") {
        $_SESSION["retailer_token"] = $input_data->retailer_token;
        $_SESSION["particular_shop_redirect"] = $input_data->particular_shop_redirect;
        $retailer->token = $input_data->retailer_token;
        $data = $retailer->singleRetailer();
        $obj->status_code = 200;
        $obj->header = "Success";
        $obj->message = "single retailer detail";
        $obj->data = $data;
    } else if ($input_data->type == "shopStatusChange") {
        $retailer->shop_token = $input_data->shop_token;
        $stmt = $retailer->shopCheckToken();
        $checkCount = $stmt->rowCount();
        if ($checkCount == 1) {
            $retailer->shop_show_status = $input_data->shop_show_status;
            if ($retailer->shopStatusUpdate()) {

                $retailer->shop_token = $input_data->shop_token;
                $retailer->distributor_token = $input_data->distributor_token;
                $retailer->shop_mapping_status = $input_data->shop_mapping_status;

                $retailer->shopMappingStatusUpdate();

                $obj->status_code = 200;
                $obj->header = "Success";
                $obj->message = "shop status updated";
            } else {
                $obj->status_code = 400;
                $obj->header = "Error";
                $obj->message = "shop status not updated";
            }
        } else {
            $obj->status_code = 400;
            $obj->header = "Error";
            $obj->message = "shop token incorrect";
        }
    } else if ($input_data->type == "unit_List") {
        $stmt = $retailer->selectUnitList();
        $data = $retailer->readUnitList($stmt);
        $obj->status_code = 200;
        $obj->header = "Success";
        $obj->message = "single retailer detail";
        $obj->data = $data;
    } else if ($input_data->type == "shop_redirect_status") {
        $_SESSION["particular_shop_redirect"] = $input_data->particular_shop_redirect;
        $_SESSION["is_redirect_retailer_sub_page"] = $input_data->is_redirect_retailer_sub_page;
    } else if ($input_data->type == "shop_back_view_retailer") {
        $_SESSION["particular_shop_redirect"] = $input_data->particular_shop_redirect;
    } else if ($input_data->type == "is_mobNo_exist") {
        $retailer->mobile_number = $input_data->contact_number;
        $stmt = $retailer->isMobileNoExistUnderDistributor();
        if ($stmt->rowCount() > 0) {
            $obj->status_code = 400;
            $obj->header = "Error";
            $obj->message = "Mobile Number already exist!";
        } else {
            $obj->status_code = 200;
            $obj->header = "Success";
            $obj->message = "Success";
        }
    } else if ($input_data->type == "token") {
        $_SESSION["retailer_token"] = $input_data->token;
        $_SESSION["unitToken"]=$input_data->unitToken;
    } else {
        $obj->status_code = 400;
        $obj->header = "Oops";
        $obj->message = "No Retailer List Detail count";
    }
    echo json_encode($obj);
}
