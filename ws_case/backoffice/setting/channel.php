<div class="">
  <div class="title_color">
    <span class="title_icon ditp-icon icon-ico-ditp-05"></span>
    ตั้งค่าระบบ
  </div>
</div>
<div class="box_appeal">
  <div class="row row_title">
    <div class="col-md-12 col-lg-4 box_appeal_title">
      ช่องทางการรับเรื่องร้องเรียน
    </div>
    <div class="col-md-12 col-lg-8 search box_s1 float_right">
      <select class="selectpicker col-xs-2 chosen-select-dissearch display_block" name="status_m"  id="status_m" data-width="200px">
        <option value="">--- เลือกประเภท ---</option>
        <option value="1">สสบ.</option>
        <option value="2">นิติการ</option>
      </select>
      <div class="box-search display_block" id="icon-search" style="">
        <input type="text" name="search_text" id="search_text" class="form-control input_box" placeholder="Search" autocomplete="off">
      </div>
      <?php if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"manage_system")[2]==1){ ?>
      <button type="button" class="btn_add click_add display_block pd_btn_10" data-toggle="modal" data-target=".bs-example-modal-lg">
        <span class="">เพิ่มช่องทางการรับเรื่องร้องเรียน</span>
      </button>
      <?php } ?>
    </div>
  </div>
  <!-- </div> -->
  <div class="tabla_data">
    <table data-toggle="table" class="table-caseCh-list"
    data-sort-name="id"
    data-sort-status="view"
    data-sort-order="DESC"
    data-side-pagination="server"
    data-pagination="true"
    data-page-size="10"
    data-page-list="[10, 50, 100, 200, ALL]"
    data-url="method.php?method=getchannel"
    data-query-params="searchQueryParams"
    data-method="post">
    <thead>
      <tr>
        <th data-field="id" data-sortable="false" data-align="center" class="center_table">
          #
        </th>
        <th data-field="name" data-sortable="true" class="name_table_250">
          ชื่อ
        </th>
        <th data-field="detail_view" data-sortable="false" class="center_table">
          ช่องทางย่อย
        </th>
        <th data-field="type" data-sortable="true" class="center_table">
          ประเภท
        </th>
        <th data-field="view" data-sortable="true" data-align="center" class="center_table">
          แสดงผล
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

<form method="POST" action="method.php?method=add_channel"  enctype="multipart/form-data" target="iframe-data"  >
  <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel">เพิ่มช่องทางการรับเรื่องร้องเรียน</h4>
        </div>
        <div class="modal-body">

          <div class="row form-group">
            <div class="col-md-3">
              <label for="message-text" class="control-label">ประเภท</label>
            </div>
            <div class="col-md-9">
              <div class="col-md-4">
                <div class="radio radio-danger">
                  <input type="radio" name="radio_section" value="1"  checked="checked" id="add1_section" >
                  <label for="add1_section">
                    สสบ.
                  </label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="radio radio-danger ">
                  <input type="radio" name="radio_section" value="2" id="add_section">
                  <label for="add_section">
                    นิติการ
                  </label>
                </div>
              </div>
            </div>
          </div>

          <div class="row form-group">
            <div class="col-md-3">
              <label for="recipient-name" class="control-label">ชื่อช่องทาง<?=$rematk?></label>
            </div>
            <div class="col-md-9">
              <input type="hidden" class="form-control" id="recipient-name" name="add_appeal" value="1" >
              <input type="text" class="form-control" id="add_name" name="add_name">
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-3">
              <label for="message-text" class="control-label">การแสดงผล</label>
            </div>
            <div class="col-md-9">
              <div class="col-md-4">
                <div class="radio radio-danger">
                  <input type="radio" name="radio_ststus" id="radio3" value="1"  checked="checked" >
                  <label for="radio3">
                    เปิด
                  </label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="radio radio-danger ">
                  <input type="radio" name="radio_ststus" id="radio4" value="0">
                  <label for="radio4">
                    ปิด
                  </label>
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
<form method="POST" action="method.php?method=add_channel"  enctype="multipart/form-data" target="iframe-data"  >
  <div class="modal fade bs-example-modal-lg_edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title title_view" id="exampleModalLabel">แก้ไขช่องทางการรับเรื่องร้องเรียน</h4>
        </div>
        <div class="modal-body" id="view_date">
          <div class="row form-group channel_hide">
            <div class="col-md-3">
              <label for="message-text" class="control-label">ประเภท</label>
            </div>
            <div class="col-md-9">
              <div class="col-md-4">
                <div class="radio radio-danger">
                  <input type="radio" name="radio_section" id="ch1_section" value="1">
                  <label for="ch1_section">
                    สสบ.
                  </label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="radio radio-danger ">
                  <input type="radio" name="radio_section" id="ch2_section" value="2">
                  <label for="ch2_section">
                    นิติการ
                  </label>
                </div>
              </div>
            </div>
          </div>

          <div class="row form-group">
            <div class="col-md-3">
              <label for="recipient-name" class="control-label">ชื่อช่องทาง<?=$rematk?></label>
            </div>
            <div class="col-md-9">
              <input type="text" class="form-control edit_name" name="add_name" id="edit_name" >
              <input type="hidden" class="id_edit" name="id_edit" id="id_edit">
            </div>
          </div>
          <div class="row channel_hide">
            <div class="col-md-3">
              <label for="message-text" class="control-label">การแสดงผล</label>
            </div>
            <div class="col-md-9">
              <div class="col-md-4">
                <div class="radio radio-danger">
                  <input type="radio" name="radio_ststus" id="ch1_edit" value="1"  checked="checked" >
                  <label for="ch1_edit">
                    เปิด
                  </label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="radio radio-danger ">
                  <input type="radio" name="radio_ststus" id="ch2_edit" value="0">
                  <label for="ch2_edit">
                    ปิด
                  </label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer footer_close">
          <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
          <?php if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"manage_system")[2]==1){ ?>
          <button type="submit" class="btn  btn_submit" onclick="">ตกลง</button>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</form>
<script>

$(document).ready(function() {

     $('.table-caseCh-list').on('load-success.bs.table', function (e) {
        auto_resize_menu();
     });
     $("input[name='search_prod_type']").change(function() {
       /* Act on the event */
     });

    $("input[name='search_text']").keypress(function(e) {
      if(e.which == 13) {
        console.log($("input[name='search_text']").val());
        $('.table-caseCh-list').bootstrapTable('refresh');
      }
    });
    $("select[name='status_m']").on('change', function() {
      $('.table-caseCh-list').bootstrapTable('refresh');
    });
 });
 function searchQueryParams(params) {
   params.status_m = $("select[name='status_m']").val();
   params.text = $("input[name='search_text']").val();
   return params; // body data
 }

</script>
