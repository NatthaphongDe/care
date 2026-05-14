<style>
  .iti--allow-dropdown{
    width:100% !important;
  }
</style>
<div class="row info_div_row">
  <div class="col-md-3">
    <div class="setting_desktop">
    <span class="icon_hr_setting"><img src="images/icon_setting.png" class="icon_setting"></span>
    <span class="txt_hr_setting"><?=$txt_Settings?></span>
    <div class="panel panel-default appeal_panel">
      <div class="div_sound">
        <span class="icon_sound_green"><img src="images/icon_sound_green.png"></span>
        <span class="txt_sound"><?=$txt_Notification?></span>
        <div class="onoffswitch">
          <?php
          $sql = "SELECT * FROM `Member` WHERE member_id = '".$_SESSION['member_id']."'";
          $query = $conn->query($sql);
          $rl = $query->fetch_assoc();
          ?>
              <input type="hidden" class="status_noti" value="<?php echo $rl['member_noti'];?>">
              <input type="checkbox" <?php if($rl['member_noti'] == 1){ echo 'checked';}?> name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" onchange="chk_status_noti(<?php echo $rl['member_noti'];?>)">
              <label class="onoffswitch-label" for="myonoffswitch">
              <span class="onoffswitch-inner"></span>
              <span class="onoffswitch-switch"></span>
              </label>
          </div>
        <hr>
      </div>
      <?php if($_SESSION["member_login_type"] == 0){?>
      <div class="div_tool">
        <!-- <a onclick="show_modal_repassword();" style="cursor: pointer;"> -->
        <!-- <a href="https://sso.ditp.go.th/sso/auth/pre_changepassword?client_id=ssocareid&token=TOKEN&redirect_uri=https://care.ditp.go.th/" style="cursor: pointer;"> -->
        <a href="https://sso.ditp.go.th/sso/auth/ck_changepassword?client_id=ssocareid&token=<?=$_SESSION['code']?>&redirect_uri=https://care.ditp.go.th/" style="cursor: pointer;">
        <span class="icon_tool"><img src="images/icon_tool.png"></span>
        <span class="txt_tool"><?=$txt_Change_password?></span>
        </a>
        <hr>
      </div>
      <?php } ?>
      <div class="div_help">
        <a href="?page=help" style="cursor: pointer;">
        <span class="icon_about"><img src="images/icon_about.png"></span>
        <span class="txt_help"><?=$txt_Help?></span>
        </a>
        <hr>
      </div>
      <div class="div_about">
        <a href="?page=about" style="cursor: pointer;">
          <span class="icon_help"><img src="images/icon_help.png"></span>
        <span class="txt_about"><?=$txt_About_DITP?></span>
        </a>
      </div>
    </div>
  </div>
  
