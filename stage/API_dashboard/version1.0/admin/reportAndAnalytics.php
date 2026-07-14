<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/database.php';
include_once '../objects/report_dashboard.php';
include_once '../config/core.php';
$input_data = json_decode(file_get_contents("php://input"));
if($input_data->dashboard_code == $verification_code){
    $database = new Database();
    $db = $database->getConnection();
    $obj = new stdClass;
    $report = new Report($db);
    
    // Global Date Filter
    if(!empty($input_data->from_date)){
        $report->fromDate = date("Y-m-d 00:00:00", strtotime($input_data->from_date));
    }
    if(!empty($input_data->to_date)){
        $report->toDate = date("Y-m-d 23:59:59", strtotime($input_data->to_date));
    }

    if($input_data->type == "dashboard_summary"){
        $obj = $report->getDashboardSummary();
        $obj->status_code = 200;
    }else if($input_data->type == "admin_overview_stats"){
        $obj->stats = $report->getAdminOverviewStats();
        $obj->status_code = 200;
    }else if($input_data->type == "box_data"){
        $obj->box_Data = $report->getReportDetailsForAdmin();
        $obj->status_code = 200;
    }else if($input_data->type == "pie_chart"){
        $unitSt = $report->unitSaleForAdmin();
        $unit_data = $report->readUnitSaleForAdmin($unitSt);
        $obj->unit_names = array_column($unit_data, 'unit_name');
        $obj->unit_sales = array_column($unit_data, 'unit_sales');
        $obj->random_color = array_column($unit_data, 'random_color');
        $obj->status_code = 200;
    }else if($input_data->type == "top_distributor"){
        $distSt = $report->top10Distributor();
        $obj->dist_Data = $report->readTop10Distributor($distSt);
        $obj->status_code = 200;
    }else if($input_data->type == "top_selling"){
        $productSt = $report->top10SellingProductForAmin();
        $obj->top_product_Data = $report->readTop10SellingProductForAmin($productSt);
        $obj->status_code = 200;
    }else if($input_data->type == "bot_selling"){
        $productSt1 = $report->bottom10SellingProductForAmin();
        $obj->bottom_product_Data = $report->readbottom10SellingProductForAmin($productSt1);
        $obj->status_code = 200;
    }else if($input_data->type == "date_range_distributor"){
        $from_date            = $input_data->from_date;
        $report->fromDate   = date("Y-m-d 00:00:00", strtotime($from_date));
        $to_date              = $input_data->to_date;
        $report->toDate     = date("Y-m-d 23:59:59", strtotime($to_date));
        $stmt=$report->top10DistributorDateRange();
        $checkCount = $stmt->rowCount();
        if($checkCount==0){
            $obj->code=503;
            $obj->data=[];
        }else{
            $obj->code = 201;
            $obj->dist_Data = $report->readTop10Distributor($stmt);
        } 
    }else if($input_data->type == "date_range_top_sell"){
        $from_date            = $input_data->from_date;
        $report->fromDate   = date("Y-m-d 00:00:00", strtotime($from_date));
        $to_date              = $input_data->to_date;
        $report->toDate     = date("Y-m-d 23:59:59", strtotime($to_date));
        $stmt=$report->top10SellingProductForAminDateRange();
        $checkCount = $stmt->rowCount();
        if($checkCount==0){
            $obj->code=503;
            $obj->data=[];
        }else{
            $obj->code = 201;
            $obj->top_product_Data = $report->readTop10SellingProductForAmin($stmt);
        } 
    }else if($input_data->type == "date_range_bot_sell"){
        $from_date            = $input_data->from_date;
        $report->fromDate   = date("Y-m-d 00:00:00", strtotime($from_date));
        $to_date              = $input_data->to_date;
        $report->toDate     = date("Y-m-d 23:59:59", strtotime($to_date));
        $stmt=$report->bottom10SellingProductForAminDateRange();
        $checkCount = $stmt->rowCount();
        if($checkCount==0){
            $obj->code=503;
            $obj->data=[];
        }else{
            $obj->code = 201;
            $obj->bottom_product_Data = $report->readbottom10SellingProductForAmin($stmt);
        } 
    }
       
echo json_encode($obj);
$db = null;

}

?>
