<?php
$access_token = 'e1MrLtknhZ66lKs5h1DRAphwwyg9ra+oOTA0wTMx4J1h19cD1yE/b9OKsHzK9qiRJQd8JT0/HBOJ+ZfR6yhTQalvcAr7jvbiMsfSI0CvFUytlY8GceZQtwkLsGiZ+OWy9omqCKYPKgq68vKEPB6axgdB04t89/1O/w1cDnyilFU=';

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;
