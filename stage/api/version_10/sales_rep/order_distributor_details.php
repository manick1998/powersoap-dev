<?php
include "../../config.php";
$json_input = getInputs();
$employee_id = $json_input->employee_id;
// $shop_id = $json_input->shop_id;
$order_id = $json_input->order_id;
$array = array();
$order_details = mysqli_query($link,"SELECT
                            orders.token,
                            orders__items.product_token,
                            orders__items.quantity,
                            orders__items.units,
                            orders__items.misc_price AS gst,
                            orders__items.price_per_unit,
                            orders__items.is_free,
                            products.name AS product_name,
                            orders__items.offer_percentage,
                            (
                                orders__items.quantity * orders__items.price_per_unit
                            ) AS amount,
                             SUM(CASE WHEN orders__items.units = 'Box' THEN(orders__items.quantity * products.piece_count) ELSE orders__items.quantity END) AS qty
                        FROM
                            orders
                        INNER JOIN  orders__items on orders__items.order_token = orders.token
                        INNER JOIN products ON orders__items.product_token = products.token
                        WHERE
                            orders.token = $order_id AND `orders__items`.`delete_status` = 1 GROUP BY `orders__items`.`id` ORDER BY `products`.`name`, `orders__items`.`is_free` ASC ");
                            // ORDER BY `orders__items`.`is_free` ASC
                            
  while($order_row = mysqli_fetch_array($order_details)) {
      $order_obj = new stdClass;
  $order_obj->product_token = $order_row['product_token'];
  // $order_obj->quantity = $order_row['quantity'];
  $order_obj->quantity = $order_row['quantity'];
  $order_obj->units = $order_row['units'];
// if($order_row['units'] == 'Box'){
        $gst_multiplier = 1 + ($order_row['gst'] / 100);
    $order_obj->amount = number_format($order_row['price_per_unit']*$order_row['qty'] / $gst_multiplier, 2, '.', '');
// }else{
//     $order_obj->amount = $order_row['amount'];
// }
  $order_obj->misc_price = $order_row['gst'];
  $order_obj->product_name = $order_row['product_name'];
  $is_free_product = $order_row['is_free'];
  if($is_free_product == 0){
    $order_obj->is_free = false;

  }else{
     $order_obj->is_free =true ;

  }
  // admin_offer
  $is_admin_offer = $order_row['offer_percentage'];
  if(($is_admin_offer == 0) || ($is_admin_offer == '')){
    $order_obj->is_admin_offer = false;
    $order_obj->is_admin_offer_value = 0;

  }else{
     $order_obj->is_admin_offer = true ;
     $order_obj->is_admin_offer_value = $order_row['offer_percentage'] ;

  }
  
  array_push($array,$order_obj);
      
  }                      
               
    $order_total = mysqli_query($link,"SELECT
                            -- SUM( orders__items.misc_price * orders__items.quantity) AS gst,
                             orders.gst AS orders_gst_total,
                            SUM( orders__items.price_per_unit * orders__items.quantity) AS pro_amount,
                            SUM((orders__items.misc_price * orders__items.quantity) +( orders__items.price_per_unit * orders__items.quantity ) ) AS total_amount,
                            orders.delivery,
                            orders.date_time,
                            orders.token,
                            orders.items,
                            orders.delivery,
                            -- shop.name AS shop_name,
                            -- shop.token AS shop_token,
                            orders.delivered_on,
                            orders.billing_amount,
                            COALESCE(employees.name,0) as employee_name,
                            orders.bill_discount_amount,
                             orders.bill_discount_percentage,
                             SUM(CASE WHEN orders__items.offer_percentage > 0 THEN (orders__items.quantity*orders__items.piece_count*orders__items.price_per_unit)*(orders__items.offer_percentage/100) ELSE 0 END) as admin_offer,
                             SUM(orders__items.offer_percentage) AS check_offer_admin
                        FROM
                            orders
                            INNER JOIN orders__items on orders__items.order_token=orders.token
                            -- INNER JOIN shop ON shop.token=orders.shop_token
                             LEFT JOIN employees ON employees.token=orders.delivery_emp_token
                        WHERE  
                             orders.token = $order_id AND `orders__items`.`delete_status` = 1");
               
            $order_mount = mysqli_fetch_array($order_total);
            $amt_obj = new stdClass;
            $gst_cal = $order_mount['orders_gst_total'];
            $gst_cal_dec = number_format((float)$gst_cal, 2, '.', '');
            $amt_obj->admin_offer = number_format($order_mount['admin_offer'], 2, '.', '');
            $check_offer_admin = $order_mount['check_offer_admin'];
            if($check_offer_admin > 0){
                $amt_obj->admin_offer_enable = true;

            }else{
                $amt_obj->admin_offer_enable = false;

            }
            $amt_obj->gst = $gst_cal_dec;
            $amount_value_nogst = $order_mount['billing_amount']+$order_mount['admin_offer'] - $gst_cal_dec;



            $amt_obj->pro_amount = number_format((float)$amount_value_nogst, 2, '.', '');
            $amt_obj->total_amount = round($order_mount['billing_amount']);
            $amt_obj->order_delivery = $order_mount['delivery'];

            $value = round($order_mount['billing_amount'] - $gst_cal_dec);
            


             // $discount_amount = $order_mount['bill_discount_amount'];
             // $percentage_amount = $order_mount['bill_discount_percentage'];
             // if($discount_amount > 0) {
             //    $amt_obj->discount_amount_finall = round($value-$discount_amount);
             //    $amt_obj->offer_value = 'Rs '.$discount_amount;

             // } elseif ($percentage_amount > 0) {
             //      $calculation = ($value*$percentage_amount)/100;
             //      $amt_obj->discount_amount_finall = round($value - $calculation);
             //      $amt_obj->offer_value = $percentage_amount.'%';
             // } else {
             //    $amt_obj->discount_amount_finall = 0;
             // }



            $schedule_date12= $order_mount['date_time'];
            $convert_date= date('j,M Y', strtotime($schedule_date12));
            $amt_obj->order_schedule_date = $convert_date;//$order_mount['date_time'];
            $delivered_on = $order_mount['delivered_on'];
            $delivery_date= date('j,M Y', strtotime($delivered_on));
            $amt_obj->order_delivery_date = $delivery_date;//$order_mount['date_time'];
            $amt_obj->order_token = $order_mount['token'];
            $amt_obj->order_items = $order_mount['items'];
            // $amt_obj->shop_name = $order_mount['shop_name'];
            // $amt_obj->shop_token = $order_mount['shop_token'];
            $amt_obj->order_status = $order_mount['delivery'];
            $amt_obj->employee_name ="Admin";// $order_mount['employee_name'];
               
               
$order_val = new stdClass;
$order_val->order_details = $array;
$order_val->order_val = $amt_obj;
                        
$obj = new stdClass;
if($employee_id){
    $obj->status_code=200; 
    $obj->message='Product found';
    $obj->title='Success';
    $obj->data = $order_val;
    
} else {
    $obj->status_code=400; 
    $obj->message='Product not found';
    $obj->title='Success';
    
}
echo json_encode($obj);

?>