<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/database.php';
include_once '../objects/offers.php';
$input_data = json_decode(file_get_contents("php://input"));
date_default_timezone_set('Asia/Kolkata');
$currentDate  = date("Y-m-d H:i:s");
$database = new Database();
$db = $database->getConnection();
$offers = new Offers($db);
$obj = new stdClass;
if ($input_data->type == "offer_log") {
    $stmt = $offers->offerLog();
    $data = $offers->readofferLog($stmt);
    $count = $stmt->rowCount();
    if ($count>0) {
        $obj-> code ='200';
        $obj->message = 'data founded';
        $obj->data = $data;
    }else{
        $obj-> code ='404';
        $obj->message = 'data not founded';
        $obj->data =[];
    }
}elseif($input_data->type == "salesrep_log") {
    $stmt = $offers->salesrepLog();
    $data = $offers->readsalesrepLog($stmt);
    $count = $stmt->rowCount();
    if ($count>0) {
        $obj-> code ='200';
        $obj->message = 'data founded';
        $obj->data = $data;
    }else{
        $obj-> code ='404';
        $obj->message = 'data not founded';
        $obj->data =[];
    }
}elseif($input_data->type == "product_log") {
    $stmt = $offers->productLog();
    $data = $offers->readproductLog($stmt);
    $count = $stmt->rowCount();
    if ($count>0) {
        $obj-> code ='200';
        $obj->message = 'data founded';
        $obj->data = $data;
    }else{
        $obj-> code ='404';
        $obj->message = 'data not founded';
        $obj->data =[];
    }
}elseif($input_data->type == "leave_log") {
    $stmt = $offers->leaveLog();
    $data = $offers->readleaveLog($stmt);
    $count = $stmt->rowCount();
    if ($count>0) {
        $obj-> code ='200';
        $obj->message = 'data founded';
        $obj->data = $data;
    }else{
        $obj-> code ='404';
        $obj->message = 'data not founded';
        $obj->data =[];
    }
}elseif($input_data->type == "division_log") {
    $stmt = $offers->divisionLog();
    $data = $offers->readdivisionLog($stmt);
    $count = $stmt->rowCount();
    if ($count>0) {
        $obj-> code ='200';
        $obj->message = 'data founded';
        $obj->data = $data;
    }else{
        $obj-> code ='404';
        $obj->message = 'data not founded';
        $obj->data =[];
    }
}elseif($input_data->type == "schedule_log") {
    $stmt = $offers->scheduleLog();
    $data = $offers->readscheduleLog($stmt);
    $count = $stmt->rowCount();
    if ($count>0) {
        $obj-> code ='200';
        $obj->message = 'data founded';
        $obj->data = $data;
    }else{
        $obj-> code ='404';
        $obj->message = 'data not founded';
        $obj->data =[];
    }
}elseif($input_data->type == "scheduleold_data") {
    $offers->salesReoToken = $input_data->salesReoToken;
    $offers->date = $input_data->date;
    $area_module = $offers->scheduleold_data();
    $areaToken =$offers->areaSelect();
    $areaValue=$offers->areaData($areaToken);
    $distToken =$offers->distSelect();
    $distValue=$offers->distData($distToken);
    $obj->code = 200;
    $obj->header = "Success";
    $obj->message = "data List";
    $obj->data = $area_module;
    $obj->datas = $areaValue;
    $obj->dataas = $distValue;
}elseif($input_data->type=="schedulenew_data") {
    $offers->salesReoToken = $input_data->salesReoToken;
    $offers->date = $input_data->date;
    $area = $offers->schedulenew_data();
    $areanew =$offers->areanewSelect();
    $areanewValue=$offers->areanewData($areanew);
    $distnewToken =$offers->distnewSelect();
    $distnewValue=$offers->distnewData($distnewToken);
    $obj->code = 200;
    $obj->header = "Success";
    $obj->message = "data List";
    $obj->data = $area;
    $obj->datas = $areanewValue;
    $obj->dataas = $distnewValue;
}elseif($input_data->type == "order_log") {
    $stmt = $offers->orderLog();
    $data = $offers->readorderLog($stmt);
    $count = $stmt->rowCount();
    if ($count>0) {
        $obj-> code ='200';
        $obj->message = 'data founded';
        $obj->data = $data;
    }else{
        $obj-> code ='404';
        $obj->message = 'data not founded';
        $obj->data =[];
    }
}
echo json_encode($obj);
?>