<?php
session_start();
include('config/config.php');
include('class/main.class.php');
include('class/case.class.php');
include('function_php/chk_login.php');
/* header("X-Frame-Options: DENY"); */
$case_cls = new case_base();
if ($_GET['regis']=="88") { ?>
 <script type="text/javascript">
		setTimeout(function () {
			register_modal(0)
		}, 500);
 </script>

<?php }
if (!($_GET['page']=="home" || $_GET['page']=="info" || $_GET['page'] == "info_detail" || $_GET['page'] == "question"|| $_GET['page'] == "usersmanual")  && checklogin() == false){
	if($_GET['page']=="appeal_detail") { 
		$case_id = $_GET['case_id'];
		$case_user_id = $_GET['user_id'];
		session_start();
		$_SESSION["appeal_detail"] = '0';
		$_SESSION["case_id"] = $case_id;
		$_SESSION["case_user_id"] = $case_user_id;

		if($case_user_id != md5($_SESSION["member_id"]) && $_SESSION["member_id"] != '') {
			$_SESSION["check_user_id"] = 'false';
		} else {
			$_SESSION["check_user_id"] = 'true';
		}
	} else {

		
		setcookie('chk_lang', null, -1, '/frontend');
		header('Location:index.php?page=home');
	}
	
} else {
	if($_GET['page']=="appeal_detail")  {
		$case_id = $_GET['case_id'];
		$case_user_id = $_GET['user_id'];
		session_start();
		$_SESSION["appeal_detail"] = '0';
		$_SESSION["case_id"] = $case_id;
		$_SESSION["case_user_id"] = $case_user_id;

		if($case_user_id != md5($_SESSION["member_id"]) && $_SESSION["member_id"] != '') {
			$_SESSION["check_user_id"] = 'false';
		} else {
			$_SESSION["check_user_id"] = 'true';
		}
	}
}
// if($_SESSION["visited_web"]=="" && $_GET["intro"]==""){
// 	header('Location:index.php?page=home&intro=king9');
// }

// if($_SESSION == ""){
// 	setcookie('chk_lang', null, -1, '/frontend');
// }
include('lang.php');

