<div class="">
  <div class="title_color">
    <span class="title_icon ditp-icon icon-ico-ditp-05"></span>
    ตั้งค่าระบบ
  </div>
</div>
<div class="box_appeal">
  <div class="row row_title">
    <div class="col-md-2  box_appeal_title">
      Banner
    </div>
    <div class="col-md-10 col-xs-12 search box_s1">
      <select class="selectpicker col-xs-2 chosen-select-dissearch display_block" name="status_m"  id="status_m" data-width="200px">
        <option value="">--- การแสดงผล ---</option>
        <option value="1">เปิด</option>
        <option value="0">ปิด</option>
      </select>
    <?php if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"manage_system")[2]==1){ ?>
      <button type="button" class="btn_add click_add display_block pd_btn_10" data-toggle="modal" data-target=".modal_add_porduct">
        <span class="">เพิ่ม Banner</span>
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
    data-url="method.php?method=getbanner"
    data-query-params="searchQueryParams"
    data-method="post">
    <thead>
      <tr>
        <th data-field="id" data-sortable="false" data-align="center" class="center_table">
        #
      </th>
      <th data-field="name" data-sortable="false" class="center_table"  >
        รูป (ไทย)
      </th>
      <th data-field="ing_en" data-sortable="false" class="center_table"  >
        รูป (Eng)
      </th>
      <th data-field="up_down" data-sortable="false" class="center_table Banner">
        ลำดับ
      </th>
      <th data-field="view" data-sortable="false" data-align="center" class="center_table">
        แสดงผล
      </th>
      <?php if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"manage_system")[2]==1){ ?>
      <th data-field="del_edit" data-sortable="false"  data-align="center" class="th_user_width width_center"
      </th>
      <?php } ?>
    </tr>
  </thead>
</table>
</div>
</div>


<!--  add_product  -->
<form method="POST" action="method.php?method=add_banner"  enctype="multipart/form-data" target="iframe-data"  >
  <div class="modal fade modal_add_porduct" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content modal_pri">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel">เพิ่ม banner</h4>
        </div>
        <div class="modal-body">

          <div class="row">
            <div class="col-md-3 ">
              <label for="recipient-name" class="control-label">รูป (ไทย)<?=$rematk?></label>
            </div>
            <div class="col-md-9">
              <div class="pre" style="padding-bottom: 10px;">
                <img id="output" class="img_pre_banner"/>
              </div>
              <input type="file" id="browse" name="pic_upload" style="display: none" onChange="Handlechange()& loadFile(event);" accept="image/x-png, image/gif, image/jpeg"/>
              <div class="box_im" >

                <input type="text" id="filename" readonly="true" class="form-control add-image-text box_im_input" />
              </div>
              <div class="box_impo" >

                <input type="button" value="Browse" id="fakeBrowse" onclick="HandleBrowseClick();"  class="btn btn-black-2 box_btn_impoet_id"/>
              </div>
              <label class="lb_txt">เลือกรูปขนาด (1920 x 569 pixels) (.png , .gif , .jpg)</label>
            </div>
          </div>

          <div class="row">
            <div class="col-md-3 ">
              <label for="recipient-name" class="control-label">รูป (Eng)<?=$rematk?></label>
            </div>
            <div class="col-md-9">
              <div class="pre_en" style="padding-bottom: 10px;">
                <img id="output_en" class="img_pre_banner"/>
              </div>
              <input type="file" id="browse_en" name="pic_upload_en" style="display: none" onChange="Handlechange_en()& loadFile_en(event);" accept="image/x-png, image/gif, image/jpeg"/>
              <div class="box_im" >

                <input type="text" id="filename_en" readonly="true" class="form-control add-image-text box_im_input" />
              </div>
              <div class="box_impo" >

                <input type="button" value="Browse" id="fakeBrowse_en" onclick="HandleBrowseClick_en();"  class="btn btn-black-2 box_btn_impoet_id"/>
              </div>
              <label class="lb_txt">เลือกรูปขนาด (1920 x 569 pixels) (.png , .gif , .jpg)</label>
            </div>
          </div>


          <div class="row form-group">
            <div class="col-md-3 ">
              <label for="message-text" class="control-label">การแสดงผล</label>
            </div>
            <div class="col-md-9">
              <div class="col-md-2">
                <div class="radio radio-danger">
                  <input type="radio" name="status" id="ch1" value="1"  checked="checked" >
                  <label for="ch1">
                    เปิด
                  </label>
                </div>
              </div>
              <div class="col-md-2">
                <div class="radio radio-danger ">
                  <input type="radio" name="status" id="ch2" value="0">
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


