<div class="">
  <div class="title_color">
    <i class="ditp-icon icon-ico-ditp-04"></i>
    จัดการผู้ใช้
  </div>
</div>
<div class="box_appeal">
  <div class="row row_title">
    <div class="col-lg-12 col-md-12 box_appeal_title pd__10">
      DITP Application member
    </div>
    <div class="col-lg-12 col-xs-12 col-md-12 search box_s1 ">
      <select class="selectpicker col-xs-2 chosen-select-dissearch display_block box_app pd_btn_app" name="status_t"  id="status_t" data-width="150px">
        <option value="">--- ประเภทบุคคล ---</option>
        <option value="0">บุคคลธรรดา</option>
        <option value="1">นิติบุคคล</option>
      </select>
      <select class="selectpicker col-xs-2 chosen-select-dissearch display_block box_app pd_btn_app" name="status_m"  id="status_m" data-width="150px">
        <option value="">--- ประเภทการใช้งานทั้งหมด ---</option>
        <option value="1">เปิด</option>
        <option value="0">ปิด</option>
      </select>
      <select class="selectpicker col-xs-2 chosen-select-dissearch box_app pd_btn_app" name="Department_members"  id="Department_members" data-width="150px">
        <option value="">--- ประเภทสมาชิกกรม ---</option>
        <option value="1">เป็นสมาชิกกรม</option>
        <option value="2">ไม่เป็นสมาชิกกรม</option>
        <option value="0">บุคคลธรรมดา</option>
      </select>
      <select class="selectpicker col-xs-2 chosen-select-dissearch box_app pd_btn_app" name="login_f_m"  id="login_f_m" data-width="180px">
        <option value="">--- ประเภทการเข้าสู่ระบบ ---</option>
        <option value="1">Facebook Login</option>
        <option value="0">Manual Login</option>
      </select>
      <select class="selectpicker col-xs-2 chosen-select-dissearch box_app pd_btn_app" name="fonfrim"  id="fonfrim" data-width="180px">
        <option value="">--- ประเภทยืนยันสมาชิก ---</option>
        <option value="1">ยืนยัน</option>
        <option value="0">ไม่ยืนยัน</option>
      </select>
      <div class="filter_report">
        <div class="input-group report_search">
          <input type="text" name="search_text" id="search_text" class="form-control input_box" placeholder="Search" autocomplete="off">
          <span class="input-group-addon bg-black btn-click-search">
            <i class="glyphicon glyphicon-search"></i>
          </span>
        </div>
      </div>
      <!-- <div class="box-search display_block box_pd_app pd_btn_app pd_btn_app pd1580" id="icon-search" style="">
        <div class="input_box">
          <input type="text" name="search_text" id="search_text" class="form-control input_box" placeholder="Search" autocomplete="off">
        </div>
      </div> -->
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
    data-url="user/method.php?method=getform_application"
    data-query-params="searchQueryParams"
    data-method="post">
    <thead>
      <th data-field="name" data-sortable="true" data-align="left" class="th_user">
      ชื่อ - สกุล
      </th>
      <th data-field="email" data-sortable="true"  data-align="left" class="th_user">
        E-mail
      </th>
      <th data-field="type_mem" data-sortable="true"  data-align="left" class="th_user center_table">
        ประเภทบุคคล
      </th>
      <th data-field="member" data-sortable="true"  data-align="left" class="th_user center_table">
        สมาชิกกรม
      </th>
      <th data-field="type" data-sortable="true"  data-align="center" class="center_table">
        การเข้าสู่ระบบ
      </th>
      <th data-field="confirm" data-sortable="true"  data-align="center" class="center_table">
        ยืนยันสมาชิก
      </th>
      <th data-field="ststus" data-sortable="false"  data-align="center" class="center_table">
        การใช้งาน
      </th>
      <th data-field="view" data-sortable="false"  data-align="center" class="th_user">
      </th>
    </tr>
  </thead>
</table>
</div>
</div>


