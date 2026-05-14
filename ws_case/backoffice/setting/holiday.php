<div class="">
  <div class="title_color">
    <span class="title_icon ditp-icon icon-ico-ditp-05"></span>
    ตั้งค่าระบบ
  </div>
</div>
<div class="box_appeal">
  <div class="row row_title">
    <div class="col-xs-12 box_appeal_title box_appeal_title_re ">
      ตั้งค่าวันหยุดราชการ
    </div>
    <div class="col-lg-5 pd_btn_10">
      <div class="box_s1">
        <label class="control-label">
          การแจ้งเตือนล่วงหน้า
        </label>
      </div>
      <div class=" search box_s1 ho col-xs-3">
        <?php
        $sql_count = "SELECT hd_setting FROM Setting_Info ";
        $query_count = $conn->query($sql_count);
        while ( $re_count =   $query_count->fetch_assoc()) {
          $bl_php =  $re_count['hd_setting'];
        }
        ?>
        <input type="text" name="search_hd" value="<?php echo $bl_php; ?>" id="search_hd" class="form-control" placeholder="Search" OnKeyPress="return chkNumber(this)" autocomplete="off" maxlength="1">
      </div>
      <div class="box_s">
        <label class="control-label">
          เดือน
        </label>
      </div>
      <?php if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"manager_noti")[2]==1){ ?>
      <button style="margin-left: 10px;" class="btn_bl btn " type="button" name="button" onclick="get_data_holiday_update();">Update</button>
      <?php } ?>
  </div>
    <div class="col-lg-7 col-xs-12 search box_s1 dup_ho">
      <select class="selectpicker col-xs-2 chosen-select-dissearch display_block" name="type_section"  id="type_section" data-width="150px">
        <option value="" selected="">--- เลือกปี ---</option>
        <?php
        $year_real = date('Y');
        for ($i=0; $i < 5 ; $i++) {
          ?>
          <option value="<?php echo $year_real; ?>"><?php echo $year_real; ?></option>
          <?php
          $year_real++;
        }
         ?>
      </select>


      <div class="filter_report">
        <div class="input-group report_search">
          <input type="text" name="search_text" id="search_text" class="form-control input_box" placeholder="Search" autocomplete="off">
          <span class="input-group-addon bg-black btn-click-search">
            <i class="glyphicon glyphicon-search"></i>
          </span>
        </div>
      </div>
      <?php if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"manager_noti")[2]==1){ ?>
        <br style="display:none;">
        <button type="button" class="btn_add click_add btn_add_left click_add_re pd_btn_10" data-toggle="modal" data-target=".modal_add_porduct">
          <span class="">เพิ่มวันหยุดราชการ</span>
        </button>
        <button type="button" class="btn_add click_add btn_add_right pd_btn_10" id="duplicate" data-toggle="modal" data-target=".modal_add_Duplicate">
          <span class=""><i class="fa fa-files-o" aria-hidden="true"></i> Duplicate</span>
        </button>
        <?php  } ?>
      </div>

  </div>
  <div class="tabla_data">
    <table data-toggle="table" class="table-caseCh-list"
    data-sort-name="id"
    data-sort-order="desc"
    data-side-pagination="server"
    data-pagination="true"
    data-page-size="10"
    data-page-list="[10, 50, 100, 200, ALL]"
    data-url="method.php?method=getholiday"
    data-query-params="searchQueryParams"
    data-method="post">
    <thead>
      <tr>
        <th data-field="id" data-sortable="false" class="center_table">
        #
        </th>
        <th data-field="name" data-sortable="true">
          หัวข้อ
        </th>
        <th data-field="date" data-sortable="true" class="center_table" data-align="center">
          วันที่เริ่มต้น - วันที่สิ้นสุด
        </th>
        <th data-field="year" data-sortable="true"  data-align="center" class="center_table">
           ปี ค.ศ.
        </th>
        <th data-field="day" data-sortable="true"  data-align="center" class="center_table">
           ระยะเวลา
        </th>
        <?php if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"manager_form")[2]==1){ ?>
        <th data-field="del_edit" data-sortable="false"  data-align="center">
      </th>
      <?php }  ?>
    </tr>
  </thead>
</table>
</div>
</div>


<!--  add_product  -->
<form method="POST" action="method.php?method=add_holiday"  enctype="multipart/form-data" target="iframe-data"  >
  <div class="modal fade modal_add_porduct" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel">เพิ่มวันหยุดราชการ</h4>
        </div>
        <div class="modal-body">

          <div class="row form-group">
            <div class="col-md-4">
              <label for="message-text" class="control-label">ปี ค.ศ</label>
            </div>
            <div class="col-md-8">
              <select class="selectpicker chosen-select-dissearch" name="year"  data-width="auto">
              <?php
              $year_real = date('Y');
              for ($i=0; $i < 5 ; $i++) {
                ?>
                <option value="<?php echo $year_real; ?>"><?php echo $year_real; ?></option>
                <?php
                $year_real++;
              }
               ?>
              </select>
            </div>
          </div>

          <div class="row form-group">
            <div class="col-md-4">
              <label for="recipient-name" class="control-label">ชื่อ<?=$rematk?></label>
            </div>
            <div class="col-md-8">
              <input type="text" class="form-control" id="add_name" name="add_name">
            </div>
          </div>

          <div class="row form-group">
            <div class="col-md-4">
              <label for="recipient-name" class="control-label">กำหนดเวลาเริ่มต้น<?=$rematk?></label>
            </div>
            <div class="col-md-5">
              <div class="input-group date" data-provide="datepicker"  data-date-format="dd/mm/yyyy">
                <input type="text"   name="date_start" id="date_start" value=""  class="form-control">
                <div class="input-group-addon">
                  <i class="glyph-icon icon-calendar"></i>
                </div>
              </div>
            </div>
          </div>

          <div class="row form-group">
            <div class="col-md-4">
              <label for="recipient-name" class="control-label">กำหนดเวลาสิ้นสุด<?=$rematk?></label>
            </div>
            <div class="col-md-5">
              <!-- <div class="input-group">
                <input type="text" name="date_stop" id="date_stop"  value=""  class="form-control bootstrap-datepicker input-mask" data-inputmask="'mask':'99/99/9999'">
                <span class="input-group-addon input-group-addon-calendar bg-black ">
                  <i class="glyph-icon icon-calendar"></i>
                </span>
              </div> -->

              <div class="input-group date" data-provide="datepicker"  data-date-format="dd/mm/yyyy">
                <input type="text"    name="date_stop" id="date_stop"  value=""  class="form-control">
                <div class="input-group-addon">
                  <i class="glyph-icon icon-calendar"></i>
                </div>
              </div>

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


