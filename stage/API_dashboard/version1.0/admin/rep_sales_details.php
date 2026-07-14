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
$date = date("Y-m-d");

if ($data->type == "sales_details") {
    $emp->rep_token = $data->rep_token;
    
    // Fetch employee basic info
    $func = $emp->rep_sales_details($date);
    $emp_data = $emp->rep_sales_details_read($func);
    
    // Fetch order statistics separately
    $stats_func = $emp->rep_sales_orders_stats($date);
    $stats_data = $emp->rep_sales_orders_stats_read($stats_func);
    
    // Combine employee info with order stats
    $data_arr = [];
    if (!empty($emp_data)) {
        $combined = $emp_data[0]; // Get first (and only) employee record
        $combined->shop_count = $stats_data->shop_count;
        $combined->total_amount = $stats_data->total_amount;
        $data_arr = [$combined];
    } else {
        // Return empty structure if no data
        $empty_obj = new stdClass;
        $empty_obj->employe_token = "-";
        $empty_obj->mobile_number = "-";
        $empty_obj->shop_count = "0";
        $empty_obj->total_amount = "0";
        $data_arr = [$empty_obj];
    }
    
    // Fetch total shops
    $total_shop = $emp->total_number_shop($date);
    $total_shop_read = $emp->total_number_shop_read($total_shop);
    
    // Fetch orders taken
    $total_shop_order_taken = $emp->total_taken_shop_order($date);
    $order_taken_total = $emp->total_taken_shop_order_read($total_shop_order_taken);
    
    // Fetch no orders
    $total_take_order_no_order = $emp->take_order_no_order($date);
    $total_take_order_no_order_read = $emp->take_order_no_order_read($total_take_order_no_order);
    
    $obj->status_code = '200';
    $obj->message = 'success';
    $obj->deatils = $data_arr;
    $obj->total_shop_read = !empty($total_shop_read) ? $total_shop_read : [["total_shop_count" => "0"]];
    $obj->order_taken_total = !empty($order_taken_total) ? $order_taken_total : [["total_shop_order" => "0"]];
    $obj->total_take_order_no_order_read = !empty($total_take_order_no_order_read) ? $total_take_order_no_order_read : [["type_count" => "0"]];
    
} elseif ($data->type == "allocate_distributor") {
    $emp->rep_token = $data->rep_token;
    
    // Fetch distributor details
    $distributor = $emp->allocted_distributor($date);
    $distributor1 = $emp->allocted_distributor_area($date);
    $distributor2 = $emp->allocted_distributor_state($date);
    
    $distributor_details = [];
    $distributor_details1 = [];
    $distributor_details2 = [];
    
    if ($distributor->rowCount() > 0) {
        $distributor_details = $emp->allocted_distributor_read($distributor);
    } else {
        $distributor_details = [["distributor_name" => "-"]];
    }
    
    if ($distributor1->rowCount() > 0) {
        $distributor_details1 = $emp->allocted_distributor_area_read($distributor1);
    } else {
        $distributor_details1 = [["area_name" => "-"]];
    }
    
    if ($distributor2->rowCount() > 0) {
        $distributor_details2 = $emp->allocted_distributor_state_read($distributor2);
    } else {
        $distributor_details2 = [["region_name" => "-"]];
    }
    
    $obj->status_code = '200';
    $obj->message = 'success';
    $obj->distributor_data = $distributor_details;
    $obj->distributor_data1 = $distributor_details1;
    $obj->distributor_data2 = $distributor_details2;
}

echo json_encode($obj);
$db = null;

?>