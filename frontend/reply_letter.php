<div class="row appeal_div_row">
  <div class="col-md-12">
    <span class="icon_hr_letter"><img src="images/icon_letter_black.png" class="icon_appeal"></span>
    <span class="txt_hr_letter_title"><?=$txt_Message?></span>
  </div>
</div>
<?php
$sql = "SELECT
c.case_id,
c.caseDtl_title,
em.emp_firstname,
em.emp_lastname,
mb.msgBox_message,
mb.msgBox_id,
mb.sender_type,
mb.sender_id,
m.member_fname,
m.member_lname,
mb.msgBoxRef_id,
mb.msgBox_datetime
FROM `Case` AS c
LEFT JOIN `Message_Box` AS mb ON c.case_id = mb.case_id
LEFT JOIN `Employee` AS em ON mb.sender_id = em.emp_id
LEFT JOIN `Member` AS m ON mb.sender_id = m.member_id
WHERE mb.msgBox_id = '".$_GET['msgBox_id']."' OR mb.msgBoxRef_id = '".$_GET['msgBox_id']."'";
$query = $conn->query($sql);
$re = $query->fetch_assoc();
$case = sprintf("%05s",$re['case_id']);
?>
<iframe name="reply_msg" style="display:none;"></iframe>
<form method="post" id="reply_letter_form" action="function_php/function_index.php?method=reply_letter&case_id=<?=$re['case_id']?>" enctype="multipart/form-data" target="reply_msg">
  <input type="hidden" name="msgBox_id" value="<?=$_GET['msgBox_id'];?>">
    <div class="panel panel-default appeal_panel">
      <div class="panel-body">
        <span class="case_reply_letter">Case ID :</span>
        <span class="case_id_reply_letter"><?=$case?></span>
        <span class="case_comment_reply_letter"><?php echo $re['caseDtl_title'];?></span>
      </div>
    </div>
    <?php
    $sql_bm = "SELECT
    c.case_id,
    c.caseDtl_title,
    em.emp_firstname,
    em.emp_lastname,
    em.emp_img_path_s,
    mb.msgBox_message,
    mb.msgBox_id,
    mb.sender_type,
    mb.sender_id,
    m.member_fname,
    m.member_lname,
    m.member_img,
    m.member_type,
    mb.msgBoxRef_id,
    mb.msgBox_datetime,
    mc.member_comp_id,
    mc.member_comp_img,
    mc.member_comp_name
    FROM `Case` AS c
    LEFT JOIN `Message_Box` AS mb ON c.case_id = mb.case_id
    LEFT JOIN `Employee` AS em ON mb.sender_id = em.emp_id
    LEFT JOIN `Member` AS m ON mb.sender_id = m.member_id
    LEFT JOIN `Member_comp` AS mc ON m.member_id = mc.member_id
    WHERE mb.msgBox_id = '".$_GET['msgBox_id']."' OR mb.msgBoxRef_id = '".$_GET['msgBox_id']."' ORDER BY mb.msgBox_id";
    $query_bm = $conn->query($sql_bm);
      while ($rs = $query_bm->fetch_assoc()) {
        $date_time = $rs['msgBox_datetime'];
        $date_time_ex = explode(" ",$date_time);
        $date_waitting = $date_time_ex[0];
        $time_waitting = $date_time_ex[1];
        $date_ex = explode("-",$date_waitting);
        $time_ex = explode(":",$time_waitting);
        $date = $date_ex[2]."/".$date_ex[1]."/".$date_ex[0];
        $time = $time_ex[0].".".$time_ex[1];
        if($rs['sender_id'] == $_SESSION['member_id'] && $rs['sender_type'] == 1){
          $sty = "background-color: #f5f5f5;";
        }else {
          $sty = "background-color: #fff;";
        }
        $rs['emp_img_path_s'] = "../backoffice/".$rs['emp_img_path_s'];
        ?>
    <div class="panel panel-default appeal_panel" style="<?=$sty;?>">
      <div class="panel-body">
        <div class="row div_name_letter">
          <?php if($rs['sender_id'] == $_SESSION['member_id'] && $rs['sender_type'] == 1){ ?>
            <div class="col-md-1">
            <?php if($rs['member_type'] == 0){
              $path = "../data/img_member/".$_SESSION['member_id']."/".$rs['member_img'];
              if(file_exists($path)) {
                $path_img = "../../data/img_member/".$_SESSION['member_id']."/".$rs['member_img'];
              }else {
                $path_img = "images/profile_emp-01.svg";
              }
              ?>
              <img src="<?=$path_img?>" class="img_msg">
            <?php }else {
              $path = "../data/img_membercom/".$rs['member_comp_id']."/".$rs['member_comp_img'];
              if(file_exists($path)) {
                $path_img = "../../data/img_membercom/".$rs['member_comp_id']."/".$rs['member_comp_img'];
              }else {
                $path_img = "images/profile_emp-01.svg";
              }
              ?>
              <img src="<?=$path_img?>" class="img_msg">
            <?php }?>
          </div>

          <div class="col-md-11">
            <?php if($rs['member_type'] == 0){ ?>
            <span class="txt_to_letter"><?=$rs['member_fname'];?>&nbsp;&nbsp;<?=$rs['member_lname'];?></span>
            <?php }else { ?>
            <span class="txt_to_letter"><?=$rs['member_comp_name'];?></span>
            <?php }?>
            <div class="div_date_letter">
              <span class="date_letter"><img src="images/icon_date.png"></span><span class="letter_date"><?=$date?></span>
              <span class="time_letter"><img src="images/icon_time.png"></span><span class="letter_time"><?=$time?></span>
            </div>
          </div>

          <?php }else {
            $pathfile_emp = $rs['emp_img_path_s'];
            $date_file = explode("backoffice",$pathfile_emp);
            if(file_exists("..".$date_file[1])) {
              $pathfile_emp_img = $date_file[1];
            }else {
              $pathfile_emp_img = "images/profile_emp-01.svg";
            }
            ?>
            <div class="col-md-1">
              <img src="<?=$pathfile_emp_img;?>" class="img_msg">
            </div>
            <div class="col-md-11">
              <span class="txt_to_letter"><?php echo $rs['emp_firstname'];?>&nbsp;&nbsp;<?php echo $rs['emp_lastname'];?></span>
              <div class="div_date_letter">
                <span class="date_letter"><img src="images/icon_date.png"></span><span class="letter_date"><?=$date?></span>
                <span class="time_letter"><img src="images/icon_time.png"></span><span class="letter_time"><?=$time?></span>
              </div>
            </div>

          <?php
            }?>
        </div>
        <hr class="hr_letter">
        <div class="name_replyletter">
        <span class="hr_name_reply_letter"><?php echo $rs['msgBox_message'];?></span>
        </div>
        <?php
        $sn = "";
        foreach (glob("../data/msg_attach/".$rs['msgBox_id']."/*.*") as $sn) {
          $sn_ex = explode("/",$sn);
          $sn_type = explode(".",$sn_ex[4]);
          ?>
          <div class="panel panel-default panel_file_detail" style="background-color:#fff;">
            <a href="<?=$sn;?>" target="_blank">
          <div class="panel-body">
            <div class="row">
              <div class="col-md-1">
                <?php if($sn_type[1] == "jpeg" || $sn_type[1] == "jpg" || $sn_type[1] == "png"){ ?>
                    <i class="fa fa-file-image-o" aria-hidden="true" style="font-size:30px;"></i>
                <?php }elseif ($sn_type[1] == "pdf") { ?>
                    <i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:30px;"></i>
                <?php }elseif ($sn_type[1] == "ppt") { ?>
                  <i class="fa fa-file-powerpoint-o" aria-hidden="true" style="font-size:30px;"></i>
                <?php }elseif ($sn_type[1] == "docx") { ?>
                    <i class="fa fa-file-word-o" aria-hidden="true" style="font-size:30px;"></i>
                <?php }elseif ($sn_type[1] == "xlsx" || $sn_type[1] == "xls") { ?>
                  <i class="fa fa-file-excel-o" aria-hidden="true" style="font-size:30px;"></i>
                <?php } ?>
        </div>
      <div class="col-md-7">
          <span><?php
          echo $sn_ex[4];
          ?>
        </span>
      </div>
      <div class="col-md-4">
        <span>Date : </span><span><?=$date?></span>
      </div>
      </div>
      </div>
    </a>
      </div>
        <?php } ?>
      </div>
    </div>
    <?php } ?>

    <div class="hr_reply_txt"><?=$txt_Replying_message?></div>
    <textarea rows="10" class="form-control txt_detail_reply" name="txt_detail_reply"></textarea>

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
                                  <p><?=$txt_Date?> : <?php echo date('d/m/Y',strtotime($case_Attachfile["caseAttach_create_datetime"]))?></p>
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
<div class="row">
<div class="btn_submit_letter">
  <button type="button" class="btn btn-warning btn_reply"><?=$txt_Reply?></button>
</div>
</div>

</form>

<script>

$(document).delegate(".btn_reply","click",function(){
  var lang = $('.language_hidden').val();
  if(lang == "2"){
    var ArlogIn = "Do you want to confirm reply to the message?";
  }else {
    var ArlogIn = "ท่านต้องการยืนยันตอบกลับข้อความหรือไม่ ?";
  }
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
        $( "#reply_letter_form" ).submit();
      }
    }
  });
});

$('.collapse_3').bind('click',function(){
var id_elm = $(this).attr('href');
if($(id_elm).hasClass('in')){
  $(this).find('span').removeClass('icon_show_detail_invite');
  $(this).find('span').addClass('icon_hide_detail_invite');
}else{
  $(this).find('span').removeClass('icon_hide_detail_invite');
  $(this).find('span').addClass('icon_show_detail_invite');
}
});
$(document).delegate(".btn_file_letter","click",function(){
  $(".file_letter_box").click();
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
                                <div class="col-xs-12 col-sm-6 list_file_name">\
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
