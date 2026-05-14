<?php include("../config/config.php"); ?>
<?php include("function.php"); ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"> -->
    <!-- <meta content="width=1920, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"> -->
    <meta name="viewport" content="width=1920">
    <title>Dashboard DITP</title>


    <link rel="stylesheet" type="text/css" href="css/assets/helpers/colors.css">
    <!-- progressbar -->
    <link rel="stylesheet" type="text/css" href="css/assets/widgets/progressbar/progressbar.css">

    <!-- BOOTSTRAP -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap/css/bootstrap.css">

    <link rel="stylesheet" type="text/css" href="css/dashboard.css?v1=120">
    <link rel="stylesheet" type="text/css" href="css/animate.css">

    <!-- spy -->
    <link rel="stylesheet" type="text/css" href="css/spy.css">



    <!-- JS Core -->
    <script type="text/javascript" src="css/assets/js-core/jquery-core.js"></script>
    <script type="text/javascript" src="css/assets/js-core/jquery-ui-core.js"></script>
    <script type="text/javascript" src="css/assets/js-core/jquery-ui-widget.js"></script>


  </head>

  <?php
  $numpage = 1;
  $numpage = $_POST[numpage];
  // echo "numpage=".$numpage;
// graph

if($numpage==2){
  $fyear = date('Y'); // วันนี้
  $fmonth= date('m'); // วันนี้
  $fday = date('d'); // วันนี้
  $fyear1_start = date("Y-m-d",strtotime("-1 YEAR", strtotime($fyear."-10-01")));
  $fyear1_end = $fyear."-09-30";
  $fyear2_start = date("Y-m-d",strtotime("-2 YEAR", strtotime($fyear."-10-01")));
  $fyear2_end = date("Y-m-d",strtotime("-1 YEAR", strtotime($fyear."-09-30")));
}

    $date = date('Y-');
    $sql = "SELECT case_receivedoc_date FROM `Case` WHERE case_status != '0' AND case_receivedoc_date LIKE '$date%' ";
    $query = $conn->query($sql);
    $total_case_year = $query->num_rows;

    $date = date('Y-m-');
    $sql = "SELECT case_receivedoc_date FROM `Case` WHERE case_status != '0' AND case_receivedoc_date LIKE '$date%' ";
    if($numpage==2){
      $sql = "SELECT case_receivedoc_date FROM `Case` WHERE case_status != '0' AND case_receivedoc_date >= '$fyear1_start' AND case_receivedoc_date<= '$fyear1_end' ";
    }
    if($numpage==3){
      $date = date('Y-');
      $sql = "SELECT case_receivedoc_date FROM `Case` WHERE case_status != '0' AND case_receivedoc_date LIKE '$date%' ";
    }
    $query = $conn->query($sql);
    $num_total_1 = $query->num_rows;
    $lastmonth = date('Y-m-',strtotime(date('Y-m-d') . "-1 month"));
    $sql = "SELECT case_receivedoc_date FROM `Case` WHERE case_status != '0' AND case_receivedoc_date LIKE '$lastmonth%' ";
    if($numpage==2){
      $sql = "SELECT case_receivedoc_date FROM `Case` WHERE case_status != '0' AND case_receivedoc_date >= '$fyear2_start' AND case_receivedoc_date<= '$fyear2_end' ";
    }
    if($numpage==3){
      $lastmonth = date('Y-m-',strtotime(date('Y-m-d') . "-1 year"));
      $sql = "SELECT case_receivedoc_date FROM `Case` WHERE case_status != '0' AND case_receivedoc_date LIKE '$lastmonth%' ";
    }
    $query = $conn->query($sql);
    $num_total_2 = $query->num_rows;
    // $num_total_2 = 15 ;

    $case_total = $num_total_1-$num_total_2;
    if($case_total<0){
      $case_total = str_replace("-"," ",$case_total);
    }
                          // เดือนที่แล้ว / เดือนนี้
    $percent_total = 100-(@($num_total_2/$num_total_1)*100);
    $pos = strpos($percent_total, ".");
    if ($pos == true) {
      $percent_total = number_format($percent_total,2);
    }

    $txt_per = "จำนวนเคส<br>ทั้งหมดที่เพิ่มขึ้น";
    $icon_per = "image/ico-5.png";
    if($percent_total<0){
      $percent_total = str_replace("-"," ",$percent_total);
      $txt_per = "จำนวนเคส<br>ทั้งหมดที่ลดลง";
      $icon_per = "image/ico-13.png";
    }
// graph

// new case
    $date = date('Y-m-d');
    $sql = "SELECT case_receivedoc_date FROM `Case` WHERE case_status = '1' AND case_receivedoc_date LIKE '$date' ";
    $query = $conn->query($sql);
    $new_today = $query->num_rows;

    $date = date('Y-m-');
    $sql = "SELECT case_receivedoc_date FROM `Case` WHERE case_status = '1' AND case_receivedoc_date LIKE '$date%' ";
    $query = $conn->query($sql);
    $new_tomonth = $query->num_rows;

    $date = date('Y-');
    $sql = "SELECT case_receivedoc_date FROM `Case` WHERE case_status = '1' AND case_receivedoc_date LIKE '$date%' ";
    $query = $conn->query($sql);
    $new_toyear = $query->num_rows;
// new case

