<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/database.php';
include_once '../objects/report_dashboard.php';
include_once '../config/core_distributor.php';
$input_data = json_decode(file_get_contents("php://input"));
if($input_data->dashboard_code == $verification_code){
        $database = new Database();
        $db = $database->getConnection();
        $obj = new stdClass;
        $report = new Report($db);
        $report->distributor_token = $input_data->distributor_token;
    if($input_data->type == "all"){
        $box_data = $report->getReportDetails();
        //Top Sale by Unit
        $report->distributor_token = $input_data->distributor_token;
        $unitSt = $report->unitSale();
        $unit_data = $report->readUnitSale($unitSt);
        $unit_names = array_column($unit_data, 'unit_name');
        $unit_sales = array_column($unit_data, 'unit_sales');
        $random_color = array_column($unit_data, 'random_color');
        $obj->unit_names = $unit_names;
        $obj->unit_sales = $unit_sales;
        $obj->random_color = $random_color;
        $pro_Cat = $report->getProductCategory();
        $year = date("Y");
        $report->cur_year = $year;
        $categorySt = $report->categorySale();
        $month = $report->monthAndYearofCategory($categorySt);
        $outer_array=[];
        for($i=0; $i<count($pro_Cat); $i++){
            $categorySt = $report->categorySale();
            $productData = $report->readProductCategory($categorySt, $pro_Cat[$i]["token"]);
            array_push($outer_array, $productData);
        } 
        // echo json_encode($pro_Cat);
       
        //Top 10 shop in purchasing product
        $shopSt = $report->top10ShopUnderDistributor();
        $shop_data = $report->readTop10ShopUnderDistributor($shopSt);
        //Top 10 Selling Product
        $productSt = $report->top10SellingProduct();
        $top_product_data = $report->readTop10SellingProduct($productSt);
        //Bottom 10  Selling Product
        $productSt1 = $report->bottom10SellingProduct();
        $bottom_product_data = $report->readbottom10SellingProduct($productSt1);
        $obj->box_Data = $box_data;
        $obj->unit_Data = $unit_data;
        $obj->Category_array = $outer_array;
        $obj->Category_month = $month;
        $obj->shop_Data = $shop_data;
        $obj->top_product_Data = $top_product_data;
        $obj->bottom_product_Data = $bottom_product_data;
        $obj->status_code = 200;
        $obj->header = "Success";
        $obj->message = "Report List";
    }else if($input_data->type == "date_range_shop"){
        $from_date            = $input_data->from_date;
        $report->fromDate   = date("Y-m-d 00:00:00", strtotime($from_date));
        $to_date              = $input_data->to_date;
        $report->toDate     = date("Y-m-d 23:59:59", strtotime($to_date));
        $stmt=$report->top10ShopUnderDistributorDateFilter();
        $checkCount = $stmt->rowCount();
        if($checkCount==0){
            $obj->code=503;
            $obj->data=[];
        }else{
            $obj->code = 201;
            $obj->shop_Data = $report->readTop10ShopUnderDistributor($stmt);
        } 
    }else if($input_data->type == "date_range_top_sell"){
        $from_date            = $input_data->from_date;
        $report->fromDate   = date("Y-m-d 00:00:00", strtotime($from_date));
        $to_date              = $input_data->to_date;
        $report->toDate     = date("Y-m-d 23:59:59", strtotime($to_date));
        $stmt=$report->top10SellingProductDateFilter();
        $checkCount = $stmt->rowCount();
        if($checkCount==0){
            $obj->code=503;
            $obj->data=[];
        }else{
            $obj->code = 201;
            $obj->top_product_Data = $report->readTop10SellingProduct($stmt);
        } 
    }else if($input_data->type == "date_range_bot_sell"){
        $from_date            = $input_data->from_date;
        $report->fromDate   = date("Y-m-d 00:00:00", strtotime($from_date));
        $to_date              = $input_data->to_date;
        $report->toDate     = date("Y-m-d 23:59:59", strtotime($to_date));
        $stmt=$report->bottom10SellingProductDateFilter();
        $checkCount = $stmt->rowCount();
        if($checkCount==0){
            $obj->code=503;
            $obj->data=[];
        }else{
            $obj->code = 201;
            $obj->bottom_product_Data = $report->readbottom10SellingProduct($stmt);
        } 
    }
       
echo json_encode($obj);   
}

?>
