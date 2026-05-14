<div class="">
  <div class="title_color">
    <i class="ditp-icon icon-ico-ditp-42"></i>
    ฐานข้อมูลผู้ติดต่อ
  </div>
</div>
<div class="box_appeal">
  <div class="row row_title">
    <div class="col-md-12 col-lg-3 box_appeal_title float_left">
      นิติบุคคลในต่างประเทศ
    </div>
    <div class="col-md-12 col-xs-12 col-lg-9  search box_s1">
      <div class="filter_report">
        <div class="input-group report_search">
          <input type="text" name="search_text" id="search_text" class="form-control input_box" placeholder="Search" autocomplete="off">
          <span class="input-group-addon bg-black btn-click-search">
            <i class="glyphicon glyphicon-search"></i>
          </span>
        </div>
      </div>
          <!-- <div class="box-search display_block" id="icon-search" style="">
            <div class="input_box">
              <input type="text" name="search_text" id="search_text" class="form-control input_box" placeholder="Search" autocomplete="off">
            </div>
          </div> -->

          <?php if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"manager_corporate")[2]==1){ ?>
            <br style="display:none;">
        <a href="../../data/setting/template/Template_corporate_inter.xlsx">
        <button type="button" class="btn_import click_add click_add_re pd_btn_10" data-toggle="modal">
          <i class="fa fa-download" aria-hidden="true"></i>
          <span class="">Download Template</span>
              </button>
            </a>
          <button type="button" class="btn_import click_add pd_btn_10" data-toggle="modal" data-target=".import_people_th">
            <i class="fa fa-file-excel-o" aria-hidden="true"></i>
            <span class="">import</span>
                </button>
          <button type="button" class="btn_add click_add pd_btn_10" data-toggle="modal" data-target=".modal_add_inter">
            <span class="">เพิ่มผู้ติดต่อ</span>
          </button>
          <?php } ?>
          </div>
  </div>

  <div class="tabla_data">
    <table data-toggle="table" class="table-caseCh-list"
    data-sort-name="id"
    data-sort-order="DESC"
    data-side-pagination="server"
    data-pagination="true"
    data-page-size="10"
    data-page-list="[10, 50, 100, 200, ALL]"
    data-url="corporate/method.php?method=get_corporate_inter"
    data-query-params="searchQueryParams"
    data-method="post">
    <thead>
      <th data-field="number" data-sortable="true"  data-align="left" class="th_user">
        เลขนิติบุคคล (13 หลัก)
      </th>
      <th data-field="name" data-sortable="true"  data-align="left" class="th_user">
        ชื่อที่จดทะเบียน
      </th>
      <th data-field="offset" data-sortable="true"  data-align="left" class="th_user">
        สาขา
      </th>
      <th data-field="tel" data-sortable="true"  data-align="left" class="th_user">
        เบอร์โทรศัพท์
      </th>
      <th data-field="web" data-sortable="true"  data-align="left" class="th_user">
        Website
      </th>
      <th data-field="address" data-sortable="true"  data-align="left" class="th_user">
        ที่อยู่ติดต่อ
      </th>
      <th data-field="prov" data-sortable="true"  data-align="left" class="th_user country_width">
        ประเทศ
      </th>
      <th data-field="contact" data-sortable="true"  data-align="left" class="th_user">
        ผู้ติดต่อ
      </th>
      <th data-field="cpr_type" data-sortable="true"  data-align="left" class="th_user">
        ประเภทธุรกิจ
      </th>
      <th data-field="reliable" data-sortable="false"  data-align="left" class="th_user">
        สถานะบริษัท
      </th>
      <?php if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"manager_corporate")[2]==1){ ?>
      <th data-field="del" data-sortable="false"  data-align="center" class="th_user_width">
      </th>
      <?php } ?>
    </tr>
  </thead>
</table>
</div>
</div>


