<?php
include "../../config.php";
$json_input = getInputs();
$salesman_token = $json_input->salesman_token;
$array = array();
$obj = new stdClass;
$query = mysqli_query($link,"SELECT `admin_distributor_token` FROM `employees` WHERE `token`='$salesman_token'");
$row = mysqli_fetch_array($query);
$employee_token = $row['admin_distributor_token'];
$bankDetails = mysqli_query($link,
    "SELECT
    `employees`.`token` AS `distributor_token`,
    `employees_payment_details`.`bank_name`,
    `employees_payment_details`.`account_number`,
    `employees_payment_details`.`bank_code`,
    `employees_payment_details`.`holder_name`,
    `employees_payment_details`.`gpay`,
    `employees_payment_details`.`paytm`
FROM
    `employees`
INNER JOIN `employees_payment_details` ON `employees`.`token` = `employees_payment_details`.`distributor_token`
WHERE
    `employees`.`token` = '$employee_token'
GROUP BY
    `employees`.`token`");
$count=mysqli_num_rows($bankDetails);
if($count>0){

            while($row = mysqli_fetch_array($bankDetails)){
                $obj1 = new stdClass;
                $obj1->distributor_token = $row["distributor_token"];
                $obj1->bank_name = $row["bank_name"];
                $obj1->account_number = $row["account_number"];
                $obj1->bank_code = $row["bank_code"];
                $obj1->gpay_number = $row["gpay"];
                $obj1->holder_name = $row["holder_name"];
                $obj1->paytm_number = $row["paytm"];
            }
        $obj->status_code = 200;
        $obj->message = "bank Details found";
        $obj->header = "success";
        $obj->data = $obj1;
    }else{
        $obj->status_code = 400;
        $obj->message = "data not found";
        $obj->header = "Error";
    }
    echo json_encode($obj);
?>