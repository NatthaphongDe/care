
<form class="form-horizontal form-caselist-search">
  <div class="row">
    <div class="col-md-12">
      <div id="page-title">
        <span class="col-sm-12 glyph-icon icon-inbox icon-title-text" aria-hidden="true">
          เรื่องร้องเรียนทั้งหมด
        </span>
        <div class="col-sm-12 col-casedate no-gutter">
          <div class="col-xs-12 col-sm-8 col-lg-9 no-gutter">

            <div class="input-group" style="width:150px;" >
              <input type="text" class="form-control daterange search_date" disabled>
              <span class="input-group-addon bg-black">
                <i class="glyph-icon icon-calendar"></i>
              </span>
            </div>
            <label>
              <input type="radio" name="open_date" value="1" class="open_date">
              Open
            </label>
            <label>
              <input type="radio" name="open_date" value="0" class="open_date" checked>
              Close
            </label>
            <label class="control-label hidden-xs">Case Date: </label>
          </div>
          <div class="col-xs-12 col-sm-4 col-lg-3 no-gutter">
            <div class="dropdown dropdown-search-valid search-valid-ditp " style="float: right;">
              <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                <img class="btn_search_valid btn_search_ditp" src="img/btn_search_ditp.png" />
              </button>
              <ul class="dropdown-menu">
                <li class="non-filter now_active"><a href="#">Non-Filter</a></li>
                <li class="search_ditp_active" ><a href="#" rel="pre-el">Member Pre-EL</a></li>
                <li class="search_ditp_active" ><a href="#" rel="el">Member EL</a></li>
                <li class="search_ditp_active" ><a href="#" rel="pre-tdc">Member Pre-TDC</a></li>
                <li class="search_ditp_active" ><a href="#" rel="tdc">Member TDC</a></li>
                <li class="search_ditp_active" ><a href="#" rel="otop">Member OTOP</a></li>
                <li class="search_ditp_active" ><a href="#" rel="sel">Member SEL</a></li>
                <li class="search_ditp_active" ><a href="#" rel="psl">Member SPL</a></li>
                <li class="search_ditp_active" ><a href="#" rel="lsp">Member LSP</a></li>
              </ul>
            </div>
            <input type="hidden" name="search_valid_ditp" value="" />

            <div class="btn_search_valid btn_search_dbd"></div>
            <input type="hidden" name="search_valid_dbd" value="" />
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <?php
    if($res_emp["empGroup_section"]=="1"){
    //print_r($caseLst_cls->prodTypeListMutiLv(1,null));
    ?>
    <div class="col-sm-3 chosen-select-elm">
      <select name="search_prod_type" class="chosen-select" data-live-search="true">
        <option value="" data-content="<span style='color:#777;'>--- ประเภทสินค้าทั้งหมด ---</span>">
          ประเภทสินค้าทั้งหมด
        </option>
        <?php
        function getProdType($lv,$ref_id,$ref_name){
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
            $ref_name_real = $ref_name."/".$prod_type["prodType_name"];
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
    <?php
  }else if($res_emp["empGroup_section"]=="2"){
    ?>
     <div class="col-sm-3 chosen-select-elm">
       <select name="search_incorrect_type" class="chosen-select" data-live-search="true">
         <option value="" data-content="<span style='color:#777;'>--- ประเภทความผิดทั้งหมด ---</span>">
           ประเภทความผิดทั้งหมด
         </option>
         <?php
         if(count($caseLst_cls->incorrect_type==0)){
           $caseLst_cls->incorrect_type = $caseLst_cls->incorrectTypeList();
         }
         foreach($caseLst_cls->incorrect_type as $incorrect_type){
           ?>
           <option value="<?php echo $incorrect_type["incType_id"] ?>" rel="" >
             <?php echo $incorrect_type["incType_name"] ?>
           </option>
           <?php
         }
         ?>
       </select>
     </div>
     <?php
    }
    ?>
    <div class="col-sm-3 chosen-select-elm">
      <select name="search_case_type" class="chosen-select" data-live-search="true">
        <option value="" data-content="<span style='color:#777;'>--- ประเภททั้งหมด ---</span>">
          ประเภททั้งหมด
        </option>
        <?php
        if(count($caseLst_cls->comp_type==0)){ //เช็คการนำเข้าข้อมูล "ประเภทการร้องเรียน" จากฐานข้อมูล
          $caseLst_cls->comp_type = $caseLst_cls->compTypeList(null,$caseLst_cls->admin_section);
        }

        foreach($caseLst_cls->comp_type as $comp_type_list){

          if(count($comp_type_list["compTypeSub1_list"])>0){
            ?>
            <option value="<?php echo $comp_type_list["compType_id"] ?>" rel="">
              <?php echo $comp_type_list["compType_name"] ?>
            </option>
            <?php
              foreach($comp_type_list["compTypeSub1_list"] as $compTypeSub1_list){

                if(count($compTypeSub1_list["compTypeSub2_list"])>0){
                  ?>
                  <option value="<?php echo $compTypeSub1_list["compTypeSub1_id"] ?>" rel="sub1" >
                    &nbsp;&nbsp;--&gt; <?php echo $compTypeSub1_list["compTypeSub1_name"] ?>
                  </option>
                  <?php
                  foreach($compTypeSub1_list["compTypeSub2_list"] as $compTypeSub2_list){
                    ?>
                    <option value="<?php echo $compTypeSub2_list["compTypeSub2_id"] ?>" rel="sub2" >
                      &nbsp;&nbsp;&nbsp;&nbsp;--&gt; <?php echo $compTypeSub2_list["compTypeSub2_name"] ?>
                    </option>
                    <?php
                  }
                }else{
                  ?>
                  <option value="<?php echo $compTypeSub1_list["compTypeSub1_id"] ?>" rel="sub1" >
                    &nbsp;&nbsp;--&gt; <?php echo $compTypeSub1_list["compTypeSub1_name"] ?>
                  </option>
                  <?php
                }
              }
          }else{
            ?>
            <option value="<?php echo $comp_type_list["compType_id"] ?>" rel="">
              <?php echo $comp_type_list["compType_name"] ?>
            </option>
            <?php
          }
        }
        ?>
      </select>
    </div>
    <div class="col-sm-3 chosen-select-dissearch-elm">
      <select name="search_priority" class="chosen-select-dissearch">
        <option value="" data-content="<span style='color:#777;'>--- ความสำคัญทั้งหมด ---</span>">
          ความสำคัญทั้งหมด
        </option>
        <?php
        if(count($caseLst_cls->priority_selct==0)){
          $caseLst_cls->priority_selct = $caseLst_cls->prioritySelectList(null,$caseLst_cls->admin_section);
        }
        foreach($caseLst_cls->priority_selct as $key => $value){
          ?>
          <option value="<?php echo $key ?>">
            <?php echo $value ?>
          </option>
          <?php
        }
        ?>
      </select>
    </div>
    <div class="col-sm-3 chosen-select-dissearch-elm search-ico-elm">
      <select name="search_status" class="chosen-select-dissearch">
        <option value="" data-content="<span style='color:#777;'>--- สถานะทั้งหมด ---</span>">
          สถานะทั้งหมด
        </option>
        <option value="0">
          Waiting
        </option>
        <option value="1">
          New
        </option>
        <option value="2">
          In Process
        </option>
        <optgroup label="Overdue">
          <option value="sub_over" data-content="<img class='ico-flag' style='float:left; margin-right:10px; width:16px; height:16px;' src='<?php echo "../".$caseLst_cls->setting_info["overdueMain_alert_img_path"] ?>' />Sub process" ></option>
          <option value="main_over" data-content="<img class='ico-flag' style='float:left; margin-right:10px; width:16px; height:16px;' src='<?php echo "../".$caseLst_cls->setting_info["overdueSub_alert_img_path"] ?>' />Main process" ></option>
        </optgroup>
        <optgroup label="Close">
          <?php
          if($caseLst_cls->admin_section=="1"){
            ?>
            <option value="1" data-content="<img class='ico-flag' style='float:left; margin-top:3px; margin-right:10px; width:16px; height:16px;' src='img/ico_caseClose_1.png' />ตกลงกันได้"></option>
            <option value="2" data-content="<img class='ico-flag' style='float:left; margin-top:3px; margin-right:10px; width:16px; height:16px;' src='img/ico_caseClose_2.png' />ผู้ร้องดำเนินการต่อ"></option>
            <option value="3"  data-content="<img class='ico-flag' style='float:left; margin-top:3px; margin-right:10px; width:16px; height:16px;' src='img/ico_caseClose_3.png' />กรมไม่สามารถดำเนินการได้ "></option>
            <?php
          }else if($caseLst_cls->admin_section=="2"){
            foreach ($caseLst_cls->caseCloseList() as $key => $value) {
              ?>
              <option value="<?php echo $key ?>" data-content="<?php echo $value ?>"></option>
              <?php
            }
          }
          ?>
          </optgroup>
      </select>
    </div>
  </div>
  <div class="row">

    <div class="col-sm-3  chosen-select-dissearch-elm">
      <select name="search_assign" class="chosen-select-dissearch" data-live-search="true">
        <option value="" data-content="<span style='color:#777;'>--- ผู้รับผิดชอบทั้งหมด ---</span>">
          ผู้รับผิดชอบทั้งหมด
        </option>
        <?php
        $emp_assign = $member_cls->emp_list_assign_all();
        foreach($emp_assign as $emp_assign_list){
          ?>
          <option value="<?php echo $emp_assign_list["data"] ?>">
            <?php echo $emp_assign_list["value"] ?>
          </option>
          <?php
        }
        ?>
      </select>
    </div>

    <div class="col-sm-3  chosen-select-dissearch-elm">


      <select name="search_channel" class="chosen-select-dissearch">
        <option value="" data-content="<span style='color:#777;'>--- ช่องทางทั้งหมด ---</span>">
          ช่องทางทั้งหมด
        </option>
        <?php
        function getChannalCase($lv,$ref_id,$ref_name){
          global $caseLst_cls;
          global $rs_case;
          $i=0;
          foreach($caseLst_cls->caseChannelListMutiLv($lv,$ref_id) as $case_channal){
            if($lv==1){
              $option .= '<optgroup>';
            }
            if($case_channal["caseCh_sublist"]>0){
              $disabled = '';
            }else{
              $disabled = '';
            }
            if($lv > 1){
              $arrow = '<i class=\'ditp-icon icon-ico-ditp-43\'></i>';
            }else {
              $arrow = '';
            }
            $ref_name_real = $ref_name."/".$case_channal["caseCh_name"];
            $option .= '<option '.$disabled.' '.($rs_case["case_feild"]["caseCh_id"]==$case_channal["caseCh_id"]?'selected':'').' value="'.$case_channal["caseCh_id"].'" rel="'.$case_channal["prodType_other_flag"].'"
            rel="'.$case_channal["caseCh_level"].'" data-content="<span style=\'padding-left:'.(20*($lv-1)).'px\'>'.$arrow.'<h style=\'display:none;\'>'.$ref_name_real.'</h>'.$case_channal["caseCh_name"].'</span>" >
                        '.$case_channal["caseCh_name"].'
                      </option>';
            if($case_channal["caseCh_sublist"]>0){
              $n_lv = $lv+1;
              $option .= getChannalCase($n_lv,$case_channal["caseCh_id"],$ref_name_real);
            }
            if($lv==1){
              $option .= '</optgroup>';
            }
            $i++;
          }
          return $option;
        }
        echo getChannalCase(1,null,null);
        ?>

      </select>
    </div>
    <div class="col-sm-3 search-ico-elm">
      <select name="search_country" class="search_country" data-live-search="true">
        <option value="" style="background:none;" data-content="<span style='color:#777;'>--- ประเทศทั้งหมด ---</span>">
          ประเทศทั้งหมด
        </option>
        <?php
        if(count($caseLst_cls->case_country==0)){
          $caseLst_cls->case_country = $caseLst_cls->countryList();
        }
        foreach($caseLst_cls->case_country as $case_country_list){
          ?>
          <option value="<?php echo $case_country_list["id"] ?>" data-content="<img class='ico-flag' style='float:left; margin-right:10px;' src='<?php echo $case_country_list["flag_32"] ?>'><?php echo $case_country_list["name"] ?>">

          </option>
          <?php
        }
        ?>
      </select>
    </div>
    <div class="col-sm-3">
      <div class="input-group">
        <input type="text" class="form-control" name="search_text" value="">
        <span class="input-group-addon bg-black btn-click-search">
          <i class="glyph-icon icon-search"></i>
        </span>
      </div>
    </div>
  </div>
</form>

<table data-toggle="table" class="table-case-list"
data-sort-name="date"
data-sort-order="desc"
data-side-pagination="server"
data-pagination="true"
data-page-size="20"
data-page-list="[20, 50, 100, 200, ALL]"
data-url="function.php?method=getCaseList"
data-query-params="searchQueryParams"
data-method="post">
<thead>
  <tr>
    <th data-field="caseId"
    data-sortable="true"
    data-align="center">
    Case ID
  </th>
  <th data-field="subject" data-sortable="true" data-align="left">
    Subject
  </th>
  <th data-field="applnt" data-sortable="true"  data-align="center">
    ผู้ร้องเรียน
  </th>
  <th data-field="complnt" data-sortable="true"  data-align="center">
    ผู้ถูกร้องเรียน
  </th>
  <th data-field="assign" data-sortable="true"  data-align="left">
    ผู้รับผิดชอบ
  </th>
  <th data-field="office" data-sortable="true"  data-align="left">
    สำนัก
  </th>
  <th data-field="date" data-sortable="true"  data-align="center">
    Date
  </th>
  <th data-field="status" data-sortable="true" data-align="left">
    Status
  </th>

</tr>
</thead>
</table>



<!-- Daterangepicker -->
<script type="text/javascript" src="assets/widgets/daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="assets/widgets/daterangepicker/moment.js"></script>


<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="assets/bootstrap-table/dist/bootstrap-table.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="assets/bootstrap-table/dist/bootstrap-table.min.js"></script>
<!-- Latest compiled and minified Locales -->
<script src="assets/bootstrap-table/dist/locale/bootstrap-table-th-TH.min.js"></script>

<link rel="stylesheet" type="text/css" href="css/case_detail.css">
<link rel="stylesheet" type="text/css" href="css/case_list.css">

<script>
var case_list = new case_list_class();

// function getcaseList() {
//   return new Promise((resolve, reject) => {
//     $.ajax({
//       url: 'function.php?method=getCaseList',
//       type: 'POST',
//       success: function (data) {
//         resolve(JSON.parse(data))
//       },
//       error: function (error) {
//         reject(error)
//       },
//     })
//   })
// }

// getcaseList()
// .then((data) => {
//   console.log(data);
// })
// .catch((error) => {
//   console.log(error)
// })


var qrStr = {};
$(function() {
  <?php
  foreach ($_GET as $key => $value) {
    if(!($key=="page")){
      ?>
      qrStr['<?php echo $key ?>'] =  '<?php echo $value ?>';
      <?php
    }
  }
  ?>

  $(".search_country").selectpicker();
  $(".chosen-select-dissearch").selectpicker();
  $(".chosen-select").selectpicker();
  $(".chosen-search").append('<i class="glyph-icon icon-search"></i>');
  $(".chosen-single div").html('<i class="glyph-icon icon-angle-down"></i>');

  $('.daterange').daterangepicker({
    format: 'DD/MM/YYYY',
    startDate: moment().subtract(29, 'days'),
    endDate: moment(),
    ranges: {
      'Today': [moment(), moment()],
      'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Last 7 Days': [moment().subtract(6, 'days'), moment()],
      'Last 30 Days': [moment().subtract(29, 'days'), moment()],
      'This Month': [moment().startOf('month'), moment().endOf('month')],
      'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
      'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
    }
  });


    $('.table-case-list').on('load-success.bs.table', function (e, name, args) {
        auto_resize_menu();
      $('[data-toggle="tooltip"]').tooltip();
      var stateObj = { "page": "case_list" };
      //history.replaceState(stateObj, "DITP Care", "index.php?page=case_list");
      qrStr = new Array();
    });



    $("select[name='search_prod_type']").change(function() {
      $('.table-case-list').bootstrapTable('refresh');
    });
    $("select[name='search_incorrect_type']").change(function() {
      $('.table-case-list').bootstrapTable('refresh');
    });
    <?php
    if($_GET["assign_emp_id"]!=""){
      ?>
      for (var k in qrStr){
        if(k=='assign_emp_id'){
          $("select[name='search_assign'] option[value='<?php echo $_GET["assign_emp_id"] ?>']").prop("selected",true);
          $(".chosen-select-dissearch").selectpicker("refresh");
        }
      }
      <?php
    }
    ?><?php
    if($_GET["case_status"]!=""){
      if($_GET["case_status"]=="5"){
        $case_status = "main_over";
      }else{
        $case_status = $_GET["case_status"];
      }
      ?>
      for (var k in qrStr){
        if(k=='case_status'){
          $("select[name='search_status']").find("option[value='<?php echo $case_status ?>']").prop("selected",true);
          $("select[name='search_status']").selectpicker("refresh");
          var text =   $("select[name='search_status']").find("option[value='<?php echo $case_status ?>']").html();
          $("select[name='search_status']").parents('.bootstrap-select').find('.filter-option').html(text);
        }
      }
      <?php
    }
    if($_GET["assign_emp_id"]!="" || $_GET["case_status"]!=""){
      ?>
      $('.table-case-list').bootstrapTable('refresh');
      <?php
    }
    ?>
    $("select[name='search_assign']").change(function() {
      $('.table-case-list').bootstrapTable('refresh');
    });
    $("select[name='search_case_type']").on('change', function() {
      $('.table-case-list').bootstrapTable('refresh');
    });
    $("select[name='search_priority']").on('change', function() {
      $('.table-case-list').bootstrapTable('refresh');
    });
    $("select[name='search_status']").on('change', function() {
      $('.table-case-list').bootstrapTable('refresh');
    });
    $("select[name='search_channel']").on('change', function() {
      $('.table-case-list').bootstrapTable('refresh');
    });
    $("select[name='search_country']").on('change', function() {
      $('.table-case-list').bootstrapTable('refresh');
    });
    $("input[name='search_text']").keypress(function(e) {
      if(e.which == 13) {
        $('.table-case-list').bootstrapTable('refresh');
      }
    });
    $(".open_date").click(function(){
      var flag = $(this).val();
      if(flag==1){
        $(".search_date").prop("disabled",false);
        $('.table-case-list').bootstrapTable('refresh');
      }else{
        $(".search_date").prop("disabled",true);
        $('.table-case-list').bootstrapTable('refresh');
      }
    });


    $('.search_date').on('apply.daterangepicker', function(ev, picker) {
        $('.table-case-list').bootstrapTable('refresh');
    });

    $('.btn_search_dbd').click(function(){
      $(this).toggleClass("active");
      if($(this).hasClass('active')){
        $('input[name="search_valid_dbd"]').val(1);
      }else{
        $('input[name="search_valid_dbd"]').val('');
      }
      $('.table-case-list').bootstrapTable('refresh');
    });
    $('.search-valid-ditp .dropdown-menu li a').click(function(){
      $('.search-valid-ditp .dropdown-menu li').removeClass("now_active");
      $(this).parent("li").addClass("now_active");
      if($(this).parent("li").hasClass("search_ditp_active")){
        $('.search-valid-ditp button .btn_search_ditp').attr("src","img/btn_search_ditp_active.png");
        $('input[name="search_valid_ditp"]').val($(this).attr("rel"));
      }else{
        $('.search-valid-ditp button .btn_search_ditp').attr("src","img/btn_search_ditp.png");
        $('input[name="search_valid_ditp"]').val('');
      }
      $('.table-case-list').bootstrapTable('refresh');
    });

    $('.btn-click-search').click(function(){
      
      $('.table-case-list').bootstrapTable('refresh');
    });

  });

  function searchQueryParams(params) {

    <?php
    foreach ($_GET as $key => $value) {
      if(!($key=="page" || $key=="case_status")){
        ?>
        for (var k in qrStr){
          if(k=='<?php echo $key ?>'){
            if(k=='assign_emp_id'){
              params.search_assign = $("select[name='search_assign']").val();
            }
            params.<?php echo $key ?> = '<?php echo $value ?>';
          }
        }
        <?php
      }
    }
    ?>
    if(params.search_assign==undefined){
      params.search_assign = $("select[name='search_assign']").val();
    }

    params.prod_type = $("select[name='search_prod_type']").val();
    params.prod_type_lv = $('select[name="search_prod_type"]').find(':selected').attr('rel');

    params.channel = $("select[name='search_channel']").val();
    params.channel_lv = $('select[name="search_channel"]').find(':selected').attr('rel');

    params.incorrect_type = $("select[name='search_incorrect_type']").val();



    var case_group = $('select[name="search_case_type"] :selected').attr('rel');
    if(case_group=="sub1"){
      params.case_type_sub1 = $("select[name='search_case_type']").val();
    }else if(case_group=="sub2"){
      params.case_type_sub2 = $("select[name='search_case_type']").val();
    }else{
      params.case_type = $("select[name='search_case_type']").val();
    }
    params.priority = $("select[name='search_priority']").val();

    var label_status=$('select[name="search_status"] :selected').parent().attr('label');
    if(label_status=="Close"){
      params.close_id = $("select[name='search_status']").val();
      params.status = "3";
    }else{
      params.close_id = "";
      params.status = $("select[name='search_status']").val();
    }
    params.country = $("select[name='search_country']").val();
    params.text = $("input[name='search_text']").val();
    if($('.search_date').prop("disabled")==false){
      params.date = $('.search_date').val();
    }
    params.valid_dbd = $("input[name='search_valid_dbd']").val();
    params.valid_ditp = $("input[name='search_valid_ditp']").val();


    return params; // body data
  }
  </script>