<!--  add -->
<form method="POST" action="corporate/method.php?method=save_corporate_inter"  enctype="multipart/form-data" target="iframe-data"  >
  <div class="modal fade modal_add_inter" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel">เพิ่มนิติบุคคลในต่างประเทศ</h4>
        </div>
        <div class="modal-body">
        <!-- <div class="box_gp_app"> -->

          <div class="row form_group_10">
              <div class="col-md-4">
                <label for="message-text" class="control-label body_txt_modal_16">หมายเลขทะเบียนการค้า<label class="txt_no_del" for=""></label></label>
              </div>
              <div class="col-md-8 ct_card">
                <input type="text" class="form-control body_txt_modal_add input-mask" name="numbertrade" value="" onkeyup="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลขเท่านั้น'); this.value='';}">
              </div>
          </div>

          <div class="row form_group_10">
              <div class="col-md-4">
                <label for="message-text" class="control-label body_txt_modal_16">ชื่อบริษัท<label class="txt_no_del" for="">*</label></label>
              </div>
              <div class="col-md-8 ct_card">
                <input type="text" class="form-control body_txt_modal_add input-mask" name="companyname" value="" >
              </div>
          </div>

          <div class="row form_group_10">
              <div class="col-md-4">
                <label for="message-text" class="control-label body_txt_modal_16">สาขา<label class="txt_no_del" for=""></label></label>
              </div>
              <div class="col-md-4 ct_card">
                <input type="text" class="form-control body_txt_modal_add input-mask" name="branch" value="" >
              </div>
          </div>
          <div class="row form_group_10">
              <div class="col-md-4">
                <label for="message-text" class="control-label body_txt_modal_16">ชื่อที่ติดต่อ<label class="txt_no_del" for=""></label></label>
              </div>
              <div class="col-md-4 ct_card">
                <input type="text" class="form-control body_txt_modal_add input-mask" name="contact_person" value="" >
              </div>
          </div>

          <div class="row form_group_10">
              <div class="col-md-4">
                <label for="message-text" class="control-label body_txt_modal_16">หมายเลขโทรศัพท์ที่ติดต่อ<label class="txt_no_del" for="">*</label></label>
              </div>
              <div class="col-md-4">
                <input type="text" class="form-control body_txt_modal_add" name="telephone" value="" onkeyup="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลขเท่านั้น'); this.value='';}">
              </div>
          </div>

          <div class="row form_group_10">
              <div class="col-md-4">
                <label for="message-text" class="control-label body_txt_modal_16">เว็บไซต์<label class="txt_no_del" for=""></label></label>
              </div>
              <div class="col-md-4">
                <input type="text" class="form-control body_txt_modal_add" name="web" value="" onkeyup="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลขเท่านั้น'); this.value='';}">
              </div>
          </div>

          <div class="row form_group_10">
              <div class="col-md-4">
                <label for="message-text" class="control-label body_txt_modal_16">E-mail ที่ติดต่อ<label class="txt_no_del" for="">*</label></label>
              </div>
              <div class="col-md-6">
                <input type="text" class="form-control body_txt_modal_add" name="email" value="" onkeyup="this.value = isThaichar_en(this.value,this)">
              </div>
          </div>

          <div class="row form_group_10">
              <div class="col-md-4">
                <label for="message-text" class="control-label body_txt_modal_16">ที่อยู่ติดต่อ<label class="txt_no_del" for="">*</label></label>
              </div>
              <div class="col-md-8 txt_add">
                <textarea name="address"  class="form-control body_txt_modal_add" rows="3"></textarea>
              </div>
          </div>

          <div class="row form_group_10">
              <div class="col-md-4">
                <label for="message-text" class="control-label body_txt_modal_16">ประเทศ<label class="txt_no_del" for="">*</label></label>
              </div>
              <div class="col-md-8 select_selectpicker">
                <select class="selectpicker col-xs-2 chosen-select-dissearch" name="Country_id"  id="" data-width="200px" data-live-search="true">
                  <option value="">--- เลือกประเทศ ---</option>
                  <?php
                  $sql_select = "SELECT * FROM Country ORDER BY id=162 DESC, name ASC";
                    $query_select = $conn->query($sql_select);
                    while ($re =   $query_select->fetch_assoc()) {
                    ?>
                    <option value="<?=$re['id']?>"><?=$re['name']?></option>
                  <?php } ?>
                </select>
              </div>
          </div>
          <div class="row form_group_10">
              <div class="col-md-4">
                <label for="message-text" class="control-label body_txt_modal_16">ประเภทธุรกิจ<label class="txt_no_del" for="">*</label></label>
              </div>
              <select class="selectpicker col-xs-2 chosen-select-dissearch" name="business_type"  id="" data-width="200px">
                <option value="">--- เลือกประเภทธุรกิจ ---</option>
                <option value="1">นำเข้า</option>
                <option value="2">ส่งออก</option>
                <option value="0">ไม่ระบุ</option>
              </select>
          </div>

        </div>
        <div class="modal-footer">
            <button type="submit" class="btn  btn_submit">บันทึกข้อมูล</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
        </div>
      </div>
    </div>
  </div>
