<?php
include("../../config/config.php");
$prodType = array();

if(isset($_GET["method"]) && $_GET["method"]=="report_issue"){
  $post = array();
  $request_body = file_get_contents('php://input');
  $post = json_decode($request_body);
  $response = report_issue($post);
  echo $response;
  exit();

}

if(isset($_GET["method"]) && $_GET["method"]=="report_country"){
 
  $post = array();
  $request_body = file_get_contents('php://input');
  $post = json_decode($request_body);
  $response = report_country($post);
  echo $response;
  exit();

}

if(isset($_GET["method"]) && $_GET["method"]=="report_country_chart"){
 
  $post = array();
  $request_body = file_get_contents('php://input');
  $post = json_decode($request_body);
  $response = report_country_chart($post);
  echo $response;
  exit();

}

if(isset($_GET["method"]) && $_GET["method"]=="report_compare"){
 
  $post = array();
  $request_body = file_get_contents('php://input');
  $post = json_decode($request_body);
  $response = report_compare($post);
  echo $response;
  exit();
}

if(isset($_GET["method"]) && $_GET["method"]=="report_product"){
  $post = array();
  $request_body = file_get_contents('php://input');
  $post = json_decode($request_body);
  $response = report_product($post);
  echo $response;
  exit();
}

if(isset($_GET["method"]) && $_GET["method"]=="report_country_thai"){
  $post = array();
  $request_body = file_get_contents('php://input');
  $post = json_decode($request_body);
  $response = report_country_thai($post);
  echo $response;
  exit();
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

function prodTypeListMutiLv($lv,$ref_id,$pro_id){
  global $conn;
  $prodTypeArrObj = array();
  $sql = "SELECT *
  FROM Product_Type
          WHERE prodType_level = '$lv'
          AND prodType_status = '0'
          AND prodType_enable = '1' ";
  if($ref_id!=""){
    $sql .= "AND prodType_ref_id = '$ref_id' ";
  }else {
    $sql .= "AND prodType_id = '$pro_id' ";
  }
  $query = $conn->query($sql);
  $prod_num = $query->num_rows;
  $lv++;
    while($result = $query->fetch_assoc()){
      $prodArr["prodType_id"] = $result["prodType_id"];
      $sql_sub = "SELECT *
                  FROM Product_Type
                  WHERE prodType_ref_id = '".$result["prodType_id"]."'
                  AND prodType_level = '$lv'
                  AND prodType_status = '0'
                  AND prodType_enable = '1' ";
      $query_sub = $conn->query($sql_sub);
      $num_sub = $query_sub->num_rows;
      $prodArr["prodType_sublist"] = $num_sub;
      array_push($prodTypeArrObj,$prodArr);
    }
  return $prodTypeArrObj;
}

function getProdType($lv,$ref_id,$pro_id){
  global $prodType;
  global $conn;
$i=0;
foreach(prodTypeListMutiLv($lv,$ref_id,$pro_id) as $prod_type){
  // echo $prod_type["prodType_id"];
  if($prod_type["prodType_sublist"]>0){
    $n_lv = $lv+1;
    $option .= getProdType($n_lv,$prod_type["prodType_id"],$prod_type["prodType_id"]);
  }
  array_push($prodType,$prod_type["prodType_id"]);
  $i++;
}

return $prodType;
}

function report_issue($post){
   global $conn;

   if($post->year_set_1 =="1"){
     if($post->date_start == ""){
       if($post->month_issue_th == ""){
         if($post->quarter == ""){
           if($post->issue_year_th == ""){
             $where_date = "";
           }else {
             if($post->year_set_2 == "2"){
               $year = $post->issue_year_th;
               $year_start = ($year-1)."-10-01";
               $year_end = $year."-09-30";
               $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
             }else {
               $year = $post->issue_year_th;
               $year_start = $year."-01-01";
               $year_end = $year."-12-31";
               $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
             }
           }
         }else {
           $year = $post->issue_year_th;
           if($post->quarter == "1"){
             $year_start = $year."-01-01";
             $year_end = $year."-03-31";
             $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
           }elseif ($post->quarter == "2") {
             $year_start = $year."-04-01";
             $year_end = $year."-06-30";
             $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
           }elseif ($post->quarter == "3") {
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
         $year = $post->issue_year_th;
         $month = $post->month_issue_th;
         $year_start = $year."-".$month."-01";
         $year_end = $year."-".$month."-31";
         $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
       }
     }else {
       if($post->date_stop == ""){
         $year = $post->issue_year_th;
         $month = $post->month_issue_th;
         $date_start = $post->date_start;

         $date_time = $date_start;
         $date_time_ex = explode(" ",$date_time);
         $date_re = $date_time_ex[0];
         $date_ex = explode("/",$date_re);
         $date_rx_year = $date_ex[2]-543;
         $date_start_ex= $date_rx_year."-".$date_ex[1]."-".$date_ex[0];

         $year_start = $date_start_ex;
         $where_date = " AND (c.case_create_datetime >= '".$year_start."')";
       }else {
         $year = $post->issue_year_th;
         $month = $post->month_issue_th;
         $date_start = $post->date_start;
         $date_stop = $post->date_stop;

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
     if($post->date_start == ""){
       if($post->month_issue_en == ""){
         if($post->quarter == ""){
           if($post->issue_year_en == ""){
             $where_date = "";
           }else {
             if($post->year_set_2 == "2"){
               $year = $post->issue_year_en;
               $year_start = ($year-1)."-10-01";
               $year_end = $year."-09-30";
               $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
             }else {
               $year = $post->issue_year_en;
               $year_start = $year."-01-01";
               $year_end = $year."-12-31";
               $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
             }

           }
         }else {
           $year = $post->issue_year_en;
           if($post->quarter == "1"){
             $year_start = $year."-01-01";
             $year_end = $year."-03-31";
             $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
           }elseif ($post->quarter == "2") {
             $year_start = $year."-04-01";
             $year_end = $year."-06-30";
             $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
           }elseif ($post->quarter == "3") {
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
         $year = $post->issue_year_en;
         $month = $post->month_issue_en;
         $year_start = $year."-".$month."-01";
         $year_end = $year."-".$month."-31";
         $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
       }
     }else {
       if($post->date_stop == ""){
         $year = $post->issue_year_en;
         $month = $post->month_issue_en;
         $date_start = $post->date_start;

         $date_time = $date_start;
         $date_time_ex = explode(" ",$date_time);
         $date_re = $date_time_ex[0];
         $date_ex = explode("/",$date_re);
         $date_start_ex= $date_ex[2]."-".$date_ex[1]."-".$date_ex[0];

         $year_start = $date_start_ex;
         $where_date = " AND (c.case_create_datetime >= '".$year_start."')";
       }else {
         $year = $post->issue_year_en;
         $month = $post->month_issue_en;
         $date_start = $post->date_start;
         $date_stop = $post->date_stop;

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


  if($post->compType_id == ""){
    $where_comp = "";
  }else {
    $where_comp = " AND c.compType_id = $post->compType_id";
  }

  if($post->office_id == ""){
    $where_office = "";
  }else {
    $where_office = " AND c.office_id = $post->office_id";
  }

  if($_SESSION['admin']['empSection'] == "1"){
    if($post->prodType_id == ""){
      $where_prod = "";
    }else {
      $sql_pro = "SELECT * FROM Product_Type WHERE prodType_id = '$post->prodType_id'";
      $query_pro = $conn->query($sql_pro);
      $re = $query_pro->fetch_assoc();


      $pro =  getProdType($re['prodType_level'],null,$post->prodType_id);

      if(join(',',$pro) == ""){
        $inpro = "''";
      }else {
        $inpro = join(',',$pro);
      }
      $where_prod = " AND c.prodType_id IN (".$inpro.")";

      // $where_prod = " AND (c.prodType_id = $post->prodType_id OR pt.prodType_ref_id = $post->prodType_id)";
    }
  }else {
    if($post->prodType_id == ""){
      $where_prod = "";
    }else {
      $where_prod = " AND c.incType_id = $post->prodType_id";
    }
  }

  if($post->caseCh_id == ""){
    $where_caseCh = "";
  }else {
    $where_caseCh = " AND (c.caseCh_id = $post->caseCh_id OR ch.caseCh_ref_id = $post->caseCh_id)";
  }

  if($post->Country_applnt == ""){
    $whereCountry_applnt = "";
  }else {
    $whereCountry_applnt = " AND c.applnt_country_id = $post->Country_applnt";
  }

  if($post->Country_complnt == ""){
    $whereCountry_complnt = "";
  }else {
    $whereCountry_complnt = " AND c.complnt_country_id = $post->Country_complnt";
  }

  if($post->member_comp_type == ""){
    $wheremembe = "";
  }else {
    $wheremembe = " AND c.applnt_valid_ditp = $post->member_comp_type";
  }


  if($post->text == ""){
    $whereSearch = "";
  }else {
    $whereSearch = " AND (c.caseDtl_title LIKE '%".$post->text."%' OR ch.caseCh_name LIKE '%".$post->text."%' OR ct.compType_name LIKE '%".$post->text."%' OR pt.prodType_name LIKE '%".$post->text."%')";
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


  if($post->status_complaint == ""){
    $whereStatus = "";
  }else {
    if($post->status_complaint == "0"){
        $whereStatus = " AND c.case_status = $post->status_complaint";
    }elseif ($post->status_complaint == "1") {
        $whereStatus = " AND c.case_status = $post->status_complaint";
    }elseif ($post->status_complaint == "2") {
        $whereStatus = " AND c.case_status = $post->status_complaint";
    }elseif ($post->status_complaint == "3") {
        $whereStatus = " AND c.case_status = $post->status_complaint";
    }elseif ($post->status_complaint == "4") {
        $whereStatus = " AND c.case_status IN (2,3)";
    }elseif ($post->status_complaint == "5") {

      $byid =  implode(',',$allS);
      if(count($byid)==0){
        $whereStatus = " AND c.case_status = 3  AND  c.case_id in (0) ";
      }else{
        $whereStatus = " AND c.case_status = 3  AND  c.case_id in ($byid) ";
      }
    }
  }


  if($post->respon == ""){
    $sql = "SELECT
    c.case_id,
    c.case_create_datetime,
    c.case_receivedoc_date,
    c.office_id,
    c.prodType_other,
    c.caseDtl_title,
    c.case_status,
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
    $sql .= " WHERE 1 AND ct.compType_section = '".$_SESSION['admin']['empSection']."'  $whereSearch $where_date $where_comp $where_prod $where_caseCh
    $whereCountry_applnt $whereCountry_complnt $whereStatus $wheremembe $where_office ";
  }else {
    $whererespon = " AND a.emp_id = $post->respon";
    $sql = "SELECT
    c.case_create_datetime,
    c.prodType_other,
    c.office_id,
    c.caseDtl_title,
    c.case_receivedoc_date,
    c.case_status,
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
    $where_prod $where_caseCh $whereCountry_applnt $whereCountry_complnt $whereStatus $whererespon $wheremembe $where_office ";
  }
   // echo $sql;
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

  if($post->status_complaint == "0" || $post->status_complaint == "1" || $post->status_complaint == ""){
    $whereincase = "";
  }elseif ($post->status_complaint == "2" || $post->status_complaint == "3") {
    if(join(',',$over_list) == ""){
      $incase = "''";
    }else {
      $incase = join(',',$over_list);
    }
    $whereincase = " AND c.case_id NOT IN (".$incase.")";
  }elseif ($post->status_complaint == "4") {
    if(join(',',$over_list) == ""){
      $incase = "''";
    }else {
      $incase = join(',',$over_list);
    }
    $whereincase = " AND c.case_id IN (".$incase.")";
  }

  if($post->respon == ""){
    $caseCh_arr = array();
    $sql_caseCh = "SELECT
    c.case_create_datetime,
    c.case_receivedoc_date,
    c.office_id,
    c.prodType_other,
    c.caseDtl_title,
    c.case_status,
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
    $where_caseCh $whereCountry_applnt $whereCountry_complnt $whereStatus $wheremembe $where_office ";
  }else {
    $whererespon = " AND a.emp_id = $post->respon";
    $caseCh_arr = array();
    $sql_caseCh = "SELECT
    c.case_create_datetime,
    c.case_receivedoc_date,
    c.office_id,
    c.prodType_other,
    c.caseDtl_title,
    c.case_status,
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
    $where_date $where_comp $where_prod $where_caseCh $whereCountry_applnt $whereCountry_complnt $whereStatus $whererespon $wheremembe $where_office ";
  }
  if($post->sort=="id"){
    $sort_col = "c.case_create_datetime";
  }
  if($post->sort=="case_receivedoc_date"){
    $sort_col = "c.case_lastSave_datetime";
  }
  if($post->sort=="complaint"){
    $sort_col = "c.compType_id";
  }
  if($post->sort=="mail"){
    $sort_col = "ch.caseCh_name";
  }
  if($post->sort=="product"){
    $sort_col = "pt.prodType_name";
  }
  if($post->sort=="close"){
    $sort_col = "c.case_close_datetime";
  }
  // echo $sql_caseCh;
  $sql_caseCh .= " ORDER BY $sort_col  $post->order ";

  $query_case = $conn->query($sql_caseCh);
  $num = $query_case->num_rows;


  $sql_caseCh .= " LIMIT $post->offset , $post->limit ";

    echo $sql_caseCh;
    exit();
     $query_edit_pass = $conn->query($sql_caseCh);
     $co_id = 0 ;
     $i_padding = 0;
     $txt_time_subover = "";
     while ($re = $query_edit_pass->fetch_assoc()) {

       if($post->status_complaint == "2"){  

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

       }elseif ($post->status_complaint == "3") {

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

      }elseif ($post->status_complaint == "4") {

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
         if($set_time['days'] < 1){
           $date = "";
         }else {
           $date = $set_time['days'].' วัน ';
         }
         if($set_time['hours'] < 1){
           $hours = "";
         }else {
           $hours = $set_time['hours'].' ชั่วโมง ';
         }

         $day_subholiday = (int)getHoliday(date('Y-m-d', strtotime($start_date_close)),$end_date_close);
          if($day_subholiday>0){
           $case_processInit_idx = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime('+'.$day_subholiday.' day', strtotime($start_date_close))))->format('Y/m/d H:i:s');
          }else{
           $case_processInit_idx = DateTime::createFromFormat('Y-m-d H:i:s', $start_date_close)->format('Y/m/d H:i:s');
          }

         $caseCh_col_arr = array();
         $co_id++ ;
         $num_page = $post->offset;
         $page = $co_id + $num_page;
         $caseCh_col_arr["id"] = '<span class="txt_nol">'.$page.'</span>';

         $date_time = $re['case_lastSave_datetime'];
         $date_time_ex = explode(" ",$date_time);
         $date_waitting = $date_time_ex[0];
         $date_ex = explode("-",$date_waitting);
         if($post->year_set_1 =="1"){
           $date_year = $date_ex[0]+543;
         }else {
           $date_year = $date_ex[0];
         }
         $date_receivedoc= $date_ex[2]."/".$date_ex[1]."/".$date_year;

         $date_time_close = $re['case_close_datetime'];
         $date_time_ex_close = explode(" ",$date_time_close);
         $date_waitting_close = $date_time_ex_close[0];
         $date_ex_close = explode("-",$date_waitting_close);
         if($post->year_set_1 =="1"){
           $date_close_year = $date_ex_close[0]+543;
         }else {
           $date_close_year = $date_ex_close[0];
         }
         $date_close= $date_ex_close[2]."/".$date_ex_close[1]."/".$date_close_year;
         if($date_close == "//543" || $date_close == "//"){
           $date_close_ex = "-";
         }else {
           $date_close_ex = $date_close;
         }

         if($date_receivedoc == "//543" || $date_receivedoc == "//"){
           $date_receivedoc_ex = "-";
         }else {
           $date_receivedoc_ex = $date_receivedoc;
         }
         $receivedoc_date = DateTime::createFromFormat('Y-m-d', $re['case_receivedoc_date'])->format('d/m/Y');
         $caseCh_col_arr["case_receivedoc_date"] = '<span class="txt_nol">'.$date_receivedoc_ex.'</span>';
         $caseCh_col_arr["close"] = '<span class="txt_nol">'.$date_close_ex.'</span>';
         if($re['caseDtl_title'] == ""){
           $caseDtl_title = "-";
         }else {
           $caseDtl_title = $re['caseDtl_title'];
         }
         $caseCh_col_arr["caseDtl_title"] = '<div class="caseDtl_title_report"><span class="txt_nol">'.$caseDtl_title.'</span></div>';
         if($re['caseCh_name'] == ""){
           $caseCh_name = "-";
         }else {
           $caseCh_name = $re['caseCh_name'];
         }
         $caseCh_col_arr["mail"] = '<span class="txt_nol">'.$caseCh_name.'</span>';
         if($re['compTypeSub1_name'] == ""){
           $compTypeSub1 = "";
         }else {
           $compTypeSub1 = "<br> &nbsp; -";
         }
         if($re['compTypeSub2_name'] == ""){
           $compTypeSub2 = "";
         }else {
           $compTypeSub2 = "<br> &nbsp; -";
         }
         $caseCh_col_arr["complaint"] = '<div class="complaint_report"><span class="txt_nol">'.$re['compType_name'].''.$compTypeSub1.' '.$re['compTypeSub1_name'].''.$compTypeSub2.' '.$re['compTypeSub2_name'].'</span></div>';
         if($_SESSION['admin']['empSection'] == "1"){
           if($re['prodType_name'] == 'อื่นๆ'){
             $product = $re['prodType_other'];
           }else {
             $product = $re['prodType_name'];
           }
         }else {
           $product = $re['incType_name'];
         }
         $caseCh_col_arr["product"] = '<div class="product_report"><span class="txt_nol">'.$product.'</span></div>';
         if($re['applnt_firstname'] == "" && $re['applnt_lastname'] == ""){
           $applnt = "-";
         }else {
           $applnt = $re['applnt_firstname'].' '.$re['applnt_lastname'];
         }
         $caseCh_col_arr["applnt"] = '<div class="name_report"><span class="txt_nol">'.$applnt.'</span></div>';
         $caseCh_col_arr["process"] = '<div class="process_report"><span class="txt_nol">'.$re['case_close_resultProcess'].'</span></div>';

         if($re['applnt_valid_ditp'] == "1"){
           $member_comp_type = "เป็นสมาชิกกรม";
         }elseif ($re['applnt_valid_ditp'] == "2") {
           $member_comp_type = "ไม่เป็นสมาชิกกรม";
         }else {
           $member_comp_type = "ไม่ระบุ";
         }

         $caseCh_col_arr["member_comp_type"] = '<div class="member_comp_report"><span class="txt_nol">'.$member_comp_type.'</span></div>';

         if($_SESSION['admin']['office'] == 0){
           $sql_ass = "SELECT *
           FROM `office_type`
           WHERE office_id = '".$re['office_id']."' ";
           $query_ass = $conn->query($sql_ass);
           $counsel = "";
           while ($rs = $query_ass->fetch_assoc()) {
           $counsel .= '<div class="name_report"><span class="txt_nol">'.$rs['office_name'].'</span></div><br>';
            }
         }else {
           $sql_ass = "SELECT a.emp_id,a.case_id,e.emp_firstname,e.emp_lastname,a.caseAsign_status
           FROM `Case_Assign` AS a LEFT JOIN `Employee` AS e ON a.emp_id = e.emp_id
           WHERE a.case_id = '".$re['case_id']."' AND a.caseAsign_status = 0";
           $query_ass = $conn->query($sql_ass);
           $counsel = "";
           while ($rs = $query_ass->fetch_assoc()) {
           $counsel .= '<div class="name_report"><span class="txt_nol">'.$rs['emp_firstname'].' '.$rs['emp_lastname'].'</span></div><br>';
            }
         }
          $caseCh_col_arr["counsel"] = $counsel;

         $caseCh_col_arr["complnt"] = '<div class="name_report"><span class="txt_nol">'.$re['complnt_name'].'</span></div>';


          $date_time2 = $re['case_close_datetime'];
          $date_time_ex2 = explode(" ",$date_time2);
          $date_waitting2 = $date_time_ex2[0];
          $date_ex2 = explode("-",$date_waitting2);
          $case_close= $date_ex2[2]."/".$date_ex2[1]."/".$date_ex2[0];

          if($case_close == "//"){
            $case_close = "-";
          }

          $num_process = 0;
          $txt_over = "";
          $txt_timeover = "";

         if($re['case_status'] == "0"){
           $status = "Waiting";
           $id = "Waiting".$re['case_status'];
         }elseif ($re['case_status'] == "1") {
           $status = "New";
           $id = "Waiting".$re['case_status'];
         }elseif ($re['case_status'] == "2") {

           if($re['case_close_datetime'] == "" || $re['case_close_datetime'] == NULL){
             $case_close_datetime = date('Y-m-d 00:00:00',time());
           }else {
             $case_close_datetime = date("Y-m-d 00:00:00",strtotime($re['case_close_datetime']));
           }
           $chk_time_close = getDateTimeData(date("Y-m-d 00:00:00",strtotime($re['case_opened_datetime'])),$case_close_datetime);

           if($chk_time_close['days'] > $re['case_compType_duration']){
             $status = "Overdue Main process";
             $id = "overdue_main";
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
                 $txt_over = "<span class='circle_report'><i class='fa fa-circle' aria-hidden='true'></i></span> กระบวนการที่ ".$num_process." - ".$rx['process_type_name'];
                 $over_time = getDateDiff($time_over,$time_compare);
                 if($over_time['days'] < 1){
                   $over_days = "";
                 }else {
                   $over_days = $over_time['days'].' วัน ';
                 }

                 if($over_time['hours'] < 1){
                   $over_hours = "";
                 }else {
                   $over_hours = $over_time['hours'].' ชั่วโมง ';
                 }
                   $txt_timeover = "<span class='txt_timeover_sub'>( ".$over_days.$over_hours.$over_time['minutes']." นาที )</span>";
                 $txt_time_subover .= $txt_over."<br>".$txt_timeover."<br>";
                 $i++;
               }else{
                 $i = 0;
               }
               $num_process++;
             }

             if($i == "0"){
               $status = "In Process";
               $id = "Pending";
             }else {
               $status = "Overdue Sub process";
               $id = "overdue_sub_process";
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
             $id = "overdue_main";
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
                 $txt_over = "<span class='circle_report'><i class='fa fa-circle' aria-hidden='true'></i></span> กระบวนการที่ ".$num_process." - ".$rx['process_type_name'];
                 $over_time = getDateDiff($time_over,$time_compare);

                 if($over_time['days'] < 1){
                   $over_days = "";
                 }else {
                   $over_days = $over_time['days'].' วัน ';
                 }

                 if($over_time['hours'] < 1){
                   $over_hours = "";
                 }else {
                   $over_hours = $over_time['hours'].' ชั่วโมง ';
                 }
                   $txt_timeover = "<span class='txt_timeover_sub'>( ".$over_days.$over_hours.$over_time['minutes']." นาที )</span>";
                 $txt_time_subover .= $txt_over."<br>".$txt_timeover."<br>";
                 $i++;
               }else{
                   $i = 0;
               }
               $num_process++;
             }

             if($i == "0"){
               if($_SESSION['admin']['empSection'] == "1"){
                 if($re['caseClose_id'] == "1"){
                   $status = "Close ตกลงกันได้ : คู่กรณีสามารถตกลงกันได้";
                   $id = "Close".$re['caseClose_id'];
                 }elseif ($re['caseClose_id'] == "2") {
                   $status = "Close ผู้ร้องดำเนินการต่อ : คู่กรณีดำเนินการในส่วนที่เกี่ยวข้องต่อไป";
                   $id = "Close".$re['caseClose_id'];
                 }elseif ($re['caseClose_id'] == "3") {
                   $status = "Close กรมไม่สามารถดำเนินการได้  : ไม่สามารถดำเนินการได้";
                   $id = "Close".$re['caseClose_id'];
                 }elseif ($re['caseClose_id'] == "11") {
                   $status = "Close : ตรวจสอบความน่าเชื่อถือของบริษัท";
                   $id = "Close".$re['caseClose_id'];
                 }
               }else {
                 if($re['caseClose_id'] == "4"){
                   $status = "Close : ไม่พบมูลความผิด";
                   $id = "Close".$re['caseClose_id'];
                 }elseif ($re['caseClose_id'] == "5") {
                   $status = "Close : ภาคทัณฑ์";
                   $id = "Close".$re['caseClose_id'];
                 }elseif ($re['caseClose_id'] == "6") {
                   $status = "Close : ตัดเงินเดือน";
                   $id = "Close".$re['caseClose_id'];
                 }elseif ($re['caseClose_id'] == "7") {
                   $status = "Close : ลดขั้นเงินเดือน";
                   $id = "Close".$re['caseClose_id'];
                 }elseif ($re['caseClose_id'] == "8") {
                   $status = "Close : ปลดออก";
                   $id = "Close".$re['caseClose_id'];
                 }elseif ($re['caseClose_id'] == "9") {
                   $status = "Close : ไล่ออก";
                   $id = "Close".$re['caseClose_id'];
                 }elseif ($re['caseClose_id'] == "10") {
                   $status = "Close : อื่นๆ";
                   $id = "Close".$re['caseClose_id'];
                 }
               }

             }else {
               $status = "Overdue Sub process";
               $id = "overdue_sub_process";
             }


           }
         }
         $arrd = array( '1'   => 'Close(overdue) : คู่กรณีสามารถตกลงกันได้'
                        ,'2'  => 'Close(overdue) : คู่กรณีดำเนินการในส่วนที่เกี่ยวข้องต่อไป'
                        ,'3'  => 'Close(overdue) : ไม่สามารถดำเนินการได้'
                        ,'4'  => 'Close(overdue) : ไม่พบมูลความผิด'
                        ,'5'  => 'Close(overdue) : ภาคทัณฑ์'
                        ,'6'  => 'Close(overdue) : ตัดเงินเดือน'
                        ,'7'  => 'Close(overdue) : ลดขั้นเงินเดือน'
                        ,'8'  => 'Close(overdue) : ปลดออก'
                        ,'9'  => 'Close(overdue) : ไล่ออก'
                        ,'10' => 'Close(overdue) : อื่นๆ'
                        ,'11' => 'Close(overdue) : ตรวจสอบความน่าเชื่อถือของบริษัท' );

         if(in_array($re['case_id'],$allS)){
            $status = $arrd[$re['caseClose_id']];
            $id = "Close".$re['caseClose_id'];
         }


         $caseCh_col_arr["status"] = '<div class="div_status_report"><span class="txt_nol '.$id.'">'.$status.'</span></div>';

         if($re['case_status'] == "3" || $re['case_status'] == "1" || $re['case_status'] == "0"){
           $caseCh_col_arr["case_close"] = '<div class="time_issue"><span class="txt_nol">'.$date.$hours.$set_time['minutes'].' นาที '.'</span></div><br>';
           $caseCh_col_arr["case_close"] .= '<span class="txt_nol txt_over">'.$txt_time_subover.'</span>';
           $caseCh_col_arr["case_close"] .= '<span class="txt_nol time_over_xr">'.$txt_timeover.'</span>';
         }else {
           $caseCh_col_arr["case_close"] = '<div class="time_issue"><span class="clock" id="clock_'.$re['case_id'].'" >'.$case_processInit_idx.'</span></div><br>';
           $caseCh_col_arr["case_close"] .= '<span class="txt_nol txt_over">'.$txt_time_subover.'</span>';
           $caseCh_col_arr["case_close"] .= '<span class="txt_nol time_over_xr">'.$txt_timeover.'</span>';
         }


         array_push($caseCh_arr,$caseCh_col_arr);
       }
       $txt_time_subover = "";
       if($post->status_complaint == "2" || $post->status_complaint == "3" || $post->status_complaint == "4"){
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
                  if($set_time['days'] < 1){
                    $date = "";
                  }else {
                    $date = $set_time['days'].' วัน ';
                  }
                  if($set_time['hours'] < 1){
                    $hours = "";
                  }else {
                    $hours = $set_time['hours'].' ชั่วโมง ';
                  }

                  $day_subholiday = (int)getHoliday(date('Y-m-d', strtotime($start_date_close)),$end_date_close);
                   if($day_subholiday>0){
                    $case_processInit_idx = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime('+'.$day_subholiday.' day', strtotime($start_date_close))))->format('Y/m/d H:i:s');
                   }else{
                    $case_processInit_idx = DateTime::createFromFormat('Y-m-d H:i:s', $start_date_close)->format('Y/m/d H:i:s');
                   }

                  $caseCh_col_arr = array();
                  $co_id++ ;
                  $num_page = $post->offset;
                  $page = $co_id + $num_page;
                  $caseCh_col_arr["id"] = '<span class="txt_nol">'.$page.'</span>';

                  $date_time = $re['case_lastSave_datetime'];
                  $date_time_ex = explode(" ",$date_time);
                  $date_waitting = $date_time_ex[0];
                  $date_ex = explode("-",$date_waitting);
                  if($post->year_set_1 =="1"){
                    $date_year = $date_ex[0]+543;
                  }else {
                    $date_year = $date_ex[0];
                  }
                  $date_receivedoc= $date_ex[2]."/".$date_ex[1]."/".$date_year;

                  $date_time_close = $re['case_close_datetime'];
                  $date_time_ex_close = explode(" ",$date_time_close);
                  $date_waitting_close = $date_time_ex_close[0];
                  $date_ex_close = explode("-",$date_waitting_close);
                  if($post->year_set_1 =="1"){
                    $date_close_year = $date_ex_close[0]+543;
                  }else {
                    $date_close_year = $date_ex_close[0];
                  }
                  $date_close= $date_ex_close[2]."/".$date_ex_close[1]."/".$date_close_year;
                  if($date_close == "//543" || $date_close == "//"){
                    $date_close_ex = "-";
                  }else {
                    $date_close_ex = $date_close;
                  }
                  if($date_receivedoc == "//543" || $date_receivedoc == "//"){
                    $date_receivedoc_ex = "-";
                  }else {
                    $date_receivedoc_ex = $date_receivedoc;
                  }
                   $receivedoc_date = DateTime::createFromFormat('Y-m-d', $re['case_receivedoc_date'])->format('d/m/Y');
                  $caseCh_col_arr["case_receivedoc_date"] = '<span class="txt_nol">'.$date_receivedoc_ex.'</span>';
                  $caseCh_col_arr["close"] = '<span class="txt_nol">'.$date_close_ex.'</span>';
                  if($re['caseDtl_title'] == ""){
                    $caseDtl_title = "-";
                  }else {
                    $caseDtl_title = $re['caseDtl_title'];
                  }
                  $caseCh_col_arr["caseDtl_title"] = '<div class="caseDtl_title_report"><span class="txt_nol">'.$caseDtl_title.'</span></div>';
                  if($re['caseCh_name'] == ""){
                    $caseCh_name = "-";
                  }else {
                    $caseCh_name = $re['caseCh_name'];
                  }
                  $caseCh_col_arr["mail"] = '<span class="txt_nol">'.$caseCh_name.'</span>';
                  if($re['compTypeSub1_name'] == ""){
                    $compTypeSub1 = "";
                  }else {
                    $compTypeSub1 = "<br> &nbsp; -";
                  }
                  if($re['compTypeSub2_name'] == ""){
                    $compTypeSub2 = "";
                  }else {
                    $compTypeSub2 = "<br> &nbsp; -";
                  }
                  $caseCh_col_arr["complaint"] = '<div class="complaint_report"><span class="txt_nol">'.$re['compType_name'].''.$compTypeSub1.' '.$re['compTypeSub1_name'].''.$compTypeSub2.' '.$re['compTypeSub2_name'].'</span></div>';
                  if($_SESSION['admin']['empSection'] == "1"){

                    if($re['prodType_name'] == 'อื่นๆ'){
                      $product = $re['prodType_other'];
                    }else {
                      $product = $re['prodType_name'];
                    }

                  }else {
                    $product = $re['incType_name'];
                  }
                  $caseCh_col_arr["product"] = '<div class="product_report"><span class="txt_nol">'.$product.'</span></div>';
                  if($re['applnt_firstname'] == "" && $re['applnt_lastname'] == ""){
                    $applnt = "-";
                  }else {
                    $applnt = $re['applnt_firstname'].' '.$re['applnt_lastname'];
                  }
                  $caseCh_col_arr["applnt"] = '<div class="name_report"><span class="txt_nol">'.$applnt.'</span></div>';
                  $caseCh_col_arr["process"] = '<div class="process_report"><span class="txt_nol">'.$re['case_close_resultProcess'].'</span></div>';

                  if($re['applnt_valid_ditp'] == "1"){
                    $member_comp_type = "เป็นสมาชิกกรม";
                  }elseif ($re['applnt_valid_ditp'] == "2") {
                    $member_comp_type = "ไม่เป็นสมาชิกกรม";
                  }else {
                    $member_comp_type = "ไม่ระบุ";
                  }

                  $caseCh_col_arr["member_comp_type"] = '<div class="member_comp_report"><span class="txt_nol">'.$member_comp_type.'</span></div>';

                  if($_SESSION['admin']['office'] == 0){
                    $sql_ass = "SELECT *
                    FROM `office_type`
                    WHERE office_id = '".$re['office_id']."' ";
                    $query_ass = $conn->query($sql_ass);
                    $counsel = "";
                    while ($rs = $query_ass->fetch_assoc()) {
                    $counsel .= '<div class="name_report"><span class="txt_nol">'.$rs['office_name'].'</span></div><br>';
                     }
                  }else {
                    $sql_ass = "SELECT a.emp_id,a.case_id,e.emp_firstname,e.emp_lastname,a.caseAsign_status
                    FROM `Case_Assign` AS a LEFT JOIN `Employee` AS e ON a.emp_id = e.emp_id
                    WHERE a.case_id = '".$re['case_id']."' AND a.caseAsign_status = 0";
                    $query_ass = $conn->query($sql_ass);
                    $counsel = "";
                    while ($rs = $query_ass->fetch_assoc()) {
                    $counsel .= '<div class="name_report"><span class="txt_nol">'.$rs['emp_firstname'].' '.$rs['emp_lastname'].'</span></div><br>';
                     }
                  }

                   $caseCh_col_arr["counsel"] = $counsel;

                  $caseCh_col_arr["complnt"] = '<div class="name_report"><span class="txt_nol">'.$re['complnt_name'].'</span></div>';


                   $date_time2 = $re['case_close_datetime'];
                   $date_time_ex2 = explode(" ",$date_time2);
                   $date_waitting2 = $date_time_ex2[0];
                   $date_ex2 = explode("-",$date_waitting2);
                   $case_close= $date_ex2[2]."/".$date_ex2[1]."/".$date_ex2[0];

                   if($case_close == "//"){
                     $case_close = "-";
                   }

                   $num_process = 0;
                   $txt_over = "";
                   $txt_timeover = "";

                  if($re['case_status'] == "0"){
                    $status = "Waiting";
                    $id = "Waiting".$re['case_status'];
                  }elseif ($re['case_status'] == "1") {
                    $status = "New";
                    $id = "Waiting".$re['case_status'];
                  }elseif ($re['case_status'] == "2") {

                    if($re['case_close_datetime'] == "" || $re['case_close_datetime'] == NULL){
                      $case_close_datetime = date('Y-m-d 00:00:00',time());
                    }else {
                      $case_close_datetime = date("Y-m-d 00:00:00",strtotime($re['case_close_datetime']));
                    }
                    $chk_time_close = getDateTimeData(date("Y-m-d 00:00:00",strtotime($re['case_opened_datetime'])),$case_close_datetime);

                    if($chk_time_close['days'] > $re['case_compType_duration']){
                      $status = "Overdue Main process";
                      $id = "overdue_main";
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
                          $txt_over = "<span class='circle_report'><i class='fa fa-circle' aria-hidden='true'></i></span> กระบวนการที่ ".$num_process." - ".$rx['process_type_name'];
                          $over_time = getDateDiff($time_over,$time_compare);
                          if($over_time['days'] < 1){
                            $over_days = "";
                          }else {
                            $over_days = $over_time['days'].' วัน ';
                          }

                          if($over_time['hours'] < 1){
                            $over_hours = "";
                          }else {
                            $over_hours = $over_time['hours'].' ชั่วโมง ';
                          }
                          $txt_timeover = "<span class='txt_timeover_sub'>( ".$over_days.$over_hours.$over_time['minutes']." นาที )</span>";
                          $txt_time_subover .= $txt_over."<br>".$txt_timeover."<br>";
                          $i++;
                        }else{
                          $i = 0;
                        }
                        $num_process++;
                      }

                      if($i == "0"){
                        $status = "In Process";
                        $id = "Pending";
                      }else {
                        $status = "Overdue Sub process";
                        $id = "overdue_sub_process";
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
                      $id = "overdue_main";
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
                          $txt_over = "<span class='circle_report'><i class='fa fa-circle' aria-hidden='true'></i></span> กระบวนการที่ ".$num_process." - ".$rx['process_type_name'];
                          $over_time = getDateDiff($time_over,$time_compare);

                          if($over_time['days'] < 1){
                            $over_days = "";
                          }else {
                            $over_days = $over_time['days'].' วัน ';
                          }

                          if($over_time['hours'] < 1){
                            $over_hours = "";
                          }else {
                            $over_hours = $over_time['hours'].' ชั่วโมง ';
                          }
                            $txt_timeover = "<span class='txt_timeover_sub'>( ".$over_days.$over_hours.$over_time['minutes']." นาที )</span>";
                          $txt_time_subover .= $txt_over."<br>".$txt_timeover."<br>";
                          $i++;
                        }else{
                            $i = 0;
                        }
                        $num_process++;
                      }

                      if($i == "0"){
                        if($_SESSION['admin']['empSection'] == "1"){
                          if($re['caseClose_id'] == "1"){
                            $status = "Close ตกลงกันได้ : คู่กรณีสามารถตกลงกันได้";
                            $id = "Close".$re['caseClose_id'];
                          }elseif ($re['caseClose_id'] == "2") {
                            $status = "Close ผู้ร้องดำเนินการต่อ : คู่กรณีดำเนินการในส่วนที่เกี่ยวข้องต่อไป";
                            $id = "Close".$re['caseClose_id'];
                          }elseif ($re['caseClose_id'] == "3") {
                            $status = "Close กรมไม่สามารถดำเนินการได้  : ไม่สามารถดำเนินการได้";
                            $id = "Close".$re['caseClose_id'];
                          }elseif ($re['caseClose_id'] == "11") {
                            $status = "Close : ตรวจสอบความน่าเชื่อถือของบริษัท";
                            $id = "Close".$re['caseClose_id'];
                          }
                        }else {
                          if($re['caseClose_id'] == "4"){
                            $status = "Close : ไม่พบมูลความผิด";
                            $id = "Close".$re['caseClose_id'];
                          }elseif ($re['caseClose_id'] == "5") {
                            $status = "Close : ภาคทัณฑ์";
                            $id = "Close".$re['caseClose_id'];
                          }elseif ($re['caseClose_id'] == "6") {
                            $status = "Close : ตัดเงินเดือน";
                            $id = "Close".$re['caseClose_id'];
                          }elseif ($re['caseClose_id'] == "7") {
                            $status = "Close : ลดขั้นเงินเดือน";
                            $id = "Close".$re['caseClose_id'];
                          }elseif ($re['caseClose_id'] == "8") {
                            $status = "Close : ปลดออก";
                            $id = "Close".$re['caseClose_id'];
                          }elseif ($re['caseClose_id'] == "9") {
                            $status = "Close : ไล่ออก";
                            $id = "Close".$re['caseClose_id'];
                          }elseif ($re['caseClose_id'] == "10") {
                            $status = "Close : อื่นๆ";
                            $id = "Close".$re['caseClose_id'];
                          }
                        }
                      }else {
                        $status = "Overdue Sub process";
                        $id = "overdue_sub_process";
                      }
                    }
                  }

                  if(in_array($re['case_id'],$allS)){
                     $status = $arrd[$re['caseClose_id']];
                     $id = "Close".$re['caseClose_id'];
                  }

                  $caseCh_col_arr["status"] = '<div class="div_status_report"><span class="txt_nol '.$id.'">'.$status.'</span></div>';

                  if($re['case_status'] == 3 || $re['case_status'] == "1" || $re['case_status'] == "0"){

                    $caseCh_col_arr["case_close"] = '<div class="time_issue"><span class="txt_nol">'.$date.$hours.$set_time['minutes'].' นาที '.'</span></div><br>';
                    $caseCh_col_arr["case_close"] .= '<span class="txt_nol txt_over">'.$txt_time_subover.'</span>';
                    $caseCh_col_arr["case_close"] .= '<span class="txt_nol time_over_xr">'.$txt_timeover.'</span>';
                  }else {
                    $caseCh_col_arr["case_close"] = '<div class="time_issue"><span class="clock" id="clock_'.$re['case_id'].'" >'.$case_processInit_idx.'</span></div><br>';
                    $caseCh_col_arr["case_close"] .= '<span class="txt_nol txt_over">'.$txt_time_subover.'</span>';
                    $caseCh_col_arr["case_close"] .= '<span class="txt_nol time_over_xr">'.$txt_timeover.'</span>';
                  }


                  array_push($caseCh_arr,$caseCh_col_arr);
                } 

              }
     }
     $data_array = array('total'=>$num,'rows'=>$caseCh_arr,'sql'=>$where_date);
     return json_encode($data_array);
}

