<?php include("../config/config.php"); ?>
<?php include("../api/ditp_extapi.php"); ?>
<?php include("class/main.class.php"); ?>
<?php include("class/case.class.php"); ?>
<?php include("class/employee.class.php"); ?>
<?php include("class/msg.class.php"); ?>
<?php

// if($_GET['test'] == '5678'){
//   echo "<pre>";
//   print_r($_SESSION);
//   echo "</pre>";
// }

// if($_GET['test'] == '5678'){
//   echo hash('sha256', 'ditp@ibusiness');
//   exit;
// }
/* header('X-Frame-Options: DENY');  */
$noti_cls = new msg_base();
$caseLst_cls = new case_list();
$member_cls = new member_base();

$caseLst_cls->setting_info();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = hash('sha256', uniqid(mt_rand(), true));
}
if(!isset($_GET["page"]) || $_GET["page"]==""){
  if ($_SESSION["admin"]["empId"] == 114) {
    header('Location: index.php?page=case_list');
    exit();
  }
  if($_SESSION["admin"]["empLv"]=="1"){
    header('Location: setting/index.php?page=channel');
  }else if($_SESSION["admin"]["empLv"]=="2"){
    header('Location: index.php?page=dashboard/dashboard');
  }else{
    header('Location: index.php?page=case_list');
  }
}
include("function.php");


$res_emp = $member_cls->emp_get_detail($_SESSION["admin"]["empId"]);

if($_GET["page"]=="case_list"||$_GET["page"]=="case_open"||$_GET["page"]=="case_open_detail"||$_GET["page"]=="case_detail"){
  $class_sfActive_case = "sfActive";
}else if($_REQUEST['page']=="dashboard/dashboard"){
  $class_sfActive_dashboard = "sfActive";
}else if($_REQUEST['page']=="report/report_issue" 
  || $_REQUEST['page']=="report/report_all"  
  || $_REQUEST['page']=="report/report_cost"  
  || $_REQUEST['page']=="report/report_issue_detail" 
  || $_REQUEST['page']=="report/report_cost_detail" 
  || $_REQUEST['page']=="report/report_country" 
  || $_REQUEST['page']=="report/report_country_detail" 
  || $_REQUEST['page']=="report/report_compare" 
  || $_REQUEST['page']=="report/report_compare_detail" 
  || $_REQUEST['page']=="report/report_product" 
  || $_REQUEST['page']=="report/report_product_detail" 
  || $_REQUEST['page']=="report/report_country_thai" 
  || $_REQUEST['page']=="report/report_country_thai_detail" 
  || $_REQUEST['page']=="report/report_blacklist" 
  || $_REQUEST['page']=="report/report_blacklist_detail" 
  ){
  $class_sfHover_report = "sfHover";
  $class_sfActive_report = "sfActive";
  $subMenuOpen_report = "display:block;";
  if($_REQUEST['page']=="report/report_issue" || $_REQUEST['page']=="report/report_issue_detail" ){
      $active_report_issue = "active_menu";
  } else if($_REQUEST['page']=="report/report_cost" || $_REQUEST['page']=="report/report_cost_detail"){
      $active_report_cost = "active_menu";
  } else if($_REQUEST['page']=="report/report_country" || $_REQUEST['page']=="report/report_country_detail"){
    $active_report_country = "active_menu";
  } else if($_REQUEST['page']=="report/report_compare" || $_REQUEST['page']=="report/report_compare_detail"){
    $active_compare = "active_menu";
  } else if($_REQUEST['page']=="report/report_product" || $_REQUEST['page']=="report/report_product_detail"){
    $active_product = "active_menu";
  } else if($_REQUEST['page']=="report/report_country_thai" || $_REQUEST['page']=="report/report_country_thai_detail"){
    $active_country_thai = "active_menu";
  } else if($_REQUEST['page']=="report/report_blacklist" || $_REQUEST['page']=="report/report_blacklist_detail" ){
    $active_report_blacklist = "active_menu";
  }
}else if($_REQUEST['page']=="knowledge/knowledge"){
    $class_sfActive_knowledge = "sfActive";
}else if($_REQUEST['page']=="Individual/contact_thai" || $_REQUEST['page']=="Individual/contact_inter"
        || $_REQUEST['page']=="corporate/corporate_thai" || $_REQUEST['page']=="corporate/corporate_inter"){
    $class_sfHover_Individual = "sfHover";
    $class_sfActive_Individual = "sfActive";
    $subMenuOpen_Individual= "display:block;";
}else if($_REQUEST['page']=="user/management_admin" || $_REQUEST['page']=="user/group" || $_REQUEST['page']=="user/application"){
  $class_sfHover_admin = "sfHover";
  $class_sfActive_admin = "sfActive";
  $subMenuOpen_admin = "display:block;";
}else if($_REQUEST['page']=="channel" || $_REQUEST['page']=="product" || $_REQUEST['page']=="country" || $_REQUEST['page']=="blacklist"
         || $_REQUEST['page']=="complaint" || $_REQUEST['page']=="process" || $_REQUEST['page']=="priority" || $_REQUEST['page']=="department"
         || $_REQUEST['page']=="product_detail_lv3" || $_REQUEST['page']=="product_detail_lv4" || $_REQUEST['page']=="product_detail_lv5"  || $_REQUEST['page']=="incorrect"){
  $class_sfHover_setting = "sfHover";
  $class_sfActive_setting = "sfActive";
  $subMenuOpen_setting = "display:block;";
}else if($_REQUEST['page']=="noti_complaint" || $_REQUEST['page']=="noti_user" || $_REQUEST['page']=="holiday"){
  $class_sfHover_setting2 = "sfHover";
  $class_sfActive_setting2 = "sfActive";
  $subMenuOpen_setting2 = "display:block;";
}else if($_REQUEST['page']=="banner" || $_REQUEST['page']=="complaint_procedure"){
  $class_sfHover_setting_fnt = "sfHover";
  $class_sfActive_setting_fnt = "sfActive";
  $subMenuOpen_setting_fnt = "display:block;";
}else if($_REQUEST['page']=="form"){
  $class_sfActive_from = "sfActive";
}else if($_REQUEST['page']=="question"){
  $class_sfHover_question = "sfHover";
  $class_sfActive_question = "sfActive";
}else if($_REQUEST['page']=="admin_questionAW" || $_REQUEST['page']=="frontend_questionAW" || $_REQUEST['page']=="frontend_questionAP"){
  $class_sfHover_report_question = "sfHover";
  $class_sfActive_report_question = "sfActive";
  $subMenuOpen_report_question = "display:block;";
  if($_REQUEST['page']=="admin_questionAW"){
    $active_admin_questionAW = "active_menu";
  }else if($_REQUEST['page']=="frontend_questionAW"){
    $active_frontend_questionAW = "active_menu";
  }else if($_REQUEST['page']=="frontend_questionAP"){
    $active_frontend_questionAP = "active_menu";
  }
}


