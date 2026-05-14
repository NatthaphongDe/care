<div class="">
  <div class="title_color">
    <i class="ditp-icon icon-ico-ditp-04"></i>
    ผู้ใช้
  </div>
</div>
<div class="box_appeal">
  <div class="row row_title">
    <div class="col-lg-3 col-md-12 box_appeal_title">
      DITP care user
    </div>
    <div class="col-lg-9 col-md-12 search box_s1">
      <select class="selectpicker col-xs-2 chosen-select-dissearch display_block box_app " name="group_id"  id="group_id" data-width="200px">
        <option value="">--- ตำแหน่งทั้งหมด ---</option>
        <?php
        $sql_ch_form = "SELECT empGroup_name,empGroup_id  FROM Employee_Group where empGroup_status = 0 AND empGroup_id != 1 ORDER by empGroup_name ASC";
        $query_ch_form = $conn->query($sql_ch_form);
        if ($query_ch_form->num_rows >0) {
          while ($re = $query_ch_form->fetch_assoc()) {
            ?>
            <option value="<?=$re['empGroup_id']?>"><?=$re['empGroup_name']?></option>
            <?php
          }
        } ?>
      </select>
      <select class="selectpicker col-xs-2 chosen-select-dissearch box_app " name="type_section"  id="type_section" data-width="200px">
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
      <!-- <div class="box-search display_block pd_btn_10" id="icon-search" style="">
        <div class="input_box">
          <input type="text" name="search_text" id="search_text" class="form-control input_box" placeholder="Search" autocomplete="off">
        </div>
      </div> -->
      <?php if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"manager_user")[2]==1){ ?>
        <button type="button" class="btn_add click_add btn_add_left pd_btn_10" data-toggle="modal" data-target=".modal_add_emp" onclick="add_app()">
          <span class="">เพิ่มผู้ใช้</span>
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
      data-url="user/method.php?method=getform_admin"
      data-query-params="searchQueryParams"
      data-method="post">
      <thead>
        <th data-field="emp_real_id" data-sortable="true" class="th_user">
          ID
        </th>
        <th data-field="name" data-sortable="true" data-align="left" class="th_user">
          ชื่อ - สกุล
        </th>
        <th data-field="empGroup" data-sortable="true"  data-align="left" class="th_user center_table">
          ตำแหน่ง
        </th>
        <th data-field="type" data-sortable="true"  data-align="left" class="th_user center_table" >
          สำนัก
        </th>
        <th data-field="tel" data-sortable="true"  data-align="left" class="th_user">
          ข้อมูลการติดต่อ
        </th>
        <?php if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"manager_user")[2]==1){ ?>
          <th data-field="del" data-sortable="false"  data-align="center" class="th_user_width">
          </th>
          <?php } ?>
        </tr>
      </thead>
    </table>
  </div>
</div>


