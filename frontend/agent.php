<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
include('config/config.php');
$lang = htmlspecialchars($_GET['lang'], ENT_QUOTES, 'UTF-8');
include('lang.php');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="57x57" href="../favicon.ico/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="../favicon.ico/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="../favicon.ico/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="../favicon.ico/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="../favicon.ico/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="../favicon.ico/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="../favicon.ico/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="../favicon.ico/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../favicon.ico/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="../favicon.ico/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../favicon.ico/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="../favicon.ico/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../favicon.ico/favicon-16x16.png">
    <link rel="manifest" href="../favicon.ico/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">


    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>DITP กรมส่งเสริมการค้าระหว่างประเทศ กระทรวงพาณิชย์</title>
    <link rel="stylesheet" href="lib/bootstrap-3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="lib/bootstrap-select/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="css/agent.css">
    <link rel="stylesheet" href="css/switch.css">
    <link rel="stylesheet" href="css/fonts.css">

    <!-- <link rel="stylesheet" type="text/css" href="lib/izitoast/dist/css/iziToast.css">
		<script type="text/javascript" src="lib/izitoast/dist/js/iziToast.js"></script> -->

    <script src="js/jquery-core.js"></script>
    <script src="js/bootbox.min.js"></script>
    <!-- <script src="assets/input-mask/inputmask.js"></script> -->
    <script src="lib/bootstrap-3.3.7/js/bootstrap.min.js"></script>
    <script src="lib/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
		<script src="lib/bootstrap-select/dist/js/bootstrap-select.js"></script>
    <script src="js/member_function.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>

    <script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script>
    <script src="https://cloud.github.com/downloads/digitalBush/jquery.maskedinput/jquery.maskedinput-1.3.min.js"></script>

    <script>
    $( document ).ready(function() {
      var win_w = $(window).width();
      var win_h = $(window).height();

      var header_h = $(".body-index-hr").height();
      var footer_h = $(".footer-index").height();
      var body_h = $(".body-index").height();

        if(body_h > 918){
            $(".container_main").css('height',"auto");
        }else {
          $(".container_main").css('height',(win_h-(header_h+footer_h))+"px");
        }
    });

    $(window).resize(function(){
      var win_w = $(window).width();
      var win_h = $(window).height();

      var header_h = $(".body-index-hr").height();
      var footer_h = $(".footer-index").height();
      var body_h = $(".body-index").height();

      if(body_h > 918){
          $(".container_main").css('height',"auto");
      }else {
        $(".container_main").css('height',(win_h-(header_h+footer_h))+"px");
      }
    });

    // var iziToast_func ={
    //   alert: function( message_txt,callback ) {
    //       iziToast.error({
    //         icon: 'ico-warning',
    //         title: 'แจ้งเตือน: ',
    //         message: message_txt,
    //         position: 'topCenter', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
    //         onOpening: function(instance, toast){
    //         },
    //         onClosing: function(instance, toast, closedBy){
    //           if(typeof(callback)=='function'){
    //               callback();
    //           }
    //         }
    //       });
    //     }
    // }
    </script>
  </head>
  <body>
    <div class="body-index">
      <div class="body-index-hr">
      <div class="row hr_index">
        <div class="col-md-1"></div>
        <div class="col-md-3 col-sm-3 col-xs-3" id="div_logo"><a href="index.php?page=home&lang=<?=$lang?>"><img src="images/logo-DITP.png"></a></div>
        <div class="col-md-7 col-sm-8 col-xs-8" id="lang_agent">
          <span class="language">
            <a onclick="language_select(1);" style="cursor: pointer;"><span <?= ($lang == "1" || $lang == "0" || $lang == "") ? "class='lang_active'" : "" ?>>TH</span></a> |
            <a onclick="language_select(2);" style="cursor: pointer;"><span <?= ($lang == "2") ? "class='lang_active'" : "" ?>>EN</span></a></span><br>
          <span class="title-language"><?=$txt_International_hr?></span>
        </div>
        <div class="col-md-1 col-sm-1 col-xs-1"></div>
      </div>
      <div class="bg_menu_hr">
      <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
        <span class="hr_agent"><?=$txt_information_registration?></span>
        </div>
        <div class="col-md-1"></div>
        </div>
      </div>
    </div>
      <div class="container container_main">
<?php

function getPositionImage($emp_img_path,$size){
  list($width, $height) = getimagesize($emp_img_path);
  $ratio = $width/$height; // width/height

  if( $ratio > 1) {
      $width = $size*$ratio;
      $height = $size;
      $css = " width:auto; height:100%; margin-left:-".(($width*0.5)-($size*0.5))."px";
  }
  else {
  $width = $size;
  $height = $size/$ratio;
        $css = "height:auto; width:100%; top:0;";
  }
  // return $height;
  return $css;
}

