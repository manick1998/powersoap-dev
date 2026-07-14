<?php

// ini_set('display_errors', 1);// show error reporting
//  error_reporting(E_ALL);
 
date_default_timezone_set('Asia/Kolkata');
$indiaDateTime = date("Y-m-d H:i:s");
$indiaDate     = date("Y-m-d");
function convertDate($format,$date){
    $dt = new DateTime($date);
    $tz = new DateTimeZone('Asia/Kolkata');
    $dt->setTimezone($tz);
    return $dt->format($format);
}

// $date = new DateTime(date("Y-m-d H:i:s"),new DateTimeZone('GMT'));
// $date->setTimezone(new DateTimeZone('GMT+5:30'));
//  $datefun =  $date->format('Y-m-d h:m:s'); 
  $currnetDateTime = $indiaDateTime;// gmdate("yyyy-mm-dd h:m:s");

  require_once __DIR__ . '/../database_credentials.php';
  
  $link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  mysqli_set_charset($link, "utf8");
if(!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

$box_value = 10;

function sendOTP($mobile) {
    // $link_new = mysqli_connect('localhost','powersoap_dev','=Kb9PetRpam2','powersoap_dev');
    // $indiaDateTime_new = date("Y-m-d H:i:s");
   $randomnums = rand(1000, 9999);
     // Collecting the variables to be sent in send otp server call
        $url = "https://apii.msg91.com/api/v5/otp?authkey=380803AF0dsqJz8g62f75785P1&country=91&mobile=$mobile&otp=$randomnums&template_id=62fe0b0ed6fc0527cd2385c4";
   

       // Creating cURL to hit the url and get the response
        $curl = curl_init();
        curl_setopt_array($curl, array(
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
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
         $result = json_decode($response);

        // From URL to get webpage contents.
        //  $url = "https://bhashsms.com/api/sendmsg.php?user=Powersoaps&pass=9003880088&sender=ASWFLY&phone=$mobile&text=Your%20verification%20code%20for%20Power%20Soaps%20is%20$randomnums.%20Thank%20you%20for%20choosing%20Abirami%20Soap%20Works%20LLP.&priority=ndnd&stype=normal";
         
        // // Initialize a CURL session.
        // $ch = curl_init();
         
        // // Return Page contents.
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
         
        // //grab URL and pass it to the variable.
        // curl_setopt($ch, CURLOPT_URL, $url);
         
        // $result = curl_exec($ch);
         
 if ($err) {
            return false; // echo "cURL Error #:" . $err;
        } else {
            if ($result->type == "success") return true;
            else return false;
        }

        // if ($result == '') {
        //     return false; // echo "cURL Error #:" . $err;
        // } else {
        //     // if ($result->type == "success") return true;
        //     // $insert_query = mysqli_query($link_new,"INSERT INTO `otp`( `mobile_number`, `otp`, `status`, `date_time`) VALUES ('$mobile','$randomnums','Pending','$indiaDateTime_new')");
        //      return true;

        // }

}

  function otpVerify($mobile,$otp){
    // $link_new1 = mysqli_connect('localhost','powersoap_dev','=Kb9PetRpam2','powersoap_dev');

        // // Collecting the variables to be sent in send otp server call
        $url = "https://apii.msg91.com/api/v5/otp/verify?authkey=380803AF0dsqJz8g62f75785P1&country=91&mobile=$mobile&otp=$otp";

        // Creating cURL to hit the url and get the response
        $curl = curl_init();
        curl_setopt_array($curl, array(
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
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        // $result = json_decode($response);
    // $get_select = mysqli_query($link_new1,"SELECT `mobile_number`,`otp`,`status` FROM `otp` WHERE `mobile_number`=$mobile  AND `status` = 'Pending' ORDER BY id DESC LIMIT 1");
    // $getdata_otp = mysqli_fetch_array($get_select);
    // $otp_val = $getdata_otp['otp'];

    // if($otp_val == $otp){
    // $update_status = mysqli_query($link_new1,"UPDATE `otp` SET `status`= 'Completed' WHERE `mobile_number` = $mobile");
    // return true;
    // } 
    // else {
    // return false;
    // }




        if ($err) {
            return false; // echo "cURL Error #:" . $err;
        } else {
            $result = json_decode($response);
            // echo $result->type;

            if ($result->type == "success") return true;
            else return false;
        }
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

function moneyFormatIndia($num){

    $explrestunits = "" ;
    $num = preg_replace('/,+/', '', $num);
    $words = explode(".", $num);
    $des = "00";
    if(count($words)<=2){
        $num=$words[0];
        if(count($words)>=2){$des=$words[1];}
        if(strlen($des)<2){$des="$des";}else{$des=substr($des,0,2);}
    }
    if(strlen($num)>3){
        $lastthree = substr($num, strlen($num)-3, strlen($num));
        $restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
        $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
        $expunit = str_split($restunits, 2);
        for($i=0; $i<sizeof($expunit); $i++){
            // creates each of the 2's group and adds a comma to the end
            if($i==0)
            {
                $explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
            }else{
                $explrestunits .= $expunit[$i].",";
            }
        }
        $thecash = $explrestunits.$lastthree;
    } else {
        $thecash = $num;
    }
    return "$thecash"; // writes the final format where $currency is the currency symbol.
    
}
$estimate_url = BASE_URL . "development/invoice_pdf/";
$baseUrlPath = BASE_URL;
?>
