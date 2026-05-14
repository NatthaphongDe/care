<?php
if ($_GET['id']!=""){
  $sql_edit = "SELECT form_id,form_name,form_start_date,form_end_date FROM Form_Of_Comp WHERE form_id =  '".$_GET['id']."'";
  $query_edit = $conn->query($sql_edit);
  while ( $re_edit =   $query_edit->fetch_assoc()) {
    $form_name =  $re_edit['form_name'];
    $form_start_date_setdate = $re_edit['form_end_date'];
    $form_end_date_setdate = $re_edit['form_start_date'];
    $form_start_date = date("d/m/Y" , strtotime($re_edit['form_start_date']));
    $form_end_date = date("d/m/Y" , strtotime($re_edit['form_end_date']) );
    $form_id = $re_edit['form_id'];
  }
  $sql_comp = "SELECT frmset_id,field_name,field_name_en FROM Field_Form_Of_Comp  WHERE form_id  ='$form_id' ";
  $query_comp = $conn->query($sql_comp);
  while ( $re_comp =   $query_comp->fetch_assoc()) {
    $frmset_id[] =   $re_comp['frmset_id'];
    $field_name[] =   $re_comp['field_name'];
    $field_name_en[] =   $re_comp['field_name_en'];

  }
  $ch_form = $frmset_id[0].",".$frmset_id[1].",".$frmset_id[2];
}
?>

<div class="">
  <div class="title_color">
    <span class="title_icon ditp-icon icon-ico-ditp-05"></span>
    ระบบจัดการฟอร์ม
  </div>
