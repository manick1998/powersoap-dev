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
    $token = $inputData->product_token;
    $inventory->token       = $token;
    $inventory->admin_token       = $inputData->admin_token;
    $inventory->productCode = $inputData->product_code;
    $category = $inventory->check($token);
    $check = $inventory->editProductCheck();
    if ($check) {
        $inventory->productName   = $inputData->product_name;
        $inventory->productWeight = $inputData->product_weight;
        $inventory->productMrp    = $inputData->product_mrp;
        $inventory->productGst    = $inputData->product_gst;
        $inventory->productBatchNumber = $inputData->product_batch_number;
        $inventory->productLocation    = $inputData->product_location;
        $inventory->productTotalCost   = $inputData->product_total_cost;
        $inventory->productDescription = $inputData->product_description;
        $inventory->product_name_short = $inputData->product_name_short;
        $inventory->hsn_code = $inputData->product_hsnCode;
        $inventory->productImage       = $inputData->product_image;
        if ($category == $inputData->product_type) {
            $inventory->productType        = $inputData->product_type;
        } else {
            $inventory->changeStatus($token, $category);
            $inventory->productType        = $inputData->product_type;
        }

        $inventory->productPieceCount  = $inputData->product_piece_count;
        $inventory->retailerPrice = $inputData->retailer_price;
        $stmt = $inventory->fetchDetails();
        $data = $inventory->readfetchDetails($stmt);
        $inventory->productname = $data[0]->product_name;
        $inventory->itemcode = $data[0]->item_code;
        $inventory->netweight = $data[0]->net_weight;
        $inventory->old_mrp = $data[0]->mrp;
        $inventory->totalcost = $data[0]->total_cost;
        $inventory->piececount = $data[0]->piece_count;
        $insert = $inventory->updateProduct();
        if ($data[0]->product_name != $inputData->product_name || $data[0]->item_code != $inputData->product_code || $data[0]->net_weight != $inputData->product_weight || $data[0]->mrp != $inputData->product_mrp || $data[0]->total_cost != $inputData->product_total_cost || $data[0]->piece_count != $inputData->product_piece_count) {
            $logupdate = $inventory->updateProductLog($indiaDateTime);
        }
        $obj->code = 201;
        $obj->message = "success";
    } else {
        $obj->code = 503;
        $obj->message = "Product code already exist!";
    }
    echo json_encode($obj);
}
