<?php
include "../../config.php";
$json_input = getInputs();
$obj = new stdclass;
$data =[];
$sales_rep_employee_id = $json_input->sales_rep_employee_id;
$selectRetailer = mysqli_query($link,"SELECT
`shop`.`token`,
`shop`.`name`,
`shop__type`.`name`AS `shop_type`,
`shop_mapping`.`status`,
`employees`.`name` AS `distributor_name`
FROM
`shop`
INNER JOIN `shop__type` ON `shop`.`shop_type_code` = `shop__type`.`token`
INNER JOIN `shop_mapping` ON `shop_mapping`.`shop_token` = `shop`.`token`
INNER JOIN `employees` ON `shop_mapping`.`distributor_token`=`employees`.`token`
WHERE
`shop`.`created_by` = '$sales_rep_employee_id' AND `shop`.`shop_show_status` = 'Active'");
while($row = mysqli_fetch_array($selectRetailer)){
    $obj1 = new stdclass;
    $obj1->token =$row['token'];
    $obj1->name =$row['name'];
    $obj1->shop_type =$row['shop_type'];
    $obj1->status =$row['status'];
    $obj1->distributor_name =$row['distributor_name'];
    array_push($data,$obj1);
}

if($sales_rep_employee_id) {
    $obj->status_code=200; 
    $obj->message='Retailer List';
    $obj->title='Success';
    $obj->data = $data;
}
else {
    $obj->status_code=400; 
    $obj->message='error';
    $obj->title='error';
    $obj->data = [];
}


echo json_encode($obj);  

?>