function report_country($post){
  global $conn;
  $sql = 'SELECT co.id , co.name ,COUNT(c.applnt_country_id) as country_num
  FROM `Case` as c
  LEFT JOIN Country as co ON co.id = c.applnt_country_id
  WHERE 1 AND co.id IS NOT NULL  
  ';
  $sql .= where_sql($post);


  $sql .= ' GROUP BY applnt_country_id ';

  $query_num = $conn->query($sql);
  $num = $query_num->num_rows;

  $sort = ' ORDER BY country_num DESC ';
  if($post->sort != ''){
    $sort = ' ORDER BY '.$post->sort.' '.$post->order.' ';
  }
  $sql .= $sort;
  $sql .= " LIMIT $post->offset , $post->limit ";
  $query = $conn->query($sql);
 
  $caseCh_arr = [];
  $i = 1;
 
  while ($res = $query->fetch_assoc()) {
    $caseCh_col_arr["id"] = 1 + $post->offset++;
    $caseCh_col_arr["name_th"] = $res['name'];
    $caseCh_col_arr["country_num"] = $res['country_num'];
    array_push($caseCh_arr,$caseCh_col_arr);
    $i++;
  }
  $data_array = array('total'=>$num,'rows'=>$caseCh_arr,'sql'=>$sql);
  return json_encode($data_array);
}

