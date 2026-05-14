<?php

if($_POST['method'] == "filter_appeal"){
include('config/config.php');
include('lang.php');
$status_filter = $_POST['chk_status'];
$txt_search = $_POST['txt_search'];
if($txt_search == ""){
  $where_search = "";
}else {
  $where_search = "AND (caseDtl_title LIKE '%$txt_search%' OR complnt_name LIKE '%$txt_search%')";
}
if($status_filter == 0){?>
  <div class="panel panel-default appeal_panel">
    <div class="panel-heading hr_appeal_panel">
      <span class="hr_txt_waiting"><?=$txt_Status?> : </span><span class="icon_waiting"><img src="images/icon_waiting.png"></span>
      <span class="all_waiting"><a href="?page=all_appeal&status=1"><?=$txt_View_all?> > </a></span>
    </div>
    <?php
    $sql_waitting = "SELECT * FROM `Case` WHERE caseCh_id in (0,1,2) AND case_status = '0' AND case_createBy_id = '".$_SESSION['member_id']."' $where_search ORDER BY case_id DESC LIMIT 0,5";
    $query_waitting = $conn->query($sql_waitting);
    if($query_waitting->num_rows > 0){
      while ($re = $query_waitting->fetch_assoc()) {
        $date_time = $re['case_create_datetime'];
        $date_time_ex = explode(" ",$date_time);
        $date_waitting = $date_time_ex[0];
        $time_waitting = $date_time_ex[1];
        $date_ex = explode("-",$date_waitting);
        $time_ex = explode(":",$time_waitting);
        $date = $date_ex[2]."/".$date_ex[1]."/".$date_ex[0];
        $time = $time_ex[0].".".$time_ex[1];
    ?>
    <div class="panel-body">
      <div class="panel panel-default panel_waiting_appeal">
        <div class="list_waiting">
          <div class="row">
            <div class="col-md-1 col-sm-2 col-xs-3 list_waiting_icon">
              <img src="images/icon_zero.png" class="icon_zero_appeal">
            </div>
            <div class="col-md-10 col-sm-8 col-xs-9 list_waiting_detail">
              <span class="txt_app hr_appeal_detail_ex"><?=$txt_Petition_topic?> : <br></span><span class="txt_app hr_appeal_detail_er"><?php echo $re['caseDtl_title'];?><br></span><span class="txt_app"> | </span>
              <span class="txt_app hr_appeal_detail_ec"><?=$txt_Petitioner_company?> : <br></span><span class="txt_app"><?php echo $re['complnt_name'];?></span></p>
              <span class="icon_date"><img src="images/all_icon_DITP/icon_19.svg" style="width:15px;"></span><span class="waiting_date"><?php echo $date;?></span>
              <span class="icon_time"><img src="images/all_icon_DITP/icon_21.svg" style="width:20px;"></span><span class="waiting_time"><?php echo $time;?></span>
            </div>
            <div class="col-md-1 col-sm-2 list_waiting_search"><span class="icon_search_detail"><a href="?page=appeal_detail&case_id=<?=$re['case_id'];?>"><img src="images/all_icon_DITP/icon_26.svg" style="width:40px;"></a></span></div>
          </div>
      </div>
      </div>
  </div>
  <?php
    }
  }else {?>
    <div class="panel-body">
      <div class="panel panel-default panel_waiting_appeal">
        <div class="list_waiting">
          <div class="row no_data">
            <span class="no_data"><?=$txt_not_found?></span>
          </div>
      </div>
      </div>
  </div>
  <?php
  }
  ?>
  </div> <!-- waiting -->

  <div class="panel panel-default appeal_panel">
    <div class="panel-heading hr_appeal_panel_pending">
      <span class="hr_txt_pending"><?=$txt_Status?> : </span><span class="icon_pending"><img src="images/icon_pending.png"></span>
      <span class="all_pending"><a href="?page=all_appeal&status=2"><?=$txt_View_all?> > </a> </span>
    </div>
    <?php
    $sql_waitting = "SELECT * FROM `Case` WHERE caseCh_id in (0,1,2) AND case_status in (1,2) AND case_createBy_id = '".$_SESSION['member_id']."' $where_search ORDER BY case_id DESC LIMIT 0,5";
    $query_waitting = $conn->query($sql_waitting);
    if($query_waitting->num_rows > 0){
      while ($re = $query_waitting->fetch_assoc()) {
        $date_time = $re['case_create_datetime'];
        $date_time_ex = explode(" ",$date_time);
        $date_waitting = $date_time_ex[0];
        $time_waitting = $date_time_ex[1];
        $date_ex = explode("-",$date_waitting);
        $time_ex = explode(":",$time_waitting);
        $date = $date_ex[2]."/".$date_ex[1]."/".$date_ex[0];
        $time = $time_ex[0].".".$time_ex[1];
    ?>
    <div class="panel-body">
      <div class="panel panel-default panel_pending_appeal">
        <div class="list_pending">
          <div class="row">
            <div class="col-md-1 col-sm-2 col-xs-3 list_pending_icon">
              <?php
              $sql_process = "SELECT
              p.process_type_id,
              pt.process_type_step
              FROM `Process` AS p
              LEFT JOIN `Process_Type` AS pt ON p.process_type_id=pt.process_type_id
              WHERE p.case_id = '".$re['case_id']."' ORDER BY p.process_id DESC";
              $query_process = $conn->query($sql_process);
              if($query_process->num_rows > 0){
                $rs = $query_process->fetch_assoc();
                if($rs['process_type_step'] == 1){ ?>
                  <img src="images/icon_twf.png" class="icon_twf_appeal">
                <?php }elseif ($rs['process_type_step'] == 2) { ?>
                  <img src="images/icon_ft.png" class="icon_twf_appeal">
                <?php }elseif ($rs['process_type_step'] == 3) { ?>
                  <img src="images/icon_stf.png" class="icon_twf_appeal">
                <?php }
              }else {?>
                <img src="images/icon_twf.png" class="icon_twf_appeal">
              <?php }
              ?>
            </div>
            <div class="col-md-10 col-sm-8 col-xs-9 list_pending_detail">
              <span class="txt_app hr_appeal_detail_ex"><?=$txt_Petition_topic?> : <br></span><span class="txt_app hr_appeal_detail_er"><?php echo $re['caseDtl_title'];?><br></span><span class="txt_app"> | </span>
              <span class="txt_app hr_appeal_detail_ec"><?=$txt_Petitioner_company?> : <br></span><span class="txt_app"><?php echo $re['complnt_name'];?></span></p>
              <span class="icon_date"><img src="images/all_icon_DITP/icon_19.svg" style="width:15px;"></span><span class="pending_date"><?php echo $date;?></span>
              <span class="icon_time"><img src="images/all_icon_DITP/icon_21.svg" style="width:20px;"></span><span class="pending_time"><?php echo $time;?></span>
            </div>
            <div class="col-md-1 col-sm-2 list_pending_search"><span class="icon_search_detail"><a href="?page=appeal_detail&case_id=<?=$re['case_id'];?>"><img src="images/all_icon_DITP/icon_26.svg" style="width:40px;"></a></span></div>
          </div>
      </div>
      </div>
  </div>
  <?php
    }
  }else {?>
    <div class="panel-body">
      <div class="panel panel-default panel_pending_appeal">
        <div class="list_pending">
          <div class="row no_data">
            <span class="no_data"><?=$txt_not_found?></span>
          </div>
      </div>
      </div>
  </div>
  <?php
  }
  ?>
  </div> <!-- pending -->

  <div class="panel panel-default appeal_panel">
    <div class="panel-heading hr_appeal_panel_complete">
      <span class="hr_txt_complete"><?=$txt_Status?> : </span><span class="icon_complete"><img src="images/icon_complete.png"></span>
      <span class="all_complete"><a href="?page=all_appeal&status=3"><?=$txt_View_all?> > </a> </span>
    </div>
    <?php
    $sql_waitting = "SELECT * FROM `Case` WHERE caseCh_id in (0,1,2) AND case_status = '3' AND case_createBy_id = '".$_SESSION['member_id']."' $where_search ORDER BY case_id DESC LIMIT 0,5";
    $query_waitting = $conn->query($sql_waitting);
    if($query_waitting->num_rows > 0){
      while ($re = $query_waitting->fetch_assoc()) {
        $date_time = $re['case_create_datetime'];
        $date_time_ex = explode(" ",$date_time);
        $date_waitting = $date_time_ex[0];
        $time_waitting = $date_time_ex[1];
        $date_ex = explode("-",$date_waitting);
        $time_ex = explode(":",$time_waitting);
        $date = $date_ex[2]."/".$date_ex[1]."/".$date_ex[0];
        $time = $time_ex[0].".".$time_ex[1];
    ?>
    <div class="panel-body">
      <div class="panel panel-default panel_complete_appeal">
        <div class="list_complete">
          <div class="row">
            <div class="col-md-1 col-sm-2 col-xs-3 list_complete_icon">
              <img src="images/icon_oneh.png" class="icon_oneh_appeal">
            </div>
            <div class="col-md-10 col-sm-8 col-xs-9 list_complete_detail">
              <span class="txt_app hr_appeal_detail_ex"><?=$txt_Petition_topic?> : <br></span><span class="txt_app hr_appeal_detail_er"><?php echo $re['caseDtl_title'];?><br></span><span class="txt_app"> | </span>
              <span class="txt_app hr_appeal_detail_ec"><?=$txt_Petitioner_company?> : <br></span><span class="txt_app"><?php echo $re['complnt_name'];?></span></p>
              <span class="icon_date"><img src="images/all_icon_DITP/icon_19.svg" style="width:15px;"></span><span class="complete_date"><?php echo $date;?></span>
              <span class="icon_time"><img src="images/all_icon_DITP/icon_21.svg" style="width:20px;"></span><span class="complete_time"><?php echo $time;?></span>
            </div>
            <div class="col-md-1 col-sm-2 list_complete_search"><span class="icon_search_detail"><a href="?page=appeal_detail&case_id=<?=$re['case_id'];?>"><img src="images/all_icon_DITP/icon_26.svg" style="width:40px;"></a></span></div>
          </div>
      </div>
      </div>
  </div>
  <?php
    }
  }else {?>
    <div class="panel-body">
      <div class="panel panel-default panel_complete_appeal">
        <div class="list_complete">
          <div class="row no_data">
            <span class="no_data"><?=$txt_not_found?></span>
          </div>
      </div>
      </div>
  </div>
  <?php
  }
  ?>
  </div> <!-- complete -->
<?php }elseif ($status_filter == 1) { ?>
  <div class="panel panel-default appeal_panel">
    <div class="panel-heading hr_appeal_panel">
      <span class="hr_txt_waiting"><?=$txt_Status?> : </span><span class="icon_waiting"><img src="images/icon_waiting.png"></span>
      <span class="all_waiting"><a href="?page=all_appeal&status=1"><?=$txt_View_all?> > </a> </span>
    </div>
    <?php
    $sql_waitting = "SELECT * FROM `Case` WHERE caseCh_id in (0,1,2) AND case_status = '0' AND case_createBy_id = '".$_SESSION['member_id']."' $where_search ORDER BY case_id DESC LIMIT 0,5";
    $query_waitting = $conn->query($sql_waitting);
    if($query_waitting->num_rows > 0){
      while ($re = $query_waitting->fetch_assoc()) {
        $date_time = $re['case_create_datetime'];
        $date_time_ex = explode(" ",$date_time);
        $date_waitting = $date_time_ex[0];
        $time_waitting = $date_time_ex[1];
        $date_ex = explode("-",$date_waitting);
        $time_ex = explode(":",$time_waitting);
        $date = $date_ex[2]."/".$date_ex[1]."/".$date_ex[0];
        $time = $time_ex[0].".".$time_ex[1];
    ?>
    <div class="panel-body">
      <div class="panel panel-default panel_waiting_appeal">
        <div class="list_waiting">
          <div class="row">
            <div class="col-md-1 col-sm-2 col-xs-3 list_waiting_icon">
              <img src="images/icon_zero.png" class="icon_zero_appeal">
            </div>
            <div class="col-md-10 col-sm-8 col-xs-9 list_waiting_detail">
              <span class="txt_app hr_appeal_detail_ex"><?=$txt_Petition_topic?> : <br></span><span class="txt_app hr_appeal_detail_er"><?php echo $re['caseDtl_title'];?><br></span><span class="txt_app"> | </span>
              <span class="txt_app hr_appeal_detail_ec"><?=$txt_Petitioner_company?> : <br></span><span class="txt_app"<?php echo $re['complnt_name'];?></span></p>
              <span class="icon_date"><img src="images/all_icon_DITP/icon_19.svg" style="width:15px;"></span><span class="waiting_date"><?php echo $date;?></span>
              <span class="icon_time"><img src="images/all_icon_DITP/icon_21.svg" style="width:20px;"></span><span class="waiting_time"><?php echo $time;?></span>
            </div>
            <div class="col-md-1 col-sm-2 list_waiting_search"><span class="icon_search_detail"><a href="?page=appeal_detail&case_id=<?=$re['case_id'];?>"><img src="images/all_icon_DITP/icon_26.svg" style="width:40px;"></a></span></div>
          </div>
      </div>
      </div>
  </div>
  <?php
    }
  }else {?>
    <div class="panel-body">
      <div class="panel panel-default panel_waiting_appeal">
        <div class="list_waiting">
          <div class="row no_data">
            <span class="no_data"><?=$txt_not_found?></span>
          </div>
      </div>
      </div>
  </div>
  <?php
  }
  ?>
  </div> <!-- waiting -->
<?php }elseif ($status_filter == 2) {?>
  <div class="panel panel-default appeal_panel">
    <div class="panel-heading hr_appeal_panel_pending">
      <span class="hr_txt_pending"><?=$txt_Status?> : </span><span class="icon_pending"><img src="images/icon_pending.png"></span>
      <span class="all_pending"><a href="?page=all_appeal&status=2"><?=$txt_View_all?> > </a> </span>
    </div>
    <?php
    $sql_waitting = "SELECT * FROM `Case` WHERE caseCh_id in (0,1,2) AND case_status in (1,2) AND case_createBy_id = '".$_SESSION['member_id']."' $where_search ORDER BY case_id DESC LIMIT 0,5";
    $query_waitting = $conn->query($sql_waitting);
    if($query_waitting->num_rows > 0){
      while ($re = $query_waitting->fetch_assoc()) {
        $date_time = $re['case_create_datetime'];
        $date_time_ex = explode(" ",$date_time);
        $date_waitting = $date_time_ex[0];
        $time_waitting = $date_time_ex[1];
        $date_ex = explode("-",$date_waitting);
        $time_ex = explode(":",$time_waitting);
        $date = $date_ex[2]."/".$date_ex[1]."/".$date_ex[0];
        $time = $time_ex[0].".".$time_ex[1];
    ?>
    <div class="panel-body">
      <div class="panel panel-default panel_pending_appeal">
        <div class="list_pending">
          <div class="row">
            <div class="col-md-1 col-sm-2 col-xs-3 list_pending_icon">
              <?php
              $sql_process = "SELECT
              p.process_type_id,
              pt.process_type_step
              FROM `Process` AS p
              LEFT JOIN `Process_Type` AS pt ON p.process_type_id=pt.process_type_id
              WHERE p.case_id = '".$re['case_id']."' ORDER BY p.process_id DESC";
              $query_process = $conn->query($sql_process);
              if($query_process->num_rows > 0){
                $rs = $query_process->fetch_assoc();
                if($rs['process_type_step'] == 1){ ?>
                  <img src="images/icon_twf.png" class="icon_twf_appeal">
                <?php }elseif ($rs['process_type_step'] == 2) { ?>
                  <img src="images/icon_ft.png" class="icon_twf_appeal">
                <?php }elseif ($rs['process_type_step'] == 3) { ?>
                  <img src="images/icon_stf.png" class="icon_twf_appeal">
                <?php }
              }else {?>
                <img src="images/icon_twf.png" class="icon_twf_appeal">
              <?php }
              ?>
            </div>
            <div class="col-md-10 col-sm-8 col-xs-9 list_pending_detail">
              <span class="txt_app hr_appeal_detail_ex"><?=$txt_Petition_topic?> : <br></span><span class="txt_app hr_appeal_detail_er"><?php echo $re['caseDtl_title'];?><br></span><span class="txt_app"> | </span>
              <span class="txt_app hr_appeal_detail_ec"><?=$txt_Petitioner_company?> : <br></span><span class="txt_app"><?php echo $re['complnt_name'];?></span></p>
              <span class="icon_date"><img src="images/all_icon_DITP/icon_19.svg" style="width:15px;"></span><span class="pending_date"><?php echo $date;?></span>
              <span class="icon_time"><img src="images/all_icon_DITP/icon_21.svg" style="width:20px;"></span><span class="pending_time"><?php echo $time;?></span>
            </div>
            <div class="col-md-1 col-sm-2 list_pending_search"><span class="icon_search_detail"><a href="?page=appeal_detail&case_id=<?=$re['case_id'];?>"><img src="images/all_icon_DITP/icon_26.svg" style="width:40px;"></a></span></div>
          </div>
      </div>
      </div>
  </div>
  <?php
    }
  }else {?>
    <div class="panel-body">
      <div class="panel panel-default panel_pending_appeal">
        <div class="list_pending">
          <div class="row no_data">
            <span class="no_data"><?=$txt_not_found?></span>
          </div>
      </div>
      </div>
  </div>
  <?php
  }
  ?>
  </div> <!-- pending -->
<?php }elseif ($status_filter == 3) { ?>
  <div class="panel panel-default appeal_panel">
    <div class="panel-heading hr_appeal_panel_complete">
      <span class="hr_txt_complete"><?=$txt_Status?> : </span><span class="icon_complete"><img src="images/icon_complete.png"></span>
      <span class="all_complete"><a href="?page=all_appeal&status=3"><?=$txt_View_all?> > </a> </span>
    </div>
    <?php
    $sql_waitting = "SELECT * FROM `Case` WHERE caseCh_id in (0,1,2) AND case_status = '3' AND case_createBy_id = '".$_SESSION['member_id']."' $where_search ORDER BY case_id DESC LIMIT 0,5";
    $query_waitting = $conn->query($sql_waitting);
    if($query_waitting->num_rows > 0){
      while ($re = $query_waitting->fetch_assoc()) {
        $date_time = $re['case_create_datetime'];
        $date_time_ex = explode(" ",$date_time);
        $date_waitting = $date_time_ex[0];
        $time_waitting = $date_time_ex[1];
        $date_ex = explode("-",$date_waitting);
        $time_ex = explode(":",$time_waitting);
        $date = $date_ex[2]."/".$date_ex[1]."/".$date_ex[0];
        $time = $time_ex[0].".".$time_ex[1];
    ?>
    <div class="panel-body">
      <div class="panel panel-default panel_complete_appeal">
        <div class="list_complete">
          <div class="row">
            <div class="col-md-1 col-sm-2 col-xs-3 list_complete_icon">
              <img src="images/icon_oneh.png" class="icon_oneh_appeal">
            </div>
            <div class="col-md-10 col-sm-8 col-xs-9 list_complete_detail">
              <span class="txt_app hr_appeal_detail_ex"><?=$txt_Petition_topic?> : <br></span><span class="txt_app hr_appeal_detail_er"><?php echo $re['caseDtl_title'];?><br></span><span class="txt_app"> | </span>
              <span class="txt_app hr_appeal_detail_ec"><?=$txt_Petitioner_company?> : <br></span><span class="txt_app"><?php echo $re['complnt_name'];?></span></p>
              <span class="icon_date"><img src="images/all_icon_DITP/icon_19.svg" style="width:15px;"></span><span class="complete_date"><?php echo $date;?></span>
              <span class="icon_time"><img src="images/all_icon_DITP/icon_21.svg" style="width:20px;"></span><span class="complete_time"><?php echo $time;?></span>
            </div>
            <div class="col-md-1 col-sm-2 list_complete_search"><span class="icon_search_detail"><a href="?page=appeal_detail&case_id=<?=$re['case_id'];?>"><img src="images/all_icon_DITP/icon_26.svg" style="width:40px;"></a></span></div>
          </div>
      </div>
      </div>
  </div>
  <?php
    }
  }else {?>
    <div class="panel-body">
      <div class="panel panel-default panel_complete_appeal">
        <div class="list_complete">
          <div class="row no_data">
            <span class="no_data"><?=$txt_not_found?></span>
          </div>
      </div>
      </div>
  </div>
  <?php
  }
  ?>
  </div> <!-- complete -->
<?}
exit();
}

