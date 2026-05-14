<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="css/Newpanel.css">
<style>
  #submit_test{
    margin-top: 20px;
    margin-bottom: 40px;
    width: 100px;
    color: #fff !important;
  }
</style>
<!-- <pre>
  <?php print_r($_POST)?>
</pre> -->
<?php
if ($lang == 1) {
  $lang_01 = 'เป็นตัวแทนบริษัท';
  $lang_02 = 'ข้อมูลบริษัท';
  $lang_03 = 'เลขนิติบุคคล';
  $lang_04 = 'ชื่อบริษัทที่จดทะเบียน';
  $lang_05 = 'ประเภทธุรกิจ';
  $lang_06 = 'สาขา';
  $lang_07 = 'เบอร์โทรศัพท์';
  $lang_08 = 'ที่อยู่ติดต่อ';
  $lang_09 = 'ประเทศ';
  $lang_10 = 'ตำแหน่ง';
  $lang_11 = 'เว็บไซต์';
  $lang_12 = 'รหัสไปรษณีย์';
  $lang_13 = 'อื่นๆ';
  $lang_14 = 'บริษัทนำเข้า';
  $lang_15 = 'บริษัทส่งออก';
  $lang_16 = '--- เลือกประเทศ ---';
  $lang_17 = 'ยื่นเรื่องในนามบุคคลธรรมดา';
  $lang_18 = 'ข้อมูลบุคคล';
  $lang_19 = 'อาชีพ';
  $lang_20 = '(หากท่านเลือกยื่นเรื่องในนามบุคคลธรรมดา กระบวนการตรวจสอบจะใช้เวลานานกว่าปกติ)';
  $lang_21 = 'ชื่อ';
  $lang_22 = 'นามสกุล';
  $lang_23 = 'เลขบัตรประชาชน';
  $lang_24 = 'ตำแหน่ง';
  $lang_25 = 'ที่อยู่';
  $lang_26 = 'อีเมล';
} else {
  $lang_01 = 'As Company Representative';
  $lang_02 = 'Company Details';
  $lang_03 = 'Company Registration Number';
  $lang_04 = 'Company Name';
  $lang_05 = 'Type of Business';
  $lang_06 = 'Branch';
  $lang_07 = 'Telephone Number';
  $lang_08 = 'Company Address';
  $lang_09 = 'Country';
  $lang_10 = 'Position';
  $lang_11 = 'Website';
  $lang_12 = 'Post Code';
  $lang_13 = 'Other';
  $lang_14 = 'Import company';
  $lang_15 = 'Export company';
  $lang_16 = '--- Select country ---';
  $lang_17 = 'As Individual';
  $lang_18 = 'Personal Information';
  $lang_19 = 'Profession';
  $lang_20 = '(Submitting a petition as an individual is subject to more investigation and/or reconciliation time)';
  $lang_21 = 'Name';
  $lang_22 = 'Surname';
  $lang_23 = 'National ID';
  $lang_24 = 'Position';
  $lang_25 = 'Address';
  $lang_26 = 'E-mail';
}
?>
<?php
$type_id_box1 = $_POST['formSetId_a'];
$type_id_box2 = $_POST['formSetId_b'];
$type_id_box3 = $_POST['formSetId_c'];

// echo $type_id_box1 . " " . $type_id_box2 . " " . $type_id_box3;
?>
<div class="row invite_div_row">
  <div class="col-md-12">
    <input type="hidden" name="status_chk" class="status_chk" value="">
    <span class="icon_sound_invite"><img src="images/all_icon_DITP/icon_4.svg" style="width:30px;"></span>
    <span class="hr_invite_txt"><?=$txt_Start_petition?> <br style="display:none;"></span>
    <span class="chk_detail" style="color:#E74C3C; margin-left:210px; font-size:22px;"><?=$txt_accuracy?></span>
