<?php 
include('report.php'); 
?>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<i class="ditp-icon icon-ico-ditp-06"></i>
<span class="txt_hr_report">Report</span>


  <div class="row">
    <div class="col-md-12" style="padding-right:0px;">
      <div class="panel panel-default panel-report">
      <div class="panel-body">
          <div class="hr_report" style="display:inline-block;">รายงานเปรียบเทียบเรื่องร้องเรียน
            <span class="txt_date_time">
            <!-- ( <?php
            if($_POST['year_set_1'] == "1"){
              if($_POST['date_start'] != "" && $_POST['date_stop'] != ""){
                echo "Date : ".$_POST['date_start']." - ".$_POST['date_stop'];
              }else {
                if($_POST['month_issue_th'] != ""){
                  if($_POST['month_issue_th'] == "01"){
                    $month = "มกราคม";
                  }elseif ($_POST['month_issue_th'] == "02") {
                    $month = "กุมภาพันธ์";
                  }elseif ($_POST['month_issue_th'] == "03") {
                    $month = "มีนาคม";
                  }elseif ($_POST['month_issue_th'] == "04") {
                    $month = "เมษายน";
                  }elseif ($_POST['month_issue_th'] == "05") {
                    $month = "พฤษภาคม";
                  }elseif ($_POST['month_issue_th'] == "06") {
                    $month = "มิถุนายน";
                  }elseif ($_POST['month_issue_th'] == "07") {
                    $month = "กรกฎาคม";
                  }elseif ($_POST['month_issue_th'] == "08") {
                    $month = "สิงหาคม";
                  }elseif ($_POST['month_issue_th'] == "09") {
                    $month = "กันยายน";
                  }elseif ($_POST['month_issue_th'] == "10") {
                    $month = "ตุลาคม";
                  }elseif ($_POST['month_issue_th'] == "11") {
                    $month = "พฤศจิกายน";
                  }elseif ($_POST['month_issue_th'] == "12") {
                    $month = "ธันวาคม";
                  }
                  if($_POST['year_set_2'] == "1"){
                    $type_year = " (ปีปฎิทิน)";
                  }else {
                    $type_year = " (ปีงบประมาณ)";
                  }
                  echo $month." ปี ".((int)$_POST['issue_year_th']+543).$type_year;
                }else {
                  if($_POST['quarter'] != ""){
                    if($_POST['quarter'] == "1"){
                      $quarter = "ไตรมาสที่ 1 ";
                    }elseif ($_POST['quarter'] == "2") {
                      $quarter = "ไตรมาสที่ 2 ";
                    }elseif ($_POST['quarter'] == "3") {
                      $quarter = "ไตรมาสที่ 3 ";
                    }elseif ($_POST['quarter'] == "4") {
                      $quarter = "ไตรมาสที่ 4 ";
                    }
                    if($_POST['year_set_2'] == "1"){
                      $type_year = " (ปีปฎิทิน)";
                    }else {
                      $type_year = " (ปีงบประมาณ)";
                    }
                    echo $quarter."ปี : ".((int)$_POST['issue_year_th']+543).$type_year;
                  }else {
                    if($_POST['year_set_2'] == "1"){
                      $type_year = " (ปีปฎิทิน)";
                    }else {
                      $type_year = " (ปีงบประมาณ)";
                    }
                    echo "ปี : ".((int)$_POST['issue_year_th']+543).$type_year;
                  }
                }
              }
            }else {
              if($_POST['date_start'] != "" && $_POST['date_stop'] != ""){
                echo "Date : ".$_POST['date_start']." - ".$_POST['date_stop'];
              }else {
                if($_POST['month_issue_en'] != ""){
                  if($_POST['month_issue_en'] == "01"){
                    $month = "January";
                  }elseif ($_POST['month_issue_en'] == "02") {
                    $month = "February";
                  }elseif ($_POST['month_issue_en'] == "03") {
                    $month = "March";
                  }elseif ($_POST['month_issue_en'] == "04") {
                    $month = "April";
                  }elseif ($_POST['month_issue_en'] == "05") {
                    $month = "May";
                  }elseif ($_POST['month_issue_en'] == "06") {
                    $month = "June";
                  }elseif ($_POST['month_issue_en'] == "07") {
                    $month = "July";
                  }elseif ($_POST['month_issue_en'] == "08") {
                    $month = "August";
                  }elseif ($_POST['month_issue_en'] == "09") {
                    $month = "September";
                  }elseif ($_POST['month_issue_en'] == "10") {
                    $month = "October";
                  }elseif ($_POST['month_issue_en'] == "11") {
                    $month = "November";
                  }elseif ($_POST['month_issue_en'] == "12") {
                    $month = "December";
                  }
                  if($_POST['year_set_2'] == "1"){
                    $type_year = " (ปีปฎิทิน)";
                  }else {
                    $type_year = " (ปีงบประมาณ)";
                  }
                  echo $month." ปี ".$_POST['issue_year_en'].$type_year;
                }else {
                  if($_POST['quarter'] != ""){
                    if($_POST['quarter'] == "1"){
                      $quarter = "ไตรมาสที่ 1 ";
                    }elseif ($_POST['quarter'] == "2") {
                      $quarter = "ไตรมาสที่ 2 ";
                    }elseif ($_POST['quarter'] == "3") {
                      $quarter = "ไตรมาสที่ 3 ";
                    }elseif ($_POST['quarter'] == "4") {
                      $quarter = "ไตรมาสที่ 4 ";
                    }
                    if($_POST['year_set_2'] == "1"){
                      $type_year = " (ปีปฎิทิน)";
                    }else {
                      $type_year = " (ปีงบประมาณ)";
                    }
                    echo $quarter."ปี : ".$_POST['issue_year_en'].$type_year;
                  }else {
                    if($_POST['year_set_2'] == "1"){
                      $type_year = " (ปีปฎิทิน)";
                    }else {
                      $type_year = " (ปีงบประมาณ)";
                    }
                    echo "ปี : ".$_POST['issue_year_en'].$type_year;
                  }
                }
              }
            }
          ?> ) -->
        </span></div>
        <div class="total-report" style="position:absolute;">

        <?php 
        $year_thai = 0;
        if($_POST['year_set_1'] == 1){
          $year_thai = 543;
        } 
        
        if($_POST['year_set_1'] == 1){ ?>
          <span class="total-case-issue_txt">ระหว่างปี <?=$_POST['year_com_1_1']+$year_thai?> กับปี <?=$_POST['year_com_1_2']+$year_thai?></span>
        <?php } else{ ?>
          <span class="total-case-issue_txt">ระหว่างปี <?=$_POST['year_com_2_1']+$year_thai?> กับปี <?=$_POST['year_com_2_2']+$year_thai?></span>
        <?php } ?>

        </div>
        <!-- <div class="total-report" style="position:absolute;">
          <span class="total-case-issue_txt">Total case : </span>
          <span class="total-case-issue"></span>
          <span class="open-issue">(</span>
          <span class="total-waiting-issue"></span>
          <span class="total-new-issue"></span>
          <span class="total-pending-issue"></span>
          <span class="total-overduemain-issue"></span>
          <span class="total-overduesub-issue"></span>
          <span class="total-closesuccess-issue"></span>
          <span class="total-closecontinue-issue"></span>
          <span class="total-closereject-issue"></span>
          <span class="total-close-issue"></span>
          <span class="Closeoverdue"></span>
          <span class="end-issue">)</span>
        </div> -->
          <div class="filter_report" style="margin-left:10px;">

          <button class="btn btn-filter" onclick="modal_chk_issue();"><i class="fa fa-filter" aria-hidden="true" style="margin-right:5px;"></i>Filter</button>

        <form method="post" action="report/export_issue.php" enctype="multipart/form-data" style="display: inline-block;margin-right: 10px;">
          <input type="hidden" class="year_set_1" name="year_set_1" value="<?=$_POST['year_set_1']?>">
          <input type="hidden" class="year_set_2" name="year_set_2" value="<?=$_POST['year_set_2']?>">
          <input type="hidden" class="issue_year_th" name="issue_year_th" value="<?=$_POST['issue_year_th']?>">
          <input type="hidden" class="issue_year_en" name="issue_year_en" value="<?=$_POST['issue_year_en']?>">
          <input type="hidden" class="quarter" name="quarter" value="<?=$_POST['quarter']?>">
          <input type="hidden" class="month_issue_th" name="month_issue_th" value="<?=$_POST['month_issue_th']?>">
          <input type="hidden" class="month_issue_en" name="month_issue_en" value="<?=$_POST['month_issue_en']?>">
          <input type="hidden" class="date_start" name="date_start" value="<?=$_POST['date_start']?>">
          <input type="hidden" class="date_stop" name="date_stop" value="<?=$_POST['date_stop']?>">
          <input type="hidden" name="compType_id" value="<?=$_POST['compType_id']?>">
          <input type="hidden" name="prodType_id" value="<?=$_POST['prodType_id']?>">
          <input type="hidden" name="caseCh_id" value="<?=$_POST['caseCh_id']?>">
          <!-- <input type="hidden" name="Country_applnt" value="<?=$_POST['Country_applnt']?>"> -->
          <input type="hidden" name="Country_complnt" value="<?=$_POST['Country_complnt']?>">
          <input type="hidden" name="member_comp_type" value="<?=$_POST['member_comp_type']?>">
          <input type="hidden" name="status_complaint" value="<?=$_POST['status_complaint']?>">
          <input type="hidden" name="respon" value="<?=$_POST['respon']?>">
          <input type="hidden" name="office_id" value="<?=$_POST['office_id']?>">


          <input type="hidden" class="export-case-issue" name="case">
          <input type="hidden" class="export-waiting-issue" name="waiting">
          <input type="hidden" class="export-new-issue" name="new">
          <input type="hidden" class="export-pending-issue" name="pending">
          <input type="hidden" class="export-overduemain-issue" name="overduemain">
          <input type="hidden" class="export-overduesub-issue" name="overduesub">
          <input type="hidden" class="export-closesuccess-issue" name="closesuccess">
          <input type="hidden" class="export-closecontinue-issue" name="closecontinue">
          <input type="hidden" class="export-closereject-issue" name="closereject">
          <input type="hidden" class="export-close-issue" name="close">
          <input type="hidden" class="export-Closeoverdue" name="Closeoverdue">

          <input type="hidden" name="year_com_1_1" value="<?=$_POST['year_com_1_1']?>">
          <input type="hidden" name="year_com_1_2" value="<?=$_POST['year_com_1_2']?>">
          <input type="hidden" name="year_com_2_1" value="<?=$_POST['year_com_2_1']?>">
          <input type="hidden" name="year_com_2_2" value="<?=$_POST['year_com_2_2']?>">
          <!-- <button class="btn btn-success">Export</button> -->
        </form>

        </div>

        <style>
          .tabla_data .bootstrap-table .table:not(.table-condensed)>tbody>tr>td {
    text-align: left !important;
    color: #000;
}
        </style>
          <div class="filter_report">
            <div class="input-group report_search">
             <!-- <input type="text" class="form-control search_text" name="search_text" id="search_text_auto">
             <span class="input-group-addon bg-black btn-click-search">
               <i class="glyphicon glyphicon-search"></i>
             </span> -->
            </div>
          </div>

          <div style="margin-top:10px;">

            <div class="tabla_data">
              <table data-toggle="table" class="table-caseCh-list"
              data-sort-name=""
              data-sort-status="status"
              data-sort-order="DESC"
              data-side-pagination="server"
              data-pagination="true"
              data-page-size="10"
              data-page-list="[10, 50, 100, 200, ALL]"
              data-url="report/report_table_all.php?method=report_compare"
              data-query-params="searchQueryParams"
              data-method="post">
                  <thead>
                    <tr>
                      <th data-field="id" data-sortable="false" data-align="center" data-width="5%">
                      ลำดับที่
                    </th>
                    <th data-field="year" data-sortable="false" data-width="10%" align="left">
                      ปี 
                    </th>
                    <?php
                      if($_POST['year_set_2'] == 1){
                    ?>
                   
                    <th data-field="JAN" data-sortable="false" data-width="5%" align="left">
                    ม.ค.
                    </th>
                    <th data-field="FEB" data-sortable="false" data-width="5%" align="left">
                    ก.พ.
                    </th>
                    <th data-field="MAR" data-sortable="false" data-width="5%" align="left">
                    มี.ค.
                    </th>
                    <th data-field="APR" data-sortable="false" data-width="5%" align="left">
                    เม.ย.
                    </th>
                    <th data-field="MAY" data-sortable="false" data-width="5%" align="left">
                    พ.ค.
                    </th>
                    <th data-field="JUN" data-sortable="false" data-width="5%" align="left">
                    มิ.ย.
                    </th>
                    <th data-field="JUL" data-sortable="false" data-width="5%" align="left">
                    ก.ค.
                    </th>
                    <th data-field="AUG" data-sortable="false" data-width="5%" align="left">
                    ส.ค.
                    </th>
                    <th data-field="SEP" data-sortable="false" data-width="5%" align="left">
                    ก.ย.
                    </th>
                    <th data-field="OCT" data-sortable="false" data-width="5%" align="left">
                    ต.ค.
                    </th>
                    <th data-field="NOV" data-sortable="false" data-width="5%" align="left">
                    พ.ย.
                    </th>
                    <th data-field="DEC" data-sortable="false" data-width="5%" align="left">
                    ธ.ค.
                    </th>
                    <?php
                      } else{
                    ?>
                    <th data-field="budget1" data-sortable="false" data-width="5%" align="left">
                    ไตรมาส 1
                    </th>
                    <th data-field="budget2" data-sortable="false" data-width="5%" align="left">
                    ไตรมาส 2
                    </th>
                    <th data-field="budget3" data-sortable="false" data-width="5%" align="left">
                    ไตรมาส 3
                    </th>
                    <th data-field="budget4" data-sortable="false" data-width="5%" align="left">
                    ไตรมาส 4
                    </th>
                    <?php
                      } 
                    ?>
                    <th data-field="case_num" data-sortable="false" data-align="center" data-width="15%">
                      จำนวนเรื่องร้องเรียนทั้งปี
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
  <div class="row">
    <div class="col-md-12" style="padding-right:0px;">
      <div class="panel panel-default panel-report">
        <div class="panel-body">
          <div id="chart"></div>
        </div>
      </div>
    </div>
  </div>

