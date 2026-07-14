<?php
include "../../config.php";
$json_input = getInputs();
$employee_id = $json_input->employee_id;
$searchText = $json_input->search_text;
$home_data = array();
date_default_timezone_set("Asia/Kolkata");   //India time (GMT+5:30)
$order_date = date('Y-m-d h:i:s');
$dateonly = $indiaDate;
$dayname =  date('l', strtotime($order_date));



//distributor_token
$get_distributor_id = mysqli_query($link, "SELECT `admin_distributor_token` FROM `employees` where `token` = '$employee_id'");
$row_id = mysqli_fetch_array($get_distributor_id);
$distributor_id = $row_id['admin_distributor_token'];


$sql = "SELECT * FROM `daily_schedule` WHERE sales_emp_token = $employee_id  AND schedule_date = '$dayname'";
$amount = $link->query($sql);
$data = $amount->num_rows;

$sql1 = "SELECT * FROM custom_daily_schedule WHERE sales_emp_token =$employee_id AND schedule_date = '$dayname'";
$amount1 = $link->query($sql1);
$data1 = $amount1->num_rows;

if ($data1 == 1 && $data == 0) {

    $amount_val1 = mysqli_query($link, "SELECT shop.id,
  shop.token AS shop_token,
  shop.name,
  shop__type.name as type_name,
  shop.address,
  shop.city,
  shop.pincode,
  unit_customise_mapping.unit_token AS unit_token,
  units.name AS units_name,
  COALESCE(SUM(orders.billing_amount),
  0) AS bill_amt_val,
  COALESCE(SUM(orders.paid_amount),
  0) AS paid_amt_val,
  shop__outstanding.bill_amount,
  shop__outstanding.paid_amt,
  shop__outstanding.total_outstanding,
  unit_customise_mapping.distributor_token,
  custom_daily_schedule.schedule_date,
  COALESCE( SUM(orders.items) ,0) AS items,
  
  COALESCE(orders.delivery, 'NoOrder') AS delivery,
  COALESCE(SUM(
      discount_order.bill_discount_amount
  ),0) AS bill_discount_amount,
 COALESCE(SUM(
      discount_order.bill_discount_percentage
  ),0) AS bill_discount_percentage
FROM
  shop

INNER JOIN shop_mapping ON shop_mapping.shop_token = shop.token
INNER JOIN unit_customise_mapping ON shop_mapping.unit_token = unit_customise_mapping.unit_token
INNER JOIN units ON unit_customise_mapping.unit_token = units.token 

INNER JOIN custom_daily_schedule ON unit_customise_mapping.custom_unit_token = custom_daily_schedule.custom_unit_token 

INNER JOIN shop__outstanding ON shop_mapping.token = shop__outstanding.shop_token


LEFT JOIN orders ON orders.shop_token = shop_mapping.token AND orders.date_time LIKE '$dateonly%' AND orders.delivery != 'Cancelled' AND custom_daily_schedule.sales_emp_token = '$employee_id'

LEFT JOIN orders AS discount_order ON discount_order.shop_token = shop.token AND discount_order.date_time < '$dateonly 23:59:59' AND discount_order.delivery != 'Cancelled'
INNER JOIN units__shop_mapping ON unit_customise_mapping.unit_token = units__shop_mapping.unit_group_token
INNER JOIN shop__type on shop__type.token = shop.shop_type_code
WHERE
  custom_daily_schedule.sales_emp_token = '$employee_id' AND custom_daily_schedule.schedule_date = '$dayname' AND shop.delete_status = '1'  AND unit_customise_mapping.delete_status = '1'  and shop.name like '%$searchText%'
GROUP BY
   shop.token
ORDER BY
  shop.id
DESC Limit 10");

    $shop_array = array();
    $discount_amount_finall_11 = 0;
    while ($shop_rows = mysqli_fetch_array($amount_val1)) {

        $delivery_check_data = $shop_rows['delivery'];
        if ($delivery_check_data == 'Pending' || $delivery_check_data == 'Completed') {
            $delivery_value = 'Completed';
        } else {
            $delivery_value = 'NoOrder';
        }
        //}

        $shop_token_data = $shop_rows['shop_token'];
        $shop_mapToken = mysqli_query($link, "SELECT `token` FROM `shop_mapping` WHERE `shop_token`='$shop_token_data' AND `distributor_token`='$distributor_id'");
        $row = mysqli_fetch_array($shop_mapToken);
        $token_map = $row['token'];
        $shop_total_value_count = mysqli_query($link, "SELECT
COALESCE(SUM(`billing_amount`),0) AS billing_amount1,
COALESCE(SUM(`paid_amount`),0) AS paid_amount1,
COALESCE(SUM(`bill_discount_amount`),0) AS bill_discount_amount,
COALESCE(SUM(CASE WHEN bill_discount_percentage !=0 THEN((`billing_amount`*`bill_discount_percentage`)/100) ELSE 0 END),0) as percentage_value,
 COALESCE( SUM(orders.items) ,0) AS items1
FROM
`orders`
WHERE
`shop_token` = '$token_map' AND `delivery` != 'Cancelled'");
        $get_shop_total_value1 = mysqli_fetch_array($shop_total_value_count);
        $shop_bill_value1 = $get_shop_total_value1['billing_amount1'];
        $shop_paid_value1 = $get_shop_total_value1['paid_amount1'];
        $percentage_value1 = $get_shop_total_value1['percentage_value'];


        $bill_discount_amount1 = $get_shop_total_value1['bill_discount_amount'];


        if ($bill_discount_amount1 > 0) {
            $discount_amount_finall_11 = round($bill_discount_amount1);
        } else {
            $discount_amount_finall_11 = 0;
        }

        $discount_amount_finall_11 = $discount_amount_finall_11  + $percentage_value1;





        $obj_shop = new stdClass;
        $obj_shop->shopId = (int)$shop_rows['id'];
        $obj_shop->shop_id = $shop_rows['shop_token'];
        $obj_shop->shop_name = $shop_rows['name'];

        $obj_shop->shop_total = round($get_shop_total_value1['billing_amount1'] - $discount_amount_finall_11);
        $obj_shop->paid_amt = round($shop_rows['paid_amt']);
        $obj_shop->balance_amt = round(($get_shop_total_value1['billing_amount1']) - ($discount_amount_finall_11 + $get_shop_total_value1['paid_amount1']));
        $get_balance_amt1 = round(($get_shop_total_value1['billing_amount1']) - ($discount_amount_finall_11 + $get_shop_total_value1['paid_amount1']));


        $obj_shop->target_amount = round($get_shop_total_value1['billing_amount1'] - $discount_amount_finall_11);
        $obj_shop->achived_amount = round($get_shop_total_value1['paid_amount1']);
        $obj_shop->balance_amount = $get_balance_amt1;
        $obj_shop->category_name = $shop_rows['type_name'];
        $obj_shop->delivery = $delivery_value;
        $obj_shop->items = $get_shop_total_value1['items1'];
        $obj_shop->address = $shop_rows['address'];
        $obj_shop->city = $shop_rows['city'];
        $obj_shop->pincode = $shop_rows['pincode'];
        $obj_shop->shop_distance = rand(1, 10);
        $obj_shop->units_name = $shop_rows['units_name'];
        array_push($shop_array, $obj_shop);
    }

    $home_screen = new stdClass;
    $home_screen->search_details = $shop_array;


    $obj = new stdClass;
    if ($employee_id && $data1 == 1) {
        $obj->status_code = 200;
        $obj->message = 'Product found';
        $obj->title = 'Success';
        $obj->data = $home_screen;
    } else {
        $obj->status_code = 400;
        $obj->message = 'Product not found';
        $obj->title = 'Success';
    }

    echo json_encode($obj);
} else {

    $shop_query = mysqli_query($link, "SELECT shop.id,
                           shop.name,
                           shop.token,
                           shop.address,
                           shop.city,
                           shop.pincode,
                           COALESCE(SUM(orders.billing_amount),0) AS bill_amt_val,
                            COALESCE(SUM(orders.paid_amount),0) AS paid_amt_val,
                           shop__outstanding.bill_amount,
                           shop__outstanding.paid_amt,
                           shop__outstanding.total_outstanding,
                           shop__type.name as type_name,
                           units.name as units_name,
                            COALESCE( SUM(orders.items) ,0) AS items,
                           COALESCE(orders.delivery,'NoOrder') as delivery,
                           SUM(discount_order.bill_discount_amount) as bill_discount_amount,
                           SUM(discount_order.bill_discount_percentage) as bill_discount_percentage
                        FROM
                            `daily_schedule`
                        INNER JOIN units__shop_mapping ON units__shop_mapping.unit_group_token = daily_schedule.unit_token
                        INNER JOIN shop__outstanding ON shop__outstanding.shop_token = units__shop_mapping.shop_token
                        LEFT JOIN orders ON orders.shop_token = units__shop_mapping.shop_token AND orders.date_time LIKE '$dateonly%' and orders.delivery != 'Cancelled' AND employee_token = $employee_id
                        LEFT JOIN orders AS discount_order ON discount_order.shop_token = units__shop_mapping.shop_token AND discount_order.date_time < '$dateonly 23:59:59' and discount_order.delivery != 'Cancelled' 
                        INNER JOIN shop_mapping on shop_mapping.token = units__shop_mapping.shop_token
                        INNER JOIN shop on shop_mapping.shop_token = shop.token
                        INNER JOIN shop__type on shop__type.token = shop.shop_type_code
                        INNER JOIN units ON units.token = daily_schedule.unit_token
                        WHERE
                            sales_emp_token = $employee_id AND units__shop_mapping.delete_status =1 AND   daily_schedule.schedule_date='$dayname'  and shop.name like '%$searchText%' GROUP BY shop.token");

    $shop_array = array();
    $discount_amount_finall = 0;
    while ($shop_row = mysqli_fetch_array($shop_query)) {

        $delivery_check = $shop_row['delivery'];
        if ($delivery_check == 'Pending' || $delivery_check == 'Completed') {
            $delivery_value = 'Completed';
        } else {
            $delivery_value = 'NoOrder';
        }



        $shop_token = $shop_row['token'];
        $shop_mapToken = mysqli_query($link, "SELECT `token` FROM `shop_mapping` WHERE `shop_token`='$shop_token' AND `distributor_token`='$distributor_id'");
        $row = mysqli_fetch_array($shop_mapToken);
        $token_map = $row['token'];
        $shop_total_value = mysqli_query($link, "SELECT
                                    SUM(`billing_amount`) AS billing_amount1,
                                    SUM(`paid_amount`) AS paid_amount1,
                                    SUM(`bill_discount_amount`) AS bill_discount_amount,
                                    SUM(CASE WHEN bill_discount_percentage !=0 THEN((`billing_amount`*`bill_discount_percentage`)/100) ELSE 0 END) as percentage_value,
                                     COALESCE( SUM(orders.items) ,0) AS items1
                                FROM
                                    `orders`
                                WHERE
                                    `shop_token` = '$token_map' AND `delivery` != 'Cancelled'");
        $get_shop_total_value = mysqli_fetch_array($shop_total_value);
        $shop_bill_value = $get_shop_total_value['billing_amount1'];
        $shop_paid_value = $get_shop_total_value['paid_amount1'];
        $percentage_value = $get_shop_total_value['percentage_value'];


        $bill_discount_amount = $get_shop_total_value['bill_discount_amount'];


        if ($bill_discount_amount > 0) {
            $discount_amount_finall1 = round($bill_discount_amount);
        } else {
            $discount_amount_finall1 = 0;
        }

        $discount_amount_finall = $discount_amount_finall1  + $percentage_value;





        $obj_shop = new stdClass;
        $obj_shop->shopId = (int)$shop_row['id'];
        $obj_shop->shop_id = $shop_row['token'];
        $obj_shop->shop_name = $shop_row['name'];

        $obj_shop->shop_total = round($get_shop_total_value['billing_amount1'] - $discount_amount_finall);
        $obj_shop->paid_amt = round($shop_row['paid_amt_val']);
        $obj_shop->balance_amt = round(($get_shop_total_value['billing_amount1']) - ($discount_amount_finall + $get_shop_total_value['paid_amount1']));
        $get_balance_amt = round(($get_shop_total_value['billing_amount1']) - ($discount_amount_finall + $get_shop_total_value['paid_amount1']));

        //$obj_shop->target_amount = round($get_shop_total_value['billing_amount1'] - $discount_amount_finall); // round($shop_row['bill_amount']);
        // $obj_shop->achived_amount = round($get_shop_total_value['paid_amount1']); //round($shop_row['paid_amt']);
        //$obj_shop->balance_amount = $get_balance_amt; //round(($get_shop_total_value['billing_amount1'] - $discount_amount_finall) - $get_shop_total_value['paid_amount1']);//round($shop_row['bill_amount'] - $shop_row['paid_amt']);

        $obj_shop->category_name = $shop_row['type_name'];
        $obj_shop->delivery = $delivery_value;
        $obj_shop->items = $get_shop_total_value['items1'];
        $obj_shop->address = $shop_row['address'];
        $obj_shop->city = $shop_row['city'];
        $obj_shop->pincode = $shop_row['pincode'];
        $obj_shop->shop_distance = rand(1, 10);
        $obj_shop->units_name = $shop_row['units_name'];
        array_push($shop_array, $obj_shop);
    }


    $home_screen = new stdClass;
    $home_screen->search_details = $shop_array;


    $obj = new stdClass;
    if ($employee_id && $data != 0) {
        $obj->status_code = 200;
        $obj->message = 'Product found';
        $obj->title = 'Success';
        $obj->data = $home_screen;
    } else {
        $obj->status_code = 400;
        $obj->message = 'Product not found';
        $obj->title = 'Success';
    }
    echo json_encode($obj);
}
