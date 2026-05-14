<div class="">
  <div class="title_color">
    <span class="title_icon ditp-icon icon-ico-ditp-05"></span>
    ตั้งค่าระบบ
  </div>
</div>
<div class="box_appeal">
  <div class="row row_title">
    <div class="col-md-5 col-lg-5 box_appeal_title">
      ประเภทของเรื่องร้องเรียน
    </div>
    <div class="col-md-12 col-lg-7 col-xs-12 search box_s1">
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
        <button type="button" class="btn_add click_add" data-toggle="modal" data-target=".modal_add_porduct" onclick="hid_day_add();">
          <span class="">เพิ่มเรื่องร้องเรียน</span>
        </button>
        <?php } ?>
      </div>
    </div>
    <div class="tabla_data">
      <table data-toggle="table" class="table-caseCh-list"
      data-sort-name="name"
      data-sort-order="ASC"
      data-side-pagination="server"
      data-pagination="true"
      data-page-size="10"
      data-page-list="[10, 50, 100, 200, ALL]"
      data-url="method.php?method=getcomplaint"
      data-query-params="searchQueryParams"
      data-method="post">
      <thead>
        <th data-field="name" data-sortable="true">
          เรื่องร้องเรียน
        </th>
        <th data-field="from" data-sortable="false" data-align="left">
          ฟอร์ม
        </th>
        <th data-field="type" data-sortable="false" data-align="center" class="center_table">
          ประเภท
        </th>
        <th data-field="day" data-sortable="false" data-align="center" class="center_table">
          เวลาดำเนินการ(วัน)
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
<form method="POST" action="method.php?method=add_complaint"  enctype="multipart/form-data" target="iframe-data"  >
  <div class="modal fade modal_add_porduct" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg complaint_en" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel">เพิ่มเรื่องร้องเรียน</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-4 ">
              <label for="message-text" class="control-label">เลือกประเภท</label>
            </div>
            <div class="col-md-8">
              <div class="col-md-4">
                <div class="radio radio-danger">
                  <input type="radio" name="radio_add" id="ch1_edit" value="1" checked="checked"   onchange="chech_section(1);" >
                  <label for="ch1_edit">
                    สสบ.
                  </label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="radio radio-danger ">
                  <input type="radio" name="radio_add" id="ch2_edit" value="2" onchange="chech_section(2);">
                  <label for="ch2_edit">
                  นิติการ
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-4 ">
              <label for="recipient-name" class="control-label">ประเภทเรื่องร้องเรียน<label class="txt_no_del">*</label></label>
            </div>
            <div class="col-md-8 chech_section ">
              <select class="selectpicker Complaint_Type"  data-width="100%" name="Complaint_Type"  id="Complaint_Type" onchange="sub_type_complaint();">
                <option value="">--- เลือกประเภทเรื่องร้องเรียน ---</option>
                <?php
                $sql_select = "SELECT compType_name,compType_id FROM Complaint_Type where compType_status = '0' AND compType_section = '1' ";
                $query_select = $conn->query($sql_select);
                while ( $re =   $query_select->fetch_assoc()) {

                  ?><option value="<?=$re['compType_id']?>"><?=$re['compType_name']?></option><?php
                }
                ?>
              </select>
            </div>

          </div>
          <div class="sub_type_complaint" id="sub_type_complaint">

          </div>
          <div class="chech_section_sub" id="chech_section_sub">

          </div>

          <div class="row form-group">
            <div class="col-md-4 ">
              <label for="recipient-name" class="control-label">ชื่อเรื่องร้องเรียน (ไทย)<label class="txt_no_del">*</label></label>
            </div>
            <div class="col-md-8 ">
              <input type="hidden" class="form-control" id="recipient-name" name="add_appeal" >
              <input type="text" class="form-control" id="add_name" name="add_name"  onkeyup="this.value = isThaichar(this.value,this)">
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-4 ">
              <label for="recipient-name" class="control-label">ชื่อเรื่องร้องเรียน (Eng)<label class="txt_no_del">*</label></label>
            </div>
            <div class="col-md-8 ">
              <input type="text" class="form-control" id="add_name_en" name="add_name_en"  onkeyup="this.value = isThaichar_en(this.value,this)">
            </div>
          </div>

          <div class="row form-group hid_day">
            <div class="col-md-4 ">
              <label for="recipient-name" class="control-label">กำหนดเวลา<label class="txt_no_del">*</label></label>
            </div>
            <div class="col-md-3 ">
              <input type="text" class="form-control" id="add_day" name="add_day" onKeyUp="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลขเท่านั้น'); this.value='';}">
            </div>
            <div class="col-md-5 ">
              <label for="recipient-name" class="control-label">วัน</label>
            </div>
          </div>
          <div class="row form-group hid_day">
            <div class="col-md-4 ">
              <label for="message-text" class="control-label">ระบุเพิ่มเติม</label>
            </div>
            <div class="col-md-8">
              <div class="col-md-4">
                <div class="radio radio-danger">
                  <input type="radio" name="ra_other" id="ra_oth1" value="1" >
                  <label for="ra_oth1">
                    มี
                  </label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="radio radio-danger ">
                  <input type="radio" name="ra_other" id="ra_oth2" value="0" checked="checked" >
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