$status_member = htmlspecialchars($_GET['page'], ENT_QUOTES, 'UTF-8');
$status = htmlspecialchars($_GET['status'], ENT_QUOTES, 'UTF-8');
$userid = htmlspecialchars($_GET['fb_id'], ENT_QUOTES, 'UTF-8');

$ch = curl_init("http://graph.facebook.com/$userid/picture?type=large");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$_pic_small = curl_exec($ch);
curl_close($ch);
$ch_ex = "http://graph.facebook.com/$userid/picture?type=large";
if($status_member == "office"){
?>
        <!-- agent office -->
<form method="post" action="#" id="member_com" enctype="multipart/form-data">
  <input type="hidden" class="status_login" value="<?php echo $status;?>">
  <input type="hidden" class="fb_id" value="<?php echo htmlspecialchars($_GET['fb_id'], ENT_QUOTES, 'UTF-8');?>">
  <input type="hidden" class="fb_name" value="<?php echo htmlspecialchars($_GET['fb_name'], ENT_QUOTES, 'UTF-8');?>">
  <input type="hidden" class="lang" value="<?=$lang?>">
  <textarea class="img_f" style="display:none;"><?php echo $ch_ex;?></textarea>
        <div class="panel panel-default panel-agent">
          <div class="panel-heading panel-hr-agent">
            <span class="icon_agent_office"><img src="images/icon_home_detail.png"></span>
            <span class="hr_txt_agent_office"><?=$txt_Company_data?></span>
          </div>
          <div class="panel-body">
            <div class="row div_row_agent">
              <div class="col-md-3 col-sm-4 col-xs-12">
              </div>
              <div class="col-md-9 col-sm-8 col-xs-12">
                <div class="div_img">
                    <img src="images/profile_emp-01.svg" id="register_img" style="<?php echo getPositionImage("images/profile_emp-01.svg",48)?>">
                </div>
              </div>
            </div>
            <div class="row div_row_agent">
              <div class="col-md-3 col-sm-4 col-xs-12">
                <span class="logo_name"><?=$txt_Company_logo?></span>
              </div>
              <div class="col-md-9 col-sm-8 col-xs-12">
                <input type="file" class="upload_file" name="upload_file" style="display:none;" accept="image/x-png, image/gif, image/jpeg"/>
                <input type="text" class="form-control box_file_agentoffice" readonly>
                <button type="button" class="btn btn-default btn_file_agentoffice">Browse</button>
              </div>
            </div>


            <div class="row div_row_agent">
              <div class="col-md-3 col-sm-4 col-xs-12">
                <span class="office_name"><?=$txt_Company_name?></span>
                <span class="color-star">*</span>
              </div>
              <div class="col-md-9 col-sm-8 col-xs-12">
                <input type="text" class="form-control box_name_agentoffice">
              </div>
            </div>

            <div class="row div_row_agent">
              <div class="col-md-3 col-sm-4 col-xs-12">
                <span class="office_branch"><?=$txt_Branch?></span>
              </div>
              <div class="col-md-9 col-sm-8 col-xs-12">
                <input type="text" class="form-control box_branch_agentoffice">
              </div>
            </div>

            <div class="row div_row_agent">
              <div class="col-md-3 col-sm-4 col-xs-12">
                <span class="office_trade"><?=$txt_Registration_Number?></span>
                <span class="color-star">*</span>
              </div>
              <div class="col-md-9 col-sm-8 col-xs-12">
                <input type="text" class="form-control box_trade_agentoffice" maxlength="13">
              </div>
            </div>
            <div class="row div_row_agent">
              <div class="col-md-3 col-sm-4 col-xs-12">
                <span class="office_business_person"><?=$txt_Type_of_business?></span>
                <span class="color-star">*</span>
              </div>
              <div class="col-md-3 col-sm-8 col-xs-12">
                <select class="selectpicker form-control sel_business_person_office" id="sel_business_person_office">
                  <option value="">
                   --- <?=$txt_Choose_business?> ---
                  </option>
                  <option value="0"><?php if($lang == "1"){ echo "ไม่ระบุ";}elseif($lang == "2"){ echo "Unknown";}else{ echo "ไม่ระบุ";}?></option>
                  <option value="1"><?php if($lang == "1"){ echo "นำเข้า";}elseif($lang == "2"){ echo "Import";}else{ echo "นำเข้า";}?></option>
                  <option value="2"><?php if($lang == "1"){ echo "ส่งออก";}elseif($lang == "2"){ echo "Export";}else{ echo "ส่งออก";}?></option>
                </select>
              </div>
              <div class="col-md-3"></div>
              <div class="col-md-3"></div>
            </div>
            <div class="row div_row_agent">
              <div class="col-md-3 col-sm-4 col-xs-12">
                <span class="office_address"><?=$txt_Address?></span>
                <span class="color-star">*</span>
              </div>
              <div class="col-md-9 col-sm-8 col-xs-12">
                <textarea rows="4" class="form-control box_address_agentoffice"></textarea>
              </div>
            </div>

            <div class="row div_row_agent">
              <div class="col-md-3 col-sm-4 col-xs-12">
                <span class="office_country"><?=$txt_Country?></span>
                <span class="color-star">*</span>
              </div>
              <div class="col-md-3 col-sm-8 col-xs-12">
                <select class="selectpicker form-control sel_country_office" data-live-search="true" id="sel_country_office">
                  <option value="">
                   --- <?=$txt_Choose_your_country?> ---
                  </option>
                  <?php
                    $sql = "select * from Country ORDER BY name";
                    $query = $conn->query($sql);
                    if($query->num_rows > 0){
                      while ($rs = $query->fetch_assoc()) {
                        // if($lang == "2"){
                        //   $name = $rs['name'];
                        // }else {
                        //   $name = $rs['name_th'];
                        // }
                  ?>
                  <option value="<?php echo $rs['id']?>"><?php echo $rs['name']?></option>
                  <?php
                        }
                    }
                  ?>
                </select>
              </div>
              <div class="col-md-3"></div>
              <div class="col-md-3"></div>
            </div>

            <div class="row div_row_agent">
              <div class="col-md-3 col-sm-4 col-xs-12 sel_city_office">
                <span class="office_city"><?=$txt_Province?></span>
                <span class="color-star">*</span>
              </div>
              <div class="col-md-3 col-sm-8 col-xs-12 sel_city_office">
                <select class="selectpicker form-control sel_city_office" data-live-search="true" id="sel_city_office">
                  <option value="">
                   --- <?=$txt_Choose_your_province?> ---
                  </option>
                  <?php
                    $sql = "select * from Province";
                    $query = $conn->query($sql);
                    if($query->num_rows > 0){
                      while ($rs = $query->fetch_assoc()) {
                        if($lang == "2"){
                          $prov_name = $rs['prov_name_eng'];
                        }else {
                          $prov_name = $rs['prov_name'];
                        }
                  ?>
                  <option value="<?php echo $rs['prov_id']?>"><?php echo $prov_name?></option>
                  <?php
                        }
                    }
                  ?>
                </select>
                <input type="text" class="form-control sel_city_office_txt" style="display:none;">
              </div>
              <div class="col-md-3 col-sm-4 col-xs-12 div_office_code">
                <span class="office_code"><?=$txt_Postcode?></span>
                <span class="color-star">*</span>
              </div>
              <div class="col-md-3 col-sm-8 col-xs-12">
                  <input type="text" maxlength="5" class="form-control box_code_agentoffice">
              </div>
            </div>


            <div class="row div_row_agent">
              <div class="col-md-3 col-sm-4 col-xs-12">
                <span class="office_tel"><?=$txt_Telephone_number?></span>
                <span class="color-star">*</span>
              </div>
              <div class="col-md-3 col-sm-8 col-xs-12">
                  <input type="text" class="form-control box_tel_agentoffice">
              </div>
              <div class="col-md-3 col-sm-4 col-xs-12 div_office_fix">
                <span class="office_fix"><?=$txt_Fax_number?></span>
              </div>
              <div class="col-md-3 col-sm-8 col-xs-12">
                  <input type="text" class="form-control box_fix_agentoffice">
              </div>
            </div>

            <div class="row div_row_agent_xr">
              <div class="col-md-3 col-sm-4 col-xs-12">
                <span class="office_department_members"><?=$txt_DITP_membership?></span>
                <span class="color-star">*</span>
              </div>
              <div class="col-md-3 col-sm-3 col-xs-6">
                <input type="radio" name="department_members" id="department_members_1" onchange="chk_department_members(1)" value="1" checked>
                <span class="txt_department"><?=$txt_ditp_yes?></span>
              </div>
              <div class="col-md-3 col-sm-3 col-xs-6" id="department_members_div">
                <input type="radio" name="department_members" id="department_members_2" onchange="chk_department_members(2)" value="2">
                <span class="txt_notdepartment"><?=$txt_ditp_no?></span>
              </div>
              <div class="col-md-3 col-sm-3">
              </div>
            </div>

        </div>
      </div>

      <div class="panel panel-default panel-agent">
        <div class="panel-heading panel-hr-agent">
          <span class="icon_agent_office"><img src="images/icon_person_w.png"></span>
          <span class="hr_txt_agent_office"><?=$txt_Petitioner_proxy?></span>
        </div>
        <div class="panel-body">
          <div class="row div_row_agent">
            <div class="col-md-3 col-sm-4 col-xs-12">
              <span class="office_name_person"><?=$txt_First_name?></span>
              <span class="color-star">*</span>
            </div>
            <div class="col-md-3 col-sm-8 col-xs-12">
                <input type="text" class="form-control box_nameperson_agentoffice">
            </div>
            <div class="col-md-3 col-sm-4 col-xs-12 div_office_fix">
              <span class="office_lastname_person"><?=$txt_Last_name?></span>
              <span class="color-star">*</span>
            </div>
            <div class="col-md-3 col-sm-8 col-xs-12">
                <input type="text" class="form-control box_lastnameperson_agentoffice">
            </div>
          </div>

          <div class="row div_row_agent">
            <div class="col-md-3 col-sm-4 col-xs-12">
              <span class="office_card_number"><?=$txt_Identification?></span>
              <span class="color-star">*</span>
            </div>
            <div class="col-md-9 col-sm-8 col-xs-12">
              <input type="text" class="form-control box_cardnumber_agentoffice" maxlength="13">
            </div>
          </div>

          <div class="row div_row_agent">
            <div class="col-md-3 col-sm-4 col-xs-12">
              <span class="office_position"><?=$txt_Position?></span>
              <span class="color-star">*</span>
            </div>
            <div class="col-md-9 col-sm-8 col-xs-12">
              <input type="text" class="form-control box_position_agentoffice">
            </div>
          </div>


          <div class="row div_row_agent">
            <div class="col-md-3 col-sm-4 col-xs-12">
              <span class="office_address_person"><?=$txt_Address?></span>
              <span class="color-star">*</span>
            </div>
            <div class="col-md-9 col-sm-8 col-xs-12">
              <textarea rows="4" class="form-control box_address_person_agentoffice"></textarea>
            </div>
          </div>

          <div class="row div_row_agent">
            <div class="col-md-3 col-sm-4 col-xs-12">
              <span class="office_country_person"><?=$txt_Country?></span>
              <span class="color-star">*</span>
            </div>
            <div class="col-md-3 col-sm-8 col-xs-12">
              <select class="selectpicker form-control sel_country_person_office" data-live-search="true" id="sel_country_person_office">
                <option value="">
                 --- <?=$txt_Choose_your_country?> ---
                </option>
                <?php
                  $sql = "select * from Country ORDER BY name";
                  $query = $conn->query($sql);
                  if($query->num_rows > 0){
                    while ($rs = $query->fetch_assoc()) {
                      // if($lang == "2"){
                      //   $name = $rs['name'];
                      // }else {
                      //   $name = $rs['name_th'];
                      // }
                ?>
                <option value="<?php echo $rs['id']?>"><?php echo $rs['name']?></option>
                <?php
                      }
                  }
                ?>
              </select>
            </div>
            <div class="col-md-3"></div>
            <div class="col-md-3"></div>
          </div>

          <div class="row div_row_agent">
            <div class="col-md-3 col-sm-4 col-xs-12 sel_city_person_office">
              <span class="office_city_person"><?=$txt_Province?></span>
              <span class="color-star">*</span>
            </div>
            <div class="col-md-3 col-sm-8 col-xs-12 sel_city_person_office">
              <select class="selectpicker form-control sel_city_person_office" data-live-search="true" id="sel_city_person_office">
                <option value="">
                 --- <?=$txt_Choose_your_province?> ---
                </option>
                <?php
                  $sql = "select * from Province";
                  $query = $conn->query($sql);
                  if($query->num_rows > 0){
                    while ($rs = $query->fetch_assoc()) {
                      if($lang == "2"){
                        $prov_name = $rs['prov_name_eng'];
                      }else {
                        $prov_name = $rs['prov_name'];
                      }
                ?>
                <option value="<?php echo $rs['prov_id']?>"><?php echo $prov_name?></option>
                <?php
                      }
                  }
                  ?>
              </select>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-12 div_office_code_po">
              <span class="office_code_person"><?=$txt_Postcode?></span>
              <span class="color-star">*</span>
            </div>
            <div class="col-md-3 col-sm-8 col-xs-12">
                <input type="text" maxlength="5" class="form-control box_code_person_agentoffice">
            </div>
          </div>


          <div class="row div_row_agent">
            <div class="col-md-3 col-sm-4 col-xs-12">
              <span class="office_tel_person"><?=$txt_Telephone_number?></span>
              <span class="color-star">*</span>

            </div>
            <div class="col-md-3 col-sm-8 col-xs-12">
                <input type="text" class="form-control box_tel_person_agentoffice">
            </div>
            <div class="col-md-3 col-sm-4 col-xs-12 div_office_fix">
              <span class="office_fix_person"><?=$txt_Mobile_telephone_number?></span>
              <span class="color-star">*</span>
            </div>
            <div class="col-md-3 col-sm-8 col-xs-12">
                <input type="text" class="form-control box_fix_person_agentoffice" id="box_fix_person_agentoffice" autocomplete="off" maxlength="10">
                <!-- <input type="tel" class="form-control box_fix_person_agentoffice" maxlength="10"> -->
            </div>
          </div>

          <div class="row div_row_agent_xr">
            <div class="col-md-3 col-sm-4 col-xs-12">
              <span class="office_sex"><?=$txt_Gender?></span>
              <span class="color-star">*</span>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-6">
              <input type="radio" name="sex" id="sex_1" onchange="chk_sex(1)" value="1" checked>
              <span class="txt_department"><?=$txt_Male?></span>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-6">
              <input type="radio" name="sex" id="sex_2" onchange="chk_sex(2)" value="2">
              <span class="txt_notdepartment"><?=$txt_Female?></span>
            </div>
            <div class="col-md-5 col-sm-4">
            </div>
          </div>

      </div>
    </div>

    <div class="panel panel-default panel-agent">
      <div class="panel-body">
        <div class="row div_row_agent">
          <div class="col-md-3 col-sm-4 col-xs-12">
            <span class="office_email"><?=$txt_email?></span>
            <span class="color-star">*</span>
          </div>
          <div class="col-md-3 col-sm-8 col-xs-12">
              <input type="email" class="form-control box_email_agentoffice">
          </div>
          <div class="col-md-6">
            <span class="txt_comment">
              <?=$txt_petition_ditp?>
            </span>
          </div>
        </div>
<?php if($status == "0"){?>
        <div class="row div_row_agent">
          <div class="col-md-3 col-sm-4 col-xs-12">
            <span class="office_password"><?=$txt_Password?></span>
            <span class="color-star">*</span>
          </div>
          <div class="col-md-3 col-sm-8 col-xs-12">
              <input type="password" class="form-control box_password_agentoffice">
          </div>
          <div class="col-md-6 col-sm-12 col-xs-12 notipass">
            <span style="color:#E74C3C;" class="notipass_txt"><?=$txt_must_contain?></span>
          </div>
        </div>

        <div class="row div_row_agent_xr">
          <div class="col-md-3 col-sm-4 col-xs-12">
            <span class="office_re_password"><?=$txt_Cpassword?></span>
            <span class="color-star">*</span>
          </div>
          <div class="col-md-3 col-sm-8 col-xs-12">
              <input type="password" class="form-control box_re_password_agentoffice">
          </div>
          <div class="col-md-6">
          </div>
        </div>
        <?php } ?>
        <div class="row hide_comment" style="display:none;">
        <div class="col-md-3 col-sm-4"></div>
        <div class="col-md-6 col-sm-8 col-xs-12">
          <span class="txt_comment_2">
              <?=$txt_petition_ditp?>
          </span>
        </div>
      </div>
      <?php if($status == "0"){?>
      <div class="row" style="margin-bottom:10px;">
      <div class="col-md-3 col-sm-3"></div>
      <div class="col-md-6 col-sm-9 col-xs-12">
      <div class="g-recaptcha" data-sitekey="6LdTxygUAAAAAGOY_dOU0RbVEhB0w2-ua99sG_Mr"></div>
      </div>
      </div>
      <?php } ?>
    </div>
  </div>

  <div class="btn_submit_agent">
    <?php if($lang == "1"){ $hr_re_ex = "กลับหน้าแรก";}elseif($lang == "2"){ $hr_re_ex = "Back To Home";}else{ $hr_re_ex = "กลับหน้าแรก";}?>
    <a href="index.php?page=home&lang=<?=$lang?>"><button type="button" class="btn" style="color: #333;border: solid 1px #ddd;"><?=$hr_re_ex?></button></a>
    <button type="button" class="btn btn-warning member_comp"><?=$txt_Registe?></button>
  </div>
</form>
        <!-- end agent office -->
<?php }else if($status_member == "person"){ ?>
        <!-- agent person -->
      <form method="post" action="#" id="member" enctype="multipart/form-data">
        <input type="hidden" class="status_login" value="<?php echo $status;?>">
        <input type="hidden" class="fb_id" value="<?php echo htmlspecialchars($_GET['fb_id'], ENT_QUOTES, 'UTF-8');?>">
        <input type="hidden" class="fb_name" value="<?php echo htmlspecialchars($_GET['fb_name'], ENT_QUOTES, 'UTF-8');?>">
        <input type="hidden" class="lang" value="<?=$lang?>">
        <textarea class="img_f" style="display:none;"><?php echo $ch_ex;?></textarea>
        <div class="panel panel-default panel-agent">
          <div class="panel-heading panel-hr-agent">
            <span class="icon_agent_office"><img src="images/all_icon_DITP/icon_13.svg" style="width:30px;"></span>
            <span class="hr_txt_agent_office"><?=$txt_Petitioner_data?></span>
          </div>
          <div class="panel-body">
            <div class="row div_row_agent">
              <div class="col-md-3 col-sm-4 col-xs-12">
              </div>
              <div class="col-md-9 col-sm-8 col-xs-12">
                <div class="div_img">
                    <img src="images/profile_emp-01.svg" id="register_img" style="<?php echo getPositionImage("images/profile_emp-01.svg",48)?>">
                </div>
              </div>
            </div>
            <div class="row div_row_agent">
              <div class="col-md-3 col-sm-3 col-xs-12">
                <span class="office_img"><?=$txt_Photo?></span>
              </div>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <input type="file" class="upload_file_person" name="upload_file_person" style="display:none;" accept="image/x-png, image/gif, image/jpeg">
                <input type="text" class="form-control box_file_agentperson" readonly>
                <button type="button" class="btn btn-default btn_file_agentperson">Browse</button>
              </div>
            </div>
            <div class="row div_row_agent">
              <div class="col-md-3 col-sm-3 col-xs-12">
                <?php
                $name = htmlspecialchars($_GET['fb_name'], ENT_QUOTES, 'UTF-8');
                $name_ex = explode(" ",$name);
                $fname = $name_ex[0];
                $lname = $name_ex[1];
                ?>
                <span class="office_name_person"><?=$txt_First_name?></span>
                <span class="color-star">*</span>
              </div>
              <div class="col-md-3 col-sm-9 col-xs-12">
                  <input type="text" class="form-control box_nameperson_agentperson" value="<?=$fname?>">
              </div>
              <div class="col-md-3 col-sm-3 col-xs-12 div_office_fix">
                <span class="office_lastname_person"><?=$txt_Last_name?></span>
                <span class="color-star">*</span>
              </div>
              <div class="col-md-3 col-sm-9 col-xs-12">
                  <input type="text" class="form-control box_lastnameperson_agentperson" value="<?=$lname?>">
              </div>
            </div>

            <div class="row div_row_agent">
              <div class="col-md-3 col-sm-3 col-xs-12">
                <span class="office_card_number"><?=$txt_Identification?></span>
                <span class="color-star">*</span>
              </div>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <input type="text" class="form-control box_cardnumber_agentoffice" maxlength="13">
              </div>
            </div>

            <div class="row div_row_agent">
              <div class="col-md-3 col-sm-3 col-xs-12">
                <span class="office_position"><?=$txt_Occupation?></span>
                <span class="color-star">*</span>
              </div>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <input type="text" class="form-control box_position_agentperson">
              </div>
            </div>


            <div class="row div_row_agent">
              <div class="col-md-3 col-sm-3 col-xs-12">
                <span class="office_address_person"><?=$txt_Address?></span>
                <span class="color-star">*</span>
              </div>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <textarea rows="4" class="form-control box_address_person_agentperson"></textarea>
              </div>
            </div>

            <div class="row div_row_agent">
              <div class="col-md-3 col-sm-3 col-xs-12">
                <span class="office_country_person"><?=$txt_Country?></span>
                <span class="color-star">*</span>
              </div>
              <div class="col-md-3 col-sm-9 col-xs-12">
                <select class="selectpicker form-control sel_country_person_person" data-live-search="true" id="sel_country_person_person">
                  <option value="">
                   --- <?=$txt_Choose_your_country?> ---
                  </option>
                  <?php
                    $sql = "select * from Country ORDER BY name";
                    $query = $conn->query($sql);
                    if($query->num_rows > 0){
                      while ($rs = $query->fetch_assoc()) {
                        // if($lang == "2"){
                        //   $name = $rs['name'];
                        // }else {
                        //   $name = $rs['name_th'];
                        // }
                  ?>
                  <option value="<?php echo $rs['id']?>"><?php echo $rs['name']?></option>
                  <?php
                        }
                    }
                  ?>
                </select>
              </div>
              <div class="col-md-3"></div>
              <div class="col-md-3"></div>
            </div>

            <div class="row div_row_agent">
              <div class="col-md-3 col-sm-3 col-xs-12 sel_city_person_person">
                <span class="office_city_person"><?=$txt_Province?></span>
                <span class="color-star">*</span>
              </div>
              <div class="col-md-3 col-sm-9 col-xs-12 sel_city_person_person">
                <select class="selectpicker form-control sel_city_person_person" data-live-search="true" id="sel_city_person_person">
                  <option value="">
                   --- <?=$txt_Choose_your_province?> ---
                  </option>
                  <?php
                    $sql = "select * from Province";
                    $query = $conn->query($sql);
                    if($query->num_rows > 0){
                      while ($rs = $query->fetch_assoc()) {
                        if($lang == "2"){
                          $prov_name = $rs['prov_name_eng'];
                        }else {
                          $prov_name = $rs['prov_name'];
                        }
                  ?>
                  <option value="<?php echo $rs['prov_id']?>"><?php echo $prov_name?></option>
                  <?php
                        }
                    }
                    ?>
                </select>
              </div>
              <div class="col-md-3 col-sm-3 col-xs-12 div_office_code">
                <span class="office_code_person"><?=$txt_Postcode?></span>
                <span class="color-star">*</span>
              </div>
              <div class="col-md-3 col-sm-9 col-xs-12">
                  <input type="text" maxlength="5" class="form-control box_code_person_agentperson">
              </div>
            </div>


            <div class="row div_row_agent">
              <div class="col-md-3 col-sm-3 col-xs-12">
                <span class="office_tel_person"><?=$txt_Telephone_number?></span>
                <span class="color-star">*</span>

              </div>
              <div class="col-md-3 col-sm-9 col-xs-12">
                  <input type="text" class="form-control box_tel_person_agentperson">
              </div>
              <div class="col-md-3 col-sm-3 col-xs-12 div_office_fix">
                <span class="office_fix_person"><?=$txt_Mobile_telephone_number?></span>
                <span class="color-star">*</span>
              </div>
              <div class="col-md-3 col-sm-9 col-xs-12">
                  <input type="text" class="form-control box_fix_person_agentperson" id="box_fix_person_agentperson" autocomplete="off"  maxlength="10">
                  <!-- <input type="tel" class="form-control box_fix_person_agentperson" maxlength="10"> -->
              </div>
            </div>

            <div class="row div_row_agent_xr">
              <div class="col-md-3 col-sm-3 col-xs-12">
                <span class="office_sex"><?=$txt_Gender?></span>
                <span class="color-star">*</span>
              </div>
              <div class="col-md-2 col-sm-3 col-xs-6">
                <input type="radio" name="sex_person" id="sex_person_1" value="1" checked>
                <span class="txt_department"><?=$txt_Male?></span>
              </div>
              <div class="col-md-2 col-sm-3 col-xs-6">
                <input type="radio" name="sex_person" id="sex_person_2" value="2">
                <span class="txt_notdepartment"><?=$txt_Female?></span>
              </div>
              <div class="col-md-5">
              </div>
            </div>

        </div>
      </div>

      <div class="panel panel-default panel-agent">
        <div class="panel-body">
          <div class="row div_row_agent">
            <div class="col-md-3 col-sm-3 col-xs-12">
              <span class="office_email"><?=$txt_email?></span>
              <span class="color-star">*</span>
            </div>
            <div class="col-md-3 col-sm-9 col-xs-12">
                <input type="email" class="form-control box_email_agentperson">
            </div>
            <div class="col-md-6">
              <span class="txt_comment">
                <?=$txt_petition_ditp?>
              </span>
            </div>
          </div>
<?php if($status == "0"){?>
          <div class="row div_row_agent">
            <div class="col-md-3 col-sm-3 col-xs-12">
              <span class="office_password"><?=$txt_Password?></span>
              <span class="color-star">*</span>
            </div>
            <div class="col-md-3 col-sm-8 col-xs-12">
                <input type="password" class="form-control box_password_agentperson">
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12 notipass">
              <span style="color:#E74C3C;" class="notipass_txt"><?=$txt_must_contain?></span>
            </div>
          </div>

          <div class="row div_row_agent_xr">
            <div class="col-md-3 col-sm-3 col-xs-12">
              <span class="office_re_password"><?=$txt_Cpassword?></span>
              <span class="color-star">*</span>
            </div>
            <div class="col-md-3 col-sm-9 col-xs-12">
                <input type="password" class="form-control box_re_password_agentperson">
            </div>
            <div class="col-md-6">
            </div>
          </div>
          <?php } ?>
          <div class="row hide_comment" style="display:none;">
          <div class="col-md-3 col-sm-3"></div>
          <div class="col-md-6 col-sm-9 col-xs-12">
            <span class="txt_comment_2">
              <?=$txt_petition_ditp?>
            </span>
          </div>
        </div>
      </div>
      <?php if($status == "0"){?>
      <div class="row" style="margin-bottom:10px;">
      <div class="col-md-3 col-sm-3"></div>
      <div class="col-md-6 col-sm-9 col-xs-12">
      <div class="g-recaptcha" data-sitekey="6LdTxygUAAAAAGOY_dOU0RbVEhB0w2-ua99sG_Mr"></div>
      </div>
      </div>
    <?php } ?>
    </div>

    <div class="btn_submit_agent">
      <?php if($lang == "1"){ $hr_re_ex = "กลับหน้าแรก";}elseif($lang == "2"){ $hr_re_ex = "Back To Home";}else{ $hr_re_ex = "กลับหน้าแรก";}?>
      <a href="index.php?page=home&lang=<?=$lang?>"><button type="button" class="btn" style="color: #333;border: solid 1px #ddd;"><?=$hr_re_ex?></button></a>
      <button type="button" class="btn btn-warning btn_member"><?=$txt_Registe?></button>
    </div>
    <?php } ?>
  </form>
        <!-- end agent person -->

      </div>

      <div id="wait_process" style="background: black; display:none;">
        <div class="wait" style="background: rgba(0 ,0 ,0 ,0.5);position: fixed;top: 0;right: 0;bottom: 0;left: 0;z-index: 1050;overflow: hidden;-webkit-overflow-scrolling: touch;outline: 0;">
          <div class="" style="text-align: center;font-size: 20px;position: absolute;left: 50%;top: 50%;border-radius: 5px;margin-left: -133px;background: #fff;width: 250px;height: 58px;">
            <img src="images/loading.gif" alt="" style="position: relative;top: 12px;right: 21px;"> <span style="position: relative;top: 14px;"><?=$txt_Please_wait?></span>
            <div class="" style="font-size:16px;padding-left:50px;">
              <!-- ระบบกำลังบันทึกข้อมูล -->
            </div>
          </div>
        </div>
      </div>

        <div class="footer-index">
          <div class="img-logo-footer">
          <img src="images/logo_foot.png">
        </div>
        <div class="credits-footer">
          <label class="credits-1">Department of International Trade Promotion, Ministry of Commerce, Thailand.  Tel. +66 2507 7999 e-mail: ditpcare@ditp.go.th</label><br>
          <label class="credits-2">© 2016, Department of International Trade Promotion, Ministry of Commerce, Thailand. All rights reserved.</label>
        </div>
      </div>

    </div>
  </div>
  </body>
