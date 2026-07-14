<?php
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
include_once '../objects/inventory.php';
$inventory = new Inventory($db);
$array = [];
$row = 1;
$indiaDate     = date("Y-m-d");
$obj = new stdClass();
if (is_array($_FILES)) {
    if (is_uploaded_file($_FILES['file_upload']['tmp_name'])) {
        $sourcePath = $_FILES['file_upload']['tmp_name'];
        if (($handle = fopen($sourcePath, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",", '"')) !== FALSE) {
                $num = count($data);
                for ($c = 0; $c < $num; $c++) {
                    if ($c == 0) {
                        if ($row > 1) {
                            $inventory->productCode   = addslashes($data[0]);
                            $stock = addslashes($data[1]);
                            $token = $inventory->checkProduct();
                            $oldStock = $inventory->oldstock($token);
                            $stockValue = $oldStock + $stock;
                            $insert = $inventory->updateStockUpload($token, $stockValue);
                            $query = mysqli_query($link, "SELECT `opening_stock`,`sales_stock`,`closing_stock` FROM `stock__report` WHERE `product_token`='$token' AND `status`='1' AND `date`='$indiaDate' ORDER BY `id` DESC LIMIT 1");
                            $row1 = mysqli_fetch_array($query);
                            $opening_stock = $row1['opening_stock'];
                            $sales_stock = $row1['sales_stock'];
                            $closing_stock = $row1['closing_stock'];
                            if ($closing_stock == 0) {
                                $closing = 0;
                            } elseif ($closing_stock < 0) {
                                $value = $opening_stock + $stock;
                                $closing = $value - $sales_stock;
                            } else {
                                $value = $opening_stock + $stock;
                                $closing = $value - $sales_stock;
                            }
                            if ($opening_stock == 0) {
                                $opening = $stock;
                                $report = $inventory->insertStockReports($indiaDateTime, $token, $opening, $closing, $sales_stock);
                            } else {
                                $opening = $opening_stock + $stock;
                                $report = $inventory->updateReport($indiaDateTime, $token, $opening, $closing, $sales_stock);
                            }
                            array_push($array, $inventory->productCode);
                        }
                    }
                }
                $row++;
            }
            fclose($handle);
            if (count($array) == 0) {
                $obj->code    = 503;
                $obj->message = implode(",", $array) . " this Product Division are not matching. We can't upload this product";
            } else {
                $obj->code     = 201;
                $obj->message = "Csv data uploaded successfully!";
            }
        }
    }
} else {
    $obj->code    = 503;
    $obj->message = "Error2";
}
echo json_encode($obj);