// pending
    $datenow = date('Y-m-d');
    $date = date('Y-m-d');
    $sql = "SELECT case_id,case_compType_duration FROM `Case`
            WHERE case_status = '2' AND case_opened_datetime LIKE '$date%' ";
    $query = $conn->query($sql);
    $row = $query->num_rows;
    $pending_today = 0;
    $overdue_today = 0;
    if($row>0){
      while ($result = $query->fetch_assoc()) {
        $case_id = $result[case_id];
        $case_compType_duration = $result[case_compType_duration];
        $sql2 = "SELECT case_opened_datetime FROM `Case` WHERE case_id = '$case_id' ";
        $query2 = $conn->query($sql2);
        $row2 = $query2->num_rows;
        if($row2>0){
          while ($result2 = $query2->fetch_assoc()) {
            $case_open = $result2[case_opened_datetime];
            $case_open = substr($case_open,0,10);
            $date_start = $case_open;
            $date_stop = $datenow;
            $getdays = getDateTimeData($date_start,$date_stop);
            $getdays = $getdays['days'];
            if($getdays<0){
              $getdays=0;
            }
            if($getdays<=$case_compType_duration){
              $pending_today++;
            }else{
              $overdue_today++;
            }
          }
        }
      }
    }

    $date = date('Y-m-');
    $sql = "SELECT case_id,case_compType_duration FROM `Case`
            WHERE case_status = '2' AND case_opened_datetime LIKE '$date%' ";
    $query = $conn->query($sql);
    $row = $query->num_rows;
    $pending_tomonth = 0;
    $overdue_tomonth = 0;
    if($row>0){
      while ($result = $query->fetch_assoc()) {
        $case_id = $result[case_id];
        $case_compType_duration = $result[case_compType_duration];
        $sql2 = "SELECT case_opened_datetime FROM `Case` WHERE case_id = '$case_id' ";
        $query2 = $conn->query($sql2);
        $row2 = $query2->num_rows;
        if($row2>0){
          while ($result2 = $query2->fetch_assoc()) {
            $case_open = $result2[case_opened_datetime];
            $case_open = substr($case_open,0,10);
            $date_start = $case_open;
            $date_stop = $datenow;
            $getdays = getDateTimeData($date_start,$date_stop);
            $getdays = $getdays['days'];
            if($getdays<0){
              $getdays=0;
            }
            if($getdays<=$case_compType_duration){
              $pending_tomonth++;
            }else{
              $overdue_tomonth++;
            }
          }
        }
      }
    }

    $date = date('Y');
    $sql = "SELECT case_id,case_compType_duration FROM `Case`
            WHERE case_status = '2' AND YEAR(case_opened_datetime) = '$date' ";
    $query = $conn->query($sql);
    $row = $query->num_rows;
    $pending_toyear = 0;
    $overdue_toyear = 0;
    if($row>0){
      while ($result = $query->fetch_assoc()) {
        $case_id = $result[case_id];
        $case_compType_duration = $result[case_compType_duration];
        $sql2 = "SELECT case_opened_datetime FROM `Case` WHERE case_id = '$case_id' ";
        $query2 = $conn->query($sql2);
        $row2 = $query2->num_rows;
        if($row2>0){
          while ($result2 = $query2->fetch_assoc()) {
            $case_open = $result2[case_opened_datetime];
            $case_open = date("Y-m-d",strtotime($case_open));
            $date_start = $case_open;
            $date_stop = $datenow;
            $getdays = getDateTimeData($date_start,$date_stop);
            $getdays = $getdays['days'];
            if($getdays<0){
              $getdays=0;
            }
            if($getdays<=$case_compType_duration){
              $pending_toyear++;
            }else{
              $overdue_toyear++;
            }
          }
        }
      }
    }
// pending
// complete
    $date = date('Y-m-d');
    $sql = "SELECT case_id,case_compType_duration,case_opened_datetime,case_close_datetime FROM `Case`
            WHERE case_status = '3' AND case_opened_datetime LIKE '$date%' ";
    $query = $conn->query($sql);
    $row = $query->num_rows;
    $Complete_today = 0;
    if($row>0){
      while ($result = $query->fetch_assoc()) {
        $case_id = $result[case_id];
        $case_compType_duration = $result[case_compType_duration];
        $case_opened_datetime = $result[case_opened_datetime];
        $case_opened_datetime = date('Y-m-d',strtotime($case_opened_datetime));
        $case_close_datetime = $result[case_close_datetime];
        $case_close_datetime = date('Y-m-d',strtotime($case_close_datetime));
        $getdays = getDateTimeData($case_opened_datetime,$case_close_datetime);
        $getdays = $getdays['days'];
        if($getdays<0){
          $getdays=0;
        }
        if($getdays<=$case_compType_duration){
          $Complete_today++;
        }else{
          $overdue_today++;
        }
      }
    }

    $date = date('Y-m-');
    $sql = "SELECT case_id,case_compType_duration,case_opened_datetime,case_close_datetime FROM `Case`
            WHERE case_status = '3' AND case_opened_datetime LIKE '$date%' ";
    $query = $conn->query($sql);
    $row = $query->num_rows;
    $Complete_tomonth = 0;
    if($row>0){
      while ($result = $query->fetch_assoc()) {
        $case_id = $result[case_id];
        $case_compType_duration = $result[case_compType_duration];
        $case_opened_datetime = $result[case_opened_datetime];
        $case_opened_datetime = date('Y-m-d',strtotime($case_opened_datetime));
        $case_close_datetime = $result[case_close_datetime];
        $case_close_datetime = date('Y-m-d',strtotime($case_close_datetime));
        $getdays = getDateTimeData($case_opened_datetime,$case_close_datetime);
        $getdays = $getdays['days'];
        if($getdays<0){
          $getdays=0;
        }
        // echo "getdays2=".$getdays."<br>";
        // echo "case_compType_duration2=".$case_compType_duration."<br><br>";
        if($getdays<=$case_compType_duration){
          $Complete_tomonth++;
        }else{
          $overdue_tomonth++;
        }

      }
    }

    $date = date('Y');
    $sql = "SELECT case_id,case_compType_duration,case_opened_datetime,case_close_datetime FROM `Case`
            WHERE case_status = '3' AND YEAR(case_opened_datetime) = '$date' ";
    $query = $conn->query($sql);
    $row = $query->num_rows;
    $Complete_toyear = 0;
    if($row>0){
      while ($result = $query->fetch_assoc()) {
        $case_id = $result[case_id];
        $case_compType_duration = $result[case_compType_duration];
        $case_opened_datetime = $result[case_opened_datetime];
        $case_opened_datetime = date('Y-m-d',strtotime($case_opened_datetime));
        $case_close_datetime = $result[case_close_datetime];
        $case_close_datetime = date('Y-m-d',strtotime($case_close_datetime));
        $getdays = getDateTimeData($case_opened_datetime,$case_close_datetime);
        $getdays = $getdays['days'];
        if($getdays<0){
          $getdays=0;
        }
        // echo "getdays3=".$getdays."<br>";
        // echo "case_compType_duration3=".$case_compType_duration."<br><br>";
        if($getdays<=$case_compType_duration){
          $Complete_toyear++;
        }else{
          // echo "case=".$case_id."<hr>";
          $overdue_toyear++;
        }
      }
    }

// complete
// box_center
$date = date('Y-m-');
$array_total_1 = array();
$sql = "SELECT compType_id,compType_name FROM `Complaint_Type` WHERE compType_status = '0' ";
$query = $conn->query($sql);
$row = $query->num_rows;
if($row>0){
  while ($rusult = $query->fetch_assoc()) {
    $sql2 = "SELECT a.compType_id , b.compType_name
                FROM `Case` a
                LEFT JOIN `Complaint_Type` b ON (a.compType_id=b.compType_id)
                WHERE a.case_status != '0' AND b.compType_id = '$rusult[compType_id]' AND a.case_receivedoc_date LIKE '$date%' ";
  if($numpage==2){
    $sql2 = "SELECT a.compType_id , b.compType_name
                FROM `Case` a
                LEFT JOIN `Complaint_Type` b ON (a.compType_id=b.compType_id)
                WHERE a.case_status != '0' AND b.compType_id = '$rusult[compType_id]' AND a.case_receivedoc_date >= '$fyear1_start' AND a.case_receivedoc_date<= '$fyear1_end' ";
  }
  if($numpage==3){
    $date = date('Y-');
    $sql2 = "SELECT a.compType_id , b.compType_name
                FROM `Case` a
                LEFT JOIN `Complaint_Type` b ON (a.compType_id=b.compType_id)
                WHERE a.case_status != '0' AND b.compType_id = '$rusult[compType_id]' AND a.case_receivedoc_date LIKE '$date%' ";
  }
    $query2 = $conn->query($sql2);
    $row2 = $query2->num_rows;
    $num_case_totle=0;
    $name_case = $rusult[compType_name];
    if($row2>0){
      while ($rusult2 = $query2->fetch_assoc()) {
        if($rusult[compType_id]==$rusult2[compType_id]){
          $num_case_totle++;
        }
      }
    }
    array_push($array_total_1,array($num_case_totle,$name_case));
  }
}

