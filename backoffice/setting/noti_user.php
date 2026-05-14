<?php

    $sql_select = "SELECT  * FROM Setting_Info where settingInfo_id = '1' ";
    $query_select = $conn->query($sql_select);
    $array_row = array();

      while($result_select = $query_select->fetch_assoc())
      {
         $normal_period = $result_select['normal_period'];
         $normal_alert_period = $result_select['normal_alert_period'];
         $overdueMain_alert_period = $result_select['overdueMain_alert_period'];
         $overdueSub_alert_period = $result_select['overdueSub_alert_period'];
         $recivedCase_from_app = $result_select['recivedCase_from_app'];
         $recivedMsg_from_app = $result_select['recivedMsg_from_app'];
         $assign_status = $result_select['assign_status'];
         $overdueMain_alert_img_path = $result_select['overdueMain_alert_img_path'];
         $overdueSub_alert_img_path = $result_select['overdueSub_alert_img_path'];
      }

 ?>


<div class="">
  <div class="title_color">
    <span class="title_icon ditp-icon icon-ico-ditp-05"></span>
    ตั้งค่าการแจ้งเตือน
  </div>
</div>
<div class="box_appeal  box_appeal_noti_user">
  <div class="row row_title">
    <div class="col-md-12 col-xs-12 box_appeal_title">
      แจ้งเตือนผู้ใช้งานระบบ
    </div>
  </div>
<form method="POST" action="method.php?method=edit_noti"  enctype="multipart/form-data" target="iframe-data"  >
  <div class="row row_title no-margin-padding">
    <div class="col-md-12 col-xs-12 no-margin-padding noti_span">
      <div class="col-md-8 col-xs-12">
        พรบ. ข้อมูลข่าวสารของข้าราชการ
      </div>
      <?php
        if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"manager_noti")[2]==1){
      ?>
      <div class="col-md-4 btn_rigt">
        <button class="btn_save btn" type="submit" name="button">บันทึก</button>
        <button class="btn_can btn" type="button" name="button" onClick="window.location.reload()">ยกเลิก</button>
      </div>
      <?php } ?>
    </div>
  </div>
  <div class="row form-group txt_noti">
    <div class="col-md-4">
      <label class="lbl_txt_noti">กำหนดระยะเวลา<?=$rematk?></label>
    </div>
    <div class="col-md-6">
      <div class="div_input">
        <input type="hidden" name="ty_check" value="3">
        <input type="text" name="normal_period" value="<?=$normal_period?>"  class="form-control input_box input_day" onkeyup="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลขเท่านั้น'); this.value='';}">
      </div>
      <div class="div_input1">
          วัน
      </div>
    </div>
  </div>

  <div class="row form-group txt_noti">
    <div class="col-md-4">
    <label class="lbl_txt_noti">แจ้งเตือนล่วงหน้าก่อนถึงเวลา<?=$rematk?></label>
    </div>
    <div class="col-md-6">
      <div class="div_input">
        <input type="text" name="normal_alert_period" value="<?=$normal_alert_period?>"  class="form-control input_box input_day" onkeyup="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลขเท่านั้น'); this.value='';}">
      </div>
      <div class="div_input1">
          วัน
      </div>
    </div>
  </div>
</form>

