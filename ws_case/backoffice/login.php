<?php include("../config/config.php"); ?>
<?php include("../api/ditp_extapi.php"); ?>
<?php include("class/main.class.php"); ?>
<?php include("class/employee.class_ldap.php");//_ldap ?>
<?php
$member_cls = new member_base();
if($_REQUEST["method"]=="login"){
  $username = mysqli_real_escape_string($conn,$_POST["username"]);
  $password = $_POST["password"];
   if($member_cls->login($username,$password)){
        if(isset($_SESSION["admin"]["empLv"]) && $_SESSION["admin"]["empLv"] == 1){ //check level เพื่อแสดงปุ่ม
            $_SESSION["admin"]["login_as"] = 1;
        }
     ?>
     <script>window.parent.location.href = "index.php";</script>
     <?php
   }else{
     ?>
     <script>alert('Username or password invalid!');</script>
     <?php
   }
   //print_r($member_cls->login($username,$password));
 exit();
}
if($member_cls->checkLoginSession()==true){
  ?>
  <script>window.location.href = "index.php";</script>
  <?php
  exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
<!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
<title>DITP Care Management</title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

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

<!-- FONTS -->
<link rel="stylesheet" type="text/css" href="css/fonts.css">


<!-- BOOTSTRAP -->
<link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.css">


<!-- HELPERS -->

<link rel="stylesheet" type="text/css" href="assets/helpers/spacing.css">
<link rel="stylesheet" type="text/css" href="assets/helpers/utils.css">

<!-- ELEMENTS -->

<link rel="stylesheet" type="text/css" href="assets/elements/buttons.css">
<link rel="stylesheet" type="text/css" href="assets/elements/content-box.css">
<link rel="stylesheet" type="text/css" href="assets/elements/forms.css">






<!-- Admin theme -->

<link rel="stylesheet" type="text/css" href="assets/themes/admin/layout.css">
<link rel="stylesheet" type="text/css" href="assets/themes/admin/color-schemes/default.css">

<!-- Components theme -->

<link rel="stylesheet" type="text/css" href="assets/themes/components/default.css">
<link rel="stylesheet" type="text/css" href="assets/themes/components/border-radius.css">

<!-- Admin responsive -->

<link rel="stylesheet" type="text/css" href="assets/helpers/responsive-elements.css">
<link rel="stylesheet" type="text/css" href="assets/helpers/admin-responsive.css">

<link rel="stylesheet" type="text/css" href="css/style_login.css">

    <!-- JS Core -->

    <script type="text/javascript" src="assets/js-core/jquery-core.js"></script>
    <script type="text/javascript" src="assets/js-core/jquery-ui-core.js"></script>
    <script type="text/javascript" src="assets/js-core/jquery-ui-widget.js"></script>
    <script type="text/javascript" src="assets/js-core/jquery-ui-mouse.js"></script>
    <script type="text/javascript" src="assets/js-core/jquery-ui-position.js"></script>
    <!--<script type="text/javascript" src="assets/js-core/transition.js"></script>-->
    <script type="text/javascript" src="assets/js-core/modernizr.js"></script>
    <script type="text/javascript" src="assets/js-core/jquery-cookie.js"></script>





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

<div class="center-vertical">
    <div class="center-content row">

        <div class="col-md-6 col-xs-12 col-md-offset-1 col-lg-offset-2 login_contain">



            <div class="content-box border-top border-red clearfix">
                <div class="content-box-wrapper row">

                    <form id="login-validation" class="" method="post" action="login.php?method=login" target="iframe_login">
                        <div id="login-form" >
                            <div class="pad20A col-md-10 col-md-offset-1">
                                <h1>Sign In</h1>
                                <div class="form-group">

                                    <div class="input-group input-group-lg">
                                        <input type="email" class="form-control" name="username" id="InputEmail1" placeholder="Username" autocomplete="off" style="text-indent:10px;">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-lg">
                                        <input type="password" class="form-control" name="password" id="InputPassword1" placeholder="Password" autocomplete="off" style="text-indent:10px;">
                                    </div>
                                </div>
                                <div class="form-group">

                                    <div class="checkbox-primary col-md-6  form-group-btn" >
                                        <label>
                                            <input type="checkbox" id="loginCheckbox1" class="custom-checkbox">
                                            Remember me
                                        </label>
                                    </div>
                                    <div class="col-md-2"></div>
                                    <div class="col-md-4 form-group-btn">
                                      <button type="submit" class="btn btn-block btn-green-alt">Login</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                    <div class="bg-login-form-right hidden-md hidden-sm hidden-xs">
                      <img src="img/bg-login-form-right.png"  />
                        <div class="center-vertical">
                            <div class="center-content">


                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>

    </div>
</div>
<iframe name="iframe_login" style="display:none"></iframe>



    <!-- WIDGETS -->

<script type="text/javascript" src="assets/bootstrap/js/bootstrap.js"></script>


<!-- Superclick -->
<script type="text/javascript" src="assets/widgets/superclick/superclick.js"></script>




</body>
</html>
