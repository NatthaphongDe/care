<form class="form-horizontal form-msg form-msg-detail" name="frm_msg_create" enctype="multipart/form-data" method="post" action="function.php?method=create_msg" target="iframe-data">
  <div class="row">
    <div class="col-xs-12">
      <div id="page-title">
        <span class="col-xs-12 icon-title-text">
          <i class="ditp-icon icon-ico-ditp-07" aria-hidden="true"></i>
          กล่องข้อความ
        </span>
      </div>
    </div>
  </div>

  <div class="panel" style="margin-top:10px;">
    <div class="row">
      <div class="col-xs-12">
        <h3 class="title-hero col-xs-12">
            <span>สร้างข้อความใหม่</span>
        </h3>
        <div class="col-xs-12 col-txt-datetime">
          <p class="text_small txt-datetime">
            <i class="ditp-icon  icon-ico-ditp-11"></i> <?php echo date('d/m/Y') ?>
          </p>
            <p class="text_small txt-datetime">
            <i class="ditp-icon  icon-ico-ditp-33"></i> <?php echo date('H:i') ?>
          </p>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <div class="form-group col-xs-12 input-group input-group-msg">
            <span class="input-group-btn">
                <button class="btn btn-default btn-to" type="button">ถึง : </button>
            </span>
            <select value="" class="form-control select-picker select-picker-msg" name="msg_to" data-live-search="true">
              <?php echo $noti_cls->getCaseList_msg() ?>
            </select>


            <input type="hidden" name="case_id" />
        </div>
        <div class="form-group col-xs-12">
          <textarea name="msg_message" rows="3" class="form-control textarea-no-resize"></textarea>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="form-group col-xs-12">
        <label class="col-sm-12 control-label" style="color:#048f78;">เอกสารแนบ</label>
        <div class="col-sm-12 col-file-list panel_caseAttach_file">

        </div>
        <div class="col-sm-4">
          <input type="hidden" name="removeFileAttachNewId" class="removeFileAttachNewId" value="" />

          <div class="fileinput fileinput-new input-group" data-provides="fileinput">
              <div class="form-control" data-trigger="fileinput">
                  <i class="glyphicon glyphicon-file fileinput-exists"></i>
                  <span class="fileinput-filename"></span>
              </div>
              <span class="input-group-addon btn btn-default btn-file">
                <span class="fileinput-new">Browse</span>
                <span class="fileinput-exists">Change</span>
                <input type="file" class="caseAttach_file" name="caseAttach_file[]" multiple  accept="<?php echo join(",",$caseOpn_cls->file_accept) ?>">
              </span>
           </div>
        </div>
        <div class="col-sm-12">
          <label class="control-label text-data-light text-data-gray" style="opacity:0.5;">* สามารถเลือกไฟล์ได้ ไม่เกินครั้งละ 5 ไฟล์ และขนาดต้องไม่เกิน 10 MB ต่อไฟล์</label>
        </div>
      </div>
    </div>

    <input type="hidden" name="msgBox_type" value="1" />
    <div class="row">
      <div class="form-group col-xs-12 div-text-center" style=" padding-top:30px;">
        <button type="submit" class="btn btn-custom-tool btn-warning btn-learn" >
          ส่งข้อความ
        </button>
      </div>
    </div>
  </div>

</form>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="assets/bootstrap-table/dist/bootstrap-table.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="assets/bootstrap-table/dist/bootstrap-table.min.js"></script>
<!-- Latest compiled and minified Locales -->
<script src="assets/bootstrap-table/dist/locale/bootstrap-table-th-TH.min.js"></script>

