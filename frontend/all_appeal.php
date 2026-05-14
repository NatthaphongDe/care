<div class="row appeal_div_row">
  <div class="col-md-12">
    <span class="icon_hr_appeal"><img src="images/all_icon_DITP/icon_6.svg" style="width:30px;" class="icon_appeal"></span>
    <span class="txt_hr_appeal"><?=$txt_existing_petition?></span>
    <input type="hidden" class="get_status" name="get_status" value="<?=$_GET['status'];?>">

    <div class="row div_status_appeal">
       <div class="col-md-6"><span><?=$txt_Status?> : </span>
         <span>
           <?php
           if($_GET['status'] == 1){
             echo "Waiting";
           }elseif ($_GET['status'] == 2) {
             echo "In Process";
           }elseif ($_GET['status'] == 3) {
            echo "Complete";
           }
           ?>
         </span>
       </div>
       <div class="col-md-6">
         <div class="input-group appeal_search">
          <input type="text" class="form-control search_text" placeholder="<?php if($lang == "1"){ echo "ค้นหา";}elseif($lang == "2"){ echo "Search";}else{ echo "ค้นหา";}?>" name="search_text" onkeypress="search_appeal_enter_all(event);" style="border-right-width: 0px;">
          <span class="input-group-addon bg-black btn-click-search">
            <i class="glyphicon glyphicon-search" onclick="search_appeal_all();"></i>
          </span>
        </div>
       </div>
    </div>
<div class="appeal_center_filter">
</div>
<div class="appeal_center">

  <?php if($_GET['status'] == 1){ ?>
    <div class="panel panel-default appeal_panel">
      <div class="panel-heading hr_appeal_panel">
        <span class="hr_txt_waiting"><?=$txt_Status?> : </span><span class="icon_waiting"><img src="images/icon_waiting.png"></span>

      </div>
      <div class="tabla_data">
              <table data-toggle="table" class="table-caseCh-list"
              data-sort-name="id"
              data-sort-status="status"
              data-sort-order="DESC"
              data-side-pagination="server"
              data-pagination="true"
              data-page-size="10"
              data-page-list="[10, 50, 100, 200, ALL]"
              data-url="all_appeal_funtion.php?method=all_appeal"
              data-query-params="searchQueryParams"
              data-method="post">
                  <thead>
                    <tr>
                      <th data-field="id" data-sortable="false" data-align="left">
                    </th>
                  </tr>
                </thead>
              </table>
            </div>
    </div>
  <?php }elseif ($_GET['status'] == 2) { ?>


    <div class="panel panel-default appeal_panel">
      <div class="panel-heading hr_appeal_panel_pending">
        <span class="hr_txt_pending"><?=$txt_Status?> : </span><span class="icon_pending"><img src="images/icon_pending.png"></span>

      </div>
      <div class="tabla_data">
              <table data-toggle="table" class="table-caseCh-list"
              data-sort-name="id"
              data-sort-status="status"
              data-sort-order="DESC"
              data-side-pagination="server"
              data-pagination="true"
              data-page-size="10"
              data-page-list="[10, 50, 100, 200, ALL]"
              data-url="all_appeal_funtion.php?method=all_appeal"
              data-query-params="searchQueryParams"
              data-method="post">
                  <thead>
                    <tr>
                      <th data-field="id" data-sortable="false" data-align="left">
                    </th>
                  </tr>
                </thead>
              </table>
            </div>



    </div>

  <?php }elseif ($_GET['status'] == 3) { ?>

    <div class="panel panel-default appeal_panel">
      <div class="panel-heading hr_appeal_panel_complete">
        <span class="hr_txt_complete"><?=$txt_Status?> : </span><span class="icon_complete"><img src="images/icon_complete.png"></span>

      </div>
      <div class="tabla_data">
              <table data-toggle="table" class="table-caseCh-list"
              data-sort-name="id"
              data-sort-status="status"
              data-sort-order="DESC"
              data-side-pagination="server"
              data-pagination="true"
              data-page-size="10"
              data-page-list="[10, 50, 100, 200, ALL]"
              data-url="all_appeal_funtion.php?method=all_appeal"
              data-query-params="searchQueryParams"
              data-method="post">
                  <thead>
                    <tr>
                      <th data-field="id" data-sortable="false" data-align="left">
                    </th>
                  </tr>
                </thead>
              </table>
            </div>
    </div>

  <?php } ?>

    </div>
  </div>
</div>
<script>
  function searchQueryParams(params) {
    params.text = $("input[name='search_text']").val();
    params.status = $("input[name='get_status']").val();
    params.lang = $(".language_hidden").val();
    return params; // body data
  }

  function search_msg(){
      $('.table-caseCh-list').bootstrapTable('refresh');
  }

$(document).ready(function() {
  $("input[name='search_text']").keypress(function(e) {
  if(e.which == 13) {
    $('.table-caseCh-list').bootstrapTable('refresh');
  }
  });
});

</script>
<style>
.th-inner{
  display: none;
}
.fixed-table-container{
  border: 0px;
}
.pagination>li:first-child>a, .pagination>li:first-child>span{
  background: #fff;
  color: #4CAF50;
}
.pagination>li:last-child>a, .pagination>li:last-child>span{
  background: #fff;
  color: #4CAF50;
}
.fixed-table-pagination .pagination-detail, .fixed-table-pagination div.pagination{
  margin-left: 10px;
  margin-right: 10px;
}
.pagination>li>a, .pagination>li>span{
  margin-left: 2px;
  margin-right: 2px;
}
.pagination>li:first-child>a, .pagination>li:first-child>span{
  margin-left: 2px;
  margin-right: 2px;
}
.pagination>li:last-child>a, .pagination>li:last-child>span{
  margin-left: 2px;
  margin-right: 2px;
}
tr{
  border: none !important;
}
td{
  border: none !important;
}
.panel-body{
  padding-bottom: 0px;
  padding-top: 0px;
}
</style>
