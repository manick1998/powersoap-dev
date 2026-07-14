<?php
include "../../config.php";
$json_input = getInputs();
$employee_id = $json_input->employee_id;
$shop_id = $json_input->shop_id;

// $token = mysqli_query($link,"SELECT `token` FROM  `orders` WHERE `shop_token` = $shop_id
//                     ORDER BY
//                         `orders`.`id` ASC");
//      $token_row = mysqli_fetch_array($token);
//     $order_id_bal =  $token_row['token'];

$shop_details = mysqli_query($link,"SELECT
                                    orders.token AS order_token,
                                    orders.date_time as schedule_date,
                                    shop.token AS shop_token,
                                    shop.name,
                                    SUM(orders.items) AS qty_total_count,
                                    SUM(orders.billing_amount) AS total_amt 
                                FROM
                                   orders
                                INNER JOIN shop ON shop.token = orders.shop_token
                                WHERE
                                   orders.shop_token = $shop_id and delivery='Pending'");
                                //   
                                    
$shop_row = mysqli_fetch_array($shop_details);
$shop_obj = new stdClass;
$shop_obj->order_token = $shop_row['order_token'];
$schedule_date12 = $shop_row['schedule_date'];

$shop_obj->schedule_date= date('j,M Y', strtotime($schedule_date12));
$shop_obj->shop_token = $shop_row['shop_token'];
$shop_obj->shop_name = $shop_row['name'];
$shop_obj->qty_total_count = $shop_row['qty_total_count'];
$shop_obj->total_amt = number_format((float)$shop_row['total_amt'], 2, '.', '');



$array =array();
$amount = mysqli_query($link,"SELECT
                        products.name,
                        SUM(orders__items.quantity) AS qty,
                        SUM( orders__items.quantity * orders__items.price_per_unit ) AS amount,
                        products.token AS products_token,
                        orders__items.units
                    FROM
                      orders
                    INNER JOIN units__shop_mapping ON orders.shop_token = units__shop_mapping.shop_token
                    INNER JOIN orders__items ON orders.token = orders__items.order_token
                    INNER JOIN products ON products.token = orders__items.product_token
                    WHERE
                       orders.shop_token = $shop_id and delivery='Pending'
                    GROUP BY
                        orders__items.product_token");
                                        //        
                            
while ($amt_value = mysqli_fetch_array($amount)){
$obj_data = new stdClass;
$obj_data->product_name=$amt_value['name'];
$obj_data->product_qty=intval($amt_value['qty']);
$obj_data->units=$amt_value['units'];

if($amt_value['units'] == 'Box'){
    $value = $amt_value['amount']*$box_value;
    $obj_data->product_amount = number_format((float)$value, 2, '.', '');
}else{
    $value = $amt_value['amount'];
    $obj_data->product_amount = number_format((float)$value, 2, '.', '');
}

// $obj_data->product_amount=intval($amt_value['amount']);
$obj_data->products_token=intval($amt_value['products_token']);

    array_push($array,$obj_data);
}

$delivery_data = new stdClass;

$delivery_data->shop_details = $shop_obj;
$delivery_data->prodcut = $array;



$obj = new stdClass;
if($employee_id){
    $obj->status_code=200; 
    $obj->message='Product found';
    $obj->title='Success';
    $obj->data = $delivery_data;
    
} else {
    $obj->status_code=400; 
    $obj->message='Product not found';
    $obj->title='Success';
    
}
echo json_encode($obj);
?>