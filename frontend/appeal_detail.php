<?php
$case_id = $_GET['case_id'];

$sql = "SELECT c.caseDtl_title,
 c.case_status,
 c.case_create_datetime,
 c.prodType_id,
 c.caseDtl_derivation,
 c.caseDtl_damage_val,
 c.curren_id,
 c.caseDtl_complnt_need,
 c.complnt_name,
 c.caseClose_id,
 cs.caseClose_title,
 p.process_type_id,
 c.compType_id,
 ct.compType_section,
 c.incType_id,
 c.case_close_resultProcess
FROM `Case` AS c
LEFT JOIN `Process` AS p ON c.case_id = p.case_id
LEFT JOIN `Process_Type` AS pt ON pt.process_type_id = p.process_type_id
LEFT JOIN `Case_Close` AS cs ON c.caseClose_id = cs.caseClose_id
LEFT JOIN `Complaint_Type` AS ct ON c.compType_id = ct.compType_id
WHERE c.case_id='$case_id' ";
$query = $conn->query($sql);
$re = $query->fetch_assoc();

$date_time = $re['case_create_datetime'];
$date_time_ex = explode(" ",$date_time);
$date_waitting = $date_time_ex[0];
$time_waitting = $date_time_ex[1];
$date_ex = explode("-",$date_waitting);
$time_ex = explode(":",$time_waitting);
$date = $date_ex[2]."/".$date_ex[1]."/".$date_ex[0];
$time = $time_ex[0].".".$time_ex[1];

