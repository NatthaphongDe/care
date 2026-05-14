<div class="">
  <div class="title_color">
    <i class="ditp-icon icon-ico-ditp-04"></i>
    องค์ความรู้เรื่องร้องเรียน
  </div>
</div>
<div class="box_appeal">
  <div class="row row_title">
    <div class="col-lg-4 col-md-12 box_appeal_title">
      องค์ความรู้เรื่องร้องเรียน
    </div>
    <div class="col-lg-8 col-md-12 search box_s1 se">
      <?php if($_SESSION["admin"]["empSection"]==1){ ?>
        <select class="selectpicker col-xs-2 chosen-select-dissearch no-margin-padding pd_re" name="product"  id="product" data-width="200px" data-live-search="true">
          <option value="">--- ประเภทสินค้าทั้งหมด ---</option>
          <?php
        function prodTypeListMutiLv_2($lv,$ref_id){
          include("../config/config.php");
          $prodTypeArrObj = array();
          $sql = "SELECT *
          FROM Product_Type
                  WHERE prodType_level = '$lv'
                  AND prodType_status = '0'
                  AND prodType_enable = '1' ";
          if($ref_id!=""){
            $sql .= "AND prodType_ref_id = '$ref_id' ";
          }
          $query = $conn->query($sql);
          $prod_num = $query->num_rows;
          $lv++;
            while($result = $query->fetch_assoc()){
              $prodArr["prodType_id"] = $result["prodType_id"];
              $prodArr["prodType_name"] = $result["prodType_name"];

              $sql_sub = "SELECT *
                          FROM Product_Type
                          WHERE prodType_ref_id = '".$result["prodType_id"]."'
                          AND prodType_level = '$lv'
                          AND prodType_status = '0'
                          AND prodType_enable = '1' ";
              $query_sub = $conn->query($sql_sub);
              $num_sub = $query_sub->num_rows;
              $prodArr["prodType_sublist"] = $num_sub;
              array_push($prodTypeArrObj,$prodArr);
            }
          return $prodTypeArrObj;
        }

        function getProdType_2($lv,$ref_id){
          global $caseLst_cls;
          $i=0;
          foreach($caseLst_cls->prodTypeListMutiLv($lv,$ref_id) as $prod_type){
            if($lv==1){
              $option .= '<optgroup>';
            }
            if($lv > 1){
              $arrow = '<i class=\'ditp-icon icon-ico-ditp-43\'></i>';
            }else {
              $arrow = '';
            }
            $ref_name_real = $ref_name."".$prod_type["prodType_name"];
            $option .= '<option value="'.$prod_type["prodType_id"].'" rel="'.$prod_type["prodType_level"].'" data-content="<span style=\'padding-left:'.(20*($lv-1)).'px\'>'.$arrow.'<h style=\'display:none;\'>'.$ref_name_real.'</h>'.$prod_type["prodType_name"].'</span>" >
                        '.$prod_type["prodType_name"].'
                      </option>';
            if($prod_type["prodType_sublist"]>0){
              $n_lv = $lv+1;
              $option .= getProdType_2($n_lv,$prod_type["prodType_id"],$ref_name_real);
            }
            if($lv==1){
              $option .= '</optgroup>';
            }
            $i++;

          }
          return $option;
        }
        echo getProdType_2(1,null,null);
    ?>
        </select>
        <?php }else if($_SESSION["admin"]["empSection"]==2){ ?>
          <select class="selectpicker col-xs-2 chosen-select-dissearch no-margin-padding pd_re" name="mistake"  id="mistake" data-width="200px" data-live-search="true">
            <option value="">ประเภทความผิดทั้งหมด</option>
            <?php
              $sql_select = "SELECT * FROM Incorrect_Type WHERE incType_status = 0 AND incType_enable = 1 ";
              $query_select = $conn->query($sql_select);
              while ($re =   $query_select->fetch_assoc()) {
              ?>
              <option value="<?=$re['incType_id']?>"><?=$re['incType_name']?></option>
            <?php } ?>
          </select>
        <?php } ?>
      <select class="selectpicker col-xs-2 chosen-select-dissearch display_block" name="status_m"  id="status_m" data-width="200px">
        <option value="">--- All Status ---</option>
        <option value="0">Waiting</option>
        <option value="1">Published</option>
        <option value="2">Hide</option>
        <!-- <option value="3">Delete</option> -->
      </select>
      <div class="filter_report">
        <div class="input-group report_search">
          <input type="text" name="search_text" id="search_text" class="form-control input_box" placeholder="Search" autocomplete="off">
          <span class="input-group-addon bg-black btn-click-search">
            <i class="glyphicon glyphicon-search"></i>
          </span>
        </div>
      </div>
      <!-- <div class="box-search display_block pd_btn_10" id="icon-search" style="">
        <div class="input_box">
          <input type="text" name="search_text" id="search_text" class="form-control input_box" placeholder="Search" autocomplete="off">
        </div>
      </div> -->
    </div>
  </div>

  <div class="tabla_data">
    <table data-toggle="table" class="table-caseCh-list"
    data-sort-name="id"
    data-sort-order="DESC"
    data-side-pagination="server"
    data-pagination="true"
    data-page-size="10"
    data-page-list="[10, 50, 100, 200, ALL]"
    data-url="knowledge/method.php?method=get_knowledge"
    data-query-params="searchQueryParams"
    data-method="post">
    <thead>
      <th data-field="case_id" data-sortable="true" data-align="left" class="th_user">
     Case ID
      </th>
      <th data-field="title" data-sortable="true"  data-align="left" class="th_user">
      ชื่อเรื่องร้องเรียน
      </th>
      <th data-field="date" data-sortable="true"  data-align="center" class="th_user center_table">
        วันที่สร้าง
      </th>
      <th data-field="ststus" data-sortable="true"  data-align="center" class="th_user center_table">
        Status
      </th>
      <th data-field="del" data-sortable="false"  data-align="center" class="cen_kl" >
      </th>
    </tr>
  </thead>