<?php if($_GET['page'] == "setting"){ ?>
  <div class="setting_mobile" style="display:none;">
  <span class="icon_hr_setting"><img src="images/icon_setting.png" class="icon_setting"></span>
  <span class="txt_hr_setting"><?=$txt_Settings?></span>
  <div class="panel panel-default appeal_panel">
    <div class="div_sound">
      <span class="icon_sound_green"><img src="images/icon_sound_green.png"></span>
      <span class="txt_sound"><?=$txt_Notification?></span>
      <div class="onoffswitch">
        <?php
        $sql = "SELECT * FROM `Member` WHERE member_id = '".$_SESSION['member_id']."'";
        $query = $conn->query($sql);
        $rl = $query->fetch_assoc();
        ?>
            <input type="hidden" class="status_noti" value="<?php echo $rl['member_noti'];?>">
            <input type="checkbox" <?php if($rl['member_noti'] == 1){ echo 'checked';}?> name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch_mo" onchange="chk_status_noti(<?php echo $rl['member_noti'];?>)">
            <label class="onoffswitch-label" for="myonoffswitch_mo">
            <span class="onoffswitch-inner"></span>
            <span class="onoffswitch-switch"></span>
            </label>
        </div>
      <hr>
    </div>
    <?php if($_SESSION["member_login_type"] == 0){?>
    <div class="div_tool">
      <a onclick="show_modal_repassword();" style="cursor: pointer;">
      <span class="icon_tool"><img src="images/icon_tool.png"></span>
      <span class="txt_tool"><?=$txt_Change_password?></span>
      </a>
      <hr>
    </div>
    <?php } ?>
    <div class="div_help">
      <a href="?page=help" style="cursor: pointer;">
      <span class="icon_about"><img src="images/icon_about.png"></span>
      <span class="txt_help"><?=$txt_Help?></span>
      </a>
      <hr>
    </div>
    <div class="div_about">
      <a href="?page=about" style="cursor: pointer;">
        <span class="icon_help"><img src="images/icon_help.png"></span>
      <span class="txt_about"><?=$txt_About_DITP?></span>
      </a>
    </div>
  </div>
</div>
<?php } ?>
  </div>
  
  <form method="post" action="" enctype="multipart/form-data" id="profile_data">
  <div class="col-md-9 profile_detail">

    <div class="profile_desktop">
    <span class="icon_hr_person"><img src="images/icon_person_profile.png" class="icon_person"></span>
    <span class="txt_hr_info"><?=$txt_Personal_information?></span>
    <div class="panel panel-default appeal_panel">
      <div class="panel-body">
      <?php
        if($_GET['test'] == '5678'){
          echo "<pre>";
          print_r($_SESSION['member']['member_id']);
          echo "</pre>";
          
        }
      ?>
        <?php
        $sql = "SELECT * FROM `Member` WHERE member_id = '".$_SESSION['member_id']."'";
        $query = $conn->query($sql);
        if($query->num_rows > 0){
          $res = $query->fetch_assoc();
        }
        
        $sql_comp = "SELECT * FROM `Member_comp` WHERE member_id = '".$_SESSION['member_id']."'";
        $query_comp = $conn->query($sql_comp);
        if($query_comp->num_rows > 0){
          $rc = $query_comp->fetch_assoc();
        }

        ?>
        
      <div class="row">
        <div class="col-md-12 col_profile">
        <!-- <pre> -->
          <?php
            // print_r($res);
          ?>
        <!-- </pre> -->
          <?php if($res['member_type'] == 0){?>
          <span class="bg_image_profile">
            <?php
            $pathfile = "../data/img_member/".$_SESSION['member_id']."/".$res['member_img'];
						if(count(glob($pathfile)) > 0) {
              ?>
            <img src="../data/img_member/<?=$_SESSION['member_id'];?>/<?=$res['member_img'];?>" class="img_profile" style="<?php echo getPositionImage("../data/img_member/".$_SESSION['member_id']."/".$res['member_img'],120)?>">
              <?php }else { ?>
                  <img src="images/profile_emp-01.svg" class="img_profile" style="<?php echo getPositionImage("images/profile_emp-01.svg",120)?>">
            <?php } ?>
          </span>
          <?php }else { ?>
            <span class="bg_image_profile">
              <?php
              $pathfile = "../data/img_membercom/".$rex['member_comp_id']."/".$rc['member_comp_img'];
  						if(count(glob($pathfile)) > 0) {
              ?>
              <img src="../data/img_membercom/<?=$rc['member_comp_id'];?>/<?=$rc['member_comp_img'];?>" class="img_profile" style="<?php echo getPositionImage("../data/img_membercom/".$rc['member_comp_id']."/".$rc['member_comp_img'],120)?>">
              <?php }else { ?>
                <img src="images/profile_emp-01.svg" class="img_profile" style="<?php echo getPositionImage("images/profile_emp-01.svg",120)?>">
              <?php } ?>
            </span>
          <?php } ?>
          <div class="edit_profile"><a onclick="show_modal_profile();" style="cursor: pointer;"><?=$txt_edit_profile?></a></div>
        </div>
      </div>
      <?php if($res['member_type'] == 1){ ?>
      <div class="row div_profile_hr">
        <div class="col-md-12">
          <span class="icon_name_office"><img src="images/icon_invite_home.png"></span>
          <span class="edit_name_office">
          <?php 
          if($lang == 1){
            echo $rc['member_comp_name'];
          } elseif($lang == 2){
            echo $rc['member_comp_name_en'];
          } else{
            echo $rc['member_comp_name'];
          }
          
          
          ?>
          </span>
        </div>
      </div>

      <div class="row div_profile">
        <div class="col-md-5">
          <span class="txt_name_branch"><?=$txt_Branch?></span>
          <span class="txt_xr">:</span>
        </div>
        <div class="col-md-7">
          <span class="txt_data_branch"><?php echo $rc['member_comp_branch'];?></span>
        </div>
      </div>

      <div class="row div_profile">
        <div class="col-md-5">
          <span class="txt_name_xr"><?=$txt_Registration_Number?></span>
          <span class="txt_xr">:</span>
        </div>
        <div class="col-md-7">
          <span class="txt_data_xr"><?php echo $rc['member_comp_taxid'];?></span>
        </div>
      </div>

      <div class="row div_profile">
        <div class="col-md-5">
          <span class="txt_name_xr"><?=$txt_Type_of_business?></span>
          <span class="txt_xr">:</span>
        </div>
        <div class="col-md-7">
          <?php
          if($lang == "1"){
            if($res['member_business'] == 0){
              $member_business = "ไม่ระบุ";
            }elseif ($res['member_business'] == 1) {
              $member_business = "นำเข้า";
            }elseif ($res['member_business'] == 2) {
              $member_business = "ส่งออก";
            }else {
              $member_business = "-";
            }
          }elseif ($lang == "2") {
            if($res['member_business'] == 0){
              $member_business = "Unknown";
            }elseif ($res['member_business'] == 1) {
              $member_business = "Import";
            }elseif ($res['member_business'] == 2) {
              $member_business = "Export";
            }else {
              $member_business = "-";
            }
          }else {
            if($res['member_business'] == 0){
              $member_business = "ไม่ระบุ";
            }elseif ($res['member_business'] == 1) {
              $member_business = "นำเข้า";
            }elseif ($res['member_business'] == 2) {
              $member_business = "ส่งออก";
            }else {
              $member_business = "-";
            }
          }
 ?>
          <span class="txt_data_xr"><?php echo $member_business;?></span>
        </div>
      </div>

      <div class="row div_profile">
        <div class="col-md-5">
          <span class="txt_name_tel"><?=$txt_Telephone_number?></span>
          <span class="txt_xr">:</span>
        </div>
        <div class="col-md-7">
          <span class="txt_data_tel"><?php echo $rc['member_comp_phone'];?></span>
        </div>
      </div>

      <div class="row div_profile">
        <div class="col-md-5">
          <span class="txt_name_fix"><?=$txt_Fax_number?></span>
          <span class="txt_xr">:</span>
        </div>
        <div class="col-md-7">
          <span class="txt_data_fix"><?php echo $rc['member_comp_fax'];?></span>
        </div>
      </div>

      <div class="row div_profile">
        <div class="col-md-5">
          <span class="txt_name_address"><?=$txt_Address?></span>
          <span class="txt_xr">:</span>
        </div>
        <div class="col-md-7">
          <span class="txt_data_address"><?php echo $rc['member_comp_address'];?></span>
        </div>
      </div>

      <div class="row div_profile">
        <div class="col-md-5">
          <span class="txt_name_city"><?=$txt_Country?></span>
          <span class="txt_xr">:</span>
        </div>
        <div class="col-md-7">
          <span class="txt_data_city">
            <?php
            $sql_country_com = "SELECT * FROM `Country` WHERE id = '".$rc['country_id']."'";
            $query_country_com = $conn->query($sql_country_com);
            if($query_country_com->num_rows > 0){
              $rx = $query_country_com->fetch_assoc();
            }
            if($lang == "1"){
              echo $rx['name'];
            }elseif ($lang == "2") {
              echo $rx['name'];
            }else {
              echo $rx['name'];
            }
            ?>
          </span>
        </div>
      </div>

    <?php if($rc['prov_id'] != "0"){ ?>
      <div class="row div_profile">
        <div class="col-md-5">
          <span class="txt_name_provice"><?=$txt_Province?></span>
          <span class="txt_xr">:</span>
        </div>
        <div class="col-md-7">

          <span class="txt_data_provice">
            <?php

            $sql_province_com = "SELECT * FROM `Province` WHERE prov_id = '".$rc['prov_id']."'";
            $query_province_com = $conn->query($sql_province_com);
            if($query_province_com->num_rows > 0){
              $rlx = $query_province_com->fetch_assoc();
            }
            if($lang == "1"){
              echo $rlx['prov_name'];
            }elseif ($lang == "2") {
              echo $rlx['prov_name_eng'];;
            }else {
              echo $rlx['prov_name'];
            }
            ?>
          </span>
        </div>
      </div>
      <?php } ?>

      <div class="row div_profile">
        <div class="col-md-5">
          <span class="txt_name_code"><?=$txt_Postcode?></span>
          <span class="txt_xr">:</span>
        </div>
        <div class="col-md-7">
          <span class="txt_data_code"><?php echo $rc['member_comp_postcode'];?></span>
        </div>
      </div>

      <!-- ข้อมูลบริษัท -->
      <?php } ?>
      
      <div class="row div_profile_hr">
        <div class="col-md-12">
          <span class="icon_name_person"><img src="images/icon_invite_person.png"></span>
          <span class="edit_name_person">
          <?php 
          if($lang == "1"){
             echo "คุณ ".$res['member_fname'].' '.$res['member_lname'];
            }elseif($lang == "2"){
              echo "Sir ".$res['member_fname_en'].' '.$res['member_lname_en'];
            }else{
              echo "คุณ ".$res['member_fname'].' '.$res['member_lname'];
            }
          ?> 
          </span>
        </div>
      </div>
      
      <div class="row div_profile">
        <div class="col-md-5 ">
          <span class="txt_code_person"><?=$txt_Identification?></span>
          <span class="txt_xr">:</span>
        </div>
        <div class="col-md-7">
          <span class="txt_data_person"><?php echo $res['member_cid'];?></span>
        </div>
      </div>
      <!-- <div class="row div_profile">
        <div class="col-md-5">
          <span class="txt_code_person"><?=$txt_Gender?></span>
          <span class="txt_xr">:</span>
        </div>
        <div class="col-md-7">
          <span class="txt_data_person"><?php
          if($res['member_sex'] == "1"){
            $sex = $txt_Male;
          }elseif ($res['member_sex'] == "2") {
            $sex = $txt_Female;
          }

           echo $sex;
           ?></span>
        </div>
      </div> -->
      <?php if($res['member_type'] == 1){?>
      <div class="row div_profile">
        <div class="col-md-5">
          <span class="txt_name_xr_person"><?=$txt_Position?></span>
          <span class="txt_xr">:</span>
        </div>
        <div class="col-md-7">
          <span class="txt_data_xr_person"><?php echo $res['member_position'];?></span>
        </div>
      </div>
      <?php }else { ?>
        <div class="row div_profile">
          <div class="col-md-5">
            <span class="txt_name_xr_person"><?=$txt_Occupation?></span>
            <span class="txt_xr">:</span>
          </div>
          <div class="col-md-7">
            <span class="txt_data_xr_person"><?php echo $res['member_occupation'];?></span>
          </div>
        </div>
        <?php } ?>
      <div class="row div_profile">
        <div class="col-md-5">
          <span class="txt_name_tel_person"><?=$txt_Mobile_telephone_number?></span>
          <span class="txt_xr">:</span>
        </div>
        <div class="col-md-7">
          <span class="txt_data_tel_person"><?php echo $res['member_phone'];?></span>
        </div>
      </div>
      <!-- <div class="row div_profile">
        <div class="col-md-5">
          <span class="txt_name_tel_person"><?=$txt_Telephone_number?></span>
          <span class="txt_xr">:</span>
        </div>
        <div class="col-md-7">
          <span class="txt_data_tel_person"><?php echo $res['member_cellphone'];?></span>
        </div>
      </div> -->

      <div class="row div_profile">
        <div class="col-md-5">
          <span class="txt_name_address_person"><?=$txt_Address?></span>
          <span class="txt_xr">:</span>
        </div>
        <div class="col-md-7">
          <span class="txt_data_address_person"><?php echo $res['member_address'];?></span>
        </div>
      </div>

      <div class="row div_profile">
        <div class="col-md-5">
          <span class="txt_name_city_person"><?=$txt_Country?></span>
          <span class="txt_xr">:</span>
        </div>
        <div class="col-md-7">
          <span class="txt_data_city_person">
            <?php
            $sql_country = "SELECT * FROM `Country` WHERE id = '".$res['country_id']."'";
            $query_country = $conn->query($sql_country);
            if($query_country->num_rows > 0){
              $rs = $query_country->fetch_assoc();
            }
            if($lang == "1"){
              echo $rs['name'];
            }elseif ($lang == "2") {
              echo $rs['name'];
            }else {
              echo $rs['name'];
            }
            ?>
          </span>
        </div>
      </div>

    <?php if($res['prov_id'] != "0"){ ?>
      <div class="row div_profile">
        <div class="col-md-5">
          <span class="txt_name_provice_person"><?=$txt_Province?></span>
          <span class="txt_xr">:</span>
        </div>
        <div class="col-md-7">

          <span class="txt_data_provice_person">
          <?php
          $sql_province = "SELECT * FROM `Province` WHERE prov_id = '".$res['prov_id']."'";
          $query_province = $conn->query($sql_province);
          if($query_province->num_rows > 0){
            $rl = $query_province->fetch_assoc();
          }
          if($lang == "1"){
            echo $rl['prov_name'];
          }elseif ($lang == "2") {
            echo $rl['prov_name_eng'];;
          }else {
            echo $rl['prov_name'];
          }


          ?>
        </span>

        </div>
      </div>
      <?php } ?>

      <div class="row div_profile_hx">
        <div class="col-md-5">
          <span class="txt_name_code_person"><?=$txt_Postcode?></span>
          <span class="txt_xr">:</span>
        </div>
        <div class="col-md-7">
          <span class="txt_data_code_person"><?php echo $res['member_postcode'];?></span>
        </div>
      </div>

    </div>
  </div>
  </div>

