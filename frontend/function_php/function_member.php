<?php
include('../config/config.php');

ini_set('display_errors', 1);
header('Content-Type: text/html; charset=utf-8');
require_once "../lib/PHPMailer-5.2.5/class.phpmailer.php";

class PassHash
{

  private static $algo = '$2a';

  private static $cost = '$10';

  public static function unique_salt()
  {

    return substr(sha1(mt_rand()), 0, 22);
  }
  public static function hash($password)
  {



    return crypt($password, self::$algo .

      self::$cost .

      '$' . self::unique_salt());
  }
  public static function check_password($hash, $password)
  {

    $full_salt = substr($hash, 0, 29);

    $new_hash = crypt($password, $full_salt);

    return ($hash == $new_hash);
  }
}

function generateApiKey()
{
  return md5(uniqid(rand(), true));
}

function deleteDirectory($dirPath)
{
  if (is_dir($dirPath)) {
    $objects = scandir($dirPath);
    foreach ($objects as $object) {
      if ($object != "." && $object != "..") {
        if (filetype($dirPath . DIRECTORY_SEPARATOR . $object) == "dir") {
          deleteDirectory($dirPath . DIRECTORY_SEPARATOR . $object);
        } else {
          unlink($dirPath . DIRECTORY_SEPARATOR . $object);
        }
      }
    }
    reset($objects);
    rmdir($dirPath);
  }
}
switch ($_POST['method']) {
  case "register_member_com":
    echo register_member_com();
    break;
  case "register_member":
    echo register_member();
    break;

  case "facebook_login":
    echo facebook_login();
    break;

  case "facebook_login_chk":
    echo facebook_login_chk();
    break;

  case "chk_login":
    echo chk_login();
    break;
}


function facebook_login()
{
  include('../config/config.php');
  $sql = "SELECT * FROM `Member` WHERE member_facebook_id = '" . $_POST['facebook_id'] . "'";
  $query = $conn->query($sql);
  if ($query->num_rows > 0) {
    $output['fb_chk'] = "00";
  } else {
    $output['fb_chk'] = "01";
  }
  header("content-type:application/json;charset=utf-8");
  echo json_encode($output);
}

function facebook_login_chk()
{
  include('../config/config.php');
  $facebook_id = $_POST['facebook_id'];
  $facebook_name = $_POST['facebook_name'];
  $sql_id = "SELECT member_facebook_id,member_id,member_type,member_facebook_type,member_lang FROM Member WHERE member_facebook_id = '$facebook_id'";
  $query_id = $conn->query($sql_id);
  if ($query_id->num_rows > 0) {
    $output['fb_chk'] = "00";
    $re = $query_id->fetch_assoc();
    $_SESSION["member_id"] = $re["member_id"];
    $_SESSION["member_type"] = $re["member_type"];
    $_SESSION["lang"] = $re["member_lang"];
    $_SESSION["chk_lang"] = 1;
    $_SESSION["member_login_type"] = $re["member_facebook_type"];
  } else {
    $output['fb_chk'] = "01";
  }
  header("content-type:application/json;charset=utf-8");
  echo json_encode($output);
}

function chk_login()
{
  include('../config/config.php');

  $username = strtolower($_POST['box_user']);
  $password = $_POST['box_pass'];

  $sql_mail = "SELECT member_email, member_password FROM Member WHERE LOWER(member_email) = ?";
  $stmt = $conn->prepare($sql_mail);

  $stmt->bind_param("s", $username);
  $stmt->execute();

  $query_mail = $stmt->get_result();

  /*$sql_mail = "SELECT member_email,member_password FROM Member WHERE LOWER(member_email) = '" . strtolower($username) . "'";
  $query_mail = $conn->query($sql_mail); */
  if ($query_mail->num_rows > 0) {
    $rs = $query_mail->fetch_assoc();
    $password_hash = $rs['member_password'];



    // TODO Test
    // if ($username == 'siri_intergroup@hotmail.com') {
    //   $sql = "SELECT member_id,member_email,member_password,member_type,member_facebook_type,member_lang
    //   FROM Member
    //   WHERE LOWER(member_email) = '" . strtolower($username) . "' AND member_status_confirm = 1 AND member_status = 1";
    //   $query = $conn->query($sql);
    //   if ($query->num_rows > 0) {
    //     $re = $query->fetch_assoc();
    //     $_SESSION["member_id"] = $re["member_id"];
    //     $_SESSION["member_type"] = $re["member_type"];
    //     $_SESSION["lang"] = $re["member_lang"];
    //     $_SESSION["chk_lang"] = 1;
    //     $_SESSION["member_login_type"] = $re["member_facebook_type"];

    //     $output['fb_chk'] = "00";
    //   }
    //   header("content-type:application/json;charset=utf-8");
    //   echo json_encode($output);
    //   exit;
    // }
    // TODO End Test

    // if ($username=='siri_intergroup@hotmail.com'){
    if (PassHash::check_password($password_hash, $password)) {
      $sql = "SELECT member_id,member_email,member_password,member_type,member_facebook_type,member_lang
      FROM Member
      WHERE LOWER(member_email) = '" . strtolower($username) . "' AND member_password='$password_hash' AND member_status_confirm = 1 AND member_status = 1";
      $query = $conn->query($sql);
      if ($query->num_rows > 0) {
        $re = $query->fetch_assoc();
        $_SESSION["member_id"] = $re["member_id"];
        $_SESSION["member_type"] = $re["member_type"];
        $_SESSION["lang"] = $re["member_lang"];
        $_SESSION["chk_lang"] = 1;
        $_SESSION["member_login_type"] = $re["member_facebook_type"];


        $output['fb_chk'] = "00";
      } else {
        $output['fb_chk'] = "01";
      }
    } else {
      $output['fb_chk'] = "02";
    }
  } else {
    $output['fb_chk'] = "03";
  }
  header("content-type:application/json;charset=utf-8");
  echo json_encode($output);
}

