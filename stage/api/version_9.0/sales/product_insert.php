<?php
include "../../config.php";
include "../../services/OrderService.php";

$json_input = getInputs();
$product_array = $json_input->data;
$sale_id = $json_input->salesPersonId;
$bill_amount = $json_input->billAmount;
$shop_token = $json_input->shopToken;
$currnetDateTime =  date("Y-m-d H:i:s");
$indiaDate =  date("Y-m-d");
$order_type = "Sales Order";

$get_distributor_token = mysqli_query($link,"SELECT `admin_distributor_token`,deparment_token FROM `employees` WHERE `token`= '$sale_id'");
$distribut_row  = mysqli_fetch_array($get_distributor_token);
$distributor_token = $distribut_row['admin_distributor_token'];
$deparment_token = $distribut_row['deparment_token'];

$getShopMapping = mysqli_query($link,"SELECT `token` FROM `shop_mapping` WHERE `shop_token` = '$shop_token' AND `distributor_token`='$distributor_token'");
$getShopMapping_row = mysqli_fetch_array($getShopMapping);
$shop_mapping_token = $getShopMapping_row['token'];
   
$getUnitToken = mysqli_query($link,"SELECT `unit_group_token`  FROM `units__shop_mapping` WHERE `shop_token` = '$shop_mapping_token'");
$getUnitToken_row = mysqli_fetch_array($getUnitToken);
$unit_token = $getUnitToken_row['unit_group_token'];

$unit_count = mysqli_query($link,"SELECT count(`unit_group_token`) AS `unit_count` FROM `units__shop_mapping` WHERE `unit_group_token`=(SELECT `unit_group_token` FROM `units__shop_mapping` WHERE `shop_token`='$shop_mapping_token' AND `delete_status`='1')"); 
$unit_count_row = mysqli_fetch_array($unit_count);
$unit_shop_count = $unit_count_row['unit_count'];

$context = [
    'shop_mapping_token' => $shop_mapping_token,
    'employee_token' => $sale_id,
    'distributor_token' => $distributor_token,
    'bill_amount' => $bill_amount,
    'unit_shop_count' => $unit_shop_count,
    'order_type' => $order_type,
    'currnetDateTime' => $currnetDateTime,
    'indiaDate' => $indiaDate,
    'app_context' => 'sales',
    'shop_token' => $shop_token,
    'baseUrlPath' => $baseUrlPath,
    'deparment_token' => $deparment_token,
    'unit_token' => $unit_token
];

$response = OrderService::processOrder($link, $product_array, $context);
echo json_encode($response);

?>