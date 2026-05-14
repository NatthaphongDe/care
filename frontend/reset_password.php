<?php
include("../config/config.php");

// echo $_GET['id'];
if($_POST['ch_type']==''){
    if($_GET['id']==''){
         ?><script type="text/javascript">alert('คุณไม่มีสิทธิ์เข้าถึงการแก้ไขรหัสผ่าน');window.parent.location.href='index.php';</script><?php
    }
    if($_GET['id']!=''){
    $sql_ch_tokin = "SELECT * FROM Member Where  member_tokin = '".$_GET['id']."' ";
      $query_ch_tokin = $conn->query($sql_ch_tokin);
      if($query_ch_tokin->num_rows>0){
          while ( $re_ch_tokin =   $query_ch_tokin->fetch_assoc()) {
          if($re_ch_tokin['member_reset_pass']=='0'){
              ?><script type="text/javascript">alert('คุณไม่สามารถแก้ไขรหัสผ่านได้ เนื่องจากรหัสผ่านมีการแก้ไขแล้ว');window.parent.location.href='index.php?page=home';</script><?php
              exit();
          }
        }
      }
      else{
        ?><script type="text/javascript">alert('คุณไม่มีสิทธิ์เข้าถึงการแก้ไขรหัสผ่าน');window.parent.location.href='index.php';</script><?php
      }
    }
}
class PassHash {
    private static $algo = '$2a';
    private static $cost = '$10';
    public static function unique_salt() {
        return substr(sha1(mt_rand()), 0, 22);
    }
    public static function hash($password) {
        return crypt($password, self::$algo .
                self::$cost .
                '$' . self::unique_salt());
    }
    public static function check_password($hash, $password) {
        $full_salt = substr($hash, 0, 29);
        $new_hash = crypt($password, $full_salt);
        return ($hash == $new_hash);
    }
}
if(isset($_GET["method"]) && $_GET["method"]=="ch_pass"){

    $p1 =  mysqli_real_escape_string($conn, $_POST['password']);
    $p2 =  mysqli_real_escape_string($conn, $_POST['password1']);
    $id_check  = mysqli_real_escape_string($conn,$_POST['ch_tokin']);
  // if($id_check==''){
  //   ?><script type="text/javascript">//alert('คุณไม่มีคำขอให้แก้ไขรหัสผ่าน');</script><?php
  //   exit();
  // }
  // if($p1==''){
  //   ?><script type="text/javascript">//alert('กรุณากรอกรหัสผ่าน');</script><?php
  //   exit();
  // }
  // if($p2==''){
  //   ?><script type="text/javascript">//alert('กรุณายืนยันรหัสผ่าน');</script><?php
  //     exit();
  // }
  // if($p1 != $p2){
  //   ?><script type="text/javascript">//alert('กรุณากรอกรหัสผ่านทั้ง 2 ช่อง ให้ตรงกัน');</script><?php
  //     exit();
  // }

  $sql_count = "SELECT * FROM Member Where  member_tokin = '$id_check'";
  $query_count = $conn->query($sql_count);
  if($query_count->num_rows>0){
    while ( $re_count =   $query_count->fetch_assoc()) {
        if($re_count['member_reset_pass']==1){
        $member_id  = $re_count['member_id'];
        $password_hash = PassHash::hash($p1);
        $sql_count = "  UPDATE `Member`
                        SET member_password='$password_hash',
                            member_reset_pass = 0
                        WHERE member_id = '$member_id' ";
        $query_count = $conn->query($sql_count);
          if($query_count){
            ?><script type="text/javascript">alert('บันทึกรหัสผ่านใหม่เรียบร้อยแล้ว');window.parent.location.href='index.php';</script><?php
          }else{
            ?><script type="text/javascript">alert('บันทึกรหัสผ่านผิดพลาดกรุณาลองใหม่');</script><?php
            exit();
          }
        }else {
          ?><script type="text/javascript">alert('ไม่สามารถแก้ไขรหัสผ่านได้ เนื่องจากมีการเแก้ไขรหัสผ่านแล้ว');</script><?php
          exit();
        }
      }
    }
exit();
}



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
    <form  class="" id="submit_form_pass" method="POST" action="reset_password.php?method=ch_pass" target="iframe_login">
        <input type="hidden" name="ch_tokin" value="<?php echo $_GET['id'];?>">
        <input type="hidden" name="ch_type" value="1">
      <div id="login-form" style="float:none" class="reset_pass content-box content-box-wrapper">
        <div class="pad20A col-md-10 col-md-offset-1">
          <h1 style="text-align: left;">Reset password</h1>
          <div class="form-group">
            <div class="input-group input-group-lg">
              <input type="password" class="form-control" name="password" id="InputPassword" placeholder="New Password" autocomplete="off">
            </div>
          </div>
          <div class="form-group">
            <div class="input-group input-group-lg">
              <input type="password" class="form-control" name="password1" id="InputPassword1" placeholder="Confrim Password" autocomplete="off">
            </div>
          <div class="" style="padding: 20px 0px 0px 10px;color: #E74C3C;">
              * must contain alphanumeric A-Z, a-z, 0-9, with at least 8 digits in length
          </div>
          </div>
          <div class="form-group">
            <div class="checkbox-primary col-md-6  form-group-btn" >
            </div>
            <div class="col-md-2"></div>
            <div class="col-md-4 form-group-btn">
              <button type="button" class="btn btn-block btn-green-alt" onclick="check_pass();">ยืนยัน</button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>

  <iframe name="iframe_login" style="display:none"></iframe>
</body>
</html>


<style media="screen">
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
</style>

<script type="text/javascript">
  function check_pass(){
  var re = new RegExp(/^(?=.*\d)(?=.*[0-9a-zA-Z]).{8,}$/);
  var p1 =  $('#InputPassword').val();
  var p2 =  $('#InputPassword1').val();
  if(p1==''){
    alert('กรุณากรอกรหัสผ่าน');
    exit();
  }
  if(p2==''){
    alert('กรุณายืนยันรหัสผ่าน');
    exit();

  }
  if(p2!=p1){
    alert('รหัสผ่านไม่ตรงกัน กรุณากรอกใหม่');
    exit();

  }
  if(re.test(p1) == false){
    alert('รหัสผ่าน ต้องมี A-z,a-z และ 0-9 และมี 8 หลักขึ้นไป');
  }else{
    document.getElementById("submit_form_pass").submit();
  }




  }
</script>
