<?php
$access_token = 'rufj2ZJ4iDMiyJvV9LHIom82VqtKJXW0oo5t4seLZqXCjdiXskE5HYMWWtGx09J/HfWHmb3PXO0TmkQm1XGYttMl24ckWdLZKcWx5sY4V5s1dk4W1zKuVjtM5khLwFI3uUkx5c/b2CFZ8rwk3mZyjQdB04t89/1O/w1cDnyilFU=';

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
   
   
$dbconn = pg_connect("host=ec2-54-225-255-132.compute-1.amazonaws.com port=5432 dbname=d1fcitdn1516dv user=roxhkyiabreyva password=b895f0848a866f6590be13f6b843b6bce4a9a875137c0e8f635722c2535500c5 sslmode=require options='--client_encoding=UTF8'") or die('Could not connect: ' . pg_last_error());

pg_query_params($dbconn, 'INSERT INTO lotto(msg, sender) VALUES ($1, $2);', array($text, "sender"));

   // Get replyToken
   $replyToken = $event['replyToken'];

   // Build message to reply back
   $messages = [
    'type' => 'text',
    'text' => $text
   ];

   // Make a POST Request to Messaging API to reply to sender
   $url = 'https://api.line.me/v2/bot/message/reply';
   $data = [
    'replyToken' => $replyToken,
    'messages' => [$messages],
   ];
   $post = json_encode($data);
   $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

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
echo "OK";
