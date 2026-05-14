<?php

include("../../config/config.php");

//-- ฟังกชั่นหาวันหยุดระหว่างวันที่กำหนด--//
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
$month_case =  $_POST['month_case'];
$year_case =   $_POST['year_case'];
$secrch_case = $_POST['secrch_case'];
$startDate = $_POST['startDate'];
$stopDate = $_POST['stopDate'];
$month_issue = $_POST['month_issue'];
$select_quarter_chk = $_POST['select_quarter_chk'];
$issue_year = $_POST['issue_year'];
$year_type_case = $_POST['year_type_case'];

if($secrch_case==0){
  if($month_case !='' ){
    if($month_case=='1'){$mon = '-01-';}
    if($month_case=='2'){$mon = '-02-';}
    if($month_case=='3'){$mon = '-03-';}
    if($month_case=='4'){$mon = '-04-';}
    if($month_case=='5'){$mon = '-05-';}
    if($month_case=='6'){$mon = '-06-';}
    if($month_case=='7'){$mon = '-07-';}
    if($month_case=='8'){$mon = '-08-';}
    if($month_case=='9'){$mon = '-09-';}
    if($month_case=='10'){$mon = '-10-';}
    if($month_case=='11'){$mon = '-11-';}
    if($month_case=='12'){ $mon = '-12-';}
  }
  if($mon != ''){
    $case_d = " AND case_create_datetime  like '%".$mon."%' ";
  }
  if($year_case !='' ){
    $y = $year_case-543;
    $case_y .= " AND case_create_datetime  like '%".$y."%' ";
  }

}else if($secrch_case=='1'){
  if($year_type_case==1){
    if($startDate!='' && $stopDate !='' ){
      if($year_type_case==1){
        $startDateY = DateTime::createFromFormat('d/m/Y',($startDate))->format('Y');
        $stopDateY = DateTime::createFromFormat('d/m/Y',($stopDate))->format('Y');
        $startDateY = $startDateY-543;
        $stopDateY = $stopDateY-543;
        $startDate = DateTime::createFromFormat('d/m/Y',($startDate))->format('m/d');
        $stopDate = DateTime::createFromFormat('d/m/Y',($stopDate))->format('m/d');
        $startDateY =  $startDateY."/".$startDate;
        $stopDateY=  $stopDateY."/".$stopDate;
        // echo "11";
      }else {
        // echo "22";
        $startDateY = DateTime::createFromFormat('d/m/Y',($startDate))->format('Y/m/d');
        $stopDateY = DateTime::createFromFormat('d/m/Y',($stopDate))->format('Y/m/d');
      }
      $sql_se = " AND case_create_datetime >= '$startDateY'  AND case_create_datetime <= '$stopDateY' ";
    }else if($month_issue!=''){
      if($month_issue=='1'){$mon = '-01-';}
      if($month_issue=='2'){$mon = '-02-';}
      if($month_issue=='3'){$mon = '-03-';}
      if($month_issue=='4'){$mon = '-04-';}
      if($month_issue=='5'){$mon = '-05-';}
      if($month_issue=='6'){$mon = '-06-';}
      if($month_issue=='7'){$mon = '-07-';}
      if($month_issue=='8'){$mon = '-08-';}
      if($month_issue=='9'){$mon = '-09-';}
      if($month_issue=='10'){$mon = '-10-';}
      if($month_issue=='11'){$mon = '-11-';}
      if($month_issue=='12'){ $mon = '-12-';}
      $case_d = "AND case_create_datetime like '%".$issue_year.$mon."%'  ";
    }else if($select_quarter_chk !='' ){
      if($select_quarter_chk==1){
        $st = $issue_year."-01-01";
        $sp = $issue_year."-04-01";
        $sql_se = " AND case_create_datetime >= '$st'  AND case_create_datetime < '$sp' ";
      }else if($select_quarter_chk==2){
        $st = $issue_year."-04-01";
        $sp = $issue_year."-07-01";
        $sql_se = " AND case_create_datetime >= '$st'  AND case_create_datetime < '$sp' ";
      }else if($select_quarter_chk==3){
        $st = $issue_year."-07-01";
        $sp = $issue_year."-10-01";
        $sql_se = " AND case_create_datetime >= '$st'  AND case_create_datetime < '$sp' ";
      }else if($select_quarter_chk==4){
        $st = $issue_year."-10-01";
        $sp = $issue_year."-12-31";
        $sql_se = " AND case_create_datetime >= '$st'  AND case_create_datetime < '$sp' ";
      }

    }else if($issue_year != ''){
      $sql_se = "AND case_create_datetime like '%".$issue_year."%'  ";
    }
  }else{    // ปีงบประมาณ
    $st = ($issue_year-1)."-10-01";
    $issue_year = $issue_year;
    $sp = $issue_year."-09-30";
    $sql_se = " AND case_create_datetime >= '$st'  AND case_create_datetime <= '$sp' ";
  }
}