if($_POST['method'] == "filter_appeal_search"){
include('config/config.php');
include('lang.php');
$status_filter = $_POST['chk_status'];
$txt_search = $_POST['txt_search'];
if($txt_search == ""){
  $where_search = "";
}else {
  $where_search = "AND (caseDtl_title LIKE '%$txt_search%' OR complnt_name LIKE '%$txt_search%')";
}
if($status_filter == 0){?>
  <div class="panel panel-default appeal_panel">
    <div class="panel-heading hr_appeal_panel">
      <span class="hr_txt_waiting"><?=$txt_Status?> : </span><span class="icon_waiting"><img src="images/icon_waiting.png"></span>
      <span class="all_waiting"><a href="?page=all_appeal&status=1"><?=$txt_View_all?> > </a></span>
    </div>
    <?php
    $sql_waitting = "SELECT * FROM `Case` WHERE caseCh_id in (0,1,2) AND case_status = '0' AND case_createBy_id = '".$_SESSION['member_id']."' $where_search ORDER BY case_id DESC";
    $query_waitting = $conn->query($sql_waitting);
    if($query_waitting->num_rows > 0){
      while ($re = $query_waitting->fetch_assoc()) {
        $date_time = $re['case_create_datetime'];
        $date_time_ex = explode(" ",$date_time);
        $date_waitting = $date_time_ex[0];
        $time_waitting = $date_time_ex[1];
        $date_ex = explode("-",$date_waitting);
        $time_ex = explode(":",$time_waitting);
        $date = $date_ex[2]."/".$date_ex[1]."/".$date_ex[0];
        $time = $time_ex[0].".".$time_ex[1];
    ?>
    <div class="panel-body">
      <div class="panel panel-default panel_waiting_appeal">
        <div class="list_waiting">
          <div class="row">
            <div class="col-md-1 col-sm-2 col-xs-3 list_waiting_icon">
              <img src="images/icon_zero.png" class="icon_zero_appeal">
            </div>
            <div class="col-md-10 col-sm-8 col-xs-9 list_waiting_detail">
              <span class="txt_app hr_appeal_detail_ex"><?=$txt_Petition_topic?> : <br></span><span class="txt_app hr_appeal_detail_er"><?php echo $re['caseDtl_title'];?><br></span><span class="txt_app"> | </span>
              <span class="txt_app hr_appeal_detail_ec"><?=$txt_Petitioner_company?> : <br></span><span class="txt_app"><?php echo $re['complnt_name'];?></span></p>
              <span class="icon_date"><img src="images/all_icon_DITP/icon_19.svg" style="width:15px;"></span><span class="waiting_date"><?php echo $date;?></span>
              <span class="icon_time"><img src="images/all_icon_DITP/icon_21.svg" style="width:20px;"></span><span class="waiting_time"><?php echo $time;?></span>
            </div>
            <div class="col-md-1 col-sm-2 list_waiting_search"><span class="icon_search_detail"><a href="?page=appeal_detail&case_id=<?=$re['case_id'];?>"><img src="images/all_icon_DITP/icon_26.svg" style="width:40px;"></a></span></div>
          </div>
      </div>
      </div>
  </div>
  <?php
    }
  }else {?>
    <div class="panel-body">
      <div class="panel panel-default panel_waiting_appeal">
        <div class="list_waiting">
          <div class="row no_data">
            <span class="no_data"><?=$txt_not_found?></span>
          </div>
      </div>
      </div>
  </div>
  <?php
  }
  ?>
  </div> <!-- waiting -->

  <div class="panel panel-default appeal_panel">
    <div class="panel-heading hr_appeal_panel_pending">
      <span class="hr_txt_pending"><?=$txt_Status?> : </span><span class="icon_pending"><img src="images/icon_pending.png"></span>
      <span class="all_pending"><a href="?page=all_appeal&status=2"><?=$txt_View_all?> > </a> </span>
    </div>
    <?php
    $sql_waitting = "SELECT * FROM `Case` WHERE caseCh_id in (0,1,2) AND case_status in (1,2) AND case_createBy_id = '".$_SESSION['member_id']."' $where_search ORDER BY case_id DESC";
    $query_waitting = $conn->query($sql_waitting);
    if($query_waitting->num_rows > 0){
      while ($re = $query_waitting->fetch_assoc()) {
        $date_time = $re['case_create_datetime'];
        $date_time_ex = explode(" ",$date_time);
        $date_waitting = $date_time_ex[0];
        $time_waitting = $date_time_ex[1];
        $date_ex = explode("-",$date_waitting);
        $time_ex = explode(":",$time_waitting);
        $date = $date_ex[2]."/".$date_ex[1]."/".$date_ex[0];
        $time = $time_ex[0].".".$time_ex[1];
    ?>
    <div class="panel-body">
      <div class="panel panel-default panel_pending_appeal">
        <div class="list_pending">
          <div class="row">
            <div class="col-md-1 col-sm-2 col-xs-3 list_pending_icon">
              <?php
              $sql_process = "SELECT
              p.process_type_id,
              pt.process_type_step
              FROM `Process` AS p
              LEFT JOIN `Process_Type` AS pt ON p.process_type_id=pt.process_type_id
              WHERE p.case_id = '".$re['case_id']."' ORDER BY p.process_id DESC";
              $query_process = $conn->query($sql_process);
              if($query_process->num_rows > 0){
                $rs = $query_process->fetch_assoc();
                if($rs['process_type_step'] == 1){ ?>
                  <img src="images/icon_twf.png" class="icon_twf_appeal">
                <?php }elseif ($rs['process_type_step'] == 2) { ?>
                  <img src="images/icon_ft.png" class="icon_twf_appeal">
                <?php }elseif ($rs['process_type_step'] == 3) { ?>
                  <img src="images/icon_stf.png" class="icon_twf_appeal">
                <?php }
              }else {?>
                <img src="images/icon_twf.png" class="icon_twf_appeal">
              <?php }
              ?>
            </div>
            <div class="col-md-10 col-sm-8 col-xs-9 list_pending_detail">
              <span class="txt_app hr_appeal_detail_ex"><?=$txt_Petition_topic?> : <br></span><span class="txt_app hr_appeal_detail_er"><?php echo $re['caseDtl_title'];?><br></span><span class="txt_app"> | </span>
              <span class="txt_app hr_appeal_detail_ec"><?=$txt_Petitioner_company?> : <br></span><span class="txt_app"><?php echo $re['complnt_name'];?></span></p>
              <span class="icon_date"><img src="images/all_icon_DITP/icon_19.svg" style="width:15px;"></span><span class="pending_date"><?php echo $date;?></span>
              <span class="icon_time"><img src="images/all_icon_DITP/icon_21.svg" style="width:20px;"></span><span class="pending_time"><?php echo $time;?></span>
            </div>
            <div class="col-md-1 col-sm-2 list_pending_search"><span class="icon_search_detail"><a href="?page=appeal_detail&case_id=<?=$re['case_id'];?>"><img src="images/all_icon_DITP/icon_26.svg" style="width:40px;"></a></span></div>
          </div>
      </div>
      </div>
  </div>
  <?php
    }
  }else {?>
    <div class="panel-body">
      <div class="panel panel-default panel_pending_appeal">
        <div class="list_pending">
          <div class="row no_data">
            <span class="no_data"><?=$txt_not_found?></span>
          </div>
      </div>
      </div>
  </div>
  <?php
  }
  ?>
  </div> <!-- pending -->

  <div class="panel panel-default appeal_panel">
    <div class="panel-heading hr_appeal_panel_complete">
      <span class="hr_txt_complete"><?=$txt_Status?> : </span><span class="icon_complete"><img src="images/icon_complete.png"></span>
      <span class="all_complete"><a href="?page=all_appeal&status=3"><?=$txt_View_all?> > </a> </span>
    </div>
    <?php
    $sql_waitting = "SELECT * FROM `Case` WHERE caseCh_id in (0,1,2) AND case_status = '3' AND case_createBy_id = '".$_SESSION['member_id']."' $where_search ORDER BY case_id DESC";
    $query_waitting = $conn->query($sql_waitting);
    if($query_waitting->num_rows > 0){
      while ($re = $query_waitting->fetch_assoc()) {
        $date_time = $re['case_create_datetime'];
        $date_time_ex = explode(" ",$date_time);
        $date_waitting = $date_time_ex[0];
        $time_waitting = $date_time_ex[1];
        $date_ex = explode("-",$date_waitting);
        $time_ex = explode(":",$time_waitting);
        $date = $date_ex[2]."/".$date_ex[1]."/".$date_ex[0];
        $time = $time_ex[0].".".$time_ex[1];
    ?>
    <div class="panel-body">
      <div class="panel panel-default panel_complete_appeal">
        <div class="list_complete">
          <div class="row">
            <div class="col-md-1 col-sm-2 col-xs-3 list_complete_icon">
              <img src="images/icon_oneh.png" class="icon_oneh_appeal">
            </div>
            <div class="col-md-10 col-sm-8 col-xs-9 list_complete_detail">
              <span class="txt_app hr_appeal_detail_ex"><?=$txt_Petition_topic?> : <br></span><span class="txt_app hr_appeal_detail_er"><?php echo $re['caseDtl_title'];?><br></span><span class="txt_app"> | </span>
              <span class="txt_app hr_appeal_detail_ec"><?=$txt_Petitioner_company?> : <br></span><span class="txt_app"><?php echo $re['complnt_name'];?></span></p>
              <span class="icon_date"><img src="images/all_icon_DITP/icon_19.svg" style="width:15px;"></span><span class="complete_date"><?php echo $date;?></span>
              <span class="icon_time"><img src="images/all_icon_DITP/icon_21.svg" style="width:20px;"></span><span class="complete_time"><?php echo $time;?></span>
            </div>
            <div class="col-md-1 col-sm-2 list_complete_search"><span class="icon_search_detail"><a href="?page=appeal_detail&case_id=<?=$re['case_id'];?>"><img src="images/all_icon_DITP/icon_26.svg" style="width:40px;"></a></span></div>
          </div>
      </div>
      </div>
  </div>
  <?php
    }
  }else {?>
    <div class="panel-body">
      <div class="panel panel-default panel_complete_appeal">
        <div class="list_complete">
          <div class="row no_data">
            <span class="no_data"><?=$txt_not_found?></span>
          </div>
      </div>
      </div>
  </div>
  <?php
  }
  ?>
  </div> <!-- complete -->
<?php }elseif ($status_filter == 1) { ?>
  <div class="panel panel-default appeal_panel">
    <div class="panel-heading hr_appeal_panel">
      <span class="hr_txt_waiting"><?=$txt_Status?> : </span><span class="icon_waiting"><img src="images/icon_waiting.png"></span>
      <span class="all_waiting"><a href="?page=all_appeal&status=1"><?=$txt_View_all?> > </a> </span>
    </div>
    <?php
    $sql_waitting = "SELECT * FROM `Case` WHERE caseCh_id in (0,1,2) AND case_status = '0' AND case_createBy_id = '".$_SESSION['member_id']."' $where_search ORDER BY case_id DESC";
    $query_waitting = $conn->query($sql_waitting);
    if($query_waitting->num_rows > 0){
      while ($re = $query_waitting->fetch_assoc()) {
        $date_time = $re['case_create_datetime'];
        $date_time_ex = explode(" ",$date_time);
        $date_waitting = $date_time_ex[0];
        $time_waitting = $date_time_ex[1];
        $date_ex = explode("-",$date_waitting);
        $time_ex = explode(":",$time_waitting);
        $date = $date_ex[2]."/".$date_ex[1]."/".$date_ex[0];
        $time = $time_ex[0].".".$time_ex[1];
    ?>
    <div class="panel-body">
      <div class="panel panel-default panel_waiting_appeal">
        <div class="list_waiting">
          <div class="row">
            <div class="col-md-1 col-sm-2 col-xs-3 list_waiting_icon">
              <img src="images/icon_zero.png" class="icon_zero_appeal">
            </div>
            <div class="col-md-10 col-sm-8 col-xs-9 list_waiting_detail">
              <span class="txt_app hr_appeal_detail_ex"><?=$txt_Petition_topic?> : <br></span><span class="txt_app hr_appeal_detail_er"><?php echo $re['caseDtl_title'];?><br></span><span class="txt_app"> | </span>
              <span class="txt_app hr_appeal_detail_ec"><?=$txt_Petitioner_company?> : <br></span><span class="txt_app"<?php echo $re['complnt_name'];?></span></p>
              <span class="icon_date"><img src="images/all_icon_DITP/icon_19.svg" style="width:15px;"></span><span class="waiting_date"><?php echo $date;?></span>
              <span class="icon_time"><img src="images/all_icon_DITP/icon_21.svg" style="width:20px;"></span><span class="waiting_time"><?php echo $time;?></span>
            </div>
            <div class="col-md-1 col-sm-2 list_waiting_search"><span class="icon_search_detail"><a href="?page=appeal_detail&case_id=<?=$re['case_id'];?>"><img src="images/all_icon_DITP/icon_26.svg" style="width:40px;"></a></span></div>
          </div>
      </div>
      </div>
  </div>
  <?php
    }
  }else {?>
    <div class="panel-body">
      <div class="panel panel-default panel_waiting_appeal">
        <div class="list_waiting">
          <div class="row no_data">
            <span class="no_data"><?=$txt_not_found?></span>
          </div>
      </div>
      </div>
  </div>
  <?php
  }
  ?>
  </div> <!-- waiting -->
<?php }elseif ($status_filter == 2) {?>
  <div class="panel panel-default appeal_panel">
    <div class="panel-heading hr_appeal_panel_pending">
      <span class="hr_txt_pending"><?=$txt_Status?> : </span><span class="icon_pending"><img src="images/icon_pending.png"></span>
      <span class="all_pending"><a href="?page=all_appeal&status=2"><?=$txt_View_all?> > </a> </span>
    </div>
    <?php
    $sql_waitting = "SELECT * FROM `Case` WHERE caseCh_id in (0,1,2) AND case_status in (1,2) AND case_createBy_id = '".$_SESSION['member_id']."' $where_search ORDER BY case_id DESC";
    $query_waitting = $conn->query($sql_waitting);
    if($query_waitting->num_rows > 0){
      while ($re = $query_waitting->fetch_assoc()) {
        $date_time = $re['case_create_datetime'];
        $date_time_ex = explode(" ",$date_time);
        $date_waitting = $date_time_ex[0];
        $time_waitting = $date_time_ex[1];
        $date_ex = explode("-",$date_waitting);
        $time_ex = explode(":",$time_waitting);
        $date = $date_ex[2]."/".$date_ex[1]."/".$date_ex[0];
        $time = $time_ex[0].".".$time_ex[1];
    ?>
    <div class="panel-body">
      <div class="panel panel-default panel_pending_appeal">
        <div class="list_pending">
          <div class="row">
            <div class="col-md-1 col-sm-2 col-xs-3 list_pending_icon">
              <?php
              $sql_process = "SELECT
              p.process_type_id,
              pt.process_type_step
              FROM `Process` AS p
              LEFT JOIN `Process_Type` AS pt ON p.process_type_id=pt.process_type_id
              WHERE p.case_id = '".$re['case_id']."' ORDER BY p.process_id DESC";
              $query_process = $conn->query($sql_process);
              if($query_process->num_rows > 0){
                $rs = $query_process->fetch_assoc();
                if($rs['process_type_step'] == 1){ ?>
                  <img src="images/icon_twf.png" class="icon_twf_appeal">
                <?php }elseif ($rs['process_type_step'] == 2) { ?>
                  <img src="images/icon_ft.png" class="icon_twf_appeal">
                <?php }elseif ($rs['process_type_step'] == 3) { ?>
                  <img src="images/icon_stf.png" class="icon_twf_appeal">
                <?php }
              }else {?>
                <img src="images/icon_twf.png" class="icon_twf_appeal">
              <?php }
              ?>
            </div>
            <div class="col-md-10 col-sm-8 col-xs-9 list_pending_detail">
              <span class="txt_app hr_appeal_detail_ex"><?=$txt_Petition_topic?> : <br></span><span class="txt_app hr_appeal_detail_er"><?php echo $re['caseDtl_title'];?><br></span><span class="txt_app"> | </span>
              <span class="txt_app hr_appeal_detail_ec"><?=$txt_Petitioner_company?> : <br></span><span class="txt_app"><?php echo $re['complnt_name'];?></span></p>
              <span class="icon_date"><img src="images/all_icon_DITP/icon_19.svg" style="width:15px;"></span><span class="pending_date"><?php echo $date;?></span>
              <span class="icon_time"><img src="images/all_icon_DITP/icon_21.svg" style="width:20px;"></span><span class="pending_time"><?php echo $time;?></span>
            </div>
            <div class="col-md-1 col-sm-2 list_pending_search"><span class="icon_search_detail"><a href="?page=appeal_detail&case_id=<?=$re['case_id'];?>"><img src="images/all_icon_DITP/icon_26.svg" style="width:40px;"></a></span></div>
          </div>
      </div>
      </div>
  </div>
  <?php
    }
  }else {?>
    <div class="panel-body">
      <div class="panel panel-default panel_pending_appeal">
        <div class="list_pending">
          <div class="row no_data">
            <span class="no_data"><?=$txt_not_found?></span>
          </div>
      </div>
      </div>
  </div>
  <?php
  }
  ?>
  </div> <!-- pending -->
<?php }elseif ($status_filter == 3) { ?>
  <div class="panel panel-default appeal_panel">
    <div class="panel-heading hr_appeal_panel_complete">
      <span class="hr_txt_complete"><?=$txt_Status?> : </span><span class="icon_complete"><img src="images/icon_complete.png"></span>
      <span class="all_complete"><a href="?page=all_appeal&status=3"><?=$txt_View_all?> > </a> </span>
    </div>
    <?php
    $sql_waitting = "SELECT * FROM `Case` WHERE caseCh_id in (0,1,2) AND case_status = '3' AND case_createBy_id = '".$_SESSION['member_id']."' $where_search ORDER BY case_id DESC";
    $query_waitting = $conn->query($sql_waitting);
    if($query_waitting->num_rows > 0){
      while ($re = $query_waitting->fetch_assoc()) {
        $date_time = $re['case_create_datetime'];
        $date_time_ex = explode(" ",$date_time);
        $date_waitting = $date_time_ex[0];
        $time_waitting = $date_time_ex[1];
        $date_ex = explode("-",$date_waitting);
        $time_ex = explode(":",$time_waitting);
        $date = $date_ex[2]."/".$date_ex[1]."/".$date_ex[0];
        $time = $time_ex[0].".".$time_ex[1];
    ?>
    <div class="panel-body">
      <div class="panel panel-default panel_complete_appeal">
        <div class="list_complete">
          <div class="row">
            <div class="col-md-1 col-sm-2 col-xs-3 list_complete_icon">
              <img src="images/icon_oneh.png" class="icon_oneh_appeal">
            </div>
            <div class="col-md-10 col-sm-8 col-xs-9 list_complete_detail">
              <span class="txt_app hr_appeal_detail_ex"><?=$txt_Petition_topic?> : <br></span><span class="txt_app hr_appeal_detail_er"><?php echo $re['caseDtl_title'];?><br></span><span class="txt_app"> | </span>
              <span class="txt_app hr_appeal_detail_ec"><?=$txt_Petitioner_company?> : <br></span><span class="txt_app"><?php echo $re['complnt_name'];?></span></p>
              <span class="icon_date"><img src="images/all_icon_DITP/icon_19.svg" style="width:15px;"></span><span class="complete_date"><?php echo $date;?></span>
              <span class="icon_time"><img src="images/all_icon_DITP/icon_21.svg" style="width:20px;"></span><span class="complete_time"><?php echo $time;?></span>
            </div>
            <div class="col-md-1 col-sm-2 list_complete_search"><span class="icon_search_detail"><a href="?page=appeal_detail&case_id=<?=$re['case_id'];?>"><img src="images/all_icon_DITP/icon_26.svg" style="width:40px;"></a></span></div>
          </div>
      </div>
      </div>
  </div>
  <?php
    }
  }else {?>
    <div class="panel-body">
      <div class="panel panel-default panel_complete_appeal">
        <div class="list_complete">
          <div class="row no_data">
            <span class="no_data"><?=$txt_not_found?></span>
          </div>
      </div>
      </div>
  </div>
  <?php
  }
  ?>
  </div> <!-- complete -->
<?}
exit();
}
?>






