
<?php
//  ini_set('display_errors', 1);// show error reporting
//   error_reporting(E_ALL);
include "../../config.php";
$json_input = getInputs();
$employee_id = $json_input->employee_id;
$order_date = date('Y-m-d h:i:s');
 $dayname =  date('l', strtotime($order_date));
$home_data=array();
//echo $indiaDate;
$dateonly = $indiaDate;
// $dateonly;

//order pending and pending item 

// $amount = mysqli_query($link,"SELECT
// SUM(CASE WHEN orders.delivery='Pending' THEN 1 ELSE 0 END)as pending_count,
// SUM(CASE WHEN orders.delivery='Completed' THEN 1 ELSE 0 END) as Completed_count,
// SUM(CASE WHEN orders.delivery = 'Pending' THEN orders.items ELSE 0 END) AS pending_items,
// SUM(CASE WHEN orders.delivery = 'Completed' THEN orders.items ELSE 0 END) as completed_items

// FROM
// `custom_daily_schedule`
// INNER JOIN unit_customise_mapping ON custom_daily_schedule.custom_unit_token = unit_customise_mapping.custom_unit_token
// INNER JOIN units__shop_mapping ON units__shop_mapping.unit_group_token = unit_customise_mapping.unit_token
// INNER JOIN orders ON orders.shop_token = units__shop_mapping.shop_token
// WHERE
// custom_daily_schedule.delivery_emp_token = $employee_id AND orders.order_type='Sales Order' AND custom_daily_schedule.schedule_date='$dayname'");
                            
//  $amt_value = mysqli_fetch_array($amount);