function random_password($length = 10)
{
  $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOP1234567890";
  $password = substr(str_shuffle($chars), 0, $length);
  return $password;
}

function sendEmail($from_email, $from_name, $to_email, $to_name, $subject, $message)
{
  $output = "";
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

    $mail->AddAddress($to_email, $to_name);

    $mail->AddCC('ditpservicenter@gmail.com', 'ditpservicenter');

    if (!$mail->Send()) {
      $status_response = "02";
      $status_response_text = "Mailer Error!: " . $mail->ErrorInfo;
    } else {
      $output = "00";
      $status_response_text = "Message sent ;)";
    }
  } catch (phpmailerException $e) {
  } catch (Exception $e) {
  }
  return $output;
}

function conf_reg($mail_chk)
{
  include('../config/config.php');

  $sql = "SELECT m.member_fname,m.member_lname,mc.member_comp_name,m.member_type
  FROM `Member` AS m LEFT JOIN `Member_comp` AS mc ON m.member_id = mc.member_id WHERE m.member_email = '" . $mail_chk . "'";
  $query = $conn->query($sql);
  $re = $query->fetch_assoc();
  $output = "";
  if ($query->num_rows > 0) {
    if ($re['member_type'] == "0") {
      $namesent = "เรียน คุณ, " . $re['member_fname'] . "  " . $re['member_lname'];
    } else {
      $namesent = "เรียน บริษัท, " . $re['member_comp_name'];
    }
    $to_email = $mail_chk;
    $passwors = random_password();
    $to_name = "เจ้าหน้าที่ของ DITP Care";
    $from_email = "ditpcare@ditp.go.th";
    $from_name = "DITP Care";
    $subject = "กรุณายืนยันการสมัครสมาชิก DITP Care";
    $password_hash = PassHash::hash($passwors);
    $url = $_SERVER['HTTP_HOST'] . "/frontend/conf_reg.php?conf=$password_hash";
    $message = " <div class=\"wrapper\" style=\"width:860px;background: #f8f8f8;\">
                  <div class=\"header\" style=\"width:auto\">
                  <img src=\"http://" . $_SERVER["HTTP_HOST"] . "/img/header_email_2.png\"  style=\"max-width: 860px;\" srtlw=\"width:100%; height:auto;\" />
                  <div>
                  <div class=\"content\" style=\"width:auto; height:auto; font-family: Tahoma, Verdana, Segoe, sans-serif; font-size:16px;\">
                  <div style=\"padding: 20px;color:#000;\">
                  " . $namesent . "
                  <br>
                  <br>
                  " . $_SERVER['HTTP_HOST'] . " ได้รับคำขอร้องจากเว็บไซต์ หากคุณต้องการยืนยันการสมัครสมาชิก
                  <br>
                  คลิกที่ลิงค์ด้านล่างนี้ เพื่อยืนยันการสมัครสมาชิกของคุณ :
                  <br>
                  <br>
                  <br>
                  <br>
                  <div style=\"text-align:center;color:#000;\">
                  <a href=\"http://" . $url . "\" style=\"background:#22A180;color:#fff;padding: 15px 50px;text-align:center;text-decoration: none;border-radius:25px\" target=\"_blank\" >ยืนยันสมัครสมาชิก</a>
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
                       ทีมงาน <a href=\"http://" . $_SERVER["HTTP_HOST"] . "\" target=\"blank\">" . $_SERVER["HTTP_HOST"] . "</a>
                     </div>
                   </div>";
    $mail =   sendEmail($from_email, $from_name, $to_email, $to_name, $subject, $message);

    $upd = "UPDATE Member SET member_token_confirm = '" . $password_hash . "' ,member_status_confirm = '0' WHERE member_email = '" . $mail_chk . "' ";
    $query_upd = $conn->query($upd);

    $output = $mail;
  } else {
    $output = "01";
  }
  return $output;
}

