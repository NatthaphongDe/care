<?php
class main{

  public function __construct(){
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
  public function getHoliday($st_date,$en_date){
    $start = new DateTime($st_date);
    $end = new DateTime($en_date);
    $days = $start->diff($end, true)->days;
    $sundays = intval($days / 7) + ($start->format('N') + $days % 7 >= 7);
    $saturdays = intval($days / 6) + ($start->format('N') + $days % 6 >= 6);
    $holiday = $sundays+$saturdays;
    return $holiday;
  }

  //-- ฟังกชั่นหาวันหยุดระหว่างวันที่กำหนด--//
  public function getDateTimeData($st_datetime,$end_datetime){
    $data = array();
    $startDate = date('Y-m-d',strtotime($st_datetime));
    $endDate = date('Y-m-d',strtotime($end_datetime));
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

  // --ฟังก์ชั่นแปลงรูปแบบวันที่--//
  public function genDate($date,$type) {
    $dateSplit = implode("-",array_reverse(explode("/",$date)));
    return $dateSplit;
  }

}

?>