function report_country_chart($post){
  global $conn;
  $sql = 'SELECT Country.id , name ,COUNT(applnt_country_id) as country_num
  FROM `Case` 
  LEFT JOIN Country ON Country.id = Case.applnt_country_id
  WHERE 1 AND Country.id IS NOT NULL
  GROUP BY applnt_country_id 
  ORDER BY country_num DESC
  ';

  $query = $conn->query($sql);
 
  $caseCh_arr = [];
  $i = 1;
  while ($res = $query->fetch_assoc()) {
    $caseCh_col_arr["id"] = 1 + $post->offset++;
    $caseCh_col_arr["name_th"] = $res['name'];
    $caseCh_col_arr["country_num"] = $res['country_num'];
    array_push($caseCh_arr,$caseCh_col_arr);
    $i++;
  }
  // $data_array = array('total'=>$num,'rows'=>$caseCh_arr,'sql'=>$sql);
  return json_encode($caseCh_arr);
}

function report_compare($post){
  global $conn;

  if($post->year_set_1 == 1){
    $year1 =$post->year_com_1_1;
    $year2 =$post->year_com_1_2;
    $year1_show = $year1+543;
    $year2_show = $year2+543;
  } else{
    $year1 =$post->year_com_2_1;
    $year2 =$post->year_com_2_2;
    $year1_show = $year1;
    $year2_show = $year2;
  }

  if($post->year_set_2 == 1){
    
    $sql = 'SELECT 
      "'.$year1_show.'" as year,
      COUNT(case_id) as num_year,
      (SELECT COUNT(case_id) as num_year FROM `Case` WHERE 1 AND case_receivedoc_date LIKE "%'.$year1.'-01%") as "1" ,
      (SELECT COUNT(case_id) as num_year FROM `Case` WHERE 1 AND case_receivedoc_date LIKE "%'.$year1.'-02%") as "2" ,
      (SELECT COUNT(case_id) as num_year FROM `Case` WHERE 1 AND case_receivedoc_date LIKE "%'.$year1.'-03%") as "3" ,
      (SELECT COUNT(case_id) as num_year FROM `Case` WHERE 1 AND case_receivedoc_date LIKE "%'.$year1.'-04%") as "4" ,
      (SELECT COUNT(case_id) as num_year FROM `Case` WHERE 1 AND case_receivedoc_date LIKE "%'.$year1.'-05%") as "5" ,
      (SELECT COUNT(case_id) as num_year FROM `Case` WHERE 1 AND case_receivedoc_date LIKE "%'.$year1.'-06%") as "6" ,
      (SELECT COUNT(case_id) as num_year FROM `Case` WHERE 1 AND case_receivedoc_date LIKE "%'.$year1.'-07%") as "7" ,
      (SELECT COUNT(case_id) as num_year FROM `Case` WHERE 1 AND case_receivedoc_date LIKE "%'.$year1.'-08%") as "8" ,
      (SELECT COUNT(case_id) as num_year FROM `Case` WHERE 1 AND case_receivedoc_date LIKE "%'.$year1.'-09%") as "9" ,
      (SELECT COUNT(case_id) as num_year FROM `Case` WHERE 1 AND case_receivedoc_date LIKE "%'.$year1.'-10%") as "10" ,
      (SELECT COUNT(case_id) as num_year FROM `Case` WHERE 1 AND case_receivedoc_date LIKE "%'.$year1.'-11%") as "11" ,
      (SELECT COUNT(case_id) as num_year FROM `Case` WHERE 1 AND case_receivedoc_date LIKE "%'.$year1.'-12%") as "12" 
    FROM `Case` WHERE 1 
    AND case_receivedoc_date BETWEEN "'.$year1.'-01-01" AND "'.$year1.'-12-31"

            UNION

            SELECT 
      "'.$year2_show.'" as year,
      COUNT(case_id) as num_year,
      (SELECT COUNT(case_id) as num_year FROM `Case` WHERE 1 AND case_receivedoc_date LIKE "%'.$year2.'-01%") as "1" ,
      (SELECT COUNT(case_id) as num_year FROM `Case` WHERE 1 AND case_receivedoc_date LIKE "%'.$year2.'-02%") as "2" ,
      (SELECT COUNT(case_id) as num_year FROM `Case` WHERE 1 AND case_receivedoc_date LIKE "%'.$year2.'-03%") as "3" ,
      (SELECT COUNT(case_id) as num_year FROM `Case` WHERE 1 AND case_receivedoc_date LIKE "%'.$year2.'-04%") as "4" ,
      (SELECT COUNT(case_id) as num_year FROM `Case` WHERE 1 AND case_receivedoc_date LIKE "%'.$year2.'-05%") as "5" ,
      (SELECT COUNT(case_id) as num_year FROM `Case` WHERE 1 AND case_receivedoc_date LIKE "%'.$year2.'-06%") as "6" ,
      (SELECT COUNT(case_id) as num_year FROM `Case` WHERE 1 AND case_receivedoc_date LIKE "%'.$year2.'-07%") as "7" ,
      (SELECT COUNT(case_id) as num_year FROM `Case` WHERE 1 AND case_receivedoc_date LIKE "%'.$year2.'-08%") as "8" ,
      (SELECT COUNT(case_id) as num_year FROM `Case` WHERE 1 AND case_receivedoc_date LIKE "%'.$year2.'-09%") as "9" ,
      (SELECT COUNT(case_id) as num_year FROM `Case` WHERE 1 AND case_receivedoc_date LIKE "%'.$year2.'-10%") as "10" ,
      (SELECT COUNT(case_id) as num_year FROM `Case` WHERE 1 AND case_receivedoc_date LIKE "%'.$year2.'-11%") as "11" ,
      (SELECT COUNT(case_id) as num_year FROM `Case` WHERE 1 AND case_receivedoc_date LIKE "%'.$year2.'-12%") as "12" 
    FROM `Case` WHERE 1 
    AND case_receivedoc_date BETWEEN "'.$year2.'-01-01" AND "'.$year2.'-12-31"
            ';
  } else{
    $sql = 'SELECT 
      "'.$year1_show.'" as year,
      COUNT(case_id) as num_year,
      (SELECT COUNT(case_id) as num_year FROM `Case` WHERE 1 AND case_receivedoc_date BETWEEN "'.($year1-1).'-10-01" AND "'.($year1-1).'-12-31") as "1" ,
      (SELECT COUNT(case_id) as num_year FROM `Case` WHERE 1 AND case_receivedoc_date BETWEEN "'.$year1.'-01-01" AND "'.$year1.'-03-31") as "2" ,
      (SELECT COUNT(case_id) as num_year FROM `Case` WHERE 1 AND case_receivedoc_date BETWEEN "'.$year1.'-04-01" AND "'.$year1.'-06-30") as "3" ,
      (SELECT COUNT(case_id) as num_year FROM `Case` WHERE 1 AND case_receivedoc_date BETWEEN "'.$year1.'-07-01" AND "'.$year1.'-09-30") as "4" 
    FROM `Case` WHERE 1 
    AND case_receivedoc_date BETWEEN "'.($year1-1).'-10-01" AND "'.$year1.'-09-30"

            UNION

            SELECT 
      "'.$year2_show.'" as year,
      COUNT(case_id) as num_year,
      (SELECT COUNT(case_id) as num_year FROM `Case` WHERE 1 AND case_receivedoc_date BETWEEN "'.($year2-1).'-10-01" AND "'.($year2-1).'-12-31") as "1" ,
      (SELECT COUNT(case_id) as num_year FROM `Case` WHERE 1 AND case_receivedoc_date BETWEEN "'.$year2.'-01-01" AND "'.$year2.'-03-31") as "2" ,
      (SELECT COUNT(case_id) as num_year FROM `Case` WHERE 1 AND case_receivedoc_date BETWEEN "'.$year2.'-04-01" AND "'.$year2.'-06-30") as "3" ,
      (SELECT COUNT(case_id) as num_year FROM `Case` WHERE 1 AND case_receivedoc_date BETWEEN "'.$year2.'-07-01" AND "'.$year2.'-09-30") as "4" 
    FROM `Case` WHERE 1 
    AND case_receivedoc_date BETWEEN "'.($year2-1).'-10-01" AND "'.$year2.'-09-30"
            ';
  }

  $query = $conn->query($sql);
 
  $caseCh_arr = [];
  $i = 1;
  while ($res = $query->fetch_assoc()) {
      $caseCh_col_arr["id"] = 1 + $post->offset++;
      $caseCh_col_arr["year"] = $res['year'];
    if($post->year_set_2 == 1){
      $caseCh_col_arr["JAN"] = $res['1'];
      $caseCh_col_arr["FEB"] = $res['2'];
      $caseCh_col_arr["MAR"] = $res['3'];
      $caseCh_col_arr["APR"] = $res['4'];
      $caseCh_col_arr["MAY"] = $res['5'];
      $caseCh_col_arr["JUN"] = $res['6'];
      $caseCh_col_arr["JUL"] = $res['7'];
      $caseCh_col_arr["AUG"] = $res['8'];
      $caseCh_col_arr["SEP"] = $res['9'];
      $caseCh_col_arr["OCT"] = $res['10'];
      $caseCh_col_arr["NOV"] = $res['11'];
      $caseCh_col_arr["DEC"] = $res['12'];
      $caseCh_col_arr["type"] = 1;
    }else{
      $caseCh_col_arr["budget1"] = $res['1'];
      $caseCh_col_arr["budget2"] = $res['2'];
      $caseCh_col_arr["budget3"] = $res['3'];
      $caseCh_col_arr["budget4"] = $res['4'];
      $caseCh_col_arr["DEC"] = $res['12'];
      $caseCh_col_arr["type"] = 2;
    }

    $caseCh_col_arr["case_num"] = $res['num_year'];
    array_push($caseCh_arr,$caseCh_col_arr);
    $i++;
  }
  $data_array = array('total'=>2,'rows'=>$caseCh_arr,'sql'=>$sql);
  return json_encode($data_array);
}