<!--  add_emp -->
<form method="POST" action="user/method.php?method=add_user" id="add_user"  enctype="multipart/form-data" target="iframe-data"  >
  <div class="modal fade modal_add_emp" tabindex="-1" id="modal_add_emp" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel">เพิ่มผู้ใช้</h4>
        </div>
        <div class="modal-body bode_font_title">
          <div class="row form-group pd_img">
            <div class="col-md-12 box_img_add">
              <div class="img_add_emp cursor" onclick="BrowseClick();">
                <div class="imp_hid">
                  <i class="fa fa-camera fa_3" aria-hidden="true"></i>
                  <br>
                  <span style="font-size:14px;">เพิ่มรูปภาพประจำตัว</span>
                </div>
                <div class="imp_hid_pre" style="display:none;">
                  <img  class="im_pre"  id="output_image"/>
                </div>
              </div>
              <i class="fa fa-pencil fa-1x brower_edit img_not_pd" id="img_not_add" aria-hidden="true" onclick="BrowseClick();"></i>
            </div>

          </div>
          <div class="txt_noti_1 txt_noti_al" id="txt_noti_1_add">
            <span>ขนาดรูปภาพ ความสูงและความกว้าง 800 Pixels ขึ้นไปเท่านั้น</span>
          </div>
          <!-- <div class="row form-group"> -->
            <input type="file" accept="image/x-png, image/jpeg" name="img_user" id="img_user" onchange="preview_image(event)" style="display: none">
          <!-- </div> -->

          <div class="box_gp radio_default_1">
            <div class="row ">
              <div class="col-md-4">
                <label for="message-text" class="control-label">เลือกประเภท</label> <label for="" class="txt_no_del">*</label>
              </div>

              <div class="col-md-8">

              <select class="selectpicker office_name" name="office_name" id="office_name"  data-width="100%" onchange="user_section()">
                <option value="">--- เลือกประเภท ---</option>
                <option value="s1">สำนักสารสนเทศและการบริการการค้าระหว่างประเทศ</option>
                <?php
                  foreach ($obj->getofficetype() as $listCountry) {
                        echo "<option value=".$listCountry["office_id"].">".$listCountry["office_name"]."</option>";
                  }
                ?>
                 <option value="s2">นิติการ</option>
               </select>
             </div>

              <!-- <div class="col-md-3">
                <div class="radio radio-danger">
                  <input type="radio" name="radio2" id="radio3" value="1" checked=""  onchange="user_section(1);">
                  <label for="radio3">
                    สสบ.
                  </label>
                </div>
              </div> -->
              <!-- <div class="col-md-5">
                <div class="radio radio-danger ">
                  <input type="radio" name="radio2" id="radio4" value="2" onchange="user_section(2);">
                  <label for="radio4">
                    นิติการ
                  </label>
                </div>
              </div> -->
            </div>

            <div class="row">
              <div class="col-md-4">
                <label for="recipient-name" class="control-label">เลือกตำแหน่ง</label> <label for="" class="txt_no_del">*</label>
              </div>
              <div class="col-md-8 no-margin-padding box_section ">
                <select class="selectpicker col-xs-2 chosen-select-dissearch display_block" name="group_id_emp"  id="group_id_emp" data-width="100%">
                  <option value="">--- ตำแหน่ง ---</option>
                  <?php
                  $sql_ch_form = "SELECT empGroup_name,empGroup_id  FROM Employee_Group where empGroup_status = 0 AND empGroup_section = '1' ORDER by empGroup_name ASC";
                  $query_ch_form = $conn->query($sql_ch_form);
                  if ($query_ch_form->num_rows >0) {
                    while ($re = $query_ch_form->fetch_assoc()) {
                      ?>
                      <option value="<?=$re['empGroup_id']?>"><?=$re['empGroup_name']?></option>
                      <?php
                    }
                  } ?>
                </select>
              </div>
            </div>
            <div class="row  dept_id-div" style="display:none">
              <div class="col-md-4">
                สำนักงานส่งเสริมการค้าในต่างประเทศ (สคต.)<label for="" class="txt_no_del">*</label>
              </div>
              <div class="col-md-8">
                <select class="selectpicker" name="dept_id"  id="dept_id" data-width="100%" data-live-search="true">
                  <option value="">--- เลือกสำนักงานส่งเสริมการค้าในต่างประเทศ (สคต.) ---</option>
                  <?php
                  $sql_ch_form = "SELECT * FROM `Department` WHERE `dept_type` = 3 AND `dept_status` =0 AND `dept_enable` =1 ORDER BY `dept_name` ASC ";
                  $query_ch_form = $conn->query($sql_ch_form);
                  if ($query_ch_form->num_rows >0) {
                    while ($re = $query_ch_form->fetch_assoc()) {
                      ?>
                      <option value="<?=$re['dept_id']?>"><?=$re['dept_name']?></option>
                      <?php
                    }
                  } ?>
                </select>
              </div>
            </div>
            <div class="row form-group dept_id-div" style="display:none">
              <div class="col-md-4">
                สถานะเข้าสู่ระบบ
              </div>
              <div class="col-md-8">
                <div class="checkbox checkbox-success" style="margin-top: 0px;">
                  <input id="Ldap" value="1" name="Ldap" class="" type="checkbox">
                    <label for="Ldap" style="margin-right:0px;">
                      <spanx>
                        เข้าใช้งานโดยระบบ LDAP
                      </spanx>
                    </label>
                  </div>
              </div>
            </div>
          </div>

          <div class="box_gp_name">
            <div class="row form-group">
              <div class="col-md-4">
                <label for="message-text" class="control-label">ชื่อ</label>  <label for="" class="txt_no_del">*</label>
              </div>
              <div class="col-md-8">
                <input type="text" class="form-control"  name="name" value="">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-md-4">
                <label for="message-text" class="control-label">สกุล</label>  <label for="" class="txt_no_del">*</label>
              </div>
              <div class="col-md-8">
                <input type="text" class="form-control"  name="lastname" value="">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-md-4">
                <label for="message-text" class="control-label">เบอร์โทร</label>  <label for="" class="txt_no_del"></label>
              </div>
              <div class="col-md-8">
                <input type="text" class="form-control"  name="tel" value="" onKeyUp="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลข'); this.value='';}">
              </div>
            </div>
          </div>

          <div class="box_gp_name">
            <div class="row form-group">
              <div class="col-md-4">
                <label for="message-text" class="control-label">E-mail</label>  <label for="" class="txt_no_del">*</label>
              </div>
              <div class="col-md-8">
                <input type="email" class="form-control"  name="email" value="" onkeyup="this.value = isThaichar_en(this.value,this)">
              </div>
            </div>
          </div>

          <div class="box_gp_name view_dashboard radio_default_2">
            <div class="row">
              <div class="col-md-5">
                <label for="message-text" class="control-label">การแสดงผล Dashboard<label for="" class="txt_no_del">*</label></label>
              </div>
              <div class="col-md-7">
                <div class="col-md-6">
                  <div class="radio radio-danger">
                    <input type="radio" name="view_dashboard" id="view" value="1" checked="" >
                    <label for="view">
                      แสดงผล
                    </label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="radio radio-danger ">
                    <input type="radio" name="view_dashboard" id="view1" value="2">
                    <label for="view1">
                      ไม่แสดงผล
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn  btn_submit">ตกลง</button>
          <button type="button" class="btn btn_red" data-dismiss="modal">ยกเลิก</button>
        </div>
      </div>
    </div>
  </div>