<script>



            // $.ajax({
            //     url: 'report/report_table_all.php?method=report_country_chart',
            //     type: 'POST',
            //     async: false,
            //     responseType: "json",
            //     data: {},
            //   success: function(res) {
            //     var res = JSON.parse(res);
            //     console.log(res);
            //     // return false;
            //     var name_chart = [];
            //     var value_chart = [];
            //     $.each(res, function( index, val ) {
            //       name_chart.push(val.name_th);
            //       value_chart.push(val.country_num);
            //     });

            //     var options = {
            //       series: [{
            //       data: value_chart,
            //       name: 'Case',
            //     }],
            //       chart: {
            //       type: 'bar',
            //       height: (35 * res.length)
            //     },
            //     plotOptions: {
            //       bar: {
            //         borderRadius: 4,
            //         horizontal: true,
            //       }
            //     },
            //     dataLabels: {
            //       enabled: true
            //     },
            //     colors: ['#048f78'],
            //     xaxis: {
            //       categories: name_chart,
            //     }
            //     };

            //     var chart = new ApexCharts(document.querySelector("#chart"), options);
            //     chart.render();
            //   },
            //   error: function(jqXHR, textStatus, errorThrown) {
            //     console.log(jqXHR, textStatus, errorThrown);

            //   }
            // });

    // var $result = $('.table-caseCh-list');
    // var chek_chart = [];
    // var i_chart = 0;
    // $('.table-caseCh-list')
    // .on('post-body.bs.table', function (e, row, $element) {
      
      
        
        // var name_chart = [];
        //   var value_chart = [];
        //   $.each(row, function( index, val ) {
        //     name_chart.push(val.name_th);
        //     value_chart.push(val.country_num);
        //   });

        //   var options = {
        //     series: [{
        //     data: value_chart
        //   }],
        //     chart: {
        //     type: 'bar',
        //     height: 350
        //   },
        //   plotOptions: {
        //     bar: {
        //       borderRadius: 4,
        //       horizontal: true,
        //     }
        //   },
        //   dataLabels: {
        //     enabled: false
        //   },
        //   xaxis: {
        //     categories: name_chart,
        //   }
        //   };

        //   console.log(options);
        //   var chart = new ApexCharts(document.querySelector("#chart"), options);
        //   chart.render();
        
    // });
  
  
      