$sql_office = "";
if($_SESSION["admin"]["office"]!=0){
  $sql_office = " AND office_id = '".$_SESSION["admin"]["office"]."' ";
}
$sql_empSection = "";
if($_SESSION["admin"]["empSection"]!=0){
  $sql_empSection = "  AND  Complaint_Type.compType_section = '".$_SESSION["admin"]["empSection"]."' ";
}

?>
<div class="case waiting_case">
  <div class="case_st color_st_1 waiting_case" id="data_case_filter_1" onclick="data_case_filter(1);">
    <div class="case_st_box waiting_case">
      <div class="">
        <div class="user-image-bd"  id="img_activ_1" style="background:url(dashboard/img/icon_dashboard-waiting-01.svg) no-repeat center; background-size:cover; "></div>
      </div>
      <div class="">
        <span class="sp_txt_case" id="sp_txt_case_1">Waiting</span><br>
        <?php
        $sql_edit = " SELECT Count(case_status) AS case_status FROM  `Case` a
                      LEFT JOIN  Complaint_Type on Complaint_Type.compType_id = a.compType_id
                      WHERE case_status = 0
                      $sql_empSection 
                      $case_d $case_y $sql_se $sql_office";
        $query_edit = $conn->query($sql_edit);
        while ( $re_edit =   $query_edit->fetch_assoc()) {

          $Waiting = $re_edit['case_status'];
        }
        ?>
        <span class="sp_txt_case_num"><?=$Waiting;?></span>
      </div>
    </div>
  </div>
</div>


<div class="case">
  <div class="case_st color_st_1 hover_new" id="data_case_filter_2" onclick="data_case_filter(2);">
    <div class="case_st_box">
      <div class="">
        <div class="user-image-bd" id="img_activ_2" style="background:url(dashboard/img/icon_dashboard-new-01.svg) no-repeat center; background-size:cover; "></div>
      </div>
      <div class="">
        <span class="sp_txt_case"  id="sp_txt_case_2" >New</span><br>
        <?php
        $sql_empSection = '';
        if($_SESSION["admin"]["empSection"] != 0){
          $sql_empSection = " AND  Complaint_Type.compType_section = '".$_SESSION["admin"]["empSection"]."' ";
        }
        $sql_edit = "SELECT Count(case_status) AS case_status FROM  `Case` a
                      LEFT JOIN  Complaint_Type on Complaint_Type.compType_id = a.compType_id
                      WHERE case_status = 1
                      $sql_empSection 
                      $case_d $case_y  $sql_se  $sql_office";
                      
        $query_edit = $conn->query($sql_edit);
        while ( $re_edit =   $query_edit->fetch_assoc()) {

          $New = $re_edit['case_status'];
        }
        ?>
        <span class="sp_txt_case_num"><?=$New;?></span>
      </div>
    </div>
  </div>
</div>

