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
    <link rel="stylesheet" type="text/css" href="css/fonts.css">

    <!-- piegage -->
    <!-- <link rel="stylesheet" type="text/css" href="css/assets/widgets/charts/piegage/piegage.css"> -->

    <link rel="stylesheet" type="text/css" href="css/assets/helpers/colors.css">

    <!-- progressbar -->
    <link rel="stylesheet" type="text/css" href="css/assets/widgets/progressbar/progressbar.css">

    <!-- BOOTSTRAP -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap/css/bootstrap.css">

    <!-- JS Core -->
    <script type="text/javascript" src="css/assets/js-core/jquery-core.js"></script>
    <script type="text/javascript" src="css/assets/js-core/jquery-ui-core.js"></script>
    <script type="text/javascript" src="css/assets/js-core/jquery-ui-widget.js"></script>

    <!-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script> -->
    <!-- <link rel="stylesheet" type="text/css" href="css/easy_chart.css">
    <script type="text/javascript" src="js/easypiechart.js"></script> -->

    <!-- <link rel="stylesheet"type="text/css" href="/path/to/jquery.easy-pie-chart.css"> -->

    <link rel="stylesheet" type="text/css" href="css/dashboard.css">

  </head>

   <!-- <button type="button" name="button" onclick="get_page(1)" style="z-index:999;">page1</button>
   <button type="button" name="button" onclick="get_page(2)" style="z-index:999;">page2</button>
   <button type="button" name="button" onclick="get_page(3)" style="z-index:999;">page3</button>
   <button type="button" name="button" onclick="get_page(4)" style="z-index:999;">page4</button> -->

