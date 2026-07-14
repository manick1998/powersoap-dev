<?php
include "../../config.php";
$json_input = getInputs();
$employee_id = $json_input->employee_id;
$array = array();
date_default_timezone_set("Asia/Kolkata");
$order_date = date('Y-m-d h:i:s');
$dayname    =  date('l', strtotime($order_date));
$yesterday  =  date('Y-m-d', strtotime($order_date));
$obj        = new stdClass;
$overall_obj= new stdClass;
$overall_obj->product_detail = [];
$overall_obj->itemsdetail = new stdClass;
$dateonly = $indiaDate;
//schedule checking
//$sql = "SELECT * FROM `daily_schedule` WHERE delivery_emp_token=$employee_id AND date(date_time)='$dateonly' AND schedule_date = '$dayname'";
$sql = "SELECT * FROM `daily_schedule` WHERE delivery_emp_token='$employee_id'  AND schedule_date = '$dayname'";
$result = $link->query($sql);
$count = $result->num_rows;
//echo $count;
if ($count == 0) {
    $salesemp = mysqli_query($link, "SELECT
    `sales_emp_token`,
    unit_customise_mapping.custom_unit_token
FROM
    `custom_daily_schedule`
INNER JOIN unit_customise_mapping ON unit_customise_mapping.custom_unit_token = custom_daily_schedule.custom_unit_token
WHERE
    `delivery_emp_token` = $employee_id AND `schedule_date` = '$dayname' GROUP BY  unit_customise_mapping.unit_token");

    if( $sale_row = mysqli_fetch_array($salesemp) ) {
        $sale_token = $sale_row['sales_emp_token'];
          $unit_token = $sale_row['custom_unit_token'];
    
        $amount = mysqli_query($link,"SELECT
        `unit_customise_mapping`.`unit_token`,
        `units__shop_mapping`.`shop_token`,
        `orders`.`token`,
        `orders`.`date_time`,
        products.name,
        orders__items.units,
        `orders__items`.`price_per_unit`,
        SUM(
            CASE WHEN orders__items.units = 'Box' THEN(
                orders__items.quantity * products.piece_count
            ) ELSE orders__items.quantity
        END
    ) AS qty,
    SUM(
        `orders__items`.`quantity` * `orders__items`.`price_per_unit`
    ) AS amount
    FROM
        `custom_daily_schedule`
    INNER JOIN unit_customise_mapping ON unit_customise_mapping.custom_unit_token = custom_daily_schedule.custom_unit_token
    INNER JOIN `units__shop_mapping` ON `units__shop_mapping`.`unit_group_token` = `unit_customise_mapping`.`unit_token`
    INNER JOIN `orders` ON `orders`.`shop_token` = `units__shop_mapping`.`shop_token`
    INNER JOIN `orders__items` ON `orders`.`token` = `orders__items`.`order_token`
    INNER JOIN `products` ON `products`.`token` = `orders__items`.`product_token`
    WHERE
        `custom_daily_schedule`.`delivery_emp_token` = $employee_id AND `custom_daily_schedule`.`schedule_date` = '$dayname' AND `orders`.`delivery` = 'Pending' AND orders__items.delete_status = 1
    GROUP BY
        `orders__items`.`product_token`");
        
    
        $countrow =  mysqli_num_rows($amount);
        while ($amt_value = mysqli_fetch_array($amount)) {
            $obj_data = new stdClass;
            $obj_data->product_name=$amt_value['name'];
            $obj_data->product_qty=intval($amt_value['qty']);
            $product_units1=$amt_value['units'];
            
                 $obj_data->product_amount= round($amt_value['price_per_unit']*$amt_value['qty']);
    
           
            $obj_data->product_units='Nos';
            array_push($array,$obj_data);
        }
        $tot_obj = new stdClass;
        $totalamt = mysqli_query($link,"SELECT
        COALESCE(SUM(orders.items),
        0) AS total_items,
        COALESCE(SUM(orders.billing_amount),
        0) AS total_cost
    FROM
        orders
    INNER JOIN units__shop_mapping ON units__shop_mapping.shop_token = orders.shop_token
    INNER JOIN unit_customise_mapping ON unit_customise_mapping.unit_token = units__shop_mapping.unit_group_token
    WHERE
    unit_customise_mapping.custom_unit_token = '$unit_token' AND orders.delivery = 'Pending'");
                        if($get_tot = mysqli_fetch_array($totalamt)) {
                            
                            $tot_obj->total_cost= round($get_tot['total_cost']);
                        }

        $items_data = mysqli_query($link,"SELECT
        (orders__items.product_token)
    FROM
        orders
    INNER JOIN orders__items ON orders__items.order_token = orders.token
    INNER JOIN units__shop_mapping ON units__shop_mapping.shop_token = orders.shop_token
    INNER JOIN unit_customise_mapping ON unit_customise_mapping.unit_token = units__shop_mapping.unit_group_token
    WHERE
    unit_customise_mapping.custom_unit_token = $unit_token AND orders.delivery = 'Pending'
        
    GROUP BY
        orders__items.product_token");
        $items_row = mysqli_num_rows($items_data);
        $tot_obj->total_items= $items_row;//$get_tot['total_items'];
        // $overall_obj= new stdClass;
        $overall_obj->product_detail = $array;
        $overall_obj->itemsdetail = $tot_obj;
        if($countrow) {
            $obj->status_code = 200; 
            $obj->title = 'Success';
            $obj->message = 'Product found';
            $obj->data = $overall_obj;
        } else {
            $obj->status_code = 200; 
            $obj->title = 'Success';
            $obj->message = 'Product found';
            $obj->data = $overall_obj;
        }
    } else {
        $obj->status_code = 200; 
        $obj->title = 'Success';
        $obj->message = 'Product found';
        $obj->data = $overall_obj;
    }
    echo json_encode($obj);
}

else{

$salesemp = mysqli_query($link, "SELECT `sales_emp_token`,unit_token FROM `daily_schedule`  WHERE `delivery_emp_token`= $employee_id AND `schedule_date`='$dayname'");
if( $sale_row = mysqli_fetch_array($salesemp) ) {
    $sale_token = $sale_row['sales_emp_token'];
      $unit_token = $sale_row['unit_token'];

    $amount = mysqli_query($link,"SELECT `daily_schedule`.`unit_token`,
                                `units__shop_mapping`.`shop_token`,
                                `orders`.`token`,
                                `orders`.`date_time`,
                                products.name,
                                orders__items.units,
                                `orders__items`.`price_per_unit`,
                                -- SUM(`orders__items`.`quantity`) AS qty,
                                 SUM(CASE WHEN orders__items.units = 'Box' THEN(orders__items.quantity * products.piece_count) ELSE orders__items.quantity END) AS qty,
                                SUM(`orders__items`.`quantity`*`orders__items`.`price_per_unit`) AS amount
                            FROM `daily_schedule`
                                INNER JOIN `units__shop_mapping` ON `units__shop_mapping`.`unit_group_token`=`daily_schedule`.`unit_token`
                                INNER JOIN `orders` ON `orders`.`shop_token` = `units__shop_mapping`.`shop_token`
                                INNER JOIN `orders__items` on `orders`.`token` = `orders__items`.`order_token`
                                INNER JOIN `products` ON `products`.`token` = `orders__items`.`product_token`
                            WHERE `daily_schedule`.`delivery_emp_token`='$employee_id'
                                AND `daily_schedule`.`schedule_date`='$dayname'
                                AND `orders`.`delivery` = 'Pending' 
                                AND orders__items.delete_status=1
                                -- AND `orders`.`date_time` LIKE '$yesterday%'
                                GROUP BY `orders__items`.`product_token`");
    
//    SELECT
//        products.name,
//        orders__items.units,
//        sum(orders__items.quantity) as qty,
//        sum(orders__items.quantity*orders__items.price_per_unit) as amount
//    FROM `daily_schedule`
//        INNER JOIN units__shop_mapping ON units__shop_mapping.unit_group_token = daily_schedule.unit_token
//        INNER JOIN orders ON orders.shop_token = units__shop_mapping.shop_token
//        INNER JOIN orders__items on orders.token = orders__items.order_token
//        INNER JOIN products ON products.token = orders__items.product_token
//    WHERE
//        daily_schedule.delivery_emp_token =$employee_id   
//        AND orders.delivery = 'Pending' 
//        AND orders.date_time LIKE '$yesterday%'
//        AND `daily_schedule`.`schedule_date`='$dayname'
//        GROUP BY orders__items.product_token
    
    //   AND orders.delivery = 'Pending'  AND daily_schedule.schedule_date='$dayname'
    $countrow =  mysqli_num_rows($amount);
    while ($amt_value = mysqli_fetch_array($amount)) {
        $obj_data = new stdClass;
        $obj_data->product_name=$amt_value['name'];
        $obj_data->order_token = $amt_value['token'];
        $obj_data->product_qty=intval($amt_value['qty']);
        $product_units1=$amt_value['units'];
        // if($product_units1 == 'Box'){
             $obj_data->product_amount= round($amt_value['price_per_unit']*$amt_value['qty']);

        // } 
        // else
        // {
        //      $obj_data->product_amount=round($amt_value['amount']);
        // }
       
        $obj_data->product_units='Nos';//$amt_value['units'];
        array_push($array,$obj_data);
    }
    $tot_obj = new stdClass;
    $totalamt = mysqli_query($link,"SELECT
                                        COALESCE( SUM(orders.items),0) AS total_items,
                                         COALESCE(SUM(orders.billing_amount),0) AS total_cost
                                    FROM orders
                                    INNER JOIN units__shop_mapping ON units__shop_mapping.shop_token= orders.shop_token
                                    WHERE
                                        units__shop_mapping.unit_group_token = '$unit_token' AND orders.delivery = 'Pending'");
                    if($get_tot = mysqli_fetch_array($totalamt)) {
                        
                        $tot_obj->total_cost= round($get_tot['total_cost']);
                    }
    $items_data = mysqli_query($link,"SELECT
                          (orders__items.product_token)
                        FROM orders
                            INNER JOIN orders__items ON orders__items.order_token=orders.token
                            INNER JOIN units__shop_mapping ON units__shop_mapping.shop_token= orders.shop_token
                        WHERE
                           units__shop_mapping.unit_group_token = $unit_token
                            AND orders.delivery = 'Pending' 
                            GROUP BY orders__items.product_token");
    $items_row = mysqli_num_rows($items_data);
    $tot_obj->total_items= $items_row;//$get_tot['total_items'];
    // $overall_obj= new stdClass;
    $overall_obj->product_detail = $array;
    $overall_obj->itemsdetail = $tot_obj;
    if($countrow) {
        $obj->status_code = 200; 
        $obj->title = 'Success';
        $obj->message = 'Product found';
        $obj->data = $overall_obj;
    } else {
        $obj->status_code = 200; 
        $obj->title = 'Success';
        $obj->message = 'Product found';
        $obj->data = $overall_obj;
    }
} else {
    $obj->status_code = 200; 
    $obj->title = 'Success';
    $obj->message = 'Product found';
    $obj->data = $overall_obj;
}
echo json_encode($obj);
}
?>