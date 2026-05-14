<?php
session_start();
include('../config/config.php');
include('../class/send_email.class.php');


// error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: text/html; charset=utf-8');
//header("X-Frame-Options: DENY");
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

switch ($_POST['method']) {
  case "chk_invite_update":
    echo chk_invite_update();
    break;
  case "edit_profile_modal":
    echo edit_profile_modal();
    break;
  case "repassword":
    echo repassword();
    break;
  case "hide_icon":
    echo hide_icon();
    break;
  case "chk_div_category":
    echo chk_div_category();
    break;
  case "read_mesBox":
    echo read_mesBox();
    break;

  case "del_msgBox":
    echo del_msgBox();
    break;
  case "del_msgnoti":
    echo del_msgnoti();
    break;
  case "update_status_noti":
    echo update_status_noti();
    break;
  case "chk_invite_step":
    echo chk_invite_step();
    break;
  case "forgot_password":
    echo forgot_password();
    break;
  case "language_select":
    echo language_select();
    break;
  case "chk_invite_txt":
    echo chk_invite_txt();
    break;
  case "chk_invite_txt_edit":
    echo chk_invite_txt_edit();
    break;
  case "count_checkcorporation_clicked":
    echo count_checkcorporation_clicked();
    break;
}

switch ($_GET['method']) {
  case "question":
    echo question();
    break;
  case "create_invite":
    echo create_invite();
    break;
  case "lang":
    $lang = $_GET['lang'];
    echo lang($lang);
    break;

  case "new_letter_case":
    $txt_search = $_GET['txt_search'];
    echo new_letter_case($txt_search);
    break;

  case "reply_letter":
    $case_id = $_GET['case_id'];
    echo reply_letter($case_id);
    break;

  case "new_letter":
    echo new_letter();
    break;

  case "Register_member":
    echo Register_Member();
    break;
}
function chk_invite_update()
{
  include('../config/config.php');
  $chk_status = $_POST['chk_status'];
  if ($chk_status != "") {
    $sql = "UPDATE Member SET member_condition ='2' WHERE member_id='" . $_SESSION['member_id'] . "'";
    $query = $conn->query($sql);
  }
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

function chk_invite_txt()
{
  include('../config/config.php');
  // $applntOrg_name = $_POST["applntOrg_name"];
  // $applntOrg_position = $_POST["applntOrg_position"];
  // $applntOrg_trade_number = $_POST["applntOrg_trade_number"];
  // $applntOrg_address = $_POST["applntOrg_address"];
  // $applntOrg_tel = $_POST["applntOrg_tel"];
  // $applntOrg_zipcode = $_POST["applntOrg_zipcode"];
  // $applnt_country_id = $_POST["applnt_country_id"];
  ///endfrom1
  ///from2
  $complnt_name = $_POST["complnt_name"];
  $complnt_import_export = $_POST["complnt_import_export"];
  $complnt_contact_address = $_POST["complnt_contact_address"];
  $complnt_prov_id = $_POST["complnt_prov_id"];
  $complnt_country_id = $_POST["complnt_country_id"];
  $complnt_zipcode = $_POST["complnt_zipcode"];

  $complnt_branch = $_POST["complnt_branch"];
  $complnt_position = $_POST["complnt_position"];
  ///endfrom2
  ///from3
  $caseDtl_title = $_POST["caseDtl_title"];
  $prodType_id = $_POST["prodType_id"];
  $incType_id = $_POST["incType_id"];
  $caseDtl_derivation = $_POST["caseDtl_derivation"];
  $caseDtl_damage_val = $_POST["caseDtl_damage_val"];
  $caseDtl_complnt_need = $_POST["caseDtl_complnt_need"];
  ///endfrom3
  $formSetId_a = $_POST["formSetId_a"];
  $formSetId_b = $_POST["formSetId_b"];
  $formSetId_c = $_POST["formSetId_c"];
  $applntOrg_show = $_POST["applntOrg_show"];
  $rdi_compTypeSub1 = $_POST["rdi_compTypeSub1"];
  $output['in_chk'] = "00";
  $output['in_chk_error'] = "";

  // print_r($_POST);
  // print_r($_SESSION['member_id']);

  $allowed_extensions = ['jpg', 'jpeg', 'png', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf', 'zip', 'rar', 'txt'];



  if ($applntOrg_show == '1') {

    if ($formSetId_b != 7) {
      // if($applntOrg_name == "" ){
      //   $output['in_chk'] = "01" ;
      //   $output['in_chk_error'] = "applntOrg_name_IdxFs_".$formSetId_a;
      // }else if ($applntOrg_position == "") {
      //   $output['in_chk'] = "01" ;
      //   $output['in_chk_error'] = "applntOrg_position_IdxFs_".$formSetId_a;
      // }else if ($applntOrg_trade_number == "") {
      //   $output['in_chk'] = "01" ;
      //   $output['in_chk_error'] = "applntOrg_trade_number_IdxFs_".$formSetId_a;
      // }else if ($applntOrg_address == "") {
      //   $output['in_chk'] = "01" ;
      //   $output['in_chk_error'] = "applntOrg_address_IdxFs_".$formSetId_a;
      // }else if ($applntOrg_tel == "") {
      //   $output['in_chk'] = "01" ;
      //   $output['in_chk_error'] = "applntOrg_tel_IdxFs_".$formSetId_a;
      // }else if ($applntOrg_zipcode == "") {
      //   $output['in_chk'] = "01" ;
      //   $output['in_chk_error'] = "applntOrg_zipcode_IdxFs_".$formSetId_a;
      // }else if ($applnt_country_id == "") {
      //   $output['in_chk'] = "01" ;
      //   $output['in_chk_error'] = "applnt_country_id_IdxFs_".$formSetId_a;
      // }


      if ($complnt_name == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "complnt_name_IdxFs_" . $formSetId_b;
      } else if ($complnt_import_export == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "complnt_import_export_IdxFs_" . $formSetId_b;
      } else if ($complnt_contact_address == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "complnt_contact_address_IdxFs_" . $formSetId_b;
      } else if ($complnt_prov_id == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "complnt_prov_id_IdxFs_" . $formSetId_b;
      } else if ($complnt_country_id == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "complnt_country_id_IdxFs_" . $formSetId_b;
      } else if ($caseDtl_title == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "caseDtl_title_IdxFs_" . $formSetId_c;
      } else if ($prodType_id == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "prodType_id_IdxFs_" . $formSetId_c;
      } else if ($caseDtl_derivation == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "caseDtl_derivation_IdxFs_" . $formSetId_c;
      } else if ($caseDtl_complnt_need == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "caseDtl_complnt_need_IdxFs_" . $formSetId_c;
      } else if ($caseDtl_damage_val == "0") {
        $output['in_chk'] = "02";
        $output['in_chk_error'] = "caseDtl_damage_val_IdxFs_" . $formSetId_c;
      } else if ($_POST["complnt_contact_tel_IdxFs_"] == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "complnt_contact_tel_IdxFs_" . $formSetId_b;
      } else if ($_POST['complnt_contact_email_IdxFs_'] == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "complnt_contact_email_IdxFs_" . $formSetId_b;
      } else {
        if (!is_dir("../../data/case_attach_tmp")) {
          mkdir("../../data/case_attach_tmp", 0777, true);
        }
        if (!is_dir("../../data/case_attach_tmp/" . $_SESSION['member_id'])) {
          mkdir("../../data/case_attach_tmp/" . $_SESSION['member_id'], 0777, true);
        } else {
          deleteDirectory("../../data/case_attach_tmp/" . $_SESSION['member_id']);
          mkdir("../../data/case_attach_tmp/" . $_SESSION['member_id'], 0777, true);
        }
        $removeIdx = explode(",", $_POST["fileinput_file_remove"]);
        $total_fileAttach = count($_FILES['file']['tmp_name']);
        for ($i = 0; $i < $total_fileAttach; $i++) {
          if ($_POST["fileinput_file_remove"] != "") {
            if (!in_array($i, $removeIdx)) {
              $file_name = $_FILES['file']['name'][$i];
              $file_size = $_FILES['file']['size'][$i];
              $file_tmp = $_FILES['file']['tmp_name'][$i];
              $file_type = $_FILES['file']['type'][$i];
              $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
              if (in_array($ext, $allowed_extensions)) {
                move_uploaded_file($file_tmp, "../../data/case_attach_tmp/" . $_SESSION['member_id'] . "/" . $file_name);
              } else {
                $output['in_chk'] = "01";
                $output['in_chk_error'] = "file_invite";
              }
            }
          } else {
            $file_name = $_FILES['file']['name'][$i];
            $file_size = $_FILES['file']['size'][$i];
            $file_tmp = $_FILES['file']['tmp_name'][$i];
            $file_type = $_FILES['file']['type'][$i];
            $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            if (in_array($ext, $allowed_extensions)) {
              move_uploaded_file($file_tmp, "../../data/case_attach_tmp/" . $_SESSION['member_id'] . "/" . $file_name);
            } else {
              $output['in_chk'] = "01";
              $output['in_chk_error'] = "file_invite";
            }
          }
        }
        $output['in_chk'] = "00";
      }
    } else {

      if ($complnt_name == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "complnt_name_IdxFs_" . $formSetId_b;
      } else if ($complnt_branch == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "complnt_branch_IdxFs_" . $formSetId_b;
      } else if ($complnt_position == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "complnt_position_IdxFs_" . $formSetId_b;
      } else if ($caseDtl_title == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "caseDtl_title_IdxFs_" . $formSetId_c;
      } else if ($incType_id == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "incType_id_IdxFs_" . $formSetId_c;
      } else if ($caseDtl_derivation == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "caseDtl_derivation_IdxFs_" . $formSetId_c;
      } else if ($caseDtl_complnt_need == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "caseDtl_complnt_need_IdxFs_" . $formSetId_c;
      } else if ($caseDtl_damage_val == "0") {
        $output['in_chk'] = "02";
        $output['in_chk_error'] = "caseDtl_damage_val_IdxFs_" . $formSetId_c;
      } else {

        if (!is_dir("../../data/case_attach_tmp")) {
          mkdir("../../data/case_attach_tmp", 0777, true);
        }
        if (!is_dir("../../data/case_attach_tmp/" . $_SESSION['member_id'])) {
          mkdir("../../data/case_attach_tmp/" . $_SESSION['member_id'], 0777, true);
        } else {
          deleteDirectory("../../data/case_attach_tmp/" . $_SESSION['member_id']);
          mkdir("../../data/case_attach_tmp/" . $_SESSION['member_id'], 0777, true);
        }
        $removeIdx = explode(",", $_POST["fileinput_file_remove"]);
        $total_fileAttach = count($_FILES['file']['tmp_name']);
        for ($i = 0; $i < $total_fileAttach; $i++) {
          if ($_POST["fileinput_file_remove"] != "") {
            if (!in_array($i, $removeIdx)) {
              $file_name = $_FILES['file']['name'][$i];
              $file_size = $_FILES['file']['size'][$i];
              $file_tmp = $_FILES['file']['tmp_name'][$i];
              $file_type = $_FILES['file']['type'][$i];
              $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
              if (in_array($ext, $allowed_extensions)) {
                move_uploaded_file($file_tmp, "../../data/case_attach_tmp/" . $_SESSION['member_id'] . "/" . $file_name);
              } else {
                $output['in_chk'] = "01";
                $output['in_chk_error'] = "file_invite";
              }
            }
          } else {
            $file_name = $_FILES['file']['name'][$i];
            $file_size = $_FILES['file']['size'][$i];
            $file_tmp = $_FILES['file']['tmp_name'][$i];
            $file_type = $_FILES['file']['type'][$i];
            $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            if (in_array($ext, $allowed_extensions)) {
              move_uploaded_file($file_tmp, "../../data/case_attach_tmp/" . $_SESSION['member_id'] . "/" . $file_name);
            } else {
              $output['in_chk'] = "01";
              $output['in_chk_error'] = "file_invite";
            }
          }
        }
        $output['in_chk'] = "00";
      }
    }
  } else {
    if ($formSetId_b != 7) {
      // if($applntOrg_name == "" ){
      //   $output['in_chk'] = "01" ;
      //   $output['in_chk_error'] = "applntOrg_name_IdxFs_".$formSetId_a;
      // }else if ($applntOrg_position == "") {
      //   $output['in_chk'] = "01" ;
      //   $output['in_chk_error'] = "applntOrg_position_IdxFs_".$formSetId_a;
      // }else if ($applntOrg_trade_number == "") {
      //   $output['in_chk'] = "01" ;
      //   $output['in_chk_error'] = "applntOrg_trade_number_IdxFs_".$formSetId_a;
      // }else if ($applntOrg_address == "") {
      //   $output['in_chk'] = "01" ;
      //   $output['in_chk_error'] = "applntOrg_address_IdxFs_".$formSetId_a;
      // }else if ($applntOrg_tel == "") {
      //   $output['in_chk'] = "01" ;
      //   $output['in_chk_error'] = "applntOrg_tel_IdxFs_".$formSetId_a;
      // }else if ($applntOrg_zipcode == "") {
      //   $output['in_chk'] = "01" ;
      //   $output['in_chk_error'] = "applntOrg_zipcode_IdxFs_".$formSetId_a;
      // }else if ($applnt_country_id == "") {
      //   $output['in_chk'] = "01" ;
      //   $output['in_chk_error'] = "applnt_country_id_IdxFs_".$formSetId_a;
      // }


      if ($rdi_compTypeSub1 == 1) {
        if (strlen($_POST["complnt_contact_tel_IdxFs_"]) != 10) {
          $output['in_chk'] = "01";
          $output['in_chk_error'] = "complnt_contact_tel_IdxFs_" . $formSetId_b;
          $output['in_chk_error1'] = "telth";
        }

        if ($complnt_zipcode != "") {
          if (strlen($complnt_zipcode) != 5) {
            $output['in_chk'] = "01";
            $output['in_chk_error'] = "complnt_zipcode_IdxFs_" . $formSetId_b;
          }
        }
      } else if ($rdi_compTypeSub1 == 2) {
        if (strlen($_POST["complnt_contact_tel_IdxFs_"]) == 0) {
          $output['in_chk'] = "01";
          $output['in_chk_error'] = "complnt_contact_tel_IdxFs_" . $formSetId_b;
          $output['in_chk_error1'] = "telen";
        }
      }


      if ($complnt_name == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "complnt_name_IdxFs_" . $formSetId_b;
      } else if ($_POST["phone-number-complnt"] == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "complnt_contact_tel_IdxFs_" . $formSetId_b;
        $output['in_chk_error1'] = "telcode";
      } else if ($_POST['complnt_contact_email_IdxFs_'] == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "complnt_contact_email_IdxFs_" . $formSetId_b;
      } else if ($complnt_import_export == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "complnt_import_export_IdxFs_" . $formSetId_b;
      } else if ($complnt_contact_address == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "complnt_contact_address_IdxFs_" . $formSetId_b;
      } else if ($complnt_prov_id == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "complnt_prov_id_IdxFs_" . $formSetId_b;
      } else if ($complnt_country_id == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "complnt_country_id_IdxFs_" . $formSetId_b;
      } else if ($caseDtl_title == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "caseDtl_title_IdxFs_" . $formSetId_c;
      } else if ($prodType_id == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "prodType_id_IdxFs_" . $formSetId_c;
      } else if ($caseDtl_derivation == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "caseDtl_derivation_IdxFs_" . $formSetId_c;
      } else if ($caseDtl_complnt_need == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "caseDtl_complnt_need_IdxFs_" . $formSetId_c;
      } else if ($caseDtl_damage_val == "0") {
        $output['in_chk'] = "02";
        $output['in_chk_error'] = "caseDtl_damage_val_IdxFs_" . $formSetId_c;
      }

      $n = 0;
      $fileup = 0;
      foreach ($_POST["caseAttach_file_name"] as $file_name) {
        if ($file_name == '') {
          $output['in_chk'] = "05";
          $output['in_chk_error'] = "caseAttach_file_name" . $n;
          $output['in_chk_error1'] = $n;
          $fileup = 1;
        }
        $n = $n + 1;
      }

      if ($fileup == 0) {
        if (!is_dir("../../data/case_attach_tmp")) {
          mkdir("../../data/case_attach_tmp", 0777, true);
        }
        if (!is_dir("../../data/case_attach_tmp/" . $_SESSION['member_id'])) {
          mkdir("../../data/case_attach_tmp/" . $_SESSION['member_id'], 0777, true);
        } else {
          deleteDirectory("../../data/case_attach_tmp/" . $_SESSION['member_id']);
          mkdir("../../data/case_attach_tmp/" . $_SESSION['member_id'], 0777, true);
        }

        $removeIdx = explode(",", $_POST["fileinput_file_remove"]);
        $total_fileAttach = count($_FILES['file']['tmp_name']);


        for ($i = 0; $i < $total_fileAttach; $i++) {
          if ($_POST["fileinput_file_remove"] != "") {
            if (!in_array($i, $removeIdx)) {
              $file_name = $_FILES['file']['name'][$i];
              $file_size = $_FILES['file']['size'][$i];
              $file_tmp = $_FILES['file']['tmp_name'][$i];
              $file_type = $_FILES['file']['type'][$i];
              $foldertemp = "../../data/case_attach_tmp/" . $_SESSION['member_id'] . "/" . $file_name;
              $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
              if (in_array($ext, $allowed_extensions)) {
                copy($file_tmp, $foldertemp);
              } else {
                $output['in_chk'] = "01";
                $output['in_chk_error'] = "file_invite";
              }
            }
          } else {
            $file_name = $_FILES['file']['name'][$i];
            $file_size = $_FILES['file']['size'][$i];
            $file_tmp = $_FILES['file']['tmp_name'][$i];
            $file_type = $_FILES['file']['type'][$i];
            $foldertemp = "../../data/case_attach_tmp/" . $_SESSION['member_id'] . "/" . $file_name;

            // echo $file_tmp;
            $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            if (in_array($ext, $allowed_extensions)) {
              copy($file_tmp, $foldertemp);
            } else {
              $output['in_chk'] = "01";
              $output['in_chk_error'] = "file_invite";
            }
          }
        }
        // $output['in_chk'] = "00" ;
      }
    } else {
      if ($complnt_name == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "complnt_name_IdxFs_" . $formSetId_b;
      } else if ($complnt_branch == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "complnt_branch_IdxFs_" . $formSetId_b;
      } else if ($complnt_position == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "complnt_position_IdxFs_" . $formSetId_b;
      } else if ($caseDtl_title == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "caseDtl_title_IdxFs_" . $formSetId_c;
      } else if ($incType_id == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "incType_id_IdxFs_" . $formSetId_c;
      } else if ($caseDtl_derivation == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "caseDtl_derivation_IdxFs_" . $formSetId_c;
      } else if ($caseDtl_complnt_need == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "caseDtl_complnt_need_IdxFs_" . $formSetId_c;
      } else if ($caseDtl_damage_val == "0") {
        $output['in_chk'] = "02";
        $output['in_chk_error'] = "caseDtl_damage_val_IdxFs_" . $formSetId_c;
      } else {

        if (!is_dir("../../data/case_attach_tmp")) {
          mkdir("../../data/case_attach_tmp", 0777, true);
        }
        if (!is_dir("../../data/case_attach_tmp/" . $_SESSION['member_id'])) {
          mkdir("../../data/case_attach_tmp/" . $_SESSION['member_id'], 0777, true);
        } else {
          deleteDirectory("../../data/case_attach_tmp/" . $_SESSION['member_id']);
          mkdir("../../data/case_attach_tmp/" . $_SESSION['member_id'], 0777, true);
        }
        $removeIdx = explode(",", $_POST["fileinput_file_remove"]);
        $total_fileAttach = count($_FILES['file']['tmp_name']);
        for ($i = 0; $i < $total_fileAttach; $i++) {
          if ($_POST["fileinput_file_remove"] != "") {
            if (!in_array($i, $removeIdx)) {
              $file_name = $_FILES['file']['name'][$i];
              $file_size = $_FILES['file']['size'][$i];
              $file_tmp = $_FILES['file']['tmp_name'][$i];
              $file_type = $_FILES['file']['type'][$i];
              $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
              if (in_array($ext, $allowed_extensions)) {
                move_uploaded_file($file_tmp, "../../data/case_attach_tmp/" . $_SESSION['member_id'] . "/" . $file_name);
              } else {
                $output['in_chk'] = "01";
                $output['in_chk_error'] = "file_invite";
              }
            }
          } else {
            $file_name = $_FILES['file']['name'][$i];
            $file_size = $_FILES['file']['size'][$i];
            $file_tmp = $_FILES['file']['tmp_name'][$i];
            $file_type = $_FILES['file']['type'][$i];
            $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            if (in_array($ext, $allowed_extensions)) {
              move_uploaded_file($file_tmp, "../../data/case_attach_tmp/" . $_SESSION['member_id'] . "/" . $file_name);
            } else {
              $output['in_chk'] = "01";
              $output['in_chk_error'] = "file_invite";
            }
          }
        }
        $output['in_chk'] = "00";
      }
    }
  }
  // echo($_SESSION['member_id']);


  header("content-type:application/json;charset=utf-8");
  echo json_encode($output);
}

function chk_invite_txt_edit()
{
  include('../config/config.php');
  // $applntOrg_name = $_POST["applntOrg_name"];
  // $applntOrg_position = $_POST["applntOrg_position"];
  // $applntOrg_trade_number = $_POST["applntOrg_trade_number"];
  // $applntOrg_address = $_POST["applntOrg_address"];
  // $applntOrg_tel = $_POST["applntOrg_tel"];
  // $applntOrg_zipcode = $_POST["applntOrg_zipcode"];
  // $applnt_country_id = $_POST["applnt_country_id"];
  ///endfrom1
  ///from2

  $complnt_name = $_POST["complnt_name"];
  $complnt_import_export = $_POST["complnt_import_export"];
  $complnt_contact_address = $_POST["complnt_contact_address"];
  $complnt_prov_id = $_POST["complnt_prov_id"];
  $complnt_country_id = $_POST["complnt_country_id"];

  $complnt_branch = $_POST["complnt_branch"];
  $complnt_position = $_POST["complnt_position"];
  ///endfrom2
  ///from3
  $caseDtl_title = $_POST["caseDtl_title"];
  $prodType_id = $_POST["prodType_id"];
  $incType_id = $_POST["incType_id"];
  $caseDtl_derivation = $_POST["caseDtl_derivation"];
  $caseDtl_damage_val = $_POST["caseDtl_damage_val"];
  $caseDtl_complnt_need = $_POST["caseDtl_complnt_need"];
  ///endfrom3
  $formSetId_a = $_POST["formSetId_a"];
  $formSetId_b = $_POST["formSetId_b"];
  $formSetId_c = $_POST["formSetId_c"];
  $applntOrg_show = $_POST["applntOrg_show"];
  $output['in_chk'] = "00";
  $output['in_chk_error'] = "";

  $allowed_extensions = ['jpg', 'jpeg', 'png', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf', 'zip', 'rar', 'txt'];
  if ($applntOrg_show == '1') {

    if ($formSetId_b != 7) {
      // if($applntOrg_name == "" ){
      //   $output['in_chk'] = "01" ;
      //   $output['in_chk_error'] = "applntOrg_name_IdxFs_".$formSetId_a;
      // }else if ($applntOrg_position == "") {
      //   $output['in_chk'] = "01" ;
      //   $output['in_chk_error'] = "applntOrg_position_IdxFs_".$formSetId_a;
      // }else if ($applntOrg_trade_number == "") {
      //   $output['in_chk'] = "01" ;
      //   $output['in_chk_error'] = "applntOrg_trade_number_IdxFs_".$formSetId_a;
      // }else if ($applntOrg_address == "") {
      //   $output['in_chk'] = "01" ;
      //   $output['in_chk_error'] = "applntOrg_address_IdxFs_".$formSetId_a;
      // }else if ($applntOrg_tel == "") {
      //   $output['in_chk'] = "01" ;
      //   $output['in_chk_error'] = "applntOrg_tel_IdxFs_".$formSetId_a;
      // }else if ($applntOrg_zipcode == "") {
      //   $output['in_chk'] = "01" ;
      //   $output['in_chk_error'] = "applntOrg_zipcode_IdxFs_".$formSetId_a;
      // }else if ($applnt_country_id == "") {
      //   $output['in_chk'] = "01" ;
      //   $output['in_chk_error'] = "applnt_country_id_IdxFs_".$formSetId_a;
      // }
      if ($complnt_name == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "complnt_name_IdxFs_" . $formSetId_b;
      } else if ($complnt_import_export == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "complnt_import_export_IdxFs_" . $formSetId_b;
      } else if ($complnt_contact_address == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "complnt_contact_address_IdxFs_" . $formSetId_b;
      } else if ($complnt_prov_id == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "complnt_prov_id_IdxFs_" . $formSetId_b;
      } else if ($complnt_country_id == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "complnt_country_id_IdxFs_" . $formSetId_b;
      } else if ($caseDtl_title == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "caseDtl_title_IdxFs_" . $formSetId_c;
      } else if ($prodType_id == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "prodType_id_IdxFs_" . $formSetId_c;
      } else if ($caseDtl_derivation == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "caseDtl_derivation_IdxFs_" . $formSetId_c;
      } else if ($caseDtl_complnt_need == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "caseDtl_complnt_need_IdxFs_" . $formSetId_c;
      } else if ($caseDtl_damage_val == "0") {
        $output['in_chk'] = "02";
        $output['in_chk_error'] = "caseDtl_damage_val_IdxFs_" . $formSetId_c;
      } else {
        if (!is_dir("../../data/case_attach_tmp")) {
          mkdir("../../data/case_attach_tmp", 0777, true);
        }
        if (!is_dir("../../data/case_attach_tmp/" . $_SESSION['member_id'])) {
          mkdir("../../data/case_attach_tmp/" . $_SESSION['member_id'], 0777, true);
        }
        $removeIdx = explode(",", $_POST["fileinput_file_remove"]);
        $total_fileAttach = count($_FILES['file']['tmp_name']);
        if ($total_fileAttach != 0) {
          for ($i = 0; $i < $total_fileAttach; $i++) {
            if ($_POST["fileinput_file_remove"] != "") {
              if (!in_array($i, $removeIdx)) {
                $file_name = $_FILES['file']['name'][$i];
                $file_size = $_FILES['file']['size'][$i];
                $file_tmp = $_FILES['file']['tmp_name'][$i];
                $file_type = $_FILES['file']['type'][$i];
                $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                if (in_array($ext, $allowed_extensions)) {
                  move_uploaded_file($file_tmp, "../../data/case_attach_tmp/" . $_SESSION['member_id'] . "/" . $file_name);
                } else {
                  $output['in_chk'] = "01";
                  $output['in_chk_error'] = "file_invite";
                }
              }
            } else {
              $file_name = $_FILES['file']['name'][$i];
              $file_size = $_FILES['file']['size'][$i];
              $file_tmp = $_FILES['file']['tmp_name'][$i];
              $file_type = $_FILES['file']['type'][$i];
              $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
              if (in_array($ext, $allowed_extensions)) {
                move_uploaded_file($file_tmp, "../../data/case_attach_tmp/" . $_SESSION['member_id'] . "/" . $file_name);
              } else {
                $output['in_chk'] = "01";
                $output['in_chk_error'] = "file_invite";
              }
            }
          }
        } else {
          if ($_POST["fileinput_file_remove"] != "") {
            $n = 0;
            foreach (glob("../../data/case_attach_tmp/" . $_SESSION['member_id'] . "/*.*") as $sn) {
              $sn_ex = explode("/", $sn);
              if (in_array($n, $removeIdx)) {
                $delurl = "../../data/case_attach_tmp/" . $_SESSION['member_id'] . "/" . $sn_ex[5];
                unlink($delurl);
              }
              $n++;
            }
          }
        }
        $output['in_chk'] = "00";
      }
    } else {

      if ($complnt_name == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "complnt_name_IdxFs_" . $formSetId_b;
      } else if ($complnt_branch == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "complnt_branch_IdxFs_" . $formSetId_b;
      } else if ($complnt_position == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "complnt_position_IdxFs_" . $formSetId_b;
      } else if ($caseDtl_title == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "caseDtl_title_IdxFs_" . $formSetId_c;
      } else if ($incType_id == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "incType_id_IdxFs_" . $formSetId_c;
      } else if ($caseDtl_derivation == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "caseDtl_derivation_IdxFs_" . $formSetId_c;
      } else if ($caseDtl_complnt_need == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "caseDtl_complnt_need_IdxFs_" . $formSetId_c;
      } else if ($caseDtl_damage_val == "0") {
        $output['in_chk'] = "02";
        $output['in_chk_error'] = "caseDtl_damage_val_IdxFs_" . $formSetId_c;
      } else {
        if (!is_dir("../../data/case_attach_tmp")) {
          mkdir("../../data/case_attach_tmp", 0777, true);
        }
        if (!is_dir("../../data/case_attach_tmp/" . $_SESSION['member_id'])) {
          mkdir("../../data/case_attach_tmp/" . $_SESSION['member_id'], 0777, true);
        }
        $removeIdx = explode(",", $_POST["fileinput_file_remove"]);
        $total_fileAttach = count($_FILES['file']['tmp_name']);
        if ($total_fileAttach != 0) {
          for ($i = 0; $i < $total_fileAttach; $i++) {
            if ($_POST["fileinput_file_remove"] != "") {
              if (!in_array($i, $removeIdx)) {
                $file_name = $_FILES['file']['name'][$i];
                $file_size = $_FILES['file']['size'][$i];
                $file_tmp = $_FILES['file']['tmp_name'][$i];
                $file_type = $_FILES['file']['type'][$i];
                $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                if (in_array($ext, $allowed_extensions)) {
                  move_uploaded_file($file_tmp, "../../data/case_attach_tmp/" . $_SESSION['member_id'] . "/" . $file_name);
                } else {
                  $output['in_chk'] = "01";
                  $output['in_chk_error'] = "file_invite";
                }
              }
            } else {
              $file_name = $_FILES['file']['name'][$i];
              $file_size = $_FILES['file']['size'][$i];
              $file_tmp = $_FILES['file']['tmp_name'][$i];
              $file_type = $_FILES['file']['type'][$i];
              $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
              if (in_array($ext, $allowed_extensions)) {
                move_uploaded_file($file_tmp, "../../data/case_attach_tmp/" . $_SESSION['member_id'] . "/" . $file_name);
              } else {
                $output['in_chk'] = "01";
                $output['in_chk_error'] = "file_invite";
              }
            }
          }
        } else {
          if ($_POST["fileinput_file_remove"] != "") {
            $n = 0;
            foreach (glob("../../data/case_attach_tmp/" . $_SESSION['member_id'] . "/*.*") as $sn) {
              $sn_ex = explode("/", $sn);
              if (in_array($n, $removeIdx)) {
                $delurl = "../../data/case_attach_tmp/" . $_SESSION['member_id'] . "/" . $sn_ex[5];
                unlink($delurl);
              }
              $n++;
            }
          }
        }
        $output['in_chk'] = "00";
      }
    }
  } else {
    if ($formSetId_b != 7) {

      if ($complnt_name == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "complnt_name_IdxFs_" . $formSetId_b;
      } else if ($complnt_import_export == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "complnt_import_export_IdxFs_" . $formSetId_b;
      } else if ($complnt_contact_address == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "complnt_contact_address_IdxFs_" . $formSetId_b;
      } else if ($complnt_prov_id == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "complnt_prov_id_IdxFs_" . $formSetId_b;
      } else if ($complnt_country_id == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "complnt_country_id_IdxFs_" . $formSetId_b;
      } else if ($caseDtl_title == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "caseDtl_title_IdxFs_" . $formSetId_c;
      } else if ($prodType_id == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "prodType_id_IdxFs_" . $formSetId_c;
      } else if ($caseDtl_derivation == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "caseDtl_derivation_IdxFs_" . $formSetId_c;
      } else if ($caseDtl_complnt_need == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "caseDtl_complnt_need_IdxFs_" . $formSetId_c;
      } else if ($caseDtl_damage_val == "0") {
        $output['in_chk'] = "02";
        $output['in_chk_error'] = "caseDtl_damage_val_IdxFs_" . $formSetId_c;
      } else {
        if (!is_dir("../../data/case_attach_tmp")) {
          mkdir("../../data/case_attach_tmp", 0777, true);
        }
        if (!is_dir("../../data/case_attach_tmp/" . $_SESSION['member_id'])) {
          mkdir("../../data/case_attach_tmp/" . $_SESSION['member_id'], 0777, true);
        }
        $removeIdx = explode(",", $_POST["fileinput_file_remove"]);
        $total_fileAttach = count($_FILES['file']['tmp_name']);
        if ($total_fileAttach != 0) {
          for ($i = 0; $i < $total_fileAttach; $i++) {
            if ($_POST["fileinput_file_remove"] != "") {
              if (!in_array($i, $removeIdx)) {
                $file_name = $_FILES['file']['name'][$i];
                $file_size = $_FILES['file']['size'][$i];
                $file_tmp = $_FILES['file']['tmp_name'][$i];
                $file_type = $_FILES['file']['type'][$i];
                $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                if (in_array($ext, $allowed_extensions)) {
                  move_uploaded_file($file_tmp, "../../data/case_attach_tmp/" . $_SESSION['member_id'] . "/" . $file_name);
                } else {
                  $output['in_chk'] = "01";
                  $output['in_chk_error'] = "file_invite";
                }
              }
            } else {
              $file_name = $_FILES['file']['name'][$i];
              $file_size = $_FILES['file']['size'][$i];
              $file_tmp = $_FILES['file']['tmp_name'][$i];
              $file_type = $_FILES['file']['type'][$i];
              $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
              if (in_array($ext, $allowed_extensions)) {
                move_uploaded_file($file_tmp, "../../data/case_attach_tmp/" . $_SESSION['member_id'] . "/" . $file_name);
              } else {
                $output['in_chk'] = "01";
                $output['in_chk_error'] = "file_invite";
              }
            }
          }
        } else {
          if ($_POST["fileinput_file_remove"] != "") {
            $n = 0;
            foreach (glob("../../data/case_attach_tmp/" . $_SESSION['member_id'] . "/*.*") as $sn) {
              $sn_ex = explode("/", $sn);
              if (in_array($n, $removeIdx)) {
                $delurl = "../../data/case_attach_tmp/" . $_SESSION['member_id'] . "/" . $sn_ex[5];
                unlink($delurl);
              }
              $n++;
            }
          }
        }

        $output['in_chk'] = "00";
      }
    } else {
      if ($complnt_name == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "complnt_name_IdxFs_" . $formSetId_b;
      } else if ($complnt_branch == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "complnt_branch_IdxFs_" . $formSetId_b;
      } else if ($complnt_position == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "complnt_position_IdxFs_" . $formSetId_b;
      } else if ($caseDtl_title == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "caseDtl_title_IdxFs_" . $formSetId_c;
      } else if ($incType_id == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "incType_id_IdxFs_" . $formSetId_c;
      } else if ($caseDtl_derivation == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "caseDtl_derivation_IdxFs_" . $formSetId_c;
      } else if ($caseDtl_complnt_need == "") {
        $output['in_chk'] = "01";
        $output['in_chk_error'] = "caseDtl_complnt_need_IdxFs_" . $formSetId_c;
      } else if ($caseDtl_damage_val == "0") {
        $output['in_chk'] = "02";
        $output['in_chk_error'] = "caseDtl_damage_val_IdxFs_" . $formSetId_c;
      } else {

        if (!is_dir("../../data/case_attach_tmp")) {
          mkdir("../../data/case_attach_tmp", 0777, true);
        }
        if (!is_dir("../../data/case_attach_tmp/" . $_SESSION['member_id'])) {
          mkdir("../../data/case_attach_tmp/" . $_SESSION['member_id'], 0777, true);
        }
        $removeIdx = explode(",", $_POST["fileinput_file_remove"]);
        $total_fileAttach = count($_FILES['file']['tmp_name']);
        if ($total_fileAttach != 0) {
          for ($i = 0; $i < $total_fileAttach; $i++) {
            if ($_POST["fileinput_file_remove"] != "") {
              if (!in_array($i, $removeIdx)) {
                $file_name = $_FILES['file']['name'][$i];
                $file_size = $_FILES['file']['size'][$i];
                $file_tmp = $_FILES['file']['tmp_name'][$i];
                $file_type = $_FILES['file']['type'][$i];
                move_uploaded_file($file_tmp, "../../data/case_attach_tmp/" . $_SESSION['member_id'] . "/" . $file_name);
              }
            } else {
              $file_name = $_FILES['file']['name'][$i];
              $file_size = $_FILES['file']['size'][$i];
              $file_tmp = $_FILES['file']['tmp_name'][$i];
              $file_type = $_FILES['file']['type'][$i];
              move_uploaded_file($file_tmp, "../../data/case_attach_tmp/" . $_SESSION['member_id'] . "/" . $file_name);
            }
          }
        } else {
          if ($_POST["fileinput_file_remove"] != "") {
            $n = 0;
            foreach (glob("../../data/case_attach_tmp/" . $_SESSION['member_id'] . "/*.*") as $sn) {
              $sn_ex = explode("/", $sn);
              if (in_array($n, $removeIdx)) {
                $delurl = "../../data/case_attach_tmp/" . $_SESSION['member_id'] . "/" . $sn_ex[5];
                unlink($delurl);
              }
              $n++;
            }
          }
        }
        $output['in_chk'] = "00";
      }
    }
  }

  header("content-type:application/json;charset=utf-8");
  echo json_encode($output);
}

function emp_get_manager($officeId, $compType_id)
{
  global $conn;
  $emp_list_arr = array();

  $sql_comp = "SELECT * FROM `Complaint_Type` WHERE `compType_id` = '$compType_id' ";
  $query_comp = $conn->query($sql_comp);
  $rs_comp = $query_comp->fetch_assoc();

  if ($rs_comp['compType_section'] == 1) {
    $sql = "SELECT * FROM Employee emp
            LEFT JOIN Employee_Group em_pg ON (emp.empGroup_id=em_pg.empGroup_id)
            WHERE emp.office_id='$officeId'
            AND em_pg.empGroup_section='1'
            AND emp.emp_status='0'
            AND em_pg.empGroup_level='2' ";
  } else if ($rs_comp['compType_section'] == 2) {
    $sql = "SELECT * FROM Employee emp
            LEFT JOIN Employee_Group em_pg ON (emp.empGroup_id=em_pg.empGroup_id)
            WHERE em_pg.empGroup_section='2'
            AND emp.emp_status='0'
            AND em_pg.empGroup_level='2' ";
  }
  $query = $conn->query($sql);
  while ($rs = $query->fetch_assoc()) {
    array_push($emp_list_arr, $rs);
  }
  return $emp_list_arr;
}

function Register_Member()
{
  include('../config/config.php');
  $data_key = json_decode(stripslashes($_POST['key']));
  $data = array();

  foreach ($data_key as $d) {
    $data[] = $d;
  }

  if ($data[1] == "0") {
    $sql_member = "UPDATE `Member` 
    SET `member_fname` = '" . $data[2] . "', `member_lname` = '" . $data[3] . "', `member_cid` = '" . $data[4] . "',
    `member_phone` = '" . $data[5] . "', `member_address` = '" . $data[7] . "',
    `member_postcode` = '" . $data[9] . "',`country_id` = " . $data[8] . ", `member_email` = '" . $data[6] . "', 
    `tel_country_code` = '" . $data[10] . "', `tel_code` = '" . $data[11] . "'
    WHERE `member_id` = " . $data[0] . "";
    $result = $conn->query($sql_member);
    return $result;
  } else {
    $sql_member = "UPDATE `Member` 
    SET `member_fname` = '" . $data[2] . "', `member_lname` = '" . $data[3] . "', `member_cid` = '" . $data[4] . "',
    `member_phone` = '" . $data[5] . "', `member_address` = '" . $data[7] . "',
    `member_postcode` = '" . $data[9] . "',`country_id` = " . $data[8] . ", `member_email` = '" . $data[6] . "',
    `tel_country_code` = '" . $data[10] . "', `tel_code` = '" . $data[11] . "'
    WHERE `member_id` = " . $data[0] . "";
    $result = $conn->query($sql_member);
    return $result;
  }
}

function create_invite()
{
  include('../config/config.php');
  // $output['status_response'] = "01";

  $date = date("Y-m-d");
  $date_time = date("Y-m-d H:i:s");

  $fId_a = $_POST["formSetId_a"];
  $fId_b = $_POST["formSetId_b"];
  $fId_c = $_POST["formSetId_c"];

  // if($_POST['prodType_id'] == ""){
  // }else {
  //   $sql_office = "SELECT * FROM `Product_Type` WHERE prodType_id='".$_POST["prodType_id"]."'";
  //   $query_office = $conn->query($sql_office);
  //   $res = $query_office->fetch_assoc();
  //   $office = $res['office_id'];
  // }

  // if($_POST['rdi_compType_id']==6 || $_POST['rdi_compType_id']==1){
  //   $office = '0';
  // }

  //ทำไว้ชั่วคราว แต่ต้องมา แก้ให้มัน loop ข้อมูลด้วยทุก post val
  $safe_complnt_name = $conn->escape_string($_POST['complnt_name']);

  $sql = "SELECT * FROM `Complaint_Type` WHERE compType_id='" . $_POST["rdi_compType_id"] . "'";
  $query = $conn->query($sql);
  if ($query->num_rows > 0) {
    $re = $query->fetch_assoc();
    $sql_case = "INSERT INTO `Case` (
      `compType_id`,
      `compTypeSub1_id`,
      `compTypeSub2_id`,
      `compType_other`,
      `case_status`,
      `caseCh_id`,
      `case_priority`,
      `case_compType_duration`,
      `case_receivedoc_date`,
      `case_receivedoc_real_datetime`,
      `caseDtl_title`,
      `prodType_id`,
      `office_id`,
      `prodType_other`,
      `caseDtl_derivation`,
      `caseDtl_damage_val`,
      `curren_id`,
      `caseDtl_complnt_need`,
      `applntOrg_trade_number`,
      `applntOrg_name`,
      `applnt_ident`,
      `applnt_firstname`,
      `applnt_lastname`,
      `applnt_type`,
      `complnt_trade_number`,
      `complnt_name`,
      `applnt_country_id`,
      `complnt_country_id`,
      `case_create_datetime`,
      `case_createBy_id`,
      `incType_id`,
      `incType_other`) VALUES (
        '" . $_POST['rdi_compType_id'] . "',
        '" . $_POST['rdi_compTypeSub1'] . "',
        '" . $_POST['rdi_compTypeSub2'] . "',
        '" . $_POST['compType_other_txt'] . "',
        '0',
        '2',
        '1',
        '" . $re['compType_duration'] . "',
        '" . $date . "',
        '" . $date_time . "',
        '" . $_POST['caseDtl_title'] . "',
        '" . $_POST['prodType_id'] . "',
        '0',
        '" . $_POST['prodType_other'] . "',
        '" . htmlspecialchars($_POST['caseDtl_derivation'], ENT_QUOTES) . "',
        '" . $_POST['caseDtl_damage_val'] . "',
        '" . $_POST['curren_id'] . "',
        '" . htmlspecialchars($_POST['caseDtl_complnt_need'], ENT_QUOTES) . "',
        '" . $_POST['applntOrg_trade_number'] . "',
        '" . $_POST['applntOrg_name'] . "',
        '" . $_POST['applnt_ident'] . "',
        '" . $_POST['applnt_firstname'] . "',
        '" . $_POST['applnt_lastname'] . "',
        '" . $_POST['applnt_type'] . "',
        '" . $_POST['complnt_trade_number'] . "',
        '" . $safe_complnt_name . "',
        '" . $_POST['applnt_country_id'] . "',
        '" . $_POST['complnt_country_id'] . "',
        '" . $date_time . "',
        '" . $_SESSION['member_id'] . "',
        '" . $_POST['incType_id'] . "',
        '" . $_POST['incType_other'] . "')";
    $query_case = $conn->query($sql_case);
    $last_case = $conn->insert_id;


    if ($_POST['rdi_compTypeSub1'] == 1) {
      $passed_persondetail = unserialize($_POST['Appint_personDetail']);
      if ($_POST['personType'] == "1") {
        $passed_Representdetail = unserialize($_POST['Represent_Allvalue']);
        $sql_applnt = "UPDATE `Case` 
        SET `applntOrg_trade_number` = '" . $passed_Representdetail[0] . "', `applntOrg_name` = '" . $passed_Representdetail[1] . "', `applnt_ident` = '" . $passed_persondetail[4] . "',
        `applnt_firstname` = '" . $passed_persondetail[2] . "', `applnt_lastname` = '" . $passed_persondetail[3] . "', `applnt_type` = '" . $_POST['applnt_type'] . "',
        `applnt_country_id` = '" . $passed_persondetail[9] . "', `applntOrg_country_id` = '" . $passed_Representdetail[8] . "'
        WHERE `case_id` = '" . $last_case . "'";
        $conn->query($sql_applnt);
      } else if ($_POST['personType'] == "2") {
        $sql_applnt = "UPDATE `Case` 
        SET `applnt_ident` = '" . $passed_persondetail[4] . "',`applnt_firstname` = '" . $passed_persondetail[2] . "', `applnt_lastname` = '" . $passed_persondetail[3] . "',
        `applnt_type` = '" . $_POST['applnt_type'] . "', `applnt_country_id` = '" . $passed_persondetail[9] . "'
        WHERE `case_id` = '" . $last_case . "'";
        $conn->query($sql_applnt);
      }
    }

    //2 3 5
    $sql_field = "SELECT * FROM `Field_Set` WHERE `frmset_id`='$fId_a' OR `frmset_id`='$fId_b' OR `frmset_id`='$fId_c' ";
    $qr_field = $conn->query($sql_field);
    while ($rs_field = $qr_field->fetch_assoc()) {
      foreach ($_POST as $key => $value) {
        $keySplit = explode('_IdxFs_', $key);
        if ($rs_field["fieldset_name"] == $keySplit[0]) {

          $desTextAlert = $rs_field["fieldset_description"];

          if ($rs_field["fieldset_require"] == "1") {
            if ($_POST[$key] == "") {
              $text_n = array(1, 2, 5, 6);
              $select_n = array(3, 4, 7, 8, 9);
              $desType = $rs_field["fieldset_type"];
              if (in_array($desType, $text_n)) {
                $initTextAlert = "กรุณาระบุ";
              }
              if (in_array($desType, $select_n)) {
                $initTextAlert = "กรุณาเลือก";
              }
              $status_response = "02";
              if ($status_response_text == "success") {
                $status_response_text = $initTextAlert . $desTextAlert;
              }
            }
          }

          if ($rs_field["fieldset_type"] == "10") {
          } else if ($rs_field["fieldset_type"] == "3") {
          } else if ($rs_field["fieldset_type"] == "7") {
            if (!($_POST[$key] == "" || $_POST[$key] == 1)) {
              $status_response = "02";
              if ($status_response_text == "success") {
                $status_response_text = "รูปแบบ " . $desTextAlert . " ไม่ถูกต้อง";
              }
            }
          }

          if ($_POST["applnt_status_IdxFs_" . $fId_a] == "1" && $rs_field["frmset_id"] == $fId_a) {
            $value = "";
          }

          if ($fId_a == 2) {
            $passed_persondetail = unserialize($_POST['Appint_personDetail']);
            if ($rs_field["fieldset_id"] == 51) {
              $sql_fieldset = "INSERT INTO `Field_Values` (`case_id`, `fieldset_id`, `fieldset_value`) VALUE ('$last_case', '" . $rs_field["fieldset_id"] . "', '" . $passed_persondetail[4] . "')";
              $conn->query($sql_fieldset);
            } else if ($rs_field["fieldset_id"] == 52) {
              $sql_fieldset = "INSERT INTO `Field_Values` (`case_id`, `fieldset_id`, `fieldset_value`) VALUE ('$last_case', '" . $rs_field["fieldset_id"] . "', '" . $passed_persondetail[2] . "')";
              $conn->query($sql_fieldset);
            } else if ($rs_field["fieldset_id"] == 53) {
              $sql_fieldset = "INSERT INTO `Field_Values` (`case_id`, `fieldset_id`, `fieldset_value`) VALUE ('$last_case', '" . $rs_field["fieldset_id"] . "', '" . $passed_persondetail[3] . "')";
              $conn->query($sql_fieldset);
            } else if ($rs_field["fieldset_id"] == 56) {
              $sql_fieldset = "INSERT INTO `Field_Values` (`case_id`, `fieldset_id`, `fieldset_value`) VALUE ('$last_case', '" . $rs_field["fieldset_id"] . "', '" . $passed_persondetail[6] . "')";
              $conn->query($sql_fieldset);
            } else if ($rs_field["fieldset_id"] == 58) {
              $sql_fieldset = "INSERT INTO `Field_Values` (`case_id`, `fieldset_id`, `fieldset_value`) VALUE ('$last_case', '" . $rs_field["fieldset_id"] . "', '" . $passed_persondetail[5] . "')";
              $conn->query($sql_fieldset);
            } else if ($rs_field["fieldset_id"] == 60) {
              $sql_fieldset = "INSERT INTO `Field_Values` (`case_id`, `fieldset_id`, `fieldset_value`) VALUE ('$last_case', '" . $rs_field["fieldset_id"] . "', '" . $passed_persondetail[7] . "')";
              $conn->query($sql_fieldset);
            } else if ($rs_field["fieldset_id"] == 61) {
              $sql_fieldset = "INSERT INTO `Field_Values` (`case_id`, `fieldset_id`, `fieldset_value`) VALUE ('$last_case', '" . $rs_field["fieldset_id"] . "', '" . $passed_persondetail[8] . "')";
              $conn->query($sql_fieldset);
            } else if ($rs_field["fieldset_id"] == 62) {
              $sql_fieldset = "INSERT INTO `Field_Values` (`case_id`, `fieldset_id`, `fieldset_value`) VALUE ('$last_case', '" . $rs_field["fieldset_id"] . "', '" . $passed_persondetail[9] . "')";
              $conn->query($sql_fieldset);
            } else if ($rs_field["fieldset_id"] == 63) {
              $sql_fieldset = "INSERT INTO `Field_Values` (`case_id`, `fieldset_id`, `fieldset_value`) VALUE ('$last_case', '" . $rs_field["fieldset_id"] . "', '" . $_POST['Appint_OrgSelect'] . "')";
              $conn->query($sql_fieldset);
            } else {
              $sql_ins_field = "INSERT INTO `Field_Values` (`case_id`, `fieldset_id`, `fieldset_value`)VALUE ('$last_case', '" . $rs_field["fieldset_id"] . "', '" . htmlspecialchars($value, ENT_QUOTES) . "')";
              $conn->query($sql_ins_field);
            }
          } else if ($fId_a == 9) {
            $passed_persondetail = unserialize($_POST['Appint_personDetail']);
            if ($rs_field["fieldset_id"] == 149) {
              $sql_fieldset = "INSERT INTO `Field_Values` (`case_id`, `fieldset_id`, `fieldset_value`) VALUE ('$last_case', '" . $rs_field["fieldset_id"] . "', '" . $passed_persondetail[4] . "')";
              $conn->query($sql_fieldset);
            } else if ($rs_field["fieldset_id"] == 150) {
              $sql_fieldset = "INSERT INTO `Field_Values` (`case_id`, `fieldset_id`, `fieldset_value`) VALUE ('$last_case', '" . $rs_field["fieldset_id"] . "', '" . $passed_persondetail[2] . "')";
              $conn->query($sql_fieldset);
            } else if ($rs_field["fieldset_id"] == 151) {
              $sql_fieldset = "INSERT INTO `Field_Values` (`case_id`, `fieldset_id`, `fieldset_value`) VALUE ('$last_case', '" . $rs_field["fieldset_id"] . "', '" . $passed_persondetail[3] . "')";
              $conn->query($sql_fieldset);
            } else if ($rs_field["fieldset_id"] == 154) {
              $sql_fieldset = "INSERT INTO `Field_Values` (`case_id`, `fieldset_id`, `fieldset_value`) VALUE ('$last_case', '" . $rs_field["fieldset_id"] . "', '" . $passed_persondetail[6] . "')";
              $conn->query($sql_fieldset);
            } else if ($rs_field["fieldset_id"] == 156) {
              $sql_fieldset = "INSERT INTO `Field_Values` (`case_id`, `fieldset_id`, `fieldset_value`) VALUE ('$last_case', '" . $rs_field["fieldset_id"] . "', '" . $passed_persondetail[5] . "')";
              $conn->query($sql_fieldset);
            } else if ($rs_field["fieldset_id"] == 158) {
              $sql_fieldset = "INSERT INTO `Field_Values` (`case_id`, `fieldset_id`, `fieldset_value`) VALUE ('$last_case', '" . $rs_field["fieldset_id"] . "', '" . $passed_persondetail[7] . "')";
              $conn->query($sql_fieldset);
            } else if ($rs_field["fieldset_id"] == 159) {
              $sql_fieldset = "INSERT INTO `Field_Values` (`case_id`, `fieldset_id`, `fieldset_value`) VALUE ('$last_case', '" . $rs_field["fieldset_id"] . "', '" . $passed_persondetail[8] . "')";
              $conn->query($sql_fieldset);
            } else if ($rs_field["fieldset_id"] == 160) {
              $sql_fieldset = "INSERT INTO `Field_Values` (`case_id`, `fieldset_id`, `fieldset_value`) VALUE ('$last_case', '" . $rs_field["fieldset_id"] . "', '" . $passed_persondetail[9] . "')";
              $conn->query($sql_fieldset);
            } else if ($rs_field["fieldset_id"] == 161) {
              $sql_fieldset = "INSERT INTO `Field_Values` (`case_id`, `fieldset_id`, `fieldset_value`) VALUE ('$last_case', '" . $rs_field["fieldset_id"] . "', '" . $_POST['applnt_type'] . "')";
              $conn->query($sql_fieldset);
            } else {
              $sql_ins_field = "INSERT INTO `Field_Values` (`case_id`, `fieldset_id`, `fieldset_value`)VALUE ('$last_case', '" . $rs_field["fieldset_id"] . "', '" . htmlspecialchars($value, ENT_QUOTES) . "')";
              $conn->query($sql_ins_field);
            }
          } else if ($fId_a == 1) {
            $passed_persondetail = unserialize($_POST['Appint_personDetail']);
            if ($rs_field["fieldset_id"] == 1) {
              $sql_fieldset = "INSERT INTO `Field_Values` (`case_id`, `fieldset_id`, `fieldset_value`) VALUE ('$last_case', '" . $rs_field["fieldset_id"] . "', '" . $passed_persondetail[4] . "')";
              $conn->query($sql_fieldset);
            } else if ($rs_field["fieldset_id"] == 2) {
              $sql_fieldset = "INSERT INTO `Field_Values` (`case_id`, `fieldset_id`, `fieldset_value`) VALUE ('$last_case', '" . $rs_field["fieldset_id"] . "', '" . $passed_persondetail[2] . "')";
              $conn->query($sql_fieldset);
            } else if ($rs_field["fieldset_id"] == 3) {
              $sql_fieldset = "INSERT INTO `Field_Values` (`case_id`, `fieldset_id`, `fieldset_value`) VALUE ('$last_case', '" . $rs_field["fieldset_id"] . "', '" . $passed_persondetail[3] . "')";
              $conn->query($sql_fieldset);
            } else if ($rs_field["fieldset_id"] == 6) {
              $sql_fieldset = "INSERT INTO `Field_Values` (`case_id`, `fieldset_id`, `fieldset_value`) VALUE ('$last_case', '" . $rs_field["fieldset_id"] . "', '" . $passed_persondetail[6] . "')";
              $conn->query($sql_fieldset);
            } else if ($rs_field["fieldset_id"] == 8) {
              $sql_fieldset = "INSERT INTO `Field_Values` (`case_id`, `fieldset_id`, `fieldset_value`) VALUE ('$last_case', '" . $rs_field["fieldset_id"] . "', '" . $passed_persondetail[5] . "')";
              $conn->query($sql_fieldset);
            } else if ($rs_field["fieldset_id"] == 10) {
              $sql_fieldset = "INSERT INTO `Field_Values` (`case_id`, `fieldset_id`, `fieldset_value`) VALUE ('$last_case', '" . $rs_field["fieldset_id"] . "', '" . $passed_persondetail[7] . "')";
              $conn->query($sql_fieldset);
            } else if ($rs_field["fieldset_id"] == 12) {
              $sql_fieldset = "INSERT INTO `Field_Values` (`case_id`, `fieldset_id`, `fieldset_value`) VALUE ('$last_case', '" . $rs_field["fieldset_id"] . "', '" . $passed_persondetail[9] . "')";
              $conn->query($sql_fieldset);
            } else if ($rs_field["fieldset_id"] == 13) {
              $sql_fieldset = "INSERT INTO `Field_Values` (`case_id`, `fieldset_id`, `fieldset_value`) VALUE ('$last_case', '" . $rs_field["fieldset_id"] . "', '" . $passed_persondetail[8] . "')";
              $conn->query($sql_fieldset);
            } else {
              $sql_ins_field = "INSERT INTO `Field_Values` (`case_id`, `fieldset_id`, `fieldset_value`)VALUE ('$last_case', '" . $rs_field["fieldset_id"] . "', '" . htmlspecialchars($value, ENT_QUOTES) . "')";
              $conn->query($sql_ins_field);
            }
          } else {
            $sql_ins_field = "INSERT INTO `Field_Values`(`case_id`, `fieldset_id`, `fieldset_value`)
              VALUE (
                '$last_case', '" . $rs_field["fieldset_id"] . "', '" . htmlspecialchars($value, ENT_QUOTES) . "'
              )";
            $qr_ins_field = $conn->query($sql_ins_field);
            if (!$qr_ins_field) {
              $status_response = "01";
              $status_response_text = "Error SQL!";
            }
          }

          // $sql_ins_field = "INSERT INTO `Field_Values`(`case_id`, `fieldset_id`, `fieldset_value`)
          // VALUE (
          //   '$last_case', '".$rs_field["fieldset_id"]."', '".htmlspecialchars($value,ENT_QUOTES)."'
          // )";
          // $qr_ins_field = $conn->query($sql_ins_field);
          // if(!$qr_ins_field){
          //   $status_response = "01";
          //   $status_response_text = "Error SQL!";
          // }
        }
      }
    }


    if ($fId_a == 1) {
      if ($_POST['applnt_type'] == "1") {
        $passed_Representdetail = unserialize($_POST['Represent_Allvalue']);
        $sql_fieldsetOrg = "INSERT INTO `Field_Values` (`case_id`, `fieldset_id`, `fieldset_value`) VALUES 
          ('$last_case', '18', '" . $passed_Representdetail[0] . "'),
          ('$last_case', '19', '" . $passed_Representdetail[1] . "'),
          ('$last_case', '20', '" . $passed_Representdetail[2] . "'),
          ('$last_case', '21', '" . $passed_Representdetail[4] . "'),
          ('$last_case', '22', '" . $passed_Representdetail[3] . "'),
          ('$last_case', '23', '" . $passed_Representdetail[5] . "'),
          ('$last_case', '229', '" . $passed_Representdetail[6] . "'),
          ('$last_case', '25', '" . $passed_Representdetail[7] . "'),
          ('$last_case', '27', '" . $passed_Representdetail[9] . "')";
        $conn->query($sql_fieldsetOrg);
      } else if ($_POST['applnt_type'] == "2") {
        $passed_Naturalpersondetail = unserialize($_POST['Naturalperson_Allvalue']);
        $sql_fieldsetNatural = "UPDATE `Field_Values` 
          SET `case_id` = '" . $last_case . "',`fieldset_id` = '7', `fieldset_value` = '" . $passed_Naturalpersondetail[0] . "' WHERE `case_id` = '" . $last_case . "' AND `fieldset_id` = '7'";
        $conn->query($sql_fieldsetNatural);
      }
    }

    if ($fId_a == 2) {
      if ($_POST['rdi_compTypeSub1'] == 1) {
        if ($_POST['Appint_OrgSelect'] == "1") {
          $passed_Representdetail = unserialize($_POST['Represent_Allvalue']);
          $sql_fieldsetOrg = "INSERT INTO `Field_Values` (`case_id`, `fieldset_id`, `fieldset_value`) VALUES 
            ('$last_case', '67', '" . $passed_Representdetail[0] . "'),
            ('$last_case', '68', '" . $passed_Representdetail[1] . "'),
            ('$last_case', '69', '" . $passed_Representdetail[2] . "'),
            ('$last_case', '70', '" . $passed_Representdetail[3] . "'),
            ('$last_case', '71', '" . $passed_Representdetail[4] . "'),
            ('$last_case', '72', '" . $passed_Representdetail[5] . "'),
            ('$last_case', '230', '" . $passed_Representdetail[6] . "'),
            ('$last_case', '74', '" . $passed_Representdetail[7] . "'),
            ('$last_case', '75', '" . $passed_Representdetail[8] . "'),
            ('$last_case', '76', '" . $passed_Representdetail[9] . "')";
          $conn->query($sql_fieldsetOrg);
        } else if ($_POST['Appint_OrgSelect'] == "2") {
          $passed_Naturalpersondetail = unserialize($_POST['Naturalperson_Allvalue']);
          $sql_fieldsetNatural = "UPDATE `Field_Values` 
          SET `case_id` = '" . $last_case . "',`fieldset_id` = '57', `fieldset_value` = '" . $passed_Naturalpersondetail[0] . "' WHERE `case_id` = '" . $last_case . "' AND `fieldset_id` = '57'";
          $conn->query($sql_fieldsetNatural);
        }
      }
    } else if ($fId_a == 9) {
      if ($_POST['applnt_type'] == "1") {
        $passed_Representdetail = unserialize($_POST['Represent_Allvalue']);
        $sql_fieldsetOrg = "INSERT INTO `Field_Values` (`case_id`, `fieldset_id`, `fieldset_value`) VALUES 
          ('$last_case', '165', '" . $passed_Representdetail[0] . "'),
          ('$last_case', '166', '" . $passed_Representdetail[1] . "'),
          ('$last_case', '167', '" . $passed_Representdetail[2] . "'),
          ('$last_case', '168', '" . $passed_Representdetail[4] . "'),
          ('$last_case', '169', '" . $passed_Representdetail[3] . "'),
          ('$last_case', '170', '" . $passed_Representdetail[5] . "'),
          ('$last_case', '230', '" . $passed_Representdetail[6] . "'),
          ('$last_case', '172', '" . $passed_Representdetail[7] . "'),
          ('$last_case', '173', '" . $passed_Representdetail[8] . "'),
          ('$last_case', '174', '" . $passed_Representdetail[9] . "')";
        $conn->query($sql_fieldsetOrg);
      } else if ($_POST['applnt_type'] == "2") {
        $passed_Naturalpersondetail = unserialize($_POST['Naturalperson_Allvalue']);
        $sql_fieldsetNatural = "UPDATE `Field_Values` 
          SET `case_id` = '" . $last_case . "',`fieldset_id` = '155', `fieldset_value` = '" . $passed_Naturalpersondetail[0] . "' WHERE `case_id` = '" . $last_case . "' AND `fieldset_id` = '155'";
        $conn->query($sql_fieldsetNatural);
      }
    }

    $caseAttach_file_name = $_POST['caseAttach_file_name'];
    $new_fileadrss = $_POST['new_fileadrss'];

    $a = 0;
    $value_name_arr = array();
    foreach ($caseAttach_file_name as $value_name) {
      $value_name_arr[$a] = $value_name;
      $a++;
    }
    $c = 0;
    $value_oldname_arr = array();
    foreach ($new_fileadrss as $value_oldname) {
      $value_oldname_arr[$c] = $value_oldname;
      $c++;
    }

    if (!is_dir("../../data/case_attach/" . $last_case)) {
      mkdir("../../data/case_attach/" . $last_case, 0775, true);
    } else {
      deleteDirectory("../../data/case_attach/" . $last_case);
      mkdir("../../data/case_attach/" . $last_case, 0775, true);
    }

    $file = glob("../../data/case_attach_tmp/" . $_SESSION['member_id'] . "/*.*");
    $i = 0;
    foreach ($file as $value) {
      $sn_ex = explode("/", $value);
      $sn_type = explode(".", $sn_ex[5]);

      $new_file = "caseAttach_file_" . $last_case . "_" . time() . "_" . $i . "." . $sn_type[1];
      $pathfile = "data/case_attach/" . $last_case . "/" . $new_file;
      $data = "../../data/case_attach/" . $last_case . "/" . $new_file;
      $sql_att = "INSERT INTO `Case_Attachfile`
  (case_id,caseAttach_title,caseAttach_file_path,caseAttach_file_oldname,caseAttach_file_name,caseAttach_file_ext,caseAttach_status,caseAttach_create_datetime,caseAttach_createBy_id)
  VALUES ('" . $last_case . "','" . $value_name_arr[$i] . "','" . $pathfile . "','" . $value_oldname_arr[$i] . "','" . $new_file . "','" . $extension . "','0','" . $date_time . "','" . $_SESSION['member_id'] . "')";
      $query_att = $conn->query($sql_att);
      copy($value, $data);
      $i++;
    }

    deleteDirectory("../../data/case_attach_tmp/" . $_SESSION['member_id']);

    $Appint_personDetail = unserialize($_POST['Appint_personDetail']);
    $Naturalperson_Allvalue = unserialize($_POST['Naturalperson_Allvalue']);


    if ($_POST['applnt_type'] == "2") {
      if ($Appint_personDetail[8] == "162") {
        $Country_type = "1";
      } else {
        $Country_type = "2";
      }

      if ($_POST['formSetId_b'] != "7") {
        $department = "1";
      } else {
        $department = "2";
      }

      if ($Appint_personDetail[4] != "") {
        $where = " AND ct_card = '" . $Appint_personDetail[4] . "' AND ct_section = '" . $_POST['compType_section'] . "' AND ct_type = '" . $Country_type . "' AND ct_department = '" . $department . "' AND ct_comp_type = 1";
      } else {
        $where = " AND ct_firstname = '" . $Appint_personDetail[2] . "' AND ct_lastname = '" . $Appint_personDetail[3] . "' AND ct_type = '" . $Country_type . "' AND ct_department = '" . $department . "' AND ct_comp_type = 1";
      }

      $sql_Contact = "SELECT * FROM `Contact_thai` WHERE 1 $where";
      $query_Contact = $conn->query($sql_Contact);
      if ($query_Contact->num_rows > 0) {
        $re = $query_Contact->fetch_assoc();
        $sql_upcont = "UPDATE Contact_thai SET
      ct_card = '" . $Appint_personDetail[4] . "',
      ct_firstname = '" . $Appint_personDetail[2] . "',
      ct_lastname = '" . $Appint_personDetail[3] . "',
      ct_business_type = '" . $_POST['applntOrg_import_export'] . "',
      ct_career = '" . $Naturalperson_Allvalue[0] . "',
      ct_homephone = '" . $Appint_personDetail[5] . "',
      ct_cellphone = '" . $Appint_personDetail[5] . "',
      ct_email = '" . $Appint_personDetail[6] . "',
      ct_address = '" . $Appint_personDetail[7] . "',
      prov_id = '" . $_POST['applnt_prov_id'] . "',
      ct_postcode = '" . $Appint_personDetail[9] . "',
      Country_id = '" . $Appint_personDetail[8] . "',
      ct_import = '0',
      ct_updateBy_id = '" . $_SESSION['member_id'] . "',
      ct_update_datetime = '" . $date_time . "',
      ct_status = '0' WHERE ct_id = '" . $re['ct_id'] . "'";
        $query_upcont = $conn->query($sql_upcont);
      } else {
        $sql_incont = "INSERT INTO Contact_thai
      (ct_section,ct_type,ct_department,ct_comp_type,ct_card,ct_firstname,ct_lastname,ct_business_type,ct_career,ct_homephone,ct_cellphone,
        ct_email,ct_address,prov_id,ct_postcode,Country_id,ct_import,ct_create_datetime,ct_createBy_id,ct_status)
      VALUES ('" . $_POST['compType_section'] . "','" . $Country_type . "','" . $department . "','1','" . $Appint_personDetail[4] . "','" . $Appint_personDetail[2] . "',
      '" . $Appint_personDetail[3] . "','" . $_POST['applntOrg_import_export'] . "','" . $Naturalperson_Allvalue[0] . "','" . $Appint_personDetail[5] . "',
      '" . $Appint_personDetail[5] . "','" . $Appint_personDetail[6] . "','" . $Appint_personDetail[7] . "','" . $_POST['applnt_prov_id'] . "',
      '" . $Appint_personDetail[9] . "','" . $Appint_personDetail[8] . "','0','" . $date_time . "','" . $_SESSION['member_id'] . "','0')";
        $query_incont = $conn->query($sql_incont);
      }

      if ($_POST['complnt_country_id'] == "162") {
        $country_co = "1";
      } else {
        $country_co = "2";
      }

      if ($_POST['complnt_trade_number'] != "") {
        $where_co = " AND cpr_numbertrade = '" . $_POST['complnt_trade_number'] . "' AND cpr_section = '" . $_POST['compType_section'] . "' AND cpr_type = '" . $country_co . "' AND cpr_comp_type = 2";
      } else {
        $where_co = " AND cpr_companyname = '" . $_POST['complnt_name'] . "' AND cpr_section = '" . $_POST['compType_section'] . "' AND cpr_type = '" . $country_co . "' AND cpr_comp_type = 2";
      }

      $sql_Contact_sub = "SELECT * FROM `Corporate` WHERE 1 $where_co";
      $query_Contact_sub = $conn->query($sql_Contact_sub);

      if ($query_Contact_sub->num_rows > 0) {
        $rs = $query_Contact_sub->fetch_assoc();
        $sql_upcont_sub = "UPDATE Corporate SET
      cpr_numbertrade = '" . $_POST['complnt_trade_number'] . "',
      cpr_companyname = '" . $_POST['complnt_name'] . "',
      cpr_type_import_export = '" . $_POST['complnt_import_export'] . "',
      cpr_branch = '" . $_POST['complnt_branch'] . "',
      cpr_telephone = '" . $_POST['complnt_contact_tel'] . "',
      cpr_email = '" . $_POST['complnt_contact_email'] . "',
      cpr_address = '" . $_POST['complnt_contact_address'] . "',
      prov_id = '" . $_POST['complnt_prov_id'] . "',
      cpr_zipcode = '" . $_POST['complnt_zipcode'] . "',
      Country_id = '" . $_POST['complnt_country_id'] . "',
      cpr_contact_person = '" . $_POST['complnt_contact_name'] . "',
      cpr_import = '0',
      cpr_updateBy_id = '" . $_SESSION['member_id'] . "',
      cpr_update_datetime = '" . $date_time . "',
      cpr_status = '0' WHERE cpr_id = '" . $rs['cpr_id'] . "'";
        $query_upcont_sub = $conn->query($sql_upcont_sub);
      } else {
        $sql_incont_sub = "INSERT INTO Corporate
      (cpr_section,cpr_type,cpr_comp_type,cpr_numbertrade,cpr_companyname,cpr_type_import_export,cpr_branch,cpr_telephone,cpr_email,cpr_address,prov_id,
        cpr_zipcode,Country_id,cpr_contact_person,cpr_import,cpr_create_datetime,cpr_createBy_id,cpr_status)
      VALUES ('" . $_POST['compType_section'] . "','" . $country_co . "','2','" . $_POST['complnt_trade_number'] . "','" . $_POST['complnt_name'] . "','" . $_POST['complnt_import_export'] . "',
      '" . $_POST['complnt_branch'] . "','" . $_POST['complnt_contact_tel'] . "','" . $_POST['complnt_contact_email'] . "','" . $_POST['complnt_contact_address'] . "',
      '" . $_POST['complnt_prov_id'] . "','" . $_POST['complnt_zipcode'] . "','" . $_POST['complnt_country_id'] . "','" . $_POST['complnt_contact_name'] . "',
      '0','" . $date_time . "','" . $_SESSION['member_id'] . "','0')";
        $query_incont_sub = $conn->query($sql_incont_sub);
      }
    } else {
      if ($_POST['applnt_country_id'] == "162") {
        $country = "1";
      } else {
        $country = "2";
      }

      if ($_POST['formSetId_b'] != "7") {
        $department = "1";
      } else {
        $department = "2";
      }

      if ($_POST['applntOrg_trade_number'] != "") {
        $where = " AND cpr_numbertrade = '" . $_POST['applntOrg_trade_number'] . "' AND cpr_section = '" . $_POST['compType_section'] . "' AND cpr_type = '" . $country . "'  AND cpr_comp_type = 1";
      } else {
        $where = " AND cpr_companyname = '" . $_POST['applntOrg_name'] . "' AND cpr_section = '" . $_POST['compType_section'] . "' AND cpr_type = '" . $country . "' AND cpr_comp_type = 1";
      }

      $sql_Contact = "SELECT * FROM `Corporate` WHERE 1 $where";
      $query_Contact = $conn->query($sql_Contact);
      if ($query_Contact->num_rows > 0) {
        $re = $query_Contact->fetch_assoc();
        $sql_upcont = "UPDATE Corporate SET
      cpr_numbertrade = '" . $_POST['applntOrg_trade_number'] . "',
      cpr_companyname = '" . $_POST['applntOrg_name'] . "',
      cpr_type_import_export = '" . $_POST['applntOrg_import_export'] . "',
      cpr_branch = '" . $_POST['applntOrg_branch'] . "',
      cpr_telephone = '" . $_POST['applntOrg_tel'] . "',
      cpr_web = '" . $_POST['applntOrg_web'] . "',
      cpr_email = '" . $_POST['applnt_email'] . "',
      cpr_address = '" . $_POST['applntOrg_address'] . "',
      prov_id = '" . $_POST['applntOrg_prov_id'] . "',
      cpr_zipcode = '" . $_POST['applntOrg_zipcode'] . "',
      cpr_department = '" . $_POST['applnt_type'] . "',
      cpr_contactfname = '" . $_POST['applnt_firstname'] . "',
      cpr_contactlname = '" . $_POST['applnt_lastname'] . "',
      Country_id = '" . $_POST['applnt_country_id'] . "',
      cpr_import = '0',
      cpr_update_datetime = '" . $date_time . "',
      cpr_updateBy_id = '" . $_SESSION['member_id'] . "',
      cpr_status = '0' WHERE cpr_id = '" . $re['cpr_id'] . "'";
        $query_upcont = $conn->query($sql_upcont);
      } else {
        $sql_incont = "INSERT INTO Corporate
      (cpr_section,
        cpr_type,
        cpr_comp_type,
        cpr_numbertrade,
        cpr_companyname,
        cpr_type_import_export,
        cpr_branch,
        cpr_telephone,
        cpr_web,
        cpr_email,
        cpr_address,
        prov_id,
        cpr_zipcode,
        cpr_department,
        cpr_contactfname,
        cpr_contactlname,
        Country_id,
        cpr_import,
        cpr_create_datetime,
        cpr_createBy_id,
        cpr_status)
      VALUES ('" . $_POST['compType_section'] . "',
      '" . $country . "',
      '" . $department . "',
      '" . $_POST['applntOrg_trade_number'] . "',
      '" . $_POST['applntOrg_name'] . "',
      '" . $_POST['applntOrg_import_export'] . "',
      '" . $_POST['applntOrg_branch'] . "',
      '" . $_POST['applntOrg_tel'] . "',
      '" . $_POST['applntOrg_web'] . "',
      '" . $_POST['applnt_email'] . "',
      '" . $_POST['applntOrg_address'] . "',
      '" . $_POST['applntOrg_prov_id'] . "',
      '" . $_POST['applntOrg_zipcode'] . "',
      '" . $_POST['applnt_type'] . "',
      '" . $_POST['applnt_firstname'] . "',
      '" . $_POST['applnt_lastname'] . "',
      '" . $_POST['applnt_country_id'] . "',
      '0',
      '" . $date_time . "',
      '" . $_SESSION['member_id'] . "',
      '0')";
        $query_incont = $conn->query($sql_incont);
      }

      if ($_POST['complnt_country_id'] == "162") {
        $country_co = "1";
      } else {
        $country_co = "2";
      }

      if ($_POST['complnt_trade_number'] != "") {
        $where_co = " AND cpr_numbertrade = '" . $_POST['complnt_trade_number'] . "' AND cpr_section = '" . $_POST['compType_section'] . "' AND cpr_type = '" . $country_co . "' AND cpr_comp_type = 2";
      } else {
        $where_co = " AND cpr_companyname = '" . $_POST['complnt_name'] . "' AND cpr_section = '" . $_POST['compType_section'] . "' AND cpr_type = '" . $country_co . "' AND cpr_comp_type = 2";
      }

      $sql_Contact_sub = "SELECT * FROM `Corporate` WHERE 1 $where_co";
      $query_Contact_sub = $conn->query($sql_Contact_sub);
      if ($query_Contact_sub->num_rows > 0) {
        $rs = $query_Contact_sub->fetch_assoc();
        $sql_upcont_sub = "UPDATE Corporate SET
      cpr_numbertrade = '" . $_POST['complnt_trade_number'] . "',
      cpr_companyname = '" . $_POST['complnt_name'] . "',
      cpr_type_import_export = '" . $_POST['complnt_import_export'] . "',
      cpr_branch = '" . $_POST['complnt_branch'] . "',
      cpr_telephone = '" . $_POST['complnt_contact_tel'] . "',
      cpr_email = '" . $_POST['complnt_contact_email'] . "',
      cpr_address = '" . $_POST['complnt_contact_address'] . "',
      prov_id = '" . $_POST['complnt_prov_id'] . "',
      cpr_zipcode = '" . $_POST['complnt_zipcode'] . "',
      Country_id = '" . $_POST['complnt_country_id'] . "',
      cpr_contact_person = '" . $_POST['complnt_contact_name'] . "',
      cpr_import = '0',
      cpr_updateBy_id = '" . $_SESSION['member_id'] . "',
      cpr_update_datetime = '" . $date_time . "',
      cpr_status = '0' WHERE cpr_id = '" . $rs['cpr_id'] . "'";
        $query_upcont_sub = $conn->query($sql_upcont_sub);
      } else {
        $sql_incont_sub = "INSERT INTO Corporate
      (cpr_section,cpr_type,cpr_comp_type,cpr_numbertrade,cpr_companyname,cpr_type_import_export,cpr_branch,cpr_telephone,cpr_email,cpr_address,prov_id,
        cpr_zipcode,Country_id,cpr_contact_person,cpr_import,cpr_create_datetime,cpr_createBy_id,cpr_status)
      VALUES ('" . $_POST['compType_section'] . "','" . $country_co . "','2','" . $_POST['complnt_trade_number'] . "','" . $_POST['complnt_name'] . "','" . $_POST['complnt_import_export'] . "',
      '" . $_POST['complnt_branch'] . "','" . $_POST['complnt_contact_tel'] . "','" . $_POST['complnt_contact_email'] . "','" . $_POST['complnt_contact_address'] . "',
      '" . $_POST['complnt_prov_id'] . "','" . $_POST['complnt_zipcode'] . "','" . $_POST['complnt_country_id'] . "','" . $_POST['complnt_contact_name'] . "',
      '0','" . $date_time . "','" . $_SESSION['member_id'] . "','0')";
        $query_incont_sub = $conn->query($sql_incont_sub);
      }
    }

    /*
  if($_POST['applnt_type'] == "0"){ //บุคคลธรรมดา

      if($_POST['applnt_country_id'] == "162"){
        $country = "1";
      }else {
        $country = "2";
      }
      
      if($_POST['formSetId_b'] != "7"){
        $department = "1";
      }else {
        $department = "2";
      }

      if($_POST['applnt_ident'] != ""){
        $where = " AND ct_card = '".$_POST['applnt_ident']."' AND ct_section = '".$_POST['compType_section']."' AND ct_type = '".$country."' AND ct_department = '".$department."' AND ct_comp_type = 1";
      }else {
        $where = " AND ct_firstname = '".$_POST['applnt_firstname']."' AND ct_lastname = '".$_POST['applnt_lastname']."' AND ct_section = '".$_POST['compType_section']."' AND ct_type = '".$country."' AND ct_department = '".$department."' AND ct_comp_type = 1";
      }
      $sql_Contact = "SELECT * FROM `Contact_thai` WHERE 1 $where";
      $query_Contact = $conn->query($sql_Contact);
      if($query_Contact->num_rows > 0){
        $re = $query_Contact->fetch_assoc();
        $sql_upcont = "UPDATE Contact_thai SET
        ct_card = '".$_POST['applnt_ident']."',
        ct_firstname = '".$_POST['applnt_firstname']."',
        ct_lastname = '".$_POST['applnt_lastname']."',
        ct_sex = '".$_POST['sex']."',
        ct_career = '".$_POST['applnt_career']."',
        ct_homephone = '".$_POST['applnt_tel']."',
        ct_cellphone = '".$_POST['applnt_mobile']."',
        ct_email = '".$_POST['applnt_email']."',
        ct_address = '".$_POST['applnt_address']."',
        prov_id = '".$_POST['applnt_prov_id']."',
        ct_postcode = '".$_POST['applnt_zipcode']."',
        Country_id = '".$_POST['applnt_country_id']."',
        ct_import = '0',
        ct_updateBy_id = '".$_SESSION['member_id']."',
        ct_update_datetime = '".$date_time."',
        ct_status = '0' WHERE ct_id = '".$re['ct_id']."'";
        $query_upcont = $conn->query($sql_upcont);
      }else {
        $sql_incont = "INSERT INTO Contact_thai
        (ct_section,ct_type,ct_department,ct_comp_type,ct_card,ct_firstname,ct_lastname,ct_sex,ct_career,ct_homephone,ct_cellphone,
          ct_email,ct_address,prov_id,ct_postcode,Country_id,ct_import,ct_create_datetime,ct_createBy_id,ct_status)
        VALUES ('".$_POST['compType_section']."','".$country."','".$department."','1','".$_POST['applnt_ident']."','".$_POST['applnt_firstname']."',
        '".$_POST['applnt_lastname']."','".$_POST['sex']."','".$_POST['applnt_career']."','".$_POST['applnt_tel']."',
        '".$_POST['applnt_mobile']."','".$_POST['applnt_email']."','".$_POST['applnt_address']."','".$_POST['applnt_prov_id']."',
        '".$_POST['applnt_zipcode']."','".$_POST['applnt_country_id']."','0','".$date_time."','".$_SESSION['member_id']."','0')";
        $query_incont = $conn->query($sql_incont);
      }


      //ผู้ถูกร้องเรียน
      if($_POST['complnt_country_id'] == "162"){
        $country_co = "1";
      }else {
        $country_co = "2";
      }

      if($_POST['complnt_trade_number'] != ""){
        $where_co = " AND cpr_numbertrade = '".$_POST['complnt_trade_number']."' AND cpr_section = '".$_POST['compType_section']."' AND cpr_type = '".$country_co."' AND cpr_comp_type = 2";
      }else {
        $where_co = " AND cpr_companyname = '".$_POST['complnt_name']."' AND cpr_section = '".$_POST['compType_section']."' AND cpr_type = '".$country_co."' AND cpr_comp_type = 2";
      }
      $sql_Contact_sub = "SELECT * FROM `Corporate` WHERE 1 $where_co";
      $query_Contact_sub = $conn->query($sql_Contact_sub);
      if($query_Contact_sub->num_rows > 0){
        $rs = $query_Contact_sub->fetch_assoc();
        $sql_upcont_sub = "UPDATE Corporate SET
        cpr_numbertrade = '".$_POST['complnt_trade_number']."',
        cpr_companyname = '".$_POST['complnt_name']."',
        cpr_type_import_export = '".$_POST['complnt_import_export']."',
        cpr_branch = '".$_POST['complnt_branch']."',
        cpr_telephone = '".$_POST['complnt_contact_tel']."',
        cpr_email = '".$_POST['complnt_contact_email']."',
        cpr_address = '".$_POST['complnt_contact_address']."',
        prov_id = '".$_POST['complnt_prov_id']."',
        cpr_zipcode = '".$_POST['complnt_zipcode']."',
        Country_id = '".$_POST['complnt_country_id']."',
        cpr_contact_person = '".$_POST['complnt_contact_name']."',
        cpr_import = '0',
        cpr_updateBy_id = '".$_SESSION['member_id']."',
        cpr_update_datetime = '".$date_time."',
        cpr_status = '0' WHERE cpr_id = '".$rs['cpr_id']."'";
        $query_upcont_sub = $conn->query($sql_upcont_sub);
      }else {
        $sql_incont_sub = "INSERT INTO Corporate
        (cpr_section,cpr_type,cpr_comp_type,cpr_numbertrade,cpr_companyname,cpr_type_import_export,cpr_branch,cpr_telephone,cpr_email,cpr_address,prov_id,
          cpr_zipcode,Country_id,cpr_contact_person,cpr_import,cpr_create_datetime,cpr_createBy_id,cpr_status)
        VALUES ('".$_POST['compType_section']."','".$country_co."','2','".$_POST['complnt_trade_number']."','".$_POST['complnt_name']."','".$_POST['complnt_import_export']."',
        '".$_POST['complnt_branch']."','".$_POST['complnt_contact_tel']."','".$_POST['complnt_contact_email']."','".$_POST['complnt_contact_address']."',
        '".$_POST['complnt_prov_id']."','".$_POST['complnt_zipcode']."','".$_POST['complnt_country_id']."','".$_POST['complnt_contact_name']."',
        '0','".$date_time."','".$_SESSION['member_id']."','0')";
        $query_incont_sub = $conn->query($sql_incont_sub);
      }
  }else { //ตัวแทนบริษัท

    if($_POST['applnt_country_id'] == "162"){
      $country = "1";
    }else {
      $country = "2";
    }
    if($_POST['formSetId_b'] != "7"){
      $department = "1";
    }else {
      $department = "2";
    }

    if($_POST['applntOrg_trade_number'] != ""){
      $where = " AND cpr_numbertrade = '".$_POST['applntOrg_trade_number']."' AND cpr_section = '".$_POST['compType_section']."' AND cpr_type = '".$country."'  AND cpr_comp_type = 1";
    }else {
      $where = " AND cpr_companyname = '".$_POST['applntOrg_name']."' AND cpr_section = '".$_POST['compType_section']."' AND cpr_type = '".$country."' AND cpr_comp_type = 1";
    }
    $sql_Contact = "SELECT * FROM `Corporate` WHERE 1 $where";
    $query_Contact = $conn->query($sql_Contact);
    if($query_Contact->num_rows > 0){
      $re = $query_Contact->fetch_assoc();
      $sql_upcont = "UPDATE Corporate SET
      cpr_numbertrade = '".$_POST['applntOrg_trade_number']."',
      cpr_companyname = '".$_POST['applntOrg_name']."',
      cpr_type_import_export = '".$_POST['applntOrg_import_export']."',
      cpr_branch = '".$_POST['applntOrg_branch']."',
      cpr_telephone = '".$_POST['applntOrg_tel']."',
      cpr_fax = '".$_POST['applntOrg_fax']."',
      cpr_email = '".$_POST['applnt_email']."',
      cpr_address = '".$_POST['applntOrg_address']."',
      prov_id = '".$_POST['applntOrg_prov_id']."',
      cpr_zipcode = '".$_POST['applntOrg_zipcode']."',
      cpr_department = '".$_POST['applnt_type']."',
      cpr_contactfname = '".$_POST['applnt_firstname']."',
      cpr_contactlname = '".$_POST['applnt_lastname']."',
      Country_id = '".$_POST['applnt_country_id']."',
      cpr_import = '0',
      cpr_update_datetime = '".$date_time."',
      cpr_updateBy_id = '".$_SESSION['member_id']."',
      cpr_status = '0' WHERE cpr_id = '".$re['cpr_id']."'";
      $query_upcont = $conn->query($sql_upcont);
    }else {
      $sql_incont = "INSERT INTO Corporate
      (cpr_section,
        cpr_type,
        cpr_comp_type,
        cpr_numbertrade,
        cpr_companyname,
        cpr_type_import_export,
        cpr_branch,
        cpr_telephone,
        cpr_fax,
        cpr_email,
        cpr_address,
        prov_id,
        cpr_zipcode,
        cpr_department,
        cpr_contactfname,
        cpr_contactlname,
        Country_id,
        cpr_import,
        cpr_create_datetime,
        cpr_createBy_id,
        cpr_status)
      VALUES ('".$_POST['compType_section']."',
      '".$country."',
      '".$department."',
      '".$_POST['applntOrg_trade_number']."',
      '".$_POST['applntOrg_name']."',
      '".$_POST['applntOrg_import_export']."',
      '".$_POST['applntOrg_branch']."',
      '".$_POST['applntOrg_tel']."',
      '".$_POST['applntOrg_fax']."',
      '".$_POST['applnt_email']."',
      '".$_POST['applntOrg_address']."',
      '".$_POST['applntOrg_prov_id']."',
      '".$_POST['applntOrg_zipcode']."',
      '".$_POST['applnt_type']."',
      '".$_POST['applnt_firstname']."',
      '".$_POST['applnt_lastname']."',
      '".$_POST['applnt_country_id']."',
      '0',
      '".$date_time."',
      '".$_SESSION['member_id']."',
      '0')";
      $query_incont = $conn->query($sql_incont);
    }


  //ผู้ถูกร้องเรียน

  if($_POST['complnt_country_id'] == "162"){
  $country_co = "1";
  }else {
  $country_co = "2";
  }

  if($_POST['complnt_trade_number'] != ""){
  $where_co = " AND cpr_numbertrade = '".$_POST['complnt_trade_number']."' AND cpr_section = '".$_POST['compType_section']."' AND cpr_type = '".$country_co."' AND cpr_comp_type = 2";
  }else {
  $where_co = " AND cpr_companyname = '".$_POST['complnt_name']."' AND cpr_section = '".$_POST['compType_section']."' AND cpr_type = '".$country_co."' AND cpr_comp_type = 2";
  }
  $sql_Contact_sub = "SELECT * FROM `Corporate` WHERE 1 $where_co";
  $query_Contact_sub = $conn->query($sql_Contact_sub);
  if($query_Contact_sub->num_rows > 0){
  $rs = $query_Contact_sub->fetch_assoc();
  $sql_upcont_sub = "UPDATE Corporate SET
  cpr_numbertrade = '".$_POST['complnt_trade_number']."',
  cpr_companyname = '".$_POST['complnt_name']."',
  cpr_type_import_export = '".$_POST['complnt_import_export']."',
  cpr_branch = '".$_POST['complnt_branch']."',
  cpr_telephone = '".$_POST['complnt_contact_tel']."',
  cpr_email = '".$_POST['complnt_contact_email']."',
  cpr_address = '".$_POST['complnt_contact_address']."',
  prov_id = '".$_POST['complnt_prov_id']."',
  cpr_zipcode = '".$_POST['complnt_zipcode']."',
  Country_id = '".$_POST['complnt_country_id']."',
  cpr_contact_person = '".$_POST['complnt_contact_name']."',
  cpr_import = '0',
  cpr_updateBy_id = '".$_SESSION['member_id']."',
  cpr_update_datetime = '".$date_time."',
  cpr_status = '0' WHERE cpr_id = '".$rs['cpr_id']."'";
  $query_upcont_sub = $conn->query($sql_upcont_sub);
  }else {
  $sql_incont_sub = "INSERT INTO Corporate
  (cpr_section,cpr_type,cpr_comp_type,cpr_numbertrade,cpr_companyname,cpr_type_import_export,cpr_branch,cpr_telephone,cpr_email,cpr_address,prov_id,
    cpr_zipcode,Country_id,cpr_contact_person,cpr_import,cpr_create_datetime,cpr_createBy_id,cpr_status)
  VALUES ('".$_POST['compType_section']."','".$country_co."','2','".$_POST['complnt_trade_number']."','".$_POST['complnt_name']."','".$_POST['complnt_import_export']."',
  '".$_POST['complnt_branch']."','".$_POST['complnt_contact_tel']."','".$_POST['complnt_contact_email']."','".$_POST['complnt_contact_address']."',
  '".$_POST['complnt_prov_id']."','".$_POST['complnt_zipcode']."','".$_POST['complnt_country_id']."','".$_POST['complnt_contact_name']."',
  '0','".$date_time."','".$_SESSION['member_id']."','0')";
  $query_incont_sub = $conn->query($sql_incont_sub);
  }
  }
  */

    $mail = new email();
    $status_can_send = true;
    $sendMail = array();
    $to_email = array();
    $to_name = array();
    foreach (emp_get_manager($office, $_POST['rdi_compType_id']) as $manager) {
      array_push($to_email, $manager["emp_email"]);
      array_push($to_name, $manager["emp_firstname"] . " " . $manager["emp_lastname"]);
    }
    $mail->to_email = $to_email;
    $mail->to_name = $to_name;
    $mail->subject = "ท่านได้รับเรื่องร้องเรียน Case ID: " . sprintf("%05d", $last_case) . " จากผู้ประกอบการผ่านเว็บไซต์ DITP Care ";
    $mail->message =  "ท่านได้รับเรื่องร้องเรียน <a href=\"http://" . $_SERVER["HTTP_HOST"] . "/backoffice/index.php?page=case_detail&caseId=" . $last_case . "\">Case ID: " . sprintf("%05d", $last_case) . "</a> จากผู้ประกอบการผ่านเว็บไซต์ DITP Care ท่านสามารถดำเนินการรับเรื่องร้องเรียนได้ที่ <a href=\"http://" . $_SERVER["HTTP_HOST"] . "/backoffice/index.php?page=case_detail&caseId=" . $last_case . "\">http://" . $_SERVER["HTTP_HOST"] . "/backoffice/index.php?page=case_detail&caseId=" . $last_case . "</a>";
    // $sendMail = $mail->send_email();
    //print_r($sendMail);

    $output['status_response'] = "00";
?>
    <script>
      window.parent.bootbox.alert('บันทึกเรื่องร้องเรียนเรียบร้อยแล้ว', function() {
        top.window.location = '/frontend/index.php?page=appeal';
      });
    </script>
  <?
  } else {
    // $output['status_response'] = "01";
  ?>
    <script>
      window.parent.bootbox.alert('ประเภทเรื่องร้องเรียนไม่มีอยู่ในระบบ', function() {
        top.window.location = '/frontend/index.php?page=invite';
      });
    </script>
  <?
  }
  // echo json_encode( $output );

}

function lang($lang)
{
  include('../config/config.php');
  /* $sql ="UPDATE Member SET member_lang='$lang' WHERE member_id = '".$_SESSION['member_id']."'";
  $query = $conn->query($sql); */
  $member_lang = $lang;
  $member_id = $_SESSION['member_id'];

  $sql = "UPDATE Member SET member_lang = ? WHERE member_id = ?";
  $stmt->prepare($sql);
  $stmt->bind_param("si", $member_lang, $member_id);
  $stmt->execute();
  $query = $stmt->get_result();
  ?>
  <script>
    window.location = '../index.php?page=home';
  </script>
  <?
}

function new_letter_case($txt_search)
{
  include('../config/config.php');

  $sql = "SELECT * FROM `Case` WHERE case_createBy_id = '" . $_SESSION['member_id'] . "' AND case_id LIKE '%$txt_search%'";
  $query = $conn->query($sql);
  if ($query->num_rows > 0) {
    $output = array();
    while ($rs = $query->fetch_assoc()) {
      $case = array();
      $case['name'] = $rs['case_id'];
      array_push($output, $case);
    }

    echo json_encode($output);
  }
  exit();
}


function edit_profile_modal()
{
  include('../config/config.php');
  $member_id = $_SESSION['member_id'];
  if ($_POST['member_type'] == "0") {
    $sql = "UPDATE `Member` SET
    member_fname = '" . $_POST['name_profile'] . "',
    member_lname = '" . $_POST['lastname_profile'] . "',
    member_cid = '" . $_POST['member_cid'] . "',
    member_sex = '" . $_POST['sex'] . "',
    member_occupation = '" . $_POST['member_occupation'] . "',
    member_phone = '" . $_POST['member_phone'] . "',
    member_cellphone = '" . $_POST['member_cellphone'] . "',
    member_address = '" . $_POST['member_address'] . "',
    country_id = '" . $_POST['country_id'] . "',
    prov_id = '" . $_POST['prov_id'] . "',
    prov_name_inter = '" . $_POST['prov_name_inter'] . "',
    member_postcode = '" . $_POST['member_postcode'] . "',
    tel_country_code = '" . $_POST['tel_country_code'] . "',
    tel_code = '" . $_POST['tel_code'] . "'
    WHERE member_id = '" . $member_id . "'";
    $query = $conn->query($sql);

    $file_data = $_POST['file'];
    if ($file_data != "") {
      list($type, $file_data) = explode(';', $file_data);
      list(, $extension) = explode('/', $type);
      list(, $file_data)      = explode(',', $file_data);
      $data = base64_decode($file_data);
      if (getimagesizefromstring($data) === false) {
        die("ไม่สามารถบันทึกรูปภาพ: ข้อมูลไม่ถูกต้อง");
      } else {
        if ($extension != "") {
          if (!is_dir("../../data/img_member/" . $member_id)) {
            mkdir("../../data/img_member/" . $member_id, 0775, true);
          } else {
            deleteDirectory('../../data/img_member/' . $member_id . '/');
            mkdir("../../data/img_member/" . $member_id, 0775, true);
          }
          if (!is_dir("../../data/img_member/" . $member_id . "/s")) {
            mkdir("../../data/img_member/" . $member_id . "/s", 0775, true);
          } else {
            deleteDirectory('../../data/img_member/' . $member_id . '/s/');
            mkdir("../../data/img_member/" . $member_id . "/s", 0775, true);
          }
          if (!is_dir("../../data/img_member/" . $member_id . "/l")) {
            mkdir("../../data/img_member/" . $member_id . "/l", 0775, true);
          } else {
            deleteDirectory('../../data/img_member/' . $member_id . '/l/');
            mkdir("../../data/img_member/" . $member_id . "/l", 0775, true);
          }
          $new_images = uniqid() . '.' . $extension;
          $file_size_s = "../../data/img_member/" . $member_id . "/s/";
          $file_size_l = "../../data/img_member/" . $member_id . "/l/";
          $file = "../../data/img_member/" . $member_id . "/" . $new_images;
          if ($extension != "") {
            $sql_update = "UPDATE `Member` SET `member_img` = '" . $new_images . "' WHERE `member_id` = '" . $member_id . "'";
            $query_update = $conn->query($sql_update);
          }
          file_put_contents($file, $data);

          $images = "../../data/img_member/" . $member_id . "/" . $new_images;
        } else {
          $images = "";
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
        $height = round($image_l_size * $h / $w);
        $photoX = ImagesX($images_orig);
        $photoY = ImagesY($images_orig);

        $images_fin = ImageCreateTrueColor($image_l_size, $height);
        // แก้พื้นหลังสีดำ
        imagealphablending($images_fin, false);
        imagesavealpha($images_fin, true);
        // แก้พื้นหลังสีดำ
        ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $image_l_size + 1, $height + 1, $photoX, $photoY);
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
        $heights = round($image_s_size * $h / $w);
        $photoXs = ImagesX($images_origs);
        $photoYs = ImagesY($images_origs);
        $images_fins = ImageCreateTrueColor($image_s_size, $heights);
        // แก้พื้นหลังสีดำ
        imagealphablending($images_fins, false);
        imagesavealpha($images_fins, true);
        // แก้พื้นหลังสีดำ
        ImageCopyResampled($images_fins, $images_origs, 0, 0, 0, 0, $image_s_size + 1, $heights + 1, $photoXs, $photoYs);
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
      }
    }
  } else {
    $sql = "UPDATE `Member` SET
    member_fname = '" . $_POST['name_profile'] . "',
    member_lname = '" . $_POST['lastname_profile'] . "',
    member_cid = '" . $_POST['member_cid'] . "',
    member_sex = '" . $_POST['sex'] . "',
    member_position = '" . $_POST['member_position'] . "',
    member_phone = '" . $_POST['member_phone'] . "',
    member_cellphone = '" . $_POST['member_cellphone'] . "',
    member_business = '" . $_POST['sel_business_person_office'] . "',
    member_address = '" . $_POST['member_address'] . "',
    country_id = '" . $_POST['country_id'] . "',
    prov_id = '" . $_POST['prov_id'] . "',
    prov_name_inter = '" . $_POST['prov_name_inter'] . "',
    member_postcode = '" . $_POST['member_postcode'] . "'
    WHERE member_id = '" . $member_id . "'";
    $query = $conn->query($sql);

    $sql_com = "UPDATE `Member_comp` SET
    member_comp_name = '" . $_POST['member_comp_name'] . "',
    member_comp_branch = '" . $_POST['member_comp_branch'] . "',
    member_comp_taxid = '" . $_POST['member_comp_taxid'] . "',
    member_comp_phone = '" . $_POST['member_comp_phone'] . "',
    member_comp_fax = '" . $_POST['member_comp_fax'] . "',
    member_comp_address = '" . $_POST['member_comp_address'] . "',
    country_id = '" . $_POST['country_id_com'] . "',
    prov_id = '" . $_POST['prov_id_com'] . "',
    prov_name_inter = '" . $_POST['prov_name_inter_com'] . "',
    member_comp_postcode = '" . $_POST['member_comp_postcode'] . "'
    WHERE member_id = '" . $member_id . "'";
    $query_com = $conn->query($sql_com);


    $sql_member = "SELECT * FROM `Member_comp` WHERE member_id = '" . $member_id . "'";
    $query_member = $conn->query($sql_member);
    $res = $query_member->fetch_assoc();

    $file_data = $_POST['file'];
    if ($file_data != "") {
      list($type, $file_data) = explode(';', $file_data);
      list(, $extension) = explode('/', $type);
      list(, $file_data)      = explode(',', $file_data);
      $data = base64_decode($file_data);
      if (getimagesizefromstring($data) === false) {
        die("ไม่สามารถบันทึกรูปภาพ: ข้อมูลไม่ถูกต้อง");
      } else {
        if ($extension != "") {
          if (!is_dir("../../data/img_membercom/" . $res['member_comp_id'])) {
            mkdir("../../data/img_membercom/" . $res['member_comp_id'], 0775, true);
          } else {
            deleteDirectory('../../data/img_membercom/' . $res['member_comp_id'] . '/');
            mkdir("../../data/img_membercom/" . $res['member_comp_id'], 0775, true);
          }
          if (!is_dir("../../data/img_membercom/" . $res['member_comp_id'] . "/s")) {
            mkdir("../../data/img_membercom/" . $res['member_comp_id'] . "/s", 0775, true);
          } else {
            deleteDirectory('../../data/img_membercom/' . $res['member_comp_id'] . '/s/');
            mkdir("../../data/img_membercom/" . $res['member_comp_id'] . "/s", 0775, true);
          }
          if (!is_dir("../../data/img_membercom/" . $res['member_comp_id'] . "/l")) {
            mkdir("../../data/img_membercom/" . $res['member_comp_id'] . "/l", 0775, true);
          } else {
            deleteDirectory('../../data/img_membercom/' . $res['member_comp_id'] . '/l/');
            mkdir("../../data/img_membercom/" . $res['member_comp_id'] . "/l", 0775, true);
          }
          $new_images = uniqid() . '.' . $extension;
          $file_size_s = "../../data/img_membercom/" . $res['member_comp_id'] . "/s/";
          $file_size_l = "../../data/img_membercom/" . $res['member_comp_id'] . "/l/";
          $file = "../../data/img_membercom/" . $res['member_comp_id'] . "/" . $new_images;
          if ($extension != "") {
            $sql_update = "UPDATE `Member_comp` SET `member_comp_img` = '" . $new_images . "' WHERE `member_comp_id` = '" . $res['member_comp_id'] . "'";
            $query_update = $conn->query($sql_update);
          }
          file_put_contents($file, $data);

          $images = "../../data/img_membercom/" . $res['member_comp_id'] . "/" . $new_images;
        } else {
          $images = "";
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
      }
    }
  }
}

function repassword()
{
  include('../config/config.php');
  $password = $_POST['password'];
  $newpassword = $_POST['newpassword'];
  $sql = "SELECT * FROM `Member` WHERE member_id = '" . $_SESSION['member_id'] . "'";
  $query = $conn->query($sql);
  if ($query->num_rows > 0) {
    $rs = $query->fetch_assoc();
    $password_hash = $rs['member_password'];
    if (PassHash::check_password($password_hash, $password)) {
      $sql_pass = "SELECT * FROM `Member` WHERE member_id = '" . $_SESSION['member_id'] . "' AND member_password='$password_hash'";
      $query_pass = $conn->query($sql_pass);
      if ($query_pass->num_rows > 0) {
        $output['pass_chk'] = "00";
        $password_hash_new = PassHash::hash($newpassword);
        $sql_re = "UPDATE `Member` SET member_password='" . $password_hash_new . "' WHERE member_id = '" . $_SESSION['member_id'] . "'";
        $query_re = $conn->query($sql_re);
      } else {
        $output['pass_chk'] = "01";
      }
    } else {
      $output['pass_chk'] = "02";
    }
  } else {
    $output['pass_chk'] = "03";
  }
  header("content-type:application/json;charset=utf-8");
  echo json_encode($output);
}

function hide_icon()
{
  include('../config/config.php');
  $date_time = date("Y-m-d H:i:s");
  $sql = "UPDATE `Message_Noti_App` SET msgNotiApp_read_status='1',msgNotiApp_read_datetime='" . $date_time . "' WHERE msgNotiApp_id='" . $_POST['msgNotiApp_id'] . "'";
  $query = $conn->query($sql);
}


function read_mesBox()
{
  include('../config/config.php');
  $date_time = date("Y-m-d H:i:s");
  $sql = "UPDATE `Message_Box_Log` SET msgBox_read_status='1',msgBox_read_datetime='" . $date_time . "' WHERE msgBox_id ='" . $_POST['msgBox_id'] . "' AND recipient_type = 1 AND recipient_id = '" . $_SESSION['member_id'] . "'";
  $query = $conn->query($sql);
}


function reply_letter($case_id)
{
  include('../config/config.php');

  if (isset($_POST['g-recaptcha-response'])) {
    $captcha = $_POST['g-recaptcha-response'];
  }
  if (!$captcha) {
  ?>
    <script type="text/javascript">
      window.parent.bootbox.alert('กรุณาระบุ Capcha เพือพิสูจน์บุคคล หากท่านไม่ใช่ หุ่นยนต์หรือสแปม', function() {
        window.parent.$('#wait_process').css('display', 'none');
      });
      //  top.window.location.href = '/frontend/index.php?page=reply_letter&msgBox_id=<?= $_POST['msgBox_id'] ?>';
    </script>
  <?php
    exit;
  }
  $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LdTxygUAAAAAKworPbcIzofBO0WZx-Z7Ur4wZdZ&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
  if ($response . success == false) {
  ?>
    <script type="text/javascript">
      window.parent.bootbox.alert('กรุณาระบุ Capcha ให้ถูกต้อง', function() {
        window.parent.$('#wait_process').css('display', 'none');
      });
      //  top.window.location.href = '/frontend/index.php?page=reply_letter&msgBox_id=<?= $_POST['msgBox_id'] ?>';
    </script>
  <?php
    exit;
  } else {
  }

  $date_time = date("Y-m-d H:i:s");
  $sql = "INSERT INTO `Message_Box` (msgBoxRef_id,msgBox_type,case_id,sender_id,sender_type,msgBox_message,msgBox_datetime)
  VALUES ('" . $_POST['msgBox_id'] . "','2','$case_id','" . $_SESSION['member_id'] . "','1','" . $_POST['txt_detail_reply'] . "','$date_time')";
  $query = $conn->query($sql);
  $last_id = $conn->insert_id;

  $sql_case = "SELECT c.case_id,ca.emp_id,ca.caseAsign_status,ca.emp_id FROM `Case` AS c
  LEFT JOIN `Case_Assign` AS ca ON c.case_id = ca.case_id
  WHERE c.case_id = '$case_id' AND ca.caseAsign_status = 0";
  $query_case = $conn->query($sql_case);
  if ($query_case->num_rows > 0) {
    while ($re = $query_case->fetch_assoc()) {
      $sql_log = "INSERT INTO `Message_Box_Log` (msgBox_id,recipient_id,recipient_type,msgBoxLog_datetime)
      VALUES ('" . $last_id . "','" . $re['emp_id'] . "','2','" . $date_time . "')";
      $query_log = $conn->query($sql_log);
    }
  }

  $caseAttach_file_name = $_POST['caseAttach_file_name'];
  $new_fileadrss = $_POST['new_fileadrss'];

  $a = 0;
  $value_name_arr = array();
  foreach ($caseAttach_file_name as $value_name) {
    $value_name_arr[$a] = $value_name;
    $a++;
  }
  $c = 0;
  $value_oldname_arr = array();
  foreach ($new_fileadrss as $value_oldname) {
    $value_oldname_arr[$c] = $value_oldname;
    $c++;
  }

  $file_data = $_POST['filePreview'];
  $i = 1;
  $b = 0;
  foreach ($file_data as $value) {
    list($type, $value) = explode(';', $value);
    list(, $extension) = explode('/', $type);
    list(, $value)      = explode(',', $value);
    $data = base64_decode($value);

    if (!is_dir("../../data/msg_attach/" . $last_id)) {
      mkdir("../../data/msg_attach/" . $last_id, 0775, true);
    } else {
      deleteDirectory("../../data/msg_attach/" . $last_id);
      mkdir("../../data/msg_attach/" . $last_id, 0775, true);
    }
    if ($extension == "vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
      $extension = "xlsx";
    } elseif ($extension == "vnd.openxmlformats-officedocument.wordprocessingml.document") {
      $extension = "docx";
    } elseif ($extension == "vnd.openxmlformats-officedocument.presentationml.presentation") {
      $extension = "ppt";
    } else {
      $extension = $extension;
    }
    $new_file = "msgAttach_file_" . $last_id . "_" . time() . "_" . $i . "." . $extension;
    $file = "../../data/msg_attach/" . $last_id . "/" . $new_file;
    $pathfile = "data/msg_attach/" . $last_id . "/" . $new_file;
    $sql_att = "INSERT INTO `Message_Box_Attachfile`
    (msgBox_id,msgBoxAttach_title,msgBoxAttach_file_path,msgBoxAttach_file_oldname,msgBoxAttach_file_name,msgBoxAttach_file_ext,msgBoxAttach_status,msgBoxAttach_create_datetime,msgBoxAttach_createBy_id)
    VALUES ('" . $last_id . "','" . $value_name_arr[$b] . "','" . $pathfile . "','" . $value_oldname_arr[$b] . "','" . $new_file . "','" . $extension . "','0','" . $date_time . "','" . $_SESSION['member_id'] . "')";
    $query_att = $conn->query($sql_att);
    file_put_contents($file, $data);
    $i++;
    $b++;
  }
  ?>
  <script>
    window.parent.bootbox.alert('บันทึกการตอบกลับเรียบร้อยแล้ว', function() {
      top.window.location = '/frontend/index.php?page=letter';
    });
  </script>
  <?
}

function del_msgBox()
{
  include('../config/config.php');
  $sql = "UPDATE `Message_Box` SET msgBox_status='1' WHERE msgBox_id = '" . $_POST['msgBox_id'] . "'";
  $query = $conn->query($sql);
}
function del_msgnoti()
{
  include('../config/config.php');
  $sql = "UPDATE `Message_Noti_App` SET msgNoti_status='1' WHERE msgNotiApp_id = '" . $_POST['msgNotiApp_id'] . "'";
  $query = $conn->query($sql);
}

function new_letter()
{
  include('../config/config.php');
  if (isset($_POST['g-recaptcha-response'])) {
    $captcha = $_POST['g-recaptcha-response'];
  }
  if (!$captcha) {
  ?>

    <script type="text/javascript">
      window.parent.bootbox.alert('กรุณาระบุ Capcha เพือพิสูจน์บุคคล หากท่านไม่ใช่ หุ่นยนต์หรือสแปม', function() {
        window.parent.$('#wait_process').css('display', 'none');
      });
      //  top.window.location.href = '/frontend/index.php?page=new_letter';
    </script>
  <?php
    exit;
  }
  $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LdTxygUAAAAAKworPbcIzofBO0WZx-Z7Ur4wZdZ&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
  if ($response . success == false) {
  ?>
    <script type="text/javascript">
      window.parent.bootbox.alert('กรุณาระบุ Capcha ให้ถูกต้อง', function() {
        window.parent.$('#wait_process').css('display', 'none');
      });
      //  top.window.location.href = '/frontend/index.php?page=new_letter';
    </script>
  <?php
    exit;
  } else {
  }
  $date_time = date("Y-m-d H:i:s");
  $sql = "INSERT INTO `Message_Box` (msgBox_type,case_id,sender_id,sender_type,msgBox_message,msgBox_datetime)
    VALUES ('1','" . $_POST['sel_case'] . "','" . $_SESSION['member_id'] . "','1','" . $_POST['box_letter'] . "','$date_time')";
  $query = $conn->query($sql);
  $last_id = $conn->insert_id;

  $sql_case = "SELECT c.case_id,ca.emp_id,ca.caseAsign_status,ca.emp_id FROM `Case` AS c
    LEFT JOIN `Case_Assign` AS ca ON c.case_id = ca.case_id
    WHERE c.case_id = '" . $_POST['sel_case'] . "' AND ca.caseAsign_status = 0";
  $query_case = $conn->query($sql_case);
  if ($query_case->num_rows > 0) {
    while ($re = $query_case->fetch_assoc()) {
      $sql_log = "INSERT INTO `Message_Box_Log` (msgBox_id,recipient_id,recipient_type,msgBoxLog_datetime)
        VALUES ('" . $last_id . "','" . $re['emp_id'] . "','2','" . $date_time . "')";
      $query_log = $conn->query($sql_log);
    }
  }

  $caseAttach_file_name = $_POST['caseAttach_file_name'];
  $new_fileadrss = $_POST['new_fileadrss'];

  $a = 0;
  $value_name_arr = array();
  foreach ($caseAttach_file_name as $value_name) {
    $value_name_arr[$a] = $value_name;
    $a++;
  }
  $c = 0;
  $value_oldname_arr = array();
  foreach ($new_fileadrss as $value_oldname) {
    $value_oldname_arr[$c] = $value_oldname;
    $c++;
  }

  $file_data = $_POST['filePreview'];
  $i = 1;
  $b = 0;
  foreach ($file_data as $value) {
    list($type, $value) = explode(';', $value);
    list(, $extension) = explode('/', $type);
    list(, $value)      = explode(',', $value);
    $data = base64_decode($value);

    if (!is_dir("../../data/msg_attach/" . $last_id)) {
      mkdir("../../data/msg_attach/" . $last_id, 0775, true);
    } else {
      deleteDirectory("../../data/msg_attach/" . $last_id);
      mkdir("../../data/msg_attach/" . $last_id, 0775, true);
    }
    if ($extension == "vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
      $extension = "xlsx";
    } elseif ($extension == "vnd.openxmlformats-officedocument.wordprocessingml.document") {
      $extension = "docx";
    } elseif ($extension == "vnd.openxmlformats-officedocument.presentationml.presentation") {
      $extension = "ppt";
    } else {
      $extension = $extension;
    }
    $new_file = "msgAttach_file_" . $last_id . "_" . time() . "_" . $i . "." . $extension;
    $file = "../../data/msg_attach/" . $last_id . "/" . $new_file;
    $pathfile = "data/msg_attach/" . $last_id . "/" . $new_file;
    $sql_att = "INSERT INTO `Message_Box_Attachfile`
      (msgBox_id,msgBoxAttach_title,msgBoxAttach_file_path,msgBoxAttach_file_oldname,msgBoxAttach_file_name,msgBoxAttach_file_ext,msgBoxAttach_status,msgBoxAttach_create_datetime,msgBoxAttach_createBy_id)
      VALUES ('" . $last_id . "','" . $value_name_arr[$b] . "','" . $pathfile . "','" . $value_oldname_arr[$b] . "','" . $new_file . "','" . $extension . "','0','" . $date_time . "','" . $_SESSION['member_id'] . "')";
    $query_att = $conn->query($sql_att);
    file_put_contents($file, $data);
    $i++;
    $b++;
  }
  ?>
  <script>
    window.parent.bootbox.alert('บันทึกการส่งข้อความเรียบร้อยแล้ว', function() {
      top.window.location = '/frontend/index.php?page=letter';
    });
  </script>
<?
}


function update_status_noti()
{
  include('../config/config.php');
  $sql = "UPDATE `Member` SET member_noti='" . $_POST['up_noti'] . "' WHERE member_id = '" . $_SESSION['member_id'] . "'";
  $query = $conn->query($sql);
}

function chk_invite_step()
{
  include('../config/config.php');
  $output['in_chk'] = "00";
  $sql = "SELECT * FROM `Complaint_Type` WHERE compType_id = '" . $_POST['chk_radio_step'] . "'";
  $query = $conn->query($sql);
  $res = $query->fetch_assoc();
  if ($query->num_rows > 0) {
    if ($res['compType_other_flag'] == "1") {
      if ($_POST['compType_other_txt'] == "") {
        $output['in_chk'] = "03";
      } else {
        $output['in_chk'] = "02";
      }
    } else {

      if ($_POST['chk_radio_step1'] == "" || $_POST['chk_radio_step1'] == "undefined") {
        $sql_step2 = "SELECT * FROM `Complaint_Type_Sub1` WHERE compType_id='" . $_POST['chk_radio_step'] . "'";
        $query_step2 = $conn->query($sql_step2);
        if ($query_step2->num_rows > 0) {
          $output['in_chk'] = "01";
        } else {
          $output['in_chk'] = "00";
        }
      } else {
        $sql_step2 = "SELECT * FROM `Complaint_Type_Sub1` WHERE compTypeSub1_id='" . $_POST['chk_radio_step1'] . "'";
        $query_step2 = $conn->query($sql_step2);
        if ($query_step2->num_rows > 0) {
          if ($_POST['chk_radio_step2'] == "" || $_POST['chk_radio_step1'] == "undefined") {
            $sql_step3 = "SELECT * FROM `Complaint_Type_Sub2` WHERE compTypeSub1_id='" . $_POST['chk_radio_step1'] . "'";
            $query_step3 = $conn->query($sql_step3);
            if ($query_step3->num_rows > 0) {
              $output['in_chk'] = "01";
            } else {
              $output['in_chk'] = "00";
            }
          } else {
            $sql_step3 = "SELECT * FROM `Complaint_Type_Sub2` WHERE compTypeSub2_id='" . $_POST['chk_radio_step2'] . "'";
            $query_step3 = $conn->query($sql_step3);
            if ($query_step3->num_rows > 0) {
              $output['in_chk'] = "00";
            } else {
              $output['in_chk'] = "01";
            }
          }
        } else {
          $output['in_chk'] = "01";
        }
      }
    }
  } else {
    $output['in_chk'] = "01";
  }
  header("content-type:application/json;charset=utf-8");
  echo json_encode($output);
}

function random_password($length = 8)
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

function forgot_password()
{
  include('../config/config.php');


  $sql = "SELECT m.member_fname,m.member_lname,mc.member_comp_name,m.member_type,m.member_status_confirm
  FROM `Member` AS m LEFT JOIN `Member_comp` AS mc ON m.member_id = mc.member_id WHERE m.member_email = '" . $_POST['email'] . "'";
  $query = $conn->query($sql);
  $re = $query->fetch_assoc();
  $output['chk_mail'] = "";
  if ($query->num_rows > 0) {

    if ($re['member_status_confirm'] == "1") {
      if ($re['member_type'] == "0") {
        $namesent = "เรียน คุณ, " . $re['member_fname'] . "  " . $re['member_lname'];
      } else {
        $namesent = "เรียน บริษัท, " . $re['member_comp_name'];
      }
      $to_email = $_POST['email'];
      $passwors = random_password();
      $to_name = "เจ้าหน้าที่ของ DITP Care";
      $from_email = "ditpcare@ditp.go.th";
      $from_name = "DITP Care";
      $subject = "คุณได้ขอตั้งค่ารหัสผ่านใหม่ DITP Care";
      $password_hash = PassHash::hash($passwors);
      $url = $_SERVER['HTTP_HOST'] . "/frontend/reset_password.php?id=$password_hash";
      $message = " <div class=\"wrapper\" style=\"width:860px;background: #f8f8f8;\">
                  <div class=\"header\" style=\"width:auto\">
                  <img src=\"http://" . $_SERVER["HTTP_HOST"] . "/img/header_email_2.png\" style=\"max-width: 860px;\" srtlw=\"width:100%; height:auto;\" />
                  <div>
                  <div class=\"content\" style=\"width:auto; height:auto; font-family: Tahoma, Verdana, Segoe, sans-serif; font-size:16px;\">
                  <div style=\"padding: 20px;color:#000;\">
                  " . $namesent . "
                  <br>
                  <br>
                  " . $_SERVER['HTTP_HOST'] . " ได้รับคำขอร้องจากเว็บไซต์ ถ้าคุณต้องการเปลี่ยนรหัสผ่าน
                  <br>
                  คลิกที่ลิงค์ด้านล่างนี้ เพื่อรีเซ็ตรหัสผ่านของคุณ :
                  <br>
                  <br>
                  <br>
                  <br>
                  <div style=\"text-align:center;color:#000;\">
                  <a href=\"http://" . $url . "\" style=\"background:#22A180;color:#fff;padding: 15px 50px;text-align:center;text-decoration: none;border-radius:25px\" target=\"_blank\" >ขอรหัสผ่านใหม่</a>
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

      $upd = "UPDATE Member SET member_tokin = '" . $password_hash . "' ,member_reset_pass = '1' WHERE member_email = '" . $_POST['email'] . "' ";
      $query_upd = $conn->query($upd);

      $output['chk_mail'] = $mail;
    } else {
      $output['chk_mail'] = "02";
    }
  } else {
    $output['chk_mail'] = "01";
  }
  header("content-type:application/json;charset=utf-8");
  echo json_encode($output);
}


function language_select()
{
  include('../config/config.php');
  $sql = "UPDATE `Member` SET member_lang='" . $_POST['type'] . "' WHERE member_id = '" . $_SESSION['member_id'] . "'";
  $query = $conn->query($sql);
}

function prodTypeListMutiLv($lv, $ref_id, $lang)
{
  include('../config/config.php');
  $prodTypeArrObj = array();
  $sql = "SELECT *
  FROM Product_Type
          WHERE prodType_level = '$lv'
          AND prodType_status = '0'
          AND prodType_enable = '1' ";
  if ($ref_id != "") {
    $sql .= "AND prodType_ref_id = '$ref_id' ";
  }
  $query = $conn->query($sql);
  $prod_num = $query->num_rows;
  $lv++;
  while ($result = $query->fetch_assoc()) {
    $prodArr["prodType_id"] = $result["prodType_id"];
    $prodArr["prodType_name"] = $result["prodType_name"];
    $prodArr["prodType_name_en"] = $result["prodType_name_en"];

    $sql_sub = "SELECT *
                  FROM Product_Type
                  WHERE prodType_ref_id = '" . $result["prodType_id"] . "'
                  AND prodType_level = '$lv'
                  AND prodType_status = '0'
                  AND prodType_enable = '1' ";
    $query_sub = $conn->query($sql_sub);
    $num_sub = $query_sub->num_rows;
    $prodArr["prodType_sublist"] = $num_sub;
    array_push($prodTypeArrObj, $prodArr);
  }
  return $prodTypeArrObj;
}

function getProdType($lv, $ref_id, $ref_name, $lang)
{
  include('../config/config.php');

  $i = 0;
  foreach (prodTypeListMutiLv($lv, $ref_id, $lang) as $prod_type) {
    if ($lv == 1) {
      $option .= '<optgroup>';
    }
    if ($lv > 1) {
      $arrow = '<i class=\'ditp-icon icon-ico-ditp-43\'></i>';
    } else {
      $arrow = '';
    }
    if ($lang == "2") {
      // $prodType_name = $prod_type["prodType_name"];
      $prodType_name = $prod_type["prodType_name_en"];
    } else {
      $prodType_name = $prod_type["prodType_name"];
    }
    $ref_name_real = $ref_name . "/" . $prod_type["prodType_name"];
    $option .= '<option value="' . $prod_type["prodType_id"] . '" rel="' . $prod_type["prodType_level"] . '" data-content="<span class=\'txt\' style=\'padding-left:' . (20 * ($lv - 1)) . 'px\'>' . $arrow . '<h style=\'display:none;\'>' . $ref_name_real . '</h>' . $prodType_name . '</span>" >
              ' . $prodType_name . '
            </option>';
    if ($prod_type["prodType_sublist"] > 0) {
      $n_lv = $lv + 1;
      $option .= getProdType($n_lv, $prod_type["prodType_id"], $ref_name_real, $lang);
    }
    if ($lv == 1) {
      $option .= '</optgroup>';
    }
    $i++;
  }
  return $option;
}


function chk_div_category()
{
  include('../config/config.php');

  $sql_lang = "SELECT * FROM `Member` WHERE member_id = '" . $_SESSION['member_id'] . "'";
  $query_lang = $conn->query($sql_lang);
  if ($query_lang->num_rows > 0) {
    $xr = $query_lang->fetch_assoc();
    $lang = $xr['member_lang'];
  } else {
    $lang = htmlspecialchars($_POST['lang'], ENT_QUOTES);;
  }
?>
  <select class="selectpicker form-control sel_category_info" id="sel_category_info_ex" data-live-search="true" onchange="search_info();">
    <option value="0"><?php if ($lang == "1") {
                        echo "ทั้งหมด";
                      } elseif ($lang == "2") {
                        echo "All";
                      } else {
                        echo "ทั้งหมด";
                      } ?></option>
    <?php echo getProdType(1, null, null, $lang); ?>
  </select>
  <?php
  exit();
}

function count_checkcorporation_clicked()
{
  include('../config/config.php');

  $sql_count = "INSERT INTO `count_checkcorporation_clicked`
  (clickByID, clickDownload)
  VALUES ('" . $_SESSION['member_id'] . "', '1')";
  $query_count = $conn->query($sql_count);
  if ($query_count) {
    return true;
  } else {
    return false;
  }
  exit();
}

function question()
{
  include('../config/config.php');
  $date_time = date("Y-m-d H:i:s");
  if ($_SESSION['member_id'] == "") {
    if ($_POST['lang_question '] == "2" || $_POST['lang_question'] == "4") {
      $txt_1 = "Please signin before making a questionnaire.";
    } else {
      $txt_1 = "กรุณาเข้าสู่ระบบก่อนทำแบบสอบถาม";
    }
  ?>
    <script type="text/javascript">
      window.parent.bootbox.alert('<?= $txt_1 ?>');
      window.parent.location.reload();
    </script>
    <?php
    exit();
  }
  if ($_POST['lang_question '] == "2" || $_POST['lang_question'] == "4") {
    $txt_1 = "Please show your satisfaction";
    $txt_2 = "Thank you for displaying the questionnaire.";
  } else {
    $txt_1 = "กรุณาแสดงความพึงพอใจใน ข้อที่";
    $txt_2 = "ขอบคุณสำหรับการแสดงการแบบสอบถาม";
  }
  $i = 1;
  foreach ($_POST['hid_questionID'] as $questionID) {
    $sql_chk = "SELECT * FROM `Feedback_Frontend_Question` WHERE feedback_q_id = '" . $questionID . "' ";
    $query_chk = $conn->query($sql_chk);
    $res = $query_chk->fetch_assoc();
    if ($res['feedback_q_chk'] == '1') {
      if ($_POST['answers_question_' . $questionID] == "") {
        if ($_POST['lang_question'] == "2") {
          $title = $res['feedback_q_title_en'];
        } else {
          $title = $res['feedback_q_title'];
        }
    ?>
        <script type="text/javascript">
          window.parent.bootbox.alert('<?= $txt_1 ?> <?= $i ?>. <?= $title ?>');
        </script>
  <?php
        exit();
      }
    }
    $i++;
  }

  $emp_id = [1, 7];

  for ($i = 0; $i < 2; $i++) {
    $sql_noti = "INSERT INTO `Message_Noti_Employee`
        (`emp_id`
        , `msgNotiEmp_message`
        , `msgNotiEmp_datetime`
        , `msgNotiEmp_status`
        , `msgNotiEmp_noti_status`
        , `msgNotiEmp_read_status`)
        VALUES (
          '" . $emp_id[$i] . "'
          ,'ได้มีการตอบแบบสอบถามการใช้งานของผู้ประกอบการ'
          , '" . $date_time . "'
          ,'0'
          ,'0'
          ,'0')";
    $query_noti = $conn->query($sql_noti);
  }



  $sql_list = "INSERT INTO `Feedback_Frontend_List`(`feedback_list_datetime`, `feedback_list_by`) VALUES ('" . $date_time . "','" . $_SESSION['member_id'] . "')";
  $query_list = $conn->query($sql_list);
  $last = $conn->insert_id;

  foreach ($_POST['hid_questionID'] as $questionID) {
    if ($_POST['answers_question_' . $questionID] != "") {
      if ($_POST['other_answers_question_' . $questionID] != "") {
        $other_answers_question = " (" . $_POST['other_answers_question_' . $questionID] . ")";
      } else {
        $other_answers_question = "";
      }
      $sql = "INSERT INTO `Feedback_Frontend_Answers`(`feedback_q_id`, `feedback_a_result`,`feedback_list_id`) VALUES ('" . $questionID . "','" . $_POST['answers_question_' . $questionID] . $other_answers_question . "','" . $last . "')";
      $query = $conn->query($sql);
    }
  }


  ?>
  <script type="text/javascript">
    window.parent.bootbox.alert('<?= $txt_2 ?>', function() {
      top.window.location = '/frontend/index.php?page=home';
    });
  </script>
<?php
  exit();
}

?>