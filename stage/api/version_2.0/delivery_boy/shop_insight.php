<?php
include "../../config.php";
$json_input = getInputs();
$employee_id = $json_input->employee_id;
$shop_id = $json_input->shop_id;


$monthly_volume = mysqli_query($link,"SELECT
							    SUM(`items`) as monthly_volumne
							FROM
							    orders
							WHERE
							    MONTH(`date_time`) = MONTH(CURRENT_DATE()) AND `shop_token`=$shop_id");

$overall_volume = mysqli_query($link,"SELECT
							    SUM(`items`) as overall_volumne
							FROM
							    orders
							WHERE
							     `shop_token`=$shop_id");
$getMonthVolume = mysqli_fetch_array($monthly_volume);
echo $month_vol = $getMonthVolume['monthly_volumne'];


?>