?>
<div class="row appeal_div_row">
  <div class="row">
    <div class="col-md-12">
      <span class="icon_hr_appeal icon_hr_appeal_detail"><img src="images/all_icon_DITP/icon_6.svg" style="width:30px;" class="icon_appeal"></span>
      <span class="txt_hr_appeal txt_hr_appeal_detail"><?=$txt_Follow?> |<br></span>
      <span class="txt_hr_appeal_ex_detail">
      <span class="txt_hr_appeal_ex"><?=$txt_Topic?> : </span>
      <span class="txt_hr_appeal_ex"><?php echo $re['caseDtl_title']?></span>
    </span>
    </div>
  </div>

  <div class="row detail_status_hr">
    <div class="col-md-6 col-sm-12">
      <div class="panel panel-default appeal_panel_detail">
          <div class="row">
            <div class="col-md-3 col-sm-3 col-xs-3 div_detail_status">
              <span class="detail_status"><?=$txt_Status?> : </span>
              <?php
              if($re['case_status'] == 0){?>
                  <span class="icon_status"><img src="images/icon_waiting_detail.png"></span>
              <?php }elseif ($re['case_status'] == 1 || $re['case_status'] == 2) {?>
                  <span class="icon_status"><img src="images/icon_pending_detail.png"></span>
              <?php }elseif ($re['case_status'] == 3) {?>
                  <span class="icon_status"><img src="images/icon_complete_detail.png"></span>
              <?php }
              ?>
            </div>
            <div class="col-md-5 col-sm-5 col-xs-4 div_percent_detail">
              <?php
              if($re['case_status'] == 0){?>
                  <span class="percent_detail"><img src="images/icon_0.png"></span>
              <?php }elseif ($re['case_status'] == 1 || $re['case_status'] == 2) {

                if($re['process_type_id'] != ""){
                  $sql_process = "SELECT
                  p.process_type_id,
                  pt.process_type_step
                  FROM `Process` AS p
                  LEFT JOIN `Process_Type` AS pt ON p.process_type_id=pt.process_type_id
                  WHERE p.case_id = '".$case_id."' ORDER BY p.process_id DESC";
                  $query_process = $conn->query($sql_process);
                  if($query_process->num_rows > 0){

                    $rl = $query_process->fetch_assoc();
                    if($rl['process_type_step'] == 1){ ?>
                      <span class="percent_detail"><img src="images/icon_25.png"></span>
                    <?php }elseif ($rl['process_type_step'] == 2) { ?>
                      <span class="percent_detail"><img src="images/icon_50.png"></span>
                    <?php }elseif ($rl['process_type_step'] == 3) { ?>
                      <span class="percent_detail"><img src="images/icon_75.png"></span>
                    <?php }

                }
              }else {?>
                <span class="percent_detail"><img src="images/icon_25.png"></span>
              <?php }

              }elseif ($re['case_status'] == 3) {?>
                  <span class="percent_detail"><img src="images/icon_100.png"></span>
              <?php } ?>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-4 div_detail_case_id">
              <span class="detail_case_id">Case ID : </span>
              <?php $case = sprintf("%05s",$case_id); ?>
              <span class="case_id_number"><?=$case?></span>

              <div class="shadow_detail"><img src="images/shadow_detail.png"></div>
            </div>
          </div>
        </div> <!-- status -->
    </div>
    <div class="col-md-6 col-sm-12">
      <?php
      $sty_ok = "background: rgba(76,170,81,1);
      background: -moz-linear-gradient(left, rgba(76,170,81,1) 0%, rgba(76,170,81,1) 68%, rgba(137,194,141,1) 100%);
      background: -webkit-gradient(left top, right top, color-stop(0%, rgba(76,170,81,1)), color-stop(68%, rgba(76,170,81,1)), color-stop(100%, rgba(137,194,141,1)));
      background: -webkit-linear-gradient(left, rgba(76,170,81,1) 0%, rgba(76,170,81,1) 68%, rgba(137,194,141,1) 100%);
      background: -o-linear-gradient(left, rgba(76,170,81,1) 0%, rgba(76,170,81,1) 68%, rgba(137,194,141,1) 100%);
      background: -ms-linear-gradient(left, rgba(76,170,81,1) 0%, rgba(76,170,81,1) 68%, rgba(137,194,141,1) 100%);
      background: linear-gradient(to right, rgba(76,170,81,1) 0%, rgba(76,170,81,1) 68%, rgba(137,194,141,1) 100%);
      filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#4caa51', endColorstr='#89c28d', GradientType=1 );";
      $sty_no = "background: #CCCCCC;";

      if($re['case_status'] == 0){ ?>

        <div class="panel panel-default appeal_panel_status1" style="<?=$sty_no?>">
          <div class="div_detail_status1">
            <span class="detail_chk_status1"><img src="images/icon_chk_no.png"></span>
            <span class="txt_chk_detail1"><?=$txt_successfully?></span>
          </div>
        </div> <!-- status1 -->
        <div class="panel panel-default appeal_panel_status2" style="<?=$sty_no?>">
          <div class="div_detail_status2">
            <span class="detail_chk_status2"><img src="images/icon_chk_no.png"></span>
            <span class="txt_chk_detail2"><?=$txt_successfully_channel?></span>
          </div>
        </div> <!-- status2 -->
        <div class="panel panel-default appeal_panel_status3" style="<?=$sty_no?>">
          <div class="div_detail_status3">
            <span class="detail_chk_status3"><img src="images/icon_chk_no.png"></span>
            <span class="txt_chk_detail3"><?=$txt_validation?></span>
          </div>
        </div> <!-- status3 -->
        <div class="panel panel-default appeal_panel_status4" style="<?=$sty_no?>">
          <div class="div_detail_status4">
            <span class="detail_chk_status4"><img src="images/icon_chk_no.png"></span>
            <span class="txt_chk_detail4"><?=$txt_Suspend?></span>
          </div>
        </div> <!-- status4 -->

      <?php }elseif ($re['case_status'] == 1 || $re['case_status'] == 2) {
        if($re['process_type_id'] != ""){
          $sql_process = "SELECT
          p.process_type_id,
          pt.process_type_step
          FROM `Process` AS p
          LEFT JOIN `Process_Type` AS pt ON p.process_type_id=pt.process_type_id
          WHERE p.case_id = '".$case_id."' ORDER BY p.process_id DESC";
          $query_process = $conn->query($sql_process);
          $rl = $query_process->fetch_assoc();
          if($rl['process_type_step'] == 1){ ?>

            <div class="panel panel-default appeal_panel_status1" style="<?=$sty_ok?>">
              <div class="div_detail_status1">
                <span class="detail_chk_status1"><img src="images/icon_chk_ok.png"></span>
                <span class="txt_chk_detail1"><?=$txt_successfully?></span>
              </div>
            </div> <!-- status1 -->
            <div class="panel panel-default appeal_panel_status2" style="<?=$sty_no?>">
              <div class="div_detail_status2">
                <span class="detail_chk_status2"><img src="images/icon_chk_no.png"></span>
                <span class="txt_chk_detail2"><?=$txt_successfully_channel?></span>
              </div>
            </div> <!-- status2 -->
            <div class="panel panel-default appeal_panel_status3" style="<?=$sty_no?>">
              <div class="div_detail_status3">
                <span class="detail_chk_status3"><img src="images/icon_chk_no.png"></span>
                <span class="txt_chk_detail3"><?=$txt_validation?></span>
              </div>
            </div> <!-- status3 -->
            <div class="panel panel-default appeal_panel_status4" style="<?=$sty_no?>">
              <div class="div_detail_status4">
                <span class="detail_chk_status4"><img src="images/icon_chk_no.png"></span>
                <span class="txt_chk_detail4"><?=$txt_Suspend?></span>
              </div>
            </div> <!-- status4 -->

          <?php }elseif ($rl['process_type_step'] == 2) { ?>


                      <div class="panel panel-default appeal_panel_status1" style="<?=$sty_ok?>">
                        <div class="div_detail_status1">
                          <span class="detail_chk_status1"><img src="images/icon_chk_ok.png"></span>
                          <span class="txt_chk_detail1"><?=$txt_successfully?></span>
                        </div>
                      </div> <!-- status1 -->
                      <div class="panel panel-default appeal_panel_status2" style="<?=$sty_ok?>">
                        <div class="div_detail_status2">
                          <span class="detail_chk_status2"><img src="images/icon_chk_ok.png"></span>
                          <span class="txt_chk_detail2"><?=$txt_successfully_channel?></span>
                        </div>
                      </div> <!-- status2 -->
                      <div class="panel panel-default appeal_panel_status3" style="<?=$sty_no?>">
                        <div class="div_detail_status3">
                          <span class="detail_chk_status3"><img src="images/icon_chk_no.png"></span>
                          <span class="txt_chk_detail3"><?=$txt_validation?></span>
                        </div>
                      </div> <!-- status3 -->
                      <div class="panel panel-default appeal_panel_status4" style="<?=$sty_no?>">
                        <div class="div_detail_status4">
                          <span class="detail_chk_status4"><img src="images/icon_chk_no.png"></span>
                          <span class="txt_chk_detail4"><?=$txt_Suspend?></span>
                        </div>
                      </div> <!-- status4 -->

          <?php }elseif ($rl['process_type_step'] == 3) { ?>

                        <div class="panel panel-default appeal_panel_status1" style="<?=$sty_ok?>">
                          <div class="div_detail_status1">
                            <span class="detail_chk_status1"><img src="images/icon_chk_ok.png"></span>
                            <span class="txt_chk_detail1"><?=$txt_successfully?></span>
                          </div>
                        </div> <!-- status1 -->
                        <div class="panel panel-default appeal_panel_status2" style="<?=$sty_ok?>">
                          <div class="div_detail_status2">
                            <span class="detail_chk_status2"><img src="images/icon_chk_ok.png"></span>
                            <span class="txt_chk_detail2"><?=$txt_successfully_channel?></span>
                          </div>
                        </div> <!-- status2 -->
                        <div class="panel panel-default appeal_panel_status3" style="<?=$sty_ok?>">
                          <div class="div_detail_status3">
                            <span class="detail_chk_status3"><img src="images/icon_chk_ok.png"></span>
                            <span class="txt_chk_detail3"><?=$txt_validation?></span>
                          </div>
                        </div> <!-- status3 -->
                        <div class="panel panel-default appeal_panel_status4" style="<?=$sty_no?>">
                          <div class="div_detail_status4">
                            <span class="detail_chk_status4"><img src="images/icon_chk_no.png"></span>
                            <span class="txt_chk_detail4"><?=$txt_Suspend?></span>
                          </div>
                        </div> <!-- status4 -->
          <?php
          }
      }else{ ?>

                    <div class="panel panel-default appeal_panel_status1" style="<?=$sty_ok?>">
                      <div class="div_detail_status1">
                        <span class="detail_chk_status1"><img src="images/icon_chk_ok.png"></span>
                        <span class="txt_chk_detail1"><?=$txt_successfully?></span>
                      </div>
                    </div> <!-- status1 -->
                    <div class="panel panel-default appeal_panel_status2" style="<?=$sty_no?>">
                      <div class="div_detail_status2">
                        <span class="detail_chk_status2"><img src="images/icon_chk_no.png"></span>
                        <span class="txt_chk_detail2"><?=$txt_successfully_channel?></span>
                      </div>
                    </div> <!-- status2 -->
                    <div class="panel panel-default appeal_panel_status3" style="<?=$sty_no?>">
                      <div class="div_detail_status3">
                        <span class="detail_chk_status3"><img src="images/icon_chk_no.png"></span>
                        <span class="txt_chk_detail3"><?=$txt_validation?></span>
                      </div>
                    </div> <!-- status3 -->
                    <div class="panel panel-default appeal_panel_status4" style="<?=$sty_no?>">
                      <div class="div_detail_status4">
                        <span class="detail_chk_status4"><img src="images/icon_chk_no.png"></span>
                        <span class="txt_chk_detail4"><?=$txt_Suspend?></span>
                      </div>
                    </div> <!-- status4 -->

      <?php }

    }elseif ($re['case_status'] == 3) { ?>


                        <div class="panel panel-default appeal_panel_status1" style="<?=$sty_ok?>">
                          <div class="div_detail_status1">
                            <span class="detail_chk_status1"><img src="images/icon_chk_ok.png"></span>
                            <span class="txt_chk_detail1"><?=$txt_successfully?></span>
                          </div>
                        </div> <!-- status1 -->
                        <div class="panel panel-default appeal_panel_status2" style="<?=$sty_ok?>">
                          <div class="div_detail_status2">
                            <span class="detail_chk_status2"><img src="images/icon_chk_ok.png"></span>
                            <span class="txt_chk_detail2"><?=$txt_successfully_channel?></span>
                          </div>
                        </div> <!-- status2 -->
                        <div class="panel panel-default appeal_panel_status3" style="<?=$sty_ok?>">
                          <div class="div_detail_status3">
                            <span class="detail_chk_status3"><img src="images/icon_chk_ok.png"></span>
                            <span class="txt_chk_detail3"><?=$txt_validation?></span>
                          </div>
                        </div> <!-- status3 -->
                        <div class="panel panel-default appeal_panel_status4" style="<?=$sty_ok?>">
                          <div class="div_detail_status4">
                            <span class="detail_chk_status4"><img src="images/icon_chk_ok.png"></span>
                            <span class="txt_chk_detail4"><?=$txt_Suspend?></span>
                          </div>
                        </div> <!-- status4 -->

      <?php }
      ?>

    </div>
  </div>
