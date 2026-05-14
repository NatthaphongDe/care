<?php
include('../config/config.php');

ini_set('display_errors', 1);
header('Content-Type: text/html; charset=utf-8');
require_once "lib/PHPMailer-5.2.5/class.phpmailer.php";

function sendEmail($from_email,$from_name,$to_email,$to_name,$subject,$message){
    $output = "" ;
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
  
     $mail->IsHTML(true);
     $mail->SetFrom($from_email, $from_name);
     $mail->AddReplyTo($from_email, $from_name);
     $mail->Subject = $subject;
  
     $mail->MsgHTML($body);
  
       $mail->AddAddress($to_email,$to_name);
  
     if(!$mail->Send()) {
       $status_response = "02";
       $status_response_text = "Mailer Error!: " . $mail->ErrorInfo;
     } else {
        $output = "00" ;
       $status_response_text="Message sent ;)";
     }
   } catch (phpmailerException $e) {
   } catch (Exception $e) {
   }
   return $output.$status_response_text;
  }
  function random_password( $length = 10 ) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOP1234567890";
    $password = substr( str_shuffle( $chars ), 0, $length );
    return $password;
   }

  $to_email = "sirilak@milott.co.th";
  $passwors = random_password();
  $to_name = "เจ้าหน้าที่ของ DITP Care";
  $from_email = "ditpcare@ditp.go.th";
  $from_name = "DITP Care";
  $subject = "กรุณายืนยันการสมัครสมาชิก DITP Care";
  $password_hash = "$2a$10$552c347a087f92f7e80bdeye5k0e9wgRzmQAVwdtRiocEqJiNSgW6";
  $url = $_SERVER['HTTP_HOST']."/frontend/conf_reg.php?conf=$password_hash";
  $message = " <div class=\"wrapper\" style=\"width:860px;background: #f8f8f8;\">
                <div class=\"header\" style=\"width:auto\">
                <img src=\"http://".$_SERVER["HTTP_HOST"]."/img/header_email.png\" srtlw=\"width:100%; height:auto;\" />
                <div>
                <div class=\"content\" style=\"width:auto; height:auto; font-family: Tahoma, Verdana, Segoe, sans-serif; font-size:16px;\">
                <div style=\"padding: 20px;color:#000;\">
                ".$namesent."
                <br>
                <br>
                ".$_SERVER['HTTP_HOST']." ได้รับคำขอร้องจากเว็บไซต์ หากคุณต้องการยืนยันการสมัครสมาชิก
                <br>
                คลิกที่ลิงค์ด้านล่างนี้ เพื่อยืนยันการสมัครสมาชิกของคุณ :
                <br>
                <br>
                <br>
                <br>
                <div style=\"text-align:center;color:#000;\">
                <a href=\"http://".$url."\" style=\"background:#22A180;color:#fff;padding: 15px 50px;text-align:center;text-decoration: none;border-radius:25px\" target=\"_blank\" >ยืนยันสมัครสมาชิก</a>
                </div>
                <br>
                <br>
                <br>
                หากคุณไม่ได้ดำเนินการร้องขอนี้ โปรดอย่าสนใจอีเมลฉบับนี้ มั่นใจได้ว่าบัญชีสมาชิกของคุณจะปลอดภัยได้กับเรา
                <br>
                </div>
                <hr style=\"border-color:#fefefe; margin:0px;\" />
                   <div class=\"footer\" style=\"width:auto; height:auto; padding:20px; font-family: Tahoma, Verdana, Segoe, sans-serif; font-size:16px;\">
                     ขอบคุณ.<br />
                     ทีมงาน <a href=\"http://".$_SERVER["HTTP_HOST"]."\" target=\"blank\">".$_SERVER["HTTP_HOST"]."</a>
                   </div>
                 </div>";
        $mail =   sendEmail($from_email,$from_name,$to_email,$to_name,$subject,$message);
        print_r($mail );
?>