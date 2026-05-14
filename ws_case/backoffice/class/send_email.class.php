<?php
class email extends main{
  var $db;
  var $dbConn;
  var $from_email;
  var $from_name;
  var $to_email;
  var $to_name;
  var $subject;
  var $message;
  var $file_accept;


  public function __construct(){
    require_once "class/PHPMailer-5.2.5/class.phpmailer.php";
    global $db,$conn;
    $this->db = $db;
    $this->dbConn = $conn;
    $this->from_email = "ditpcare@ditp.go.th";
    $this->from_name = "DITP Care";
    $this->file_accept = array("jpg","jpeg","png","doc","docx","xls","xlsx","ppt","pptx","pdf","zip","rar");
  }


  public function send_email($post,$file){

    $status_response = "00";
    $status_response_text = "Not send!";


    $path_group = "mail_attach";
    $this->deleteDirectory("../data/$path_group/tmp/".$_SESSION["admin"]["empId"]);
    $file_name = array();
    for ($i=0; $i <= $post['count_fileattach']; $i++) {
      if($file["fileattach".$i]["name"]!=""){
        $ext = pathinfo($file["fileattach".$i]["name"], PATHINFO_EXTENSION);
        $new_filename = $file["fileattach".$i]["name"];
        $new_filepath = "data/$path_group/tmp/".$_SESSION["admin"]["empId"]."/".$new_filename;
        $file_name[$i] = $file["fileattach".$i]["name"];
        if(!in_array($ext,$this->file_accept)){
            $status_response = "02";
            $status_response_text = "รูปแบบไฟล์แนบไม่ถูกต้อง !";
        }else{


         if(!is_dir("../data/$path_group")){
           mkdir("../data/$path_group", 0775, true);
         }
         if(!is_dir("../data/$path_group/tmp")){
           mkdir("../data/$path_group/tmp", 0775, true);
         }
         if(!is_dir("../data/$path_group/tmp/".$_SESSION["admin"]["empId"])){
           mkdir("../data/$path_group/tmp/".$_SESSION["admin"]["empId"], 0775, true);
         }

         if(!(move_uploaded_file($file["fileattach".$i]["tmp_name"],"../".$new_filepath))){
             $status_response = "02";
             $status_response_text = "การอัพโหลดไฟล์แนบผิดพลาด";
         }
       }
      }
    }
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
  		//$mail->SMTPSecure = "ssl";	// sets the prefix to the servier
  		$mail->Host = "203.150.62.22"; // SMTP server
  		// $mail->Host = "outgoin.mail.go.th"; // SMTP server

  		$mail->Port = 25; // พอร์ท
      $mail->Username = "ditpcare@ditp.go.th"; // account SMTP
      $mail->Password = 'Ditp2017'; // รหัสผ่าน SMTP

      $mail->IsHTML(true);
  		$mail->SetFrom($this->from_email, $this->from_name);
  		$mail->AddReplyTo($this->from_email, $this->from_name);
  		$mail->Subject = $this->subject;

  		$mail->MsgHTML($body);
      for ($ifs=0; $ifs<$post['count_fileattach']; $ifs++) {
        $mail->AddAttachment("../data/$path_group/tmp/".$_SESSION["admin"]["empId"]."/".$file_name[$ifs],$file_name[$ifs]);
      }

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

    $sql_ins_msg_log = " INSERT INTO log_email (  status,msg,type  )   VALUES (  $dh , '".$html_message."',2 ) ";
    $qr_ins_msg_log = $this->dbConn->query($sql_ins_msg_log);


    return array('status_response' => $status_response,'status_response_text' => $status_response_text,'datetime'=>date('Y-m-d H:i:s'));
  }