<iframe name="chk_invite" style="display:none;"></iframe>
  <form method="post" action="" id="chk_invite_step3" enctype="multipart/form-data" target="">
  <input type="hidden" class="rdi_compType_id" name="rdi_compType_id" value="<?php echo $_POST["rdi_compType_id"]?>">
  <input type="hidden" class="rdi_compTypeSub1" name="rdi_compTypeSub1" value="<?php echo $_POST["rdi_compTypeSub1"]?>">
  <input type="hidden" class="rdi_compTypeSub2" name="rdi_compTypeSub2" value="<?php echo $_POST["rdi_compTypeSub2"]?>">
  <input type="hidden" class="compType_other_txt" name="compType_other_txt" value="<?php echo $_POST["compType_other_txt"]?>">
  <input type="hidden" class="formSetId_a" name="formSetId_a" value="<?php echo $type_id_box1?>">
  <input type="hidden" class="formSetId_b" name="formSetId_b" value="<?php echo $type_id_box2?>">
  <input type="hidden" class="formSetId_c" name="formSetId_c" value="<?php echo $type_id_box3?>">
  <div class="invite_step3">
    <?php
    //หัวข้อที่ 1
    if($_POST["rdi_compTypeSub1"] == ""){ $rdi_compTypeSub1 = 0;}else{ $rdi_compTypeSub1 = $_POST["rdi_compTypeSub1"];}
    $sql_namefrom1 = "SELECT * FROM Form_Link_Complaint_Type WHERE compType_id = '".$_POST["rdi_compType_id"]."' AND compTypeSub1_id = '".$rdi_compTypeSub1."'  AND frmset_id = '$type_id_box1'";
    $query_namefrom1 = $conn->query($sql_namefrom1);
    $res1 = $query_namefrom1->fetch_assoc();

    //หัวข้อที่ 2
    if($_POST["rdi_compTypeSub1"] == ""){ $rdi_compTypeSub2 = 0;}else{ $rdi_compTypeSub2 = $_POST["rdi_compTypeSub1"];}
    $sql_namefrom2 = "SELECT * FROM Form_Link_Complaint_Type WHERE compType_id = '".$_POST["rdi_compType_id"]."' AND compTypeSub1_id = '".$rdi_compTypeSub2."'  AND frmset_id = '$type_id_box2'";
    $query_namefrom2 = $conn->query($sql_namefrom2);
    $res2 = $query_namefrom2->fetch_assoc();

    ?>

    <?php
    // $caseAttach_file_name = $_POST['caseAttach_file_name'];
    // foreach ($caseAttach_file_name as $value) {
      ?>
      <!-- <input type="hidden" name="file_name_hr[]" value="<?//=$value;?>"> -->
      <?php
    // }
    ?>
    <div class="panel panel-default panel_datetime">
      <div class="row">
        <div class="col-md-12 form_invite">
          <div class="hr_form_invite"><?=$txt_Formula?>
            <?php
            $sql = "SELECT * FROM `Complaint_Type` WHERE compType_id='".$_POST["rdi_compType_id"]."'";
            $query = $conn->query($sql);
            $re = $query->fetch_assoc();
            if($lang == "1"){ echo $re['compType_name'];}elseif($lang == "2"){ echo $re['compType_name_en'];}else{ echo $re['compType_name'];}
            ?>
            <input type="hidden" name="compType_section" value="<?=$re['compType_section']?>">
            <input type="hidden" name="compType_duration" value="<?=$re['compType_duration']?>">
        </div>
          <div class="txt_hr_form_invite">
          <?php
          $sql_t1 = "SELECT * FROM `Complaint_Type_Sub1` WHERE compTypeSub1_id='".$_POST["rdi_compTypeSub1"]."'";
          $query_t1 = $conn->query($sql_t1);
          $re1 = $query_t1->fetch_assoc();
          if($lang == "1"){ echo $re1['compTypeSub1_name'];}elseif($lang == "2"){ echo $re1['compTypeSub1_name_en'];}else{ echo $re1['compTypeSub1_name'];}
          ?>&nbsp;
          <?php
          $sql_t2 = "SELECT * FROM `Complaint_Type_Sub2` WHERE compTypeSub2_id='".$_POST["rdi_compTypeSub2"]."'";
          $query_t2 = $conn->query($sql_t2);
          $re2 = $query_t2->fetch_assoc();
          if($lang == "1"){ echo $re2['compTypeSub2_name'];}elseif($lang == "2"){ echo $re2['compTypeSub2_name_en'];}else{ echo $re2['compTypeSub2_name'];}
          ?>
        </div>
        </div>
      </div>
    </div>

    <div class="panel panel-default panel_datetime">
      <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-7 date_invite"><span class="txt_date_invite"><?=$txt_Date?> : <?php echo date('d/m/Y',time()); ?></span></div>
        <div class="col-md-6 col-sm-6 col-xs-5 time_invite"><span class="txt_time_invite"><?=$txt_Time?> : <?php echo date('H:i',time()); ?></span></div>
      </div>
    </div>

    <div class="panel panel-default">
      <div class="panel-heading hr_invite_panel">
        <span class="hr_input_detail"><?php if($lang == "2"){echo $res1['frmset_name_en'];}else{ echo $res1['frmset_name'];}?></span>
        <a data-toggle="collapse" href="#collapse_1" class="collapse_1"><span class="icon_hide_detail_invite"></span></a>
      </div>
      <div id="collapse_1" class="panel-collapse collapse in">
      <div class="panel-body">
        <div class="row div_name_office_invite">
          <div class="col-md-12">
            <div class="hr_invite">
              <span class="icon_invite_person"><img src="images/icon_invite_person.png"></span>
              <span class="hr_invite_title"><?=$txt_Petitioner?></span>
            </div>
            <div class="hr_invite_name_div">
              <!-- <span class="hr_invite_name"><?php echo $_POST['applnt_firstname_IdxFs_'.$type_id_box1]?>&nbsp;&nbsp;&nbsp;<?php echo $_POST['applnt_lastname_IdxFs_'.$type_id_box1]?></span> -->
              <input type="hidden" name="applnt_firstname" value="<?=$_POST['applnt_firstname_IdxFs_'.$type_id_box1];?>">
              <input type="hidden" name="applnt_lastname" value="<?=$_POST['applnt_lastname_IdxFs_'.$type_id_box1];?>">
              <input type="hidden" name="applnt_ident" value="<?=$_POST['applnt_ident_IdxFs_'.$type_id_box1];?>">
              <input type="hidden" name="applnt_email" value="<?=$_POST['applnt_email_IdxFs_'.$type_id_box1];?>">
              <input type="hidden" name="applnt_career" value="<?=$_POST['applnt_career_IdxFs_'.$type_id_box1];?>">
              <input type="hidden" name="applnt_address" value="<?=$_POST['applnt_address_IdxFs_'.$type_id_box1];?>">
              <input type="hidden" name="applnt_prov_id" value="<?=$_POST['applnt_prov_id_IdxFs_'.$type_id_box1];?>">
              <input type="hidden" name="applnt_zipcode" value="<?=$_POST['applnt_zipcode_IdxFs_'.$type_id_box1];?>">
              <input type="hidden" name="applnt_tel" value="<?=$_POST['applnt_tel_IdxFs_'.$type_id_box1];?>">
              <input type="hidden" name="applnt_mobile" value="<?=$_POST['applnt_mobile_IdxFs_'.$type_id_box1];?>">
              <input type="hidden" name="applntOrg_import_export" value="<?=$_POST['applntOrg_import_export_IdxFs_'.$type_id_box1];?>">
              <?php
              if($_POST['applnt_gender_IdxFs_'.$type_id_box1] == 1){
                $sex = "m";
              }else {
                $sex = "f";
              }
              ?>
              <input type="hidden" name="sex" value="<?=$_POST['applnt_gender_IdxFs_'.$type_id_box1];?>">
              <input type="hidden" name="applnt_gender" value="<?=$sex;?>">
              <input type="hidden" name="applnt_type" value="<?=$_POST['personType'];?>" <?=$type_id_box1?>>
                <?php if($_POST['applntOrg_show'] == ""){ ?>
              <input type="hidden" name="applnt_country_id" value="<?=$_POST['applnt_country_id_IdxFs_'.$type_id_box1];?>">
                <?php } ?>
            </div>

            <?php if($_POST['applnt_type_IdxFs_'.$type_id_box1] == "1" && $_POST['applntOrg_show'] == ""){ ?>
              <div class="icon_invite_home_div">
                <span class="icon_invite_home"><img src="images/icon_invite_home.png"></span>
                <span class="hr_invite_company"><?=$txt_Registered_company?></span>
              </div>
              <div class="hr_invite_company_name_div">
                <span class="hr_invite_company_name"><?php if($_POST['applntOrg_name_IdxFs_'.$type_id_box1]==""){echo "-";}else{echo $_POST['applntOrg_name_IdxFs_'.$type_id_box1];}?></span>
              </div>
            <?php } ?>
            <?php if($_POST['personType'] == "1"){ ?>
              <div class="hr_invite_company_name_div">
                <input type="hidden" name="applntOrg_name" value="<?php echo $_POST['appint_personinfo1'][1] ?>">
                <input type="hidden" name="applntOrg_branch" value="<?php echo $_POST['appint_personinfo1'][3] ?>">
                <input type="hidden" name="applntOrg_trade_number" value="<?php echo $_POST['appint_personinfo1'][0] ?>">
                <input type="hidden" name="applntOrg_address" value="<?php echo $_POST['appint_personinfo1'][7] ?>">
                <input type="hidden" name="applntOrg_prov_id" value="<?=$_POST['applntOrg_prov_id_IdxFs_'.$type_id_box1];?>">
                <input type="hidden" name="applntOrg_zipcode" value="<?php echo $_POST['appint_personinfo1'][9] ?>">
                <input type="hidden" name="applntOrg_tel" value="<?php echo $_POST['appint_personinfo1'][5] ?>">
                <input type="hidden" name="applntOrg_web" value="<?php echo $_POST['appint_personinfo1'][6] ?>">
              </div>
            <?php } ?>
            
            <input type='hidden' name='Appint_personDetail' value="<?php echo htmlentities(serialize($_POST['appint_personinfo'])); ?>"/>
            <input type='hidden' name='Appint_personedit' value="<?php echo htmlentities(serialize($_POST)); ?>"/>

            <div class="Newpanel-header">
              <div class="row">
                  <div class="collapse in" id="multiCollapse">
                  <input type="hidden" name="appint_personinfo[]" value="<?php echo $_POST['appint_personinfo'][0]?>">
                  <input type="hidden" name="appint_personinfo[]" value="<?php echo $_POST['appint_personinfo'][1]?>">
                    <div class="card card-body">
                      <div class="row flexcenter" style="margin-left:0px; margin-right:0px;">
                        <div class="col-sm-2">
                        <?php echo $lang_21?>
                        </div>
                        <div class="col-sm-4">
                          <input type="text" class="form-control" id="" name="appint_personinfo[]" value="<?php echo $_POST['appint_personinfo'][2]?>" disabled>
                        </div>
                        <div class="col-sm-2 text-center">
                          <?php echo $lang_22?>
                        </div>
                        <div class="col-sm-4">
                          <input type="text" class="form-control" id="" name="appint_personinfo[]" value="<?php echo $_POST['appint_personinfo'][3]?>" disabled>
                        </div>
                      </div>
                      <div class="row flexcenter" style="margin-left:0px; margin-right:0px; margin-top: 8px;">
                        <div class="col-sm-2">
                          <?php echo $lang_23?>
                        </div>
                        <div class="col-sm-4">
                          <input type="text" class="form-control" id="" name="appint_personinfo[]" value="<?php echo $_POST['appint_personinfo'][4]?>" disabled>
                        </div>
                        <!-- <div class="col-sm-2 text-center">
                          <?php 
                            if($_POST['appint_personinfo'][1] == '0'){
                              echo $lang_19;
                            }else{
                              echo $lang_24;
                            }
                          ?>
                        </div>
                        <div class="col-sm-4">
                          <input type="text" class="form-control" id="" name="appint_personinfo[]" value="<?php echo $_POST['appint_personinfo'][5]?>" disabled>
                        </div> -->
                      </div>
                      <div class="row flexcenter" style="margin-left:0px; margin-right:0px; margin-top: 8px;">
                        <div class="col-sm-2">
                          <?php echo $lang_07?>
                        </div>
                        <div class="col-sm-4">
                          <input type="text" class="form-control" id="" name="appint_personinfo[]" value="<?php echo $_POST['appint_personinfo'][5]?>" disabled>
                          <input type="hidden" name="applnt_mobile_country" value="<?=$_POST['applnt_mobile_country'];?>">
                          <input type="hidden" name="applnt_mobile_code" value="<?=$_POST['applnt_mobile_code'];?>">
                        </div>
                        <div class="col-sm-2 text-center">
                          <?php echo $lang_26?> 
                        </div>
                        <div class="col-sm-4">
                          <input type="text" class="form-control" id="" name="appint_personinfo[]" value="<?php echo $_POST['appint_personinfo'][6]?>" disabled>
                        </div>
                      </div>
                      <div class="row flexcenternew" style="margin-left:0px; margin-right:0px; margin-top: 8px;">
                        <div class="col-sm-2">
                          <?php echo $lang_25?>
                        </div>
                        <div class="col-sm-10" style="padding-left: 11px;">
                          <textarea rows="4" class="form-control" name="appint_personinfo[]" disabled><?php echo $_POST['appint_personinfo'][7]?></textarea>
                        </div>
                      </div>
                      <div class="row flexcenter" style="margin-left:0px; margin-right:0px; margin-top: 8px;">
                        <div class="col-sm-2 ">
                          <?php echo $lang_09?>
                        </div>
                        <div class="col-sm-4">
                          <input type="hidden" class="form-control" id="" name="appint_personinfo[]" value="<?php echo $_POST['appint_personinfo'][8]?>" disabled>
                          <input type="text" class="form-control" id="" name="" value="<?php echo $_POST['appint_personinfo'][10]?>" disabled>
                        </div>
                        <div class="col-sm-2 text-center">
                          <?php echo $lang_12?>
                        </div>
                        <div class="col-sm-4 ">
                          <input type="text" class="form-control" name="appint_personinfo[]" onkeypress="onlynum_validate(event)" value="<?php echo $_POST['appint_personinfo'][9]?>" disabled> 
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
            

            <?php if($_POST['applntOrg_show'] != ""){ ?>
              <?php 
                if($_POST['rdi_compTypeSub1'] == 1){
                  ?>
                    <div class="Newpanel-body" id="Newpanel-value" data-id="1">
                      <input type='hidden' name='Org_Allvalue' value="<?php echo htmlentities(serialize($_POST)); ?>"/>
                      <input type='hidden' name='Appint_OrgSelect' value="<?php echo $_POST['applntOrg_nameSelect']; ?>"/>
                    <?php
                      if($_POST['applntOrg_nameSelect'] == 1){
                    ?>
                      <input type='hidden' name='Represent_Allvalue' value="<?php echo htmlentities(serialize($_POST['appint_personinfo1'])); ?>"/>
                      <input type='hidden' name='OrgRepresent_CountryID' value="<?php echo $_POST['applnt_countryid_idx']; ?>"/>
                      <div class="form-check">
                        <div class="flexcenter">
                          <input class="form-check-input Checkboxagent" type="checkbox" value="" id="" checked disabled>
                          <label class="form-check-label" for="CheckboxagentDefault">
                              <?php echo $lang_01?>
                          </label>
                        </div>
                        <div class="collapse in" id="collapseagent">
                          <div class="card card-body">
                            <div class="card-header flexcenter">
                              <i class="bi bi-building fa-2x"></i>
                              <span><?php echo $lang_02?></span>
                            </div>
                            <div class="Underlineborder"></div>
                            <div class="card-content">
                              <div class="row flexcenter">
                                <div class="col-sm-2">
                                  <?php echo $lang_03;?><span style="color:#E74C3C;">*</span>
                                </div>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control" id="corporatenumber" disabled value="<?php echo $_POST['appint_personinfo1'][0] ?>"> 
                                </div>
                              </div>
                              <div class="row flexcenter">
                                <div class="col-sm-2">
                                  <?php echo $lang_04;?><span style="color:#E74C3C;">*</span>
                                </div>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control" disabled value="<?php echo $_POST['appint_personinfo1'][1] ?>"> 
                                </div>
                              </div>
                              <div class="row flexcenter">
                                <div class="col-sm-2">
                                  <?php echo $lang_05;?><span style="color:#E74C3C;">*</span>
                                </div>
                                <div class="col-sm-10 flexcenter">
                                    <select class="form-select form-select-lg mb-3" id="SelectType_Business" disabled>
                                      <option value="0"><?php echo $lang_13;?></option>
                                      <option value="1"><?php echo $lang_14;?></option>
                                      <option value="2"><?php echo $lang_15;?></option>
                                    </select>
                                    <input class="" type="text" id="InputType_Business" disabled>
                                </div>
                              </div>
                              <div class="row flexcenter">
                                <div class="col-sm-2">
                                  <?php echo $lang_06;?>
                                </div>
                                <div class="col-sm-4" style="margin-left: 3px;">
                                  <input type="text" class="form-control" disabled value="<?php echo $_POST['Represent_value'][4] ?>"> 
                                </div>
                                <div class="col-sm-2 text-right">
                                  <?php echo $lang_07;?><span style="color:#E74C3C;">*</span>
                                </div>
                                <div class="col-sm-4" style="margin-left: 3px;">
                                  <input type="text" class="form-control" disabled value="<?php echo $_POST['Represent_value'][5] ?>"> 
                                </div>
                              </div>
                              <div class="row flexcenter">
                                <div class="col-sm-2">
                                  <?php echo $lang_11;?><span style="color:#E74C3C;">*</span>
                                </div>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control" disabled value="<?php echo $_POST['Represent_value'][6] ?>"> 
                                </div>
                              </div>
                              <div class="row flexcenternew">
                                <div class="col-sm-2">
                                  <?php echo $lang_08;?><span style="color:#E74C3C;">*</span>
                                </div>
                                <div class="col-sm-10">
                                    <textarea rows="4" class="form-control applntOrg_address" disabled><?php echo $_POST['Represent_value'][7] ?></textarea>
                                </div>
                              </div>
                              <div class="row flexcenter">
                                <div class="col-sm-2">
                                  <?php echo $lang_09;?><span style="color:#E74C3C;">*</span>
                                </div>
                                <div class="col-sm-4" style="margin-left: 3px;">
                                  <input type="text" class="form-control" disabled value="<?php echo $_POST['applntOrg_country']?>"> 
                                </div>
                                <div class="col-sm-2 textend">
                                  <?php echo $lang_12;?><span style="color:#E74C3C;">*</span>
                                </div>
                                <div class="col-sm-4">
                                  <input type="text" class="form-control" disabled value="<?php echo $_POST['Represent_value'][8] ?>"> 
                                </div>
                            </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <?php
                      }else{
                      ?>
                      <input type='hidden' name='Naturalperson_Allvalue' value="<?php echo htmlentities(serialize($_POST['Natural_person'])); ?>"/>
                      <div class="form-check">
                        <div class="flexcenter">
                          <input class="form-check-input Checkboxperson" type="checkbox" value="" id="" checked disabled>
                          <label class="form-check-label" for="CheckboxpersonDefault">
                            <?php echo $lang_17;?>
                          </label>
                        </div>
                        <div class="collapse in" id="collapseperson">
                          <div class="card card-body">
                              <div class="card-header flexcenter">
                              <i class="bi bi-person-fill fa-2x"></i>
                              <span><?php echo $lang_18;?></span>
                              </div>
                              <div class="Underlineborder"></div>
                              <div class="card-content">
                              <div class="row flexcenter">
                                  <div class="col-sm-2">
                                    <?php echo $lang_19;?>
                                  </div>
                                  <div class="col-sm-10">
                                    <input type="text" class="form-control" id="" disabled value="<?php echo $_POST['Natural_person'][0]?>"> 
                                  </div>
                              </div>
                              </div>
                              <span style="margin-bottom: 5px; color: red;"><?php echo $lang_20;?></span>
                          </div>
                        </div>
                      </div>
                      <?php }?>
                    </div>
                  <?php
                }else{ ?>
                  <div class="Newpanel-body" id="Newpanel-value" data-id="1">
                  <input type='hidden' name='Org_Allvalue' value="<?php echo htmlentities(serialize($_POST)); ?>"/>
                  <input type='hidden' name='Appint_OrgSelect' value="<?php echo $_POST['applntOrg_nameSelect']; ?>"/>
                <?php
                  if($_POST['personType'] == 1){
                ?>
                  <input type='hidden' name='Represent_Allvalue' value="<?php echo htmlentities(serialize($_POST['appint_personinfo1'])); ?>"/>
                  <input type='hidden' name='OrgRepresent_CountryID' value="<?php echo $_POST['applnt_countryid_idx']; ?>"/>
                  <div class="form-check">
                    <div class="flexcenter">
                      <input class="form-check-input Checkboxagent" type="checkbox" value="1" id="CheckboxpersonDefault" name="appint_personType[]" checked disabled>
                      <label class="form-check-label" for="CheckboxagentDefault">
                          <?php echo $lang_01?>
                      </label>
                    </div>
                    <div class="collapse in" id="collapseagent">
                      <div class="card card-body">
                        <div class="card-header flexcenter">
                          <i class="bi bi-building fa-2x"></i>
                          <span><?php echo $lang_02?></span>
                        </div>
                        <div class="Underlineborder"></div>
                        <div class="card-content">
                          <div class="row flexcenter">
                            <div class="col-sm-2">
                              <?php echo $lang_03;?>
                            </div>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" id="corporatenumber" name="appint_personinfo1[]" disabled value="<?php echo $_POST['appint_personinfo1'][0] ?>"> 
                            </div>
                          </div>
                          <div class="row flexcenter">
                            <div class="col-sm-2">
                              <?php echo $lang_04;?>
                            </div>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" disabled name="appint_personinfo1[]" value="<?php echo $_POST['appint_personinfo1'][1] ?>"> 
                            </div>
                          </div>
                          <div class="row flexcenter">
                            <div class="col-sm-2">
                              <?php echo $lang_05;?>
                            </div>
                            <div class="col-sm-2 flexcenter">
                                <select class="custom-select " id="appint_personcomtype" disabled name="appint_personinfo1[]">
                                  <option value="0" <?php if($_POST['appint_personinfo1'][2] == 0) {echo 'selected';} ?>><?php echo $lang_13;?></option>
                                  <option value="1" <?php if($_POST['appint_personinfo1'][2] == 1) {echo 'selected';} ?>><?php echo $lang_14;?></option>
                                  <option value="2" <?php if($_POST['appint_personinfo1'][2] == 2) {echo 'selected';} ?>><?php echo $lang_15;?></option>
                                </select>
                            </div>
                            <?php if($_POST['appint_personinfo1'][2] == 0){ ?>
                              <div class="col-sm-4" id="appint_personinfo13">
                                <input type="text" class="form-control"  value="<?php echo $_POST['appint_personinfo13'] ?>" name="appint_personinfo13" readonly="readonly" />
                              </div>
                            <?php } ?>
                          </div>
                          <div class="row flexcenter">
                            <div class="col-sm-2">
                              <?php echo $lang_06;?>
                            </div>
                            <div class="col-sm-4" style="margin-left: 3px;">
                              <input type="text" class="form-control" name="appint_personinfo1[]" disabled value="<?php echo $_POST['appint_personinfo1'][3] ?>"> 
                            </div>
                            <div class="col-sm-2 text-right">
                              <?php echo $lang_24;?>
                            </div>
                            <div class="col-sm-4" style="margin-left: 3px;">
                              <input type="text" class="form-control" name="appint_personinfo1[]" disabled value="<?php echo $_POST['appint_personinfo1'][4] ?>"> 
                            </div>
                          </div>
                          <div class="row flexcenter">
                            <div class="col-sm-2">
                              <?php echo $lang_07;?>
                            </div>
                            <div class="col-sm-4">
                              <input type="text" class="form-control" name="appint_personinfo1[]" disabled value="<?php echo $_POST['appint_personinfo1'][5] ?>"> 
                            </div>
                            <div class="col-sm-2 text-right">
                              <?php echo $lang_11;?>
                            </div>
                            <div class="col-sm-4" style="margin-left: 3px;">
                              <input type="text" class="form-control" name="appint_personinfo1[]" disabled value="<?php echo $_POST['appint_personinfo1'][6] ?>"> 
                            </div>
                          </div>
                          <div class="row flexcenternew">
                            <div class="col-sm-2">
                              <?php echo $lang_08;?>
                            </div>
                            <div class="col-sm-10">
                                <textarea rows="4" class="form-control applntOrg_address" name="appint_personinfo1[]" disabled><?php echo $_POST['appint_personinfo1'][7] ?></textarea>
                            </div>
                          </div>
                          <div class="row flexcenter">
                            <div class="col-sm-2">
                              <?php echo $lang_09;?>
                            </div>
                            <div class="col-sm-4">
                              <input type="hidden" class="form-control" id="" name="appint_personinfo1[]" value="<?php echo $_POST['appint_personinfo1'][8]?>" disabled>
                              <input type="text" class="form-control" id="" name="appint_personinfo1[]" value="<?php echo $_POST['appint_personinfo'][10]?>" disabled>
                            </div>
                            <div class="col-sm-2 textend">
                              <?php echo $lang_12;?>
                            </div>
                            <div class="col-sm-4">
                              <input type="text" class="form-control" name="appint_personinfo1[]" disabled value="<?php echo $_POST['appint_personinfo1'][9] ?>"> 
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php
                  }else{
                  ?>
                  <input type='hidden' name='Naturalperson_Allvalue' value="<?php echo htmlentities(serialize($_POST['appint_personinfo2'])); ?>"/>
                  <div class="form-check">
                    <div class="flexcenter">
                      <input class="form-check-input Checkboxperson" type="checkbox" value="2" id="CheckboxpersonDefault" name="appint_personType[]" checked disabled>
                      <label class="form-check-label" for="CheckboxpersonDefault">
                        <?php echo $lang_17;?>
                      </label>
                    </div>
                    <div class="collapse in" id="collapseperson">
                      <div class="card card-body">
                          <div class="card-header flexcenter">
                          <i class="bi bi-person-fill fa-2x"></i>
                          <span><?php echo $lang_18;?></span>
                          </div>
                          <div class="Underlineborder"></div>
                          <div class="card-content">
                          <div class="row flexcenter">
                              <div class="col-sm-2">
                                <?php echo $lang_19;?>
                              </div>
                              <div class="col-sm-10">
                                <input type="text" class="form-control" id="" name="appint_personinfo2" value="<?php echo $_POST['appint_personinfo2'][0]?>" readonly="readonly"> 
                              </div>
                          </div>
                          </div>
                          <span style="margin-bottom: 5px; color: red;"><?php echo $lang_20;?></span>
                      </div>
                    </div>
                  </div>
                  <?php }?>
                </div>
                <?php
                }
              ?>
              <!-- <div class="row">
                <div class="panel-body">
                <div class="panel panel-default" style="margin-top: 20px;">
                <div class="panel-body">

                  <div class="row div_branch_invite">
                    <div class="col-md-3 col-sm-4"><?=$txt_Company_name_ex?><span class="txt_xr txt_xr_detail">:</span></div>
                    <div class="col-md-4 col-sm-8 txt_invite_detail"><?php if($_POST['applntOrg_name_IdxFs_'.$type_id_box1]==""){echo "-";}else{echo $_POST['applntOrg_name_IdxFs_'.$type_id_box1];} ?></div>
                    <input type="hidden" name="applntOrg_name" value="<?=$_POST['applntOrg_name_IdxFs_'.$type_id_box1];?>">
                    <div class="col-md-5"></div>
                  </div>

                  <div class="row div_branch_invite">
                    <div class="col-md-3 col-sm-4"><?=$txt_Branch?><span class="txt_xr txt_xr_detail">:</span></div>
                    <div class="col-md-4 col-sm-8 txt_invite_detail"><?php if($_POST['applntOrg_branch_IdxFs_'.$type_id_box1]==""){echo "-";}else{echo $_POST['applntOrg_branch_IdxFs_'.$type_id_box1];}?></div>
                    <input type="hidden" name="applntOrg_branch" value="<?=$_POST['applntOrg_branch_IdxFs_'.$type_id_box1];?>">
                    <div class="col-md-5"></div>
                  </div>

                  <div class="row div_branch_invite">
                    <div class="col-md-3 col-sm-4"><?=$txt_Position?><span class="txt_xr txt_xr_detail">:</span></div>
                    <div class="col-md-4 col-sm-8 txt_invite_detail"><?php if($_POST['applntOrg_position_IdxFs_'.$type_id_box1]==""){echo "-";}else{echo $_POST['applntOrg_position_IdxFs_'.$type_id_box1];}?></div>
                    <input type="hidden" name="applntOrg_position" value="<?=$_POST['applntOrg_position_IdxFs_'.$type_id_box1];?>">
                    <div class="col-md-5"></div>
                  </div>

                  <div class="row div_branch_invite">
                    <div class="col-md-3 col-sm-4"><?=$txt_Registration_Number?><span class="txt_xr txt_xr_detail">:</span></div>
                    <div class="col-md-4 col-sm-8 txt_invite_detail"><?php if($_POST['applntOrg_trade_number_IdxFs_'.$type_id_box1]==""){echo "-";}else{echo $_POST['applntOrg_trade_number_IdxFs_'.$type_id_box1];}?></div>
                    <input type="hidden" name="applntOrg_trade_number" value="<?=$_POST['applntOrg_trade_number_IdxFs_'.$type_id_box1];?>">
                    <div class="col-md-5"></div>
                  </div>

                  <div class="row div_branch_invite">
                    <div class="col-md-3 col-sm-4"><?=$txt_Address?><span class="txt_xr txt_xr_detail">:</span></div>
                    <div class="col-md-4 col-sm-8 txt_invite_detail"><?php if($_POST['applntOrg_address_IdxFs_'.$type_id_box1]==""){echo "-";}else{echo $_POST['applntOrg_address_IdxFs_'.$type_id_box1];}?></div>
                    <input type="hidden" name="applntOrg_address" value="<?=$_POST['applntOrg_address_IdxFs_'.$type_id_box1];?>">
                    <div class="col-md-5"></div>
                  </div>

                  <div class="row div_branch_invite">
                    <div class="col-md-3 col-sm-4"><?=$txt_Telephone_number?><span class="txt_xr txt_xr_detail">:</span></div>
                    <div class="col-md-4 col-sm-8 txt_invite_detail"><?php if($_POST['applntOrg_tel_IdxFs_'.$type_id_box1]==""){echo "-";}else{echo $_POST['applntOrg_tel_IdxFs_'.$type_id_box1];}?></div>
                    <input type="hidden" name="applntOrg_tel" value="<?=$_POST['applntOrg_tel_IdxFs_'.$type_id_box1];?>">
                    <div class="col-md-5"></div>
                  </div>

                  <div class="row div_branch_invite">
                    <div class="col-md-3 col-sm-4"><?=$txt_Fax_number?><span class="txt_xr txt_xr_detail">:</span></div>
                    <div class="col-md-4 col-sm-8 txt_invite_detail"><?php if($_POST['applntOrg_fax_IdxFs_'.$type_id_box1]==""){echo "-";}else{echo $_POST['applntOrg_fax_IdxFs_'.$type_id_box1];}?></div>
                    <input type="hidden" name="applntOrg_fax" value="<?=$_POST['applntOrg_fax_IdxFs_'.$type_id_box1];?>">
                    <div class="col-md-5"></div>
                  </div>

                  <?php if($_POST['applnt_country_id_IdxFs_'.$type_id_box1] == 162){?>
                  <div class="row div_branch_invite">
                    <div class="col-md-3 col-sm-4"><?=$txt_Province?><span class="txt_xr txt_xr_detail">:</span></div>
                    <div class="col-md-4 col-sm-8 txt_invite_detail">
                      <?php
                      $sql_po = "SELECT * FROM Province WHERE prov_id = '".$_POST['applntOrg_prov_id_IdxFs_'.$type_id_box1]."'";
                      $query_po = $conn->query($sql_po);
                      $rsa = $query_po->fetch_assoc();
                      if($rsa['prov_name']==""){echo "-";}else{echo $rsa['prov_name'];}
                      ?></div>
                    <input type="hidden" name="applntOrg_prov_id" value="<?=$_POST['applntOrg_prov_id_IdxFs_'.$type_id_box1];?>">
                    <div class="col-md-5"></div>
                  </div>
                  <?php } ?>
                  <div class="row div_branch_invite">
                    <div class="col-md-3 col-sm-4"><?=$txt_Postcode?><span class="txt_xr txt_xr_detail">:</span></div>
                    <div class="col-md-4 col-sm-8 txt_invite_detail"><?php if($_POST['applntOrg_zipcode_IdxFs_'.$type_id_box1]==""){echo "-";}else{echo $_POST['applntOrg_zipcode_IdxFs_'.$type_id_box1];}?></div>
                    <input type="hidden" name="applntOrg_zipcode" value="<?=$_POST['applntOrg_zipcode_IdxFs_'.$type_id_box1];?>">
                    <div class="col-md-5"></div>
                  </div>

                  <div class="row div_branch_invite">
                    <div class="col-md-3 col-sm-4"><?=$txt_Country?><span class="txt_xr txt_xr_detail">:</span></div>
                    <div class="col-md-4 col-sm-8 txt_invite_detail">
                      <?php
                    $country = $_POST['applnt_country_id_IdxFs_'.$type_id_box1];
                    $sql = "SELECT * FROM Country WHERE id = '$country'";
                    $query = $conn->query($sql);
                    $re = $query->fetch_assoc();
                    if($re['name']==""){echo "-";}else{echo $re['name'];}
                    ?></div>
                    <input type="hidden" name="applnt_country_id" value="<?=$_POST['applnt_country_id_IdxFs_'.$type_id_box1];?>">
                    <div class="col-md-5"></div>
                  </div>
                </div>
              </div>
              </div>
            </div> -->
            <?php
              }else if($_POST['rdi_compTypeSub1'] == 1){
                ?>
                  <div class="Newpanel-body" id="Newpanel-value" data-id="1">
                    <input type='hidden' name='Org_Allvalue' value="<?php echo htmlentities(serialize($_POST)); ?>"/>
                    <input type='hidden' name='Appint_OrgSelect' value="<?php echo $_POST['applntOrg_nameSelect']; ?>"/>
                  <?php
                    if($_POST['applntOrg_nameSelect'] == 1){
                  ?>
                    <input type='hidden' name='Represent_Allvalue' value="<?php echo htmlentities(serialize($_POST['appint_personinfo1'])); ?>"/>
                    <input type='hidden' name='OrgRepresent_CountryID' value="<?php echo $_POST['applnt_countryid_idx']; ?>"/>
                    <div class="form-check">
                      <div class="flexcenter">
                        <input class="form-check-input Checkboxagent" type="checkbox" value="1" id="CheckboxpersonDefault" name="appint_personType[]" checked disabled>
                        <label class="form-check-label" for="CheckboxagentDefault">
                            <?php echo $lang_01?>
                        </label>
                      </div>
                      <div class="collapse in" id="collapseagent">
                        <div class="card card-body">
                          <div class="card-header flexcenter">
                            <i class="bi bi-building fa-2x"></i>
                            <span><?php echo $lang_02?></span>
                          </div>
                          <div class="Underlineborder"></div>
                          <div class="card-content">
                          <div class="row flexcenter">
                              <div class="col-sm-2">
                                <?php echo $lang_03;?>
                              </div>
                              <div class="col-sm-10">
                                <input type="text" class="form-control" id="corporatenumber" disabled value="<?php echo $_POST['appint_personinfo1'][0] ?>" name="appint_personinfo1[]"> 
                              </div>
                            </div>
                            <div class="row flexcenter">
                              <div class="col-sm-2">
                                <?php echo $lang_04;?>
                              </div>
                              <div class="col-sm-10">
                                <input type="text" class="form-control" disabled value="<?php echo $_POST['appint_personinfo1'][1] ?>" name="appint_personinfo1[]"> 
                              </div>
                            </div>
                            <div class="row flexcenter">
                              <div class="col-sm-2">
                                <?php echo $lang_05;?>
                              </div>
                              <div class="col-sm-2 flexcenter">
                                  <select class="custom-select " id="appint_personcomtype" disabled name="appint_personinfo1[]">
                                    <option value="0" <?php if($_POST['appint_personinfo1'][2] == 0) {echo 'selected';} ?>><?php echo $lang_13;?></option>
                                    <option value="1" <?php if($_POST['appint_personinfo1'][2] == 1) {echo 'selected';} ?>><?php echo $lang_14;?></option>
                                    <option value="2" <?php if($_POST['appint_personinfo1'][2] == 2) {echo 'selected';} ?>><?php echo $lang_15;?></option>
                                  </select>
                              </div>
                              <?php if($_POST['appint_personinfo1'][2] == 0){ ?>
                                <div class="col-sm-4" id="appint_personinfo13">
                                  <input type="text" class="form-control" value="<?php echo $_POST['appint_personinfo13'] ?>" name="appint_personinfo13" readonly="readonly" />
                                </div>
                              <?php } ?>
                            </div>
                            <div class="row flexcenter">
                              <div class="col-sm-2">
                                <?php echo $lang_06;?>
                              </div>
                              <div class="col-sm-4" style="margin-left: 3px;">
                                <input type="text" class="form-control" disabled value="<?php echo $_POST['appint_personinfo1'][3] ?>" name="appint_personinfo1[]"> 
                              </div>
                              <div class="col-sm-2 text-right">
                                <?php echo $lang_24;?>
                              </div>
                              <div class="col-sm-4" style="margin-left: 3px;">
                                <input type="text" class="form-control" disabled value="<?php echo $_POST['appint_personinfo1'][4] ?>" name="appint_personinfo1[]"> 
                              </div>
                            </div>
                            <div class="row flexcenter">
                              <div class="col-sm-2">
                                <?php echo $lang_07;?>
                              </div>
                              <div class="col-sm-4">
                                <input type="text" class="form-control" disabled value="<?php echo $_POST['appint_personinfo1'][5] ?>" name="appint_personinfo1[]"> 
                                <input type="hidden" name="applntOrg_mobile_country" value="<?=$_POST['applntOrg_mobile_country'];?>">
                                <input type="hidden" name="applntOrg_mobile_code" value="<?=$_POST['applntOrg_mobile_code'];?>">
                              </div>
                              <div class="col-sm-2 text-right">
                                <?php echo $lang_11;?>
                              </div>
                              <div class="col-sm-4" style="margin-left: 3px;">
                                <input type="text" class="form-control" disabled value="<?php echo $_POST['appint_personinfo1'][6] ?>" name="appint_personinfo1[]"> 
                              </div>
                            </div>
                            <div class="row flexcenternew">
                              <div class="col-sm-2">
                                <?php echo $lang_08;?>
                              </div>
                              <div class="col-sm-10">
                                  <textarea rows="4" class="form-control applntOrg_address" name="appint_personinfo1[]" disabled><?php echo $_POST['appint_personinfo1'][7] ?></textarea>
                              </div>
                            </div>
                            <div class="row flexcenter">
                              <div class="col-sm-2">
                                <?php echo $lang_09;?>
                              </div>
                              <div class="col-sm-4">
                                <input type="hidden" class="form-control" id="" name="appint_personinfo1[]" value="<?php echo $_POST['appint_personinfo1'][8]?>" disabled>
                                <input type="text" class="form-control" id="" name="appint_personinfo1[]"  value="<?php echo $_POST['appIntOrg_countryname']?>" disabled>
                              </div>
                              <div class="col-sm-2 textend">
                                <?php echo $lang_12;?>
                              </div>
                              <div class="col-sm-4">
                                <input type="text" class="form-control" disabled name="appint_personinfo1[]" value="<?php echo $_POST['appint_personinfo1'][9] ?>"> 
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php
                    }else{
                    ?>
                    <input type='hidden' name='Naturalperson_Allvalue' value="<?php echo htmlentities(serialize($_POST['appint_personinfo2'])); ?>"/>
                    <div class="form-check">
                      <div class="flexcenter">
                        <input class="form-check-input Checkboxperson" type="checkbox" value="1" id="CheckboxpersonDefault" name="appint_personType[]" checked disabled>
                        <label class="form-check-label" for="CheckboxpersonDefault">
                          <?php echo $lang_17;?>
                        </label>
                      </div>
                      <div class="collapse in" id="collapseperson">
                        <div class="card card-body">
                            <div class="card-header flexcenter">
                            <i class="bi bi-person-fill fa-2x"></i>
                            <span><?php echo $lang_18;?></span>
                            </div>
                            <div class="Underlineborder"></div>
                            <div class="card-content">
                            <div class="row flexcenter">
                                <div class="col-sm-2">
                                  <?php echo $lang_19;?>
                                </div>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control" id="" name="appint_personinfo2" disabled value="<?php echo $_POST['appint_personinfo2'][0]?>"> 
                                </div>
                            </div>
                            </div>
                            <span style="margin-bottom: 5px; color: red;"><?php echo $lang_20;?></span>
                        </div>
                      </div>
                    </div>
                    <?php }?>
                  </div>
                <?php 
              } else { ?>
                  <div class="Newpanel-body" id="Newpanel-value" data-id="1">
                    <input type='hidden' name='Org_Allvalue' value="<?php echo htmlentities(serialize($_POST)); ?>"/>
                    <input type='hidden' name='Appint_OrgSelect' value="<?php echo $_POST['applntOrg_nameSelect']; ?>"/>
                  <?php
                    if($_POST['personType'] == 1){
                  ?>
                    <input type='hidden' name='Represent_Allvalue' value="<?php echo htmlentities(serialize($_POST['appint_personinfo1'])); ?>"/>
                    <input type='hidden' name='OrgRepresent_CountryID' value="<?php echo $_POST['applnt_countryid_idx']; ?>"/>
                    <div class="form-check">
                      <div class="flexcenter">
                        <input class="form-check-input Checkboxagent" type="checkbox" value="1" id="CheckboxpersonDefault" name="appint_personType[]" checked disabled>
                        <label class="form-check-label" for="CheckboxagentDefault">
                            <?php echo $lang_01?>
                        </label>
                      </div>
                      <div class="collapse in" id="collapseagent">
                        <div class="card card-body">
                          <div class="card-header flexcenter">
                            <i class="bi bi-building fa-2x"></i>
                            <span><?php echo $lang_02?></span>
                          </div>
                          <div class="Underlineborder"></div>
                          <div class="card-content">
                            <div class="row flexcenter">
                              <div class="col-sm-2">
                                <?php echo $lang_03;?>
                              </div>
                              <div class="col-sm-10">
                                <input type="text" class="form-control" id="corporatenumber" name="appint_personinfo1[]" disabled value="<?php echo $_POST['appint_personinfo1'][0] ?>"> 
                              </div>
                            </div>
                            <div class="row flexcenter">
                              <div class="col-sm-2">
                                <?php echo $lang_04;?>
                              </div>
                              <div class="col-sm-10">
                                <input type="text" class="form-control" disabled name="appint_personinfo1[]" value="<?php echo $_POST['appint_personinfo1'][1] ?>"> 
                              </div>
                            </div>
                            <div class="row flexcenter">
                              <div class="col-sm-2">
                                <?php echo $lang_05;?>
                              </div>
                              <div class="col-sm-2 flexcenter">
                                  <select class="custom-select " id="appint_personcomtype" disabled name="appint_personinfo1[]">
                                    <option value="0" <?php if($_POST['appint_personinfo1'][2] == 0) {echo 'selected';} ?>><?php echo $lang_13;?></option>
                                    <option value="1" <?php if($_POST['appint_personinfo1'][2] == 1) {echo 'selected';} ?>><?php echo $lang_14;?></option>
                                    <option value="2" <?php if($_POST['appint_personinfo1'][2] == 2) {echo 'selected';} ?>><?php echo $lang_15;?></option>
                                  </select>
                              </div>
                              <?php if($_POST['appint_personinfo1'][2] == 0){ ?>
                                <div class="col-sm-4" id="appint_personinfo13">
                                  <input type="text" class="form-control"  value="<?php echo $_POST['appint_personinfo13'] ?>" name="appint_personinfo13" readonly="readonly" />
                                </div>
                              <?php } ?>
                            </div>
                            <div class="row flexcenter">
                              <div class="col-sm-2">
                                <?php echo $lang_06;?>
                              </div>
                              <div class="col-sm-4" style="margin-left: 3px;">
                                <input type="text" class="form-control" name="appint_personinfo1[]" disabled value="<?php echo $_POST['appint_personinfo1'][3] ?>"> 
                              </div>
                              <div class="col-sm-2 text-right">
                                <?php echo $lang_24;?>
                              </div>
                              <div class="col-sm-4" style="margin-left: 3px;">
                                <input type="text" class="form-control" name="appint_personinfo1[]" disabled value="<?php echo $_POST['appint_personinfo1'][4] ?>"> 
                              </div>
                            </div>
                            <div class="row flexcenter">
                              <div class="col-sm-2">
                                <?php echo $lang_07;?>
                              </div>
                              <div class="col-sm-4">
                                <input type="text" class="form-control" name="appint_personinfo1[]" disabled value="<?php echo $_POST['appint_personinfo1'][5] ?>"> 
                                <input type="hidden" name="applntOrg_mobile_country" value="<?=$_POST['applntOrg_mobile_country'];?>">
                                <input type="hidden" name="applntOrg_mobile_code" value="<?=$_POST['applntOrg_mobile_code'];?>">
                              </div>
                              <div class="col-sm-2 text-right">
                                <?php echo $lang_11;?>
                              </div>
                              <div class="col-sm-4" style="margin-left: 3px;">
                                <input type="text" class="form-control" name="appint_personinfo1[]" disabled value="<?php echo $_POST['appint_personinfo1'][6] ?>"> 
                              </div>
                            </div>
                            <div class="row flexcenternew">
                              <div class="col-sm-2">
                                <?php echo $lang_08;?>
                              </div>
                              <div class="col-sm-10">
                                  <textarea rows="4" class="form-control applntOrg_address" name="appint_personinfo1[]" disabled><?php echo $_POST['appint_personinfo1'][7] ?></textarea>
                              </div>
                            </div>
                            <div class="row flexcenter">
                              <div class="col-sm-2">
                                <?php echo $lang_09;?>
                              </div>
                              <div class="col-sm-4">
                                <input type="hidden" class="form-control" id="" name="appint_personinfo1[]" value="<?php echo $_POST['appint_personinfo1'][8]?>" disabled>
                                <input type="text" class="form-control" id="" name="appint_personinfo1[]" value="<?php echo $_POST['appint_personinfo'][10]?>" disabled>
                              </div>
                              <div class="col-sm-2 textend">
                                <?php echo $lang_12;?>
                              </div>
                              <div class="col-sm-4">
                                <input type="text" class="form-control" name="appint_personinfo1[]" disabled value="<?php echo $_POST['appint_personinfo1'][9] ?>"> 
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php
                    }else{
                    ?>
                    <input type='hidden' name='Naturalperson_Allvalue' value="<?php echo htmlentities(serialize($_POST['appint_personinfo2'])); ?>"/>
                    <div class="form-check">
                      <div class="flexcenter">
                        <input class="form-check-input Checkboxperson" type="checkbox" value="2" id="CheckboxpersonDefault" name="appint_personType[]" checked disabled>
                        <label class="form-check-label" for="CheckboxpersonDefault">
                          <?php echo $lang_17;?>
                        </label>
                      </div>
                      <div class="collapse in" id="collapseperson">
                        <div class="card card-body">
                            <div class="card-header flexcenter">
                            <i class="bi bi-person-fill fa-2x"></i>
                            <span><?php echo $lang_18;?></span>
                            </div>
                            <div class="Underlineborder"></div>
                            <div class="card-content">
                            <div class="row flexcenter">
                                <div class="col-sm-2">
                                  <?php echo $lang_19;?>
                                </div>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control" id="" name="appint_personinfo2" value="<?php echo $_POST['appint_personinfo2'][0]?>" readonly="readonly"> 
                                </div>
                            </div>
                            </div>
                            <span style="margin-bottom: 5px; color: red;"><?php echo $lang_20;?></span>
                        </div>
                      </div>
                    </div>
                    <?php }?>
                  </div>
            <?php
              }
            ?>
          </div>
        </div>
      </div>
    </div>
    </div>


