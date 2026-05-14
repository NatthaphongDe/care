<form class="form-horizontal form-notification">
  <div class="row">
    <div class="col-md-12">
      <div id="page-title">
        <span class="col-sm-12 icon-title-text">
          <i class="ditp-icon icon-ico-ditp-08" aria-hidden="true"></i>
          Notification
        </span>
      </div>
    </div>
  </div>
  <div class="panel" style="margin-top:10px;">
    <div class="row">

      <div class="col-xs-12">
        <table data-toggle="table" class="table-noti-list"
        data-side-pagination="server"
        data-pagination="true"
        data-page-size="20"
        data-page-list="[20, 50, 100, 200, ALL]"
        data-url="function.php?method=getNotiList"
        data-query-params="searchQueryParams"
        data-method="post">
        <thead>
          <tr>
            <th data-field="notiList">

            </th>
          </tr>
        </thead>
        </table>
      </div>
    </div>
  </div>
</form>

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

</script>


  <style>
  .form-notification  .title-hero, .title-hero span{
    text-align: left;
  }
  .row{
    display: inline-block;
    float: none;
    width: 100%;
    height: auto;
  }
  .fixed-table-toolbar{
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