</script>

<form method="post" action="#" id="modal_filter_issue" enctype="multipart/form-data">
		<div class="modal fade" id="modal_chk_issue" tabindex="-1" role="dialog" aria-labelledby="modal_chk_issue" style="padding:0px;">
			<div class="modal-dialog modal_chk_issue" role="document" style="width:1200px;">
				<div class="modal-content" style="border-radius: 11px 11px 11px 11px;">
					<div class="modal-body">

              <div class="row" style="margin-top:30px;">
                <div class="col-md-1"></div>
                <div class="col-md-10" style="padding-right:0px;">
                  <div class="panel panel-default" style="background-color: #eceff1;">
                      <div class="panel-body">
                        <div class="row">
                          <div class="col-md-2 col-sm-4 col-xs-12">การแสดงผล</div>
                          <div class="radio radio-success col-md-2 col-sm-4 col-xs-6">
                            <input type="radio" value="1" name="year_set_1" id="year_set1_1" onclick="chk_radio_issue_year_modal();" <?php if($_POST['year_set_1'] == "1"){ echo "checked";}?>>
                            <label class="txt_report" for="year_set1_1">พ.ศ.</label>
                          </div>
                          <div class="radio radio-success col-md-4 col-sm-4 col-xs-6">
                            <input type="radio" value="2" name="year_set_1" id="year_set1_2" onclick="chk_radio_issue_year_modal();" <?php if($_POST['year_set_1'] == "2"){ echo "checked";}?>>
                            <label class="txt_report" for="year_set1_2">ค.ศ.</label>
                          </div>
                          <div class="col-md-4"></div>
                        </div>
                      </div>
                    </div>

                  <div class="panel panel-default" style="background-color: #eceff1;">
                      <div class="panel-body">
                        <div class="row">
                          <div class="col-md-2 col-sm-4 col-xs-12">ประเภทปี</div>
                          <div class="radio radio-success col-md-2 col-sm-4 col-xs-6">
                            <input type="radio" value="1" name="year_set_2" id="year_set2_1" onclick="chk_radio_issue_modal();" <?php if($_POST['year_set_2'] == "1"){ echo "checked";}?>>
                            <label class="txt_report" for="year_set2_1">ปีปฏิทิน</label>
                          </div>
                          <div class="radio radio-success col-md-4 col-sm-4 col-xs-6">
                            <input type="radio" value="2" name="year_set_2" id="year_set2_2" onclick="chk_radio_issue_modal();" <?php if($_POST['year_set_2'] == "2"){ echo "checked";}?>>
                            <label class="txt_report" for="year_set2_2">ปีงบประมาณ</label>
                          </div>
                          <div class="col-md-4"></div>
                        </div>
                      </div>
                    </div>

                    <div class="panel panel-default" style="background-color: #eceff1;">
            <div class="panel-body">
              <div class="row div_report date_issue row-margin">
                <div class="col-md-2" style="font-weight: bold;">ปีที่ต้องการเปรียบเทียบ</div>
                <div class="col-md-3 col-xs-12">
                  <span class="txt_report">ปี</span>
                </div>
                <div class="col-md-4 col-xs-12">
                  <div class="issue_year1">
                  <select class="selectpicker form-control" name="year_com_1_1" id="year_com_1_1" onchange="select_month_issue();">
                  <option value="">- เลือกปี -</option>
                    <?php
                    $date_year = date("Y");
                    for($year = $date_year+1; $year>=$date_year-5; $year--){
                      $year_sum = $year+543;
                    ?>
                    <option value="<?=$year;?>"><?=$year_sum;?></option>
                    <?php  } ?>
                  </select>
                </div>
                <div class="issue_year2">
                  <select class="selectpicker form-control" name="year_com_2_1" id="year_com_2_1" onchange="select_month_issue();">
                  <option value="">- เลือกปี -</option>
                    <?php
                    $date_year = date("Y");
                    $selected = '';
                    $ii = 0;
                    for($year = $date_year+1; $year>=$date_year-5; $year--){
                      if($ii == 0){
                        $selected = 'selected';
                      }
                      $ii++;
                    ?>
                    <option value="<?=$year;?>"   ><?=$year;?></option>
                    <?php  } ?>
                  </select>
                </div>
                <input type="hidden" class="year_start" value="<?=$date_year-5;?>">
                <input type="hidden" class="year_stop" value="<?=$date_year+1;?>">
                
                </div>
                
                <div class="col-md-5"></div>
              </div>
              <div class="row div_report date_issue ">
                <div class="col-md-2"></div>
                <div class="col-md-3 col-xs-12">
                  <span class="txt_report">เปรียบเทียบปี</span>
                </div>
                <div class="col-md-4 col-xs-12" id="quarter_txt">
                  
                <div class="issue_year1">
                  <select class="selectpicker form-control" name="year_com_1_2" id="year_com_1_2" onchange="select_month_issue();">
                  <option value="">- เลือกปี -</option>
                    <?php
                    $date_year = date("Y");
                    $ii = 0;
                    for($year = $date_year+1; $year>=$date_year-5; $year--){
                      $year_sum = $year+543;
                      if($ii == 1){
                        $selected = 'selected';
                      }
                      $ii++;
                    ?>
                    <option value="<?=$year;?>" ><?=$year_sum;?></option>
                    <?php  } ?>
                  </select>
                </div>
                <div class="issue_year2">
                  <select class="selectpicker form-control" name="year_com_2_2" id="year_com_2_2" onchange="select_month_issue();">
                    <option value="">- เลือกปี -</option>
                    <?php
                    $date_year = date("Y");
                    for($year = $date_year+1; $year>=$date_year-5; $year--){
                    ?>
                    <option value="<?=$year;?>"><?=$year;?></option>
                    <?php  } ?>
                  </select>
                </div>
                </div>
                <div class="col-md-5"></div>
              </div>
            </div>
          </div>

                   
                </div>
                <div class="col-md-1"></div>
            </div>
            </div>
            <hr style="margin-left:10px;margin-right:10px;">
            <div class="btn-report-issue">
              <button type="button" class="btn btn-success submit_report_issue_modal_com">ตกลง</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
            </div>
          </div>
				</div>

	</div>
