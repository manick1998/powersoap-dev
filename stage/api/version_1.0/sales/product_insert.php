<?php

include "../../config.php";
$json_input = getInputs();
$product_array = $json_input->data;
 $sale_id = $json_input->salesPersonId;
   $bill_amount = $json_input->billAmount;
   $shop_token = $json_input->shopToken;
//   $currnetDateTime =  gmdate("Y-m-d H:i:s");
$currnetDateTime =  date("Y-m-d H:i:s");
   $order_type = "Sales Order";
   $item_count = count($product_array);
   $token  = genToken('token','orders');
   
   $get_distributor_token = mysqli_query($link,"SELECT `admin_distributor_token` FROM `employees` WHERE `token`= '$sale_id'");
   $distribut_row  = mysqli_fetch_array($get_distributor_token);
   $dist_token_value = $distribut_row['admin_distributor_token'];
   
   
 $order_insert = mysqli_query($link,"INSERT INTO `orders`( `token`, `date_time`, `order_type`, `shop_token`, `employee_token`, `items`, `billing_amount`,`delivery`) 
VALUES ('$token','$currnetDateTime','$order_type','$shop_token','$sale_id','$item_count','$bill_amount','pending')");
foreach( $product_array as $key => $data) {
     $category_token = $data->category_token;
     $product_token = $data->token;
     $product_name = $data->name;
     $item_code = $data->item_code;
     $order_qty = $data->order_count;
     $units = $data->order_type;
     $product_per_price = $data->product_per_price;
     $product_per_gst = $data->product_gst;
 
 
 $order_product = mysqli_query($link,"INSERT INTO `orders__items`( `order_token`, `product_token`, `price_per_unit`, `misc_price`, `quantity`, `units`, `date_time`) VALUES 
 ('$token','$product_token','$product_per_price','$product_per_gst','$order_qty','$units','$currnetDateTime')");
 
 $shop_stck_list = mysqli_query($link,"INSERT INTO `shop__stock_list`( `products_token`, `shop_token`, `qty`, `sales`) VALUES ('$product_token','$shop_token','$order_qty','$bill_amount')");
 
 
 
 $select_dist_stock = mysqli_query($link,"SELECT `stock_in_hand` FROM `stock__distributor` WHERE `product_token`='$product_token' AND`employee_token`= '$dist_token_value'");
 $selectrow_dist = mysqli_fetch_array($select_dist_stock);
 $old_stock_count = $selectrow_dist['stock_in_hand'];
 $newcount_stock = $old_stock_count - $order_qty;
 $stockUpdate = mysqli_query($link,"UPDATE `stock__distributor` SET `stock_in_hand`='$newcount_stock' WHERE `product_token`='$product_token' AND `employee_token`='$dist_token_value'");

  }

$check_shop = mysqli_query($link,"SELECT `shop_token` FROM `shop__outstanding` WHERE `shop_token` = $shop_token "); 
$check = mysqli_num_rows($check_shop);
 
if($check) {
    $addamount = mysqli_query($link,"SELECT  `bill_amount`, `paid_amt`, `total_outstanding` FROM `shop__outstanding` WHERE `shop_token` = $shop_token");
    $row1= mysqli_fetch_array($addamount);
     $billAmount = $row1['bill_amount'];
    $total_outstanding = $row1['total_outstanding'];
    $new_billAmount= $billAmount+$bill_amount;
    $new_total_outstanding  = $total_outstanding +$bill_amount;
    $newupdate = mysqli_query($link,"UPDATE `shop__outstanding` SET `bill_amount`='$new_billAmount',`total_outstanding`= '$new_total_outstanding' WHERE `shop_token` = $shop_token ");
    
}
else {
  $insertshop = mysqli_query($link,"INSERT INTO `shop__outstanding`( `date_time`, `shop_token`, `bill_amount`, `paid_amt`, `total_outstanding`) VALUES ('$currnetDateTime','$shop_token','$bill_amount',0,'$bill_amount')");
  
    
}


$obj = new stdClass;
if($order_insert){
    $obj->status_code=200; 
    $obj->message='Product inserted';
    $obj->title='Success';
    
} else {
    $obj->status_code=400; 
    $obj->message='Product not found';
    $obj->title='Success';
    
}

echo json_encode($obj);


?>