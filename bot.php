<?php

namespace LINE;

use LINE\LINEBot;
use LINE\LINEBot\Constant\MessageType;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\Util\DummyHttpClient;

require_once('corebot.php');

$channelAccessToken = 'e1MrLtknhZ66lKs5h1DRAphwwyg9ra+oOTA0wTMx4J1h19cD1yE/b9OKsHzK9qiRJQd8JT0/HBOJ+ZfR6yhTQalvcAr7jvbiMsfSI0CvFUytlY8GceZQtwkLsGiZ+OWy9omqCKYPKgq68vKEPB6axgdB04t89/1O/w1cDnyilFU=';
$channelSecret = '01499f7264759f7ab07bb96a2eb63279';


$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($channelAccessToken);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $channelSecret]);
//$client = new corebot($channelAccessToken, $channelSecret);
foreach ($bot->parseEvents() as $event) {
    switch ($event['type']) {
        case 'message':
            $message = $event['message'];
            switch ($message['type']) {
                case 'text':
                    //$client->replyMessage(array(
                    //    'replyToken' => $event['replyToken'],
                    //    'messages' => array(
                    //        array(
                    //            'type' => 'text',
                    //            'text' => $message['text']
                    //        )
                    //    )
                    //));
                    $response = $bot->replyText($channelAccessToken, 'hello!');
                    break;
                default:
                    error_log("Unsupporeted message type: " . $message['type']);
                    break;
            }
            break;
        default:
            error_log("Unsupporeted event type: " . $event['type']);
            break;
    }
};
