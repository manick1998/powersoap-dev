<?php
include "../../../config.php";
include "../../../services/OrderService.php";

$json_input = getInputs();
$product_array = $json_input->data;
$distributor_token = $json_input->distributor_token;
$bill_amount = $json_input->billAmount;
$shop_token = $json_input->shopToken;
$currnetDateTime =  date("Y-m-d H:i:s");
$indiaDate = date("Y-m-d");
$order_type = "Retailer Order";

$getShopMapping = mysqli_query($link,"SELECT `token` FROM `shop_mapping` WHERE `shop_token` = '$shop_token' AND `distributor_token`='$distributor_token'");
$getShopMapping_row = mysqli_fetch_array($getShopMapping);
$shop_mapping_token = $getShopMapping_row['token'];

$context = [
    'shop_mapping_token' => $shop_mapping_token,
    'employee_token' => $distributor_token,
    'distributor_token' => $distributor_token,
    'bill_amount' => $bill_amount,
    'unit_shop_count' => 0,
    'order_type' => $order_type,
    'currnetDateTime' => $currnetDateTime,
    'indiaDate' => $indiaDate,
    'app_context' => 'retailer',
    'shop_token' => $shop_token,
    'baseUrlPath' => $baseUrlPath
];

$response = OrderService::processOrder($link, $product_array, $context);
echo json_encode($response);

?>