<div class="row appeal_div_row">
  <div class="col-md-12">
    <span class="icon_hr_letter"><img src="images/icon_letter_black.png" class="icon_appeal"></span>
    <span class="txt_hr_letter_title"><?=$txt_New_message?></span>
  </div>
</div>
<iframe name="new_msg" style="display:none;"></iframe>
<form method="post" action="function_php/function_index.php?method=new_letter" id="form_new_letter" enctype="multipart/form-data" target="new_msg">
  <div class="case_id_newletter">
    <div class="txt_case_id" id="txt_letter">
      <span class="txt_case_id_letter"><?=$txt_To?> :</span>
      <select class="form-control selectpicker sel_case" id="sel_case" name="sel_case" data-live-search="true">
        <option value=""><?=$txt_choose_topic?></option>
        <?php
        $sql = "SELECT case_id,caseDtl_title FROM `Case` WHERE case_createBy_id = '".$_SESSION['member_id']."' AND caseCh_id IN (1,2) AND case_assign_status = 1";
        $query = $conn->query($sql);
        if($query->num_rows > 0){
          while ($re = $query->fetch_assoc()) {
            $case = sprintf("%05s",$re['case_id']);?>
              <option value="<?php echo $re['case_id'];?>">Case ID <?php echo $case;?> - <?php echo $re['caseDtl_title'];?> </option>
        <?php
          }
        }
        ?>

      </select>
    </div>
 </div>
<div class="div_date_letter">
  <span class="date_letter"><img src="images/icon_date.png"></span><span class="letter_date"><?php echo date('d/m/Y',time()); ?></span>
  <span class="time_letter"><img src="images/icon_time.png"></span><span class="letter_time"><?php echo date('H:i',time()); ?></span>
  <span class="txt_to_letter">&nbsp;|&nbsp;<?=$txt_To?>&nbsp;DITP</span>
</div>
<div class="new_detail_letter">
  <span class="txt_hr_new_letter"><?=$txt_Message?></span>
  <textarea rows="10" class="form-control box_letter" name="box_letter"></textarea>
</div>
<div class="div_file_letter">
  <span class="col-md-12 txt_file_letter"><?=$txt_Attached?></span>
  <div class="row">
  <div class="col-md-12 fileinput">
  <span class="fileinput-filename" id="fileinput-filename" style="display:none;"></span>
  <input type="hidden" class="fileinput_file" name="fileinput_file">
  <input type="file" class="form-control file_letter_box" name="file_invite[]" multiple><button type="button" class="btn btn-default btn_file_letter">Browse</button>
  <div class="txt_comment_file">* <?=$txt_files_maximum?></div>
  </div>
  </div>
  <div class="row">
  <div class="col-md-12 panel_caseAttach_file">
    <?php
            $i=0;
            if(isset($_GET["method"]) && $_GET["method"]=="editcase"){
              foreach ($rs_case["case_Attachfile"] as $case_Attachfile) {
                if($rs_case["case"]["applnt_type"]!=0){
                  $name_sender = $rs_case["case_feild"]["applntOrg_name"];
                }else{
                  $name_sender = $rs_case["case_feild"]["applnt_firstname"]." ".$rs_case["case_feild"]["applnt_lastname"];
                }?>
                <div class="panel" id="panel_caseAttach_file_<?=$i?>">
                    <div class="panel-body panel-body-list-file">
                        <ul class="list-file col-sm-12">
                        <li class="no-gutter">
                            <div class="col-xs-12 col-sm-1">
                              <i class="glyph-icon icon-file-pdf-o icon-thumb-file"></i>
                            </div>
                            <div class="col-xs-12 col-sm-6 list_file_name" >
                              <input type="text" name="caseAttach_file_name[<?=$i?>]" value="<?php echo $case_Attachfile["caseAttach_title"];?>" class="form-control" placeholder="กรุณาระบุหัวข้อของไฟล์แนบ" required />
                              <input type="hidden" name="caseAttach_file_id[<?=$i?>]" value="<?php echo $case_Attachfile["caseAttach_id"];?>"  />
                              <p><?php echo $case_Attachfile["caseAttach_file_oldname"];?></p>
                            </div>
                            <div class="col-xs-12 col-sm-3">
                              <p>Date : <?php echo date('d/m/Y',strtotime($case_Attachfile["caseAttach_create_datetime"]))?></p>
                            </div>
                        </li>
                        </ul>
                    </div>
                </div>
                <?php
                  $i++;
              }
            }?>
    </div>
  </div>