<?php if($_GET['page'] == "profile"){ ?>
  <div class="profile_mobile" style="display:none;">
  <span class="icon_hr_person"><img src="images/icon_person_profile.png" class="icon_person"></span>
  <span class="txt_hr_info"><?=$txt_Personal_information?></span>

  <div class="panel panel-default appeal_panel profile_box">
    <div class="panel-body">
      <?php
      $sql = "SELECT * FROM `Member` WHERE member_id = '".$_SESSION['member_id']."'";
      $query = $conn->query($sql);
      if($query->num_rows > 0){
        $res = $query->fetch_assoc();
      }

      $sql_comp = "SELECT * FROM `Member_comp` WHERE member_id = '".$_SESSION['member_id']."'";
      $query_comp = $conn->query($sql_comp);
      if($query_comp->num_rows > 0){
        $rc = $query_comp->fetch_assoc();
      }
      ?>
    <div class="row">
      <div class="col-md-12 col_profile">
        <?php if($res['member_type'] == 0){?>
        <span class="bg_image_profile">
          <?php
          $pathfile = "../data/img_member/".$_SESSION['member_id']."/".$res['member_img'];
          if(count(glob($pathfile)) > 0) {
            ?>
          <img src="../data/img_member/<?=$_SESSION['member_id'];?>/<?=$res['member_img'];?>" class="img_profile" style="<?php echo getPositionImage("../data/img_member/".$_SESSION['member_id']."/".$res['member_img'],120)?>">
            <?php }else { ?>
              <img src="images/profile_emp-01.svg" class="img_profile" style="<?php echo getPositionImage("images/profile_emp-01.svg",120)?>">
          <?php } ?>
        </span>
        <?php }else { ?>
          <span class="bg_image_profile">
            <?php
            $pathfile = "../data/img_membercom/".$rex['member_comp_id']."/".$rc['member_comp_img'];
            if(count(glob($pathfile)) > 0) {
            ?>
            <img src="../data/img_membercom/<?=$rc['member_comp_id'];?>/<?=$rc['member_comp_img'];?>" class="img_profile" style="<?php echo getPositionImage("../data/img_membercom/".$rc['member_comp_id']."/".$rc['member_comp_img'],120)?>">
              <?php }else { ?>
                <img src="images/profile_emp-01.svg" class="img_profile" style="<?php echo getPositionImage("images/profile_emp-01.svg",120)?>">
              <?php } ?>
          </span>
        <?php } ?>
        <div class="edit_profile"><a onclick="show_modal_profile();" style="cursor: pointer;"><?=$txt_edit_profile?></a></div>
      </div>
    </div>
    <?php if($res['member_type'] == 1){ ?>
    <div class="row div_profile_hr">
      <div class="col-md-12">
        <span class="icon_name_office"><img src="images/icon_invite_home.png"></span>
        <span class="edit_name_office"><?php echo $rc['member_comp_name'];?></span>
      </div>
    </div>

    <div class="row div_profile">
      <div class="col-md-5 col-sm-5 col-xs-12">
        <span class="txt_name_branch"><?=$txt_Branch?></span>
        <span class="txt_xr txt_xrs">:</span>
      </div>
      <div class="col-md-7 col-sm-7 col-xs-12">
        <span class="txt_xrz" style="display:none;">:</span>
        <span class="txt_data_branch"><?php echo $rc['member_comp_branch'];?></span>
      </div>
    </div>

    <div class="row div_profile">
      <div class="col-md-5 col-sm-5 col-xs-12">
        <span class="txt_name_xr"><?=$txt_Registration_Number?></span>
        <span class="txt_xr txt_xrs">:</span>
      </div>
      <div class="col-md-7 col-sm-7 col-xs-12">
        <span class="txt_xrz" style="display:none;">:</span>
        <span class="txt_data_xr"><?php echo $rc['member_comp_taxid'];?></span>
      </div>
    </div>

    <div class="row div_profile">
      <div class="col-md-5 col-sm-5 col-xs-12">
        <span class="txt_name_xr"><?=$txt_Type_of_business?></span>
        <span class="txt_xr txt_xrs">:</span>
      </div>
      <div class="col-md-7 col-sm-7 col-xs-12">
        <span class="txt_xrz" style="display:none;">:</span>
        <?php    if($lang == "1"){
              if($res['member_business'] == 0){
                $member_business = "ไม่ระบุ";
              }elseif ($res['member_business'] == 1) {
                $member_business = "นำเข้า";
              }elseif ($res['member_business'] == 2) {
                $member_business = "ส่งออก";
              }else {
                $member_business = "-";
              }
            }elseif ($lang == "2") {
              if($res['member_business'] == 0){
                $member_business = "Unknown";
              }elseif ($res['member_business'] == 1) {
                $member_business = "Import";
              }elseif ($res['member_business'] == 2) {
                $member_business = "Export";
              }else {
                $member_business = "-";
              }
            }else {
              if($res['member_business'] == 0){
                $member_business = "ไม่ระบุ";
              }elseif ($res['member_business'] == 1) {
                $member_business = "นำเข้า";
              }elseif ($res['member_business'] == 2) {
                $member_business = "ส่งออก";
              }else {
                $member_business = "-";
              }
            } ?>
        <span class="txt_data_xr"><?php echo $member_business;?></span>
      </div>
    </div>

    <div class="row div_profile">
      <div class="col-md-5 col-sm-5 col-xs-12">
        <span class="txt_name_tel"><?=$txt_Telephone_number?></span>
        <span class="txt_xr txt_xrs">:</span>
      </div>
      <div class="col-md-7 col-sm-7 col-xs-12">
        <span class="txt_xrz" style="display:none;">:</span>
        <span class="txt_data_tel"><?php echo $rc['member_comp_phone'];?></span>
      </div>
    </div>

    <div class="row div_profile">
      <div class="col-md-5 col-sm-5 col-xs-12">
        <span class="txt_name_fix"><?=$txt_Fax_number?></span>
        <span class="txt_xr txt_xrs">:</span>
      </div>
      <div class="col-md-7 col-sm-7 col-xs-12">
        <span class="txt_xrz" style="display:none;">:</span>
        <span class="txt_data_fix"><?php echo $rc['member_comp_fax'];?></span>
      </div>
    </div>

    <div class="row div_profile">
      <div class="col-md-5 col-sm-5 col-xs-12">
        <span class="txt_name_address"><?=$txt_Address?></span>
        <span class="txt_xr txt_xrs">:</span>
      </div>
      <div class="col-md-7 col-sm-7 col-xs-12">
        <span class="txt_xrz" style="display:none;">:</span>
        <span class="txt_data_address"><?php echo $rc['member_comp_address'];?></span>
      </div>
    </div>

    <div class="row div_profile">
      <div class="col-md-5 col-sm-5 col-xs-12">
        <span class="txt_name_city"><?=$txt_Country?></span>
        <span class="txt_xr txt_xrs">:</span>
      </div>
      <div class="col-md-7 col-sm-7 col-xs-12">
        <span class="txt_xrz" style="display:none;">:</span>
        <span class="txt_data_city">
          <?php
          $sql_country_com = "SELECT * FROM `Country` WHERE id = '".$rc['country_id']."'";
          $query_country_com = $conn->query($sql_country_com);
          if($query_country_com->num_rows > 0){
            $rx = $query_country_com->fetch_assoc();
          }
          if($lang == "1"){
            echo $rx['name'];
          }elseif ($lang == "2") {
            echo $rx['name'];
          }else {
            echo $rx['name'];
          }
          ?>
        </span>
      </div>
    </div>

  <?php if($rc['prov_id'] != "0"){ ?>
    <div class="row div_profile">
      <div class="col-md-5 col-sm-5 col-xs-12">
        <span class="txt_name_provice"><?=$txt_Province?></span>
        <span class="txt_xr txt_xrs">:</span>
      </div>
      <div class="col-md-7 col-sm-7 col-xs-12">
        <span class="txt_xrz" style="display:none;">:</span>
        <span class="txt_data_provice">
          <?php
          $sql_province_com = "SELECT * FROM `Province` WHERE prov_id = '".$rc['prov_id']."'";
          $query_province_com = $conn->query($sql_province_com);
          if($query_province_com->num_rows > 0){
            $rlx = $query_province_com->fetch_assoc();
          }
          if($lang == "1"){
            echo $rlx['prov_name'];
          }elseif ($lang == "2") {
            echo $rlx['prov_name_eng'];;
          }else {
            echo $rlx['prov_name'];
          }
          ?>
        </span>
      </div>
    </div>
    <?php } ?>

    <div class="row div_profile">
      <div class="col-md-5 col-sm-5 col-xs-12">
        <span class="txt_name_code"><?=$txt_Postcode?></span>
        <span class="txt_xr txt_xrs">:</span>
      </div>
      <div class="col-md-7 col-sm-7 col-xs-12">
        <span class="txt_xrz" style="display:none;">:</span>
        <span class="txt_data_code"><?php echo $rc['member_comp_postcode'];?></span>
      </div>
    </div>

    <!-- ข้อมูลบริษัท -->
    <?php } ?>

    <div class="row div_profile_hr">
      <div class="col-md-12">
        <span class="icon_name_person"><img src="images/icon_invite_person.png"></span>
        <span class="edit_name_person"><?php if($lang == "1"){ echo "คุณ";}elseif($lang == "2"){ echo "Sir";}else{ echo "คุณ";}?> <?php echo $res['member_fname'];?>&nbsp;&nbsp;<?php echo $res['member_lname'];?> </span>
      </div>
    </div>

    <div class="row div_profile">
      <div class="col-md-5 col-sm-5 col-xs-12">
        <span class="txt_code_person"><?=$txt_Identification?></span>
        <span class="txt_xr txt_xrs">:</span>
      </div>
      <div class="col-md-7 col-sm-7 col-xs-12">
        <span class="txt_xrz" style="display:none;">:</span>
        <span class="txt_data_person"><?php echo $res['member_cid'];?></span>
      </div>
    </div>
    <div class="row div_profile">
      <div class="col-md-5 col-sm-5 col-xs-12">
        <span class="txt_code_person"><?=$txt_Gender?></span>
        <span class="txt_xr">:</span>
      </div>
      <div class="col-md-7 col-sm-7 col-xs-12">
        <span class="txt_data_person"><?php
        if($res['member_sex'] == "1"){
          $sex = $txt_Male;
        }elseif ($res['member_sex'] == "2") {
          $sex = $txt_Female;
        }

         echo $sex;
         ?></span>
      </div>
    </div>
    <?php if($res['member_type'] == 1){?>
    <div class="row div_profile">
      <div class="col-md-5 col-sm-5 col-xs-12">
        <span class="txt_name_xr_person"><?=$txt_Position?></span>
        <span class="txt_xr txt_xrs">:</span>
      </div>
      <div class="col-md-7 col-sm-7 col-xs-12">
        <span class="txt_data_xr_person"><?php echo $res['member_position'];?></span>
      </div>
    </div>
    <?php }else { ?>
      <div class="row div_profile">
        <div class="col-md-5 col-sm-5 col-xs-12">
          <span class="txt_name_xr_person"><?=$txt_Occupation?></span>
          <span class="txt_xr txt_xrs">:</span>
        </div>
        <div class="col-md-7 col-sm-7 col-xs-12">
          <span class="txt_xrz" style="display:none;">:</span>
          <span class="txt_data_xr_person"><?php echo $res['member_occupation'];?></span>
        </div>
      </div>
      <?php } ?>
    <div class="row div_profile">
      <div class="col-md-5 col-sm-5 col-xs-12">
        <span class="txt_name_tel_person"><?=$txt_Mobile_telephone_number?></span>
        <span class="txt_xr txt_xrs">:</span>
      </div>
      <div class="col-md-7 col-sm-7 col-xs-12">
        <span class="txt_data_tel_person"><?php echo $res['member_phone'];?></span>
      </div>
    </div>
    <div class="row div_profile">
      <div class="col-md-5 col-sm-5 col-xs-12">
        <span class="txt_name_tel_person"><?=$txt_Telephone_number?></span>
        <span class="txt_xr txt_xrs">:</span>
      </div>
      <div class="col-md-7 col-sm-7 col-xs-12">
        <span class="txt_data_tel_person"><?php echo $res['member_cellphone'];?></span>
      </div>
    </div>
    <div class="row div_profile">
      <div class="col-md-5 col-sm-5 col-xs-12">
        <span class="txt_name_address_person"><?=$txt_Address?></span>
        <span class="txt_xr txt_xrs">:</span>
      </div>
      <div class="col-md-7 col-sm-7 col-xs-12">
        <span class="txt_xrz" style="display:none;">:</span>
        <span class="txt_data_address_person"><?php echo $res['member_address'];?></span>
      </div>
    </div>

    <div class="row div_profile">
      <div class="col-md-5 col-sm-5 col-xs-12">
        <span class="txt_name_city_person"><?=$txt_Country?></span>
        <span class="txt_xr txt_xrs">:</span>
      </div>
      <div class="col-md-7 col-sm-7 col-xs-12">
        <span class="txt_xrz" style="display:none;">:</span>
        <span class="txt_data_city_person">
          <?php
          $sql_country = "SELECT * FROM `Country` WHERE id = '".$res['country_id']."'";
          $query_country = $conn->query($sql_country);
          if($query_country->num_rows > 0){
            $rs = $query_country->fetch_assoc();
          }
          if($lang == "1"){
            echo $rs['name'];
          }elseif ($lang == "2") {
            echo $rs['name'];
          }else {
            echo $rs['name'];
          }
          ?>
        </span>
      </div>
    </div>

  <?php if($res['prov_id'] != "0"){ ?>
    <div class="row div_profile">
      <div class="col-md-5 col-sm-5 col-xs-12">
        <span class="txt_name_provice_person"><?=$txt_Province?></span>
        <span class="txt_xr txt_xrs">:</span>
      </div>
      <div class="col-md-7 col-sm-7 col-xs-12">
        <span class="txt_xrz" style="display:none;">:</span>

        <span class="txt_data_provice_person">
        <?php
        $sql_province = "SELECT * FROM `Province` WHERE prov_id = '".$res['prov_id']."'";
        $query_province = $conn->query($sql_province);
        if($query_province->num_rows > 0){
          $rl = $query_province->fetch_assoc();
        }
        if($lang == "1"){
          echo $rl['prov_name'];
        }elseif ($lang == "2") {
          echo $rl['prov_name_eng'];;
        }else {
          echo $rl['prov_name'];
        }
        ?>
      </span>

      </div>
    </div>
    <?php } ?>

    <div class="row div_profile_hx">
      <div class="col-md-5 col-sm-5 col-xs-12">
        <span class="txt_name_code_person"><?=$txt_Postcode?></span>
        <span class="txt_xr txt_xrs">:</span>
      </div>
      <div class="col-md-7 col-sm-7 col-xs-12">
        <span class="txt_xrz" style="display:none;">:</span>
        <span class="txt_data_code_person"><?php echo $res['member_postcode'];?></span>
      </div>
    </div>

  </div>
</div>
</div>
<?php } ?>
</div>

