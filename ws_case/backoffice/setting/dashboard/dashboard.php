<?php
$today = date("m");
$toyear = date("Y");
?>
<div class="">
  <div class="title_color" style="margin-bottom: 10px;">
    <i class="ditp-icon icon-ico-ditp-01"></i>
    Dashboard
  </div>
</div>
<!-- <div class=""> -->
<div class="col-md-8">
  <div class="">

    <div class="bg_db">
      <div class="row   db_lbl_title">
        <div class="col-md-3 no-margin-padding pd_10">
          <lable class="title_case">New Case</lable>
        </div>
        <div class="col-md-9 box_s1 box_db none_select" style="text-align: right;    position: relative;     margin-top: 12px;">
          <select name="month_case" id="month_case" class="selectpicker_v" data-width="150px" onchange="ch_val();">
            <option value=" ">เลือกเดือน</option>
            <?php
            $month = array("มกราคม ","กุมภาพันธ์ ","มีนาคม ","เมษายน ","พฤษภาคม ","มิถุนายน ","กรกฎาคม ","สิงหาคม ","กันยายน ","ตุลาคม ","พฤศจิกายน ","ธันวาคม ");
            for($i=0; $i<sizeof($month); $i++) {
              $val = $i+1;
              ?>

              <option value="<?php echo $val ?>" <?php if($today==$val){ echo 'selected' ;} ?>  ><?PHP echo $month[$i]?></option>
              <?php }?>
            </select>
            <select name="year_case" id="year_case" class="selectpicker_v" data-width="150px" onchange="ch_val() && data_case_filter();">
              <option value="" selected="">เลือกปี</option>
              <?php
              $date_year = date("Y");
              for($year = $date_year-5; $year<=$date_year+1; $year++){
                $year_sum = $year+543;
                ?>
                <option value="<?=$year_sum;?>" <?php if($toyear==$year){ echo 'selected' ;} ?> ><?=$year_sum;?></option>
                <?php  } ?>
              </select>
              <div class="by_case" style="display: inline-block;">
                <?php
                  $y_set = $date_year + 543 ;
                  echo $month[ $today-1]."ปี ".$y_set;
                ?>
              </div>
              <i class="fa fa-ellipsis-v adv_se" aria-hidden="true" onclick="filter_case(1);" style="top: -5px;position: relative;"></i>
              <div style="padding: 15px; width: 630px; " class="show_search" id="show_search">

                <div class="box_right">
                  <button type="button" name="btn_search" class="fa fa-ellipsis-v btn_adv" data-toggle="modal" data-target="#importinventory" onclick="hiddenDiv(1)"></button>
                </div>
                <div class="box_filter">
                  <div class="box_filter_pd">
                    <div class="box_gp_bd txt_box_bd">
                      <div class="row pg_db_5">
                        <div class="col-md-3">
                          <label for="message-text" class="control-label lbl_fix" style="">การแสดงผล</label>
                        </div>
                        <div class="col-md-4">
                          <div class="radio radio-danger">
                            <input type="radio" value="1" name="display_case" id="display_id_case_1" onclick="chk_radio_issue_year();" checked>
                            <label class="txt_report" for="display_id_case_1">พ.ศ.</label>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="radio radio-danger ">
                            <input type="radio" value="2" name="display_case" id="display_id_case_2" onclick="chk_radio_issue_year();">
                            <label class="txt_report" for="display_id_case_2">ค.ศ.</label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="box_filter_pd">
                    <div class="box_gp_bd">
                      <div class="row pg_db_5">
                        <div class="col-md-3">
                          <label for="message-text" class="control-label lbl_fix">ประเภทปี</label>
                        </div>
                        <div class="col-md-4">
                          <div class="radio radio-danger">
                            <input type="radio" value="1" name="year_type_case" id="year_set2_1" onclick="chk_radio_issue();" checked>
                            <label class="txt_report" for="year_set2_1">ปีปฏิทิน</label>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="radio radio-danger ">
                            <input type="radio" value="2" name="year_type_case" id="year_set2_2" onclick="chk_radio_issue();">
                            <label class="txt_report" for="year_set2_2">ปีงบประมาณ</label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="box_filter_pd">
                    <div class="box_gp_bd">
                      <div class="row form-group gp_year">
                        <div class="col-md-3">
                          <label for="message-text" class="control-label">ประเภทปี</label>
                        </div>
                        <div class="col-md-4">
                          <label for="message-text" class="control-label">ช่วงเวลา</label>
                        </div>
                        <div class="col-md-5">
                          <div class="div_be issue_year1">
                            <select class="selectpicker form-control" name="issue_year_th" id="issue_year1" onchange="select_month_issue();">
                              <option value="">- เลือกปี -</option>
                              <?php
                              $date_year = date("Y");
                              for($year = $date_year-5; $year<=$date_year+1; $year++){
                                $year_sum = $year+543;
                                ?>
                                <option value="<?=$year;?>"><?=$year_sum;?></option>
                                <?php  } ?>
                              </select>
                            </div>
                            <div class="div_ad issue_year2" style="display:none">
                              <select class="selectpicker form-control" name="issue_year_en" id="issue_year2" onchange="select_month_issue();">
                                <option value="">- เลือกปี -</option>
                                <?php
                                $date_year = date("Y");
                                for($year = $date_year-5; $year<=$date_year+1; $year++){
                                  ?>
                                  <option value="<?=$year;?>"><?=$year;?></option>
                                  <?php  } ?>
                                </select>
                              </div>
                              <input type="hidden" class="year_start" value="<?=$date_year-5;?>">
                              <input type="hidden" class="year_stop" value="<?=$date_year+1;?>">
                            </div>
                          </div>
                          <div class="row form-group box_Quarterly">
                            <div class="col-md-3">

                            </div>
                            <div class="col-md-4">
                              <label for="message-text" class="control-label">รายไตรมาส</label>
                            </div>
                            <div class="col-md-5">
                              <select class="selectpicker form-control" name="quarter" id="select_quarter_chk" onchange="select_quarter(this.value);">
                                <option value="">- เลือกไตรมาส -</option>
                                <option value="1">ไตรมาส ที่ 1</option>
                                <option value="2">ไตรมาส ที่ 2</option>
                                <option value="3">ไตรมาส ที่ 3</option>
                                <option value="4">ไตรมาส ที่ 4</option>
                              </select>
                            </div>
                          </div>
                          <div class="row form-group gp_month box_monthly">
                            <div class="col-md-3">
                            </div>
                            <div class="col-md-4">
                              <label for="message-text" class="control-label">รายเดือน</label>
                            </div>
                            <div class="col-md-5">
                              <div class="months_issue1">
                                <select class="selectpicker form-control" name="month_issue_th" id="month_issue_1" onchange="select_month_issue();">
                                  <option value="">- เลือกเดือน -</option>
                                  <?php
                                  $months = array(
                                    "01"=>'มกราคม',
                                    "02"=>'กุมภาพันธ์',
                                    "03"=>'มีนาคม',
                                    "04"=>'เมษายน',
                                    "05"=>'พฤษภาคม',
                                    "06"=>'มิถุนายน',
                                    "07"=>'กรกฎาคม ',
                                    "08"=>'สิงหาคม',
                                    "09"=>'กันยายน',
                                    "10"=>'ตุลาคม',
                                    "11"=>'พฤศจิกายน',
                                    "12"=>'ธันวาคม',
                                  );
                                  foreach ($months as $key => $value) {
                                    ?>
                                    <option value="<?=$key?>"><?=$value?></option>
                                    <?php } ?>
                                  </select>
                                </div>

                                <div class="months_issue2">
                                  <select class="selectpicker form-control" name="month_issue_en" id="month_issue_2" onchange="select_month_issue();">
                                    <option value="">- เลือกเดือน -</option>
                                    <?php
                                    $months = array(
                                      "01"=>'January',
                                      "02"=>'February',
                                      "03"=>'March',
                                      "04"=>'April',
                                      "05"=>'May',
                                      "06"=>'June',
                                      "07"=>'July ',
                                      "08"=>'August',
                                      "09"=>'September',
                                      "10"=>'October',
                                      "11"=>'November',
                                      "12"=>'December',
                                    );
                                    foreach ($months as $key => $value) {
                                      ?>
                                      <option value="<?=$key?>"><?=$value?></option>
                                      <?php } ?>
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="box_filter_pd box_costom">
                            <div class="box_gp_bd">
                              <div class="row form-group gp_st_date">
                                <div class="col-md-3">
                                  <label for="message-text" class="control-label">กำหนดเอง</label>
                                </div>
                                <div class="col-md-4">
                                  <label for="message-text" class="control-label">Start Date :</label>
                                </div>
                                <div class="col-md-5">
                                  <div class="input-group st_date">
                                    <div class="input-group date" id="datetimepicker_case_1" onchange="set_date_select()">
                                      <!-- <input type="text" class="form-control input-mask" data-inputmask="'mask':'99/99/9999'" name="date_start" id="startDate" /> -->
                                      <input type="text" class="form-control input-mask" data-inputmask="'mask':'99/99/9999'" name="date_start" id="startDate" />

                                      <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar color_green"></span>
                                      </span>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="row gp_sp_date">
                                <div class="col-md-3">

                                </div>
                                <div class="col-md-4">
                                  <label for="message-text" class="control-label">Stop Date :</label>
                                </div>
                                <div class="col-md-5">
                                  <div class="input-group sp_date">
                                    <div class="input-group date" id="datetimepicker_case_2">
                                      <input type="text" class="form-control input-mask" data-inputmask="'mask':'99/99/9999'" name="date_stop" id="stopDate" />
                                      <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar color_green"></span>
                                      </span>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row box_btn_db" style="">
                            <button type="submit" class="btn btn_submit sb_db" name="submit_case">ตกลง</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row_st">
                    <div class="data_case_filter">

                    </div>


                    <div class="tb_bd" style="">
                      <table data-toggle="table" class="table-caseCh-list_case"
                      data-sort-name="id"
                      data-sort-status="view"
                      data-sort-order="DESC"
                      data-side-pagination="server"
                      data-pagination="true"
                      data-page-size="5"
                      data-url="dashboard/method.php?method=getchannel"
                      data-query-params="searchQueryParams_case"
                      data-method="post">
                      <thead class="th_non">
                        <tr>
                          <th data-field="name" data-sortable="true">
                            ชื่อ
                          </th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>


            <!-- <div class="col-md-8 box_all_activ"> -->
            <div class="">
              <div class="bg_db pd_all_mar">
                <div class="row db_lbl_title">
                  <div class="col-md-3 no-margin-padding pd_10 filter_activity">
                    <select name="filter_activity" id="filter_activity" class="selectpicker" data-width="200" onchange="ch_activity();">
                      <option value="">All Activity</option>
                      <option value="00">สร้างเรื่องร้องเรียน</option>
                      <option value="01">แก้ไขเรื่องร้องเรียน</option>
                      <option value="10">Assign</option>
                      <option value="11">Re-Assign</option>
                      <option value="12">สร้างกระบวนการ</option>
                      <option value="21">ปิดกระบวนการ</option>
                      <option value="31">ยุติข้อร้องเรียน</option>
                    </select>
                  </div>
                  <div class="col-md-9 box_s1 box_db none_select" style="text-align: right;    position: relative;     margin-top: 16px;">
                    <select name="month_activity" id="month_activity" class="selectpicker_v" data-width="150px" onchange="ch_activity();">
                      <option value="">เลือกเดือน</option>
                      <?php $month = array("มกราคม ","กุมภาพันธ์ ","มีนาคม ","เมษายน ","พฤษภาคม ","มิถุนายน ","กรกฎาคม ","สิงหาคม ","กันยายน ","ตุลาคม ","พฤศจิกายน ","ธันวาคม ");
                      for($i=0; $i<sizeof($month); $i++) {
                        $val = $i+1;
                        ?>
                        <option value="<?php echo $val;?>" <?php if($today==$val){ echo 'selected' ;} ?> > <?PHP echo $month[$i]?></option>
                        <?php }?>
                      </select>
                      <select name="year_activity" id="year_activity" class="selectpicker_v" data-width="150px">
                        <option value="" selected="">เลือกปี</option>
                        <?php
                        $date_year = date("Y");
                        for($year = $date_year-5; $year<=$date_year+1; $year++){
                          $year_sum = $year+543;
                          ?>
                          <option value="<?=$year;?>" <?php if($toyear==$year){ echo 'selected' ;} ?>><?=$year_sum;?></option>
                          <?php  } ?>
                        </select>
                        <div class="by_activity" style="display: inline-block;">
                          <?php
                                  $y_set = $date_year + 543 ;
                                echo $month[ $today-1]."ปี ".$y_set;  ?>
                        </div>
                        <i class="fa fa-ellipsis-v adv_se" aria-hidden="true" onclick="filter_case(3);" style="position: relative;top: -5px;"></i>
                        <div style="padding: 15px; width: 630px; " class="show_allativity" id="show_search_allactivity">
                          <div class="box_right">
                            <button type="button" name="btn_search" class="fa fa-ellipsis-v btn_adv" data-toggle="modal" data-target="#importinventory" onclick="hiddenDiv(3)"></button>
                          </div>
                          <div class="box_filter">
                            <div class="box_filter_pd">
                              <div class="box_gp_bd txt_box_bd">
                                <div class="row pg_db_5">
                                  <div class="col-md-3">
                                    <label for="message-text" class="control-label lbl_fix" style="">การแสดงผล</label>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="radio radio-danger">
                                      <input type="radio" value="1" name="display_activity" id="display_id_activity_1" onclick="chk_radio_activity_year();" checked>
                                      <label class="txt_report" for="display_id_activity_1">พ.ศ.</label>
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="radio radio-danger ">
                                      <input type="radio" value="2" name="display_activity" id="display_id_activity_2" onclick="chk_radio_activity_year();">
                                      <label class="txt_report" for="display_id_activity_2">ค.ศ.</label>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="box_filter_pd">
                              <div class="box_gp_bd">
                                <div class="row pg_db_5">
                                  <div class="col-md-3">
                                    <label for="message-text" class="control-label lbl_fix">ประเภทปี</label>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="radio radio-danger">
                                      <input type="radio" value="1" name="year_type_activity" id="year_set_activity2_1" onclick="chk_radio_activity_type();" checked>
                                      <label class="txt_report" for="year_set_activity2_1">ปีปฏิทิน</label>
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="radio radio-danger ">
                                      <input type="radio" value="2" name="year_type_activity" id="year_set_activity2_2" onclick="chk_radio_activity_type();">
                                      <label class="txt_report" for="year_set_activity2_2">ปีงบประมาณ</label>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="box_filter_pd">
                              <div class="box_gp_bd">
                                <div class="row form-group gp_year">
                                  <div class="col-md-3">
                                    <label for="message-text" class="control-label">ประเภทปี</label>
                                  </div>
                                  <div class="col-md-4">
                                    <label for="message-text" class="control-label">ช่วงเวลา</label>
                                  </div>
                                  <div class="col-md-5">
                                    <div class="div_be issue_year_activity1">
                                      <select class="selectpicker form-control" name="issue_year_th_activit" id="issue_year_activity1" onchange="select_month_activity();">
                                        <option value="">- เลือกปี -</option>
                                        <?php
                                        $date_year = date("Y");
                                        for($year = $date_year-5; $year<=$date_year+1; $year++){
                                          $year_sum = $year+543;
                                          ?>
                                          <option value="<?=$year;?>"><?=$year_sum;?></option>
                                          <?php  } ?>
                                        </select>
                                      </div>
                                      <div class="div_ad issue_year_activity2" style="display:none">
                                        <select class="selectpicker form-control" name="issue_year_en_activity" id="issue_year_activity2" onchange="select_month_activity();">
                                          <option value="">- เลือกปี -</option>
                                          <?php
                                          $date_year = date("Y");
                                          for($year = $date_year-5; $year<=$date_year+1; $year++){
                                            ?>
                                            <option value="<?=$year;?>"><?=$year;?></option>
                                            <?php  } ?>
                                          </select>
                                        </div>
                                        <input type="hidden" class="year_start_cat" value="<?=$date_year-5;?>">
                                        <input type="hidden" class="year_stop_cat" value="<?=$date_year+1;?>">
                                      </div>
                                    </div>
                                    <div class="row form-group box_Quarterly box_activity_Quarterly">
                                      <div class="col-md-3">

                                      </div>
                                      <div class="col-md-4">
                                        <label for="message-text" class="control-label">รายไตรมาส</label>
                                      </div>
                                      <div class="col-md-5">
                                        <select class="selectpicker form-control" name="quarter" id="select_quarter_chk_activity" onchange="select_quarter_activity(this.value);">
                                          <option value="">- เลือกไตรมาส -</option>
                                          <option value="1">ไตรมาส ที่ 1</option>
                                          <option value="2">ไตรมาส ที่ 2</option>
                                          <option value="3">ไตรมาส ที่ 3</option>
                                          <option value="4">ไตรมาส ที่ 4</option>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="row form-group gp_month box_monthly box_box_activity_Quarterly_monthly">
                                      <div class="col-md-3">
                                      </div>
                                      <div class="col-md-4">
                                        <label for="message-text" class="control-label">รายเดือน</label>
                                      </div>
                                      <div class="col-md-5">
                                        <div class="months_cost_activity1">
                                          <select class="selectpicker form-control" name="month_issue_th" id="month_issue_activity1" onchange="select_month_activity();">
                                            <option value="">- เลือกเดือน -</option>
                                            <?php
                                            $months = array(
                                              "01"=>'มกราคม',
                                              "02"=>'กุมภาพันธ์',
                                              "03"=>'มีนาคม',
                                              "04"=>'เมษายน',
                                              "05"=>'พฤษภาคม',
                                              "06"=>'มิถุนายน',
                                              "07"=>'กรกฎาคม ',
                                              "08"=>'สิงหาคม',
                                              "09"=>'กันยายน',
                                              "10"=>'ตุลาคม',
                                              "11"=>'พฤศจิกายน',
                                              "12"=>'ธันวาคม',
                                            );
                                            foreach ($months as $key => $value) {
                                              ?>
                                              <option value="<?=$key?>"><?=$value?></option>
                                              <?php } ?>
                                            </select>
                                          </div>

                                          <div class="months_cost_activity2">
                                            <select class="selectpicker form-control" name="month_issue_en" id="month_issue_activity2" onchange="select_month_activity();">
                                              <option value="">- เลือกเดือน -</option>
                                              <?php
                                              $months = array(
                                                "01"=>'January',
                                                "02"=>'February',
                                                "03"=>'March',
                                                "04"=>'April',
                                                "05"=>'May',
                                                "06"=>'June',
                                                "07"=>'July ',
                                                "08"=>'August',
                                                "09"=>'September',
                                                "10"=>'October',
                                                "11"=>'November',
                                                "12"=>'December',
                                              );
                                              foreach ($months as $key => $value) {
                                                ?>
                                                <option value="<?=$key?>"><?=$value?></option>
                                                <?php } ?>
                                              </select>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>

                                    <div class="box_filter_pd box_activity_costom">
                                      <div class="box_gp_bd">
                                        <div class="row form-group gp_st_date">
                                          <div class="col-md-3">
                                            <label for="message-text" class="control-label">กำหนดเอง</label>
                                          </div>
                                          <div class="col-md-4">
                                            <label for="message-text" class="control-label">Start Date :</label>
                                          </div>
                                          <div class="col-md-5">
                                            <div class="input-group st_date">
                                              <div class="input-group date" id="datetimepicker_activity_1" onchange="set_date_activity_select()">
                                                <input type="text" class="form-control input-mask" data-inputmask="'mask':'99/99/9999'" name="date_start" id="startDate_activity" />
                                                <span class="input-group-addon">
                                                  <span class="glyphicon glyphicon-calendar color_green"></span>
                                                </span>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="row gp_sp_date">
                                          <div class="col-md-3">

                                          </div>
                                          <div class="col-md-4">
                                            <label for="message-text" class="control-label">Stop Date :</label>
                                          </div>
                                          <div class="col-md-5">
                                            <div class="input-group sp_date">
                                              <div class="input-group date" id="datetimepicker_activity_2">
                                                <input type="text" class="form-control input-mask" data-inputmask="'mask':'99/99/9999'" name="date_stop" id="stopDate_activity" />
                                                <span class="input-group-addon">
                                                  <span class="glyphicon glyphicon-calendar color_green"></span>
                                                </span>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="row box_btn_db">
                                      <button type="submit" class="btn btn_submit sb_db"  name="submit_activity">ตกลง</button>
                                    </div>
                                  </div>
                                </div>
                      </div>
                    </div>
                    <div class="tb_bd" style="">
                      <table data-toggle="table" class="table-caseCh-list"
                      data-sort-name="id"
                      data-sort-status="view"
                      data-sort-order="DESC"
                      data-side-pagination="server"
                      data-pagination="true"
                      data-page-size="5"
                      data-url="dashboard/method.php?method=getlogcase"
                      data-query-params="searchQueryParams_activity"
                      data-method="post">
                      <thead class="th_non">
                        <tr>
                          <th data-field="name" data-sortable="true">
                            ชื่อ
                          </th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="bg_db">
                <div class="db_lbl_title"  style="padding-top:10px">
                  <lable class="title_case">Category</lable>
                  <div class="float_right">
                    <lable class="by_year">
                      By Fiacal Year <?=$y_set; ?>
                    </lable>
                    <i class="fa fa-ellipsis-v adv_se" aria-hidden="true" onclick="filter_case(2);" style="    top: -2px;position: relative;"></i>
                    <div style="padding: 15px; width: 630px; " class="show_cat" id="show_search_cat">
                      <div class="box_right">
                        <button type="button" name="btn_search" class="fa fa-ellipsis-v btn_adv" data-toggle="modal" data-target="#importinventory" onclick="hiddenDiv(2)"></button>
                      </div>
                      <div class="box_filter">
                        <div class="box_filter_pd">
                          <div class="box_gp_bd txt_box_bd">
                            <div class="row pg_db_5">
                              <div class="col-md-3">
                                <label for="message-text" class="control-label lbl_fix" style="">การแสดงผล</label>
                              </div>
                              <div class="col-md-4">
                                <div class="radio radio-danger">
                                  <input type="radio" value="1" name="display_cat" id="display_id_cat_1" onclick="chk_radio_cat_year();" checked>
                                  <label class="txt_report" for="display_id_cat_1">พ.ศ.</label>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="radio radio-danger ">
                                  <input type="radio" value="2" name="display_cat" id="display_id_cat_2" onclick="chk_radio_cat_year();">
                                  <label class="txt_report" for="display_id_cat_2">ค.ศ.</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="box_filter_pd">
                          <div class="box_gp_bd">
                            <div class="row pg_db_5">
                              <div class="col-md-3">
                                <label for="message-text" class="control-label lbl_fix">ประเภทปี</label>
                              </div>
                              <div class="col-md-4">
                                <div class="radio radio-danger">
                                  <input type="radio" value="1" name="year_type_cat" id="year_set_cat2_1" onclick="chk_radio_cat_type();" checked>
                                  <label class="txt_report" for="year_set_cat2_1">ปีปฏิทิน</label>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="radio radio-danger ">
                                  <input type="radio" value="2" name="year_type_cat" id="year_set_cat2_2" onclick="chk_radio_cat_type();">
                                  <label class="txt_report" for="year_set_cat2_2">ปีงบประมาณ</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="box_filter_pd">
                          <div class="box_gp_bd">
                            <div class="row form-group gp_year">
                              <div class="col-md-3">
                                <label for="message-text" class="control-label">ประเภทปี</label>
                              </div>
                              <div class="col-md-4">
                                <label for="message-text" class="control-label">ช่วงเวลา</label>
                              </div>
                              <div class="col-md-5">
                                <div class="div_be issue_year_cat1">
                                  <select class="selectpicker form-control" name="issue_year_th_cat" id="issue_year_cat1" onchange="select_month_cat();">
                                    <option value="">- เลือกปี -</option>
                                    <?php
                                    $date_year = date("Y");
                                    for($year = $date_year-5; $year<=$date_year+1; $year++){
                                      $year_sum = $year+543;
                                      ?>
                                      <option value="<?=$year;?>"><?=$year_sum;?></option>
                                      <?php  } ?>
                                    </select>
                                  </div>
                                  <div class="div_ad issue_year_cat2" style="display:none">
                                    <select class="selectpicker form-control" name="issue_year_en" id="issue_year_cat2" onchange="select_month_cat();">
                                      <option value="">- เลือกปี -</option>
                                      <?php
                                      $date_year = date("Y");
                                      for($year = $date_year-5; $year<=$date_year+1; $year++){
                                        ?>
                                        <option value="<?=$year;?>"><?=$year;?></option>
                                        <?php  } ?>
                                      </select>
                                    </div>
                                    <input type="hidden" class="year_start_cat" value="<?=$date_year-5;?>">
                                    <input type="hidden" class="year_stop_cat" value="<?=$date_year+1;?>">
                                  </div>
                                </div>
                                <div class="row form-group box_Quarterly box_case_Quarterly">
                                  <div class="col-md-3">

                                  </div>
                                  <div class="col-md-4">
                                    <label for="message-text" class="control-label">รายไตรมาส</label>
                                  </div>
                                  <div class="col-md-5">
                                    <select class="selectpicker form-control" name="quarter" id="select_quarter_chk_cat" onchange="select_quarter_cat(this.value);">
                                      <option value="">- เลือกไตรมาส -</option>
                                      <option value="1">ไตรมาส ที่ 1</option>
                                      <option value="2">ไตรมาส ที่ 2</option>
                                      <option value="3">ไตรมาส ที่ 3</option>
                                      <option value="4">ไตรมาส ที่ 4</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="row form-group gp_month box_monthly box_cat_monthly">
                                  <div class="col-md-3">
                                  </div>
                                  <div class="col-md-4">
                                    <label for="message-text" class="control-label">รายเดือน</label>
                                  </div>
                                  <div class="col-md-5">
                                    <div class="months_cost_cat1">
                                      <select class="selectpicker form-control" name="month_issue_th" id="month_issue_cat1" onchange="select_month_cat();">
                                        <option value="">- เลือกเดือน -</option>
                                        <?php
                                        $months = array(
                                          "01"=>'มกราคม',
                                          "02"=>'กุมภาพันธ์',
                                          "03"=>'มีนาคม',
                                          "04"=>'เมษายน',
                                          "05"=>'พฤษภาคม',
                                          "06"=>'มิถุนายน',
                                          "07"=>'กรกฎาคม ',
                                          "08"=>'สิงหาคม',
                                          "09"=>'กันยายน',
                                          "10"=>'ตุลาคม',
                                          "11"=>'พฤศจิกายน',
                                          "12"=>'ธันวาคม',
                                        );
                                        foreach ($months as $key => $value) {
                                          ?>
                                          <option value="<?=$key?>"><?=$value?></option>
                                          <?php } ?>
                                        </select>
                                      </div>

                                      <div class="months_cost_cat2">
                                        <select class="selectpicker form-control" name="month_issue_en" id="month_issue_cat2" onchange="select_month_cat();">
                                          <option value="">- เลือกเดือน -</option>
                                          <?php
                                          $months = array(
                                            "01"=>'January',
                                            "02"=>'February',
                                            "03"=>'March',
                                            "04"=>'April',
                                            "05"=>'May',
                                            "06"=>'June',
                                            "07"=>'July ',
                                            "08"=>'August',
                                            "09"=>'September',
                                            "10"=>'October',
                                            "11"=>'November',
                                            "12"=>'December',
                                          );
                                          foreach ($months as $key => $value) {
                                            ?>
                                            <option value="<?=$key?>"><?=$value?></option>
                                            <?php } ?>
                                          </select>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>

                                <div class="box_filter_pd box_cat_costom">
                                  <div class="box_gp_bd">
                                    <div class="row form-group gp_st_date">
                                      <div class="col-md-3">
                                        <label for="message-text" class="control-label">กำหนดเอง</label>
                                      </div>
                                      <div class="col-md-4">
                                        <label for="message-text" class="control-label">Start Date :</label>
                                      </div>
                                      <div class="col-md-5">
                                        <div class="input-group st_date">
                                          <div class="input-group date" id="datetimepicker_cat_1" onchange="set_date_cat_select()">
                                            <input type="text" class="form-control input-mask" data-inputmask="'mask':'99/99/9999'" name="date_start" id="startDate_cat" />
                                            <span class="input-group-addon">
                                              <span class="glyphicon glyphicon-calendar color_green"></span>
                                            </span>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="row gp_sp_date">
                                      <div class="col-md-3">

                                      </div>
                                      <div class="col-md-4">
                                        <label for="message-text" class="control-label">Stop Date :</label>
                                      </div>
                                      <div class="col-md-5">
                                        <div class="input-group sp_date">
                                          <div class="input-group date" id="datetimepicker_cat_2">
                                            <input type="text" class="form-control input-mask" data-inputmask="'mask':'99/99/9999'" name="date_stop" id="stopDate_cat" />
                                            <span class="input-group-addon">
                                              <span class="glyphicon glyphicon-calendar color_green"></span>
                                            </span>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="row box_btn_db">
                                  <button type="submit" class="btn btn_submit sb_db" onclick="search_cat();">ตกลง</button>
                                </div>
                              </div>
                            </div>

