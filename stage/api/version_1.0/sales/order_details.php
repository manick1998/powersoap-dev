<?php
include "../../config.php";
$json_input = getInputs();
$employee_id = $json_input->employee_id;
$shop_id = $json_input->shop_id;
$order_id = $json_input->order_id;
$array = array();
;
$order_details = mysqli_query($link,"SELECT
                            orders.token,
                            orders__items.product_token,
                            orders__items.quantity,
                            orders__items.units,
                            orders__items.misc_price AS gst,
                            products.name AS product_name,
                            (
                                orders__items.quantity * orders__items.price_per_unit
                            ) AS amount
                        FROM
                            orders
                        INNER JOIN  orders__items on orders__items.order_token = orders.token
                        INNER JOIN products ON orders__items.product_token = products.token
                        WHERE
                            orders.token = $order_id");
                            
  while($order_row = mysqli_fetch_array($order_details)) {
      $order_obj = new stdClass;
  $order_obj->product_token = $order_row['product_token'];
  $order_obj->quantity = $order_row['quantity'];
  $order_obj->units = $order_row['units'];
if($order_row['units'] == 'Box'){
    $order_obj->amount = $order_row['amount']*$box_value;
}else{
    $order_obj->amount = $order_row['amount'];
}
  $order_obj->misc_price = $order_row['gst'];
  $order_obj->product_name = $order_row['product_name'];
  
  array_push($array,$order_obj);
      
  }                      
               
    $order_total = mysqli_query($link,"SELECT
                            SUM( orders__items.misc_price * orders__items.quantity) AS gst,
                            SUM( orders__items.price_per_unit * orders__items.quantity) AS pro_amount,
                            SUM((orders__items.misc_price * orders__items.quantity) +( orders__items.price_per_unit * orders__items.quantity ) ) AS total_amount,
                            orders.delivery,
                            orders.date_time,
                            orders.token,
                            orders.items,
                            orders.delivery,
                            shop.name AS shop_name,
                            shop.token AS shop_token,
                            orders.delivered_on,
                            orders.billing_amount
                        FROM
                            orders
                            INNER JOIN orders__items on orders__items.order_token=orders.token
                            INNER JOIN shop ON shop.token=orders.shop_token
                            
                        WHERE  
                             orders.token = $order_id");
               
            $order_mount = mysqli_fetch_array($order_total);
            $amt_obj = new stdClass;
            $amt_obj->gst = $order_mount['gst'];
            $amt_obj->pro_amount = $order_mount['billing_amount'] -$order_mount['gst'] ;
            $amt_obj->total_amount = $order_mount['billing_amount'];
            $amt_obj->order_delivery = $order_mount['delivery'];
            
            $schedule_date12= $order_mount['date_time'];
            $convert_date= date('j,M Y', strtotime($schedule_date12));
            $amt_obj->order_schedule_date = $convert_date;//$order_mount['date_time'];
            $delivered_on = $order_mount['delivered_on'];
            $delivery_date= date('j,M Y', strtotime($delivered_on));
            $amt_obj->order_delivery_date = $delivery_date;//$order_mount['date_time'];
            $amt_obj->order_token = $order_mount['token'];
            $amt_obj->order_items = $order_mount['items'];
            $amt_obj->shop_name = $order_mount['shop_name'];
            $amt_obj->shop_token = $order_mount['shop_token'];
            $amt_obj->order_status = $order_mount['delivery'];
            
               
               
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