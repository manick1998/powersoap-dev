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
$salesemp = mysqli_query($link, "SELECT `sales_emp_token` FROM `daily_schedule`  WHERE `delivery_emp_token`= $employee_id AND `schedule_date`='$dayname'");
if( $sale_row = mysqli_fetch_array($salesemp) ) {
    $sale_token = $sale_row['sales_emp_token'];
    $amount = mysqli_query($link,"SELECT `daily_schedule`.`unit_token`,
                                `units__shop_mapping`.`shop_token`,
                                `orders`.`token`,
                                `orders`.`date_time`,
                                products.name,
                                orders__items.units,
                                SUM(`orders__items`.`quantity`) AS qty,
                                SUM(`orders__items`.`quantity`*`orders__items`.`price_per_unit`) AS amount
                            FROM `daily_schedule`
                                INNER JOIN `units__shop_mapping` ON `units__shop_mapping`.`unit_group_token`=`daily_schedule`.`unit_token`
                                INNER JOIN `orders` ON `orders`.`shop_token` = `units__shop_mapping`.`shop_token`
                                INNER JOIN `orders__items` on `orders`.`token` = `orders__items`.`order_token`
                                INNER JOIN `products` ON `products`.`token` = `orders__items`.`product_token`
                            WHERE `daily_schedule`.`delivery_emp_token`='$employee_id'
                                AND `daily_schedule`.`schedule_date`='$dayname'
                                AND `orders`.`delivery` = 'Pending' 
                                AND `orders`.`date_time` LIKE '$yesterday%'
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
        $obj_data->product_qty=intval($amt_value['qty']);
        $product_units1=$amt_value['units'];
        if($product_units1 == 'Box'){
             $obj_data->product_amount=number_format(intval($amt_value['amount']*$box_value),2);

        } 
        else
        {
             $obj_data->product_amount=number_format(intval($amt_value['amount']),2);
        }
       
        $obj_data->product_units=$amt_value['units'];
        array_push($array,$obj_data);
    }
    $tot_obj = new stdClass;
    $totalamt = mysqli_query($link,"SELECT
                                        SUM(orders.items) AS total_items,
                                        SUM(orders.billing_amount) AS total_cost
                                    FROM orders
                                    WHERE
                                        employee_token = $sale_token AND orders.delivery = 'Pending'");
                    if($get_tot = mysqli_fetch_array($totalamt)) {
                        
                        $tot_obj->total_cost= $get_tot['total_cost'];
                    }
    $items_data = mysqli_query($link,"SELECT
                          (orders__items.product_token)
                        FROM orders
                            INNER JOIN orders__items ON orders__items.order_token=orders.token
                        WHERE
                            orders.employee_token = $sale_token
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
?>