
<form class="form-horizontal form-msg">
  <div class="row">
    <div class="col-xs-12 col-sm-6">
      <div id="page-title">
        <span class="col-sm-12 icon-title-text">
          <i class="ditp-icon icon-ico-ditp-07" aria-hidden="true"></i>
          กล่องข้อความ
        </span>
      </div>
    </div>
    <div class="col-xs-12 col-sm-6" style="text-align:right;">
      <button type="button" class="btn btn-custom-tool btn-success btn-learn" onclick="window.location.href='index.php?page=message_box_create';" >
        <i class="ditp-icon icon-ico-ditp-21"></i>
        สร้างข้อความใหม่
      </button>
    </div>
  </div>

    <div class="panel" style="margin-top:10px;">
      <div class="row title-row">
        <div class="col-xs-12">
          <h3 class="title-hero col-xs-12">
              <span>กล่องข้อความ</span>
          </h3>
        </div>
      </div>
      <div class="row">

        <div class="col-xs-12">
          <table data-toggle="table" class="table-msg-list"
          data-side-pagination="server"
          data-pagination="true"
          data-page-size="20"
          data-page-list="[20, 50, 100, 200, ALL]"
          data-url="function.php?method=getMsgBoxList"
          data-query-params="searchQueryParams"
          data-method="post">
          <thead>
            <tr>
              <th data-field="msgList">

              </th>
          </tr>
          </thead>
          </table>
        </div>
    </div>
  </div>
</form>
<div class="clearfix"></div>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="assets/bootstrap-table/dist/bootstrap-table.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="assets/bootstrap-table/dist/bootstrap-table.min.js"></script>
<!-- Latest compiled and minified Locales -->
<script src="assets/bootstrap-table/dist/locale/bootstrap-table-th-TH.min.js"></script>

<script>
  function searchQueryParams(params) {

    return params; // body data
  }


  function remove_msg(elm,msg_id){
    $.ajax({
      url: "function.php?method=remove_msg",
      data:{ "msg_id":msg_id },
      type: 'post',
      async: false,
      success: function(data_res) {
        console.log(data_res);
        if(data_res=="00"){
          $('.table-msg-list').bootstrapTable('refresh');
        }
      }
    });
  }

</script>
<style>
.form-msg  .title-hero, .title-hero span{
  text-align: left;
}
.row{
  display: inline-block;
  float: none;
  width: 100%;
  height: auto;
}
#page-content{
    float: none;
    width: auto;
    text-align: center;
}
</style>
