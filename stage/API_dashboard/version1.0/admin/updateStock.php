<?php
$obj = new stdClass();
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
$indiaDate     = date("Y-m-d");
// if($inputData->dashboard_code == $verification_code){
include_once '../objects/inventory.php';
$inventory = new Inventory($db);
$inventory->productToken  = $inputData->product_token;
$stmt = $inventory->singleProductCheck();
$checkCount = $stmt->rowCount();
if ($checkCount != 0) {
    $inventory->stockInHand  = $inputData->stock_in_hand;
    $stocktype = $inputData->stocktype;
    $inventory->beforestack  = $inputData->beforestack;
    $inventory->admin_token  = $inputData->admin_token;
    $stmt1 = $inventory->updateStockCheck($indiaDateTime);
    $check = $inventory->checkProductScheme($indiaDate);
    $count = $check->rowCount();
    if ($count > 0) {
        $oldstockSales = $inventory->oldStocksales($indiaDate);
        $oldstockopen = $inventory->oldStockOpen($indiaDate);
        $oldstockclose = $inventory->oldStockclose($indiaDate);
        if ($stocktype == 'add') {
            $opening = $inputData->stock_in_hand + $oldstockopen;
        } else {
            if ($inputData->stock_in_hand > $oldstockopen) {
                $update = 2;
                $opening = $inputData->stock_in_hand;
            } else {
                $opening =  abs($oldstockopen - $inputData->stock_in_hand);
            }
        }
        if ($oldstockclose < 0) {
            $closing = $oldstockclose;
        } elseif ($oldstockclose > 0) {
            $data = $oldstockopen - $inputData->stock_in_hand;
            $closing = $data - $oldstockSales;
        } else {
            $closing = 0;
        }

        if ($update != 2) {
            $insertclose = $inventory->updateReports($indiaDate, $opening, $closing);
        }
    }
    $checkCount1 = $stmt1->rowCount();
    if ($checkCount1 == 0 && $update != 2) {
        $inventory->insertStock();
        $inventory->insertStock_log($indiaDateTime);
    } else {
        if ($stocktype == 'add') {
            $stockValue = $inputData->beforestack +  $inputData->stock_in_hand;
        } else {
            $stockValue = $inputData->beforestack - $inputData->stock_in_hand;
        }
        if ($update != 2) {
            $inventory->updateStock($stockValue);
            $inventory->insertStock_log($indiaDateTime);
            $result = $inventory->check_log();
        }
        // if ($result->rowCount() > 0) {
        //     $inventory->updateStock_log($indiaDateTime);
        //     $inventory->insertStock_log1($indiaDateTime);
        // }
    }
}
if ($update == 2) {
    $obj->code = 400;
} else {
    $obj->code = 201;
}
echo json_encode($obj);
//}
