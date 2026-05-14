<div class="">
  <div class="title_color">
    <span class="title_icon ditp-icon icon-ico-ditp-05"></span>
    ตั้งค่าระบบ
  </div>
</div>
<div class="box_appeal">
  <div class="row row_title">
    <div class="col-lg-3 col-md-12 box_appeal_title">
      ประเภทกระบวนการ
    </div>
    <div class="col-lg-9 col-md-12 search box_s1">
      <select class="selectpicker col-xs-2 chosen-select-dissearch" name="type_section"  id="type_section" data-width="200px">
        <option value="">--- ประเภททั้งหมด ---</option>
        <option value="1">สสบ.</option>
        <option value="2">นิติการ</option>
      </select>
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
      <?php if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"manage_system")[2]==1){ ?>
      <button type="button " class="btn_add click_add btn_add_left box_pd_app pd_btn_10" data-toggle="modal" data-target=".modal_add_porduct">
        <span class="">เพิ่มประเภทกระบวนการ</span>
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
    data-url="method.php?method=getprocess"
    data-query-params="searchQueryParams"
    data-method="post">
    <thead>
      <tr>
        <th data-field="id" data-sortable="false" data-align="center">
          #
        </th>
        <th data-field="name" data-sortable="true" class="name_table_250">
          ชื่อ
        </th>
        <th data-field="type" data-sortable="true" data-align="center" class="center_table">
          ประเภท
        </th>
        <th data-field="step" data-sortable="true"  data-align="center" class="center_table">
          ขั้นตอนการทำงาน/Progress
        </th>
        <th data-field="duration" data-sortable="false"  data-align="center" class="center_table">
          กำหนดเวลา(วัน)
        </th>
        <th data-field="view" data-sortable="false"  data-align="center" class="center_table">
          การแสดงผล
        </th>
        <?php if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"manage_system")[2]==1){ ?>
        <th data-field="del_edit" data-sortable="false"  data-align="center" class="th_user_width">
        </th>
        <?php } ?>
      </tr>
    </thead>
  </table>
</div>
</div>


