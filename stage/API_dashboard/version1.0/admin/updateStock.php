<?php
$obj = new stdClass();
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
$indiaDate = date("Y-m-d");

include_once '../objects/inventory.php';
$inventory = new Inventory($db);
$inventory->productToken = $inputData->product_token;
$stmt = $inventory->singleProductCheck();
$checkCount = $stmt->rowCount();

if ($checkCount != 0) {
    $stocktype = $inputData->stocktype;
    $beforestack = floatval($inputData->beforestack);
    $input_stock = floatval($inputData->stock_in_hand);
    $inventory->admin_token = $inputData->admin_token;
    
    // Calculate correct stock value (Add or Remove)
    if ($stocktype == 'add') {
        $stockValue = $beforestack + $input_stock;
    } else {
        $stockValue = $beforestack - $input_stock;
        if ($stockValue < 0) $stockValue = 0;
    }
    
    $inventory->stockInHand = $stockValue;
    $inventory->beforestack = $beforestack;

    $stmt1 = $inventory->updateStockCheck($indiaDateTime);
    $checkCount1 = $stmt1->rowCount();

    $check = $inventory->checkProductScheme($indiaDate);
    $count = $check->rowCount();
    if ($count > 0) {
        $oldstockSales = $inventory->oldStocksales($indiaDate);
        $oldstockopen = $inventory->oldStockOpen($indiaDate);
        $oldstockclose = $inventory->oldStockclose($indiaDate);
        if ($stocktype == 'add') {
            $opening = $input_stock + $oldstockopen;
        } else {
            if ($input_stock > $oldstockopen) {
                $update = 2;
                $opening = $input_stock;
            } else {
                $opening = abs($oldstockopen - $input_stock);
            }
        }
        if ($oldstockclose < 0) {
            $closing = $oldstockclose;
        } elseif ($oldstockclose > 0) {
            $data = $oldstockopen + $input_stock;
            $closing = $data - $oldstockSales;
        } else {
            $closing = 0;
        }

        if ($update != 2) {
            $insertclose = $inventory->updateReports($indiaDate, $opening, $closing);
        }
    }

    if ($update != 2) {
        if ($checkCount1 == 0) {
            // If no record exists in stock__admin, insert it safely
            $inventory->insertStock();
        } else {
            // If record exists, update it with the total accumulated value
            $inventory->updateStock($stockValue);
        }
        $inventory->insertStock_log($indiaDateTime);
    }
}

if ($update == 2) {
    $obj->code = 400;
} else {
    $obj->code = 201;
}
echo json_encode($obj);