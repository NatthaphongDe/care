<?php include("question_function/question_file.php"); ?>
<i class="ditp-icon icon-ico-ditp-06"></i>
<span class="txt_hr_report">รายการแบบสอบถามของแอดมิน</span>

  <div class="row">
    <div class="col-md-12" style="padding-right:0px;">
      <div class="panel panel-default panel-report">
      <div class="panel-body">
          <div class="hr_report" style="display:inline-block;">รายงานแบบสอบถามของแอดมิน</div>
          <div class="row">
            <div class="col-md-9"></div>
            <div class="col-md-3">
            <div class="filter_report">
              <div class="input-group report_search">
               <input type="text" class="form-control search_text" name="search_text" id="search_text_auto">
               <span class="input-group-addon bg-black btn-click-search">
                 <i class="glyphicon glyphicon-search"></i>
               </span>
              </div>
            </div>
          </div>
        </div>
          <div style="margin-top:30px;">
            <div class="tabla_data">
              <table data-toggle="table" class="table-caseCh-list"
              data-sort-name="id"
              data-sort-status="status"
              data-sort-order="DESC"
              data-side-pagination="server"
              data-pagination="true"
              data-page-size="10"
              data-page-list="[10, 50, 100, 200, ALL]"
              data-url="question_function/admin_function.php?method=admin_function"
              data-query-params="searchQueryParams"
              data-method="post">
                  <thead>
                    <tr>
                      <th class="numberpage" data-field="id" data-sortable="false" data-align="center">
                      #
                    </th>
                    <th data-field="name" data-sortable="true" data-align="left">
                      ชื่อ - นามสกุล
                    </th>
                    <th data-field="office" data-sortable="true" data-align="left">
                      สำนัก
                    </th>
                    <th data-field="date" data-sortable="true" data-align="left">
                      วันที่ทำแบบสอบถาม
                    </th>
                    <th class="numberpage" data-field="search" data-sortable="false" data-align="center">
                      ดูรายละเอียด
                    </th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <form method="post" action="#" id="modal_questionAW" enctype="multipart/form-data">
  		<div class="modal fade" id="modal_chk_questionAW" tabindex="-1" role="dialog" aria-labelledby="modal_chk_questionAW" style="padding:0px;">
  			<div class="modal-dialog modal_chk_questionAW" role="document" style="width:700px;">
  				<div class="modal-content" style="border-radius: 11px 11px 11px 11px;">
            <div class="modal-header" style="padding-bottom:0px;">
              <div class="modal-title add-group-modal-title">
                  <span class="hr_transfer">รายละเอียดแบบสอบถาม</span>
                <div class="close_modal" style="float: right; padding-bottom: 10px; padding-right: 10px;">
                  <a href="javascript:void(0);" data-dismiss="modal" aria-hidden="true">
                  <i class="ditp-icon icon-ico-ditp-20" aria-hidden="true"></i>
                </a>
                </div>
              </div>
            </div>
  					<div class="modal-body">
  						<div class="row" style="margin-bottom:30px;">
  							<div class="box-add-modal-group">
                  <div class="row">
                  <div class="col-md-3" style="padding-left:25px;">ชื่อ - นามสกุล : </div>
                  <div class="col-md-9 name_emp"></div>
                </div>
  						</div>
  					</div>
            <!-- <div class="div_table">
            <div class="row" style="display:inherit;">
              <div class="col-md-1 hr_txt_1">ลำดับ</div>
              <div class="col-md-6 hr_txt">คำถาม</div>
              <div class="col-md-5 hr_txt_1">ความคิดเห็น</div>
            </div>
            <div class="row">
              <div class="col-md-1 detail_num"></div>
              <div class="col-md-6 detail_question"></div>
              <div class="col-md-5 detail_questionAW"></div>
            </div>
            </div> -->
            <table class="table table-bordered">
            <thead>
              <tr>
                <th>ลำดับ</th>
                <th>คำถาม</th>
                <th>ความคิดเห็น</th>
              </tr>
            </thead>
            <tbody>
              <!-- <tr>
                <td class="detail_num"></td>
                <td class="detail_question"></td>
                <td class="detail_questionAW"></td>
              </tr> -->
            </tbody>
          </table>
  				</div>
  			</div>
  		</div>
  	</div>
  </form>

<script>
$(document).ready(function() {
     $('.table-caseCh-list').on('load-success.bs.table', function (e) {
        auto_resize_menu();
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
// ส่งค่าเข้า datatable
function searchQueryParams(params) {
  params.text = $("input[name='search_text']").val();
  return params; // body data
}
//////////
function show_detail(id){
  $('#modal_chk_questionAW').modal('show');
  $.ajax({
      url: 'question_function/function.php',
      type: 'POST',
      async: false,
      responseType: "json",
      data: {
        'id':id,
        "method":"show_detailAW"
      },
    success: function(res) {
      var table_content = "";
      var name_emp = "";
      $.each(res,function(index, el) {
        name_emp = el.name_emp;
        table_content += "<tr>";
        table_content += el.num;
        table_content += el.feedback;
        table_content += el.result;
        table_content += "</tr>";
      });
      $('.table_aws tbody').html(table_content);
      $('.name_emp').html(name_emp);
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(jqXHR, textStatus, errorThrown);

    }
  });
}
</script>
<style>
.icon-ico-ditp-43{
  display: inline-block;
  position: relative;
  top: -2px;
}
span .txt{
  margin-left: 0px !important;
  top: 1px;
  color: #388E3C !important;
  font-size: 14px !important;
  padding-left: 5px !important;
}
span .label{
  margin-left: 0px !important;
  top: 1px;
  color: #388E3C !important;
  font-size: 14px !important;
  padding-left: 5px !important;
}
.bootstrap-select.btn-group .dropdown-toggle .filter-option .icon-ico-ditp-43{
  display: none;
}
.bootstrap-select.btn-group .dropdown-menu li a.opt{
  padding-left: 5px;
}
.hr_txt{
  border: solid 1px #ddd;
  padding: 5px 0px 5px 0px;
  text-align:center;
  border-bottom: 0px;
  border-right: 0px;
  border-left: 0px;
}
.hr_txt_1{
  border: solid 1px #ddd;
  padding: 5px 0px 5px 0px;
  text-align:center;
  border-bottom: 0px;
}
.detail_num,.detail_question,.detail_questionAW{
  border: solid 1px #ddd;
  padding: 0px !important;
  border-bottom: 0px;
}
.feedback,.detail_question{
  border-right: 0px;
  border-left: 0px;
}
.div_table{
  margin-left: 10px;
}
.fixed-table-pagination .pagination-info{
  margin-left: 10px;
}
.numberpage > .th-inner {
  text-align: center;
}
</style>