<!--  add_product  -->
<form method="POST" action="method.php?method=add_process"  enctype="multipart/form-data" target="iframe-data"  >
  <div class="modal fade modal_add_porduct" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel">เพิ่มประเภทกระบวนการ</h4>
        </div>
        <div class="modal-body">
          <div class="row ">
            <div class="col-md-4">
              <label for="message-text" class="control-label">เลือกประเภท</label>
            </div>
            <div class="col-md-8">
              <div class="col-md-4">
                <div class="radio radio-danger">
                  <input type="radio" name="radio_section" id="radio3" value="1"  checked="checked" >
                  <label for="radio3">
                    สสบ.
                  </label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="radio radio-danger ">
                  <input type="radio" name="radio_section" id="radio4" value="2">
                  <label for="radio4">
                  นิติการ
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label for="message-text" class="control-label">หน่วยงานที่ติดต่อ</label>
            </div>
            <div class="col-md-8">
              <div class="col-md-4">
                <div class="radio radio-danger">
                  <input type="radio" name="radio_contact" id="contact_1" value="1" onchange="hide_depart(1);">
                  <label for="contact_1">
                    มี
                  </label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="radio radio-danger ">
                  <input type="radio" name="radio_contact" id="contact_2" value="0" checked="checked" onchange="hide_depart(2);">
                  <label for="contact_2">
                  ไม่มี
                  </label>
                </div>
              </div>
            </div>
          </div>

          <div class="row form-group hide_depart">
            <div class="col-md-4">
              <label for="message-text" class="control-label">ประเภทหน่วยงาน<?=$rematk?></label>
            </div>
            <div class="col-md-8">
              <select class="selectpicker chosen-select-dissearch" name="Depart_type"  id="" data-width="100%" data-live-search="false">
                <option value="">--- เลือกหน่วยงาน ---</option>
                <?php
                $sql_select = "SELECT * FROM  Department_Type ORDER BY  deptType_name ASC";
                  $query_select = $conn->query($sql_select);
                  while ($re =   $query_select->fetch_assoc()) {
                  ?>
                  <option value="<?=$re['deptType_id']?>"><?=$re['deptType_name']?></option>
                <?php } ?>
              </select>
            </div>
          </div>

          <div class="row form-group">
            <div class="col-md-4">
              <label for="recipient-name" class="control-label">ชื่อกระบวนการ<?=$rematk?></label>
            </div>
            <div class="col-md-8">
              <input type="hidden" class="form-control" id="recipient-name" name="add_name" >
              <input type="text" class="form-control" id="add_name" name="add_name">
            </div>
          </div>

          <div class="row form-group">
            <div class="col-md-4">
              <label for="recipient-name" class="control-label">กำหนดเวลา<?=$rematk?></label>
            </div>
            <div class="col-md-3 ">
              <input type="hidden" class="form-control" id="recipient-name" name="add_date" >
              <input type="text" class="form-control" id="add_day" name="add_day" onKeyUp="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลขเท่านั้น'); this.value='';}">
            </div>
            <div class="col-md-5 ">
              <label for="recipient-name" class="control-label">วัน</label>
            </div>
          </div>
          <div class="row ">
            <div class="col-md-4">
              <label for="message-text" class="control-label">ขั้นตอนการทำงาน</label>
            </div>
            <div class="col-md-8">
              <div class="col-md-3">
                <div class="radio radio-danger">
                  <input type="radio" name="radio_step" id="ch1_step" value="1"  checked="checked" >
                  <label for="ch1_step">
                    1/(25%)
                  </label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="radio radio-danger ">
                  <input type="radio" name="radio_step" id="ch2_step" value="2">
                  <label for="ch2_step">
                    2/(50%)
                  </label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="radio radio-danger">
                  <input type="radio" name="radio_step" id="ch3_step" value="3"  >
                  <label for="ch3_step">
                  3/(75%)
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label for="message-text" class="control-label">การแสดงผล</label>
            </div>
            <div class="col-md-8">
              <div class="col-md-3">
                <div class="radio radio-danger">
                  <input type="radio" name="radio_enable" id="ch1_enable" value="1"  checked="checked" >
                  <label for="ch1_enable">
                    เปิด
                  </label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="radio radio-danger ">
                  <input type="radio" name="radio_enable" id="ch2_enable" value="0">
                  <label for="ch2_enable">
                   ปิด
                  </label>
                </div>
              </div>
            </div>
          </div>

          <div class="row form-group">
            <div class="col-md-4">
              <label for="recipient-name" class="control-label">ข้อความแจ้งเตือนกรณีกระบวนการถูกสร้างขึ้น (ไทย)</label>
            </div>
            <div class="col-md-8">
              <textarea class="form-control resize_textarea" rows="2" name="message_noti" cols="80" onkeyup="this.value = isThaichar(this.value,this)"></textarea>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-4">
              <label for="recipient-name" class="control-label">ข้อความแจ้งเตือนกรณีกระบวนการถูกสร้างขึ้น (Eng)</label>
            </div>
            <div class="col-md-8">
              <textarea class="form-control resize_textarea" rows="2" name="message_noti_en" cols="80" onkeyup="this.value = isThaichar_en(this.value,this)"></textarea>
            </div>
          </div>

          <div class="row form-group">
            <div class="col-md-4">
              <label for="recipient-name" class="control-label">ข้อความแจ้งเตือนกรณีมีเอกสารเข้า (ไทย)</label>
            </div>
            <div class="col-md-8">
              <textarea class="form-control resize_textarea" rows="2" name="send_back" cols="80" onkeyup="this.value = isThaichar(this.value,this)"></textarea>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-4">
              <label for="recipient-name" class="control-label">ข้อความแจ้งเตือนกรณีมีเอกสารเข้า (Eng)</label>
            </div>
            <div class="col-md-8">
              <textarea class="form-control resize_textarea" rows="2" name="send_back_en" cols="80" onkeyup="this.value = isThaichar_en(this.value,this)" ></textarea>
            </div>
          </div>

          <div class="row form-group">
            <div class="col-md-4">
              <label for="recipient-name" class="control-label">ข้อความแจ้งเตือนกรณีมีเอกสารออก (ไทย)</label>
            </div>
            <div class="col-md-8">
              <textarea class="form-control resize_textarea" rows="2" name="send_to" cols="80" onkeyup="this.value = isThaichar(this.value,this)"></textarea>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-4">
              <label for="recipient-name" class="control-label">ข้อความแจ้งเตือนกรณีมีเอกสารออก (Eng)</label>
            </div>
            <div class="col-md-8">
              <textarea class="form-control resize_textarea" rows="2" name="send_to_en" cols="80" onkeyup="this.value = isThaichar_en(this.value,this)"></textarea>
            </div>
          </div>


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
          <button type="submit" class="btn  btn_submit">ตกลง</button>
        </div>
      </div>
    </div>
  </div>
