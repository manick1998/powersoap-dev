<?php
include "../../config.php";
$json_input=getInputs();
$currentDate = $indiaDateTime ;
$current = $indiaDate;
$sales_rep_token = isset($json_input->sales_rep_token) ? mysqli_real_escape_string($link, $json_input->sales_rep_token) : "";
$latitude = isset($json_input->latitude) ? mysqli_real_escape_string($link, $json_input->latitude) : "";
$longitude = isset($json_input->longitude) ? mysqli_real_escape_string($link, $json_input->longitude) : "";
$area = isset($json_input->area) ? mysqli_real_escape_string($link, $json_input->area) : "";
$area_name = isset($json_input->area_name) ? mysqli_real_escape_string($link, $json_input->area_name) : "";
date_default_timezone_set("Asia/Kolkata");







$schedule_token = mysqli_query($link,"SELECT
`rep_schedule_token`
FROM
`schedule_sales_rep`
WHERE
`sales_rep_token` = '$sales_rep_token' AND date(`date_time`)='$current' AND `status`='1'");
$row_id = mysqli_fetch_array($schedule_token);
$schedule_rep_token = $row_id ? $row_id['rep_schedule_token'] : "";

$distances =mysqli_query($link,"SELECT
latitud,
langitud,
date_time
FROM
`live_location`
WHERE
`rep_token` = '$sales_rep_token' AND date_time BETWEEN NOW() - INTERVAL 1 MINUTE AND NOW()");
$row_dist = mysqli_fetch_array($distances);
$dist_latitude = ($row_dist && isset($row_dist["latitud"]) && $row_dist["latitud"] != "") ? (float)$row_dist["latitud"] : 0.0;
$dist_longitude = ($row_dist && isset($row_dist["langitud"]) && $row_dist["langitud"] != "") ? (float)$row_dist["langitud"] : 0.0;

$latitude_val = (float)$latitude;
$longitude_val = (float)$longitude;

$theta = $longitude_val - $dist_longitude;
$dist = sin(deg2rad($dist_latitude)) * sin(deg2rad($latitude_val)) +  cos(deg2rad($dist_latitude)) * cos(deg2rad($latitude_val)) * cos(deg2rad($theta));
if ($dist > 1.0) {
    $dist = 1.0;
} else if ($dist < -1.0) {
    $dist = -1.0;
}
$dist = acos($dist);
$dist = rad2deg($dist);
$miles = $dist * 60 * 1.1515;
$distance = round($miles * 1609.344);



$order = 1;
$insert_success = true;
$sql_error = "";

if($schedule_rep_token!="" && $dist_latitude==0 && $dist_longitude==0){
$sql1 = mysqli_query($link,"INSERT INTO `live_location`(
    `rep_schedule_token`,
    `rep_token`,
    `latitud`,
    `langitud`,
    `area_location`,
    `area_name`,
    `date_time`,
    `type`
)
VALUES('$schedule_rep_token','$sales_rep_token','$latitude','$longitude','$area_name','$area','$currentDate','$order')");
if (!$sql1) {
    $insert_success = false;
    $sql_error = mysqli_error($link);
}
}
else if($schedule_rep_token!="" && $distance<=10 && $dist_latitude!="" && $dist_longitude!=""){
    $sql4 = mysqli_query($link,"UPDATE `live_location` SET `date_time`='$currentDate' WHERE `rep_token` = '$sales_rep_token' AND date_time BETWEEN NOW() - INTERVAL 1 MINUTE AND NOW()");
    if (!$sql4) {
        $insert_success = false;
        $sql_error = mysqli_error($link);
    }
}
$obj = new stdClass;
if($schedule_rep_token ) {
    if (!$insert_success) {
        $obj->status_code=500; 
        $obj->message='SQL Error: ' . $sql_error;
        $obj->title='failure';
    } else {
        $obj->status_code=200; 
        $obj->message='data inserted successfully';
        $obj->title='Success';
    }
}
else {
    $obj->status_code=400; 
    $obj->message='Today schedule not available';
    $obj->title='failure';
}


echo json_encode($obj);

?>