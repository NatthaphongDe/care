<div class="">
  <div class="title_color">
    <i class="ditp-icon icon-ico-ditp-04"></i>
    ผู้ใช้
  </div>
</div>
<div class="box_appeal">
  <div class="row row_title">
    <div class="col-md-4 box_appeal_title">
      Group Management
    </div>
    <?php
      if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"manage_group")[2]==1){
    ?>
    <div class="col-md-8 search box_s1 float_gp_re">
      <a href="?page=user/group_manager">
        <button type="button" class="btn_add click_add" data-toggle="modal" data-target=".modal_add_porduct">
          <span class="">เพิ่มกลุ่ม</span>
        </button>
      </a>
    </div>
    <?php } ?>
  </div>
  <?php

  $sql_edit = "SELECT * FROM Employee_Group WHERE empGroup_status = '0' ";
  $query_edit = $conn->query($sql_edit);
  while ( $re_edit =   $query_edit->fetch_assoc()) {

    ?>
    <div class="row form-group box_name gp">
      <div class="col-md-6 col-sm-6 col-xs-12">
        <label for="" class="control-label lbl_name">
          <?=$re_edit['empGroup_name'];?>
        </label>
      </div>

    <div class="col-md-3 col-sm-3 col-xs-12">
      <?php
      $sql_select = "SELECT empGroup_id FROM Employee where empGroup_id = '".$re_edit['empGroup_id']."' AND emp_status = 0 ";
      $query_select = $conn->query($sql_select);
      $num = $query_select->num_rows;
      ?>
      <label for="" class="control-label lbl_count">
        จำนวน <?=$num;?> คน
      </label>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-12" style="text-align: right;">

    <?php if( $re_edit['empGroup_id']==1){ ?>
        <!-- <button class="btn_can btn lbl_mana " type="button" name="button" style="cursor: default;">Manager</button> -->
        <?php if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"manage_group")[2]==1){  ?>
          <!-- <span for="" class="control-label txt_non" style="vertical-align: top; padding-left:10px"><i class="fa fa-trash" aria-hidden="true"></i></span> -->
        <?php } ?>
      <?php }else{ ?>
          <button class="btn_can btn lbl_mana" type="button" name="button" onclick="window.location.href='?page=user/group_manager&id=<?php echo $re_edit['empGroup_id']?>'">แก้ไข</button>

          <?php if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"manage_group")[2]==1){  ?>
        <span for="" class="control-label cursor txt_no_del" style="vertical-align: top; padding-left:10px"  onclick="ConfirmDelete() && del_group('<?php echo $re_edit['empGroup_id'];?>','<?php echo $num; ?>');">
          <i class="fa fa-trash" aria-hidden="true"></i>
        </span>
        <?php } ?>


      <?php } ?>
    </div>
  </div>
  <?php
  }
?>

</div>
