<?php
include "../../config.php";
$json_input = getInputs();
$distributor_token = $json_input->distributor_token;
$show =mysqli_query($link,"SELECT `delete_status` from `employees` where `token`='$distributor_token'");
$list = mysqli_fetch_array($show);
$listdata = $list['delete_status'];
if($listdata==0){
$selectList = mysqli_query($link,"SELECT
`employees`.`employee_image`,
`employees`.`name`,
`region`.`region_name`,
`employees`.`license_number`,
`deparment`.`name` AS `deparment_name`,
`employees`.`join_date`,
`employees`.`address`,
GROUP_CONCAT(`products__category`.`name`) AS `division_name`,
`employees__state`.`state_name`,
`employees__attachments`.`attachment_url` AS `attach`
FROM
`employees`
INNER JOIN `deparment` ON `deparment`.`token` = `employees`.`deparment_token`
INNER JOIN `employees__division_mapping` ON `employees__division_mapping`.`employee_token` = `employees`.`token`
INNER JOIN `products__category` ON `products__category`.`token` = `employees__division_mapping`.`division_token`
INNER JOIN `sales_rep_add_distributor` ON `sales_rep_add_distributor`.`distributor_token` = `employees`.`token`
INNER JOIN `region` ON `region`.`token` = `employees`.`region_id`
LEFT JOIN `employees__state` ON `employees__state`.`state_token` = `employees`.`state_id`
LEFT JOIN `employees__attachments` ON `employees__attachments`.`employee_token` = `employees`.`token`
WHERE
`employees`.`delete_status` = '0' AND `employees__division_mapping`.`delete_status` = '1'  AND `employees`.`token` = '$distributor_token'");
while($row = mysqli_fetch_array($selectList)){
    $obj1 = new stdclass;
    $obj1->employee_image =$row['employee_image']==null?"":$row['employee_image'];
    $obj1->name =$row['name']==null?"":$row['name'];
    $obj1->region_name = $row['region_name']==null?"":$row['region_name'];
    $obj1->license_number = $row['license_number']==null?"":$row['license_number'];
    $obj1->department_name =$row['deparment_name']==null?"":$row['deparment_name'];
    $obj1->join_date =$row['join_date']==null?"":$row['join_date'];
    $obj1->address = $row['address']==null?"":$row['address'];
    $obj1->state_name = $row['state_name']==null?"":$row['state_name'];
    $division=$row['division_name'];
    $divisiondata= explode(",", $division);
    $division = implode(', ', $divisiondata);
    $obj1->division_name = $division==""?"":$division;
    $attach=$row['attach'];
    $obj1->attach_image = $attach==""?"":$attach;
}
}else if($listdata ==1){
    $selectList = mysqli_query($link,"SELECT
`employees`.`employee_image`,
`employees`.`name`,
`region`.`region_name`,
`employees`.`license_number`,
`deparment`.`name` AS `deparment_name`,
`employees`.`join_date`,
`employees`.`address`,
GROUP_CONCAT(`products__category`.`name`) AS `division_name`,
`employees__state`.`state_name`,
`employees__attachments`.`attachment_url` AS `attach`
FROM
`employees`
INNER JOIN `deparment` ON `deparment`.`token` = `employees`.`deparment_token`
INNER JOIN `employees__division_mapping` ON `employees__division_mapping`.`employee_token` = `employees`.`token`
INNER JOIN `products__category` ON `products__category`.`token` = `employees__division_mapping`.`division_token`
INNER JOIN `region` ON `region`.`token` = `employees`.`region_id`
LEFT JOIN `employees__state` ON `employees__state`.`state_token` = `employees`.`state_id`
LEFT JOIN `employees__attachments` ON `employees__attachments`.`employee_token` = `employees`.`token`
WHERE
`employees`.`delete_status` = '1' AND `employees__division_mapping`.`delete_status` = '1' AND `employees`.`token` = '$distributor_token'");
while($row = mysqli_fetch_array($selectList)){
    $obj1 = new stdclass;
    $obj1->employee_image =$row['employee_image']==null?"":$row['employee_image'];
    $obj1->name =$row['name']==null?"":$row['name'];
    $obj1->region_name = $row['region_name']==null?"":$row['region_name'];
    $obj1->license_number = $row['license_number']==null?"":$row['license_number'];
    $obj1->department_name =$row['deparment_name']==null?"":$row['deparment_name'];
    $obj1->join_date =$row['join_date']==null?"":$row['join_date'];
    $obj1->address = $row['address']==null?"":$row['address'];
    $obj1->state_name = $row['state_name']==null?"":$row['state_name'];
    $division=$row['division_name'];
    $divisiondata= explode(",", $division);
    $division = implode(', ', $divisiondata);
    $obj1->division_name = $division==""?"":$division;
    $attach=$row['attach'];
    $obj1->attach_image = $attach==""?"":$attach;
}
}else{
    $selectList = mysqli_query($link,"SELECT
    `employees`.`employee_image`,
    `employees`.`name`,
    `region`.`region_name`,
    `employees`.`license_number`,
    `deparment`.`name` AS `deparment_name`,
    `employees`.`join_date`,
    `employees`.`address`,
    GROUP_CONCAT(`products__category`.`name`) AS `division_name`,
    `employees__state`.`state_name`,
    `employees__attachments`.`attachment_url` AS `attach`
FROM
    `employees`
INNER JOIN `deparment` ON `deparment`.`token` = `employees`.`deparment_token`
INNER JOIN `employees__division_mapping` ON `employees__division_mapping`.`employee_token` = `employees`.`token`
INNER JOIN `products__category` ON `products__category`.`token` = `employees__division_mapping`.`division_token`
INNER JOIN `sales_rep_add_distributor` ON `sales_rep_add_distributor`.`distributor_token` = `employees`.`token`
INNER JOIN `region` ON `region`.`token` = `employees`.`region_id`
LEFT JOIN `employees__state` ON `employees__state`.`state_token` = `employees`.`state_id`
LEFT JOIN `employees__attachments` ON `employees__attachments`.`employee_token` = `employees`.`token`
WHERE
    `sales_rep_add_distributor`.`status_code` = '2' AND `employees`.`delete_status` = '2' AND `employees__division_mapping`.`delete_status` = '1' AND `employees`.`token` = '$distributor_token'");
    while($row = mysqli_fetch_array($selectList)){
        $obj1 = new stdclass;
        $obj1->employee_image =$row['employee_image']==null?"":$row['employee_image'];
        $obj1->name =$row['name']==null?"":$row['name'];
        $obj1->region_name = $row['region_name']==null?"":$row['region_name'];
        $obj1->license_number = $row['license_number']==null?"":$row['license_number'];
        $obj1->department_name =$row['deparment_name']==null?"":$row['deparment_name'];
        $obj1->join_date =$row['join_date']==null?"":$row['join_date'];
        $obj1->address = $row['address']==null?"":$row['address'];
        $obj1->state_name = $row['state_name']==null?"":$row['state_name'];
        $division=$row['division_name'];
        $divisiondata= explode(",", $division);
        $division = implode(', ', $divisiondata);
        $obj1->division_name = $division==""?"":$division;
        $attach=$row['attach'];
        $obj1->attach_image = $attach==""?"":$attach;
    } 
}
$obj = new stdclass;
if($distributor_token!="") {
    $obj->status_code=200; 
    $obj->message='onBoardDistributor List';
    $obj->title='Success';
    $obj->data = $obj1;
}
else {
    $obj->status_code=400; 
    $obj->message='error';
    $obj->title='error';
    $obj->data = [];
}


echo json_encode($obj);  

?>