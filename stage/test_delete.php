<?php
$_POST = json_decode('{"dashboard_code":"16682245","region_token":"R101","type":"DeleteRegionName"}');
echo file_get_contents("http://localhost:8888/powersoap_live-main/stage/API_dashboard/version1.0/admin/addRegion.php", false, stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => 'Content-Type: application/json',
        'content' => json_encode($_POST)
    ]
]));