</form>

<script>



$(document).ready(function() {

  $(document).delegate(".submit_report_issue_modal_com","click",function(){
  var chk_radio = $('input[name=year_set_1]:checked', '#modal_filter_issue').val();
  console.log($('#year_com_1_1').val(), $('#year_com_1_2').val());
  if(chk_radio == "1"){
    if($('#year_com_1_1').val() == "" || $('#year_com_1_2').val() == ""){
        alert("กรุณาเลือกปีที่ต้องการเปรียบเทียบ");
    } else if($('#year_com_1_1').val() == $('#year_com_1_2').val() ){
        alert("ปีที่ต้องการเปรียบเทียบซ้ำกัน");
    }else {
      $( "#modal_filter_issue" ).submit();
    }
  } else{
    if($('#year_com_2_1').val() == "" || $('#year_com_2_2').val() == ""){
        alert("กรุณาเลือกปีที่ต้องการเปรียบเทียบ");
    } else if($('#year_com_2_1').val() == $('#year_com_2_2').val() ){
        alert("ปีที่ต้องการเปรียบเทียบซ้ำกัน");
    }else {
      $( "#modal_filter_issue" ).submit();
    }
  }
    
});

    var chek_chart = [];
    var i_chart = 0;
    $('.table-caseCh-list').on('load-success.bs.table', function (e, name, args) {
    // $('#chart').html('');
    console.log(name.rows);
    auto_resize_menu();
    var data = [];
    $.each(name.rows, function( index, val ) {
        if(val.type==1){
          data.push({
            'name': val.year,
            'data': [val.JAN, val.FEB, val.MAR, val.APR, val.MAY, val.JUN, val.JUL, val.AUG, val.SEP, val.OCT, val.NOV, val.DEC]
          });
        } else {
          data.push({
            'name': val.year,
            'data': [val.budget1, val.budget2, val.budget3, val.budget4]
          });
        }
        
    })

    if(name.rows.length > 0 ){
      if(name.rows[0].type == 1){
        var title = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];
      } else{
        var title = ['ไตรมาสที่ 1', 'ไตรมาสที่ 2', 'ไตรมาสที่ 3', 'ไตรมาสที่ 4'];
      }
    }
    
    
    var options = {
          series: data,
          chart: {
          height: 350,
          type: 'line',
          zoom: {
            enabled: false
          }
        },
        dataLabels: {
          enabled: true
        },
        stroke: {
          curve: 'straight'
        },
        title: {
          text: 'กราฟเปรียบเทียบเรื่องร้องเรียน',
          align: 'left'
        },
        grid: {
          row: {
            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5
          },
        },
        colors: ['#048f78', '#f1b705'],
        xaxis: {
          categories: title,
        }
        };
        console.log(options);
        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    // console.log(name);
    auto_resize_menu();
    /* jQuery UI นับเวลา */
      $('.clock').each(function(){
        var elm_click = "#"+$(this).attr('id');
        var datetime = $(this).text();
        $(elm_click).countdown(datetime, {elapse:true}).on('update.countdown', function(event) {
          var format = '';

          if(event.offset.days == 0 && event.offset.hours == 0 && event.offset.minutes == 0 && event.offset.seconds < 60) {
            format = '0 วัน' + format;
          }else{
            if(event.offset.minutes > 0){
              format = '%M นาที' + format;
              //var format = '%M นาที';
            }
            if(event.offset.hours   > 0){
              format = '%H ชั่วโมง ' + format;
            }
            if(event.offset.totalDays > 0) {
              format = '%D วัน ' + format;
            }
          }
          /*if(event.offset.weeks > 0) {
            format = '%-w week%!w ' + format;
          }*/
          $(this).html(event.strftime(format));

        })
        .on('finish.countdown', function(event) {
          $(this).html('This offer has expired!')
            .parent().addClass('disabled');

        });
      });
    });



if($('#startDate').val() == ""){
  $('#stopDate').prop('disabled', 'disabled');
}


if($('.year_set_1').val() == "1"){
  if($('.issue_year_th').val() == ""){
    $('#issue_year1').attr('disabled', true);
  }else {
    $('#issue_year1').attr('disabled', false);
  }
  select_quarter_modal($('.quarter').val(),$('.month_issue_th').val());

  var month = $('.month_issue_th').val();

    $('#month_issue_1 option[value="'+month+'"]').attr("selected","selected");
    $('.selectpicker').selectpicker('refresh');
}else {

  if($('.issue_year_en').val() == ""){
    $('#issue_year2').attr('disabled', true);
  }else {
    $('#issue_year2').attr('disabled', false);
  }
  select_quarter_modal($('.quarter').val());

  var month = $('.month_issue_en').val();
  $('#month_issue_2 option[value="'+month+'"]').attr("selected","selected");
  $('.selectpicker').selectpicker('refresh');
}

if($('.year_set_2').val() == "1"){
  $('.date_issue_panel').show();
}else {
  $('.date_issue_panel').hide();
}

  // $('.table-caseCh-list').on('load-success.bs.table', function (e) {
  //   // $('[data-toggle="tooltip"]').tooltip();
  //   auto_resize_menu();
  // });

  $("input[name='search_text']").keypress(function(e) {
    if(e.which == 13) {
      $('.table-caseCh-list').bootstrapTable('refresh');
    }
  });

// var options = {
//
// url: "report/num_rows_report_issue.php?txt_search="+$("#search_text_auto").val()+"&method=search_text_issue",
//
// getValue: "name",
//
// list: {
//   match: {
//     enabled: true
//   }
// }
// };
//
// $("#search_text_auto").easyAutocomplete(options);
// $('.table-caseCh-list').bootstrapTable('refresh');
});

