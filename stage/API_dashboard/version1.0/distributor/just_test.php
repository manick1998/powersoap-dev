<?php
$endpoint = 'https://api.sandbox.paypal.com/v1/oauth2/token'; // PayPal API endpoint (sandbox)
$client_id = 'ASiss-7UgPLLPMTs32oFFD9pybj2IB7MBWbzwDatGRHmujHmypdLMI9ThVuyxnYwCyA4SAs7dNijYy_-'; // Your PayPal client ID
$client_secret = 'EPbebSV50_CNXLvxeIfi7dMikkU1b36negebSy1fywlQU2f55gxejFesC0s4DnCrmSR-hvbnQE9bYu3v'; // Your PayPal client secret
// Request an access token
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $endpoint);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Accept-Language: en_US'));
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, $client_id . ':' . $client_secret);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
$result = curl_exec($ch);
curl_close($ch);
$response = json_decode($result, true);
if (isset($response['access_token'])) {
  $access_token = $response['access_token'];
  // Verify PayPal account existence
  $username = 'bosco@mobility.international'; // PayPal account username
  $password = 'Frog@@678@@Frog'; // PayPal account password
  $endpoint = 'https://api.sandbox.paypal.com/v1/identity/openidconnect/userinfo/?schema=openid';
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $endpoint);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $access_token));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_USERPWD, $username . ':' . $password);
  $result = curl_exec($ch);
  curl_close($ch);
  $response = json_decode($result, true);
  if (isset($response['user_id'])) {
    echo "PayPal account exists.";
  } else {
    echo "PayPal account does not exist.";
  }
} else {
  echo "Failed to retrieve access token.";
}
?>






