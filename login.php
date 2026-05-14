<?php
session_start();

include('config/config.php');

$token = $_GET['token'];
$onetime = $_GET['onetime'];
// $token = '8bb5f343a3c7401600b068f077a476c3';
// $onetime = 'XTjK1trJ';

  $sql = "SELECT *  FROM `Member` WHERE `member_api_key` LIKE '".$token."' AND `member_onetime` LIKE '".$onetime."'";
  $query = $conn->query($sql);
if ($query->num_rows > 0) {
   $rl = $query->fetch_assoc();
   $_SESSION["member_id"] = $rl["member_id"];
   $_SESSION["member_type"] = $rl["member_type"];
   $_SESSION["lang"] = $rl["member_lang"];
   $_SESSION["chk_lang"] = 1;
   $_SESSION["member_login_type"] = $rl["member_facebook_type"];

   $sql1 = "UPDATE `Member` SET `member_onetime` = '' WHERE `Member`.`member_api_key` = '$token'";
   $result=mysqli_query($conn,$sql1);

   header('Location: frontend/index.php?page=invite');
}else{
  echo "กรุณาล็อคอินใหม่";
}


?>
