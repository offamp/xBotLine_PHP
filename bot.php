<?php
$channelAccessToken = 'e1MrLtknhZ66lKs5h1DRAphwwyg9ra+oOTA0wTMx4J1h19cD1yE/b9OKsHzK9qiRJQd8JT0/HBOJ+ZfR6yhTQalvcAr7jvbiMsfSI0CvFUytlY8GceZQtwkLsGiZ+OWy9omqCKYPKgq68vKEPB6axgdB04t89/1O/w1cDnyilFU=';
date_default_timezone_set("Asia/Bangkok");
//$access_token = '';
// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON

$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = $event['message']['text'];
			$texts = explode(" ", $text);
			
			$messages = '';
			$codi = 1;
			switch ( $texts[0] )
			{
				case 'สวัสดี' :
					// Build message to reply back
					$messages = [
						'type' => 'text',
						'text' => 'ดีจร้า ^^'
					];
					break;
				case 'อากาศ' :
					// Build message to reply back
					$messages = [
						'type' => 'text',
						'text' => 'ออกไปมองท้องฟ้าดูจร้า'
					];
					break;
				case 'เวลา' :
					// Build message to reply back
					$messages = [
						'type' => 'text',
						'text' => date('Y-m-d H:i:s')
					];
					break;
				case 'บาย' :
					// Build message to reply back
					$messages = [
						'type' => 'text',
						'text' => 'บายจร้า เจอกันใหม่ ^^'
					];
					break;
				case 'ลูกค้า' :
					// Build message to reply back
					if(count($texts) >= 2)
					{
						if($texts[1] == '')
						{
							$messages = [
								'type' => 'text',
								'text' => 'ไม่พบข้อมูลลูกค้า.'
							];						
							break;
						}
						else
						{
						    try {
								
							$client = new SoapClient("http://122.155.180.88:8080/service1.svc?wsdl",
								array(
								  "trace"      => 1,		// enable trace to view what is happening
								  "exceptions" => 0,		// disable exceptions
								  "cache_wsdl" => 0) 		// disable any caching on the wsdl, encase you alter the wsdl server
							  );

							$params = array(
									   'value' => $texts[1],
									   'key' => "f1936efff69e4a7eac64df55f6636ade"
							);

							//$data = $client->GetCustomerByCustomerCode($params);
							
							//$point = $client->GetCstPointByCustomerCode($params);

						   //print_r($point);
						   //echo $data;
						   
						   $point = $client->GetPointByCode($params);
						
							//echo $point->GetPointByCodeResult;

							$messages = [
								'type' => 'text',
								'text' => $point->GetPointByCodeResult
							];						
							break;				   
							
						} catch (Exception $e) {
						        //echo 'Caught exception: ',  $e->getMessage(), "\n";
							$messages = [
								'type' => 'text',
								'text' => $e->getMessage()
							];						
							break;								    
						}	
					     }
					}
								
					$messages = [
						'type' => 'text',
						'text' => 'ไม่พบข้อมูลลูกค้า..'
					];
					break;					
				default:
					$codi = 0;
					break;				
			}
			
			if($codi==1)
			{
				// Get replyToken
				$replyToken = $event['replyToken'];
				// Build message to reply back
				//$messages = [
				//	'type' => 'text',
				//	'text' => $text
				//];
				// Make a POST Request to Messaging API to reply to sender
				$url = 'https://api.line.me/v2/bot/message/reply';
				$data = [
					'replyToken' => $replyToken,
					'messages' => [$messages],
				];
				$post = json_encode($data);
				$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $channelAccessToken);
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
				$result = curl_exec($ch);
				curl_close($ch);
				echo $result . "\r\n";	
			}
		}
	}
}
echo "OK";
?>
