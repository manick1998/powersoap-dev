<?php
	$is_cache_avoided = true;
	$js_cache_string = $is_cache_avoided ? "?date_time=" . date("Y-m-d_H:i:s"): "";
    $api_path = "../MD_Webapp/php";

    $link = mysqli_connect("localhost", "powersoap", '*9iyjb6B9%$5', "powersoap_dev");
    $cookie_token = $_COOKIE["token_admin_dashboard_development"];
    $result  = mysqli_query($link, "SELECT 
    count(token) AS counts,
    `id`,
    `name`,
    `token`,
    `email`,
    `phone_number`,
    `state_id`
    FROM `admin_login` 
    WHERE `token`='$cookie_token'");
    $row     = mysqli_fetch_array($result);
    if($row["counts"]==1){
        $token = $row['token'];
        $cookie_admin_name   = $row['name'];
    }else{
        $cookie_admin_name = "";
        $verification_code = "6978567859";
        setcookie("token_admin_dashboard_development", "", time() + (86400 * 30), "/");
    }

	// app config
	date_default_timezone_set('Asia/Kolkata');
$indiaDateTime = date("Y-m-d H:i:s");
$indiaDate     = date("Y-m-d");
// $date = new DateTime(date("Y-m-d H:i:s"),new DateTimeZone('GMT'));
// $date->setTimezone(new DateTimeZone('GMT+5:30'));
//  $datefun =  $date->format('Y-m-d h:m:s'); 
  $currnetDateTime = $indiaDateTime;// gmdate("yyyy-mm-dd h:m:s");

$link = mysqli_connect('localhost','powersoap','*9iyjb6B9%$5','powersoap_dev');
if(!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}


function getInputs() {
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    return json_decode(file_get_contents("php://input"));
}


function genToken($col,$table){
    $gen_token = mysqli_query($GLOBALS['link'],"SELECT ROUND((RAND() * (99999999-10000000))+10000000) AS `random_num` FROM `$table` WHERE 'random_num' NOT IN (SELECT `$col` FROM `$table`) LIMIT 1");
    if($token_number = mysqli_fetch_array($gen_token)){
        return $token_number['random_num'];
    } else {
        return rand(10000000,99999999);
    }
   
}
function indCurrencyFormatComma($num){
    return $num = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $num);
}

?>