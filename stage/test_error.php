<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$_POST = json_decode('{"dashboard_code":"16682245","region_token":"R101","type":"DeleteRegionName"}');
ob_start();
include '/Applications/MAMP/htdocs/powersoap_live-main/stage/API_dashboard/version1.0/admin/addRegion.php';
$output = ob_get_clean();
echo $output;