<?php if($re['case_status'] == 0){?>
  <div class="row">
    <div class="col-md-12 div_remind">
      <span class="icon_remind"><img src="images/all_icon_DITP/icon_25.svg" style="width:40px;"></span>
      <span class="txt_loading"><?=$txt_working?></span>
    </div>
    <div class="col-md-12 div_remind2" style="display:none;">
      <div class="col-xs-2 icon_remind"><img src="images/all_icon_DITP/icon_25.svg" style="width:40px;"></div>
      <div class="col-xs-10 txt_loading"><?=$txt_working?></div>
    </div>
  </div>
<?php } ?>
<?php if($re['case_status'] == 3){?>
  <div class="row">
    <div class="col-md-12 div_remind">
      <span class="txt_cose"><?=$txt_Halt?></span>
    </div>
    <div class="col-md-12 div_remind2" style="display:none;">
      <div class="txt_cose"><?=$txt_Halt?></div>
    </div>
  </div>
  <div class="panel panel-default" style="margin-top:20px;">
    <div class="div_detail_col">
      <span class="txt_chk_detail_col"><?php echo $re['caseClose_title'];?> <?php if($lang == "1"){ echo "โดยที่";}elseif($lang == "2"){ echo "by";}else{ echo "โดยที่";}?> <?php echo $re['case_close_resultProcess'];?></span>
    </div>
  </div> <!-- status4 -->
<?php } ?>

