<?php
$access_token = 'rufj2ZJ4iDMiyJvV9LHIom82VqtKJXW0oo5t4seLZqXCjdiXskE5HYMWWtGx09J/HfWHmb3PXO0TmkQm1XGYttMl24ckWdLZKcWx5sY4V5s1dk4W1zKuVjtM5khLwFI3uUkx5c/b2CFZ8rwk3mZyjQdB04t89/1O/w1cDnyilFU=';

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;
