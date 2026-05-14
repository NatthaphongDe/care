<?php
session_start();
include('config/config.php');

function checklogin() {
	if (isset($_SESSION["member_id"])) {
		if(get_data_user($_SESSION["member_id"])==true){
			return true;
		}else{
			return false;
		}
	}
	else{
		return false;
	}
}
function get_data_user($member_id){
  include('config/config.php');
  $sql = "SELECT * FROM Member WHERE member_id = '$member_id'";
  $query = $conn->query($sql);
  if($query->num_rows > 0){
  $re = $query->fetch_assoc();

    $_SESSION["member_id"] = $re["member_id"];
    $_SESSION["member_type"] = $re["member_type"];
		$_SESSION["chk_lang"] = 1;
		$_SESSION["lang"] = $re["member_lang"];

    return true;
  }else {
    return false;
  }
}
?>
