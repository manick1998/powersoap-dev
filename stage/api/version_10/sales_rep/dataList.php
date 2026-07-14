<?php
include "../../config.php";
$json_input=getInputs();
$obj = new stdClass;
$sql1 = mysqli_query($link,"");

$check_status = mysqli_num_rows($sql1);

$sql1 = mysqli_query($link,"SELECT
                                *
                            FROM
                                `employees`
                            INNER JOIN deparment ON deparment.token=employees.deparment_token WHERE  deparment.token= '72602780'");

?>