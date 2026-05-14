<?php

if($_GET['id']==1){
  ?><script type="text/javascript">location.href ="index.php?page=user/group";</script><?
}
?>

<form method="POST" action="user/method.php?method=add_group"  id="add_group" enctype="multipart/form-data" target="iframe-data"  >
  <?php
  if($_GET['id']!=''){
    $sql_check_role = "select empGroup_name,empGroup_enable,empGroup_section,empGroup_level from Employee_Group where empGroup_id = '".$_GET['id']."'";
    $query_check_role = $conn->query($sql_check_role);
    while($re = $query_check_role->fetch_assoc()) {
      $empGroup_name =  $re['empGroup_name'];
      $empGroup_enable =    $re['empGroup_enable'];
      $empGroup_section = $re['empGroup_section'];
      $empGroup_level = $re['empGroup_level'];

    }
  }
  ?>

  <input type="hidden" name="id_ch" value="<?= $_REQUEST['id']?>">

  <div class="">
    <div class="title_color">
      <i class="ditp-icon icon-ico-ditp-04"></i>
      ผู้ใช้
    </div>
  </div>
  <div class="box_appeal">
    <div class="row row_title">
      <div class="col-md-12 box_appeal_title">
        เพิ่มกลุ่ม
      </div>
    </div>
    <div class="row form-group">
      <div class="col-md-2">
        <label for="" class="control-label">ชื่อกลุ่ม<label class="txt_no_del">*</label></label>
      </div>
      <div class="col-md-5">
        <input type="text" class="form-control" name="gp_name" value="<?=$empGroup_name;?>">
      </div>
    </div>
    <div class="row form-group">
      <div class="col-md-2 ">
        <label for="message-text" class="control-label">สถานะ</label>
      </div>
      <div class="col-md-9">
        <div class="col-md-3">
          <div class="radio radio-danger">
            <input type="radio" name="radio_status" id="radio3" value="1" <?php if($_GET['id']==''){ echo "checked"; }else if($empGroup_enable==1){ echo "checked"; } ?>>
            <label for="radio3">
              เปิด
            </label>
          </div>
        </div>
        <div class="col-md-3">
          <div class="radio radio-danger ">
            <input type="radio" name="radio_status" id="radio4" value="0" <?php if($_GET['id']==''){ echo "checked"; }else if($empGroup_enable==0){ echo "checked"; } ?>>
            <label for="radio4">
              ปิด
            </label>
          </div>
        </div>
      </div>
    </div>


    <div class="row form-group">
      <div class="col-md-2 ">
        <label for="message-text" class="control-label">ระดับกลุ่ม</label>
      </div>
      <div class="col-md-9">
        <div class="col-md-3">
          <div class="radio radio-danger">
            <input type="radio" name="radio_gp" id="radio_gp_1" value="0" <?php if($_GET['id']==''){ echo "checked"; }else if($empGroup_level==0){ echo "checked"; } ?>>
            <label for="radio_gp_1">
              พนักงาน
            </label>
          </div>
        </div>
        <div class="col-md-3">
          <div class="radio radio-danger ">
            <input type="radio" name="radio_gp" id="radio_gp_2" value="2" <?php if($_GET['id']==''){ }else if($empGroup_level==2){ echo "checked"; } ?>>
            <label for="radio_gp_2">
              ผู้จัดการ
            </label>
          </div>
        </div>
      </div>
    </div>

    <div class="row form-group">
      <div class="col-md-2">
        <label for="message-text" class="control-label">เลือกประเภท</label>
      </div>
      <div class="col-md-9">
        <div class="col-md-3">
          <div class="radio radio-danger">
            <input type="radio" name="radio_sections" id="radio5" value="1" <?php if($_GET['id']==''){ echo "checked"; }else if($empGroup_section==1){ echo "checked"; } ?>>
            <label for="radio5">
              สสบ.
            </label>
          </div>
        </div>
        <div class="col-md-3">
          <div class="radio radio-danger ">
            <input type="radio" name="radio_sections" id="radio6" value="2" <?php if($_GET['id']==''){ echo "checked"; }else if($empGroup_section==2){ echo "checked"; } ?>>
            <label for="radio6">
              นิติการ
            </label>
          </div>
        </div>
      </div>
    </div>
    <div class="row form-group">
      <div class="col-md-2">
        <label for="" class="control-label">สิทธิ์การใช้งาน</label>
      </div>
      <div class="col-md-10 box_group no-margin-padding table-responsive">
        <table class="">
          <tr class="title_group">
            <th class="tb_1">
            </th>
            <th class="">
              <div class="checkbox checkbox-success checkbox-inline tb_g_re">
                <input type="checkbox" id="checkbox_Read_all_mobile" class="checkbox_black_sub chked1" name="" value="<?php echo $re_edit['case_id']?>">
                <!-- <label for="checkbox_Read_all_mobile tb_2">Read All</label> -->
                <label for="checkbox_Read_all_mobile">Read All</label>
              </div>
            </td><th class="tb_2">
              <div class="checkbox checkbox-success checkbox-inline tb_g_re">
                <input type="checkbox" id="checkbox_Write_all_mobile" class="checkbox_black_sub chked2" name="" value="<?php echo $re_edit['case_id']?>">
                <!-- <label for="checkbox_Write_all_mobile tb_2">Write All</label> -->
                <label for="checkbox_Write_all_mobile">Write All</label>
              </div>
            </td><th class="tb_2">
              <div class="checkbox checkbox-success checkbox-inline tb_g_re">
                <input type="checkbox" id="checkbox_Enable_all_mobile" class="checkbox_black_sub chked3" name="" value="<?php echo $re_edit['case_id']?>">
                <!-- <label for="checkbox_Enable_all_mobile tb_2">Enable All</label> -->
                <label for="checkbox_Enable_all_mobile">Enable All</label>
              </div>
            </th>
          </tr>
          <?php

          $sql_select = "  SELECT page_id,page_name AS 'group' , GROUP_CONCAT(page_permission) AS permission , GROUP_CONCAT(page_id) AS 'ids',page_title
          FROM Page WHERE page_setting = '0'  GROUP BY page_name ORDER By page_id";
          $query = $conn->query($sql_select);
          if ($query->num_rows >0){
            while($re = $query->fetch_assoc()) {
              $permission = split(",", $re["permission"]);
              $id = split(",", $re["ids"]);
              ?>
              <tr style="border-bottom: solid 1px #ececec;">
                <td class="no-margin-padding">
                  <div class="col-md-12 tb_1">
                    <label for="" class="control-label <?php if($re['page_title']==1){ echo "tit_nol_gp"; }else{ echo "tit_nol_gp_1";} ?>">
                      <?php if($re['page_title']==0){ ?> <i class="fa fa-long-arrow-right pd_group" aria-hidden="true"></i> <?php  }?>
                      <?php echo $re['group']; ?></label>
                    </div>
                  </td>
                  <td class="no-margin-padding tb_2" style="padding-left:10px;">
                    <?php   foreach($id as $index => $idx) {
                      if($_GET['id']!=''){
                        $sql_check_role = "select * from Employee_Group_Permission where empGroup_id = '".$_GET['id']."' and page_id = '".$idx."'";
                        $query_check_role = $conn->query($sql_check_role);
                        if ($query_check_role->num_rows>0) {
                          $checked = 1;
                        }
                        else {
                          $checked = 0;
                        }
                      }
                      if ($permission[$index]==1) { ?>
                        <div class="checkbox checkbox-success" style="display:inline-block;">
                          <input id="<?php echo $idx; ?>" value="<?php echo $idx; ?>" name="permission[]"  <?php if ($checked==1) { echo 'checked="checked"'; } ?> class="styled department_check chked_child1" style="margin-left:0px;"  type="checkbox">
                            <label for="<?php echo $idx; ?>" style="margin-right:0px;">
                              <spanx>
                                Read
                              </spanx>
                            </label>
                          </div>
                          <?php  } } ?>
                        </td>  <td class="no-margin-padding tb_2">
                          <?php   foreach($id as $index => $idx) {
                            if($_GET['id']!=''){
                              $sql_check_role = "select * from Employee_Group_Permission where empGroup_id = '".$_GET['id']."' and page_id = '".$idx."'";
                              $query_check_role = $conn->query($sql_check_role);
                              if ($query_check_role->num_rows>0) {
                                $checked = 1;
                              }
                              else {
                                $checked = 0;
                              }
                            }

                            if ($permission[$index]==2) { ?>
                              <div class="checkbox checkbox-success" style="display:inline-block;    margin-top: 10px;">
                                <input id="<?php echo $idx; ?>" value="<?php echo $idx; ?>" name="permission[]"  <?php if ($checked==1) { echo 'checked="checked"'; } ?> class="styled department_check chked_child2" style="margin-left:0px;"  type="checkbox">
                                  <label for="<?php echo $idx; ?>" style="margin-right:0px;">
                                    <spanx>
                                      Write
                                    </spanx>
                                  </label>
                                </div>
                                <? } ?>
                                <?php } ?>
                              </td>  <td class="no-margin-padding tb_2">
                                <?php   foreach($id as $index => $idx) {
                                  if($_GET['id']!=''){
                                    $sql_check_role = "select * from Employee_Group_Permission where empGroup_id = '".$_GET['id']."' and page_id = '".$idx."'";
                                    $query_check_role = $conn->query($sql_check_role);
                                    if ($query_check_role->num_rows>0) {
                                      $checked = 1;
                                    }
                                    else {
                                      $checked = 0;
                                    }
                                  }

                                  if ($permission[$index]==3) { ?>
                                    <div class="checkbox checkbox-success" style="display:inline-block;    margin-top: 10px;">
                                      <input id="<?php echo $idx; ?>" value="<?php echo $idx; ?>" name="permission[]"  <?php if ($checked==1) { echo 'checked="checked"'; } ?> class="styled department_check chked_child3" style="margin-left:0px;"  type="checkbox">
                                        <label for="<?php echo $idx; ?>" style="margin-right:0px;">
                                          <spanx>
                                            Enable
                                          </spanx>
                                        </label>
                                      </div>
                                      <? } ?>
                                      <?php } ?>
                                    </td>
                                  </tr>
                                  <?php } }?>
                                </table>
                              </div>
                            </div>
                            <div class="row form-group" style="text-align:center;">
                              <div class="col-md-12" style="text-align: center;">

                                <button type="button" class="btn btn_close" data-dismiss="modal" onclick="location.href='?page=user/group';"><i class="fa fa-arrow-left" aria-hidden="true"></i> ยกเลิก</button>
                                <?php
                                if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"manage_group")[2]==1){
                                  ?>
                                  <button type="button" class="btn  btn_submit" onclick="Confirmsave();">ตกลง</button>
                                  <?php } ?>
                                </div>
                              </div>
                            </div>
                          </form>

<script type="text/javascript">
  $('.chked1').click (function () {
    $('.chked_child1').prop('checked', this.checked);
  });
  $('.chked2').click (function () {
    $('.chked_child2').prop('checked', this.checked);
  });
  $('.chked3').click (function () {
    $('.chked_child3').prop('checked', this.checked);
  });
</script>

<style media="screen">
  .pd_group{
    padding-left: 25px;
  }
  .tit_nol_gp{
    padding-left: 15px;
  }
  th, td {
    text-align: left;
    padding: 00px;
  }
</style>
