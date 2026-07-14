<?php

header('Content-Type: application/json');
$file = file_get_contents('php://input');
$json = json_decode($file);
$device = $json->device;
$app_version = $json->version;
$obj = new stdClass();

$php_version = "1.2";
if ($php_version == $app_version) {
    $obj->isForceUpdate = false;
} else {
    $obj->isForceUpdate = true;
}
$obj->status_code = 200;
$obj->title = 'Success';
$obj->app_link = "https://play.google.com/store/apps/details?id=com.powersoaps.distributorsales";
$obj->title = "PowerSoap";
$obj->description = "Kindly update PowerSoap, We've upgraded your PowerSoap experience with this update.";
$obj->button_title = "Update";

echo json_encode($obj);