// box_center
// graph right

$lastmonth = date('Y-m',strtotime(date('Y-m-d') . "-1 month"));
$array_total_2 = array();
$sql = "SELECT compType_id,compType_name FROM `Complaint_Type` WHERE compType_status = '0' ";
$query = $conn->query($sql);
$row = $query->num_rows;
if($row>0){
  while ($rusult = $query->fetch_assoc()) {
    $sql2 = "SELECT a.compType_id
                FROM `Case` a
                LEFT JOIN `Complaint_Type` b ON (a.compType_id=b.compType_id)
                WHERE a.case_status != '0' AND b.compType_id = '$rusult[compType_id]' AND a.case_receivedoc_date LIKE '$lastmonth%' ";
  if($numpage==2){
    $sql2 = "SELECT a.compType_id
                FROM `Case` a
                LEFT JOIN `Complaint_Type` b ON (a.compType_id=b.compType_id)
                WHERE a.case_status != '0' AND b.compType_id = '$rusult[compType_id]' AND a.case_receivedoc_date >= '$fyear2_start' AND a.case_receivedoc_date<= '$fyear2_end' ";
    }
    if($numpage==3){
      $lastmonth = date('Y-',strtotime(date('Y-m-d') . "-1 year"));
      $sql2 = "SELECT a.compType_id
                  FROM `Case` a
                  LEFT JOIN `Complaint_Type` b ON (a.compType_id=b.compType_id)
                  WHERE a.case_status != '0' AND b.compType_id = '$rusult[compType_id]' AND a.case_receivedoc_date LIKE '$lastmonth%' ";
      }
    $query2 = $conn->query($sql2);
    $row2 = $query2->num_rows;
    $num_case_totle=0;
    $name_case = $rusult[compType_name];
    if($row2>0){
      while ($rusult2 = $query2->fetch_assoc()) {
        if($rusult[compType_id]==$rusult2[compType_id]){
          $num_case_totle++;
        }
      }
    }
    array_push($array_total_2,array($num_case_totle,$name_case));
  }
}

//graph right
   ?>
   <!-- <button type="button" name="button" onclick="get_page(1)" style="z-index:999;">page1</button>
   <button type="button" name="button" onclick="get_page(2)" style="z-index:999;">page2</button>
   <button type="button" name="button" onclick="get_page(3)" style="z-index:999;">page3</button>
   <button type="button" name="button" onclick="get_page(4)" style="z-index:999;">page4</button> -->

<!-- <div class="bw_1"></div>
<div class="bw_2"></div> -->
<div class="" id="animationSandbox"></div>
<script>
function testAnim(x) {
  $('#animationSandbox').removeClass().addClass(x + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
  $(this).removeClass();
  $('#animationSandbox').addClass('bw_3');
  });
  };

$(document).ready(function(){
  var anim = "slideInLeft";
  testAnim(anim);
});