<!--  edit_product  -->
<form method="POST" action="method.php?method=add_banner"  enctype="multipart/form-data" target="iframe-data"  >
  <div class="modal fade edit_banner" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <input type="hidden" name="id_edit" value="" id="id_edit">
      <div class="modal-content modal_pri">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel">แก้ไข Banner</h4>
        </div>
        <div class="modal-body">

          <div class="row form-group">
            <div class="col-md-3 ">
              <label for="recipient-name" class="control-label">รูป (ไทย)<?=$rematk?></label>
              <input type="hidden" id="default_img">
            </div>
            <div class="col-md-9">
              <div class="pre_edit" style="padding-bottom: 10px;">
                <img id="output_edit" class="img_pre_banner"/>
              </div>
              <input type="file" id="browse_edit1" name="pic_upload" style="display: none" onChange="Handlechange_edit() & loadFile_edit(event)" accept="image/x-png, image/gif, image/jpeg"/>
									<div class="box_im">
										<input type="text" id="filename_edit" readonly="true" class="form-control add-image-text box_im_input" />
									</div>
									<div class="box_impo" >
										<input type="button" value="Browse.." id="fakeBrowse_edit" onclick="HandleBrowseClick_edit();" class="btn btn-black-2 box_btn_impoet_id"/>
									</div>
              <label class="lb_txt">เลือกรูปขนาด (1920 x 569 pixels) (.png , .gif , .jpg)</label>
            </div>
          </div>

          <div class="row form-group">
            <div class="col-md-3 ">
              <label for="recipient-name" class="control-label">รูป (Eng)<?=$rematk?></label>
              <input type="hidden" id="default_img_en">
            </div>
            <div class="col-md-9">
              <div class="pre_edit_en" style="padding-bottom: 10px;">
                <img id="output_edit_en" class="img_pre_banner"/>
              </div>
              <input type="file" id="browse_edit1_en" name="pic_upload_en" style="display: none" onChange="Handlechange_edit_en() & loadFile_edit_en(event)" accept="image/x-png, image/gif, image/jpeg"/>
                  <div class="box_im">
                    <input type="text" id="filename_edit_en" readonly="true" class="form-control add-image-text box_im_input" />
                  </div>
                  <div class="box_impo" >
                    <input type="button" value="Browse.." id="fakeBrowse_edit_en" onclick="HandleBrowseClick_edit_en();"    class="btn btn-black-2 box_btn_impoet_id"/>
                  </div>
              <label class="lb_txt">เลือกรูปขนาด (1920 x 569 pixels) (.png , .gif , .jpg)</label>
            </div>
          </div>

          <div class="row form-group hide_edit">
            <div class="col-md-3 ">
              <label for="message-text" class="control-label">การแสดงผล</label>
            </div>
            <div class="col-md-9">
              <div class="col-md-2">
                <div class="radio radio-danger">
                  <input type="radio" name="status" id="ch1_edit" value="1">
                  <label for="ch1_edit">
                    เปิด
                  </label>
                </div>
              </div>
              <div class="col-md-2">
                <div class="radio radio-danger ">
                  <input type="radio" name="status" id="ch2_edit" value="0">
                  <label for="ch2_edit">
                    ปิด
                  </label>
                </div>
            </div>
          </div>
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
          <?php if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"manage_system")[2]==1){ ?>
          <button type="submit" class="btn  btn_submit">ตกลง</button>
          <?php   } ?>
        </div>
      </div>
    </div>
  </div>
</form>

<script>

function HandleBrowseClick_edit()
{
  var fileinput = document.getElementById("browse_edit1");
  fileinput.click();
}
function HandleBrowseClick_edit_en()
{
  var fileinput = document.getElementById("browse_edit1_en");
  fileinput.click();
}


function Handlechange_edit()
{
  var fileinput = document.getElementById("browse_edit1");
  var textinput = document.getElementById("filename_edit");
  textinput.value = fileinput.value;
}
function Handlechange_edit_en()
{
  var fileinput = document.getElementById("browse_edit1_en");
  var textinput = document.getElementById("filename_edit_en");
  textinput.value = fileinput.value;
}



function HandleBrowseClickxc(id){
  $('#id_p').val(id);
  $('#browse_edit').click();

}

function HandleBrowseClick_en()
{
  var fileinput = document.getElementById("browse_en");
  fileinput.click();
}
function Handlechange_en()
{
  var fileinput = document.getElementById("browse_en");
  var textinput = document.getElementById("filename_en");
  textinput.value = fileinput.value;
}

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
  $('.pre').hide();
  $('.pre_en').hide();
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
  $("select[name='status_m']").on('change', function() {
    $('.table-caseCh-list').bootstrapTable('refresh');
  });

});
function searchQueryParams(params) {
  params.status_m = $("select[name='status_m']").val();
  params.text = $("input[name='search_text']").val();
  if($('.search_date').prop("disabled")==false){
    params.date = $('.search_date').val();
  }
  return params; // body data
}


function autoupload(){
  $("#add_images").submit();
}
$("#sum_edit").change(function() {
  $("#edit_pri").submit();
});


var loadFile = function(event) {
  $('.pre').show();
  var output = document.getElementById('output');
  if(event.target.files[0]!=undefined){
    output.src = URL.createObjectURL(event.target.files[0]);
  }else{
    $('.pre').hide();
  }
};

var loadFile_en = function(event) {
  $('.pre_en').show();
  var output = document.getElementById('output_en');
  if(event.target.files[0]!=undefined){
    output.src = URL.createObjectURL(event.target.files[0]);
  }else{
    $('.pre_en').hide();
  }
};



var loadFile_edit = function(event) {
  $('.pre_edit').html('');
  $('.pre_edit').html('<img id="output_edit" class="img_pre_banner">');
  $('.pre_edit').show();
  var output_edit = document.getElementById('output_edit');
  if(event.target.files[0]!=undefined){
    output_edit.src = URL.createObjectURL(event.target.files[0]);
  }else{
    output_edit.src = $('#default_img').val();
  }
};

var loadFile_edit_en = function(event) {
  $('.pre_edit_en').html('');
  $('.pre_edit_en').html('<img id="output_edit_en" class="img_pre_banner">');
  $('.pre_edit_en').show();
  var output_edit_en = document.getElementById('output_edit_en');
  if(event.target.files[0]!=undefined){
    output_edit_en.src = URL.createObjectURL(event.target.files[0]);
  }else{
    output_edit_en.src = $('#default_img_en').val();
  }
};



</script>
