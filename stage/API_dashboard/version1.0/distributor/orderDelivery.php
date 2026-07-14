<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$obj=new stdClass();
include_once '../../../api/version_3.0/delivery_boy/push_notification.php';
include_once '../config/core_distributor.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
if($inputData->dashboard_code == $verification_code){
    include_once '../objects/orders.php';
    $order = new OrderList($db);
    $order->distributor_token  = $inputData->distributor_token;
    $order->shop_token  = $inputData->shop_token;
    $order->current_date  = $indiaDateTime;
    $order->employee_token  = $inputData->employee_token;
    $order->billing_amount  = $inputData->billing_amount;
    $date_value  = $inputData->date_value;
    $order->order_token  = $inputData->order_token;
    $stmt = $order->checkShop();
    $count = $stmt->rowCount();
    if($count >0){
        $stmt1 = $order->distributorOrderDelivery();
        $saleslog = $order->checkSalesLog();
        $saleslogCount = $saleslog->rowCount();
        if($saleslogCount == 0){
            $insertSalesLog = $order->salesLogInsert();
        }else{
            $updateSaleLog = $order->updateSalesLogDistributor($indiaDateTime);

        }
        // $obj = new StdClass();
        if($stmt1){
            $obj->status_code = 200;
            $obj->message = "order Completed successfully";
        }else{
            $obj->status_code = 400;
            $obj->message = "Something happend!";
        }
        $echeck = $order->checkOrerComplete();
        $numcount = $echeck->rowCount();
        if($numcount > 0){
        while($row = $echeck->fetch(PDO::FETCH_ASSOC)){
            
            $ordername = $row["order_number"];
            $disname = $row["disname"];
            $device_token = $row["device_token"];
            $shopName = $row["name"];
            $saleRepToken = $row["name"];
        }
        $order->saleRepToken = $saleRepToken;
        sendNotification($device_token,$ordername,$shopName,$disname);
        $order->notificationInsert();
        } 
    }
   echo json_encode($obj);
}
?>