// if ($_SERVER['REMOTE_ADDR'] == "10.8.1.4") {
// 	echo "<pre>";
// 	print_r($_SESSION);
// 	echo "</pre>";
// }
?>
 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml" >
  <head>
		<!-- Favicons -->
		<link rel="icon" type="image/png" href="img/logo-DITP-title.png">
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
		<!-- <link rel="icon" type="image/png" sizes="32x32" href="../favicon.ico/favicon-32x32.png"> -->
		<link rel="icon" type="image/png" sizes="96x96" href="../favicon.ico/favicon-96x96.png">
		<!-- <link rel="icon" type="image/png" sizes="16x16" href="../favicon.ico/favicon-16x16.png"> -->
		<!-- <link rel="manifest" href="../favicon.ico/manifest.json"> -->
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
		<meta name="theme-color" content="#ffffff">

	<meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' *.gstatic.com *.google.com connect.facebook.net 'unsafe-inline' *.googletagmanager.com 'unsafe-eval'; style-src 'self' 'unsafe-inline' *.jsdelivr.net  *.cloudflare.com *.datatables.net *.googleapis.com; font-src 'self' *.jsdelivr.net *.cloudflare.com *.gstatic.com; connect-src 'self' *.facebook.com analytics.google.com; img-src 'self' * data:; frame-src 'self' *.facebook.com; media-src 'none'; object-src 'none'; manifest-src 'none'; worker-src 'none'; form-action 'self'; " always;>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>DITP กรมส่งเสริมการค้าระหว่างประเทศ กระทรวงพาณิชย์</title>
    <link rel="stylesheet" href="lib/bootstrap-3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="lib/bootstrap-3.3.7/css/build.css">
		<link rel="stylesheet" href="lib/bootstrap-select-1.13.14/dist/css/bootstrap-select.min.css">
		<link rel="stylesheet" href="lib/bootstrap-datepicker-1.6.4-dist/css/bootstrap-datepicker.min.css" />
    <link rel="stylesheet" href="lib/font-awesome-4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="lib/EasyAutocomplete-master/dist/easy-autocomplete.css">
    <link rel="stylesheet" href="css/frontend_index_2020.css?v=20180521">
		<link rel="stylesheet" href="css/king_of_css.css">
    <link rel="stylesheet" href="css/switch.css">
    <link rel="stylesheet" href="css/fonts.css">
		<link rel="stylesheet" href="css/font-icon.css">
		<link rel="stylesheet" href="lib/bootstrap-table/dist/bootstrap-table.min.css">

		<link rel="stylesheet" href="assets/intlTelInput/css/intlTelInput.css">
  		<link rel="stylesheet" href="assets/intlTelInput/css/demo.css">
		<link rel="stylesheet" href="lib/SweetAlert2/sweetalert2.min.css">

		<!-- <link rel="stylesheet" type="text/css" href="lib/izitoast/dist/css/iziToast.css">
		<script type="text/javascript" src="lib/izitoast/dist/js/iziToast.js"></script> -->

		<script src="lib/SweetAlert2/sweetalert2.all.min.js"></script>
    <script src="js/jquery-core.js"></script>
		<script src="assets/input-mask/inputmask.js"></script>
		<script src="js/bootbox.min.js"></script>
		<script src="assets/js-core/jquery-cookie.js"></script>
    <script src="lib/bootstrap-3.3.7/js/bootstrap.min.js"></script>
		<script src="lib/bootstrap-select-1.13.14/dist/js/bootstrap-select.min.js"></script>
		<script src="lib/bootstrap-select-1.13.14/dist/js/bootstrap-select.js"></script>
		<script src="lib/bootstrap-table/dist/bootstrap-table.min.js"></script>
		<?php if($lang == "1"){?>
		<script src="lib/bootstrap-table/dist/locale/bootstrap-table-th-TH.min.js"></script>
		<?php } ?>
		<script type="text/javascript" src="lib/bootstrap-datepicker-1.6.4-dist/js/bootstrap-datepicker.js"></script>
		<script src="lib/EasyAutocomplete-master/dist/jquery.easy-autocomplete.js"></script>
    <script src="js/index_function.js"></script>
		<script src='https://www.google.com/recaptcha/api.js'></script>

		<!-- Google tag (gtag.js) -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=G-XC2T48NSER"></script>
		<script>
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			gtag('js', new Date());

			gtag('config', 'G-XC2T48NSER');
		</script>
		<script src="js/jquery.inputmask.js"></script>
		<script>

		$(document).ready(function () {
			  $('.box-overlay.box-outer').height($(window).height());
			  $(window).resize(function () {
			    $('.box-overlay.box-outer').height($(window).height());
			  });
			  $(window).scroll(function () {
			    if ($(this).scrollTop() > 100) {
			      $('.scrollup').fadeIn();
			    } else {
			      $('.scrollup').fadeOut();
			    }
			  });

			  $('.scrollup').click(function () {
			    $("html, body").animate({
			      scrollTop: 0
			    }, 600);
			    return false;
			  });

				var isFirefox = navigator.userAgent.toLowerCase().indexOf('firefox') > -1;
				if(isFirefox){
					// Do Firefox-related activities
					$(".box-overlay.box-outer").css({
						"height":$(window).height()+"px",
						"transform": "translate3d(0px, 0px, 0px)"
					});
					$(".box-overlay .box-middle").css({
						"transform": "translate3d(0px, 0px, 0px)"
					});

				}

			});


			$(window).scroll(function() {
				var isFirefox = navigator.userAgent.toLowerCase().indexOf('firefox') > -1;
				if(isFirefox){
					// Do Firefox-related activities
					console.log("a");
						//increaseLag(this);
						var scrollTop = $(this).scrollTop();
						console.log(scrollTop);
						$(".box-overlay.box-outer").css("top", scrollTop+"px");

				}
			});

			$(document).resize(function () {
				$(".box-overlay.box-outer").css({
					"height":$(window).height()+"px",
					"transform": "translate3d(0px, 0px, 0px)"
				});
				$(".box-overlay.box-outer").css({
					"height":$(window).height()+"px",
					"transform": "translate3d(0px, 0px, 0px)"
				});
			});
		function hidepopup_king9(){
			  $.post("function_php/visited_web.php", function( data ) {
			    window.location.href="index.php?page=home";
			  });
			}

		</script>

  </head>
  <body>
