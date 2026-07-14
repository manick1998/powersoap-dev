<?php
include "../../config.php";
$json_input = getInputs();
$obj = new stdclass;
$shop_token = $json_input->token;
$selectList = mysqli_query($link,"SELECT
`shop`.`name`,
`shop`.`mobile_number`,
`shop`.`contact_person`,
`shop__type`.`name` AS `shop_type`,
`shop`.`license_number`,
`shop`.`license_image`,
`shop`.`address`,
`employees`.`name` AS `employee_name`,
GROUP_CONCAT(
    CONCAT(`products__category`.`name`)
) AS `divisions`
FROM
`shop`
INNER JOIN `shop__type` ON `shop`.`shop_type_code` = `shop__type`.`token`
INNER JOIN `shop_mapping` ON `shop_mapping`.`shop_token` = `shop`.`token`
INNER JOIN `employees` ON `employees`.`token` = `shop_mapping`.`distributor_token`
INNER JOIN `employees__division_mapping` ON `employees__division_mapping`.`employee_token` = `employees`.`token`
INNER JOIN `products__category` ON `products__category`.`token` = `employees__division_mapping`.`division_token`
WHERE
`shop`.`token` = '$shop_token' AND `shop`.`shop_show_status` = 'Active' AND `employees__division_mapping`.`delete_status`='1'");
while($row = mysqli_fetch_array($selectList)){
    $obj1 = new stdclass;
    $obj1->name =$row['name']==""?"":$row['name'];
    $obj1->mobile_number = $row['mobile_number']==""?"":$row['mobile_number'];
    $obj1->contact_person =$row['contact_person'];
    $obj1->license_number = $row['license_number']==""?"":$row['license_number'];
    $obj1->shop_type = $row['shop_type']==""?"":$row['shop_type'];
    $obj1->license_image = $row['license_image']==""?"":$row['license_image'];
    $obj1->address = $row['address']==""?"":$row['address'];
    $obj1->employee_name = $row['employee_name']==""?"":$row['employee_name'];
    $obj1->divisions = $row['divisions']==""?"":$row['divisions'];
}

if($shop_token) {
    $obj->status_code=200; 
    $obj->message='onBoardRetailer List';
    $obj->title='Success';
    $obj->data = $obj1==""?"":$obj1;
}
else {
    $obj->status_code=400; 
    $obj->message='error';
    $obj->title='error';
    $obj->data = [];
}


echo json_encode($obj);  

?>