<div class="case">
  <div class="case_st color_st_1 hover_pending" id="data_case_filter_3" onclick="data_case_filter(3);">
    <div class="case_st_box">
      <div class="">
        <div class="user-image-bd"  id="img_activ_3" style="background:url(dashboard/img/icon_dashboard-pending-01.svg) no-repeat center; background-size:cover; "></div>
      </div>
      <div class="">
        <span class="sp_txt_case"  id="sp_txt_case_3">In Process</span><br>
        <?php
        $array_padd = array();

        $sql_Pending = "SELECT c.case_id,c.case_opened_datetime,c.case_close_datetime,c.case_compType_duration,c.case_status  FROM  `Case` c
        LEFT JOIN Complaint_Type ct ON c.compType_id = ct.compType_id
        WHERE case_status = 2  $sql_caseCh $sql_office";
        $query_Pending = $conn->query($sql_Pending);
        $i_padding_num = 0;
        while ( $re_Pending =   $query_Pending->fetch_assoc()) {

          $chk_time_close = getDateTimeData($re_Pending['case_opened_datetime'],$re_Pending['case_close_datetime']);
          if($chk_time_close['days'] > $re_Pending['case_compType_duration']){
            $status = "Overdue Main process";
            array_push($array_padd,$re_Pending['case_id']);

          }else {

            $sql_process = "SELECT
            p.case_id,
            p.process_type_id,
            p.process_type_duration,
            p.process_over_datetime,
            p.process_complete_datetime,
            p.process_status
            FROM  `Process` p
            LEFT JOIN Process_Type pt on p.process_type_id =  pt.process_type_id
            WHERE  p.case_id =  '".$re_Pending['case_id']."'";
            $query_process = $conn->query($sql_process);
            $i_padding = 0;

            while ( $re_process =   $query_process->fetch_assoc()) {
              if($re_Pending["case_status"]=="2"){
                $datatime_diff = getDateTimeData(date("Y-m-d 00:00:00",strtotime($re_Pending["case_opened_datetime"])),date('Y-m-d 00:00:00',time()));
              }else if($re_Pending["case_status"]=="3"){
                $datatime_diff = getDateTimeData(date("Y-m-d 00:00:00",strtotime($re_Pending["case_opened_datetime"])),date("Y-m-d 00:00:00",strtotime($re_Pending["case_close_datetime"])));
              }

              if($datatime_diff["days"]<0){
                $datatime_diff["days"] = 0;
              }
              if($datatime_diff["days"]>0 && $re_Pending["case_opened_datetime"]!="" && $datatime_diff["days"]>$re_Pending["case_compType_duration"]){
                array_push($array_padd,$re_Pending["case_id"]);
              }
            }
          }
        }

        if(join(',',$array_padd)==''){
          $array_check2 = "''";
        }else{
          $array_check2 = join(',',$array_padd);
        }
        $sql_empSection = '';
        if($_SESSION["admin"]["empSection"] != 0){
          $sql_empSection = " AND  Complaint_Type.compType_section = '".$_SESSION["admin"]["empSection"]."' ";
        }

        $sql_Pending_1 = "SELECT * FROM  `Case` a
                          LEFT JOIN  Complaint_Type on Complaint_Type.compType_id = a.compType_id
                          WHERE case_status = 2
                          $sql_empSection
                          AND case_id NOT IN (".$array_check2.") $case_d $case_y $sql_se $sql_office";
        $query_Pending_1 = $conn->query($sql_Pending_1);
        $num_pad = $query_Pending_1->num_rows;
        if($num_pad == ""){
          $num_pedding = "0";
        }else {
          $num_pedding = $num_pad;
        }

        ?>
        <span class="sp_txt_case_num"><?=$num_pedding;?></span>
      </div>
    </div>
  </div>
</div>