<form method="POST" action="method.php?method=edit_noti"  enctype="multipart/form-data" target="iframe-data"  >
  <div class="row row_title no-margin-padding">
    <div class="col-md-12 col-xs-12 no-margin-padding noti_span">
      <div class="col-md-8 col-xs-12">
        Overdue
      </div>
      <!-- <div class="btn_rigt">Overdue กระบวนการหลัก</div> -->
      <?php
        if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"manager_noti")[2]==1){
      ?>
      <div class="col-md-4 col-xs-12   btn_rigt">
        <button class="btn_save btn" type="submit" name="button">บันทึก</button>
        <button class="btn_can btn" type="button" name="button" onClick="window.location.reload()">ยกเลิก</button>
        </div>
        <?php } ?>
    </div>
  </div>
  <!-- <div class="btn_rigt">Overdue กระบวนการย่อย</div> -->
  <div class="row form-group txt_noti lbl_txt_noti_title">Main Overdue</div>
  <div class="row form-group txt_noti">
    <div class="col-md-4">
      <label class="lbl_txt_noti">กำหนดระยะเวลาแจ้งเตือนล่วงหน้าก่อนถึงเวลา<?=$rematk?></label>
    </div>
    <div class="col-md-6">
      <div class="div_input" >
        <input type="hidden" name="ty_check" value="4">
        <input type="text" name="overdueMain_alert_period" value="<?=$overdueMain_alert_period?>"  class="form-control input_box input_day">
      </div>
      <div class="div_input1">
          วัน
      </div>
    </div>
  </div>
  <div class="row form-group txt_noti">
    <div class="col-md-4">
      <label class="lbl_txt_noti">สัญลักษณ์<?=$rematk?></label>
    </div>
    <div class="col-md-6">
      <div class="div_input img_noti img_padd" >
        <!-- <i class=" img_padd i_padd" style="background-image: url(<?=$overdueMain_alert_img_path?>);" aria-hidden="true"></i> -->
        <span class="positions_box">
        <img src="../../<?=$overdueMain_alert_img_path?>" alt="Smiley face" height="25" width="25">
        </span>
        <!-- <i class="fa fa-exclamation img_padd i_padd" aria-hidden="true"></i> -->


      </div>
      <?php
        if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"manager_noti")[2]==1){
      ?>
      <div class="div_input1 lbl_txt_noti_title img_noti_btn cursor">
        <i class="fa icon-ico-ditp-10 txt_no_edit i_padd txt_lb" aria-hidden="true" onclick="edit_img_1(1);" ></i>
        <!-- <i class="fa txt_no_edit i_padd txt_lb" aria-hidden="true" onclick="edit_img_1(1);"></i> -->
      </div>
      <?php } ?>

      <div class="div_input1 lbl_txt_noti_title">
          *เลือกรูปขนาด (100 x 100 pixels) (.png , .gif , .jpg)
      </div>
    </div>
  </div>

  <div class="row form-group txt_noti lbl_txt_noti_title">Sub Overdue</div>
  <div class="row form-group txt_noti">
    <div class="col-md-4">
      <label class="lbl_txt_noti">กำหนดระยะเวลาแจ้งเตือนล่วงหน้าก่อนถึงเวลา<?=$rematk?></label>
    </div>
    <div class="col-md-6">
      <div class="div_input">
        <input type="text" name="overdueSub_alert_period" value="<?=$overdueSub_alert_period?>"  class="form-control input_box input_day">
      </div>
      <div class="div_input1">
          วัน
      </div>
    </div>
  </div>
  <div class="row form-group txt_noti">
    <div class="col-md-4">
      <label class="lbl_txt_noti">สัญลักษณ์<?=$rematk?></label>
    </div>
    <div class="col-md-6">
      <div class="div_input img_noti img_padd" >
        <span class="positions_box">
        <!-- <i class="fa fa-exclamation-triangle i_padd" aria-hidden="true"></i> -->
        <img src="../../<?=$overdueSub_alert_img_path?>" alt="Smiley face" height="25" width="25">
      </span>
      </div>
      <?php
        if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"manager_noti")[2]==1){
      ?>
      <div class="div_input1 lbl_txt_noti_title img_noti_btn cursor">
        <i class="fa icon-ico-ditp-10 txt_no_edit i_padd txt_lb"  onclick="edit_img_1(2);"  aria-hidden="true"></i>
      </div>
      <?php } ?>
      <div class="div_input1 lbl_txt_noti_title">
          *เลือกรูปขนาด (100 x 100 pixels) (.png , .gif , .jpg)
      </div>
    </div>
  </div>
