<?php
include "../../config.php";
$json_input = getInputs();
$distributorToken = $json_input->distributor_token;
$retailer_array=array();
$obj = new stdClass;
$shop_query = mysqli_query($link,"SELECT
`shop`.`token`,
`shop`.`name`,
`shop`.`address`,
`shop`.`city`,
`shop`.`pincode`,
COALESCE(`shop`.`unit_token`, 0) AS unit_token,
COALESCE(SUM(orders.billing_amount),0) AS total_amount,
COUNT(orders.token) AS total_count,
COALESCE(SUM(orders.items),0) AS items,
COALESCE(orders.delivery, 'NoOrder') AS delivery,
COALESCE(SUM(orders.paid_amount),0) AS paid_amount,
COALESCE(SUM(orders.bill_discount_amount),0) AS bill_discount_amount,
COALESCE(SUM(orders.bill_discount_percentage),0) AS bill_discount_percentage,
shop__type.name AS shop_type
FROM shop
LEFT JOIN orders ON orders.shop_token = shop.token AND orders.delivery != 'Cancelled' AND orders.distributor_token = $distributorToken
INNER JOIN shop__type ON shop__type.token = shop.shop_type_code
WHERE shop.distributor_token = $distributorToken AND shop.shop_show_status = 'Active'
GROUP BY `shop`.`token`");

while($row2 = mysqli_fetch_array($shop_query)){
    $retailer_obj = new stdClass;
    $shop_tken = $row2['token'];
    $last_date = mysqli_query($link,"SELECT
                         COALESCE(date_time,0) as last_date
                         FROM `orders`
                         WHERE `shop_token` = '$shop_tken'
                         ORDER BY `orders`.`id` desc LIMIT 1");
                        $get_last_date = mysqli_fetch_array($last_date);
                        $retailer_obj->shop_token = $row2['token'];
                        $retailer_obj->shop_name = $row2['name'];
                        $retailer_obj->total_amount = round($row2['total_amount']);
                        $total_amount = round($row2['total_amount']);
                        $retailer_obj->total_count = $row2['total_count'];
                        $retailer_obj->category_name = $row2['shop_type'];
                        $retailer_obj->address = $row2['address'];
                        $retailer_obj->city = $row2['city'];
                        $retailer_obj->pincode = $row2['pincode'];
                        $retailer_obj->items = $row2['items'];
                        $retailer_obj->unit_token = $row2['unit_token'];
                        $retailer_obj->delivery = $row2['delivery'];
                        $paid_amount= $row2['paid_amount'];
                        $bill_discount_amount = $row2['bill_discount_amount'];
                        $bill_discount_percentage = $row2['bill_discount_percentage'];
                             if($bill_discount_amount > 0) {
                                $discount_amount_finall1 = round($bill_discount_amount);
                             } 
                             else {
                                $discount_amount_finall1 = 0;
                             }
                        $discount_amount_finall = $discount_amount_finall1  + $bill_discount_percentage;
                        $get_balance_amt = round($total_amount - ($discount_amount_finall + $paid_amount));
                        $retailer_obj->balance_amount = $get_balance_amt;
                        array_push($retailer_array,$retailer_obj);
}

if($distributorToken) {
    $data = new stdClass;
    $obj->status_code=200; 
    $obj->message='Data Found';
    $obj->title='Success';
    $obj->data=$retailer_array;
}else {
    $obj->status_code=400; 
    $obj->message='No Data Found';
    $obj->title='failure';
}
echo json_encode($obj);

?>