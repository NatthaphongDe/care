<?php
// session_start();
 include("../config/config.php");

$year = date("Y");
$search_cat = $_POST['search_cat'];
if($search_cat==0){
  $where_year = " AND case_receivedoc_date like '%".$year."%' ";

}else{
   $display_cat = $_POST['display_cat'];
   $year_type_cat = $_POST['year_type_cat'];
   $issue_year =  $_POST['issue_year'];
   $select_quarter_chk = $_POST['select_quarter_chk_cat'];
   $month = $_POST['month'];
   $startDate = $_POST['startDate_cat'];
   $stopDate = $_POST['stopDate_cat'];


  if($year_type_cat=='2'){
    $st = $issue_year."-10-01";
    $issue_year = $issue_year +1;
    $sp = $issue_year."-09-30";
    $where_year = " AND case_receivedoc_date >= '$st'  AND case_receivedoc_date <= '$sp' ";
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
      $where_year = "AND case_receivedoc_date like '%".$mon."%'  ";

    }else  if($select_quarter_chk!=''){
      if($select_quarter_chk==1){
        $st = $issue_year."-01-01";
        $sp = $issue_year."-04-01";
        $where_year = " AND case_receivedoc_date >= '$st'  AND case_receivedoc_date < '$sp' ";
      }else if($select_quarter_chk==2){
        $st = $issue_year."-04-01";
        $sp = $issue_year."-07-01";
        $where_year = " AND case_receivedoc_date >= '$st'  AND case_receivedoc_date < '$sp' ";
      }else if($select_quarter_chk==3){
        $st = $issue_year."-07-01";
        $sp = $issue_year."-10-01";
        $where_year = " AND case_receivedoc_date >= '$st'  AND case_receivedoc_date < '$sp' ";
      }else if($select_quarter_chk==4){
        $st = $issue_year."-10-01";
        $sp = $issue_year."-12-31";
        $where_year = " AND case_receivedoc_date >= '$st'  AND case_receivedoc_date < '$sp' ";
      }
    }else if($issue_year!=''){
      $where_year = "AND case_receivedoc_date like '%".$issue_year."%'  ";
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
      $where_year = " AND case_receivedoc_date >= '$startDateY'  AND case_receivedoc_date <= '$stopDateY' ";
      }
  }
}
// echo $where_year;
?>

<div id="container" style="min-width: 310px; height: 300px; max-width: 600px; margin: 0 auto"></div>

  <?php
  $sql_edit = " SELECT compType_name,compType_id FROM `Complaint_Type`
                WHERE `compType_status` = 0
                AND  compType_section = '".$_SESSION["admin"]["empSection"]."'
                ";
  $query_edit = $conn->query($sql_edit);
  // $color = 0;
  if($query_edit->num_rows>0){
   ?>

   <div class="gp_compType_name">
   <?PHP
   $date = array('#7E57C2', '#F06292', '#4DB6AC', '#8D6E63','#11EA11' ,'#FF0000' ,'#E5A505','#0A16EF','#2E8B57','#FFE4E1');
   $array_cat =  array();
   $array_loop = array();
   $color = 0;

  while ( $re_edit = $query_edit->fetch_assoc()) {
    // $date = array('#7E57C2', '#F06292', '#4DB6AC', '#8D6E63','#11EA11' ,'#FF0000' ,'#E5A505','#0A16EF','#2E8B57','#FFE4E1');

    ?>
    <div class="display_block">
      <div class="box_cat_color" style="background:<?=$date[$color];?>"></div>
      <?=$re_edit['compType_name']; ?>
    </div>
    <div class="total_cat">
      <?php

      $sql_count = "SELECT Count(c.compType_id) AS compType_id FROM  `Case` as c
                    left join  Complaint_Type on Complaint_Type.compType_id = c.compType_id
                    WHERE c.compType_id = '".$re_edit['compType_id']."'
                    AND  Complaint_Type.compType_section = '".$_SESSION["admin"]["empSection"]."'
                    $where_year   ";
      $query_count = $conn->query($sql_count);
      while ( $re_count =   $query_count->fetch_assoc()) {

        echo  $co_case = $re_count['compType_id'];
        $name =  $re_edit['compType_name'];
        $array_cat["case"] = $co_case;
        $array_cat["name"] = $name;
        $array_cat["color"] = $date[$color];
        array_push($array_loop,$array_cat);
        $total_case = $total_case +  $co_case;
        }
      ?></div>
      <?php
          echo "<br>";
            $color++;
    }
  }
  if($total_case==''){
    $total_case = 0;
  }
  // echo "<pre>";
  // print_r($array_loop);
  // echo "</pre>";
  ?>
