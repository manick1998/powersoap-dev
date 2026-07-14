<?php
include "../../config.php";
$json_input = getInputs();
$obj = new stdclass;
$data =[];
$sales_rep_employee_id = $json_input->sales_rep_employee_id;
$selectDistributor = mysqli_query($link,"SELECT
`employees`.`token`,
`employees`.`name`,
`employees__state`.`state_name`,
`deparment`.`name` AS `department_name`,
`sales_rep_add_distributor`.`status_code`
FROM
`sales_rep_add_distributor`
INNER JOIN `employees` ON `sales_rep_add_distributor`.`distributor_token` = `employees`.`token`
INNER JOIN `deparment` ON `deparment`.`token` = `employees`.`deparment_token`
INNER JOIN `employees__state` ON `employees__state`.`state_token` = `employees`.`state_id`
WHERE
`sales_rep_add_distributor`.`rep_token` = '$sales_rep_employee_id'");
while($row = mysqli_fetch_array($selectDistributor)){
    $obj1 = new stdclass;
    $obj1->token =$row['token'];
    $obj1->name =$row['name'];
    $obj1->state_name =$row['state_name'];
    $obj1->department_name =$row['department_name'];
    $obj1->status_code =$row['status_code'];
    array_push($data,$obj1);
}

if($sales_rep_employee_id) {
    $obj->status_code=200; 
    $obj->message='onBoardDistributor List';
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