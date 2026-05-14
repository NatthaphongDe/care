<div class="">
  <div class="title_color">
    <span class="title_icon ditp-icon icon-ico-ditp-05"></span>
    ตั้งค่าระบบ
  </div>
</div>
<div class="box_appeal">
  <div class="row row_title">
    <div class="col-lg-2 col-md-12 box_appeal_title">
      หน่วยงาน
    </div>

    <div class="col-lg-10 col-md-12 search box_s1 float_right">
      <select class="selectpicker col-xs-2 chosen-select-dissearch display_block" name="status_dep"  id="status_dep" data-width="220px">
        <option value="">--- ประเภทหน่วยงาน ---</option>
        <?php
        $sql_select = "SELECT * FROM  Department_Type ORDER BY  deptType_name ASC";
        $query_select = $conn->query($sql_select);
        while ($re =   $query_select->fetch_assoc()) {
          ?>
          <option value="<?=$re['deptType_id']?>"><?=$re['deptType_name']?></option>
          <?php } ?>
      </select>
      <select class="selectpicker chosen-select-dissearch display_block" name="status_m"  id="status_m" data-width="200px">
        <option value="">--- เลือกประเภท ---</option>
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
        <a href="../../data/setting/template/Template_department.xlsx">
          <button type="button" class="btn_import click_add click_add_re pd_btn_10" data-toggle="modal">
            <i class="fa fa-download" aria-hidden="true"></i>
            <span class="">Download Template</span>
          </button>
        </a>
        <button type="button" class="btn_import click_add pd_btn_10" data-toggle="modal" data-target=".import_department">
          <i class="fa fa-file-excel-o" aria-hidden="true"></i>
          <span class="">import</span>
        </button>
        <button type="button" class="btn_add click_add display_block btn_add_left pd_btn_10" data-toggle="modal" data-target=".add_department">
          <span class="">เพิ่มหน่วยงาน</span>
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
      data-url="method.php?method=getdepartment"
      data-query-params="searchQueryParams"
      data-method="post">
      <thead>
        <tr>
          <th data-field="id" data-sortable="false" data-align="center">
            #
          </th>
          <th data-field="name" data-sortable="true"  class="name_table_250">
            ชื่อหน่วยงาน
          </th>
          <th data-field="dep" data-sortable="true" class="center_table">
            ประเภท
          </th>
          <th data-field="type_dep" data-sortable="true">
            ประเภทหน่วยงาน
          </th>
          <th data-field="director" data-sortable="true"  class="name_table_250">
            ชื่อผู้อำนวยการ
          </th>
          <th data-field="email" data-sortable="true"  class="name_table_250">
          อีเมล
          </th>
          <th data-field="address" data-sortable="true"  class="name_table_dep">
          ที่อยู่
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

  <form method="POST" action="method.php?method=add_department"  enctype="multipart/form-data" target="iframe-data">
    <div class="modal fade bs-example-modal-lg add_department" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel">เพิ่มหน่วยงาน</h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-4">
                <label for="message-text" class="control-label">หน่วยงาน</label>
              </div>
              <div class="col-md-8">
                <div class="col-md-6">
                  <div class="radio radio-danger">
                    <input type="radio" name="radio_section" id="radio_section1" value="1"  checked="checked" >
                    <label for="radio_section1">สสบ.</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="radio radio-danger ">
                    <input type="radio" name="radio_section" id="radio_section2" value="2" >
                    <label for="radio_section2">นิติการ</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-md-4 ">
                <label for="message-text" class="control-label">ประเภทหน่วยงาน<?=$rematk?></label>
              </div>
              <div class="col-md-8 contact">
                <select class="selectpicker col-xs-2 chosen-select-dissearch display_block" name="group_id" id="select_dp" data-width="100%" onchange="depa_type(1);">
                  <option value="">--- ประเภทหน่วยงาน ---</option>
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

              <div class="row form-group none_dp">
                <div class="col-md-4">
                  <label for="message-text" class="control-label">ทวีป<?=$rematk?></label>
                </div>
                <div class="col-md-8">
                  <select class="selectpicker col-xs-2 chosen-select-dissearch display_block" data-live-search="true"  id="continents_id" name="Continents" data-width="100%" onchange="Continents_select();">
                    <option value="">--- เลือกทวีป ---</option>
                    <?php
                    $sql_ch_form = "  SELECT * FROM Continents ORDER BY  code ASC ";
                    $query_ch_form = $conn->query($sql_ch_form);
                    if ($query_ch_form->num_rows >0) {
                      while ($re = $query_ch_form->fetch_assoc()) {
                        ?>
                        <option value="<?=$re['code']?>"><?=$re['name']?></option>
                        <?php
                      }
                    } ?>
                  </select>
                </div>
              </div>

              <div class="row form-group box_country none_dp" style="display:none">
              </div>


              <div class="row form-group">
                <div class="col-md-4">
                  <label for="recipient-name" class="control-label">ชื่อหน่วยงาน<?=$rematk?></label>
                </div>
                <div class="col-md-8" style="padding-left: 20px;">
                  <input type="hidden" class="form-control" name="add_appeal" value="1" >
                  <input type="text" class="form-control" name="add_name">
                </div>
              </div>

              <div class="row form-group add_name_short" style="display: none;">
                <div class="col-md-4">
                  <label for="recipient-name" class="control-label">ชื่อย่อหน่วยงาน<?=$rematk?></label>
                </div>
                <div class="col-md-8" style="padding-left: 20px;">
                  <input type="text" class="form-control" name="name_short">
                </div>
              </div>


              <div class="row form-group affiliation">
                <div class="col-md-4">
                  <label for="recipient-name" class="control-label">สังกัด</label>
                </div>
                <div class="col-md-8" style="padding-left: 20px;">
                  <input type="hidden" class="form-control" name="add_appeal" value="1" >
                  <input type="text" class="form-control" name="affiliation">
                </div>
              </div>


              <div class="row form-group">
                <div class="col-md-4">
                  <label for="recipient-name" class="control-label">ชื่อผู้อำนวยการ<?=$rematk?></label>
                </div>
                <div class="col-md-8" style="padding-left: 20px;">
                  <input type="text" class="form-control" name="director">
                </div>
              </div>

              <div class="row form-group">
                <div class="col-md-4">
                  <label for="recipient-name" class="control-label">ชื่อผู้ช่วย/ประสานงาน</label>
                </div>
                <div class="col-md-8" style="padding-left: 20px;">
                  <input type="text" class="form-control" name="assistant">
                </div>
              </div>

              <div class="row form-group">
                <div class="col-md-4">
                  <label for="recipient-name" class="control-label">หมายเลขโทรศัพท์<?=$rematk?></label>
                </div>
                <div class="col-md-8" style="padding-left: 20px;">
                  <input type="text" class="form-control" name="tel">
                </div>
              </div>

              <div class="row form-group">
                <div class="col-md-4">
                  <label for="recipient-name" class="control-label">หมายเลขแฟกซ์</label>
                </div>
                <div class="col-md-8" style="padding-left: 20px;">
                  <input type="text" class="form-control" name="fax">
                </div>
              </div>


              <div class="row form-group">
                <div class="col-md-4">
                  <label for="recipient-name" class="control-label">อีเมล</label>
                </div>
                <div class="col-md-8" style="padding-left: 20px;">
                  <input type="text" class="form-control" name="email">
                </div>
              </div>

              <div class="row form-group address_hide">
                <div class="col-md-4">
                  <label for="recipient-name" class="control-label">ที่อยู่</label>
                </div>
                <div class="col-md-8" style="padding-left: 20px;">
                  <textarea class="form-control" rows="2" name="address" cols="80"></textarea>
                </div>
              </div>

              <div class="row form-group">
                <div class="col-md-4">
                  <label for="recipient-name" class="control-label">ข้อความแจ้งเตือนกรณีเลือกหน่วยงาน (ไทย)</label>
                </div>
                <div class="col-md-8" style="padding-left: 20px;">
                  <textarea class="form-control resize_textarea" rows="2" name="message_noti" cols="80" onkeyup="this.value = isThaichar(this.value,this)"></textarea>
                </div>
              </div>
              <div class="row form-group">
                <div class="col-md-4">
                  <label for="recipient-name" class="control-label">ข้อความแจ้งเตือนกรณีเลือกหน่วยงาน (Eng)</label>
                </div>
                <div class="col-md-8" style="padding-left: 20px;">
                  <textarea class="form-control resize_textarea" rows="2" name="message_noti_en" cols="80" onkeyup="this.value = isThaichar_en(this.value,this)"></textarea>
                </div>
              </div>


              <div class="row form-group">
                <div class="col-md-4">
                  <label for="message-text" class="control-label">การแสดงผล</label>
                </div>
                <div class="col-md-8">
                  <div class="col-md-2">
                    <div class="radio radio-danger">
                      <input type="radio" name="radio_ststus" id="radio3" value="1"  checked="checked" >
                      <label for="radio3">
                        เปิด
                      </label>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="radio radio-danger ">
                      <input type="radio" name="radio_ststus" id="radio4" value="2">
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


    <form method="POST" action="method.php?method=add_department"  enctype="multipart/form-data" target="iframe-data"  >
      <div class="modal fade bs-example-modal-lg_edit edit_department" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title title_view" id="exampleModalLabel">แก้ไขหน่วยงาน</h4>
            </div>
            <div class="modal-body" id="view_date">
              <div class="row none_edit_dp" id="none_edit_dp1">
                <div class="col-md-4">
                  <label for="message-text" class="control-label">ชื่อสำนักงาน</label>
                </div>
                <div class="col-md-8">
                  <div class="col-md-6">
                    <div class="radio radio-danger">
                      <input type="radio" name="radio_section" id="radio_section1_edit" value="1" >
                      <label for="radio_section1_edit">สสบ.</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="radio radio-danger ">
                      <input type="hidden" name="id_department" value="" id="id_department">
                      <input type="radio" name="radio_section" id="radio_section2_edit" value="2" >
                      <label for="radio_section2_edit">นิติการ</label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row form-group none_edit_dp" id="none_edit_dp2">
                <div class="col-md-4">
                  <label for="message-text" class="control-label">ประเภทหน่วยงาน<?=$rematk?></label>
                </div>
                <div class="col-md-8">
                  <div class="incType_1">
                    <select class="selectpicker col-xs-2 chosen-select-dissearch display_block" name="group_id"  id="group_id" data-width="100%" onchange="depa_type(2);" >
                      <option value="">ประเภทหน่วยงาน</option>
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
                </div>


                <div class="row form-group continents_hide">
                  <div class="col-md-4">
                    <label for="message-text" class="control-label">ทวีป<?=$rematk?></label>
                  </div>
                  <div class="col-md-8">
                    <select class="selectpicker col-xs-2 chosen-select-dissearch display_block " data-live-search="true"  id="continents_edit" name="Continents" data-width="100%" onchange="Continents_select(2);">
                      <option value="">เลือกทวีป</option>
                      <?php
                      $sql_ch_form = "  SELECT * FROM Continents ORDER BY  code ASC ";
                      $query_ch_form = $conn->query($sql_ch_form);
                      if ($query_ch_form->num_rows >0) {
                        while ($re = $query_ch_form->fetch_assoc()) {
                          ?>
                          <option value="<?=$re['code']?>"><?=$re['name']?></option>
                          <?php
                        }
                      } ?>
                    </select>
                  </div>
                </div>


                <div class="row form-group box_country">
                  <div class="col-md-4 ">
                    <label for="message-text" class="control-label">ประเทศ<?=$rematk?></label>
                  </div>
                  <div class="col-md-8">
                    <select class="selectpicker col-xs-2 chosen-select-dissearch display_block" data-live-search="true" name="Country" id="Country" data-width="100%">
                      <option value="">เลือกประเทศ</option>
                      <?php
                      $sql_ch_form = "  SELECT id,name  FROM Country
                      where country_status = 0 ORDER BY id=162 DESC, name ASC";
                      $query_ch_form = $conn->query($sql_ch_form);
                      if ($query_ch_form->num_rows >0) {
                        while ($re = $query_ch_form->fetch_assoc()) {
                          ?>
                          <option value="<?=$re['id']?>"><?=$re['name']?></option>
                          <?php
                        }
                      } ?>
                    </select>
                  </div>
                </div>


                <div class="row form-group">
                  <div class="col-md-4">
                    <label for="recipient-name" class="control-label">ชื่อหน่วยงาน<?=$rematk?></label>
                  </div>
                  <div class="col-md-8" style="padding-left: 20px;">
                    <input type="text" class="form-control" id="add_name" name="add_name">
                  </div>
                </div>
                
                <div class="row form-group add_name_short_edit" style="display: none;">
                  <div class="col-md-4">
                    <label for="recipient-name" class="control-label">ชื่อย่อหน่วยงาน<?=$rematk?></label>
                  </div>
                  <div class="col-md-8" style="padding-left: 20px;">
                    <input type="text" class="form-control" name="name_short" id="add_name_short_edit">
                  </div>
                </div>

                <div class="row form-group affiliation_edit">
                  <div class="col-md-4">
                    <label for="recipient-name" class="control-label">สังกัด</label>
                  </div>
                  <div class="col-md-8" style="padding-left: 20px;">
                    <input type="hidden" class="form-control" name="add_appeal" value="1" >
                    <input type="text" class="form-control" name="affiliation" id="affiliation">
                  </div>
                </div>



                <div class="row form-group">
                  <div class="col-md-4">
                    <label for="recipient-name" class="control-label">ชื่อผู้อำนวยการ<?=$rematk?></label>
                  </div>
                  <div class="col-md-8" style="padding-left: 20px;">
                    <input type="text" class="form-control" name="director" id="director">
                  </div>
                </div>

                <div class="row form-group">
                  <div class="col-md-4">
                    <label for="recipient-name" class="control-label">ชื่อผู้ช่วย/ประสานงาน</label>
                  </div>
                  <div class="col-md-8" style="padding-left: 20px;">
                    <input type="text" class="form-control" name="assistant" id="assistant">
                  </div>
                </div>

                <div class="row form-group">
                  <div class="col-md-4">
                    <label for="recipient-name" class="control-label">หมายเลขโทรศัพท์<?=$rematk?></label>
                  </div>
                  <div class="col-md-8" style="padding-left: 20px;">
                    <input type="text" class="form-control" name="tel" id="tel">
                  </div>
                </div>

                <div class="row form-group">
                  <div class="col-md-4">
                    <label for="recipient-name" class="control-label">หมายเลขแฟกซ์</label>
                  </div>
                  <div class="col-md-8" style="padding-left: 20px;">
                    <input type="text" class="form-control" name="fax" id="fax">
                  </div>
                </div>

                <div class="row form-group">
                  <div class="col-md-4">
                    <label for="recipient-name" class="control-label">E-mail</label>
                  </div>
                  <div class="col-md-8" style="padding-left: 20px;">
                    <input type="text" class="form-control" name="email" id="email">
                  </div>
                </div>

                <div class="row form-group address_hide_edit">
                  <div class="col-md-4">
                    <label for="recipient-name" class="control-label">ที่อยู่</label>
                  </div>
                  <div class="col-md-8" style="padding-left: 20px;">
                    <textarea name="address" class="form-control" rows="2" id="address" cols="80"></textarea>
                  </div>
                </div>

                <div class="row form-group">
                  <div class="col-md-4">
                    <label for="recipient-name" class="control-label">ข้อความแจ้งเตือนกรณีเลือกหน่วยงาน (ไทย)</label>
                  </div>
                  <div class="col-md-8" style="padding-left: 20px;">
                    <textarea class="form-control resize_textarea" rows="2" name="message_noti" id="message_noti" cols="80" onkeyup="this.value = isThaichar(this.value,this)"></textarea>
                  </div>
                </div>
                <div class="row form-group">
                  <div class="col-md-4">
                    <label for="recipient-name" class="control-label">ข้อความแจ้งเตือนกรณีเลือกหน่วยงาน (Eng)</label>
                  </div>
                  <div class="col-md-8" style="padding-left: 20px;">
                    <textarea class="form-control resize_textarea" rows="2" name="message_noti_en" id="message_noti_en" cols="80" onkeyup="this.value = isThaichar_en(this.value,this)"></textarea>
                  </div>
                </div>

                <div class="row form-group none_edit_dp" id="none_edit_dp3">
                  <div class="col-md-4">
                    <label for="message-text" class="control-label">การแสดงผล</label>
                  </div>
                  <div class="col-md-8">
                    <div class="col-md-2">
                      <div class="radio radio-danger">
                        <input type="radio" name="radio_ststus" id="radio_ststus_edit1" value="1">
                        <label for="radio_ststus_edit1">
                          เปิด
                        </label>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="radio radio-danger ">
                        <input type="radio" name="radio_ststus" id="radio_ststus_edit2" value="2">
                        <label for="radio_ststus_edit2">
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

        <!--  import_depart  -->
        <form method="POST" action="method.php?method=import_department"  enctype="multipart/form-data" target="iframe-data"  >
          <div class="modal fade import_department" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title" id="exampleModalLabel">Import department</h4>
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

        <div class="modal fade modal_department_ststus" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
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

  $('.address_hide').hide();
  $('.affiliation').hide();
  $('.none_dp').hide();
  $('.table-caseCh-list').on('load-success.bs.table', function (e) {
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
  $("select[name='status_dep']").on('change', function() {
    $('.table-caseCh-list').bootstrapTable('refresh');
  });
});

$(document).on('click','.btn-click-search',function() {
  $('.table-caseCh-list').bootstrapTable('refresh');
});

function searchQueryParams(params) {
  params.status_m = $("select[name='status_m']").val();
  params.status_dep = $("select[name='status_dep']").val();

  params.text = $("input[name='search_text']").val();
  return params; // body data
}

</script>
