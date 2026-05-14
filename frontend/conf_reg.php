<?php
include("../config/config.php");
?>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
  <title>DITP Care Management</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

  <!-- FONTS -->
  <link rel="stylesheet" type="text/css" href="forgot_pass/css/fonts_login.css">

  <!-- BOOTSTRAP -->
  <link rel="stylesheet" type="text/css" href="forgot_pass/assets/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="forgot_pass/assets/helpers/utils.css">
  <link rel="stylesheet" type="text/css" href="forgot_pass/assets/elements/forms.css">
  <link rel="stylesheet" type="text/css" href="forgot_pass/css/style_login.css">

  <!-- JS Core -->

  <script type="text/javascript" src="forgot_pass/assets/js-core/jquery-core.js"></script>

  <script type="text/javascript">
  $(window).load(function(){
    setTimeout(function() {
      $('#loading').fadeOut( 400, "linear" );
    }, 300);
  });
  </script>
</head>
<body>
  <div id="loading">
    <div class="spinner">
      <div class="bounce1"></div>
      <div class="bounce2"></div>
      <div class="bounce3"></div>
    </div>
  </div>

  <style type="text/css">

  html,body {
    height: 100%;
    background: #F5F5F5;
  }
  </style>
  <div class="col-md-12 pd_box_re" style="text-align: -webkit-center;">
      <div id="login-form" style="float:none" class="reset_pass content-box content-box-wrapper">
        <div class="col-md-12">
          <?php

              if($_GET['conf']==''){ ?>
                <div class="row" id="row_url_fail">
                  <div class="col-md-1"></div>
                    <div class="col-md-10">
                      <div class="panel panel-default panel_invite_orter">
                        <span class="url_fail"> ลิ้ง URL ของท่านไม่ถูกต้อง กรุณาตรวจสอบเพื่อยืนยันการสมัครสมาชิกของท่าน</span>
                      <div class="panel-body">
                      </div>
                      </div>
                    </div>
                  <div class="col-md-1"></div>
                </div>
                <div class="bk_home"><button class="btn btn-warning" style="width:100px;" onclick="bk_home();">หน้าหลัก</button></div>
              <?php }else{
                $date_time = date("Y-m-d H:i:s");
                $sql_ch_tokin = "SELECT * FROM Member Where  member_token_confirm = '".$_GET['conf']."' AND member_status_confirm = 0 ";
                  $query_ch_tokin = $conn->query($sql_ch_tokin);
                  if($query_ch_tokin->num_rows>0){
                      $re_ch_tokin =   $query_ch_tokin->fetch_assoc();
                      if($re_ch_tokin['member_status_confirm']=='0'){
                        $sql_count = "  UPDATE `Member` SET member_status_confirm = 1 , member_date_confirm = '".$date_time."' WHERE member_id = '".$re_ch_tokin['member_id']."' ";
                        $query_count = $conn->query($sql_count);
                        ?>
                        <div class="row" id="row_url_fail_con">
                          <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <span class="url_fail" style="font-size:18px;">ท่านได้ยืนยันการสมัครสมาชิกเรียบร้อยแล้ว</span>
                                <span class="url_fail_con" style="font-size:18px;">กรุณาเลือกช่องทางการเข้าสู่ระบบ</span>
                            </div>
                          <div class="col-md-1"></div>
                        </div>
                        <div class="bk_home">
                          <button class="btn btn-warning Web_Application" style="width:130px;" onclick="bk_home();">Web Application</button>
                          <a href="https://itunes.apple.com/us/app/ditp-care/id1258032044"><img class="home_center_app"  src="images/home_center_app.png" style="margin-left:10px; margin-right:10px;"></a>
                          <a href="https://play.google.com/store/apps/details?id=th.go.ditp.ditpcare"><img src="images/home_center_play.png"></a>
                        </div>
                        <?php
                      }else {
                        ?>
                        <div class="row" id="row_url_fail_con">
                          <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <span class="url_fail" style="font-size:18px;">ท่านได้ยืนยันการสมัครสมาชิกเรียบร้อยแล้ว</span>
                                <span class="url_fail_con" style="font-size:18px;">กรุณาเลือกช่องทางการเข้าสู่ระบบ</span>
                            </div>
                          <div class="col-md-1"></div>
                        </div>
                        <div class="bk_home">
                          <button class="btn btn-warning Web_Application" style="width:130px;" onclick="bk_home();">Web Application</button>
                          <a href="https://itunes.apple.com/us/app/ditp-care/id1258032044"><img class="home_center_app" src="images/home_center_app.png" style="margin-left:10px; margin-right:10px;"></a>
                          <a href="https://play.google.com/store/apps/details?id=th.go.ditp.ditpcare"><img src="images/home_center_play.png"></a>
                        </div>
                        <?php

                      }

                }else {
                  ?>
                  <div class="row" id="row_url_fail">
                    <div class="col-md-1"></div>
                      <div class="col-md-10">
                        <div class="panel panel-default panel_invite_orter">
                          <span class="url_fail"> ลิ้ง URL ของท่านไม่ถูกต้อง กรุณาตรวจสอบเพื่อยืนยันการสมัครสมาชิกของท่าน</span>
                        <div class="panel-body">
                        </div>
                        </div>
                      </div>
                    <div class="col-md-1"></div>
                  </div>
                  <div class="bk_home"><button class="btn btn-warning" style="width:100px;" onclick="bk_home();">หน้าหลัก</button></div>
                  <?php
                }
              }

          ?>
        </div>
      </div>

  </div>
</body>
</html>


<style media="screen">
#row_url_fail_con{
  position: relative;
  top: 50px;
}
#row_url_fail{
  position: relative;
  top: 100px;
}
.bk_home{
  position: relative;
  top: 150px;
}
.panel_invite_orter{
  margin-bottom: 0px;
  background-color: #faebd7;
}
.url_fail_con{
  margin-top: 15px;
  display: inline-block;
}
.url_fail{
  margin-top: 25px;
  display: inline-block;
}
.pd_box_re{
  margin-top: 100px;
}
@media only screen and (max-width: 768px){
  #login-form{
    margin: 90px;
    padding-bottom: 10px;
  }
}
@media screen and (max-width: 650px){
  .reset_pass .content-box .content-box-wrapper {
    padding: 5px;
    width: auto;
  }
  .pd_box_re{
    margin-top: 10px
  }
  #login-form {
    margin-top: 10px;
    margin: 0px;
    padding-bottom: 10px;
  }
}


@media (max-width:768px) {
  #row_url_fail{
    top:-45px;
  }
  .bk_home{
    top:-20px;
  }
  #row_url_fail_con{
    top:-45px;
  }
}
@media (max-width:425px) {
    .pd_box_re {
      margin-top: 100px;
  }
}
@media (max-width:375px) {
    .url_fail,.url_fail_con {
      font-size: 16px !important;
  }
  .Web_Application
  {
    width: 220px !important;
    margin-bottom: 10px;
  }
  .home_center_app{
    margin-left: 0px !important;
    margin-right: 15px !important;
  }
}
@media (max-width:320px) {
    .url_fail,.url_fail_con {
      font-size: 14px !important;
  }
}
</style>

<script type="text/javascript">
 function bk_home(){
   window.location.href='index.php?page=home';
 }
</script>