<script>
  function searchQueryParams(params) {

    return params; // body data
  }
  $(document).ready(function(){
    $('.select-picker').selectpicker();
  });
  $(function(){
    // Multiple images preview in browser
    var filePreview = function(input,file_name,callback) {
        if (input) {

                var reader = new FileReader();

                reader.onload = function(event) {
                  var file_tmp = event.target.result;
                  if(typeof callback === "function"){
                    callback(file_tmp,file_name);
                  }
                }

                reader.readAsDataURL(input);
        }
    };

    //ส่วนอัพโหลดเอกสารประกอบการร้องเรียน
    $(".caseAttach_file").bind("click",function(event){
      <?php
      if($_GET["method"]=="createcase"){
       ?>
        $(".panel_caseAttach_file .caseAttach_file").remove();
        <?php
      }else{
        ?>
         $(".panel_caseAttach_file .caseAttach_file_new").remove();
         <?php

      }
      ?>
    });

    $(".caseAttach_file").bind("change",function(event){
      var file_attach = $(this)[0].files;

      <?php
      if($_GET["method"]=="createcase"){
       ?>
        $(".panel_caseAttach_file .caseAttach_file").remove();
        <?php
      }else{
        ?>
         $(".panel_caseAttach_file .caseAttach_file_new").remove();
         <?php

      }
      ?>
      $(this).parents(".fileinput").find(".fileinput-filename").text('');


      var count_file = $(".panel-body-list-file").length;

      if(file_attach.length<=5){
        var file_attach_length = file_attach.length;

        var idx = 0;
        <?php
        if($_GET["method"]=="createcase"){
         ?>
         $(".panel-body-list-file").remove();
          <?php
        }
        ?>
        var alert_num = 0;
        var file_name_alert  = new Array();
        for (i=0; i < file_attach_length; i++) {
          if(i>0){
            var file_name_only = file_attach[i].name;
            var file_name = ", "+file_attach[i].name;
          }else{
            var file_name_only = file_attach[i].name;
            var file_name = file_attach[i].name;
          }

          if(file_attach[i].size>10485760){
              file_name_alert.push(file_attach[i].name);
              alert_num++;
          }

          $(this).parents(".fileinput").find(".fileinput-filename").append(file_name);

          <?php
            $name_sender = "";
          ?>


          var file_view = filePreview(this.files[i],file_name_only,function(filePreviewTmp,filename){
            if(idx<5){
              var elm_panel_id = "caseAttach_file_new_"+idx;
              var elm_panel = "caseAttach_file_new";
              var gen_html = '<div class="panel '+elm_panel+'" id="'+elm_panel_id+'" >\
                              <div class="panel-body panel-body-list-file">\
                                  <ul class="list-file col-sm-12">\
                                  <li class="no-gutter">\
                                    <div class="col-xs-12 col-sm-1">\
                                      <i class="glyph-icon icon-file-o icon-thumb-file"></i>\
                                    </div>\
                                    <div class="col-xs-12 col-sm-6 list_file_name" style="padding-right:10px;">\
                                      <input type="text" name="caseAttach_file_name['+idx+']" class="form-control" placeholder="กรุณาระบุหัวข้อของไฟล์แนบ" required />\
                                      <p>'+filename+'</p>\
                                      <input type="hidden" name="caseAttach_file_id['+idx+']" />\
                                      <input type="hidden" name="filePreview" id="filePreview'+idx+'" value="'+filePreviewTmp+'" />\
                                      <input type="hidden" name="new_fileadrss" id="new_fileadrss'+idx+'" value="'+filename+'" />\
                                    </div>\
                                    <div class="col-xs-12 col-sm-3">\
                                      <p>Date : <?php echo date('d/m/Y') ?></p>\
                                      <p class="text_small">Sender : <?php echo $res_emp["emp_firstname"] ?>  <?php echo $res_emp["emp_lastname"] ?></p>\
                                    </div>\
                                    <div class="col-xs-12 col-sm-2 col-btn-file">\
                                      <button type="button" class="btn btn-round btn-bg22 btn-edit-file previewFileAttach" >\
                                        <a href="'+filePreviewTmp+'" download>\
                                          <i class="my-icon icon-ico-ditp-22"></i>\
                                        </a>\
                                      </button>\
                                      <button type="button" class="btn btn-round btn-danger btn-del-file" onclick="case_open.remove_file_new(\''+elm_panel_id+'\',\''+idx+'\');">\
                                        <i class="my-icon icon-ico-ditp-28"></i>\
                                      </button>\
                                    </div>\
                                  </li>\
                                  </ul>\
                              </div>\
                          </div>';
                $(".panel_caseAttach_file").append(gen_html);
            }
            idx++;

          });

        }
        if(alert_num>0){
          iziToast_func.alert("ขออภัย...ไฟล์เอกสาร "+file_name_alert.join(" , ")+" มีขนาดใหญ่เกินไป กรุณาอัพโหลดไฟล์เอกสารขนาดไม่เกิน 10 MB !",function(){
            $(".caseAttach_file").val('');
            $(".fileinput-filename").text('');
            $(".caseAttach_file_new").remove();
          });
        }
        setTimeout(function(){
          auto_resize_menu();
        },500);
    }else{
      var file_attach_length = 5;
      iziToast_func.alert("ขออภัย...ท่านสามารถเลือกไฟล์ได้ ไม่เกินครั้งละ 5 ไฟล์ และขนาดต้องไม่เกิน 10 MB ต่อไฟล์");
      event.preventDefault();
    }
    });
    $(document).delegate(".previewFileAttach","click",function(){
      $(".frm_msg_create").attr("target","_blank");
      $(".frm_msg_create").attr("action","view_file_attach.php");
      $(".frm_msg_create").submit();
      $(".frm_msg_create").attr("target","iframe-data");
      $(".frm_msg_create").attr("action","function.php?method=<?php echo $type_method ?>");

    });

    if($(".checkbox-company").prop("checked")==true){
        $(".checkbox-company").parents('.panel-body-bg2').find('input').prop('disabled',false);
        $(".checkbox-company").parents('.panel-body-bg2').find('button').prop('disabled',false);
        $(".checkbox-company").parents('.panel-body-bg2').find('select').prop('disabled',false);
        $(".checkbox-company").parents('.panel-body-bg2').find('textarea').prop('disabled',false);
        $(".checkbox-company").prop('disabled',false);
        $(".checkbox-company").parents(".form-group-inner").show();
    }else{
        $(".checkbox-company").parents('.panel-body-bg2').find('input').prop('disabled',true);
        $(".checkbox-company").parents('.panel-body-bg2').find('button').prop('disabled',true);
        $(".checkbox-company").parents('.panel-body-bg2').find('select').prop('disabled',true);
        $(".checkbox-company").parents('.panel-body-bg2').find('textarea').prop('disabled',true);
        $(".checkbox-company").prop('disabled',false);
        $(".checkbox-company").parents(".panel-body-bg2").find(".form-group-inner").hide();
    }
});

</script>