</form>

<form method="post" action="https://care.ditp.go.th/frontend/index.php?page=profile" enctype="multipart/form-data" id="modal_profile_form">
<div class="modal fade" id="modal_profile" tabindex="-1" role="dialog" aria-labelledby="modal_profile">
  <div class="modal-dialog modal_profile_edit" role="document" style="width:900px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: 10;"><span aria-hidden="true"><img src="images/btn-exit.png"></span></button>
        <h4 class="modal-title"><span class="icon_hr_person"><img src="images/icon_person_profile.png" class="icon_person"></span>
        <span class="txt_hr_info txt-alert"><?=$txt_edit_profile?></span></h4>
      </div>
      <div class="modal-body edit_profile_sty">
        <div class="panel panel-default appeal_panel">
          <div class="panel-body">
            <?php
            $sql = "SELECT * FROM `Member` WHERE member_id = '".$_SESSION['member_id']."'";
            $query = $conn->query($sql);
            if($query->num_rows > 0){
              $res = $query->fetch_assoc();
            }
            $sql_comp = "SELECT * FROM `Member_comp` WHERE member_id = '".$_SESSION['member_id']."'";
            $query_comp = $conn->query($sql_comp);
            if($query_comp->num_rows > 0){
              $rc = $query_comp->fetch_assoc();
            }
            function getPositionImage_modal($emp_img_path,$size){
              list($width, $height) = getimagesize($emp_img_path);
              $ratio = $width/$height; // width/height

              if( $ratio > 1) {
                  $width = $size*$ratio;
                  $height = $size;
                  $css = " width:auto; height:100%; margin-left:-".(($width*0.5)-($size*0.5))."px";
              }
              else {
              $width = $size;
              $height = $size/$ratio;
                    $css = "height:auto; width:100%; top:0;";
              }
              // return $height;
              return $css;
            }
            ?>
          <div class="row">
            <input type="hidden" class="prov_id_hidden" value="<?=$res['prov_id']?>">
            <input type="hidden" class="prov_id_com_hidden" value="<?=$rc['prov_id']?>">
            <input type="hidden" name="member_type" class="form-control member_type" value="<?php echo $res['member_type'];?>">
            <div class="col-md-12 col_profile">
              <?php if($res['member_type'] == 0){?>

              <div class="bg_image_profile">
                <?php
                $pathfile = "../data/img_member/".$_SESSION['member_id']."/".$res['member_img'];
                if(count(glob($pathfile)) > 0) {
                  ?>
                  <input type="hidden" class="pathfile_profile" value="../data/img_member/<?=$_SESSION['member_id'];?>/<?=$res['member_img'];?>">
                <img src="../data/img_member/<?=$_SESSION['member_id'];?>/<?=$res['member_img'];?>" class="img_profile_edit" style="<?php echo getPositionImage_modal("../data/img_member/".$_SESSION['member_id']."/".$rc['member_img'],120)?>">
                  <?php }else { ?>
                    <input type="hidden" class="pathfile_profile" value="images/profile_emp-01.svg">
                    <img src="images/profile_emp-01.svg" class="img_profile_edit" style="<?php echo getPositionImage_modal("images/profile_emp-01.svg",120)?>">
                <?php } ?>
                  <input type="file" name="file_profile" class="file_profile" style="display:none;" accept="image/x-png, image/gif, image/jpeg">
                  <input type="hidden" name="name_file_edit" class="name_file_edit">
              </div>
              <a onclick="click_edit_img_profile();" style="cursor: pointer;"><img src="images/icon_camera.png" class="icon_camera"></a>
              <?php }else { ?>
                <div class="bg_image_profile">

                  <?php
                  $pathfile = "../data/img_membercom/".$rc['member_comp_id']."/".$rc['member_comp_img'];
                  if(count(glob($pathfile)) > 0) {
                    ?>
                    <input type="hidden" class="pathfile_profile" value="../data/img_membercom/<?=$rc['member_comp_id'];?>/<?=$rc['member_comp_img'];?>">
                  <img src="../data/img_membercom/<?=$rc['member_comp_id'];?>/<?=$rc['member_comp_img'];?>" class="img_profile_edit" style="<?php echo getPositionImage_modal("../data/img_membercom/".$rc['member_comp_id']."/".$rc['member_comp_img'],120)?>">
                    <?php }else { ?>
                      <input type="hidden" class="pathfile_profile" value="images/profile_emp-01.svg">
                      <img src="images/profile_emp-01.svg" class="img_profile_edit" style="<?php echo getPositionImage_modal("images/profile_emp-01.svg",120)?>">
                  <?php } ?>
                    <input type="file" name="file_profile" class="file_profile" style="display:none;" accept="image/x-png, image/gif, image/jpeg">
                    <input type="hidden" name="name_file_edit" class="name_file_edit">
                </div>
                <a onclick="click_edit_img_profile();" style="cursor: pointer;"><img src="images/icon_camera.png" class="icon_camera"></a>
              <?php } ?>
            </div>
          </div>
          <?php if($res['member_type'] == 1){
            $sql_comp = "SELECT * FROM `Member_comp` WHERE member_id = '".$_SESSION['member_id']."'";
            $query_comp = $conn->query($sql_comp);
            if($query_comp->num_rows > 0){
              $rc = $query_comp->fetch_assoc();
            }
            ?>
          <div class="row div_profile_hr">
            <div class="col-md-5 col-sm-5 col-xs-12">
              <span class="edit_name_office_"><?=$txt_Company_name_ex?></span>
              <span style="color:#E74C3C;">*</span>
              <span class="txt_xr xr-1">:</span>
            </div>
            <div class="col-md-7 col-sm-7 col-xs-12">
              <input type="text" name="member_comp_name" class="form-control member_comp_name" value="<?php echo $rc['member_comp_name'];?>">
            </div>
          </div>

          <div class="row div_profile">
            <div class="col-md-5 col-sm-5 col-xs-12">
              <span class="txt_name_branch"><?=$txt_Branch?></span>
              <span style="color:#E74C3C;">*</span>
              <span class="txt_xr xr-1">:</span>
            </div>
            <div class="col-md-7 col-sm-7 col-xs-12">
              <input type="text" name="member_comp_branch" class="form-control member_comp_branch" value="<?php echo $rc['member_comp_branch'];?>">
            </div>
          </div>

          <div class="row div_profile">
            <div class="col-md-5 col-sm-5 col-xs-12">
              <span class="txt_name_xr"><?=$txt_Registration_Number?></span>
              <span style="color:#E74C3C;">*</span>
              <span class="txt_xr xr-1">:</span>
            </div>
            <div class="col-md-7 col-sm-7 col-xs-12">
              <input type="text" disabled name="member_comp_taxid" class="form-control member_comp_taxid" value="<?php echo $rc['member_comp_taxid'];?>">
            </div>
          </div>

          <div class="row div_profile">
            <div class="col-md-5 col-sm-5 col-xs-12">
              <span class="txt_name_xr"><?=$txt_Type_of_business?></span>
              <span style="color:#E74C3C;">*</span>
              <span class="txt_xr xr-1">:</span>
            </div>
            <div class="col-md-7 col-sm-7 col-xs-12">
              <select name="sel_business_person_office" class="selectpicker form-control sel_business_person_office" id="sel_business_person_office">
                <option value="">
                 --- <?php if($lang == "1"){ echo "เลือกประเภทธุรกิจ";}elseif($lang == "2"){ echo "Choose business category";}else{ echo "เลือกประเภทธุรกิจ";}?> ---
                </option>
                <option value="0" <?php if($res['member_business'] == 0){ echo "selected";}?>><?php if($lang == "1"){ echo "ไม่ระบุ";}elseif($lang == "2"){ echo "Unknown";}else{ echo "ไม่ระบุ";}?></option>
                <option value="1" <?php if($res['member_business'] == 1){ echo "selected";}?>><?php if($lang == "1"){ echo "นำเข้า";}elseif($lang == "2"){ echo "Import";}else{ echo "นำเข้า";}?></option>
                <option value="2" <?php if($res['member_business'] == 2){ echo "selected";}?>><?php if($lang == "1"){ echo "ส่งออก";}elseif($lang == "2"){ echo "Export";}else{ echo "ส่งออก";}?></option>
              </select>
            </div>
          </div>

          <div class="row div_profile">
            <div class="col-md-5 col-sm-5 col-xs-12">
              <span class="txt_name_tel"><?=$txt_Telephone_number?></span>
              <span style="color:#E74C3C;">*</span>
              <span class="txt_xr xr-1">:</span>
            </div>
            <div class="col-md-7 col-sm-7 col-xs-12">
              <input type="text" name="member_comp_phone" class="form-control member_comp_phone" value="<?php echo $rc['member_comp_phone'];?>">
            </div>
          </div>

          <div class="row div_profile">
            <div class="col-md-5 col-sm-5 col-xs-12">
              <span class="txt_name_fix"><?=$txt_Fax_number?></span>
              <span class="txt_xr xr-1">:</span>
            </div>
            <div class="col-md-7 col-sm-7 col-xs-12">
              <input type="text" name="member_comp_fax" class="form-control member_comp_fax" value="<?php echo $rc['member_comp_fax'];?>">
            </div>
          </div>

          <div class="row div_profile">
            <div class="col-md-5 col-sm-5 col-xs-12">
              <span class="txt_name_address"><?=$txt_Address?></span>
              <span style="color:#E74C3C;">*</span>
              <span class="txt_xr xr-1">:</span>
            </div>
            <div class="col-md-7 col-sm-7 col-xs-12">
              <textarea name="member_comp_address" class="form-control member_comp_address" rows="4"><?php echo $rc['member_comp_address'];?></textarea>
            </div>
          </div>

          <div class="row div_profile">
            <div class="col-md-5 col-sm-5 col-xs-12">
              <span class="txt_name_city"><?=$txt_Country?></span>
              <span style="color:#E74C3C;">*</span>
              <span class="txt_xr xr-1">:</span>
            </div>
            <div class="col-md-7 col-sm-7 col-xs-12">
                <select name="country_id_com" id="country_id_com" class="selectpicker form-control country_id_com" data-live-search="true">
                  <option value="">
                   --- <?=$txt_Choose_your_country?> ---
                  </option>
                <?php
                $sql_country_com = "SELECT * FROM `Country` ORDER BY name";
                $query_country_com = $conn->query($sql_country_com);
                if($query_country_com->num_rows > 0){
                  while ($rx = $query_country_com->fetch_assoc()) { ?>
                    <option value="<?php echo $rx['id']?>"<?php if($rc["country_id"]==$rx['id']){ echo 'selected';}?>>
                      <?php  if($lang == "1"){
                              echo $rx['name'];
                            }elseif ($lang == "2") {
                              echo $rx['name'];
                            }else {
                              echo $rx['name'];
                            }?></option>
                    <?php
                  }
                }
                ?>
              </select>
            </div>
          </div>

          <div class="row div_profile prov_id_com">
            <div class="col-md-5 col-sm-5 col-xs-12">
              <span class="txt_name_provice"><?=$txt_Province?></span>

              <span class="txt_xr xr-1">:</span>
            </div>
            <div class="col-md-7 col-sm-7 col-xs-12">

                <select name="prov_id_com" id="prov_id_com" class="selectpicker form-control" data-live-search="true">
                  <option value="">
                   --- <?=$txt_Choose_your_province?> ---
                  </option>
                <?php
                $sql_province_com = "SELECT * FROM `Province`";
                $query_province_com = $conn->query($sql_province_com);
                if($query_province_com->num_rows > 0){
                  while ($rlx = $query_province_com->fetch_assoc()) { ?>
                    <option value="<?php echo $rlx['prov_id']?>"<?php if($rc["prov_id"]==$rlx['prov_id']){ echo 'selected';}?>>
                      <?php   if($lang == "1"){
                                echo $rlx['prov_name'];
                              }elseif ($lang == "2") {
                                echo $rlx['prov_name_eng'];;
                              }else {
                                echo $rlx['prov_name'];
                              }?></option>
                  <?php
                  }
                }
                ?>
              </select>

            </div>
          </div>

          <div class="row div_profile">
            <div class="col-md-5 col-sm-5 col-xs-12">
              <span class="txt_name_code"><?=$txt_Postcode?></span>
              <span style="color:#E74C3C;">*</span>
              <span class="txt_xr xr-1">:</span>
            </div>
            <div class="col-md-7 col-sm-7 col-xs-12">
              <input type="text" name="member_comp_postcode" class="form-control member_comp_postcode" value="<?php echo $rc['member_comp_postcode'];?>">
            </div>
          </div>
          <hr>
          <!-- ข้อมูลบริษัท -->
          <?php } ?>

          <div class="row div_profile_hr">
            <div class="col-md-5 col-sm-5 col-xs-12">
              <span class="edit_name_person_"><?php if($lang == "1"){ echo "ชื่อ";}elseif($lang == "2"){ echo "First name";}else{ echo "ชื่อ";}?></span>
              <span style="color:#E74C3C;">*</span>
              <span class="txt_xr xr-1">:</span>
            </div>
            <div class="col-md-7 col-sm-7 col-xs-12">
              <input type="text" name="name_profile" class="form-control name_profile" value="<?php echo $res['member_fname'];?>" disabled>
            </div>
          </div>

          <div class="row div_profile">
            <div class="col-md-5 col-sm-5 col-xs-12">
              <span class="edit_lname_person"><?php if($lang == "1"){ echo "นามสกุล";}elseif($lang == "2"){ echo "Last names";}else{ echo "นามสกุล";}?></span>
              <span style="color:#E74C3C;">*</span>
              <span class="txt_xr xr-1">:</span>
            </div>
            <div class="col-md-7 col-sm-7 col-xs-12">
                <input type="text" name="lastname_profile" class="form-control lastname_profile" value="<?php echo $res['member_lname'];?>" disabled>
            </div>
          </div>

          <div class="row div_profile">
            <div class="col-md-5 col-sm-5 col-xs-12">
              <span class="txt_code_person"><?=$txt_Identification?></span>
              <span style="color:#E74C3C;">*</span>
              <span class="txt_xr xr-1">:</span>
            </div>
            <div class="col-md-7 col-sm-7 col-xs-12">
              <input type="text" name="member_cid" id="member_cid" class="form-control member_cid" disabled value="<?php echo $res['member_cid'];?>" 
              <?php if($res['member_cid'] != ''){ ?>
                
              <?php } ?>
              >
            </div>
          </div>
          <!-- <div class="row div_profile">
            <div class="col-md-5 col-sm-5 col-xs-12">
              <span class="txt_code_person"><?=$txt_Gender?></span>
              <span style="color:#E74C3C;">*</span>
              <span class="txt_xr xr-1">:</span>
            </div>
            <div class="col-md-7 col-sm-7 col-xs-12">
              <select name="sex" id="sex" class="selectpicker form-control sex">
                <option value="1" <?php if($res["member_sex"]==1){ echo 'selected';}?>><?=$txt_Male?></option>
                <option value="2" <?php if($res["member_sex"]==2){ echo 'selected';}?>><?=$txt_Female?></option>
            </select>
            </div>
          </div> -->
          <?php if($res['member_type'] == 1){?>
          <div class="row div_profile">
            <div class="col-md-5 col-sm-5 col-xs-12">
              <span class="txt_name_xr_person"><?=$txt_Position?></span>
              <span style="color:#E74C3C;">*</span>
              <span class="txt_xr xr-1">:</span>
            </div>
            <div class="col-md-7 col-sm-7 col-xs-12">
              <input type="text" name="member_position" class="form-control member_position" value="<?php echo $res['member_position'];?>">
            </div>
          </div>
          <?php }else { ?>
            <div class="row div_profile">
              <div class="col-md-5 col-sm-5 col-xs-12">
                <span class="txt_name_xr_person"><?=$txt_Occupation?></span>
                <span style="color:#E74C3C;">*</span>
                <span class="txt_xr xr-1">:</span>
              </div>
              <div class="col-md-7 col-sm-7 col-xs-12">
                <input type="text" name="member_occupation" class="form-control member_occupation" value="<?php echo $res['member_occupation'];?>">
              </div>
            </div>
            <?php } ?>
          <div class="row div_profile">
            <div class="col-md-5 col-sm-5 col-xs-12">
              <span class="txt_name_tel_person"><?=$txt_Mobile_telephone_number?></span>
              <span style="color:#E74C3C;">*</span>
              <span class="txt_xr xr-1">:</span>
            </div>
            <div class="col-md-7 col-sm-7 col-xs-12">
              <div id="tel1">
                <input type="tel" name="member_phone" id="member_phone" class="form-control member_phone number_only" value="<?php echo $res['member_phone'];?>">
                <input type="hidden" name="tel_country_code">
                <input type="hidden" name="tel_code">
              </div>
            </div>
          </div>

          <!-- <div class="row div_profile">
            <div class="col-md-5 col-sm-5 col-xs-12">
              <span class="txt_name_tel_person"><?=$txt_Telephone_number?></span>
              <span style="color:#E74C3C;">*</span>
              <span class="txt_xr xr-1">:</span>
            </div>
            <div class="col-md-7 col-sm-7 col-xs-12">
              <input type="text" name="member_cellphone" id="member_cellphone" class="form-control member_cellphone" value="<?php echo $res['member_cellphone'];?>">
            </div>
          </div> -->

          <div class="row div_profile">
            <div class="col-md-5 col-sm-5 col-xs-12">
              <span class="txt_name_address_person"><?=$txt_Address?></span>
              <span style="color:#E74C3C;">*</span>
              <span class="txt_xr xr-1">:</span>
            </div>
            <div class="col-md-7 col-sm-7 col-xs-12">
              <textarea name="member_address" class="form-control member_address" rows="4"><?php echo $res['member_address'];?></textarea>
            </div>
          </div>

          <div class="row div_profile">
            <div class="col-md-5 col-sm-5 col-xs-12">
              <span class="txt_name_city_person"><?=$txt_Country?></span>
              <span style="color:#E74C3C;">*</span>
              <span class="txt_xr xr-1">:</span>
            </div>
            <div class="col-md-7 col-sm-7 col-xs-12">
              <select name="country_id" id="country_id" class="selectpicker form-control country_id" data-live-search="true">
                <option value="">
                 --- <?=$txt_Choose_your_country?> ---
                </option>
              <?php
              $sql_country = "SELECT * FROM `Country` ORDER BY name";
              $query_country = $conn->query($sql_country);
              if($query_country->num_rows > 0){
                while ($rs = $query_country->fetch_assoc()) { ?>
                  <option value="<?php echo $rs['id']?>"<?php if($res["country_id"]==$rs['id']){ echo 'selected';}?>>
                    <?php if($lang == "1"){
                            echo $rs['name'];
                          }elseif ($lang == "2") {
                            echo $rs['name'];
                          }else {
                            echo $rs['name'];
                          }?></option>
                  <?php
                }
              }
              ?>
            </select>
            </div>
          </div>
          <div class="row div_profile prov_id">
            <div class="col-md-5 col-sm-5 col-xs-12">
              <span class="txt_name_provice_person"><?=$txt_Province?></span>

              <span class="txt_xr xr-1">:</span>
            </div>
            <div class="col-md-7 col-sm-7 col-xs-12">

                <select name="prov_id" id="prov_id" class="selectpicker form-control " data-live-search="true">
                  <option value="">
                   --- <?=$txt_Choose_your_province?> ---
                  </option>
                <?php
                $sql_province = "SELECT * FROM `Province`";
                $query_province = $conn->query($sql_province);
                if($query_province->num_rows > 0){
                  while ($rl = $query_province->fetch_assoc()) { ?>
                    <option value="<?php echo $rl['prov_id']?>"<?php if($res["prov_id"]==$rl['prov_id']){ echo 'selected';}?>>
                      <?php  if($lang == "1"){
                                echo $rl['prov_name'];
                              }elseif ($lang == "2") {
                                echo $rl['prov_name_eng'];;
                              }else {
                                echo $rl['prov_name'];
                              }?></option>
                  <?php
                  }
                }
                ?>
              </select>

            </div>
          </div>



          <div class="row div_profile_hx">
            <div class="col-md-5 col-sm-5 col-xs-12">
              <span class="txt_name_code_person"><?=$txt_Postcode?></span>
              <span style="color:#E74C3C;">*</span>
              <span class="txt_xr xr-1">:</span>
            </div>
            <div class="col-md-7 col-sm-7 col-xs-12">
              <input type="text" name="member_postcode" id="member_postcode" class="form-control member_postcode" value="<?php echo $res['member_postcode'];?>">
            </div>
          </div>

        </div>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-cancel" data-dismiss="modal"><?php if($lang == "1"){ echo "ยกเลิก";}elseif($lang == "2"){ echo "Cancel";}else{ echo "ยกเลิก";}?></button>
        <button type="button" class="btn btn-success edit_profile_modal" name="edit_profile_modal"><?php if($lang == "1"){ echo "บันทึก";}elseif($lang == "2"){ echo "Confirm";}else{ echo "บันทึก";}?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</form>