<?php if($re['case_status'] != 3){?>
  <div class="row">
    <div class="col-md-12 div_remind">
      <span class="icon_remind"><img src="images/all_icon_DITP/icon_24.svg" style="width:40px;"></span>
      <span class="txt_remind"><?=$txt_Call_Centre?></span>
    </div>
    <div class="col-md-12 div_remind2" style="display:none; margin-top:10px;">
      <div class="col-xs-2 icon_remind"><img src="images/all_icon_DITP/icon_24.svg" style="width:40px;"></div>
      <div class="col-xs-10 txt_remind"><?=$txt_Call_Centre?></div>
    </div>
  </div>
<?php } ?>


  <div class="panel panel-default appeal_panel appeal_panel_detail_ex">
    <div class="panel-heading hr_appeal_detail_panel">
      <span class="hr_txt_waiting hr_box_appeal_detail"><?=$txt_About_petition?></span>
      <a data-toggle="collapse" href="#collapse_1" class="collapse_1"><span class="icon_hide_detail_invite"></span></a>
      <span class="detail_time box_time_appeal"><?php echo $time;?></span><span class="icon_time_w"><img src="images/all_icon_DITP/icon_20.svg" style="width:18px;"></span>
      <span class="detail_date box_date_appeal"><?php echo $date;?></span><span class="icon_date_w"><img src="images/all_icon_DITP/icon_18.svg" style="width:15px;"></span>


    </div>
    <div id="collapse_1" class="panel-collapse collapse in">
    <div class="panel-body">
      <div class="row div_complaint_detail">
        <div class="col-md-12">
          <div class="hr_complaint_detail"><?=$txt_Topic?></div>
          <div class="txt_complaint_detail"><?php if($re['caseDtl_title'] == ""){ echo "-";}else{echo $re['caseDtl_title'];}?></div>
        </div>
      </div>
      <div class="row div_category_detail">
        <?php if($re['compType_section'] == "1"){?>
          <div class="col-md-12">
            <div class="hr_category_detail"><?=$txt_Type_goods?></div>
            <div class="txt_category_detail">
              <?php
            $sql = "SELECT * FROM `Product_Type` WHERE prodType_id = '".$re['prodType_id']."'";
            $query = $conn->query($sql);
            if($query->num_rows > 0){
              $rs = $query->fetch_assoc();
            }
            if($rs['prodType_name'] == ""){ echo "-";}else{echo $rs['prodType_name'];}
            ?>
          </div>
          </div>
        <?php }else { ?>
          <div class="col-md-12">
            <div class="hr_category_detail"><?=$txt_complaint?></div>
            <div class="txt_category_detail">
              <?php
            $sql = "SELECT * FROM `Incorrect_Type` WHERE incType_id = '".$re['incType_id']."'";
            $query = $conn->query($sql);
            if($query->num_rows > 0){
              $rs = $query->fetch_assoc();
            }
            if($rs['incType_name'] == ""){ echo "-";}else{echo $rs['incType_name'];}
            ?>
          </div>
          </div>
        <?php } ?>


      </div>
      <div class="row div_history_detail">
        <div class="col-md-12">
          <div class="hr_history_detail"><?=$txt_Bg_information?></div>
          <div class="txt_history_detail">
            <?php if($re['caseDtl_derivation'] == ""){ echo "-";}else{echo $re['caseDtl_derivation'];}?></div>
        </div>
      </div>
      <div class="row div_charge_detail">
        <div class="col-md-12">
          <div class="hr_charge_detail"><?=$txt_Damage_ex?></div>
          <div class="txt_charge_detail"><?php echo $re['caseDtl_damage_val'];?>
            <?php
            $sql_curren = "SELECT * FROM `Currency` WHERE curren_id = '".$re['curren_id']."'";
            $query_curren = $conn->query($sql_curren);
            if($query_curren->num_rows > 0){
              $rl = $query_curren->fetch_assoc();
              echo $rl['curren_name'];
            }
            ?>
          </div>
        </div>
      </div>
      <div class="row div_demand_detail">
        <div class="col-md-12">
          <div class="hr_demand_detail"><?=$txt_requirement?></div>
          <div class="txt_demand_detail"><?php if($re['caseDtl_complnt_need'] == ""){ echo "-";}else{echo $re['caseDtl_complnt_need'];}?></div>
        </div>
      </div>
  </div>