<!--  coppy   -->
<form method="POST" action="method.php?method=copy_duplicate"  enctype="multipart/form-data" target="iframe-data"  >
  <div class="modal fade modal_add_Duplicate" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel">Duplicate วันหยุดราชการ</h4>
        </div>
        <div class="modal-body">

          <div class="row form-group">
            <div class="col-md-5">
              <label for="message-text" class="control-label">เลือกปีที่ต้องการ Duplicat<?=$rematk?></label>
            </div>
            <div class="col-md-5">
            <input type="hidden" name="copy_duplicate" value="" id="copy_duplicate" >
              <select class="selectpicker chosen-select-dissearch" name="year"  data-width="150px">
              <?php
              $sql_edit = "SELECT holiday_year FROM `PublicHoliday` WHERE `holiday_status` = 0 GROUP by holiday_year ORDER BY `PublicHoliday`.`holiday_year` DESC";
              $query_edit = $conn->query($sql_edit);
                while ( $re_edit =   $query_edit->fetch_assoc()) {
                ?>
                <option value="<?php echo $re_edit['holiday_year']; ?>"><?php echo $re_edit['holiday_year']; ?></option>
                <?php
              }
               ?>
              </select>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-5 ">
              <label for="message-text" class="control-label">Duplicate ไปยังปี<?=$rematk?></label>
            </div>
            <div class="col-md-5">
              <select class="selectpicker chosen-select-dissearch" name="year_duplicate"  data-width="150px">
              <?php
              $year_real = date('Y');
              for ($i=0; $i < 5 ; $i++) {
                ?>
                <option value="<?php echo $year_real; ?>"><?php echo $year_real; ?></option>
                <?php
                $year_real++;
              }
               ?>
              </select>
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


<!--  edit_product  -->
<form method="POST" action="method.php?method=add_holiday"  enctype="multipart/form-data" target="iframe-data"  >
  <div class="modal fade edit_holiday" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title title_view" id="exampleModalLabel">แก้ไขวันหยุดราชการ</h4>
        </div>
        <div class="modal-body" id="view_date">

          <div class="row form-group">
            <div class="col-md-4">
              <label for="message-text" class="control-label">เลือกประเภท</label>
            </div>
            <div class="col-md-8">
              <select class="selectpicker chosen-select-dissearch" name="year"  id="year" data-width="auto">
              <?php
              $year_real = date('Y');
              for ($i=0; $i < 5 ; $i++) {
                ?>
                <option value="<?php echo $year_real; ?>"><?php echo $year_real; ?></option>
                <?php
                $year_real++;
              }
               ?>
              </select>
            </div>
          </div>

          <div class="row form-group">
            <div class="col-md-4">
              <label for="recipient-name" class="control-label">ชื่อ<?=$rematk?></label>
            </div>
            <div class="col-md-8">
              <input type="hidden" class="form-control" id="id_edit" name="id_edit" >
              <input type="text" class="form-control" id="edit_name" name="add_name">
            </div>
          </div>

          <div class="row form-group">
            <div class="col-md-4">
              <label for="recipient-name" class="control-label">กำหนดเวลาเริ่มต้น<?=$rematk?></label>
            </div>
            <div class="col-md-5">
              <!-- <div class="input-group"> -->
              <div class="input-group date" data-provide="datepicker"  data-date-format="dd/mm/yyyy">
                  <input type="text" name="date_start" id="date_start_edit"  value=""  class="form-control bootstrap-datepicker ">
                <span class="input-group-addon input-group-addon-calendar bg-black hide_show">
                  <i class="glyph-icon icon-calendar"></i>
                </span>
              </div>
            </div>
          </div>

          <div class="row form-group">
            <div class="col-md-4">
              <label for="recipient-name" class="control-label">กำหนดเวลาสิ้นสุด<?=$rematk?></label>
            </div>
            <div class="col-md-5 ">
              <!-- <div class="input-group"> -->
              <div class="input-group date" data-provide="datepicker"  data-date-format="dd/mm/yyyy">
                <input type="text" name="date_stop" id="date_stop_edit"  value=""  class="form-control bootstrap-datepicker">
                <span class="input-group-addon input-group-addon-calendar bg-black hide_show">
                  <i class="glyph-icon icon-calendar"></i>
                </span>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer footer_close">
          <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
          <?php if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"manager_noti")[2]==1){ ?>
          <button type="submit" class="btn  btn_submit">ตกลง</button>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</form>

<script>
$(function(){
    $(".input-mask").inputmask();
  });

$(document).ready(function() {
  // btn_duplicate();

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
