<?php
$obj = new stdClass();
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
if ($inputData->dashboard_code == $verification_code) {
    include_once '../objects/inventory.php';
    $inventory = new Inventory($db);
    if ($inputData->type == "all") {
        $stmt = $inventory->productCheck();
        $checkCount = $stmt->rowCount();
        if ($checkCount == 0) {
            $obj->code = 503;
            $obj->data = [];
        } else {
            $obj->code = 201;
            $obj->data = $inventory->readProduct($stmt);
        }
    } else if ($inputData->type == "single_product") {
        $inventory->productToken  = $inputData->product_token;
        $stmt = $inventory->singleProductCheck();
        $checkCount = $stmt->rowCount();
        if ($checkCount == 0) {
            $obj->code = 503;
            $obj->data = [];
        } else {
            $obj->code = 201;
            $obj->data = $inventory->readSingleProduct($stmt);
        }
    } else if ($inputData->type == "count_check") {
        $inventory->searchQuery  = "";
        $stmt = $inventory->serverProductCheckfilter();
        $stmt1 = $inventory->activeproductcount();
        $obj->activeprod_count = $stmt1->rowCount();
        $obj->Count = $stmt->rowCount();
    } else if ($inputData->type == "productStatusChange") {
        $inventory->productToken = $inputData->product_token;
        $inventory->admin_token = $inputData->admin_token;
        $stmt1 = $inventory->fetchDetail();
        $data = $inventory->readfetchDetail($stmt1);
        $inventory->productname = $data[0]->product_name;
        $inventory->itemcode = $data[0]->item_code;
        $inventory->netweight = $data[0]->net_weight;
        $inventory->old_mrp = $data[0]->mrp;
        $inventory->totalcost = $data[0]->total_cost;
        $inventory->piececount = $data[0]->piece_count;
        $stmt = $inventory->productCheckToken();
        $checkCount = $stmt->rowCount();
        if ($checkCount == 1) {
            $inventory->statusValue = $inputData->product_status;
            $inventory->productStatusUpdate();
            $inventory->deleteProductLog($indiaDateTime);
        }
        $obj->code = 201;
        $obj->message = "Success";
    } else if ($inputData->type == "AddSchemeForProduct") {
        $token = token_generate("products__scheme", "token");
        $inventory->token = $token;
        $inventory->product_token = $inputData->product_token;
        $inventory->product_name = $inputData->product_name;
        $inventory->differproducttoken = $inputData->differproducttoken;
        $inventory->differentproductname = $inputData->differentproductname;
        $inventory->additional_offer = $inputData->additional_offer;
        $inventory->scheme_name = $inputData->scheme_name;
        $inventory->buy_product_box = $inputData->buy_product_box;
        $inventory->get_product_box = $inputData->get_product_box;
        $inventory->from_Date   = date("Y-m-d H:i:s", strtotime($inputData->from_Date));
        $inventory->to_Date   = date("Y-m-d H:i:s", strtotime($inputData->to_Date));
        $inventory->scheme_image = $inputData->scheme_image;
        if ($inventory->addProductScheme($indiaDateTime)) {
            if ($inputData->product_token == $inputData->differproducttoken) {
                //$inventory->schemeSameMsg($inputData->product_name, $inputData->buy_product_box, $inputData->get_product_box);
            } else {
                //$inventory->schemedifferMsg($inputData->product_name, $inputData->buy_product_box, $inputData->get_product_box, $inputData->differentproductname);
            }
            $obj->code = 201;
            $obj->message = "Success";
        } else {
            $obj->code = 503;
            $obj->message = "Error";
        }
    } else if ($inputData->type == "ViewAddedScheme") {
        $inventory->product_token = $inputData->product_token;
        $stmt = $inventory->readProductDetails();
        $data = $inventory->readProductDetailsData($stmt);
        $obj->code = 201;
        $obj->message = "Success";
        $obj->data = $data;
    }
    // else if($inputData->type == "deactivate_scheme"){
    //     $inventory->product_token = $inputData->product_token;
    //     if($inventory->deactivate_scheme()){
    //         $obj->code=201;
    //         $obj->message = "Deactivated";
    //     }else{
    //         $obj->code=503;
    //         $obj->message = "Error";
    //    }
    // }
    echo json_encode($obj);
    $db = null;
}
