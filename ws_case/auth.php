<?php
// required headers
header("Access-Control-Allow-Origin: *");
//header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include("../config/config_ws.php");
include("../backoffice/class/main.class.php");

$_class = new main();

require_once 'vendor/autoload.php';

use \Firebase\JWT\JWT;

//$key_pain = "ditp@ibusiness";
//$key = hash("SHA256",$key_pain);
$privateKey = <<<EOD
-----BEGIN RSA PRIVATE KEY-----
MIICXAIBAAKBgQCamxTyOYjiC2lzZ6MLxpYl+W4jQv/tXLDWz732B3dwK9qviAtR
UNLD6KR5HdWsJ1q2DY2Tcf65LNGx9xZDONaApwV+b/Q67Z4e/+FD8eIGi/K88yx4
V1UAjFtx11KYdQd2REyt7g675tpbqOOvyjHHVKpPa/9QKhYE801XFG33PwIDAQAB
AoGAaav6Ax2kG6xlJQX/ATt4wPfdeah/uMMT858GXbT4w+iVjkhUQ/4UMOdAE7B6
rTIw5CIbVF4kFnk10ofp5YRhx3Ns22aQ5bQNOGsXFV4fncVQR6uQKI+Ma1JCMvoS
6ArUZNDVFoEEwmGw2iIK9nDwiVc6xZhVSme1o2fg9XaKk9ECQQD1VumIwcGWesga
EPTmBKjnDh1oqAUSnhIfF/I/I7ePLz9opMj+mYh/eZA9F0tXL5zDlSxoHUzJq3Xg
45NMmsZlAkEAoVLfi4O9j61vbMh/2JJ84JSs6kqLbu6IqSYR/VoD2kNuQLLQVnVr
4JwypxSAi4U70OtGaGq/Tf2cuOP3vqKK0wJBAOjqLCfDGpBL3HCyrG06+0bwJYdY
DAjSvI18ZGUA+aEbz+z+lDrxc57hv8fft4z8DK25j0EAoAfNmcl5BDxzq+kCQEkK
JHweIW0zsQcnn/qGGFP1/HP3XDnVdbpfqjVy09u2O+y/COScNUN0dNqAxdJleDeW
zkHoUsUU1ig/zqNZJFECQBH6CfWlW3jgDoWi2/R+2gi/0CfwlvLn9D35+20i/C8r
WiJ2EIWqhxKOQ2LdhJgcwzQRtuYX3CK3jgIx6g1Ueeg=
-----END RSA PRIVATE KEY-----
EOD;


// get the HTTP method, path and body of the request
$post = json_decode(file_get_contents('php://input'),true);
$post = (object)$post;
// $post->username="ditppartner";
// $post->password="ditp@ibusiness";

$username = trim($post->username);
$password = $post->password;
$password_hash = hash("sha256",$password);


$username = trim($post->username);
$password = $post->password;
$password_hash = hash("sha256",$password);
$sql = "SELECT userws_id
FROM User_WebService
WHERE userws_username='$username'
AND userws_password='$password_hash'
AND userws_status_lock = 0";

$query = $_class->dbConn->query($sql);
$rows_uws = $query->num_rows;
if($rows_uws>0){
  $rs_uws = $query->fetch_assoc();


  $token = array(
      "urw" => $rs_uws["userws_id"],
      "lsg" => time(),
      "exp" => time()+3600,
  );

  /**
   * IMPORTANT:
   * You must specify supported algorithms for your application. See
   * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
   * for a list of spec-compliant algorithms.
   */
  //$jwt = JWT::encode($token, $privateKey);

  //trigger exception in a "try" block
  try {
    $jwt = JWT::encode($token, $privateKey, 'RS256');

    $sql_upd_token = "UPDATE User_WebService
                      SET token = '$jwt'
                      WHERE userws_id = '".$rs_uws["userws_id"]."' ";
    $query_upd_token = $_class->dbConn->query($sql_upd_token);
  }
  //catch exception
  catch(Exception $e) {
    if($decoded==""){
        $data_array = array('message'=>'Generate Token Failed !');
        echo json_encode($data_array);
        exit();
    }
  }
}else{
  $data_array = array('message'=>'Login Failed !');
  echo json_encode($data_array);
  exit();
}

echo $jwt;
exit();

?>