</form>




<!--  add -->
<form method="POST" action="corporate/method.php?method=save_corporate_inter"  enctype="multipart/form-data" target="iframe-data"  >
  <div class="modal fade modal_corporate_inter" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title title_view" id="exampleModalLabel">แก้ไขนิติบุคคลในต่างประเทศ</h4>
        </div>
        <div class="modal-body" id="view_date">
          <div class="row form_group_10">
              <div class="col-md-4">
                <label for="message-text" class="control-label body_txt_modal_16">หมายเลขทะเบียนการค้า<label class="txt_no_del" for=""></label></label>
              </div>
              <div class="col-md-8 ct_card">
                <input type="hidden" name="id_ch" id="id_ch" value="">
                <input type="text" class="form-control body_txt_modal_add input-mask" name="numbertrade" id="numbertrade" value="" onkeyup="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลขเท่านั้น'); this.value='';}">
              </div>
          </div>

          <div class="row form_group_10">
              <div class="col-md-4">
                <label for="message-text" class="control-label body_txt_modal_16">ชื่อบริษัท<label class="txt_no_del" for=""></label></label>
              </div>
              <div class="col-md-8 ct_card">
                <div class="id_care_edit"  id="ct_card" >
                  </div>
              </div>
          </div>

          <div class="row form_group_10">
              <div class="col-md-4">
                <label for="message-text" class="control-label body_txt_modal_16">สาขา<label class="txt_no_del" for=""></label></label>
              </div>
              <div class="col-md-4 ct_card">
                <input type="text" class="form-control body_txt_modal_add input-mask" name="branch" id="branch" value="" >
              </div>
          </div>

          <div class="row form_group_10">
              <div class="col-md-4">
                <label for="message-text" class="control-label body_txt_modal_16">ชื่อที่ติดต่อ<label class="txt_no_del" for=""></label></label>
              </div>
              <div class="col-md-4 ct_card">
                <input type="text" class="form-control body_txt_modal_add input-mask" name="contact_person" id="contactfname" value="" >
              </div>
          </div>

          <div class="row form_group_10">
              <div class="col-md-4">
                <label for="message-text" class="control-label body_txt_modal_16">หมายเลขโทรศัพท์ที่ติดต่อ<label class="txt_no_del" for="">*</label></label>
              </div>
              <div class="col-md-4">
                <input type="text" class="form-control body_txt_modal_add" name="telephone" id="telephone" value="" onkeyup="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลขเท่านั้น'); this.value='';}">
              </div>
          </div>

          <div class="row form_group_10">
              <div class="col-md-4">
                <label for="message-text" class="control-label body_txt_modal_16">เว็บไซต์<label class="txt_no_del" for=""></label></label>
              </div>
              <div class="col-md-6">
                <input type="text" class="form-control body_txt_modal_add" name="web" id="web" value="">
              </div>
          </div>

          <div class="row form_group_10">
              <div class="col-md-4">
                <label for="message-text" class="control-label body_txt_modal_16">E-mail ที่ติดต่อ<label class="txt_no_del" for="">*</label></label>
              </div>
              <div class="col-md-6">
                <input type="text" class="form-control body_txt_modal_add" name="email" id="email" value="" onkeyup="this.value = isThaichar_en(this.value,this)">
              </div>
          </div>

          <div class="row form_group_10">
              <div class="col-md-4">
                <label for="message-text" class="control-label body_txt_modal_16">ที่อยู่ติดต่อ<label class="txt_no_del" for="">*</label></label>
              </div>
              <div class="col-md-8 txt_add">
                <textarea name="address" id="address" class="form-control body_txt_modal_add" rows="3"></textarea>
              </div>
          </div>

          <div class="row form_group_10">
              <div class="col-md-4">
                <label for="message-text" class="control-label body_txt_modal_16">ประเทศ<label class="txt_no_del" for="">*</label></label>
              </div>
              <div class="col-md-8 select_selectpicker">
                <select class="selectpicker col-xs-2 chosen-select-dissearch" name="Country_id"  id="Country" data-width="200px" data-live-search="true">
                  <option value="">--- เลือกประเทศ ---</option>
                  <?php
                  $sql_select = "SELECT * FROM Country ORDER BY id=162 DESC, name ASC";
                    $query_select = $conn->query($sql_select);
                    while ($re =   $query_select->fetch_assoc()) {
                    ?>
                    <option value="<?=$re['id']?>"><?=$re['name']?></option>
                  <?php } ?>
                </select>
              </div>
          </div>
          <div class="row form_group_10">
              <div class="col-md-4">
                <label for="message-text" class="control-label body_txt_modal_16">ประเภทธุรกิจ<label class="txt_no_del" for="">*</label></label>
              </div>
              <select class="selectpicker col-xs-2 chosen-select-dissearch" name="business_type"  id="business_type" data-width="200px">
                <option value="">--- เลือกประเภทธุรกิจ ---</option>
                <option value="1">นำเข้า</option>
                <option value="2">ส่งออก</option>
                <option value="0">อื่นๆ</option>
              </select>
          </div>
        </div>
        <div class="modal-footer footer_close">
          <?php if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"manager_corporate")[2]==1){ ?>
            <button type="submit" class="btn  btn_submit">บันทึกข้อมูล</button>
          <?php } ?>
          <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
        </div>
      </div>
    </div>
  </div>
