<?php
if($_POST['method']!="search_notibell"){
  include('config/config.php');
$date_time = date("Y-m-d H:i:s");
$sql= "UPDATE `Message_Noti_App` SET msgNotiApp_noti_status='1',msgNotiApp_noti_datetime='".$date_time."' WHERE member_id ='".$_SESSION['member_id']."'";
$query = $conn->query($sql);
}
?>

<div class="row appeal_div_row">
  <div class="col-md-12">
    <span class="icon_hr_bell"><img src="images/icon_bell.png" class="icon_appeal"></span>
    <span class="txt_hr_bell_title"><?=$txt_Notification?></span>

    <div class="input-group appeal_search">
     <input type="text" class="form-control search_text" placeholder="<?php if($lang == "1"){ echo "ค้นหา";}elseif($lang == "2"){ echo "Search";}else{ echo "ค้นหา";}?>" name="search_text" style="border-right-width: 0px;">
     <span class="input-group-addon bg-black btn-click-search" onclick="search_noti()">
       <i class="glyphicon glyphicon-search"></i>
     </span>
   </div>
    <div class="panel panel-default appeal_panel appeal_panel_bell">
      <div class="panel-body" style="padding: 0px;">
           <div class="tabla_data">
                   <table data-toggle="table" class="table-caseCh-list"
                   data-sort-name="id"
                   data-sort-status="status"
                   data-sort-order="DESC"
                   data-side-pagination="server"
                   data-pagination="true"
                   data-page-size="10"
                   data-page-list="[10, 50, 100, 200, ALL]"
                   data-url="noti_funtion.php?method=noti_bell"
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
  </div>
  </div>
</div>

<script>
$( document ).ready(function() {
  $('.noti_bell').remove();
  });
  function hide_icon(id){
    $.ajax({
        url: 'function_php/function_index.php',
        type: 'POST',
        async: false,
        responseType: "json",
        data: {
          'msgNotiApp_id':id,
          "method":"hide_icon"
        },
      success: function(res) {
        $('#fa_circle_'+id).remove();
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(jqXHR, textStatus, errorThrown);

      }
    });
  }

  function searchQueryParams(params) {
    params.text = $("input[name='search_text']").val();
    params.lang = $(".language_hidden").val();
    return params; // body data
  }

  function search_noti(){
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
</style>
