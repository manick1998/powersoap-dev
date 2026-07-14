<?php

include "../../config.php";
$json_input=getInputs();
$currentDate = $indiaDateTime ;
$current = $indiaDate;
$sales_rep_token = $json_input->sales_rep_token;
$latitude=$json_input->latitude;
$longitude = $json_input->longitude;

$schedule_token = mysqli_query($link,"SELECT
`rep_schedule_token`
FROM
`schedule_sales_rep`
WHERE
`sales_rep_token` = '$sales_rep_token' AND date(`date_time`)='$current' AND `status`='1'");
$row_id = mysqli_fetch_array($schedule_token);
$schedule_rep_token = $row_id['rep_schedule_token'];

$distances =mysqli_query($link,"SELECT
latitud,
langitud,
date_time
FROM
`live_location`
WHERE
`rep_token` = '$sales_rep_token' AND date_time BETWEEN NOW() - INTERVAL 1 MINUTE AND NOW()");
$row_dist = mysqli_fetch_array($distances);
$dist_latitude=$row_dist["latitud"]==""?0:$row_dist["latitud"];
$dist_longitude=$row_dist["langitud"]==""?0:$row_dist["langitud"];

$theta = $longitude - $dist_longitude;
$dist = sin(deg2rad($dist_latitude)) * sin(deg2rad($latitude)) +  cos(deg2rad($dist_latitude)) * cos(deg2rad($latitude)) * cos(deg2rad($theta));
$dist = acos($dist);
$dist = rad2deg($dist);
$miles = $dist * 60 * 1.1515;
$distance = round($miles * 1609.344);


$order = 1;

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
else if($schedule_rep_token!="" && $distance<=10 && $dist_latitude!="" && $dist_longitude!=""){
    $sql4 = mysqli_query($link,"UPDATE `live_location` SET `date_time`='$currentDate' WHERE `rep_token` = '$sales_rep_token' AND date_time BETWEEN NOW() - INTERVAL 1 MINUTE AND NOW()");
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