// ส่งค่าเข้า datatable
function searchQueryParams(params) {
  params.text = $("input[name='search_text']").val();
  params.year_set_1 = $("input[name='year_set_1']").val();
  params.year_set_2 = $("input[name='year_set_2']").val();
  params.issue_year_th = $("input[name='issue_year_th']").val();
  params.issue_year_en = $("input[name='issue_year_en']").val();
  params.quarter = $("input[name='quarter']").val();
  params.month_issue_th = $("input[name='month_issue_th']").val();
  params.month_issue_en = $("input[name='month_issue_en']").val();
  params.date_start = $("input[name='date_start']").val();
  params.date_stop = $("input[name='date_stop']").val();
  params.compType_id = $("input[name='compType_id']").val();
  params.prodType_id = $("input[name='prodType_id']").val();
  params.caseCh_id = $("input[name='caseCh_id']").val();
  // params.Country_applnt = $("input[name='Country_applnt']").val();
  params.Country_complnt = $("input[name='Country_complnt']").val();
  params.member_comp_type = $("input[name='member_comp_type']").val();
  params.status_complaint = $("input[name='status_complaint']").val();
  params.respon = $("input[name='respon']").val();
  params.office_id = $("input[name='office_id']").val();
  params.year_com_1_1 = $("input[name='year_com_1_1']").val();
  params.year_com_1_2 = $("input[name='year_com_1_2']").val();
  params.year_com_2_1 = $("input[name='year_com_2_1']").val();
  params.year_com_2_2 = $("input[name='year_com_2_2']").val();
  console.log(params);

  // $.ajax({
  //     url: 'report/num_rows_report_issue.php',
  //     type: 'POST',
  //     async: false,
  //     responseType: "json",
  //     data: ,
  //   success: function(res) {

  //   },
  //   error: function(jqXHR, textStatus, errorThrown) {
  //     console.log(jqXHR, textStatus, errorThrown);

  //   }
  // });

  return params; // body data
}
//////////

