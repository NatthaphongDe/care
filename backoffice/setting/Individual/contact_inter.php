<div class="">
  <div class="title_color">
    <i class="ditp-icon icon-ico-ditp-42"></i>
    ฐานข้อมูลผู้ติดต่อ
  </div>
</div>
<div class="box_appeal">
  <div class="row row_title">
    <div class="col-lg-3 col-md-12 box_appeal_title float_left">
      บุคคลภายในต่างประเทศ
    </div>
    <div class="col-lg-9 col-md-12 search search_re box_s1">
      <div class="filter_report">
        <div class="input-group report_search">
          <input type="text" name="search_text" id="search_text" class="form-control input_box" placeholder="Search" autocomplete="off">
          <span class="input-group-addon bg-black btn-click-search">
            <i class="glyphicon glyphicon-search"></i>
          </span>
        </div>
      </div>
      <!-- <div class="input-group input-group-search">
        <span class="input-group-addon bg-black btn-click-search">
          <i class="glyph-icon icon-search"></i>
        </span>
      </div> -->
      <!-- <div class="box-search display_block pd_btn_10" id="icon-search" style="">
        <div class="input_box">
          <input type="text" name="search_text" id="search_text" class="form-control input_box" placeholder="Search" autocomplete="off">
        </div>
      </div> -->
      <?php if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"manager_Individual")[2]==1){ ?>
      <br style="display:none;">
      <!-- <div class="col-xs-3 box_s"> -->
      <a href="../../data/setting/template/Template_People_inter.xlsx">
        <button type="button" class="btn_import click_add click_add_re pd_btn_10" data-toggle="modal">
          <i class="fa fa-download" aria-hidden="true"></i>
          <span class="">Download Template</span>
        </button>
      </a>
      <button type="button" class="btn_import click_add pd_btn_10" data-toggle="modal" data-target=".import_people_th">
        <i class="fa fa-file-excel-o" aria-hidden="true"></i>
        <span class="">import</span>
      </button>
      <button type="button" class="btn_add click_add pd_btn_10" data-toggle="modal" data-target=".modal_add_inter">
        <span class="">เพิ่มผู้ติดต่อ</span>
      </button>
      <?php } ?>
      <!-- </div> -->
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
    data-url="Individual/method.php?method=get_contact_inter"
    data-query-params="searchQueryParams"
    data-method="post">
    <thead>
      <!-- <th data-field="id" data-sortable="true" data-align="left" class="th_user">
      ID
    </th> -->
    <th data-field="id_care" data-sortable="true"  data-align="left" class="th_user">
      Passport No.
    </th>
    <th data-field="name" data-sortable="true"  data-align="left" class="th_user">
      ชื่อ - สกุล
    </th>
    <th data-field="numbertrade" data-sortable="true"  data-align="left" class="th_user">
      เลขนิติบุคคล
    </th>
    <th data-field="business_type" data-sortable="true"  data-align="center" class="th_user">
      ประเภทธุรกิจ
    </th>
    <th data-field="career" data-sortable="true"  data-align="left" class="th_user">
      ตำแหน่ง
    </th>
    <th data-field="cell" data-sortable="true"  data-align="left" class="th_user">
      เบอร์
    </th>
    <th data-field="cellphone" data-sortable="true"  data-align="left" class="th_user">
      เบอร์โทรศัพท์มือถือ
    </th>
    <th data-field="email" data-sortable="true"  data-align="left" class="th_user">
      E-mail
    </th>
    <th data-field="address" data-sortable="true"  data-align="left" class="th_user">
      ที่อยู่ติดต่อ
    </th>
    <th data-field="province" data-sortable="true"  data-align="left" class="th_user country_width">
      ประเทศ
    </th>
    <?php if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"manager_Individual")[2]==1){ ?>
    <th data-field="del" data-sortable="false"  data-align="left" class="th_user_width">
    </th>
    <?php } ?>
  </tr>
</thead>
</table>
</div>
</div>


