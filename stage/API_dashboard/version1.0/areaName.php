<?php
$link = mysqli_connect("localhost", "powersoap", '*9iyjb6B9%$5', "powersoap_dev");

// Define the batch size
$batchSize = 100; // You can adjust this as needed

$checkquery = mysqli_query($link, "SELECT * FROM `live_location` WHERE area_name='' LIMIT $batchSize");
if (mysqli_num_rows($checkquery) != 0) {
    while ($checkrow = mysqli_fetch_array($checkquery)) {
        $latitud = $checkrow['latitud'];
        $langitud = $checkrow['langitud'];
        $apiKey = 'AIzaSyDFhqD4CXFJHcBNzxXKeOThoIZNQh7R2cw'; // Replace with your actual API key
        $get_area_name = get_area_name($latitud, $langitud, $apiKey);
        $id = $checkrow['id'];
        $query = mysqli_query($link, "UPDATE `live_location` SET `area_name`='$get_area_name' WHERE `id`='$id'");
    }
}

function get_area_name($latitude, $longitude, $apiKey) {
    $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$latitude,$longitude&key=$apiKey";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($response);
    if ($data->status == "OK") {
        $results = $data->results;
        if (!empty($results)) {
            $areaName = $results[0]->address_components[3]->long_name;
            return $areaName;
        } else {
            echo "No results found";
        }
    } else {
        echo "Geocoding API request failed";
    }
}
mysqli_close($link);
?>