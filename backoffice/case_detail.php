
<link rel="stylesheet" type="text/css" href="css/case_detail.css">
<!-- <form class="form-horizontal" name="form-detail" action="/"> -->
  <div class="row" id="page_case_detail">

    <!-- Left Container -->
    <div class="col-md-8 col-lg-8">

      <!-- History Menu -->
      <div class="panel" id="panel-his-menu">
        <div class="panel-body">

          <div class="nav-history">
              <a href="index.php" class="">
                <span class="ditp-icon icon-ico-ditp-01"></span>
              </a>
              <span class="glyph-icon icon-angle-right"></span>
              <a href="index.php?page=case_list" class="">
                เรื่องร้องเรียนทั้งหมด
              </a>
              <span class="glyph-icon icon-angle-right"></span>
              <a href="javascript:void(0);" class="no-underline">Case ID <?php echo sprintf("%05d",$rs_case["case"]["case_id"]); ?> - <?php echo $rs_case["case"]["caseDtl_title"]; ?>  </a>
              <span class="exportCase" onclick="exportCase()">export</span>
          </div>
        </div>
      </div>
      <!-- /History Menu -->

      <div id="page-title">
        <span class="title-text">
          Case ID <?php echo sprintf("%05d",$rs_case["case"]["case_id"]); ?> - <?php echo $rs_case["case"]["caseDtl_title"]; ?>
          <input type="hidden" name="case_id" value="<?php echo $rs_case["case"]["case_id"]; ?>" />
        </span>
      </div>


      <?php
      $no = 0;
      $formSet_html = array();
      foreach ($arr_formSetList as  $formSetList_panel) {
        // if (in_array($_SESSION['admin']['empId'], array('1', '7'))) {
        //   echo '<br>formsetId.: '.$formSetList_panel["frmset_id"].' :: '.$formSetList_panel["frmset_name"];
        // }
        array_push($formSet_html,$caseDtl_cls->setFromList_detailCase($formSetList_panel["frmset_id"],$formSetList_panel["frmset_name"],$no+1));
        $no++;
        //echo $formSetList_panel["frmset_id"];
      }
      ?>

      <!-- รายละเอียดเรื่องร้องเรียน -->
      <div class="panel" id="panel-form-c">
          <?php echo $formSet_html[2]; ?>
      </div>
      <!-- /รายละเอียดเรื่องร้องเรียน -->



      <!--  ผู้ร้องเรียน -->
      <div class="panel" id="panel-form-2">
        <?php echo $formSet_html[0]; ?>
      </div>
      <!-- /ผู้ร้องเรียน -->

      <!-- ขบริษัทต่างชาติผู้ถูกร้องเรียน -->
      <div class="panel" id="panel-form-2">
        <!-- ssss -->
        <!-- <pre>
          <? print_r($rs_case)?>
        </pre> -->
        <?php echo $formSet_html[1]; ?>


      </div>
      <!-- /บริษัทต่างชาติผู้ถูกร้องเรียน -->

      <?php
      if($rs_case["case"]["case_status"]==3){
        ?>
        <div class="panel">
          <div class="panel-body">
            <div class="form-group col-md-12">
              <label class="col-sm-4 control-label">สถานะการยุติข้อร้องเรียน</label>
              <div class="col-sm-8">
                <?php
                $closeType = $caseDtl_cls->caseCloseList();
             
                ?>
                <label class="text-data text-data-green text-data-size16"><?php echo $closeType[$rs_case["case"]["caseClose_id"]] ?></label>
              </div>
            </div>
            <div class="form-group col-md-12">
              <label class="col-sm-4 control-label">ผลการดำเนินการ</label>
              <div class="col-sm-8">
                <label class="text-data text-data-green text-data-size16"><?php echo $rs_case["case"]["case_close_resultProcess"] ?></label>
              </div>
            </div>
            <div class="form-group col-md-12">
              <label class="col-sm-4 control-label">สถานะบริษัท (Watchlist, Blacklist)</label>
              <div class="col-sm-8">
                <label class="text-data text-data-green text-data-size16">
                  <?php

                   $case_status = '';
                    if($rs_case["case"]["reliable"] == 1){
                      $case_status = 'Watchlist';
                    } elseif($rs_case["case"]["reliable"] == 2){
                      $case_status = 'Blacklist';
                    } else{
                      $case_status = 'ไม่มีสถานะ';
                    }
                    echo  $case_status;
                  //  echo $rs_case["case"]["reliable"] 
                   ?></label>
              </div>
            </div>
              </div>
        </div>
        <?php
      }
      ?>



    <!-- กระบวนการเริ่มต้น -->
    <?php
    //if($rs_case["case"]["case_status"]==1){
      include('template/process_initial.php');
    //}
    ?>
    <!-- /กระบวนการเริ่มต้น -->

    <!-- กระบวนการที่ถูกเพิ่ม -->
    <div class="panel-process-outter" ></div>
    <!-- /กระบวนการที่ถูกเพิ่ม -->


    <!-- กรณียังไม่ยุติข้อร้องเรียนแล้ว -->
    <?php
    if(($rs_case["case"]["case_status"]!=0 && $rs_case["case"]["case_status"]!=3) && $rs_case["case"]["my_case_assign"]==1 && $rs_case["case"]["case_assign_status"]==1 && $_SESSION["admin"]["empPosition"]!=6 && $_SESSION["admin"]["empPosition"]!=7 && $_SESSION["admin"]["empPosition"]!=8){
      //if($rs_case["case"]["case_status"]!=3){
      ?>
      <div class="row row-footer-btn">
        <div class="col-lg-12">
          <div class="form-group col-sm-12 div-text-center">
            <?php
            if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"create_process")[3]==1){
              ?>
              <button type="button" class="btn ra-100 btn-new-process">
                <i class="ditp-icon icon-ico-ditp-21"></i>
                <span>สร้างกระบวนการ</span>
              </button>
            <?php
            }
            if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"close_case")[3]==1){
              ?>
              <button type="button" class="btn ra-100 btn-close-case"
               type="button" onclick="case_close.openCloseCase('#model_close_case',null,'<?php echo $rs_case["case"]["case_id"]?>');">
                ยุติข้อร้องเรียน และแจ้งผลการดำเนินงาน
              </button>
              <?php
            }
            ?>
          </div>
        </div>
      </div>
      <?php
      //}
    }
    ?>
    <!-- /กรณียังไม่ยุติข้อร้องเรียนแล้ว -->

    <!-- กรณียุติข้อร้องเรียนแล้ว -->
    <?php
    if($rs_case["case"]["case_status"]==3){
      ?>
      <div class="row row-footer-btn">
        <div class="col-lg-12 div-text-center">
          <?php
          if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"re_open_case")[3]==1 && $_SESSION["admin"]["empPosition"]!=6 && $_SESSION["admin"]["empPosition"]!=7 && $_SESSION["admin"]["empPosition"]!=8){
          ?>
            <button type="button" class="btn ra-100 btn-custom-tool btn-create-editcase" value="2"  onclick="case_close.reOpenCase('<?php echo $rs_case["case"]["case_id"]?>');">
              Reopen
            </button>
          <?php
          }
          if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"dis_kpi_case")[3]==1 && $_SESSION["admin"]["empPosition"]!=6 && $_SESSION["admin"]["empPosition"]!=7 && $_SESSION["admin"]["empPosition"]!=8){

            if($_SESSION["admin"]["empPosition"]=="3" && $rs_case["case"]["case_disKPI_status"]=="0"){
              $datatimeGen_opencase = $caseDtl_cls->getDateTimeData($rs_case["case"]["case_opened_datetime"],$rs_case["case"]["case_close_datetime"]);
              if($datatimeGen_opencase["days"] > $rs_case["case"]["case_compType_duration"]){
                ?>
                <!-- กรณียุติข้อร้องเรียนหลังจาก Overdue -->
                <button type="button" class="btn ra-100 btn-custom-tool btn-warning btn-diskpi" onclick="case_close.openDiscreditCase('#model_discredit_kpi');">
                  ให้ KPI ติดลบ
                </button>
                <!-- /กรณียุติข้อร้องเรียนหลังจาก Overdue -->
                <?php
              }

            }
          }

          if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"save_to_knowledge")[3]==1 && $_SESSION["admin"]["empPosition"]!=6 && $_SESSION["admin"]["empPosition"]!=7 && $_SESSION["admin"]["empPosition"]!=8){
            if($rs_case["case"]["case_knowledge_type"]=="0") {
              ?>
              <button type="button" class="btn ra-100 btn-custom-tool btn-warning btn-learn" onclick="case_close.openKnowledgeCase('<?php echo $rs_case["case"]["case_id"]?>');">
                ส่งไปยังองค์ความรู้เรื่องร้องเรียน
              </button>
              <?php
            }
          }
          ?>

           <?php
          if ($_SESSION["admin"]["empId"] == 114) {?>
            <button type="button" class="btn ra-100 btn-custom-tool " style="background: #1976d2 !important;color: #fff !important;font-family: 'kanitregular'; font-size: 16px;"
               type="button" onclick="case_close.openCloseCase('#model_edit_close_case',null,'<?php echo $rs_case["case"]["case_id"]?>');">
                แก้ไข ผลการดำเนินงาน
              </button>
          <?php
          }
          ?>
        </div>
      </div>
      <?php
    }
    ?>
    <!-- /กรณียุติข้อร้องเรียนแล้ว -->

  </div>
  <!-- /Left Container -->

  <!-- Right Container -->
  <div class="col-md-4 col-lg-4">
    <?php include('right_sidebar.php'); ?>
  </div>
  <!-- /Right Container -->

