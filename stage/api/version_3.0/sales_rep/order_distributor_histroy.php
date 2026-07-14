<?php
include "../../config.php";
$json_input = getInputs();
$employee_id = $json_input->employee_id;
$distributor_token = $json_input->distributor_token;

$array = array();



// $outstanding_amount = mysqli_query($link,"SELECT
//                     SUM(orders.billing_amount - orders.paid_amount) AS outstanding_amt,
//                     SUM(orders.bill_discount_amount) as bill_discount_amount,
//                     SUM(orders.bill_discount_percentage) as bill_discount_percentage,
//                     SUM(CASE WHEN orders.bill_discount_percentage !=0 THEN((orders.`billing_amount`*orders.`bill_discount_percentage`)/100) ELSE 0 END) as percentage_value
//                 FROM
//                     orders
//                 INNER JOIN shop ON shop.token = orders.shop_token 
//                 WHERE
//                     shop.token = $shop_id and orders.delivery != 'Cancelled'");
// $get_outstanding_amt = mysqli_fetch_array($outstanding_amount);
// $amount_val = new stdClass;
//       $bill_discount_amount = $get_outstanding_amt['bill_discount_amount'];
//       $bill_discount_percentage = $get_outstanding_amt['bill_discount_percentage'];
//       $percentage_value = $get_outstanding_amt['percentage_value'];

//      if($bill_discount_amount > 0) {
//                     $discount_amount_finall1 = round($bill_discount_amount);
//                  } 
                
//                   else {
//                     $discount_amount_finall1 = 0;
//                  }
// $discount_amount_finall = $discount_amount_finall1+$percentage_value;

//     $amount_val->outstanding_amount_value = round($get_outstanding_amt['outstanding_amt']-$discount_amount_finall);


$order_hisyory = mysqli_query($link,"SELECT
                                orders.date_time AS schedule_date,
                                orders.token,
                                orders.order_number,
                                COALESCE(orders.items,0) AS items,
                                orders.shop_token,
                                orders.billing_amount,
                                orders.paid_amount,
                                ( orders.billing_amount - orders.paid_amount ) AS outstanding_amt,
                                orders.delivery,
                                orders.employee_token,
                                orders.bill_discount_amount,
                                orders.bill_discount_percentage,
                                ( CASE WHEN orders.bill_discount_percentage != 0 THEN( ( orders.`billing_amount` * orders.`bill_discount_percentage` ) / 100 ) ELSE 0  END
                            ) AS percentage_value
                            FROM
                                orders
                            LEFT JOIN employees ON employees.token = orders.employee_token
                            WHERE
                                orders.employee_token = $distributor_token  AND `orders`.`order_type`='Distributor Order'
                            ORDER BY
                                orders.id
                            DESC");

while($order_row = mysqli_fetch_array($order_hisyory)) {
    $obj_order = new stdClass;
        $schedule_date12= $order_row['schedule_date'];
        $convert_date= date('j,M Y', strtotime($schedule_date12));
        $obj_order->schedule_date= $convert_date;
        $obj_order->order_token= $order_row['token'];
        // $obj_order->paid_amount= round($order_row['paid_amount']);
        $obj_order->items= $order_row['items'];
        $obj_order->billing_amount= round($order_row['billing_amount']);
        $obj_order->order_number= $order_row['order_number'];
        array_push($array,$obj_order);
}


$obj_data = new stdClass;
// $obj_data->outstanding_value = $amount_val;
$obj_data->order_hisyory_data = $array;




$obj = new stdClass;
if($employee_id){
    $obj->status_code=200; 
    $obj->message='Product found';
    $obj->title='Success';
    $obj->data = $obj_data;
    
} else {
    $obj->status_code=400; 
    $obj->message='Product not found';
    $obj->title='Failed';
    
}
echo json_encode($obj);
?>