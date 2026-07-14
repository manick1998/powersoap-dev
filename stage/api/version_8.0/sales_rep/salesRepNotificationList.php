<?php
include "../../config.php";
$json_input = getInputs();
$sales_rep_id = $json_input->sales_rep_id;
$obj = new stdClass;
$sql1 = mysqli_query($link,"SELECT
                            `employees`.`name` AS `distributor_name`,
                            `shop`.`name` AS `shop_name`,
                            `push_notification`.`order_id`,
                            DATE(`push_notification`.`date_time`) AS `date`,
        					TIME(`push_notification`.`date_time`) AS `time`
                            FROM
                            `employees`
                            INNER JOIN `push_notification` ON `employees`.`token` = `push_notification`.`distributor_token`
                            INNER JOIN `shop_mapping` ON `shop_mapping`.`token` = `push_notification`.`shop_token`
                            INNER JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
                            WHERE
                            `push_notification`.`sales_rep_token` = '$sales_rep_id' ORDER BY `push_notification`.`id` DESC");

$list = [];
while ($row=mysqli_fetch_array($sql1,MYSQLI_BOTH)) {
    $obj1 = new stdClass;
    $obj1->distributor_name = $row['distributor_name'];
    $obj1->shop_name = $row['shop_name'];
    $obj1->order_id = $row['order_id'];
    $obj1->time   =convertDate("g:ia",$row['time']);
    $obj1->date = date("d-m-Y", strtotime($row['date']));
    array_push($list,$obj1);
}
if(sizeof($list)){
    $obj->status_code=200; 
    $obj->message='Data found';
    $obj->title='Success';
    $obj->data=$list;
    
} else {
    $obj->status_code=400; 
    $obj->message='data not found';
    $obj->title='Error';
    
}
echo json_encode($obj);

?>