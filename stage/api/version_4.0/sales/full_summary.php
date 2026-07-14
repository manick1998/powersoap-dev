<?php
include "../../config.php";
$json_input = getInputs();
$employee_id = $json_input->employee_id;
$summary_array = array();
$dayname =  date('l', strtotime($currnetDateTime));
$dateonly = $indiaDate;
// $summary = mysqli_query($link,"SELECT
//                             shop.name,
//                             orders.items,
//                             orders.billing_amount
                           
//                         FROM
//                             shop
//                         INNER JOIN orders ON shop.token = orders.shop_token
//                         WHERE
//                             orders.employee_token = $employee_id");
$sql = "SELECT * FROM `daily_schedule` WHERE sales_emp_token = $employee_id AND date(date_time) = '$dateonly' AND schedule_date = '$dayname'";
 $amount = $link->query($sql);
$data= $amount->num_rows;

if ($data == 0) {
    $summary = mysqli_query($link,"SELECT
    shop.name,
    SUM(orders.items) AS items,
    shop.token,
    SUM(orders.billing_amount) AS bill_amount,
    shop__type.name AS shop_type
FROM
    `custom_daily_schedule`
INNER JOIN unit_customise_mapping ON unit_customise_mapping.custom_unit_token = custom_daily_schedule.custom_unit_token
INNER JOIN units__shop_mapping ON units__shop_mapping.unit_group_token = unit_customise_mapping.unit_token
INNER JOIN shop__outstanding ON shop__outstanding.shop_token = units__shop_mapping.shop_token
INNER JOIN shop ON shop.token = units__shop_mapping.shop_token
INNER JOIN shop__type ON shop__type.token = shop.shop_type_code
INNER JOIN orders ON orders.shop_token = shop.token

WHERE
    sales_emp_token = $employee_id AND units__shop_mapping.delete_status = 1 AND orders.`date_time` LIKE '%$dateonly%' AND custom_daily_schedule.schedule_date = '$dayname' AND orders.delivery = 'Pending'
GROUP BY
    shop.name");                           
                            
    while($summary_data = mysqli_fetch_array($summary)) {
        $obj = new stdClass;
         $obj->shop_name = $summary_data['name'];
        $obj->quantity = $summary_data['items'];
        $obj->sale_amount = round($summary_data['bill_amount']);
         $obj->shop_type = $summary_data['shop_type'];
        array_push($summary_array,$obj);
        
    }
    
    
    
    $obj_final = new stdClass;
if($employee_id){
    $obj_final->status_code=200; 
    $obj_final->message='summary data found';
    $obj_final->title='Success';
    $obj_final->data = $summary_array;
    
} else {
    $obj_final->status_code=400; 
    $obj_final->message='summary data not found';
    $obj_final->title='Success';
    
}



    echo json_encode($obj_final);

}
else {
    

 $summary = mysqli_query($link,"SELECT
                        shop.name,
                        SUM(orders.items) as items,
                        shop.token,
                        sum(orders.billing_amount) as bill_amount,
                        shop__type.name AS shop_type
                    FROM
                        `daily_schedule`
                    INNER JOIN units__shop_mapping ON units__shop_mapping.unit_group_token = daily_schedule.unit_token
                    INNER JOIN shop__outstanding ON shop__outstanding.shop_token = units__shop_mapping.shop_token
                    INNER JOIN shop ON shop.token = units__shop_mapping.shop_token
                    INNER JOIN shop__type ON shop__type.token = shop.shop_type_code
                    INNER JOIN orders ON orders.shop_token = shop.token
                    WHERE
                        sales_emp_token = $employee_id AND units__shop_mapping.delete_status = 1 AND orders.`date_time` LIKE '%$dateonly%' AND   daily_schedule.schedule_date = '$dayname' AND orders.delivery='Pending'
                    GROUP BY
                        shop.name");                           
                            
    while($summary_data = mysqli_fetch_array($summary)) {
        $obj = new stdClass;
         $obj->shop_name = $summary_data['name'];
        $obj->quantity = $summary_data['items'];
        $obj->sale_amount = round($summary_data['bill_amount']);
         $obj->shop_type = $summary_data['shop_type'];
        array_push($summary_array,$obj);
        
    }
    
    
    
    $obj_final = new stdClass;
if($employee_id){
    $obj_final->status_code=200; 
    $obj_final->message='summary data found';
    $obj_final->title='Success';
    $obj_final->data = $summary_array;
    
} else {
    $obj_final->status_code=400; 
    $obj_final->message='summary data not found';
    $obj_final->title='Success';
    
}



    echo json_encode($obj_final);
}
?>