function report_product($post){
  global $conn;
  $sql = 'SELECT p.prodType_id, p.prodType_name, COUNT( c.prodType_id ) as num_case
  FROM `Case` as c
  LEFT JOIN Product_Type as p USING(prodType_id)
  WHERE 1 AND c.prodType_id <> 0 
  ';

  $sql .= where_sql($post);
  $sql .= ' GROUP BY c.prodType_id ';

  // return $sql;
  $query_num = $conn->query($sql);
  $num = $query_num->num_rows;

  $sort = 'ORDER BY num_case DESC ';
  if($post->sort != ''){
    $sort = ' ORDER BY '.$post->sort.' '.$post->order.' ';
  }
  $sql .= $sort;
  $sql .= " LIMIT $post->offset , $post->limit ";
  $query = $conn->query($sql);
 
  $caseCh_arr = [];
  $i = 1;
 
  while ($res = $query->fetch_assoc()) {
    $caseCh_col_arr["id"] = 1 + $post->offset++;
    $caseCh_col_arr["prodType_name"] = $res['prodType_name'];
    $caseCh_col_arr["num_case"] = $res['num_case'];
    array_push($caseCh_arr,$caseCh_col_arr);
    $i++;
  }
  $data_array = array('total'=>$num,'rows'=>$caseCh_arr,'sql'=>$sql);
  return json_encode($data_array);
}