<?php
/* if($_SESSION["visited_web"]==""){
	?>
<div class="box-overlay box-outer">
  <div class="box-middle">
    <div class="container_pop">
      <div class="box-login">
        <p style="text-align: center;"class="btn_goto_home"><a onclick="hidepopup_king9();" href="javascript:;"><span>เข้าสู่เว็บไซต์</span></a></p></div>
      </div>
    </div>
  </div>
  <?php
} */
	?>

	<?php //if($_GET['state']!='update'){ ?>
		<!-- <div class="container">
			<div class="row">
				<div class="col text-center">
					<img src='../img/header_email.png' width='100%'>
						<h2 class="jumbotron-heading">ขออภัยในความไม่สะดวก</h2>
						<p class="lead text-muted">
							ขณะนี้อยู่ระหว่างปรับปรุงระบบ <br>
							เพื่อเพิ่มประสิทธิภาพการให้บริการ
						</p>
						
				</div>
			</div>
		</div> -->
	<?php //exit; //} ?>

	<style>

body,html{
  margin: 0px !important;
  padding: 0px;
  overflow-x: hidden;
  background-color: #EBEBEB;
  padding-right: 0px !important;
  font-family: 'kanit';
  font-weight: lighter;
  font-style: normal;
  font-size: 16px;
}

.nav > li > a:not( :hover ) {
  background-color: transparent;
}

		.checkbox-inline input{
			width: auto;
    		height: auto;
		}
/* @media screen and (max-width: 1250px) {
  .hidden-c {
   width:15px;
  }
} */
.navbar-nav>li>a {
    padding-top: 10px;
    padding-bottom: 10px;
    line-height: 15px;
}

.iti__flag.iti__tw {
  height: 14px;
  background-position: 29px 0px !important;
  background-color: #fff !important;
}

@media (max-width: 1600px) {
  .navbar-nav>li {
    width: 160px;
  }

  .navbar-nav>li>a {
    font-size: 14px;
  }
  .text_sub_menu {
    font-size: 9px !important;
  }
}

@media (max-width: 1440px){
  .div_center_hide{
    height: 165px !important;
  }
  .center_img_2{
    width: 40%;
  }

  .navbar-nav>li {
    width: 140px;
  }

  .navbar-nav>li>a {
    font-size: 12px;
  }
  .text_sub_menu {
    font-size: 8px !important;
  }
}

@media (max-width: 1268px){
  .navbar-nav>li{
    width: 115px;
  }
  .navbar-nav>li>a{
    font-size: 10px;
  }
  .text_sub_menu {
    font-size: 6px !important;
  }
}
	</style>

	<?php //if($_SESSION['visited_popup'] != 1){ ?>
	<!-- <div id="myModal" class="modal fade" role="dialog" data-backdrop="static"> -->
	<!-- <div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
		<div class="modal-header" style="padding:5px;">
			<button type="button" class="close" data-dismiss="modal" onclick="modal_popup('close')">&times;</button>
		</div>
		<div class="modal-body" style="padding:6px;">
			<a href="file_ditp/DITP-CARE_Link.pdf" target="_blank"><img src="img/covid-19.jpg" width="100%"></a> -->
			<!--<a onclick="modal_popup('view')" data-dismiss="modal" target="_blank" style="cursor:pointer"><img src="img/covid-19.jpg" width="100%"></a>-->
		<!-- </div>
		</div>

	</div>
	</div> -->
	<!-- end of modal -->
	<?php //} ?>

  <div class="body-index">
    <div class="body-index-hr">
    <div class="row hr_index">
      <div class="col-md-1"></div>
      <div class="col-md-8 col-sm-8 col-xs-10" id="div_logo">
        <div class="div_logo-d">
					<a href="?page=home">
						<img src="images/logo-DITP.png">
	        </a>
        </div>
					<span class="title-language " style="font-size: 28px; font-weight:300;font-style: unset; "><?=$txt_International_hr?></span>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-2" id="div_language">
				<input type="hidden" class="language_hidden" value="<?php if($lang != ""){ echo $lang;}else{ echo "1";}?>">
				<input type="hidden" class="language_sess" value="<?=$xr['member_lang'];?>">
				
		<div class="col-7 col-md-8 " style="margin-top: 5px;" >
			<!-- <img src="img/logo-01.png"> -->
			<!-- Logo_69thAnniversaryDITP-04 -->
			<!-- <a href="https://www.ditp.go.th/" target="_blank" >
				<img src="img/DITP_DESIGN_B-02.png" style="max-width:150px; max-height:51px;min-width:100px; min-height:34px; width: 100%; height:100%;">
			</a> -->
      <?php
        // if($lang == "1" || $lang == "0" || $lang == ""){
          ?><!-- <img src="img/logo-01-01.png"> --><?php
        // }else{
          ?><!-- <img src="img/logo-01-02.png"> --><?php
        // }
       ?>
		</div>
		<div class="col-5 col-md-4">
				<span class="language">
					<a onclick="language_select(1);" style="cursor: pointer;"><span <?= ($lang == "1" || $lang == "0" || $lang == "") ? "class='lang_active'" : "" ?>>TH</span></a> |
					<a onclick="language_select(2);" style="cursor: pointer;"><span <?= ($lang == "2") ? "class='lang_active'" : "" ?>>EN</span></a></span><br>
				<!-- <span class="title-language"><?=$txt_International_hr?></span> -->
				</div>
      </div>
      <div class="col-md-1"></div>
    </div>
    <div class="bg_menu_hr">
    <div class="row">
      <!-- <div class="col-md-1" id="menu_nav_hr"></div> -->
      <div class="col-md-9 col-sm-9 col-xs-3 no-padding" id="menu_nav">
				<?php $login = $_SESSION['member_id'];?>
        <nav class="navbar">
          <div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
            <div class="navbar-collapse collapse no-padding" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">
                <li <?= ($_GET['page'] == "home" || $_GET['page'] == "") ? "class='active'" : "" ?>>
									<?php if($_SESSION['member_id'] == ""){
										$lang_home = "&lang=".htmlspecialchars($_GET['lang'], ENT_QUOTES);
									}else {
										$lang_home = "";
									}?>
                  <a href="?page=home<?=$lang_home?>" style="
    padding-top: 20px;
    padding-bottom: 20px;
