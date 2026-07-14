<?php
function sendPushNotification($to,$data){
$apiKey = 'AAAAohvacmI:APA91bFoLvXPvu1LIDunT2o0U5-3n0Y29a4U28QK_CoSmFj5etLpS8jP5IgrUR3YfhgCT9jOu9JxJX_eMsWN5eQj6DAqNDv9Powu2XBm3XpCBmjYaaHiXeev3B1PIjgcQaU8_hPJ1EY5';

$fields = array( 'to' => $to,
'notification' => $data );

$headers = array( 'Authorization: key='.$apikey, 'Content-Type: application/json');
$url = 'https://fcm.googleapis.com/fcm/send';
$ch = curl_init();
curl_setopt( $ch, CURLOPT_URL, $url);
curl_setopt ( $ch, CURLOPT_POST, true);
curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
$result = curl_exec($ch);
curl_close($ch);
return json_decode($result, true);
}



{

    $token = $s;

    $api_key = 'AAAAxFYsvcQ:APA91bHSdf80_307kElM5hzLcpYDlBR4OVWVToGgoyiJxwsbeulTX-Kh4deErXzTzmgneeynQKtOFnwvYytxq5VjwBk1xzEZ9VpuFRqACHqG50oIHuvFwqHCfsbsncXlk5RyndyKL7e6';

    $reg_token = array(
        $token
    );

    $msg = array(
        'message' => stripslashes($message),
        'title' => stripslashes($name),
        'content_url' => $notification,
        'notifictaion_token' => $ntoken,
        'tag' => 1,
        'type' => "default"
    );
    $fields = array(
        'registration_ids' => $reg_token,
        'data' => $msg
    );
    $headers = array(
        'Authorization: key=' . $api_key,
        'Content-Type: application/json'
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
     curl_exec($ch);
    curl_close($ch);
    // $res = json_decode($result);
    // $flag = $res->success;
}

?>