</div>
<form method="POST" action="method.php?method=add_form" name="add_form" enctype="multipart/form-data" target="iframe-data"  >
  <div class="box_appeal">
    <div class="tabla_data">ชื่อฟอร์ม<?=$rematk?>
      <input type="text" name="title_name" id="title_name" value="<?=$form_name?>" class="form-control input_box txt_title" autocomplete="off">
    </div>
    <div class="row box_form form-group">
      <div class="col-sm-2">
        <div class="" style="margin-top: 5px;">
          <lable class="control-label">ระยะเวลาใช้งานฟอร์มตั้งแต่<?=$rematk?></lable>
        </div>
      </div>
      <div class="col-sm-3 ">
        <div class="input-group date" data-provide="datepicker"  data-date-format="dd/mm/yyyy">
          <input type="text"  name="date_start" id="date_start" value="<?=$form_start_date?>"  class="form-control" >
          <div class="input-group-addon">
            <i class="glyph-icon icon-calendar"></i>
          </div>
        </div>
      </div>
      <div class="col-sm-1">
        <div class="" style="margin-top: 5px;">
          <lable class="control-label" >ถึง<?=$rematk?></lable>
        </div>
      </div>
      <div class="col-sm-3 ">
        <div class="input-group date" data-provide="datepicker"  data-date-format="dd/mm/yyyy">
          <input type="text"  name="date_stop" id="date_stop" value="<?=$form_end_date?>"  class="form-control">
          <div class="input-group-addon">
            <i class="glyph-icon icon-calendar"></i>
          </div>
        </div>
      </div>
      <div class="col-md-3">
      </div>
    </div>
    <div class="row box_form_detail">
      <div class="box_padding">
        <div class="col-sm-7">
          <div class="box_data_1 box_form_detail_1">


            <div class="box_border row margin_b_15">
              <div class="row form-group box_sel">
                <div class="col-sm-4">
                  <label for="" class="control-label">ข้อมูลส่วนที่ 1 (ไทย)<?=$rematk?></label>
                </div>
                <div class="col-sm-8">
                  <input type="text" name="part_name[]" id="add_name"  value="<?=$field_name['0']?>"   class="form-control" autocomplete="off">
                </div>
              </div>
                <div class="row form-group box_sel_en">
                <div class="col-sm-4">
                  <label for="" class="control-label">ข้อมูลส่วนที่ 1 (Eng)<?=$rematk?></label>
                </div>
                <div class="col-sm-8">
                  <input type="text" name="part_name_en[]" id="add_name_en"  value="<?=$field_name_en['0']?>"   class="form-control" autocomplete="off">
                </div>
              </div>
              <div class="col-sm-12 box_add_form">
                <div class="">
                  <ul id="sortable1" class="connectedSortable form_add form_recive">
                    <?php
                    if ($_GET['id']!=""){
                      $sql_select = "SELECT * FROM Form_Set WHERE frmset_id IN ($frmset_id[0])";
                      $query_select = $conn->query($sql_select);
                      while ( $re =   $query_select->fetch_assoc()) {
                        ?>
                        <li class="ui-state-default li_form " value="<?=$re['frmset_id']?>" rel="<?php echo $re["frmset_type"] ?>">
                          <input type="hidden" id="txt_id" name="type_from[]" value="<?=$re['frmset_id']?>">
                          <input type="hidden" name="id_form[]" value="<?=$re['frmset_id']?>">
                          <span class="span_form"><i class="fa fa-tasks" aria-hidden="true"></i>
                          </span><?=$re['frmset_name']?>
                        </li>
                        <?php }} ?>
                      </ul>
                    </div>
                  </div>
                </div>

                <div class="box_border row margin_b_15">
                  <div class="row form-group box_sel">
                    <div class="col-sm-4">
                      <label for="" class="control-label">ข้อมูลส่วนที่ 2 (ไทย)<?=$rematk?></label>
                    </div>
                    <div class="col-sm-8">
                      <input type="text" name="part_name[]" id="add_name"   value="<?=$field_name['1']?>" class="form-control"autocomplete="off">
                    </div>
                  </div>
                  <div class="row form-group box_sel_en">
                    <div class="col-sm-4">
                      <label for="" class="control-label">ข้อมูลส่วนที่ 2 (Eng)<?=$rematk?></label>
                    </div>
                    <div class="col-sm-8">
                      <input type="text" name="part_name_en[]" id="add_name_en"   value="<?=$field_name_en['1']?>" class="form-control"autocomplete="off">
                    </div>
                  </div>

                  <div class="col-sm-12 box_add_form">
                    <ul id="sortable2" class="connectedSortable form_add">
                      <?php
                      if ($_GET['id']!=""){
                        $sql_select = "SELECT * FROM Form_Set WHERE `frmset_id` IN ($frmset_id[1])";
                        $query_select = $conn->query($sql_select);
                        while ( $re =   $query_select->fetch_assoc()) {
                          ?>
                          <li class="ui-state-default li_form " value="<?=$re['frmset_id']?>" rel="<?php echo $re["frmset_type"] ?>">
                            <input type="hidden" id="txt_id" name="type_from[]" value="<?=$re['frmset_type']?>">
                            <input type="hidden" name="id_form[]" value="<?=$re['frmset_id']?>">
                            <span class="span_form"><i class="fa fa-tasks" aria-hidden="true"></i>
                            </span><?=$re['frmset_name']?>
                          </li>
                          <?php }} ?>
                        </ul>
                      </div>
                    </div>

                    <div class="box_border row">
                      <div class="row form-group box_sel">
                        <div class="col-sm-4">
                          <label for="" class="control-label">ข้อมูลส่วนที่ 3 (ไทย)<?=$rematk?></label>
                        </div>
                        <div class="col-sm-8">
                          <input type="text" name="part_name[]" id="add_name"  value="<?=$field_name['2']?>"   class="form-control" autocomplete="off">
                        </div>
                      </div>
                        <div class="row form-group box_sel_en">
                        <div class="col-sm-4">
                          <label for="" class="control-label">ข้อมูลส่วนที่ 3 (Eng)<?=$rematk?></label>
                        </div>
                        <div class="col-sm-8">
                          <input type="text" name="part_name_en[]" id="add_name_en"  value="<?=$field_name_en['2']?>"   class="form-control" autocomplete="off">
                        </div>
                      </div>
                      <div class="col-sm-12 box_add_form">
                        <ul id="sortable3" class="connectedSortable form_add">
                          <?php
                          if ($_GET['id']!=""){
                            $sql_select = "SELECT * FROM Form_Set WHERE `frmset_id` IN ($frmset_id[2])";
                            $query_select = $conn->query($sql_select);
                            while ( $re =   $query_select->fetch_assoc()) {
                              ?>
                              <li class="ui-state-default li_form " value="<?=$re['frmset_id']?>" rel="<?php echo $re["frmset_type"] ?>">
                                <input type="hidden" id="txt_id" name="type_from[]" value="<?=$re['frmset_type']?>">
                                <input type="hidden" name="id_form[]" value="<?=$re['frmset_id']?>">
                                <span class="span_form"><i class="fa fa-tasks" aria-hidden="true"></i>
                                </span><?=$re['frmset_name']?>
                              </li>
                              <?php }} ?>
                            </ul>
                          </div>
                        </div>

                      </div>
                    </div>
                    <div class="col-sm-5 box_data_1 box_form_detail_1">
                      <div class="">
                        <div class="input-group">
                          <input type="text" class="form-control search_text" name="search_text" value="" id="search_text" >
                          <span class="input-group-addon bg-black btn-click-search">
                            <i class="glyph-icon icon-search cursor" onclick="get_form();"></i>
                          </span>
                        </div>
                        <div class="grt_form my_scroll">
                          <ul id="sortable_main" class="sortable">
                            <?php

                            if ($_GET['id']!=""){
                              $sql_select = "SELECT * FROM Form_Set WHERE `frmset_id` NOT IN ($ch_form)";
                            }else{
                              $sql_select = "SELECT frmset_name,frmset_id,frmset_type FROM Form_Set ";
                            }

                            $query_select = $conn->query($sql_select);
                            while ( $re =   $query_select->fetch_assoc()) {

                              ?>
                              <li class="ui-state-default li_form " value="<?=$re['frmset_id']?>" rel="<?php echo $re["frmset_type"] ?>">
                                <input type="hidden" id="txt_id" name="type_from[]" value="<?=$re['frmset_type']?>">
                                <input type="hidden" name="id_form[]" value="<?=$re['frmset_id']?>">
                                <span class="span_form"><i class="fa fa-tasks" aria-hidden="true"></i>
                                </span><?=$re['frmset_name']?>
                              </li>
                              <?php } ?>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="box_form_btn">
                    <input type="hidden" name="countFormset" value="0">
                    <?php if($_GET['val']==0){ ?>
                      <button type="button" class="btn btn-default" style="width: 80px;"  onclick="location.href='?page=form';">ปิด</button>
                    <?php }else{ ?>
                      <button type="button" class="btn btn_close" onclick="location.href='?page=form';" >ยกเลิก</button>
                    <?php if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"manager_form")[2]==1){?>
                      <button type="button" class="btn  btn_submit" onclick="document.add_form.submit()">ตกลง</button>
                    <?php } ?>
                    <?php }?>


                    <?php if ($_GET['id']!=""){ ?>
                      <input type="hidden" name="check_edit" value="1">
                      <input type="hidden" name="id" value="<?=$_GET['id']?>">
                      <input type="hidden" name="id_set" value="<?=$frmset_id?>">
                    <?php } ?>
                      <input type="hidden" name="id_ch1" id="id_ch1" value="<?=$frmset_id[0]?>">
                      <input type="hidden" name="id_ch2" id="id_ch2" value="<?=$frmset_id[1]?>">
                      <input type="hidden" name="id_ch3" id="id_ch3" value="<?=$frmset_id[2]?>">
                </div>
  </div>