</div>
<!-- </form> -->

<?php include('template/modal_history_applnt.php'); ?>
<?php include('template/modal_close_case.php'); ?>
<?php include('template/modal_discredit_kpi.php'); ?>
<?php include('template/modal_transfer.php'); ?>


<?php include('template/modal_history_applnt.php'); ?>
<?php include('template/modal_history_complnt.php'); ?>

<?php include('template/modal_process_overdue.php'); ?>

<?php include('template/modal_assign.php'); ?>


<!-- moment -->
<script type="text/javascript" src="assets/widgets/daterangepicker/moment.js"></script>

<script type="text/javascript" src="assets/widgets/autocomplete/autocomplete.js" ></script>
<script type="text/javascript" src="assets/widgets/autocomplete/menu.js" ></script>

<script type="text/javascript" src="assets/widgets/ckeditor/ckeditor.js"></script>
<script>
case_detail = new case_detail_class();
case_close = new case_close_class();





$(function(){
    case_detail.case_class.gen_header_color();
});

$(document).ready(function(){

  CKEDITOR.config.toolbar = [
   ['Styles','Format','Font','FontSize'],

   ['Bold','Italic','Underline','StrikeThrough','-','Undo','Redo','-','Cut','Copy','Paste','Find','Replace','-','Outdent','Indent','-','Print'],

   ['NumberedList','BulletedList','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
   ['TextColor','BGColor','Source'],
   ['Link','Unlink']
  ] ;
  CKEDITOR.config.height = 200;

  $('.select-picker').selectpicker();



  $('select.select-type-process').each(function(){
    var deptType = $(this).find("option[value='"+$(this).val()+"']").attr("rel");
    var deptTypez = $(this).find("option[value='"+$(this).val()+"']").attr("value");
    if(deptType!=0){
      if(deptTypez==3 || deptTypez == 5){
        $(this).parents('.panel-form-6').find(".panel-department").hide();
      }else{
        $(this).parents('.panel-form-6').find(".panel-department").show();
        var $panelform6 = $(this).parents('.panel-form-6');
        $panelform6.find("select.process_dept_id_demo").find("option").each(function(index, el) {
            $panelform6.find("select.process_dept_id").html($panelform6.find("select.process_dept_id_demo").html());
        });
        $(this).parents('.panel-form-6').find("select.process_dept_id").find("option").each(function(index, el) {
          if($(this).attr("rel")!=deptType && $(this).attr("rel")!=0){
            $(this).remove();
          }
        });
        var dept_id = $(this).parents('.panel-form-6').find(".dept_id").val();
        $(this).parents('.panel-form-6').find("select.process_dept_id").find("option[value='"+dept_id+"']").prop("selected",true);
        $('select.select-picker').selectpicker('refresh');
      }
    }else{
      $(this).parents('.panel-form-6').find(".panel-department").hide();
    }
  });

  //-- Event แสดง-ซ่อน เนื้อหากระบวนการ --//
  $(document).delegate('.btn-new-process','click',function(){
    var num_process = $('.panel-form-6').length+1;

    $.ajax({
      url: "template/process_container.php",
      method: "GET",
      data: {method:'getProcess_form',caseId:$('#collapse_process_1 input[name="case_id"]').val()},
      async: false,
      success: function(result){
        console.log(result);
        $('.panel-process-outter').append(result);
        $('#heading_process_idx a').attr('aria-controls','collapse_process_'+num_process);
        $('#heading_process_idx a').attr('href','#collapse_process_'+num_process);
        $('#collapse_process_idx').attr('id','collapse_process_'+num_process);
        $('#heading_process_idx').attr('id','heading_process_'+num_process);
        $('#ckeditor_idx').attr('id','ckeditor_'+num_process+'_1_1');
        $('#procPropEmail_file_idx').attr('id','procPropEmail_file_'+num_process+'_1_1');
        $('#card-block-idx').attr('id','card-block-new-'+num_process);

        case_detail.case_class.gen_header_color();
      }
    });
    $('select.select-picker').selectpicker('refresh');

    //setTimeout(function(){
      $('#collapse_process_'+num_process+' .ckeditor').each(function() {
        CKEDITOR.replace($(this).attr('id'));
      });
    //},500);

    $('#collapse_process_'+num_process+' .custom-select').uniform();
    $('#collapse_process_'+num_process+' .bootstrap-datepicker-process').datepicker({
      format: 'dd/mm/yyyy',
      startDate: new Date()
    });

    $('#collapse_process_'+num_process+' .bootstrap-datepicker-process').each(function(index, el) {
      if($(this).val()==""){
        $(this).datepicker("update", new Date());
      }
    });

    var d = new Date();
    var h = d.getHours();
    h = ('00'+h).slice(-2);
    var i = d.getMinutes();
    i = ('00'+i).slice(-2);
    $('#collapse_process_'+num_process+' .bootstrap-timepicker').each(function(index, el) {
      if($(this).val()==""){
        $(this).val(h+":"+i+":00");
      }
    });
    $('#collapse_process_'+num_process+' .bootstrap-timepicker').datetimepicker({format: 'LT'});

    $('#heading_process_'+num_process+' .title-process').html('กระบวนการที่ '+(num_process-2));
    $('#heading_process_'+num_process+' .title-process').attr('rel','กระบวนการที่ '+(num_process-2));
    $('#collapse_process_'+num_process+' .select-type-process').parents('.selector').append('<i class="glyph-icon icon-angle-down" style="background:none;border:none;"></i>');
    setTimeout(function(){
      auto_resize_menu();
    },500);
  });

  $('[data-toggle="tooltip"]').tooltip();

  $('.bootstrap-datepicker-process').datepicker({
      format: 'dd/mm/yyyy',
      startDate: new Date()
  });
  $('.bootstrap-datepicker-process').each(function(index, el) {
    if($(this).val()==""){
      $(this).datepicker("setDate", new Date());
    }
  });

  var d = new Date();
  var h = d.getHours();
  h = ('00'+h).slice(-2);
  var i = d.getMinutes();
  i = ('00'+i).slice(-2);
  $('.bootstrap-timepicker').each(function(index, el) {
    if($(this).val()==""){
      $(this).val(h+":"+i+":00");
    }
  });
  $('.bootstrap-timepicker').datetimepicker({format: 'LT'});

  $(document).delegate(".input-group-addon-calendar","click", function(e){
      $(this).parent().find('.bootstrap-datepicker-process').datepicker('show');
  });
  <?php
  if($proc_overdue_status==1){ //ถ้ามีกระบวนการเกิน overdue
    ?>
    window.parent.$("#model_process_overdue .proc_over_title_txt").html("<?php echo $proc_overdue_title ?>");
    window.parent.$("#model_process_overdue .proc_over_duration_txt").html("<?php echo $proc_overdue_duration ?>");
    $("#model_process_overdue").modal("show");
    <?php
  }
  ?>

  //-- เมื่อคลิ๊กปิดกระบวนการ--//
  $(document).delegate('.btn-close-process-list','click',function(event){
    $this = $(this);
    bootbox.confirm({
      size: "large",
      message: "ท่านต้องการปิดกระบวนการ?",
      buttons: {
          cancel: {
              label: '<i class="fa fa-times"></i> ยกเลิก'
          },
          confirm: {
              label: '<i class="fa fa-check"></i> บันทึก'
          }
      },
      callback: function(result){
        if(result){
          closeOvlBootobox();
          $this.parents('form').attr("action","function.php?method=close_process");
          show_loading_feedback('show');
          $this.parents('form').submit();
        }else{
          event.preventDefault();
        }
      }
    })
  });

/* jQuery UI นับเวลา */
  $('.clock').each(function(){
    var elm_click = "#"+$(this).attr('id');
    var datetime = $(this).parents('button.btn-countdown-time').attr("rel");
    $(elm_click).countdown(datetime, {elapse:true}).on('update.countdown', function(event) {
      var format = '';

      if(event.offset.days == 0 && event.offset.hours == 0 && event.offset.minutes == 0 && event.offset.seconds < 60) {
        format = '1 นาที' + format;
      }else{
        if(event.offset.minutes > 0){
          format = '%M นาที' + format;
        }
        if(event.offset.hours   > 0){
          format = '%H ชั่วโมง ' + format;
        }
        if(event.offset.totalDays > 0) {
          format = '%D วัน ' + format;
        }
      }
      $(this).html(event.strftime(format));

    })
    .on('finish.countdown', function(event) {
      $(this).html('This offer has expired!')
        .parent().addClass('disabled');

    });
  });

  /* jQuery UI autocomplete */
  $("#emp_assign_search").autocomplete({
      source: function( request, response ) {
        $.ajax({
          url: "function.php?method=emp_list_assign",
          data: {txt_search:$("#emp_assign_search").val()},
          type: "post",
          dataType: "json",
          async:false,
          success: function(data) {
            response( data.suggestions );
          }
        });
      }
      // ,select: function (event, ui) {
      //   var emp_id = ui.item.data;
      //   var value = ui.item.value;
      //   case_detail.add_emp_assign(emp_id,function(){
      //     setTimeout(function(){
      //         $("#emp_assign_search").val('');
      //     },300)
      //   });
      // }
  });
  $('#emp_assign_search').focus(function(){
    var html_list= "";
    $.ajax({
      url: "function.php?method=emp_list_assign",
      data: {txt_search:$("#emp_assign_search").val()},
      type: "post",
      dataType: "json",
      async:false,
      success: function(data) {
        html_list  += '';
        $.each(data.suggestions,function(index, el) {
          html_list  += '<li class="ui-menu-item" id="ui-id-'+el.data+'" tabindex="-1" aria-label="'+el.value+'" rel="'+el.data+'" >'+el.value+'</li>';
        });

      }
    });
    if($('.ui-autocomplete').length>0){
      $('body .ui-autocomplete').html(html_list);
      $('body .ui-autocomplete').css({
        'position': 'fixed',
        'display': 'block',
        'width': '406px',
        'top': '187px',
        'left': '50%',
        'margin-left': '-132px'
      });
    }
  });

  $(document).delegate(".ui-menu-item","click",function(){
    var emp_id = $(this).attr("rel");
    if(emp_id==undefined){
      var emp_id_tmp = $(this).html();
      emp_id_tmp = emp_id_tmp.split(" - ");
      emp_id = parseInt(emp_id_tmp[0]);
    }
    var value = $(this).attr("aria-label");
    case_detail.add_emp_assign(emp_id,function(){
       setTimeout(function(){
           $("#emp_assign_search").val('');
       },300);
     });
  });

  <?php
  if(isset($_GET["hrefelmId"]) && $_GET["hrefelmId"]!=""){
    ?>
    $('html, body').animate({
        scrollTop: $("#<?php echo $_GET["hrefelmId"] ?> .row-footer-btn").offset().top
    }, 1000);
    <?php
  }
  if(isset($_GET["hrefelmcloseId"]) && $_GET["hrefelmcloseId"]!=""){
    ?>
    $('html, body').animate({
        scrollTop: $("#<?php echo $_GET["hrefelmcloseId"] ?>").parents(".panel-body").offset().top
    }, 1000);
    <?php
  }
  ?>

  <?php
  if($rs_case["case"]["case_status"] == 3){
    /* $(".card-block").find('button').remove();*/
    ?>
    $(".card-block").find('button').prop('disabled',true);
    $(".card-block").find('input').prop('disabled',true);
    $(".card-block").find('select').prop('disabled',true);
    $(".card-block").find('textarea').prop('disabled',true);
    $(".card-block").find('.icon-add-channel').parents('a').remove();
    $(".card .collapse").removeClass('in');
    $(".card .btn-collape-process>.glyph-icon").removeClass('icon-angle-up');
    $(".card .btn-collape-process>.glyph-icon").addClass('icon-angle-down');



    <?php
  }else{

    for ($i=0; $i<count($case_processInit_idx); $i++) {
      if($case_processInit_idx[$i]["process_status"]=="1"){
        /* $("#card-block-<?php echo $case_processInit_idx[$i]["process_id"] ?>").find('button').remove(); */
        ?>
        $("#card-block-<?php echo $case_processInit_idx[$i]["process_id"] ?>").find('button').prop('disabled',true);
        $("#card-block-<?php echo $case_processInit_idx[$i]["process_id"] ?>").find('input').prop('disabled',true);
        $("#card-block-<?php echo $case_processInit_idx[$i]["process_id"] ?>").find('select').prop('disabled',true);
        $("#card-block-<?php echo $case_processInit_idx[$i]["process_id"] ?>").find('textarea').prop('disabled',true);
        $("#card-block-<?php echo $case_processInit_idx[$i]["process_id"] ?>").find('.icon-add-channel').parents('a').remove();
        <?php
      }else{
        if($i>=3 && $rs_case["case"]["my_case_assign"]!=1){
           /*$("#card-block-<?php echo $case_processInit_idx[$i]["process_id"] ?>").find('button').remove();*/
          ?>
          $("#card-block-<?php echo $case_processInit_idx[$i]["process_id"] ?>").find('button').prop('disabled',true);
          $("#card-block-<?php echo $case_processInit_idx[$i]["process_id"] ?>").find('input').prop('disabled',true);
          $("#card-block-<?php echo $case_processInit_idx[$i]["process_id"] ?>").find('select').prop('disabled',true);
          $("#card-block-<?php echo $case_processInit_idx[$i]["process_id"] ?>").find('textarea').prop('disabled',true);
          $("#card-block-<?php echo $case_processInit_idx[$i]["process_id"] ?>").find('.icon-add-channel').parents('a').remove();
          <?php
        }
      }
    }
  }
  ?>

});


function selectEmpAssign(emp_id,value){
  case_detail.add_emp_assign(emp_id,function(){
    setTimeout(function(){
        $("#emp_assign_search").val('');
    },500)
  });
}

function exportCase() {
  let divId = 'page_case_detail';
  let headContent = document.getElementsByTagName('head')[0].innerHTML;
  let ycase = document.getElementById(divId).innerHTML;
  let mywindow = window.open('/backoffice/print_case_detail.php', 'PRINT', 'height=650,width=900,top=100,left=150');


  mywindow.document.write(`<html><head>`);
  mywindow.document.write(headContent);
  mywindow.document.write(`<link rel="stylesheet" type="text/css" href="css/case_detail.css">`);
  mywindow.document.write('</head><body >');
  mywindow.document.write(document.getElementById(divId).innerHTML);
  mywindow.document.write('</body></html>');

  mywindow.document.close(); // necessary for IE >= 10
  mywindow.focus(); // necessary for IE >= 10*/

  setTimeout(function(){
    mywindow.print();
  }, 1500); 
  
  // mywindow.close();

  return true;
}


</script>
