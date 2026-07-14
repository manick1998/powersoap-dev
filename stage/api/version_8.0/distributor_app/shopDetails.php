<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include "../../config.php";
$json_input = getInputs();
$distributorToken = $json_input->distributor_token;
$shop_id = $json_input->shop_id;
$shop_query = mysqli_query($link,"SELECT
                shop.name AS shop_name,
                shop.token AS token,
                shop__type.name AS shop_type,
                shop.mobile_number,
                shop.coordinates,
                shop.address,
                shop.city,
                COALESCE(SUM(shop__outstanding.bill_amount),0) AS out_bill_amount,
                COALESCE(SUM(shop__outstanding.paid_amt),0) AS out_paid_amt,
                COALESCE(SUM(shop__outstanding.total_outstanding),0) AS out_total_outstanding,
                COALESCE(SUM(orders.billing_amount),0) AS bill_amt_val,
                COALESCE(SUM(orders.paid_amount),0) AS paid_amt_val,
                COALESCE(SUM(orders.items),0) AS items,
                COALESCE(SUM(orders.billing_amount),0) AS amount,
                COALESCE(SUM(orders.bill_discount_amount),0) AS bill_discount_amount,
                COALESCE(SUM(orders.bill_discount_percentage),0) AS bill_discount_percentage,
                SUM(CASE WHEN orders.bill_discount_percentage != 0 THEN((orders.`billing_amount` * orders.`bill_discount_percentage`) / 100) ELSE 0 END) AS percentage_value,
                shop.shop_show_status,
                COALESCE(units.name,'') AS `unit_name`
                FROM `shop`
                INNER JOIN shop__type ON shop.shop_type_code = shop__type.token
                LEFT JOIN shop__outstanding ON shop__outstanding.shop_token = shop.token
                LEFT JOIN orders ON orders.shop_token = shop.token
                LEFT JOIN units ON units.token = shop.unit_token
                WHERE shop.distributor_token = $distributorToken AND shop.token = $shop_id
                GROUP BY orders.distributor_token");
                $shop_obj = new stdClass;                 
                $shop_row = mysqli_fetch_array($shop_query);
                $bill_discount_amount = $shop_row['bill_discount_amount'];
                $bill_discount_percentage = $shop_row['bill_discount_percentage'];
                    if($bill_discount_amount > 0) {
                        $discount_amount_finall1 = round($bill_discount_amount);
                    } 
                    else {
                    $discount_amount_finall1 = 0;
                    }
                $discount_amount_finall=$discount_amount_finall1+$shop_row['percentage_value'];
                $shop_obj->shop_name= $shop_row['shop_name'];
                $shop_obj->address= $shop_row['address'];
                $shop_obj->city= $shop_row['city'];
                $shop_obj->shop_type= $shop_row['shop_type'];
                $shop_obj->mobile_number= $shop_row['mobile_number'];
                $shop_obj->bill_amount= round($shop_row['bill_amt_val']-$discount_amount_finall);
                $shop_obj->paid_amt= round($shop_row['paid_amt_val']);
                $shop_obj->total_outstanding= round(($shop_row['bill_amt_val']-$discount_amount_finall)-$shop_row['paid_amt_val']);
                $shop_obj->coordinates= utf8_encode($shop_row['coordinates']);
                $shop_obj->shop_status= $shop_row['shop_show_status'];
                $shop_obj->unit_name= $shop_row['unit_name'];
$obj= new stdClass; 
if($distributorToken !='') {
    $obj->status_code=200; 
    $obj->message='Shop found';
    $obj->title='Success';
    $obj->data=$shop_obj;
}else {
    $obj->status_code=400; 
    $obj->message='Shop not found';
    $obj->title='Failure';
}
echo json_encode($obj);
?>