</form>

<form method="POST" action="method.php?method=save_process"  enctype="multipart/form-data" target="iframe-data"  >
  <div class="modal fade edit_product" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" >
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title title_view" id="exampleModalLabel">แก้ไขประเภทกระบวนการ</h4>
        </div>
        <div class="modal-body" id="view_date">
          <div class="row hide_edit">
            <div class="col-md-4">
              <label for="message-text" class="control-label">เลือกประเภท</label>
            </div>
            <div class="col-md-8 ">
              <div class="col-md-4 b1">
                <div class="radio radio-danger">
                  <input type="radio" name="radio_section" id="ch1_section_edit" value="1"  checked="checked" >
                  <label for="ch1_section_edit">
                    สสบ.
                  </label>
                </div>
              </div>
              <div class="col-md-4 b1">
                <div class="radio radio-danger ">
                  <input type="radio" name="radio_section" id="ch2_section_edit" value="2">
                  <label for="ch2_section_edit">
                  นิติการ
                  </label>
                </div>
              </div>

              <div class="col-md-8 b2">
                <div class="radio radio-danger ">
                    <input type="radio" name="radio_section1" id="ch2_section_edit1" value="0" checked="checked" >
                  <label for="ch2_section_edit">
                    สสบ. และ นิติการ
                  </label>
                </div>
              </div>

            </div>
            </div>

          <div class="row hide_edit">
            <div class="col-md-4">
              <label for="message-text" class="control-label">หน่วยงานที่ติดต่อ</label>
            </div>
            <div class="col-md-8">
              <div class="col-md-4">
                <div class="radio radio-danger">
                  <input type="radio" name="radio_contact" id="contact_edit_1" value="1"   onchange="hide_depart(1);" >
                  <label for="contact_edit_1">
                    มี
                  </label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="radio radio-danger ">
                  <input type="radio" name="radio_contact" id="contact_edit_2" value="0"  onchange="hide_depart(2);">
                  <label for="contact_edit_2">
                  ไม่มี
                  </label>
                </div>
              </div>
            </div>
          </div>

          <div class="row form-group hide_depart">
            <div class="col-md-4">
              <label for="message-text" class="control-label">ประเภทหน่วยงาน<?=$rematk?></label>
            </div>
            <div class="col-md-8">
              <select class="selectpicker chosen-select-dissearch" name="Depart_type"  id="Depart_type" data-width="100%" data-live-search="false">
                <option value="">เลือกหน่วยงาน</option>
                <?php
                $sql_select = "SELECT * FROM  Department_Type ORDER BY  deptType_name ASC";
                  $query_select = $conn->query($sql_select);
                  while ($re =   $query_select->fetch_assoc()) {
                  ?>
                  <option value="<?=$re['deptType_id']?>"><?=$re['deptType_name']?></option>
                <?php } ?>
              </select>
            </div>
          </div>


          <div class="row form-group">
            <div class="col-md-4">
              <label for="recipient-name" class="control-label">ชื่อกระบวนการ<?=$rematk?></label>
            </div>
            <div class="col-md-8">
              <input type="hidden" class="form-control" id="id_edit" name="id_edit"  >
              <input type="text" class="form-control" id="edit_name" name="edit_name">
            </div>
          </div>

          <div class="row form-group hide_edit">
            <div class="col-md-4">
              <label for="recipient-name" class="control-label">กำหนดเวลา<?=$rematk?></label>
            </div>
            <div class="col-md-4">
              <input type="hidden" class="form-control" id="recipient-name" name="add_date" >
              <input type="text" class="form-control" id="edit_day" name="edit_day" onKeyUp="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลขเท่านั้น'); this.value='';}">
            </div>
            <div class="col-md-4">
              <label for="recipient-name" class="control-label">วัน</label>
            </div>
          </div>
          <div class="row hide_edit">
            <div class="col-md-4">
              <label for="message-text" class="control-label">ขั้นตอนการทำงาน</label>
            </div>
            <div class="col-md-8">
              <div class="col-md-3">
                <div class="radio radio-danger">
                  <input type="radio" name="radio_step" id="ch1_step_edit" value="1" >
                  <label for="ch1_step_edit">
                    1/(25%)
                  </label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="radio radio-danger ">
                  <input type="radio" name="radio_step" id="ch2_step_edit" value="2">
                  <label for="ch2_step_edit">
                    2/(50%)
                  </label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="radio radio-danger">
                  <input type="radio" name="radio_step" id="ch3_step_edit" value="3">
                  <label for="ch3_step_edit">
                  3/(75%)
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div class="row hide_edit">
            <div class="col-md-4">
              <label for="message-text" class="control-label">การแสดงผล</label>
            </div>
            <div class="col-md-8">
              <div class="col-md-3">
                <div class="radio radio-danger">
                  <input type="radio" name="radio_enable" id="ch1_enable_edit" value="1" >
                  <label for="ch1_enable_edit">
                    เปิด
                  </label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="radio radio-danger ">
                  <input type="radio" name="radio_enable" id="ch2_enable_edit" value="0">
                  <label for="ch2_enable_edit">
                   ปิด
                  </label>
                </div>
              </div>
            </div>
          </div>

          <div class="row form-group">
            <div class="col-md-4">
              <label for="recipient-name" class="control-label">ข้อความแจ้งเตือนกรณีกระบวนการถูกสร้างขึ้น (ไทย)</label>
            </div>
            <div class="col-md-8">
              <textarea class="form-control resize_textarea" rows="2" name="message_noti"  id="message_noti" cols="80" onkeyup="this.value = isThaichar(this.value,this)"></textarea>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-4">
              <label for="recipient-name" class="control-label">ข้อความแจ้งเตือนกรณีกระบวนการถูกสร้างขึ้น (Eng)</label>
            </div>
            <div class="col-md-8">
              <textarea class="form-control resize_textarea" rows="2" name="message_noti_en"  id="message_noti_en" cols="80" onkeyup="this.value = isThaichar_en(this.value,this)"></textarea>
            </div>
          </div>

          <div class="row form-group hide_back">
            <div class="col-md-4">
              <label for="recipient-name" class="control-label">ข้อความแจ้งเตือนกรณีมีเอกสารเข้า (ไทย)</label>
            </div>
            <div class="col-md-8">
              <textarea class="form-control resize_textarea" rows="2" name="message_in"  id="message_in" cols="80" onkeyup="this.value = isThaichar(this.value,this)"></textarea>
            </div>
          </div>
          <div class="row form-group hide_back">
            <div class="col-md-4">
              <label for="recipient-name" class="control-label">ข้อความแจ้งเตือนกรณีมีเอกสารเข้า (Eng)</label>
            </div>
            <div class="col-md-8">
              <textarea class="form-control resize_textarea" rows="2" name="message_in_en"  id="message_in_en" cols="80" onkeyup="this.value = isThaichar_en(this.value,this)"></textarea>
            </div>
          </div>


          <div class="row form-group">
            <div class="col-md-4">
              <label for="recipient-name" class="control-label">ข้อความแจ้งเตือนกรณีมีเอกสารออก (ไทย)</label>
            </div>
            <div class="col-md-8">
              <textarea class="form-control resize_textarea" rows="2" name="message_out"  id="message_out" cols="80" onkeyup="this.value = isThaichar(this.value,this)"></textarea>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-4">
              <label for="recipient-name" class="control-label">ข้อความแจ้งเตือนกรณีมีเอกสารออก (Eng)</label>
            </div>
            <div class="col-md-8">
              <textarea class="form-control resize_textarea" rows="2" name="message_out_en"  id="message_out_en" cols="80" onkeyup="this.value = isThaichar_en(this.value,this)"></textarea>
            </div>
          </div>

        </div>
        <div class="modal-footer footer_close">
          <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
          <?php if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"manage_system")[2]==1){ ?>
          <button type="submit" class="btn  btn_submit" >ตกลง</button>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</form>

<script>

$(document).ready(function() {
  $('.hide_depart').hide();
  $('.table-caseCh-list').on('load-success.bs.table', function (e) {
    auto_resize_menu();
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
  $("select[name='type_section']").on('change', function() {
    $('.table-caseCh-list').bootstrapTable('refresh');
  });
});

$(document).on('click','.btn-click-search',function() {
  $('.table-caseCh-list').bootstrapTable('refresh');
});

function searchQueryParams(params) {
  params.type_section = $("select[name='type_section']").val();
  params.text = $("input[name='search_text']").val();
  if($('.search_date').prop("disabled")==false){
    params.date = $('.search_date').val();
  }
  return params; // body data
}
</script>
