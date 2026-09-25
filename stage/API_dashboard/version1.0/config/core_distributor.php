<?php
error_reporting(0);
ini_set('display_errors', 0);
@session_start();
//require_once '../../../../../vendor/autoload.php'; //Twilio
//use Twilio\Rest\Client; //Twilio
date_default_timezone_set('Asia/Kolkata');
$indiaDateTime = date("Y-m-d H:i:s");
$indiaDate = date("Y-m-d");
$indiaDateFormat = date("d-m-Y");
$userImageUrl = 'https://d15oaddy33hwjt.cloudfront.net/userImage/';
$verification_code = "6FBE2BCF86";
require_once dirname(__FILE__) . '/../../../database_credentials.php';
$invoicepath = APP_FOLDER_PATH;
$baseUrlPath = BASE_URL;
$tcpf_file = PDF_GENERATOR_PATH;
$dashboard_link = APP_ROOT_URL;

$link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

mysqli_set_charset($link, "utf8");
//$distributor_token1 = $_SESSION['distributor_token'];
// mysqli_query($link, "SET SESSION group_concat_max_len = 1000000;");
//$cookie_token    = $_COOKIE["token_admin_dashboard_development"];
//
//$result  = mysqli_query($link, "SELECT `token`, `name`, `email_id` FROM `employees` WHERE `token`='$distributor_token1' AND `block_status`='1'");
//$row     = mysqli_fetch_array($result);
//if(mysqli_num_rows($result)==1){
//    $cookie_admin_name   = $row['name'];
//}else{
//    unset($_SESSION['distributor_token']);
//    $cookie_admin_name = "";
//    $verification_code = "6978567859";
//}
function getInputs()
{
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    return json_decode(file_get_contents("php://input"));
}

function token_generate($table_name, $column_name)
{
    $random = rand(10000000, 99999999);
    $val = true;
    do {
        $result = mysqli_query($GLOBALS['link'], "SELECT `$column_name` FROM `$table_name` WHERE `$column_name`='$random'");
        $count = mysqli_num_rows($result);
        if ($count == 0) {
            $val = false;
        } else {
            $random = rand(10000000, 99999999);
        }
    } while ($val);
    return $random;
}

//function moneyFormatIndia($num){
//    $explrestunits = "" ;
//    if(strlen($num)>3){
//        $lastthree = substr($num, strlen($num)-3, strlen($num));
//        $restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
//        $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
//        $expunit = str_split($restunits, 2);
//        for($i=0; $i < sizeof($expunit);  $i++){
//            // creates each of the 2's group and adds a comma to the end
//            if($i==0)
//            {
//                $explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
//            }else{
//                $explrestunits .= $expunit[$i].",";
//            }
//        }
//        $thecash = $explrestunits.$lastthree;
//    } else {
//        $thecash = $num;
//    }
//    return $thecash; // writes the final format where $currency is the currency symbol.
//}
//$link = "";

function numbertoword($number)
{
    //$number = 190908100.25;
    $no = floor($number);
    $point = round($number - $no, 2) * 100;
    $hundred = null;
    $digits_1 = strlen($no);
    $i = 0;
    $str = array();
    $words = array(
        '0' => '', '1' => 'one', '2' => 'two',
        '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
        '7' => 'seven', '8' => 'eight', '9' => 'nine',
        '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
        '13' => 'thirteen', '14' => 'fourteen',
        '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
        '18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty',
        '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
        '60' => 'sixty', '70' => 'seventy',
        '80' => 'eighty', '90' => 'ninety'
    );
    $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
    while ($i < $digits_1) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += ($divider == 10) ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str[] = ($number < 21) ? $words[$number] .
                " " . $digits[$counter] . $plural . " " . $hundred
                :
                $words[floor($number / 10) * 10]
                . " " . $words[$number % 10] . " "
                . $digits[$counter] . $plural . " " . $hundred;
        } else {
            $str[] = null;
        }
    }
    $str = array_reverse($str);
    $result = implode('', $str);
    $points = ($point) ?
        "." . $words[$point / 10] . " " .
        $words[$point = $point % 10] : '';
    return ucwords($result . "rupees  ");
}
//. $points . " paise"

function email($email_id, $otp)
{
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->addAddress($email_id);
    
    // --- Gmail SMTP Settings Updated Here ---
    $mail->setFrom('otppowersoaps@gmail.com', 'PowerSoaps');
    $mail->Username = 'otppowersoaps@gmail.com';
    $mail->Password = 'hyxftdvmqldkqoxa'; // App Password (Spaces removed)  #Power@12345
    $mail->Host = 'smtp.gmail.com';
    // ----------------------------------------
    
    $mail->Subject = 'Otp generate for forgot password from Distributor Dashboard';
    $mail->Body = 'Your OTP for password change request is ' . $otp;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->isHTML(true);
    
    if (!$mail->send()) {
        // echo 'Mailer Error: ' . $mail->ErrorInfo;
        return false;
    } else {
        // echo "success";
        return true;
    }
}

function indCurrencyFormatComma($num)
{
    return $num = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $num);
}

$distributor_token = $_SESSION["distributor_token"];
$result = mysqli_query($link, "SELECT count(`id`) AS `notification_count` FROM `admin_notification` WHERE `distributor_token`='$distributor_token' AND `seen_status`='0' AND `delete_status`='1'");
$row = mysqli_fetch_assoc($result);
$notiCount = $row["notification_count"];