</form>
<script src="js/jquery-ui.js"></script>
<script>

    $(document).ready(function(){ "use strict";
    $(function() {
      var ch = <?php echo $_GET['val']; ?>;
      if(ch == '1' ){

        var countSetForm = 0;
        $( "#sortable_main" ).sortable({
          connectWith: ["#sortable1","#sortable2","#sortable3"],
          receive: function(event, ui) {
            countSetForm--;
            $("input[name='countFormset']").val(countSetForm);
            var id_ch = $(ui.item).attr("value");
            // console.log(countSetForm);
            var id = $(ui.item).attr("rel");
            if(id==1){
              $('#id_ch1').val('');
              // console.log(id);
            }else if(id==2){
              $('#id_ch2').val('');
              // console.log(id);
            }else if(id=3){
              $('#id_ch3').val('');
              // console.log(id);
            }
          }

        });
        $( "#sortable1" ).sortable({
          connectWith: "#sortable_main",
          receive: function(event, ui) {
            var id = $(ui.item).attr("rel");
            var id_ch = $(ui.item).attr("value");

            if($(this).attr("id")!="sortable"+id){
              $(ui.sender).sortable('cancel');
              $('#id_ch1').val('');
            }else{
              if($(this).parent().find("li").length==1){
                countSetForm++;
                $('#id_ch1').val(id_ch);

              }
            }

            // so if > 1
            if($(this).parent().find("li").length>1){
              $( "#sortable_main" ).append($(this).parent().find('li').first()[0]);
              $('#id_ch1').val(id_ch);
            }
            setTimeout(function(){
              $(this).parent().find('li').first().remove();
            },300);
            $("input[name='countFormset']").val(countSetForm);
            // console.log(countSetForm);
            // console.log(id_ch);
          }
        });
        $( "#sortable2" ).sortable({

          connectWith: "#sortable_main",
          receive: function(event, ui) {
            var id = $(ui.item).attr("rel");
            var id_ch = $(ui.item).attr("value");

            if($(this).attr("id")!="sortable"+id){
              $(ui.sender).sortable('cancel');
            }else{
              if($(this).parent().find("li").length==1){
                $('#id_ch2').val(id_ch);
                countSetForm++;
              }
            }

            // so if > 1
            if($(this).parent().find("li").length>1){
              $( "#sortable_main" ).append($(this).parent().find('li').first()[0]);
              $('#id_ch2').val(id_ch);
            }
            setTimeout(function(){
              $(this).parent().find('li').first().remove();
            },300);
            $("input[name='countFormset']").val(countSetForm);
            // console.log(countSetForm);
          }
        });
        $( "#sortable3" ).sortable({

          connectWith: "#sortable_main",
          receive: function(event, ui) {
            var id = $(ui.item).attr("rel");
            var id_ch = $(ui.item).attr("value");


            if($(this).attr("id")!="sortable"+id){
              $(ui.sender).sortable('cancel');
            }else{
              if($(this).parent().find("li").length==1){
                $('#id_ch3').val(id_ch);
                countSetForm++;
              }
            }
            // so if > 1
            if($(this).parent().find("li").length>1){
              $( "#sortable_main" ).append($(this).parent().find('li').first()[0]);
              $('#id_ch3').val(id_ch);
            }
            setTimeout(function(){
              $(this).parent().find('li').first().remove();
            },300);
            $("input[name='countFormset']").val(countSetForm);
            // console.log(countSetForm);
          }
        });
      }
    });
    $(function(){
      $(".input-mask").inputmask();
    });

    $('#search_text').keypress(function(e) {
      if(e.which==13){
        get_form();
      }
    });
  });

  </script>
