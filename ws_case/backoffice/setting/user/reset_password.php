<?php
include("../../../config/config.php");
require_once "../../class/PHPMailer-5.2.5/class.phpmailer.php";
function random_password( $length = 8 ) {
  $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOP1234567890";
  $password = substr( str_shuffle( $chars ), 0, $length );
  return $password;
 }



    $emp_email = $_POST['repass_id'];

    $sql_select = "SELECT * FROM Member WHERE  member_id = '".$_POST['repass_id']."' ";
     $query_select = $conn->query($sql_select);


     if($query_select->num_rows > 0 ){
   $row=$query_select->fetch_assoc();
   $mailsent = $row['member_email'];
   $emp_email = $mailsent;
   $namesent = $row['member_fname']." ".$row['member_lname'];
   $newpassword = random_password();

    $message = "<table cellpadding=\"5\" cellspacing=\"0\">
     <tr >
      <td>
      </td>
     </tr>
      <td style=\" color:#000;font-size:16px; \">
    สวัสดีคุณ".$row['emp_name']." ".$row['emp_lastname']."
      </td>
     </tr>
     <tr>
      <td style=\" color:#707070;font-size:15px; \">
    เราได้รับคำขอให้รีเซ็ตรหัสผ่าน Web Helpdesk & Assets Management ของคุณ
      </td>
     </tr>
     <tr ><td></td></tr>
     <tr>
      <td style=\" color:#707070;font-size:15px; \">
    Email : ".$row['emp_email']."
      </td>
     </tr>
     <tr>
      <td style=\" color:#707070;font-size:15px; \">
    Password : ".$newpassword."
      </td>
     </tr>
     <tr ><td></td></tr><tr ><td></td></tr>
     <tr>
      <td style=\" color:#707070;font-size:15px; \">
    คุณสามารถใช้ Email และ Password นี้เข้าใช้งานได้ที่ Web Helpdesk & Assets Management

      </td>
     </tr>
     <tr>
      <td style=\" font-size:15px; \">
    Team www.phyathai.com
      </td>
     </tr>
    </table>";

  $send_email_fnc = sendEmail($emp_email,"Noreply Phyathai",$mailsent,$namesent,"รีเซ็ตรหัสผ่านของคุณ",$message,$newpassword,$emp_email);
  if($send_email_fnc=='1'){
    echo "รีเซ็ตรหัสผ่านบัญชีของคุณเรียบร้อยแล้ว <br>กรุณา Login Email เพื่อรับรหัสผ่าน";
  }
     }
     else
     {
   //$json = array('status' => '2' );
       //echo json_encode($json);
	       "SELECT * FROM phya_employee WHERE emp_email = '".$emp_email."' AND emp_status = '1'";
          echo "กรุณาติดต่อเจ้าหน้าที่";echo "<br>";
          echo "เบอร์ติดต่อ 1190-23456";
     }




 function sendEmail($from_email,$from_name,$to_email,$to_name,$subject,$message,$newpassword2,$mail_check){
	 global $dbConnection;
  $body = $message;
  try {
   $mail = new PHPMailer(true);
   $mail->CharSet = "utf-8";
   $mail->IsSMTP();
   $mail->SMTPDebug = 0;
   $mail->SMTPAuth = true;
   //$mail->SMTPSecure = "ssl";	// sets the prefix to the servier
   $mail->Host = "203.150.62.22"; // SMTP server
   $mail->Port = 25; // พอร์ท
   $mail->Username = "ditpcare@ditp.go.th"; // account SMTP
   $mail->Password = 'Ditp2017'; // รหัสผ่าน SMTP
   $mail->SetFrom($from_email, $from_name);
   $mail->AddReplyTo($from_email, $from_name);
   $mail->Subject = $subject;
   $mail->MsgHTML($body);
   $toEmail= $to_email;
   $toName = $to_name;
   $i=0;
  //  foreach($toEmail as $toEmail_add){
    //echo $toEmail_add." ".$toName[$i]."<br>";
    $mail->AddAddress($toEmail,$toName);
    $i++;
  //  }
   if(!$mail->Send()) {
    //$json = array('status' => '0');
    $json = '0';
   } else {
    /*mysqli_query("UPDATE phya_employee SET
    emp_password = '".md5($newpassword2)."'
    WHERE emp_email = '$mail_check'
    ");*/
	$upd = "UPDATE phya_employee SET emp_password = '".md5($newpassword2)."' WHERE emp_email = '".$mail_check."'";
	$query_upd = $dbConnection->query($upd);
    // $json = array('status' => '1' );
      $json = '1';
   }
  //  echo json_encode($json);
  } catch (phpmailerException $e) {
    // $json = array('status' => '0' );
      $json = '0';
    //echo json_encode($json);
  } catch (Exception $e) {
    // $json = array('status' => '0' );
      $json = '0';
    //echo json_encode($json);
  }

  return $json;
 }
?>