</div>
</div> <!-- div รายละเอียดเรื่องร้องเรียน -->

<div class="panel panel-default appeal_panel appeal_panel_detail_ex">
  <div class="panel-heading hr_appeal_detail_panel">
    <span class="hr_txt_waiting hr_box_appeal_detail"><?=$txt_Defendant_ex?></span>
    <a data-toggle="collapse" href="#collapse_2" class="collapse_2"><span class="icon_hide_detail_invite"></span></a>
  </div>
  <div id="collapse_2" class="panel-collapse collapse in">
  <div class="panel-body">
    <div class="row div_name_office_detail">
      <?php
      $case = array();
      $sql_formset = "SELECT * FROM `Field_Values` AS fv LEFT JOIN `Field_Set` AS fs ON fv.fieldset_id = fs.fieldset_id WHERE case_id = '$case_id'";
      $query_formset = $conn->query($sql_formset);
      while ($rx = $query_formset->fetch_assoc()) {
        $case[$rx["fieldset_name"]] = $rx["fieldset_value"];
      }
      ?>
      <div class="col-md-12">
        <span class="icon_detail_home"><img src="images/icon_invite_home.png"></span>
          <span class="hr_detail_company_name"><?php echo $re['complnt_name'];?></span>
      </div>
    </div>
    <div class="row div_branch_detail">
      <div class="col-md-3 col-sm-4 txt_app_hr"><?=$txt_Branch?><span class="txt_xr txt_xr_appeal">:</span></div>
      <div class="col-md-4 col-sm-8 txt_app_de"><?php if($case['complnt_branch'] == ""){ echo "-";}else{echo $case['complnt_branch'];}?></div>
      <div class="col-md-5"></div>
    </div>
    <div class="row div_trade_detail">
      <div class="col-md-3 col-sm-4 txt_app_hr"><?=$txt_Contact_name?><span class="txt_xr txt_xr_appeal">:</span></div>
      <div class="col-md-4 col-sm-8 txt_app_de"><?php if($case['complnt_contact_name'] == ""){ echo "-";}else{echo $case['complnt_contact_name'];}?></div>
      <div class="col-md-5"></div>
    </div>
    <div class="row div_contacts_detail">
      <div class="col-md-3 col-sm-4 txt_app_hr"><?=$txt_email_to?><span class="txt_xr txt_xr_appeal">:</span></div>
      <div class="col-md-4 col-sm-8 txt_app_de"><?php if($case['complnt_contact_email'] == ""){ echo "-";}else{echo $case['complnt_contact_email'];}?></div>
      <div class="col-md-5"></div>
    </div>
    <div class="row div_tel_detail">
      <div class="col-md-3 col-sm-4 txt_app_hr"><?=$txt_Tel_number?><span class="txt_xr txt_xr_appeal">:</span></div>
      <div class="col-md-4 col-sm-8 txt_app_de"><?php if($case['complnt_contact_tel'] == ""){ echo "-";}else{echo $case['complnt_contact_tel'];}?></div>
      <div class="col-md-5"></div>
    </div>
    <div class="row div_address_detail">
      <div class="col-md-3 col-sm-4 txt_app_hr"><?=$txt_Address?><span class="txt_xr txt_xr_appeal">:</span></div>
      <div class="col-md-4 col-sm-8 txt_app_de"><?php if($case['complnt_contact_address'] == ""){ echo "-";}else{echo $case['complnt_contact_address'];}?></div>
      <div class="col-md-5"></div>
    </div>
    <div class="row div_country_detail">
      <div class="col-md-3 col-sm-4 txt_app_hr"><?=$txt_Country?><span class="txt_xr txt_xr_appeal">:</span></div>
      <div class="col-md-4 col-sm-8 txt_app_de">
        <?php
        $sql_country = "SELECT * FROM `Country` WHERE id = '".$case['complnt_country_id']."'";
        $query_country = $conn->query($sql_country);
        $ra = $query_country->fetch_assoc();
      if($ra['name'] == ""){ echo "-";}else{echo $ra['name'];}
      ?></div>
      <div class="col-md-5"></div>
    </div>