<?php if($type_id_box2 != 7){?>
    <div class="panel panel-default">
      <div class="panel-heading hr_invite_panel">
        <span class="hr_input_detail"><?php if($lang == "2"){echo $res2['frmset_name_en'];}else{ echo $res2['frmset_name'];}?></span>
        <a data-toggle="collapse" href="#collapse_2" class="collapse_2"><span class="icon_hide_detail_invite"></span></a>
      </div>
      <div id="collapse_2" class="panel-collapse collapse in">
      <div class="panel-body">
        <div class="row div_name_office_invite">
          <div class="col-md-12">
            <span class="icon_invite_home"><img src="images/icon_invite_home.png"></span>
              <span class="hr_invite_company_name"><?php if($_POST['complnt_name_IdxFs_'.$type_id_box2]==""){echo "-";}else{echo $_POST['complnt_name_IdxFs_'.$type_id_box2];}?></span>
              <input type="hidden" name="complnt_name" value="<?=$_POST['complnt_name_IdxFs_'.$type_id_box2];?>">
              <input type="hidden" name="complnt_trade_number" value="<?=$_POST['complnt_trade_number_IdxFs_'.$type_id_box2];?>">
          </div>
        </div>
        <div class="row div_branch_invite">
          <div class="col-md-3 col-sm-4"><?=$txt_Branch?><span class="txt_xr txt_xr_detail">:</span></div>
          <div class="col-md-4 col-sm-8 txt_invite_detail"><?php if($_POST['complnt_branch_IdxFs_'.$type_id_box2]==""){echo "-";}else{echo $_POST['complnt_branch_IdxFs_'.$type_id_box2];}?></div>
          <input type="hidden" name="complnt_branch" value="<?=$_POST['complnt_branch_IdxFs_'.$type_id_box2];?>">
          <div class="col-md-5"></div>
        </div>
        <div class="row div_trade_invite">
          <div class="col-md-3 col-sm-4"><?=$txt_Contact_name?><span class="txt_xr txt_xr_detail">:</span></div>
          <div class="col-md-4 col-sm-8 txt_invite_detail"><?php if($_POST['complnt_contact_name_IdxFs_'.$type_id_box2]==""){echo "-";}else{echo $_POST['complnt_contact_name_IdxFs_'.$type_id_box2];}?></div>
          <input type="hidden" name="complnt_contact_name" value="<?=$_POST['complnt_contact_name_IdxFs_'.$type_id_box2];?>">
          <div class="col-md-5"></div>
        </div>
        <div class="row div_contacts_invite">
          <div class="col-md-3 col-sm-4"><?=$txt_email_to?><span class="txt_xr txt_xr_detail">:</span></div>
          <div class="col-md-4 col-sm-8 txt_invite_detail"><?php if($_POST['complnt_contact_email_IdxFs_'.$type_id_box2]==""){echo "-";}else{echo $_POST['complnt_contact_email_IdxFs_'.$type_id_box2];}?></div>
          <input type="hidden" name="complnt_contact_email" value="<?=$_POST['complnt_contact_email_IdxFs_'.$type_id_box2];?>">
          <div class="col-md-5"></div>
        </div>
        <div class="row div_tel_invite">
          <div class="col-md-3 col-sm-4"><?=$txt_Tel_number?><span class="txt_xr txt_xr_detail">:</span></div>
          <div class="col-md-4 col-sm-8 txt_invite_detail"><?php if($_POST['complnt_contact_tel_IdxFs_'.$type_id_box2]==""){echo "-";}else{echo $_POST['complnt_mobile_code']; echo $_POST['complnt_contact_tel_IdxFs_'.$type_id_box2];}?></div>
          <input type="hidden" name="complnt_contact_tel" value="<?=$_POST['complnt_contact_tel_IdxFs_'.$type_id_box2];?>">
          <input type="hidden" name="complnt_mobile_country" value="<?=$_POST['complnt_mobile_country'];?>">
          <input type="hidden" name="complnt_mobile_code" value="<?=$_POST['complnt_mobile_code'];?>">
          <div class="col-md-5"></div>
        </div>
        <div class="row div_tel_invite">
          <div class="col-md-3 col-sm-4"><?=$txt_Type_of_business?><span class="txt_xr txt_xr_detail">:</span></div>
          <div class="col-md-4 col-sm-8 txt_invite_detail"><?php
          if($_POST['complnt_import_export_IdxFs_'.$type_id_box2] == "0"){
            $Business = "อื่นๆ";
          }elseif ($_POST['complnt_import_export_IdxFs_'.$type_id_box2] == "1") {
            $Business = "นำเข้า";
          }elseif ($_POST['complnt_import_export_IdxFs_'.$type_id_box2] == "2") {
            $Business = "ส่งออก";
          }
          if($Business==""){echo "-";}else{echo $Business;}
          ?></div>
          <input type="hidden" name="complnt_import_export" value="<?=$_POST['complnt_import_export_IdxFs_'.$type_id_box2];?>">
          <div class="col-md-5"></div>
        </div>
        <div class="row div_address_invite">
          <div class="col-md-3 col-sm-4"><?=$txt_Address?><span class="txt_xr txt_xr_detail">:</span></div>
          <div class="col-md-4 col-sm-8 txt_invite_detail"><?php if($_POST['complnt_contact_address_IdxFs_'.$type_id_box2]==""){echo "-";}else{echo $_POST['complnt_contact_address_IdxFs_'.$type_id_box2];}?></div>
          <input type="hidden" name="complnt_contact_address" value="<?=$_POST['complnt_contact_address_IdxFs_'.$type_id_box2];?>">
          <div class="col-md-5"></div>
        </div>
        <div class="row div_country_invite">
          <div class="col-md-3 col-sm-4"><?=$txt_Country?><span class="txt_xr txt_xr_detail">:</span></div>
          <div class="col-md-4 col-sm-8 txt_invite_detail">
            <?php
          $country = $_POST['complnt_country_id_IdxFs_'.$type_id_box2];
          $sql = "SELECT * FROM Country WHERE id = '$country'";
          $query = $conn->query($sql);
          $re = $query->fetch_assoc();
          if($re['name']==""){echo "-";}else{echo $re['name'];}
          ?></div>
          <input type="hidden" name="complnt_country_id" value="<?=$_POST['complnt_country_id_IdxFs_'.$type_id_box2];?>">
          <div class="col-md-5"></div>
        </div>
        <?php if($country == 162){ ?>
        <div class="row div_prov_invite">
          <div class="col-md-3 col-sm-4"><?=$txt_Province?><span class="txt_xr txt_xr_detail">:</span></div>
          <div class="col-md-4 col-sm-8 txt_invite_detail">
          <?php
          $Province = $_POST['complnt_prov_id_IdxFs_'.$type_id_box2];
          $sql_p = "SELECT * FROM Province WHERE prov_id = '$Province'";
          $query_p = $conn->query($sql_p);
          $rsx = $query_p->fetch_assoc();
          if($rsx['prov_name']==""){echo "-";}else{echo $rsx['prov_name'];}
          ?></div>
          <input type="hidden" name="complnt_prov_id" value="<?=$_POST['complnt_prov_id_IdxFs_'.$type_id_box2];?>">
          <div class="col-md-5"></div>
        </div>
        <?php } ?>
        <div class="row div_zipcode_invite">
          <div class="col-md-3 col-sm-4"><?=$txt_Postcode?><span class="txt_xr txt_xr_detail">:</span></div>
          <div class="col-md-4 col-sm-8 txt_invite_detail"><?php if($_POST['complnt_zipcode_IdxFs_'.$type_id_box2]==""){echo "-";}else{echo $_POST['complnt_zipcode_IdxFs_'.$type_id_box2];}?></div>
          <input type="hidden" name="complnt_zipcode" value="<?=$_POST['complnt_zipcode_IdxFs_'.$type_id_box2];?>">
          <div class="col-md-5"></div>
        </div>
      </div>
    </div>
    </div>
<?php }else { ?>
  <div class="panel panel-default">
    <div class="panel-heading hr_invite_panel">
      <span class="hr_input_detail"><?php if($lang == "2"){echo $res2['frmset_name_en'];}else{ echo $res2['frmset_name'];}?></span>
      <a data-toggle="collapse" href="#collapse_2" class="collapse_2"><span class="icon_hide_detail_invite"></span></a>
    </div>
    <div id="collapse_2" class="panel-collapse collapse in">
    <div class="panel-body">
      <div class="row div_name_office_invite">
        <div class="col-md-12">
          <span class="icon_invite_home"><img src="images/icon_invite_home.png"></span>
            <span class="hr_invite_company_name"><?php echo $_POST['complnt_name_IdxFs_'.$type_id_box2]?></span>
            <input type="hidden" name="complnt_name" value="<?=$_POST['complnt_name_IdxFs_'.$type_id_box2];?>">
        </div>
      </div>
      <div class="row div_branch_invite">
        <div class="col-md-3 col-sm-4"><?=$txt_Branch?><span class="txt_xr txt_xr_detail">:</span></div>
        <div class="col-md-4 col-sm-8 txt_invite_detail"><?php if($_POST['complnt_branch_IdxFs_'.$type_id_box2]==""){echo "-";}else{echo $_POST['complnt_branch_IdxFs_'.$type_id_box2];}?></div>
        <input type="hidden" name="complnt_branch" value="<?=$_POST['complnt_branch_IdxFs_'.$type_id_box2];?>">
        <div class="col-md-5"></div>
      </div>
      <div class="row div_branch_invite">
        <div class="col-md-3 col-sm-4"><?=$txt_Position?><span class="txt_xr txt_xr_detail">:</span></div>
        <div class="col-md-4 col-sm-8 txt_invite_detail"><?php if($_POST['complnt_position_IdxFs_'.$type_id_box2]==""){echo "-";}else{echo $_POST['complnt_position_IdxFs_'.$type_id_box2];}?></div>
        <input type="hidden" name="complnt_position" value="<?=$_POST['complnt_position_IdxFs_'.$type_id_box2];?>">
        <div class="col-md-5"></div>
      </div>
      <div class="row div_branch_invite">
        <div class="col-md-3 col-sm-4"><?=$txt_Date_Birth?><span class="txt_xr txt_xr_detail">:</span></div>
        <div class="col-md-4 col-sm-8 txt_invite_detail"><?php if($_POST['complnt_birthday_IdxFs_'.$type_id_box2]==""){echo "-";}else{echo $_POST['complnt_birthday_IdxFs_'.$type_id_box2];}?></div>
        <input type="hidden" name="complnt_birthday" value="<?=$_POST['complnt_birthday_IdxFs_'.$type_id_box2];?>">
        <div class="col-md-5"></div>
      </div>
      <div class="row div_branch_invite">
        <div class="col-md-3 col-sm-4"><?=$txt_Age?><span class="txt_xr txt_xr_detail">:</span></div>
        <div class="col-md-4 col-sm-8 txt_invite_detail"><?php if($_POST['complnt_age_IdxFs_'.$type_id_box2]==""){echo "-";}else{echo $_POST['complnt_age_IdxFs_'.$type_id_box2];}?></div>
        <input type="hidden" name="complnt_age" value="<?=$_POST['complnt_age_IdxFs_'.$type_id_box2];?>">
        <div class="col-md-5"></div>
      </div>
      <div class="row div_tel_invite">
        <div class="col-md-3 col-sm-4"><?=$txt_Tel_number?><span class="txt_xr txt_xr_detail">:</span></div>
        <div class="col-md-4 col-sm-8 txt_invite_detail"><?php if($_POST['complnt_contact_tel_IdxFs_'.$type_id_box2]==""){echo "-";}else{echo $_POST['complnt_contact_tel_IdxFs_'.$type_id_box2];}?></div>
        <input type="hidden" name="complnt_contact_tel" value="<?=$_POST['complnt_contact_tel_IdxFs_'.$type_id_box2];?>">
        <div class="col-md-5"></div>
      </div>
      <div class="row div_contacts_invite">
        <div class="col-md-3 col-sm-4"><?=$txt_email_to?><span class="txt_xr txt_xr_detail">:</span></div>
        <div class="col-md-4 col-sm-8 txt_invite_detail"><?php if($_POST['complnt_contact_email_IdxFs_'.$type_id_box2]==""){echo "-";}else{echo $_POST['complnt_contact_email_IdxFs_'.$type_id_box2];}?></div>
        <input type="hidden" name="complnt_contact_email" value="<?=$_POST['complnt_contact_email_IdxFs_'.$type_id_box2];?>">
        <div class="col-md-5"></div>
      </div>
      <div class="row div_address_invite">
        <div class="col-md-3 col-sm-4"><?=$txt_Address?><span class="txt_xr txt_xr_detail">:</span></div>
        <div class="col-md-4 col-sm-8 txt_invite_detail"><?php if($_POST['complnt_contact_address_IdxFs_'.$type_id_box2]==""){echo "-";}else{echo $_POST['complnt_contact_address_IdxFs_'.$type_id_box2];}?></div>
        <input type="hidden" name="complnt_contact_address" value="<?=$_POST['complnt_contact_address_IdxFs_'.$type_id_box2];?>">
        <div class="col-md-5"></div>
      </div>
    </div>
  </div>
  </div>
<?php } ?>


    <div class="panel panel-default">
      <div class="panel-body">
        <div class="row div_complaint_invite">
          <div class="col-md-12">
            <div class="hr_complaint_invite txt_invite_detail_hr"><?=$txt_Topic?></div>
            <div class="txt_complaint_invite txt_invite_detail"><?php echo $_POST['caseDtl_title_IdxFs_'.$type_id_box3]?></div>
            <input type="hidden" name="caseDtl_title" value="<?=$_POST['caseDtl_title_IdxFs_'.$type_id_box3];?>">
          </div>
        </div>
        <div class="row div_category_invite">
          <?php if($type_id_box2 != 7){ ?>
            <div class="col-md-12">
              <div class="hr_category_invite txt_invite_detail_hr"><?=$txt_Type_goods?></div>
              <div class="txt_category_invite txt_invite_detail">
                <?php
                $prodType = $_POST['prodType_id_IdxFs_'.$type_id_box3];
                $sql_prodType = "SELECT * FROM Product_Type WHERE prodType_id = '$prodType'";
                $query_prodType = $conn->query($sql_prodType);
                $rl = $query_prodType->fetch_assoc();
                echo $rl['prodType_name'];
                ?>
                  <input type="hidden" name="prodType_id" value="<?=$_POST['prodType_id_IdxFs_'.$type_id_box3];?>">
              </div>
            </div>
            <?php if($rl['prodType_other_flag'] == 1){?>
            <div class="col-md-12">
              <div class="hr_category_invite txt_invite_detail_hr"><?=$txt_Type_or?></div>
              <div class="txt_category_invite txt_invite_detail">
                <?php
                echo $_POST['prodType_other_IdxFs_'.$type_id_box3];
                ?>
                  <input type="hidden" name="prodType_other" value="<?=$_POST['prodType_other_IdxFs_'.$type_id_box3];?>">
              </div>
            </div>
            <?php }
           }else { ?>
            <div class="col-md-12">
              <div class="hr_category_invite txt_invite_detail_hr"><?=$txt_complaint?></div>
              <div class="txt_category_invite txt_invite_detail">
                <?php
                $incType = $_POST['incType_id_IdxFs_'.$type_id_box3];
                $sql_incType = "SELECT * FROM `Incorrect_Type` WHERE incType_id = '$incType'";
                $query_incType = $conn->query($sql_incType);
                $rl = $query_incType->fetch_assoc();
                echo $rl['incType_name'];
                ?>
                  <input type="hidden" name="incType_id" value="<?=$_POST['incType_id_IdxFs_'.$type_id_box3];?>">
              </div>
            </div>
            <?php if($rl['incType_other_flag'] == 1){?>
            <div class="col-md-12">
              <div class="hr_category_invite txt_invite_detail_hr"><?=$txt_Type_or?></div>
              <div class="txt_category_invite txt_invite_detail">
                <?php
                echo $_POST['incType_other_IdxFs_'.$type_id_box3];
                ?>
                  <input type="hidden" name="incType_other" value="<?=$_POST['incType_other_IdxFs_'.$type_id_box3];?>">
              </div>
            </div>
            <?php }
          } ?>

        </div>
        <div class="row div_history_invite">
          <div class="col-md-12">
            <div class="hr_history_invite txt_invite_detail_hr"><?=$txt_Bg_information?></div>
            <div class="txt_history_invite txt_invite_detail"><?php echo $_POST['caseDtl_derivation_IdxFs_'.$type_id_box3]?></div>
            <input type="hidden" name="caseDtl_derivation" value="<?=$_POST['caseDtl_derivation_IdxFs_'.$type_id_box3];?>">
          </div>
        </div>
        <div class="row div_charge_invite">
          <div class="col-md-12">
            <div class="hr_charge_invite txt_invite_detail_hr"><?=$txt_Damage_ex?></div>
            <div class="txt_charge_invite txt_invite_detail"><?php echo $_POST['caseDtl_damage_val_IdxFs_'.$type_id_box3]?>&nbsp;
              <?php
              $curren = $_POST['curren_id_IdxFs_'.$type_id_box3];
              $sql_curren = "SELECT * FROM Currency WHERE curren_id = '$curren'";
              $query_curren = $conn->query($sql_curren);
              $rs = $query_curren->fetch_assoc();
              echo $rs['curren_name'];
              ?>
              <input type="hidden" name="caseDtl_damage_val" value="<?=$_POST['caseDtl_damage_val_IdxFs_'.$type_id_box3];?>">
              <input type="hidden" name="curren_id" value="<?=$_POST['curren_id_IdxFs_'.$type_id_box3];?>">
            </div>
          </div>
        </div>
        <div class="row div_demand_invite">
          <div class="col-md-12">
            <div class="hr_demand_invite txt_invite_detail_hr"><?=$txt_requirement?></div>
            <div class="txt_demand_invite txt_invite_detail"><?php echo $_POST['caseDtl_complnt_need_IdxFs_'.$type_id_box3]?></div>
            <input type="hidden" name="caseDtl_complnt_need" value="<?=$_POST['caseDtl_complnt_need_IdxFs_'.$type_id_box3];?>">
          </div>
        </div>
        <div class="row div_name_file">
          <div class="col-md-12">
            <div class="hr_file_invite txt_invite_detail_hr"><?=$txt_Attached?></div>
            <input type="hidden" name="fileinput_file" value="<?=$_POST['fileinput_file']?>">

            <?php
            foreach ($_POST['new_fileadrss'] as $value) { ?>
            <input type="hidden" name="new_fileadrss[]" value="<?=$value?>">
          <?php  }
            foreach ($_POST['caseAttach_file_name'] as $value) { ?>
              <input type="hidden" name="caseAttach_file_name[]" value="<?=$value?>">
            <?php }
            $sn = "";
            foreach (glob("../data/case_attach_tmp/".$_SESSION['member_id']."/*.*") as $sn) {
              $sn_ex = explode("/",$sn);
              $sn_type = explode(".",$sn_ex[4]);
              ?>
              <div class="panel panel-default panel_file_detail" style="background-color:#fff;">
                <a href="<?=$sn;?>" target="_blank">
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-1">
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
                  </div>
            <div class="col-md-10">
                <span><?php
                echo $sn_ex[4];
                ?>
              </span>
            </div>
          </div>
          </div>
        </a>
          </div>
            <?php } ?>

          </div>
        </div>
      </div>
      <div class="row" style="margin-top:20px; margin-bottom:10px; margin-left:10px;">
      <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="g-recaptcha" data-sitekey="6LdTxygUAAAAAGOY_dOU0RbVEhB0w2-ua99sG_Mr"></div>
      </div>
      </div>
    </div>

    <div class="btn-div">
    <button class="btn btn-warning form-control btn-edit-invite" type="button" onclick="submitForm('?page=invite_edit','1')" ><?php if($lang == "1"){ echo "แก้ไข";}elseif($lang == "2"){ echo "Edit";}else{ echo "แก้ไข";}?></button>
    <!-- <button class="btn btn-success form-control btn-confirm-invite" type="button"><?php if($lang == "1"){ echo "ส่งแบบฟอร์ม";}elseif($lang == "2"){ echo "Submit form";}else{ echo "ส่งแบบฟอร์ม";}?></button> -->
    <button class="btn btn-success form-control" id="submit_test" type="button"><?php if($lang == "1"){ echo "ส่งแบบฟอร์ม";}elseif($lang == "2"){ echo "Submit form";}else{ echo "ส่งแบบฟอร์ม";}?></button>
    </div>
  </div> <!-- invite_step3 -->
