<?php
include 'vendor/autoload.php';
require_once dirname(__FILE__) . '/../../../../database_credentials.php';

function sendNotifications()
{
    $order_date = date('Y-m-d H:i:s'); // corrected date format
    $dayname = date('l', strtotime($order_date));
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if (!$link) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $employee_query = mysqli_query($link, "SELECT `sales_emp_token`,`distributor_token` FROM `daily_schedule` WHERE `schedule_date`='$dayname' AND `sales_emp_token`!=''");

    while ($employee_row = mysqli_fetch_array($employee_query)) {
        $employee_token = $employee_row['sales_emp_token'];
        $distributor_token = $employee_row['distributor_token'];

        $query2 = mysqli_query($link, "SELECT `state_id` FROM `employees` WHERE `token`='$distributor_token' AND `state_id`!=''");
        $state_row = mysqli_fetch_array($query2);
        $state_token = $state_row['state_id'];

        $query = mysqli_query($link, "SELECT `device_token` FROM `employees` WHERE `token`='$employee_token' AND `device_token`!=''");
        $row = mysqli_fetch_array($query);
        $deviceToken = $row['device_token'];

        if ($deviceToken != '') {
            if ($state_token == '81940285' || $state_token == '28444992') {
                $title = "Today's Schedule";
                $body = "அன்புள்ள விற்பனையாளர் உங்கள் இன்றைய கடை பட்டியல் தயாராக உள்ளது. தயவுசெய்து உடனடியாக ஆர்டர் செய்யுங்கள். நன்றி.";
            } else {
                $title = "Today's Schedule";
                $body = "Dear Salesman, Your shop list for today's beat is ready. Please place your order immediately in the Powersoasp salesman app. Thank you.";
            }

            sendSMS($deviceToken, $title, $body);
        } else {
            error_log("Device token for employee token $employee_token is missing.");
        }
    }
}

function sendSMS($deviceToken, $title, $body)
{
    $payload = [
        'message' => [
            'token' => $deviceToken,
            'notification' => [
                'title' => $title,
                'body' => $body,
            ],
        ],
    ];

    $projectId = 'powersoap-sales'; // Firebase project ID
    $accessToken = getAccessToken();

    $result = sendFCMNotification($projectId, $accessToken, $payload);

    if ($result['status'] === 'success') {
        return ('Notification sent successfully.');
    } else {
        return ("Notification sent unsuccessful: " . $result['message']);
    }
}

function base64UrlEncode($data)
{
    return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
}

function createJWT($payload, $privateKey, $alg = 'RS256')
{
    $header = [
        'typ' => 'JWT',
        'alg' => $alg
    ];
    $base64UrlHeader = base64UrlEncode(json_encode($header));
    $base64UrlPayload = base64UrlEncode(json_encode($payload));
    $data = $base64UrlHeader . '.' . $base64UrlPayload;
    openssl_sign($data, $signature, $privateKey, OPENSSL_ALGO_SHA256);
    $base64UrlSignature = base64UrlEncode($signature);

    return $base64UrlHeader . '.' . $base64UrlPayload . '.' . $base64UrlSignature;
}

function getAccessToken()
{
    $serviceAccountFilePath =  '../../salesAppFirebaseConfig.json';
    $credentials = json_decode(file_get_contents($serviceAccountFilePath), true);
    $privateKey = $credentials['private_key'];

    $tokenUri = 'https://oauth2.googleapis.com/token';
    $payload = [
        'iss' => $credentials['client_email'],
        'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
        'aud' => 'https://oauth2.googleapis.com/token',
        'iat' => time(),
        'exp' => time() + 3600,
    ];

    $jwt = createJWT($payload, $privateKey);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $tokenUri);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
        'assertion' => $jwt,
    ]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    if ($response === false) {
        throw new Exception('Curl error: ' . curl_error($ch));
    }
    $responseData = json_decode($response, true);
    curl_close($ch);
    if (!isset($responseData['access_token'])) {
        throw new Exception('Could not fetch access token.');
    }
    return $responseData['access_token'];
}

function sendFCMNotification($projectId, $accessToken, $payload)
{
    $url = 'https://fcm.googleapis.com/v1/projects/' . $projectId . '/messages:send';
    try {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json',
        ]);

        $response = curl_exec($ch);
        if ($response === false) {
            throw new Exception('Curl error: ' . curl_error($ch));
        }
        $responseData = json_decode($response, true);
        print_r($responseData);
        if (isset($responseData['name'])) {
            return [
                'status' => 'success',
                'response' => $responseData,
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Request failed: ' . json_encode($responseData),
            ];
        }
    } catch (Exception $e) {
        return [
            'status' => 'error',
            'message' => 'Error: ' . $e->getMessage(),
        ];
    }
}

// Call the sendNotifications function
sendNotifications();
