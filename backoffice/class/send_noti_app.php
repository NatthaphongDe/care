<?php
define( 'URL_COULD_MSSAGE', 'https://fcm.googleapis.com/fcm/send' );
define( 'API_ACCESS_KEY', 'AIzaSyD4u2VxLRU04ePwTFN6VWk47kKxg6skgyo' );
function sendnoti($token,$CaseId,$message,$title,$device_platform,$msgNotiApp_id){
  global $conn;
   $token = $token; //token here
   $registrationIds = array($token) ;
   $fields = array(
   	'registration_ids' 	=> $registrationIds,
   );
   $body = "This is the body show Notification";
   $allnotreadmsg = 1;
   $notification = array(
     'title' =>$title ,
     'text' => $message,
     'sound'=> 1,
     'badge'=> $allnotreadmsg,
     'urlto'	=> '217'
   );

   if($device_platform=="1"){
     $registrationIds = array( $token );
     $msg = array(
     	'message' 	=> $message,
     	'title'		=> $title,
     	'subtitle'	=> 'This is a subtitle. subtitle',
     	'tickerText'	=> 'Ticker text here...Ticker text here...Ticker text here',
     	'vibrate'	=> 1,
     	'sound'		=> 1,
     	'largeIcon'	=> 'large_icon',
     	'smallIcon'	=> 'small_icon',
      'urlto'	=> $CaseId,
      'msgNotiApp_id'	=> $msgNotiApp_id
     );
     $fields = array(
     	'registration_ids' 	=> $registrationIds,
     	'data'			=> $msg
     );
     $arrayToSend = array('registration_ids' => $registrationIds, 'notification' => $notification,'priority'=>'high');
   }else{
     $arrayToSend = array('to' => $token, 'notification' => $notification,'priority'=>'high');
   }
   $json = json_encode($arrayToSend);

   $headers = array();
   $headers[] = 'Content-Type: application/json';
   $headers[] = 'Authorization: key=' . API_ACCESS_KEY;
   //Setup curl, add headers and post parameters.
   $ch = curl_init();
   curl_setopt( $ch,CURLOPT_URL, URL_COULD_MSSAGE );
	curl_setopt( $ch,CURLOPT_POST, true );
	curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
	curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
	curl_setopt( $ch,CURLOPT_POSTFIELDS,  $json  );
	$response = curl_exec($ch );
	curl_close( $ch );

   return $response;
}
function sendnotiAndroid($token,$CaseId,$message,$title,$msgNotiApp_id){
  $registrationIds = array( $token );
  $msg = array(
  	'message' 	=> $message,
  	'title'		=> $title,
  	'subtitle'	=> 'This is a subtitle. subtitle',
  	'tickerText'	=> 'Ticker text here...Ticker text here...Ticker text here',
  	'vibrate'	=> 1,
  	'sound'		=> 1,
  	'largeIcon'	=> 'large_icon',
  	'smallIcon'	=> 'small_icon',
    'urlto'	=> $CaseId,
    'msgNotiApp_id'	=> $msgNotiApp_id
  );
  $fields = array(
  	'registration_ids' 	=> $registrationIds,
  	'data'			=> $msg
  );

  $headers = array(
  	'Authorization: key=' . API_ACCESS_KEY,
  	'Content-Type: application/json'
  );
  $ch = curl_init();
  curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
  // curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
  curl_setopt( $ch,CURLOPT_POST, true );
  curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
  curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
  curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
  curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
  $result = curl_exec($ch );
  curl_close( $ch );

  return $result;
}
?>