<div class="row appeal_div_row">
  <div class="col-md-12">
    <span class="icon_hr_appeal"><img src="images/all_icon_DITP/icon_6.svg" style="width:30px;" class="icon_appeal"></span>
    <span class="txt_hr_appeal"><?php if($lang == "1"){ echo "เรื่องร้องเรียนของคุณ";}elseif($lang == "2"){ echo "Your complaint";}else{ echo "เรื่องร้องเรียนของคุณ";}?></span>

    <div class="row div_status_appeal">
       <div class="col-md-6 col-sm-6 col-xs-12"><span><?=$txt_Status?> : </span>
         <select class="form-control selectpicker sel_status_appeal" id="sel_status_appeal" onchange="sel_status_appeal();">
           <option value="0"><?php if($lang == "1"){ echo "ทั้งหมด";}elseif($lang == "2"){ echo "All";}else{ echo "ทั้งหมด";}?></option>
           <option value="1">Waiting</option>
           <option value="2">In Process</option>
           <option value="3">Complete</option>
         </select>
         <!-- <span><img src="images/icon_search.png" onclick="sel_status_appeal();"></span> -->
       </div>
       <div class="col-md-6 col-sm-6 col-xs-12">
         <div class="input-group appeal_search">
          <input type="text" class="form-control search_text" placeholder="<?php if($lang == "1"){ echo "ค้นหา";}elseif($lang == "2"){ echo "Search";}else{ echo "ค้นหา";}?>" name="search_text" onkeypress="search_appeal_enter(event);" style="border-right-width: 0px;">
          <span class="input-group-addon bg-black btn-click-search">
            <i class="glyphicon glyphicon-search" onclick="search_appeal();"></i>
          </span>
        </div>
       </div>
    </div>
