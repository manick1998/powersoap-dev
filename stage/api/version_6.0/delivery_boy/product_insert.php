<?php 
// ini_set('display_errors', 1);// show error reporting
//  error_reporting(E_ALL);
include "../../config.php";
$json_input = getInputs();
$product_array = $json_input->data;
$sale_id = $json_input->employee_id;
$bill_amount = ($json_input->billAmount);
$shop_token = $json_input->shopToken; 
$currnetDateTime =  date("Y-m-d H:i:s");
$order_type = "Spot Order";
$item_count = count($product_array);
$token  = genToken('token','orders');
$order_number = "ORD-R".$token;
   $obj = new stdClass;
   
   $get_distributor_token = mysqli_query($link,"SELECT `admin_distributor_token`,deparment_token FROM `employees` WHERE `token`= '$sale_id'");
   $distribut_row  = mysqli_fetch_array($get_distributor_token);
   $dist_token_value = $distribut_row['admin_distributor_token'];
   $deparment_token = $distribut_row['deparment_token'];

   
   $getShopMapping = mysqli_query($link,"SELECT `token` FROM `shop_mapping` WHERE `shop_token`='$shop_token' AND `distributor_token`='$dist_token_value'");
   $getShopMapping_row = mysqli_fetch_array($getShopMapping);
   $shop_mapping_token = $getShopMapping_row['token'];
   
   $getUnitToken = mysqli_query($link,"SELECT `unit_group_token`  FROM `units__shop_mapping` WHERE `shop_token` = '$shop_token'");
   $getUnitToken_row = mysqli_fetch_array($getUnitToken);
   $unit_token = $getUnitToken_row['unit_group_token'];
 

   // product_items_count
   $product_item_val = 0;
   foreach( $product_array as $key => $data) {
    $is_free = $data->is_free;
    if($is_free == false){

    $product_item_val +=1;
}
   

   }
   $final_product_item_count = $product_item_val;


 
//prem code added start
 $unit_count = mysqli_query($link,"SELECT count(`unit_group_token`) AS `unit_count` FROM `units__shop_mapping` WHERE `unit_group_token`=(SELECT `unit_group_token` FROM `units__shop_mapping` WHERE `shop_token`='$shop_token' AND `delete_status`=1)"); 
 $unit_count_row = mysqli_fetch_array($unit_count);
 $unit_shop_count = $unit_count_row['unit_count'];
//prem code added end
   
