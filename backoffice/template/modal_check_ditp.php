<?php
include("../../config/config.php");
include("../../api/ditp_extapi.php");
include("../class/main.class.php");
include("../class/case.class.php");
include("../class/check_webservice.php");

//if(isset($_GET["textId"]) && $_GET["textId"]!=""){
  $wsvc_cls = new webservice_base();
  $ditp_info = $wsvc_cls->check_webservice_ditp($_GET["textId"]);

  if($_GET["method"]=="getData_ditp"){
    $res = array("data_html"=>$ditp_info,"status_ditp"=>$wsvc_cls->status_ditp);
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
                  <h4 class="modal-title">ตรวจสอบข้อมูลจาก DITP</h4>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-12">
                    <label class="col-sm-12 control-label">เลขนิติบุคคล</label>
                    <div class="col-sm-11">
                        <input type="text" class="form-control input-mask" id="ident_number" name="ident_number" value="<?php echo $_GET["textId"] ?>" data-inputmask="&apos;mask&apos;:&apos;9-99999-9999-999&apos;"  />
                    </div>
                    <div class="col-sm-1">
                      <a href="javascript:void(0)" class="icon-search-btn">
                        <i class="glyph-icon icon-search"></i>
                      </a>
                    </div>
                  </div>
                </div>

                <div class="panel-body panel-body-outer-bg2" style="padding:10px;">
                  <div class="col-md-12 panel-body-bg2 no-gutter ditp_info">
                      <div class="cssload-container" style="display:none;">
                      	<div class="cssload-whirlpool"></div>
                      </div>
                      <div class="col-md-12 ditp_info_inner no-gutter">
                      <?php echo $ditp_info ?>
                      </div>
                  </div>
                </div>

              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-success btn-open-model-confirm" id="btn-true" onclick="send_ditp_status('<?php echo $wsvc_cls->status_ditp=="00"?"1":"2" ?>','<?php echo $_GET["frmSet"] ?>','<?php echo $_GET["frmType"] ?>')" >ตกลง</button>
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
                    <textarea name="note_ditp_check" id="note_ditp_check" rows="3" class="form-control textarea-no-resize"></textarea>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-success btn-success-final" onclick="send_ditp_status('1','<?php echo $_GET["frmSet"] ?>','<?php echo $_GET["frmType"] ?>')">ยืนยัน</button>
              </div>
          </div>
      </div>
  </div>


<script type="text/javascript" src="../assets/bootstrap/js/bootstrap.js"></script>


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
    // $('.btn-open-model-confirm').click(function(){
    //   $('#model_check').modal('hide');
    //   $('#model_comfirm_check').modal('show');
    //   $('.btn-success-final').attr("onClick","send_ditp_status('1','<?php echo $_GET["frmSet"] ?>')");
    // });

    $('.btn-open-model-invalid').click(function(){
      $('#model_check').modal('hide');
      $('#model_comfirm_check').modal('show');
      $('.btn-success-final').attr("onClick","send_ditp_status('2','<?php echo $_GET["frmSet"] ?>','<?php echo $_GET["frmType"] ?>')");
    });
  });
  function getDataService(){
    var data_res_html = "";
    $.ajax({
      url: "modal_check_ditp.php?method=getData_ditp",
      data:{ "frmSet" : <?php echo $_GET["frmSet"]?>, "textId":$("#ident_number").val() },
      type: 'get',
      dataType: "json",
      async: false,
      success: function( data_res ) {
        data_res_html=data_res.data_html;
        // if(data_res.status_ditp=="01"){
        //   $("#btn-true").prop("disabled",true);
        // }else{
        //   $("#btn-true").prop("disabled",false);
        // }
      }
    });

    $(".cssload-container").hide();
    $(".ditp_info_inner").html(data_res_html);
  }

  function closeWindow() {
    window.close();
  }

  function send_ditp_status(status,frmset,frmType){
    if(status=="1"){
      var channel = $(window.opener.document).find("input[name='caseCh_id']").val();
      var method = $(window.opener.document).find("input[name='method_type']").val();
      var dtype = $("#ditp_type").val();
      // console.log(dtype);
      if(!(dtype == 'other' || dtype == '' || dtype == 'non member')) {
        if(confirm("กรุณายืนยันผลตรวจสอบ \"เป็นสมาชิกกรม\" ")){
          $(window.opener.document).find("#check_ditp_logo_IdxFs_"+frmset).attr("src","img/logo_ditp/btn-ditp-"+$("#ditp_type").val()+".png");
          // $(window.opener.document).find("#check_ditp_logo_IdxFs_"+frmset).attr("src","img/btn_check_ditp_1.png");
          $(window.opener.document).find("#"+frmType+"_valid_ditp_IdxFs_"+frmset).attr('value',1);
          $(window.opener.document).find("#"+frmType+"_valid_ditp_org_IdxFs_"+frmset).attr('value',$("#ditp_type").val());
          $(window.opener.document).find("#check_ditp_note_IdxFs_"+frmset).attr('value',$("#note_ditp_check").val());
          
          var cont = '';
          if(frmType == 'applnt') {
            frmType = 'applntOrg';
          } else {
            cont = '_contact';
          }


          if(!(channel==1 || channel==2) && method != 'editcase'){
            // $(window.opener.document).find("input[name='"+frmType+"_trade_number_IdxFs_"+frmset+"']").val($("#ident_number").val());
            // $(window.opener.document).find("input[name='"+frmType+"_name_IdxFs_"+frmset+"']").attr('value',$("#res_company_name").text());
            // $(window.opener.document).find("input[name='"+frmType+""+cont+"_tel_IdxFs_"+frmset+"']").attr('value',$("#res_telephone").text());
            // $(window.opener.document).find("input[name='"+frmType+""+cont+"_fax_IdxFs_"+frmset+"']").attr('value',$("#res_fax").text());
            // $(window.opener.document).find("textarea[name='"+frmType+""+cont+"_address_IdxFs_"+frmset+"']").val($("#res_address").text());
            // $(window.opener.document).find("input[name='"+frmType+"_zipcode_IdxFs_"+frmset+"']").val($("#res_postcode").text());

            // // $(window.opener.document).find("input[name='"+frmType+"Org_name_IdxFs_"+frmset+"']").attr('value',$("#res_company_name").text());
            // //Get the text using the value of select
            // var text = $(window.opener.document).find("select[name='"+frmType+"_prov_id_IdxFs_"+frmset+"']").find("option[value='"+$("#res_province_id").val()+"']").text();
            // //We need to show the text inside the span that the plugin show
            // $(window.opener.document).find("select[name='"+frmType+"_prov_id_IdxFs_"+frmset+"']").parents('.bootstrap-select').find('.filter-option').text(text);
            // //Check the selected attribute for the real select
            // $(window.opener.document).find("select[name='"+frmType+"_prov_id_IdxFs_"+frmset+"']").val(1);

          }

          closeWindow();
        }
      } else {
        if(confirm("กรุณายืนยันผลตรวจสอบ \"ไม่เป็นสมาชิกกรม\" ")){
          $(window.opener.document).find("#check_ditp_logo_IdxFs_"+frmset).attr("src","img/logo_ditp/btn_check_ditp_2.png");
          $(window.opener.document).find("#"+frmType+"_valid_ditp_IdxFs_"+frmset).attr('value',2);
          $(window.opener.document).find("#"+frmType+"_valid_ditp_org_IdxFs_"+frmset).attr('value',$("#ditp_type").val());
          $(window.opener.document).find("#check_ditp_note_IdxFs_"+frmset).attr('value',$("#note_ditp_check").val());

          var cont = '';
          if(frmType == 'applnt') {
            frmType = 'applntOrg';
          } else {
            cont = '_contact';
          }

          if(!(channel==1 || channel==2) && method != 'editcase'){
            // $(window.opener.document).find("input[name='"+frmType+"_trade_number_IdxFs_"+frmset+"']").val($("#ident_number").val());
            // $(window.opener.document).find("input[name='"+frmType+"_name_IdxFs_"+frmset+"']").attr('value',$("#res_company_name").text());
            // $(window.opener.document).find("input[name='"+frmType+""+cont+"_tel_IdxFs_"+frmset+"']").attr('value',$("#res_telephone").text());
            // $(window.opener.document).find("input[name='"+frmType+""+cont+"_fax_IdxFs_"+frmset+"']").attr('value',$("#res_fax").text());
            // $(window.opener.document).find("textarea[name='"+frmType+""+cont+"_address_IdxFs_"+frmset+"']").val($("#res_address").text());
            // $(window.opener.document).find("input[name='"+frmType+"_zipcode_IdxFs_"+frmset+"']").val($("#res_postcode").text());

            // // $(window.opener.document).find("input[name='"+frmType+"Org_name_IdxFs_"+frmset+"']").attr('value',$("#res_company_name").text());
            // //Get the text using the value of select
            // var text = $(window.opener.document).find("select[name='"+frmType+"_prov_id_IdxFs_"+frmset+"']").find("option[value='"+$("#res_province_id").val()+"']").text();
            // //We need to show the text inside the span that the plugin show
            // $(window.opener.document).find("select[name='"+frmType+"_prov_id_IdxFs_"+frmset+"']").parents('.bootstrap-select').find('.filter-option').text(text);
            // //Check the selected attribute for the real select
            // $(window.opener.document).find("select[name='"+frmType+"_prov_id_IdxFs_"+frmset+"']").val(1);

          }
          closeWindow();
        }
      }
      
    }else if(status=="2"){
      if(confirm("กรุณายืนยันผลตรวจสอบ \"ไม่เป็นสมาชิกกรม\" ")){
        $(window.opener.document).find("#check_ditp_logo_IdxFs_"+frmset).attr("src","img/logo_ditp/btn_check_ditp_2.png");
        $(window.opener.document).find("#"+frmType+"_valid_ditp_IdxFs_"+frmset).attr('value',2);
        $(window.opener.document).find("#"+frmType+"_valid_ditp_org_IdxFs_"+frmset).attr('value',$("#ditp_type").val());
        $(window.opener.document).find("#check_ditp_note_IdxFs_"+frmset).attr('value',$("#note_ditp_check").val());
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
