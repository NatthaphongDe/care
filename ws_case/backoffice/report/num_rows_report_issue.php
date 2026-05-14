<?php

include("../../config/config.php");
switch ($_POST['method']) {
  case "report_issue":
    echo report_issue();
  break;
}
switch ($_GET['method']) {
  case "search_text_issue":
  $txt_search = $_GET['txt_search'];
    echo search_text_issue($txt_search);
  break;
}
//-- ฟังกชั่นหาวันหยุดระหว่างวันที่กำหนด--//
function getHoliday($st_date,$en_date){
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
    $num_holiday_= $result["holiday_date_amount"]-($sundays+$saturdays);

  }
  return $num_holiday_public;
}

  //-- ฟังกชั่นหาวันหยุดระหว่างวันที่กำหนด--//
function getDateTimeData($st_datetime,$end_datetime){
  $data = array();
  $startDate = date('Y-m-d H:i:s',strtotime($st_datetime));
  $endDate = date('Y-m-d H:i:s',strtotime($end_datetime));
  $getHoliday = getHoliday($startDate,$endDate);
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

function getDateDiff($st_datetime,$end_datetime){
  $data = array();
  $startDate = date('Y-m-d H:i:s',$st_datetime);
  $endDate = date('Y-m-d H:i:s',$end_datetime);
  $startDatetime = $startDate;
  $endDatetime = $endDate;

  $seconds = strtotime($endDatetime) - strtotime($startDatetime);
  $days    = floor($seconds / 86400);
  $hours   = floor(($seconds - ($days * 86400)) / 3600);
  $minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);

  $data["seconds"] = $seconds;
  $data["days"]    = $days;
  $data["hours"]   = $hours;
  $data["minutes"] = $minutes;
  return $data;

}