$order_insert = mysqli_query($link,"INSERT INTO `orders`( `token`,`order_number`, `date_time`, `order_type`, `shop_token`, `employee_token`,`distributor_token`, `items`, `billing_amount`,`outstanding_amount`,`delivery`,`delivery_emp_token`, `approved_on`, `delivered_on`,`unit_shop_count`) 
                        VALUES ('$token','$order_number', '$currnetDateTime','$order_type','$shop_mapping_token','$sale_id','$dist_token_value' ,'$final_product_item_count','$bill_amount','0','Completed','$sale_id','$currnetDateTime','$currnetDateTime','$unit_shop_count')");

if($order_insert){
    // daily summary
 $emp_daily_summary = mysqli_query($link,"INSERT INTO `employees__daily_summary`( `date_time`, `department_token`, `employees_token`, `location_token`, `order_value`, `collection`, `                              productivity`, `outlets_covered`) VALUES ('$currnetDateTime','$deparment_token','$sale_id','$unit_token','0','0','0','0')");
}
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
 
        // if($units =='Box'){
        // $disrtributor_product_count = $order_qty*$piece_count;

        // }  
        // else {
        // $disrtributor_product_count =$order_qty;

        // }

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


        $order_product = mysqli_query($link,"INSERT INTO `orders__items`( `order_token`, `product_token`, `price_per_unit` , `piece_count`, `misc_price`, `quantity`,`offer_amount`, `units`,`is_discount_enable` ,`discount_value`, `date_time`)
        VALUES ('$token','$product_token','$product_per_price','$piece_count','$product_per_gst','$order_qty','$product_amount_value','$units','$discount_val','$percentage_number','$currnetDateTime')");

        $shop_stck_list = mysqli_query($link,"INSERT INTO `shop__stock_list`( `products_token`, `shop_token`, `qty`, `sales`) VALUES ('$product_token','$shop_token','$order_qty','$bill_amount')");

        // update count in distributor
        $select_dist_stock = mysqli_query($link,"SELECT `stock_in_hand`,`sold_pieces` FROM `stock__distributor` WHERE `product_token`='$product_token' AND`employee_token`= '$dist_token_value'");
        $selectrow_dist = mysqli_fetch_array($select_dist_stock);
        $old_stock_count = $selectrow_dist['stock_in_hand'];
        $sold_old_pices = $selectrow_dist['sold_pieces']; 
        
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

        // freeproduct
        // discount buy and get
        $old_stock_count=0;
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

            // update stock for distributor
            $select_dist_stock = mysqli_query($link,"SELECT `stock_in_hand` FROM `stock__distributor` WHERE `product_token`='$product_token' AND`employee_token`= '$dist_token_value'");
            $selectrow_dist = mysqli_fetch_array($select_dist_stock);
            $old_stock_count = $selectrow_dist['stock_in_hand']; 
            $newcount_stock = $old_stock_count - $product_dist_count;
            $stockUpdate = mysqli_query($link,"UPDATE `stock__distributor` SET `stock_in_hand`='$newcount_stock' WHERE `product_token`='$product_token' AND `employee_token`='$dist_token_value'");


        }
        


        
    }
}
  // value for bill amount
  $bill_amount_final = round($bill_amount);
  $update_value_billAmount = mysqli_query($link,"UPDATE `orders` SET `billing_amount`= '$bill_amount_final',`outstanding_amount`='$bill_amount_final' WHERE `token`='$token'");

$check_shop = mysqli_query($link,"SELECT `shop_token` FROM `shop__outstanding` WHERE `shop_token` = $shop_mapping_token "); 
$check = mysqli_num_rows($check_shop);
 
            if($check) {
                        $addamount = mysqli_query($link,"SELECT  `bill_amount`, `paid_amt`, `total_outstanding` FROM `shop__outstanding` WHERE `shop_token` = $shop_mapping_token");
                        $row1= mysqli_fetch_array($addamount);
                         $billAmount = $row1['bill_amount'];
                        $total_outstanding = $row1['total_outstanding'];
                        $new_billAmount= $billAmount+$bill_amount;
                        $new_total_outstanding  = $total_outstanding +$bill_amount;
                        $newupdate = mysqli_query($link,"UPDATE `shop__outstanding` SET `bill_amount`='$new_billAmount',`total_outstanding`= '$new_total_outstanding' WHERE `shop_token` = $shop_mapping_token ");


                        $check_status = mysqli_query($link,"SELECT 1 FROM `sales__log` WHERE `distributor_token`='$dist_token_value' AND `sales_token`='$sale_id' AND  `shop_token` ='$shop_mapping_token' AND `date_time` LIKE '%$indiaDate%'");
                        if(mysqli_num_rows($check_status) ){
                                     $sales_update = mysqli_query($link,"UPDATE `sales__log` SET `status`='Completed'  WHERE `distributor_token` = '$dist_token_value' AND `sales_token` = '$sale_id' AND `shop_token`='$shop_mapping_token' AND `date_time` LIKE '%$indiaDate%'");
                        }
                            else
                            {
                            $sales_log = mysqli_query($link,"INSERT INTO `sales__log`(`date_time`, `distributor_token`, `sales_token`, `shop_token`, `status`) VALUES ('$currnetDateTime','$dist_token_value','$sale_id','$shop_mapping_token','Completed')");
                            }

            }
            else {
              $insertshop = mysqli_query($link,"INSERT INTO `shop__outstanding`( `date_time`, `shop_token`, `bill_amount`, `paid_amt`, `total_outstanding`) VALUES ('$currnetDateTime','$shop_mapping_token','$bill_amount',0,'$bill_amount')");

              }



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