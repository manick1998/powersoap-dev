<?php
    require_once dirname(__FILE__) . '/../../database_credentials.php';
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    // echo $link;
    $GLOBALS['link'] = $link;
    date_default_timezone_set('Asia/Kolkata');
    $currentDate  = date("Y-m-d H:i:s");

    function getInputs() {
        // required headers
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
        return json_decode(file_get_contents("php://input"));
    }

    // $result = mysqli_query($GLOBALS['link'], "SELECT `id`,`token`,`order_type` FROM `orders` ORDER BY `id` ASC");
    // while($row = mysqli_fetch_array($result)){
    //     $orderId = $row['id'];
       
    //     if($row['order_type']=="Distributor Order"){
    //         $orderNumber = "ORD-D".$row['token'];
    //     }else{
    //         $orderNumber = "ORD-R".$row['token'];
    //     }
    //     mysqli_query($GLOBALS['link'], "UPDATE `orders` SET `order_number`='$orderNumber' WHERE `id`='$orderId'");
    // }
?>