</form>

</div>
</div>
<script>

function Register_ajax() {
  var Member = $("[name='appint_personinfo[]']").map(function(){return $(this).val();}).get();
  var applnt_mobile_country = $("[name='applnt_mobile_country']").val();
  var applnt_mobile_code = $("[name='applnt_mobile_code']").val();
  Member.push(applnt_mobile_country, applnt_mobile_code);
  var data = JSON.stringify(Member);
  return new Promise((resolve, reject) => {
    $.ajax({
      url: 'function_php/function_index.php?method=Register_member',
      type: 'POST',
      data: {
        key: data,
      },
      success: function (data) {
        resolve(data)
      },
      error: function (error) {
        reject(error)
      },
    })
  })
}

$('#submit_test').on('click', function(){
  Register_ajax()
  .then((data) => {
    console.log(data);
    if(data == 1){
      var lang = $('.language_hidden').val();
      if(lang == "2"){
        var ArlogIn = "Confirm the petition?";
      }else {
        var ArlogIn = "ยืนยันบันทึกการแจ้งเรื่อง ?";
      }
      bootbox.confirm(ArlogIn, function(result) {
          if (result) {
              console.log(submitForm('function_php/function_index.php?method=create_invite','2'));
          }else {
            $('.btn-confirm-invite').attr('disabled',false);
          }
      });
    }else{
      
    }
  })
  .catch((error) => {
    console.log(error)
  })
})

