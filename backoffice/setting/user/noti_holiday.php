<?php
include("../../../config/config.php");
require_once "../library/PHPMailer-5.2.5/class.phpmailer.php";
$day =  date('Y-12-31');
$day_current = date ("Y-m-d");
// echo "<br>";
$sql_count = "SELECT hd_setting FROM Setting_Info WHERE settingInfo_id = '1'  ";
$query_count = $conn->query($sql_count);
while ( $re_count =   $query_count->fetch_assoc()) {
$bl_php =  "-".$re_count['hd_setting'];

}
$strNewDate = date ("Y-m-d", strtotime("$bl_php month", strtotime($day)));



if($day_current >= $strNewDate  ){
    $sql_count = "SELECT holiday_year FROM PublicHoliday WHERE holiday_year = '".date('Y')."'  ";
    $query_count = $conn->query($sql_count);
    if($query_count->num_rows<1){




    }else {
      echo "ปีนี้มีแล้ว";
    }
}else{
  echo "ยังไม่ถึงเวลา";
}



?>