<form method="post" action="#" id="modal_repasssword" enctype="multipart/form-data">
		<div class="modal fade" id="modal_chk_repassword" tabindex="-1" role="dialog" aria-labelledby="modal_chk_repasswordr" style="padding:0px;">
			<div class="modal-dialog modal_repassword" role="document" style="width:600px;">
				<div class="modal-content" style="border-radius: 11px 11px 11px 11px;">
          <div class="modal-header" style="padding-bottom:0px;">
            <div class="modal-title add-group-modal-title">
              <div class="close_modal"> <a href="javascript:void(0);" data-dismiss="modal" aria-hidden="true"><img src="images/btn-exit.png"></a></div>
            </div>
          </div>
					<div class="modal-body">
            <div class="row" style="text-align:center;">
            <div class="txt_hr_repassword"><?=$txt_Change_password?></div>
          </div>
          <div class="row" style="margin-top:15px;">
          <div class="col-md-3"><?php if($lang == "1"){ echo "รหัสเดิม";}elseif($lang == "2"){ echo "Original Password";}else{ echo "รหัสเดิม";}?>
            <span class="txt_xr xr_modal">:</span>
          </div>
          <div class="col-md-9"><input type="Password" class="form-control txt_password"></div>
          </div>
          <div class="row" style="margin-top:15px;">
          <div class="col-md-3"><?php if($lang == "1"){ echo "รหัสใหม่";}elseif($lang == "2"){ echo "New Password";}else{ echo "รหัสใหม่";}?>
            <span class="txt_xr xr_modal">:</span>
          </div>
          <div class="col-md-9"><input type="Password" class="form-control txt_newpassword"></div>
          </div>

          <div class="row" style="margin-top:5px;">
          <div class="col-md-3"></div>
          <div class="col-md-9"><span style="color:#E74C3C;"><?=$txt_must_contain?></span></div>
          </div>

          <div class="row" style="margin-top:15px;">
          <div class="col-md-3"><?=$txt_Cpassword?>
            <span class="txt_xr xr_modal">:</span>
          </div>
          <div class="col-md-9"><input type="Password" class="form-control txt_newpassword_con"></div>
          </div>
				</div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?php if($lang == "1"){ echo "ยกเลิก";}elseif($lang == "2"){ echo "Cancel";}else{ echo "ยกเลิก";}?></button>
          <button type="button" class="btn btn-success edit_password_modal"><?php if($lang == "1"){ echo "บันทึก";}elseif($lang == "2"){ echo "Confirm";}else{ echo "บันทึก";}?></button>
        </div>
			</div>
		</div>
	</div>