  public function send_email_close_case($post, $case_id, $member_id) {
    $member_id = md5($member_id);
    // print_r($post);
    $html_message = '<div class="wrapper" style="width:860px; background: #f8f8f8;">

      <div class="content" style="width:auto; height:auto; padding:20px; font-family: Tahoma, Verdana, Segoe, sans-serif; font-size:16px;">
        <!-- ข้อความ -->
        สวัสดีค่ะ คุณ '.$post["applnt_firstname"].' '.$post["applnt_lastname"].' <br /> <br />
        &nbsp;&nbsp; ตามที่ท่านได้สอบถาม/ร้องเรียนในระบบบริหารจัดการเรื่องร้องเรียนและข้อพิพาททางการค้าระหว่างประเทศ (DITP CARE) หมายเลขเคส ('.$case_id.') นั้น DITP Service Center
        ได้ดำเนินการเรียบร้อยแล้ว ท่านสามารถตรวจสอบผลได้ที่ <a href="http://'.$_SERVER["HTTP_HOST"].'/frontend/index.php?page=appeal_detail&case_id='.$case_id.'&user_id='.$member_id.'" target="blank">care.ditp.go.th</a>   <br /> <br />

        อีเมลฉบับนี้เป็นการแจ้งข้อมูลจากระบบอัตโนมัติ กรุณาอย่าตอบกลับ หากท่านมีข้อสงสัยหรือต้องการสอบถามรายละเอียดเพิ่มเติม กรุณาติดต่อตามเบอร์โทรศัพท์ที่ได้ให้ไว้ด้านล่าง  <br /> <br />
      </div>

      <div class="content" style="width:auto; height:auto; padding:20px; font-family: Tahoma, Verdana, Segoe, sans-serif; font-size:16px; color: #999999">
        <!-- ข้อความ -->
        DITP Service Center 1169 & DITP Care Team <br />
        สำนักสารสนเทศและการบริการการค้าระหว่างประเทศ <br />
        กรมส่งเสริมการค้าระหว่างประเทศ (DITP) <br />
        Tel. (+66) 2507 - 8247 / 8257 <br />
        <a href="https://bit.ly/3kiXy7K" target="blank">Facebook</a> | <a href="https://line.me/ti/p/@fom5198h" target="blank">LINE</a> | <a href="https://ditp.go.th/" target="blank">Website</a>  <br />
      </div>


      <hr style="border-color:#fefefe; margin:0px;" />

      <div class="footer" style="width:auto; height:auto; padding:20px; font-family: Tahoma, Verdana, Segoe, sans-serif; font-size:16px; text-align: center;">
        <img src="http://care.ditp.go.th/img/footer_email.png" srtlw="width:100%; height:auto;" />
      </div>
    </div>';
    $body = $html_message;
    $from_email = 'ditpcare@ditp.go.th';
    $from_name = 'ditp care';
    $to_email = $post["applnt_email"];
    $to_name = $post["applnt_firstname"].' '.$post["applnt_lastname"];
    $subject = 'ผลการจัดการเรื่องร้องเรียนและข้อพิพาททางการค้าระหว่างประเทศ (DITP CARE)';
    try {
      $mail = new PHPMailer(true);
      $mail->CharSet = "utf-8";
      $mail->IsSMTP();
      $mail->SMTPDebug = 0;
      $mail->SMTPAuth = true;
      //$mail->SMTPSecure = "ssl";	// sets the prefix to the servier
      $mail->Host = "203.150.62.22"; // SMTP server
      // $mail->Host = "outgoin.mail.go.th"; // SMTP server

      $mail->Port = 25; // พอร์ท
      $mail->Username = "ditpcare@ditp.go.th"; // account SMTP
      $mail->Password = 'Ditp2017'; // รหัสผ่าน SMTP

      $mail->IsHTML(true);
      $mail->SetFrom($from_email, $from_name);
      $mail->AddReplyTo($from_email, $from_name);
      $mail->AddAddress($to_email, $to_name);
      $mail->Subject = $subject;

      $mail->MsgHTML($body);
      
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


    // print_r($post);
    return array('status_response' => $status_response,'status_response_text' => $status_response_text,'datetime'=>date('Y-m-d H:i:s'));
  }
}
?>
