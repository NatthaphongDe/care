<?php
require_once "lib/PHPMailer-5.2.5/class.phpmailer.php";
function sendEmail($from_email,$from_name,$to_email,$to_name,$subject,$message){
  $output = "" ;
  $body = $message;
  try {
   $mail = new PHPMailer(true);
   $mail->CharSet = "utf-8";
   $mail->IsSMTP();
   $mail->SMTPDebug = 1;
   $mail->SMTPAuth = true;
   $mail->SMTPSecure = "tls";	// sets the prefix to the servier
   $mail->Host = "smtp.gmail.com"; // SMTP server
   $mail->Port = 465; // พอร์ท
   $mail->Username = ""; // account SMTP
   $mail->Password = ''; // รหัสผ่าน SMTP

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
 return $output;
}

$mail =   sendEmail('sudjai.s@ibusiness.co.th','Test','sudjai.s@ibusiness.co.th','Test Mail','ทดสอบระบบ','test mail message');
print_r($mail);
exit();
?>