</form>
</div>

<div class="modal fade" id="modal_alert" tabindex="-1" role="dialog" aria-labelledby="modal_chk_repasswordr" style="padding:0px;">
			<div class="modal-dialog modal_repassword" role="document" style="width:600px;">
				<div class="modal-content" style="border-radius: 11px 11px 11px 11px;">
          <div class="modal-header" style="padding-bottom:0px;">
            <div class="modal-title add-group-modal-title">
              <div class="close_modal"> <a href="javascript:void(0);" data-dismiss="modal" aria-hidden="true"><img src="images/btn-exit.png"></a></div>
            </div>
          </div>
					<div class="modal-body">
            <div class="row" style="text-align:center;">
            <div class="txt_hr_repassword">กรุณากรอกข้อมูลให้ครบเพื่อใช้งานต่อไป</div>
          </div>
				</div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success"  data-dismiss="modal"><?php if($lang == "1"){ echo "ตกลง";}elseif($lang == "2"){ echo "Ok";}else{ echo "ตกลง";}?></button>
        </div>
			</div>
		</div>
	</div>
<script src="assets/intlTelInput/js/intlTelInput.js"></script>
<script>

  var editname_last = <?php echo $res['member_type']?>;
  if(editname_last != 0){
    $('.name_profile').removeAttr('disabled');
    $('.lastname_profile').removeAttr('disabled');
    $('.member_cid').removeAttr('disabled')
  }


  var input = document.querySelector("#member_phone");
  window.intlTelInput(input, {
            initialCountry: "<?=$res['tel_country_code']?>",
        });

  function setInputFilter(textbox, inputFilter) {
    ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
      textbox.addEventListener(event, function() {
        if (inputFilter(this.value)) {
          this.oldValue = this.value;
          this.oldSelectionStart = this.selectionStart;
          this.oldSelectionEnd = this.selectionEnd;
        } else if (this.hasOwnProperty("oldValue")) {
          this.value = this.oldValue;
          this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
        } else {
          this.value = "";
        }
      });
    });
  }

