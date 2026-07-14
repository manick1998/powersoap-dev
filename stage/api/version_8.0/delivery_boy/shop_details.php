<?php
include "../../config.php";
$json_input = getInputs();
$employee_id = $json_input->employee_id;
$shop_id = $json_input->shop_id;
$order_date = date('Y-m-d h:i:s');
 $dayname =  date('l', strtotime($order_date));
$home_data=array();
//echo $indiaDate;
$dateonly = $indiaDate;

$sql = "SELECT * FROM `daily_schedule` WHERE delivery_emp_token='$employee_id' AND schedule_date = '$dayname'";
$result = $link->query($sql);
$count = $result->num_rows;
//echo $count;
if ($count == 0) {
    $shop_data = mysqli_query($link,"SELECT
    shop.name,
    COALESCE(SUM(orders.items),
    0) AS items,
    COALESCE(SUM(orders.billing_amount),
    0) AS amount,
    shop.token,
    shop__type.name AS shop_type,
    shop.mobile_number,
    shop.coordinates,
    COALESCE(
        GROUP_CONCAT(
            DISTINCT orders.delivery
        ORDER BY
            orders.delivery
        ),
        'NoOrder'
    ) AS delivery,
    units.name AS units_name,
    shop.address,
    shop.city,
    shop.shop_show_status
    -- COALESCE(orders.delivery,'NoOrder') as delivery
FROM
    `custom_daily_schedule`
INNER JOIN unit_customise_mapping ON unit_customise_mapping.custom_unit_token = custom_daily_schedule.custom_unit_token
INNER JOIN units__shop_mapping ON units__shop_mapping.unit_group_token = unit_customise_mapping.unit_token
LEFT JOIN orders ON orders.shop_token = units__shop_mapping.shop_token
INNER JOIN shop_mapping ON shop_mapping.token= units__shop_mapping.shop_token
INNER JOIN shop ON shop.token = shop_mapping.shop_token
INNER JOIN shop__type ON shop__type.token = shop.shop_type_code
INNER JOIN units ON units.token = units__shop_mapping.unit_group_token
WHERE
    custom_daily_schedule.delivery_emp_token = '$employee_id' AND shop.token='$shop_id' GROUP BY orders.shop_token");
                
$shop_row = mysqli_fetch_array($shop_data);
$obj_shop = new stdClass;
 $obj_shop->name= $shop_row['name'];
 $obj_shop->items= $shop_row['items'];
 $obj_shop->amount= $shop_row['amount'];
 $obj_shop->token= $shop_row['token'];
 $obj_shop->shop_type= $shop_row['shop_type'];
 $obj_shop->mobile_number= $shop_row['mobile_number'];
 $obj_shop->units_name= $shop_row['units_name'];
 $obj_shop->address= $shop_row['address'];
 $obj_shop->city= $shop_row['city'];
 $obj_shop->status_val=explode(',', $shop_row['delivery'])[0] ;
 $obj_shop->coordinates= utf8_encode($shop_row['coordinates']);
 $obj_shop->shop_status= $shop_row['shop_show_status'];
 
 
 $obj = new stdClass;
if($shop_id){
    $obj->status_code=200; 
    $obj->message='Product found';
    $obj->title='Success';
    $obj->data = $obj_shop;
    
} else {
    $obj->status_code=400; 
    $obj->message='Product not found';
    $obj->title='Success';
    
}
echo json_encode($obj);
}

else{
    $shop_data = mysqli_query($link,"SELECT
    shop.name,
      COALESCE(SUM(orders.items),0) as items,
    COALESCE(SUM(orders.billing_amount),0) as amount,
    shop.token,
    shop__type.name as shop_type,
    shop.mobile_number,
    shop.coordinates,
    COALESCE(GROUP_CONCAT(DISTINCT orders.delivery ORDER by orders.delivery),'NoOrder') as delivery,
    units.name as units_name,
    shop.address,
    shop.city,
    shop.shop_show_status
FROM
    `daily_schedule`
INNER JOIN units__shop_mapping ON units__shop_mapping.unit_group_token = daily_schedule.unit_token
left JOIN orders ON orders.shop_token = units__shop_mapping.shop_token
INNER JOIN shop_mapping ON shop_mapping.token= units__shop_mapping.shop_token
INNER JOIN shop ON shop.token = shop_mapping.shop_token
INNER JOIN shop__type on  shop__type.token= shop.shop_type_code
INNER JOIN units ON units.token = daily_schedule.unit_token
WHERE
    daily_schedule.delivery_emp_token = '$employee_id' AND shop.token='$shop_id' GROUP BY orders.shop_token ");
    
$shop_row = mysqli_fetch_array($shop_data);
$obj_shop = new stdClass;
$obj_shop->name= $shop_row['name'];
$obj_shop->items= $shop_row['items'];
$obj_shop->amount= $shop_row['amount'];
$obj_shop->token= $shop_row['token'];
$obj_shop->shop_type= $shop_row['shop_type'];
$obj_shop->mobile_number= $shop_row['mobile_number'];
$obj_shop->units_name= $shop_row['units_name'];
$obj_shop->address= $shop_row['address'];
$obj_shop->city= $shop_row['city'];
$obj_shop->status_val=explode(',', $shop_row['delivery'])[0] ;
$obj_shop->coordinates= utf8_encode($shop_row['coordinates']);
$obj_shop->shop_status= $shop_row['shop_show_status'];


$obj = new stdClass;
if($shop_id){
$obj->status_code=200; 
$obj->message='Product found';
$obj->title='Success';
$obj->data = $obj_shop;

} else {
$obj->status_code=400; 
$obj->message='Product not found';
$obj->title='Success';

}
echo json_encode($obj);
}


?>