<?php
// session_start();
include("../../config/config.php");

$year = date("Y");
$search_cat = $_POST['search_cat'];
if($search_cat==0){
  $st = ($year-1)."-10-01";
  $sp = $year."-09-30";
  // $where_year = " AND DATE(case_create_datetime) >= '$st'  AND DATE(case_create_datetime) <= '$sp' ";
  $where_year = " AND DATE(case_create_datetime) like '%".$year."%' ";

}else{
  $display_cat = $_POST['display_cat'];
  $year_type_cat = $_POST['year_type_cat'];
  $issue_year =  $_POST['issue_year'];
  $select_quarter_chk = $_POST['select_quarter_chk_cat'];
  $month = $_POST['month'];
  $startDate = $_POST['startDate_cat'];
  $stopDate = $_POST['stopDate_cat'];


  if($year_type_cat=='2'){
    $st = ($issue_year-1)."-10-01";
    $issue_year = $issue_year;
    $sp = $issue_year."-09-30";
    $where_year = " AND DATE(case_create_datetime) >= '$st'  AND DATE(case_create_datetime) <= '$sp' ";
  }else{
    if ($month!='') {
      if($month=='1'){$mon = '-01-';}
      if($month=='2'){$mon = '-02-';}
      if($month=='3'){$mon = '-03-';}
      if($month=='4'){$mon = '-04-';}
      if($month=='5'){$mon = '-05-';}
      if($month=='6'){$mon = '-06-';}
      if($month=='7'){$mon = '-07-';}
      if($month=='8'){$mon = '-08-';}
      if($month=='9'){$mon = '-09-';}
      if($month=='10'){$mon = '-10-';}
      if($month=='11'){$mon = '-11-';}
      if($month=='12'){ $mon = '-12-';}
      $where_year = "AND DATE(case_create_datetime) like '%".$issue_year."".$mon."%'  ";

    }else  if($select_quarter_chk!=''){
      if($select_quarter_chk==1){
        $st = $issue_year."-01-01";
        $sp = $issue_year."-04-01";
        $where_year = " AND DATE(case_create_datetime) >= '$st'  AND DATE(case_create_datetime) < '$sp' ";
      }else if($select_quarter_chk==2){
        $st = $issue_year."-04-01";
        $sp = $issue_year."-07-01";
        $where_year = " AND DATE(case_create_datetime) >= '$st'  AND DATE(case_create_datetime) < '$sp' ";
      }else if($select_quarter_chk==3){
        $st = $issue_year."-07-01";
        $sp = $issue_year."-10-01";
        $where_year = " AND DATE(case_create_datetime) >= '$st'  AND DATE(case_create_datetime) < '$sp' ";
      }else if($select_quarter_chk==4){
        $st = $issue_year."-10-01";
        $sp = $issue_year."-12-31";
        $where_year = " AND DATE(case_create_datetime) >= '$st'  AND DATE(case_create_datetime) < '$sp' ";
      }
    }else if($issue_year!=''){
      $where_year = "AND DATE(case_create_datetime) like '%".$issue_year."%'  ";
    }else if ($startDate!='' && $stopDate!=''){

      if($display_cat==1){
        $startDateY = DateTime::createFromFormat('d/m/Y',($startDate))->format('Y');
        $stopDateY = DateTime::createFromFormat('d/m/Y',($stopDate))->format('Y');
        $startDateY = $startDateY-543;
        $stopDateY = $stopDateY-543;
        $startDate = DateTime::createFromFormat('d/m/Y',($startDate))->format('m/d');
        $stopDate = DateTime::createFromFormat('d/m/Y',($stopDate))->format('m/d');
        $startDateY =  $startDateY."/".$startDate;
        $stopDateY=  $stopDateY."/".$stopDate;
      }else{
        $startDateY = DateTime::createFromFormat('d/m/Y',($startDate))->format('Y/m/d');
        $stopDateY = DateTime::createFromFormat('d/m/Y',($stopDate))->format('Y/m/d');
      }
      $where_year = " AND DATE(case_create_datetime) >= '$startDateY'  AND DATE(case_create_datetime) <= '$stopDateY' ";
    }
  }
}
// echo $where_year;