if($member_cls->checkLoginSession()==false){
  ?>
  <script>window.location.href = "login.php";</script>
  <?php
}


if(isset($_GET["page"]) && $_GET["page"]=="message_box_list"){
  $noti_cls->update_open_msg();
}

if(isset($_GET["page"]) && $_GET["page"]=="message_box_detail"){
  $noti_cls->update_read_msg($_GET["msgId"]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<style>
/* Loading Spinner */
.spinner{margin:0;width:70px;height:18px;margin:-35px 0 0 -9px;position:absolute;top:50%;left:50%;text-align:center}.spinner > div{width:18px;height:18px;background-color:#333;border-radius:100%;display:inline-block;-webkit-animation:bouncedelay 1.4s infinite ease-in-out;animation:bouncedelay 1.4s infinite ease-in-out;-webkit-animation-fill-mode:both;animation-fill-mode:both}.spinner .bounce1{-webkit-animation-delay:-.32s;animation-delay:-.32s}.spinner .bounce2{-webkit-animation-delay:-.16s;animation-delay:-.16s}@-webkit-keyframes bouncedelay{0%,80%,100%{-webkit-transform:scale(0.0)}40%{-webkit-transform:scale(1.0)}}@keyframes bouncedelay{0%,80%,100%{transform:scale(0.0);-webkit-transform:scale(0.0)}40%{transform:scale(1.0);-webkit-transform:scale(1.0)}}
</style>


<meta charset="UTF-8">
<!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
<title>DITP Care Management</title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

<!-- cache-control -->
<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />

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
<!-- <link rel="icon" type="image/png" sizes="32x32" href="../favicon.ico/favicon-32x32.png"> -->
<link rel="icon" type="image/png" sizes="96x96" href="../favicon.ico/favicon-96x96.png">
<!-- <link rel="icon" type="image/png" sizes="16x16" href="../favicon.ico/favicon-16x16.png"> -->
<!-- <link rel="manifest" href="../favicon.ico/manifest.json"> -->
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">


<!-- FONTS -->
<link rel="stylesheet" type="text/css" href="css/fonts.css">
<link rel="stylesheet" type="text/css" href="css/fonts-icon.css">

<!-- BOOTSTRAP -->
<link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.css">


<!-- HELPERS -->

<link rel="stylesheet" type="text/css" href="assets/helpers/animate.css">
<link rel="stylesheet" type="text/css" href="assets/helpers/backgrounds.css">
<link rel="stylesheet" type="text/css" href="assets/helpers/boilerplate.css">
<link rel="stylesheet" type="text/css" href="assets/helpers/border-radius.css">
<link rel="stylesheet" type="text/css" href="assets/helpers/grid.css">
<link rel="stylesheet" type="text/css" href="assets/helpers/page-transitions.css">
<link rel="stylesheet" type="text/css" href="assets/helpers/spacing.css">
<link rel="stylesheet" type="text/css" href="assets/helpers/typography.css">
<link rel="stylesheet" type="text/css" href="assets/helpers/utils.css">
<link rel="stylesheet" type="text/css" href="assets/helpers/colors.css">

<!-- ELEMENTS -->

<link rel="stylesheet" type="text/css" href="assets/elements/badges.css">
<link rel="stylesheet" type="text/css" href="assets/elements/buttons.css">
<link rel="stylesheet" type="text/css" href="assets/elements/content-box.css">
<link rel="stylesheet" type="text/css" href="assets/elements/dashboard-box.css">
<link rel="stylesheet" type="text/css" href="assets/elements/forms.css">
<link rel="stylesheet" type="text/css" href="assets/elements/images.css">
<link rel="stylesheet" type="text/css" href="assets/elements/info-box.css">
<link rel="stylesheet" type="text/css" href="assets/elements/invoice.css">
<link rel="stylesheet" type="text/css" href="assets/elements/loading-indicators.css">
<link rel="stylesheet" type="text/css" href="assets/elements/menus.css">
<link rel="stylesheet" type="text/css" href="assets/elements/panel-box.css">
<link rel="stylesheet" type="text/css" href="assets/elements/response-messages.css">
<link rel="stylesheet" type="text/css" href="assets/elements/responsive-tables.css">
<link rel="stylesheet" type="text/css" href="assets/elements/ribbon.css">
<link rel="stylesheet" type="text/css" href="assets/elements/social-box.css">
<link rel="stylesheet" type="text/css" href="assets/elements/tables.css">
<link rel="stylesheet" type="text/css" href="assets/elements/tile-box.css">
<link rel="stylesheet" type="text/css" href="assets/elements/timeline.css">



<!-- ICONS -->

<link rel="stylesheet" type="text/css" href="assets/icons/fontawesome/fontawesome.css">
<link rel="stylesheet" type="text/css" href="assets/icons/linecons/linecons.css">
<link rel="stylesheet" type="text/css" href="assets/icons/spinnericon/spinnericon.css">


<!-- WIDGETS -->

<!-- <link rel="stylesheet" type="text/css" href="assets/widgets/accordion-ui/accordion.css">
<link rel="stylesheet" type="text/css" href="assets/widgets/calendar/calendar.css">
<link rel="stylesheet" type="text/css" href="assets/widgets/carousel/carousel.css"> -->

<!-- <link rel="stylesheet" type="text/css" href="assets/widgets/charts/justgage/justgage.css">
<link rel="stylesheet" type="text/css" href="assets/widgets/charts/morris/morris.css">
<link rel="stylesheet" type="text/css" href="assets/widgets/charts/piegage/piegage.css">
<link rel="stylesheet" type="text/css" href="assets/widgets/charts/xcharts/xcharts.css"> -->

<link rel="stylesheet" type="text/css" href="assets/widgets/chosen/chosen.css">
<link rel="stylesheet" type="text/css" href="assets/widgets/colorpicker/colorpicker.css">
<link rel="stylesheet" type="text/css" href="assets/widgets/datatable/datatable.css">

<link rel="stylesheet" type="text/css" href="assets/widgets/datetimepicker/build/css/bootstrap-datetimepicker.css">
<link rel="stylesheet" type="text/css" href="assets/widgets/bootstrap-datepicker-master/css/bootstrap-datepicker3.css">
<link rel="stylesheet" type="text/css" href="assets/widgets/daterangepicker/daterangepicker.css">
<link rel="stylesheet" type="text/css" href="assets/widgets/dialog/dialog.css">
<link rel="stylesheet" type="text/css" href="assets/widgets/dropdown/dropdown.css">
<!-- <link rel="stylesheet" type="text/css" href="assets/widgets/dropzone/dropzone.css"> -->
<link rel="stylesheet" type="text/css" href="assets/widgets/file-input/fileinput.css">
<link rel="stylesheet" type="text/css" href="assets/widgets/input-switch/inputswitch.css">
<link rel="stylesheet" type="text/css" href="assets/widgets/input-switch/inputswitch-alt.css">
<!-- <link rel="stylesheet" type="text/css" href="assets/widgets/ionrangeslider/ionrangeslider.css"> -->
<link rel="stylesheet" type="text/css" href="assets/widgets/jcrop/jcrop.css">
<link rel="stylesheet" type="text/css" href="assets/widgets/jgrowl-notifications/jgrowl.css">
<link rel="stylesheet" type="text/css" href="assets/widgets/loading-bar/loadingbar.css">
<!-- <link rel="stylesheet" type="text/css" href="assets/widgets/maps/vector-maps/vectormaps.css"> -->
<link rel="stylesheet" type="text/css" href="assets/widgets/markdown/markdown.css">
<link rel="stylesheet" type="text/css" href="assets/widgets/modal/modal.css">
<link rel="stylesheet" type="text/css" href="assets/widgets/multi-select/multiselect.css">
<link rel="stylesheet" type="text/css" href="assets/widgets/multi-upload/fileupload.css">
<!-- <link rel="stylesheet" type="text/css" href="assets/widgets/nestable/nestable.css"> -->
<link rel="stylesheet" type="text/css" href="assets/widgets/noty-notifications/noty.css">
<!-- <link rel="stylesheet" type="text/css" href="assets/widgets/popover/popover.css"> -->
<link rel="stylesheet" type="text/css" href="assets/widgets/pretty-photo/prettyphoto.css">
<link rel="stylesheet" type="text/css" href="assets/widgets/progressbar/progressbar.css">
<!-- <link rel="stylesheet" type="text/css" href="assets/widgets/range-slider/rangeslider.css"> -->
<link rel="stylesheet" type="text/css" href="assets/widgets/slidebars/slidebars.css">
<link rel="stylesheet" type="text/css" href="assets/widgets/slider-ui/slider.css">
<!-- <link rel="stylesheet" type="text/css" href="assets/widgets/summernote-wysiwyg/summernote-wysiwyg.css"> -->
<link rel="stylesheet" type="text/css" href="assets/widgets/tabs-ui/tabs.css">
<link rel="stylesheet" type="text/css" href="assets/widgets/theme-switcher/themeswitcher.css">
<link rel="stylesheet" type="text/css" href="assets/widgets/timepicker/jquery.timepicker.css">
<!-- <link rel="stylesheet" type="text/css" href="assets/widgets/tocify/tocify.css"> -->
<link rel="stylesheet" type="text/css" href="assets/widgets/tooltip/tooltip.css">
<link rel="stylesheet" type="text/css" href="assets/widgets/touchspin/touchspin.css">
<link rel="stylesheet" type="text/css" href="assets/widgets/uniform/uniform.css">
<link rel="stylesheet" type="text/css" href="assets/widgets/wizard/wizard.css">
<!-- <link rel="stylesheet" type="text/css" href="assets/widgets/xeditable/xeditable.css"> -->

<!-- SNIPPETS -->
<link rel="stylesheet" type="text/css" href="assets/snippets/chat.css">
<link rel="stylesheet" type="text/css" href="assets/snippets/files-box.css">
<link rel="stylesheet" type="text/css" href="assets/snippets/login-box.css">
<link rel="stylesheet" type="text/css" href="assets/snippets/notification-box.css">
<link rel="stylesheet" type="text/css" href="assets/snippets/progress-box.css">
<link rel="stylesheet" type="text/css" href="assets/snippets/todo.css">
<link rel="stylesheet" type="text/css" href="assets/snippets/user-profile.css">
<link rel="stylesheet" type="text/css" href="assets/snippets/mobile-navigation.css">

<!-- APPLICATIONS -->
<!-- <link rel="stylesheet" type="text/css" href="assets/applications/mailbox.css"> -->

<!-- Admin theme -->
<link rel="stylesheet" type="text/css" href="assets/themes/admin/layout.css">
<link rel="stylesheet" type="text/css" href="assets/themes/admin/color-schemes/default.css">

<!-- Components theme -->
<link rel="stylesheet" type="text/css" href="assets/themes/components/default.css">
<link rel="stylesheet" type="text/css" href="assets/themes/components/border-radius.css">

<!-- Admin responsive -->
<link rel="stylesheet" type="text/css" href="assets/helpers/responsive-elements.css">
<link rel="stylesheet" type="text/css" href="assets/helpers/admin-responsive.css">

<!-- bootstrap-select -->
<link rel="stylesheet" href="assets/widgets/bootstrap-select-1.13.14/dist/css/bootstrap-select.css">


<!-- iziToast -->
<link rel="stylesheet" type="text/css" href="assets/widgets/izitoast/dist/css/iziToast.css">
<script type="text/javascript" src="assets/widgets/izitoast/dist/js/iziToast.js"></script>

<!-- My-css -->
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/right_sidebar.css">

<link rel="stylesheet" href="assets/intlTelInput/css/intlTelInput.css">
<link rel="stylesheet" href="assets/intlTelInput/css/demo.css">

<style>
  input[type='radio']{
  width: auto;
  height: auto;
}
</style>

<!-- JS Core -->
<!-- <script type="text/javascript" src="assets/js-core/jquery-3.7.1.min.js"></script> -->
<script type="text/javascript" src="assets/js-core/jquery-core.js"></script>
<script type="text/javascript" src="assets/js-core/jquery-ui-core.js"></script>
<script type="text/javascript" src="assets/js-core/jquery-ui-widget.js"></script>
<script type="text/javascript" src="assets/js-core/jquery-ui-mouse.js"></script>
<script type="text/javascript" src="assets/js-core/jquery-ui-position.js"></script>
<!--<script type="text/javascript" src="assets/js-core/transition.js"></script>-->
<script type="text/javascript" src="assets/js-core/modernizr.js"></script>
<script type="text/javascript" src="assets/js-core/jquery-cookie.js"></script>
<!-- Uniform -->
<!--<link rel="stylesheet" type="text/css" href="assets/widgets/uniform/uniform.css">-->
<script type="text/javascript" src="assets/widgets/uniform/uniform.js"></script>
<script type="text/javascript" src="assets/widgets/uniform/uniform-demo.js"></script>

<!-- <script type="text/javascript" src="assets/widgets/moment/min/moment.min.js"></script> -->
 <script type="text/javascript" src="assets/widgets/moment-2.29.4/min/moment.min.js"></script>
<script type="text/javascript" src="assets/widgets/datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="assets/widgets/bootstrap-datepicker-master/js/bootstrap-datepicker.min.js"></script>
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-102727247-1"></script>

<script type="text/javascript">

window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		console.log (window.dataLayer);
		gtag('js', new Date());

		gtag('config', 'UA-102727247-1');

var iziToast_func ={
  alert: function( message_txt,callback ) {
    iziToast.error({
      timeout: 5000,
      icon: 'ico-warning',
      title: 'แจ้งเตือน: ',
      message: message_txt,
      position: 'topCenter', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
      onOpening: function(instance, toast){
      },
      onClosing: function(instance, toast, closedBy){
        if(typeof(callback)=='function'){
            callback();
        }
      }
    });
  }
  ,success: function( message_txt,callback ) {
    iziToast.success({
      timeout: 1000,
      pauseOnHover: false,
      title: 'OK',
      message: message_txt,
      position: 'topCenter', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
      onOpening: function(instance, toast){
      },
      onClosing: function(instance, toast, closedBy){
        if(typeof(callback)=='function'){
            callback();
        }
      }
    });
  }
  ,confirm: function( message_txt,btn1,btn2,callback1,callback2 ) {
    iziToast.show({
      class: 'toast-confirm',
      theme: 'light', // dark
      color: 'red', // blue, red, green, yellow
      icon: 'icon-person',
      title: 'Alert',
      message: message_txt,
      position: 'center', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
      progressBar: false,
      //progressBarColor: 'rgb(0, 255, 184)',
      timeout: false,
      buttons: [
          ['<button>'+btn1+'</button>', function (instance, toast) {
            if(typeof(callback1)=='function'){
                callback1();
            }
          }],
          ['<button>'+btn2+'</button>', function (instance, toast) {
              instance.hide({
                  transitionOut: 'fadeOutUp',
                  onClosing: function(instance, toast, closedBy){
                    if(typeof(callback2)=='function'){
                        callback2();
                    }
                  }
              }, toast, 'close', 'btn2');
          }]
      ],
      onOpening: function(instance, toast){
        if($('.toast-confirm').length>1){
          $('.toast-confirm').eq(0).remove();
        }
      },
      onClosing: function(instance, toast, closedBy){
        if(typeof(callback2)=='function'){
            callback2();
        }
      }
    });
  }
}

/* Datepicker bootstrap */
$(document).ready(function(){
    var date_receive = new Date();
    date_receive = date_receive.setDate(date_receive.getDate() + 1);
    $('.bootstrap-datepicker-receive').datepicker({
        format: 'dd/mm/yyyy',
autoclose: true,
        endDate: '+0d'
    });
    $('.bootstrap-datepicker-bday').datepicker({
        format: 'dd/mm/yyyy',
autoclose: true,
        endDate: '+0d'
    });
    $('.bootstrap-datepicker').datepicker({
        format: 'dd/mm/yyyy'
    });

    // $('.bootstrap-timepicker').datetimepicker({
    //     format: 'LT'
    // });

    $(document).delegate(".input-group-addon-calendar","click", function(e){
        $(this).parent().find('.bootstrap-datepicker').datepicker('show');
        $(this).parent().find('.bootstrap-datepicker-receive').datepicker('show');
        $(this).parent().find('.bootstrap-datepicker-bday').datepicker('show');
    });
});

</script>


<script src="assets/widgets/timepicker/jquery.timepicker.js"></script>
<script type="text/javascript">
/* timepicki */
  // $(function(){ "use strict";
  //   $(".bootstrap-timepicker").timepicker({
  //     'step': 15,
  //     'timeFormat': 'H:i',
  //     'forceRoundTime': true
  //   });
  // });

</script>


<!-- DITP Class -->
<script type="text/javascript" src="js/case.js?v=20250131"></script>


<script type="text/javascript">

function auto_resize_menu(addHeight){
  var win_h = $(window).height();
  var win_w = $(window).width();
  //console.log($("#page-content").height());
  win_h_page = $("#page-wrapper").height();
  if($("#page-wrapper").height()>win_h){
    $('#sidebar-menu').css({"min-height":win_h_page+"px"});
    $('#sidebar-menu').css({"height":"auto"});
  }else{
    $('#sidebar-menu').css({"min-height":win_h+"px"});
    $('#sidebar-menu').css({"height":"auto"});
  }
  // if(win_w>768){
  //   $(".page-sidebar-mobile").removeClass("in");
  //   $(".page-sidebar-mobile").hide();
  //   $(".page-sidebar-desktop").show();
  // }else{
  //   $(".page-sidebar-mobile").css({"display":""});
  //   $(".page-sidebar-desktop").hide();
  // }

}

$(window).load(function(){
  setTimeout(function() {
    $('#loading').fadeOut( 400, "linear" );
  }, 300);

  //-- Set Width'.span-title' --//
  // var w_card_header = $('.card-header').width();
  // $('.span-title').width(w_card_header-260);
});
$(document).ready(function(){
  setTimeout(function(){
    auto_resize_menu();
  },500);
});
$(window).resize(function(){
  auto_resize_menu();
});

case_open = new case_open_class();


</script>

<style>
<?php
$priority_list_css = $caseLst_cls->prioritySelectList("all");
foreach ($priority_list_css as $key => $value) {
  $priority_detail = $caseLst_cls->priorityDetail($key);

  echo '.btn-priority-'.$key.'{
    background: '.$priority_detail["color"].';
    padding: 0 20px;
  }
  .btn-priority-'.$key.'::before{
    content:"'.$priority_detail["name"].'";
  }';
}
?>
</style>
</head>


<body class="fixed-sidebar fixed-header">
  <div id="sb-site">
    <div id="loading">
      <div class="spinner">
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
      </div>
    </div>

    <div id="loading_feedback" style="display:none;">
      <div class="pad20A radius-all-8 float-left mrg15R bg-black loading_icon">
          <img src="assets/images/spinner/loader-light.gif" alt="">
      </div>
    </div>

    <div id="page-wrapper">
      <?php
      $type_size_windows = "desktop";
      include("slide_menu.php");
      ?>

      <div id="page-content-wrapper">
        <div id="mobile-navigation">
          <button id="nav-toggle" class="collapsed" data-toggle="collapse" data-target=".page-sidebar-mobile"><span></span></button>
          <a href="index.html" class="logo-content-small" title="MonarchUI"></a>
        </div>
        <div id="page-header" class="bg-gradient-7 font-inverse">

          <div id="header-nav-left">

          </div><!-- #header-nav-left -->

          <div id="header-nav-right" class="col-xs-9 col-sm-8">
            <?php
            if($_SESSION["admin"]["empSection"]!=0 && $_SESSION["admin"]["empPosition"]!=7 && $_SESSION["admin"]["empPosition"]!=8){
              ?>
              <a href="index.php?page=message_box_list" class="hdr-btn" title="Message">
                <i class="ditp-icon icon-ico-ditp-07"></i>
                <span class="bs-badge badge-danger" id="bs-badge-msg"><?php echo $noti_cls->total_msg_unread() ?></span>
              </a>
              <?php } ?>

              <a href="index.php?page=notification_list" class="hdr-btn popover-button" id="chatbox-btn-1" title="Notification" data-id="#popover_noti" data-placement="bottom">
                <i class="ditp-icon icon-ico-ditp-08"></i>
                <span class="bs-badge badge-danger" id="bs-badge-noti"><?php echo $noti_cls->total_noti_unread() ?></span>
              </a>
              <div class="hide" id="popover_noti">
                  <ul class="noti_list">
                    <?php
                    $noti_list_popup = $noti_cls->getNotiList_popup();
                    if(count($noti_list_popup)>0){
                      foreach ($noti_list_popup as $noti_list) {
                        $time_dif = $noti_cls->getDateTimeData($noti_list["msgNotiEmp_datetime"],date('Y-m-d H:i:s'));
                        if($time_dif["days"]>30){
                          $txt_time_dif = floor($time_dif["days"]/30)." เดือน";
                        }else{
                          if($time_dif["days"]>0){
                            $txt_time_dif = $time_dif["days"]." วัน";
                          }else{
                            if($time_dif["hours"]>0){
                              $txt_time_dif = $time_dif["hours"]." ชั่วโมง";
                            }else{
                              if($time_dif["minutes"]>0){
                                $txt_time_dif = $time_dif["minutes"]." นาที";
                              }else{
                                $txt_time_dif = "1 นาที";
                              }
                            }
                          }
                        }
                        $read_status = "";
                        if($noti_list["msgNotiEmp_read_status"]==1){
                          $read_status = "read_noti_status";
                        }
                        ?>
                        <li class="<?php echo $read_status ?>">
                          <span class="msg"><?php echo $noti_list["msgNotiEmp_message"] ?></span>
                          <span class="txt-date"><?php echo $txt_time_dif ?></span>
                        </li>
                        <?php
                      }
                    }else{
                      ?>
                      <?php
                    }
                    ?>
                    <li style="text-align:center;">
                      <a href="index.php?page=notification_list">
                        ดูการแจ้งเตือนทั้งหมด
                      </a>
                    </li>

                  </ul>
              </div>

            <?php if($_SESSION["admin"]["empSection"]!=0 && $_SESSION["admin"]["empPosition"]!=7 && $_SESSION["admin"]["empPosition"]!=8){
              //if($_GET["page"]=="case_list"){ //แสดงส่วนนี้ ถ้าอยู่หน้า Case List เท่านั้น
              if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"createcase")[2]==1){
                ?>
                <a class="hidden-xs btn btn-border btn-alt border-black btn-link font-black ra-100 btn-case-create" href="javascript:void(0);" onclick="case_open.openCase('#model_create_case')" title="">
                  <span>สร้าง Case</span>
                  <i class="ditp-icon icon-ico-ditp-10 icon-case-create"></i>
                </a>
                <a class="hidden-sm hidden-md hidden-lg btn btn-border btn-alt border-black btn-link font-black btn-case-create" href="javascript:void(0);" onclick="case_open.openCase('#model_create_case')" title="">
                  <i class="ditp-icon icon-ico-ditp-10 icon-case-create"></i>
                </a>
                <?php
              }
              //}
              ?>

              <?php
            }
            ?>

            <!---------------- Login as ------------------>
            <?php if(isset($_SESSION["admin"]["login_as"]) && $_SESSION["admin"]["login_as"] == 1){ ?>
            <div class="user-account-btn dropdown" style="width:auto; max-width:200px; margin-top:9px">
              <button class="btn" data-toggle="modal" data-target=".login-as">Login As</button>
            </div>
            <?php } ?>
            <!-- <?php //if(isset($_SESSION['admin']['login_as']) && $_SESSION['admin']['login_as']){ ?>
              <div class="user-account-btn dropdown" style="width:auto; max-width:200px; margin-top:9px">
                <button class="btn btn-danger" data-toggle="modal" data-target=".login-as">Log Out</button>
              </div>
            <?php //} ?> -->
            <!--------------------------------------------->

            <!-- user-account-btn dropdown -->
            <div class="user-account-btn dropdown" style="width:auto; max-width:200px;">
                <a href="#" title="My Account" class="user-profile clearfix" data-toggle="dropdown">
                  <div class="border-user-img">
                    <?php
                      if(count(glob($res_emp["emp_img_path_s"]))==0 || $res_emp['emp_img_path_s'] == '') {
                        ?>
                        <img id="img_profile_sm" src="/backoffice/setting/img/profile_emp-01.svg" alt="">
                        <?php
                      }else{
                        ?>
                        <img id="img_profile_sm" src="<?php echo $res_emp["emp_img_path_s"] ?>" alt="Profile image" style="<?php echo $caseLst_cls->getPositionImage($res_emp["emp_img_path_s"],50) ?>">
                        <?php
                      }
                      ?>
                    </div>
                    <span style="shot-text hidden-xs"><?php echo $res_emp["emp_firstname"] ?>  <?php echo $res_emp["emp_lastname"] ?></span>
                    <i class="glyph-icon icon-angle-down hidden-xs"></i>
                </a>
                <div class="dropdown-menu float-left profile-panel-dropdown-menu">
                    <div class="box-sm">

                        <div class="login-box clearfix">
                          <div class="row">
                              <div class="col-md-4">
                                <div class="user-img">
                                    <a href="javascript:void(0)" class="change-img">Change photo</a>
                                    <form name="frm-change-img-profile" id="frm-change-img-profile" method="post"  enctype="multipart/form-data"  action="function.php?method=change_img_profile" target="iframe-data">
                                      <input type="file" name="img_profile" id="img_profile" style="display:none" />
                                      <input type="hidden" id="img_profile_oldhid" value="" />
                                      <input type="text" name="csrf_token" hidden value="<?php echo $_SESSION['csrf_token']; ?>">
                                    </form>
                                    <div class="border-user-img border-user-img-large">
                                    <?php
                                      if(count(glob($res_emp["emp_img_path_s"]))==0 || $res_emp['emp_img_path_s'] == '') {
                                          ?><img id="img_profile_lg" src="/backoffice/setting/img/profile_emp-01.svg" alt=""><?php
                                      }else{
                                        ?>
                                        <img id="img_profile_lg" src="<?php echo $res_emp["emp_img_path_s"] ?>" alt="Profile image" style="<?php echo $caseLst_cls->getPositionImage($res_emp["emp_img_path_s"],80) ?>">
                                        <?php
                                      } ?>
                                    </div>
                                </div>
                              </div>
                              <div class="col-md-8">
                                <div class="user-info">
                                    <span>
                                      <p>
                                        <b>ID:</b> <?php echo $res_emp["emp_real_id"] ?> - <?php echo $res_emp["emp_firstname"] ?>  <?php echo $res_emp["emp_lastname"] ?>
                                      </p>
                                      <p>
                                        <b>แผนก:</b> <?php echo $res_emp["empGroup_name"] ?>
                                      </p>
                                      <?php if($_SESSION['admin']['empSection'] != '2'){?>
                                      <p>
                                        <b>สำนัก:</b> <?php if($_SESSION['admin']['office'] == '0'){ echo "สำนักสารสนเทศและการบริการการค้าระหว่างประเทศ"; }else { echo $res_emp["office_name"];} ?>
                                      </p>
                                      <?php } ?>
                                      <!-- <i>UX/UI developer</i> -->
                                    </span>
                                </div>
                              </div>
                          </div>
                        </div>

                        <div class="divider"></div>
                        <div class="pad5A button-pane-alt text-center">
                            <a href="function.php?method=logout" class="btn display-block font-normal btn-danger">
                                <i class="glyph-icon icon-power-off"></i>
                                Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>

          </div><!-- #header-nav-right -->


        </div>

        <!-- Modal Login_as -->
        <form method="POST" action="setting/user/method.php?method=login_as">
          <div class="modal fade login-as" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                <div class="modal-dialog modal-md" role="document">

                <div class="modal-content">
                    <div class="modal-header" style="background-color: #388E3C !important; color: #FFF;">
                      <h4 class="modal-title" id="exampleModalLabel" style="color: #FFF">เข้าสู่ระบบด้วยบัญชีอื่น</h4>
                    </div>
                    <div class="modal-body">
                      
                          <div class="row form-group text-center" style="padding-left: 30%; padding-right: 30%;">
                        
                            <select name="emp_id" class="login_as_picker" data-live-search="true" data-size="10" required>
                              <option value="" style="background:none;" data-content="<span style='color:#777;'>--- เลือกบัญชีที่ต้องการ ---</span>"></option>
                              <?php
                                $data = $member_cls->getEmployee();
                                while($row = $data->fetch_assoc()){
                                  $name_as = $row['emp_firstname']."  ".$row['emp_lastname'];
                                  $emp_id = $row['emp_id'];
                              ?>
                                <option value="<?php echo $emp_id; ?>"><?php echo $name_as; ?></option>
                                <?php } ?>
                            </select>
                          </div>

                        
                    </div>
                    <input type="text" name="csrf_token" hidden value="<?php echo $_SESSION['csrf_token']; ?>">
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                      <button type="submit" class="btn btn_submit" style="background: #7CB342 !important; color: #FFF;">ตกลง</button>
                    </div>
                  </div>
              </div>
            </div>
          </form>
          <!-- End modal -->


        <?php
        $type_size_windows = "mobile";
        include("slide_menu.php");
        ?>

        <div id="page-content">

          <div class="container">
            <?php
            if(!($_GET['page']=="import_case" || $_GET['page']=="message_box_list" || $_GET['page']=="message_box_detail" || $_GET['page']=="message_box_create" ||  $_GET['page']=="notification_list" ) && $member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],$_GET['page'])[1]!=1
              || (
                $_GET['page']=="case_open"
                && ($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"createcase")[2]!=1
                  || $member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"editcase")[2]!=1)
              ) || (
                $_GET['method']=="re_open_case"
                && ($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"re_open_case")[3]!=1)
              )
            ){
              if($_SESSION["admin"]["empPosition"]==6 || $_SESSION["admin"]["empPosition"]==7 || $_SESSION["admin"]["empPosition"]==8){
                include($_REQUEST['page'].".php");
              }else{
                echo 1;
                include("noprivilege.php");
              }
            }else{
              if(isset($_REQUEST['page']) && $_REQUEST['page']!=""){
                include($_REQUEST['page'].".php");
              }else{
                include("home.php");
              }
            }
            ?>

            <?php include('template/modal_create_case.php'); ?>

            <!-- WIDGETS -->

            <script type="text/javascript" src="assets/bootstrap/js/bootstrap.js"></script>


            <!-- Bootstrap Progress Bar -->

            <script type="text/javascript" src="assets/widgets/progressbar/progressbar.js"></script>


            <!-- Superclick -->

            <script type="text/javascript" src="assets/widgets/superclick/superclick.js"></script>

            <!-- Input switch alternate -->

            <script type="text/javascript" src="assets/widgets/input-switch/inputswitch-alt.js"></script>

            <!-- Slim scroll -->

            <script type="text/javascript" src="assets/widgets/slimscroll/slimscroll.js"></script>

            <!-- Slidebars -->

            <script type="text/javascript" src="assets/widgets/slidebars/slidebars.js"></script>
            <script type="text/javascript" src="assets/widgets/slidebars/slidebars-demo.js"></script>

            <!-- PieGage -->

            <script type="text/javascript" src="assets/widgets/charts/piegage/piegage.js"></script>
            <script type="text/javascript" src="assets/widgets/charts/piegage/piegage-demo.js"></script>

            <!-- Screenfull -->

            <script type="text/javascript" src="assets/widgets/screenfull/screenfull.js"></script>

            <!-- Content box -->

            <script type="text/javascript" src="assets/widgets/content-box/contentbox.js"></script>

            <!-- Overlay -->
            <script type="text/javascript" src="assets/widgets/overlay/overlay.js"></script>

            <!-- Widgets init for demo -->
            <script type="text/javascript" src="assets/js-init/widgets-init.js"></script>
            <!-- Widgets init for demo -->

            <!-- Countdown time -->
            <script type="text/javascript" src="assets/jquery.countdown-2.2.0/jquery.countdown.min.js"></script>
            <!-- Countdown time -->

            <!-- Bootbox alert -->
            <script type="text/javascript" src="assets/widgets/bootbox/bootbox.min.js"></script>
            <!-- Bootbox alert -->

            <!-- Theme layout -->

            <!-- <script type="text/javascript" src="assets/themes/admin/layout.js"></script> -->

            <!-- Theme switcher -->

            <!-- <script type="text/javascript" src="assets/widgets/theme-switcher/themeswitcher.js"></script> -->

            <!-- bootstrap-select -->
            <script type="text/javascript" src="assets/widgets/bootstrap-select-1.13.14/dist/js/bootstrap-select.min.js"></script>

            <script>

            function getPositionImage(width,height,size){
              var ratio = (width/height); // width/height
              var css = "";
              if( ratio > 1) {
                  width = (size*ratio);
                  height = size;
                  css = " width:auto; height:100%; margin-left:-"+((width*0.5)-(size*0.5))+"px";
              }
              else {
              width = size;
              height = (size/ratio);
                css = "height:auto; width:100%; top:0;";
              }
              return css;
            }

            function pageTransitions() {

                var transitions = ['.pt-page-moveFromLeft', 'pt-page-moveFromRight', 'pt-page-moveFromTop', 'pt-page-moveFromBottom', 'pt-page-fade', 'pt-page-moveFromLeftFade', 'pt-page-moveFromRightFade', 'pt-page-moveFromTopFade', 'pt-page-moveFromBottomFade', 'pt-page-scaleUp', 'pt-page-scaleUpCenter', 'pt-page-flipInLeft', 'pt-page-flipInRight', 'pt-page-flipInBottom', 'pt-page-flipInTop', 'pt-page-rotatePullRight', 'pt-page-rotatePullLeft', 'pt-page-rotatePullTop', 'pt-page-rotatePullBottom', 'pt-page-rotateUnfoldLeft', 'pt-page-rotateUnfoldRight', 'pt-page-rotateUnfoldTop', 'pt-page-rotateUnfoldBottom'];
                for (var i in transitions) {
                    var transition_name = transitions[i];
                    if ($('.add-transition').hasClass(transition_name)) {

                        $('.add-transition').addClass(transition_name + '-init page-transition');

                        setTimeout(function() {
                            $('.add-transition').removeClass(transition_name + ' ' + transition_name + '-init page-transition');
                        }, 1200);
                        return;
                    }
                }

            };

            $(document).ready(function() {
                $(".login_as_picker").selectpicker();
                pageTransitions();

                // ADD SLIDEDOWN ANIMATION TO DROPDOWN //
                $('.dropdown').on('show.bs.dropdown', function(e){
                    $(this).find('.dropdown-menu').first().stop(true, true).slideDown();
                });

                // ADD SLIDEUP ANIMATION TO DROPDOWN //
                $('.dropdown').on('hide.bs.dropdown', function(e){
                    $(this).find('.dropdown-menu').first().stop(true, true).slideUp();
                });

                /* Sidebar menu */
                $(function() {

                  $(".sf-with-ul").click(function(){
                    if(!$(this).hasClass("sfActive")){
                      $(this).parents("#sidebar-menu").find("li").removeClass("sfHover");
                      $(this).parents("#sidebar-menu").find("li").find("a").removeClass("sfActive");
                      $(this).parents("#sidebar-menu").find("li").find(".sidebar-submenu").slideUp();

                      $(this).parent().addClass("sfHover");
                      $(this).addClass("sfActive");
                      $(this).parent().find(".sidebar-submenu").slideDown();
                    }else{
                      $(this).parent().toggleClass("sfHover");
                      $(this).toggleClass("sfActive");
                      $(this).parent().find(".sidebar-submenu").slideToggle();
                    }
                  });

                    //automatically open the current path
                    var path = window.location.pathname.split('/');
                    path = path[path.length-1];
                    if (path !== undefined) {
                        $("#sidebar-menu").find("a[href$='" + path + "']").addClass('sfActive');
                        $("#sidebar-menu").find("a[href$='" + path + "']").parents().eq(3).superclick('show');
                    }

                });

                /* Colapse sidebar */
                $(function() {

                    $('#close-sidebar').click(function() {
                        $('body').toggleClass('closed-sidebar');
                        $('.glyph-icon', this).toggleClass('icon-angle-right').toggleClass('icon-angle-left');
                    });

                });

                /* Sidebar scroll */

                $(".change-img").on('click', function() {
                  $("#img_profile").trigger('click');

                  /* Act on the event */
                });
                <?php
                if(count(glob($res_emp["emp_img_path_s"]))==0 || $res_emp['emp_img_path_s'] == '') {
                  ?>
                  var old_img = "/backoffice/setting/img/profile_emp-01.svg";
                  <?php
                }else{
                  ?>
                  var old_img = "<?php echo $res_emp["emp_img_path_s"] ?>";
                  <?php
                }
                ?>

                $("#img_profile_oldhid").val(old_img);

                $("#img_profile").on('change', function() {
                  var fileExtension = ['jpeg', 'jpg', 'png'];
                  if (!($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1)) {

            				show_loading_feedback("show");
                    $('#frm-change-img-profile').submit();
                    readURL(this);
                  }else{
                    show_loading_feedback("hide");
            	    	iziToast_func.alert("กรุณาอัพโหลดไฟล์รูปภาพประเภท jpg, jpge และ png !");
                  }
                });

            });

            function readURL(input) {

                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                      var image = new Image();
                      image.src = e.target.result;
                      image.onload = function() {
                        console.log(this.width);
                        $('.border-user-img img').attr('src', this.src);
                        $('.user-account-btn .border-user-img img').attr('style', getPositionImage(this.width,this.height,50));
                        $('#frm-change-img-profile .border-user-img img').attr('style', getPositionImage(this.width,this.height,80));

                      }

                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            </script>
          </div>
        </body>
        <iframe name="iframe-data" frameborder="0" style="display:none;"></iframe>
        </html>
