<?php

$API_URL = 'https://api.line.me/v2/bot/message/reply';
$ACCESS_TOKEN = 'MI5/Zsb0N/oB/oBGw0V7hh8UhCvWMbCANwXkd+2mSHwPIxhnvww8EKjWzvfE7Q9OeivgZj8B32ojTXYKMUuptQB5EzSX89MiBnOzP/Yv9AVvjUxQgoQkeMeBjhJBG+tOPk+LxrGdaIqhzmtZJODiHQdB04t89/1O/w1cDnyilFU='; // Access Token ค่าที่เราสร้างขึ้น
$POST_HEADER = array('Content-Type: application/json', 'Authorization: Bearer ' . $ACCESS_TOKEN);

$request = file_get_contents('php://input');   // Get request content
$request_array = json_decode($request, true);   // Decode JSON to Array

if ( sizeof($request_array['events']) > 0 )
{

 foreach ($request_array['events'] as $event)
 {
  $reply_message = '';
  $reply_token = $event['replyToken'];

  if ( $event['type'] == 'message' ) 
  {
   
   if( $event['message']['type'] == 'text' )
   {
		$text = $event['message']['text'];
		
		$reply_message = 'ระบบกรมสรรพสามิตได้รับข้อความ ('.$text.') เรียบร้อย!!';   
	   
	   if($text == "ตื่นรึยังบอท"){
		   $reply_message = 'ตื่นแล้ว! พร้อมให้บริการ...';
	   }
	    if($text == "กว่าจะตอบฉันน๊ะบอท"){
		   $reply_message = 'ขอภัยในความล่าช้า ฉันยังง่วงนิสหน่อย แต่ฉันพร้อให้บริการตลอดเวลา..';
	   }
	   if($text == "ปริมาณแอลกอฮอล์ที่เข้าสู่ระบบ"){
		   $reply_message = 'https://www.excise.go.th/cs/groups/public/documents/document/dwnt/mzgy/~edisp/uatucm382602.pdf';
	   }
	  
	   if($text == "ข้อมูลผู้ผลิตและจำหน่ายเอทานอล"){
		   $reply_message = 'https://webdev.excise.go.th/alc/locations.html';
	   }
	   
	   if($text == "ใบอนุญาตขายสุราของฉันหมดอายุวันไหน"){
		   $reply_message = 'ฉันขอเลขที่ใบอนุญาตของคุณเพื่อทำการตรวจสอบ';
	   }
	   
   }
   else
    $reply_message = 'ระบบกรมสรรพสามิตได้รับ '.ucfirst($event['message']['type']).' ของคุณแล้ว';
  
  }
  else
   $reply_message = 'ระบบกรมสรรพสามิตได้รับ Event '.ucfirst($event['type']).' ของคุณแล้ว';
 
  if( strlen($reply_message) > 0 )
  {
   //$reply_message = iconv("tis-620","utf-8",$reply_message);
   $data = [
    'replyToken' => $reply_token,
    'messages' => [['type' => 'text', 'text' => $reply_message]]
   ];
   $post_body = json_encode($data, JSON_UNESCAPED_UNICODE);

   $send_result = send_reply_message($API_URL, $POST_HEADER, $post_body);
   echo "Result: ".$send_result."\r\n";
  }
 }
}

echo "OK";

function send_reply_message($url, $post_header, $post_body)
{
 $ch = curl_init($url);
 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($ch, CURLOPT_HTTPHEADER, $post_header);
 curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body);
 curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
 $result = curl_exec($ch);
 curl_close($ch);

 return $result;
}

?>
