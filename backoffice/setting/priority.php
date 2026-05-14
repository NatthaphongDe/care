<div class="">
  <div class="title_color">
    <span class="title_icon ditp-icon icon-ico-ditp-05"></span>
    ตั้งค่าระบบ
  </div>
</div>
<div class="box_appeal">
  <div class="row row_title">
    <div class="col-md-2  box_appeal_title">
      Priority
    </div>
    <div class="col-md-10 col-xs-12 search box_s1">
      <select class="selectpicker col-xs-2 chosen-select-dissearch display_block" name="status_m"  id="status_m" data-width="200px">
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
      
      <!-- <div class="box-search display_block" id="icon-search" style="" >
        <div class="input_box">
          <input type="text" name="search_text" id="search_text" class="form-control input_box" placeholder="Search" autocomplete="off">
        </div>
      </div> -->
      <?php if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"manage_system")[2]==1){ ?>
        <button type="button" class="btn_add click_add display_block" data-toggle="modal" data-target=".modal_add_porduct">
          <span class="">เพิ่ม Priority</span>
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
      data-url="method.php?method=getpriority"
      data-query-params="searchQueryParams"
      data-method="post">
      <thead>
        <tr>
          <th data-field="id" data-sortable="false" data-align="center" class="center_table">
            #
          </th>
          <th data-field="name" data-sortable="true">
            ระดับ Priority
          </th>
          <th data-field="type" data-sortable="true" data-align="center" class="center_table">
            ประเภท
          </th>
          <th data-field="pic" data-sortable="false" data-align="center" class="center_table">
            สัญลักษณ์
          </th>
          <th data-field="color" data-sortable="false" data-align="center" class="center_table color">
            สีแสดงผล
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


  <!--  add_product  -->
  <form method="POST" action="method.php?method=add_priority"  enctype="multipart/form-data" target="iframe-data"  >
    <div class="modal fade modal_add_porduct" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal_pri">
          <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel">เพิ่ม Priority</h4>
          </div>
          <div class="modal-body" >
            <div class="row form-group">
              <div class="col-md-3 ">
                <label for="message-text" class="control-label">เลือกประเภท</label>
              </div>
              <div class="col-md-9">
                <div class="col-md-2">
                  <div class="radio radio-danger">
                    <input type="radio" name="radio_section" id="ch1_section" value="1"  checked="checked" >
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
              <div class="col-md-3 ">
                <label for="recipient-name" class="control-label">ระดับ Priority<?=$rematk?></label>
              </div>
              <div class="col-md-9 ">
                <input type="hidden" class="form-control" id="recipient-name" name="add_appeal" >
                <input type="text" class="form-control" id="add_name" name="add_name">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-md-3 ">
                <label for="recipient-name" class="control-label">สัญลักษณ์<?=$rematk?></label>
              </div>
              <div class="col-md-9">
                <div class="img_country" style="    margin-bottom: 10px;">
                <img id="output" class="ico-flag-priority"/>
                </div>
                <input type="file" id="browse" name="pic_upload" style="display: none" onChange="Handlechange() & loadFile(event);"  accept="image/x-png, image/gif, image/jpeg"/>
                <div class="box_im" >
                  <input type="text" id="filename" readonly="true" class="form-control add-image-text box_im_input" />
                </div>
                <div class="box_impo" >
                  <input type="button" value="Browse" id="fakeBrowse" onclick="HandleBrowseClick();"  class="btn btn-black-2 box_btn_impoet_id"/>
                </div>
                <label class="lb_txt">เลือกรูปขนาด (100 x 100 pixels) (.png , .gif)</label>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-md-3">
                <label for="" class="control-label">สีแสดงผล</label>
              </div>
              <div class="col-md-8">
                <div class="row">
                  <div class="col-md-5">
                    <input type="text" name="colorpicker" id="colorpicker-br" class="form-control">
                  </div>
                  <div class="col-md-6">
                  </div>
                </div>
              </div>
            </div>


            <div class="row form-group">
              <div class="col-md-3 ">
                <label for="message-text" class="control-label">การแสดงผล<?=$rematk?></label>
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
  <form method="POST" action="method.php?method=save_priority"  enctype="multipart/form-data" target="iframe-data"  >
    <div class="modal fade modal_edit_priority" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal_pri">
          <div class="modal-header">
            <h4 class="modal-title title_view" id="exampleModalLabel">แก้ไข Priority</h4>
          </div>
          <div class="modal-body" id="view_date">
            <div class="row form-group hide_edit">
              <div class="col-md-3 ">
                <label for="message-text" class="control-label">เลือกประเภท</label>
              </div>
              <div class="col-md-9">
                <div class="col-md-2">
                  <div class="radio radio-danger">
                    <input type="radio" name="radio_section" id="ch1_section_edit" value="1" >
                    <label for="ch1_section_edit">
                      สสบ.
                    </label>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="radio radio-danger ">
                    <input type="radio" name="radio_section" id="ch2_section_edit" value="2">
                    <label for="ch2_section_edit">
                      นิติการ
                    </label>
                  </div>
                </div>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-md-3 ">
                <label for="recipient-name" class="control-label">ระดับ Priority<?=$rematk?></label>
              </div>
              <div class="col-md-9 ">
                <input type="hidden" class="form-control" id="recipient-name" name="add_appeal" >
                <input type="text" class="form-control" id="edit_name" name="edit_name">
                <input type="hidden" class="form-control" id="id_edit" name="id_edit">
              </div>
            </div>

            <div class="row form-group" style="display:none">
              <div class="col-md-3 ">
                <label for="recipient-name" class="control-label">สัญลักษณ์<?=$rematk?></label>
              </div>
              <div class="col-md-9">
                <input type="file" id="browse_edit1" name="priority_edit" style="display: none" onChange="Handlechange_edit();" accept="image/x-png, image/gif, image/jpeg"/>
                <div class="box_im">
                  <input type="text" id="filename_edit" readonly="true" class="form-control add-image-text box_im_input" />
                </div>
                <div class="box_impo" >
                  <input type="button" value="Browse.." id="fakeBrowse_edit" onclick="HandleBrowseClick_edit();"    class="btn btn-black-2 box_btn_impoet_id"/>
                </div>
                <label class="lb_txt">เลือกรูปขนาด (100 x 100 pixels) (.png , .gif)</label>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-md-3">
                <label for="" class=" control-label">สีแสดงผล<?=$rematk?></label>
              </div>
              <div class="col-md-8">
                <div class="row">
                  <div class="col-md-5">
                    <input type="text" name="colorpicker_edit" id="colorpicker-br1" class="form-control color_edit">
                  </div>
                </div>
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
          <div class="modal-footer footer_close">
            <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
            <?php if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"manage_system")[2]==1){ ?>
              <button type="submit" class="btn  btn_submit">ตกลง</button>
              <?php   } ?>
            </div>
          </div>
        </div>
      </div>
    </form>
    <form method="POST" class="form_pri" action="method.php?method=add_priority_edit_pic" id="edit_pri"  enctype="multipart/form-data" target="iframe-data" >
      <input type="file" id="browse_edit" name="pic_upload" style="display: none" onChange="loadFile_edit();" accept="image/x-png, image/gif, image/jpeg"/>
      <input type="hidden" name="id" id="id_p">
    </form>
    <script type="text/javascript" src="../assets/widgets/colorpicker/colorpicker.js"></script>
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


    $(function() { "use strict";
    $('#colorpicker-br').minicolors(
      {
        animationSpeed: 100,
        change: null,
        changeDelay: 0,
        control: 'hue',
        defaultValue: '',
        hide: null,
        hideSpeed: 100,
        inline: false,
        letterCase: 'lowercase',
        opacity: false,
        position: 'bottom right',
        show: null,
        showSpeed: 100,
        textfield: true,
        theme: 'default'
      });
    });

    $(function() { "use strict";
    $('#colorpicker-br1').minicolors(
      {
        animationSpeed: 100,
        change: null,
        changeDelay: 0,
        control: 'hue',
        defaultValue: '',
        hide: null,
        hideSpeed: 100,
        inline: false,
        letterCase: 'lowercase',
        opacity: false,
        position: 'bottom right',
        show: null,
        showSpeed: 100,
        textfield: true,
        theme: 'default'
      });
    });



    function HandleBrowseClickxc(id){
      $('#id_p').val(id);
      $('#browse_edit').click();

    }
    function loadFile_edit() {
      var id = $('#id_p').val();
      // var edit_pri = 'edit_pri'+id;
      // console.log('"'+edit_pri+'"');
      document.getElementById("edit_pri").submit();
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
    $(document).on('click','.btn-click-search',function() {
      $('.table-caseCh-list').bootstrapTable('refresh');
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
  $('.img_country').show();
  var output = document.getElementById('output');
  if(event.target.files[0]!=undefined){
    output.src = URL.createObjectURL(event.target.files[0]);
  }else{
    $('.img_country').hide();
  }
};



    </script>