</div>

<div class="row" style="margin-top:20px;">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="g-recaptcha" data-sitekey="6LdTxygUAAAAAGOY_dOU0RbVEhB0w2-ua99sG_Mr"></div>
</div>
</div>

<div class="btn_submit_letter">
  <button type="button" class="btn btn-warning btn_newletter"><?=$txt_Send_message?></button>
</div>
</form>

<script>
$(document).delegate(".btn_newletter","click",function(){
  var sel_case = $('#sel_case').val();
  var lang = $('.language_hidden').val();
  if(lang == "2"){
    var ArlogIn = "Do you want to confirm the message?";
    var ArlogIn2 = "Please choose a Complaint topic";
  }else {
    var ArlogIn = "ท่านต้องการยืนยันการส่งข้อความหรือไม่ ?";
    var ArlogIn2 = "กรุณาเลือกหัวข้อเรื่องร้องเรียน";
  }

    if(sel_case != ""){
      bootbox.confirm({
      message: ArlogIn,
      buttons: {
          confirm: {
              label: 'Yes',
              className: 'btn-success'
          },
          cancel: {
              label: 'No',
              className: 'btn-danger'
          }
      },
      callback: function (result) {
          if(result == true){
            $('#wait_process').css('display','block');
            $( "#form_new_letter" ).submit();
          }
      }
    });
    }else {
      bootbox.alert(ArlogIn2);
    }

  });

function select_case_id(){
  $('#modal_chk_case_msg').modal('show');
}


$(document).delegate(".btn_file_letter","click",function(){
  $(".file_letter_box").click();
  });
$(document).delegate(".file_letter_box","change",function(){
  $('.container_main').css('height','auto');
});
// Multiple images preview in browser
    var filePreview = function(input,file_name_only,type_file_input,callback) {
        if (input) {

            //var filesAmount = input.files.length;

            //for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();

                reader.onload = function(event) {
                  var file_tmp = event.target.result;
                  if(typeof callback === "function"){
                  callback(file_tmp,file_name_only,type_file_input);
                  }
                }

                reader.readAsDataURL(input);
            //}
        }
    };

    function del_file_invite(panel_id){
     $("#caseAttach_file_new_"+panel_id).remove();
     var h_con = $('.container_main').height();
      if(h_con < 661){
        $('.container_main').css('height','661px');
      }
    }