</div>
</div>
<!-- Category -->
<div class="data_category">
</div>
</div>
</div>



<div class="col-md-12 box_all_kpi">
  <div class="bg_db">
    <div class="row db_lbl_title">
      <div class="col-md-3 no-margin-padding pd_10 filter_activity">
        <lable class="title_case">KPI</lable>

      </div>
      <div class="col-md-9 box_s1 box_db none_select" style="text-align: right;position: relative;margin-top: 12px;">
        <select name="month_kpi" id="month_kpi" class="selectpicker_v" data-width="150px" onchange="ch_kpi();">
          <option value=" ">เลือกเดือน</option>
          <?php $month = array("มกราคม ","กุมภาพันธ์ ","มีนาคม ","เมษายน ","พฤษภาคม ","มิถุนายน ","กรกฎาคม ","สิงหาคม ","กันยายน ","ตุลาคม ","พฤศจิกายน ","ธันวาคม ");
          for($i=0; $i<sizeof($month); $i++) {   $val = $i+1; ?>
            <option value="<?php echo $i+1;?>" <?php if($today==$val){ echo 'selected' ;} ?>  > <?PHP echo $month[$i]?></option>
            <?php }?>
          </select>
          <select name="year_kpi" id="year_kpi" class="selectpicker_v" data-width="150px" onchange="ch_kpi();">
            <option value="" selected="">เลือกปี</option>
            <?php
            $date_year = date("Y");
            for($year = $date_year-5; $year<=$date_year+1; $year++){
              $year_sum = $year+543;
              ?>
              <option value="<?=$year;?>"      <?php if($toyear==$year){ echo 'selected' ;} ?>><?=$year_sum;?></option>
              <?php  } ?>
            </select>
            <div class="by_kpi" style="display: inline-block;">
              <?php
                $y_set = $date_year + 543 ;
                echo $month[ $today-1]."ปี ".$y_set;
              ?>
            </div>
            <i class="fa fa-ellipsis-v adv_se" aria-hidden="true" onclick="filter_case(4);" style="top: -5px;position: relative;"></i>
            <div style="padding: 15px; width: 630px; " class="show_kpi" id="show_search_kpi">
              <div class="box_right">
                <button type="button" name="btn_search" class="fa fa-ellipsis-v btn_adv" data-toggle="modal" data-target="#importinventory" onclick="hiddenDiv(4)"></button>
              </div>
              <div class="box_filter">
                <div class="box_filter_pd">
                  <div class="box_gp_bd txt_box_bd">
                    <div class="row pg_db_5">
                      <div class="col-md-3">
                        <label for="message-text" class="control-label lbl_fix" style="">การแสดงผล</label>
                      </div>
                      <div class="col-md-4">
                        <div class="radio radio-danger">
                          <input type="radio" value="1" name="display_kpi" id="display_id_kpi_1" onclick="chk_radio_kpi_year();" checked>
                          <label class="txt_report" for="display_id_kpi_1">พ.ศ.</label>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="radio radio-danger ">
                          <input type="radio" value="2" name="display_kpi" id="display_id_kpi_2" onclick="chk_radio_kpi_year();">
                          <label class="txt_report" for="display_id_kpi_2">ค.ศ.</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="box_filter_pd">
                  <div class="box_gp_bd">
                    <div class="row pg_db_5">
                      <div class="col-md-3">
                        <label for="message-text" class="control-label lbl_fix">ประเภทปี</label>
                      </div>
                      <div class="col-md-4">
                        <div class="radio radio-danger">
                          <input type="radio" value="1" name="year_type_kpi" id="year_set_kpi2_1" onclick="chk_radio_kpi_type();" checked>
                          <label class="txt_report" for="year_set_kpi2_1">ปีปฏิทิน</label>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="radio radio-danger ">
                          <input type="radio" value="2" name="year_type_kpi" id="year_set_kpi2_2" onclick="chk_radio_kpi_type();">
                          <label class="txt_report" for="year_set_kpi2_2">ปีงบประมาณ</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="box_filter_pd">
                  <div class="box_gp_bd">
                    <div class="row form-group gp_year">
                      <div class="col-md-3">
                        <label for="message-text" class="control-label">ประเภทปี</label>
                      </div>
                      <div class="col-md-4">
                        <label for="message-text" class="control-label">ช่วงเวลา</label>
                      </div>
                      <div class="col-md-5">
                        <div class="div_be issue_year_kpi1">
                          <select class="selectpicker form-control" name="issue_year_th_kpi" id="issue_year_kpi1" onchange="select_month_kpi();">
                            <option value="">- เลือกปี -</option>
                            <?php
                            $date_year = date("Y");
                            for($year = $date_year-5; $year<=$date_year+1; $year++){
                              $year_sum = $year+543;
                              ?>
                              <option value="<?=$year;?>"><?=$year_sum;?></option>
                              <?php  } ?>
                            </select>
                          </div>
                          <div class="div_ad issue_year_kpi2" style="display:none">
                            <select class="selectpicker form-control" name="issue_year_en" id="issue_year_kpi2" onchange="select_month_kpi();">
                              <option value="">- เลือกปี -</option>
                              <?php
                              $date_year = date("Y");
                              for($year = $date_year-5; $year<=$date_year+1; $year++){
                                ?>
                                <option value="<?=$year;?>"><?=$year;?></option>
                                <?php  } ?>
                              </select>
                            </div>
                            <input type="hidden" class="year_start_kpi" value="<?=$date_year-5;?>">
                            <input type="hidden" class="year_stop_kpi" value="<?=$date_year+1;?>">
                          </div>
                        </div>
                        <div class="row form-group box_Quarterly box_kpi_Quarterly">
                          <div class="col-md-3">

                          </div>
                          <div class="col-md-4">
                            <label for="message-text" class="control-label">รายไตรมาส</label>
                          </div>
                          <div class="col-md-5">
                            <select class="selectpicker form-control" name="quarter" id="select_quarter_chk_kpi" onchange="select_quarter_kpi(this.value);">
                              <option value="">- เลือกไตรมาส -</option>
                              <option value="1">ไตรมาส ที่ 1</option>
                              <option value="2">ไตรมาส ที่ 2</option>
                              <option value="3">ไตรมาส ที่ 3</option>
                              <option value="4">ไตรมาส ที่ 4</option>
                            </select>
                          </div>
                        </div>
                        <div class="row form-group gp_month box_monthly box_kpi_monthly">
                          <div class="col-md-3">
                          </div>
                          <div class="col-md-4">
                            <label for="message-text" class="control-label">รายเดือน</label>
                          </div>
                          <div class="col-md-5">
                            <div class="months_cost_kpi1">
                              <select class="selectpicker form-control" name="month_issue_th" id="month_issue_kpi1" onchange="select_month_kpi();">
                                <option value="">- เลือกเดือน -</option>
                                <?php
                                $months = array(
                                  "01"=>'มกราคม',
                                  "02"=>'กุมภาพันธ์',
                                  "03"=>'มีนาคม',
                                  "04"=>'เมษายน',
                                  "05"=>'พฤษภาคม',
                                  "06"=>'มิถุนายน',
                                  "07"=>'กรกฎาคม ',
                                  "08"=>'สิงหาคม',
                                  "09"=>'กันยายน',
                                  "10"=>'ตุลาคม',
                                  "11"=>'พฤศจิกายน',
                                  "12"=>'ธันวาคม',
                                );
                                foreach ($months as $key => $value) {
                                  ?>
                                  <option value="<?=$key?>"><?=$value?></option>
                                  <?php } ?>
                                </select>
                              </div>

                              <div class="months_cost_kpi2">
                                <select class="selectpicker form-control" name="month_issue_en" id="month_issue_kpi2" onchange="select_month_kpi();">
                                  <option value="">- เลือกเดือน -</option>
                                  <?php
                                  $months = array(
                                    "01"=>'January',
                                    "02"=>'February',
                                    "03"=>'March',
                                    "04"=>'April',
                                    "05"=>'May',
                                    "06"=>'June',
                                    "07"=>'July ',
                                    "08"=>'August',
                                    "09"=>'September',
                                    "10"=>'October',
                                    "11"=>'November',
                                    "12"=>'December',
                                  );
                                  foreach ($months as $key => $value) {
                                    ?>
                                    <option value="<?=$key?>"><?=$value?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="box_filter_pd box_kpi_costom">
                          <div class="box_gp_bd">
                            <div class="row form-group gp_st_date">
                              <div class="col-md-3">
                                <label for="message-text" class="control-label">กำหนดเอง</label>
                              </div>
                              <div class="col-md-4">
                                <label for="message-text" class="control-label">Start Date :</label>
                              </div>
                              <div class="col-md-5">
                                <div class="input-group st_date">
                                  <div class="input-group date" id="datetimepicker_kpi_1" onchange="set_date_kpi_select()">
                                    <input type="text" class="form-control input-mask" data-inputmask="'mask':'99/99/9999'" name="date_start" id="startDate_kpi" />
                                    <span class="input-group-addon">
                                      <span class="glyphicon glyphicon-calendar color_green"></span>
                                    </span>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="row gp_sp_date">
                              <div class="col-md-3">

                              </div>
                              <div class="col-md-4">
                                <label for="message-text" class="control-label">Stop Date :</label>
                              </div>
                              <div class="col-md-5">
                                <div class="input-group sp_date">
                                  <div class="input-group date" id="datetimepicker_kpi_2">
                                    <input type="text" class="form-control input-mask" data-inputmask="'mask':'99/99/9999'" name="date_stop" id="stopDate_kpi" />
                                    <span class="input-group-addon">
                                      <span class="glyphicon glyphicon-calendar color_green"></span>
                                    </span>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row box_btn_db">
                          <button type="submit" class="btn btn_submit sb_db" onclick="search_kpi();">ตกลง</button>
                        </div>
                      </div>
                    </div>

          </div>
        </div>
        <div class="box_color">

          <div class="in_line">
            <div class="bar_new">
            </div>
            New
          </div>
          <div class="in_line">
            <div class="bar_pending">
            </div>
            Pending
          </div>
          <div class="in_line">
            <div class="bar_overdue">
            </div>
            Overdue
          </div>
          <div class="in_line">
            <div class="bar_close">
            </div>
            Close
          </div>


        </div>
        <div class="row data_kpi">
        </div>
        </div>
      </div>
      <!-- </div> -->



      <!-- </div> -->
      <!-- <div style="padding: 15px; display: none;width: 630px; " class="show_search" id="show_search"> -->
      <input type="hidden" name="search_kpi" id="search_kpi" value="0">
      <input type="hidden" name="search_activity" id="search_activity" value="0">
      <input type="hidden" name="search_cat" id="search_cat" value="0">
      <input type="hidden" name="secrch_case" id="secrch_case" value="0">
      <input type="hidden" name="input_case" id="input_case" value="2">
      <input type="hidden" class="year_start" value="<?=$year_real-5;?>">
      <input type="hidden" class="year_stop" value="<?=$year_real+1;?>">
      <link rel="stylesheet" type="text/css" href="dashboard/css/dashboard.css">
      <link rel="stylesheet" type="text/css" href="setting/css/responsive.css">
      <link rel="stylesheet" type="text/css" href="setting/css/build.css">
        <input type="hidden" id="son_active" value="">
      <!-- <div class="box-message">
      <div class="btn-group">
      <button type="button" class="btn-profile btn-default dropdown-toggle"
      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"  onclick="Noti_massage();">

      <div class="noti_vi">  <i class="fa fa-ellipsis-v adv_se" aria-hidden="true"></i>
    </div>
  </button>
  <ul class="dropdown-menu menu-profile dropdown-menu-right none-padding box_noti" id="box_noti" >
  dcddvdvdv
</ul>
</div>
</div> -->
<!-- <link rel="stylesheet" href="dashboard/js/dashboard.js"> -->
<script src="dashboard/js/dashboard.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="assets/bootstrap-table/dist/bootstrap-table.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="assets/bootstrap-table/dist/bootstrap-table.min.js"></script>
<!-- Latest compiled and minified Locales -->
<script src="assets/bootstrap-table/dist/locale/bootstrap-table-th-TH.min.js"></script>

<link rel="stylesheet" href="setting/css/font-awesome.css">
<link rel="stylesheet" href="setting/css/font-awesome.min.css">


<link rel="stylesheet" href="report/lib/bootstrap-datepicker-1.6.4-dist/css/bootstrap-datepicker.min.css" />
<script src="report/lib/bootstrap-datepicker-custom/dist/js/bootstrap-datepicker-custom.js"></script>
<script src="report/lib/bootstrap-datepicker-custom/dist/locales/bootstrap-datepicker.th.min.js" charset="UTF-8"></script>

<script src="dashboard/js/functions.js"></script>
<script type="text/javascript" src="assets/widgets/input-mask/inputmask.js"></script>

<link rel="stylesheet" type="text/css" href="assets/widgets/progressbar/progressbar.css">
<script type="text/javascript" src="assets/widgets/progressbar/progressbar.js"></script>

<script>
function hiddenDiv(id) {

  if(id==1){
    $('#show_search').hide();
  }else if(id==2){
    $('#show_search_cat').hide();
  }else if(id==3){
    $('#show_search_allactivity').hide();
  }else if(id==4){
    $('#show_search_kpi').hide();
  }

}
function hiddenDiv_cat() {
  $('#show_search_cat').hide();
}

function filter_case(id) {
    if(id==1){
      $('#show_search').show();
    }else if(id==2){
      $('#show_search_cat').show();
    }else if(id==3){
      $('#show_search_allactivity').show();
    }else if(id==4){
      $('#show_search_kpi').show();
    }
}


$(document).ready(function() {

  $(".input-mask").inputmask();       //inputmask
  data_category();                    //data_category
  data_case_filter();                 //data_case_filter
  data_kpi();                    //data_category

  $('#show_search').hide();           // ค้นกา case
  $('#show_search_cat').hide();      // ค้นกา cat
  $('.months_cost_cat2').hide();
  $('#show_search_allactivity').hide();
  // $('.months_cost_activity2').hide();
  $('.months_cost_activity2').hide();
  $('#select_quarter_chk_activity').attr('disabled', true);
  $('#stopDate_activity').attr('disabled', true);
  $('#month_issue_activity1').attr('disabled', true);
  $('#show_search_kpi').hide();
  $('.months_cost_kpi2').hide();


  $('.selectpicker').selectpicker('refresh');


  $('.table-caseCh-list').on('load-success.bs.table', function (e) {
  });
  $("input[name='search_prod_type']").change(function() {
    /* Act on the event */
  });

  $("input[name='search_text']").keypress(function(e) {
    if(e.which == 13) {
      $('.table-caseCh-list').bootstrapTable('refresh');
    }

  });

  // by filter_activity
  $("select[name='filter_activity']").on('change', function() {
    $('.table-caseCh-list').bootstrapTable('refresh');
  });
  $("select[name='month_activity']").on('change', function() {
    $('.table-caseCh-list').bootstrapTable('refresh');
  });
  $("select[name='year_activity']").on('change', function() {
    $('.table-caseCh-list').bootstrapTable('refresh');
  });



  //case
  $("select[name='month_case']").on('change', function() {
    $('.table-caseCh-list_case').bootstrapTable('refresh');
  });
  // $(".waiting_case").on('click', function() {
  //   console.log(22);
  //   $('.table-caseCh-list_case').bootstrapTable('refresh');
  // });

  $("select[name='year_case']").on('change', function() {
    $('.table-caseCh-list_case').bootstrapTable('refresh');
  });


  $("button[name='submit_case']").on('click', function() {

    var display_case = $('input[name=display_case]:checked').val();
    if(display_case==1){
      var year =  $("select[name='issue_year_th']").val();
      var month_txt =  $("select[name='month_issue_th']").val();
    }else{
      var year =  $("select[name='issue_year_en']").val();
      var month_txt =  $("select[name='month_issue_en']").val();
    }
    var year_type_case = $('input[name=year_type_case]:checked').val();
    var date_start =  $("input[name='date_start']").val();
    var date_stop =  $("input[name='date_stop']").val();
    if(year_type_case == 1){
      if(date_start =='' && year ==''  ){
          alert('กรุณาเลือกช่วงเวลา หรือ กำหนดเอง Start Date ');
      }else if(date_start !=''){
        if(date_stop ==''){
            alert('กรุณาเลือกวันที่ Stop Date ');
        }else{
          console.log(2);
          $(".by_case").html("<span>วันที่ "+date_start+" - "+date_stop+"</span>");

          $('#secrch_case').val(1);
          data_case_filter();
          $('#show_search').hide();
          $('.table-caseCh-list_case').bootstrapTable('refresh');
        }
      }else{
        // console.log(month_txt);
        var select_quarter_chk =  $('#select_quarter_chk').val();
        if(display_case==1){
          var  thmonth = new Array (  "มกราคม","กุมภาพันธ์","มีนาคม", "เมษายน",
                                      "พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม",
                                      "กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
          year = parseInt(year) + 543;
          if(month_txt!=''){
            $(".by_case").html("<span>"+thmonth[month_txt-1]+" ปี "+year+" (ปีปฏิทิน)</span>");
          }else if(select_quarter_chk!=''){
            $(".by_case").html("<span>ไตรมาสที่ "+select_quarter_chk+" ปี "+year+" (ปีปฏิทิน)</span>");
          }else{
            $(".by_case").html("<span>ปี "+year+" (ปีปฏิทิน)</span>");
          }
        }else{
          if(month_txt!=''){
            var  thmonth = new Array (  "January","February","February", "April",
                                        "May","June", "July","August",
                                        "September","October","October","October");
            year = parseInt(year);
            $(".by_case").html("<span>"+thmonth[month_txt-1]+" year "+year+" (ปีปฏิทิน)</span>");
          }else if(select_quarter_chk!=''){

            $(".by_case").html("<span>ไตรมาสที "+select_quarter_chk+" ปี "+year+" (ปีปฏิทิน)</span>");
          }else{
            $(".by_case").html("<span>ปี "+year+" (ปีปฏิทิน)</span>");
          }
        }

        $('#secrch_case').val(1);
        data_case_filter();
        $('#show_search').hide();

        $('.table-caseCh-list_case').bootstrapTable('refresh');
      }
    }else{
      if(year==''){
        alert('กรุณาเลือกช่วงเวลา');
      }else{
        if(display_case==1){
          year = parseInt(year) + 543;
        }
        $(".by_case").html("<span>ปี "+year+" (ปีงบประมาณ)</span>");
        $('#secrch_case').val(1);
        data_case_filter();
        $('#show_search').hide();
        $('.table-caseCh-list_case').bootstrapTable('refresh');
      }
    }
  });



$("button[name='submit_activity']").on('click', function() {
  var display_activity = $('input[name=display_activity]:checked').val();
  if(display_activity==1){
    var year_activity  =  $("#issue_year_activity1").val();
    var month_txt =  $("#month_issue_activity1").val();
  }else{
    var year_activity  =  $("#issue_year_activity2").val();
    var month_txt =  $("#month_issue_activity2").val();
  }
  var year_type_activity = $('input[name=year_type_activity]:checked').val();
  var startDate_activity =  $("#startDate_activity").val();
  var stopDate_activity =   $("#stopDate_activity").val();
  var select_quarter_chk_activity =   $("#select_quarter_chk_activity").val();


  if(year_type_activity == 1){
    if(startDate_activity =='' && year_activity  ==''  ){
        alert('กรุณาเลือกช่วงเวลา หรือ กำหนดเอง Start Date ');
    }else if(startDate_activity !=''){
      if(stopDate_activity ==''){
          alert('กรุณาเลือกวันที่ Stop Date ');
      }else{
        console.log(1);
        $(".by_activity").html("<span>วันที่ "+startDate_activity+" - "+stopDate_activity+"</span>");
        $('#search_activity').val(1);
        $('.table-caseCh-list').bootstrapTable('refresh');
        $('#show_search_allactivity').hide();

      }
    }else{
      if(display_activity==2){
          if(startDate_activity =='' && year_activity  ==''  ){
                alert('กรุณาเลือกช่วงเวลา หรือ กำหนดเอง Start Date ');
          }else {
            if(month_txt!=''){
              var  thmonth = new Array (  "January","February","February", "April",
                                          "May","June", "July","August",
                                          "September","October","October","October");
              year_activity = parseInt(year_activity);
              $(".by_activity").html("<span>"+thmonth[month_txt-1]+" year "+year_activity+" (ปีปฏิทิน)</span>");
            }else if(select_quarter_chk_activity!=''){

              $(".by_activity").html("<span>ไตรมาสที "+select_quarter_chk_activity+" ปี "+year_activity+" (ปีปฏิทิน)</span>");
            }else{
              $(".by_activity").html("<span>ปี "+year_activity+" (ปีปฏิทิน)</span>");
            }
            console.log(2);
            $('#search_activity').val(1);
            $('.table-caseCh-list').bootstrapTable('refresh');
            $('#show_search_allactivity').hide();
          }
      }else{
        var  thmonth = new Array (  "มกราคม","กุมภาพันธ์","มีนาคม", "เมษายน",
                                    "พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม",
                                    "กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
        year_activity = parseInt(year_activity) + 543;
        if(month_txt!=''){
          $(".by_activity").html("<span>"+thmonth[month_txt-1]+" ปี "+year_activity+" (ปีปฏิทิน)</span>");
        }else if(select_quarter_chk_activity!=''){
          $(".by_activity").html("<span>ไตรมาสที่ "+select_quarter_chk_activity+" ปี "+year_activity+" (ปีปฏิทิน)</span>");
        }else{
          $(".by_activity").html("<span>ปี "+year_activity+" (ปีปฏิทิน)</span>");
        }
        console.log(3);
        $('#search_activity').val(1);
        $('.table-caseCh-list').bootstrapTable('refresh');
        $('#show_search_allactivity').hide();
      }
    }
  }else{

    if(year_activity==''){
      alert('กรุณาเลือกช่วงเวลา');
    }else{

      if(display_activity==1){
        year_activity = parseInt(year_activity) + 543;
      }
      $(".by_activity").html("<span>ปี "+year_activity+" (ปีงบประมาณ)</span>");
      console.log(4);
      $('#search_activity').val(1);
      $('.table-caseCh-list').bootstrapTable('refresh');
      $('#show_search_allactivity').hide();
    }
  }
});


});
function searchQueryParams_case(params) {

  // เช็คปี
  var issue_year_th = $("select[name='issue_year_th']").val();
  var issue_year_en = $("select[name='issue_year_en']").val();
  if(issue_year_th!=''){
    params.chechk_type_year = 1;
    params.year_adv = $("select[name='issue_year_th']").val();
  }else if(issue_year_en!=''){

    params.year_adv = $("select[name='issue_year_en']").val();
  }
  // ไตรมาส
  params.quarter = $("select[name='quarter']").val();

  // เข็ครายเดือน
  var month_issue_th = $("select[name='month_issue_th']").val();
  var month_issue_en = $("select[name='month_issue_en']").val();
  if(month_issue_th!=''){
    params.month_adv = $("select[name='month_issue_th']").val();
  }else if(month_issue_en!=''){
    params.month_adv = $("select[name='month_issue_en']").val();
  }

  // วันที่เริ่มต้น
  params.date_start = $("input[name='date_start']").val();
  params.date_stop = $("input[name='date_stop']").val();
  params.input_case = $("input[name='input_case']").val();
  params.secrch_case = $("input[name='secrch_case']").val();
  params.display_case = $('input[name=display_case]:checked').val();
  params.month_case = $("select[name='month_case']").val();
  params.year_case = $("select[name='year_case']").val();
  params.filter_activity = $("select[name='filter_activity']").val();
  params.text = $("input[name='search_text']").val();
  return params;
}

function searchQueryParams_activity(params) {

params.year_type_activity= $('input[name=year_type_activity]:checked').val();

  params.display_activity= $('input[name=display_activity]:checked').val();
  if(params.display_activity==1){
    params.year = $('#issue_year_activity1').val();
    params.month = $('#month_issue_activity1').val();

  }else{
    params.year = $('#issue_year_activity2').val();
    params.month = $('#month_issue_activity2').val();
  }
  params.select_quarter_chk_activity =  $('#select_quarter_chk_activity').val();
  params.search_activity = $("#search_activity").val();
  params.startDate_activity = $("#startDate_activity").val();
  params.stopDate_activity = $("#stopDate_activity").val();



  params.filter_activity = $("select[name='filter_activity']").val();
  params.month_activity = $("select[name='month_activity']").val();
  params.year_activity = $("select[name='year_activity']").val();
  params.text = $("input[name='search_text']").val();
  return params; // body data
}


function chk_select_year(){

  var chk_radio = $('input[name=display_case]:checked').val();
  if(chk_radio == "1"){
    var set_year = $('#issue_year1').val();
  }else {
    var set_year = $('#issue_year2').val();
  }
  // $('.selectpicker').val('default');


  if(set_year == ""){
    // console.log('-1-');

    $("#select_quarter_chk").val('default');
    $("#month_issue_1").val('default');
    $("#month_issue_2").val('default');


    $('#select_quarter_chk').attr('disabled', true);
    $('#month_issue_1').attr('disabled', true);
    $('#month_issue_2').attr('disabled', true);
    $('#startDate').prop('disabled', 'disabled');
    $('#stopDate').prop('disabled', 'disabled');
    $('#select_quarter_chk').attr('disabled', true);
    $('#startDate').attr('disabled', false);

    // $('.selectpicker').selectpicker('refresh');

  }else {
    // console.log('-2-');

  // $('.selectpicker').val('default');
    $('#select_quarter_chk').attr('disabled', false);
    $('#month_issue_1').attr('disabled', false);
    $('#month_issue_2').attr('disabled', false);
    $('#startDate').prop('disabled', true);
    $('#stopDate').attr('disabled', true);
    $('#startDate').val('');
    $('#stopDate').val('');



  }
  // $('.selectpicker').selectpicker('refresh');
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
  var chk_radio = $('input[name=display_case]:checked').val();
  if(chk_radio == "1"){
    var lang = 'th';
    var th = true;
  }else {
    var lang = 'en';
    var th = false;
  }
  var  select_quarter_chk = $('issue_year1').val();
  if(select_quarter_chk==''){


  $('#select_quarter_chk').attr('disabled', true);
  }else{

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
  $('#datetimepicker_case_1').datepicker("remove");
  $('#datetimepicker_case_2').datepicker("remove");


  $('#datetimepicker_case_1').datepicker({
    'format': 'dd/mm/yyyy',
    'startDate': getStartDate(),
    'endDate': getEndDate(),
    'language': lang,
    'thaiyear': th,
    'autoclose': true
  });
  $('#datetimepicker_case_2').datepicker({
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
      // $('.selectpicker').selectpicker('refresh');
});
function set_date_select(){
  $('#stopDate').prop('disabled', false);
  select_month_issue();
      // $('.selectpicker').selectpicker('refresh');
}


function getStartDate() {
  var chk_radio = $('input[name=display_case]:checked').val();
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
  d= "01-"+set_month+"-"+set_year;

  return d;
}

function getEndDate() {
  var chk_radio = $('input[name=display_case]:checked').val();
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
  return set_date+"-"+set_month+"-"+set_year;
}


///////////////////////////////////////////////////////   cat   ///////////////////////////////////////////////////////////////////////////////////////
function chk_select_year_cat(){
  var chk_radio = $('input[name=display_cat]:checked').val();
  if(chk_radio == "1"){
    var set_year = $('#issue_year_cat1').val();
  }else {
    var set_year = $('#issue_year_cat2').val();
  }
// $('#issue_year_cat1').val();
//   if()

  if(set_year == ""){
    $('#select_quarter_chk_cat').attr('disabled', true);
    $('#month_issue_cat1').attr('disabled', true);
    $('#month_issue_cat2').attr('disabled', true);
    $('#startDate_cat').prop('disabled', false);
    $('#stopDate_cat').prop('disabled', 'disabled');
    $('#select_quarter_chk_cat').val('default');
    $('#select_quarter_chk_cat').attr('disabled', true);
    $('#month_issue_cat1').val('default');
    $('#month_issue_cat2').val('default');
    $('#month_issue_cat1').attr('disabled', true);
    $('#month_issue_cat2').attr('disabled', true);
    $('.months_issue1').show();
    $('.months_issue2').hide();
  }else {
    $('.months_issue2').show();
    $('.months_issue1').hide();
    $('#select_quarter_chk_cat').attr('disabled', false);
    $('#month_issue_cat1').attr('disabled', false);
    $('#month_issue_cat2').attr('disabled', false);
    $('#startDate_cat').prop('disabled', true);
    // $('#stopDate_cat').prop('disabled', false);
    // $('.selectpicker').selectpicker('refresh');
  }
  var chk_radio_ty = $('input[name=year_type_cat]:checked').val();
  if(chk_radio_ty == "2"){
    $('#select_quarter_chk_cat').attr('disabled', true);
    $('#month_issue_th').attr('disabled', true);
    $('#startDate_cat').prop('disabled', 'disabled');
    $('#month_issue_cat1').prop('disabled', 'disabled');

    $('.selectpicker').selectpicker('refresh');

  }else{
    // $('#select_quarter_chk_cat').attr('disabled', false);
  }
  var ch_1 = $('#issue_year_cat1').val();
  var ch_2 = $('#issue_year_cat2').val();
  if( ch_1!='' || ch_2 !='') {
    if(chk_radio == 2 && chk_radio_ty == 2){
      $('#month_issue_cat2').attr('disabled', true);
    }
    // $('.selectpicker').selectpicker('refresh');
  }
  $('#startDate_cat').val('');
  $('#stopDate_cat').val('');
}
chk_select_year_cat();

$("#issue_year_cat1").change(function() {
  chk_select_year_cat();
    $('.selectpicker').selectpicker('refresh');

});
$("#issue_year_cat2").change(function() {
  chk_select_year_cat();
    $('.selectpicker').selectpicker('refresh');
});


function select_month_cat(){
  var chk_radio = $('input[name=display_cat]:checked').val();
  if(chk_radio == "1"){
    var lang = 'th';
    var th = true;
  }else {
    var lang = 'en';
    var th = false;
  }
  var  select_quarter_chk_cat = $('select_quarter_chk_cat').val();
  if(select_quarter_chk_cat=='1'){
    $('#month_issue_cat2').attr('disabled', false);
    $('.selectpicker').selectpicker('refresh');
  }
  var  issue_year_cat1 = $('#issue_year_cat1').val();
  var  issue_year_cat2 = $('#issue_year_cat2').val();
  if(issue_year_cat1 !='' || issue_year_cat2!='' ){
    // $('#startDate_cat').prop('disabled', 'disabled');
    // $('#stopDate_cat').prop('disabled', 'disabled');
  }
  var startDate_cat = $('#startDate_cat').val();
  if (startDate_cat != ""){
    var date_split = startDate_cat.split("/");
    if(chk_radio == "1"){
      var year_set = parseInt(date_split[2]);
      var split_date = date_split[0]+"-"+date_split[1]+"-"+(year_set-543);
    }else {
      var split_date = date_split[0]+"-"+date_split[1]+"-"+date_split[2];
    }
    start = split_date;
    end = getEndDate_cat();
  }else {
    start = getStartDate_cat();
    end = getEndDate_cat();
  }
  $('#datetimepicker_cat_1').datepicker("remove");
  $('#datetimepicker_cat_2').datepicker("remove");


    $('#datetimepicker_cat_1').datepicker({
      'format': 'dd/mm/yyyy',
      'startDate': getStartDate(),
      'endDate': getEndDate(),
      'language': lang,
      'thaiyear': th,
      'autoclose': true
    });
    $('#datetimepicker_cat_2').datepicker({
      'format': 'dd/mm/yyyy',
      'startDate': start,
      'endDate': end,
      'language': lang,
      'thaiyear': th,
      'autoclose': true
    });
}
select_month_cat();

$( "#issue_year_th_cat" ).change(function() {
  select_month_cat();
});
function set_date_cat_select(){
  $('#stopDate_cat').prop('disabled', false);
  select_month_cat();
}


function getStartDate_cat() {
  var chk_radio = $('input[name=display_cat]:checked').val();
  var year_start_cat = $('.year_start_cat').val();
  var year_stop_cat = $('.year_stop_cat').val();
  var select_quarter = $('#select_quarter_chk_cat').val();
  if(chk_radio == "1"){
    var set_year = $('#issue_year_cat1').val();
    var set_month = $('#month_issue_cat1').val();
  }else {
    var set_year = $('#issue_year_cat2').val();
    var set_month = $('#month_issue_cat2').val();
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
    set_year = year_start_cat;
  }
  d= "01-"+set_month+"-"+set_year;

  return d;
}

function getEndDate_cat() {
  var chk_radio = $('input[name=display_cat]:checked').val();
  var year_start_cat = $('.year_start_cat').val();
  var year_stop_cat = $('.year_stop_cat').val();
  var select_quarter = $('#select_quarter_chk_cat').val();
  if(chk_radio == "1"){
    var set_year = $('#issue_year_cat1').val();
    var set_month = $('#month_issue_cat1').val();
  }else {
    var set_year = $('#issue_year_cat2').val();
    var set_month = $('#month_issue_cat2').val();
  }
  if(set_year == ""){
    set_year = year_stop_cat;
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
  return set_date+"-"+set_month+"-"+set_year;
}




///////////////////////////////////////////////////////   all a   ///////////////////////////////////////////////////////////////////////////////////////

// select_month_activity
function chk_select_year_activity(){
  var chk_radio = $('input[name=display_activity]:checked').val();
  if(chk_radio == "1"){
    var set_year = $('#issue_year_activity1').val();
  }else {
    var set_year = $('#issue_year_activity2').val();
  }

  if(set_year == ""){
    $('#select_quarter_chk_activity').attr('disabled', true);
    $('#month_issue_activity1').attr('disabled', true);
    $('#month_issue_activity2').attr('disabled', true);
    $('#startDate_activity').prop('disabled', false);
    $('#stopDate_activity').prop('disabled', 'disabled');
    $('#select_quarter_chk_activity').val('default');
    $('#select_quarter_chk_activity').attr('disabled', true);
    $('#month_issue_activity1').val('default');
    $('#month_issue_activity2').val('default');
    $('#month_issue_activity1').attr('disabled', true);
    $('#month_issue_activity2').attr('disabled', true);
    $('.months_issue1').show();
    $('.months_issue2').hide();
  }else if(set_year != "" ){
    $('.months_issue2').show();
    $('.months_issue1').hide();
    $('#select_quarter_chk_activity').attr('disabled', false);
    $('#month_issue_activity1').attr('disabled', false);
    $('#month_issue_activity2').attr('disabled', false);
    $('#startDate_activity').attr('disabled', true);


  }
  var chk_radio_ty = $('input[name=year_type_activity]:checked').val();
  if(chk_radio_ty == "2"){
    $('#select_quarter_chk_activity').attr('disabled', true);
    $('#month_issue_th').attr('disabled', true);
    $('#startDate_activity').prop('disabled', 'disabled');
    $('#month_issue_activity1').prop('disabled', 'disabled');
    $('.selectpicker').selectpicker('refresh');

  }
  var ch_1 = $('#issue_year_activity1').val();
  var ch_2 = $('#issue_year_activity2').val();
  if( ch_1!='' || ch_2 !='') {
    if(chk_radio == 2 && chk_radio_ty == 2){
      $('#month_issue_activity2').attr('disabled', true);
    }
    // $('.selectpicker').selectpicker('refresh');
  }
  $('#startDate_activity').val('');
  $('#stopDate_activity').val('');
}
chk_select_year_activity();

$("#issue_year_activity1").change(function() {
  chk_select_year_activity();

    $('.selectpicker').selectpicker('refresh');

});
$("#issue_year_activity2").change(function() {
  chk_select_year_activity();
    $('.selectpicker').selectpicker('refresh');
});



function select_month_activity(){
  var chk_radio = $('input[name=display_activity]:checked').val();
  if(chk_radio == "1"){
    var lang = 'th';
    var th = true;
  }else {
    var lang = 'en';
    var th = false;
  }
  var  select_quarter_chk_cat = $('select_quarter_chk_activity').val();
  if(select_quarter_chk_cat=='1'){
    $('#month_issue_activity2').attr('disabled', false);
    $('.selectpicker').selectpicker('refresh');
  }
  var  issue_year_cat1 = $('#issue_year_activity1').val();
  var  issue_year_cat2 = $('#issue_year_activity2').val();
  if(issue_year_cat1 !='' || issue_year_cat2!='' ){
    $('#startDate_activity').prop('disabled', true);
    $('#stopDate_activity').prop('disabled', true);
    $('.selectpicker').selectpicker('refresh');

  }else{
    //
    // $('#startDate_activity').prop('disabled', false);
    // $('#stopDate_activity').prop('disabled', true);
    // $('#startDate_activity').val('default');
    //   $('#stopDate_activity').val('default');
  }
  var startDate_cat = $('#startDate_activity').val();
  if (startDate_cat != ""){
    var date_split = startDate_cat.split("/");
    if(chk_radio == "1"){
      var year_set = parseInt(date_split[2]);
      var split_date = date_split[0]+"-"+date_split[1]+"-"+(year_set-543);
    }else {
      var split_date = date_split[0]+"-"+date_split[1]+"-"+date_split[2];
    }
    start = split_date;
    end = getEndDate_cat();
  }else {
    start = getStartDate_cat();
    end = getEndDate_cat();
  }
  $('#datetimepicker_activity_1').datepicker("remove");
  $('#datetimepicker_activity_2').datepicker("remove");


    $('#datetimepicker_activity_1').datepicker({
      'format': 'dd/mm/yyyy',
      'startDate': getStartDate(),
      'endDate': getEndDate(),
      'language': lang,
      'thaiyear': th,
      'autoclose': true
    });
    $('#datetimepicker_activity_2').datepicker({
      'format': 'dd/mm/yyyy',
      'startDate': start,
      'endDate': end,
      'language': lang,
      'thaiyear': th,
      'autoclose': true
    });
}
select_month_activity();

$( "#issue_year_th_activity" ).change(function() {
  select_month_activity();
});
function set_date_activity_select(){
  $('#stopDate_activity').prop('disabled', false);
  select_month_activity();
}


function getStartDate_activity() {
  var chk_radio = $('input[name=display_activity]:checked').val();
  var year_start_cat = $('.year_start_activityt').val();
  var year_stop_cat = $('.year_stop_activity').val();
  var select_quarter = $('#select_quarter_chk_activity').val();
  if(chk_radio == "1"){
    var set_year = $('#issue_year_activity1').val();
    var set_month = $('#month_issue_activity1').val();
  }else {
    var set_year = $('#issue_year_activity2').val();
    var set_month = $('#month_issue_activity2').val();
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
    set_year = year_start_cat;
  }
  d= "01-"+set_month+"-"+set_year;

  return d;
}

function getEndDate_cat() {
  var chk_radio = $('input[name=display_activity]:checked').val();
  var year_start_cat = $('.year_start_activity').val();
  var year_stop_cat = $('.year_stop_activity').val();
  var select_quarter = $('#select_quarter_chk_activity').val();
  if(chk_radio == "1"){
    var set_year = $('#issue_year_activity1').val();
    var set_month = $('#month_issue_activity1').val();
  }else {
    var set_year = $('#issue_year_activity2').val();
    var set_month = $('#month_issue_activity2').val();
  }
  if(set_year == ""){
    set_year = year_stop_cat;
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
  return set_date+"-"+set_month+"-"+set_year;
}




///////////////////////////////////////////////////////    Kpi  ///////////////////////////////////////////////////////////////////////////////////////

function chk_select_year_kpi(){
  var chk_radio = $('input[name=display_kpi]:checked').val();
  if(chk_radio == "1"){
    var set_year = $('#issue_year_kpi1').val();
  }else {
    var set_year = $('#issue_year_kpi2').val();
  }

  if(set_year == ""){
    $('#select_quarter_chk_kpi').attr('disabled', true);
    $('#month_issue_kpi1').attr('disabled', true);
    $('#month_issue_kpi2').attr('disabled', true);
    $('#startDate_kpi').prop('disabled', false);
    $('#stopDate_kpi').prop('disabled', 'disabled');
    $('#select_quarter_chk_kpi').val('default');
    $('#select_quarter_chk_kpi').attr('disabled', true);
    $('#month_issue_kpi1').val('default');
    $('#month_issue_kpi2').val('default');
    $('#month_issue_kpi1').attr('disabled', true);
    $('#month_issue_kpi2').attr('disabled', true);
    $('.months_issue1').show();
    $('.months_issue2').hide();
  }else if(set_year != "" ){
    $('.months_issue2').show();
    $('.months_issue1').hide();
    $('#select_quarter_chk_kpi').attr('disabled', false);
    $('#month_issue_kpi1').attr('disabled', false);
    $('#month_issue_kpi2').attr('disabled', false);
    $('#startDate_kpi').attr('disabled', true);


  }
  var chk_radio_ty = $('input[name=year_type_kpi]:checked').val();
  if(chk_radio_ty == "2"){
    $('#select_quarter_chk_kpi').attr('disabled', true);
    $('#month_issue_th').attr('disabled', true);
    $('#startDate_kpi').prop('disabled', 'disabled');
    $('#month_issue_kpi1').prop('disabled', 'disabled');
    $('.selectpicker').selectpicker('refresh');

  }
  var ch_1 = $('#issue_year_kpi1').val();
  var ch_2 = $('#issue_year_kpi2').val();
  if( ch_1!='' || ch_2 !='') {
    if(chk_radio == 2 && chk_radio_ty == 2){
      $('#month_issue_kpi2').attr('disabled', true);
    }
    // $('.selectpicker').selectpicker('refresh');
  }
  $('#startDate_kpi').val('');
  $('#stopDate_kpi').val('');
}
chk_select_year_kpi();

$("#issue_year_kpi1").change(function() {
  chk_select_year_kpi();

    $('.selectpicker').selectpicker('refresh');

});
$("#issue_year_kpi2").change(function() {
  chk_select_year_kpi();
    $('.selectpicker').selectpicker('refresh');
});



function select_month_kpi(){
  var chk_radio = $('input[name=display_kpi]:checked').val();
  if(chk_radio == "1"){
    var lang = 'th';
    var th = true;
  }else {
    var lang = 'en';
    var th = false;
  }
  var  select_quarter_chk_cat = $('select_quarter_chk_kpi').val();
  if(select_quarter_chk_cat=='1'){
    $('#month_issue_kpi2').attr('disabled', false);
    $('.selectpicker').selectpicker('refresh');
  }
  var  issue_year_cat1 = $('#issue_year_kpi1').val();
  var  issue_year_cat2 = $('#issue_year_kpi2').val();
  if(issue_year_cat1 !='' || issue_year_cat2!='' ){
    $('#startDate_kpi').prop('disabled', true);
    $('#stopDate_kpi').prop('disabled', true);
    $('.selectpicker').selectpicker('refresh');

  }else{
    //
    // $('#startDate_kpi').prop('disabled', false);
    // $('#stopDate_kpi').prop('disabled', true);
    // $('#startDate_kpi').val('default');
    //   $('#stopDate_kpi').val('default');
  }
  var startDate_cat = $('#startDate_kpi').val();
  if (startDate_cat != ""){
    var date_split = startDate_cat.split("/");
    if(chk_radio == "1"){
      var year_set = parseInt(date_split[2]);
      var split_date = date_split[0]+"-"+date_split[1]+"-"+(year_set-543);
    }else {
      var split_date = date_split[0]+"-"+date_split[1]+"-"+date_split[2];
    }
    start = split_date;
    end = getEndDate_cat();
  }else {
    start = getStartDate_cat();
    end = getEndDate_cat();
  }
  $('#datetimepicker_kpi_1').datepicker("remove");
  $('#datetimepicker_kpi_2').datepicker("remove");


    $('#datetimepicker_kpi_1').datepicker({
      'format': 'dd/mm/yyyy',
      'startDate': getStartDate(),
      'endDate': getEndDate(),
      'language': lang,
      'thaiyear': th,
      'autoclose': true
    });
    $('#datetimepicker_kpi_2').datepicker({
      'format': 'dd/mm/yyyy',
      'startDate': start,
      'endDate': end,
      'language': lang,
      'thaiyear': th,
      'autoclose': true
    });
}
select_month_kpi();

$( "#issue_year_th_kpi" ).change(function() {
  select_month_kpi();
});
function set_date_kpi_select(){
  $('#stopDate_kpi').prop('disabled', false);
  select_month_kpi();
}


function getStartDate_kpi() {
  var chk_radio = $('input[name=display_kpi]:checked').val();
  var year_start_cat = $('.year_start_kpit').val();
  var year_stop_cat = $('.year_stop_kpi').val();
  var select_quarter = $('#select_quarter_chk_kpi').val();
  if(chk_radio == "1"){
    var set_year = $('#issue_year_kpi1').val();
    var set_month = $('#month_issue_kpi1').val();
  }else {
    var set_year = $('#issue_year_kpi2').val();
    var set_month = $('#month_issue_kpi2').val();
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
    set_year = year_start_cat;
  }
  d= "01-"+set_month+"-"+set_year;

  return d;
}

function getEndDate_cat() {
  var chk_radio = $('input[name=display_kpi]:checked').val();
  var year_start_cat = $('.year_start_kpi').val();
  var year_stop_cat = $('.year_stop_kpi').val();
  var select_quarter = $('#select_quarter_chk_kpi').val();
  if(chk_radio == "1"){
    var set_year = $('#issue_year_kpi1').val();
    var set_month = $('#month_issue_kpi1').val();
  }else {
    var set_year = $('#issue_year_kpi2').val();
    var set_month = $('#month_issue_kpi2').val();
  }
  if(set_year == ""){
    set_year = year_stop_cat;
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
  return set_date+"-"+set_month+"-"+set_year;
}




</script>
