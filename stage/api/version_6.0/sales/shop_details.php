<?php
include "../../config.php";
$json_input = getInputs();
$employee_id = $json_input->employee_id;
$shop_id = $json_input->shop_id;


//distributor_token
$stmt = mysqli_query($link,"SELECT `admin_distributor_token` FROM `employees` WHERE token='$employee_id'");
$gettoken = mysqli_fetch_array($stmt);
$distributor_token = $gettoken['admin_distributor_token'];


$shop_query = mysqli_query($link,"SELECT
shop.name AS shop_name,
COALESCE(SUM(orders.items),0) as items,
COALESCE(SUM(orders.billing_amount),0) as amount,
shop__type.name AS shop_type,
shop.mobile_number,
shop__outstanding.bill_amount,
shop__outstanding.paid_amt,
COALESCE(SUM(orders.billing_amount),0) AS bill_amt_val,
COALESCE(SUM(orders.paid_amount),0) AS paid_amt_val,
shop.coordinates,
shop__outstanding.total_outstanding,
units.name as unit_name,
shop.address,
shop.city,
sum(orders.bill_discount_amount) as bill_discount_amount,
orders.bill_discount_percentage,
SUM(CASE WHEN orders.bill_discount_percentage !=0 THEN((orders.`billing_amount`*orders.`bill_discount_percentage`)/100) ELSE 0 END) as percentage_value,
shop.shop_show_status
FROM
`shop`
INNER JOIN `shop_mapping` ON shop_mapping.shop_token = shop.token
INNER JOIN shop__type ON shop.shop_type_code = shop__type.token
INNER JOIN shop__outstanding ON shop_mapping.token = shop__outstanding.shop_token
INNER JOIN units__shop_mapping ON units__shop_mapping.shop_token = shop_mapping.token and units__shop_mapping.delete_status='1'
INNER JOIN units ON units__shop_mapping.unit_group_token=units.token and units__shop_mapping.delete_status='1'
LEFT JOIN orders ON orders.shop_token = units__shop_mapping.shop_token and orders.delivery != 'Cancelled' and units__shop_mapping.delete_status='1'
WHERE
shop.token = '$shop_id' and shop_mapping.distributor_token = '$distributor_token'   GROUP BY orders.shop_token");


   
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
  $shop_obj->bill_amount= round($shop_row['bill_amt_val'] - $discount_amount_finall);//$shop_row['bill_amount'];
  $shop_obj->paid_amt= round($shop_row['paid_amt_val']);//$shop_row['paid_amt'];
  $shop_obj->unit_name= $shop_row['unit_name'];
  $shop_obj->total_outstanding= round(($shop_row['bill_amt_val'] - $discount_amount_finall)- $shop_row['paid_amt_val']);//$shop_row['bill_amount'] - $shop_row['paid_amt'];//$shop_row['total_outstanding'];
  $shop_obj->coordinates= utf8_encode($shop_row['coordinates']);
  $shop_obj->shop_status= $shop_row['shop_show_status'];
  // $shop_obj->items= $shop_row['items'];
 // $shop_obj->amount= $shop_row['amount'];
  
  
  
$obj= new stdClass; 
if($shop_id !='') {
$obj->status_code=200; 
    $obj->message='Shop found';
    $obj->title='Success';
    $obj->data=$shop_obj;
    
    
}
else {
    $obj->status_code=400; 
    $obj->message='Shop not found';
    $obj->title='Failure';
}

echo json_encode($obj);

?>