$sql_office = "";
if($_SESSION["admin"]["office"]!=0){
  $sql_office = " AND office_id = '".$_SESSION["admin"]["office"]."' ";
}

?>
<div class="row" style="margin: 0;">
  <div class="col-md-12">
    <div class="row">
      <div class="case_total">
        <span></span>
      </div>
      <div class="col-md-6">
        <div id="container1" style=""></div>
      </div>
      <div class="col-md-6">
        <div id="container2" style=""></div>
      </div>
    </div>
  </div>




<?php
$date = array('#f1a501', '#f1a501', '#f1a501', '#f1a501', '#f1a501', '#4f9451' ,'#f090b6','#0A16EF','#2E8B57','#FFE4E1');
$array_cat =  array();
$array_loop = array();
$array_loop_t1 = array();
$array_loop_t2 = array();
$color = 0;
$sql_empSection = "";
if($_SESSION["admin"]["empSection"]!=0){
  $sql_empSection = "  AND  compType_section = '".$_SESSION["admin"]["empSection"]."' ";
}
$sql_lv1 = " SELECT * FROM `Complaint_Type`
WHERE `compType_status` = '0'
$sql_empSection
";
$query_lv1 = $conn->query($sql_lv1);
// if($query_lv1->num_rows>0){

$sql_countt1 = "SELECT count(case_id) as case_id FROM `Case` WHERE complnt_country_id = 162 AND compType_id IN (1, 6, 4) $where_year  $sql_office ";
$query_countt1 = $conn->query($sql_countt1);
$re_total1 = $query_countt1->fetch_assoc();

$sql_countt2 = "SELECT count(case_id) as case_id FROM `Case` WHERE complnt_country_id != 162 AND compType_id IN (1, 6, 4) $where_year  $sql_office ";
$query_countt2 = $conn->query($sql_countt2);
$re_total2 = $query_countt2->fetch_assoc();

// echo $sql_countt2;

$re_total = $re_total1['case_id']+$re_total2['case_id'];

$sql_countt3 = "SELECT count(case_id) as case_id FROM `Case` WHERE compType_id = 1 $where_year  $sql_office ";
$query_countt3 = $conn->query($sql_countt3);
$case_total1 = $query_countt3->fetch_assoc();

$sql_countt4 = "SELECT count(case_id) as case_id FROM `Case` WHERE compType_id = 6 $where_year  $sql_office ";
$query_countt4 = $conn->query($sql_countt4);
$case_total2 = $query_countt4->fetch_assoc();

