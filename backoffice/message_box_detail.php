<form class="form-horizontal form-msg form-msg-detail" name="frm_msg_create" enctype="multipart/form-data" method="post" action="function.php?method=create_msg" target="iframe-data">
  <div class="row">
    <div class="col-md-12">
      <div id="page-title">
        <span class="col-sm-12 icon-title-text">
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
            <span>Case ID <?php echo sprintf("%05d",$rs_msg["msg"]["case_id"]) ?> -  <?php echo $rs_msg["msg"]["caseDtl_title"] ?></span>
        </h3>
      </div>
    </div>
    <div class="row">

      <ul class="chat-box chat-box-msg">
        <li class="no-gutter">
          <div class="col-sm-2 col-md-2 col-lg-1" style="text-align:center">
            <div class="status-badge border-user-img">
              <?php
                if(count(glob($rs_msg["msg"]["img_sender"]))==0 || $rs_msg["msg"]["img_sender"] == '') {
                  ?>
                  <img src="setting/img/profile_emp-01.svg" alt="">
                  <?php
                }else{
                  ?>
                  <img src="<?php echo $rs_msg["msg"]["img_sender"]; ?>" alt="<?php echo $rs_msg["msg"]["img_sender"]; ?>"  style="<?php echo $noti_cls->getPositionImage($rs_msg["msg"]["img_sender"],50) ?>">
                  <?php
                }
                ?>
            </div>
          </div>
          <div class="col-sm-10 col-md-10 col-lg-11">
            <div class="col-xs-12 col-txt-sender" style="padding:0px;">
              <p>
                <?php echo $rs_msg["msg"]["msgBox_sender"] ?>
              </p>
            </div>
            <div class="col-xs-12 col-txt-datetime" style="padding:0px;">
              <p class="text_small txt-datetime">
                <i class="ditp-icon  icon-ico-ditp-11"></i> <?php echo date('d/m/Y',strtotime($rs_msg["msg"]["msgBox_datetime"])) ?>
              </p>
                <p class="text_small txt-datetime">
                <i class="ditp-icon  icon-ico-ditp-33"></i> <?php echo date('H:i',strtotime($rs_msg["msg"]["msgBox_datetime"])) ?>
              </p>
            </div>
          </div>
          <div class="col-xs-12" style="margin-top:10px;">
            <div class="form-group col-xs-12 body-message" style="margin-bottom:0px;">
              <?php echo $rs_msg["msg"]["msgBox_message"] ?>
            </div>
          </div>
          <?php
          foreach ($rs_msg["msg_Attachfile"] as $msg_Attachfile) {
            ?>
            <div class="col-xs-12">
            <a href="view_file_attach.php?fileadrss_msg=<?php echo $msg_Attachfile["msgBoxAttach_id"] ?>" target="_blank">
              <div class="panel-body panel-body-list-file" style="padding: 0 20px; margin-bottom:10px;">
                <ul class="list-file col-sm-12">
                   <li class="no-gutter" style="padding: 0px;">
                     <div class="col-xs-12 col-sm-1">
                       <i class="glyph-icon icon-<?php echo $noti_cls->genfileIcon($msg_Attachfile["msgBoxAttach_file_ext"]) ?>-o icon-thumb-file"></i>
                     </div>
                     <div class="col-xs-12 col-sm-7 list_file_name">
                       <p><?php echo $msg_Attachfile["msgBoxAttach_title"] ?></p>
                       <p style="color:#b3b3b3;"><?php echo $msg_Attachfile["msgBoxAttach_file_oldname"] ?></p>
                     </div>
                     <div class="col-xs-12 col-sm-4">
                       <p>Date : <?php echo date("d/mY",strtotime($msg_Attachfile["msgBoxAttach_create_datetime"])) ?></p>
                       <p class="text_small">Sender : <?php echo $rs_msg["msg"]["msgBox_sender"] ?></p>
                     </div>
                   </li>
                 </ul>
               </div>
            </a>
          </div>
            <?php
          }
          ?>
        </li>
      </ul>



      <ul class="chat-box chat-box-msg chat-box-msg-reply">
      <?php
      foreach ($rs_msg["msg_reply"] as $rs_msg_reply) {
        ?>
          <li class="no-gutter">
            <div class="col-sm-2 col-md-2 col-lg-1" style="text-align:center">
              <div class="status-badge border-user-img">
                <?php
                  if(count(glob($rs_msg_reply["img_sender"]))==0 || $rs_msg_reply["img_sender"] == '') {
                    ?>
                    <img src="setting/img/profile_emp-01.svg" alt="">
                    <?php
                  }else{
                    ?>
                    <img src="<?php echo $rs_msg_reply["img_sender"] ?>" alt="<?php echo $rs_msg_reply["img_sender"] ?>" style="<?php echo $noti_cls->getPositionImage($rs_msg_reply["img_sender"],50) ?>">
                    <?php
                  }
                  ?>
              </div>
            </div>
            <div class="col-sm-10 col-md-10 col-lg-11">
              <div class="col-xs-12 col-txt-sender" style="padding:0px;">
                <p>
                  <?php echo $rs_msg_reply["msgBox_sender"] ?>
                </p>
              </div>
              <div class="col-xs-12 col-txt-datetime" style="padding:0px;">
                <p class="text_small txt-datetime">
                  <i class="ditp-icon  icon-ico-ditp-11"></i> <?php echo date('d/m/Y',strtotime($rs_msg_reply["msgBox_datetime"])) ?>
                </p>
                  <p class="text_small txt-datetime">
                  <i class="ditp-icon  icon-ico-ditp-33"></i> <?php echo date('H:i',strtotime($rs_msg_reply["msgBox_datetime"])) ?>
                </p>
              </div>
            </div>
            <div class="col-xs-12" style="margin-top:10px;">
              <div class="form-group col-xs-12 body-message" style="margin-bottom:0px;">
                <?php echo $rs_msg_reply["msgBox_message"] ?>
              </div>
            </div>
            <?php
            foreach ($rs_msg_reply["msg_Attachfile"] as $msg_Attachfile_ref) {
              ?>
              <div class="col-xs-12">
                <a href="view_file_attach.php?fileadrss_msg=<?php echo $msg_Attachfile_ref["msgBoxAttach_id"] ?>" target="_blank">
                  <div class="panel-body panel-body-list-file" style="padding: 0 20px; margin-bottom:10px;">
                    <ul class="list-file col-sm-12">
                       <li class="no-gutter" style="padding: 0px;">
                         <div class="col-xs-12 col-sm-1">
                           <i class="glyph-icon icon-<?php echo $noti_cls->genfileIcon($msg_Attachfile_ref["msgBoxAttach_file_ext"]) ?>-o icon-thumb-file"></i>
                         </div>
                         <div class="col-xs-12 col-sm-7 list_file_name">
                           <p><?php echo $msg_Attachfile_ref["msgBoxAttach_title"] ?></p>
                           <p style="color:#b3b3b3;"><?php echo $msg_Attachfile_ref["msgBoxAttach_file_oldname"] ?></p>
                         </div>
                         <div class="col-xs-12 col-sm-4">
                           <p>Date : <?php echo date("d/mY",strtotime($msg_Attachfile_ref["msgBoxAttach_create_datetime"])) ?></p>
                           <p class="text_small">Sender : <?php echo $rs_msg_reply["msgBox_sender"] ?></p>
                         </div>
                       </li>
                     </ul>
                   </div>
                </a>
              </div>
              <?php
            }

            ?>
          </li>
          <?php
          }
          ?>
      </ul>

    </div>

    <div class="row" style="margin-top:20px;">
      <div class="form-group col-xs-12">
        <label class="col-sm-12 control-label" style="color:#048f78;">ตอบกลับ</label>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <input type="hidden" name="msgId" value="<?php echo $_GET["msgId"] ?>" />
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
                <input type="file" class="caseAttach_file" name="caseAttach_file[]" multiple  accept="<?php echo join(",",$caseLst_cls->file_accept) ?>">
              </span>
           </div>
        </div>
        <div class="col-sm-12">
          <label class="control-label text-data-light text-data-gray" style="opacity:0.5;">* สามารถเลือกไฟล์ได้ ไม่เกินครั้งละ 5 ไฟล์ และขนาดต้องไม่เกิน 10 MB ต่อไฟล์</label>
        </div>
      </div>
    </div>

    <input type="hidden" name="msg_to" value="<?php echo $rs_msg["msg"]["case_id"] ?>" />
    <input type="hidden" name="msgBox_id" value="<?php echo $rs_msg["msg"]["msgBox_id"] ?>" />
    <input type="hidden" name="msgBox_type" value="2" />
    <div class="row">
      <div class="form-group col-xs-12 div-text-center" style=" padding-top:30px;">
        <button type="submit" class="btn btn-custom-tool btn-warning btn-learn" >
          ส่งข้อความ
        </button>
      </div>
    </div>
  </div>

</form>



<script>
  setTimeout(function(){
      auto_resize_menu();
  },500);
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

          if(file_attach[i].size>1048576){
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
