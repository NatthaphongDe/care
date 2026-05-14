<?php
class main{
  var $db;
  var $dbConn;

  public function __construct(){
    global $db,$conn;
    $this->db = $db;
    $this->dbConn = $conn;
  }

  //-- ฟังกชั่นแปลงค่าให้เป็นค่า่ปกติ--//
  public function data_filter($value) {
    $newVal = trim($value);
    $newVal = htmlspecialchars($newVal);
    $newVal = mysqli_real_escape_string($this->dbConn,$newVal);
    return $newVal;

  }

  //-- ฟังกชั่นตรวจสอบ วันที่--//
  function validateDate($date, $format = 'd/m/Y')
  {
      $d = DateTime::createFromFormat($format, $date);
      return $d && $d->format($format) == $date;
  }
  //-- ฟังกชั่นตรวจสอบ วันที่--//
  function validateFormat($text, $pattern)
  {
    if (preg_match($pattern, $text) == '0') {
       return false;
    }else{
       return true;
    }
  }


  //-- ฟังกชั่นหาวันหยุดระหว่างวันที่กำหนด--//
  public function getHoliday($st_date,$en_date,$type=""){
    $start = new DateTime($st_date);
    $end = new DateTime($en_date);
    $days = $start->diff($end, true)->days;
    $sundays = intval($days / 7) + ($start->format('N') + $days % 7 >= 7);
    $saturdays = intval($days / 6) + ($start->format('N') + $days % 6 >= 6);
    $holiday = (int)$sundays+(int)$saturdays+(int)$this->getHoliday_public(date('Y-m-d',strtotime($st_date)),date('Y-m-d',strtotime($en_date)));
    if($holiday>0){
      /*if($type!="full"){
        $holiday = $holiday-1;
      }*/
    }

    return $holiday;
  }

  //-- ฟังกชั่นหาจำนวนวันหยุดจากระบบ-//
  public function getHoliday_public($start, $end){
    $sql = "SELECT * FROM `PublicHoliday` WHERE `holiday_status` = '0' AND holiday_date_start<='$start' AND holiday_date_end>='$end' ";
    $query = $this->dbConn->query($sql);
    $num_holiday_public = $query->num_rows;
    if($num_holiday_public>0){
      while($result = $query->fetch_assoc()){

        $start = new DateTime($result['holiday_date_start']." 00:00:00");
        $end = new DateTime($result['holiday_date_end']." 00:00:00");
        $days = $start->diff($end, true)->days;
        $sundays = intval($days / 7) + ($start->format('N') + $days % 7 >= 7);
        $saturdays = intval($days / 6) + ($start->format('N') + $days % 6 >= 6);
        $num_holiday_public = $result["holiday_date_amount"]-($sundays+$saturdays);

      }
    }else{
      $num_holiday_public = 0;
    }
    return $num_holiday_public;
  }

  //-- ฟังกชั่นหาวันหยุดระหว่างวันที่กำหนด--//
  public function getDateTimeData($st_datetime,$end_datetime){
    $data = array();
    $startDate = date('Y-m-d H:i:s',strtotime($st_datetime));
    $endDate = date('Y-m-d H:i:s',strtotime($end_datetime));
    $getHoliday = $this->getHoliday($startDate,$endDate);
    $startDatetime = $st_datetime;
    $endDatetime = $end_datetime;
    if($getHoliday>0){
      $endDatetime_subholoday = date('Y-m-d H:i:s', strtotime('-'.$getHoliday.' day', strtotime($endDate)));
    }else{
      $endDatetime_subholoday = $end_datetime;
    }
    $seconds = strtotime($endDatetime_subholoday) - strtotime($startDatetime);
    $days    = floor($seconds / 86400);
    $hours   = floor(($seconds - ($days * 86400)) / 3600);
    $minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);

    $data["startDate"] = $startDate;
    $data["endDate"] = $endDate;
    $data["getHoliday"] = $getHoliday;
    $data["startDatetime"] = $startDatetime;
    $data["endDatetime"] = $endDatetime;
    $data["endDatetime_subholoday"] = $endDatetime_subholoday;

    $data["seconds"] = $seconds;
    $data["days"]    = $days;
    $data["hours"]   = $hours;
    $data["minutes"] = $minutes;
    return $data;

  }

  //-- ฟังกชั่นลบไฟล์และโฟลเดอร์ --//
  public function deleteDirectory($dirPath) {
  	if (is_dir($dirPath)) {
  		$objects = scandir($dirPath);
  		foreach ($objects as $object) {
  			if ($object != "." && $object !="..") {
  				if (filetype($dirPath . DIRECTORY_SEPARATOR . $object) == "dir") {
  					$this->deleteDirectory($dirPath . DIRECTORY_SEPARATOR . $object);
  				} else {
  					unlink($dirPath . DIRECTORY_SEPARATOR . $object);
  				}
  			}
  		}
  	reset($objects);
  	rmdir($dirPath);
  	}
  }

  public function setting_info() {
    $sql = "SELECT * FROM `Setting_Info` ";
    $query = $this->dbConn->query($sql);
    $this->setting_info = $query->fetch_assoc();
  }

  // --ฟังก์ชั่นแปลงรูปแบบวันที่--//
  public function genDate($date,$type) {
    $dateSplit = implode("-",array_reverse(explode("/",$date)));
    return $dateSplit;
  }


  public function filesize2bytes($str) {
      $bytes = 0;

      $bytes_array = array(
          'B' => 1,
          'KB' => 1024,
          'MB' => 1024 * 1024,
          'GB' => 1024 * 1024 * 1024,
          'TB' => 1024 * 1024 * 1024 * 1024,
          'PB' => 1024 * 1024 * 1024 * 1024 * 1024,
      );

      $bytes = floatval($str);

      if (preg_match('#([KMGTP]?B)$#si', $str, $matches) && !empty($bytes_array[$matches[1]])) {
          $bytes *= $bytes_array[$matches[1]];
      }

      $bytes = intval(round($bytes, 2));

      return $bytes;
  }

  public function getPositionImage($emp_img_path,$size){
    list($width, $height) = getimagesize($emp_img_path);
    $ratio = $width/$height; // width/height

    if( $ratio > 1) {
        $width = $size*$ratio;
        $height = $size;
        $css = " width:auto; height:100%; left:50%; margin-left:-".(($width*0.5)-($size*0.5))."px";
    }
    else {
    $width = $size;
    $height = $size/$ratio;
          $css = "height:auto; width:100%; top:0;";
    }
    return $css;
  }
}




?>