</div>

  <?php
  $sql_edit = "SELECT casePrt_id,casePrt_name,casePrt_img_path FROM `Case_Priority` WHERE `casePrt_status` = 0 AND  casePrt_section = '".$_SESSION["admin"]["empSection"]."'";
  $query_edit = $conn->query($sql_edit);
  if($query_edit->num_rows>0){
 ?><div class="gp_compType_name">
   <div class="db_lbl_title div_pti">
     <lable class="title_case">Priority</lable>

   </div><?php
  while ( $re_edit = $query_edit->fetch_assoc()) {
    // echo
    ?>
    <div class="display_block">


      <?php
     if(!file_exists('../../'.$re_edit['casePrt_img_path']) || $re_edit['casePrt_img_path']==''  ) {
      ?><img src="setting/img/default_priority.png" alt="Smiley face" height="20" width="20" ><?php
     }else{ ?>
      <img src="../<?=$re_edit['casePrt_img_path']?>" alt="Smiley face" height="20" width="20" >
      <?php } ?>
      <?=$re_edit['casePrt_name']; ?>
      </div>
      <div class="total_cat">
        <?php
        $sql_casePrt = "SELECT Count(case_priority) AS case_priority FROM  `Case` as c
                        left join  Complaint_Type on Complaint_Type.compType_id = c.compType_id
                        WHERE c.case_priority = '".$re_edit['casePrt_id']."'
                        AND  Complaint_Type.compType_section = '".$_SESSION["admin"]["empSection"]."'
                        $where_year  ";
      $query_casePrt = $conn->query($sql_casePrt);
      while ( $re_casePrt =   $query_casePrt->fetch_assoc()) {
        echo  $case_priority = $re_casePrt['case_priority'];
      }
      ?>
    </div>
    <?php
    echo "<br>";
  }
  ?>
</div>
<?php } ?>
<?php
if($search_cat==0){  ?>
  <script src="../dashboard/js/highcharts.js"></script>
<?php  } ?>
<script src="../dashboard/js/exporting.js"></script>
<script type="text/javascript">

  Highcharts.chart('container', {
    chart: {
      plotBackgroundColor: null,
      plotBorderWidth: 0,
      plotShadow: false
    },
    series: [{
      type: 'pie',
      <?php
      if(count($array_loop)==0 || count($array_loop)==1){
        ?>borderWidth: 0,<?php
      }else{
            ?>borderWidth: 6,<?php
      }
      ?>
      borderColor: '#fff',
      name: 'Total Case',
      innerSize: '75%',
      data: [
        <?php
        for ($i=0; $i < count($array_loop); $i++) {
          if($i>0){
            echo ",";
          }
          ?> { name:'<? echo $array_loop[$i]["name"];?>',y:<? echo (int)$array_loop[$i]["case"];?>,color:'<? echo $array_loop[$i]["color"];?>'}<?php
        }
        if(count($array_loop)==0){
          ?>
          { y : 100 , color : '#D3D3D3' }<?php
        }
        ?>
      ]
    }],
    title: {
      text: '<span class="total_txt">Total Case</span><br><span class="total_txt_sun" style="  font-weight: lighter;font-family:kanit;font-size: 40px;"><?=$total_case;?></span>',
      align: 'center',
      verticalAlign: 'middle',
      y: -10
    },
    tooltip: {
      <?php
      if(count($array_loop)==0){
        ?>enabled: false ,<?php
      }
      ?>
      pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
      pie: {
        allowPointSelect: true,
        cursor: 'pointer',
        dataLabels: {
          enabled: false,
          distance: -50,
          style: {
            fontWeight: 'bold',
            color: 'white',

          }
        },
      }
    }
  });
</script>