</form>

<form method="POST" action="method.php?method=edit_noti" style="display: none;"   enctype="multipart/form-data" target="iframe-data"  >
  <div class="row row_title no-margin-padding">
    <div class="col-md-12  col-xs-12 no-margin-padding noti_span">
      <div class="col-md-8 col-xs-12">
        การแจ้งเตือนอื่นๆ
      </div>
      <?php
        if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"manager_noti")[2]==1){
      ?>
      <div class="col-md-4 btn_rigt">
        <button class="btn_save btn" type="submit" name="button">บันทึก</button>
        <button class="btn_can btn" type="button" name="button" onClick="window.location.reload()">ยกเลิก</button>
      </div>
      <?php } ?>
    </div>
  </div>

  <div class="row form-group txt_noti">
    <div class="col-md-4">
      <label class="lbl_txt_noti">การรับเรื่องร้องเรียนจาก application</label>
    </div>
    <div class="col-md-6">
      <input type="hidden" name="ty_check" value="5">
      <select class="selectpicker" data-width="100px" name="recivedCase_from_app">
        <option value="1" <?php if($recivedCase_from_app==1){ echo "selected";} ?>>เปิด</option>
        <option value="0" <?php if($recivedCase_from_app==0){ echo "selected";} ?>>ปิด</option>
      </select>
    </div>
  </div>

  <div class="row form-group txt_noti">
    <div class="col-md-4">
      <label class="lbl_txt_noti">ข้อความจาก application</label>
    </div>
    <div class="col-md-6">
      <select class="selectpicker" data-width="100px" name="recivedMsg_from_app">
        <option value="1" <?php if($recivedMsg_from_app==1){ echo "selected";} ?>>เปิด</option>
        <option value="0" <?php if($recivedMsg_from_app==0){ echo "selected";} ?>>ปิด</option>
      </select>
    </div>
  </div>

  <div class="row form-group txt_noti">
    <div class="col-md-4">
      <label class="lbl_txt_noti">การ Assign</label>
    </div>
    <div class="col-md-6">
      <select class="selectpicker" data-width="100px" name="assign_status">
        <option value="1" <?php if($assign_status==1){ echo "selected";} ?>>เปิด</option>
        <option value="0" <?php if($assign_status==0){ echo "selected";} ?>>ปิด</option>
      </select>
    </div>
  </div>
</div>
</form>
<form method="POST" action="method.php?method=add_img_noti" id="edit_img_from"  enctype="multipart/form-data" target="iframe-data"  >
    <input type="file" id="edit_img_1" name="add_pic_user" style="display: none" onChange="edit_changfile_1();" accept="image/x-png, image/gif, image/jpg"/>
    <input type="hidden" id="filename_edit" readonly="true" class="form-control add-image-text name_brow" />
    <input type="hidden" name="type_over" value="" id="type_over" class="type_over">
</form>
<script>
function edit_img_1(id_type)
{
  $('.type_over').val(id_type);
  var fileinput = document.getElementById("edit_img_1");
  fileinput.click();
}

function edit_changfile_1()
{
  var fileinput = document.getElementById("edit_img_1");
  var textinput = document.getElementById("filename_edit");
  textinput.value = fileinput.value;
  document.getElementById("edit_img_from").submit();
}


$(document).ready(function() {
     $('.table-caseCh-list').on('load-success.bs.table', function (e) {
     });
     $("input[name='search_prod_type']").change(function() {
       /* Act on the event */
     });
        $("input[name='search_text']").keypress(function(e) {
          if(e.which == 13) {
            $('.table-caseCh-list').bootstrapTable('refresh');
          }
        });

 });
 function searchQueryParams(params) {
   params.text = $("input[name='search_text']").val();
   if($('.search_date').prop("disabled")==false){
     params.date = $('.search_date').val();
   }
   return params; // body data
 }


</script>