function report_country_thai($post){
  global $conn;
  $sql = 'SELECT co.id , co.name ,COUNT(c.applnt_country_id) as country_num
  FROM `Case` as c
  LEFT JOIN Country as co ON co.id = c.applnt_country_id
  WHERE 1 AND co.id IS NOT NULL
  AND c.complnt_country_id = "162"
  ';

  $sql .= where_sql($post);
  $sql .= ' GROUP BY applnt_country_id ';
  $query_num = $conn->query($sql);
  $num = $query_num->num_rows;

  $sort = ' ORDER BY country_num DESC ';
  if($post->sort != ''){
    $sort = ' ORDER BY '.$post->sort.' '.$post->order.' ';
  }
  $sql .= $sort;
  $sql .= " LIMIT $post->offset , $post->limit ";
  $query = $conn->query($sql);
 
  $caseCh_arr = [];
  $i = 1;
 
  while ($res = $query->fetch_assoc()) {
    $caseCh_col_arr["id"] = 1 + $post->offset++;
    $caseCh_col_arr["name_th"] = $res['name'];
    $caseCh_col_arr["country_num"] = $res['country_num'];
    array_push($caseCh_arr,$caseCh_col_arr);
    $i++;
  }
  $data_array = array('total'=>$num,'rows'=>$caseCh_arr,'sql'=>$sql);
  return json_encode($data_array);
}