$( document ).ready(function() {

//ส่วนอัพโหลดเอกสารประกอบการร้องเรียน


  $(".file_letter_box").bind("click",function(event){
    $(this).val('');
  });
  $(".file_letter_box").bind("change",function(event){
    var file_attach = $(this)[0].files;

    <?php
    if($_GET["page"]=="reply_letter"){
     ?>
      $(".panel_caseAttach_file .file_letter_box").remove();
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
    }else{
      var file_attach_length = 5;
      bootbox.alert("ขออภัย...ท่านสามารถเลือกไฟล์ได้ ไม่เกินครั้งละ 5 ไฟล์ และขนาดต้องไม่เกิน 50 MB ต่อไฟล์");
    }
    var idx = 0;
    <?php
    if($_GET["page"]=="reply_letter"){
     ?>
     $(".panel .caseAttach_file_new").remove();
      <?php
    }
    ?>
    // var file_name = "";
    var alert_num = 0;
    var file_name_alert  = new Array();
    for (i=0; i < file_attach_length; i++) {
      if(i>0){
        var file_name_only = file_attach[i].name;
        var file_name = file_name+", "+file_attach[i].name;

        var file_type_only = file_attach[i].type;
        var file_type = ", "+file_attach[i].type;
      }else{
        var file_name_only = file_attach[i].name;
        var file_name = file_attach[i].name;

        var file_type_only = file_attach[i].type;
        var file_type = file_attach[i].type;
      }
      $(this).parents(".fileinput").find(".fileinput-filename").append(file_name);


      if(file_attach[i].size>10485760){
        file_name_alert.push(file_attach[i].name);
        alert_num++;
      }

var type_file = file_type_only.split('/');
var type_file_input = type_file[1];
      var file_view = filePreview(this.files[i],file_name_only,type_file_input,function(file_tmp,file_name_only_tmp,type_file_input_xr){
        if(idx<5){

          var elm_panel_id = "caseAttach_file_new_"+idx;
          var elm_panel = "caseAttach_file_new";
          var gen_html = '<div class="panel '+elm_panel+'" id="'+elm_panel_id+'" >\
                          <div class="panel-body panel-body-list-file">\
                              <ul class="list-file col-sm-12">\
                              <li class="no-gutter">\
                                <div class="col-xs-12 col-sm-1">\
                                <input type="hidden" name="type_file_xr[]" value="'+type_file_input_xr+'">';
                                if(type_file_input_xr == "pdf"){
                                gen_html +='<i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:45px;"></i>';
                                }else if (type_file_input_xr == "jpeg" || type_file_input_xr == "jpg" || type_file_input_xr == "png") {
                                  gen_html +='<i class="fa fa-file-image-o" aria-hidden="true" style="font-size:45px;"></i>';
                                }else if (type_file_input_xr == "docx") {
                                  gen_html +='<i class="fa fa-file-word-o" aria-hidden="true" style="font-size:45px;"></i>';
                                }else if (type_file_input_xr == "ppt") {
                                  gen_html +='<i class="fa fa-file-powerpoint-o" aria-hidden="true" style="font-size:45px;"></i>';
                                }else if (type_file_input_xr == "xlsx" || type_file_input_xr == "xls") {
                                  gen_html +='<i class="fa fa-file-excel-o" aria-hidden="true" style="font-size:45px;"></i>';
                                }
                                gen_html +='</div>\
                                <div class="col-xs-12 col-sm-6 list_file_name file_new_letter">\
                                  <input type="text" name="caseAttach_file_name[]" class="form-control" placeholder="กรุณาระบุหัวข้อของไฟล์แนบ" required />\
                                  <p>'+file_name_only_tmp+'</p>\
                                  <input type="hidden" name="caseAttach_file_id[]" />\
                                  <input type="hidden" name="filePreview[]" id="filePreview'+idx+'" value="'+file_tmp+'" />\
                                  <input type="hidden" name="new_fileadrss[]" id="new_fileadrss'+idx+'" value="'+file_name_only_tmp+'" />\
                                </div>\
                                <div class="col-xs-12 col-sm-3">\
                                  <p>Date : <?php echo date('d/m/Y') ?></p>\
                                </div>\
                                <div class="col-xs-12 col-sm-2 col-btn-file" style="text-align:right;">\
                                <span class="icon_del"><a onclick="del_file_invite('+idx+');"><img src="images/icon_delete.png" style="margin-top:18px;"></a></span>\
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
              bootbox.alert("ขออภัย...ไฟล์เอกสาร "+file_name_alert.join(" , ")+" มีขนาดใหญ่เกินไป กรุณาอัพโหลดไฟล์เอกสารขนาดไม่เกิน 10 MB !",function(){
                $(".fileinput_file").val('');
                $(".fileinput-filename").text('');
                $(".caseAttach_file_new").remove();
                $(".panel_caseAttach_file").remove();
              });
            }

  });

  });
</script>