<form method="POST" action="method.php?method=edit_complaint"  enctype="multipart/form-data" target="iframe-data"  >
  <div class="modal fade edit_complaint" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg complaint_en" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel">แก้ไขประเภทของเรื่องร้องเรียน</h4>
        </div>
        <div class="modal-body">
          <div class="row form-group">
            <div class="col-md-4">
              <label for="recipient-name" class="control-label" name="edit_name">ชื่อเรื่องร้องเรียน (ไทย)<label class="txt_no_del">*</label></label>
            </div>
            <div class="col-md-8">
              <input type="text" class="form-control edit_name" id="edit_name" name="edit_name" onkeyup="this.value = isThaichar(this.value,this)">
              <input type="hidden" class="id_edit" id="id_edit" name="id_edit">
              <input type="hidden" class="type" id="type" name="type">
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-4">
              <label for="recipient-name" class="control-label" name="edit_name">ชื่อเรื่องร้องเรียน (Eng)<label class="txt_no_del">*</label></label>
            </div>
            <div class="col-md-8">
              <input type="text" class="form-control edit_name" id="edit_name_en" name="edit_name_en" onkeyup="this.value = isThaichar_en(this.value,this)">
            </div>
          </div>
          <div class="row form-group hid_day">
            <div class="col-md-4">
              <label for="recipient-name" class="control-label">กำหนดเวลา<label class="txt_no_del">*</label></label>
            </div>
            <div class="col-md-3">
              <input type="hidden" class="form-control" id="recipient-name" name="add_appeal" >
              <input type="text" class="form-control" id="edit_day" name="edit_day" onKeyUp="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลขเท่านั้น'); this.value='';}">
            </div>
            <div class="col-md-5">
              <label for="recipient-name" class="control-label">วัน</label>
            </div>
          </div>
          <div class="row form-group hid_day">
            <div class="col-md-4 ">
              <label for="message-text" class="control-label">ระบุเพิ่มเติม</label>
            </div>
            <div class="col-md-8">
              <div class="col-md-4">
                <div class="radio radio-danger">
                  <input type="radio" name="ra_other_edit" id="ra_edit_oth1" value="1" >
                  <label for="ra_edit_oth1">
                    มี
                  </label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="radio radio-danger ">
                  <input type="radio" name="ra_other_edit" id="ra_edit_oth2" value="0">
                  <label for="ra_edit_oth2">
                  ไม่มี
                  </label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
          <button type="submit" class="btn  btn_submit" >ตกลง</button>
        </div>
      </div>
    </div>
  </div>
</form>

<div class="modal fade modal_select_from" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg-form complaint_nodal" role="document">
    <div class="modal-content">
      <div class="modal-header   modal-header-from ">
        <div clas="display_block">
          <div class="modal-title_form" id="exampleModalLabel">
            <label for="">เลือกฟอร์ม</label>
            <div class="display_block" style="float: right;">
              <div class=" search box_s1">
                <div class="box-search" id="icon-search" style="">
                  <div class="input_box">
                    <input type="text" name="search_frm" id="search_frm" class="form-control input_box search_frm" onkeypress="search_frm_keypress(event);" placeholder="Search" autocomplete="off" >
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <form method="POST" action="method.php?method=select_formset"  enctype="multipart/form-data" target="iframe-data" id="select_submit" >
        <div class="modal-body">
          <div class="from_padd">
            <div class="col-md-12 ">
              <input type="hidden" name="type_from" id="type_from" value="">
              <input type="hidden" name="id_add1" id="id_add1" value="" >
              <input type="hidden" name="id_add2" id="id_add2" value="" >
              <input type="hidden" name="id_add3" id="id_add3" value="" >
              <input type="hidden" name="add_edit" id="add_edit" value="" >
              <input type="hidden" name="id_form" id="id_form" value="" >

              <table class="border_table" id="get_select">
                <?php
                $day_check = date("Y-m-d");
                $sql_edit = "SELECT form_id,form_name,form_start_date,form_end_date FROM  Form_Of_Comp
                WHERE form_start_date <=  '$day_check'
                AND form_end_date >= '$day_check'
                AND `form_status` = 0 ";
                $query_edit = $conn->query($sql_edit);
                while ( $re_edit =   $query_edit->fetch_assoc()) {
                  $form_id = $re_edit['form_id'];
                  $form_name =  $re_edit['form_name'];
                  $form_start_date = date("d/m/Y" , strtotime($re_edit['form_start_date']) );
                  $form_end_date = date("d/m/Y" , strtotime($re_edit['form_end_date']) );
                  ?>
                  <tr>
                    <th class="center"><input type="radio" name="form_set" id="form_set_<?=$form_id?>" value="<?=$form_id?>"></th>
                    <th><label class="txt_nol_form"><?=$form_name?></label></th>
                    <th><label class="txt_nol_form"><?=$form_start_date." - ".$form_end_date?></label></th>
                  </tr>
                  <?php
                }
                ?>
              </table>
            </div>
          </div>
        </div>
    </form>
        <div class="modal-footer modal-footer_fix" style="">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-top: 15px;">ปิด</button>
          <?php if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"manage_system")[2]==1){ ?>
            <button type="submit" class="btn btn_submit" style="margin-top: 15px;" onclick="select_submit();" >ตกลง</button>
            <?php } ?>
          </div>
      </div>
    </div>
  </div>

  <script type="text/javascript" src="../assets/widgets/chosen/chosen.js"></script>
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
  function select_submit() {
    document.getElementById('select_submit').submit();
  }
  function hid_day_add() {
    $('.hid_day').show();
  }
  </script>
