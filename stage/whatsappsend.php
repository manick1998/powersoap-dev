<?php
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://apii.msg91.com/api/v5/whatsapp/whatsapp-outbound-message/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "integrated_number": "918110882222",
    "content_type": "template",
    "payload": {
        "to": "<9360957658>",
        "type": "template",
        "template": {
            "name": "abirami_soaps_works_llp",
            "language": {
                "code": "en_GB",
                "policy": "deterministic"
            },
            "components": [
                {
                    "type": "body",
                    "parameters": [
                        {
                            "type": "text",
                            "text": "<{{40}}>"
                        },
                        {
                            "type": "text",
                            "text": "<{{2}}>"
                        },
                        {
                            "type": "text",
                            "text": "<{{04/01/2024}}>"
                        },
                        {
                            "type": "text",
                            "text": "<{{04/01/2024}}>"
                        }
                    ]
                }
            ]
        },
        "messaging_product": "whatsapp"
    }
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'authkey: <380803AF0dsqJz8g62f75785P1>',
  ),
));
$response = curl_exec($curl);
curl_close($curl);
echo $response;
?>