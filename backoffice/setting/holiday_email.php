<?php include("../../config/config.php");
require_once "../class/PHPMailer-5.2.5/class.phpmailer.php";

$y = date("Y-m-d");
// $y = "2017-11-10";

// เชควันหยุดเสาอาทิตย์
$strStartDate = $y;
$DayOfWeek = date("w", strtotime($strStartDate));
		if($DayOfWeek == 0 or $DayOfWeek ==6)  // 0 = Sunday, 6 = Saturday;
		{
      exit();
		}
  // เชควันหยุดที่ฐานข้อมูล
$sql_day = " SELECT * FROM `PublicHoliday` WHERE `holiday_date_start` >= '$strStartDate' AND `holiday_date_end` <= '$strStartDate' ";
$query_day = $conn->query($sql_day);
    if($query_day->num_rows > 0){
      exit();
    }
$y_1 = date("Y");

$sql_holiday = " SELECT holiday_name FROM PublicHoliday WHERE holiday_year = '".((int)$y_1+1)."' AND holiday_status = '0' ";
$query_holiday = $conn->query($sql_holiday);
if($query_holiday->num_rows < 1){
  $sql_count = "SELECT hd_setting FROM Setting_Info ";
  $query_count = $conn->query($sql_count);
  while ( $re_count =   $query_count->fetch_assoc()) {
    $year =($y)."-12-31";
    $bl_php =  "-".$re_count['hd_setting']." month";
    // วันที่ต้องส่ง
    $datedate = date ("Y-m-d", strtotime($bl_php, strtotime($year)));

    // วันปัจจุบัน
    $date_present1 = $y;
    // สิ้นปี
    $year =($y_1)."-12-31";
    // วันที่เหลือ
    $day_s = (strtotime($year) - strtotime($date_present1) ) / ( 60 * 60 * 24 );
    $d1 = new DateTime($date_present1);
    $d2 = new DateTime($year);
    // จำนวนเดือนที่เหลือ
    $interval = $d2->diff($d1);
    if($day_s <=30){
      $day_mail =  $day_s." วัน";
    }else{
      $day_mail =  $interval->format('%m เดือน');

    }
  }
}else{
  exit();
}


if( $y > $datedate){

// echo date('m/d/Y', $time_end);
$sql_ch = " SELECT empGroup_id FROM `Employee_Group_Permission` WHERE `page_id` = 31 ";
 $query_ch = $conn->query($sql_ch);
 if($query_ch->num_rows > 0){
    while ($re = $query_ch->fetch_assoc()) {
      $sql_name = " SELECT emp_firstname,emp_lastname,emp_email,emp_id FROM `Employee` WHERE `empGroup_id` = '".$re['empGroup_id']."' ";
      $query_name = $conn->query($sql_name);
        if($query_name->num_rows > 0){
           while ($re_name = $query_name->fetch_assoc()) {

       $emp_email = $re_name['emp_email'];
			 $form_emil = "ditpcare@ditp.go.th";
       $namesent = $re_name['emp_firstname']."   ".$re_name['emp_lastname'];

           $url = $_SERVER['HTTP_HOST']."/backoffice/setting/index.php?page=holiday";


					 $message ="
					 <div class=\"wrapper\" style=\"width:860px;background: #f8f8f8;\">
														 <div class=\"header\" style=\"width:auto\">
														 <img src=\"http://".$_SERVER["HTTP_HOST"]."/img/header_email.png\" srtlw=\"width:100%; height:auto;\" />
														 <div>
														 <div class=\"content\" style=\"width:auto; height:auto; font-family: Tahoma, Verdana, Segoe, sans-serif; font-size:16px;\">
														 <div style=\"padding: 20px;color:#000;\">
													   สวัสดีคุณ ".$namesent."
														 <br>กรุณาตั้งค่าวันหยุดราชการเหลือเวลาอีก ".$day_mail." ในการตั้งค่าวันหยุดราชการ ถ้าคุณต้องการตั้งค่าวันหยุด กรุณาคลิกที่ลิงค์ด้านล่าง
														 <br>
														 <br>
														 <br>
														 <br>
														 <div style=\"text-align:center;color:#000;\">
												 		<a href=\"$url\" style=\"background:#22A180;color:#fff;padding: 15px 50px;text-align:center;text-decoration: none;border-radius:25px\" target=\"_blank\" >ตั้งค่าวันหยุด</a>
												 		</div>
														 <br>
														 <br>
														 <br>

														 <br>
														 </div>
														 <hr style=\"border-color:#fefefe; margin:0px;\" />
																<div class=\"footer\" style=\"width:auto; height:auto; padding:20px; font-family: Tahoma, Verdana, Segoe, sans-serif; font-size:16px;\">
																	ขอบคุณ.<br />
																	ทีมงาน <a href=\"http://".$_SERVER["HTTP_HOST"]."\" target=\"blank\">".$_SERVER["HTTP_HOST"]."</a>
																</div>
															</div>
					 ";

          $send_email_fnc = sendEmail($form_emil,"DITP Care",array($emp_email),array($namesent),"ตั้งค่าวันหยุดราชการ DITP Care",$message);

          if($send_email_fnc=='1'){
             $upd = "INSERT INTO `Log_Email_Holiday`( `emp_id`, `leh_status`,leh_date,emp_email) VALUES ('".$re_name['emp_id']."','1','".date("Y-m-d h:i:sa")."','$emp_email')";
             $query_upd = $conn->query($upd);
            // echo "1";
          }else{
            $upd = "INSERT INTO `Log_Email_Holiday`( `emp_id`, `leh_status`,leh_date,emp_email) VALUES ('".$re_name['emp_id']."','2','".date("Y-m-d h:i:sa")."','$emp_email')";
            $query_upd = $conn->query($upd);
            // echo "0";
          }
        }
      }
    }
  }
}


   function sendEmail($from_email,$from_name,$to_email,$to_name,$subject,$message){
     global $dbConnection;
    $body = $message;
    try {
     $mail = new PHPMailer(true);
     $mail->CharSet = "utf-8";
     $mail->IsSMTP();
     $mail->SMTPDebug = 0;
		 $mail->SMTPAuth = true;
		 $mail->SMTPSecure = "ssl";	// sets the prefix to the servier
		 $mail->Host = "mailrelay.uc-workd.com"; // SMTP server 203.150.62.22
		 $mail->Port = 465; // พอร์ท
		 $mail->Username = "ditpcare@ditp.go.th"; // account SMTP
		 $mail->Password = 'NzMxQzVFMjANzQ3MSRUE0UIxN0MNUQwMTBCNENDQzkw'; // รหัสผ่าน SMTP

     $mail->SetFrom($from_email, $from_name);
     $mail->AddReplyTo($from_email, $from_name);
     $mail->Subject = $subject;
     $mail->MsgHTML($body);
     $toEmail= $to_email;
     $toName = $to_name;
     $i=0;
     foreach($toEmail as $toEmail_add){
      //echo $toEmail_add." ".$toName[$i]."<br>";
      $mail->AddAddress($toEmail_add,$toName[$i]);
      $i++;
     }
     if(!$mail->Send()) {
      $json = '0';
     } else {
        $json = '1';
     }
    } catch (phpmailerException $e) {
        $json = '0';
    } catch (Exception $e) {
        $json = '0';
    }
    return $json;
   }

 ?>