$sql_countt5 = "SELECT count(case_id) as case_id FROM `Case` WHERE compType_id = 4 $where_year  $sql_office ";
$query_countt5 = $conn->query($sql_countt5);
$case_total3 = $query_countt5->fetch_assoc();


  ?>

    <div class="col-md-6">
      <div class="gp_compType_name">
        <div class="total_cat case_title col-md-8 col-sm-8 col-xs-8"></div>
        <div class="total_cat_center case_title col-md-2 col-sm-2 col-xs-2">
          <span>Cases</span>
        </div>
        <div class="total_cat_center case_title col-md-2 col-sm-2 col-xs-2">
          <span>%</span>
        </div>

        <div class="display_block case_title col-md-8 col-sm-8 col-xs-8">
          <span >ผู้ประกอบการในไทยร้องเรียน</span>
        </div>
        <div class="total_cat case_title col-md-2 col-sm-2 col-xs-2">
          <div class="row">
            <div class="case_tooltip col-md-9 col-sm-9 col-xs-9">
              <span><?php 
                echo $re_total2['case_id'];
              ?></span>
            </div>
          </div>
          
        </div>
        <div class="total_cat case_title col-md-2 col-sm-2 col-xs-2">
          <div class="row">
            <div class="case_tooltip col-md-9 col-sm-9 col-xs-9">
              <span>100</span>
            </div>
          </div>
        </div>
      <?PHP
      // while ( $re_edit = $query_lv1->fetch_assoc()) {
            // echo
            $sql_edit = " SELECT * FROM `Complaint_Type`
                          WHERE `compType_status` = 0
                          AND  compType_id IN(1,6,4) ORDER BY compType_order_sort ASC";
            $query_edit = $conn->query($sql_edit);
            $s = 1;
            $color = 0;
              if($query_edit->num_rows>0){
                while ( $re_edit = $query_edit->fetch_assoc()) {
                  ?>
                  <div class="display_block case_title2 ft_bold col-md-8 col-sm-8 col-xs-8">
                    <div class="box_cat_color" style="background:<?=$date[$color];?>"></div>
                    &nbsp;<?=$re_edit['compType_name']; ?>
                  </div>
                  <div class="total_cat ft_bold col-md-2 col-sm-2 col-xs-2">
                    <div class="row">
                      <div class="case_tooltip col-md-9 col-sm-9 col-xs-9">
                        <?php
                          $sql_count = "SELECT count(c.compType_id) as compType_id
                          FROM `Case` as c
                          left join Complaint_Type as ct
                          on c.compType_id = ct.compType_id
                          WHERE c.compType_id = '".$re_edit['compType_id']."'
                          AND c.complnt_country_id != 162
                          $where_year  $sql_office ";

                          $query_count = $conn->query($sql_count);
                          while ( $re_count =   $query_count->fetch_assoc()) {
                            echo  $co_case1 = $re_count['compType_id'];
                            $pp_per = total_per($co_case1, $re_total2['case_id']);
                            $case_per = total_per($co_case1, ${"case_total$s"}['case_id']);
                            
                            $name =  $re_edit['compType_name'];
                            $array_cat["case"] = $co_case1;
                            $array_cat["name"] = $name;
                            $array_cat["color"] = $date[$color];
                            $array_cat["pp_per"] = round( $pp_per);
                            $array_cat["case_per"] = round($case_per);
                            array_push($array_loop,$array_cat);
                            $total_case1 = $total_case1 +  $co_case1;
                          }
                        ?>
                      </div>
                    </div>
                    </div>
                    <div class="total_cat col-md-2 col-sm-2 col-xs-2">
                      <div class="row">
                        <div class="case_tooltip col-md-9 col-sm-9 col-xs-9">
                          <span class="ft_bold"><?php 
                            $pp_per = total_per($co_case1, $re_total2['case_id']);
                            echo round($pp_per);
                            $case_per = total_per($co_case1, ${"case_total$s"}['case_id']);
                            //echo "%";
                          ?></span>
                        </div>
                      </div>
                      
                    </div>
                    <?php
                    echo "<br>";
                    if($s == 1) {
                      $sql_edit = " SELECT * FROM `Complaint_Type_Sub2` WHERE  compTypeSub2_id IN(1, 2, 3, 7, 8, 9, 11, 12) GROUP BY `compTypeSub2_name`";
                      $query_edit1 = $conn->query($sql_edit);
                      if($query_edit1->num_rows>0){
                        $color1 = $color + 1;
                        while ( $re_edit1 = $query_edit1->fetch_assoc()) {
                          ?>
                          <div class="display_block  col-md-8 col-sm-8 col-xs-8">
                            <div class="row">
                              <div class="col-md-2"></div>
                              <div class="col-md-10">
                                <div class="box_cat_color2" style="background:<?=$date[$color];?>"></div>
                                &nbsp;<?=$re_edit1['compTypeSub2_name'];?> <?php if($re_edit1['compTypeSub2_id'] == 2) {echo("(IM)");};?> <?php if($re_edit1['compTypeSub2_id'] == 1) {echo("(EX)");};?>
                              </div>
                            </div>
                          </div>
                          <div class="total_cat col-md-2 col-sm-2 col-xs-2">
                            <div class="row">
                              <div class="case_tooltip col-md-9 col-sm-9 col-xs-9">
                                <?php
                                  if($re_edit1['compTypeSub2_id'] == 1) {
                                    $compTypeSub2_id = '(1, 7)';
                                  } else if($re_edit1['compTypeSub2_id'] == 2) {
                                    $compTypeSub2_id = '(2, 8)';
                                  } else if($re_edit1['compTypeSub2_id'] == 3) {
                                    $compTypeSub2_id = '(3, 9)';
                                  } else if($re_edit1['compTypeSub2_id'] == 11) {
                                    $compTypeSub2_id = '(11, 12)';
                                  }
                                  $sql_count = "SELECT count(c.compType_id) as compType_id
                                  FROM `Case` as c
                                  left join Complaint_Type as ct
                                  on c.compType_id = ct.compType_id
                                  WHERE c.compTypeSub2_id IN $compTypeSub2_id
                                  AND c.complnt_country_id != 162 AND c.compType_id = 1
                                  $where_year  $sql_office ";
                
                                  $query_count = $conn->query($sql_count);
                                  while ( $re_count =   $query_count->fetch_assoc()) {
                                    echo  $co_case1 = $re_count['compType_id'];
                                    $pp_per = total_per($co_case1, $re_total2['case_id']);
                                    $case_per = total_per($co_case1, ${"case_total$s"}['case_id']);
                                    //echo "%";
                                    $name =  $re_edit1['compType_name'];
                                    $array_cat["case"] = $co_case1;
                                    $array_cat["name"] = $name;
                                    $array_cat["color"] = $date[$color];
                                    $array_cat["pp_per"] = round($pp_per);
                                    $array_cat["case_per"] = round($case_per);
                                    array_push($array_loop,$array_cat);
                                    // $total_case1 = $total_case1 +  $co_case1;
                                  }
                                ?>
                              </div>
                            </div>
                          </div>
                          <div class="total_cat col-md-2 col-sm-2 col-xs-2">
                            <div class="row">
                              <div class="case_tooltip col-md-9 col-sm-9 col-xs-9">
                                <span><?php 
                                  $pp_per = total_per($co_case1, $re_total2['case_id']);
                                  echo round($pp_per);
                                  $case_per = total_per($co_case1, ${"case_total$s"}['case_id']);
                                ?></span>
                              </div>
                            </div>
                            
                          </div>
                          <?php
                          echo "<br>";
                          // echo $color;
                          $color++;
                        }
                      }
                    }
                    // echo $color;
                    $color++;
                    $s++;
                }
              }

              

            // }
          // }
        // }
        $total_case =  $total_case1+$total_case;
        if($total_case==''){
          $total_case = 0;
        }
        // echo "<pre>";
        // print_r($array_loop);
        // echo "</pre>";
        ?>
      </div>
    </div>

    <div class="col-md-6">
      <div class="gp_compType_name">
      <div class="total_cat case_title col-md-8 col-sm-8 col-xs-8"></div>
        <div class="total_cat_center case_title col-md-2 col-sm-2 col-xs-2">
          <span>Cases</span>
        </div>
        <div class="total_cat_center case_title col-md-2 col-sm-2 col-xs-2">
          <span>%</span>
        </div>

        <div class="display_block case_title col-md-8 col-sm-8 col-xs-8">
          <span >ผู้ประกอบการในต่างประเทศร้องเรียน</span>
        </div>
        <div class="total_cat case_title col-md-2 col-sm-2 col-xs-2">
          <div class="row">
            <div class="case_tooltip col-md-9 col-sm-9 col-xs-9">
              <span><?php 
                echo $re_total1['case_id'];
              ?></span>
            </div>
          </div>
          
        </div>
        <div class="total_cat case_title col-md-2 col-sm-2 col-xs-2">
          <div class="row">
            <div class="case_tooltip col-md-9 col-sm-9 col-xs-9">
              <span>100</span>
            </div>
          </div>
          
        </div>
        
      <?PHP
      // while ( $re_edit = $query_lv1->fetch_assoc()) {
            // echo
            $sql_edit = " SELECT * FROM `Complaint_Type`
                          WHERE `compType_status` = 0
                          AND  compType_id IN(1,6,4) ORDER BY compType_order_sort ASC";
            $query_edit = $conn->query($sql_edit);
            $s = 1;
            $color = 0;
              if($query_edit->num_rows>0){
                while ( $re_edit = $query_edit->fetch_assoc()) {
                  ?>
                  <div class="display_block case_title2 ft_bold col-md-8 col-sm-8 col-xs-8">
                    <div class="box_cat_color" style="background:<?=$date[$color];?>"></div>
                    &nbsp;<?=$re_edit['compType_name']; ?>
                  </div>
                  <div class="total_cat ft_bold col-md-2 col-sm-2 col-xs-2">
                    <div class="row">
                      <div class="case_tooltip col-md-9 col-sm-9 col-xs-9">
                        <?php
                          $sql_count = "SELECT count(c.compType_id) as compType_id
                          FROM `Case` as c
                          left join Complaint_Type as ct
                          on c.compType_id = ct.compType_id
                          WHERE c.compType_id = '".$re_edit['compType_id']."'
                          AND c.complnt_country_id = 162
                          $where_year  $sql_office ";
                          $query_count = $conn->query($sql_count);
                          while ( $re_count =   $query_count->fetch_assoc()) {
                            echo  $co_case1 = $re_count['compType_id'];
                            $pp_per = total_per($co_case1, $re_total1['case_id']);
                            $case_per = total_per($co_case1, ${"case_total$s"}['case_id']);
                            //echo "%";
                            $name =  $re_edit['compType_name'];
                            $array_cat["case"] = $co_case1;
                            $array_cat["name"] = $name;
                            $array_cat["color"] = $date[$color];
                            $array_cat["pp_per"] = round($pp_per);
                            $array_cat["case_per"] = round($case_per);
                            array_push($array_loop,$array_cat);
                            $total_case1 = $total_case1 +  $co_case1;
                          }
                          // echo ;
                        ?>
                      </div>
                    </div>
                  </div>
                  <div class="total_cat ft_bold col-md-2 col-sm-2 col-xs-2">
                    <div class="row">
                      <div class="case_tooltip col-md-9 col-sm-9 col-xs-9">
                        <span class="ft_bold"><?php 
                          $pp_per = total_per($co_case1, $re_total1['case_id']);
                          echo round($pp_per);
                          $case_per = total_per($co_case1, ${"case_total$s"}['case_id']);
                          //echo "%";
                        ?></span>
                      </div>
                    </div>
                  </div>
                    <?php
                    echo "<br>";
                    if($s == 1) {
                      $sql_edit = " SELECT * FROM `Complaint_Type_Sub2` WHERE  compTypeSub2_id IN(1, 2, 3, 7, 8, 9, 11, 12) GROUP BY `compTypeSub2_name`";
                      $query_edit1 = $conn->query($sql_edit);
                      if($query_edit1->num_rows>0){
                        while ( $re_edit1 = $query_edit1->fetch_assoc()) {
                          ?>
                          <div class="display_block  col-md-8 col-sm-8 col-xs-8">
                            <div class="row">
                              <div class="col-md-2"></div>
                              <div class="col-md-10">
                                <div class="box_cat_color2" style="background:<?=$date[$color];?>"></div>
                                &nbsp;<?=$re_edit1['compTypeSub2_name']; ?> <?php if($re_edit1['compTypeSub2_id'] == 1) {echo("(IM)");};?> <?php if($re_edit1['compTypeSub2_id'] == 2) {echo("(EX)");};?>
                              </div>
                            </div>
                          </div>
                          <div class="total_cat col-md-2 col-sm-2 col-xs-2">
                            <div class="row">
                              <div class="case_tooltip col-md-9 col-sm-9 col-xs-9">
                                <?php
                                  if($re_edit1['compTypeSub2_id'] == 1) {
                                    $compTypeSub2_id = '(1, 7)';
                                  } else if($re_edit1['compTypeSub2_id'] == 2) {
                                    $compTypeSub2_id = '(2, 8)';
                                  } else if($re_edit1['compTypeSub2_id'] == 3) {
                                    $compTypeSub2_id = '(3, 9)';
                                  } else if($re_edit1['compTypeSub2_id'] == 11) {
                                    $compTypeSub2_id = '(11, 12)';
                                  }
                                  $sql_count = "SELECT count(c.compType_id) as compType_id
                                  FROM `Case` as c
                                  left join Complaint_Type as ct
                                  on c.compType_id = ct.compType_id
                                  WHERE c.compTypeSub2_id IN $compTypeSub2_id
                                  AND c.complnt_country_id = 162 AND c.compType_id = 1
                                  $where_year  $sql_office ";
                
                                  $query_count = $conn->query($sql_count);
                                  while ( $re_count =   $query_count->fetch_assoc()) {
                                    echo  $co_case1 = $re_count['compType_id'];
                                    $pp_per = total_per($co_case1, $re_total1['case_id']);
                                    $case_per = total_per($co_case1, ${"case_total$s"}['case_id']);
                                    //echo "%";
                                    $name =  $re_edit1['compType_name'];
                                    $array_cat["case"] = $co_case1;
                                    $array_cat["name"] = $name;
                                    $array_cat["color"] = $date[$color];
                                    $array_cat["pp_per"] = round($pp_per);
                                    $array_cat["case_per"] = round($case_per);
                                    array_push($array_loop,$array_cat);
                                    // $total_case1 = $total_case1 +  $co_case1;
                                  }
                                ?>
                              </div>
                            </div>
                          </div>
                          <div class="total_cat col-md-2 col-sm-2 col-xs-2">
                            <div class="row">
                              <div class="case_tooltip col-md-9 col-sm-9 col-xs-9">
                                <span><?php 
                                  $pp_per = total_per($co_case1, $re_total1['case_id']);
                                  echo round( $pp_per);
                                  $case_per = total_per($co_case1, ${"case_total$s"}['case_id']);
                                ?></span>
                              </div>
                            </div>
                            
                          </div>
                          <?php
                          echo "<br>";
                          $color++;
                        }
                      }
                    }
                    $color++;
                    $s++;
                }
              }

            // }
          // }
        // }
        // $total_case =  $total_case1+$total_case;
        // if($total_case==''){
        //   $total_case = 0;
        // }
        // echo "<pre>";
        // print_r($array_loop);
        // echo "</pre>";

        // echo json_encode($array_loop);
        ?>
      </div>
    </div>

    
  </div>
  

  
  
  

  <?php
  function total_per($t1, $t2) {
    $pp_per = ($t1/$t2)*100;
    return $pp_per;
  }
  ?>
    

    
