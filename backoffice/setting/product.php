<div class="">
  <div class="title_color">
    <span class="title_icon ditp-icon icon-ico-ditp-05"></span>
    ตั้งค่าระบบ
  </div>
</div>
<div class="box_appeal">
  <div class="row row_title">
    <div class="col-lg-2 col-md-12 box_appeal_title">
      ประเภทสินค้า
    </div>
    <div class="col-lg-10 col-xs-12  search box_s1">
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
      <br style="display:none;">
      <!-- <a href="../../data/setting/template/Template_product.xlsx">
        <button type="button" class="btn_import click_add click_add_re" data-toggle="modal">
          <i class="fa fa-download" aria-hidden="true"></i>
          <span class="">Download Template</span>
        </button>
      </a>
      <button type="button" class="btn_import click_add" data-toggle="modal" data-target=".import_product">
        <i class="fa fa-file-excel-o" aria-hidden="true"></i>
        <span class="">import</span>
      </button> -->
      <button type="button" class="btn_add click_add pd_btn_10" data-toggle="modal" data-target=".modal_add_porduct">
        <span class="">เพิ่มประเภทสินค้า</span>
      </button>
      <?php } ?>
    </div>
  </div>
<div class="tabla_data">
  <table data-toggle="table" class="table-caseCh-list"
  data-sort-name="id"
  data-sort-order="ASC"
  data-side-pagination="server"
  data-pagination="true"
  data-page-size="10"
  data-page-list="[10, 50, 100, 200, ALL]"
  data-url="method.php?method=getproduct"
  data-query-params="searchQueryParams"
  data-method="post">
  <thead>
    <tr>
      <th data-field="id" data-sortable="false" data-align="center" class="center_table">
      #
    </th>
    <th data-field="name" data-sortable="true">
      ชื่อประเภทสินค้า (ไทย)
    </th>
    <th data-field="name_en" data-sortable="true">
      ชื่อประเภทสินค้า (Eng)
    </th>
    <!-- <th data-field="detail_view" data-sortable="false" class="center_table">
      ประเภทสินค้าย่อย
    </th> -->
    <th data-field="view" data-sortable="false" data-align="center" class="center_table">
      แสดงผล
    </th>
    <?php if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"manage_system")[2]==1){ ?>
    <th data-field="del_edit" data-sortable="false"  data-align=""  class="th_user_width width_center">
    </th>
    <?php } ?>
  </tr>
</thead>
</table>
</div>
</div>

<!--  import_product  -->
<form method="POST" action="method.php?method=import_product"  enctype="multipart/form-data" target="iframe-data"  >
  <div class="modal fade import_product" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel">Import Product</h4>
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
                <div class="box_im" >
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

<!--  import_product  -->
<form method="POST" action="method.php?method=add_product"  enctype="multipart/form-data" target="iframe-data"  >
  <div class="modal fade modal_add_porduct" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel">เพิ่มประเภทสินค้า</h4>
        </div>
        <div class="modal-body">




          <div class="row form-group">
            <div class="col-md-4">
              <label for="recipient-name" class="control-label">ชื่อประเภทสินค้า (ไทย)<?=$rematk?></label>
            </div>
            <div class="col-md-8">
              <input type="hidden" class="form-control" id="recipient-name" name="add_appeal" >
              <input type="text" class="form-control" id="add_name" name="add_name" onkeyup="this.value = isThaichar(this.value,this)" onpaste="this.value = isThaichar(this.value,this)" >
            </div>
          </div>


          <div class="row form-group">
            <div class="col-md-4">
              <label for="recipient-name" class="control-label">ชื่อประเภทสินค้า (Eng)<?=$rematk?></label>
            </div>
            <div class="col-md-8">
              <input type="text" class="form-control" id="add_name_en" name="add_name_en" onkeyup="this.value = isThaichar_en(this.value,this)" onpaste="this.value = isThaichar_en(this.value,this)">
            </div>
          </div>

          <!-- <div class="row form-group">
            <div class="col-md-4">
              <label for="recipient-name" class="control-label">สำนัก<?=$rematk?></label>
            </div>
            <div class="col-md-8">
              <select class="selectpicker" name="office_name"  data-width="100%">
                <option value="">--- เลือกสำนัก ---</option>
                <option value="0">สำนักสารสนเทศและการบริการการค้าระหว่างประเทศ</option>
                <?php
                foreach ($obj->getofficetype() as $listCountry) {
                      echo "<option value=".$listCountry["office_id"].">".$listCountry["office_name"]."</option>";
                }
                 ?>
               </select>
            </div>
          </div> -->

          <div class="row ">
            <div class="col-md-4">
              <label for="message-text" class="control-label">การแสดงผล</label>
            </div>
            <div class="col-md-8">
              <div class="col-md-3">
                <div class="radio radio-danger">
                  <input type="radio" name="radio_url_cms" id="radio3" value="1"  checked="checked" >
                  <label for="radio3">
                    เปิด
                  </label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="radio radio-danger ">
                  <input type="radio" name="radio_url_cms" id="radio4" value="0">
                  <label for="radio4">
                    ปิด
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 ">
              <label for="message-text" class="control-label">ระบุเพิ่มเติม</label>
            </div>
            <div class="col-md-8">
              <div class="col-md-3">
                <div class="radio radio-danger">
                  <input type="radio" name="ra_other" id="ra_oth1" value="1" >
                  <label for="ra_oth1">
                    มี
                  </label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="radio radio-danger ">
                  <input type="radio" name="ra_other" id="ra_oth2" value="0" checked>
                  <label for="ra_oth2">
                  ไม่มี
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