function register_member_com()
{
  include('../config/config.php');

  if ($_POST['status'] == "0") {
    if (isset($_POST['g-recaptcha-response'])) {
      $captcha = $_POST['g-recaptcha-response'];
    }
    if (!$captcha) {
      $output['email_chk_mem'] = "02";
      header("content-type:application/json;charset=utf-8");
      echo json_encode($output);
      exit;
    }
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LdTxygUAAAAAKworPbcIzofBO0WZx-Z7Ur4wZdZ&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
    if ($response . success == false) {
      $output['email_chk_mem'] = "03";
      header("content-type:application/json;charset=utf-8");
      echo json_encode($output);
      exit;
    } else {
      //echo '<h2>Thanks for posting comment.</h2>';
    }
  }
  $box_name_agentoffice = htmlspecialchars($_POST['box_name_agentoffice']);
  $box_branch_agentoffice = htmlspecialchars($_POST['box_branch_agentoffice']);
  $box_trade_agentoffice = htmlspecialchars($_POST['box_trade_agentoffice']);
  $box_address_agentoffice = htmlspecialchars($_POST['box_address_agentoffice']);
  $sel_city_office = $_POST['sel_city_office'];
  $box_code_agentoffice = $_POST['box_code_agentoffice'];
  $sel_country_office = $_POST['sel_country_office'];
  $box_tel_agentoffice = $_POST['box_tel_agentoffice'];
  $box_fix_agentoffice = $_POST['box_fix_agentoffice'];
  $department_members = $_POST['department_members'];

  $box_nameperson_agentoffice = htmlspecialchars($_POST['box_nameperson_agentoffice']);
  $box_lastnameperson_agentoffice = htmlspecialchars($_POST['box_lastnameperson_agentoffice']);
  $box_cardnumber_agentoffice = $_POST['box_cardnumber_agentoffice'];
  $box_position_agentoffice = htmlspecialchars($_POST['box_position_agentoffice']);
  $box_address_person_agentoffice = htmlspecialchars($_POST['box_address_person_agentoffice']);
  $sel_city_person_office = $_POST['sel_city_person_office'];
  $box_code_person_agentoffice = $_POST['box_code_person_agentoffice'];
  $sel_country_person_office = $_POST['sel_country_person_office'];
  $box_tel_person_agentoffice = $_POST['box_tel_person_agentoffice'];
  $box_fix_person_agentoffice = $_POST['box_fix_person_agentoffice'];
  $office_sex = $_POST['office_sex'];
  $box_email_agentoffice = $_POST['box_email_agentoffice'];
  $box_password_agentoffice = $_POST['box_password_agentoffice'];
  $sel_business_person_office = $_POST['sel_business_person_office'];
  $fb_id = $_POST['fb_id'];
  $fb_name = $_POST['fb_name'];
  $status = $_POST['status'];
  if ($status == "") {
    $status_type = 1;
  } else {
    $status_type = $status;
  }
  if ($box_password_agentoffice != "") {
    $password_hash = PassHash::hash($box_password_agentoffice);
  } else {
    $password_hash = "";
  }
  $key_api = generateApiKey();
  $date = date("Y-m-d H:i:s");

  $sql = "SELECT * FROM `Member` WHERE LOWER(member_email) = '" . strtolower($box_email_agentoffice) . "'";
  $query = $conn->query($sql);
  if ($query->num_rows > 0) {
    $output['email_chk_mem'] = "00";
  } else {
    $sql_membercom = "INSERT INTO `Member`
      ( `member_fname`,
        `member_lname`,
        `member_cid`,
        `member_occupation`,
        `member_position`,
        `member_address`,
        `prov_id`,
        `member_postcode`,
        `country_id`,
        `member_phone`,
        `member_cellphone`,
        `member_sex`,
        `member_email`,
        `member_password`,
        `member_api_key`,
        `member_facebook_id`,
        `member_facebook_name`,
        `member_facebook_type`,
        `member_type`,
        `member_lang`,
        `member_noti`,
        `member_condition`,
        `member_creDate`,
        `member_status`,
        `member_business`
      )
        VALUES (
        '" . $box_nameperson_agentoffice . "',
        '" . $box_lastnameperson_agentoffice . "',
        '" . $box_cardnumber_agentoffice . "',
        '" . $box_position_agentoffice . "',
        '" . $box_position_agentoffice . "',
        '" . $box_address_person_agentoffice . "',
        '" . $sel_city_person_office . "',
        '" . $box_code_person_agentoffice . "',
        '" . $sel_country_person_office . "',
        '" . $box_tel_person_agentoffice . "',
        '" . $box_fix_person_agentoffice . "',
        '" . $office_sex . "',
        '" . $box_email_agentoffice . "',
        '" . $password_hash . "',
        '" . $key_api . "',
        '" . $fb_id . "',
        '" . $fb_name . "',
        '" . $status_type . "',
        '1',
        '0',
        '1',
        '1',
        '" . $date . "',
        '1',
        '" . $sel_business_person_office . "'
        )";
    $query_membercom = $conn->query($sql_membercom);
    $last_membercom = $conn->insert_id;

    $sql_membercomp = "INSERT INTO `Member_comp`
        (
          `member_id`,
          `member_comp_name`,
          `member_comp_branch`,
          `member_comp_taxid`,
          `member_comp_address`,
          `prov_id`,
          `member_comp_postcode`,
          `country_id`,
          `member_comp_phone`,
          `member_comp_fax`,
          `member_comp_type`
        ) VALUES (
          '" . $last_membercom . "',
          '" . $box_name_agentoffice . "',
          '" . $box_branch_agentoffice . "',
          '" . $box_trade_agentoffice . "',
          '" . $box_address_agentoffice . "',
          '" . $sel_city_office . "',
          '" . $box_code_agentoffice . "',
          '" . $sel_country_office . "',
          '" . $box_tel_agentoffice . "',
          '" . $box_fix_agentoffice . "',
          '" . $department_members . "'
        )";
    $query_membercomp = $conn->query($sql_membercomp);
    $last_membercomp = $conn->insert_id;

    if ($_POST['status'] == "") {
      if ($_POST['file'] == "") {
        $ch = curl_init($_POST['file_fb']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $_pic_small = curl_exec($ch);
        curl_close($ch);
        $file_data = $_pic_small;
        if (!is_dir("../../data/img_membercom/" . $last_membercomp)) {
          mkdir("../../data/img_membercom/" . $last_membercomp, 0775, true);
        } else {
          deleteDirectory("../../data/img_membercom/" . $last_membercomp);
          mkdir("../../data/img_membercom/" . $last_membercomp, 0775, true);
        }
        if (!is_dir("../../data/img_membercom/" . $last_membercomp . "/s")) {
          mkdir("../../data/img_membercom/" . $last_membercomp . "/s", 0775, true);
        } else {
          deleteDirectory("../../data/img_membercom/" . $last_membercomp . "/s/");
          mkdir("../../data/img_membercom/" . $last_membercomp . "/s", 0775, true);
        }
        if (!is_dir("../../data/img_membercom/" . $last_membercomp . "/l")) {
          mkdir("../../data/img_membercom/" . $last_membercomp . "/l", 0775, true);
        } else {
          deleteDirectory("../../data/img_membercom/" . $last_membercomp . "/l/");
          mkdir("../../data/img_membercom/" . $last_membercomp . "/l", 0775, true);
        }
        $new_images = uniqid() . '.jpg';
        $extension = 'jpg';
        $file_size_s = "../../data/img_membercom/" . $last_membercomp . "/s/";
        $file_size_l = "../../data/img_membercom/" . $last_membercomp . "/l/";
        $file = "../../data/img_membercom/" . $last_membercomp . "/" . $new_images;
        $sql_update = "UPDATE `Member_comp` SET `member_comp_img` = '" . $new_images . "' WHERE `member_comp_id` = '" . $last_membercomp . "'";
        $query_update = $conn->query($sql_update);
        file_put_contents($file, $file_data);
        $images = "../../data/img_membercom/" . $last_membercomp . "/" . $new_images;
      } else {
        $file_data = $_POST['file'];
        list($type, $file_data) = explode(';', $file_data);
        list(, $extension) = explode('/', $type);
        list(, $file_data)      = explode(',', $file_data);
        $data = base64_decode($file_data);
        if ($extension != "") {
          if (!is_dir("../../data/img_membercom/" . $last_membercomp)) {
            mkdir("../../data/img_membercom/" . $last_membercomp, 0775, true);
          } else {
            deleteDirectory("../../data/img_membercom/" . $last_membercomp);
            mkdir("../../data/img_membercom/" . $last_membercomp, 0775, true);
          }
          if (!is_dir("../../data/img_membercom/" . $last_membercomp . "/s")) {
            mkdir("../../data/img_membercom/" . $last_membercomp . "/s", 0775, true);
          } else {
            deleteDirectory("../../data/img_membercom/" . $last_membercomp . "/s/");
            mkdir("../../data/img_membercom/" . $last_membercomp . "/s", 0775, true);
          }
          if (!is_dir("../../data/img_membercom/" . $last_membercomp . "/l")) {
            mkdir("../../data/img_membercom/" . $last_membercomp . "/l", 0775, true);
          } else {
            deleteDirectory("../../data/img_membercom/" . $last_membercomp . "/l/");
            mkdir("../../data/img_membercom/" . $last_membercomp . "/l", 0775, true);
          }
          $new_images = uniqid() . '.' . $extension;
          $file_size_s = "../../data/img_membercom/" . $last_membercomp . "/s/";
          $file_size_l = "../../data/img_membercom/" . $last_membercomp . "/l/";
          $file = "../../data/img_membercom/" . $last_membercomp . "/" . $new_images;


          $sql_update = "UPDATE `Member_comp` SET `member_comp_img` = '" . $new_images . "' WHERE `member_comp_id` = '" . $last_membercomp . "'";
          $query_update = $conn->query($sql_update);
          file_put_contents($file, $data);
          $images = "../../data/img_membercom/" . $last_membercomp . "/" . $new_images;
        } else {
          $images = "";
        }
      }
    } else {
      $file_data = $_POST['file'];
      list($type, $file_data) = explode(';', $file_data);
      list(, $extension) = explode('/', $type);
      list(, $file_data)      = explode(',', $file_data);
      $data = base64_decode($file_data);
      if ($extension != "") {
        if (!is_dir("../../data/img_membercom/" . $last_membercomp)) {
          mkdir("../../data/img_membercom/" . $last_membercomp, 0775, true);
        } else {
          deleteDirectory("../../data/img_membercom/" . $last_membercomp);
          mkdir("../../data/img_membercom/" . $last_membercomp, 0775, true);
        }
        if (!is_dir("../../data/img_membercom/" . $last_membercomp . "/s")) {
          mkdir("../../data/img_membercom/" . $last_membercomp . "/s", 0775, true);
        } else {
          deleteDirectory("../../data/img_membercom/" . $last_membercomp . "/s/");
          mkdir("../../data/img_membercom/" . $last_membercomp . "/s", 0775, true);
        }
        if (!is_dir("../../data/img_membercom/" . $last_membercomp . "/l")) {
          mkdir("../../data/img_membercom/" . $last_membercomp . "/l", 0775, true);
        } else {
          deleteDirectory("../../data/img_membercom/" . $last_membercomp . "/l/");
          mkdir("../../data/img_membercom/" . $last_membercomp . "/l", 0775, true);
        }
        $new_images = uniqid() . '.' . $extension;
        $file_size_s = "../../data/img_membercom/" . $last_membercomp . "/s/";
        $file_size_l = "../../data/img_membercom/" . $last_membercomp . "/l/";
        $file = "../../data/img_membercom/" . $last_membercomp . "/" . $new_images;


        $sql_update = "UPDATE `Member_comp` SET `member_comp_img` = '" . $new_images . "' WHERE `member_comp_id` = '" . $last_membercomp . "'";
        $query_update = $conn->query($sql_update);
        file_put_contents($file, $data);
        $images = "../../data/img_membercom/" . $last_membercomp . "/" . $new_images;
      } else {
        $images = "";
      }
    }
    $image_l_size = 800;
    $image_s_size = 320;

    //$size = GetimageSize($images);
    list($w, $h) = GetimageSize($images);

    if ($extension == "jpg" || $extension == "jpeg") {
      $images_orig = imagecreatefromjpeg($images);
      $images_origs = imagecreatefromjpeg($images);
    }

    if ($extension == "png") {

      $images_orig = imagecreatefrompng($images);
      $images_origs = imagecreatefrompng($images);
    }
    if ($extension == "gif") {
      $images_orig = imagecreatefromgif($images);
      $images_origs = imagecreatefromgif($images);
    }


    //---- l size -- //
    if ($w > $h) {
      $height = round($image_l_size);
      $width = round($image_l_size * $w / $h);
    } else {
      $height = round($image_l_size * $h / $w);
      $width = round($image_l_size);
    }
    $photoX = ImagesX($images_orig);
    $photoY = ImagesY($images_orig);

    $images_fin = ImageCreateTrueColor($width, $height);
    // แก้พื้นหลังสีดำ
    imagealphablending($images_fin, false);
    imagesavealpha($images_fin, true);
    // แก้พื้นหลังสีดำ
    ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width + 1, $height + 1, $photoX, $photoY);
    if ($extension == "jpeg" || $extension == "jpg") {
      ImageJPEG($images_fin, $file_size_l . $new_images);
    }
    if ($extension == "png") {
      ImagePNG($images_fin, $file_size_l . $new_images);
    }
    if ($extension == "gif") {
      ImageGIF($images_fin, $file_size_l . $new_images);
    }
    ImageDestroy($images_orig);
    ImageDestroy($images_fin);


    //---- s size -- //
    if ($w > $h) {
      $heights = round($image_s_size);
      $widths = round($image_s_size * $w / $h);
    } else {
      $heights = round($image_s_size * $h / $w);
      $widths = round($image_s_size);
    }
    $photoXs = ImagesX($images_origs);
    $photoYs = ImagesY($images_origs);
    $images_fins = ImageCreateTrueColor($widths, $heights);
    // แก้พื้นหลังสีดำ
    imagealphablending($images_fins, false);
    imagesavealpha($images_fins, true);
    // แก้พื้นหลังสีดำ
    ImageCopyResampled($images_fins, $images_origs, 0, 0, 0, 0, $widths + 1, $heights + 1, $photoXs, $photoYs);
    if ($extension == "jpeg" || $extension == "jpg") {
      ImageJPEG($images_fins, $file_size_s . $new_images);
    }
    if ($extension == "png") {
      ImagePNG($images_fins, $file_size_s . $new_images);
    }
    if ($extension == "gif") {
      ImageGIF($images_fins, $file_size_s . $new_images);
    }
    ImageDestroy($images_origs);
    ImageDestroy($images_fins);


    $date_time = date("Y-m-d H:i:s");
    $msgBox = "ยินดีต้อนรับ บริษัท " . $box_name_agentoffice . " สู่บริการ DITP Care ของเรา";
    $msgBox_en = "Welcome " . $box_name_agentoffice . " to DITP Care Service";
    $sql_box = "INSERT INTO `Message_Box` (msgBox_type,sender_id,sender_type,msgBox_message,msgBox_message_en,msgBox_datetime)
        VALUES ('1','" . $last_membercom . "','0','" . $msgBox . "','" . $msgBox_en . "','$date_time')";
    $query_box = $conn->query($sql_box);
    $last_id = $conn->insert_id;

    $sql_log = "INSERT INTO `Message_Box_Log` (msgBox_id,recipient_id,recipient_type,msgBoxLog_datetime)
      VALUES ('" . $last_id . "','" . $last_membercom . "','1','" . $date_time . "')";
    $query_log = $conn->query($sql_log);
    if ($_POST['status'] != "") {
      $conf_reg = conf_reg($box_email_agentoffice);
      $output['chk_mail'] = $conf_reg;
    } else {
      $output['chk_mail'] = "02";
    }

    $output['email_chk_mem'] = "01";
  }
  header("content-type:application/json;charset=utf-8");
  echo json_encode($output);
}