//shop_count_value
$sql = "SELECT * FROM `daily_schedule` WHERE delivery_emp_token=$employee_id AND date(date_time)='$dateonly'";
$result = $link->query($sql);
$count = $result->num_rows;
if ($count == 0) {
    


$overallCount  = mysqli_query($link,"SELECT
COUNT(shop.token) as count_value
FROM
`custom_daily_schedule`
INNER JOIN unit_customise_mapping ON unit_customise_mapping.custom_unit_token = custom_daily_schedule.custom_unit_token

INNER JOIN units__shop_mapping ON units__shop_mapping.unit_group_token = unit_customise_mapping.unit_token
INNER JOIN shop__outstanding ON shop__outstanding.shop_token = units__shop_mapping.shop_token
INNER JOIN shop on shop.token=units__shop_mapping.shop_token
WHERE
custom_daily_schedule.delivery_emp_token = $employee_id AND units__shop_mapping.delete_status =1 AND custom_daily_schedule.schedule_date='$dayname'");
                            
                            $overallCount_row = mysqli_fetch_array($overallCount);
//order logs statuscheck 

             $shop_value1 = mysqli_query($link,"SELECT * FROM `sales__log` WHERE `date_time` LIKE '%$dateonly%' AND `sales_token` = $employee_id");
                  $shoptake_value12 = mysqli_num_rows($shop_value1);
//orders item quantity check and pending

$pending_items = mysqli_query($link,"SELECT SUM(CASE WHEN orders__items.units = 'Box' THEN (orders__items.quantity*products.piece_count )ELSE orders__items.quantity END) AS pending_items
                       
                    FROM
                        `custom_daily_schedule`
                    INNER JOIN unit_customise_mapping ON  custom_daily_schedule.custom_unit_token = unit_customise_mapping.custom_unit_token
                    INNER JOIN units__shop_mapping ON units__shop_mapping.unit_group_token = unit_customise_mapping.unit_token
                    INNER JOIN orders ON orders.shop_token = units__shop_mapping.shop_token
                    INNER JOIN orders__items ON orders__items.order_token = orders.token
                    INNER JOIN products ON products.token = orders__items.product_token
                    WHERE
                        custom_daily_schedule.delivery_emp_token = $employee_id AND orders.order_type in ('Sales Order','Spot Order') AND custom_daily_schedule.schedule_date='$dayname' AND orders.delivery='Pending' AND  orders__items.delete_status=1 AND orders.date_time < '$dateonly 23:59:59'
                        GROUP BY orders__items.id");

$pending_items_row = mysqli_fetch_array($pending_items);
$get_pending_items = $pending_items_row['pending_items'];

//orders item quantity check and complited

$completed_items = mysqli_query($link,"SELECT
SUM(CASE WHEN orders__items.units = 'Box' THEN (orders__items.quantity*products.piece_count )ELSE orders__items.quantity END) AS completed_items
 
FROM
 `custom_daily_schedule`
INNER JOIN unit_customise_mapping ON custom_daily_schedule.custom_unit_token = unit_customise_mapping.custom_unit_token
INNER JOIN units__shop_mapping ON units__shop_mapping.unit_group_token = unit_customise_mapping.unit_token
INNER JOIN orders ON orders.shop_token = units__shop_mapping.shop_token
INNER JOIN orders__items ON orders__items.order_token = orders.token
INNER JOIN products ON products.token = orders__items.product_token
WHERE
 custom_daily_schedule.delivery_emp_token = $employee_id AND orders.order_type in ('Sales Order','Spot Order') AND custom_daily_schedule.schedule_date='$dayname' AND orders.delivery='Completed' AND  orders__items.delete_status=1 AND orders.delivered_on LIKE '$dateonly%'");

$completed_items_row = mysqli_fetch_array($completed_items);
$get_completed_items = $completed_items_row['completed_items'];
//order transaction amount
$today_collection = mysqli_query($link,"SELECT SUM(`amount`) as today_amount FROM `shop__order_transaction` WHERE `employee_id` = $employee_id AND `date_time` LIKE '$dateonly%'");
$get_today_amt  = mysqli_fetch_array($today_collection);
$today_collection_amount  = $get_today_amt['today_amount'];
//total order amount
            $over_all_amount = mysqli_query($link,"SELECT SUM(billing_amount) as overallamt FROM `orders` WHERE `employee_token` =$employee_id AND date_time LIKE '$dateonly%' AND `order_type`='Sales Order'");
            $get_all_amount = mysqli_fetch_array($over_all_amount);
            $overall_item_amt = $get_all_amount['overallamt'];


// today_collection
            $total_amount = mysqli_query($link,"SELECT SUM(amount) as total_amt FROM `shop__order_transaction` WHERE `employee_id`='$employee_id' AND date_time LIKE'$indiaDate%'");
            $get_total_amt = mysqli_fetch_array($total_amount);
            $employee_total_amount = $get_total_amt['total_amt'];


$obj_data = new stdClass;
$obj_data->cover_today_value= intval($shoptake_value12);// intval($amt_value['Completed_count']);
$obj_data->cover_today_outoff= intval($overallCount_row['count_value']);//intval($amt_value['pending_count']+$amt_value['Completed_count']);


$obj_data->today_items_value = intval($get_completed_items);//intval($amt_value['completed_items']);
$obj_data->today_outoff_items =  intval( $get_completed_items+$get_pending_items );//intval($amt_value['pending_items'] + $amt_value['completed_items']);
$obj_data->today_collection = intval($employee_total_amount);//intval($amt_value['total_amt']);
$obj_data->achived_productivity = intval($shoptake_value12);//3;
$obj_data->overall_productivity = intval($overallCount_row['count_value']);//5;
$obj_data->today_collection_amount = round($today_collection_amount);//5;
$obj_data->overall_item_amount_value = round($overall_item_amt);//5;

// echo $shoptake_value12;
if($shoptake_value12 > 0){
    if($overallCount_row['count_value'] ==0){
    $obj_data->overall =0;// round(($shoptake_value12/$overallCount_row['count_value'])*5);
    }else{
        $obj_data->overall = round(($shoptake_value12/$overallCount_row['count_value'])*5);
    }

}else{
$obj_data->overall = 0;//round(($shoptake_value12/$amt_value['count_value'])*5);
}
$shop_array = array();

 // echo $dateonly;
// shopDetails
$shop_list = mysqli_query($link,"SELECT
orders.id,
shop.name,
shop.token,
shop.address,
shop.city,
shop.pincode,
COALESCE( SUM(orders.items) ,0) AS items,
COALESCE(SUM(orders.billing_amount),0) AS bill_amt,
COALESCE(SUM(orders.paid_amount),0) AS paid_amt,
shop__type.name AS shop_type,
COALESCE(GROUP_CONCAT(DISTINCT orders.delivery ORDER by orders.delivery),'NoOrder') as delivery,
units.name as units_name,
SUM(orders.bill_discount_amount) as bill_discount_amount,
SUM(CASE WHEN bill_discount_percentage !=0 THEN((`billing_amount`*`bill_discount_percentage`)/100) ELSE 0 END) as percentage_value
FROM
`custom_daily_schedule`
INNER JOIN unit_customise_mapping ON custom_daily_schedule.custom_unit_token = unit_customise_mapping.custom_unit_token
INNER JOIN units__shop_mapping ON units__shop_mapping.unit_group_token = unit_customise_mapping.unit_token
LEFT JOIN orders ON orders.shop_token = units__shop_mapping.shop_token   and orders.delivery != 'Cancelled' AND orders.date_time <'$dateonly 23:59:59'
INNER JOIN shop ON shop.token = units__shop_mapping.shop_token
INNER JOIN shop__type ON shop__type.token = shop.shop_type_code
INNER JOIN units ON units.token =unit_customise_mapping.unit_token
WHERE
custom_daily_schedule.delivery_emp_token = $employee_id AND custom_daily_schedule.schedule_date='$dayname' AND units__shop_mapping.delete_status ='1' 
GROUP BY shop.token
 ORDER BY shop.id Desc");
                        
while($row_shop = mysqli_fetch_array($shop_list)) {
    $cancell_status = explode(',', $row_shop['delivery'])[0];;
     $shop_obj = new stdClass;


     $shop_token = $row_shop['token'];
     
//getting balance and paid amount

 $shop_total_value = mysqli_query($link,"SELECT
 SUM(`billing_amount`) AS billing_amount1,
 (`paid_amount`) AS paid_amount1,
 SUM(`bill_discount_amount`) AS bill_discount_amount,
 SUM(bill_discount_percentage) AS bill_discount_percentage,
 SUM(CASE WHEN bill_discount_percentage !=0 THEN((`billing_amount`*`bill_discount_percentage`)/100) ELSE 0 END) as percentage_value
FROM
 `orders`
WHERE
 `shop_token` = '$shop_token' AND `delivery` != 'Cancelled'");
             $get_shop_total_value = mysqli_fetch_array($shop_total_value);
             $shop_bill_value = $get_shop_total_value['billing_amount1'];
             $shop_paid_value = $get_shop_total_value['paid_amount1'];
             $percentage_value = $get_shop_total_value['percentage_value'];


               $bill_discount_amount = $get_shop_total_value['bill_discount_amount'];
               

                 if($bill_discount_amount > 0) {
                        $discount_amount_finall1 = round($bill_discount_amount);
                     } 
                     else {
                        $discount_amount_finall1 = 0;
                     }
                     $discount_amount_finall = $discount_amount_finall1  + $percentage_value;



 

     $shop_obj->shop_name = $row_shop['name'];
     $shop_obj->shop_items = $row_shop['items'];
     $shop_obj->shop_total = round(($get_shop_total_value['billing_amount1'] - $discount_amount_finall) - $get_shop_total_value['paid_amount1']);
     $shop_obj->paid_amt = round($get_shop_total_value['paid_amount1'] );
     $shop_obj->balance_amt = round(($get_shop_total_value['billing_amount1'] - $discount_amount_finall )- $get_shop_total_value['paid_amount1']);

     $shop_obj->shop_type = $row_shop['shop_type'];
     $shop_obj->shop_token = $row_shop['token'];
     $shop_obj->shop_distance = '4km';
     $shop_obj->units_name = $row_shop['units_name'];
     $shop_obj->address = $row_shop['address'];
     $shop_obj->city = $row_shop['city'];
     $shop_obj->pincode = $row_shop['pincode'];
     
     if($cancell_status == 'Cancelled'){
     $shop_obj->shop_status ='NoOrder';
 }
 else { 
$shop_obj->shop_status = explode(',', $row_shop['delivery'])[0];
 }
 
    array_push($shop_array,$shop_obj);
}


        $home_screen = new stdClass;
        $home_screen->summary_details = $obj_data;
        $home_screen->shop_details = $shop_array;


$obj = new stdClass;
if($employee_id){
    $obj->status_code=200; 
    $obj->message='Product found';
    $obj->title='Success';
    $obj->data = $home_screen;
    
} else {
    $obj->status_code=400; 
    $obj->message='Product not found';
    $obj->title='Success';
    
}
echo json_encode($obj);
}
else {
    echo"no data";
    $overallCount  = mysqli_query($link,"SELECT
                        COUNT(shop.token) as count_value
                    FROM
                        `daily_schedule`
                    INNER JOIN units__shop_mapping ON units__shop_mapping.unit_group_token = daily_schedule.unit_token
                    INNER JOIN shop__outstanding ON shop__outstanding.shop_token = units__shop_mapping.shop_token
                    INNER JOIN shop on shop.token=units__shop_mapping.shop_token
                    WHERE
                        delivery_emp_token = $employee_id AND units__shop_mapping.delete_status =1 AND daily_schedule.schedule_date='$dayname'");
                            
                            $overallCount_row = mysqli_fetch_array($overallCount);
//order logs statuscheck 

             $shop_value1 = mysqli_query($link,"SELECT * FROM `sales__log` WHERE `date_time` LIKE '%$dateonly%' AND `sales_token` = $employee_id");
                            // $shop_value1 = mysqli_query($link,"SELECT
                                                        // DISTINCT sales__log.shop_token
                                                    // FROM
                                                        // `sales__log`
                                                        // inner JOIN units__shop_mapping ON units__shop_mapping.shop_token = sales__log.shop_token
                                                    // WHERE
                                                        // `date_time` LIKE '$dateonly%' AND `sales_token` = '$employee_id' AND units__shop_mapping.delete_status=1  GROUP BY units__shop_mapping.unit_group_token");
             $shoptake_value12 = mysqli_num_rows($shop_value1);
//orders item quantity check and pending

$pending_items = mysqli_query($link,"SELECT
                       SUM(CASE WHEN orders__items.units = 'Box' THEN (orders__items.quantity*products.piece_count )ELSE orders__items.quantity END) AS pending_items
                        
                    FROM
                        `daily_schedule`
                    INNER JOIN units__shop_mapping ON units__shop_mapping.unit_group_token = daily_schedule.unit_token
                    INNER JOIN orders ON orders.shop_token = units__shop_mapping.shop_token
                    INNER JOIN orders__items ON orders__items.order_token = orders.token
                    INNER JOIN products ON products.token = orders__items.product_token
                    WHERE
                        daily_schedule.delivery_emp_token = $employee_id AND orders.order_type in ('Sales Order','Spot Order') AND daily_schedule.schedule_date='$dayname' AND orders.delivery='Pending' AND  orders__items.delete_status=1 AND orders.date_time < '$dateonly 23:59:59'");

$pending_items_row = mysqli_fetch_array($pending_items);
$get_pending_items = $pending_items_row['pending_items'];

//orders item quantity check and complited

$completed_items = mysqli_query($link,"SELECT
                       SUM(CASE WHEN orders__items.units = 'Box' THEN (orders__items.quantity*products.piece_count )ELSE orders__items.quantity END) AS completed_items
                        
                    FROM
                        `daily_schedule`
                    INNER JOIN units__shop_mapping ON units__shop_mapping.unit_group_token = daily_schedule.unit_token
                    INNER JOIN orders ON orders.shop_token = units__shop_mapping.shop_token
                    INNER JOIN orders__items ON orders__items.order_token = orders.token
                    INNER JOIN products ON products.token = orders__items.product_token
                    WHERE
                        daily_schedule.delivery_emp_token = $employee_id AND orders.order_type in ('Sales Order','Spot Order') AND daily_schedule.schedule_date='$dayname' AND orders.delivery='Completed' AND  orders__items.delete_status=1 AND orders.delivered_on LIKE '$dateonly%'");

$completed_items_row = mysqli_fetch_array($completed_items);
$get_completed_items = $completed_items_row['completed_items'];
//order transaction amount
$today_collection = mysqli_query($link,"SELECT SUM(`amount`) as today_amount FROM `shop__order_transaction` WHERE `employee_id` = $employee_id AND `date_time` LIKE '$dateonly%'");
$get_today_amt  = mysqli_fetch_array($today_collection);
 

$today_collection_amount  = $get_today_amt['today_amount'];
//total order amount
            $over_all_amount = mysqli_query($link,"SELECT SUM(billing_amount) as overallamt FROM `orders` WHERE `employee_token` =$employee_id AND date_time LIKE '$dateonly%' AND `order_type`='Sales Order'");

            $get_all_amount = mysqli_fetch_array($over_all_amount);
            $overall_item_amt = $get_all_amount['overallamt'];


// today_collection
            $total_amount = mysqli_query($link,"SELECT SUM(amount) as total_amt FROM `shop__order_transaction` WHERE `employee_id`='$employee_id' AND date_time LIKE'$indiaDate%'");
            $get_total_amt = mysqli_fetch_array($total_amount);
            $employee_total_amount = $get_total_amt['total_amt'];


$obj_data = new stdClass;
$obj_data->cover_today_value= intval($shoptake_value12);// intval($amt_value['Completed_count']);
$obj_data->cover_today_outoff= intval($overallCount_row['count_value']);//intval($amt_value['pending_count']+$amt_value['Completed_count']);


$obj_data->today_items_value = intval($get_completed_items);//intval($amt_value['completed_items']);
$obj_data->today_outoff_items =  intval( $get_completed_items+$get_pending_items );//intval($amt_value['pending_items'] + $amt_value['completed_items']);
$obj_data->today_collection = intval($employee_total_amount);//intval($amt_value['total_amt']);
$obj_data->achived_productivity = intval($shoptake_value12);//3;
$obj_data->overall_productivity = intval($overallCount_row['count_value']);//5;
$obj_data->today_collection_amount = round($today_collection_amount);//5;
$obj_data->overall_item_amount_value = round($overall_item_amt);//5;

// echo $shoptake_value12;
if($shoptake_value12 > 0){
    if($overallCount_row['count_value'] ==0){
    $obj_data->overall =0;// round(($shoptake_value12/$overallCount_row['count_value'])*5);
    }else{
        $obj_data->overall = round(($shoptake_value12/$overallCount_row['count_value'])*5);
    }

}else{
$obj_data->overall = 0;//round(($shoptake_value12/$amt_value['count_value'])*5);
}
$shop_array = array();

 // echo $dateonly;
// shopDetails
$shop_list = mysqli_query($link,"SELECT
                                orders.id,
                                shop.name,
                                shop.token,
                                shop.address,
                                shop.city,
                                shop.pincode,
                                COALESCE( SUM(orders.items) ,0) AS items,
                                COALESCE(SUM(orders.billing_amount),0) AS bill_amt,
                                COALESCE(SUM(orders.paid_amount),0) AS paid_amt,
                                shop__type.name AS shop_type,
                                COALESCE(GROUP_CONCAT(DISTINCT orders.delivery ORDER by orders.delivery),'NoOrder') as delivery,
                                units.name as units_name,
                                SUM(orders.bill_discount_amount) as bill_discount_amount,
                                
                                SUM(CASE WHEN bill_discount_percentage !=0 THEN((`billing_amount`*`bill_discount_percentage`)/100) ELSE 0 END) as percentage_value
                                -- COALESCE(orders.delivery,'NoOrder') as delivery
                            FROM
                                `daily_schedule`
                            INNER JOIN units__shop_mapping ON units__shop_mapping.unit_group_token = daily_schedule.unit_token
                            LEFT JOIN orders ON orders.shop_token = units__shop_mapping.shop_token   and orders.delivery != 'Cancelled' AND orders.date_time <'$dateonly 23:59:59'
                            INNER JOIN shop ON shop.token = units__shop_mapping.shop_token
                            INNER JOIN shop__type ON shop__type.token = shop.shop_type_code
                            INNER JOIN units ON units.token = daily_schedule.unit_token
                            WHERE
                                daily_schedule.delivery_emp_token = $employee_id AND daily_schedule.schedule_date='$dayname' AND units__shop_mapping.delete_status =1  
                                GROUP BY shop.token
                                 ORDER BY shop.id Desc");
// AND orders.date_time LIKE '$dateonly%'
                            
while($row_shop = mysqli_fetch_array($shop_list)) {
    $cancell_status = explode(',', $row_shop['delivery'])[0];;
     $shop_obj = new stdClass;


     $shop_token = $row_shop['token'];
     
//getting balance and paid amount

 $shop_total_value = mysqli_query($link,"SELECT
                                    SUM(`billing_amount`) AS billing_amount1,
                                    (`paid_amount`) AS paid_amount1,
                                    SUM(`bill_discount_amount`) AS bill_discount_amount,
                                    SUM(bill_discount_percentage) AS bill_discount_percentage,
                                    SUM(CASE WHEN bill_discount_percentage !=0 THEN((`billing_amount`*`bill_discount_percentage`)/100) ELSE 0 END) as percentage_value
                                FROM
                                    `orders`
                                WHERE
                                    `shop_token` = '$shop_token' AND `delivery` != 'Cancelled'");
             $get_shop_total_value = mysqli_fetch_array($shop_total_value);
             $shop_bill_value = $get_shop_total_value['billing_amount1'];
             $shop_paid_value = $get_shop_total_value['paid_amount1'];
             $percentage_value = $get_shop_total_value['percentage_value'];


               $bill_discount_amount = $get_shop_total_value['bill_discount_amount'];
               

                 if($bill_discount_amount > 0) {
                        $discount_amount_finall1 = round($bill_discount_amount);
                     } 
                     else {
                        $discount_amount_finall1 = 0;
                     }
                     $discount_amount_finall = $discount_amount_finall1  + $percentage_value;



 

     $shop_obj->shop_name = $row_shop['name'];
     $shop_obj->shop_items = $row_shop['items'];
     $shop_obj->shop_total = round(($get_shop_total_value['billing_amount1'] - $discount_amount_finall) - $get_shop_total_value['paid_amount1']);
     $shop_obj->paid_amt = round($get_shop_total_value['paid_amount1'] );
     $shop_obj->balance_amt = round(($get_shop_total_value['billing_amount1'] - $discount_amount_finall )- $get_shop_total_value['paid_amount1']);

     $shop_obj->shop_type = $row_shop['shop_type'];
     $shop_obj->shop_token = $row_shop['token'];
     $shop_obj->shop_distance = '4km';
     $shop_obj->units_name = $row_shop['units_name'];
     $shop_obj->address = $row_shop['address'];
     $shop_obj->city = $row_shop['city'];
     $shop_obj->pincode = $row_shop['pincode'];
     
     if($cancell_status == 'Cancelled'){
     $shop_obj->shop_status ='NoOrder';// explode(',', $row_shop['delivery'])[0];
 }
 else { 
$shop_obj->shop_status = explode(',', $row_shop['delivery'])[0];
 }

// if($cancell_status  == 'Completed') {
//         $shop_token_value = $row_shop['token'];
//         $shop_completed_status = mysqli_query($link,"SELECT 1  FROM `orders` WHERE `shop_token` = '$shop_token_value' AND `date_time` LIKE '$dateonly%'");
//          $check_complete_status = mysqli_num_rows($shop_completed_status);
//         if($check_complete_status == 0){
//             $shop_obj->shop_status ='NoOrder';

//         }
//      }

 
    array_push($shop_array,$shop_obj);
}


        $home_screen = new stdClass;
        $home_screen->summary_details = $obj_data;
        $home_screen->shop_details = $shop_array;


$obj = new stdClass;
if($employee_id){
    $obj->status_code=200; 
    $obj->message='Product found';
    $obj->title='Success';
    $obj->data = $home_screen;
    
} else {
    $obj->status_code=400; 
    $obj->message='Product not found';
    $obj->title='Success';
    
}
echo json_encode($obj);
}
?>