function num_rows_issue(){
  var text = $("input[name='search_text']").val();
  var year_set_1 = $("input[name='year_set_1']").val();
  var year_set_2 = $("input[name='year_set_2']").val();
  var issue_year_th = $("input[name='issue_year_th']").val();
  var issue_year_en = $("input[name='issue_year_en']").val();
  var quarter = $("input[name='quarter']").val();
  var month_issue_th = $("input[name='month_issue_th']").val();
  var month_issue_en = $("input[name='month_issue_en']").val();
  var date_start = $("input[name='date_start']").val();
  var date_stop = $("input[name='date_stop']").val();
  var compType_id = $("input[name='compType_id']").val();
  var prodType_id = $("input[name='prodType_id']").val();
  var caseCh_id = $("input[name='caseCh_id']").val();
  // var Country_applnt = $("input[name='Country_applnt']").val();
  var Country_complnt = $("input[name='Country_complnt']").val();
  var member_comp_type = $("input[name='member_comp_type']").val();
  var status_complaint = $("input[name='status_complaint']").val();
  var respon = $("input[name='respon']").val();
  var office_id = $("input[name='office_id']").val();

  $.ajax({
      url: 'report/num_rows_report_issue.php',
      type: 'POST',
      async: false,
      responseType: "json",
      data: {
        'text':text,
        'year_set_1':year_set_1,
        'year_set_2':year_set_2,
        'issue_year_th':issue_year_th,
        'issue_year_en':issue_year_en,
        'quarter':quarter,
        'month_issue_th':month_issue_th,
        'month_issue_en':month_issue_en,
        'date_start':date_start,
        'date_stop':date_stop,
        'compType_id':compType_id,
        'prodType_id':prodType_id,
        'caseCh_id':caseCh_id,
        // 'Country_applnt':Country_applnt,
        'Country_complnt':Country_complnt,
        'member_comp_type':member_comp_type,
        'status_complaint':status_complaint,
        'respon':respon,
        'office_id':office_id,
        "method":"report_issue"
      },
    success: function(res) {
      $('.total-case-issue').text(res.total);

      $('.total-waiting-issue').text("Waiting "+res.waiting+",");
      $('.total-new-issue').text("New "+res.new+",");
      $('.total-pending-issue').text("In Process "+res.pending+",");
      $('.total-overduemain-issue').text("Overdue Main Process "+res.overduemain+",");
      $('.total-overduesub-issue').text("Overdue Sub Process "+res.overduesub+",");
      $('.total-closesuccess-issue').text("Close Success "+res.closesuccess+",");
      $('.total-closecontinue-issue').text("Close Continue "+res.closecontinue+",");
      $('.total-closereject-issue').text("Close Reject "+res.closereject+",");
      $('.total-close-issue').text("Close "+res.close+',');
      $('.Closeoverdue').text("Close(overdue) "+res.Closeoverdue);

      $('.export-case-issue').val(res.total);

      $('.export-waiting-issue').val("Waiting "+res.waiting+",");
      $('.export-new-issue').val("New "+res.new+",");
      $('.export-pending-issue').val("In Process "+res.pending+",");
      $('.export-overduemain-issue').val("Overdue Main Process "+res.overduemain+",");
      $('.export-overduesub-issue').val("Overdue Sub Process "+res.overduesub+",");
      $('.export-closesuccess-issue').val("Close Success "+res.closesuccess+",");
      $('.export-closecontinue-issue').val("Close Continue "+res.closecontinue+",");
      $('.export-closereject-issue').val("Close Reject "+res.closereject+",");
      $('.export-close-issue').val("Close "+res.close+',');
      $('.export-Closeoverdue').val("Close(overdue) "+res.Closeoverdue);


    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(jqXHR, textStatus, errorThrown);

    }
  });
}
num_rows_issue();

