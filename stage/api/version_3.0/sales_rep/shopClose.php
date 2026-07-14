<?php

include "../../config.php";
$json_input=getInputs();
$currentDate = $indiaDateTime ;
$current = $indiaDate;
$sales_rep_token = $json_input->sales_rep_token;
$latitude=$json_input->latitude;
$longitude = $json_input->longitude;
$type = $json_input->type;

if($type="shopClosed"){
    $order = 3;
}

$schedule_token = mysqli_query($link,"SELECT
`rep_schedule_token`
FROM
`schedule_sales_rep`
WHERE
`sales_rep_token` = '$sales_rep_token' AND date(`date_time`)='$current' AND `status`='1'");
$row_id = mysqli_fetch_array($schedule_token);
$schedule_rep_token = $row_id['rep_schedule_token'];





if($schedule_rep_token!="" && $dist_latitude==0 && $dist_longitude==0){
$sql1 = mysqli_query($link,"INSERT INTO `live_location`(
    `rep_schedule_token`,
    `rep_token`,
    `latitud`,
    `langitud`,
    `date_time`,
    `type`
)
VALUES('$schedule_rep_token','$sales_rep_token','$latitude','$longitude','$currentDate','$order')");
}

$obj = new stdClass;
		if($schedule_rep_token ) {
        $obj->status_code=200; 
        $obj->message='data inserted successfully';
        $obj->title='Success';
    }
    else {
        $obj->status_code=400; 
        $obj->message='Today schedule not available';
        $obj->title='failure';
    }


echo json_encode($obj);

?>