</form>



<!--  edit_emp -->
<form method="POST" action="user/method.php?method=add_user" id="edit_user"  enctype="multipart/form-data" target="iframe-data"  >
  <div class="modal fade modal_edit_emp" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title title_view" id="exampleModalLabel">แก้ไขผู้ใช้</h4>
          <input type="hidden" name="" value="" id="default_img">
        </div>
        <div class="modal-body bode_font_title"  id="view_date">
          <div class="row form-group pd_img">
            <div class="col-md-12 box_img_add">
              <div class="img_add_emp cursor" onclick="BrowseClick_edit();">
                <div class="imp_hid">
                  <i class="fa fa-camera fa_3" aria-hidden="true"></i>
                  <br>
                  <span style="font-size:14px;">เพิ่มรูปภาพประจำตัว</span>
                </div>
                <div class="imp_hid_pre" style="display:none;">
                  <img id="output_image_1" class="im_pre" />
                </div>
              </div>
              <i class="fa fa-pencil fa-1x brower_edit img_not_pd" id="img_not" aria-hidden="true" onclick="BrowseClick_edit();"></i>
            </div>
          </div>
          <div class="txt_noti_1 txt_noti_al" id="txt_noti_1">
            <span>ขนาดรูปภาพ ความสูงและความกว้าง 800 Pixels ขึ้นไปเท่านั้น</span>
          </div>
          <!-- <div class="txt_noti_2 txt_noti_al" id="txt_noti_2">
            <span>ขนาดรูปภาพ (800x800)px ขึ้นไปเท่านั้น</span>
          </div> -->
          <!-- <div class="row "> -->
            <input type="file" accept="image/x-png, image/jpeg" name="img_user" id="img_user_edit" onchange="preview_image_edit(event)" style="display: none">
          <!-- </div> -->

          <div class="box_gp">
            <div class="row ">
              <div class="col-md-4">
                <label for="message-text" class="control-label">เลือกประเภท</label> <label for="" class="txt_no_del">*</label>
              </div>
              <div class="col-md-8">

              <select class="selectpicker office_name" name="office_name" id="office_name_edit"  data-width="100%" onchange="user_section_edit()">
                <option value="">--- เลือกประเภท ---</option>
                <option value="s1">สำนักสารสนเทศและการบริการการค้าระหว่างประเทศ</option>
                <?php
                foreach ($obj->getofficetype() as $listCountry) {
                      echo "<option value=".$listCountry["office_id"].">".$listCountry["office_name"]."</option>";
                }
                 ?>
                 <option value="s2">นิติการ</option>

               </select>
               <input type="hidden" name="id_edit" value="" class="" id="id_edit" >
               <input type="hidden"  value="" name="ch_radio" id="ch_radio">

             </div>
              <!-- <div class="col-md-3">
                <div class="radio radio-danger">
                  <input type="radio" class="ckeck_dis" name="radio1" id="radio1" value="1" checked=""  onchange="user_section_edit(1);">
                  <label for="radio1">
                    สสบ.
                  </label>
                </div>
              </div>
              <div class="col-md-5">
                <div class="radio radio-danger ">
                  <input type="radio" class="ckeck_dis" name="radio1" id="radio2" value="2" onchange="user_section_edit(2);">
                  <label for="radio2">
                    นิติการ
                  </label>
                </div>
              </div> -->
            </div>

            <div class="row form-group">
              <div class="col-md-4">
                <label for="recipient-name" class="control-label">เลือกตำแหน่ง</label> <label for="" class="txt_no_del">*</label>
              </div>
              <div class="col-md-8 no-margin-padding box_section ">
                <div class="s1" style="display:none">
                  <select class="selectpicker col-xs-2 chosen-select-dissearch display_block" name="group_id_emp_edit"  id="s1" data-width="100%">
                    <option value="">--- ตำแหน่ง ---</option>
                    <?php
                    $sql_ch_form = "SELECT empGroup_name,empGroup_id  FROM Employee_Group where empGroup_status = 0 AND empGroup_section = '1' ORDER by empGroup_name ASC";
                    $query_ch_form = $conn->query($sql_ch_form);
                    if ($query_ch_form->num_rows >0) {
                      while ($re = $query_ch_form->fetch_assoc()) {
                        ?>
                        <option value="<?=$re['empGroup_id']?>"><?=$re['empGroup_name']?></option>
                        <?php
                      }
                    } ?>
                  </select>
                </div>
                <div class="s2" style="display:none">
                  <select class="selectpicker col-xs-2 chosen-select-dissearch display_block" name="group_id_emp_edit_1"  id="s2" data-width="100%">
                    <option value="">--- ตำแหน่ง ---</option>
                    <?php
                    $sql_ch_form = "SELECT empGroup_name,empGroup_id  FROM Employee_Group where empGroup_status = 0 AND empGroup_section = '2' ORDER by empGroup_name ASC";
                    $query_ch_form = $conn->query($sql_ch_form);
                    if ($query_ch_form->num_rows >0) {
                      while ($re = $query_ch_form->fetch_assoc()) {
                        ?>
                        <option value="<?=$re['empGroup_id']?>"><?=$re['empGroup_name']?></option>
                        <?php
                      }
                    } ?>
                  </select>

                </div>
              </div>
            </div>

            <div class="row  dept_id-div-edit" style="display:none">
              <div class="col-md-4">
                สำนักงานส่งเสริมการค้าในต่างประเทศ (สคต.)<label for="" class="txt_no_del">*</label>
              </div>
              <div class="col-md-8">
                <select class="selectpicker" name="dept_id"  id="dept_id_edit" data-width="100%" data-live-search="true">
                  <option value="">--- เลือกสำนักงานส่งเสริมการค้าในต่างประเทศ (สคต.) ---</option>
                  <?php
                  $sql_ch_form = "SELECT * FROM `Department` WHERE `dept_type` = 3 AND `dept_status` =0 AND `dept_enable` =1 ORDER BY `dept_name` ASC ";
                  $query_ch_form = $conn->query($sql_ch_form);
                  if ($query_ch_form->num_rows >0) {
                    while ($re = $query_ch_form->fetch_assoc()) {
                      ?>
                      <option value="<?=$re['dept_id']?>"><?=$re['dept_name']?></option>
                      <?php
                    }
                  } ?>
                </select>
              </div>
            </div>
            <div class="row form-group dept_id-div-edit" style="display:none">
              <div class="col-md-4">
                สถานะเข้าสู่ระบบ
              </div>
              <div class="col-md-8">
                <div class="checkbox checkbox-success" style="margin-top: 0px;">
                  <input id="Ldap_edit" value="1" name="Ldap" class="" type="checkbox">
                    <label for="Ldap_edit" style="margin-right:0px;">
                      <spanx>
                        เข้าใช้งานโดยระบบ LDAP
                      </spanx>
                    </label>
                  </div>
              </div>
            </div>
          </div>

          <div class="box_gp_name">
            <div class="row form-group">
              <div class="col-md-4">
                <label for="message-text" class="control-label">ชื่อ</label>  <label for="" class="txt_no_del">*</label>
              </div>
              <div class="col-md-8">
                <input type="text" class="form-control"  name="name" id="emp_firstname" value="">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-md-4">
                <label for="message-text" class="control-label">สกุล</label>  <label for="" class="txt_no_del">*</label>
              </div>
              <div class="col-md-8">
                <input type="text" class="form-control"  name="lastname" id="emp_lastname" value="">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-md-4">
                <label for="message-text" class="control-label">เบอร์โทร</label>  <label for="" class="txt_no_del"></label>
              </div>
              <div class="col-md-8">
                <input type="text" class="form-control"  name="tel" id="emp_tel" value="" onKeyUp="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลข'); this.value='';}">
              </div>
            </div>
          </div>

          <div class="box_gp_name">
            <div class="row form-group">
              <div class="col-md-4">
                <label for="message-text" class="control-label">E-mail</label>  <label for="" class="txt_no_del">*</label>
              </div>
              <div class="col-md-8">
                <input type="email" class="form-control"  name="email" id="emp_email" value="" onkeyup="this.value = isThaichar_en(this.value,this)">
              </div>
            </div>
          </div>

          <div class="box_gp_name view_dashboard">
            <div class="row">
              <div class="col-md-5">
                <label for="message-text" class="control-label">การแสดงผล Dashboard<label for="" class="txt_no_del">*</label></label>
              </div>
              <div class="col-md-7">
                <div class="col-md-6">
                  <div class="radio radio-danger">
                    <input type="radio" class="ckeck_dis" name="view_dashboard" id="view_edit" value="1"  >
                    <label for="view_edit">
                      แสดงผล
                    </label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="radio radio-danger ">
                    <input type="radio" class="ckeck_dis" name="view_dashboard" id="view1_edit" value="2">
                    <label for="view1_edit">
                      ไม่แสดงผล
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="box_gp_name Password-reset" style="padding: 20px 20px 0px 20px;">
            <div class="row form-group">
              <div class="col-md-4">
                <label for="message-text" class="control-label">Password</label>
              </div>
              <div class="col-md-8">
                <div class="" style="margin-top: 6px;">
                  <span class="lbl_repass cursor" data-toggle="modal" onclick="Confirm_password() &amp;&amp; reset_password_office();">re-password</span>
                </div>
              </div>
            </div>
          </div>


        </div>
        <div class="modal-footer footer_close">
          <?php if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"manager_user")[2]==1){ ?>
            <button type="submit" class="btn  btn_submit">ตกลง</button>
            <?php } ?>
            <button type="button" class="btn  btn_red" data-dismiss="modal">ยกเลิก</button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <input type="hidden" id="ch_img" name="" value="">
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
    $("select[name='group_id']").on('change', function() {
      $('.table-caseCh-list').bootstrapTable('refresh');
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

    params.group_id = $("select[name='group_id']").val();
    params.text = $("input[name='search_text']").val();
    if($('.search_date').prop("disabled")==false){
      params.date = $('.search_date').val();
    }
    return params; // body data
  }


  var preview_image = function(event) {
    $('.imp_hid').hide();
    $('.imp_hid_pre').show();
    var output_image = document.getElementById('output_image');
    if(event.target.files[0]!=undefined){
      output_image.src = URL.createObjectURL(event.target.files[0]);
    }else{
      $('.imp_hid').show();
      $('.imp_hid_pre').hide();
    }

    var img = new Image();
    img.src = output_image.src;
    img.onload = function(){
      $('#output_image').attr('style', getPositionImage(this.width,this.height,128));
    }
  };



  var preview_image_edit = function(event) {
    if($('#ch_img').val()==1){
      var image_x = document.getElementById('output_image_1');
      image_x.parentNode.removeChild(image_x);
      $('#ch_img').val(0);
    }
    $('.imp_hid').hide();
    $('.imp_hid_pre').show();
    var output = document.getElementById('output_image_1');
    if(event.target.files[0]!=undefined){
      output.src = URL.createObjectURL(event.target.files[0]);
    }else{
      var default_img = $('#default_img').val();
      if(default_img==''){
        $('.imp_hid_pre').hide();
        $('.imp_hid').show();
      }else{
        output.src = $('#default_img').val();
      }
    }
    var img = new Image();
    img.src =output.src;
    img.onload = function(){
      $('#output_image_1').attr('style', getPositionImage(this.width,this.height,128));
    }

  };


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
  function add_app(){
    $('.imp_hid').show();
    $('.imp_hid_pre').hide();
    $(".imp_hid_pre").html("<img id='output_image'>");
    $('input[type=text]').val('');

  }


  </script>
