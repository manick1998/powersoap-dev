<?php
//notification
function sendNotification($device_token,$order_number,$shop_name,$dist_name){

    $api_key = 'AAAAohvacmI:APA91bFoLvXPvu1LIDunT2o0U5-3n0Y29a4U28QK_CoSmFj5etLpS8jP5IgrUR3YfhgCT9jOu9JxJX_eMsWN5eQj6DAqNDv9Powu2XBm3XpCBmjYaaHiXeev3B1PIjgcQaU8_hPJ1EY5';

    $msg = array(
    	'message' 	 => $shop_name.' of '.$dist_name.' : '.$order_number.' has been delivered.',
    	'title'		 => 'Power Soaps',
        'notification_for'		 => 'Deliverd',
        'order_Id'		 => $order_number,
        'Shop_name'		 => $shop_name
    );

    $reg_token = array(
        $device_token
    );

    $fields = array(
    	'registration_ids' 	=> $reg_token,
    	'data' => $msg
    );

    $headers = array(
    	'Authorization: key=' . $api_key,
    	'Content-Type: application/json'
    );
    $ch = curl_init();
    curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
    curl_setopt( $ch,CURLOPT_POST, true );
    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
    $result = curl_exec($ch);
    curl_close( $ch );
    //$res = json_decode($result);
    //$flag = $res->success;
    //echo $result;
}
?>