</form>





<!--  importt  -->
<!-- Individual/method.php?method=add_contact_thai -->
<form method="POST" action="corporate/method.php?method=import_corporate_inter"  enctype="multipart/form-data" target="iframe-data"  >
  <div class="modal fade import_people_th" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel">Import Person</h4>
        </div>
        <div class="modal-body">
          <div class="row ">
            <div class="x-detail" style="margin-top:10px;">
              <div class="col-md-4">
                <div class="asset-detail-titlex">Upload Excel</div>
              </div>
              <div class="col-md-8">
                <input type="file" id="browse" name="userimport"  style="display: none"  onChange="Handlechange();" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"/>
                <input type="hidden" name="import" value="1" />
                <div class="box_im">
                  <input type="text" id="filename" readonly="true" class="form-control input-browse box_im_input"/>
                </div>
                <div class="box_impo">
                  <input type="button" value="Browse.." id="fakeBrowse" onclick="HandleBrowseClick();" class="btn btn-btn box_btn_impoet_id"/>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
          <button type="submit" class="btn  btn_submit" onclick="">ตกลง</button>
        </div>
      </div>
    </div>
  </div>
</form>

<div class="modal fade modal_ststus" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Status Import</h4>
      </div>
      <div class="modal-body ststus_im" style="overflow-y: auto;">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" onClick="window.location.reload();">ปิด</button>
      </div>
    </div>
  </div>
</div>


<script>
$(function(){
    $(".input-mask").inputmask();
  });
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
    auto_resize_menu();
  });
  $("input[name='search_prod_type']").change(function() {
    /* Act on the event */
  });
  $("input[name='search_text']").keypress(function(e) {
    if(e.which == 13) {
      $('.table-caseCh-list').bootstrapTable('refresh');
    }
  });
  $("select[name='status_m']").on('change', function() {
    $('.table-caseCh-list').bootstrapTable('refresh');
  });
  $("select[name='login_f_m']").on('change', function() {
    $('.table-caseCh-list').bootstrapTable('refresh');
  });
  $("select[name='Department_members']").on('change', function() {
    $('.table-caseCh-list').bootstrapTable('refresh');
  });

});

$(document).on('click','.btn-click-search',function() {
  $('.table-caseCh-list').bootstrapTable('refresh');
});

function searchQueryParams(params) {
  params.Department_members = $("select[name='Department_members']").val();

  params.login_f_m = $("select[name='login_f_m']").val();

  params.status_m = $("select[name='status_m']").val();
  params.text = $("input[name='search_text']").val();
  if($('.search_date').prop("disabled")==false){
    params.date = $('.search_date').val();
  }
  return params; // body data
}
</script>
