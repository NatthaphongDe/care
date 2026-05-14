<?php


require_once "class/PHPMailer-5.2.5/class.phpmailer.php";

$from_email = "ditpcare@ditp.go.th";
$from_name = "DITP Care";

$html_message = '<div class="wrapper" style="width:860px; background: #f8f8f8;">
  <div class="header" style="width:auto">
    <img src="http://'.$_SERVER["HTTP_HOST"].'/img/header_email.png" srtlw="width:100%; height:auto;" />
  <div>
  <div class="content" style="width:auto; height:auto; padding:20px; font-family: Tahoma, Verdana, Segoe, sans-serif; font-size:16px;">
    <!-- ข้อความ -->
    ทดสอบส่งอีเมลล์ด้วย SMTP Gateway ของ DITP
  </div>
  <hr style="border-color:#fefefe; margin:0px;" />
  <div class="footer" style="width:auto; height:auto; padding:20px; font-family: Tahoma, Verdana, Segoe, sans-serif; font-size:16px;">
    ขอบคุณ.<br />
    ทีมงาน <a href="http://'.$_SERVER["HTTP_HOST"].'" target="blank">'.$_SERVER["HTTP_HOST"].'</a>
  </div>
</div>';

$body = $html_message;
try {
  $mail = new PHPMailer(true);
  $mail->CharSet = "utf-8";
  $mail->IsSMTP();
  $mail->SMTPDebug = 2;
  $mail->SMTPAuth = true;
  //$mail->SMTPSecure = "ssl";	// sets the prefix to the servier
  $mail->Host = "203.150.62.22"; // SMTP server
  // $mail->Host = "outgoin.mail.go.th"; // SMTP server

  $mail->Port = 25; // พอร์ท
  $mail->Username = "ditpcare@ditp.go.th"; // account SMTP
  $mail->Password = 'Ditp2017'; // รหัสผ่าน SMTP

  /*$mail->SMTPDebug = 0;
  $mail->SMTPAuth = false;
  //$mail->SMTPSecure = "tls";	// sets the prefix to the servier
  $mail->Host = "10.7.99.16"; // SMTP server
  $mail->Port = 25; // พอร์ท
  $mail->Username = "......."; // account SMTP*/

  $mail->IsHTML(true);
  $mail->SetFrom($from_email, $from_name);
  $mail->AddReplyTo($from_email, $from_name);
  $mail->Subject = 'ทดสอบส่งอีเมลล์ด้วย SMTP Gateway ของ DITP';

  $mail->MsgHTML($body);


  $toEmail= array('Santisook.s@ibusiness.co.th');
  $toName = array('Santisook.s');

  $i=0;
  foreach($toEmail as $toEmail_add){
    $toEmail_add = trim($toEmail_add);
    $mail->AddAddress($toEmail_add,$toName[$i]);
    $i++;
  }
  if(!$mail->Send()) {
    $status_response = "02";
    $status_response_text = "Mailer Error!: " . $mail->ErrorInfo;
  } else {
    $status_response = "00";
    $status_response_text="Message sent ;)";
    //$status_response_text = $file_name[$i];


  }
} catch (phpmailerException $e) {
  echo "IP Address (host) : ".$mail->Host."<br />";
  echo "Port : ".$mail->Port."<br />";
  echo "SMTP Auth : ".($mail->SMTPAuth==1?"true":"false")."<br />";
  echo "SMTP Secure : ".$mail->SMTPSecure."<br />";
  echo "Username : ".$mail->Username."<br />";
  echo "Password : ".$mail->Password."<br /><hr />";
  echo $e->errorMessage(); //Pretty error messages from PHPMailer
} catch (Exception $e) {
  echo "IP Address (host) : ".$mail->Host."<br />";
  echo "Port : ".$mail->Port."<br />";
  echo "SMTP Auth : ".$mail->SMTPAuth."<br />";
  echo "SMTP Secure : ".$mail->SMTPSecure."<br />";
  echo "Username : ".$mail->Username."<br />";
  echo "Password : ".$mail->Password."<br /><hr />";
  echo $e->getMessage(); //Boring error messages from anything else!
}



$res = array('status_response' => $status_response,'status_response_text' => $status_response_text,'datetime'=>date('Y-m-d H:i:s'));
//print_r($res);


?>