function modal_chk_issue(){
  $('#modal_chk_issue').modal('show');
}




function chk_select_year(){
  var chk_radio = $('input[name=year_set_1]:checked', '#modal_filter_issue').val();
    if(chk_radio == "1"){
      var set_year = $('#issue_year1').val();
    }else {
      var set_year = $('#issue_year2').val();
    }

    if(set_year == ""){
        $('#select_quarter_chk').attr('disabled', true);
        $('#month_issue_1').attr('disabled', true);
        $('#month_issue_2').attr('disabled', true);
        $('#startDate').prop('disabled', false);
        $('#select_quarter_chk').val('');
        $('#month_issue_1').val('');
        $('#month_issue_2').val('');

    }else {
      $('#select_quarter_chk').attr('disabled', false);
      $('#month_issue_1').attr('disabled', false);
      $('#month_issue_2').attr('disabled', false);
      $('#startDate').prop('disabled', 'disabled');
      $('#stopDate').prop('disabled', 'disabled');
    }
}
chk_select_year();

$( "#issue_year1" ).change(function() {
  chk_select_year();
  $('.selectpicker').selectpicker('refresh');
});
$( "#issue_year2" ).change(function() {
  chk_select_year();
  $('.selectpicker').selectpicker('refresh');
});


function select_month_issue(){
var chk_radio = $('input[name=year_set_1]:checked', '#modal_filter_issue').val();
if(chk_radio == "1"){
  var lang = 'th';
  var th = true;
}else {
  var lang = 'en';
  var th = false;
}
var startDate = $('#startDate').val();
if (startDate != ""){
  var date_split = startDate.split("/");
  if(chk_radio == "1"){
    var year_set = parseInt(date_split[2]);
    var split_date = date_split[0]+"-"+date_split[1]+"-"+(year_set-543);
  }else {
    var split_date = date_split[0]+"-"+date_split[1]+"-"+date_split[2];
  }
  start = split_date;
  end = getEndDate();
  }else {
    start = getStartDate();
    end = getEndDate();
  }
     $('#datetimepicker').datepicker("remove");
     $('#datetimepicker2').datepicker("remove");

     $('#datetimepicker').datepicker({
             'format': 'dd/mm/yyyy',
             'startDate': getStartDate(),
             'endDate': getEndDate(),
             'language': lang,
             'thaiyear': th,
             'autoclose': true
         });
     $('#datetimepicker2').datepicker({
             'format': 'dd/mm/yyyy',
             'startDate': start,
             'endDate': end,
             'language': lang,
             'thaiyear': th,
             'autoclose': true
         });

}
select_month_issue();