<?php
if($search_cat==0){  ?>
  <script src="../dashboard/js/highcharts.js"></script>
<?php  } ?>
<script src="../dashboard/js/exporting.js"></script>
<script type="text/javascript">

  $(".case_total").find('span').text('Total <? echo($re_total2['case_id'] + $re_total1['case_id']);?> case');
      
  Highcharts.chart('container1', {
    chart: {
        type: 'pie'
    },
    title: {
      text: 'ผู้ร้องเรียน',
      style: {
        color: '#004d40',
        fontWeight: 'bold',
        fontSize: '22px',
        fontFamily: 'Kanit'
      }
    },
    subtitle: {
        text: null
    },
    // tooltip: {
    //   pointFormat: '{point.cusname1} {point.custom1}%<br>{point.cusname2} {point.custom2}%<br>{point.cusname3} {point.custom3}%'
    // },
    plotOptions: {
      pie: {
        size: '100%',
        colors: [
          '#7d59b3',
          '#5585ad'
        ],
        cursor: 'pointer',
        dataLabels: {
          style: { 
            fontFamily: 'Kanit',
            fontWeight: 'normal',
            fontSize: '16px',
            color: '#4d4d4d' 
          }
        },
        data: [ 
          <?php if($re_total1['case_id'] != 0) {  ?>
          {
              name: 'ต่างประเทศ <br> <? echo($re_total1['case_id']);?> ราย',
              y: <? echo($re_total1['case_id']);?>,
              cusname1: '<? echo($array_loop[7]["name"]);?>',
              cusname2: '<? echo($array_loop[12]["name"]);?>',
              cusname3: '<? echo($array_loop[13]["name"]);?>',
              custom1: <? echo (int)$array_loop[7]["pp_per"];?>,
              custom2: <? echo (int)$array_loop[12]["pp_per"];?>,
              custom3: <? echo (int)$array_loop[13]["pp_per"];?>,
            },  <?php } ?>
          
          <?php if($re_total2['case_id'] != 0) {  ?>
          {
            name: 'ไทย <? echo($re_total2['case_id']);?> ราย',
            y: <? echo($re_total2['case_id']);?>,
            cusname1: '<? echo($array_loop[0]["name"]);?>',
            cusname2: '<? echo($array_loop[5]["name"]);?>',
            cusname3: '<? echo($array_loop[6]["name"]);?>',
            custom1: <? echo (int)$array_loop[0]["pp_per"];?>,
            custom2: <? echo (int)$array_loop[5]["pp_per"];?>,
            custom3: <? echo (int)$array_loop[6]["pp_per"];?>,
          }  <?php } ?>
      ]
        
      }
    },
    series: [{
      type: 'pie',
        // name: 'Asset Allocation',
      dataLabels: {
        verticalAlign: 'top',
        enabled: true,
        color: '#ffffff',
        connectorWidth: 1,
        distance: -75,
        connectorColor: '#ffffff',
        stoke: '#ffffff',
        formatter: function() {
            return Math.round(this.percentage) + '%';
        },
        style: { 
          fontSize: '38px',
        },
      }
    }, 
    {
      type: 'pie',
      // name: 'Asset Allocation',
      dataLabels: {
          enabled: true,
          color: '#000000',
          connectorWidth: 1,
          distance: 30,
          connectorColor: '#000000',
          formatter: function() {
              return  this.point.name ;
          }
      },
      marker: {
          enabled: false
      },
      states: {
          hover: {
              lineWidth: 0
          }
      },
    }],
    exporting: {
      enabled: false
    },
    credits: {
      enabled: false
    },
    tooltip: {
      useHTML: true,
      headerFormat: '<table><tr><th colspan="2">{point.cusname1}</th></tr>',
      pointFormat: '<tr style="font-family: Kanit;"><td><div class="box_case_color" style="background:#f1a501"> </div> {point.cusname1} </td>' +
          '<td style="text-align: right"> {point.custom1}%</td></tr>'+
          '<tr style="font-family: Kanit;"><td><div class="box_case_color" style="background:#4f9451"> </div> {point.cusname2} </td>' +
          '<td style="text-align: right">&nbsp  {point.custom2}%</td></tr>'+
          '<tr style="font-family: Kanit;"><td><div class="box_case_color" style="background:#f090b6"> </div> {point.cusname3} </td>' +
          '<td style="text-align: right">&nbsp  {point.custom3}%</td></tr>',
      footerFormat: '</table>',
      valueDecimals: 2,
      borderRadius: 15
    },
  });

  Highcharts.chart('container2', {
    chart: {
      type: 'pie',
    },
    title: {
      text: 'เรื่องร้องเรียน',
      style: {
        color: '#004d40',
        fontWeight: 'bold',
        fontSize: '22px',
        fontFamily: 'Kanit'
      }
    },
    subtitle: {
        text: null
    },
    // tooltip: {
    //   pointFormat: '{point.cusname1} {point.custom1}%<br>{point.cusname2} {point.custom2}%',
      
    // },
    plotOptions: {
      pie: {
        size: '100%',
        colors: [
          '#4f9451',
          '#f090b6',
          '#f1a501',
        ],
        cursor: 'pointer',
        dataLabels: {
            style: { 
              fontFamily: 'Kanit',
              fontWeight: 'normal',
              fontSize: '16px',
              color: '#4d4d4d' 
            },
        },
        data: [ <?php if($case_total2['case_id'] != 0) {  ?>
          {
            name: 'กรณีตรวจสอบความ  <br> น่าเชื่อถือของบริษัท <br> <? echo($case_total2['case_id']);?> ราย',
            y: <? echo($case_total2['case_id']);?>,
            cusname1: 'ไทย',
            cusname2: 'ต่างประเทศ',
            custom1: <? echo (int)$array_loop[5]["case_per"];?>,
            custom2: <? echo (int)$array_loop[12]["case_per"];?>,
            
          }, <?php } ?>
          <?php if($case_total3['case_id'] != 0) {  ?>
          {
            name: 'อื่น ๆ <? echo($case_total3['case_id']);?> ราย',
            y: <? echo($case_total3['case_id']);?>,
            cusname1: 'ไทย',
            cusname2: 'ต่างประเทศ',
            custom1: <? echo (int)$array_loop[6]["case_per"];?>,
            custom2: <? echo (int)$array_loop[13]["case_per"];?>,
            
          }, <?php } ?>
          <?php if($case_total1['case_id'] != 0) {  ?>
          {
            name: 'ข้อพิพาททางการค้า <br> ระหว่างประเทศ  <br> <? echo($case_total1['case_id']);?> ราย',
            y: <? echo($case_total1['case_id']);?>,
            cusname1: 'ไทย',
            cusname2: 'ต่างประเทศ',
            custom1: <? echo (int)$array_loop[0]["case_per"];?>,
            custom2: <? echo (int)$array_loop[7]["case_per"];?>,
            
          } <?php } ?>
        ]
      }
    },
    series: [{
        type: 'pie',
          // name: 'Asset Allocation',
          dataLabels: {
            verticalAlign: 'top',
            enabled: true,
            color: '#ffffff',
            connectorWidth: 1,
            distance: -60,
            connectorColor: '#ffffff',
            formatter: function() {
                return Math.round(this.percentage) + '%';
            },
            style: { 
              fontSize: '32px',
            },
          }
        }, {
          type: 'pie',
          // name: 'Asset Allocation',
          dataLabels: {
              enabled: true,
              color: '#000000',
              connectorWidth: 1,
              distance: 30,
              connectorColor: '#000000',
              formatter: function() {
                  return  this.point.name ;
              }
          },
      marker: {
          enabled: false
      },
      states: {
          hover: {
              lineWidth: 0
          }
      },
      // enableMouseTracking: false
    }],
    exporting: {
      enabled: false
    },
    credits: {
      enabled: false
    },
    tooltip: {
      useHTML: true,
      headerFormat: '<table><tr><th colspan="2">{point.cusname1}</th></tr>',
      pointFormat: '<tr style="font-family: Kanit;"><td><div class="box_case_color" style="background:#5585ad"> </div> {point.cusname1} </td>' +
          '<td style="text-align: right"> {point.custom1}%</td></tr>'+
          '<tr style="font-family: Kanit;"><td><div class="box_case_color" style="background:#7d59b3"> </div> {point.cusname2} </td>' +
          '<td style="text-align: right">&nbsp  {point.custom2}%</td></tr>',
      footerFormat: '</table>',
      valueDecimals: 2,
      borderRadius: 15
    },
  });

  $("#container2").find('.highcharts-data-labels').attr("transform","translate(10, 40) scale(1, 1)");
  $("#container1").find('.highcharts-data-labels').attr("transform","translate(10, 40) scale(1, 1)");
  $("#container1").find('.highcharts-text-outline').attr("stroke","transparent");
  $("#container2").find('.highcharts-text-outline').attr("stroke","transparent");

    </script>