function register_member()
{
  include('../config/config.php');

  if ($_POST['status'] == "0") {

    if (isset($_POST['g-recaptcha-response'])) {
      $captcha = $_POST['g-recaptcha-response'];
    }
    if (!$captcha) {
      $output['email_chk_mem'] = "02";
      header("content-type:application/json;charset=utf-8");
      echo json_encode($output);
      exit;
    }
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LdTxygUAAAAAKworPbcIzofBO0WZx-Z7Ur4wZdZ&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
    if ($response . success == false) {
      $output['email_chk_mem'] = "03";
      header("content-type:application/json;charset=utf-8");
      echo json_encode($output);
      exit;
    } else {
      //echo '<h2>Thanks for posting comment.</h2>';
    }
  }

  $box_nameperson_agentperson = htmlspecialchars($_POST['box_nameperson_agentperson']);
  $box_lastnameperson_agentperson = htmlspecialchars($_POST['box_lastnameperson_agentperson']);
  $box_cardnumber_agentoffice = $_POST['box_cardnumber_agentoffice'];
  $box_position_agentperson = htmlspecialchars($_POST['box_position_agentperson']);
  $box_address_person_agentperson = htmlspecialchars($_POST['box_address_person_agentperson']);
  $sel_city_person_person = $_POST['sel_city_person_person'];
  $box_code_person_agentperson = $_POST['box_code_person_agentperson'];
  $sel_country_person_person = $_POST['sel_country_person_person'];
  $box_tel_person_agentperson = $_POST['box_tel_person_agentperson'];
  $box_fix_person_agentperson = $_POST['box_fix_person_agentperson'];
  $sex_person = $_POST['sex_person'];
  $box_email_agentperson = $_POST['box_email_agentperson'];
  $box_password_agentperson = $_POST['box_password_agentperson'];
  $sel_business_person = $_POST['sel_business_person'];
  $fb_id = $_POST['fb_id'];
  $fb_name = $_POST['fb_name'];
  $status = $_POST['status'];
  if ($status == "") {
    $status_type = 1;
  } else {
    $status_type = $status;
  }
  if ($box_password_agentperson != "") {
    $password_hash = PassHash::hash($box_password_agentperson);
  } else {
    $password_hash = "";
  }


  $key_api = generateApiKey();
  $date = date("Y-m-d H:i:s");

  $sql = "SELECT * FROM `Member` WHERE LOWER(member_email) = '" . strtolower($box_email_agentperson) . "'";
  $query = $conn->query($sql);
  if ($query->num_rows > 0) {
    $output['email_chk_mem'] = "00";
  } else {
    $sql_member = "INSERT INTO `Member`
      ( `member_fname`,
        `member_lname`,
        `member_cid`,
        `member_occupation`,
        `member_position`,
        `member_address`,
        `prov_id`,
        `member_postcode`,
        `country_id`,
        `member_phone`,
        `member_cellphone`,
        `member_sex`,
        `member_email`,
        `member_password`,
        `member_api_key`,
        `member_facebook_id`,
        `member_facebook_name`,
        `member_facebook_type`,
        `member_type`,
        `member_lang`,
        `member_noti`,
        `member_condition`,
        `member_creDate`,
        `member_status`,
        `member_business`
      )
        VALUES (
        '" . $box_nameperson_agentperson . "',
        '" . $box_lastnameperson_agentperson . "',
        '" . $box_cardnumber_agentoffice . "',
        '" . $box_position_agentperson . "',
        '" . $box_position_agentperson . "',
        '" . $box_address_person_agentperson . "',
        '" . $sel_city_person_person . "',
        '" . $box_code_person_agentperson . "',
        '" . $sel_country_person_person . "',
        '" . $box_tel_person_agentperson . "',
        '" . $box_fix_person_agentperson . "',
        '" . $sex_person . "',
        '" . $box_email_agentperson . "',
        '" . $password_hash . "',
        '" . $key_api . "',
        '" . $fb_id . "',
        '" . $fb_name . "',
        '" . $status_type . "',
        '0',
        '0',
        '1',
        '1',
        '" . $date . "',
        '1',
        '" . $sel_business_person . "'
        )";
    $query_member = $conn->query($sql_member);
    $last_member = $conn->insert_id;
    if ($_POST['status'] == "") {
      if ($_POST['file'] == "") {
        $ch = curl_init($_POST['file_fb']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $_pic_small = curl_exec($ch);
        curl_close($ch);
        $file_data = $_pic_small;
        if (!is_dir("../../data/img_member/" . $last_member)) {
          mkdir("../../data/img_member/" . $last_member, 0775, true);
        } else {
          deleteDirectory("../../data/img_member/" . $last_member);
          mkdir("../../data/img_member/" . $last_member, 0775, true);
        }
        if (!is_dir("../../data/img_member/" . $last_member . "/s")) {
          mkdir("../../data/img_member/" . $last_member . "/s", 0775, true);
        } else {
          deleteDirectory("../../data/img_member/" . $last_member . "/s/");
          mkdir("../../data/img_member/" . $last_member . "/s", 0775, true);
        }
        if (!is_dir("../../data/img_member/" . $last_member . "/l")) {
          mkdir("../../data/img_member/" . $last_member . "/l", 0775, true);
        } else {
          deleteDirectory("../../data/img_member/" . $last_member . "/l/");
          mkdir("../../data/img_member/" . $last_member . "/l", 0775, true);
        }
        $new_images = uniqid() . '.jpg';
        $extension = 'jpg';
        $file_size_s = "../../data/img_member/" . $last_member . "/s/";
        $file_size_l = "../../data/img_member/" . $last_member . "/l/";
        $file = "../../data/img_member/" . $last_member . "/" . $new_images;
        $sql_update = "UPDATE `Member` SET `member_img` = '" . $new_images . "' WHERE `member_id` = '" . $last_member . "'";
        $query_update = $conn->query($sql_update);
        file_put_contents($file, $file_data);
        $images = "../../data/img_member/" . $last_member . "/" . $new_images;
      } else {
        $file_data = $_POST['file'];
        list($type, $file_data) = explode(';', $file_data);
        list(, $extension) = explode('/', $type);
        list(, $file_data)      = explode(',', $file_data);
        $data = base64_decode($file_data);
        if ($extension != "") {
          if (!is_dir("../../data/img_member/" . $last_member)) {
            mkdir("../../data/img_member/" . $last_member, 0775, true);
          } else {
            deleteDirectory("../../data/img_member/" . $last_member);
            mkdir("../../data/img_member/" . $last_member, 0775, true);
          }
          if (!is_dir("../../data/img_member/" . $last_member . "/s")) {
            mkdir("../../data/img_member/" . $last_member . "/s", 0775, true);
          } else {
            deleteDirectory("../../data/img_member/" . $last_member . "/s/");
            mkdir("../../data/img_member/" . $last_member . "/s", 0775, true);
          }
          if (!is_dir("../../data/img_member/" . $last_member . "/l")) {
            mkdir("../../data/img_member/" . $last_member . "/l", 0775, true);
          } else {
            deleteDirectory("../../data/img_member/" . $last_member . "/l/");
            mkdir("../../data/img_member/" . $last_member . "/l", 0775, true);
          }
          $new_images = uniqid() . '.' . $extension;
          $file_size_s = "../../data/img_member/" . $last_member . "/s/";
          $file_size_l = "../../data/img_member/" . $last_member . "/l/";
          $file = "../../data/img_member/" . $last_member . "/" . $new_images;


          $sql_update = "UPDATE `Member` SET `member_img` = '" . $new_images . "' WHERE `member_id` = '" . $last_member . "'";
          $query_update = $conn->query($sql_update);
          file_put_contents($file, $data);
          $images = "../../data/img_member/" . $last_member . "/" . $new_images;
        } else {
          $images = "";
        }
      }
    } else {
      $file_data = $_POST['file'];
      list($type, $file_data) = explode(';', $file_data);
      list(, $extension) = explode('/', $type);
      list(, $file_data)      = explode(',', $file_data);
      $data = base64_decode($file_data);
      if ($extension != "") {
        if (!is_dir("../../data/img_member/" . $last_member)) {
          mkdir("../../data/img_member/" . $last_member, 0775, true);
        } else {
          deleteDirectory("../../data/img_member/" . $last_member);
          mkdir("../../data/img_member/" . $last_member, 0775, true);
        }
        if (!is_dir("../../data/img_member/" . $last_member . "/s")) {
          mkdir("../../data/img_member/" . $last_member . "/s", 0775, true);
        } else {
          deleteDirectory("../../data/img_member/" . $last_member . "/s/");
          mkdir("../../data/img_member/" . $last_member . "/s", 0775, true);
        }
        if (!is_dir("../../data/img_member/" . $last_member . "/l")) {
          mkdir("../../data/img_member/" . $last_member . "/l", 0775, true);
        } else {
          deleteDirectory("../../data/img_member/" . $last_member . "/l/");
          mkdir("../../data/img_member/" . $last_member . "/l", 0775, true);
        }
        $new_images = uniqid() . '.' . $extension;
        $file_size_s = "../../data/img_member/" . $last_member . "/s/";
        $file_size_l = "../../data/img_member/" . $last_member . "/l/";
        $file = "../../data/img_member/" . $last_member . "/" . $new_images;


        $sql_update = "UPDATE `Member` SET `member_img` = '" . $new_images . "' WHERE `member_id` = '" . $last_member . "'";
        $query_update = $conn->query($sql_update);
        file_put_contents($file, $data);
        $images = "../../data/img_member/" . $last_member . "/" . $new_images;
      } else {
        $images = "";
      }
    }

    $image_l_size = 800;
    $image_s_size = 320;

    //$size = GetimageSize($images);
    list($w, $h) = GetimageSize($images);

    if ($extension == "jpg" || $extension == "jpeg") {
      $images_orig = imagecreatefromjpeg($images);
      $images_origs = imagecreatefromjpeg($images);
    }

    if ($extension == "png") {

      $images_orig = imagecreatefrompng($images);
      $images_origs = imagecreatefrompng($images);
    }
    if ($extension == "gif") {
      $images_orig = imagecreatefromgif($images);
      $images_origs = imagecreatefromgif($images);
    }


    //---- l size -- //
    if ($w > $h) {
      $height = round($image_l_size);
      $width = round($image_l_size * $w / $h);
    } else {
      $height = round($image_l_size * $h / $w);
      $width = round($image_l_size);
    }
    $photoX = ImagesX($images_orig);
    $photoY = ImagesY($images_orig);

    $images_fin = ImageCreateTrueColor($width, $height);
    // แก้พื้นหลังสีดำ
    imagealphablending($images_fin, false);
    imagesavealpha($images_fin, true);
    // แก้พื้นหลังสีดำ
    ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width + 1, $height + 1, $photoX, $photoY);
    if ($extension == "jpeg" || $extension == "jpg") {
      ImageJPEG($images_fin, $file_size_l . $new_images);
    }
    if ($extension == "png") {
      ImagePNG($images_fin, $file_size_l . $new_images);
    }
    if ($extension == "gif") {
      ImageGIF($images_fin, $file_size_l . $new_images);
    }
    ImageDestroy($images_orig);
    ImageDestroy($images_fin);


    //---- s size -- //
    if ($w > $h) {
      $heights = round($image_s_size);
      $widths = round($image_s_size * $w / $h);
    } else {
      $heights = round($image_s_size * $h / $w);
      $widths = round($image_s_size);
    }
    $photoXs = ImagesX($images_origs);
    $photoYs = ImagesY($images_origs);
    $images_fins = ImageCreateTrueColor($widths, $heights);
    // แก้พื้นหลังสีดำ
    imagealphablending($images_fins, false);
    imagesavealpha($images_fins, true);
    // แก้พื้นหลังสีดำ
    ImageCopyResampled($images_fins, $images_origs, 0, 0, 0, 0, $widths + 1, $heights + 1, $photoXs, $photoYs);
    if ($extension == "jpeg" || $extension == "jpg") {
      ImageJPEG($images_fins, $file_size_s . $new_images);
    }
    if ($extension == "png") {
      ImagePNG($images_fins, $file_size_s . $new_images);
    }
    if ($extension == "gif") {
      ImageGIF($images_fins, $file_size_s . $new_images);
    }
    ImageDestroy($images_origs);
    ImageDestroy($images_fins);

    $date_time = date("Y-m-d H:i:s");
    $msgBox = "ยินดีต้อนรับ คุณ " . $box_nameperson_agentperson . "  " . $box_lastnameperson_agentperson . " สู่บริการ DITP Care ของเรา";
    $msgBox_en = "Welcome " . $box_nameperson_agentperson . "  " . $box_lastnameperson_agentperson . " to DITP Care Service";
    $sql_box = "INSERT INTO `Message_Box` (msgBox_type,sender_id,sender_type,msgBox_message,msgBox_message_en,msgBox_datetime)
        VALUES ('1','" . $last_member . "','0','" . $msgBox . "','" . $msgBox_en . "','$date_time')";
    $query_box = $conn->query($sql_box);
    $last_id = $conn->insert_id;

    $sql_log = "INSERT INTO `Message_Box_Log` (msgBox_id,recipient_id,recipient_type,msgBoxLog_datetime)
      VALUES ('" . $last_id . "','" . $last_member . "','1','" . $date_time . "')";
    $query_log = $conn->query($sql_log);
    if ($_POST['status'] != "") {
      $conf_reg = conf_reg($box_email_agentperson);
      $output['chk_mail'] = $conf_reg;
    } else {
      $output['chk_mail'] = "02";
    }
    $output['email_chk_mem'] = "01";
  }
  header("content-type:application/json;charset=utf-8");
  echo json_encode($output);
}