<!--  edit_emp -->
  <div class="modal fade modal_view_app" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel">รายละเอียดผู้ใช้งาน</h4>
        </div>
        <div class="modal-body">
          <div class="row form-group pd_img">
          <div class="col-md-12 box_img_add">
            <div class="img_add_emp">
              <div class="imp_hid">
                <i class="fa fa-camera fa_3" aria-hidden="true"></i>
                <br>
                <span style="font-size:14px;">ไม่พบรูปภาพ</span>
              </div>
              <div class="imp_hid_pre" style="display:none;">
                <img id="output_image_1"/>
              </div>
            </div>
          </div>
        </div>
        <div class="row form-group">
          <input type="file" accept="image/x-png, image/jpeg" name="img_user" id="img_user_edit" onchange="preview_image_edit(event)" style="display: none">
        </div>


        <div class="box_gp_app">
          <div class="row form-group">
            <div class="col-md-4">
              <label for="message-text" class="control-label v_app_title">ชื่อ</label>
            </div>
            <div class="col-md-8" id="v_name">
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-4">
              <label for="message-text" class="control-label v_app_title">ตำแหน่ง</label>
            </div>
            <div class="col-md-8" id="v_position">
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-4">
              <label for="message-text" class="control-label v_app_title">ที่อยู่</label>
            </div>
            <div class="col-md-8" id="v_address">
            </div>
          </div>

          <div class="row form-group">
            <div class="col-md-4">
              <label for="message-text" class="control-label v_app_title">ชื่อบริษัท</label>
            </div>
            <div class="col-md-8" id="v_com">
            </div>
          </div>

          <div class="row form-group">
            <div class="col-md-4">
              <label for="message-text" class="control-label v_app_title">เบอร์โทรศัพท์</label>
            </div>
            <div class="col-md-8" id="v_tel">
            </div>
          </div>

          <div class="row form-group">
            <div class="col-md-4">
              <label for="message-text" class="control-label v_app_title">เบอร์โทรศัพท์มือถือ</label>
            </div>
            <div class="col-md-8" id="v_moile">
            </div>
          </div>

          <div class="row form-group">
            <div class="col-md-4">
              <label for="message-text" class="control-label v_app_title">สมาชิกกรม</label>
            </div>
            <div class="col-md-8" id="v_ty">
            </div>
          </div>

          <div class="row form-group">
            <div class="col-md-4">
              <label for="message-text" class="control-label v_app_title">ประเภท</label>
            </div>
            <div class="col-md-8" id="v_type">
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-4">
              <label for="message-text" class="control-label v_app_title">E-mail</label>
            </div>
            <div class="col-md-8" id="v_mail">
            </div>
          </div>
          <?php if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"manager_member")[2]==1){ ?>
          <div class="row form-group " id="check_facebook">
            <div class="col-md-4">
              <label for="message-text" class="control-label v_app_title">Password</label>
            </div>
            <div class="col-md-8" id="">
              <span class="lbl_repass cursor" data-toggle="modal" onclick="Confirm_password() && reset_password();" >re-password</span>
              <input type="hidden" name="repass_id" value="" id="repass_id">

            </div>
          </div>
          <?php } ?>
        </div>
        </div>
        <div class="modal-footer">
          <!-- <button type="submit" class="btn  btn_submit">ตกลง</button> -->
          <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
        </div>
      </div>
    </div>
  </div>
<!-- </form> -->


<script>

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
  $("select[name='status_t']").on('change', function() {
    $('.table-caseCh-list').bootstrapTable('refresh');
  });
  $("select[name='login_f_m']").on('change', function() {
    $('.table-caseCh-list').bootstrapTable('refresh');
  });
  $("select[name='fonfrim']").on('change', function() {
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

  params.status_t = $("select[name='status_t']").val();
  params.status_m = $("select[name='status_m']").val();
  params.text = $("input[name='search_text']").val();
  params.fonfrim = $("select[name='fonfrim']").val();

  if($('.search_date').prop("disabled")==false){
    params.date = $('.search_date').val();
  }
  return params; // body data
}

function preview_image(event)
{
     var reader = new FileReader();
     reader.onload = function()
     {
       $('.imp_hid').hide();
       $('.imp_hid_pre').show();
      var output = document.getElementById('output_image');
      output.src = reader.result;
     }
     reader.readAsDataURL(event.target.files[0]);
}



function preview_image_edit(event)
{
     var reader = new FileReader();
     reader.onload = function()
     {
       $('.imp_hid').hide();
       $('.imp_hid_pre').show();
      var output = document.getElementById('output_image_1');
      output.src = reader.result;
     }
     reader.readAsDataURL(event.target.files[0]);
}

function BrowseClick()
{
  var fileinput = document.getElementById("img_user");
  fileinput.click();
}
function BrowseClick_edit()
{
  var fileinput = document.getElementById("img_user_edit");
  fileinput.click();
}


function confirmMember(mem_id){
  $.post("user/method.php?method=confirmMember",
    {
        mem_id: mem_id
    },
    function(data, status){
      if(data=="00"){
        $(".comfirm-member-"+mem_id).html('<span class="type_green">ยืนยัน</span>');
      }
    }
  );
}

</script>