<div class="container-fluid" >
  <div class="container-fluid" >

    <div class="row" style="margin-top: -102px;margin-bottom: 30px;">
      <div class="col-xs-12 col-lg-9" style="font-size: 48px;">
       <span style="color:#fff;text-shadow: 2px 2px #cf8424;padding-left:40px;">Summary as of</span> <span style="color:#ffedce;text-shadow: 2px 2px #d98625;"><?php echo date('M d, Y'); ?></span>
      </div>
      <div class="col-xs-12 col-lg-3" style="margin-top: 24px;text-align: right;">
        <div class="time_top2">
          <span class="time_top"><?php echo date('H:i:s')?></span>
        </div>
        <img src="image/db_logo.png" style="margin-top: -103px;">
      </div>
    </div>

    <div id="test_carousel">

      <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">

        <div class="carousel-inner" role="listbox">
          <?php
          $sql_office = "SELECT * FROM `office_type` order by office_id asc ";
          $query_office = $conn->query($sql_office);
          if($query_office->num_rows>0){
            $active_first = 0;
            while ($result_office = $query_office->fetch_assoc()) {
                $sql = "SELECT * FROM `Employee` a
                LEFT JOIN `Employee_Group` b on (a.empGroup_id=b.empGroup_id)
                LEFT JOIN `office_type` c on (a.office_id=c.office_id)
                WHERE b.empGroup_section = '1'
                AND b.empGroup_level = '0'
                AND b.empGroup_id != '9'
                AND a.emp_available_dashboard = '1'
                AND a.emp_status = '0'
                AND a.office_id = '$result_office[office_id]'
                order by c.office_id,a.emp_real_id asc
                 ";
              //  echo "<br>".$sql;
               $query = $conn->query($sql);
               $row = $query->num_rows;
               $max_member = $row;
               $rop_member = 0;
               if($row>0){
                 ?><div class="item <?php if($active_first==0){ echo 'active';$active_first++; } ?>"><?
                 while ($result = $query->fetch_assoc()) {
                   $rop_member++;
                   ?>
                     <div class="col-lg-4" style="color:#fff">
                       <div class="col-lg-12 ">
                         <div class="col-lg-12 box_big">
                           <div class="row">
                             <div class="col-lg-4" style="margin-top: 20px;text-align: -webkit-center;overflow:hidden;width: 186px;height: 156px;">
                               <?php
                                 $true_pic = $result[emp_img_path];
                                 $true_pic = explode('/',$true_pic);
                                 $show_pic = "../data/emp_images/".$true_pic[2]."/s/*.*";
                                 $value="";
                                 foreach (glob($show_pic) as $value) {
                                 break;
                                 }
                                 if($value!=""){
                                   $show_pic = $value;
                                 }else{
                                   $show_pic = "image/db_person_1.png";
                                 }
                                 ?>
                               <?php /* <div class="show_img_emp" style="background: url('<?php echo $show_pic ?>') no-repeat center top;"></div> */?>
                               <img src="<?php echo $show_pic ?>" style="<?php echo getPositionImage($show_pic,100); ?>">
                             </div>
                             <div class="col-lg-8" style="margin-top: 45px;margin-right: -10px;">
                               <div class="" style="font-size:28px; white-space: nowrap;text-overflow: ellipsis;overflow: hidden;">
                                 <?php echo $result[emp_firstname]." ".$result[emp_lastname]; ?>
                               </div>
                               <div class="" style="font-family: 'kanit-light';">
                                 E-mail : <?php echo $result[emp_email]; ?>
                               </div>
                               <div class="" style="font-family: 'kanit-light';">
                                 Tel : <?php echo $result[emp_tel]; ?>
                               </div>
                               <div class="" style="font-family: 'kanit-light';">
                                 <?php if($result[office_id]==0){ ?>
                                   สำนัก : สำนักสารสนเทศและการบริการการค้าระหว่างประเทศ
                               <?php }else{ ?>
                                   สำนัก : <?php echo $result[office_name]; ?>
                                 <?php } ?>
                               </div>
                             </div>
                           </div>
                             <!-- คำนวน case -->
                             <?php
                             // totalcase
                             $sql2 = "SELECT * FROM `Case_Assign` a
                                     LEFT JOIN `Case` b on (a.case_id=b.case_id)
                                     WHERE a.emp_id = '$result[emp_id]' AND b.case_status != '0' AND a.caseAsign_status = '0'
                                     ";
                             $query2 = $conn->query($sql2);
                             $totle_case = $query2->num_rows;

                             // totalcase
                             // new case
                             $sql2 = "SELECT * FROM `Case_Assign` a
                                     LEFT JOIN `Case` b on (a.case_id=b.case_id)
                                     WHERE a.emp_id = '$result[emp_id]' AND b.case_status = '1' AND a.caseAsign_status = '0'
                                     ";
                             $query2 = $conn->query($sql2);
                             $new_case = $query2->num_rows;
                             // echo "<hr>newcase=";
                             // echo $new_case;
                             // echo "<hr>";
                             // new case

                             // pending
                                 $datenow = date('Y-m-d');
                                 $sql2 = "SELECT * FROM `Case_Assign` a
                                         LEFT JOIN `Case` b on (a.case_id=b.case_id)
                                         LEFT JOIN `Complaint_Type` c on (b.compType_id=c.compType_id)
                                         WHERE a.emp_id = '$result[emp_id]' AND b.case_status = '2' AND a.caseAsign_status = '0'
                                         ";
                                 $query2 = $conn->query($sql2);
                                 $row2 = $query2->num_rows;
                                 $pending_today = 0;
                                 $overdue_today = 0;
                                 $process_overdue = array();
                                 if($row2>0){
                                   while ($result2 = $query2->fetch_assoc()) {
                                      $case_id = $result2[case_id];
                                      $case_compType_duration = $result2[case_compType_duration];
                                     $sql3 = "SELECT case_opened_datetime FROM `Case` WHERE case_id = '$case_id' ";
                                     $query3 = $conn->query($sql3);
                                     $row3 = $query3->num_rows;
                                     if($row3>0){
                                       while ($result3 = $query3->fetch_assoc()) {
                                         $case_open = $result3[case_opened_datetime];
                                         $case_open = substr($case_open,0,10);
                                         $date_start = $case_open;
                                         $date_stop = $datenow;
                                         $getdays = getDateTimeData($date_start,$date_stop);
                                         $getdays = $getdays['days'];
                                         if($getdays<1){
                                           $getdays=0;
                                         }
                                         if($getdays<=$case_compType_duration){
                                           $pending_today++;
                                         }else{ // main over due
                                           array_push($process_overdue,$case_id);
                                           $overdue_today++;
                                         }
                                       }
                                     }
                                   }
                                 }
                                 //   echo "<hr>array=";
                                 // print_r($process_overdue);
                                 $txt_overdue = array();
                                 for ($i=0; $i < count($process_overdue); $i++) {
                                   $sql2 = "SELECT * FROM `Process` WHERE case_id = '$process_overdue[$i]' ";
                                   $query2 = $conn->query($sql2);
                                   $row2 = $query2->num_rows;
                                   if($row2>0){
                                     while ($result2 = $query2->fetch_assoc()) {
                                       $txt = $result2[process_over_datetime];
                                       if($result2[process_complete_datetime]!=""){
                                         if($result2[process_complete_datetime] > gmdate("Y-m-d H:i:s", $txt)){
                                           if($result2[process_over_note]!=""){
                                             array_push($txt_overdue,$result2[process_over_note]);
                                           }
                                         }
                                       }else{
                                         if(date('Y-m-d H:i:s') > gmdate("Y-m-d H:i:s", $txt)){
                                           if($result2[process_over_note]!=""){
                                             array_push($txt_overdue,$result2[process_over_note]);
                                           }
                                         }
                                       }
                                     }
                                   }
                                 }
                                 // echo "<hr>text overdue array=";
                                 // print_r($txt_overdue);
                                 // echo "<hr>pending=";
                                 // echo $pending_today;
                                 // echo "<hr>";

                             // pending
                             // complete
                             $sql2 = "SELECT * FROM `Case_Assign` a
                                     LEFT JOIN `Case` b on (a.case_id=b.case_id)
                                     LEFT JOIN `Complaint_Type` c on (b.compType_id=c.compType_id)
                                     WHERE a.emp_id = '$result[emp_id]' AND b.case_status = '3' AND a.caseAsign_status = '0' ";
                             $query2 = $conn->query($sql2);
                             $row2 = $query2->num_rows;
                             $Complete_today = 0;
                             if($row2>0){
                               while ($result2 = $query2->fetch_assoc()) {
                                 $case_id = $result2[case_id];
                                 $case_compType_duration = $result2[case_compType_duration];
                                 $case_opened_datetime = $result2[case_opened_datetime];
                                 $case_opened_datetime = substr($case_opened_datetime,0,10);
                                 $case_close_datetime = $result2[case_close_datetime];
                                 $case_close_datetime = substr($case_close_datetime,0,10);
                                 $getdays = getDateTimeData($case_opened_datetime,$case_close_datetime);
                                 $getdays = $getdays['days'];
                                 if($getdays<1){
                                   $getdays=0;
                                 }
                                 if($getdays<=$case_compType_duration){
                                   $Complete_today++;
                                 }else{
                                   $overdue_today++;
                                 }
                               }
                             }
                             // echo "<hr>overdue=";
                             // echo $overdue_today;
                             // echo "<hr>";

                             // echo "<hr>complete=";
                             // echo $Complete_today;
                             // echo "<hr>";
                             // complete

                              ?>
                           <div class="row box_medium">
                             <div class="col-lg-4 text-center">
                               <div class="" style="font-size: 25px;margin-top: 48px;font-family: 'kanitthin';">
                                 Total Case
                               </div>
                               <div class="" style="font-size: 80px;margin-top: -20px;">
                                 <?php echo $totle_case; ?>
                               </div>
                             </div>
                             <div class="col-lg-8 box_small">
                               <?php
                               $all_case = 0;
                               $all_case = $all_case+$new_case;
                               $all_case = $all_case+$pending_today;
                               $all_case = $all_case+$Complete_today;
                               $all_case = $all_case+$overdue_today;
                                ?>
                               <div class="row" style="margin-top: 10px;">
                                 <div class="col-lg-4">
                                   <!-- <img src="image/ico-10.png" width="100%"> -->
                                   <div class="chart-alt-10" data-percent="<?php echo ($new_case/$all_case)*100; ?>" data-bar-color="#2196F3"></div>
                                   <div class="chart_num_case"><?php echo $new_case; ?></div>
                                   <div class="chart_txt_case">New Case</div>
                                 </div>
                                 <div class="col-lg-4">
                                   <div class="chart-alt-10" data-percent="<?php echo ($pending_today/$all_case)*100; ?>" data-bar-color="#FF9800"></div>
                                   <div class="chart_num_case"><?php echo $pending_today; ?></div>
                                   <div class="chart_txt_case">In Process</div>
                                 </div>
                                 <div class="col-lg-4">
                                   <div class="chart-alt-10" data-percent="<?php echo ($Complete_today/$all_case)*100; ?>" data-bar-color="#4CAF50"></div>
                                   <div class="chart_num_case"><?php echo $Complete_today; ?></div>
                                   <div class="chart_txt_case">Complete</div>
                                 </div>
                               </div>

                               <div class="row" style="margin-top: 15px;">
                                 <div class="col-lg-4">
                                   <div class="chart-alt-10" data-percent="<?php echo($overdue_today/$all_case)*100; ?>" data-bar-color="#F44336"></div>
                                   <div class="chart_num_case"><?php echo $overdue_today; ?></div>
                                   <div class="chart_txt_case">Overdue</div>
                                 </div>
                                 <div class="col-lg-8 row">
                                   <div class="" style="margin-top:10px;">
                                     <?php
                                     for ($i=0; $i < count($txt_overdue); $i++) { ?>
                                       <div class="col-lg-3">
                                         <img src="image/ico-12.png">
                                       </div>
                                       <div class="col-lg-9" style="margin-top:5px;font-family: 'kanit-light';">
                                         <?php echo $txt_overdue[$i]; ?>
                                       </div>
                                   <?php } ?>
                                   </div>
                                 </div>
                               </div>

                             </div>
                           </div>

                         </div>
                       </div>
                     </div>
                     <?php if($rop_member%6==0){?>
                     </div>
                     <?php if($rop_member==$max_member){ }else{?><div class="item <?="m=".$max_member."r=".$rop_member?>"><?php } ?>
                   <?php } ?>
             <?php  } echo '</div>';
                 } ?>
                 <?php if($rop_member==$max_member){ }else{ ?></div><?php } ?>
        <?  }
          }
          ?>
          </div>

        <!-- Controls -->
        <!-- <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a> -->

  </div>

</div> <!-- test carousel -->
  </div>

</div>



<script type="text/javascript">

  function slide_auto() {
    $('.carousel').carousel('next');
     timer_2 = setTimeout(function(){ slide_auto(); }, 20000);
  }

  $(document).ready(function (){
    show_div();
     timer_1 = setTimeout(function(){ slide_auto(); }, 20000);
  });

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


</script>

    <script type="text/javascript" src="css/assets/widgets/charts/piegage/piegage.js"></script>
    <script type="text/javascript" src="css/assets/widgets/charts/piegage/piegage-demo.js"></script>
<!-- Bootstrap Progress Bar -->
<script type="text/javascript" src="css/assets/widgets/progressbar/progressbar.js"></script>
<script type="text/javascript" src="css/bootstrap/js/bootstrap.js"></script>
