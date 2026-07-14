<?php
include "../../config.php";
$json_input = getInputs();
$product_array = $json_input->data;
$sale_id = $json_input->salesPersonId;
$bill_amount1 = $json_input->billAmount;
$bill_amount = ($bill_amount1);
$shop_token = $json_input->shopToken;
$currnetDateTime =  date("Y-m-d H:i:s");
$indiaDate =  date("Y-m-d");
$order_type = "Sales Order";
$item_count = count($product_array);
$token = $json_input->order_id;

$query = mysqli_query($link,"SELECT date(`date_time`)AS `date` FROM `orders` WHERE `token`='$token'");
$row = mysqli_fetch_array($query);
$date = $row['date'];


   // product_items_count
   $product_item_val = 0;
   foreach( $product_array as $key => $data) {
    $is_free = $data->is_free;
    if($is_free == false){

    $product_item_val +=1;
} 
   }
   $final_product_item_count = $product_item_val;
if($date==$indiaDate){
$order_update = mysqli_query($link,"UPDATE `orders` SET `items`='$final_product_item_count',`billing_amount`='$bill_amount' WHERE `token`='$token'");

$status_change = mysqli_query($link,"UPDATE `orders__items` SET  `delete_status`='2' WHERE `order_token`='$token'");

$bill_amount=0;
foreach( $product_array as $key => $data) {
     $category_token = $data->category_token;
     $product_token = $data->token;
     $product_name = $data->name;
     $item_code = $data->item_code;
     $order_qty = $data->added_count;
     $units = $data->added_type;
     $product_per_price = $data->product_per_price;
     $product_per_gst = $data->product_gst;
     $piece_count = $data->piece_count;
     $is_discount_enable = $data->discount_enable;
      $is_free = $data->is_free;
     $is_scheme = $data->is_scheme;
     $limit_box = $data->limit_box;
     $free_box = $data->free_box;
     $percentage = (property_exists($data, 'percentage')) ? $data->percentage:0 ;




     if($is_free == false){

       if($units == 'Box'){
            $order_qty1 = $order_qty*$piece_count;
             $product_amount_value = $order_qty*$piece_count*$product_per_price;

        }else
        {
            $order_qty1 = $order_qty;
            $product_amount_value = $order_qty*$product_per_price;
        }

  


     if($is_discount_enable){
        $discount_val = 1;
        $percentage_number = (float) filter_var( $percentage, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
        $percentage_cal = $percentage_number/100;
        $product_value = ($order_qty1*$product_per_price) - ($order_qty1*$product_per_price*$percentage_cal); 

     }else{
        $discount_val = 0;
         $product_value = ($order_qty1*$product_per_price);

     }

      $bill_amount+= $product_value;
 
 
 $order_product = mysqli_query($link,"INSERT INTO `orders__items`( `order_token`, `product_token`, `price_per_unit`, `piece_count`, `misc_price`, `quantity`,`offer_amount`, `units`,`is_discount_enable` ,`discount_value`, `date_time`) VALUES 
 ('$token','$product_token','$product_per_price','$piece_count','$product_per_gst','$order_qty','$product_amount_value','$units','$discount_val','$percentage_number','$currnetDateTime')");
 
 $shop_stck_list = mysqli_query($link,"INSERT INTO `shop__stock_list`( `products_token`, `shop_token`, `qty`, `sales`) VALUES ('$product_token','$shop_mapping_token','$order_qty','$bill_amount')");
 
 
 
 $select_dist_stock = mysqli_query($link,"SELECT `stock_in_hand`,`sold_pieces` FROM `stock__distributor` WHERE `product_token`='$product_token' AND`employee_token`= '$dist_token_value'");
 $selectrow_dist = mysqli_fetch_array($select_dist_stock);
 $old_stock_count = $selectrow_dist['stock_in_hand'];
 $sold_old_pices = $selectrow_dist['sold_pieces'];
 // $newcount_stock = $old_stock_count - $order_qty;
 if($units =='Box'){
    $disrtributor_product_count = $order_qty;
    $newcount_stock = $old_stock_count - $disrtributor_product_count;
    $stockUpdate = mysqli_query($link,"UPDATE `stock__distributor` SET `stock_in_hand`='$newcount_stock' WHERE `product_token`='$product_token' AND `employee_token`='$dist_token_value'");
 } 
 else {
    $disrtributor_product_count =$order_qty;
    $new_sold_pieces = $sold_old_pices + $disrtributor_product_count;
    $new_box =  $old_stock_count - floor($new_sold_pieces / $piece_count);
    $balanace_pieces = $new_sold_pieces % $piece_count;
    $stockUpdate = mysqli_query($link,"UPDATE `stock__distributor` SET `stock_in_hand` = '$new_box', `sold_pieces`='$balanace_pieces' WHERE `product_token`='$product_token' AND `employee_token`='$dist_token_value'");
 }





 if($is_scheme){
    if($units =='Box'){ 
        $free_box_val = ($order_qty/$limit_box)*$free_box;
            if($free_box_val >= 1) {

                $product_box_count = (int)($free_box_val);
                $units_offer = 'Box';
                $product_dist_count = $product_box_count*$piece_count;

            }
            else{
                $product_box_count =(int)($free_box_val*$piece_count);
                $units_offer = 'Nos';
                $product_dist_count = $product_box_count;

            }
                if($product_box_count > 0){
                    $order_product = mysqli_query($link,"INSERT INTO `orders__items`( `order_token`, `product_token`, `price_per_unit`, `piece_count`, `misc_price`, `quantity`, `units`,`is_free`,`is_discount_enable`, `date_time`) VALUES 
                    ('$token','$product_token','$product_per_price','$piece_count','$product_per_gst','$product_box_count','$units_offer','1','0','$currnetDateTime')");
                }


    }
    else {
        // qutatity cal
        $qtyToBox = $order_qty/$piece_count;
        $qtyToBox_value = ($qtyToBox);
        $free_box_val = ($qtyToBox_value/$limit_box)*$free_box;
            if($free_box_val >= 1) {
                $product_box_count = (int)($free_box_val);
                $units_offer = 'Box';
                $product_dist_count = $product_box_count*$piece_count;

            }else{
                $product_box_count = (int)($free_box_val*$piece_count);
                $units_offer = 'Nos';
                $product_dist_count = $product_box_count;

            }
                if($product_box_count >0){
                    $order_product = mysqli_query($link,"INSERT INTO `orders__items`( `order_token`, `product_token`, `price_per_unit`, `piece_count`, `misc_price`, `quantity`, `units`,`is_free`,`is_discount_enable`, `date_time`) VALUES 
                    ('$token','$product_token','$product_per_price','$piece_count','$product_per_gst','$product_box_count','$units_offer','1','0','$currnetDateTime')");

                }

    }



    $select_dist_stock = mysqli_query($link,"SELECT `stock_in_hand` FROM `stock__distributor` WHERE `product_token`='$product_token' AND`employee_token`= '$dist_token_value'");
    $selectrow_dist = mysqli_fetch_array($select_dist_stock);
    $old_stock_count = $selectrow_dist['stock_in_hand'];
    // $newcount_stock = $old_stock_count - $order_qty;
    $newcount_stock = $old_stock_count - $product_dist_count;
    $stockUpdate = mysqli_query($link,"UPDATE `stock__distributor` SET `stock_in_hand`='$newcount_stock' WHERE `product_token`='$product_token' AND `employee_token`='$dist_token_value'");



}



}

  }

   // value for bill amount
  $bill_amount_final = round($bill_amount);
  $update_value_billAmount = mysqli_query($link,"UPDATE `orders` SET `billing_amount`= '$bill_amount_final',`outstanding_amount`='$bill_amount_final' WHERE `token`='$token'");




$check_shop = mysqli_query($link,"SELECT `shop_token` FROM `shop__outstanding` WHERE `shop_token` = '$shop_mapping_token' "); 
$check = mysqli_num_rows($check_shop);
 
 
if($check) {
    $addamount = mysqli_query($link,"SELECT  `bill_amount`, `paid_amt`, `total_outstanding` FROM `shop__outstanding` WHERE `shop_token` = '$shop_mapping_token'");
    $row1= mysqli_fetch_array($addamount);
     $billAmount = $row1['bill_amount'];
    $total_outstanding = $row1['total_outstanding'];
    $new_billAmount= $billAmount+$bill_amount;
    $new_total_outstanding  = $total_outstanding +$bill_amount;
    $newupdate = mysqli_query($link,"UPDATE `shop__outstanding` SET `bill_amount`='$new_billAmount',`total_outstanding`= '$new_total_outstanding' WHERE `shop_token` = '$shop_mapping_token' ");
    
}
else {
  $insertshop = mysqli_query($link,"INSERT INTO `shop__outstanding`( `date_time`, `shop_token`, `bill_amount`, `paid_amt`, `total_outstanding`,`receiver_token`) VALUES ('$currnetDateTime','$shop_mapping_token','$bill_amount','0','$bill_amount','0')");
  
    
}


if($order_update){
// for pdf invoice
    $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $baseUrlPath.'TCPDF-main/examples/salesOrderInvoice.php',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('order_token' => "$token"),
));

$response = curl_exec($curl);

curl_close($curl);
// echo $response;
}

$obj = new stdClass;
if($order_update){
    $obj->status_code=200; 
    $obj->message='Product inserted';
    $obj->title='Success';
    
} else {
    $obj->status_code=400; 
    $obj->message='Product not found';
    $obj->title='Success';
    
}
}else{
    $obj->status_code=400; 
    $obj->message='Within one day';
    $obj->title='Success';
 }

echo json_encode($obj);


?>