</html>
<script>
  $( document ).ready(function() {
    $("#sel_city_person_person").prop('disabled', 'disabled');
    $("#sel_city_office").prop('disabled', 'disabled');
    $("#sel_city_person_office").prop('disabled', 'disabled');

    if($('.status_login').val() == ""){
      if($('.img_f').val() != ""){
        $('#register_img').attr('src', $('.img_f').val());
      }
    }

  });

  $( document ).ready(function() {
        $("#box_fix_person_agentoffice").mask('999-999-9999',
          {
              reverse: true,
              onChange: function(cpf){
                  var cpfEl = $('section.inscricao #cpf').get(0);
                  cpfEl.selectionStart = cpfEl.selectionEnd = cpfEl.value.length;
              }
          }
      );

      $("#box_fix_person_agentperson").mask('999-999-9999',
        {
            reverse: true,
            onChange: function(cpf){
                var cpfEl = $('section.inscricao #cpf').get(0);
                cpfEl.selectionStart = cpfEl.selectionEnd = cpfEl.value.length;
            }
        }
    );

    });

    $("#box_fix_person_agentoffice").on("blur", function() {
      var last = $(this).val().substr( $(this).val().indexOf("-") + 1 );

      if( last.length == 3 ) {
          var move = $(this).val().substr( $(this).val().indexOf("-") - 1, 1 );
          var lastfour = move + last;

          var first = $(this).val().substr( 0, 9 );

          $(this).val( first + '-' + lastfour );
      }else{
      }
    });

    $("#box_fix_person_agentperson").on("blur", function() {
      var last = $(this).val().substr( $(this).val().indexOf("-") + 1 );

      if( last.length == 3 ) {
          var move = $(this).val().substr( $(this).val().indexOf("-") - 1, 1 );
          var lastfour = move + last;

          var first = $(this).val().substr( 0, 9 );

          $(this).val( first + '-' + lastfour );
      }else{
      }
    });


  $(".box_tel_person_agentoffice").keypress(function (e) {
       //if the letter is not digit then display error and don't type anything
       if (e.which != 8 && e.which != 0 && String.fromCharCode(e.which) != '-' && (e.which < 48 || e.which > 57)) {
          //display error message
          // $("#errmsg").html("Digits Only").show().fadeOut("slow");
                 return false;
      }
  });

  $(".box_tel_person_agentperson").keypress(function (e) {
       //if the letter is not digit then display error and don't type anything
       if (e.which != 8 && e.which != 0 && String.fromCharCode(e.which) != '-' && (e.which < 48 || e.which > 57)) {
          //display error message
          // $("#errmsg").html("Digits Only").show().fadeOut("slow");
                 return false;
      }
  });

  var getUrlParameter = function getUrlParameter(sParam) {
      var sPageURL = decodeURIComponent(window.location.search.substring(1)),
          sURLVariables = sPageURL.split('&'),
          sParameterName,
          i;

      for (i = 0; i < sURLVariables.length; i++) {
          sParameterName = sURLVariables[i].split('=');

          if (sParameterName[0] === sParam) {
              return sParameterName[1] === undefined ? true : sParameterName[1];
          }
      }
  };

  function language_select(type){
      var status_login = $('.status_login').val();
      var blog = getUrlParameter('page');
        window.location.href = '/frontend/agent.php?page='+blog+'&status='+status_login+'&lang='+type+'';
  }
</script>