</script>
<div class="container-fluid" >
  <div class="container-fluid">

    <div class="row" style="margin-top: -90px;margin-bottom: 55px;">
      <?php if($numpage==1){ ?>
      <div class="col-xs-12 col-lg-9" style="font-size: 40px;">
       <span style="color:#fff;text-shadow: 2px 2px #cf8424;padding-left:20px;">Monthly summary as of</span> <span style="color:#ffedce;text-shadow: 2px 2px #d98625;"><?php echo date('M d, Y'); ?></span>
      </div>
      <?php } ?>
      <?php if($numpage==2){ ?>
        <div class="col-xs-12 col-lg-9" style="font-size: 36px;">
          <span style="color:#fff;text-shadow: 2px 2px #cf8424;padding-left:20px;">Fiscal Yearly summary as of</span> <span style="color:#ffedce;text-shadow: 2px 2px #d98625;"><?php echo date('M d, Y'); ?></span>
        </div>
      <?php } ?>
      <?php if($numpage==3){ ?>
        <div class="col-xs-12 col-lg-9" style="font-size: 40px;">
         <span style="color:#fff;text-shadow: 2px 2px #cf8424;padding-left:20px;">Yearly summary as of</span> <span style="color:#ffedce;text-shadow: 2px 2px #d98625;"><?php echo date('M d, Y'); ?></span>
        </div>
      <?php } ?>
      <div class="col-xs-12 col-lg-3" style="margin-top: 24px;text-align: right;">
        <div class="time_top2">
          <span class="time_top"><?php echo date('H:i:s')?></span>
        </div>
        <img src="image/db_logo.png" style="margin-top: -103px;">
      </div>
    </div>

    <div class="row"  id="div_1_top">
      <div class="col-xs-12 col-lg-8">
          <div class="col-lg-12 box_l">
          <div class="">
            <div class="col-lg-6 full_table">
              <div class="row">
                <?php if($numpage==1){ ?>
                  <span class="crop_grey" style="float: left;text-transform: uppercase;"><?php echo date('M Y'); ?> </span>
                <?php } ?>
                <?php if($numpage==2){ ?>
                  <span class="crop_grey" style="float: left;text-transform: uppercase;">Fiscal Year <?php echo $str_year = substr($fyear1_end,0,4); ?> </span>
                <?php } ?>
                <?php if($numpage==3){ ?>
                  <span class="crop_grey" style="float: left;text-transform: uppercase;">Year <?php echo date('Y')?></span>
                <?php } ?>
              </div>
              <div class="text-center">
                <div id="container_top_1"></div>
              </div>

            </div>

            <?php
            $sql = "SELECT compType_id,compType_name FROM `Complaint_Type` WHERE compType_status = '0' ";
            $query = $conn->query($sql);
            $row = $query->num_rows;
            if($row<=4){
             ?>
            <div class="col-lg-6" id="no_slide">
            <?php
              // รอรหัสสี
              $color = array("#f06292","#7E57C2","#8D6E63","#4DB6AC","#f00","#28705c","#20386e","#b61cc0","#c03d2c","#55dec9","#1e699e","#3c9e1e","#f2f037","#4937f2","#20c53f");

              $date = date('Y-m-');
              $sql = "SELECT a.compType_id
                          FROM `Case` a
                          LEFT JOIN `Complaint_Type` b ON (a.compType_id=b.compType_id)
                          WHERE a.case_status != '0' AND a.case_receivedoc_date LIKE '$date%' ";
            if($numpage==2){
              $sql = "SELECT a.compType_id
                          FROM `Case` a
                          LEFT JOIN `Complaint_Type` b ON (a.compType_id=b.compType_id)
                          WHERE a.case_status != '0' AND a.case_receivedoc_date >= '$fyear1_start' AND a.case_receivedoc_date<= '$fyear1_end' ";
            }
            if($numpage==3){
              $date = date('Y-');
              $sql = "SELECT a.compType_id
                          FROM `Case` a
                          LEFT JOIN `Complaint_Type` b ON (a.compType_id=b.compType_id)
                          WHERE a.case_status != '0' AND a.case_receivedoc_date LIKE '$date%' ";
            }
              $query = $conn->query($sql);
              $num_row_total = $query->num_rows;
              // $sql = "SELECT compType_id,compType_name FROM `Complaint_Type` WHERE compType_status = '0' ";
              $sql = "SELECT compType_id,compType_name FROM `Complaint_Type` WHERE compType_status = '0' limit 4 ";
              $query = $conn->query($sql);
              $row = $query->num_rows;
              if($row>0){
                $show_color = 0;
                $case_to_case = 0;

                while ($rusult = $query->fetch_assoc()) {
                  $sql2 = "SELECT a.compType_id
                              FROM `Case` a
                              LEFT JOIN `Complaint_Type` b ON (a.compType_id=b.compType_id)
                              WHERE a.case_status != '0' AND b.compType_id = '$rusult[compType_id]' AND a.case_receivedoc_date LIKE '$date%' ";
                if($numpage==2){
                  $sql2 = "SELECT a.compType_id
                              FROM `Case` a
                              LEFT JOIN `Complaint_Type` b ON (a.compType_id=b.compType_id)
                              WHERE a.case_status != '0' AND b.compType_id = '$rusult[compType_id]' AND a.case_receivedoc_date >= '$fyear1_start' AND a.case_receivedoc_date<= '$fyear1_end' ";
                  }
                  if($numpage==3){
                    $sql2 = "SELECT a.compType_id
                                FROM `Case` a
                                LEFT JOIN `Complaint_Type` b ON (a.compType_id=b.compType_id)
                                WHERE a.case_status != '0' AND b.compType_id = '$rusult[compType_id]' AND a.case_receivedoc_date LIKE '$date%' ";
                    }
                  $query2 = $conn->query($sql2);
                  $row2 = $query2->num_rows;
                  $case_to_case = $case_to_case+$row2;
                }

                $query = $conn->query($sql);
                while ($rusult = $query->fetch_assoc()) {
                  $sql2 = "SELECT a.compType_id
                              FROM `Case` a
                              LEFT JOIN `Complaint_Type` b ON (a.compType_id=b.compType_id)
                              WHERE a.case_status != '0' AND b.compType_id = '$rusult[compType_id]' AND a.case_receivedoc_date LIKE '$date%' ";
                if($numpage==2){
                  $sql2 = "SELECT a.compType_id
                              FROM `Case` a
                              LEFT JOIN `Complaint_Type` b ON (a.compType_id=b.compType_id)
                              WHERE a.case_status != '0' AND b.compType_id = '$rusult[compType_id]' AND a.case_receivedoc_date >= '$fyear1_start' AND a.case_receivedoc_date<= '$fyear1_end' ";
                  }
                  if($numpage==3){
                    $sql2 = "SELECT a.compType_id
                                FROM `Case` a
                                LEFT JOIN `Complaint_Type` b ON (a.compType_id=b.compType_id)
                                WHERE a.case_status != '0' AND b.compType_id = '$rusult[compType_id]' AND a.case_receivedoc_date LIKE '$date%' ";
                    }
                  $query2 = $conn->query($sql2);
                  $row2 = $query2->num_rows;
                  $num_case_totle=0;
                  if($row2>0){
                    while ($rusult2 = $query2->fetch_assoc()) {
                      if($rusult[compType_id]==$rusult2[compType_id]){
                        $num_case_totle++;
                      }
                    }
                  }
                  ?>
                  <div class="row txt_box mar_b20">
                    <div class="col-lg-2" style="margin-top: 10px;">
                      <div class="" style="position:relative; background:#fff; width:68px; height:68px; border-radius:50%;">
                        <div class="" style="position:absolute; background:<?php echo $color[$show_color]; ?>; width:40px; height:40px; border-radius:50%; top:21%; left:21%;"></div>
                      </div>
                    </div>
                    <div class="col-lg-8" style="border-right: 2px solid #378e7b;">
                      <div class="txt_case_box_center">
                        <span><?php echo $num_case_totle; ?></span>
                        <span style="float: right;">
                          <?php
                          $pos = strpos(($num_case_totle/$case_to_case)*100, ".");
                          if ($pos == true) {
                            $value_case = number_format(($num_case_totle/$case_to_case)*100,2);
                          }else{
                            $value_case = ($num_case_totle/$case_to_case)*100;
                          }
                          echo $value_case
                           ?>%</span>
                      </div>
                      <div class="text_comptype_name">
                        <?php echo $rusult[compType_name]; ?>
                      </div>
                    </div>
                    <div class="col-lg-2" style="color: #fff;font-size: 22px;margin-top: 30px;margin-left: 0px;padding: 0 0 0 20px;font-family: 'kanit-light';">
                      <?php
                      $pos = strpos(($array_total_1[$show_color][0]/$array_total_2[$show_color][0])*100, ".");
                      if ($pos == true) {
                        $value_case = number_format(($array_total_1[$show_color][0]/$array_total_2[$show_color][0])*100,2);
                      }else{
                        $value_case = ($array_total_1[$show_color][0]/$array_total_2[$show_color][0])*100;
                      }
                      ?>
                      <span class="percen_case_box_left">
                        <?php if($value_case>=0){ ?>
                          <img src="image/ico-5.png" width="20px;">
                        <?php }else{ $value_case = str_replace("-"," ",$value_case);?>
                          <img src="image/ico-13.png" width="20px;">
                        <?php } ?>
                      </span>
                      <span class="percen_case_box_center">
                        <?php echo $value_case;?>%
                      </span>
                    </div>
                  </div>
                <?php
              $show_color++;  }
              }
               ?>
            </div>
              <?php }else{ ?>
                <script type="text/javascript">
                $(document).ready(function (){
                  $('ul.spy').simpleSpy(4, 4000);
                  show_div();
                });
                </script>
            <div class="col-lg-6" id="slide">
              <ul class="spy">
            <?php
              // รอรหัสสี
              $color = array("#f06292","#7E57C2","#8D6E63","#4DB6AC","#f00","#28705c","#20386e","#b61cc0","#c03d2c","#55dec9","#1e699e","#3c9e1e","#f2f037","#4937f2","#20c53f");

              $date = date('Y-m-');
              $sql = "SELECT a.compType_id
                          FROM `Case` a
                          LEFT JOIN `Complaint_Type` b ON (a.compType_id=b.compType_id)
                          WHERE a.case_status != '0' AND a.case_receivedoc_date LIKE '$date%' ";
            if($numpage==2){
              $sql = "SELECT a.compType_id
                          FROM `Case` a
                          LEFT JOIN `Complaint_Type` b ON (a.compType_id=b.compType_id)
                          WHERE a.case_status != '0' AND a.case_receivedoc_date >= '$fyear1_start' AND a.case_receivedoc_date<= '$fyear1_end' ";
              }
              if($numpage==3){
                $date = date('Y-');
                $sql = "SELECT a.compType_id
                            FROM `Case` a
                            LEFT JOIN `Complaint_Type` b ON (a.compType_id=b.compType_id)
                            WHERE a.case_status != '0' AND a.case_receivedoc_date LIKE '$date%' ";
                }
              $query = $conn->query($sql);
              $num_row_total = $query->num_rows;
              // $sql = "SELECT compType_id,compType_name FROM `Complaint_Type` WHERE compType_status = '0' ";
              $sql = "SELECT compType_id,compType_name FROM `Complaint_Type` WHERE compType_status = '0' ORDER BY compType_id asc ";
              $query = $conn->query($sql);
              $row = $query->num_rows;
              $active_li = 0;
              if($row>0){
                $show_color = 0;
                $case_to_case = 0;

                while ($rusult = $query->fetch_assoc()) {
                  $sql2 = "SELECT a.compType_id
                              FROM `Case` a
                              LEFT JOIN `Complaint_Type` b ON (a.compType_id=b.compType_id)
                              WHERE a.case_status != '0' AND b.compType_id = '$rusult[compType_id]' AND a.case_receivedoc_date LIKE '$date%' ";
                if($numpage==2){
                  $sql2 = "SELECT a.compType_id
                              FROM `Case` a
                              LEFT JOIN `Complaint_Type` b ON (a.compType_id=b.compType_id)
                              WHERE a.case_status != '0' AND b.compType_id = '$rusult[compType_id]' AND a.case_receivedoc_date >= '$fyear1_start' AND a.case_receivedoc_date<= '$fyear1_end' ";
                  }
                  if($numpage==3){
                    $sql2 = "SELECT a.compType_id
                                FROM `Case` a
                                LEFT JOIN `Complaint_Type` b ON (a.compType_id=b.compType_id)
                                WHERE a.case_status != '0' AND b.compType_id = '$rusult[compType_id]' AND a.case_receivedoc_date LIKE '$date%' ";
                    }
                  $query2 = $conn->query($sql2);
                  $row2 = $query2->num_rows;
                  $case_to_case = $case_to_case+$row2;
                }

                $query = $conn->query($sql);
                while ($rusult = $query->fetch_assoc()) {
                  $sql2 = "SELECT a.compType_id
                              FROM `Case` a
                              LEFT JOIN `Complaint_Type` b ON (a.compType_id=b.compType_id)
                              WHERE a.case_status != '0' AND b.compType_id = '$rusult[compType_id]' AND a.case_receivedoc_date LIKE '$date%' ";
                if($numpage==2){
                  $sql2 = "SELECT a.compType_id
                              FROM `Case` a
                              LEFT JOIN `Complaint_Type` b ON (a.compType_id=b.compType_id)
                              WHERE a.case_status != '0' AND b.compType_id = '$rusult[compType_id]' AND a.case_receivedoc_date >= '$fyear1_start' AND a.case_receivedoc_date<= '$fyear1_end' ";
                  }
                  if($numpage==3){
                    $sql2 = "SELECT a.compType_id
                                FROM `Case` a
                                LEFT JOIN `Complaint_Type` b ON (a.compType_id=b.compType_id)
                                WHERE a.case_status != '0' AND b.compType_id = '$rusult[compType_id]' AND a.case_receivedoc_date LIKE '$date%' ";
                    }
                  $query2 = $conn->query($sql2);
                  $row2 = $query2->num_rows;
                  $num_case_totle=0;
                  if($row2>0){
                    while ($rusult2 = $query2->fetch_assoc()) {
                      if($rusult[compType_id]==$rusult2[compType_id]){
                        $num_case_totle++;
                      }
                    }
                  }
                  $active_li++;
                  ?>
                  <li class="<?php if ($active_li==1){ echo "acrive_li"; } ?>" >
                  <div class="txt_box">
                    <div class="col-lg-2" style="margin-top: 10px;">
                      <div class="" style="position:relative; background:#fff; width:68px; height:68px; border-radius:50%;">
                        <div class="" style="position:absolute; background:<?php echo $color[$show_color]; ?>; width:40px; height:40px; border-radius:50%; top:21%; left:21%;"></div>
                      </div>
                    </div>
                    <div class="col-lg-8" style="border-right: 2px solid #378e7b;">
                      <div class="txt_case_box_center">
                        <span><?php echo $num_case_totle; ?></span>
                        <span style="float: right;">
                          <?php
                          $pos = strpos(@($num_case_totle/$case_to_case)*100, ".");
                          if ($pos == true) {
                            $value_case = number_format(@($num_case_totle/$case_to_case)*100,2);
                          }else{
                            $value_case = @($num_case_totle/$case_to_case)*100;
                          }
                          echo $value_case
                           ?>%</span>
                      </div>
                      <div class="text_comptype_name">
                        <?php echo $rusult[compType_name]; ?>
                      </div>
                    </div>
                    <div class="col-lg-2" style="color: #fff;font-size: 22px;margin-top: 30px;margin-left: 0px;padding: 0 0 0 20px;font-family: 'kanit-light';">
                      <?php
                      $pos = strpos(@($array_total_1[$show_color][0]/$array_total_2[$show_color][0])*100, ".");
                      if ($pos == true) {
                        $value_case = number_format(@($array_total_1[$show_color][0]/$array_total_2[$show_color][0])*100,2);
                      }else{
                        $value_case = @($array_total_1[$show_color][0]/$array_total_2[$show_color][0])*100;
                      }
                      ?>
                      <span class="percen_case_box_left">
                        <?php if($value_case>=0){ ?>
                          <img src="image/ico-5.png" width="20px;">
                        <?php }else{ $value_case = str_replace("-"," ",$value_case);?>
                          <img src="image/ico-13.png" width="20px;">
                        <?php } ?>
                      </span>
                      <span class="percen_case_box_center">
                        <?php echo $value_case;?>%
                      </span>
                    </div>
                  </div>
                  </li>
                <?php
              $show_color++;  }
              }
               ?>
               <?php
               $sql = "SELECT compType_id FROM `Complaint_Type` WHERE compType_status = '0' ORDER BY compType_id asc ";
               $query = $conn->query($sql);
               $row = $query->num_rows;
               if($row>0){
                 $array_comptype = array();
                 $rop_ar = 1;
                 while ($rusult = $query->fetch_assoc()) {
                   if($rop_ar<=3){
                     $rop_ar++;
                     array_push($array_comptype,$rusult[compType_id]);
                   }
                 }
               }
               $arr_comptype = "";
               for ($i=0; $i < count($array_comptype) ; $i++) {
                 $arr_comptype = $arr_comptype.$array_comptype[$i].",";
               }
               $arr_comptype = substr($arr_comptype,0,-1);

               $sql = "SELECT compType_id,compType_name FROM `Complaint_Type` WHERE compType_status = '0' AND compType_id in ($arr_comptype) ORDER BY compType_id desc ";
               $query = $conn->query($sql);
               $row = $query->num_rows;
               $active_li = 0;
               if($row>0){
                 $show_color = $row;
                 $case_to_case = 0;

                 while ($rusult = $query->fetch_assoc()) {
                   $sql2 = "SELECT a.compType_id
                               FROM `Case` a
                               LEFT JOIN `Complaint_Type` b ON (a.compType_id=b.compType_id)
                               WHERE a.case_status != '0' AND b.compType_id = '$rusult[compType_id]' AND a.case_receivedoc_date LIKE '$date%' ";
                 if($numpage==2){
                   $sql2 = "SELECT a.compType_id
                               FROM `Case` a
                               LEFT JOIN `Complaint_Type` b ON (a.compType_id=b.compType_id)
                               WHERE a.case_status != '0' AND b.compType_id = '$rusult[compType_id]' AND a.case_receivedoc_date >= '$fyear1_start' AND a.case_receivedoc_date<= '$fyear1_end' ";
                   }
                   if($numpage==3){
                     $sql2 = "SELECT a.compType_id
                                 FROM `Case` a
                                 LEFT JOIN `Complaint_Type` b ON (a.compType_id=b.compType_id)
                                 WHERE a.case_status != '0' AND b.compType_id = '$rusult[compType_id]' AND a.case_receivedoc_date LIKE '$date%' ";
                     }
                   $query2 = $conn->query($sql2);
                   $row2 = $query2->num_rows;
                   $case_to_case = $case_to_case+$row2;
                 }

                 $query = $conn->query($sql);
                 while ($rusult = $query->fetch_assoc()) {
                   $sql2 = "SELECT a.compType_id
                               FROM `Case` a
                               LEFT JOIN `Complaint_Type` b ON (a.compType_id=b.compType_id)
                               WHERE a.case_status != '0' AND b.compType_id = '$rusult[compType_id]' AND a.case_receivedoc_date LIKE '$date%' ";
                 if($numpage==2){
                   $sql2 = "SELECT a.compType_id
                               FROM `Case` a
                               LEFT JOIN `Complaint_Type` b ON (a.compType_id=b.compType_id)
                               WHERE a.case_status != '0' AND b.compType_id = '$rusult[compType_id]' AND a.case_receivedoc_date >= '$fyear1_start' AND a.case_receivedoc_date<= '$fyear1_end' ";
                   }
                   if($numpage==3){
                     $sql2 = "SELECT a.compType_id
                                 FROM `Case` a
                                 LEFT JOIN `Complaint_Type` b ON (a.compType_id=b.compType_id)
                                 WHERE a.case_status != '0' AND b.compType_id = '$rusult[compType_id]' AND a.case_receivedoc_date LIKE '$date%' ";
                     }
                   $query2 = $conn->query($sql2);
                   $row2 = $query2->num_rows;
                   $num_case_totle=0;
                   if($row2>0){
                     while ($rusult2 = $query2->fetch_assoc()) {
                       if($rusult[compType_id]==$rusult2[compType_id]){
                         $num_case_totle++;
                       }
                     }
                   }
                   $active_li++;
                   $show_color--;
                   ?>
                   <li class="test" >
                   <div class="txt_box <?=$rusult[compType_id]?>">
                     <div class="col-lg-2" style="margin-top: 10px;">
                       <div class="" style="position:relative; background:#fff; width:68px; height:68px; border-radius:50%;">
                         <div class="" style="position:absolute; background:<?php echo $color[$show_color]; ?>; width:40px; height:40px; border-radius:50%; top:21%; left:21%;"></div>
                       </div>
                     </div>
                     <div class="col-lg-8" style="border-right: 2px solid #378e7b;">
                       <div class="txt_case_box_center">
                         <span><?php echo $num_case_totle; ?></span>
                         <span style="float: right;">
                           <?php
                           $pos = strpos(@($num_case_totle/$case_to_case)*100, ".");
                           if ($pos == true) {
                             $value_case = number_format(@($num_case_totle/$case_to_case)*100,2);
                           }else{
                             $value_case = @($num_case_totle/$case_to_case)*100;
                           }
                           echo $value_case
                            ?>%</span>
                       </div>
                       <div class="text_comptype_name">
                         <?php echo $rusult[compType_name]; ?>
                       </div>
                     </div>
                     <div class="col-lg-2" style="color: #fff;font-size: 22px;margin-top: 30px;margin-left: 0px;padding: 0 0 0 20px;font-family: 'kanit-light';">
                       <?php
                       $pos = strpos(@($array_total_1[$show_color][0]/$array_total_2[$show_color][0])*100, ".");
                       if ($pos == true) {
                         $value_case = number_format(@($array_total_1[$show_color][0]/$array_total_2[$show_color][0])*100,2);
                       }else{
                         $value_case = @($array_total_1[$show_color][0]/$array_total_2[$show_color][0])*100;
                       }
                       ?>
                       <span class="percen_case_box_left">
                         <?php if($value_case>=0){ ?>
                           <img src="image/ico-5.png" width="20px;">
                         <?php }else{ $value_case = str_replace("-"," ",$value_case);?>
                           <img src="image/ico-13.png" width="20px;">
                         <?php } ?>
                       </span>
                       <span class="percen_case_box_center">
                         <?php echo $value_case;?>%
                       </span>
                     </div>
                   </div>
                   </li>
                 <?php
                 }
               }
                ?>
               </ul>
            </div>
        <?php } ?>
          </div>
        </div>
      </div>

      <div class="col-xs-12 col-lg-4">
        <div class="col-lg-12 box_r">
          <div class="row">
            <?php if($numpage==1){ ?>
              <span class="crop_grey" style="float: right;text-transform: uppercase;"><?php echo date('M Y',strtotime("-1 month")); ?></span>
            <?php } ?>
            <?php if($numpage==2){ ?>
              <span class="crop_grey" style="float: right;text-transform: uppercase;">Fiscal Year <?php echo $str_year = substr($fyear2_end,0,4); ?></span>
            <?php } ?>
            <?php if($numpage==3){ ?>
              <span class="crop_grey" style="float: right;text-transform: uppercase;">Year <?php echo date('Y',strtotime("-1 year")); ?></span>
            <?php } ?>
          </div>
          <div class="row text-center" style="margin-top:20px;margin-bottom:-20px;">
            <div id="container_top_2"></div>
          </div>

          <div class="container-fluid txt_box2" style="margin-top: 53px;">
            <div class="col-lg-1" style="margin-top: 19px; padding:0px;">
              <img src="<?php echo $icon_per; ?>" width="37">
            </div>
            <div class="col-lg-3" >
              <div class="txt_total_r text-center">
                <?php echo $case_total; ?>
              </div>
            </div>
            <div class="col-lg-5">
              <div class="txt_per_r">
                <?php echo $txt_per; ?>
              </div>
            </div>
            <div class="col-lg-3 txt_percent_r">
              <?php echo $percent_total."%"; ?>
            </div>
          </div>

        </div>
      </div>

    </div>

  </div>

  <div class="" style="margin-top:2%;" id="div_1_bottom">
    <div class="col-lg-3 ">
      <div class="col-lg-12 box_mini">
      <div class="row" style="float: right;margin-top: 22px;">
        <span class="btn_priority_1">
          <img src="image/ico-6.png" style="width: 17px;padding-bottom: 6px;">
          New Case
        </span>
      </div>
      <div class="row text-center" style="margin-top: 60px;color:#fff;">
        <div class="col-lg-4" style="margin-top: -25px;">
          <div class="" style="font-size: 76px;">
            <?php echo $new_today; ?>
          </div>
          <div class="" style="margin-top: -18px;font-family: 'kanit-light-italic';">
            Today Case
          </div>
        </div>
        <div class="col-lg-4" style="border-left: 1px solid #fff;border-right: 1px solid #fff;">
          <div class="" style="font-size: 46px;">
            <?php echo $new_tomonth; ?>
          </div>
          <div class="" style="font-size: 13px;font-family: 'kanit-light-italic';">
            Total Monthly
          </div>
        </div>
        <div class="col-lg-4">
          <div class="" style="font-size: 46px;">
            <?php echo $new_toyear; ?>
          </div>
          <div class="" style="font-family: 'kanit-light-italic';">
            Total Yearly
          </div>
        </div>
      </div>
      <div class="container-fluid tab_pro">
        <?php
        $pos = strpos(@($new_toyear/$total_case_year)*100, ".");
        if ($pos == true) {
          $value_case = number_format(@($new_toyear/$total_case_year)*100,2);
        }else{
          $value_case = @($new_toyear/$total_case_year)*100;
        }
        ?>
        <div class="progressbar-small progressbar" data-value="<?php echo $value_case; ?>">
          <div class="progressbar-value progress_1 tooltip-button" title="<?php echo $value_case; ?>%">
          </div>
        </div>

        <div class="" style="margin-top: 6px;color: #fff;font-size: 13px;">
          <span class="float:left;">
            <?php echo $value_case; ?>%
          </span>
          <span class="" style="float:right;font-family: 'kanit-light';">
            ของเคสทั้งหมด
          </span>
        </div>
      </div>
    </div>
    </div>

    <div class="col-lg-3">
    <div class="col-lg-12 box_mini">
      <div class="row" style="float: right;margin-top: 22px;">
        <span class="btn_priority_2">
          <img src="image/ico-7.png" style="width: 17px;padding-bottom: 6px;">
          In Process
        </span>
      </div>
      <div class="row text-center" style="margin-top: 60px;color:#fff;">
        <div class="col-lg-4" style="margin-top: -25px;">
          <div class="" style="font-size: 76px;">
            <?php echo $pending_today; ?>
          </div>
          <div class="" style="margin-top: -18px;font-family: 'kanit-light-italic';">
            Today Case
          </div>
        </div>
        <div class="col-lg-4" style="border-left: 1px solid #fff;border-right: 1px solid #fff;">
          <div class="" style="font-size: 46px;">
            <?php echo $pending_tomonth; ?>
          </div>
          <div class="" style="font-size: 13px;font-family: 'kanit-light-italic';">
            Total Monthly
          </div>
        </div>
        <div class="col-lg-4">
          <div class="" style="font-size: 46px;">
            <?php echo $pending_toyear; ?>
          </div>
          <div class="" style="font-family: 'kanit-light-italic';">
            Total Yearly
          </div>
        </div>
      </div>
      <div class="container-fluid tab_pro">
        <?php
        $pos = strpos(@($pending_toyear/$total_case_year)*100, ".");
        if ($pos == true) {
          $value_case = number_format(@($pending_toyear/$total_case_year)*100,2);
        }else{
          $value_case = @($pending_toyear/$total_case_year)*100;
        }
        ?>
        <div class="progressbar-small progressbar" data-value="<?php echo $value_case; ?>">
          <div class="progressbar-value progress_2 tooltip-button" title="<?php echo $value_case; ?>%">
          </div>
        </div>

        <div class="" style="margin-top: 6px;color: #fff;font-size: 13px;">
          <span class="float:left;">
            <?php echo $value_case; ?>%
          </span>
          <span class="" style="float:right;">
            ของเคสทั้งหมด
          </span>
        </div>
      </div>
    </div>
    </div>

    <div class="col-lg-3">
    <div class="col-lg-12 box_mini">
      <div class="row" style="float: right;margin-top: 22px;">
        <span class="btn_priority_3">
          <img src="image/ico-8.png" style="width: 17px;padding-bottom: 6px;">
          Overdue
        </span>
      </div>
      <div class="row text-center" style="margin-top: 60px;color:#fff;">
        <div class="col-lg-4" style="margin-top: -25px;">
          <div class="" style="font-size: 76px;">
            <?php echo $overdue_today; ?>
          </div>
          <div class="" style="margin-top: -18px;font-family: 'kanit-light-italic';">
            Today Case
          </div>
        </div>
        <div class="col-lg-4" style="border-left: 1px solid #fff;border-right: 1px solid #fff;">
          <div class="" style="font-size: 46px;">
            <?php echo $overdue_tomonth; ?>
          </div>
          <div class="" style="font-size: 13px;font-family: 'kanit-light-italic';">
            Total Monthly
          </div>
        </div>
        <div class="col-lg-4">
          <div class="" style="font-size: 46px;">
            <?php echo $overdue_toyear; ?>
          </div>
          <div class="" style="font-family: 'kanit-light-italic';">
            Total Yearly
          </div>
        </div>
      </div>
      <div class="container-fluid tab_pro">
        <?php
        $pos = strpos(@($overdue_toyear/$total_case_year)*100, ".");
        if ($pos == true) {
          $value_case = number_format(@($overdue_toyear/$total_case_year)*100,2);
        }else{
          $value_case = @($overdue_toyear/$total_case_year)*100;
        }
        ?>
        <div class="progressbar-small progressbar" data-value="<?php echo $value_case; ?>">
          <div class="progressbar-value progress_3 tooltip-button" title="<?php echo $value_case; ?>%">
          </div>
        </div>
        <div class="" style="margin-top: 6px;color: #fff;font-size: 13px;">
          <span class="float:left;">
            <?php echo $value_case; ?>%
          </span>
          <span class="" style="float:right;">
            ของเคสทั้งหมด
          </span>
        </div>
      </div>
    </div>
    </div>

    <div class="col-lg-3">
    <div class="col-lg-12 box_mini">
      <div class="row" style="float: right;margin-top: 22px;">
        <span class="btn_priority_4">
          <img src="image/ico-9.png" style="width: 17px;padding-bottom: 6px;">
          Complete
        </span>
      </div>
      <div class="row text-center" style="margin-top: 60px;color:#fff;">
        <div class="col-lg-4" style="margin-top: -25px;">
          <div class="" style="font-size: 76px;">
            <?php echo $Complete_today; ?>
          </div>
          <div class="" style="margin-top: -18px;font-family: 'kanit-light-italic';">
            Today Case
          </div>
        </div>
        <div class="col-lg-4" style="border-left: 1px solid #fff;border-right: 1px solid #fff;">
          <div class="" style="font-size: 46px;">
            <?php echo $Complete_tomonth; ?>
          </div>
          <div class="" style="font-size: 13px;font-family: 'kanit-light-italic';">
            Total Monthly
          </div>
        </div>
        <div class="col-lg-4">
          <div class="" style="font-size: 46px;">
            <?php echo $Complete_toyear; ?>
          </div>
          <div class="" style="font-family: 'kanit-light-italic';">
            Total Yearly
          </div>
        </div>
      </div>
      <div class="container-fluid tab_pro">
        <?php
        $pos = strpos(@($Complete_toyear/$total_case_year)*100, ".");
        if ($pos == true) {
          $value_case = number_format(@($Complete_toyear/$total_case_year)*100,2);
        }else{
          $value_case = @($Complete_toyear/$total_case_year)*100;
        }
        ?>
        <div class="progressbar-small progressbar" data-value="<?php echo $value_case; ?>">
          <div class="progressbar-value progress_4 tooltip-button" title="<?php echo $value_case; ?>%">
          </div>
        </div>
        <div class="" style="margin-top: 6px;color: #fff;font-size: 13px;">
          <span class="float:left;">
            <?php echo $value_case; ?>%
          </span>
          <span class="" style="float:right;">
            ของเคสทั้งหมด
          </span>
        </div>
      </div>
    </div>
    </div>
  </div>

