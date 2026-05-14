<div class="">
  <div class="title_color">
    <span class="title_icon ditp-icon icon-ico-ditp-05"></span>
    ตั้งค่าระบบ
  </div>
</div>
<div class="box_appeal">
  <div class="row row_title">
    <div class="col-xs-12 box_appeal_title">
      Blacklist
    </div>
  </div>
  <div class="row form-group">
    <div class="col-md-2">
      <label class="control-label">
        จำนวนครั้งที่ถูกร้องเรียน
      </label>
    </div>
    <div class="col-md-10">
      <div class=" search box_s1">
        <?php
        $sql_count = "SELECT bl_setting FROM Setting_Info ";
        $query_count = $conn->query($sql_count);
        while ( $re_count =   $query_count->fetch_assoc()) {
         $bl_php =  $re_count['bl_setting'];
        }

         ?>
        <input type="text" name="search_text" value="<?php echo $bl_php; ?>" id="search_text" class="form-control" placeholder="Search" autocomplete="off" OnKeyPress="return chkNumber(this)" maxlength="3">
      </div>
      <div class="box_s">
        <label class="control-label">
          ครั้ง
        </label>
      </div>
       <!-- <div class=""  > -->
         <button style="margin-left: 10px;" class="btn_bl btn" type="button" name="button" onclick="get_data_company();">Update</button>
       <!-- </div> -->
    </div>
  </div>
  <!-- <div class="bl_width display_table"> -->
  <div class="row pad_row">

    <div class="col-xs-12 col-md-5  display_table">
      <table class=" table table-striped table_bl">
        <thead>
          <tr>
            <th class="thead_table center_table" style="width:  80px;">
              <div class="checkbox checkbox-success checkbox-inline txt_bl">
                <input type="checkbox" id="inlineCheckbox2" class="checkbox_black" value="">
                <label for="inlineCheckbox2">All</label>
              </div>
            </th>
            <th class="thead_table" style="width: 100%;">
              <div class="txt_bl">
                ตรวจสอบ Blacklist
              </div>
            </th>
          </tr>
        </thead>
        <tbody class="score_table get_data_company">
          <?php
          $sql_edit = "SELECT complnt_trade_number,case_id,count(case_id) as count_sum FROM `Case` WHERE complnt_trade_number !='' GROUP by complnt_trade_number ASC  ";
          $query_edit = $conn->query($sql_edit);
          $color = 0;
          //if ($query_edit->num_rows>0){
            while ( $re_edit =   $query_edit->fetch_assoc()) {

              $complnt_trade_number =  $re_edit['complnt_trade_number'];

              $sql_select = "SELECT complnt_trade_number FROM `Backlist_Complnt` where complnt_trade_number =  '$complnt_trade_number'  ";
              $query_select = $conn->query($sql_select);
              if ($query_select->num_rows<1){

                ?>
                <tr class="<?php if($color%2){ echo "tb_color"; }else{ echo  "tb_color_1"; } ?>">
                  <td class="center_table" style="width: 80px;">
                    <div class="checkbox checkbox-success checkbox-inline">
                      <input type="checkbox" class="checkbox_black_sub checkbox_1" name="" value="<?php echo $re_edit['case_id']?>">
                      <label for=""></label>
                    </div>
                  </td>
                  <td class="cursor cursor<?php echo $re_edit['case_id']?>"  style="width: 100%;"  data-toggle="collapse" data-parent="#accordion" href="#collapseThree_<?php echo $re_edit['case_id']?>" aria-expanded="false" aria-controls="collapseThree">
                    <div class="card">
                      <div class="card-header" role="tab" id="heading">
                        <h5 class="mb-0">
                          <span class="collapsed bl_txt span_bl" data-toggle="collapse" data-parent="#accordion" href="#collapseThree<?php echo $re_edit['case_id']?>" aria-expanded="false" aria-controls="collapseThree">
                            <?php echo $complnt_trade_number;?>
                          </span>
                          <div class="arrow_bl arrow_bl<?php echo $re_edit['case_id']?> ">
                            <i class="fa fa-chevron-down up_rolate<?php echo $re_edit['case_id']?> cursor i_txt" aria-hidden="true"  ></i>
                          </div>
                        </h5>
                      </div>
                      <div id="collapseThree_<?php echo $re_edit['case_id']?>" class="collapse p_box" role="tabpanel" aria-labelledby="heading">
                        <div class="card-block">
                          <?php

                          $sql_edit1 = "SELECT caseDtl_title,case_id FROM `Case` WHERE complnt_trade_number = '$complnt_trade_number'  ";
                          $query_edit1 = $conn->query($sql_edit1);
                          while($re_edit1 =   $query_edit1->fetch_assoc()) {
                            $caseDtl_title =  $re_edit1['caseDtl_title'];
                            $case_id =  $re_edit1['case_id'];
                            ?>
                            <span class="span_bl_sub">
                              <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                              Case ID <?php echo $case_id; ?> - <?php echo $caseDtl_title; ?></span><br>
                              <?php } ?>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <?php
                    $color++;
                  }
                }
              /*}else{
                ?>
                <tr>
                  <th class="thead_table center_table" style="width:  1%;" colspan="2">
                    ไม่พบข้อมูล
                  </th>
                </tr>
                <?php
              }*/

              $sql_edit = "SELECT complnt_trade_number,case_id,count(case_id) as count_sum FROM `Case` WHERE complnt_trade_number ='' AND complnt_name !='' GROUP by complnt_name ASC  ";
              $query_edit = $conn->query($sql_edit);
              $color = 0;
                while ( $re_edit =   $query_edit->fetch_assoc()) {

                  $complnt_trade_number =  $re_edit['complnt_trade_number'];

                  $sql_select = "SELECT complnt_trade_number FROM `Backlist_Complnt` where complnt_trade_number =  '$complnt_trade_number'  ";
                  $query_select = $conn->query($sql_select);
                  if ($query_select->num_rows<1){

                    ?>
                    <tr class="<?php if($color%2){ echo "tb_color"; }else{ echo  "tb_color_1"; } ?>">
                      <td class="center_table" style="width: 80px;">
                        <div class="checkbox checkbox-success checkbox-inline">
                          <input type="checkbox" class="checkbox_black_sub checkbox_1" name="" value="<?php echo $re_edit['case_id']?>">
                          <label for=""></label>
                        </div>
                      </td>
                      <td class="cursor cursor<?php echo $re_edit['case_id']?>"  style="width: 100%;"  data-toggle="collapse" data-parent="#accordion" href="#collapseThree_<?php echo $re_edit['case_id']?>" aria-expanded="false" aria-controls="collapseThree">

                        <div class="card">
                          <div class="card-header" role="tab" id="heading">
                            <h5 class="mb-0">
                              <span class="collapsed bl_txt span_bl" data-toggle="collapse" data-parent="#accordion" href="#collapseThree<?php echo $re_edit['case_id']?>" aria-expanded="false" aria-controls="collapseThree">
                                <?php echo $complnt_trade_number;?>
                              </span>
                              <div class="arrow_bl arrow_bl<?php echo $re_edit['case_id']?> ">
                                <i class="fa fa-chevron-down up_rolate<?php echo $re_edit['case_id']?> cursor i_txt" aria-hidden="true"  ></i>
                              </div>
                            </h5>
                          </div>
                          <div id="collapseThree_<?php echo $re_edit['case_id']?>" class="collapse p_box" role="tabpanel" aria-labelledby="heading">
                            <div class="card-block">
                              <?php
                              $sql_edit1 = "SELECT caseDtl_title,case_id FROM `Case` WHERE complnt_trade_number = '$complnt_trade_number'  ";
                              $query_edit1 = $conn->query($sql_edit1);
                              while($re_edit1 =   $query_edit1->fetch_assoc()) {
                                $caseDtl_title =  $re_edit1['caseDtl_title'];
                                $case_id =  $re_edit1['case_id'];
                                ?>
                                <span class="span_bl_sub">
                                  <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                                  Case ID <?php echo $case_id; ?> - <?php echo $caseDtl_title; ?></span><br>
                                  <?php } ?>
                                </div>
                              </div>
                            </div>
                          </td>
                        </tr>
                        <?php
                        $color++;
                      }
                    }
              ?>
            </tbody>
          </table>
        </div>
        <div class="display_table col-md-2 col-xs-12 pa_bl" style="">
          <?php if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"manage_system")[2]==1){ ?>
            <button type="submit" class="btn btn_swit"  onclick="confirm('ยืนยันการเพิ่ม Blacklist ?') && add_blacklist()">
              <i class="fa fa-arrow-right" aria-hidden="true"></i>
            </button>
          </br>
        </br>
        <button type="submit" class="btn btn_swit"  onclick="confirm('ยืนยันการยกเลิก Blacklist ?') && del_blacklist()">
          <i class="fa fa-arrow-left" aria-hidden="true"></i>
        </button>
        <?php } ?>
      </div>
      <div class="display_table col-xs-12 col-md-5">
        <table class=" table table-striped table_bl">
          <thead>
            <tr>
              <th class="thead_table center_table" style="width:  80px;">
              <div class="checkbox checkbox-success checkbox-inline txt_bl">
                <input type="checkbox" id="inlineCheckbox3" class="checkbox_black_del" value="">
                <label for="inlineCheckbox3" >All</label>
              </div>
            </th>
            <th class="thead_table" style="width: 100%;">
              <div class="txt_bl">Blacklist Box</div></th>
            </tr>
          </thead>
          <tbody class="score_table">
            <?php
            $sql_edit = "SELECT complnt_name,backlist_id FROM `Backlist_Complnt` GROUP by complnt_name ASC  ";
            $query_edit = $conn->query($sql_edit);
            $color = 0;
            if ($query_edit->num_rows>0){
              while ( $re_edit =   $query_edit->fetch_assoc()) {
                $complnt_trade_number =  $re_edit['complnt_name'];
                ?>
                <tr class="<?php if($color%2){ echo "tb_color"; }else{ echo  "tb_color_1"; } ?>">
                  <td class="center_table" style="width: 80px;">
                    <div class="checkbox checkbox-success checkbox-inline">
                      <input type="checkbox" class="checkbox_black_sub_del checkbox_1" name="" value="<?php echo $re_edit['backlist_id']?>">
                      <label for=""></label>
                    </div>
                  </td>
                  <td class=""  style="width: 100%;">
                    <span class="span_bl">
                      <?php echo $complnt_trade_number; ?>
                    </span>
                  </td>
                </tr>
                <?php
                $color++;
              }
            }else{
              ?>
              <tr>
                <th class="thead_table center_table" style="width:  1%;" colspan="2">
                  ไม่พบข้อมูล
                </th>
              </tr>
              <?php
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>


  <script type="text/javascript" src="../assets/widgets/chosen/chosen.js"></script>
  <style media="screen">
  <style>

  tr {
    width: 100%;
    display: inline-table;
  }

  table{
    height:351px;
  }
  tbody{
    overflow-y: scroll;
    height: 300px;
    width: 96.5%;
    position: absolute;
  }

  table {
    border-collapse: collapse;
    width: 100%;
  }

  th, td {
    text-align: left;
    padding: 8px;
  }
  .table-overflow { overflow: auto; }



  table, td, th {
    border: 1px solid #ddd;
  }
  .score_table{
  }
  </style>
  <script>




  function click_sub(id) {
  //
  //
  // // var id_elm = $(this).attr('href');
  // var id_elm = $('.cursor'+id).attr("href");
  //
  //     if($(id_elm).hasClass('in')){
  //       // console.log(1);
  //           // $(".up_rolate"+id).toggleClass("arrow-rotate");
  //           $('.arrow_bl'+id).html('<i class="fa fa-chevron-up  cursor i_txt arrow-rotate" aria-hidden="true" ></i>');
  //
  //     }else{
  //       // console.log(2);
  //           // $(".up_rolate"+id).toggleClass("arrow-rotate");
  //           $('.arrow_bl'+id).html('<i class="fa fa-chevron-down  cursor i_txt arrow-rotate" aria-hidden="true" ></i>');
  //     }
  }
  $(document).ready(function() {
    get_data_company(5);

    $('.table-caseCh-list').on('load-success.bs.table', function (e) {
      $('[data-toggle="tooltip"]').tooltip();
    });
    $("input[name='search_prod_type']").change(function() {
      /* Act on the event */
    });
    $("input[name='search_text']").keypress(function(e) {
      if(e.which == 13) {
        $('.table-caseCh-list').bootstrapTable('refresh');
      }
    });
  });
  function searchQueryParams(params) {
    params.text = $("input[name='search_text']").val();
    if($('.search_date').prop("disabled")==false){
      params.date = $('.search_date').val();
    }
    return params; // body data
  }

  $('.checkbox_black_del').click (function () {
    $('.checkbox_black_sub_del').prop('checked', this.checked);
  });

  $('.checkbox_black').click (function () {
    $('.checkbox_black_sub').prop('checked', this.checked);
  });



  $(document).delegate('.cursor_click','click',function(){
  var id_elm = $(this).attr('href');
  var res = id_elm.split("_");
  if($(id_elm).hasClass('in')){
    $('.arrow_bl'+res[1]).html('<i class="fa fa-chevron-up  cursor i_txt arrow-rotate" aria-hidden="true" ></i>');
  }else{
    $('.arrow_bl'+res[1]).html('<i class="fa fa-chevron-down  cursor i_txt arrow-rotate" aria-hidden="true" ></i>');
  }
  });

  </script>
