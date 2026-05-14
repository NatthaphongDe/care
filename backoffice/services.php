<script>

  $('.bs-table').bootstrapTable();

  function searchQueryParams(params) {
        return params; // body data
  }
</script>

<div id="page-title">
    <h2>Service Management</h2>

</div>

<form class="form-horizontal bordered-row">
  <div class="panel">
    <div class="panel-body">
      <div id="toolbar">
          <button id="remove" class="btn btn-danger" disabled>
              <i class="glyphicon glyphicon-remove"></i> Delete
          </button>
      </div>
      <div class="table-container">
      	<table class="table table-filter bs-table"
           data-toolbar="#toolbar"
           data-search="true"
           data-show-refresh="true"
           data-show-toggle="true"
           data-show-columns="true"
           data-show-export="true"
           data-detail-view="true"
           data-detail-formatter="detailFormatter"
           data-minimum-count-columns="2"
           data-show-pagination-switch="true"
           data-pagination="true"
           data-id-field="id"
           data-page-list="[10, 25, 50, 100, ALL]"
           data-show-footer="false"
           data-side-pagination="server"
           data-url="/examples/bootstrap_table/data"
           data-query-params="searchQueryParams">
      		<tbody>
      			<tr data-status="pagado">
      				<td>
      					<div class="ckbox">
      						<input type="checkbox" id="checkbox1">
      						<label for="checkbox1"></label>
      					</div>
      				</td>
      				<td>
      					<a href="javascript:;" class="star">
      						<i class="glyphicon glyphicon-star"></i>
      					</a>
      				</td>
      				<td>
      					<div class="media">
      						<a href="#" class="pull-left">
      							<img src="https://s3.amazonaws.com/uifaces/faces/twitter/fffabs/128.jpg" class="media-photo">
      						</a>
      						<div class="media-body-tbl">
      							<span class="media-meta pull-right">Febrero 13, 2016</span>
      							<h4 class="title">
      								Lorem Impsum
      								<span class="pull-right pagado">(Pagado)</span>
      							</h4>
      							<p class="summary">Ut enim ad minim veniam, quis nostrud exercitation...</p>
      						</div>
      					</div>
      				</td>
      			</tr>
      			<tr data-status="pendiente">
      				<td>
      					<div class="ckbox">
      						<input type="checkbox" id="checkbox3">
      						<label for="checkbox3"></label>
      					</div>
      				</td>
      				<td>
      					<a href="javascript:;" class="star">
      						<i class="glyphicon glyphicon-star"></i>
      					</a>
      				</td>
      				<td>
      					<div class="media">
      						<a href="#" class="pull-left">
      							<img src="https://s3.amazonaws.com/uifaces/faces/twitter/fffabs/128.jpg" class="media-photo">
      						</a>
      						<div class="media-body-tbl">
      							<span class="media-meta pull-right">Febrero 13, 2016</span>
      							<h4 class="title">
      								Lorem Impsum
      								<span class="pull-right pendiente">(Pendiente)</span>
      							</h4>
      							<p class="summary">Ut enim ad minim veniam, quis nostrud exercitation...</p>
      						</div>
      					</div>
      				</td>
      			</tr>
      			<tr data-status="cancelado">
      				<td>
      					<div class="ckbox">
      						<input type="checkbox" id="checkbox2">
      						<label for="checkbox2"></label>
      					</div>
      				</td>
      				<td>
      					<a href="javascript:;" class="star">
      						<i class="glyphicon glyphicon-star"></i>
      					</a>
      				</td>
      				<td>
      					<div class="media">
      						<a href="#" class="pull-left">
      							<img src="https://s3.amazonaws.com/uifaces/faces/twitter/fffabs/128.jpg" class="media-photo">
      						</a>
      						<div class="media-body-tbl">
      							<span class="media-meta pull-right">Febrero 13, 2016</span>
      							<h4 class="title">
      								Lorem Impsum
      								<span class="pull-right cancelado">(Cancelado)</span>
      							</h4>
      							<p class="summary">Ut enim ad minim veniam, quis nostrud exercitation...</p>
      						</div>
      					</div>
      				</td>
      			</tr>
      			<tr data-status="pagado" class="selected">
      				<td>
      					<div class="ckbox">
      						<input type="checkbox" id="checkbox4" checked>
      						<label for="checkbox4"></label>
      					</div>
      				</td>
      				<td>
      					<a href="javascript:;" class="star star-checked">
      						<i class="glyphicon glyphicon-star"></i>
      					</a>
      				</td>
      				<td>
      					<div class="media">
      						<a href="#" class="pull-left">
      							<img src="https://s3.amazonaws.com/uifaces/faces/twitter/fffabs/128.jpg" class="media-photo">
      						</a>
      						<div class="media-body-tbl">
      							<span class="media-meta pull-right">Febrero 13, 2016</span>
      							<h4 class="title">
      								Lorem Impsum
      								<span class="pull-right pagado">(Pagado)</span>
      							</h4>
      							<p class="summary">Ut enim ad minim veniam, quis nostrud exercitation...</p>
      						</div>
      					</div>
      				</td>
      			</tr>
      			<tr data-status="pendiente">
      				<td>
      					<div class="ckbox">
      						<input type="checkbox" id="checkbox5">
      						<label for="checkbox5"></label>
      					</div>
      				</td>
      				<td>
      					<a href="javascript:;" class="star">
      						<i class="glyphicon glyphicon-star"></i>
      					</a>
      				</td>
      				<td>
      					<div class="media">
      						<a href="#" class="pull-left">
      							<img src="https://s3.amazonaws.com/uifaces/faces/twitter/fffabs/128.jpg" class="media-photo">
      						</a>
      						<div class="media-body-tbl">
      							<span class="media-meta pull-right">Febrero 13, 2016</span>
      							<h4 class="title">
      								Lorem Impsum
      								<span class="pull-right pendiente">(Pendiente)</span>
      							</h4>
      							<p class="summary">Ut enim ad minim veniam, quis nostrud exercitation...</p>
      						</div>
      					</div>
      				</td>
      			</tr>
      		</tbody>
      	</table>
      </div>
    <div class="panel-body">
  <div class="panel">
</form>
