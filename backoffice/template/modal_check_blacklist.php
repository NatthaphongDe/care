<?php
include("../../config/config.php");
include("../../api/ditp_extapi.php");
include("../class/main.class.php");
include("../class/case.class.php");
include("../class/check_webservice.php");

//if(isset($_GET["textId"]) && $_GET["textId"]!=""){
  $wsvc_cls = new webservice_base();

  // print_r($_GET);
  
  // $blacklist_info = $wsvc_cls->check_webservice_blacklist($_GET["textId"],$_GET["textName"]);
  $blacklist_info = $wsvc_cls->check_webservice_blacklist($_GET["textId"]);
  // echo "<pre>" ;
  // print_r($blacklist_info);
  // echo "</pre>" ;
  // exit;
  // echo 1;

  if($_GET["method"]=="getData_blacklist"){

    $res = array("data_html"=>$wsvc_cls->check_webservice_blacklist($_GET["textId"]), "status_blacklist"=>$wsvc_cls->status_blacklist);
    echo json_encode($res);
    exit();
  }
  
//}
?>
<!DOCTYPE html>
<html lang="en">
<head>

<style>
/* Loading Spinner */
.spinner{margin:0;width:70px;height:18px;margin:-35px 0 0 -9px;position:absolute;top:50%;left:50%;text-align:center}.spinner > div{width:18px;height:18px;background-color:#333;border-radius:100%;display:inline-block;-webkit-animation:bouncedelay 1.4s infinite ease-in-out;animation:bouncedelay 1.4s infinite ease-in-out;-webkit-animation-fill-mode:both;animation-fill-mode:both}.spinner .bounce1{-webkit-animation-delay:-.32s;animation-delay:-.32s}.spinner .bounce2{-webkit-animation-delay:-.16s;animation-delay:-.16s}@-webkit-keyframes bouncedelay{0%,80%,100%{-webkit-transform:scale(0.0)}40%{-webkit-transform:scale(1.0)}}@keyframes bouncedelay{0%,80%,100%{transform:scale(0.0);-webkit-transform:scale(0.0)}40%{transform:scale(1.0);-webkit-transform:scale(1.0)}}
.text-red {
  color: red;
  margin-top: 10px;
  margin-left: 10px;
}
</style>


<meta charset="UTF-8">
<!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
<title> DITP </title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

<!-- Favicons -->

<link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/images/icons/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/images/icons/apple-touch-icon-114-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/images/icons/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="../assets/images/icons/apple-touch-icon-57-precomposed.png">
<!-- <link rel="shortcut icon" href="../assets/images/icons/favicon.png"> -->


<!-- FONTS -->
<link rel="stylesheet" type="text/css" href="../css/fonts.css">
<link rel="stylesheet" type="text/css" href="../css/fonts-icon.css">

<!-- BOOTSTRAP -->
<link rel="stylesheet" type="text/css" href="../assets/bootstrap/css/bootstrap.css">


<!-- HELPERS -->

<link rel="stylesheet" type="text/css" href="../assets/helpers/animate.css">
<link rel="stylesheet" type="text/css" href="../assets/helpers/backgrounds.css">
<link rel="stylesheet" type="text/css" href="../assets/helpers/boilerplate.css">
<link rel="stylesheet" type="text/css" href="../assets/helpers/border-radius.css">
<link rel="stylesheet" type="text/css" href="../assets/helpers/grid.css">
<link rel="stylesheet" type="text/css" href="../assets/helpers/page-transitions.css">
<link rel="stylesheet" type="text/css" href="../assets/helpers/spacing.css">
<link rel="stylesheet" type="text/css" href="../assets/helpers/typography.css">
<link rel="stylesheet" type="text/css" href="../assets/helpers/utils.css">
<link rel="stylesheet" type="text/css" href="../assets/helpers/colors.css">

<!-- ELEMENTS -->

<link rel="stylesheet" type="text/css" href="../assets/elements/badges.css">
<link rel="stylesheet" type="text/css" href="../assets/elements/buttons.css">
<link rel="stylesheet" type="text/css" href="../assets/elements/content-box.css">
<link rel="stylesheet" type="text/css" href="../assets/elements/dashboard-box.css">
<link rel="stylesheet" type="text/css" href="../assets/elements/forms.css">
<link rel="stylesheet" type="text/css" href="../assets/elements/images.css">
<link rel="stylesheet" type="text/css" href="../assets/elements/info-box.css">
<link rel="stylesheet" type="text/css" href="../assets/elements/invoice.css">
<link rel="stylesheet" type="text/css" href="../assets/elements/loading-indicators.css">
<link rel="stylesheet" type="text/css" href="../assets/elements/menus.css">
<link rel="stylesheet" type="text/css" href="../assets/elements/panel-box.css">
<link rel="stylesheet" type="text/css" href="../assets/elements/response-messages.css">
<link rel="stylesheet" type="text/css" href="../assets/elements/responsive-tables.css">
<link rel="stylesheet" type="text/css" href="../assets/elements/ribbon.css">
<link rel="stylesheet" type="text/css" href="../assets/elements/social-box.css">
<link rel="stylesheet" type="text/css" href="../assets/elements/tables.css">
<link rel="stylesheet" type="text/css" href="../assets/elements/tile-box.css">
<link rel="stylesheet" type="text/css" href="../assets/elements/timeline.css">



<!-- ICONS -->

<link rel="stylesheet" type="text/css" href="../assets/icons/fontawesome/fontawesome.css">
<link rel="stylesheet" type="text/css" href="../assets/icons/linecons/linecons.css">
<link rel="stylesheet" type="text/css" href="../assets/icons/spinnericon/spinnericon.css">


<!-- WIDGETS -->

<link rel="stylesheet" type="text/css" href="../assets/widgets/accordion-ui/accordion.css">
<link rel="stylesheet" type="text/css" href="../assets/widgets/calendar/calendar.css">
<link rel="stylesheet" type="text/css" href="../assets/widgets/carousel/carousel.css">

<link rel="stylesheet" type="text/css" href="../assets/widgets/charts/justgage/justgage.css">
<link rel="stylesheet" type="text/css" href="../assets/widgets/charts/morris/morris.css">
<link rel="stylesheet" type="text/css" href="../assets/widgets/charts/piegage/piegage.css">
<link rel="stylesheet" type="text/css" href="../assets/widgets/charts/xcharts/xcharts.css">

<link rel="stylesheet" type="text/css" href="../assets/widgets/chosen/chosen.css">
<link rel="stylesheet" type="text/css" href="../assets/widgets/colorpicker/colorpicker.css">
<link rel="stylesheet" type="text/css" href="../assets/widgets/datatable/datatable.css">
<link rel="stylesheet" type="text/css" href="../assets/widgets/datepicker/datepicker.css">
<link rel="stylesheet" type="text/css" href="../assets/widgets/datepicker-ui/datepicker.css">
<link rel="stylesheet" type="text/css" href="../assets/widgets/daterangepicker/daterangepicker.css">
<link rel="stylesheet" type="text/css" href="../assets/widgets/dialog/dialog.css">
<link rel="stylesheet" type="text/css" href="../assets/widgets/dropdown/dropdown.css">
<link rel="stylesheet" type="text/css" href="../assets/widgets/dropzone/dropzone.css">
<link rel="stylesheet" type="text/css" href="../assets/widgets/file-input/fileinput.css">
<link rel="stylesheet" type="text/css" href="../assets/widgets/input-switch/inputswitch.css">
<link rel="stylesheet" type="text/css" href="../assets/widgets/input-switch/inputswitch-alt.css">
<link rel="stylesheet" type="text/css" href="../assets/widgets/ionrangeslider/ionrangeslider.css">
<link rel="stylesheet" type="text/css" href="../assets/widgets/jcrop/jcrop.css">
<link rel="stylesheet" type="text/css" href="../assets/widgets/jgrowl-notifications/jgrowl.css">
<link rel="stylesheet" type="text/css" href="../assets/widgets/loading-bar/loadingbar.css">
<link rel="stylesheet" type="text/css" href="../assets/widgets/maps/vector-maps/vectormaps.css">
<link rel="stylesheet" type="text/css" href="../assets/widgets/markdown/markdown.css">
<link rel="stylesheet" type="text/css" href="../assets/widgets/modal/modal.css">
<link rel="stylesheet" type="text/css" href="../assets/widgets/multi-select/multiselect.css">
<link rel="stylesheet" type="text/css" href="../assets/widgets/multi-upload/fileupload.css">
<link rel="stylesheet" type="text/css" href="../assets/widgets/nestable/nestable.css">
<link rel="stylesheet" type="text/css" href="../assets/widgets/noty-notifications/noty.css">
<link rel="stylesheet" type="text/css" href="../assets/widgets/popover/popover.css">
<link rel="stylesheet" type="text/css" href="../assets/widgets/pretty-photo/prettyphoto.css">
<link rel="stylesheet" type="text/css" href="../assets/widgets/progressbar/progressbar.css">
<link rel="stylesheet" type="text/css" href="../assets/widgets/range-slider/rangeslider.css">
<link rel="stylesheet" type="text/css" href="../assets/widgets/slidebars/slidebars.css">
<link rel="stylesheet" type="text/css" href="../assets/widgets/slider-ui/slider.css">
<link rel="stylesheet" type="text/css" href="../assets/widgets/summernote-wysiwyg/summernote-wysiwyg.css">
<link rel="stylesheet" type="text/css" href="../assets/widgets/tabs-ui/tabs.css">
<link rel="stylesheet" type="text/css" href="../assets/widgets/theme-switcher/themeswitcher.css">
<link rel="stylesheet" type="text/css" href="../assets/widgets/tocify/tocify.css">
<link rel="stylesheet" type="text/css" href="../assets/widgets/tooltip/tooltip.css">
<link rel="stylesheet" type="text/css" href="../assets/widgets/touchspin/touchspin.css">
<link rel="stylesheet" type="text/css" href="../assets/widgets/uniform/uniform.css">
<link rel="stylesheet" type="text/css" href="../assets/widgets/wizard/wizard.css">
<link rel="stylesheet" type="text/css" href="../assets/widgets/xeditable/xeditable.css">

<!-- SNIPPETS -->

<link rel="stylesheet" type="text/css" href="../assets/snippets/chat.css">
<link rel="stylesheet" type="text/css" href="../assets/snippets/files-box.css">
<link rel="stylesheet" type="text/css" href="../assets/snippets/login-box.css">
<link rel="stylesheet" type="text/css" href="../assets/snippets/notification-box.css">
<link rel="stylesheet" type="text/css" href="../assets/snippets/progress-box.css">
<link rel="stylesheet" type="text/css" href="../assets/snippets/todo.css">
<link rel="stylesheet" type="text/css" href="../assets/snippets/user-profile.css">
<link rel="stylesheet" type="text/css" href="../assets/snippets/mobile-navigation.css">

<!-- APPLICATIONS -->

<link rel="stylesheet" type="text/css" href="../assets/applications/mailbox.css">

<!-- Admin theme -->

<link rel="stylesheet" type="text/css" href="../assets/themes/admin/layout.css">
<link rel="stylesheet" type="text/css" href="../assets/themes/admin/color-schemes/default.css">

<!-- Components theme -->

<link rel="stylesheet" type="text/css" href="../assets/themes/components/default.css">
<link rel="stylesheet" type="text/css" href="../assets/themes/components/border-radius.css">

<!-- Admin responsive -->

<link rel="stylesheet" type="text/css" href="../assets/helpers/responsive-elements.css">
<link rel="stylesheet" type="text/css" href="../assets/helpers/admin-responsive.css">

<!-- bootstrap-select -->
<link rel="stylesheet" href="../assets/widgets/bootstrap-select/dist/css/bootstrap-select.css">

<link rel="stylesheet" type="text/css" href="../css/style.css">

<!-- JS Core -->

<script type="text/javascript" src="../assets/js-core/jquery-core.js"></script>
<script type="text/javascript" src="../assets/js-core/jquery-ui-core.js"></script>
<script type="text/javascript" src="../assets/js-core/jquery-ui-widget.js"></script>
<script type="text/javascript" src="../assets/js-core/jquery-ui-mouse.js"></script>
<script type="text/javascript" src="../assets/js-core/jquery-ui-position.js"></script>

<script type="text/javascript" src="../assets/js-core/modernizr.js"></script>
<script type="text/javascript" src="../assets/js-core/jquery-cookie.js"></script>
<!-- Uniform -->

<script type="text/javascript" src="../assets/widgets/uniform/uniform.js"></script>
<script type="text/javascript" src="../assets/widgets/uniform/uniform-demo.js"></script>


</head>
<body>
<div class="modal fade display-block" tabindex="1"  id="model_check">
    <div class="form-horizontal">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" onclick="closeWindow();">
                    <i class="ditp-icon icon-ico-ditp-20"></i>
                  </button>
                  <h4 class="modal-title">ตรวจสอบข้อมูลจาก Blacklist</h4>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-12">
                    <!-- <label class="col-sm-12 control-label">เลขนิติบุคคล</label> -->
                    <div class="col-sm-11">
                        <input type="text" class="form-control input-mask" id="ident_number" name="ident_number" value=""  />
                    </div>
                    <div class="col-sm-1">
                      <a href="javascript:void(0)" class="icon-search-btn">
                      <i class="glyph-icon icon-search"></i>
                      </a>
                    </div>
                  </div>
                </div>

                <div class="text-red">*สามารถค้นหาได้จากชื่อบริษัท ชื่อ นามสกุล เลขนิติบุคคล หรือเลขบัตรประชาชน</div>

                <div class="panel-body panel-body-outer-bg2" style="padding:10px;">
                  <div class="cssload-container" style="display:none">
                    <div class="cssload-whirlpool"></div>
                  </div>
                  <div class="blacklist_info">
                    <!-- <div class="col-md-12 panel-body-bg2 no-gutter">
                      <div class="col-md-12 blacklist_info_inner no-gutter">
                        <?php echo $blacklist_info['show'] ?>
                      </div>
                    </div> -->
                  </div>
                  
                </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-success btn-open-model-confirm" id="btn-true" onclick="send_blacklist_status('<?php echo $wsvc_cls->status_blacklist=="00"?"1":"2" ?>','<?php echo $_GET["frmSet"] ?>')" >ตกลง</button>
                  <!-- <button type="button" class="btn btn-danger btn-open-model-invalid" >ข้อมูลไม่ถูกต้อง</button> -->
              </div>
          </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="model_comfirm_check" tabindex="-1" role="dialog" aria-labelledby="model_comfirm_check_label" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" onclick="closeWindow();">
                      <i class="ditp-icon icon-ico-ditp-20"></i>
                  </button>
                  <h4 class="modal-title">หมายเหตุ</h4>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-12">
                    <textarea name="note_blacklist_check" id="note_blacklist_check" rows="3" class="form-control textarea-no-resize"></textarea>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-success btn-success-final" onclick="send_blacklist_status('1','<?php echo $_GET["frmSet"] ?>','<?php echo $_GET["frmType"] ?>')">ยืนยัน</button>
              </div>
          </div>
      </div>
  </div>


  <!-- bootstrap -->
<script type="text/javascript" src="../assets/bootstrap/js/bootstrap.js"></script>

<!-- bootstrap-select -->
<script type="text/javascript" src="../assets/widgets/bootstrap-select/dist/js/bootstrap-select.min.js"></script>

<script type="text/javascript" src="../assets/widgets/input-mask/inputmask.js"></script>

<script type="text/javascript">
  /* Input masks */
  $(document).ready(function() {

    $(".icon-search-btn").on("click",function(){
      $(".cssload-container").show();
      getDataService();
    });
    $("#ident_number").keypress(function(event) {
      /* Act on the event */
      if(event.which==13){
        $(".cssload-container").show();
        getDataService();
      }
    });
    $(".input-mask").inputmask();
    $('.btn-open-model-invalid').click(function(){
      $('#model_check').modal('hide');
      $('#model_comfirm_check').modal('show');
      $('.btn-success-final').attr("onClick","send_blacklist_status('2','<?php echo $_GET["frmSet"] ?>','<?php echo $_GET["frmType"] ?>')");
    });
  });

  function getDataService(){
    var data_res_html = "";
    $.ajax({
      url: "modal_check_blacklist.php?method=getData_blacklist",
      data:{ "frmSet" : '<?php echo $_GET["frmSet"]?>', "textId":$("#ident_number").val() },
      type: 'get',
      dataType: "json",
      async: false,
      success: function( data_res ) {
        data_res_html=data_res.data_html;
        $(".cssload-container").hide();
        $(".blacklist_info").html(data_res_html.show);
        $('#btn-true').removeAttr('onclick');
        if(data_res_html.data.status == 00) {
          status = 1;
        } else {
          status = 2;
        }
        $('#btn-true').attr('onClick', 'send_blacklist_status(' + status + ', "<?php echo $_GET["frmSet"] ?>");');
        var num = $(".reliable").length;
        if(num == 1) {
          $('input[name="complnt_checked[]"]:first').attr('checked', true);
        }
        
      }
    });
    
  }

  function closeWindow() {
    window.close();
  }

  function send_blacklist_status(status,frmset,frmType, com_name, com_address){
    console.log(status);
    if(status=="1"){
      var id = '';
      $('input[name="complnt_checked[]"]').each(function() {
        var sThisVal = (this.checked ? $(this).val() : "");
        if (sThisVal != '') {
          id = $(this).val()
        }
      })
      console.log(id);
      if(id != '') {
        if($("#reliable"+id).val() == 'Blacklist') {
          if(confirm("กรุณายืนยันผลตรวจสอบ \"สถานะ Blacklist\" ")){
            $(window.opener.document).find("#check_backlist_logo_IdxFs_"+frmset).attr("src","img/btn_check_backlist_1.png");
            $(window.opener.document).find("#complnt_backlist_IdxFs_"+frmset).attr('value',1);
            
            closeWindow();
          }
        } else {
          if(confirm("กรุณายืนยันผลตรวจสอบ \""+$("#reliable"+id).val()+"\" ")){
            $(window.opener.document).find("#check_backlist_logo_IdxFs_"+frmset).attr("src","img/btn_check_backlist_2.png");
            $(window.opener.document).find("#complnt_backlist_IdxFs_"+frmset).attr('value',2);
            closeWindow();
          }
        }
      } else {
        if(confirm("กรุณาเลือกบริษัทที่ตรวจสอบ")){
        
        }
      }
      
      
    }else if(status=="2"){
      if(confirm("กรุณายืนยันผลตรวจสอบ \"ไม่พบ Blacklist\" ")){
        $(window.opener.document).find("#check_backlist_logo_IdxFs_"+frmset).attr("src","img/btn_check_backlist_2.png");
        $(window.opener.document).find("#complnt_backlist_IdxFs_"+frmset).attr('value',2);
        closeWindow();
      }
    }
  }

</script>

<style>
  .icon-search{
    font-size: 24px;
  }
</style>
</body>