</table>
</div>
</div>


<!--  edit_emp -->
<form method="POST" action="knowledge/method.php?method=save_knowledge"  enctype="multipart/form-data" target="iframe-data"  >
  <div class="modal fade modal_view_app" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-body" id="view_date">
        <div class="box_gp_app">
          <div class="row form-group kl_box_status">
            <div class="col-md-2 ">
              <input type="hidden" name="id" value="" id="id">
              <label for="message-text" class="control-label title_kl" style="padding-top: 10px;">สถานะ</label>
            </div>
            <div class="col-md-10">
              <div class="col-md-3">
                <div class="radio radio-danger">
                  <input type="radio" name="radio_status" id="radio3" value="0" checked="">
                  <label for="radio3 ib_wt"  class="ib_wt">
                    Waiting
                  </label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="radio radio-danger ">
                  <input type="radio" name="radio_status" id="radio4" value="1">
                  <label for="radio4" class="ib_pu">
                    Published
                  </label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="radio radio-danger">
                  <input type="radio" name="radio_status" id="radio5" value="2" checked="">
                  <label for="radio5" class="ib_hi">
                    Hide
                  </label>
                </div>
              </div>
            </div>
          </div>

          <div class="row form-group">
            <div class="col-md-12 no-margin-padding">
              <label for="message-text" class="control-label title_kl">ประเภทเรื่องร้องเรียน</label>
            </div>
            <div class="col-md-12 kl_box_status_1" id="compType_name">
            </div>
            <div class="col-md-8" id="v_tel">
            </div>
          </div>

          <div class="row form-group">
            <div class="col-md-6 no-margin-padding">
              <div class="col-md-12 no-margin-padding">
                <label for="message-text" class="control-label title_kl">ข้อมูลผู้ร้องเรียน</label>
              </div>
              <div class="col-md-12 no-margin-padding" style="padding-right:5px">

                <input type="text" class="form-control" name="applnt_name" value="" id="applnt_name">
              </div>
            </div>
            <div class="col-md-6 no-margin-padding">
              <div class="col-md-12 no-margin-padding">
                <label for="message-text" class="control-label title_kl">ข้อมูลผู้ถูกร้องเรียน</label>
              </div>
              <div class="col-md-12 no-margin-padding" style="padding-left:5px;">
                <input type="text" class="form-control" name="complnt_name" id="complnt_name" value="">
              </div>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-12 no-margin-padding">
              <div class="col-md-12 no-margin-padding">
                <label for="message-text" class="control-label title_kl">หัวข้อเรื่อง <label class="txt_no_del" for="">*</label></label>
              </div>
              <div class="col-md-12 no-margin-padding txt">
                <input type="text" class="form-control" name="caseDtl_title" id="caseDtl_title" value="">
              </div>
            </div>
          </div>
          <?php if($_SESSION["admin"]["empSection"]==1){ ?>
            <div class="row form-group">
              <div class="col-md-12 no-margin-padding">
                <div class="col-md-12 no-margin-padding">
                  <label for="message-text" class="control-label title_kl">ประเภทสินค้า <label class="txt_no_del" for="">*</label></label>
                </div>
                <div class="col-md-12 no-margin-padding kl_no_pd_p">
                  <select class="selectpicker col-xs-2 chosen-select-dissearch" name="prodType_id"  id="prodType_id" data-width="200px" style="padding: 0;" data-live-search="true">
                    <option value="">--- ประเภทสินค้า ---</option>
                    <?php
                  function prodTypeListMutiLv($lv,$ref_id){
                    include("../config/config.php");
                    $prodTypeArrObj = array();
                    $sql = "SELECT *
                    FROM Product_Type
                            WHERE prodType_level = '$lv'
                            AND prodType_status = '0'
                            AND prodType_enable = '1' ";
                    if($ref_id!=""){
                      $sql .= "AND prodType_ref_id = '$ref_id' ";
                    }
                    $query = $conn->query($sql);
                    $prod_num = $query->num_rows;
                    $lv++;
                      while($result = $query->fetch_assoc()){
                        $prodArr["prodType_id"] = $result["prodType_id"];
                        $prodArr["prodType_name"] = $result["prodType_name"];

                        $sql_sub = "SELECT *
                                    FROM Product_Type
                                    WHERE prodType_ref_id = '".$result["prodType_id"]."'
                                    AND prodType_level = '$lv'
                                    AND prodType_status = '0'
                                    AND prodType_enable = '1' ";
                        $query_sub = $conn->query($sql_sub);
                        $num_sub = $query_sub->num_rows;
                        $prodArr["prodType_sublist"] = $num_sub;
                        array_push($prodTypeArrObj,$prodArr);
                      }
                    return $prodTypeArrObj;
                  }

                  function getProdType($lv,$ref_id){
                    global $caseLst_cls;
                    $i=0;
                    foreach($caseLst_cls->prodTypeListMutiLv($lv,$ref_id) as $prod_type){
                      if($lv==1){
                        $option .= '<optgroup>';
                      }
                      if($lv > 1){
                        $arrow = '<i class=\'ditp-icon icon-ico-ditp-43\'></i>';
                      }else {
                        $arrow = '';
                      }
                      $ref_name_real = $ref_name."".$prod_type["prodType_name"];
                      $option .= '<option value="'.$prod_type["prodType_id"].'" rel="'.$prod_type["prodType_level"].'" data-content="<span style=\'padding-left:'.(20*($lv-1)).'px\'>'.$arrow.'<h style=\'display:none;\'>'.$ref_name_real.'</h>'.$prod_type["prodType_name"].'</span>" >
                                  '.$prod_type["prodType_name"].'
                                </option>';
                      if($prod_type["prodType_sublist"]>0){
                        $n_lv = $lv+1;
                        $option .= getProdType($n_lv,$prod_type["prodType_id"],$ref_name_real);
                      }
                      if($lv==1){
                        $option .= '</optgroup>';
                      }
                      $i++;

                    }
                    return $option;
                  }
                  echo getProdType(1,null,null);
              ?>
                  </select>
                </div>
              </div>
            </div>
          <?php }else if($_SESSION["admin"]["empSection"]==2){ ?>
            <div class="row form-group">
              <div class="col-md-12 no-margin-padding">
                <div class="col-md-12 no-margin-padding">
                  <label for="message-text" class="control-label title_kl">ประเภทความผิด <label class="txt_no_del" for="">*</label></label>
                </div>
                <div class="col-md-12 no-margin-padding  kl_no_pd_p">
                  <select class="selectpicker col-xs-2 chosen-select-dissearch" name="mistake_up"  id="mistake_up" data-width="200px" style="padding: 0;" data-live-search="true">
                    <option value="">ประเภทความผิด</option>
                    <?php
                    $sql_select = "SELECT * FROM  Incorrect_Type WHERE incType_status = '0' AND incType_enable = '1' ";
                      $query_select = $conn->query($sql_select);
                      while ($re =   $query_select->fetch_assoc()) {
                      ?>
                      <option value="<?=$re['incType_id']?>"><?=$re['incType_name']?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
          <?php } ?>

          <div class="row form-group">
            <div class="col-md-12 no-margin-padding">
              <div class="col-md-12 no-margin-padding">
                <label for="message-text" class="control-label title_kl">ความเป็นมาของประเด็นเรื่องร้องเรียน <label class="txt_no_del" for="">*</label></label>
              </div>
              <div class="col-md-12 no-margin-padding">
                <textarea class="form-control ckeditor" rows="4" id="caseDtl_derivation" name="caseDtl_derivation"></textarea>
              </div>
            </div>
          </div>

          <div class="row form-group">
            <div class="col-md-12 no-margin-padding">
              <div class="col-md-12 no-margin-padding">
                <label for="message-text" class="control-label title_kl">มูลค่าความเสียหาย</label>
              </div>
              <div class="col-md-12 no-margin-padding">
                <input type="text" class="form-control" name="caseDtl_damage_val" id="caseDtl_damage_val" value="">
              </div>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-12 no-margin-padding">
              <div class="col-md-12 no-margin-padding">
                <label for="message-text" class="control-label title_kl">ความต้องการของผู้ร้องเรียน</label>
              </div>
              <div class="col-md-12 no-margin-padding">
                <textarea class="form-control ckeditor" name="caseDtl_complnt_need" value="" id="caseDtl_complnt_need"></textarea>
              </div>
            </div>
          </div>

          <div class="row form-group">
            <div class="col-md-12 no-margin-padding">
              <div class="col-md-12 no-margin-padding">
                <label for="message-text" class="control-label title_kl">ผลการดำเนินการ <label class="txt_no_del" for="">*</label></label>
              </div>
              <div class="col-md-12 no-margin-padding">
                <div class="col-md-12 kl_box_status_1" id="caseClose_title">
                </div>
                <div class="col-md-12 no-margin-padding mr_10">
                  <textarea class="form-control" name="case_close_resultProcess" rows="3" id="case_close_resultProcess"></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
        </div>
        <div class="modal-footer no_border_footer">
            <button type="submit" class="btn  btn_submit">บันทึกข้อมูล</button>
          <button type="button" class="btn btn-default btn_can_kl" data-dismiss="modal">ยกเลิก</button>
        </div>
      </div>
    </div>
  </div>
</form>

<script type="text/javascript" src="../assets/widgets/ckeditor/ckeditor.js"></script>
<script>
$(document).ready(function() {

  CKEDITOR.config.toolbar = [
   ['Styles','Format','Font','FontSize'],
   ['Bold','Italic','Underline','StrikeThrough','-','Undo','Redo','-','Cut','Copy','Paste','Find','Replace','-','Outdent','Indent','-','Print'],
   ['TextColor','BGColor','Source']
  ] ;

  $( 'textarea.ckeditor').each( function() {

    CKEDITOR.replace( $(this).attr('id') );

  });

  $('.table-caseCh-list').on('load-success.bs.table', function (e) {
    auto_resize_menu();
  });
  $("input[name='search_text']").keypress(function(e) {
    if(e.which == 13) {
      $('.table-caseCh-list').bootstrapTable('refresh');
    }
  });
  $("select[name='product']").on('change', function() {
    $('.table-caseCh-list').bootstrapTable('refresh');
  });
  $("select[name='mistake']").on('change', function() {
    $('.table-caseCh-list').bootstrapTable('refresh');
  });

  $("select[name='status_m']").on('change', function() {
    $('.table-caseCh-list').bootstrapTable('refresh');
  });

});

$(document).on('click','.btn-click-search',function() {
  $('.table-caseCh-list').bootstrapTable('refresh');
});

function searchQueryParams(params) {
  params.status_m = $("select[name='status_m']").val();
  params.mistake = $("select[name='mistake']").val();
  params.product = $("select[name='product']").val();
  params.text = $("input[name='search_text']").val();
  if($('.search_date').prop("disabled")==false){
    params.date = $('.search_date').val();
  }
  return params; // body data
}


function Confirm_duplicate()
{
  var x = confirm("ยืนยันการ duplicate ข้อมูล ? ");
  if (x)
      return true;
  else
    return false;
}


</script>
