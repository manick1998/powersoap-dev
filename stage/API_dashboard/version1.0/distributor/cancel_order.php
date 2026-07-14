<?php
$obj=new stdClass();
include_once '../config/core_distributor.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
if($inputData->dashboard_code == $verification_code){
    include_once '../objects/orders.php';
    $order = new OrderList($db);
    $order_items = $inputData->order_items;
    $distributor_token = $inputData->distributor_token;
    foreach($order_items as $orderData){
        $order->product_token = $orderData->product_token;
        $order->pieces_count = $orderData->pieces_count;
        $stock_in_hand = $order->selectStockOrderDistributor($distributor_token,$order->product_token);
        $newStockInHand = $stock_in_hand + $order->pieces_count;
        $balanace_pieces=$orderData->sold_pieces;
        $stmt = $order->returnStockOnCancel($order->product_token,$newStockInHand,$balanace_pieces,$distributor_token);
    }
    $order->distributor_token  = $inputData->distributor_token;
    $order->shop_token  = $inputData->shop_token;
    $order->employee_token  = $inputData->employee_token;
    $order->billing_amount  = $inputData->billing_amount;
    $date_value  = $inputData->date_value;
    $order->orderDate   = date("Y-m-d", strtotime($date_value));
    $stmt1 = $order->updateSalesLog();
    $stmt2 = $order->selectBillingAmount();
    $order->total_billing_amount = $stmt2->old_bill_amount-$inputData->billing_amount;
    $order->total_outstanding = $stmt2->old_total_outstanding-$inputData->billing_amount;
    $stmt3 = $order->updateBillingAmount();
    $order->orderToken  = $inputData->order_token;
    $obj->code=201;
    $obj->data =$order->cancelOrder($indiaDateTime);
    echo json_encode($obj);
}
?>