<div class="appeal_center_filter">
</div>
<div class="appeal_center">
  <div class="panel panel-default appeal_panel">
    <div class="panel-heading hr_appeal_panel">
      <span class="hr_txt_waiting"><?=$txt_Status?> : </span><span class="icon_waiting"><img src="images/icon_waiting.png"></span>
      <span class="all_waiting"><a href="?page=all_appeal&status=1"><?=$txt_View_all?> > </a> </span>
    </div>
    <?php
    $sql_waitting = "SELECT * FROM `Case` WHERE caseCh_id in (0,1,2) AND case_status = '0' AND case_createBy_id = '".$_SESSION['member_id']."' ORDER BY case_id DESC LIMIT 0,5";
    $query_waitting = $conn->query($sql_waitting);
    if($query_waitting->num_rows > 0){
      while ($re = $query_waitting->fetch_assoc()) {
        $date_time = $re['case_create_datetime'];
        $date_time_ex = explode(" ",$date_time);
        $date_waitting = $date_time_ex[0];
        $time_waitting = $date_time_ex[1];
        $date_ex = explode("-",$date_waitting);
        $time_ex = explode(":",$time_waitting);
        $date = $date_ex[2]."/".$date_ex[1]."/".$date_ex[0];
        $time = $time_ex[0].".".$time_ex[1];
    ?>
    <div class="panel-body">
      <div class="panel panel-default panel_waiting_appeal">
        <div class="list_waiting">
          <div class="row">
            <div class="col-md-1 col-sm-2 col-xs-3 list_waiting_icon">
              <img src="images/icon_zero.png" class="icon_zero_appeal">
            </div>
            <div class="col-md-10 col-sm-8 col-xs-9 list_waiting_detail">
              <span class="txt_app hr_appeal_detail_ex"><?=$txt_Petition_topic?> : <br></span><span class="txt_app hr_appeal_detail_er"><?php echo $re['caseDtl_title'];?><br></span><span class="txt_app slot_appeal"> | </span>
              <span class="txt_app hr_appeal_detail_ec"><?=$txt_Petitioner_company?> : <br></span><span class="txt_app"><?php echo $re['complnt_name'];?></span></p>
              <span class="icon_date"><img src="images/all_icon_DITP/icon_19.svg" style="width:15px;"></span><span class="waiting_date"><?php echo $date;?></span>
              <span class="icon_time"><img src="images/all_icon_DITP/icon_21.svg" style="width:20px;"></span><span class="waiting_time"><?php echo $time;?></span>
            </div>
            <div class="col-md-1 col-sm-2 list_waiting_search"><span class="icon_search_detail"><a href="?page=appeal_detail&case_id=<?=$re['case_id'];?>"><img src="images/all_icon_DITP/icon_26.svg" style="width:40px;"></a></span></div>
          </div>
      </div>
      </div>
  </div>
  <?php
    }
  }else {?>
    <div class="panel-body">
      <div class="panel panel-default panel_waiting_appeal">
        <div class="list_waiting">
          <div class="row no_data">
            <span class="no_data"><?=$txt_not_found?></span>
          </div>
      </div>
      </div>
  </div>
  <?php
  }
  ?>
  </div> <!-- waiting -->

  <div class="panel panel-default appeal_panel">
    <div class="panel-heading hr_appeal_panel_pending">
      <span class="hr_txt_pending"><?=$txt_Status?> : </span><span class="icon_pending"><img src="images/icon_pending.png"></span>
      <span class="all_pending"><a href="?page=all_appeal&status=2"><?=$txt_View_all?> > </a> </span>
    </div>
    <?php
    $sql_waitting = "SELECT * FROM `Case` WHERE caseCh_id in (0,1,2) AND case_status in (1,2) AND case_createBy_id = '".$_SESSION['member_id']."' ORDER BY case_id DESC LIMIT 0,5";
    $query_waitting = $conn->query($sql_waitting);
    if($query_waitting->num_rows > 0){
      while ($re = $query_waitting->fetch_assoc()) {
        $date_time = $re['case_create_datetime'];
        $date_time_ex = explode(" ",$date_time);
        $date_waitting = $date_time_ex[0];
        $time_waitting = $date_time_ex[1];
        $date_ex = explode("-",$date_waitting);
        $time_ex = explode(":",$time_waitting);
        $date = $date_ex[2]."/".$date_ex[1]."/".$date_ex[0];
        $time = $time_ex[0].".".$time_ex[1];
    ?>
    <div class="panel-body">
      <div class="panel panel-default panel_pending_appeal">
        <div class="list_pending">
          <div class="row">
            <div class="col-md-1 col-sm-2 col-xs-3 list_pending_icon">
              <?php
              $sql_process = "SELECT
              p.process_type_id,
              pt.process_type_step
              FROM `Process` AS p
              LEFT JOIN `Process_Type` AS pt ON p.process_type_id=pt.process_type_id
              WHERE p.case_id = '".$re['case_id']."' ORDER BY p.process_id DESC";
              $query_process = $conn->query($sql_process);
              if($query_process->num_rows > 0){
                $rs = $query_process->fetch_assoc();
                if($rs['process_type_step'] == 1){ ?>
                  <img src="images/icon_twf.png" class="icon_twf_appeal">
                <?php }elseif ($rs['process_type_step'] == 2) { ?>
                  <img src="images/icon_ft.png" class="icon_twf_appeal">
                <?php }elseif ($rs['process_type_step'] == 3) { ?>
                  <img src="images/icon_stf.png" class="icon_twf_appeal">
                <?php }
              }else {?>
                <img src="images/icon_twf.png" class="icon_twf_appeal">
              <?php }
              ?>
            </div>
            <div class="col-md-10 col-sm-8 col-xs-9 list_pending_detail">
              <span class="txt_app hr_appeal_detail_ex"><?=$txt_Petition_topic?> : <br></span><span class="txt_app hr_appeal_detail_er"><?php echo $re['caseDtl_title'];?><br></span><span class="txt_app slot_appeal"> | </span>
              <span class="txt_app hr_appeal_detail_ec"><?=$txt_Petitioner_company?> : <br></span><span class="txt_app"><?php echo $re['complnt_name'];?></span></p>
              <span class="icon_date"><img src="images/all_icon_DITP/icon_19.svg" style="width:15px;"></span><span class="pending_date"><?php echo $date;?></span>
              <span class="icon_time"><img src="images/all_icon_DITP/icon_21.svg" style="width:20px;"></span><span class="pending_time"><?php echo $time;?></span>
            </div>
            <div class="col-md-1 col-sm-2 list_pending_search"><span class="icon_search_detail"><a href="?page=appeal_detail&case_id=<?=$re['case_id'];?>"><img src="images/all_icon_DITP/icon_26.svg" style="width:40px;"></a></span></div>
          </div>
      </div>
      </div>
  </div>
  <?php
    }
  }else {?>
    <div class="panel-body">
      <div class="panel panel-default panel_pending_appeal">
        <div class="list_pending">
          <div class="row no_data">
            <span class="no_data"><?=$txt_not_found?></span>
          </div>
      </div>
      </div>
  </div>
  <?php
  }
  ?>
  </div> <!-- pending -->

  <div class="panel panel-default appeal_panel">
    <div class="panel-heading hr_appeal_panel_complete">
      <span class="hr_txt_complete"><?=$txt_Status?> : </span><span class="icon_complete"><img src="images/icon_complete.png"></span>
      <span class="all_complete"><a href="?page=all_appeal&status=3"><?=$txt_View_all?> > </a> </span>
    </div>
    <?php
    $sql_waitting = "SELECT * FROM `Case` WHERE caseCh_id in (0,1,2) AND case_status = '3' AND case_createBy_id = '".$_SESSION['member_id']."' ORDER BY case_id DESC LIMIT 0,5";
    $query_waitting = $conn->query($sql_waitting);
    if($query_waitting->num_rows > 0){
      while ($re = $query_waitting->fetch_assoc()) {
        $date_time = $re['case_create_datetime'];
        $date_time_ex = explode(" ",$date_time);
        $date_waitting = $date_time_ex[0];
        $time_waitting = $date_time_ex[1];
        $date_ex = explode("-",$date_waitting);
        $time_ex = explode(":",$time_waitting);
        $date = $date_ex[2]."/".$date_ex[1]."/".$date_ex[0];
        $time = $time_ex[0].".".$time_ex[1];
    ?>
    <div class="panel-body">
      <div class="panel panel-default panel_complete_appeal">
        <div class="list_complete">
          <div class="row">
            <div class="col-md-1 col-sm-2 col-xs-3 list_complete_icon">
              <img src="images/icon_oneh.png" class="icon_oneh_appeal">
            </div>
            <div class="col-md-10 col-sm-8 col-xs-9 list_complete_detail">
              <span class="txt_app hr_appeal_detail_ex"><?=$txt_Petition_topic?> : <br></span><span class="txt_app hr_appeal_detail_er"><?php echo $re['caseDtl_title'];?><br></span><span class="txt_app slot_appeal"> | </span>
              <span class="txt_app hr_appeal_detail_ec"><?=$txt_Petitioner_company?> : <br></span><span class="txt_app"><?php echo $re['complnt_name'];?></span></p>
              <span class="icon_date"><img src="images/all_icon_DITP/icon_19.svg" style="width:15px;"></span><span class="complete_date"><?php echo $date;?></span>
              <span class="icon_time"><img src="images/all_icon_DITP/icon_21.svg" style="width:20px;"></span><span class="complete_time"><?php echo $time;?></span>
            </div>
            <div class="col-md-1 col-sm-2 list_complete_search"><span class="icon_search_detail"><a href="?page=appeal_detail&case_id=<?=$re['case_id'];?>"><img src="images/all_icon_DITP/icon_26.svg" style="width:40px;"></a></span></div>
          </div>
      </div>
      </div>
  </div>
  <?php
    }
  }else {?>
    <div class="panel-body">
      <div class="panel panel-default panel_complete_appeal">
        <div class="list_complete">
          <div class="row no_data">
            <span class="no_data"><?=$txt_not_found?></span>
          </div>
      </div>
      </div>
  </div>
  <?php
  }
  ?>
  </div> <!-- complete -->
</div>
  </div>
</div>
