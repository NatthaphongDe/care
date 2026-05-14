<div class="">
  <div class="title_color">
    <span class="title_icon ditp-icon icon-ico-ditp-05"></span>
    ตั้งค่าระบบ
  </div>
</div>
<div class="box_appeal">
  <div class="row row_title">
    <div class="col-md-6 box_appeal_title">
      <a href="?page=product">
        <span class="txt_pro" > ประเภทสินค้า</span></a> >
        <?php

        $sql_select4 = "SELECT prodType_name,prodType_ref_id FROM Product_Type where prodType_id = '".$_GET['id_product']."'";
        $query_select4 = $conn->query($sql_select4);
        $re4 =   $query_select4->fetch_assoc();
         $title4 = $re4['prodType_name'];
         $prodType_ref_id4 = $re4['prodType_ref_id'];


        $sql_select3 = "SELECT * FROM `Product_Type` WHERE `prodType_id` = '$prodType_ref_id4' AND `prodType_level` = 2 ORDER BY `prodType_ref_id` ASC";
        $query_select3 = $conn->query($sql_select3);
        $re3 =   $query_select3->fetch_assoc();
        $title3 = $re3['prodType_name'];
        $prodType_ref_id3 = $re3['prodType_ref_id'];

        ?>
        <span class="txt_pro" ><a href="?page=product_detail&id_product=<?=$prodType_ref_id3 ?>"><?= $title3 ?></a></span>
          >
        <span class="txt_pro" ><a href="?page=product_detail_lv3&id_product=<?=$prodType_ref_id4 ?>"><?= $title4 ?></a></span>

      </div>
      <div class="col-md-6 search box_s1">
        <div class="box-search display_block" id="icon-search" style="">
          <div class="input_box">
            <input type="text" name="search_text" id="search_text" class="form-control input_box" placeholder="Search" autocomplete="off">
          </div>
        </div>
        <?php if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"manage_system")[2]==1){ ?>
        <button type="button" class="btn_add click_add" data-toggle="modal" data-target=".modal_add_porduct">
          <span class="">เพิ่มประเภทสินค้า</span>
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
      data-url="method.php?method=getproduct_detail_lv4"
      data-query-params="searchQueryParams"
      data-method="post">
      <thead>
        <tr>
          <th data-field="id" data-sortable="false" data-align="center" class="center_table">
            #
          </th>
          <!-- <th data-field="name" data-sortable="true">
            ประเภท<?=$title4?>
          </th> -->
          <th data-field="name" data-sortable="true">
            ชื่อประเภทสินค้า (ไทย)
          </th>
          <th data-field="name_en" data-sortable="true">
            ชื่อประเภทสินค้า (Eng)
          </th>
          <th data-field="detail_view" data-sortable="false"class="center_table">
            ประเภทสินค้าย่อย
          </th>
          <th data-field="view" data-sortable="false" data-align="center" class="center_table">
            แสดงผล
          </th>
          <?php if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"manage_system")[2]==1){ ?>
          <th data-field="del_edit" data-sortable="false"  data-align="center"  class="th_user_width">

          </th>
          <?php } ?>
        </tr>
      </thead>
    </table>
  </div>
</div>

<!--  import_product  -->
<div class="modal fade import_product" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Import Product</h4>
      </div>
      <div class="modal-body">
        <div class="row ">
          <div class="x-detail" style="margin-top:10px;">
            <div class="col-xs-4">
              <div class="asset-detail-titlex">Upload Excel</div>
            </div>
            <div class="col-xs-8">
              <input type="file" id="browse" name="userimport" style="display: none" onChange="Handlechange();" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"/>	<input type="hidden" name="import" value="1" />
              <div style="float:left;width:calc(100%-110px); display:table; margin-right:10px;" >
                <input type="text" id="filename" readonly="true" class="form-control input-browse" style="margin-left:0px;  border:1px solid #ccc;"/>
              </div>
              <div style="float:left; width:100px; display:table;">
                <input type="button" value="Browse.." id="fakeBrowse" onclick="HandleBrowseClick();" class="btn btn-btn" style="height:30px; line-height:30px; padding-left:20px; padding-right:20px; padding-top:0px; padding-bottom:0px;  border:1px solid #ccc;  width:100px;"/>
              </div>
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