<div class="case">
  <div class="case_st color_st_4 hover_overdue" id="data_case_filter_4" onclick="data_case_filter(4);">
    <div class="case_st_box">
      <div class="">
        <div class="user-image-bd"  id="img_activ_4" style="background:url(dashboard/img/icon_dashboard-overdue-01.svg) no-repeat center; background-size:cover; "></div>
      </div>
      <div class="">
        <span class="sp_txt_case"  id="sp_txt_case_4">Overdue</span><br>
        <?php
        $array_padd = array();
        $sql_Pending = "SELECT c.case_id,c.case_opened_datetime,c.case_close_datetime,c.case_compType_duration,c.case_status FROM  `Case` c
        LEFT JOIN Complaint_Type ct ON c.compType_id = ct.compType_id
        WHERE case_status IN (2,3)  $sql_caseCh";
        $query_Pending = $conn->query($sql_Pending);
        $i_padding_num = 0;
        while ( $re_Pending =   $query_Pending->fetch_assoc()) {
          $chk_time_close = getDateTimeData($re_Pending['case_opened_datetime'],$re_Pending['case_close_datetime']);
          if($chk_time_close['days'] > $re_Pending['case_compType_duration']){
            // $status = "Overdue Main process";
            array_push($array_padd,$re_Pending['case_id']);
          }else {
            $sql_process = "SELECT
            p.case_id,
            p.process_type_id,
            p.process_type_duration,
            p.process_over_datetime,
            p.process_complete_datetime,
            p.process_status
            FROM  `Process` p
            LEFT JOIN Process_Type pt on p.process_type_id =  pt.process_type_id
            WHERE  p.case_id =  '".$re_Pending['case_id']."'";
            $query_process = $conn->query($sql_process);
            $i_padding = 0;

            while ( $re_process =   $query_process->fetch_assoc()) {

              // main
              if($re_Pending["case_status"]=="2"){
                $datatime_diff = getDateTimeData(date("Y-m-d 00:00:00",strtotime($re_Pending["case_opened_datetime"])),date('Y-m-d 00:00:00',time()));
              }else if($re_Pending["case_status"]=="3"){
                $datatime_diff = getDateTimeData(date("Y-m-d 00:00:00",strtotime($re_Pending["case_opened_datetime"])),date("Y-m-d 00:00:00",strtotime($re_Pending["case_close_datetime"])));
              }
              if($datatime_diff["days"]<0){
                $datatime_diff["days"] = 0;
              }
              if($datatime_diff["days"]>0 && $re_Pending["case_opened_datetime"]!="" && $datatime_diff["days"]>$re_Pending["case_compType_duration"]){
                array_push($array_padd,$re_Pending["case_id"]);
              }
            }
          }
        }


        if(join(',',$array_padd)==''){
          $array_check3 = "''";
        }else{
          $array_check3 = join(',',$array_padd);
        }

        $sql_empSection = '';
        if($_SESSION["admin"]["empSection"] != 0){
          $sql_empSection = " AND  Complaint_Type.compType_section = '".$_SESSION["admin"]["empSection"]."' ";
        }

        $sql_Pending_1 = "SELECT * FROM  `Case` a
                          LEFT JOIN  Complaint_Type on Complaint_Type.compType_id = a.compType_id
                          WHERE case_status IN (2,3)
                          $sql_empSection
                          AND case_id IN (".$array_check3.") $case_d $case_y $sql_se $sql_office";
        $query_Pending_1 = $conn->query($sql_Pending_1);
        $num_overdue = $query_Pending_1->num_rows;
        if($num_overdue == ""){
          $num_overdue = "0";
        }else {
          $num_overdue = $num_overdue;
        }
        ?>
        <span class="sp_txt_case_num"><?php echo $num_overdue; ?></span>
      </div>
    </div>
  </div>
</div>

