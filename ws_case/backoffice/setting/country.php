<div class="">
  <div class="title_color">
    <span class="title_icon ditp-icon icon-ico-ditp-05"></span>
    ตั้งค่าระบบ
  </div>
</div>
<div class="box_appeal">
  <div class="row row_title">
    <div class="col-md-4 box_appeal_title">
      ประเทศ
    </div>
    <div class="col-md-8 col-xs-12 search box_s1">
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
        <button type="button" class="btn_add click_add" data-toggle="modal" data-target=".modal_add_country">
          <span class="">เพิ่มประเทศ</span>
        </button>
        <?php } ?>
      </div>
    </div>
    <div class="tabla_data">
      <table data-toggle="table" class="table-caseCh-list"
      data-sort-name="name"
      data-sort-order="DESC"
      data-side-pagination="server"
      data-pagination="true"
      data-page-size="10"
      data-page-list="[10, 50, 100, 200, ALL]"
      data-url="method.php?method=getcountry"
      data-query-params="searchQueryParams"
      data-method="post">
      <thead>
        <tr>
          <th data-field="id" data-sortable="false" data-align="center" class="center_table">
            #
          </th>
          <th data-field="name_th" data-sortable="true" data-align="left">
            ชื่อประเทศ (ไืทย)
          </th>
          <th data-field="name" data-sortable="true" data-align="left">
            ชื่อประเทศ (Eng)
          </th>
          <th data-field="pic" data-sortable="false" data-align="center"  class="center_table">
            ธงชาติ
          </th>
          <th data-field="view" data-sortable="false" data-align="center" class="center_table">
            แสดงผล
          </th>
          <?php if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"manage_system")[2]==1){ ?>
            <th data-field="del_edit" data-sortable="false"  data-align="center" class="width_edit">

            </th>
            <?php } ?>
          </tr>
        </thead>
      </table>
    </div>
  </div>


  <!--  add_country  -->
  <form method="POST" action="method.php?method=add_country"  enctype="multipart/form-data" target="iframe-data"  >
    <div class="modal fade modal_add_country" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel">เพิ่มประเทศ</h4>
          </div>
          <div class="modal-body">

            <div class="row form-group">
              <div class="col-md-4">
                <label for="recipient-name" class="control-label">ชื่อประเทศ (Th)<?=$rematk?></label>
              </div>
              <div class="col-md-8">
                <input type="hidden" class="form-control" id="recipient-name" name="add_appeal" >
                <input type="text" class="form-control" id="add_name_th" name="add_name_th" onkeyup="this.value = isThaichar(this.value,this)">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-md-4">
                <label for="recipient-name" class="control-label">ชื่อประเทศ (Eng)<?=$rematk?></label>
              </div>
              <div class="col-md-8">
                <input type="hidden" class="form-control" id="recipient-name" name="add_appeal" >
                <input type="text" class="form-control" id="add_name_en" name="add_name_en" onkeyup="this.value = isThaichar_en(this.value,this)">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-md-4">
                <label for="recipient-name" class="control-label">ทวีป<?=$rematk?></label>
              </div>
              <div class="col-md-8">
                <select class="selectpicker chosen-select-dissearch display_block" data-live-search="true" data-width="100%" name="continent_code">
                  <option value="">
                    --- เลือกทวีป ---
                  </option>
                  <?php
                  foreach ($caseLst_cls->continentsList() as $continentsList) {
                    ?>
                    <option value="<?php echo $continentsList["code"] ?>">
                      <?php echo $continentsList["name"] ?>
                    </option>
                    <?php
                  }
                   ?>
                </select>
              </div>
            </div>


            <div class="row form-group">
              <div class="col-md-4">
                <div class="asset-detail-titlex">ธงชาติ<?=$rematk?></div>
              </div>
              <div class="col-md-8">

                <div class="img_country" style="    margin-bottom: 10px;">
                <img id="output" class="ico-flag-pre"/>
                </div>
                <input type="file" id="browse" name="add_pic_countyr" style="display: none" onChange="Handlechange() & loadFile(event);" >
                <input type="hidden" name="import" value="1" />
                <div class="box_im" >
                  <input type="text" id="filename" readonly="true" class="form-control input-browse box_im_input" />
                </div>
                <div class="box_impo">
                  <input type="button" value="Browse.." id="fakeBrowse" onclick="HandleBrowseClick();" class="btn btn-btn box_btn_impoet_id" />
                </div>
              </div>
            </div>

            <div class="row ">
              <div class="col-md-4">
                <label for="message-text" class="control-label">การแสดงผล</label>
              </div>
              <div class="col-md-8">
                <div class="col-md-3">
                  <div class="radio radio-danger">
                    <input type="radio" name="radio_country" id="radio3" value="1"  checked="checked" >
                    <label for="radio3">
                      เปิด
                    </label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="radio radio-danger ">
                    <input type="radio" name="radio_country" id="radio4" value="0">
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

  <!--  edit_country  -->
  <form method="POST" action="method.php?method=add_country"  enctype="multipart/form-data" target="iframe-data"  >
    <div class="modal fade edit_country" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title title_view" id="exampleModalLabel">แก้ไขข้อมูลประเทศ</h4>
          </div>
          <div class="modal-body" id="view_date">

            <div class="row form-group">
              <div class="col-md-4">
                <label for="recipient-name" class="control-label">ชื่อประเทศ (Th)<?=$rematk?></label>
                <input type="hidden" id="default_img" >
              </div>
              <div class="col-md-8">
                <input type="text" class="form-control" id="edit_name_th" name="add_name_th" onkeyup="this.value = isThaichar(this.value,this)">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-md-4">
                <label for="recipient-name" class="control-label">ชื่อประเทศ (Eng)<?=$rematk?></label>
              </div>
              <div class="col-md-8">
                <input type="hidden" class="form-control" id="id_edit" name="id_edit" >
                <input type="text" class="form-control" id="edit_name_en" name="add_name_en" onkeyup="this.value = isThaichar_en(this.value,this)">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-md-4">
                <label for="recipient-name" class="control-label">ทวีป<?=$rematk?></label>
              </div>
              <div class="col-md-8">
                <select class="selectpicker chosen-select-dissearch display_block continent_code_edit" data-live-search="true" name="continent_code" data-width="100%" >
                  <option value="">
                    --- เลือกทวีป ---
                  </option>
                  <?php
                  foreach ($caseLst_cls->continentsList() as $continentsList) {
                    ?>
                    <option value="<?php echo $continentsList["code"] ?>">
                      <?php echo $continentsList["name"] ?>
                    </option>
                    <?php
                  }
                   ?>
                </select>
              </div>
            </div>


            <div class="row form-group">
              <div class="col-md-4">
                <div class="asset-detail-titlex">ธงชาติ<?=$rematk?></div>
              </div>
              <div class="col-md-8">
                <div class="pre_edit" style="margin-bottom: 10px;">
                  <img id="output_edit" class="ico-flag-pre"/>
                </div>
                <div class="edit_pre_hide " style="display:none; margin-bottom: 10px;">
                  <img id="output_edit" class="ico-flag-pre"/>
                </div>


                <input type="file" id="browse_edit1" name="add_pic_countyr" style="display: none" onChange="Handlechange_edit() & loadFile_edit(event);"  accept="image/x-png, image/gif, image/jpeg"/>
                <div class="box_im">
                  <input type="text" id="filename_edit" readonly="true" class="form-control add-image-text box_im_input" />
                </div>
                <div class="box_impo">
                  <input type="button" value="Browse.." id="fakeBrowse_edit" onclick="HandleBrowseClick_edit();" class="btn btn-black-2 box_btn_impoet_id"/>
                </div>
              </div>
            </div>

            <div class="row" id="none_country">
              <div class="col-md-4">
                <label for="message-text" class="control-label">การแสดงผล</label>
              </div>
              <div class="col-md-8">
                <div class="col-md-3">
                  <div class="radio radio-danger">
                    <input type="radio" name="radio_country" id="ch1_edit" value="1"  checked="checked" >
                    <label for="ch1_edit">
                      เปิด
                    </label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="radio radio-danger ">
                    <input type="radio" name="radio_country" id="ch2_edit" value="0">
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
              <button type="submit" class="btn  btn_submit">ตกลง</button>
              <?php } ?>
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

    function Handlechange_edit()
    {
      var fileinput = document.getElementById("browse_edit1");
      var textinput = document.getElementById("filename_edit");
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
      $('.img_country').hide();
      $('.edit_pre_hide').hide();


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


    var loadFile = function(event) {
      $('.img_country').show();
      var output = document.getElementById('output');
      if(event.target.files[0]!=undefined){
        output.src = URL.createObjectURL(event.target.files[0]);
      }else{
        $('.img_country').hide();
      }
    };

    var loadFile_edit = function(event) {
      $('.edit_pre_hide').show();
      $('.hie_edit').hide();
      var output_edit = document.getElementById('output_edit');
      if(event.target.files[0]!=undefined){
        output_edit.src = URL.createObjectURL(event.target.files[0]);
        $('.pre_edit').show();
        $('.edit_pre_hide').show();
      }else{
        output_edit.src = $('#default_img').val();
      }
    };


    </script>
