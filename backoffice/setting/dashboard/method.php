<?php
include("../config/config.php");

function getHoliday($st_date,$en_date){
  $start = new DateTime($st_date);
  $end = new DateTime($en_date);
  $days = $start->diff($end, true)->days;
  $sundays = intval($days / 7) + ($start->format('N') + $days % 7 >= 7);
  $saturdays = intval($days / 6) + ($start->format('N') + $days % 6 >= 6);
  $holiday = $sundays+$saturdays;
  if($holiday>0){
  }

  return $holiday;
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

if(isset($_GET["method"]) && $_GET["method"]=="getchannel"){
  $post = array();
  $request_body = file_get_contents('php://input');
  $post = json_decode($request_body);
  $response = getchannel($post);
  echo $response;
  exit();
}


function getchannel($post){
  include("../config/config.php");


      if($post->input_case == 1 ){                                   //watt
        $status = " AND case_status in (0) ";
        $title ="Waiting Case ID";
      }else if($post->input_case == '' || $post->input_case == 2 ){  //new
        $status = " AND case_status in (1) ";
        $title ="New Case ID";
      }else if($post->input_case == 3 ){                             //padd
        $status = " AND case_status in (2) ";
        $title ="Pending Case ID";
      }else if($post->input_case == 4 ){                             //over
        $status = " AND case_status in (2,3) ";
        $title ="Overdue Case ID";
      }else if($post->input_case == 5 ){                             //close
        $status = " AND case_status in (3) ";
        $title ="Close Case ID";
      }

if($post->secrch_case=='0'){
      if($post->month_case !='' ){
        if($post->month_case=='1'){$mon = '-01-';}
        if($post->month_case=='2'){$mon = '-02-';  }
        if($post->month_case=='3'){$mon = '-03-';  }
        if($post->month_case=='4'){$mon = '-04-';}
        if($post->month_case=='5'){$mon = '-05-';}
        if($post->month_case=='6'){$mon = '-06-'; }
        if($post->month_case=='7'){$mon = '-07-';}
        if($post->month_case=='8'){$mon = '-08-';}
        if($post->month_case=='9'){$mon = '-09-';}
        if($post->month_case=='10'){$mon = '-10-';}
        if($post->month_case=='11'){$mon = '-11-';}
        if($post->month_case=='12'){ $mon = '-12-'; }
      }
       if($mon != ''){
         $date_1 = " AND case_receivedoc_date  like '%".$mon."%' ";
       }
      if($post->year_case !='' ){
          $y = ((int)$post->year_case)-543;
          $date_2 = " AND case_receivedoc_date  like '%".$y."%' ";
      }
}else{
  if($post->display_case==1){
    if($post->year_adv!=''){
        $y = $post->year_adv;
      $date_filter = " AND case_receivedoc_date  like '%".$y."%' ";
    }else if($post->month_adv!=''){
        if($post->month_case=='1'){$mon = '-01-';}
        if($post->month_case=='2'){$mon = '-02-';  }
        if($post->month_case=='3'){$mon = '-03-';  }
        if($post->month_case=='4'){$mon = '-04-';}
        if($post->month_case=='5'){$mon = '-05-';}
        if($post->month_case=='6'){$mon = '-06-'; }
        if($post->month_case=='7'){$mon = '-07-';}
        if($post->month_case=='8'){$mon = '-08-';}
        if($post->month_case=='9'){$mon = '-09-';}
        if($post->month_case=='10'){$mon = '-10-';}
        if($post->month_case=='11'){$mon = '-11-';}
        if($post->month_case=='12'){ $mon = '-12-'; }
        if($mon != ''){
          $date_filter = " AND case_receivedoc_date  like '%".$mon."%' ";
        }
    }else if($post->quarter!=''){
      if($post->quarter==1){
        $st = $issue_year."-01-01";
        $sp = $issue_year."-04-01";
        $date_filter = " AND case_receivedoc_date >= '$st'  AND case_receivedoc_date < '$sp' ";
      }else if($post->quarter==2){
        $st = $issue_year."-04-01";
        $sp = $issue_year."-07-01";
        $date_filter = " AND case_receivedoc_date >= '$st'  AND case_receivedoc_date < '$sp' ";
      }else if($post->quarter==3){
        $st = $issue_year."-07-01";
        $sp = $issue_year."-10-01";
        $date_filter = " AND case_receivedoc_date >= '$st'  AND case_receivedoc_date < '$sp' ";
      }else if($post->quarter==4){
        $st = $issue_year."-10-01";
        $sp = $issue_year."-12-31";
        $date_filter = " AND case_receivedoc_date >= '$st'  AND case_receivedoc_date < '$sp' ";
      }
    }else if($post->date_start!='' && $post->date_stop!=''){
      $startDate = $post->date_start;
      $stopDate = $post->date_stop;
      if($post->display_case==1){
        $startDateY = DateTime::createFromFormat('d/m/Y',($startDate))->format('Y');
        $stopDateY = DateTime::createFromFormat('d/m/Y',($stopDate))->format('Y');
        $startDateY = $startDateY-543;
        $stopDateY = $stopDateY-543;
        $startDate = DateTime::createFromFormat('d/m/Y',($startDate))->format('m/d');
        $stopDate = DateTime::createFromFormat('d/m/Y',($stopDate))->format('m/d');
        $startDateY =  $startDateY."/".$startDate;
        $stopDateY=  $stopDateY."/".$stopDate;
      }else{
        $startDateY = DateTime::createFromFormat('d/m/Y',($startDate))->format('Y/m/d');
        $stopDateY = DateTime::createFromFormat('d/m/Y',($stopDate))->format('Y/m/d');
      }
      $date_filter = " AND case_receivedoc_date >= '$startDateY'  AND case_receivedoc_date <= '$stopDateY' ";
    }
  }else{
    $issue_year = $post->year_adv;
    $st = $issue_year."-10-01";
    $issue_year = $issue_year +1;
    $sp = $issue_year."-09-30";
    $date_filter = " AND case_receivedoc_date >= '$st'  AND case_receivedoc_date <= '$sp' ";
  }
}


  $caseCh_arr = array();
  $array_padd = array();

  $sql_caseCh = "SELECT case_id,case_status,case_open_date,case_close_datetime,caseDtl_title,case_priority,compType_duration,case_opened_datetime
                  FROM `Case` as c
                  LEFT JOIN Complaint_Type as ct on  ct.compType_id = c.compType_id
                  WHERE 1  $status $date_filter $date_1 $date_2 ";
  if($post->sort=="id"){
    $sort_col = "case_id";
  }

    $sql_caseCh .= " ORDER BY $sort_col  $post->order ";
    // echo $sql_caseCh;
    $query_edit_pass_all = $conn->query($sql_caseCh);
    $query_edit_pass = $conn->query($sql_caseCh);
    while ($re = $query_edit_pass->fetch_assoc()) {

          $chk_time_close = getDateTimeData($re['case_opened_datetime'],$re['case_close_datetime']);
          if($chk_time_close['days'] > $re['compType_duration']){
            $status = "Overdue Main process";
            array_push($array_padd,$re['case_id']);

          }else {

            $sql_process = "SELECT
            p.case_id,
            p.process_type_id,
            pt.process_type_duration,
            p.process_over_datetime,
            p.process_complete_datetime,
            p.process_status
            FROM  `Process` as p
            left join Process_Type as pt on p.process_type_id =  pt.process_type_id
            WHERE  p.case_id =  '".$re['case_id']."'";
            $query_process = $conn->query($sql_process);
            $i_padding = 0;

            while ( $re_process =   $query_process->fetch_assoc()) {
              $time_over_x = $re_process["process_over_datetime"];
              if($re_process["process_status"]==1){
                $time_compare_x = strtotime($re_process["process_complete_datetime"]);
              }else{
                $time_compare_x = time();
              }
              if($time_compare_x > $time_over_x){
                $i_padding++;
                // echo $re_process['case_id']."<br>";

                array_push($array_padd,$re_process['case_id']);

              }else {
                $i_padding = 0;
              }
            }
          }
      }
$sql_Pending = "  SELECT * FROM  `Case` as a
                  left join  Complaint_Type on Complaint_Type.compType_id = a.compType_id
                  WHERE 1
                  AND  Complaint_Type.compType_section = '".$_SESSION["admin"]["empSection"]."'
                  $status $date_filter $date_1 $date_2  ";


 if($post->input_case == 3){
  //  echo "--3";
  if(join(',',$array_padd)==''){
    $array_check2 = "''";
  }else{
    $array_check2 = join(',',$array_padd);
  }

    $sql_Pending .= "AND case_id not in ('".$array_check2."') ";
 }else if($post->input_case == 4){
   if(join(',',$array_padd)==''){
     $array_check2 = "''";
   }else{
     $array_check2 = join(',',$array_padd);
   }

    $sql_Pending .=" AND case_id in ('".$array_check2."') " ;
 }else if($post->input_case == 5){
  //  echo "--5";
    if(join(',',$array_padd)==''){
      $array_check2 = "''";
    }else{
      $array_check2 = join(',',$array_padd);
    }
   $sql_Pending .=" AND case_id not in ('".$array_check2."') " ;
 }

  $sql_Pending .= " ORDER BY $sort_col  $post->order ";
  $query_Pending = $conn->query($sql_Pending);
  $num = $query_Pending->num_rows;
  $sql_Pending .= " LIMIT $post->offset , $post->limit ";
  $query_Pending = $conn->query($sql_Pending);
// echo $sql_Pending;
if($query_Pending->num_rows>0){
  while ($re_Pending = $query_Pending->fetch_assoc()) {
    $caseCh_col_arr = array();

        if($re_Pending['case_open_date']==null || $re_Pending['case_open_date'] == ''){
          $date_start ='-';
        }else{
          $date_start  = date("d/m/Y" , strtotime($re_Pending['case_open_date']));
        }
        if($re_Pending['case_close_datetime']==null || $re_Pending['case_close_datetime'] == ''){
          $date_stop ='-';
        }else{
          $date_stop  = date("d/m/Y" , strtotime($re_Pending['case_close_datetime']));
        }
        $sql_select = "SELECT casePrt_img_path  FROM Case_Priority where casePrt_id = '".$re_Pending['case_priority']."' ";
        $query_select = $conn->query($sql_select);
        $re_pic = $query_select->fetch_assoc();

        if(!file_exists('../../'.$re_pic['casePrt_img_path']) || $re_pic['casePrt_img_path']=='' ) {
        $pic = "<img src='setting/img/default_priority.png' alt='Smiley face' height='20' width='20' >";
        }else{
        $pic = '<img src="../'.$re_pic['casePrt_img_path'].'" alt="Smiley face" height="20" width="20" >';
        }

        $caseCh_col_arr["name"] = '<a href="index.php?page=case_detail&caseId='.$re_Pending['case_id'].'"><span class="txt_case">'.$title.' '.$re_Pending['case_id'].' - </span>
                                  <span class="txt_title">'.$re_Pending['caseDtl_title'].'</span> '.$pic.'<br>
                                  <span class="txt_start">Start : '.$date_start.' | Stop : '.$date_stop.' </span></a>';
        array_push($caseCh_arr,$caseCh_col_arr);
      }
    }

  $data_array = array('total'=>$num,'rows'=>$caseCh_arr);
  return json_encode($data_array);
}



if(isset($_GET["method"]) && $_GET["method"]=="getlogcase"){
  $post = array();
  $request_body = file_get_contents('php://input');
  $post = json_decode($request_body);
  $response = getlogcase($post);
  echo $response;
  exit();

}


function getlogcase ($post){
  include("../config/config.php");

  $caseCh_arr = array();
  $sql_caseCh = " SELECT  * FROM `Log_Case`
                  LEFT join `Case` as c on c.case_id = Log_Case.case_id
                  left join  Complaint_Type on Complaint_Type.compType_id = c.compType_id
                  left join Employee on Log_Case.emp_id = Employee.emp_id
                  WHERE 1
                  AND  Complaint_Type.compType_section = '".$_SESSION["admin"]["empSection"]."'
                  ";

  if($post->sort=="id"){
    $sort_col = "logCase_id";
  }
  if($post->filter_activity != ""){
    $sql_caseCh .= " AND logCase_type = '$post->filter_activity'";
  }


if($post->search_activity==0){
    if($post->month_activity !='' ){
      if($post->month_activity=='1'){$mon = '-01-';}
      if($post->month_activity=='2'){$mon = '-02-';  }
      if($post->month_activity=='3'){$mon = '-03-';  }
      if($post->month_activity=='4'){$mon = '-04-';}
      if($post->month_activity=='5'){$mon = '-05-';}
      if($post->month_activity=='6'){$mon = '-06-'; }
      if($post->month_activity=='7'){$mon = '-07-';}
      if($post->month_activity=='8'){$mon = '-08-';}
      if($post->month_activity=='9'){$mon = '-09-';}
      if($post->month_activity=='10'){$mon = '-10-';}
      if($post->month_activity=='11'){$mon = '-11-';}
      if($post->month_activity=='12'){ $mon = '-12-'; }
    }
     if($mon != ''){
       $sql_caseCh .= " AND logCase_datetime  like '%".$mon."%' ";
     }
     if($post->year_activity !='' ){
        $y = $post->year_activity;
        $sql_caseCh .= " AND logCase_datetime  like '%".$y."%' ";
      }
}else{
  $issue_year = $post->year;
  if($post->year_type_activity==1){
      if($post->month!=''){
        if($post->month=='1'){$mon = '-01-';}
        if($post->month=='2'){$mon = '-02-';  }
        if($post->month=='3'){$mon = '-03-';  }
        if($post->month=='4'){$mon = '-04-';}
        if($post->month=='5'){$mon = '-05-';}
        if($post->month=='6'){$mon = '-06-'; }
        if($post->month=='7'){$mon = '-07-';}
        if($post->month=='8'){$mon = '-08-';}
        if($post->month=='9'){$mon = '-09-';}
        if($post->month=='10'){$mon = '-10-';}
        if($post->month=='11'){$mon = '-11-';}
        if($post->month=='12'){ $mon = '-12-'; }
        if($mon != ''){
          $sql_caseCh .= " AND case_receivedoc_date  like '%".$mon."%' ";
        }
      }else if($post->select_quarter_chk_activity!=''){
        if($post->select_quarter_chk_activity==1){
          $st = $issue_year."-01-01";
          $sp = $issue_year."-04-01";
          $sql_caseCh .= " AND case_receivedoc_date >= '$st'  AND case_receivedoc_date < '$sp' ";
        }else if($post->select_quarter_chk_activity==2){
          $st = $issue_year."-04-01";
          $sp = $issue_year."-07-01";
          $sql_caseCh .= " AND case_receivedoc_date >= '$st'  AND case_receivedoc_date < '$sp' ";
        }else if($post->select_quarter_chk_activity==3){
          $st = $issue_year."-07-01";
          $sp = $issue_year."-10-01";
          $sql_caseCh .= " AND case_receivedoc_date >= '$st'  AND case_receivedoc_date < '$sp' ";
        }else if($post->select_quarter_chk_activity==4){
          $st = $issue_year."-10-01";
          $sp = $issue_year."-12-31";
          $sql_caseCh .= " AND case_receivedoc_date >= '$st'  AND case_receivedoc_date < '$sp' ";
        }
      }else  if($post->year!=''){
            $sql_caseCh .= " AND case_receivedoc_date  like '%".$issue_year."%' ";
      }else if($post->startDate_activity !='' && $post->stopDate_activity !=""){
        $startDate = $post->startDate_activity;
        $stopDate = $post->stopDate_activity;
        if($post->display_activity==1){
          $startDateY = DateTime::createFromFormat('d/m/Y',($startDate))->format('Y');
          $stopDateY = DateTime::createFromFormat('d/m/Y',($stopDate))->format('Y');
          $startDateY = $startDateY-543;
          $stopDateY = $stopDateY-543;
          $startDate = DateTime::createFromFormat('d/m/Y',($startDate))->format('m/d');
          $stopDate = DateTime::createFromFormat('d/m/Y',($stopDate))->format('m/d');
          $startDateY =  $startDateY."/".$startDate;
          $stopDateY=  $stopDateY."/".$stopDate;
        }else{
          $startDateY = DateTime::createFromFormat('d/m/Y',($startDate))->format('Y/m/d');
          $stopDateY = DateTime::createFromFormat('d/m/Y',($stopDate))->format('Y/m/d');
        }
        $sql_caseCh .= " AND case_receivedoc_date >= '$startDateY'  AND case_receivedoc_date <= '$stopDateY' ";
      }
  }else{

      $st = $issue_year."-10-01";
      $issue_year = $issue_year +1;
      $sp = $issue_year."-09-30";
      $sql_caseCh .= " AND case_receivedoc_date >= '$st'  AND case_receivedoc_date <= '$sp' ";
  }
}


  $sql_caseCh .= " ORDER BY $sort_col  $post->order ";
  $query_edit_pass_all = $conn->query($sql_caseCh);
  $num = $query_edit_pass_all->num_rows;
  $sql_caseCh .= " LIMIT $post->offset , $post->limit ";

  // echo   $sql_caseCh;
  $query_edit_pass = $conn->query($sql_caseCh);
  while ($re = $query_edit_pass->fetch_assoc()) {
    $caseCh_col_arr = array();


    if(!file_exists('../../'.$re['emp_img_path']) || $re['emp_img_path']=='' ) {
       $pic = '<div class="col-md-2 img_activ" style="background:url(setting/img/profile_emp-01.svg) no-repeat center; background-size:cover; margin-top: 5px;"></div>';
    }else{
      $pic = '<div class="col-md-2 img_activ" style="background:url(../'.$re['emp_img_path'].') no-repeat center; background-size:cover; margin-top: 5px;"></div>';
    }

     $ss= ($re["logCase_datetime"]!=""?date('d/m/Y h:i A', strtotime($re["logCase_datetime"])):"xx/xx/xxxx  xx:xx AM");

    $caseCh_col_arr["name"] = '
    <a href="index.php?page=case_detail&caseId='.$re['case_id'].'">'.$pic.'
        <div class="col-md-10" style="  display: inline-block;">
          <span class="txt_title">'.$re['emp_firstname'].'  '.$re['emp_lastname'].'</span>
          <span class=" txt_case"> '. $re['logCase_text']  .'   Case ID '.$re['case_id'].'</span><br>
          <span class="txt_start">'.$ss.'</span>
        </div>
    </a>';
    array_push($caseCh_arr,$caseCh_col_arr);
  }
  $data_array = array('total'=>$num,'rows'=>$caseCh_arr);
  return json_encode($data_array);
}

?>
