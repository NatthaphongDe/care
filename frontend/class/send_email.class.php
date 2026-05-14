<?php
class email {
  var $from_email;
  var $from_name;
  var $to_email;
  var $to_name;
  var $subject;
  var $message;
  var $file_accept;


  public function __construct(){
    require_once "../lib/PHPMailer-5.2.5/class.phpmailer.php";
    $this->from_email = "ditpcare@ditp.go.th";
    $this->from_name = "DITP Care";
    $this->file_accept = array("jpg","jpeg","png","doc","docx","xls","xlsx","ppt","pptx","pdf","zip","rar");
    global $conn;
    $this->conn = $conn;
  }


  public function send_email($post,$file){

      $status_response = "00";
      $status_response_text = "Not send!";


      $path_group = "mail_attach";
      $html_message = '<div class="wrapper" style="width:860px; background: #f8f8f8;">
        <div class="header" style="width:auto">
          <img src="http://'.$_SERVER["HTTP_HOST"].'/img/header_email.png" srtlw="width:100%; height:auto;" />
        <div>
        <div class="content" style="width:auto; height:auto; padding:20px; font-family: Tahoma, Verdana, Segoe, sans-serif; font-size:16px;">
          <!-- ข้อความ -->
          '.$this->message.'
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
    		$mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";	// sets the prefix to the servier
        $mail->Host = "mailrelay.uc-workd.com"; // SMTP server 203.150.62.22

        // $mail->Host = "outgoin.mail.go.th"; // SMTP server
        $mail->Port = 465; // พอร์ท
        $mail->Username = "ditpcare@ditp.go.th"; // account SMTP
        $mail->Password = 'NzMxQzVFMjANzQ3MSRUE0UIxN0MNUQwMTBCNENDQzkw'; // รหัสผ่าน SMTP

        $mail->IsHTML(true);
    		$mail->SetFrom($this->from_email, $this->from_name);
    		$mail->AddReplyTo($this->from_email, $this->from_name);
    		$mail->Subject = $this->subject;

    		$mail->MsgHTML($body);

    		$toEmail= $this->to_email;
    		$toName = $this->to_name;

    		$i=0;
    		foreach($toEmail as $toEmail_add){
          $toEmail_add = trim($toEmail_add);
    			$mail->AddAddress($toEmail_add,$toName[$i]);
    			$i++;
    		}
        
        $mail->AddCC('ditpservicenter@gmail.com', 'ditpservicenter');

        $dh = 0;
    		if(!$mail->Send()) {
          $dh = 2;
          $status_response = "02";
          $status_response_text = "Mailer Error!: " . $mail->ErrorInfo;
    		} else {
          $dh = 1;
          $status_response = "00";
    			$status_response_text="Message sent ;)";
          //$status_response_text = $file_name[$i];
    		}
    	} catch (phpmailerException $e) {
    	  //echo $e->errorMessage(); //Pretty error messages from PHPMailer
    	} catch (Exception $e) {
    	  //echo $e->getMessage(); //Boring error messages from anything else!
    	}

      $sql_ins_msg_log = " INSERT INTO log_email (  status,msg,type  )   VALUES (  $dh , '".$html_message."',1 ) ";
      $qr_ins_msg_log = $this->conn->query($sql_ins_msg_log);

      return array('status_response' => $status_response,'status_response_text' => $status_response_text,'datetime'=>date('Y-m-d H:i:s'));
    }
}
?>