</div>


<script type="text/javascript">

setInterval(function(){

      var currentTime = new Date();
      var hours = currentTime.getHours();
      var minutes = currentTime.getMinutes();
      var seconds = currentTime.getSeconds();

      // Add leading zeros
      minutes = (minutes < 10 ? "0" : "") + minutes;
      seconds = (seconds < 10 ? "0" : "") + seconds;
      hours = (hours < 10 ? "0" : "") + hours;

      // Compose the string for display
      var currentTimeString = hours + ":" + minutes + ":" + seconds;
      $(".time_top").html(currentTimeString);

},1000);

  $(document).ready(function (){

    <?php if($num_total_1!=0){ ?>

    Highcharts.chart('container_top_1', {
      chart: {
        plotBackgroundColor: null,
        plotBorderWidth: 0,
        plotShadow: false
      },
      // colors: ['#7E57C2', '#F06292', '#4DB6AC', '#8D6E63'],
      colors: [
        <?php
          echo "'".$color[0]."'";
          for ($i=1; $i < count($color); $i++) {
            echo ", '".$color[$i]."'";
          }
         ?>
      ],
      title: {
        text: '<span class="total_txt" style="font-family: kanitregular;">Total Case</span><br><span class="total_txt_sun" style=" font-weight: lighter;font-family: kanitregular;font-size: 100px;"><?php echo $num_total_1; ?></span>',
        align: 'center',
        verticalAlign: 'middle',
        y: -50
      },
      tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
      },
      plotOptions: {
        pie: {
          dataLabels: {
            enabled: false,
            distance: -50,
            style: {
              fontWeight: 'bold',
              color: 'white'
            }
          },

        }
      },
      series: [{
        type: 'pie',
        name: 'Total Case',
        innerSize: '75%',
        data: [
          // ['Overdue', 25],
          // ['Waiting', 10],
          // ['Pending', 50],
          // ['Close', 10],
          <?php
            for ($i=0; $i < count($array_total_1); $i++) {
              echo "['".$array_total_1[$i][1]."', ".$array_total_1[$i][0]."],";
            }
           ?>
        ]
      }]
    });

    <?php }else{ ?>

      Highcharts.chart('container_top_1', {
        chart: {
          plotBackgroundColor: null,
          plotBorderWidth: 0,
          plotShadow: false
        },
        colors: ['#8a9494'],
        title: {
          text: '<span class="total_txt" style="font-family: kanitregular;">Total Case</span><br><span class="total_txt_sun" style=" font-weight: lighter;font-family: kanitregular;font-size: 100px;">0</span>',
          align: 'center',
          verticalAlign: 'middle',
          y: -50
        },
        tooltip: {
          pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
          pie: {
            dataLabels: {
              enabled: false,
              distance: -50,
              style: {
                fontWeight: 'bold',
                color: 'white'
              }
            },

          }
        },
        series: [{
          type: 'pie',
          name: 'Total Case',
          innerSize: '75%',
          data: [
            ['No Case', 100],
          ]
        }]
      });

      <?php } ?>

      <?php if($num_total_2!=0){ ?>
    Highcharts.chart('container_top_2', {
      chart: {
        plotBackgroundColor: null,
        plotBorderWidth: 0,
        plotShadow: false
      },
      // colors: ['#7E57C2', '#F06292', '#4DB6AC', '#8D6E63'],
      colors: [
      <?php
        echo "'".$color[0]."'";
        for ($i=1; $i < count($color); $i++) {
          echo ", '".$color[$i]."'";
        }
       ?>
       ],
      title: {
        text: '<span class="total_txt" style="font-family: kanitregular;">Total Case</span><br><span class="total_txt_sun" style=" font-weight: lighter;font-family: kanitregular;font-size: 60px;"><?php echo $num_total_2; ?></span>',
        align: 'center',
        verticalAlign: 'middle',
        y: -30
      },
      tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
      },
      plotOptions: {
        pie: {
          dataLabels: {
            enabled: false,
            distance: -50,
            style: {
              fontWeight: 'bold',
              color: 'white'
            }
          },

        }
      },
      series: [{
        type: 'pie',
        name: 'Total Case',
        innerSize: '75%',
        data: [
          // ['Overdue', 25],
          // ['Waiting', 10],
          // ['Pending', 50],
          // ['Close', 10],
          <?php
            for ($i=0; $i < count($array_total_2); $i++) {
              echo "['".$array_total_2[$i][1]."', ".$array_total_2[$i][0]."],";
            }
           ?>
        ]
      }]
    });
        <?php }else{ ?>
          Highcharts.chart('container_top_2', {
            chart: {
              plotBackgroundColor: null,
              plotBorderWidth: 0,
              plotShadow: false
            },
            colors: ['#8a9494'],
            title: {
              text: '<span class="total_txt" style="font-family: kanitregular;">Total Case</span><br><span class="total_txt_sun" style=" font-weight: lighter;font-family: kanitregular;font-size: 60px;">0</span>',
              align: 'center',
              verticalAlign: 'middle',
              y: -30
            },
            tooltip: {
              pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
              pie: {
                dataLabels: {
                  enabled: false,
                  distance: -50,
                  style: {
                    fontWeight: 'bold',
                    color: 'white'
                  }
                },

              }
            },
            series: [{
              type: 'pie',
              name: 'Total Case',
              innerSize: '75%',
              data: [
                ['No Case', 100],
              ]
            }]
          });

          <?php } ?>
  });
</script>

<!-- Bootstrap Progress Bar -->
<script type="text/javascript" src="css/assets/widgets/progressbar/progressbar.js"></script>
<script type="text/javascript" src="css/bootstrap/js/bootstrap.js"></script>

<script src="js/jquery-1.2.6.js" type="text/javascript"></script>
<script src="js/spy_box_mid.js" type="text/javascript"></script>
