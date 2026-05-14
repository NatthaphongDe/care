<?php include("../config/config.php"); ?>
<?php include("class/main.class.php"); ?>
<?php include("class/employee.class.php"); ?>
<?php include("class/case.class.php"); ?>
<?php include("class/send_email.class.php"); ?>

<?php


function alert_bot(){

  $caseLst_cls = new case_list();
  $emp_cls = new member_base();

  $caseLst_cls->setting_info();

  $sql_case = "SELECT * ";
  $sql_case .= "FROM `Case_Assign` asign ";
  $sql_case .= "LEFT JOIN `Case` c ON (c.case_id=asign.case_id) ";
  $sql_case .= "WHERE c.case_status='2' AND asign.caseAsign_status = '0' ";

  $sql_case_search = $sql_case;
  $query_case_search = $caseLst_cls->dbConn->query($sql_case_search);

  $send_case_main = array();
  $send_case_sub = array();
  $mail = new email();
  while($rs_case_list = $query_case_search->fetch_assoc()){
    $caseLst_cls->case_id = $rs_case_list["case_id"];
    $rs_case = $caseLst_cls->get_case_process_data();


      $datatime_diff = array();
      $datatime_diff = $caseLst_cls->getDateTimeData(date("Y-m-d 00:00:00",strtotime($rs_case_list["case_opened_datetime"])),date('Y-m-d 00:00:00',time()));

      if($datatime_diff["days"]<0){
        $datatime_diff["days"] = 0;
      }
      $dataSend = array();
      // echo $dif_work_day = (int)$rs_case_list["case_compType_duration"]-(int)$datatime_diff["days"];
      // echo "<br />";
      if($datatime_diff["days"]>0 && $rs_case_list["case_opened_datetime"]!="" && $dif_work_day>0 && $dif_work_day<=(int)$caseLst_cls->overdueMain_alert_period){
        $rs_emp = $emp_cls->emp_get_detail($rs_case_list["emp_id"]);
        $mail->to_email = array($rs_emp["emp_email"]);
        $mail->to_name = array($rs_emp["emp_firstname"]." ".$rs_emp["emp_lastname"]);
        $mail->Subject =  "แจ้งเตือนก่อนเกินกำหนดเวลาเรื่องร้องเรียน ID:".sprintf("%05d",$rs_case_list["case_id"])." - ".$rs_case_list["caseDtl_title"];
        if(($dif_work_day+1)>0){
          $mail->message =  "เนื่องจากเรื่องร้องเรียน ID:".sprintf("%05d",$rs_case_list["case_id"])." - ".$rs_case_list["caseDtl_title"]." จะครบกำหนดระยะเวลาการทำงานในอีก ".($dif_work_day+1)." วัน
                              ระบบจึงส่งอีเมลมาเพื่อแจ้งเตือนให้ท่านทราบ เพื่อเข้าไปดำเนินการตามขั้นตอนต่อไป ";
        }else if(($dif_work_day+1)==0){
          $mail->message =  "เนื่องจากเรื่องร้องเรียน ID:".sprintf("%05d",$rs_case_list["case_id"])." - ".$rs_case_list["caseDtl_title"]." ได้เกินกำหนดระยะเวลาการทำงานแล้ว
                              ระบบจึงส่งอีเมลให้ท่านเพื่อแจ้งเตือนให้ท่านทราบ เพื่อเข้าไปดำเนินการตามขั้นตอนต่อไป ";
        }else if(($dif_work_day+1)<0){
          $mail->message =  "เนื่องจากเรื่องร้องเรียน ID:".sprintf("%05d",$rs_case_list["case_id"])." - ".$rs_case_list["caseDtl_title"]." ได้เกินกำหนดระยะเวลาการทำงาน ".($dif_work_day*(-1))." วันแล้ว
                              ระบบจึงส่งอีเมลให้ท่านเพื่อแจ้งเตือนให้ท่านทราบ เพื่อเข้าไปดำเนินการตามขั้นตอนต่อไป ";
        }
        $mail->message .= "หากต้องการเข้าไปดำเนินการ กรุณาคลิกที่นี้ <a href=\"http://".$_SERVER["HTTP_HOST"]."/backoffice/index.php?page=case_detail&caseId=".$rs_case_list["case_id"]."\">http://".$_SERVER["HTTP_HOST"]."/backoffice/index.php?page=case_detail&caseId=".$rs_case_list["case_id"]."</a>";

        $sendMail = $mail->send_email();
      }
      foreach ($rs_case["case_process"] as $case_process) {


        $time_over = $case_process["process_over_datetime"];
        if($case_process["process_complete_datetime"]!=""){
          $time_compare = strtotime($case_process["process_complete_datetime"]);
        }else{
          $time_compare = time();
        }

        if($time_compare>$time_over){
          if(!in_array($send_case_sub,$rs_case_list["case_id"])){
            array_push($send_case_sub,$rs_case_list["case_id"]);
            $rs_emp = $emp_cls->emp_get_detail($rs_case_list["emp_id"]);
            $mail->to_email = array($rs_emp["emp_email"]);
            $mail->to_name = array($rs_emp["emp_firstname"]." ".$rs_emp["emp_lastname"]);
            $mail->Subject =  "แจ้งเตือนก่อนเกินกำหนดเวลากระบวนการ".$case_process["process_type_name"]."ของเรื่องร้องเรียน ID:".sprintf("%05d",$rs_case_list["case_id"])." - ".$rs_case_list["caseDtl_title"];
            if(($dif_work_day+1)>0){
              $mail->message =  "เนื่องจากกระบวนการ".$case_process["process_type_name"]."ของเรื่องร้องเรียน ID:".sprintf("%05d",$rs_case_list["case_id"])." - ".$rs_case_list["caseDtl_title"]." จะครบกำหนดระยะเวลาการทำงานในอีก ".($dif_work_day+1)." วัน
                                  ระบบจึงส่งอีเมลมาเพื่อแจ้งเตือนให้ท่านทราบ เพื่อเข้าไปดำเนินการตามขั้นตอนต่อไป ";
            }else if(($dif_work_day+1)==0){
              $mail->message =  "เนื่องจากกระบวนการ".$case_process["process_type_name"]."ของเรื่องร้องเรียน ID:".sprintf("%05d",$rs_case_list["case_id"])." - ".$rs_case_list["caseDtl_title"]." ได้เกินกำหนดระยะเวลาการทำงานแล้ว
                                  ระบบจึงส่งอีเมลให้ท่านเพื่อแจ้งเตือนให้ท่านทราบ เพื่อเข้าไปดำเนินการตามขั้นตอนต่อไป ";
            }else if(($dif_work_day+1)<0){
              $mail->message =  "เนื่องจากกระบวนการ".$case_process["process_type_name"]."ของเรื่องร้องเรียน ID:".sprintf("%05d",$rs_case_list["case_id"])." - ".$rs_case_list["caseDtl_title"]." ได้เกินกำหนดระยะเวลาการทำงาน ".($dif_work_day*(-1))." วันแล้ว
                                  ระบบจึงส่งอีเมลให้ท่านเพื่อแจ้งเตือนให้ท่านทราบ เพื่อเข้าไปดำเนินการตามขั้นตอนต่อไป ";
            }
            $mail->message .= "หากต้องการเข้าไปดำเนินการ กรุณาคลิกที่นี้ <a href=\"http://".$_SERVER["HTTP_HOST"]."/backoffice/index.php?page=case_detail&caseId=".$rs_case_list["case_id"]."\">http://".$_SERVER["HTTP_HOST"]."/backoffice/index.php?page=case_detail&caseId=".$rs_case_list["case_id"]."</a>";
            $sendMail = $mail->send_email();
          }
        }
      }
  }

  mysqli_close($caseLst_cls->dbConn);
}
alert_bot();
?>