</div>
</div>
</div> <!-- div ข้อมูลบริษัทผู้ถูกร้องเรียน -->

<div class="panel panel-default appeal_panel appeal_panel_xr appeal_panel_detail_ex">
  <div class="panel-heading hr_appeal_detail_panel">
    <span class="hr_txt_waiting hr_box_appeal_detail"><?=$txt_Documentation?></span>
    <a data-toggle="collapse" href="#collapse_3" class="collapse_3"><span class="icon_hide_detail_invite"></span></a>
  </div>
  <div id="collapse_3" class="panel-collapse collapse in">
  <div class="panel-body" style="color:#808080;">
    <?php
    $file_count = glob("../data/case_attach/$case_id/*.*");
    if(count($file_count) > 0){
      $sn = "";
      foreach (glob("../data/case_attach/$case_id/*.*") as $sn) {
        $sn_ex = explode("/",$sn);
        $sn_type = explode(".",$sn_ex[4]);
        ?>

        <div class="panel panel-default panel_file_detail">
          <a href="<?=$sn;?>" target="_blank">
        <div class="panel-body">
        <?php if($sn_type[1] == "jpeg" || $sn_type[1] == "jpg" || $sn_type[1] == "png"){ ?>
            <i class="fa fa-file-image-o" aria-hidden="true" style="font-size:30px;"></i>
        <?php }elseif ($sn_type[1] == "pdf") { ?>
            <i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:30px;"></i>
        <?php }elseif ($sn_type[1] == "ppt") { ?>
          <i class="fa fa-file-powerpoint-o" aria-hidden="true" style="font-size:30px;"></i>
        <?php }elseif ($sn_type[1] == "docx") { ?>
            <i class="fa fa-file-word-o" aria-hidden="true" style="font-size:30px;"></i>
        <?php }elseif ($sn_type[1] == "xlsx" || $sn_type[1] == "xls") { ?>
          <i class="fa fa-file-excel-o" aria-hidden="true" style="font-size:30px;"></i>
        <?php } ?>
        <span><?php
        echo $sn_ex[4];
        ?>
      </span>
    </div>
  </a>
    </div>
      <?php }
    }else { ?>
      <div class="panel panel-default panel_file_detail">
      <div class="panel-body" style="text-align: center;">
      <span><?=$txt_Attachment_not?></span>
      </div>
      </div>
  <?php } ?>
