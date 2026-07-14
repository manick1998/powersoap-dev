<?php
//    $randomnums = rand(1000, 9999);
   $mobile = 7339316066;
   $otp = 5142;
//    // $textMessage = 'Your verification code for Power Soaps is '.$randomnums.'. Thank you for choosing Abirami Soap Works LLP.';
//    // echo $textMessage;


// // From URL to get webpage contents.
//  $url = "https://bhashsms.com/api/sendmsg.php?user=Powersoaps&pass=9003880088&sender=ASWFLY&phone=$mobile&text=Your%20verification%20code%20for%20Power%20Soaps%20is%20$randomnums.%20Thank%20you%20for%20choosing%20Abirami%20Soap%20Works%20LLP.&priority=ndnd&stype=normal";
 
// // Initialize a CURL session.
// $ch = curl_init();
 
// // Return Page contents.
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 
// //grab URL and pass it to the variable.
// curl_setopt($ch, CURLOPT_URL, $url);
 
// $result = curl_exec($ch);
 
// echo $result;

  
  $link_new1 = mysqli_connect('localhost','powersoap_dev','=Kb9PetRpam2','powersoap_dev');

        // // Collecting the variables to be sent in send otp server call
        // $url = "https://apii.msg91.com/api/v5/otp/verify?authkey=355579A8NqUhJs1609e2fc0P1&country=91&mobile=$mobile&otp=$otp";

        // // Creating cURL to hit the url and get the response
        // $curl = curl_init();
        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => $url,
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => "",
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 30,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => "GET",
        //     CURLOPT_SSL_VERIFYHOST => 0,
        //     CURLOPT_SSL_VERIFYPEER => 0,
        //     CURLOPT_HTTPHEADER => array(
        //         "content-type: application/json"
        //     )
        // ));
        // $response = curl_exec($curl);
        // $err = curl_error($curl);
        // curl_close($curl);

        // $result = json_decode($response);
    $get_select = mysqli_query($link_new1,"SELECT `mobile_number`,`otp`,`status` FROM `otp` WHERE `mobile_number`=$mobile  AND `status` = 'Pending' ORDER BY id DESC LIMIT 1");
    $getdata_otp = mysqli_fetch_array($get_select);
     echo $otp_val = $getdata_otp['otp'];

    if($otp_val == $otp){
        $update_status = mysqli_query($link_new1,"UPDATE `otp` SET `status`= 'Completed' WHERE `mobile_number` = $mobile");
    return true;
    
    } 
    else {
    return false;
    } 

?>