$( document ).ready(function() {

  var country_id = "<?php echo $res['country_id']?>";
  if(country_id != 162){
    $('.modal_profile_edit .txt_code_person').text('Passport ID');
    $('.txt_code_person:eq(0)').text('Passport ID');
  }

  setInputFilter(document.getElementById("member_postcode"), function(value) {
      return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 100000);
  });
  setInputFilter(document.getElementById("member_cid"), function(value) {
      return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 10000000000000);
  });

  setInputFilter(document.getElementById("member_phone"), function(value) {
      return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 100000000000000000000);
  });

  setInputFilter(document.getElementById("member_cellphone"), function(value) {
      return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 100000000000000000000);
  });

  if($('.prov_id_hidden').val() == "0"){
    $('.prov_id').hide();
  }else {
    $('.prov_id').show();
  }

  if($('.prov_id_com_hidden').val() == "0"){
    $('.prov_id_com').hide();
  }else {
    $('.prov_id_com').show();
  }


  var edit = '<?=$_GET['edit']?>';
  console.log(edit);
  if(edit=='true'){
    $('#modal_profile').modal({backdrop: 'static', keyboard: false})  
    // $('.close').hide();
    $('#modal_profile').modal('show');
    $('.btn-cancel').attr('data-dismiss', '');
    $('.close').attr('data-dismiss', '');
    $('.txt-alert').text('กรุณาป้อนข้อมูลให้ครบเพื่อใช้งานต่อไป');
    $(".txt-alert").css("color", "red");
  }

  $('#modal_profile').on('hidden.bs.modal', function (e) {
    location.reload();
  });
  
});

  function chk_status_noti(chk){
    var status_noti = $('.status_noti').val();
    var up_noti = chk;
    if(status_noti == '1'){
      $('.status_noti').val(2);
      up_noti = 2;
    }else {
      $('.status_noti').val(1);
      up_noti = 1;
    }
    $.ajax({
        url: 'function_php/function_index.php',
        type: 'POST',
        async: false,
        responseType: "json",
        data: {
          'up_noti':up_noti,
          "method":"update_status_noti"
        },
      success: function(res) {
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(jqXHR, textStatus, errorThrown);

      }
    });
  }
</script>