</div>
</div>
</div> <!-- div เอกสารประกอบการร้องเรียน -->


</div>


<div id="myModal_login" class="modal fade" role="dialog" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" onclick="modal_popuph('close')">&times;</button>
    </div>
    <div class="modal-body" style="      padding-bottom: 30px;  text-align: center;">
    <i class="fa fa-exclamation-triangle" aria-hidden="true" style=" color: #048F78; font-size: 120px;"></i>
      <p style="font-size: xx-large;">กรุณาเข้าสู่ระบบ</p>
      <p style=" color: red;">*บัญชีผู้ใช้เดียวกับที่แจ้งเรื่องร้องเรียน</p>
      <a href="https://sso-uat.ditp.go.th/sso/index.php/auth?response_type=token&client_id=ssocareid&redirect_uri=<?=htmlentities(urlencode('https://caredev.ditp.go.th/api/autologin_sso_v2.php'))?>&state=ugfjdfksg1" class="btn btn-success" style=" background-color: #048F78;  border: 3px solid #048F78;"><?=$txt_alert_login4?></a>
    </div>
    </div>
  </div>
</div>

<div id="myModal_case" class="modal fade" role="dialog" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" onclick="modal_popuph('close')">&times;</button>
    </div>
    <div class="modal-body" style="      padding-bottom: 30px;  text-align: center;">
    <i class="fa fa-exclamation-triangle" aria-hidden="true" style=" color: #048F78; font-size: 120px;"></i>
      <p style="font-size: xx-large;">บัญชีของคุณไม่มีสิทธิ์เข้าใช้งานหน้านี้</p>
      <a href="/frontend/index.php?page=home" class="btn btn-success" style=" background-color: #048F78;  border: 3px solid #048F78;"><?=$txt_ok?></a>
    </div>
    </div>
  </div>