$(document).on("click", ".btn-confirm-invite", function(e) {
  // var lang = $('.language_hidden').val();
  // if(lang == "2"){
  //   var ArlogIn = "Confirm the petition?";
  // }else {
  //   var ArlogIn = "ยืนยันบันทึกการแจ้งเรื่อง ?";
  // }
  //   e.preventDefault();
  //   bootbox.confirm(ArlogIn, function(result) {
  //       if (result) {
              // Register_ajax()
              // .catch((error) => {
              //   console.log(error)
              // })
  //           console.log(submitForm('function_php/function_index.php?method=create_invite','2'));
  //       }else {
  //         $('.btn-confirm-invite').attr('disabled',false);
  //       }
  //   });
});

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

  var result = "<?php echo $_POST['Represent_value'][2]?>";
  if(result == "0"){
    $('#SelectType_Business option[value='+ result +']').attr('selected', true);
    $('#InputType_Business').val("<?php echo $_POST['Represent_value'][3]?>");
  }else if(result == "1"){
    $('#SelectType_Business option[value='+ result +']').attr('selected', true);
    $('#InputType_Business').css('display', 'none');
  }else if(result == "2"){
    $('#SelectType_Business option[value='+ result +']').attr('selected', true);
    $('#InputType_Business').css('display', 'none');
  }

  $('#up_square').on('click', function(){
    if($('#multiCollapse').hasClass('in')){
      $('.Newpanel-header').css('height', '60px');
      $('#multiCollapse').removeClass('in');
      $(this).addClass('bi-caret-down-square-fill');
      $(this).removeClass('bi-caret-up-square');
    }else{
      $('.Newpanel-header').css('height', 'auto');
      $('#multiCollapse').addClass('in');
      $(this).addClass('bi-caret-up-square');
      $(this).removeClass('bi-caret-down-square-fill');
    }
  })

  var country_id = "<?php echo $_POST['appint_personinfo'][9]?>";
  $('.person_country option[value='+ country_id +']').attr('selected', true);


</script>
