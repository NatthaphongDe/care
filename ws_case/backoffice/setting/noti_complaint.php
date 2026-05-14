<?php

    $sql_select = "SELECT  * FROM Setting_Info where settingInfo_id = '1' ";
    $query_select = $conn->query($sql_select);
    $array_row = array();

      while($result_select = $query_select->fetch_assoc())
      {
         $noti_status = $result_select['noti_status'];
         $noti_process25 = $result_select['noti_process25'];
         $noti_process50 = $result_select['noti_process50'];
         $noti_process75 = $result_select['noti_process75'];
         $noti_process100 = $result_select['noti_process100'];
         $noti_process25_en = $result_select['noti_process25_en'];
         $noti_process50_en = $result_select['noti_process50_en'];
         $noti_process75_en = $result_select['noti_process75_en'];
         $noti_process100_en = $result_select['noti_process100_en'];
         $notiMsg_status = $result_select['notiMsg_status'];

      }

 ?>
<div class="">
  <div class="title_color">
    <span class="title_icon ditp-icon icon-ico-ditp-05"></span>
    ตั้งค่าการแจ้งเตือน
  </div>
</div>
<div class="box_appeal ">
  <div class="row row_title">
    <div class="col-md-12 col-xs-12 box_appeal_title">
      แจ้งเตือนผู้ร้องเรียน
    </div>
  </div>
<form method="POST" action="method.php?method=edit_noti"  enctype="multipart/form-data" target="iframe-data"  >
  <div class="row row_title no-margin-padding">
    <div class="col-md-12  col-xs-12 no-margin-padding noti_span">
      <div class="col-md-8  col-xs-12">
        การดำเนินการแต่ละกระบวนการ
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
    <div class="col-md-3">
      <label class="lbl_txt_noti">การแจ้งเตือน</label>
    </div>
    <div class="col-md-9">
      <input type="hidden" name="ty_check" value="1">
      <select class="selectpicker" name="progress_status">
        <option value="1" <?php if($noti_status==1){ echo "selected";}?> >เปิด</option>
        <option value="0" <?php if($noti_status==0){ echo "selected";}?>>ปิด</option>
      </select>
    </div>
  </div>
  <div class="row form-group txt_noti">
    <div class="col-md-3">
    <label class="lbl_txt_noti">ความคืบหน้า (Progress) 25% (ไทย)<?=$rematk?></label>
    </div>
    <div class="col-md-6">
      <input type="text" name="progress_25" value="<?=$noti_process25?>"  class="form-control input_box" onkeyup="this.value = isThaichar(this.value,this)">
    </div>
  </div>
  <div class="row form-group txt_noti">
    <div class="col-md-3">
    <label class="lbl_txt_noti">ความคืบหน้า (Progress) 25% (Eng)<?=$rematk?></label>
    </div>
    <div class="col-md-6">
      <input type="text" name="progress_25_en" value="<?=$noti_process25_en?>"  class="form-control input_box" onkeyup="this.value = isThaichar_en(this.value,this)">
    </div>
  </div>
  <div class="row form-group txt_noti">
    <div class="col-md-3">
      <label class="lbl_txt_noti">ความคืบหน้า (Progress) 50% (ไทย)<?=$rematk?></label>
    </div>
    <div class="col-md-6">
      <input type="text" name="progress_50" value="<?=$noti_process50?>"  class="form-control input_box" onkeyup="this.value = isThaichar(this.value,this)">
    </div>
  </div>
  <div class="row form-group txt_noti">
    <div class="col-md-3">
      <label class="lbl_txt_noti">ความคืบหน้า (Progress) 50% (Eng)<?=$rematk?></label>
    </div>
    <div class="col-md-6">
      <input type="text" name="progress_50_en" value="<?=$noti_process50_en?>"  class="form-control input_box" onkeyup="this.value = isThaichar_en(this.value,this)">
    </div>
  </div>

  <div class="row form-group txt_noti">
    <div class="col-md-3">
      <label class="lbl_txt_noti">ความคืบหน้า (Progress) 75% (ไทย)<?=$rematk?></label>
    </div>
    <div class="col-md-6">
      <input type="text" name="progress_75" value="<?=$noti_process75?>"  class="form-control input_box" onkeyup="this.value = isThaichar(this.value,this)">
    </div>
  </div>
  <div class="row form-group txt_noti">
    <div class="col-md-3">
      <label class="lbl_txt_noti">ความคืบหน้า (Progress) 75% (Eng)<?=$rematk?></label>
    </div>
    <div class="col-md-6">
      <input type="text" name="progress_75_en" value="<?=$noti_process75_en?>"  class="form-control input_box" onkeyup="this.value = isThaichar_en(this.value,this)">
    </div>
  </div>

  <div class="row form-group txt_noti">
    <div class="col-md-3">
      <label class="lbl_txt_noti">ความคืบหน้า (Progress) 100% (ไทย)<?=$rematk?></label>
    </div>
    <div class="col-md-6">
      <input type="text" name="progress_100" value="<?=$noti_process100?>"  class="form-control input_box" onkeyup="this.value = isThaichar(this.value,this)">
    </div>
  </div>
  <div class="row form-group txt_noti">
    <div class="col-md-3">
      <label class="lbl_txt_noti">ความคืบหน้า (Progress) 100% (Eng)<?=$rematk?></label>
    </div>
    <div class="col-md-6">
      <input type="text" name="progress_100_en" value="<?=$noti_process100_en?>"  class="form-control input_box" onkeyup="this.value = isThaichar_en(this.value,this)">
    </div>
  </div>

</form>
<form method="POST" action="method.php?method=edit_noti" style="display: none;"  enctype="multipart/form-data" target="iframe-data"  >
  <div class="row row_title no-margin-padding">
    <div class="col-md-12  col-xs-12 no-margin-padding noti_span">
      <div class="col-md-8  col-xs-12">
        การแจ้งเตือนอื่นๆ
      </div>
      <!-- <div class="no-margin-padding noti_span no-margin-padding" style="float:right;    border-top: 0px solid #dfe8f1;"> -->
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
    <div class="col-md-3">
      <label class="lbl_txt_noti">ข้อความ</label>
    </div>
    <div class="col-md-9">
      <input type="hidden" name="ty_check" value="2">
      <select class="selectpicker" name="progress_message">
        <option value="1"  <?php if($notiMsg_status==1){ echo "selected";}?> >เปิด</option>
        <option value="0"  <?php if($notiMsg_status==0){ echo "selected";}?> >ปิด</option>
      </select>
    </div>
  </div>
</form>
</div>

<script>

function HandleBrowseClick()
{
    var fileinput = document.getElementById("browse");
    fileinput.click();
}
function Handlechange()
	{
		var fileinput = document.getElementById("browse");
		var textinput = document.getElementById("filename");
		textinput.value = fileinput.value;
	}
$(document).ready(function() {

     $('.table-caseCh-list').on('load-success.bs.table', function (e) {
       $('[data-toggle="tooltip"]').tooltip();
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