</div>

<script>

$(document).ready(function() {
  <?php if(isset($_GET['user_id'])) { if(checklogin() == false) { ?>
    $('#myModal_login').modal('show');
  <?php } 
  if($_SESSION["check_user_id"] == 'false') { ?>
    $('#myModal_case').modal('show');
  <?php 
		session_start();
    unset($_SESSION['check_user_id']);

    } }
  ?>
});

function modal_popuph(type) {
  if(type == 'close') {
    location.href = "/frontend/index.php?page=home";

  }
}

$('.collapse_1').bind('click',function(){
var id_elm = $(this).attr('href');
if($(id_elm).hasClass('in')){
  $(this).find('span').removeClass('icon_hide_detail_invite');
  $(this).find('span').addClass('icon_show_detail_invite');
}else{
  $(this).find('span').removeClass('icon_show_detail_invite');
  $(this).find('span').addClass('icon_hide_detail_invite');
}
});

$('.collapse_2').bind('click',function(){
var id_elm = $(this).attr('href');
if($(id_elm).hasClass('in')){
  $(this).find('span').removeClass('icon_hide_detail_invite');
  $(this).find('span').addClass('icon_show_detail_invite');
}else{
  $(this).find('span').removeClass('icon_show_detail_invite');
  $(this).find('span').addClass('icon_hide_detail_invite');
}
});

$('.collapse_3').bind('click',function(){
var id_elm = $(this).attr('href');
if($(id_elm).hasClass('in')){
  $(this).find('span').removeClass('icon_hide_detail_invite');
  $(this).find('span').addClass('icon_show_detail_invite');
}else{
  $(this).find('span').removeClass('icon_show_detail_invite');
  $(this).find('span').addClass('icon_hide_detail_invite');
}
});
</script>
