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
    $inventory->productCode = $inputData->product_code;
    $inventory->admin_token = $inputData->admin_token;
    $token                    = $inventory->tokenGenerate();
    $inventory->token         = $token;
    $inventory->productName   = $inputData->product_name;
    $inventory->productWeight = $inputData->product_weight;
    $inventory->productMrp    = $inputData->product_mrp;
    $inventory->productGst    = $inputData->product_gst;
    $inventory->productBatchNumber = $inputData->product_batch_number;
    $inventory->productLocation    = $inputData->product_location;
    $inventory->productTotalCost   = $inputData->product_total_cost;
    $inventory->productDescription = $inputData->product_description;
    $inventory->productImage       = $inputData->product_image;
    $inventory->productType        = $inputData->product_type;
    $inventory->productPieceCount  = $inputData->product_piece_count;
    $inventory->retailerPrice  = $inputData->retailer_price;
    $inventory->name_short = $inputData->product_name_shortform;
    $inventory->hsn_code = $inputData->product_hsnCode;
    $stmt = $inventory->addProductCheck();
    $checkCount = $stmt->rowCount();
    if ($checkCount == 0) {
        if ($inventory->addProduct($indiaDateTime)) {
            $log = $inventory->addProductLog($indiaDateTime);
            if ($inventory->addDistributorStockInHand()) {
                $inventory->insertStockAdd($indiaDateTime);
                $inventory->insertStockReportsNew($token, $indiaDate);
                $obj->code = 201;
                $obj->message = $inventory->productType;
            }
        }
    } else {
        $obj->code = 503;
        $obj->message = "Product code already exist!";
    }
    echo json_encode($obj);
    $db = null;
}