function report_issue(){

  global $conn;
   $text = $_POST['text'];
   $year_set_1 = $_POST['year_set_1'];
   $year_set_2 = $_POST['year_set_2'];
   $issue_year_th = $_POST['issue_year_th'];
   $issue_year_en = $_POST['issue_year_en'];
   $quarter = $_POST['quarter'];
   $month_issue_th = $_POST['month_issue_th'];
   $month_issue_en = $_POST['month_issue_en'];
   $date_start = $_POST['date_start'];
   $date_stop = $_POST['date_stop'];
   $compType_id = $_POST['compType_id'];
   $prodType_id = $_POST['prodType_id'];
   $caseCh_id = $_POST['caseCh_id'];
   $Country_applnt = $_POST['Country_applnt'];
   $Country_complnt = $_POST['Country_complnt'];
   $member_comp_type = $_POST['member_comp_type'];
   $member_comp_type_ditp = $_POST['member_comp_type_ditp'];
   $status_complaint = $_POST['status_complaint'];
   $respon = $_POST['respon'];
   $office_id = $_POST['office_id'];
   $reliable = $_POST['reliable'];

   if($year_set_1 =="1"){
     if($date_start == ""){
       if($month_issue_th == ""){
         if($quarter == ""){
           if($issue_year_th == ""){
             $where_date = "";
           }else {
             if($year_set_2 == "2"){
               $year = $issue_year_th;
               $year_start = ($year-1)."-10-01";
               $year_end = $year."-09-30";
               $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
             }else {
               $year = $issue_year_th;
               $year_start = $year."-01-01";
               $year_end = $year."-12-31";
               $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
             }
           }
         }else {
           $year = $issue_year_th;
           if($quarter == "1"){
             $year_start = $year."-01-01";
             $year_end = $year."-03-31";
             $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
           }elseif ($quarter == "2") {
             $year_start = $year."-04-01";
             $year_end = $year."-06-30";
             $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
           }elseif ($quarter == "3") {
             $year_start = $year."-07-01";
             $year_end = $year."-09-30";
             $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
           }else {
             $year_start = $year."-10-01";
             $year_end = $year."-12-31";
             $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
           }
         }
       }else {
         $year = $issue_year_th;
         $month = $month_issue_th;
         $year_start = $year."-".$month."-01";
         $year_end = $year."-".$month."-31";
         $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
       }
     }else {
       if($date_stop == ""){
         $year = $issue_year_th;
         $month = $month_issue_th;
         $date_start = $date_start;

         $date_time = $date_start;
         $date_time_ex = explode(" ",$date_time);
         $date_re = $date_time_ex[0];
         $date_ex = explode("/",$date_re);
         $date_rx_year = $date_ex[2]-543;
         $date_start_ex= $date_rx_year."-".$date_ex[1]."-".$date_ex[0];

         $year_start = $date_start_ex;
         $where_date = " AND (c.case_create_datetime >= '".$year_start."')";
       }else {
         $year = $issue_year_th;
         $month = $month_issue_th;
         $date_start = $date_start;
         $date_stop = $date_stop;

         $date_time = $date_start;
         $date_time_ex = explode(" ",$date_time);
         $date_re = $date_time_ex[0];
         $date_ex = explode("/",$date_re);
         $date_rx_year = $date_ex[2]-543;
         $date_start_ex= $date_rx_year."-".$date_ex[1]."-".$date_ex[0];

         $date_time_rx = $date_stop;
         $date_time_rx = explode(" ",$date_time_rx);
         $date_rx = $date_time_rx[0];
         $date_rx = explode("/",$date_rx);
         $date_ex_year = $date_rx[2]-543;
         $date_stop_rx= $date_ex_year."-".$date_rx[1]."-".$date_rx[0];

         $year_start = $date_start_ex;
         $year_end = $date_stop_rx;
         $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
       }
     }

   }else {
     if($date_start == ""){
       if($month_issue_en == ""){
         if($quarter == ""){
           if($issue_year_en == ""){
             $where_date = "";
           }else {
             if($year_set_2 == "2"){
               $year = $issue_year_en;
               $year_start = ($year-1)."-10-01";
               $year_end = $year."-09-30";
               $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
             }else {
               $year = $issue_year_en;
               $year_start = $year."-01-01";
               $year_end = $year."-12-31";
               $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
             }
           }
         }else {
           $year = $issue_year_en;
           if($quarter == "1"){
             $year_start = $year."-01-01";
             $year_end = $year."-03-31";
             $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
           }elseif ($quarter == "2") {
             $year_start = $year."-04-01";
             $year_end = $year."-06-30";
             $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
           }elseif ($quarter == "3") {
             $year_start = $year."-07-01";
             $year_end = $year."-09-30";
             $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
           }else {
             $year_start = $year."-10-01";
             $year_end = $year."-12-31";
             $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
           }
         }
       }else {
         $year = $issue_year_en;
         $month = $month_issue_en;
         $year_start = $year."-".$month."-01";
         $year_end = $year."-".$month."-31";
         $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
       }
     }else {
       if($date_stop == ""){
         $year = $issue_year_en;
         $month = $month_issue_en;
         $date_start = $date_start;

         $date_time = $date_start;
         $date_time_ex = explode(" ",$date_time);
         $date_re = $date_time_ex[0];
         $date_ex = explode("/",$date_re);
         $date_start_ex= $date_ex[2]."-".$date_ex[1]."-".$date_ex[0];

         $year_start = $date_start_ex;
         $where_date = " AND (c.case_create_datetime >= '".$year_start."')";
       }else {
         $year = $issue_year_en;
         $month = $month_issue_en;
         $date_start = $date_start;
         $date_stop = $date_stop;

         $date_time = $date_start;
         $date_time_ex = explode(" ",$date_time);
         $date_re = $date_time_ex[0];
         $date_ex = explode("/",$date_re);
         $date_start_ex= $date_ex[2]."-".$date_ex[1]."-".$date_ex[0];

         $date_time_rx = $date_stop;
         $date_time_rx = explode(" ",$date_time_rx);
         $date_rx = $date_time_rx[0];
         $date_rx = explode("/",$date_rx);
         $date_stop_rx= $date_rx[2]."-".$date_rx[1]."-".$date_rx[0];

         $year_start = $date_start_ex;
         $year_end = $date_stop_rx;
         $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
       }
     }
   }


  if($compType_id == ""){
    $where_comp = "";
  }else {
    $where_comp = " AND c.compType_id = $compType_id";
  }

  if($_SESSION['admin']['empSection'] == "1"){
    if($prodType_id == ""){
      $where_prod = "";
    }else {
      $where_prod = " AND (c.prodType_id = $prodType_id OR pt.prodType_ref_id = $prodType_id)";
    }
  }else {
    if($prodType_id == ""){
      $where_prod = "";
    }else {
      $where_prod = " AND c.incType_id = $prodType_id";
    }
  }

  if($caseCh_id == ""){
    $where_caseCh = "";
  }else {
    $where_caseCh = " AND (c.caseCh_id = $caseCh_id OR ch.caseCh_ref_id = $caseCh_id)";
  }

  if($office_id == ""){
    $where_office = "";
  }else {
    $where_office = " AND c.office_id = $office_id";
  }

  if($Country_applnt == ""){
    $whereCountry_applnt = "";
  }else {
    $whereCountry_applnt = " AND c.applnt_country_id = $Country_applnt";
  }

  if($Country_complnt == ""){
    $whereCountry_complnt = "";
  }else {
    $whereCountry_complnt = " AND c.complnt_country_id = $Country_complnt";
  }

  if($member_comp_type == ""){
    $wheremembe = "";
  }else {
    $wheremembe = " AND c.applnt_valid_ditp = $member_comp_type";
  }
  if ($member_comp_type_ditp == "") {
    $wheremembeditp = "";
  } else {
    $wheremembeditp = " AND c.complnt_valid_ditp = $member_comp_type_ditp";
    /* if ($member_comp_type_ditp== 1) {
      $wheremembeditp = " AND (complnt_valid_ditp IN (1, 2) AND complnt_valid_ditp_org != '')";
    } else if ($member_comp_type_ditp== 2) {
      $wheremembeditp = " AND c.complnt_valid_ditp = $member_comp_type_ditp AND c.complnt_valid_ditp_org == '' ";
    } else {
      $wheremembeditp = " AND c.complnt_valid_ditp = $member_comp_type_ditp";
    } */
  }
  
  if($reliable == ""){
    $where_reliable = "";
  } else {
    $where_reliable = " AND reliable = $reliable";
  }

  if($text == ""){
    $whereSearch = "";
  }else {
    $whereSearch = " AND (c.caseDtl_title LIKE '%".$text."%' OR ch.caseCh_name LIKE '%".$text."%' OR ct.compType_name LIKE '%".$text."%' OR pt.prodType_name LIKE '%".$text."%')";
  }


  $sqlomplaint = "  SELECT  case_id ,case_opened_datetime ,case_close_datetime,case_compType_duration FROM `Case`  WHERE   `case_status` = 3 ";
  $queryomplaint = $conn->query($sqlomplaint);
  $allS = array();
  while($results = $queryomplaint->fetch_assoc()){
    $all_work = getDateTimeData($results["case_opened_datetime"],date("Y-m-d 00:00:00",strtotime($results["case_close_datetime"])));
    if($all_work['days']>$results['case_compType_duration']){
      $results['days']  = $all_work['days'];
      array_push($allS,$results['case_id']);
    }
  }


  if($status_complaint == ""){
    $whereStatus = "";
  }else {
    if($status_complaint == "0"){
        $whereStatus = " AND c.case_status = $status_complaint";
    }elseif ($status_complaint == "1") {
        $whereStatus = " AND c.case_status = $status_complaint";
    }elseif ($status_complaint == "2") {
        $whereStatus = " AND c.case_status = $status_complaint";
    }elseif ($status_complaint == "3") {
        $whereStatus = " AND c.case_status = $status_complaint";
    }elseif ($status_complaint == "4") {
      $whereStatus = " AND c.case_status IN (2,3)";

    }elseif ($status_complaint == "5") {

      $byid =  implode(',',$allS);
      if(count($byid)==0){
        $whereStatus = " AND c.case_status = 3  AND  c.case_id in (0) ";
      }else{
        $whereStatus = " AND c.case_status = 3  AND  c.case_id in ($byid) ";
      }
    }




  }
  if($respon == ""){
    $sql = "SELECT
    c.case_id,
    c.case_create_datetime,
    c.case_receivedoc_date,
    c.caseDtl_title,
    c.case_status,
    c.reliable,
    c.compType_id,
    c.compTypeSub1_id,
    c.compTypeSub2_id,
    ct.compType_name,
    c.case_compType_duration,
    ct1.compTypeSub1_name,
    ct2.compTypeSub2_name,
    c.prodType_id,
    pt.prodType_name,
    c.applnt_firstname,
    c.applnt_lastname,
    c.complnt_name,
    c.case_close_datetime,
    c.caseCh_id,
    c.case_id,
    c.applnt_country_id,
    c.complnt_country_id,
    ch.caseCh_name,
    c.case_opened_datetime,
    c.case_close_resultProcess,
    c.applnt_valid_ditp,
    c.complnt_valid_ditp,
    c.complnt_valid_ditp_org,
    c.caseClose_id,
    c.incType_id,
    it.incType_name,
    ch.caseCh_section,
    c.case_lastSave_datetime
    FROM `Case` AS c
    LEFT JOIN `Complaint_Type` AS ct ON c.compType_id = ct.compType_id
    LEFT JOIN `Complaint_Type_Sub1` AS ct1 ON c.compTypeSub1_id = ct1.compTypeSub1_id
    LEFT JOIN `Complaint_Type_Sub2` AS ct2 ON c.compTypeSub2_id = ct2.compTypeSub2_id
    LEFT JOIN `Product_Type` AS pt ON c.prodType_id = pt.prodType_id
    LEFT JOIN `Case_Channel` AS ch ON c.caseCh_id = ch.caseCh_id
    LEFT JOIN `Incorrect_Type` AS it ON c.incType_id = it.incType_id";
    $sql .= " WHERE 1 AND ct.compType_section = '".$_SESSION['admin']['empSection']."' $where_caseCh $whereSearch $where_date $where_comp $where_prod $where_caseCh
    $whereCountry_applnt $whereCountry_complnt $whereStatus $wheremembe $wheremembeditp $where_office $where_reliable ";
  }else {
    $whererespon = " AND a.emp_id = $respon";
    $sql = "SELECT
    c.case_create_datetime,
    c.case_receivedoc_date,
    c.caseDtl_title,
    c.case_status,
    c.reliable,
    c.compType_id,
    c.case_compType_duration,
    c.compTypeSub1_id,
    c.compTypeSub2_id,
    ct.compType_name,
    ct1.compTypeSub1_name,
    ct2.compTypeSub2_name,
    c.prodType_id,
    pt.prodType_name,
    c.applnt_firstname,
    c.applnt_lastname,
    c.complnt_name,
    c.case_close_datetime,
    c.caseCh_id,
    c.case_id,
    c.applnt_country_id,
    c.complnt_country_id,
    ch.caseCh_name,
    c.case_opened_datetime,
    c.case_close_resultProcess,
    a.emp_id,
    c.applnt_valid_ditp,
    c.complnt_valid_ditp,
    c.complnt_valid_ditp_org,
    c.caseClose_id,
    c.incType_id,
    it.incType_name,
    ch.caseCh_section,
    c.case_lastSave_datetime
    FROM `Case` AS c
    LEFT JOIN `Complaint_Type` AS ct ON c.compType_id = ct.compType_id
    LEFT JOIN `Complaint_Type_Sub1` AS ct1 ON c.compTypeSub1_id = ct1.compTypeSub1_id
    LEFT JOIN `Complaint_Type_Sub2` AS ct2 ON c.compTypeSub2_id = ct2.compTypeSub2_id
    LEFT JOIN `Product_Type` AS pt ON c.prodType_id = pt.prodType_id
    LEFT JOIN `Case_Channel` AS ch ON c.caseCh_id = ch.caseCh_id
    LEFT JOIN `Case_Assign` AS a ON c.case_id = a.case_id
    LEFT JOIN `Incorrect_Type` AS it ON c.incType_id = it.incType_id";
    $sql .= " WHERE 1 AND ct.compType_section = '".$_SESSION['admin']['empSection']."' AND a.caseAsign_status = 0 $where_caseCh $whereSearch $where_date $where_comp
    $where_prod $where_caseCh $whereCountry_applnt $whereCountry_complnt $whereStatus $whererespon $wheremembe $wheremembeditp $where_office $where_reliable ";
  }
  
  $query = $conn->query($sql);

  $over_list = array();
  while ($li = $query->fetch_assoc()) {

    if($li['case_close_datetime'] == "" || $li['case_close_datetime'] == NULL){
      $case_close_datetime = date('Y-m-d 00:00:00',time());
    }else {
      $case_close_datetime = date("Y-m-d 00:00:00",strtotime($li['case_close_datetime']));
    }
    $chk_time_close = getDateTimeData(date("Y-m-d 00:00:00",strtotime($li['case_opened_datetime'])),$case_close_datetime);
    if($chk_time_close['days'] > $li['case_compType_duration']){
      $status = "Overdue Main process";
      array_push($over_list,$li['case_id']);

    }else {
      $sql_process = "SELECT
      p.process_id,
      p.process_type_id,
      p.case_id,
      p.process_type_duration,
      p.process_save_datetime,
      p.process_complete_datetime,
      p.process_status,
      p.process_over_datetime,
      pt.process_type_name
      FROM `Process` AS p
      LEFT JOIN `Process_Type` AS pt ON p.process_type_id = pt.process_type_id
      WHERE p.case_id = '".$li['case_id']."'";

      $query_process = $conn->query($sql_process);


      while ($res = $query_process->fetch_assoc()) {

        $time_over_x = $res["process_over_datetime"];
        if($res["process_status"]=="1"){
          $time_compare_x = strtotime($res["process_complete_datetime"]);
        }else{
          $time_compare_x = time();
        }

        if($time_compare_x > $time_over_x){
          array_push($over_list,$res['case_id']);
        }
      }
    }
  }

  if($status_complaint == "0" || $status_complaint == "1" || $status_complaint == ""){
    $whereincase = "";
  }elseif ($status_complaint == "2" || $status_complaint == "3") {
    if(join(',',$over_list) == ""){
      $incase = "''";
    }else {
      $incase = join(',',$over_list);
    }
    $whereincase = " AND c.case_id NOT IN (".$incase.")";
  }elseif ($status_complaint == "4") {
    if(join(',',$over_list) == ""){
      $incase = "''";
    }else {
      $incase = join(',',$over_list);
    }
    $whereincase = " AND c.case_id IN (".$incase.")";
  }


  $output = "";
  if($respon == ""){
    $sql_caseCh = "SELECT
    c.case_create_datetime,
    c.case_receivedoc_date,
    c.caseDtl_title,
    c.case_status,
    c.reliable,
    c.compType_id,
    c.compTypeSub1_id,
    c.compTypeSub2_id,
    ct.compType_name,
    c.case_compType_duration,
    ct1.compTypeSub1_name,
    ct2.compTypeSub2_name,
    c.prodType_id,
    pt.prodType_name,
    c.applnt_firstname,
    c.applnt_lastname,
    c.complnt_name,
    c.case_close_datetime,
    c.caseCh_id,
    c.case_id,
    c.applnt_country_id,
    c.complnt_country_id,
    ch.caseCh_name,
    c.case_opened_datetime,
    c.case_close_resultProcess,
    c.applnt_valid_ditp,
    c.complnt_valid_ditp,
    c.complnt_valid_ditp_org,
    c.caseClose_id,
    c.incType_id,
    it.incType_name,
    ch.caseCh_section,
    c.case_lastSave_datetime
    FROM `Case` AS c
    LEFT JOIN `Complaint_Type` AS ct ON c.compType_id = ct.compType_id
    LEFT JOIN `Complaint_Type_Sub1` AS ct1 ON c.compTypeSub1_id = ct1.compTypeSub1_id
    LEFT JOIN `Complaint_Type_Sub2` AS ct2 ON c.compTypeSub2_id = ct2.compTypeSub2_id
    LEFT JOIN `Product_Type` AS pt ON c.prodType_id = pt.prodType_id
    LEFT JOIN `Case_Channel` AS ch ON c.caseCh_id = ch.caseCh_id
    LEFT JOIN `Incorrect_Type` AS it ON c.incType_id = it.incType_id";
    $sql_caseCh .= " WHERE 1 AND ct.compType_section = '".$_SESSION['admin']['empSection']."' $where_caseCh $whereincase $whereSearch $where_date $where_comp $where_prod
    $where_caseCh $whereCountry_applnt $whereCountry_complnt $whereStatus $wheremembe $wheremembeditp $where_office $where_reliable ";
  }else {
    $whererespon = " AND a.emp_id = $respon";
    $sql_caseCh = "SELECT
    c.case_create_datetime,
    c.case_receivedoc_date,
    c.caseDtl_title,
    c.case_status,
    c.reliable,
    c.compType_id,
    c.case_compType_duration,
    c.compTypeSub1_id,
    c.compTypeSub2_id,
    ct.compType_name,
    ct1.compTypeSub1_name,
    ct2.compTypeSub2_name,
    c.prodType_id,
    pt.prodType_name,
    c.applnt_firstname,
    c.applnt_lastname,
    c.complnt_name,
    c.case_close_datetime,
    c.caseCh_id,
    c.case_id,
    c.applnt_country_id,
    c.complnt_country_id,
    ch.caseCh_name,
    c.case_opened_datetime,
    c.case_close_resultProcess,
    a.emp_id,
    c.applnt_valid_ditp,
    c.complnt_valid_ditp,
    c.complnt_valid_ditp_org,
    c.caseClose_id,
    c.incType_id,
    it.incType_name,
    ch.caseCh_section,
    c.case_lastSave_datetime
    FROM `Case` AS c
    LEFT JOIN `Complaint_Type` AS ct ON c.compType_id = ct.compType_id
    LEFT JOIN `Complaint_Type_Sub1` AS ct1 ON c.compTypeSub1_id = ct1.compTypeSub1_id
    LEFT JOIN `Complaint_Type_Sub2` AS ct2 ON c.compTypeSub2_id = ct2.compTypeSub2_id
    LEFT JOIN `Product_Type` AS pt ON c.prodType_id = pt.prodType_id
    LEFT JOIN `Case_Channel` AS ch ON c.caseCh_id = ch.caseCh_id
    LEFT JOIN `Case_Assign` AS a ON c.case_id = a.case_id
    LEFT JOIN `Incorrect_Type` AS it ON c.incType_id = it.incType_id";
    $sql_caseCh .= " WHERE 1 AND ct.compType_section = '".$_SESSION['admin']['empSection']."' AND a.caseAsign_status = 0 $where_caseCh $whereincase $whereSearch
    $where_date $where_comp $where_prod $where_caseCh $whereCountry_applnt $whereCountry_complnt $whereStatus $whererespon $wheremembe $wheremembeditp $where_office $where_reliable ";
  }
  $query_case = $conn->query($sql_caseCh);
  $num = $query_case->num_rows;
  $query_edit_pass = $conn->query($sql_caseCh);
  $co_id = 0 ;
  $i_padding = 0;
  $waiting = 0;
  $new = 0;
  $pending = 0;
  $overduemain = 0;
  $overduesub = 0;
  $closesuccess = 0;
  $closecontinue = 0;
  $closereject = 0;
  $close = 0;
  $Closeoverdue = 0;

  $num_row = 0;
  while ($re = $query_edit_pass->fetch_assoc()) {

   if($status_complaint == "2"){

     $sql_process = "SELECT
     p.process_id,
     p.process_type_id,
     p.case_id,
     p.process_type_duration,
     p.process_save_datetime,
     p.process_complete_datetime,
     p.process_status,
     p.process_over_datetime,
     pt.process_type_name
     FROM `Process` AS p
     LEFT JOIN `Process_Type` AS pt ON p.process_type_id = pt.process_type_id
     WHERE p.case_id = '".$re['case_id']."'";

     $query_process = $conn->query($sql_process);


     while ($res = $query_process->fetch_assoc()) {

       $time_over_x = $res["process_over_datetime"];
       if($res["process_status"]=="1"){
         $time_compare_x = strtotime($res["process_complete_datetime"]);
       }else{
         $time_compare_x = time();
       }

       if($time_compare_x > $time_over_x){
         $i_padding++;
       }else{
         $i_padding = 0;
       }

     }

   }elseif ($status_complaint == "3") {
     $sql_process = "SELECT
     p.process_id,
     p.process_type_id,
     p.case_id,
     p.process_type_duration,
     p.process_save_datetime,
     p.process_complete_datetime,
     p.process_status,
     p.process_over_datetime,
     pt.process_type_name
     FROM `Process` AS p
     LEFT JOIN `Process_Type` AS pt ON p.process_type_id = pt.process_type_id
     WHERE p.case_id = '".$re['case_id']."'";

     $query_process = $conn->query($sql_process);


     while ($res = $query_process->fetch_assoc()) {

       $time_over_x = $res["process_over_datetime"];
       if($res["process_status"]==1){
         $time_compare_x = strtotime($res["process_complete_datetime"]);
       }else{
         $time_compare_x = time();
       }

       if($time_compare_x > $time_over_x){
         $i_padding++;
       }else{

         $i_padding = 0;
       }

     }

   }elseif ($status_complaint == "4") {

     if($re['case_close_datetime'] == "" || $re['case_close_datetime'] == NULL){
       $case_close_datetime = date('Y-m-d 00:00:00',time());
     }else {
       $case_close_datetime = date("Y-m-d 00:00:00",strtotime($re['case_close_datetime']));
     }
     $chk_time_close = getDateTimeData(date("Y-m-d 00:00:00",strtotime($re['case_opened_datetime'])),$case_close_datetime);
     if($chk_time_close['days'] > $re['case_compType_duration']){
       $status = "Overdue Main process";
       $i_padding = 0;

     }else {
       $sql_process = "SELECT
       p.process_id,
       p.process_type_id,
       p.case_id,
       p.process_type_duration,
       p.process_save_datetime,
       p.process_complete_datetime,
       p.process_status,
       p.process_over_datetime,
       pt.process_type_name
       FROM `Process` AS p
       LEFT JOIN `Process_Type` AS pt ON p.process_type_id = pt.process_type_id
       WHERE p.case_id = '".$re['case_id']."'";

       $query_process = $conn->query($sql_process);


       while ($res = $query_process->fetch_assoc()) {

         $time_over_x = $res["process_over_datetime"];
         if($res["process_status"]=="1"){
           $time_compare_x = strtotime($res["process_complete_datetime"]);
         }else{
           $time_compare_x = time();
         }

         if($time_compare_x > $time_over_x){
           $i_padding = 0;
         }
       }
     }

   }else {

     if($re['case_status'] == 3){
       $end_date_close = $re['case_close_datetime'];
       $start_date_close = $re['case_opened_datetime'];
     }else if($re['case_status'] == 2){
       $end_date_close = date("Y-m-d H:i:s");
       $start_date_close = $re['case_opened_datetime'];
     }else {
       $end_date_close = date("Y-m-d H:i:s");
       $start_date_close = date("Y-m-d H:i:s");
     }

     $set_time = getDateTimeData($start_date_close,$end_date_close);

     $day_subholiday = (int)getHoliday(date('Y-m-d', strtotime($start_date_close)),$end_date_close);
      if($day_subholiday>0){
       $case_processInit_idx = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime('+'.$day_subholiday.' day', strtotime($start_date_close))))->format('Y/m/d H:i:s');
      }else{
       $case_processInit_idx = DateTime::createFromFormat('Y-m-d H:i:s', $start_date_close)->format('Y/m/d H:i:s');
      }


      $num_process = 0;
      $txt_over = "";
      $txt_timeover = "";

     if($re['case_status'] == "0"){
       $status = "Waiting";
       $waiting++;
     }elseif ($re['case_status'] == "1") {
       $status = "New";
       $new++;
     }elseif ($re['case_status'] == "2") {

       if($re['case_close_datetime'] == "" || $re['case_close_datetime'] == NULL){
         $case_close_datetime = date('Y-m-d 00:00:00',time());
       }else {
         $case_close_datetime = date("Y-m-d 00:00:00",strtotime($re['case_close_datetime']));
       }
       $chk_time_close = getDateTimeData(date("Y-m-d 00:00:00",strtotime($re['case_opened_datetime'])),$case_close_datetime);

       if($chk_time_close['days'] > $re['case_compType_duration']){
         $status = "Overdue Main process";
         if(in_array($re['case_id'],$allS)){
           $Closeoverdue++;
         }else{
           $overduemain++;
         }
       }else {

         $sql_process = "SELECT
         p.process_id,
         p.process_type_id,
         p.case_id,
         p.process_type_duration,
         p.process_save_datetime,
         p.process_complete_datetime,
         p.process_status,
         p.process_over_datetime,
         pt.process_type_name
         FROM `Process` AS p
         LEFT JOIN `Process_Type` AS pt ON p.process_type_id = pt.process_type_id
         WHERE p.case_id = '".$re['case_id']."'";

         $query_process = $conn->query($sql_process);
         $i = 0;
         while ($rx = $query_process->fetch_assoc()) {

           $time_over = $rx["process_over_datetime"];
           if($rx["process_status"]==1){
             $time_compare = strtotime($rx["process_complete_datetime"]);
           }else{
             $time_compare = time();
           }

           if($time_compare>$time_over){
              $over_time = getDateDiff($time_over,$time_compare);
             $i++;
           }else{
             $i = 0;
           }
           $num_process++;
         }

         if($i == "0"){
           $status = "Pending";
           $pending++;
         }else {
           $status = "Overdue Sub process";
           $overduesub++;
         }


       }

     }elseif ($re['case_status'] == "3") {
       if($re['case_close_datetime'] == "" || $re['case_close_datetime'] == NULL){
         $case_close_datetime = date('Y-m-d 00:00:00',time());
       }else {
         $case_close_datetime = date("Y-m-d 00:00:00",strtotime($re['case_close_datetime']));
       }
       $chk_time_close = getDateTimeData(date("Y-m-d 00:00:00",strtotime($re['case_opened_datetime'])),$case_close_datetime);

       if($chk_time_close['days'] > $re['case_compType_duration']){
         $status = "Overdue Main process";
         if(in_array($re['case_id'],$allS)){
           $Closeoverdue++;
         }else{
           $overduemain++;
         }
       }else {

         $sql_process = "SELECT
         p.process_id,
         p.process_type_id,
         p.case_id,
         p.process_type_duration,
         p.process_save_datetime,
         p.process_complete_datetime,
         p.process_status,
         p.process_over_datetime,
         pt.process_type_name
         FROM `Process` AS p
         LEFT JOIN `Process_Type` AS pt ON p.process_type_id = pt.process_type_id
         WHERE p.case_id = '".$re['case_id']."'";

         $query_process = $conn->query($sql_process);
         $i = 0;

         while ($rx = $query_process->fetch_assoc()) {

           $time_over = $rx["process_over_datetime"];
           if($rx["process_status"]==1){
             $time_compare = strtotime($rx["process_complete_datetime"]);
           }else{
             $time_compare = time();
           }

           if($time_compare>$time_over){
            $over_time = getDateDiff($time_over,$time_compare);
             $i++;
           }else{
               $i = 0;
           }
           $num_process++;
         }

         if($i == "0"){

           if($_SESSION['admin']['empSection'] == "1"){
             if($re['caseClose_id'] == "1"){
               $status = "Close ตกลงกันได้";
               $closesuccess++;
             }elseif ($re['caseClose_id'] == "2") {
               $status = "Close ผู้ร้องดำเนินการต่อ";
               $closecontinue++;
             }elseif ($re['caseClose_id'] == "3") {
               $status = "Close ไม่สามารถดำเนินการได้ ";
               $closereject++;
             }elseif ($re['caseClose_id'] == "11") {
               $status = "Close";
               $close++;
             }
           }else {
             if($re['caseClose_id'] == "4"){
               $status = "Close";
               $close++;
             }elseif ($re['caseClose_id'] == "5") {
               $status = "Close";
               $close++;
             }elseif ($re['caseClose_id'] == "6") {
               $status = "Close";
               $close++;
             }elseif ($re['caseClose_id'] == "7") {
               $status = "Close";
               $close++;
             }elseif ($re['caseClose_id'] == "8") {
               $status = "Close";
               $close++;
             }elseif ($re['caseClose_id'] == "9") {
               $status = "Close";
               $close++;
             }elseif ($re['caseClose_id'] == "10") {
               $status = "Close";
               $close++;
             }
           }

         }else {
           $status = "Overdue Sub process";
           $overduesub++;
         }


       }
     }
     $num_row++;
   }
   $num = $num_row;
   if($status_complaint == "2" || $status_complaint == "3" || $status_complaint == "4"){
            if($i_padding == "0"){

              if($re['case_status'] == 3){
                $end_date_close = $re['case_close_datetime'];
                $start_date_close = $re['case_opened_datetime'];
              }else if($re['case_status'] == 2){
                $end_date_close = date("Y-m-d H:i:s");
                $start_date_close = $re['case_opened_datetime'];
              }else {
                $end_date_close = date("Y-m-d H:i:s");
                $start_date_close = date("Y-m-d H:i:s");
              }

              $set_time = getDateTimeData($start_date_close,$end_date_close);

              $day_subholiday = (int)getHoliday(date('Y-m-d', strtotime($start_date_close)),$end_date_close);
               if($day_subholiday>0){
                $case_processInit_idx = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime('+'.$day_subholiday.' day', strtotime($start_date_close))))->format('Y/m/d H:i:s');
               }else{
                $case_processInit_idx = DateTime::createFromFormat('Y-m-d H:i:s', $start_date_close)->format('Y/m/d H:i:s');
               }

              $co_id++ ;
              $num_page = $offset;
              $page = $co_id + $num_page;


               $num_process = 0;
               $txt_over = "";
               $txt_timeover = "";

              if($re['case_status'] == "0"){
                $status = "Waiting";
                $waiting++;
                $num_row++;
              }elseif ($re['case_status'] == "1") {
                $status = "New";
                $new++;
                $num_row++;
              }elseif ($re['case_status'] == "2") {
                if($re['case_close_datetime'] == "" || $re['case_close_datetime'] == NULL){
                  $case_close_datetime = date('Y-m-d 00:00:00',time());
                }else {
                  $case_close_datetime = date("Y-m-d 00:00:00",strtotime($re['case_close_datetime']));
                }
                $chk_time_close = getDateTimeData(date("Y-m-d 00:00:00",strtotime($re['case_opened_datetime'])),$case_close_datetime);

                if($chk_time_close['days'] > $re['case_compType_duration']){
                  $status = "Overdue Main process";
                  if(in_array($re['case_id'],$allS)){
                    $Closeoverdue++;
                  }else{
                    $overduemain++;
                  }
                  $num_row++;
                }else {

                  $sql_process = "SELECT
                  p.process_id,
                  p.process_type_id,
                  p.case_id,
                  p.process_type_duration,
                  p.process_save_datetime,
                  p.process_complete_datetime,
                  p.process_status,
                  p.process_over_datetime,
                  pt.process_type_name
                  FROM `Process` AS p
                  LEFT JOIN `Process_Type` AS pt ON p.process_type_id = pt.process_type_id
                  WHERE p.case_id = '".$re['case_id']."'";

                  $query_process = $conn->query($sql_process);
                  $i = 0;
                  while ($rx = $query_process->fetch_assoc()) {

                    $time_over = $rx["process_over_datetime"];
                    if($rx["process_status"]==1){
                      $time_compare = strtotime($rx["process_complete_datetime"]);
                    }else{
                      $time_compare = time();
                    }

                    if($time_compare>$time_over){
                      $over_time = getDateDiff($time_over,$time_compare);
                      $i++;
                    }else{
                      $i = 0;
                    }
                    $num_process++;
                  }

                  if($i == "0"){
                    $status = "Pending";
                    $num_row++;
                    $pending++;
                  }else {
                    $status = "Overdue Sub process";
                    $overduesub++;
                    $num_row++;
                  }


                }

              }elseif ($re['case_status'] == "3") {

                if($re['case_close_datetime'] == "" || $re['case_close_datetime'] == NULL){
                  $case_close_datetime = date('Y-m-d 00:00:00',time());
                }else {
                  $case_close_datetime = date("Y-m-d 00:00:00",strtotime($re['case_close_datetime']));
                }
                $chk_time_close = getDateTimeData(date("Y-m-d 00:00:00",strtotime($re['case_opened_datetime'])),$case_close_datetime);

                if($chk_time_close['days'] > $re['case_compType_duration']){
                  $status = "Overdue Main process";
                  if(in_array($re['case_id'],$allS)){
                    $Closeoverdue++;
                  }else{
                    $overduemain++;
                  }
                  $num_row++;
                }else {

                  $sql_process = "SELECT
                  p.process_id,
                  p.process_type_id,
                  p.case_id,
                  p.process_type_duration,
                  p.process_save_datetime,
                  p.process_complete_datetime,
                  p.process_status,
                  p.process_over_datetime,
                  pt.process_type_name
                  FROM `Process` AS p
                  LEFT JOIN `Process_Type` AS pt ON p.process_type_id = pt.process_type_id
                  WHERE p.case_id = '".$re['case_id']."'";

                  $query_process = $conn->query($sql_process);
                  $i = 0;

                  while ($rx = $query_process->fetch_assoc()) {

                    $time_over = $rx["process_over_datetime"];
                    if($rx["process_status"]==1){
                      $time_compare = strtotime($rx["process_complete_datetime"]);
                    }else{
                      $time_compare = time();
                    }

                    if($time_compare>$time_over){
                      $over_time = getDateDiff($time_over,$time_compare);
                      $i++;
                    }else{
                        $i = 0;
                    }
                    $num_process++;
                  }

                  if($i == "0"){
                    if($_SESSION['admin']['empSection'] == "1"){
                      if($re['caseClose_id'] == "1"){
                        $status = "Close ตกลงกันได้";
                        $closesuccess++;
                      }elseif ($re['caseClose_id'] == "2") {
                        $status = "Close ผู้ร้องดำเนินการต่อ";
                        $closecontinue++;
                      }elseif ($re['caseClose_id'] == "3") {
                        $status = "Close ไม่สามารถดำเนินการได้ ";
                        $closereject++;
                      }elseif ($re['caseClose_id'] == "11") {
                        $status = "Close";
                        $close++;
                      }
                    }else {
                      if($re['caseClose_id'] == "4"){
                        $status = "Close";
                        $close++;
                      }elseif ($re['caseClose_id'] == "5") {
                        $status = "Close";
                        $close++;
                      }elseif ($re['caseClose_id'] == "6") {
                        $status = "Close";
                        $close++;
                      }elseif ($re['caseClose_id'] == "7") {
                        $status = "Close";
                        $close++;
                      }elseif ($re['caseClose_id'] == "8") {
                        $status = "Close";
                        $close++;
                      }elseif ($re['caseClose_id'] == "9") {
                        $status = "Close";
                        $close++;
                      }elseif ($re['caseClose_id'] == "10") {
                        $status = "Close";
                        $close++;
                      }
                    }
                  }else {
                    $status = "Overdue Sub process";
                    $overduesub++;
                  }
                }
              }

            }
                    $num_row++;
        }
        $num = $num_row;
      }

      $output['total'] = $num;
      $output['waiting'] = $waiting;
      $output['new'] = $new;
      $output['pending'] = $pending;
      $output['overduemain'] = $overduemain;
      $output['overduesub'] = $overduesub;
      $output['closesuccess'] = $closesuccess;
      $output['closecontinue'] = $closecontinue;
      $output['closereject'] = $closereject;
      $output['close'] = $close;
      $output['Closeoverdue'] = $Closeoverdue;
     header("content-type:application/json;charset=utf-8");
     echo json_encode( $output );
}


function search_text_issue($txt_search){


  global $conn;

  $sql = "SELECT * FROM `Case` WHERE applnt_firstname LIKE '%$txt_search%' OR applnt_lastname LIKE '%$txt_search%' OR complnt_name LIKE '%$txt_search%'";
  $query = $conn->query($sql);
  if($query->num_rows > 0){
    $output = array();
    while ($rs = $query->fetch_assoc()) {
     $case = array();
     $case['name'] = $rs['applnt_firstname'];
     array_push($output,$case);
    }
    echo json_encode($output);
  }
  exit();
}
?>
