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
  		$mail->SMTPSecure = "ssl";	// sets the prefix to the servier
  		$mail->Host = "smtp.gmail.com"; // SMTP server

  		$mail->Port = 465; // พอร์ท
  		$mail->Username = "noreply.ditp@gmail.com"; // account SMTP
  		$mail->Password = 'Ibusiness@02'; // รหัสผ่าน SMTP

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
  		if(!$mail->Send()) {
        $status_response = "02";
        $status_response_text = "Mailer Error!: " . $mail->ErrorInfo;
  		} else {
        $status_response = "00";
  			$status_response_text="Message sent ;)";
        //$status_response_text = $file_name[$i];


  		}
  	} catch (phpmailerException $e) {
  	  //echo $e->errorMessage(); //Pretty error messages from PHPMailer
  	} catch (Exception $e) {
  	  //echo $e->getMessage(); //Boring error messages from anything else!
  	}



    return array('status_response' => $status_response,'status_response_text' => $status_response_text,'datetime'=>date('Y-m-d H:i:s'));
  }
}
?>
