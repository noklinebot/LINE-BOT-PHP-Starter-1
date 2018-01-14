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
   
      // Get replyToken
   $replyToken = $event['replyToken'];



   
   
   
   
    // Insert postgreSQL
   $dbconn = pg_connect("host=ec2-54-225-255-132.compute-1.amazonaws.com port=5432 dbname=d1fcitdn1516dv user=roxhkyiabreyva password=b895f0848a866f6590be13f6b843b6bce4a9a875137c0e8f635722c2535500c5 sslmode=require options='--client_encoding=UTF8'") or die('Could not connect: ' . pg_last_error());
   pg_query_params($dbconn, 'INSERT INTO lotto(msg, sender) VALUES ($1, $2);', array($text, $replyToken));
   
$GLOBALS["checktype"] = "";
$GLOBALS["ArrNo"]=0;

function MySortNum($TmpStr){
	$stringParts = str_split($TmpStr);
	sort($stringParts);
	return implode('', $stringParts);
}

function MyType($TmpStr){
	if (strlen($TmpStr)==1){
		return "วิ่ง";
	}
	else if (strlen($TmpStr)==2){
		return "2ตัว";
	}
	else if (strlen($TmpStr)==3){
		return "3ตัว";
	}
	else{
		return "";	
	}

}

	
	$SPLine=$array = preg_split("/(\r\n|\n|\r)/", $text);

	$arrlength = count($SPLine);
	
	
	for($x = 0; $x < $arrlength; $x++) {
		//echo $SPLine[$x];
		//echo "<br>";
		$ReadData= trim(strtoupper($SPLine[$x]));
		if ($ReadData=='บน'){
			$checktype = 'บน';
		}
		else if ($ReadData=='ล่าง'){
			$checktype = 'ล่าง';
		}

		$ReturnData[$x] = $SPLine[$x]. " /// ";

		if (($checktype=="บน" || $checktype=="ล่าง")){
			if (!empty($ReadData)){
				if (strpos(trim($ReadData),' ')>0 || strpos(trim($ReadData),'-')>0){
					$ArrLine="";
					if (strpos(trim($ReadData),'-')>0){
						$ArrLine=explode('-', trim($ReadData));
					}
					else if (strpos(trim($ReadData),' ')>0 ){
						$ArrLine=explode(' ', trim($ReadData));	
					}
					
					if (count($ArrLine)==2){
						if (is_numeric($ArrLine[0])){
							if (strlen($ArrLine[0])>0 && strlen($ArrLine[0])<4){
								if (strpos(trim($ArrLine[1]),'X')>0){
									$ArrLine1=explode('X', trim($ArrLine[1]));
									
									if (count($ArrLine1)==2){
										if (is_numeric($ArrLine1[0])){
											if ($checktype=="บน"){
												$CorrectData[$ArrNo][0] = $ArrLine[0];
												$CorrectData[$ArrNo][1] = $ArrLine1[0];
												$CorrectData[$ArrNo][2] = "0";
												$CorrectData[$ArrNo][3] = "0";
												$ArrNo=$ArrNo+1;
												$ReturnData[$x] = $ReturnData[$x] . " " . MyType($ArrLine[0]) . "บน " . $ArrLine[0] . "-" . $ArrLine1[0];
											}
											else if ($checktype=="ล่าง"){
												$CorrectData[$ArrNo][0] = $ArrLine[0];
												$CorrectData[$ArrNo][1] = "0";
												$CorrectData[$ArrNo][2] = "0";
												$CorrectData[$ArrNo][3] = $ArrLine1[0];
												$ArrNo=$ArrNo+1;
												$ReturnData[$x] = $ReturnData[$x] . " " . MyType($ArrLine[0]) . "ล่าง " . $ArrLine[0] . "-" . $ArrLine1[0];
											}
											else{
												//ไม่ระบุ บน ล่าง หรือ ตัวเลขแทง
												$ReturnData[$x] = $ReturnData[$x] . " ไม่ระบุ บน ล่าง หรือ ตัวเลขแทง";
											}
											
											if (is_numeric($ArrLine1[1])){
												if (strlen($ArrLine[0])==1){
													//รายการไม่ถูกต้อง
													$ReturnData[$x] = $ReturnData[$x] . " x รายการไม่ถูกต้อง";
												}
												else if (strlen($ArrLine[0])==2){
													$TmpSwapString = str_split($ArrLine[0]);
													$SwapString = "$TmpSwapString[1]$TmpSwapString[0]";
													if ($checktype=="บน"){
														$CorrectData[$ArrNo][0] = $SwapString;
														$CorrectData[$ArrNo][1] = $ArrLine1[1];
														$CorrectData[$ArrNo][2] = "0";
														$CorrectData[$ArrNo][3] = "0";
														$ArrNo=$ArrNo+1;
														$ReturnData[$x] = $ReturnData[$x] . " x " . MyType($SwapString) . "บน " . $SwapString . "-" . $ArrLine1[1];
													}
													else if ($checktype=="ล่าง"){
														$CorrectData[$ArrNo][0] = $SwapString;
														$CorrectData[$ArrNo][1] = "0";
														$CorrectData[$ArrNo][2] = "0";
														$CorrectData[$ArrNo][3] = $ArrLine1[1];
														$ArrNo=$ArrNo+1;
														$ReturnData[$x] = $ReturnData[$x] . " x " . MyType($SwapString) . "ล่าง " . $SwapString . "-" . $ArrLine1[1];
													}
													else{
														//ไม่ระบุ บน ล่าง หรือ ตัวเลขแทง
														$ReturnData[$x] = $ReturnData[$x] . " x ไม่ระบุ บน ล่าง หรือ ตัวเลขแทง";
													}

												}
												else if (strlen($ArrLine[0])==3){
													$SwapString = MySortNum($ArrLine[0]);
													if ($checktype=="บน"){
														$CorrectData[$ArrNo][0] = $SwapString;
														$CorrectData[$ArrNo][1] = "0";
														$CorrectData[$ArrNo][2] = $ArrLine1[1];
														$CorrectData[$ArrNo][3] = "0";
														$ArrNo=$ArrNo+1;
														$ReturnData[$x] = $ReturnData[$x] . " x " . MyType($SwapString) . "โต๊ดบน " . $SwapString . "-" . $ArrLine1[1];
													}
													else if ($checktype=="ล่าง"){
														//รายการไม่ถูกต้อง
														$ReturnData[$x] = $ReturnData[$x] . " x รายการไม่ถูกต้อง";
													}
													else{
														//ไม่ระบุ บน ล่าง หรือ ตัวเลขแทง
														$ReturnData[$x] = $ReturnData[$x] . " x ไม่ระบุ บน ล่าง หรือ ตัวเลขแทง";
													}
												}
												else{
													//รายการไม่ถูกต้อง
													$ReturnData[$x] = $ReturnData[$x] . " x รายการไม่ถูกต้อง";
												}
											}
											else
											{
												// ค่าเงินผิด
												$ReturnData[$x] = $ReturnData[$x] . " x ค่าเงินผิด";
											}

										}
										else
										{
											// ค่าเงินผิด
											$ReturnData[$x] = $ReturnData[$x] . " x ค่าเงินผิด";
										}
									}
									else{
										//รายการไม่ถูกต้อง
										$ReturnData[$x] = $ReturnData[$x] . " x รายการไม่ถูกต้อง";
									}

								}
								else{
									if (is_numeric($ArrLine[1])){
										if ($checktype=="บน"){
											$CorrectData[$ArrNo][0] = $ArrLine[0];
											$CorrectData[$ArrNo][1] = $ArrLine[1];
											$CorrectData[$ArrNo][2] = "0";
											$CorrectData[$ArrNo][3] = "0";
											$ArrNo=$ArrNo+1;
											$ReturnData[$x] = $ReturnData[$x] . " " . MyType($ArrLine[0]) . "บน " . $ArrLine[0] . "-" . $ArrLine[1];
										}
										else if ($checktype=="ล่าง"){
											$CorrectData[$ArrNo][0] = $ArrLine[0];
											$CorrectData[$ArrNo][1] = "0";
											$CorrectData[$ArrNo][2] = "0";
											$CorrectData[$ArrNo][3] = $ArrLine[1];
											$ArrNo=$ArrNo+1;
											$ReturnData[$x] = $ReturnData[$x] . " " . MyType($ArrLine[0]) . "ล่าง " . $ArrLine[0] . "-" . $ArrLine[1];
										}
										else{
											//ไม่ระบุ บน ล่าง หรือ ตัวเลขแทง
											$ReturnData[$x] = $ReturnData[$x] . " ไม่ระบุ บน ล่าง หรือ ตัวเลขแทง";
										}
									}
									else{
										// ค่าเงินผิด
										$ReturnData[$x] = $ReturnData[$x] . " ค่าเงินผิด";
									}	
								}
							}
							else{
								//รายการไม่ถูกต้อง
								$ReturnData[$x] = $ReturnData[$x] . " รายการไม่ถูกต้อง";
							}
						}
						else
						{
							//รายการต้องเป็นตัวเลข
							$ReturnData[$x] = $ReturnData[$x] . " รายการต้องเป็นตัวเลข";
						}
					}
					else{
						// รูปแบบไม่ถูกต้อง
						$ReturnData[$x] = $ReturnData[$x]. " รูปแบบไม่ถูกต้อง";			
					}
				}
				else{
					if ($checktype=="บน" || $checktype=="ล่าง"){
				
					}
					else{
						// รูปแบบไม่ถูกต้อง
						$ReturnData[$x] = $ReturnData[$x]. " รูปแบบไม่ถูกต้อง";
					}
				}		
			}
			else
			{
				// รูปแบบไม่ถูกต้อง
				$ReturnData[$x] = $ReturnData[$x]. " รูปแบบไม่ถูกต้อง";
				
			}

		}
		else 
		{
			//ไม่ระบุ บน ล่าง หรือ ตัวเลขแทง
			$ReturnData[$x] = $ReturnData[$x] . " ไม่ระบุ บน ล่าง หรือ ตัวเลขแทง";
		}
	}
		

for($x = 0; $x < count($CorrectData); $x++) {


	//echo $CorrectData[$x][0];
	//echo $CorrectData[$x][1];
	//echo $CorrectData[$x][2];
	//echo $CorrectData[$x][3];
	//echo "<br>";
}

echo "<br>";
   
  $text = "";
for($x = 0; $x < count($ReturnData); $x++) {
	echo $ReturnData[$x];
	echo "<br>";
 $text = $text . $ReturnData[$x] . "\n";
}

   
   
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
