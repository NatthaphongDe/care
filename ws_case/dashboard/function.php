<?php

function getPositionImage($emp_img_path,$size){
  list($width, $height) = getimagesize($emp_img_path);
  $ratio = $width/$height; // width/height

  if( $ratio > 1) {
    $width = $size*$ratio;
    $height = $size;
    // $css = " width:auto; height:100%; margin-left:-".floor($width/2)."px";
    $css = " width:auto; height:100%; left:50%; margin-left:-".(($width*0.5)-($size*0.5))."px";
  }
  else {
    $width = $size;
    $height = $size/$ratio;
    $css = "height:auto; width:100%; top:0;";
  }
  return $css;
}

function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

//-- ฟังกชั่นหาวันหยุดระหว่างวันที่กำหนด--//
function getHoliday($st_date,$en_date,$type=""){
  $start = new DateTime($st_date);
  $end = new DateTime($en_date);
  $days = $start->diff($end, true)->days;
  $sundays = intval($days / 7) + ($start->format('N') + $days % 7 >= 7);
  $saturdays = intval($days / 6) + ($start->format('N') + $days % 6 >= 6);
  $holiday = (int)$sundays+(int)$saturdays+(int)getHoliday_public(date('Y-m-d',strtotime($st_date)),date('Y-m-d',strtotime($en_date)));
  if($holiday>0){
    /*if($type!="full"){
    $holiday = $holiday-1;
  }*/
}

return $holiday;
}

//-- ฟังกชั่นหาจำนวนวันหยุดจากระบบ-//
function getHoliday_public($start, $end){
  global $conn;
  $sql = "SELECT * FROM `PublicHoliday` WHERE `holiday_status` = '0' AND holiday_date_start<='$start' AND holiday_date_end>='$end' ";
  $query = $conn->query($sql);
  $num_holiday_= $query->num_rows;
  while($result = $query->fetch_assoc()){

    $start = new DateTime($result['holiday_date_start']." 00:00:00");
    $end = new DateTime($result['holiday_date_end']." 00:00:00");
    $days = $start->diff($end, true)->days;
    $sundays = intval($days / 7) + ($start->format('N') + $days % 7 >= 7);
    $saturdays = intval($days / 6) + ($start->format('N') + $days % 6 >= 6);
    $num_holiday_= (int)$result["holiday_date_amount"]-((int)$sundays+(int)$saturdays);

  }
  return $num_holiday_public;
}

function getDateTimeData($st_datetime,$end_datetime){
$data = array();
$startDate = date('Y-m-d',strtotime($st_datetime));
$endDate = date('Y-m-d',strtotime($end_datetime));
$getHoliday = getHoliday($startDate,$endDate);
$startDatetime = $st_datetime;
$endDatetime = $end_datetime;
if($getHoliday>0){
$endDatetime_subholoday = date('Y-m-d', strtotime('-'.$getHoliday.' day', strtotime($endDate)));
}else{
$endDatetime_subholoday = $end_datetime;
}
$seconds = strtotime($endDatetime_subholoday) - strtotime($startDatetime);
$days = floor($seconds / 86400);
$hours = floor(($seconds - ($days * 86400)) / 3600);
$minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);

$data["startDate"] = $startDate;
$data["endDate"] = $endDate;
$data["getHoliday"] = $getHoliday;
$data["startDatetime"] = $startDatetime;
$data["endDatetime"] = $endDatetime;
$data["endDatetime_subholoday"] = $endDatetime_subholoday;

$data["seconds"] = $seconds;
$data["days"] = $days;
$data["hours"] = $hours;
$data["minutes"] = $minutes;
return $data;

}
 ?>