">
                  <span class="icon_home"><img src="images/all_icon_DITP/icon_1.svg" style="width:30px;"></span><br>
                  <?=$txt_home?>
                  <span class="sr-only">(current)</span></a></li>
               
                <li <?= ($_GET['page'] == "invite" && $_GET['type'] == 1) ? "class='active md-login'" : "class='md-login'" ?> style="cursor: pointer;">
					
                  <a style="padding-top: 20px; padding-bottom: 20px;"
				  <?php if($login != ""){ ?>
				  href="?page=invite&type=1" style="padding-top: 20px; padding-bottom: 20px;"
				  <?php }?>>
				  <span class="icon_invite"><img src="images/all_icon_DITP/icon_3.svg" class=" hidden-c" style="width:30px;"></span><br >
				  <span>                <?=$txt_Start_petition?></span>
				  	</a>
				</li>
				<li <?= ($_GET['page'] == "invite" && $_GET['type'] == 2)  ? "class='active non-md-login'" : "class='non-md-login'" ?>  style="cursor: pointer;">
                  <a 
				  <?php if($login != "" && FALSE){ ?>
				  	href="?page=invite&type=2" style="padding-top: 20px; padding-bottom: 20px;"
				  <?php } else {?>
					href="https://www.ditp.go.th/corruption-and-Misconduct-Complaint-Form" style="padding-top: 20px; padding-bottom: 20px;"
				  <?php }?>
					>
				  <span class="icon_invite"><img src="images/all_icon_DITP/icon_3.svg" class="hidden-c" style="width:30px;"></span><br >
				  <span>     <?=$txt_Start_petition_2?></span>
             
				  	</a>
				</li>
				  <?php if($login != ""){?>
                <li <?= ($_GET['page'] == "appeal" || $_GET['page'] == "appeal_detail" || $_GET['page'] == "all_appeal") ? "class='active'" : "" ?>>
                  <a href="?page=appeal" style="padding-top: 20px; padding-bottom: 20px;">
                  <span class="icon_appeal"><img src="images/all_icon_DITP/icon_5.svg" style="width:30px;"></span><br>
                  <?=$txt_existing_petition?>
                  </a>
				  </li>
				  <?php } ?>		

					<!-- <li  class="info_nav md-login" style="     cursor: pointer;   width: 190px;">
						<a  style=" padding-top: 20px; padding-bottom: 20px; ">
							<span class="icon_info fa fa_ico_menu fa-bullhorn"></span><br>
						<?php if($_GET['lang'] == '2'){ ?>
							Start your petition<br>
							<p style="font-size: 10px;">international trade conflict</p>
						<?php } else{ ?>
							แจ้งเรื่องร้องเรียน<br>
							<p style="font-size: 10px;">ข้อพิพากทางการค้าระหว่างประเทศ</p>
						<?php } ?>
						</a>
					</li>
					<li  class="info_nav md-login" style="  cursor: pointer;   width: 190px;">
						<a  style=" padding-top: 20px; padding-bottom: 20px; ">
						<?php if($_GET['lang'] == '2'){ ?>
							<span class="icon_info fa fa_ico_menu fa-bullhorn"></span><br>
							Start your petition<br>
							<p style="font-size: 10px;">Corruption in government</p>
						<?php } else{ ?>
								<span class="icon_info fa fa_ico_menu fa-bullhorn"></span><br>
							แจ้งเรื่องร้องเรียน<br>
							<p style="font-size: 10px;">ทุจริตในภาครัฐและวินัยราชการ</p>
						<?php } ?>
						</a>
					</li> -->

                	<li <?= ($_GET['page'] == "info" || $_GET['page'] == "info_detail") ? "class='info_nav active'" : "" ?> class="info_nav">
									<?php if($_SESSION['member_id'] == ""){
										$lang_info = "&lang=".htmlspecialchars($_GET['lang'], ENT_QUOTES);
									}else {
										$lang_info = "";
									}?>
						<a href="?page=info<?=$lang_info?>" style=" padding-top: 20px; padding-bottom: 20px;">
						<span class="icon_info"><img src="images/all_icon_DITP/icon_7.svg" style="width:30px;"></span><br>
						<?=$txt_Knowledge?>
						</a>
					</li>
									
                	<!-- <li <?= ($_GET['page'] == "usermanual") ? "class='info_nav active'" : "" ?> class="info_nav">
									<?php if($_SESSION['member_id'] == ""){
										$lang_info = "&lang=".htmlspecialchars($_GET['lang'], ENT_QUOTES);
									}else {
										$lang_info = "";
									}?>
						<a href="?page=usersmanual<?=$lang_info?>" style="padding-top: 20px;padding-bottom: 20px;">
							<span class="icon_info fa fa_ico_menu fa-book"></span><br>
							<?=$txt_UserManual?>
						</a>
					</li> -->
					<li class="info_nav" style="cursor: pointer;">
						<a style="padding-top: 30px; padding-bottom: 30px;" target="_blank" href="https://sso.ditp.go.th/sso/index.php/auth?response_type=token&client_id=SS8663835&redirect_uri=https://sso.ditp.go.th/sso/portal/ck_portal&state=1">
							<span class="icon_invite"><img src="img/logo SSO.png" class=" hidden-c" style="width:30px;"></span><br >
							<span>     <?=$txt_sso_portal?></span>
						</a>
					</li>

              	</ul>
            </div><!-- /.navbar-collapse -->


          </div><!-- /.container-fluid -->
        </nav>

      </div>
      <div class="col-md-3 col-sm-3 col-xs-8" id="siam_credits">
				<div class="div_logout">
        <?php if($login != ""){ ?>
        <div class="letter"><a href="?page=letter" title="<?=$txt_Message?>"><img src="images/all_icon_DITP/icon_9.svg" style="width:30px;"></a>
					<?php
					$case_id_arr = array();
					$sql = "SELECT * FROM `Case` WHERE caseCh_id in (1,2) AND case_createBy_id = '".$_SESSION['member_id']."'";
					$query = $conn->query($sql);
					while ($re = $query->fetch_assoc()) {
						$case_id_arr['case_id'] = $re['case_id'];
						array_push($case_id_arr,$case_id_arr['case_id']);
					}
					$case = "";
					$i =0;
					foreach ($case_id_arr as $value) {
						if($i == 0){
							$case =  $value;
						}else {
							$case .=  ",".$value;
						}
						$i++;
					}
					$sql_box = "SELECT * FROM `Message_Box`
					WHERE ((case_id IN ($case) AND sender_type = 2)
					OR (sender_type = 0 AND sender_id = '".$_SESSION['member_id']."')) AND msgBox_status = 0";
					$query_box = $conn->query($sql_box);
						if($query_box->num_rows > 0){
							while ($res = $query_box->fetch_assoc()) {
							$sql_log = "SELECT * FROM `Message_Box_Log` WHERE msgBox_id = '".$res['msgBox_id']."' AND msgBox_noti_status = 0 AND recipient_type = 1";
	            $query_log = $conn->query($sql_log);
							if($query_log->num_rows > 0){
								$sum_noti_letter = $query_log->num_rows;
								?>

								<span class="noti_letter">
									<?php
									if($sum_noti_letter > 99){
										echo "99+";
									}else {
										echo $sum_noti_letter;
									}
									?>
								</span>

						<?php
							}
						}
					}
					?></div>
        <div class="bell"><a href="?page=bell" title="<?=$txt_Notification?>"><img src="images/all_icon_DITP/icon_11.svg" style="width:30px;"></a>
					<?php
						$sql_noti = "SELECT m.msgNoti_status,m.member_id,m.msgNotiApp_noti_status,mb.member_noti FROM `Message_Noti_App` AS m
						LEFT JOIN `Member` AS mb ON m.member_id = mb.member_id
						 WHERE m.msgNoti_status = 0 AND m.member_id = '".$_SESSION['member_id']."' AND m.msgNotiApp_noti_status = '0'";
						$query_noti = $conn->query($sql_noti);
						if($query_noti->num_rows > 0){
							$sum_noti = $query_noti->num_rows;
							?>

							<span class="noti_bell">
								<?php
								if($sum_noti > 99){
									echo "99+";
								}else {
									echo $sum_noti;
								}
								?>
							</span>

					<?php
						}
					?></div>
	
				<?php
				
				$sql = "SELECT * FROM `Member` WHERE member_id = '".$_SESSION['member_id']."'";
				$query = $conn->query($sql);
				if($query->num_rows > 0){
					$res = $query->fetch_assoc();
				}

				$sql_comp = "SELECT * FROM `Member_comp` WHERE member_id = '".$_SESSION['member_id']."'";
				$query_comp = $conn->query($sql_comp);
				if($query_comp->num_rows > 0){
					$rc = $query_comp->fetch_assoc();
				}
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
				?>
				
        <span class="logo_siam" onclick="toggleMenu()" style="cursor: pointer;">
					<?php if($_SESSION["member_type"] == 0 || $_SESSION["member_type"]==3 || $_SESSION["member_type"]==4){
						$pathfile = "../data/img_member/".$_SESSION['member_id']."/".$res['member_img'];
						if(count(glob($pathfile)) > 0) {
						?>
						<img data-c="1" src="../data/img_member/<?=$_SESSION['member_id'];?>/<?=$res['member_img'];?>" style="<?php echo getPositionImage("../data/img_member/".$_SESSION['member_id']."/".$res['member_img'],35)?>">
					<?php
				}else { ?>
						<img src="images/profile_emp-01.svg" x1>
							<?php }
						}else {
						$sql = "SELECT * FROM `Member_comp` WHERE member_id = '".$_SESSION['member_id']."'";
						$query = $conn->query($sql);
						$rex = $query->fetch_assoc();

						$pathfile = "../data/img_membercom/".$rex['member_comp_id']."/".$rc['member_comp_img'];
						// echo count(glob($pathfile));
						if(count(glob($pathfile)) > 0) {
						?>
						<? if($rex['member_comp_id'] !=""){
							?>
						<img  data-c="2"  src="../data/img_membercom/<?=$rex['member_comp_id'];?>/<?=$rc['member_comp_img'];?>" style="<?php echo getPositionImage("../data/img_membercom/".$rex['member_comp_id']."/".$rc['member_comp_img'],35)?>">
							<?
						}else{
							?>
							<img src="images/profile_emp-01.svg" x2>
					<?	}?>
					<?php
						}else { ?>
					<img src="images/profile_emp-01.svg" x3>
				<?php }
						}
				?>
				</span>
        <span class="name_siam hidden-sm " onclick="toggleMenu()" style="cursor: pointer;">
		
        	<?php //if($_SESSION["member_type"] == 0){ 
				if($_SESSION["member_type"] == 0 || $_SESSION["member_type"] == 4 || $_SESSION["member_type"] == 3){ ?>
						<?php echo '<div style="
	width: 130px;
	display: table-footer-group;
	/* white-space: nowrap; */
	width: 40%;
	/* border: 1px solid #000000; */
	overflow: hidden;
	text-align: left;
	line-height: 17px;
">'.$res['member_fname'];?>&nbsp;&nbsp;<?php echo $res['member_lname'].'</div>';?>
					<?php }else { 
						echo '<div style="
						width: 130px;
						display: table-footer-group;
						/* white-space: nowrap; */
						width: 40%;
						/* border: 1px solid #000000; */
						overflow: hidden;
						text-align: left;
						line-height: 17px;
					">'.$rc['member_comp_name'].'</div>';
					} ?>
        </span>
        <div class="dropdown" style="display:inline-block; width:10px; height:10px;" id="setting_menu">
          <button class="btn dropdown-toggle" onclick="toggleMenu()" type="button" data-toggle="dropdown" style="background:url(images/icon_dropdown.png) center no-repeat;"></button>
          <ul class="dropdown-menu" id="menu-box">
            <li <?= ($_GET['page'] == "setting")?>><a href="?page=setting"><?=$txt_Settings?></a></li>
            <li <?= ($_GET['page'] == "profile")?>><a href="?page=profile"><?=$txt_Personal_information?></a></li>
            <li style="cursor: pointer;"><a onclick="logout();"><?php if($lang == "1"){ echo "ออกจากระบบ";}elseif($lang == "2"){ echo "Sign out";}else{ echo "ออกจากระบบ";}?></a></li>
          </ul>
        </div>
        <?php } else { ?>
		<span class="register"><a id="register_modal" href="https://sso.ditp.go.th/sso/index.php/register?response_type=token&client_id=ssocareid&redirect_uri=<?=htmlentities(urlencode('https://care.ditp.go.th/api/autologin_sso_v2.php'))?>&state=ugfjdfksg1"><?php if($lang == "1"){ echo "ลงทะเบียน";}elseif($lang == "2"){ echo "Register";}else{ echo "ลงทะเบียน";}?></a></span>
        <!-- <span class="register"><a id="register_modal" href="javascript:register_modal(0);"><?php if($lang == "1"){ echo "ลงทะเบียน";}elseif($lang == "2"){ echo "Register";}else{ echo "ลงทะเบียน";}?></a></span> -->
        <!--<button class="btn btn-warning btn_login" style="width:135px;" onclick="login_modal();"><i class="fa fa-lock" aria-hidden="true" style="margin-right:5px;"></i><?php if($lang == "1"){ echo "เข้าสู่ระบบ";}elseif($lang == "2"){ echo "Log in";}else{ echo "เข้าสู่ระบบ";}?></button>-->
		<a class="btn btn-warning btn_login" href="https://sso.ditp.go.th/sso/index.php/auth?response_type=token&client_id=ssocareid&redirect_uri=<?=htmlentities(urlencode('https://care.ditp.go.th/api/autologin_sso_v2.php'))?>&state=ugfjdfksg1"><i class="fa fa-lock" aria-hidden="true" style="margin-right:5px;"></i><?php if($lang == "1"){ echo "เข้าสู่ระบบ";}elseif($lang == "2"){ echo "Log in";}else{ echo "เข้าสู่ระบบ";}?></a>
		<?php } ?>
			</div>
      </div>
      <div class="col-md-1 col-sm-1 col-xs-1"></div>
      </div>
    </div>
  </div>
          <?php

          if ($_GET['page']=="home" || $_GET['page']==""){
            include('home.php');
            /* include('modal/modal_register.php');
            include('modal/modal_login.php');
            include('modal/modal_lang.php'); */
          }else {?>
						<div class="container container_main">
									<?php
									if ($_GET['page']=="invite") {
										if($_GET['type'] == 1){
											include('invite_1.php');
										} else{
											include('invite.php');
										}
									}elseif ($_GET['page']=="appeal") {
										include('appeal.php');
									}elseif ($_GET['page']=="info") {
										include('info.php');
										/* include('modal/modal_register.php');
				            			include('modal/modal_login.php'); */
									}elseif ($_GET['page']=="usersmanual") {
										include('usersmanual.php');
										/* include('modal/modal_register.php');
				            			include('modal/modal_login.php'); */
									}elseif ($_GET['page']=="appeal_detail") {
										include('appeal_detail.php');
									}elseif ($_GET['page']=="info_detail") {
										include('info_detail.php');
										/* include('modal/modal_register.php');
				            			include('modal/modal_login.php'); */
									}elseif ($_GET['page']=="setting" || $_GET['page']=="profile") {
										include('profile.php');
									}elseif ($_GET['page']=="letter") {
										include('letter.php');
									}elseif ($_GET['page']=="bell") {
										include('bell.php');
									}elseif ($_GET['page']=="new_letter") {
										include('new_letter.php');
									}elseif ($_GET['page']=="reply_letter") {
										include('reply_letter.php');
									}elseif ($_GET['page']=="invite_form") {
										include('invite_form.php');
									}elseif ($_GET['page']=="invite_detail") {
										include('invite_detail.php');
									}elseif ($_GET['page']=="invite_edit") {
										include('invite_edit.php');
									}elseif ($_GET['page']=="all_appeal") {
										include('all_appeal.php');
									}elseif ($_GET['page']=="help") {
										include('help.php');
									}elseif ($_GET['page']=="about") {
										include('about.php');
									}elseif ($_GET['page']=="question") {
										include('question.php');
										//if ($_GET['ref']=="quest_force") {
					            			/* include('modal/modal_login.php'); */

											if(checklogin() == false){
												?>
												<script>
													login_modal();
												</script>
												<?php
											}
										//}
									}
										?>
						</div>
        <?php  }
          ?>

			<div id="wait_process" style="background: black;display:none;">
	      <div class="wait" style="background: rgba(0 ,0 ,0 ,0.5);position: fixed;top: 0;right: 0;bottom: 0;left: 0;z-index: 1050;overflow: hidden;-webkit-overflow-scrolling: touch;outline: 0;">
	        <div class="" style="text-align: center;font-size: 20px;position: absolute;left: 50%;top: 50%;border-radius: 5px;margin-left: -133px;background: #fff;width: 250px;height: 58px;">
	          <img src="images/loading.gif" alt="" style="position: relative;top: 12px;right: 21px;"> <span style="position: relative;top: 14px;"><?=$txt_Please_wait?></span>
	          <div class="" style="font-size:16px;padding-left:50px;">
	            <!-- ระบบกำลังบันทึกข้อมูล -->
	          </div>
	        </div>
	      </div>
	    </div>

			<div id="wait_process_mail" style="background: black;display:none;">
				<div class="wait" style="background: rgba(0 ,0 ,0 ,0.5);position: fixed;top: 0;right: 0;bottom: 0;left: 0;z-index: 1050;overflow: hidden;-webkit-overflow-scrolling: touch;outline: 0;">
					<div class="" style="text-align: center;font-size: 20px;position: absolute;left: 50%;top: 50%;border-radius: 5px;margin-left: -133px;background: #fff;width: 250px;height: 58px;">
						 <span style="margin-top:10px; display:inline-block;"><?=$txt_Please_wait?></span>
					</div>
				</div>
			</div>

      <div class="footer-index">
        <div class="img-logo-footer">
			<a href="https://www.ditp.go.th/" target="_blank" rel="noopener noreferrer">
				<img src="images/ENG W@3x.png" style='height: 40px;'>
			</a>
      </div>
      <div class="credits-footer">
        <label class="credits-1">Department of International Trade Promotion, Ministry of Commerce, Thailand.  Tel. +66 2507 7999 <?=$txt_email_footer?></label><br>
        <label class="credits-2">© 2016, Department of International Trade Promotion, Ministry of Commerce, Thailand. All rights reserved.</label>
      </div>
    </div>

  </div>
