<?php
include "../../config.php";
$json_input = getInputs();
$employee_id = $json_input->employee_id;
$shop_id = $json_input->shop_id;

$shop_data = mysqli_query($link,"SELECT
                shop.name,
                  COALESCE(SUM(orders.items),0) as items,
                COALESCE(SUM(orders.billing_amount),0) as amount,
                shop.token,
                shop__type.name as shop_type,
                shop.mobile_number,
                COALESCE(GROUP_CONCAT(DISTINCT orders.delivery ORDER by orders.delivery),'NoOrder') as delivery
                -- COALESCE(orders.delivery,'NoOrder') as delivery
            FROM
                `daily_schedule`
            INNER JOIN units__shop_mapping ON units__shop_mapping.unit_group_token = daily_schedule.unit_token
            left JOIN orders ON orders.shop_token = units__shop_mapping.shop_token
            INNER JOIN shop ON shop.token= units__shop_mapping.shop_token
            INNER JOIN shop__type on  shop__type.token= shop.shop_type_code
            WHERE
                daily_schedule.delivery_emp_token = $employee_id AND shop.token=$shop_id GROUP BY orders.shop_token ");
                
$shop_row = mysqli_fetch_array($shop_data);
$obj_shop = new stdClass;
 $obj_shop->name= $shop_row['name'];
 $obj_shop->items= $shop_row['items'];
 $obj_shop->amount= $shop_row['amount'];
 $obj_shop->token= $shop_row['token'];
 $obj_shop->shop_type= $shop_row['shop_type'];
 $obj_shop->mobile_number= $shop_row['mobile_number'];
 // $obj_shop->status_val= $shop_row['delivery'];
 $obj_shop->status_val=explode(',', $shop_row['delivery'])[0] ;
 
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

?>