function where_sql ($post){
  if($post->year_set_1 =="1"){
    if($post->date_start == ""){
      if($post->month_issue_th == ""){
        if($post->quarter == ""){
          if($post->issue_year_th == ""){
            $where_date = "";
          }else {
            if($post->year_set_2 == "2"){
              $year = $post->issue_year_th;
              $year_start = ($year-1)."-10-01";
              $year_end = $year."-09-30";
              $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
            }else {
              $year = $post->issue_year_th;
              $year_start = $year."-01-01";
              $year_end = $year."-12-31";
              $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
            }
          }
        }else {
          $year = $post->issue_year_th;
          if($post->quarter == "1"){
            $year_start = $year."-01-01";
            $year_end = $year."-03-31";
            $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
          }elseif ($post->quarter == "2") {
            $year_start = $year."-04-01";
            $year_end = $year."-06-30";
            $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
          }elseif ($post->quarter == "3") {
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
        $year = $post->issue_year_th;
        $month = $post->month_issue_th;
        $year_start = $year."-".$month."-01";
        $year_end = $year."-".$month."-31";
        $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
      }
    }else {
      if($post->date_stop == ""){
        $year = $post->issue_year_th;
        $month = $post->month_issue_th;
        $date_start = $post->date_start;

        $date_time = $date_start;
        $date_time_ex = explode(" ",$date_time);
        $date_re = $date_time_ex[0];
        $date_ex = explode("/",$date_re);
        $date_rx_year = $date_ex[2]-543;
        $date_start_ex= $date_rx_year."-".$date_ex[1]."-".$date_ex[0];

        $year_start = $date_start_ex;
        $where_date = " AND (c.case_create_datetime >= '".$year_start."')";
      }else {
        $year = $post->issue_year_th;
        $month = $post->month_issue_th;
        $date_start = $post->date_start;
        $date_stop = $post->date_stop;

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
    if($post->date_start == ""){
      if($post->month_issue_en == ""){
        if($post->quarter == ""){
          if($post->issue_year_en == ""){
            $where_date = "";
          }else {
            if($post->year_set_2 == "2"){
              $year = $post->issue_year_en;
              $year_start = ($year-1)."-10-01";
              $year_end = $year."-09-30";
              $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
            }else {
              $year = $post->issue_year_en;
              $year_start = $year."-01-01";
              $year_end = $year."-12-31";
              $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
            }

          }
        }else {
          $year = $post->issue_year_en;
          if($post->quarter == "1"){
            $year_start = $year."-01-01";
            $year_end = $year."-03-31";
            $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
          }elseif ($post->quarter == "2") {
            $year_start = $year."-04-01";
            $year_end = $year."-06-30";
            $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
          }elseif ($post->quarter == "3") {
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
        $year = $post->issue_year_en;
        $month = $post->month_issue_en;
        $year_start = $year."-".$month."-01";
        $year_end = $year."-".$month."-31";
        $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
      }
    }else {
      if($post->date_stop == ""){
        $year = $post->issue_year_en;
        $month = $post->month_issue_en;
        $date_start = $post->date_start;

        $date_time = $date_start;
        $date_time_ex = explode(" ",$date_time);
        $date_re = $date_time_ex[0];
        $date_ex = explode("/",$date_re);
        $date_start_ex= $date_ex[2]."-".$date_ex[1]."-".$date_ex[0];

        $year_start = $date_start_ex;
        $where_date = " AND (c.case_create_datetime >= '".$year_start."')";
      }else {
        $year = $post->issue_year_en;
        $month = $post->month_issue_en;
        $date_start = $post->date_start;
        $date_stop = $post->date_stop;

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

  if($post->compType_id == ""){
    $where_comp = "";
  }else {
    $where_comp = " AND c.compType_id = $post->compType_id";
  }

  if($post->office_id == ""){
    $where_office = "";
  }else {
    $where_office = " AND c.office_id = $post->office_id";
  }

  if($_SESSION['admin']['empSection'] == "1"){
    if($post->prodType_id == ""){
      $where_prod = "";
    }else {
      $sql_pro = "SELECT * FROM Product_Type WHERE prodType_id = '$post->prodType_id'";
      $query_pro = $conn->query($sql_pro);
      $re = $query_pro->fetch_assoc();


      $pro =  getProdType($re['prodType_level'],null,$post->prodType_id);

      if(join(',',$pro) == ""){
        $inpro = "''";
      }else {
        $inpro = join(',',$pro);
      }
      $where_prod = " AND c.prodType_id IN (".$inpro.")";

      // $where_prod = " AND (c.prodType_id = $post->prodType_id OR pt.prodType_ref_id = $post->prodType_id)";
    }
  }else {
    if($post->prodType_id == ""){
      $where_prod = "";
    }else {
      $where_prod = " AND c.incType_id = $post->prodType_id";
    }
  }

  if($post->caseCh_id == ""){
    $where_caseCh = "";
  }else {
    $where_caseCh = " AND (c.caseCh_id = $post->caseCh_id OR ch.caseCh_ref_id = $post->caseCh_id)";
  }

  if($post->Country_applnt == ""){
    $whereCountry_applnt = "";
  }else {
    $whereCountry_applnt = " AND c.applnt_country_id = $post->Country_applnt";
  }

  if($post->Country_complnt == ""){
    $whereCountry_complnt = "";
  }else {
    $whereCountry_complnt = " AND c.complnt_country_id = $post->Country_complnt";
  }

  if($post->member_comp_type == ""){
    $wheremembe = "";
  }else {
    $wheremembe = " AND c.applnt_valid_ditp = $post->member_comp_type";
  }

  $sql = $where_date.$where_comp.$where_office.$where_prod.$where_caseCh.$whereCountry_applnt.$whereCountry_complnt;

  return $sql;
}

?>
