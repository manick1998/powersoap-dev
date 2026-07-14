<?php
$obj = new stdClass();
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
$indiaDate     = date("Y-m-d");
if ($inputData->dashboard_code == $verification_code) {
    include_once '../objects/order.php';
    $order = new Order($db);
    if ($inputData->type == "all") {
        $order->orderType   = "Distributor Order";
        $stmt = $order->orderCheck();
        $checkCount = $stmt->rowCount();
        if ($checkCount == 0) {
            $obj->code = 503;
            $obj->data = [];
        } else {
            $obj->code = 201;
            $obj->data = $order->readOrderDist($stmt);
        }
    } else if ($inputData->type == "date_range") {
        $order->orderType  = "Distributor Order";
        $from_date         = $inputData->from_date;
        $order->fromDate   = date("Y-m-d 00:00:00", strtotime($from_date));
        $to_date           = $inputData->to_date;
        $order->toDate     = date("Y-m-d 23:59:59", strtotime($to_date));
        $stmt = $order->orderCheckDateRange();
        $checkCount = $stmt->rowCount();
        if ($checkCount == 0) {
            $obj->code = 503;
            $obj->data = [];
        } else {
            $obj->code = 201;
            $obj->data = $order->readOrderDist($stmt);
        }
    } else if ($inputData->type == "particular_order_detail") {
        $order->orderToken  = $inputData->order_token;
        $stmt = $order->singleOrderDetail();
        $checkCount = $stmt->rowCount();
        if ($checkCount == 0) {
            $obj->data = [];
        } else {
            $obj->data = $order->readSingleOrder($stmt, $baseUrlPath);
        }
        $stmt = $order->singleOrderItemDetail();
        $checkCount = $stmt->rowCount();
        if ($checkCount == 0) {
            $obj->data_item = [];
        } else {
            $obj->data_item = $order->readSingleOrderItemDetail($stmt);
        }
        $divisions = $order->getDivisionByDistributor();
        $numCount = $divisions->rowCount();
        if ($numCount == 0) {
            $obj->data_division = [];
        } else {
            $obj->data_division = $order->readDivisionCount($divisions);
        }
        $obj->data_payment =  $order->readSingleOrderPayment();
    } else if ($inputData->type == "approve") {
        $order->orderToken      = $inputData->order_token;
        $order->distributorToken = $inputData->distributor_token;
        $order->admin_token = $inputData->admin_token;
        $stmt      = $order->singleOrderItemDetail();
        $itemArray = $order->readSingleOrderItemDetail($stmt);
        $stmt2   = mysqli_query($link, "SELECT
        employees.mobile_number,
        employees.name,
        orders.order_number,
        orders.billing_amount
     FROM
        orders
    INNER JOIN employees ON orders.employee_token = employees.token
    WHERE
        orders.token = $order->orderToken");
        $row22 = mysqli_fetch_assoc($stmt2);
        $mobile_number = $row22['mobile_number'];
        $name = $row22['name'];
        $order_number = $row22['order_number'];
        $billing_amount = $row22['billing_amount'];
        $products  = "";
        $check_product = true;
        foreach ($itemValue as $data) {
            $order->mobile_number = $data->mobile_number;
            $order->name = $data->name;
            $order->order_number = $data->order_number;
            $order->billing_amount = $data->billing_amount;
        }
        foreach ($itemArray as $value) {
            if ($value->is_free == '0') {
                $order->productToken = $value->product_token;
                $order->quantity     = $value->quantity_plus_piece;
                $stmt = $order->productStockCheck();
                $checkCount = $stmt->rowCount();
                if ($checkCount == 0) {
                    $check_product  = false;
                    $products .= $value->item_name . ", ";
                }
            }
        }
        if ($check_product) {
            foreach ($itemArray as $value) {
                $order->productToken = $value->product_token;
                $quantity            = $value->quantity_plus_piece;
                $stockQuantity       = $order->stockProductQuantity();
                $updateQuantity      = (int)$stockQuantity - (int)$quantity;
                $order->updateAdminStock($updateQuantity);
                // $order->updateAdminStockReports($updateQuantity);
                // $closeQuantity       = $order->stockClose($indiaDate);
                // $openQuantity       = $order->stockOpen($indiaDate);
                // $salesStock = (int)$openQuantity - (int)$closeQuantity;
                // $order->StockReports($salesStock, $indiaDate);
            }
            $order->approveDistributorOrder($indiaDateTime);
            $order->orderApproveMsg($mobile_number, $name, $order_number, $billing_amount);
            $order->approveInsertLog($indiaDateTime);
            $obj->code     = 201;
            $obj->message  = "";
        } else {
            $productString = "You can't approve this order. Because we don't have enough stock for these products " . rtrim($products, ', ') . ".";
            $obj->code     = 503;
            $obj->message  = $productString;
        }
    } else if ($inputData->type == "deliver") {
        $order->orderToken      = $inputData->order_token;
        $order->distributorToken = $inputData->distributor_token;
        $order->admin_token = $inputData->admin_token;
        $stmt      = $order->singleOrderItemDetail();
        $itemArray = $order->readSingleOrderItemDetail($stmt);
        $stmt2   = mysqli_query($link, "SELECT
        employees.mobile_number,
        employees.name,
        orders.order_number,
        orders.billing_amount
     FROM
        orders
    INNER JOIN employees ON orders.employee_token = employees.token
    WHERE
        orders.token = $order->orderToken");
        $row22 = mysqli_fetch_assoc($stmt2);
        $mobile_number = $row22['mobile_number'];
        $name = $row22['name'];
        $order_number = $row22['order_number'];
        $billing_amount = $row22['billing_amount'];
        $products  = "";
        $check_product = true;
        foreach ($itemArray as $value) {
            $order->productToken = $value->product_token;
            $quantity            = $value->quantity_plus_piece;
            $distributorStockQuantity  = $order->distributorProductQuantity();
            $distributorUpdateQuantity = (int)$distributorStockQuantity + (int)$quantity;
            $order->updateDistributorStock($distributorUpdateQuantity);
            $query4 = mysqli_query($link, "SELECT `product_token` FROM `stock__report` WHERE `product_token`='$value->product_token' AND date='$indiaDate' ORDER BY id DESC LIMIT 1");
            $count_token = mysqli_num_rows($query4);
            $query5 = mysqli_query($link, "SELECT `sales_stock` FROM `stock__report` WHERE `product_token`='$value->product_token' AND date='$indiaDate' ORDER BY id DESC LIMIT 1");
            $countSales = mysqli_fetch_assoc($query5);
            $countSalesValue = $countSales['sales_stock'];
            if ($count_token == 0 && $countSalesValue == 0) {
                $query1 = mysqli_query($link, "SELECT `opening_stock`,`closing_stock` FROM `stock__report` WHERE `product_token`='$value->product_token'");
                $row11 = mysqli_fetch_assoc($query1);
                $opening = $row11["opening_stock"];
                $closed = $row11["closing_stock"];
                $closing_stock = abs($opening - $quantity);
                $stock_reports = mysqli_query($link, "INSERT INTO `stock__report`(`product_token`, `sales_stock`, `opening_stock`, `closing_stock`, `date`) VALUES ('$value->product_token','$quantity','$opening','$closing_stock','$indiaDate')");
            } else {
                $query2 = mysqli_query($link, "SELECT `opening_stock`,`closing_stock`,`sales_stock` FROM `stock__report` WHERE `product_token`='$value->product_token' AND date='$indiaDate' ORDER by id DESC LIMIT 1");
                $row44 = mysqli_fetch_assoc($query2);
                $old_stock = $row44["closing_stock"];
                $opening = $row44["opening_stock"];
                $closed = $row44["closing_stock"];
                $sales = $row44["sales_stock"];

                if ($closed == 0) {
                    $closing = $sales + $quantity;
                    $closing_stock = $opening - $closing;
                } elseif ($closed < 0) {
                    $total = $sales + $quantity;
                    $closing = $opening - $total;
                    $closing_stock = $closing;
                    echo $closing_stock;
                } else {
                    $closing = $sales + $quantity;
                    $closing_stock = $opening - $closing;
                }
                if ($opening == $quantity) {
                    $opening = 0;
                }

                if ($sales == 0) {
                    $sales_quantity = $quantity;
                } else {
                    $sales_quantity = $sales + $quantity;
                }

                $stock_reports = mysqli_query($link, "UPDATE stock__report SET  sales_stock='$sales_quantity',opening_stock='$opening',closing_stock='$closing_stock' WHERE product_token='$value->product_token' AND date='$indiaDate'");
            }
        }
        $order->deliverDistributorOrder($indiaDateTime);
        $order->orderDeliverMsg($mobile_number, $name, $order_number, $billing_amount);
        $order->deliverInsertLog($indiaDateTime);
        $obj->code     = 201;
        $obj->message  = "";
    } elseif ($inputData->type == "editItem") {
        $order->orderToken = $inputData->order_token;
        $stmt = $order->editScheme();
        $orderItem = $order->editSchemeData($stmt);
        $order_token = $orderItem[0];
        $product_token = $orderItem[1];
        $stmt1 = $order->schemeProduct($product_token);
        $orderName = $order->editSchemeProduct($stmt1);
        if ($orderName) {
            $obj->status_code = 200;
            $obj->orderData = $orderName;
            $obj->order_token = $order_token;
        } else {
            $obj->status_code = 400;
            $obj->message = "Error";
        }
    } elseif ($inputData->type == "schemeEdit") {
        $product_token = $inputData->selectedProduct;
        foreach ($product_token as $token) {
            $order->orderToken = $inputData->order_token;
            $stmt = $order->updateScheme($token, $indiaDateTime);
        }
        if ($stmt) {
            $obj->code = 200;
            $obj->message = "Product changed successfully";
        } else {
            $obj->code = 400;
            $obj->message = "error";
        }
    }
    echo json_encode($obj);
    $db = null;
}