$( "#select_quarter_chk" ).change(function() {
  select_month_issue();
});
function set_date_select(){
  $('#stopDate').prop('disabled', false);
  // select_month_issue();
}

$(".dropdown-menu li" ).click(function() {
  console.log('8888');
  $('#chart').html('');
});

function getStartDate() {
  var chk_radio = $('input[name=year_set_1]:checked', '#modal_filter_issue').val();
  var year_start = $('.year_start').val();
  var year_stop = $('.year_stop').val();
  var select_quarter = $('#select_quarter_chk').val();
    if(chk_radio == "1"){
      var set_year = $('#issue_year1').val();
      var set_month = $('#month_issue_1').val();
    }else {
      var set_year = $('#issue_year2').val();
      var set_month = $('#month_issue_2').val();
    }

if(select_quarter == ""){
  if(set_month == ""){
    set_month = "01";
  }
}else if (select_quarter == "1") {
  if(set_month == ""){
    set_month = "01";
  }
}else if (select_quarter == "2") {
  if(set_month == ""){
    set_month = "04";
  }
}else if (select_quarter == "3") {
  if(set_month == ""){
    set_month = "07";
  }
}else if (select_quarter == "4") {
  if(set_month == ""){
    set_month = "10";
  }
}


if(set_year == ""){
  set_year = year_start;
}
    d= "01-01-"+set_year;

    return d;
}

function getEndDate() {
  var chk_radio = $('input[name=year_set_1]:checked', '#modal_filter_issue').val();
  var year_start = $('.year_start').val();
  var year_stop = $('.year_stop').val();
  var select_quarter = $('#select_quarter_chk').val();
    if(chk_radio == "1"){
      var set_year = $('#issue_year1').val();
      var set_month = $('#month_issue_1').val();
    }else {
      var set_year = $('#issue_year2').val();
      var set_month = $('#month_issue_2').val();
    }
    if(set_year == ""){
      set_year = year_stop;
    }

    if(select_quarter == ""){
      if(set_month == ""){
        set_month = "12";
      }
    }else if (select_quarter == "1") {
      if(set_month == ""){
        set_month = "03";
      }
    }else if (select_quarter == "2") {
      if(set_month == ""){
        set_month = "06";
      }
    }else if (select_quarter == "3") {
      if(set_month == ""){
        set_month = "09";
      }
    }else if (select_quarter == "4") {
      if(set_month == ""){
        set_month = "12";
      }
    }

    var set_date = new Date(new Date(set_year, parseInt(set_month),1)-1).getDate();


    return "31-12-"+set_year;
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
</style>
