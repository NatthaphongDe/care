<div class="">
  <div class="title_color">
    <span class="title_icon ditp-icon icon-ico-ditp-05"></span>
    ตั้งค่าระบบ
  </div>
</div>
<div class="box_appeal">
  <div class="row row_title">
    <div class="col-md-4 box_appeal_title">
      ระบบจัดการฟอร์ม
    </div>
    <div class="col-md-8 col-xs-12 search box_s1">
      <select class="selectpicker col-xs-2 chosen-select-dissearch display_block" name="status_form"  id="status_form" data-width="auto">
        <option value="">--- All Status ---</option>
        <option value="1">ฟอร์มที่ใชงานได้</option>
        <option value="2">ฟอร์มที่หมดอายุการใช้งาน</option>
      </select>
      <div class="box-search display_block" id="icon-search" style="">
        <div class="input_box">
          <input type="text" name="search_text" id="search_text" class="form-control input_box" placeholder="Search" autocomplete="off">
        </div>
      </div>
      <?php if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"manager_form")[2]==1){ ?>
        <a href="?page=form_add&val=1">
          <button type="button" class="btn_add click_add btn_add_left pd_btn_10" >
            <span class="">สร้างฟอร์ม</span>
          </button>
        </a>
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
      data-url="method.php?method=getform"
      data-query-params="searchQueryParams"
      data-method="post">
      <thead>
        <th data-field="name" data-sortable="true" class="name_table_250">
          ชื่อ
        </th>
        <th data-field="day" data-sortable="true" data-align="center" class="center_table">
          ระยะเวลาใช้งานฟอร์ม
        </th>
        <?php if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"manager_form")[2]==1){ ?>
          <th data-field="del_edit" data-sortable="false"  data-align="-webkit-center" >
          </th>
          <?php } ?>
        </tr>
      </thead>
    </table>
  </div>
</div>

<form method="POST" action="method.php?method=copy_from"  enctype="multipart/form-data" target="iframe-data"  >
  <div class="modal fade copy_from" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel">คัดลอกฟอร์มประเภทของเรื่องร้องเรียน</h4>
        </div>
        <div class="modal-body">
          <div class="row form-group">
            <div class="x-detail" style="margin-top:10px;">
              <div class="col-xs-3">
                <div class="asset-detail-titlex">ชื่อฟอร์ม<?=$rematk?></div>
              </div>
              <div class="col-xs-9">
                <input class="form-control" type="text" name="new_name" value="">
                <input type="hidden" name="cop_id" id="cop_id" value="">
              </div>
            </div>
          </div>

          <div class="row form-group">
            <div class="col-sm-3">
              ระยะเวลาใช้งานฟอร์มตั้งแต่<?=$rematk?>
            </div>
            <div class="col-sm-4">
              <!-- <div class="input-group"> -->
              <div class="input-group date" data-provide="datepicker"  data-date-format="dd/mm/yyyy">
                <input type="text" name="date_start_copy" id="date_start_copy" class="form-control bootstrap-datepicker input-mask" data-inputmask="'mask':'99/99/9999'" >
                <span class="input-group-addon input-group-addon-calendar bg-black">
                  <i class="glyph-icon icon-calendar"></i>
                </span>
              </div>
            </div>
            <div class="col-sm-1">
              ถึง<?=$rematk?>
            </div>
            <div class="col-sm-4">
              <!-- <div class="input-group"> -->
              <div class="input-group date" data-provide="datepicker"  data-date-format="dd/mm/yyyy">
                <input type="text" name="date_stop_copy" id="date_stop_copy" class="form-control bootstrap-datepicker input-mask" data-inputmask="'mask':'99/99/9999'" >
                <span class="input-group-addon input-group-addon-calendar bg-black">
                  <i class="glyph-icon icon-calendar"></i>
                </span>
              </div>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
          <button type="submit" class="btn  btn_submit" onclick="add_channel();">ตกลง</button>
        </div>
      </div>
    </div>
  </div>
</form>
<script type="text/javascript" src="../assets/widgets/chosen/chosen.js"></script>
<script>
$(document).ready(function() {
  $(".input-mask").inputmask();

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
  $("select[name='status_form']").on('change', function() {
    $('.table-caseCh-list').bootstrapTable('refresh');
  });

});
function searchQueryParams(params) {
  params.status_form = $("select[name='status_form']").val();
  params.text = $("input[name='search_text']").val();
  if($('.search_date').prop("disabled")==false){
    params.date = $('.search_date').val();
  }
  return params; // body data
}


</script>