<div class="case">
  <div class="case_st color_st_5 hover_close" id="data_case_filter_5" onclick="data_case_filter(5);">
    <div class="case_st_box">
      <div class="">
        <div class="user-image-bd"  id="img_activ_5" style="background:url(dashboard/img/icon_dashboard-close-01.svg) no-repeat center; background-size:cover; "></div>
      </div>
      <div class="">
        <span class="sp_txt_case"  id="sp_txt_case_5">Close</span><br>
        <?php
        $array_padd = array();
        $sql_Pending = "SELECT c.case_id,c.case_opened_datetime,c.case_close_datetime,c.case_compType_duration,c.case_status   FROM  `Case` c
        LEFT JOIN Complaint_Type ct ON c.compType_id = ct.compType_id
        WHERE case_status = 3  $sql_caseCh";
        $query_Pending = $conn->query($sql_Pending);
        $i_padding_num = 0;
        while ( $re_Pending =   $query_Pending->fetch_assoc()) {

          $chk_time_close = getDateTimeData($re_Pending['case_opened_datetime'],$re_Pending['case_close_datetime']);
          if($chk_time_close['days'] > $re_Pending['case_compType_duration']){
            $status = "Overdue Main process";
            array_push($array_padd,$re_Pending['case_id']);
          }else {
            $sql_process = "SELECT
            p.case_id,
            p.process_type_id,
            p.process_type_duration,
            p.process_over_datetime,
            p.process_complete_datetime,
            p.process_status
            FROM  `Process` p
            LEFT JOIN Process_Type pt on p.process_type_id =  pt.process_type_id
            WHERE  p.case_id =  '".$re_Pending['case_id']."'";
            $query_process = $conn->query($sql_process);
            $i_padding = 0;
            // echo $sql_process;
            while ( $re_process =   $query_process->fetch_assoc()) {

              if($re_Pending["case_status"]=="2"){
                $datatime_diff = getDateTimeData(date("Y-m-d 00:00:00",strtotime($re_Pending["case_opened_datetime"])),date('Y-m-d 00:00:00',time()));
              }else if($re_Pending["case_status"]=="3"){
                $datatime_diff = getDateTimeData(date("Y-m-d 00:00:00",strtotime($re_Pending["case_opened_datetime"])),date("Y-m-d 00:00:00",strtotime($re_Pending["case_close_datetime"])));
              }
              if($datatime_diff["days"]<0){
                $datatime_diff["days"] = 0;
              }
              if($datatime_diff["days"]>0 && $re_Pending["case_opened_datetime"]!="" && $datatime_diff["days"]>$re_Pending["case_compType_duration"]){
                array_push($array_padd,$re_Pending["case_id"]);
              }
            }
          }
        }
        // echo
        if(join(',',$array_padd)==''){
          $array_check4 = "''";
        }else{
          $array_check4 = join(',',$array_padd);
        }

        $sql_empSection = '';
        if($_SESSION["admin"]["empSection"] != 0){
          $sql_empSection = " AND  Complaint_Type.compType_section = '".$_SESSION["admin"]["empSection"]."' ";
        }
        $sql_Pending_1 = "SELECT * FROM  `Case` a
                          LEFT JOIN  Complaint_Type on Complaint_Type.compType_id = a.compType_id
                          WHERE case_status = 3
                          $sql_empSection
                          AND case_id NOT IN (".$array_check4.") $case_d $case_y $sql_se $sql_office ";
        $query_Pending_1 = $conn->query($sql_Pending_1);
        $num_close = $query_Pending_1->num_rows;
        // echo $sql_Pending_1;
        if($num_close == ""){
          $num_close = "0";
        }else {
          $num_close = $num_close;
        }
        ?>
        <span class="sp_txt_case_num"><?=$num_close;?></span>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">

    $(document).ready(function () {
      var son_id = $('#son_active').val();
      if(son_id==''){
        $('#data_case_filter_2').addClass('active_filter2');
        $('#img_activ_2').css('background','url(dashboard/img/icon_dashboard-new-02.svg) no-repeat center','background-size:cover;');
        $('#sp_txt_case_2').addClass('txt_ait');

      }else{
        $('#data_case_filter_'+son_id).addClass('active_filter'+son_id);
        $('#sp_txt_case_'+son_id).addClass('txt_ait');
        if(son_id=='1'){
          $('#img_activ_'+son_id).css('background','url(dashboard/img/icon_dashboard-waiting-02.svg) no-repeat center','background-size:cover;');
        }else if(son_id=='2'){
          $('#img_activ_'+son_id).css('background','url(dashboard/img/icon_dashboard-new-02.svg) no-repeat center','background-size:cover;');
        }else if(son_id=='3'){
          $('#img_activ_'+son_id).css('background','url(dashboard/img/icon_dashboard-pending-02.svg) no-repeat center','background-size:cover;');
        }else if(son_id=='4'){
          $('#img_activ_'+son_id).css('background','url(dashboard/img/icon_dashboard-overdue-02.svg) no-repeat center','background-size:cover;');
        }else if(son_id=='5'){
          $('#img_activ_'+son_id).css('background','url(dashboard/img/icon_dashboard-close-02.svg) no-repeat center','background-size:cover;');
        }
      }
    });
</script>
