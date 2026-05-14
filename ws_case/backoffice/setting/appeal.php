<div class="">
  <div class="title_color">
    <span class="title_icon ditp-icon icon-ico-ditp-05"></span>
    ตั้งค่าระบบ
  </div>
</div>
<div class="box_appeal">
  <div class="row row_title">
    <div class="col-xs-4 box_appeal_title">
      ช่องทางการรับเรื่องร้องเรียน
    </div>
    <div class="col-xs-5 search box_s1">
      <div class="box-search" id="icon-search" style="">
        <div class="input_box">
          <input type="text" name="search_text" id="search_text" class="form-control input_box" placeholder="Search" autocomplete="off">
        </div>
      </div>
    </div>
    <div class="col-xs-3 box_s">
      <button type="button" class="btn_add click_add" data-toggle="modal" data-target=".bs-example-modal-lg">
        <span class="">เพิ่มช่องทางการรับเรื่องร้องเรียน</span>
      </button>
    </div>
  </div>
  <div class="tabla_data">
    <table data-toggle="table"  id="example" class="example"  class="table-caseCh-list"
    data-sort-name="id"
    data-sort-order="desc"
    data-side-pagination="server"
    data-pagination="true"
    data-page-size="20"
    data-page-list="[20, 50, 100, 200, ALL]"
    data-url="method.php?method=getchannel"
    data-query-params="searchQueryParams"
    data-method="post">
        <thead>
          <tr>
            <th data-field="id"
            data-sortable="true"
            data-align="center">
            #
          </th>
          <th data-field="name" data-sortable="true">
            ชื่อ
          </th>
          <th data-field="view" data-sortable="true" data-align="center">
            แสดงผล
          </th>
          <th data-field="del_edit" data-sortable="true"  data-align="center">
            &nbsp;<span class="icon-ico-ditp-10"  data-toggle="modal" data-target=".bs-example-modal-lg_edit" ></span>&nbsp;&nbsp;<span class="icon-ico-ditp-28"></span>
          </th>
        </tr>
      </thead>
    </table>
  </div>
</div>
  <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">

    <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel">เพิ่มช่องทางการรับเรื่องร้องเรียน</h4>
        </div>
        <div class="modal-body">
            <div class="row form-group">
              <div class="col-md-3 ">
                <label for="recipient-name" class="control-label">ชื่อ</label>
            </div>
            <div class="col-md-9 ">
              <input type="hidden" class="form-control" id="recipient-name" name="add_appeal" value="1" >
              <input type="text" class="form-control" id="add_name" name="add_name">
            </div>
            </div>
            <div class="row ">
              <div class="col-md-3 ">
                <label for="message-text" class="control-label">การแสดงผล</label>
              </div>
              <div class="col-md-9">
                <input type="radio" name="radio_url_cms" id="ch1" value="0"  checked="checked"/>&nbsp;เปิด
								<input type="radio" name="radio_url_cms" id="ch2" value="1" />&nbsp;ปิด&nbsp;&nbsp;&nbsp;
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

<div class="modal fade bs-example-modal-lg_edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel">แก้ไขช่องทางการรับเรื่องร้องเรียน</h4>
        </div>
        <div class="modal-body">

            <div class="row form-group">
              <div class="col-md-3 ">
                <label for="recipient-name" class="control-label">ชื่อ</label>
            </div>
            <div class="col-md-9 ">
              <input type="text" class="form-control edit_name" id="edit_name" >
              <input type="hidden" class="id_edit" id="id_edit">

            </div>
            </div>
            <div class="row ">
              <div class="col-md-3 ">
                <label for="message-text" class="control-label">การแสดงผล</label>
              </div>
              <div class="col-md-9">
                <input type="radio" name="radio_url_cms" value="1" id="ch1_edit" />&nbsp;เปิด
								<input type="radio" name="radio_url_cms" id="ch2_edit" value="0" />&nbsp;ปิด&nbsp;&nbsp;&nbsp;
              </div>
            </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
          <button type="button" class="btn  btn_submit" onclick="save_channel();">ตกลง</button>
        </div>
      </div>
  </div>
</div>

<!-- <script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script> -->

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="../assets/bootstrap-table/dist/bootstrap-table.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="../assets/bootstrap-table/dist/bootstrap-table.min.js"></script>
<!-- Latest compiled and minified Locales -->
<script src="../assets/bootstrap-table/dist/locale/bootstrap-table-th-TH.min.js"></script>

<!-- <script src="js/jquery-3.2.1.min.js"></script> -->
<link rel="stylesheet" type="text/css" href="css/css_appeal.css">
 <script type="text/javascript" src="function.js"></script>
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/bs-3.3.5/jq-2.1.4,dt-1.10.8/datatables.min.css"/> -->
 <!-- <script type="text/javascript" src="https://cdn.datatables.net/r/bs-3.3.5/jqc-1.11.3,dt-1.10.8/datatables.min.js"></script> -->
<script>


$(document).ready(function() {
        //
        // $("input[name='search_text']").keypress(function(e) {
        //   if(e.which == 13) {
        //     $('.table-caseCh-list').bootstrapTable('refresh');
        //   }
        // });

 });

 function searchQueryParams(params) {



   //
  //  params.text = $("input[name='search_text']").val();
  //  if($('.search_date').prop("disabled")==false){
  //    params.date = $('.search_date').val();
  //  }
  //  console.log( params.text);
  //  return params; // body data
 }
 $("#search_text").keypress(function(){
    var  test =   $('#search_text').val();
      console.log($('#search_text').val());
    });


</script>
