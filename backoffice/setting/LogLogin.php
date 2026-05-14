<div class="">
  <div class="title_color">
    <span class="title_icon ditp-icon icon-ico-ditp-05"></span>
    Log Login
  </div>
</div>
<div class="box_appeal">
  <div class="row row_title">
    <div class="col-md-2  box_appeal_title">
      Log Login
    </div>
    <div class="col-md-10 col-xs-12 search box_s1">
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
      <div class="box-search display_block pd_btn_10" id="icon-search" style="">
        <div class="input_box">
          <input type="text" name="search_text" id="search_text" class="form-control input_box" placeholder="Search" autocomplete="off">
        </div>
      </div>
      </div>
  </div>
  <div class="tabla_data">
    <table data-toggle="table" class="table-caseCh-list"
    data-sort-name="log_id"
    data-sort-order="DESC"
    data-side-pagination="server"
    data-pagination="true"
    data-page-size="10"
    data-page-list="[10, 50, 100, 200, ALL]"
    data-url="method.php?method=getloglogin"
    data-query-params="searchQueryParams"
    data-method="post">
    <thead>
      <tr>
        <th data-field="1" data-sortable="false" data-align="center" class="center_table">
        #
      </th>
      <th data-field="2" data-sortable="true" data-align="left" class=""  >
        อีเมล
      </th>
      <th data-field="3" data-sortable="true" data-align="left" class="center_table"  >
        เข้าสู่ระบบ
      </th>

      <th data-field="4" data-sortable="true" class=""  >
        ตำแหน่ง
      </th>
      <th data-field="5" data-sortable="true" class="">
        วันที่
      </th>
    </tr>
  </thead>
</table>
</div>
</div>

<script type="text/javascript">
function searchQueryParams(params) {
  params.status_m = $("select[name='group_id']").val();
  params.text = $("input[name='search_text']").val();
  if($('.search_date').prop("disabled")==false){
    params.date = $('.search_date').val();
  }
  return params; // body data
}

$(document).ready(function() {
  $('.table-caseCh-list').on('load-success.bs.table', function (e) {
    auto_resize_menu();
    $('[data-toggle="tooltip"]').tooltip();
  });
  $("input[name='search_text']").keypress(function(e) {
    if(e.which == 13) {
      $('.table-caseCh-list').bootstrapTable('refresh');
    }
  });
  $("select[name='group_id']").on('change', function() {
    $('.table-caseCh-list').bootstrapTable('refresh');
  });

});
</script>
