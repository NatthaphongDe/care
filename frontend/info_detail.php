<div class="row appeal_div_row">
  <div class="col-md-12">
    <input type="hidden" class="ck_id" value="<?=htmlspecialchars($_GET['ck_id'], ENT_QUOTES);?>">
    <?php
    $ck_id = mysqli_real_escape_string($conn,$_GET['ck_id']);
    $sql = "SELECT
    ck.caseDtl_title,
    ck.compType_id,
    ck.complnt_name,
    ck.applnt_name,
    ck.caseDtl_derivation,
    ck.caseDtl_damage_val,
    ck.curren_id,
    ck.case_id,
    ck.caseDtl_complnt_need,
    ck.case_close_resultProcess,
    ck.incType_id,
    it.incType_name,
    it.incType_name_en,
    cr.curren_name,
    ct.compType_name,
    ct.compType_name_en,
    c.caseClose_id,
    cs.caseClose_title,
    pt.prodType_name,
    pt.prodType_name_en
    FROM `Case_Knowledge` AS ck
    LEFT JOIN `Complaint_Type` AS ct ON ck.compType_id = ct.compType_id
    LEFT JOIN `Currency` AS cr ON ck.curren_id = ck.curren_id
    LEFT JOIN `Product_Type` AS pt ON ck.prodType_id = pt.prodType_id
    LEFT JOIN `Case` AS c ON ck.case_id = c.case_id
    LEFT JOIN `Case_Close` AS cs ON c.caseClose_id = cs.caseClose_id
    LEFT JOIN `Incorrect_Type` AS it ON ck.incType_id = it.incType_id
    WHERE ck.caseKnlg_id = ?";
    $stmt = mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($stmt, "s", $ck_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $re = mysqli_fetch_array($result, MYSQLI_ASSOC);
    /* $query = $conn->query($sql);
    $re = $query->fetch_assoc(); */
    if($lang == "2"){
      $prodType_name = $re['prodType_name_en'];
      $incType_name = $re['incType_name_en'];
    }else {
      $prodType_name = $re['prodType_name'];
      $incType_name = $re['incType_name'];
    }
    ?>
    <span class="icon_hr_info"><img src="images/all_icon_DITP/icon_8.svg" style="width:30px;" class="icon_info"></span>
    <span class="txt_hr_info txt_info_detail_rx"><?=$txt_Knowledge?> &nbsp; <span class="txt_info_detail">|</span> &nbsp;<br style="display:none;"></span>
    <span class="txt_hr_info_ex txt_info_detail_rs"><?=$txt_Subject?> : </span>
    <span class="txt_hr_info_ex"><?php echo $re['caseDtl_title'];?></span>

    <div class="panel panel-default appeal_panel">
      <div class="panel-heading hr_info_panel">
        <span class="icon_hr_info"><img src="images/all_icon_DITP/icon-18.svg" style="width:30px;" class="icon_info"></span>
        <span class="txt_info"><?=$txt_About_petition?></span>
      </div>
      <div class="panel-body">
        <div class="row row_hr_title">
          <div class="col-md-12">
            <div class="div_hr_title"><span class="txt_hr_title"><?=$txt_Type_petition_hr?></span></div>
            <div class="div_txt_title"><span class="txt_title"><?php
            if($lang == "1"){
              $compType_name = $re['compType_name'];
            }elseif ($lang == "2") {
              $compType_name = $re['compType_name_en'];
            }else {
              $compType_name = $re['compType_name'];
            }
             echo $compType_name;?></span></div>
          </div>
        </div>

        <div class="row row_hr_title">
          <div class="col-md-12">
            <div class="div_hr_title2"><span class="txt_hr_title2"><?=$txt_Petitioner_data?></span></div>
            <div class="div_txt_title2"><span class="txt_title2"><?php echo $re['complnt_name'];?></span></div>
          </div>
        </div>
      <?php if($re['applnt_name']!= ""){?>
        <div class="row row_hr_title2">
          <div class="col-md-12">
            <div class="div_hr_title3"><span class="txt_hr_title3"><?=$txt_Defendant_Information?></span></div>
            <div class="div_txt_title3"><span class="txt_title3"><?php echo $re['applnt_name'];?></span></div>
          </div>
        </div>
        <?php } ?>
    </div>
  </div> <!-- รายละเอียดเรื่องร้องเรียน -->

  <div class="panel panel-default appeal_panel">
    <div class="panel-body">
      <div class="row row_hr_detail">
        <div class="col-md-12">
            <?php if($re['prodType_id'] != 0){?>
              <div class="div_hr_detail"><span class="txt_hr_detail"><?=$txt_Type_goods?></span></div>
              <div class="div_txt_detail"><span class="txt_detail"><?php echo $prodType_name;?></span></div>
            <?php }else { ?>
              <div class="div_hr_detail"><span class="txt_hr_detail"><?=$txt_complaint?></span></div>
              <div class="div_txt_detail"><span class="txt_detail"><?php echo $incType_name;?></span></div>
            <?php } ?>
        </div>
      </div>

      <div class="row row_hr_detail">
        <div class="col-md-12">
          <div class="div_hr_detail2"><span class="txt_hr_detail2"><?=$txt_Bg_information?></span></div>
          <div class="div_txt_detail2"><span class="txt_detail2"><?php echo strip_tags($re['caseDtl_derivation']);?></span></div>
        </div>
      </div>

      <div class="row row_hr_detail">
        <div class="col-md-12">
          <div class="div_hr_detail3"><span class="txt_hr_detail3"><?=$txt_Damage_ex?></span></div>
          <div class="div_txt_detail3"><span class="txt_detail3"><?php echo $re['caseDtl_damage_val'];?>&nbsp;<?php echo $re['curren_name'];?></span></div>
        </div>
      </div>

      <div class="row row_hr_detail2">
        <div class="col-md-12">
          <div class="div_hr_detail4"><span class="txt_hr_detail4"><?=$txt_requirement?></span></div>
          <div class="div_txt_detail4"><span class="txt_detail4"><?php echo strip_tags($re['caseDtl_complnt_need']);?></span></div>
        </div>
      </div>
  </div>
</div> <!-- รายละเอียดเรื่องร้องเรียน -->

<div class="row row_hr_detail2">
  <div class="col-md-12">
    <div class="div_txt_detail5"><span class="txt_detail5"><?=$txt_Halt?></span></div>
  </div>
</div>

<div class="panel panel-default appeal_panel_min">
  <div class="panel-body">
    <div class="row row_hr_detail2">
      <div class="col-md-12">
        <div class="div_txt_detail6"><span class="txt_detail6"><?php echo $re['caseClose_title'];?> <?php if($lang == "1"){ echo "โดยที่";}elseif($lang == "2"){ echo "by";}else{ echo "โดยที่";}?> <?php echo $re['case_close_resultProcess'];?></span></div>
      </div>
    </div>
</div>
</div> <!-- รายละเอียดเรื่องร้องเรียน -->

  </div>
</div>