<!--  import_product  -->
<form method="POST" action="method.php?method=add_product_detail"  enctype="multipart/form-data" target="iframe-data"  >
  <div class="modal fade modal_add_porduct" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel">เพิ่มประเภทสินค้า</h4>
        </div>
        <div class="modal-body">
          <div class="row form-group">
            <div class="col-md-5">
              <label for="recipient-name" class="control-label">ชื่อประเภทสินค้าย่อย (ไทย)<?=$rematk?></label>
            </div>
            <div class="col-md-7">
              <input type="hidden" class="form-control" id="recipient-name" name="add_appeal" >
              <input type="text" class="form-control" id="add_name" name="add_name" onkeyup="this.value = isThaichar(this.value,this)">
              <input type="hidden" class="form-control" id="input_lv" name="input_lv" value="4">
              <input type="hidden" name="type_p" value="<?=$_GET['id_product']?>">

            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-5">
              <label for="recipient-name" class="control-label">ชื่อประเภทสินค้า (Eng)<?=$rematk?></label>
            </div>
            <div class="col-md-7">
              <input type="text" class="form-control" id="add_name_en" name="add_name_en" onkeyup="this.value = isThaichar_en(this.value,this)">
            </div>
          </div>
          <div class="row">
            <div class="col-md-5">
              <label for="message-text" class="control-label">การแสดงผล</label>
            </div>
            <div class="col-md-7">
              <div class="col-md-3">
                <div class="radio radio-danger">
                  <input type="radio" name="radio_url_cms" id="ch1" value="1"  checked="">
                  <label for="ch1">
                    เปิด
                  </label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="radio radio-danger ">
                  <input type="radio" name="radio_url_cms" id="ch2" value="0">
                  <label for="ch2">
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

<form method="POST" action="method.php?method=edit_product"  enctype="multipart/form-data" target="iframe-data"  >
  <div class="modal fade edit_product" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title title_view" id="exampleModalLabel">แก้ไขประเภทสินค้า</h4>
        </div>
        <div class="modal-body" id="view_date">
          <div class="row form-group">
            <div class="col-md-5">
              <label for="recipient-name" class="control-label" name="edit_name">ชื่อประเภทสินค้าย่อย (ไทย)<?=$rematk?></label>
            </div>
            <div class="col-md-7">
              <input type="text" class="form-control edit_name" id="edit_name" name="edit_name" onkeyup="this.value = isThaichar(this.value,this)">
              <input type="hidden" class="id_edit" id="id_edit" name="id_edit">
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-5">
              <label for="recipient-name" class="control-label" name="edit_name">ชื่อประเภทสินค้าย่อย (Eng)<?=$rematk?></label>
            </div>
            <div class="col-md-7">
              <input type="text" class="form-control edit_name" id="edit_name_en" name="edit_name_en" onkeyup="this.value = isThaichar_en(this.value,this)">
            </div>
          </div>

          <div class="row" id="product_del_none">
            <div class="col-md-5">
              <label for="message-text" class="control-label">การแสดงผล</label>
            </div>
            <div class="col-md-7">
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
        </div>
        <div class="modal-footer footer_close">
          <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
          <button type="submit" class="btn  btn_submit">ตกลง</button>
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

});
function searchQueryParams(params) {
  params.text = $("input[name='search_text']").val();
  if($('.search_date').prop("disabled")==false){
    params.date = $('.search_date').val();
  }
  params.id_product = "<?=$_GET['id_product']?>";
  return params; // body data
}


</script>
