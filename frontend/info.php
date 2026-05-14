<?php

function prodTypeListMutiLv($lv,$ref_id,$pro_id){
  include('../config/config.php');
  $prodTypeArrObj = array();
  $sql = "SELECT *
  FROM Product_Type
          WHERE prodType_level = '$lv'
          AND prodType_status = '0'
          AND prodType_enable = '1' ";
  if($ref_id!=""){
    $sql .= "AND prodType_ref_id = '$ref_id' ";
  }else {
    $sql .= "AND prodType_id = '$pro_id' ";
  }
  $query = $conn->query($sql);
  $prod_num = $query->num_rows;
  $lv++;
    while($result = $query->fetch_assoc()){
      $prodArr["prodType_id"] = $result["prodType_id"];
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

function getProdType($lv,$ref_id,$pro_id){
  global $prodType;
  include('../config/config.php');
$i=0;
foreach(prodTypeListMutiLv($lv,$ref_id,$pro_id) as $prod_type){
  if($prod_type["prodType_sublist"]>0){
    $n_lv = $lv+1;
    $option .= getProdType($n_lv,$prod_type["prodType_id"],$prod_type["prodType_id"]);
  }
  array_push($prodType,$prod_type["prodType_id"]);
  $i++;
}

return $prodType;
}

if($_POST['method'] == "search_info"){
  include('config/config.php');
  $lang = $_POST['lang'];
  include('lang.php');
  $start_page = $_POST['start_page'];
  $end_page = $_POST['end_page'];
  $search_text = $_POST['search_text'];
  $sel_hr_info = $_POST['sel_hr_info'];
  $sel_category_info = $_POST['sel_category_info'];


  if($start_page == ""){
    $start_page = 0;
  }
  if($end_page == ""){
    $end_page = 5;
  }
  if ($_POST['currentPage']==""){
		$page_chk =1;
	} else{
		$page_chk = $_POST['currentPage'];
	}

  if ($_POST['numpage']==""){
    $start_page=0;
    $end_page = 5;
  } else{
    $start_page = $start_page;
    $end_page = $end_page;
  }

    if($search_text == ""){
      $search_txt = "";
    }else {
      $search_txt = "AND (ck.caseDtl_title LIKE '%$search_text%')";
    }

    if($sel_hr_info == "0"){
      $search_Comp = "";
    }else {
      $search_Comp = "AND ck.compType_id = '$sel_hr_info'";
    }
    if($_POST['type'] == "2"){
      if($sel_category_info == "0"){
        $search_Product = "";
      }else {
        $search_Product = "AND (ck.incType_id = '$sel_category_info')";
      }
    }else {
      if($_POST['type_val'] == "2"){
        if($sel_category_info == "0"){
          $search_Product = "";
        }else {
          $search_Product = "AND (ck.incType_id = '$sel_category_info')";
        }
      }else {
        if($sel_category_info == "0"){
          $search_Product = "";
        }else {
          $sql_pro = "SELECT * FROM Product_Type WHERE prodType_id = '$sel_category_info'";
          $query_pro = $conn->query($sql_pro);
          $re = $query_pro->fetch_assoc();
          $prodType = array();
          $pro =  getProdType($re['prodType_level'],null,$sel_category_info);
          if(join(',',$pro) == ""){
            $inpro = "''";
          }else {
            $inpro = join(',',$pro);
          }
          $search_Product = "AND ck.prodType_id IN (".$inpro.")";
        }
      }
    }

    if($_POST['type'] == ""){
      $search_type = "AND (ct.compType_section = '".$_POST['type_val']."')";
    }else {
      $search_type = "AND (ct.compType_section = '".$_POST['type']."')";
    }



  $sql = "SELECT
    ck.caseDtl_title,
    ck.compType_id,
    ck.prodType_id,
    ck.caseKnlg_id,
    ck.caseKnlg_status,
    ck.incType_id,
    it.incType_name,
    it.incType_name_en,
    ct.compType_name,
    ct.compType_name_en,
    pt.prodType_name,
    pt.prodType_name_en
    FROM `Case_Knowledge` AS ck
    LEFT JOIN `Complaint_Type` AS ct ON ck.compType_id = ct.compType_id
    LEFT JOIN `Product_Type` AS pt ON ck.prodType_id = pt.prodType_id
    LEFT JOIN `Incorrect_Type` AS it ON ck.incType_id = it.incType_id
    WHERE ck.caseKnlg_status = '1' $search_txt $search_Comp $search_Product $search_type
    LIMIT $start_page,$end_page";

    $query = $conn->query($sql);
    if($query->num_rows > 0){
      while ($re = $query->fetch_assoc()) {
        if($lang == "2"){
          $prodType_name = $re['prodType_name_en'];
          $incType_name = $re['incType_name_en'];
        }else {
          $prodType_name = $re['prodType_name'];
          $incType_name = $re['incType_name'];
        } ?>
        <div class="panel panel-default appeal_panel">
          <div class="panel-heading hr_info_panel">
            <span class="hr_txt_info"><?=$txt_Subject?> : </span>
            <span class="txt_info"><?php echo $re['caseDtl_title'];?></span>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-1 col-sm-1 col-xs-3">
                <div class="div_icon_globe"><span class="icon_globe"><img src="images/icon_globe.png"></span></div>
                <div class="div_icon_book_green"><span class="icon_book_green"><img src="images/icon_book_green.png"></span></div>
              </div>
              <div class="col-md-10 col-sm-9 col-xs-9 no-padding">
                <div class="type_info">
                  <span class="txt_hr_type_info"><?=$txt_Type_petition_hr?></span></p>
                  <span class="txt_type_info">
                     <?php
                      if($lang == "2"){
                        echo $re['compType_name_en'];
                      }else {
                        echo $re['compType_name'];
                      }
                      ?>
                    </span>
                </div>
                <div class="type_cat">
                  <?php if($re['prodType_id'] != 0){?>
                  <span class="txt_hr_type_cat"><?=$txt_Type_goods?></span></p>
                  <span class="txt_type_cat"><?php echo $prodType_name?></span>
                  <?php }else { ?>
                    <span class="txt_hr_type_cat"><?=$txt_complaint?></span></p>
                    <span class="txt_type_cat"><?php echo $incType_name?></span>
                  <?php } ?>
                </div>
              </div>
              <div class="col-md-1 col-sm-2 search_info"><span class="icon_search_detail"><a href="?page=info_detail&ck_id=<?=$re['caseKnlg_id'];?>" target="_blank"><img src="images/all_icon_DITP/icon_26.svg" style="width:40px;"></a></span></div>
            </div>
        </div>
        </div>
      <?php }
    }else { ?>
      <div class="panel panel-default appeal_panel">
        <div class="panel-heading hr_info_panel"></div>
        <div class="panel-body">
          <div class="row">
            <div class="col-md-12" style="text-align:center;">
              <span><?=$txt_not_found?></span>
            </div>
          </div>
      </div>
    </div>
    <?php }
  ?>
  <div class="next_page">
      <nav aria-label="Page navigation example">
        <ul class="pagination">
          <?php
          $sql = "SELECT
          ck.caseDtl_title,
          ck.compType_id,
          ck.prodType_id,
          ck.caseKnlg_id,
          ck.caseKnlg_status,
          ck.incType_id,
          it.incType_name,
          it.incType_name_en,
          ct.compType_name,
          ct.compType_name_en,
          pt.prodType_name,
          pt.prodType_name_en
          FROM `Case_Knowledge` AS ck
          LEFT JOIN `Complaint_Type` AS ct ON ck.compType_id = ct.compType_id
          LEFT JOIN `Product_Type` AS pt ON ck.prodType_id = pt.prodType_id
          LEFT JOIN `Incorrect_Type` AS it ON ck.incType_id = it.incType_id
          WHERE ck.caseKnlg_status = '1' $search_txt $search_Comp $search_Product $search_type";
          $query = $conn->query($sql);
          $sum_page = $query->num_rows;
          $page = $sum_page/5;
          $page_x = 5;
          $page_y = 0;
          ?>
          <?php if($sum_page > 0){
            if($page_chk > 1){
              ?>
          <li class="page-item">
            <a class="page-link" href="#" aria-label="Previous" id="prev" onclick="btnnextpage(1);">
              <span aria-hidden="true"><img src="images/icon_previous.png" style="margin-top:6px;"></span>
              <span class="sr-only">Previous</span>
            </a>
          </li>
          <?php }else{?>
            <li class="page-item" style="opacity: 0.5;">
              <a class="page-link" href="#" aria-label="Previous" id="prev" style="pointer-events: none;">
                <span aria-hidden="true"><img src="images/icon_previous.png" style="margin-top:6px;"></span>
                <span class="sr-only">Previous</span>
              </a>
            </li>
            <?php } } ?>

          <?php for($i=1; $i<=ceil($page); $i++){ ?>
              <li <?= ($i == $page_chk) ? "class='page-item active'" : "page-item" ?>><a class="page-link" href="#" onclick="search_info(<?=$page_y;?>,<?=$page_x?>,<?=$i?>,1)"><?=$i;?></a></li>
          <?php
          $page_x = $page_x+5;
          $page_y = $page_x-5;
            }
          ?>
          <?php
          if($sum_page > 0){

          if($page_chk < ceil($page)){ ?>
          <li class="page-item">
            <a class="page-link" href="#" aria-label="Next" id="nexts" onclick="btnnextpage(2);">
              <span aria-hidden="true"><img src="images/icon_nextpage.png" style="margin-top:6px;"></span>
              <span class="sr-only">Next</span>
            </a>
          </li>
          <?php }else { ?>
            <li class="page-item" style="opacity: 0.5;">
              <a class="page-link" href="#" aria-label="Next" id="nexts" style="pointer-events: none;">
                <span aria-hidden="true"><img src="images/icon_nextpage.png" style="margin-top:6px;"></span>
                <span class="sr-only">Next</span>
              </a>
            </li>
          <?php } } ?>
        </ul>
      </nav>
  </div>
<?php
  exit();
}
?>


<div class="row info_div_row">
  <div class="col-md-12">
    <span class="icon_hr_info"><img src="images/all_icon_DITP/icon_8.svg" style="width:30px;" class="icon_info"></span>
    <span class="txt_hr_info"><?=$txt_Knowledge?></span>

    <div class="row div_status_appeal info_search_hr">

       <div class="col-md-4 col-sm-12 no-padding col-cat">
         <div class="row">
           <div class="col-md-5 col-sm-3 no-padding">
             <span class="hr_info_search_hr_ex"><?=$txt_choose_complaint_topic?> : </span>
          </div>
           <div class="div_category_1" style="display:inline-block;">
             <div class="col-md-7 col-sm-9 nopadding">
                   <select class="form-control sel_category_info sel_cat_info_ex" id="sel_category_info">
                     <option value="0"><?=$txt_Please_wait?></option>
                   </select>
                 </div>
            </div>
            <div class="col-md-7 col-sm-9 nopadding">
         <select class="selectpicker form-control sel_hr_info" id="sel_hr_info" onchange="search_info(0,5,1);">
           <option value="0"><?php if($lang == "1"){ echo "ทั้งหมด";}elseif($lang == "2"){ echo "All";}else{ echo "ทั้งหมด";}?></option>
           <?php
           $sql = "SELECT * FROM `Complaint_Type` WHERE compType_status = 0";
           $query = $conn->query($sql);
           while ($re = $query->fetch_assoc()) { ?>
             <option value="<?php echo $re['compType_id'];?>,<?php echo $re['compType_section'];?>">
                <?php
                 if($lang == "2"){
                   echo $re['compType_name_en'];
                 }else {
                   echo $re['compType_name'];
                 }
                 ?>
               </option>
          <?php
           }
           ?>
         </select>
       </div>
       </div>
       </div>

       <div class="col-md-4 col-sm-12 no-padding col-category">

         <div class="row">
           <div class="col-md-5 col-sm-3 no-padding">
             <span class="hr_info_search_hr"><?=$txt_choose_type?> : </span>
           </div>
         <div class="div_category_1" id="div_category_1_ex" style="display:inline-block;width: 205px;float: left;margin-left: 15px;">
           <!-- <div class="col-md-7"> -->
           <select class="form-control sel_cat_info_hr" id="sel_cat_info_hr">
             <option value="0"><?=$txt_Please_wait?></option>
           </select>
         <!-- </div> -->
        </div>
        <div class="col-md-7 col-sm-9 nopadding">
         <div class="div_category" style="display:inline-block;">
         <select class="selectpicker form-control sel_cat_info" id="sel_cat_info" onchange="search_info_type();">
           <option value="1"><?=$txt_Type_goods?></option>
           <option value="2"><?=$txt_complaint?></option>
         </select>
       </div>
      </div>
    </div>

      </div>

       <div class="col-md-4 col-sm-12 no-padding col-category-1">
         <div class="row">
           <div class="col-md-5 col-sm-3 no-padding hr_info_search_hr_div">
         <span class="hr_info_search_hr"><?=$txt_Type_goods?> : </span>
       </div>
           <div class="div_category_1" style="display:inline-block; width: 205px; float: left;margin-left: 15px;">
                   <select class="form-control sel_category_info" id="sel_category_info">
                     <option value="0"><?=$txt_Please_wait?></option>
                   </select>
            </div>
          <div class="col-md-7 col-sm-9 nopadding">
            <div class="div_category_2" style="display:none;"></div>
          </div>
          </div>
         <!-- <span class="img_search_info"><img src="images/icon_search.png" onclick="search_info();"></span> -->
       </div>

       <div class="col-md-4 col-sm-12 no-padding col-category-2" style="display:none;">
         <div class="row">
           <div class="col-md-5 col-sm-3 no-padding hr_info_search_hr_div">
         <span class="hr_info_search_hr"><?=$txt_complaint?> : </span>
        </div>
           <div class="div_category_1" style="display:inline-block;width: 205px;float: left;margin-left: 15px;">
                   <select class="form-control sel_Incor_info" id="sel_Incor_info">
                     <option value="0"><?=$txt_Please_wait?></option>
                   </select>
                 </div>

              <div class="col-md-7 col-sm-9 nopadding">
            <div class="div_category_3" style="display:none;">
              <select class="selectpicker form-control sel_Incorrect_info" id="sel_Incorrect_info" onchange="search_info(0,5,1);">
                <option value="0"><?php if($lang == "1"){ echo "ทั้งหมด";}elseif($lang == "2"){ echo "All";}else{ echo "ทั้งหมด";}?></option>
                <?php
                $sql = "SELECT * FROM `Incorrect_Type` WHERE incType_status = 0 AND incType_enable = 1";
                $query = $conn->query($sql);
                while ($re = $query->fetch_assoc()) { ?>
                  <option value="<?php echo $re['incType_id'];?>">
                     <?php
                      if($lang == "2"){
                        echo $re['incType_name_en'];
                      }else {
                        echo $re['incType_name'];
                      }
                      ?>
                    </option>
               <?php
                }
                ?>
              </select>
            </div>
          </div>
          </div>
       </div>

       <div class="col-md-12 col-sm-12 div_search_info" style="margin-top:20px;">
         <div class="col-sm-3 no-padding"></div>
         <div class="col-sm-9 no-padding">
         <div class="input-group appeal_search appeal_search_info">
          <input type="text" class="form-control search_text" placeholder="<?php if($lang == "1"){ echo "ค้นหา";}elseif($lang == "2"){ echo "Search";}else{ echo "ค้นหา";}?>" name="search_text" onkeypress="search_info_enter(event,0,5,1);" style="border-right-width: 0px;">
          <span class="input-group-addon bg-black btn-click-search">
            <i class="glyphicon glyphicon-search" onclick="search_info(0,5,1);"></i>
          </span>
        </div>
        </div>
       </div>
    </div>
    <div class="info_center">

      <?php
        $sql = "SELECT
        ck.caseDtl_title,
        ck.compType_id,
        ck.prodType_id,
        ck.caseKnlg_id,
        ck.caseKnlg_status,
        ck.incType_id,
        it.incType_name,
        it.incType_name_en,
        ct.compType_name,
        ct.compType_name_en,
        pt.prodType_name,
        pt.prodType_name_en
        FROM `Case_Knowledge` AS ck
        LEFT JOIN `Complaint_Type` AS ct ON ck.compType_id = ct.compType_id
        LEFT JOIN `Product_Type` AS pt ON ck.prodType_id = pt.prodType_id
        LEFT JOIN `Incorrect_Type` AS it ON ck.incType_id = it.incType_id
        WHERE ck.caseKnlg_status = '1'
        LIMIT 5";
        $query = $conn->query($sql);
        if($query->num_rows > 0){
          while ($re = $query->fetch_assoc()) {
            if($lang == "2"){
              $prodType_name = $re['prodType_name_en'];
              $incType_name = $re['incType_name_en'];
            }else {
              $prodType_name = $re['prodType_name'];
              $incType_name = $re['incType_name'];
            }
            ?>
            <div class="panel panel-default appeal_panel">
              <div class="panel-heading hr_info_panel">
                <span class="hr_txt_info"><?=$txt_Subject?> : </span>
                <span class="txt_info"><?php echo $re['caseDtl_title'];?></span>
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-1 col-sm-1 col-xs-3">
                    <div class="div_icon_globe"><span class="icon_globe"><img src="images/icon_globe.png"></span></div>
                    <div class="div_icon_book_green"><span class="icon_book_green"><img src="images/icon_book_green.png"></span></div>
                  </div>
                  <div class="col-md-10 col-sm-9 col-xs-9 no-padding">
                    <div class="type_info">
                      <span class="txt_hr_type_info"><?=$txt_Type_petition_hr?></span></p>
                      <span class="txt_type_info">
                        <?php
                        if($lang == "2"){
                          echo $re['compType_name_en'];
                        }else {
                          echo $re['compType_name'];
                        }
                        ?>
                      </span>
                    </div>
                    <div class="type_cat">
                      <?php if($re['prodType_id'] != 0){?>
                      <span class="txt_hr_type_cat"><?=$txt_Type_goods?></span></p>
                      <span class="txt_type_cat"><?php echo $prodType_name?></span>
                      <?php }else { ?>
                        <span class="txt_hr_type_cat"><?=$txt_complaint?></span></p>
                        <span class="txt_type_cat"><?php echo $incType_name?></span>
                      <?php } ?>
                    </div>
                  </div>
                  <?php if($_SESSION['member_id'] == ""){
                    $lang_info = "&lang=".htmlspecialchars($_GET['lang'], ENT_QUOTES);
                  }else {
                    $lang_info = "";
                  }?>
                  <div class="col-md-1 col-sm-2 search_info"><span class="icon_search_detail"><a href="?page=info_detail&ck_id=<?=$re['caseKnlg_id'];?><?=$lang_info?>"><img src="images/all_icon_DITP/icon_26.svg" style="width:40px;"></a></span></div>
                </div>
            </div>
            </div>
          <?php }
        }else { ?>
          <div class="panel panel-default appeal_panel">
            <div class="panel-heading hr_info_panel"></div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-12" style="text-align:center;">
                  <span><?=$txt_not_found?></span>
                </div>
              </div>
          </div>
        </div>
        <?php }
      ?>
      <div class="next_page">
          <nav aria-label="Page navigation example">
            <ul class="pagination">
              <?php if($query->num_rows > 0){?>
              <li class="page-item" style="opacity: 0.5;">
                <a class="page-link" href="#" aria-label="Previous" id="prev" onclick="btnnextpage(1);" style="pointer-events: none;">
                  <span aria-hidden="true"><img src="images/icon_previous.png" style="margin-top:6px;"></span>
                  <span class="sr-only">Previous</span>
                </a>
              </li>
              <?php } ?>
              <?php
              $sql = "SELECT
              ck.caseDtl_title,
              ck.compType_id,
              ck.prodType_id,
              ck.caseKnlg_id,
              ck.caseKnlg_status,
              ct.compType_name,
              ct.compType_name_en,
              pt.prodType_name
              FROM `Case_Knowledge` AS ck
              LEFT JOIN `Complaint_Type` AS ct ON ck.compType_id = ct.compType_id
              LEFT JOIN `Product_Type` AS pt ON ck.prodType_id = pt.prodType_id
              WHERE ck.caseKnlg_status = '1'";
              $query = $conn->query($sql);
              $sum_page = $query->num_rows;
              $page = $sum_page/5;
              $page_x = 5;
              $page_y = 0;
              $page_chk = 1;
              for($i=1; $i<=ceil($page); $i++){ ?>
                  <li <?= ($i == $page_chk) ? "class='page-item active'" : "class='page-item'" ?>><a class="page-link" href="#" onclick="search_info(<?=$page_y;?>,<?=$page_x?>,<?=$i?>,1)"><?=$i;?></a></li>
              <?php
              $page_x = $page_x+5;
              $page_y = $page_x-5;
                }
              ?>
              <?php
              if($sum_page > 0 ){
              if($page_chk < ceil($page)){ ?>
              <li class="page-item">
                <a class="page-link" href="#" aria-label="Next" id="nexts" onclick="btnnextpage(2);">
                  <span aria-hidden="true"><img src="images/icon_nextpage.png" style="margin-top:6px;"></span>
                  <span class="sr-only">Next</span>
                </a>
              </li>
              <?php }else { ?>
                <li class="page-item" style="opacity: 0.5;">
                  <a class="page-link" href="#" aria-label="Next" id="nexts" style="pointer-events: none;">
                    <span aria-hidden="true"><img src="images/icon_nextpage.png" style="margin-top:6px;"></span>
                    <span class="sr-only">Next</span>
                  </a>
                </li>
              <?php } } ?>
            </ul>
          </nav>
      </div>
    </div>
    <div class="info_search"></div>
  </div>
  <input type="hidden" class="start_numpage" value="0">
  <input type="hidden" class="end_numpage" value="5">
</div>

<script>
  function search_info(start,end,page,id){
    if(id == "1"){
      currentPage = page;
      $('.start_numpage').val(start);
      $('.end_numpage').val(end);
    }else {
      $('.start_numpage').val(start);
      $('.end_numpage').val(end);
    }
    var search_text = $('.search_text').val();
    var lang = $('.language_hidden').val();
    var el = document.getElementById("sel_hr_info");
    var strUserl = el.options[el.selectedIndex].value;
    var strUserl_ex = strUserl.split(',');
    var ex = document.getElementById("sel_cat_info");
    var type_val = ex.options[ex.selectedIndex].value;
    if(strUserl_ex[1] == "2"){
      var e = document.getElementById("sel_Incorrect_info");
      var strUser = e.options[e.selectedIndex].value;
    }else {
      if(type_val == "2"){
        var e = document.getElementById("sel_Incorrect_info");
        var strUser = e.options[e.selectedIndex].value;
      }else {
        var e = document.getElementById("sel_category_info_ex");
        var strUser = e.options[e.selectedIndex].value;
      }

    }
    if(strUserl_ex[1] == "2"){
      $('#sel_cat_info option[value="2"]').attr("selected",true);
      $('#sel_cat_info option[value="1"]').attr("selected",false);
      $('#sel_cat_info option[value="1"]').attr("disabled",true);
      $('#sel_cat_info option[value="2"]').attr("disabled",false);
      $('.col-category-1').hide();
      $('.col-category-2').show();
      $('.div_category_3').css('display','inline-block');
      $('.selectpicker').selectpicker('refresh');
    }else if(strUserl_ex[1] == "1"){
      $('#sel_cat_info option[value="1"]').attr("selected",true);
      $('#sel_cat_info option[value="2"]').attr("selected",false);
      $('#sel_cat_info option[value="2"]').attr("disabled",true);
      $('#sel_cat_info option[value="1"]').attr("disabled",false);
      $('.col-category-1').show();
      $('.col-category-2').hide();
      $('.div_category_3').css('display','none');
      $('.selectpicker').selectpicker('refresh');
    }else {
      // $('#sel_cat_info option[value="1"]').attr("selected",true);
      // $('#sel_cat_info option[value="2"]').attr("selected",false);
      $('#sel_cat_info option[value="2"]').attr("disabled",false);
      $('#sel_cat_info option[value="1"]').attr("disabled",false);
      // $('.col-category-1').show();
      // $('.col-category-2').hide();
      // $('.div_category_3').css('display','none');
      $('.selectpicker').selectpicker('refresh');
    }

      // var type_val = $('#sel_cat_info').val();

      console.log(strUserl_ex[1]);
    $.ajax({
        url: 'info.php',
        type: 'POST',
        async: false,
        responseType: "json",
        data: {
          'search_text':search_text,
          'sel_hr_info':strUserl_ex[0],
          'sel_category_info':strUser,
          'start_page':start,
          'end_page':end,
          'currentPage':currentPage,
          'numpage':numpage,
          'lang':lang,
          'page':page,
          'type':strUserl_ex[1],
          'type_val':type_val,
          "method":"search_info"
        },
      success: function(res) {
        $('.info_search').html(res);
        $('.info_center').hide();
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(jqXHR, textStatus, errorThrown);

      }
    });
  }

  function search_info_enter(e,start,end,page,id){
    if(id == "1"){
      currentPage = page;
      $('.start_numpage').val(start);
      $('.end_numpage').val(end);
    }else {
      $('.start_numpage').val(start);
      $('.end_numpage').val(end);
    }
    var lang = $('.language_hidden').val();
    var search_text = $('.search_text').val();
    var el = document.getElementById("sel_hr_info");
    var strUserl = el.options[el.selectedIndex].value;
    var strUserl_ex = strUserl.split(',');

    var ex = document.getElementById("sel_cat_info");
    var type_val = ex.options[ex.selectedIndex].value;
    // var type_val = $('#sel_cat_info').val();
    if(strUserl_ex[1] == "2"){
      var elx = document.getElementById("sel_Incorrect_info");
      var strUser = elx.options[elx.selectedIndex].value;
    }else {
      if(type_val == "2"){
        var elx = document.getElementById("sel_Incorrect_info");
        var strUser = elx.options[elx.selectedIndex].value;
      }else {
        var elx = document.getElementById("sel_category_info_ex");
        var strUser = elx.options[elx.selectedIndex].value;
      }

    }

    if(e.keyCode == 13){
      $.ajax({
          url: 'info.php',
          type: 'POST',
          async: false,
          responseType: "json",
          data: {
            'search_text':search_text,
            'sel_hr_info':strUserl_ex[0],
            'sel_category_info':strUser,
            'start_page':start,
            'end_page':end,
            'currentPage':currentPage,
            'numpage':numpage,
            'lang':lang,
            'type':strUserl_ex[1],
            'type_val':type_val,
            "method":"search_info"
          },
        success: function(res) {
          $('.info_search').html(res);
          $('.info_center').hide();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR, textStatus, errorThrown);

        }
      });
    }
  }

  function search_info_type(){
    var type = $('#sel_cat_info').val();
    if(type == "2"){
      $('.col-category-1').hide();
      $('.col-category-2').show();
      $('.div_category_3').css('display','inline-block');
      $('#sel_Incorrect_info').val('0').trigger('change');
      // $('#sel_cat_info option[value="2"]').attr("selected",true);
      // $('#sel_cat_info option[value="1"]').attr("selected",false);
      $('.selectpicker').selectpicker('refresh');
    }else {
      $('.col-category-1').show();
      $('.col-category-2').hide();
      $('.div_category_3').css('display','none');
      $('#sel_category_info_ex').val('0').trigger('change');
      // $('#sel_cat_info option[value="1"]').attr("selected",true);
      // $('#sel_cat_info option[value="2"]').attr("selected",false);
      $('.selectpicker').selectpicker('refresh');
    }
  }

  var currentPage=1;
  var numpage = 0;
  function btnnextpage(idbtn)
  {
    var start = $('.start_numpage').val();
    var end = $('.end_numpage').val();
  	currentPage= (idbtn=='2') ? currentPage + 1 : currentPage - 1;
    numpage= (idbtn=='2') ?  + 5 :  - 5;
    var start_page = parseInt(start)+(numpage);
    var end_page = parseInt(end)+(numpage);
  	search_info(start_page,end_page,null,2);

  }

  $( document ).ready(function() {
    chk_div_category();
  });
</script>
<style>
.icon-ico-ditp-43{
  display: inline-block;
  position: relative;
  top: -2px;
}
.sel_category_info > .btn .txt{
  margin-left: 0px !important;
  top: 1px;
  padding-left: 5px !important;
}
.bootstrap-select.btn-group .dropdown-menu li a.opt{
  padding-left: 5px;
}
.bootstrap-select.btn-group .dropdown-toggle .filter-option .icon-ico-ditp-43{
  display: none;
}
.dropdown-menu>li>a{
  padding: 1px 20px !important;
}
</style>