</div>
  </body>
</html>


<script type="text/javascript">

$(document).ready(function() {
	sethead();
	
	// $('#myModal').modal('show');
	
	// $('#myModalEven').modal('show');
	// $('#myModalEven').on('hidden.bs.modal', function () {
		
	// })

	var d = new Date();
	var date = d.getDate() + '/' + d.getMonth() + '/' + d.getFullYear();
	var time = d.getHours();
	// console.log(time);
	
	$('#myModalEven').modal('hide');

	if(date == '8/0/2023' && time >= 6) {
		$("#myModalEven").find('img').attr("src","img/Popup_080166.jpg");
	} else {
		$("#myModalEven").find('img').attr("src","img/DITP_12 Aug.jpg");
	}

	// if(date == '7/11/2022' && time >= 6) {
	// 	$('#myModalEven').modal('show');
	// }
	

	$(".md-login").click(function(){
		$('#myModal_login').modal('show');
	});

	$(".fm-login").click(function(){
		$('#myModal_loginForm').modal('show');
	});
	
});
$(window).resize(function () {
	var wid = $( window ).width() ;
	sethead(wid);

});


function sethead(wid) {
	var he = $('#div_language').height();
	$('#div_logo').css('height', he);
	$('#div_language').css('height', he);
	
}

function modal_popup(type){
	console.log(type)
	$.ajax({
		url: "function_php/visited_covid.php",
		data: {},
		method : 'post',
		success: function (response) {
			let data = JSON.parse(response)
			console.log(data)
			if(data.res_code == '00' && type == 'view'){
				console.log('eiei')
				window.open("https://www.ditp.go.th/ditp_web61/article_sub_view.php?filename=&title=778955&cate=2571&d=0");
			}
		}
	});
}



</script>
<script>
  $("#zipcodes").inputmask({"mask": "99999"});
</script>
