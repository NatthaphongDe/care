<?php
if($_POST['method']!="search_letter"){
include('config/config.php');
$date_time = date("Y-m-d H:i:s");

$case_id_arr = array();
$sql = "SELECT * FROM `Case` WHERE caseCh_id in (1,2)  AND case_createBy_id = '".$_SESSION['member_id']."'";
$query = $conn->query($sql);
while ($re = $query->fetch_assoc()) {
  $case_id_arr['case_id'] = $re['case_id'];
  array_push($case_id_arr,$case_id_arr['case_id']);
}
$case = "";
$i =0;
foreach ($case_id_arr as $value) {
  if($i == 0){
    $case =  $value;
  }else {
    $case .=  ",".$value;
  }
  $i++;
}
$sql_noti= "UPDATE `Message_Box_Log` SET msgBox_noti_status='1',msgBox_noti_datetime='".$date_time."' WHERE recipient_type = 1 AND recipient_id = '".$_SESSION['member_id']."'";
$query_noti = $conn->query($sql_noti);
}
?>

<div class="row appeal_div_row">
  <div class="col-md-12">
    <span class="icon_hr_letter"><img src="images/icon_letter_black.png" class="icon_appeal"></span>
    <span class="txt_hr_letter_title"><?=$txt_Message?></span>

    <span class="new_letter_plus1" style="display:none;">
      <a href="?page=new_letter">
     <span class="txt_plus_letter"><?=$txt_Create_message?></span>
     <span class="icon_plus"><img src="images/icon_plus.png"></span></a>
   </span>

    <div class="input-group appeal_search">
     <input type="text" class="form-control search_text" placeholder="<?php if($lang == "1"){ echo "ค้นหา";}elseif($lang == "2"){ echo "Search";}else{ echo "ค้นหา";}?>" name="search_text" style="border-right-width: 0px;">
     <span class="input-group-addon bg-black btn-click-search" onclick="search_msg();">
       <i class="glyphicon glyphicon-search"></i>
     </span>
   </div>
   <span class="new_letter_plus2">
     <a href="?page=new_letter">
    <span class="txt_plus_letter"><?=$txt_Create_message?></span>
    <span class="icon_plus"><img src="images/icon_plus.png"></span></a>
  </span>
    <div class="letter_center_hr">
    <div class="panel panel-default appeal_panel">
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
                   data-url="msg_funtion.php?method=msg_list"
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
</div>
<script>
$( document ).ready(function() {
  $('.noti_letter').remove();
  });

  function searchQueryParams(params) {
    params.text = $("input[name='search_text']").val();
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
</style>
