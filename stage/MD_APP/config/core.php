<?php
//require_once '../../../../../vendor/autoload.php'; //Twilio
//use Twilio\Rest\Client; //Twilio
date_default_timezone_set('Asia/Kolkata');
$indiaDateTime = date("Y-m-d H:i:s");
$indiaDate     = date("Y-m-d");
$userImageUrl='https://d15oaddy33hwjt.cloudfront.net/userImage/';
$verification_code = "9QQ9XK3DdF";
$invoicepath = "/development/";
$baseUrlPath = "https://powersoapapp.in/development/";
$tcpf_file = "/home/powersoap/public_html/development/invoice_pdf/";
$dashboard_link = "https://powersoapapp.in/";

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
    $cookie_admin_state   = $row['state_id'];
}else{
    $cookie_admin_name = "";
    $verification_code = "6978567859";
    setcookie("token_admin_dashboard_development", "", time() + (86400 * 30), "/");
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
function gmdate_to_normal_datetime($date){
    $dt = new DateTime($date, new DateTimeZone('UTC'));
    $dt->setTimezone(new DateTimeZone('Asia/Kolkata'));
    return $dt->format('Y-m-d H:i:s');
}
function email($email_id,$password,$distributor_name,$invoicepath,$dashboard_link){
    $mail = new PHPMailer;
    $mail->isSMTP(); 
    $mail->addAddress($email_id);
    $mail->setFrom('support@powersoapapp.in', 'PowerSoaps');       
    $mail->Username = 'AKIAZJLC2MIPTRWPFQ5Q';
    $mail->Password = 'BOvjyaJ2clBt/auQnnDwXHuzqz8mnymLt01BEWSNkHjH';
    $mail->Host = 'email-smtp.ap-south-1.amazonaws.com';
    $mail->Subject = 'Password for Sign Up from Distributor Dashboard';
    //$mail->Body = $password;
    $mail->Body = 'Dear '.$distributor_name.',<br/><br/> Your Personal Login Details<br/> E-mail : '.$email_id.'<br/> Password : '.$password.'<br/>Dashboard link: '.$dashboard_link.' <br/><br/> Thank you,<br/> PowerSoaps';
    $mail->SMTPAuth = true;                           
    $mail->SMTPSecure = 'tls';                         
    $mail->Port = 587;
    $mail->isHTML(true);
    if (!$mail->send()) {
//         echo 'Mailer Error: ' . $mail->ErrorInfo;
        return false;
    } else {
//         echo "success";
        return true;
    }
}
function emailSend($email_id,$password,$distributor_name){
    $mail = new PHPMailer;
    $mail->isSMTP(); 
    $mail->addAddress($email_id);
    $mail->setFrom('support@powersoapapp.in', 'PowerSoaps');       
    $mail->Username = 'AKIAZJLC2MIPTRWPFQ5Q';
    $mail->Password = 'BOvjyaJ2clBt/auQnnDwXHuzqz8mnymLt01BEWSNkHjH';
    $mail->Host = 'email-smtp.ap-south-1.amazonaws.com';
    $mail->Subject = 'Password for Sign Up from Admin Dashboard';
    //$mail->Body = $password;
    $mail->Body = 'Dear '.$distributor_name.',<br/><br/> Your Personal Login Details<br/> E-mail : '.$email_id.'<br/> Password : '.$password.'<br/> Thank you,<br/> PowerSoaps';
    $mail->SMTPAuth = true;                           
    $mail->SMTPSecure = 'tls';                         
    $mail->Port = 587;
    $mail->isHTML(true);
    if (!$mail->send()) {
//         echo 'Mailer Error: ' . $mail->ErrorInfo;
        return false;
    } else {
//         echo "success";
        return true;
    }
}
//dateconvert
function convertDate($format,$date){
    $dt = new DateTime($date);
    $tz = new DateTimeZone('Asia/Kolkata');
    $dt->setTimezone($tz);
    return $dt->format($format);
}
function generatePassword($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function token_generate($table_name,$column_name){
    $random = rand(10000000,99999999);
    $val=true;
    do{
        $result = mysqli_query($GLOBALS['link'], "SELECT `$column_name` FROM `$table_name` WHERE `$column_name`='$random'");
        $count = mysqli_num_rows($result);
        if($count==0){
            $val = false;
        }else{
            $random = rand(10000000,99999999);
        }
    }while($val);
    return $random;
}

function moneyFormatIndia($cost) {
    $cost = number_format((float)$cost, 2, '.', '');
    $cost_value_array = explode(".", $cost);

    $num = $cost_value_array[0];

    $explrestunits = "";
    if(strlen($num)>3) {
        $lastthree = substr($num, strlen($num)-3, strlen($num));
        $restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
        $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
        $expunit = str_split($restunits, 2);
        for($i=0; $i<sizeof($expunit); $i++) {
            // creates each of the 2's group and adds a comma to the end
            if($i==0) {
                $explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
            } else {
                $explrestunits .= $expunit[$i].",";
            }
        }
        $thecash = $explrestunits . $lastthree;
    } else {
        $thecash = $num;
    }
    if ( $cost_value_array[1] != "00") {
        $thecash .= "." . $cost_value_array[1];
    }
    return $thecash; // writes the final format where $currency is the currency symbol.
}
?>