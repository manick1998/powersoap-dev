<?php
$url = "https://apii.msg91.com/api/v5/otp/verify?authkey=380803AF0dsqJz8g62f75785P1&country=91&mobile=7339316066&otp=2295";

       
       // // Creating cURL to hit the url and get the response
       //  $curl = curl_init();
       //  curl_setopt_array($curl, array(
       //      CURLOPT_URL => $url,
       //      CURLOPT_RETURNTRANSFER => true,
       //      CURLOPT_ENCODING => "",
       //      CURLOPT_MAXREDIRS => 10,
       //      CURLOPT_TIMEOUT => 30,
       //      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
       //      CURLOPT_CUSTOMREQUEST => "GET",
       //      CURLOPT_SSL_VERIFYHOST => 0,
       //      CURLOPT_SSL_VERIFYPEER => 0,
       //      CURLOPT_HTTPHEADER => array(
       //          "content-type: application/json"
       //      )
       //  ));
       //  $response = curl_exec($curl);
       //  $err = curl_error($curl);
       //  curl_close($curl);
         

       //  echo $result = json_decode($response);



        $curl = curl_init();

curl_setopt_array($curl, [
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_SSL_VERIFYHOST => 0,
  CURLOPT_SSL_VERIFYPEER => 0,
  CURLOPT_HTTPHEADER => array(
  	"content-type: application/json"
   )
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  // echo "cURL Error #:" . $err;
  return false;
} else {
  // echo $response;
  if ($response->type == "success")
  { 
  	return true;
  	echo "true";
  }
            else{
            	echo "false";

             return false;
         }
}


?>