<?php

require_once 'vendor/autoload.php';

use \Firebase\JWT\JWT;

$publicKey = <<<EOD
-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCamxTyOYjiC2lzZ6MLxpYl+W4j
Qv/tXLDWz732B3dwK9qviAtRUNLD6KR5HdWsJ1q2DY2Tcf65LNGx9xZDONaApwV+
b/Q67Z4e/+FD8eIGi/K88yx4V1UAjFtx11KYdQd2REyt7g675tpbqOOvyjHHVKpP
a/9QKhYE801XFG33PwIDAQAB
-----END PUBLIC KEY-----
EOD;

$jwt = $post->token;
//trigger exception in a "try" block
try {
  $decoded = JWT::decode($jwt, $publicKey, array('RS256'));

  /*
   NOTE: This will now be an object instead of an associative array. To get
   an associative array, you will need to cast it as such:
  */

  $user_data = (array) $decoded;
}
//catch exception
catch(Exception $e) {
  if($decoded==""){
      $data_array = array('res_code'=>'01', 'message'=>'Token Failed !');
      echo json_encode($data_array);
      exit();
  }
}

//echo "Decode:\n" . print_r($decoded_array, true) . "\n";
?>
