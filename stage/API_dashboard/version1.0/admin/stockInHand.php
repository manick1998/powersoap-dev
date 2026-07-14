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
        $stmt = $inventory->stockCheckCount();
        $checkCount = $stmt->rowCount();
        $obj->code = 201;
        $obj->data = $checkCount; //$inventory->readStock($stmt);
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
    } else if ($inputData->type = "updateStocks") {
        $inventory->stocks = $inputData->stocks;
        $inventory->mfscount = $inputData->mfscount;
        $inventory->token = $inputData->token;
        $inventory->distributor_token = $inputData->distributor_token;
        $stmt = $inventory->updatestocksDistributor();
        if ($stmt) {
            $obj->code   = 201;
            $obj->message = "Success";
        } else {
            $obj->code   = 400;
            $obj->message = "data not inserted";
        }
    }
    echo json_encode($obj);
}