<!--  import_product  -->
<div class="modal fade modal_add_porduct_ststus" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
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
<!-- </form> -->


<form method="POST" action="method.php?method=save_product"  enctype="multipart/form-data" target="iframe-data"  >
  <div class="modal fade edit_product" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title title_view" id="exampleModalLabel">แก้ไขประเภทสินค้า</h4>
        </div>
        <div class="modal-body" id="view_date">
          <div class="row form-group">
            <div class="col-md-4">
              <label for="recipient-name" class="control-label" name="edit_name">ชื่อประเภทสินค้า (ไทย)<?=$rematk?></label>
            </div>
            <div class="col-md-8">
              <input type="text" class="form-control edit_name" id="edit_name" name="edit_name" onkeyup="this.value = isThaichar(this.value,this)">
              <input type="hidden" class="id_edit" id="id_edit" name="id_edit">

            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-4">
              <label for="recipient-name" class="control-label" name="edit_name">ชื่อประเภทสินค้า (Eng)<?=$rematk?></label>
            </div>
            <div class="col-md-8">
              <input type="text" class="form-control edit_name" id="edit_name_en" name="edit_name_en" onkeyup="this.value = isThaichar_en(this.value,this)" >
            </div>
          </div>

          <!-- <div class="row form-group">
            <div class="col-md-4">
              <label for="recipient-name" class="control-label">สำนัก<?=$rematk?></label>
            </div>
            <div class="col-md-8">
              <select class="selectpicker office_name" name="office_name"  id="office_name" data-width="100%">
                <option value="">--- เลือกสำนัก ---</option>
                <option value="0">สำนักสารสนเทศและการบริการการค้าระหว่างประเทศ</option>
                <?php
                foreach ($obj->getofficetype() as $listCountry) {
                      echo "<option value=".$listCountry["office_id"].">".$listCountry["office_name"]."</option>";
                }
                 ?>
               </select>
            </div>
          </div> -->


          <div class="row product_del_none" id="product_del_none">
            <div class="col-md-4">
              <label for="message-text" class="control-label">การแสดงผล</label>
            </div>
            <div class="col-md-8">
              <div class="col-md-3">
                <div class="radio radio-danger">
                  <input type="radio" name="radio_url_cms" id="ch1_edit" value="1" >
                  <label for="ch1_edit">
                    เปิด
                  </label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="radio radio-danger ">
                  <input type="radio" name="radio_url_cms" id="ch2_edit" value="0">
                  <label for="ch2_edit">
                    ปิด
                  </label>
                </div>
              </div>
            </div>
          </div>

          <div class="row product_del_none" id="product_del_none_1">
            <div class="col-md-4 ">
              <label for="message-text" class="control-label">ระบุเพิ่มเติม</label>
            </div>
            <div class="col-md-8">
              <div class="col-md-3">
                <div class="radio radio-danger">
                  <input type="radio" name="ra_edit_other" id="ra_edit_oth1" value="1" >
                  <label for="ra_edit_oth1">
                    มี
                  </label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="radio radio-danger ">
                  <input type="radio" name="ra_edit_other" id="ra_edit_oth2" value="0">
                  <label for="ra_edit_oth2">
                  ไม่มี
                  </label>
                </div>
              </div>
            </div>
          </div>

        </div>
        <div class="modal-footer footer_close">
          <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
          <button type="submit" class="btn  btn_submit" >ตกลง</button>
        </div>
      </div>
    </div>
  </div>
</form>
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

});

$(document).on('click','.btn-click-search',function() {
  $('.table-caseCh-list').bootstrapTable('refresh');
});

function searchQueryParams(params) {
  params.text = $("input[name='search_text']").val();
  if($('.search_date').prop("disabled")==false){
    params.date = $('.search_date').val();
  }
  return params; // body data
}
</script>