<!--  add -->
<form method="POST" action="Individual/method.php?method=save_contact_inter"  enctype="multipart/form-data" target="iframe-data"  >
  <div class="modal fade modal_add_inter" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel">เพิ่มบุคคลในต่างประเทศ</h4>
        </div>
        <div class="modal-body">
          <!-- <div class="box_gp_app"> -->
          <div class="row form_group_10">
            <div class="col-md-4">
              <label for="message-text" class="control-label body_txt_modal_16">Passport No.<label class="txt_no_del" for=""></label></label>
            </div>
            <div class="col-md-4 ct_card">
              <input type="text" class="form-control body_txt_modal_add input-mask" name="ct_card" value="">
            </div>
          </div>

          <div class="row form_group_10">
            <div class="col-md-4">
              <label for="message-text" class="control-label body_txt_modal_16">ชื่อ<label class="txt_no_del" for="">*</label></label>
            </div>
            <div class="col-md-4">
              <input type="text" class="form-control body_txt_modal_add" name="ct_firstname" value="">
            </div>
          </div>

          <div class="row form_group_10">
            <div class="col-md-4">
              <label for="message-text" class="control-label body_txt_modal_16">สกุล<label class="txt_no_del" for="">*</label></label>
            </div>
            <div class="col-md-4">
              <input type="text" class="form-control body_txt_modal_add" name="ct_lastname" value="">
            </div>
          </div>


          <div class="row form_group_10">
            <div class="col-md-4">
              <label for="message-text" class="control-label body_txt_modal_16">วัน/เดือน/ปี เกิด<label class="txt_no_del" for=""></label></label>
            </div>
            <div class="col-md-4">
              <!-- <input type="text" class="form-control body_txt_modal_add" name="ct_birthday" value=""> -->
              <!-- <div class="input-group"> -->
              <div class="input-group date" data-provide="datepicker"  data-date-format="dd/mm/yyyy">
                <input type="text" name="ct_birthday" value=""  class="form-control bootstrap-datepicker input-mask" data-inputmask="'mask':'99/99/9999'">
                <span class="input-group-addon input-group-addon-calendar bg-black">
                  <i class="glyph-icon icon-calendar"></i>
                </span>
              </div>
            </div>
          </div>
          <div class="row form_group_10">
            <div class="col-md-4">
              <label for="message-text" class="control-label body_txt_modal_16">เพศ<label class="txt_no_del" for=""></label></label>
            </div>
            <div class="col-md-8">
              <!-- <input type="text" class="form-control body_txt_modal_add" name="" value=""> -->
              <div class="col-md-2">
                <div class="radio radio-danger ">
                  <input type="radio" name="ct_sex" id="radio3" value="1" checked="">
                  <label for="radio3" class="body_txt_modal_add">
                    ชาย
                  </label>
                </div>
              </div>
              <div class="col-md-2">
                <div class="radio radio-danger ">
                  <input type="radio" name="ct_sex" id="radio4" value="2">
                  <label for="radio4" class="body_txt_modal_add">
                    หญิง
                  </label>
                </div>
              </div>
            </div>
          </div>

          <div class="row form_group_10">
            <div class="col-md-4">
              <label for="message-text" class="control-label body_txt_modal_16">อาชีพ<label class="txt_no_del" for=""></label></label>
            </div>
            <div class="col-md-6">
              <input type="text" class="form-control body_txt_modal_add" name="ct_career" value="">
            </div>
          </div>
          <div class="row form_group_10">
            <div class="col-md-4">
              <label for="message-text" class="control-label body_txt_modal_16">เบอร์โทรศัพท์<label class="txt_no_del" for="">*</label></label>
            </div>
            <div class="col-md-4">
              <input type="text" class="form-control body_txt_modal_add" name="ct_homephone" value="">
            </div>
          </div>
          <div class="row form_group_10">
            <div class="col-md-4">
              <label for="message-text" class="control-label body_txt_modal_16">เบอร์โทรศัพท์มือถือ<label class="txt_no_del" for=""></label></label>
            </div>
            <div class="col-md-4">
              <input type="text" class="form-control body_txt_modal_add" name="ct_cellphone" value="">
            </div>
          </div>
          <div class="row form_group_10">
            <div class="col-md-4">
              <label for="message-text" class="control-label body_txt_modal_16">E-mail<label class="txt_no_del" for="">*</label></label>
            </div>
            <div class="col-md-6">
              <input type="email" class="form-control body_txt_modal_add" name="ct_email" value="" onkeyup="this.value = isThaichar_en(this.value,this)">
            </div>
          </div>
          <div class="row form_group_10">
            <div class="col-md-4">
              <label for="message-text" class="control-label body_txt_modal_16">ที่อยู่ติดต่อ<label class="txt_no_del" for="">*</label></label>
            </div>
            <div class="col-md-8 txt_add">
              <textarea name="ct_address"  class="form-control body_txt_modal_add" rows="3"></textarea>
              <!-- <input type="text"name="" value=""> -->
            </div>
          </div>
          <div class="row form_group_10">
            <div class="col-md-4">
              <label for="message-text" class="control-label body_txt_modal_16">ประเทศ<label class="txt_no_del" for=""></label></label>
            </div>
            <div class="col-md-8 select_selectpicker">
              <select class="selectpicker col-xs-2 chosen-select-dissearch" name="Country_id"  id="" data-width="200px" data-live-search="true">
                <option value="">--- เลือกประเทศ ---</option>
                <?php
                $sql_select = "SELECT * FROM Country  ORDER BY id=162 DESC, name ASC";
                $query_select = $conn->query($sql_select);
                while ($re =   $query_select->fetch_assoc()) {
                  ?>
                  <option value="<?=$re['id']?>"><?=$re['name']?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn  btn_submit">บันทึกข้อมูล</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
          </div>
        </div>
      </div>
    </div>
  </form>



  <!--  edit -->
  <form method="POST" action="Individual/method.php?method=save_contact_inter"  enctype="multipart/form-data" target="iframe-data"  >
    <div class="modal fade modal_edit_inter" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title title_view" id="exampleModalLabel">แก้ไขบุคคลในต่างประเทศ</h4>
            <input type="hidden" id="id_ch" name="id_ch" value="">
          </div>
          <div class="modal-body" id="view_date">
            <div class="row form_group_10">
              <div class="col-md-4">
                <label for="message-text" class="control-label body_txt_modal_16">Passport No.<label class="txt_no_del" for=""></label></label>
              </div>
              <div class="col-md-4">
                <div class="id_care_edit"  id="ct_card">
                </div>
              </div>
            </div>

            <div class="row form_group_10">
              <div class="col-md-4">
                <label for="message-text" class="control-label body_txt_modal_16">ชื่อ<label class="txt_no_del" for="">*</label></label>
              </div>
              <div class="col-md-4">
                <input type="text" class="form-control body_txt_modal_add" name="ct_firstname" id="ct_firstname" value="">
              </div>
            </div>

            <div class="row form_group_10">
              <div class="col-md-4">
                <label for="message-text" class="control-label body_txt_modal_16">สกุล<label class="txt_no_del" for="">*</label></label>
              </div>
              <div class="col-md-4">
                <input type="text" class="form-control body_txt_modal_add" name="ct_lastname" id="ct_lastname" value="">
              </div>
            </div>


            <div class="row form_group_10">
              <div class="col-md-4">
                <label for="message-text" class="control-label body_txt_modal_16">วัน/เดือน/ปี เกิด<label class="txt_no_del" for=""></label></label>
              </div>
              <div class="col-md-4">
                <!-- <div class="input-group"> -->
                <div class="input-group date" data-provide="datepicker"  data-date-format="dd/mm/yyyy">
                  <input type="text" name="ct_birthday" id="ct_birthday" value=""  class="form-control bootstrap-datepicker input-mask" data-inputmask="'mask':'99/99/9999'">
                  <span class="input-group-addon input-group-addon-calendar bg-black hi_ct">
                    <i class="glyph-icon icon-calendar"></i>
                  </span>
                </div>
              </div>
            </div>
            <div class="row form_group_10">
              <div class="col-md-4">
                <label for="message-text" class="control-label body_txt_modal_16">เพศ<label class="txt_no_del" for=""></label></label>
              </div>
              <div class="col-md-8">
                <div class="col-md-2">
                  <div class="radio radio-danger ">
                    <input type="radio" name="ct_sex" id="radio3_edit" value="1" checked="">
                    <label for="radio3_edit" class="body_txt_modal_add">
                      ชาย
                    </label>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="radio radio-danger ">
                    <input type="radio" name="ct_sex" id="radio4_edit" value="2">
                    <label for="radio4_edit" class="body_txt_modal_add">
                      หญิง
                    </label>
                  </div>
                </div>
              </div>
            </div>

            <div class="row form_group_10">
              <div class="col-md-4">
                <label for="message-text" class="control-label body_txt_modal_16">อาชีพ<label class="txt_no_del" for=""></label></label>
              </div>
              <div class="col-md-4">
                <input type="text" class="form-control body_txt_modal_add" name="ct_career" id="ct_career" value="">
              </div>
            </div>
            <div class="row form_group_10">
              <div class="col-md-4">
                <label for="message-text" class="control-label body_txt_modal_16">เบอร์โทรศัพท์<label class="txt_no_del" for="">*</label></label>
              </div>
              <div class="col-md-4">
                <input type="text" class="form-control body_txt_modal_add" name="ct_homephone" id="ct_homephone" value="" >
              </div>
            </div>
            <div class="row form_group_10">
              <div class="col-md-4">
                <label for="message-text" class="control-label body_txt_modal_16">เบอร์โทรศัพท์มือถือ<label class="txt_no_del" for=""></label></label>
              </div>
              <div class="col-md-4">
                <input type="text" class="form-control body_txt_modal_add" name="ct_cellphone" id="ct_cellphone" value="" >
              </div>
            </div>
            <div class="row form_group_10">
              <div class="col-md-4">
                <label for="message-text" class="control-label body_txt_modal_16">E-mail<label class="txt_no_del" for="">*</label></label>
              </div>
              <div class="col-md-6">
                <input type="email" class="form-control body_txt_modal_add" name="ct_email" id="ct_email" value="" onkeyup="this.value = isThaichar_en(this.value,this)">
              </div>
            </div>
            <div class="row form_group_10">
              <div class="col-md-4">
                <label for="message-text" class="control-label body_txt_modal_16">ที่อยู่ติดต่อ<label class="txt_no_del" for="">*</label></label>
              </div>
              <div class="col-md-8 txt_add">
                <textarea name="ct_address" id="ct_address"  class="form-control body_txt_modal_add" rows="3"></textarea>
                <!-- <input type="text"name="" value=""> -->
              </div>
            </div>
            <div class="row form_group_10">
              <div class="col-md-4">
                <label for="message-text" class="control-label body_txt_modal_16">ประเทศ<label class="txt_no_del" for=""></label></label>
              </div>
              <div class="col-md-8 select_selectpicker">
                <select class="selectpicker col-xs-2 chosen-select-dissearch" name="Country_id"  id="Country_id" data-width="200px" data-live-search="true">
                  <option value="">--- เลือกประเทศ ---</option>
                  <?php
                  $sql_select = "SELECT * FROM Country ORDER BY id=162 DESC, name ASC ";
                  $query_select = $conn->query($sql_select);
                  while ($re =   $query_select->fetch_assoc()) {
                    ?>
                    <option value="<?=$re['id']?>"><?=$re['name']?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <!-- </div> -->
            </div>
            <div class="modal-footer footer_close">
              <!-- <button type="submit" class="btn  btn_submit">ตกลง</button> -->
              <?php if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"manager_Individual")[2]==1){ ?>
              <button type="submit" class="btn  btn_submit">บันทึกข้อมูล</button>
              <?php } ?>
              <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
            </div>
          </div>
        </div>
      </div>
    </form>


    <!--  importt  -->
    <!-- Individual/method.php?method=add_contact_thai -->
    <form method="POST" action="Individual/method.php?method=import_people_inter"  enctype="multipart/form-data" target="iframe-data"  >
      <div class="modal fade import_people_th" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="exampleModalLabel">Import Person</h4>
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

    <div class="modal fade modal_ststus" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
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
    $(function(){
      $(".input-mask").inputmask();
    });
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

    $(document).on('click','.btn-click-search',function() {
      $('.table-caseCh-list').bootstrapTable('refresh');
    });


    $(document).ready(function() {

      $('.table-caseCh-list').on('load-success.bs.table', function (e) {
        $('[data-toggle="tooltip"]').tooltip();
        auto_resize_menu();
      });
      $("input[name='search_text']").keypress(function(e) {
        if(e.which == 13) {
          $('.table-caseCh-list').bootstrapTable('refresh');
        }
      });
    });
    function searchQueryParams(params) {
      params.text = $("input[name='search_text']").val();
      return params; // body data
    }
</script>
