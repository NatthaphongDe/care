<?php
// ini_set('display_errors', 1);
// 	ini_set('display_startup_errors', 1);
// 	error_reporting(E_ALL);
// return 'dd';
// exit;
session_start();
//-- ฟังกชั่นลบไฟล์และโฟลเดอร์ --//
function deleteDirectory($dirPath) {
	if (is_dir($dirPath)) {
		$objects = scandir($dirPath);
		foreach ($objects as $object) {
			if ($object != "." && $object !="..") {
				if (filetype($dirPath . DIRECTORY_SEPARATOR . $object) == "dir") {
					deleteDirectory($dirPath . DIRECTORY_SEPARATOR . $object);
				} else {
					unlink($dirPath . DIRECTORY_SEPARATOR . $object);
				}
			}
		}
	reset($objects);
	rmdir($dirPath);
	}
}

if(isset($_REQUEST["method"]) && $_REQUEST["method"]=="logout"){
	unset($_SESSION["admin"]);
	?>
	<script>
	window.location.href="login.php"
	</script>
	<?php
	exit();
}
switch ($_POST['method']) {
  case "saveTransfer_Log":
		include("../config/config.php");
  	include("class/main.class.php");
	  include("class/case.class.php");
    echo saveTransfer_Log();
  break;
	case "set_officeType":
		include("../config/config.php");
    echo set_officeType();
	case "set_prodType":
		include("../config/config.php");
    echo set_prodType($_POST["value_office"]);
  break;
}
if(isset($_REQUEST["method"]) && (
	//$_REQUEST["method"]=="save_case" ||
	//$_REQUEST["method"]=="update_case" ||
	$_REQUEST["method"]=="save_open_case" ||
	$_REQUEST["method"]=="save_process" ||
	$_REQUEST["method"]=="close_process" ||
	$_REQUEST["method"]=="assign_case" ||
	$_REQUEST["method"]=="close_case" ||
	$_REQUEST["method"]=="note_process_overdue" ||
	$_REQUEST["method"]=="dis_kpi_case" ||
	$_REQUEST["method"]=="create_msg" ||
	$_REQUEST["method"]=="change_img_profile" ||
	$_REQUEST["method"]=="change_img_profile_setting")){
		
  include_once("../config/config.php");
  include_once("class/main.class.php");
  include_once("class/send_email.class.php");
  include_once("class/case.class.php");
  include_once("class/employee.class.php");
	include_once("class/msg.class.php");

	if($_REQUEST["method"]=="create_msg"){

		$noti_cls = new msg_base();
	}

	$caseDtl_cls = new case_detail();

	$member_cls = new member_base();
	
	$email_cls = new email();

	?>
	<script type="text/javascript" src="js/case.js"></script>
	<script type="text/javascript" src="assets/js-core/jquery-core.js"></script>
	<script type="text/javascript" src="assets/bootstrap/js/bootstrap.js"></script>
	<script type="text/javascript" src="assets/widgets/bootbox/bootbox.min.js"></script>

	<link rel="stylesheet" type="text/css" href="assets/widgets/izitoast/dist/css/iziToast.css">
	<script type="text/javascript" src="assets/widgets/izitoast/dist/js/iziToast.js"></script>

	<script>
	iziToast.settings({
	    timeout: 5000,
	    resetOnHover: false,
	    icon: 'material-icons',
	    transitionIn: 'flipInX',
	    transitionOut: 'flipOutX',
	    onOpening: function(){
	    },
	    onClosing: function(){
	    }
	});

	var iziToast_func ={
		alert: function( message_txt,callback ) {
	    iziToast.error({
	      timeout: 5000,
	      icon: 'ico-warning',
	      title: 'แจ้งเตือน: ',
	      message: message_txt,
	      position: 'topCenter', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
	      onOpening: function(instance, toast){
	      },
	      onClosing: function(instance, toast, closedBy){
	        if(typeof(callback)=='function'){
	            callback();
	        }
	      }
	    });
	  }
	  ,success: function( message_txt,callback ) {
	    iziToast.success({
	      timeout: 1000,
	      pauseOnHover: false,
	      title: 'OK',
	      message: message_txt,
	      position: 'center', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
	      onOpening: function(instance, toast){
	      },
	      onClosing: function(instance, toast, closedBy){
	        if(typeof(callback)=='function'){
	            callback();
	        }
	      }
	    });
	  }
	}
	</script>
	<?php

	if($member_cls->checkLoginSession()==false){
	  ?>
	  <script>
		iziToast_func.alert("ขออภัย...ระยะเวลาเซสชั่นการเข้าสู่ระบบของท่านหมดลงแล้ว กรุณาเข้าสู่ระบบใหม่อีกครั้ง");
		window.parent.location.href = "login.php";
		</script>
	  <?php
		exit();
	}

}
if(isset($_REQUEST["method"]) && (
	$_REQUEST["method"]=="save_case" ||
	$_REQUEST["method"]=="update_case" ||
	$_REQUEST["method"]=="chk_assign" ||
	$_REQUEST["method"]=="emp_list_assign" ||
	$_REQUEST["method"]=="emp_get_detail" ||
	$_REQUEST["method"]=="chk_close_process" ||
	$_REQUEST["method"]=="check_backlist" ||
	$_REQUEST["method"]=="save_to_knowledge" ||
	$_REQUEST["method"]=="get_detpartment_data"||
	$_REQUEST["method"]=="get_check_blacklist_watchlist")){//*ยังไม่เช็ค session admin
  include("../config/config.php");
  include("class/main.class.php");
  include("class/case.class.php");
  include("class/employee.class.php");

	$caseDtl_cls = new case_detail();
	$member_cls = new member_base();

}

//-- Bootstrap Table --//
if(isset($_REQUEST["method"]) && (
	$_REQUEST["method"]=="createcase_init" ||
	$_REQUEST["method"]=="editcase_init" ||
	$_REQUEST["method"]=="getCaseList" ||
	$_REQUEST["method"]=="getNotiList" ||
	$_REQUEST["method"]=="getMsgBoxList" ||
	$_REQUEST["method"]=="update_open_noti" ||
	$_REQUEST["method"]=="remove_msg")){
  include("../config/config.php");
  include("class/main.class.php");
  include("class/case.class.php");
  include("class/msg.class.php");
  include("class/employee.class.php");

	$caseLst_cls = new case_list();
	$noti_cls = new msg_base();
}

if(isset($_GET["page"]) && (
	$_GET["page"]=="message_box_detail" ||
	$_GET["page"]=="message_box_create")){

	if(isset($_GET["msgId"])){
	  $rs_msg = $noti_cls->get_msg_data($_GET["msgId"]);
	}

	if($_GET["page"]=="message_box_detail" && count($rs_msg["msg"]["case_id"])==""){
		?>
		<script>
			parent.iziToast_func.alert('ขออภัย...ไม่มีข้อความที่ท่านต้องการในระบบ !');
			window.location.href="index.php?page=case_list";
		</script>
		<?php
		exit();
	}else{
		if($rs_msg["msg"]["msgBox_type"]=="2"){
			?>
			<script>
				parent.iziToast_func.alert('ขออภัย...ไม่มีข้อความที่ท่านต้องการในระบบ !');
				window.location.href="index.php?page=case_list";
			</script>
			<?php
			exit();
		}
	}
	//print_r($rs_msg["msg"]);

}

if(!isset($_GET["page"]) && (isset($_REQUEST["method"]) && $_REQUEST["method"]=="createcase_init")){

	$method_case = "";
  $caseOpn_cls = new case_open();

  $rdi_compType_id = mysqli_real_escape_string($conn,$_POST["rdi_compType_id"]);
  $rdi_compTypeSub1 = mysqli_real_escape_string($conn,$_POST["rdi_compTypeSub1"]);
  $rdi_compTypeSub2 = mysqli_real_escape_string($conn,$_POST["rdi_compTypeSub2"]);
  $compType_other_flag = mysqli_real_escape_string($conn,$_POST["compType_other_flag"]);
  $compType_other = mysqli_real_escape_string($conn,$_POST["compType_other"]);

  $caseOpn_cls->compType_id = $rdi_compType_id;
  $caseOpn_cls->compTypeSub1 = $rdi_compTypeSub1;
  $caseOpn_cls->compTypeSub2 = $rdi_compTypeSub2;
  $caseOpn_cls->compType_other_flag = $compType_other_flag;
  $caseOpn_cls->compType_other = $compType_other;

//   if (in_array($_SESSION['admin']['empId'], array('1', '7'))) {
// 	echo '<br>compType_id.: '.$caseOpn_cls->compType_id;
// 	echo '<br>compTypeSub1.: '.$caseOpn_cls->compTypeSub1;
// 	echo '<br>compTypeSub2.: '.$caseOpn_cls->compTypeSub2;
// 	echo '<br>compType_other_flag.: '.$caseOpn_cls->compType_other_flag;
// 	echo '<br>compType_other.: '.$caseOpn_cls->compType_other;
//   }
  	// if (in_array($_SESSION['admin']['empId'], array('1', '7')) && in_array($caseOpn_cls->compType_id, array('4', '6'))) {
  	if (in_array($caseOpn_cls->compType_id, array('4', '6'))) {
		$chkCompType = '00';
	} 
	else {
		$chkCompType = $caseOpn_cls->chkCompType();
	}
	// if (in_array($_SESSION['admin']['empId'], array('1', '7'))) {
	// 	echo '<br>';
	// 	var_dump($chkCompType);
	// 	echo '<br>';
	// }
	if($chkCompType["status_response"]=="02"){
		?>
		<script>
		parent.iziToast_func.alert('<?php echo $chkCompType["status_response_text"] ?>');
		</script>

		<?php
		exit();
	}

	$arr_formSetList = $caseOpn_cls->genFromSetForCompType();

	if(count($arr_formSetList)<3){
		?>
		<script>
		parent.iziToast_func.alert("ขออภัย...ประเภทเรื่องร้องเรียนที่ท่านเลือก ยังไม่ได้กำหนดแบบฟอร์ม กรุณาเลือกประเภทเรื่องร้องเรียนอื่น");
		</script>

		<?php
		exit();
	}

	$pageSetting = mysqli_real_escape_string($conn,$_POST["index_page_type"]);
	?>

	<script>
	<?php
	if($pageSetting=="setting"){
		?>
		window.parent.document.getElementById("frm-modal-create-case").setAttribute("action","../index.php?page=case_open&method=createcase");
		<?php
	}else{
		?>
		window.parent.document.getElementById("frm-modal-create-case").setAttribute("action","index.php?page=case_open&method=createcase");
		<?php
	} ?>
	window.parent.document.getElementById("frm-modal-create-case").removeAttribute("target");
	window.parent.document.getElementById("frm-modal-create-case").submit();
	</script>
	<?php
	exit();


}

if(!isset($_GET["page"]) && (isset($_REQUEST["method"]) && $_REQUEST["method"]=="editcase_init")) {
	$caseOpn_cls = new case_open();

	$rdi_compType_id = mysqli_real_escape_string($conn,$_POST["ed_rdi_compType_id"]);
	$rdi_compTypeSub1 = mysqli_real_escape_string($conn,$_POST["ed_rdi_compTypeSub1"]);
	$rdi_compTypeSub2 = mysqli_real_escape_string($conn,$_POST["ed_rdi_compTypeSub2"]);
	$compType_other_flag = mysqli_real_escape_string($conn,$_POST["ed_compType_other_flag"]);
	$compType_other = mysqli_real_escape_string($conn,$_POST["ed_compType_other"]);

	if(($rdi_compType_id == 6) && $rdi_compTypeSub2 == '') {
		$rdi_compTypeSub2 = 9;
	}

	$caseOpn_cls->compType_id = $rdi_compType_id;
	$caseOpn_cls->compTypeSub1 = $rdi_compTypeSub1;
	$caseOpn_cls->compTypeSub2 = $rdi_compTypeSub2;
	$caseOpn_cls->compType_other_flag = $compType_other_flag;
	$caseOpn_cls->compType_other = $compType_other;

	if (in_array($caseOpn_cls->compType_id, array('6'))) {
		$chkCompType = '00';
	} 
	else {
		$chkCompType = $caseOpn_cls->chkCompType();
	}
	
	if($chkCompType["status_response"]=="02"){
		?>
		<script>
		parent.iziToast_func.alert('<?php echo $chkCompType["status_response_text"] ?>');
		</script>

		<?php
		exit();
	}

	$caseOpn_cls->case_id = mysqli_real_escape_string($conn,$_POST["case_id"]);
	// print_r($_GET);
  	$editCompType = $caseOpn_cls->editFromSetForCompType_editcase();
	// print_r($editCompType);
	// exit();
	if($editCompType["status_response"]=="00") {
		// print_r($editCompType);
		// exit();
		// header("Refresh:0");
		?>
		<script>
			window.parent.document.getElementById("frm-modal-edit-case").setAttribute("action","index.php?page=case_open&method=editcase&caseId=<?php echo $_POST["case_id"] ?>");
			window.parent.document.getElementById("frm-modal-edit-case").removeAttribute("target");
			window.parent.document.getElementById("frm-modal-edit-case").submit();
		</script>
		<?php
		exit();
	}

	exit();
}

if(isset($_GET["page"]) && $_GET["page"]=="case_open" && (isset($_REQUEST["method"]) && $_REQUEST["method"]=="createcase")){
	$method_case = "";
  $caseOpn_cls = new case_open();

  $rdi_compType_id = mysqli_real_escape_string($conn,$_POST["rdi_compType_id"]);
  $rdi_compTypeSub1 = mysqli_real_escape_string($conn,$_POST["rdi_compTypeSub1"]);
  $rdi_compTypeSub2 = mysqli_real_escape_string($conn,$_POST["rdi_compTypeSub2"]);
  $compType_other_flag = mysqli_real_escape_string($conn,$_POST["compType_other_flag"]);
  $compType_other = mysqli_real_escape_string($conn,$_POST["compType_other"]);

  $caseOpn_cls->compType_id = $rdi_compType_id;
  $caseOpn_cls->compTypeSub1 = $rdi_compTypeSub1;
  $caseOpn_cls->compTypeSub2 = $rdi_compTypeSub2;
  $caseOpn_cls->compType_other_flag = $compType_other_flag;
  $caseOpn_cls->compType_other = $compType_other;
  $arr_formSetList = $caseOpn_cls->genFromSetForCompType();
}

if($_GET["page"]=="case_open_detail" || ($_GET["page"]=="case_open" && isset($_REQUEST["method"]) && ($_REQUEST["method"]=="editcase"))){
	$method_case = "editcase";

	if(!isset($_GET["caseId"]) || $_GET["caseId"]==""){
		?>
		<script>
		window.location.href="index.php?page=case_list";
		</script>
		<?php
		exit();
	}

	$caseOpn_cls = new case_open();

	$caseOpn_cls->case_id = $_GET["caseId"];


  $arr_formSetListArr = $caseOpn_cls->genFromSetForCompType_editcase();

	$rdi_compType_id = $arr_formSetListArr["compType_id"];
  $rdi_compTypeSub1 = $arr_formSetListArr["compTypeSub1_id"];
  $rdi_compTypeSub2 = $arr_formSetListArr["compTypeSub2_id"];

	$arr_formSetList = $arr_formSetListArr["fromSet"];

  $rs_case = $caseOpn_cls->getData_editcase();

	if(count($rs_case["case"])==0){
		?>
		<script>
		window.location.href="index.php?page=case_list";
		</script>
		<?php
		exit();
	}

	if($_GET["page"]=="case_open_detail"){
		//-- -ดึงข้อมูล Ref.Case ของ ผู้ร้องเรียน--//
		$rs_caseRef_applnt = $caseOpn_cls->getCaseToRef("applnt",$rs_case["case"]["applnt_ident"]);
		//-- -ดึงข้อมูล Ref.Case ของ บริษัทผู้ร้องเรียน--//
		$rs_caseRef_applntOrg = $caseOpn_cls->getCaseToRef("applnt_org",$rs_case["case"]["applntOrg_trade_number"]);
		//-- -ดึงข้อมูล Ref.Case ของ บริษัทผู้ถูกร้องเรียน--//
		$rs_caseRef_complnt = $caseOpn_cls->getCaseToRef("complnt",$rs_case["case"]["complnt_trade_number"]);
		$page_redirect = "";
		if(count($rs_case["case_process"])>0){
			$page_redirect = "case_detail";
		}

		if($rs_case["case"]["case_status"]=="1" && $rs_case["case"]["case_step_detail"]=="1"){
			$page_redirect = "case_detail";
		}

		if($page_redirect!=""){
			?>
			<script>
			window.location.href="index.php?page=<?php echo $page_redirect ?>&caseId=<?php echo $rs_case["case"]["case_id"] ?>";
			</script>
			<?php
			exit();
		}
	}

	$page_redirect="";
	if($rs_case["case"]["case_status"]=="3"){ //กรณีสถานะ เป็น In Process และ Close
		$page_redirect = "case_detail";
		if($page_redirect!=""){
			?>
			<script>
			window.location.href="index.php?page=<?php echo $page_redirect ?>&caseId=<?php echo $rs_case["case"]["case_id"] ?>";
			</script>
			<?php
			exit();
		}
	}
}

if($_GET["page"]=="case_open" && isset($_REQUEST["method"]) && $_REQUEST["method"]=="re_open_case" && isset($_GET["caseRefId"]) && $_GET["caseRefId"]!=""){
	$method_case = "re_open_case";
	$caseOpn_cls = new case_open();

	if(!isset($_GET["caseRefId"]) || $_GET["caseRefId"]==""){
		?>
		<script>
		iziToast_func.alert('ขออภัย...ไม่มีเรื่องร้องเรียนที่ท่านต้องการ Re-Open ในระบบ !');
		window.location.href="index.php?page=case_detail&caseId=<?php echo $_GET["caseRefId"] ?>";
		</script>
		<?php
		exit();
	}

	$caseOpn_cls->case_id = $_GET["caseRefId"];

  $arr_formSetListArr = $caseOpn_cls->genFromSetForCompType_editcase();

	$rdi_compType_id = $arr_formSetListArr["compType_id"];
  $rdi_compTypeSub1 = $arr_formSetListArr["compTypeSub1_id"];
  $rdi_compTypeSub2 = $arr_formSetListArr["compTypeSub2_id"];

	$arr_formSetList = $arr_formSetListArr["fromSet"];

  $rs_case = $caseOpn_cls->getData_editcase();

	if(count($rs_case["case"])==0){
		?>
		<script>
		iziToast_func.alert('ขออภัย...ไม่มีเรื่องร้องเรียนที่ท่านต้องการ Re-Open ในระบบ !');
		window.location.href="index.php?page=case_list";
		</script>
		<?php
		exit();
	}
}

if($_GET["page"]=="case_open" && $rdi_compType_id=="" && (!isset($_REQUEST["method"]) || (isset($_REQUEST["method"]) && $_REQUEST["method"]=="createcase"))){
	?>
	<script>
	alert('กรุณาสร้าง Case จากปุ่ม "สร้าง Case" ในหน้ารายการเรื่องร้องเรียน เท่านั้น');
	window.location.href="index.php?page=case_list";
	</script>
	<?php
	exit();
}

if($_GET["page"]=="case_detail"){

	if(!isset($_GET["caseId"]) || $_GET["caseId"]==""){
		?>
		<script>
		iziToast_func.alert('ขออภัย...ไม่มีเรื่องร้องเรียนที่ท่านต้องการในระบบ !');
		window.location.href="index.php?page=case_list";
		</script>
		<?php
		exit();
	}

	$caseOpn_cls = new case_open();
	$caseDtl_cls = new case_detail();

	$caseDtl_cls->case_id = $_GET["caseId"];

  $arr_formSetListArr = $caseDtl_cls->genFromSetForCompType_detailCase();

	$rdi_compType_id = $arr_formSetListArr["compType_id"];
  $rdi_compTypeSub1 = $arr_formSetListArr["compTypeSub1_id"];
  $rdi_compTypeSub2 = $arr_formSetListArr["compTypeSub2_id"];

	$arr_formSetList = $arr_formSetListArr["fromSet"];

	//-- -ดึงข้อมูล Case --//
  $rs_case = $caseDtl_cls->getData_detailcase();


	if(count($rs_case["case"])==0){
		?>
		<script>
		window.location.href="index.php?page=case_list";
		</script>
		<?php
		exit();
	}else{
		$page_redirect="";
		if($rs_case["case"]["case_lastSave_datetime"]==""){
			$page_redirect = "case_open_detail";
		}else{
			if($rs_case["case"]["case_status"]!="2" && $rs_case["case"]["case_status"]!="3"){ //กรณีสถานะ ไม่ใช่ In Process และ Close
					//กรณีสถานะ ไม่ใช่ Waiting หรือ New ที่มาจาก App หริอ WebApp และ ยังไม่รับเคส
					if($rs_case["case"]["case_status"]=="1" && $rs_case["case"]["case_step_detail"]=="0"){
						$page_redirect = "case_open_detail";
					}else{
						// if($rs_case["case"]["case_status"]=="0" && ($rs_case["case"]["caseCh_id"]=="1" || $rs_case["case"]["caseCh_id"]=="2")){
						// 	$page_redirect = "case_open&method=editcase";
						// }

					}
			}
		}
		if($page_redirect!=""){
			?>
			<script>
			window.location.href="index.php?page=<?php echo $page_redirect ?>&caseId=<?php echo $rs_case["case"]["case_id"] ?>";
			</script>
			<?php
			exit();
		}


	}


	//-- -ดึงข้อมูล Ref.Case ของ ผู้ร้องเรียน--//
	$rs_caseRef_applnt = $caseDtl_cls->getCaseToRef("applnt",$rs_case["case"]["applnt_ident"]);
	//-- -ดึงข้อมูล Ref.Case ของ บริษัทผู้ร้องเรียน--//
	$rs_caseRef_applntOrg = $caseDtl_cls->getCaseToRef("applnt_org",$rs_case["case"]["applntOrg_trade_number"]);
	//-- -ดึงข้อมูล Ref.Case ของ บริษัทผู้ถูกร้องเรียน--//
	$rs_caseRef_complnt = $caseDtl_cls->getCaseToRef("complnt",$rs_case["case"]["complnt_trade_number"]);

	//-- -ดึงข้อมูล ID ของ กระบวนการของ Case--//

	if(count($caseDtl_cls->processType)==0){ //เช็คการนำเข้าข้อมูล "ประเภทกระบวนการ" จากฐานข้อมูล
	  $caseDtl_cls->processType = $caseDtl_cls->caseProcessTypeList(null,$caseDtl_cls->admin_section);
	}
	$processTypeName = $caseDtl_cls->processType;

	$proc_overdue_status = 0;
	// $proc_overdue_title =  $processTypeName[1];
	// $proc_id =  4;
	if(count($rs_case["case_process"])>0){
		$case_processInit_idx = array();
		$i=0;
		foreach ($rs_case["case_process"] as $case_process) {
			if($case_process["process_type_id"]==1){
				$case_processInit_idx[0]["process_id"] = $case_process["process_id"];
				$case_processInit_idx[0]["process_type_id"] = $case_process["process_type_id"];
				$case_processInit_idx[0]["process_type_name"] = $case_process["process_type_name"];
				$case_processInit_idx[0]["process_status"] = $case_process["process_status"];
				$case_processInit_idx[0]["process_save_datetime"] = $case_process["process_save_datetime"];
				$case_processInit_idx[0]["process_over_note"] = $case_process["process_over_note"];

				$process_type_duration = $case_process["process_type_duration"]; //ระยะเวลา
				$day_subholiday = (int)$caseDtl_cls->getHoliday(date('Y-m-d', strtotime($case_process["process_save_datetime"])),date('Y-m-d',time()));
				if($day_subholiday>0){
					$case_processInit_idx[0]["process_save_datetime_ctd"] = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime('+'.$day_subholiday.' day', strtotime($case_process["process_save_datetime"]))))->format('Y/m/d H:i:s');
					if(strtotime('+'.$day_subholiday.' day', strtotime($case_process["process_save_datetime"]))>time()){
						$case_processInit_idx[0]["process_save_datetime_ctd"] = "0000-00-00";
					}
				}else{
					$case_processInit_idx[0]["process_save_datetime_ctd"] = DateTime::createFromFormat('Y-m-d H:i:s', $case_process["process_save_datetime"])->format('Y/m/d H:i:s');
				}

				$case_processInit_idx[0]["process_over_datetime"] = $case_process["process_over_datetime"];
				$case_processInit_idx[0]["process_complete_datetime"] = $case_process["process_complete_datetime"];
				$case_processInit_idx[0]["procPropApp_status"] = $case_process["procPropApp_status"];
				$case_processInit_idx[0]["procPropTel1_status"] = $case_process["procPropTel1_status"];
				$case_processInit_idx[0]["procPropFax1_status"] = $case_process["procPropFax1_status"];
				$case_processInit_idx[0]["procPropEmail1_status"] = $case_process["procPropEmail1_status"];
				$case_processInit_idx[0]["procPropMail1_status"] = $case_process["procPropMail1_status"];
				$case_processInit_idx[0]["procPropTel2_status"] = $case_process["procPropTel2_status"];
				$case_processInit_idx[0]["procPropFax2_status"] = $case_process["procPropFax2_status"];
				$case_processInit_idx[0]["procPropEmail2_status"] = $case_process["procPropEmail2_status"];
				$case_processInit_idx[0]["procPropMail2_status"] = $case_process["procPropMail2_status"];
				$case_processInit_idx[0]["note"] = $case_process["process_note"];

				$time_over = $case_process["process_over_datetime"];
				if($case_process["process_complete_datetime"]!=""){
					$time_compare = strtotime($case_process["process_complete_datetime"]);
				}else{
					$time_compare = time();
				}
				if($case_process["process_status"]==0 && $time_compare>$time_over && $case_process["process_over_note"]=="" && $case_process["process_createBy_id"]==$caseDtl_cls->admin_id){
					$proc_overdue_status = 1;
					$proc_overdue_title =  $processTypeName[$case_process["process_type_id"]];
					$proc_overdue_duration = $case_process["process_type_duration"];
					$proc_id = $case_process["process_id"];
				}

			  $i++;
			}else if($case_process["process_type_id"]==2){
				$case_processInit_idx[1]["process_id"] = $case_process["process_id"];
				$case_processInit_idx[1]["process_type_id"] = $case_process["process_type_id"];
				$case_processInit_idx[1]["process_type_name"] = $case_process["process_type_name"];
				$case_processInit_idx[1]["process_status"] = $case_process["process_status"];
				$case_processInit_idx[1]["process_save_datetime"] = $case_process["process_save_datetime"];
				$case_processInit_idx[1]["process_over_note"] = $case_process["process_over_note"];

				$process_type_duration = $case_process["process_type_duration"]; //ระยะเวลา
				$day_subholiday = (int)$caseDtl_cls->getHoliday(date('Y-m-d', strtotime($case_process["process_save_datetime"])),date('Y-m-d',time()),"full");
				if($day_subholiday>0){
					$case_processInit_idx[1]["process_save_datetime_ctd"] = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime('+'.$day_subholiday.' day', strtotime($case_process["process_save_datetime"]))))->format('Y/m/d H:i:s');
					if(strtotime('+'.$day_subholiday.' day', strtotime($case_process["process_save_datetime"]))>time()){
						$case_processInit_idx[1]["process_save_datetime_ctd"] = "0000-00-00";
					}
				}else{
					$case_processInit_idx[1]["process_save_datetime_ctd"] = DateTime::createFromFormat('Y-m-d H:i:s', $case_process["process_save_datetime"])->format('Y/m/d H:i:s');
				}

				$case_processInit_idx[1]["process_over_datetime"] = $case_process["process_over_datetime"];
				$case_processInit_idx[1]["process_complete_datetime"] = $case_process["process_complete_datetime"];
				$case_processInit_idx[1]["procPropTel2_status"] = $case_process["procPropTel2_status"];
				$case_processInit_idx[1]["procPropFax2_status"] = $case_process["procPropFax2_status"];
				$case_processInit_idx[1]["procPropEmail2_status"] = $case_process["procPropEmail2_status"];
				$case_processInit_idx[1]["procPropMail2_status"] = $case_process["procPropMail2_status"];
				$case_processInit_idx[1]["note"] = $case_process["process_note"];

				$time_over = $case_process["process_over_datetime"];
				if($case_process["process_complete_datetime"]!=""){
					$time_compare = strtotime($case_process["process_complete_datetime"]);
				}else{
					$time_compare = time();
				}
				if($case_process["process_status"]==0 && $time_compare>$time_over && $case_process["process_over_note"]=="" && $case_process["process_createBy_id"]==$caseDtl_cls->admin_id){
					$proc_overdue_status = 1;
					$proc_overdue_title =  $processTypeName[$case_process["process_type_id"]];
					$proc_overdue_duration = $case_process["process_type_duration"];
					$proc_id = $case_process["process_id"];
				}

				$i++;
			}
		}


		if(!isset($case_processInit_idx[0])){
			$case_processInit_idx[0] = array();
			$i++;
		}if(!isset($case_processInit_idx[1])){
			$case_processInit_idx[1] = array();
			$i++;
		}
		foreach ($rs_case["case_process"] as $case_process) {
			if($case_process["process_type_id"]!=1 && $case_process["process_type_id"]!=2){
				$case_processInit_idx[$i]["process_id"] = $case_process["process_id"];
				$case_processInit_idx[$i]["process_type_id"] = $case_process["process_type_id"];
				$case_processInit_idx[$i]["dept_id"] = $case_process["dept_id"];
				$case_processInit_idx[$i]["process_status"] = $case_process["process_status"];
				$case_processInit_idx[$i]["process_save_datetime"] = $case_process["process_save_datetime"];
				$case_processInit_idx[$i]["process_over_note"] = $case_process["process_over_note"];

				$process_type_duration = $case_process["process_type_duration"]; //ระยะเวลา
				$day_subholiday = (int)$caseDtl_cls->getHoliday(date('Y-m-d', strtotime($case_process["process_save_datetime"])),date('Y-m-d',time()));
				if($day_subholiday>0){
					$case_processInit_idx[$i]["process_save_datetime_ctd"] = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime('+'.$day_subholiday.' day', strtotime($case_process["process_save_datetime"]))))->format('Y/m/d H:i:s');

					if(strtotime('+'.$day_subholiday.' day', strtotime(date("Y-m-d 00:00:00",strtotime($case_process["process_save_datetime"]))))>strtotime(date("Y-m-d 00:00:00",time()))){
						$case_processInit_idx[$i]["process_save_datetime_ctd"] = "0000-00-00";
					}
				}else{
					$case_processInit_idx[$i]["process_save_datetime_ctd"] = DateTime::createFromFormat('Y-m-d H:i:s', $case_process["process_save_datetime"])->format('Y/m/d H:i:s');
				}

				$case_processInit_idx[$i]["process_over_datetime"] = $case_process["process_over_datetime"];
				$case_processInit_idx[$i]["process_complete_datetime"] = $case_process["process_complete_datetime"];
				$case_processInit_idx[$i]["process_to1"] = $case_process["process_to1"];
				$case_processInit_idx[$i]["process_to2"] = $case_process["process_to2"];
				$case_processInit_idx[$i]["process_title1"] = $case_process["process_title1"];
				$case_processInit_idx[$i]["process_title2"] = $case_process["process_title2"];
				$case_processInit_idx[$i]["procPropTel1_status"] = $case_process["procPropTel1_status"];
				$case_processInit_idx[$i]["procPropFax1_status"] = $case_process["procPropFax1_status"];
				$case_processInit_idx[$i]["procPropEmail1_status"] = $case_process["procPropEmail1_status"];
				$case_processInit_idx[$i]["procPropMail1_status"] = $case_process["procPropMail1_status"];
				$case_processInit_idx[$i]["procPropOffcLetter1_status"] = $case_process["procPropOffcLetter1_status"];
				$case_processInit_idx[$i]["procPropTel2_status"] = $case_process["procPropTel2_status"];
				$case_processInit_idx[$i]["procPropFax2_status"] = $case_process["procPropFax2_status"];
				$case_processInit_idx[$i]["procPropEmail2_status"] = $case_process["procPropEmail2_status"];
				$case_processInit_idx[$i]["procPropMail2_status"] = $case_process["procPropMail2_status"];
				$case_processInit_idx[$i]["procPropOffcLetter2_status"] = $case_process["procPropOffcLetter2_status"];
				$case_processInit_idx[$i]["note"] = $case_process["process_note"];
				$case_processInit_idx[$i]["dept_id"] = $case_process["dept_id"];

				$time_over = $case_process["process_over_datetime"];
				if($case_process["process_complete_datetime"]!=""){
					$time_compare = strtotime($case_process["process_complete_datetime"]);
				}else{
					$time_compare = time();
				}
				if($case_process["process_status"]==0 && $time_compare>$time_over && $case_process["process_over_note"]=="" && $case_process["process_createBy_id"]==$caseDtl_cls->admin_id){
					$proc_overdue_status = 1;
					$proc_overdue_title =  $processTypeName[$case_process["process_type_id"]];
					$proc_overdue_duration = $case_process["process_type_duration"];
					$proc_id = $case_process["process_id"];
				}

				$process_last_open = $case_process["process_id"];

				$i++;
			}
		}
		$iFinal_process = $i-1;
	}
	//จะได้ชุด Array "$case_process_idx" ออกมา
}

//-- -บันทึก สร้าง Case --//
if(isset($_REQUEST["method"]) && $_REQUEST["method"]=="save_case"){

	// echo 'dsds';
	// exit();
	
	
	// ini_set('display_errors', 1);
	// ini_set('display_startup_errors', 1);
	// error_reporting(E_ALL);

	ini_set('max_execution_time', 0);

  	$caseOpn_cls = new case_open();

  	$response = $caseOpn_cls->save_case($_POST,$_FILES);
	echo json_encode($response);
	// echo json_encode($_POST);
	/*if($response["status_response"]=="00"){
		?>
		<script>
				show_loading_feedback("hide","window_parent");
			parent.iziToast_func.success('ระบบบันทึกเรื่องร้องเรียนเรียบร้อยแล้ว',function(){
				window.parent.location.href="index.php?page=case_open_detail&caseId=<?php echo $response["last_case_id"] ?>";
				});
		</script>
		<?php
		exit();
	  }else if($response["status_response"]=="01"){
		?>
		<script>
				show_loading_feedback("hide","window_parent");
			parent.iziToast_func.alert("บันทึกเรื่องร้องเรียนเกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง");
		</script>
		<?php
		exit();
	  }else if($response["status_response"]=="02"){
			?>
		<script>
				// show_loading_feedback("hide","window_parent");
				parent.iziToast_func.alert("<?php echo $response["status_response_text"] ?>");
		</script>
		<?php
		exit();
		}
		*/
}

//-- -บันทึกก้ไข Case --//
if(isset($_REQUEST["method"]) && $_REQUEST["method"]=="update_case"){

	ini_set('max_execution_time', 0);
	
	// echo 'dd';
	// exit;
	// print_r($_POST);
	// echo "<br />";
	// echo count($_FILES);

  	$caseOpn_cls = new case_open();
  	$response = $caseOpn_cls->update_case($_POST,$_FILES);
	echo json_encode($response);

/*
  if($response["status_response"]=="00"){
    ?>
    <script>
			swalWithBootstrapButtons.fire({
				text: "ระบบบันทึกเรื่องร้องเรียนเรียบร้อยแล้ว",
				icon: 'success',
				reverseButtons: true,
				timer: 1500,
				timerProgressBar: true
			}).then((result) => {
				if(result.dismiss === Swal.DismissReason.timer || result.isConfirmed){
					window.parent.location.href="index.php?page=case_open_detail&caseId=<?php echo $response["last_case_id"] ?>";
				}
			})
    </script>
    <?php
    exit();
  }else if($response["status_response"]=="01"){
    ?>
    <script>
			swalWithBootstrapButtons.fire({
				text: "บันทึกเรื่องร้องเรียนเกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง",
				icon: 'error',
				reverseButtons: true,
				timer: 1500,
				timerProgressBar: true
			}).then((result) => {
				if(result.dismiss === Swal.DismissReason.timer || result.isConfirmed){
					window.location.href="index.php?page=case_open&method=editcase&caseId=<?php echo $response["last_case_id"] ?>";
				}
			})
    </script>
    <?php
    exit();
  }else if($response["status_response"]=="02"){
		?>
		<script>
			swalWithBootstrapButtons.fire({
				text: "<?php echo $response["status_response_text"]?>",
				icon: 'error',
				reverseButtons: true,
				timer: 1500,
				timerProgressBar: true
			}).then((result) => {
				if(result.dismiss === Swal.DismissReason.timer || result.isConfirmed){
					window.location.href="index.php?page=case_open&method=editcase&caseId=<?php echo $response["last_case_id"] ?>";
				}
			})
		</script>
    <?php
    exit();
	}
	*/
	
}

//-- -บันทึกหน้า สรุป หลังสร้างเคส Case --//
if(isset($_REQUEST["method"]) && $_REQUEST["method"]=="save_open_case"){
	$caseOpn_cls = new case_open();
	$response = $caseOpn_cls->save_open_case($_POST);
	if($response["status_response"]=="00"){
		?>
		<script>
				show_loading_feedback("hide","window_parent");
			parent.iziToast_func.success('ระบบบันทึกและรับเรื่องร้องเรียนเรียบร้อยแล้ว',function(){
				window.parent.location.href="index.php?page=case_open_detail&caseId=<?php echo $response["case_id"] ?>";
				});
		</script>
		<?php
		exit();
  	}else if($response["status_response"]=="01"){
		?>
		<script>
				show_loading_feedback("hide","window_parent");
			parent.iziToast_func.alert("บันทึกเรื่องร้องเรียนเกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง");
		</script>
		<?php
		exit();
	}else if($response["status_response"]=="03"){
		?>
		<script>
				show_loading_feedback("hide","window_parent");
			window.parent.location.href="index.php?page=case_detail&caseId=<?php echo $response["case_id"] ?>";
		</script>
		<?php
		exit();
	}
}

//-- -บันทึกกระกวนการ --//
if(isset($_REQUEST["method"]) && $_REQUEST["method"]=="save_process"){
	if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"save_process")[3]!=1){
		?>
		<script>
			show_loading_feedback("hide","window_parent");
			parent.iziToast_func.alert('ขออภัย...ท่านไม่มีสิทธิ์ใช้งานส่วนนี้');
		</script>
		<?php
		exit();
	}
	$response = $caseDtl_cls->save_process($_POST,$_FILES);
  
	if($response["status_response"]=="00"){
		?>
		<script>
			show_loading_feedback("hide","window_parent");
			parent.iziToast_func.success('ระบบบันทึกกระบวนการเรียบร้อยแล้ว',function(){
				window.parent.location.href="index.php?page=case_detail&caseId=<?php echo $response["last_case_id"] ?>&hrefelmId=card-block-<?php echo $response["last_process_id"] ?>";
			});
			</script>
		<?php
		exit();
	}else if($response["status_response"]=="01"){
		?>
		<script>
			show_loading_feedback("hide","window_parent");
			parent.iziToast_func.alert('ระบบบันทึกกระบวนการเกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');

		</script>
		<?php
		exit();
	}else if($response["status_response"]=="02"){
			?>
		<script>
			show_loading_feedback("hide","window_parent");
			parent.iziToast_func.alert('<?php echo $response["status_response_text"] ?>');
		</script>
		<?php
		exit();
	}
}

//-- ระบุสาเหตุกระกวนการเกินกำหนดเวลา --//
if(isset($_REQUEST["method"]) && $_REQUEST["method"]=="note_process_overdue"){
	$response = $caseDtl_cls->note_process_overdue($_POST);

	if($response["status_response"]=="00"){
		?>
		<script>
			show_loading_feedback("hide","window_parent");
			parent.iziToast_func.success('ระบบบันทึกหมายเหตุกระบวนการเกินกำหนดเรียบร้อยแล้ว',function(){
				window.parent.location.reload();
			});
		</script>
		<?php
		exit();
	}else if($response["status_response"]=="01"){
		?>
		<script>
			show_loading_feedback("hide","window_parent");
			parent.iziToast_func.alert('ระบบหมายเหตุกระบวนการเกินกำหนดเกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');
		</script>
		<?php
		exit();
	}else if($response["status_response"]=="02"){
		?>
		<script>
			show_loading_feedback("hide","window_parent");
			parent.iziToast_func.alert('<?php echo $response["status_response_text"] ?>');
		</script>
		<?php
		exit();
	}
}


//-- ปิดกระกวนการ --//
if(isset($_REQUEST["method"]) && $_REQUEST["method"]=="close_process"){

	$caseDtl_cls->case_id = $_POST["case_id"];
	$rs_case = $caseDtl_cls->getData_detailcase();
	$proc_overdue_status = 0;
	if(count($rs_case["case_process"])>0){
		$i=0;
		foreach ($rs_case["case_process"] as $case_process) {
			$time_over = $case_process["process_over_datetime"];
			if($case_process["process_complete_datetime"]!=""){
				$time_compare = strtotime($case_process["process_complete_datetime"]);
			}else{
				$time_compare = time();
			}
			$processTypeName = $caseDtl_cls->caseProcessTypeList("all",$caseDtl_cls->admin_section);

			if($case_process["process_status"]==0 && $time_compare>$time_over && $case_process["process_over_note"]=="" && $case_process["process_createBy_id"]==$caseDtl_cls->admin_id){
				$proc_overdue_status = 1;
				$proc_overdue_title =  $processTypeName[$case_process["process_type_id"]];
				$proc_overdue_duration = $case_process["process_type_duration"];
				$proc_id = $case_process["process_id"];
				?>
				<script>
				show_loading_feedback("hide","window_parent");
		    window.parent.$("#model_process_overdue .proc_over_title_txt").html("<?php echo $proc_overdue_title ?>");
		    window.parent.$("#model_process_overdue .proc_over_duration_txt").html("<?php echo $proc_overdue_duration ?>");
		    window.parent.$("#model_process_overdue").modal("show");

				</script>
		    <?php
			}
		}
	}
	if($proc_overdue_status==1){ //ถ้ามีกระบวนการเกิน overdue
		exit();
  }

	if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"close_process")[3]!=1){
		?>
    <script>
		show_loading_feedback("hide","window_parent");
    parent.iziToast_func.alert('ขออภัย...ท่านไม่มีสิทธิ์ใช้งานส่วนนี้');
    </script>
    <?php
    exit();
	}

	$response = $caseDtl_cls->close_process($_POST);
	if($response["status_response"]=="00"){
    ?>
    <script>
		show_loading_feedback("hide","window_parent");
    parent.iziToast_func.success('ระบบปิดกระบวนการเรียบร้อยแล้ว',function(){
			window.parent.location.href="index.php?page=case_detail&caseId=<?php echo $response["last_case_id"] ?>&hrefelmcloseId=card-block-<?php echo $response["last_process_id"] ?>";
    });
    </script>
    <?php
    exit();
  }else if($response["status_response"]=="01"){
    ?>
    <script>
		show_loading_feedback("hide","window_parent");
    parent.iziToast_func.alert('ระบบปิดกระบวนการเกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');

    </script>
    <?php
    exit();
  }else if($response["status_response"]=="02"){
		?>
    <script>
		show_loading_feedback("hide","window_parent");
		parent.iziToast_func.alert('<?php echo $response["status_response_text"] ?>');

    </script>
    <?php
    exit();
	}
}

//-- แสดงรายชื่อพนักงานตอน Assign --//
if(isset($_REQUEST["method"]) && $_REQUEST["method"]=="emp_list_assign"){
		$emp_cls = new member_base();
		$res = $emp_cls->emp_list_assign($_POST);
		$query = array();
		$query["query"] = "Unit";
		$query["suggestions"] = $res;
		$response = json_encode($query);
		echo $response;
}

//-- แสดงรายละเอียดพนักงานตอน Assign --//
if(isset($_REQUEST["method"]) && $_REQUEST["method"]=="emp_get_detail"){
		$emp_cls = new member_base();
		$_POST["emp_id"] = $emp_cls->data_filter($_POST["emp_id"]);
		$res = $emp_cls->emp_get_detail($_POST["emp_id"]);
		$response = json_encode($res);
		echo $response;
}


//-- ตรวจสอบปุ่ม Assign --//
if(isset($_REQUEST["method"]) && $_REQUEST["method"]=="chk_assign"){
		$response = null;
		$caseDtl_cls->case_id = $_POST["case_id"];
	  $rs_case = $caseDtl_cls->getData_editcase();
		if($rs_case["case"]["case_assign_status"]==0){
			if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"assign_case")[3]!=1){
				$response = "02";
			}
		}else if($rs_case["case"]["case_assign_status"]==1){
			if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"re_assign_case")[3]!=1){
				$response = "02";
			}
		}

		if($response==null){
			$response = $caseDtl_cls->check_assign_case($_POST);
		}
		echo $response;
}

//-- ตรวจสอบ Process ก่อนยุติข้อร้องเรียน --//
if(isset($_REQUEST["method"]) && $_REQUEST["method"]=="chk_close_process"){
		$response = $caseDtl_cls->check_close_process($_POST["case_id"]);
		echo $response;
}




//-- บันทึกการ Assign --//
if(isset($_REQUEST["method"]) && $_REQUEST["method"]=="assign_case"){
	$response = $caseDtl_cls->assign_case($_POST);


  if($response["status_response"]=="00"){
    ?>
    <script>
		show_loading_feedback("hide","window_parent");
    parent.iziToast_func.success('ระบบบันทึกข้อมูลผู้รับผิดชอบเรียบร้อยแล้ว',function(){
	    window.parent.location.href="index.php?page=case_detail&caseId=<?php echo $response["last_case_id"] ?>";
		});
    </script>
    <?php
    exit();
  }else if($response["status_response"]=="01"){
    ?>
    <script>
		show_loading_feedback("hide","window_parent");
		parent.iziToast_func.alert("ระบบบันทึกข้อมูลผู้รับผิดชอบเกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง");
    </script>
    <?php
    exit();
  }else if($response["status_response"]=="02"){
		?>
    <script>
		show_loading_feedback("hide","window_parent");
		parent.iziToast_func.alert("<?php echo $response["status_response_text"] ?>");
    </script>
    <?php
    exit();
	}

}


//-- บันทึกการยุติข้อร้องเรียน --//
if(isset($_REQUEST["method"]) && $_REQUEST["method"]=="close_case"){

	$caseDtl_cls->case_id = $_POST["case_id"];
	$rs_case = $caseDtl_cls->getData_detailcase();
	$proc_overdue_status = 0;
	if(count($rs_case["case_process"])>0){
		$i=0;
		foreach ($rs_case["case_process"] as $case_process) {
			$datatime_diff = $caseDtl_cls->getDateTimeData(date("Y-m-d 00:00:00",strtotime($case_process["process_save_datetime"])),date("Y-m-d 00:00:00",strtotime($case_process["process_complete_datetime"])));
			if($datatime_diff["days"]<0){
				$datatime_diff["days"] = 0;
			}
			$time_over = $case_process["process_over_datetime"];
			if($case_process["process_complete_datetime"]!=""){
				$time_compare = strtotime($case_process["process_save_datetime"]) - strtotime($case_process["process_complete_datetime"],' - '.$datatime_diff["days"].' days');
			}else{
				$time_compare = time();
			}
			$processTypeName = $caseDtl_cls->caseProcessTypeList("all",$caseDtl_cls->admin_section);

			if($case_process["process_status"]==0 && $time_compare>$time_over && $case_process["process_over_note"]=="" && $case_process["process_createBy_id"]==$caseDtl_cls->admin_id){
				$proc_overdue_status = 1;
				$proc_overdue_title =  $processTypeName[$case_process["process_type_id"]];
				$proc_overdue_duration = $case_process["process_type_duration"];
				$proc_id = $case_process["process_id"];
				?>
				<script>
				show_loading_feedback("hide","window_parent");
		    window.parent.$("#model_process_overdue .proc_over_title_txt").html("<?php echo $proc_overdue_title ?>");
		    window.parent.$("#model_process_overdue .proc_over_duration_txt").html("<?php echo $proc_overdue_duration ?>");
		    window.parent.$("#model_process_overdue").modal("show");

				</script>
		    <?php
			}
		}
	}
	if($proc_overdue_status==1){ //ถ้ามีกระบวนการเกิน overdue
		exit();
  }

	if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"close_case")[3]!=1){
		?>
    <script>
		show_loading_feedback("hide","window_parent");
    parent.iziToast_func.alert('ขออภัย...ท่านไม่มีสิทธิ์ใช้งานส่วนนี้');
    </script>
    <?php
    exit();
	}

	$response = $caseDtl_cls->close_case($_POST);
	if($response["status_response"]=="00"){
		$send_mail = $email_cls->send_email_close_case($rs_case["case_feild"], $_POST["case_id"], $rs_case['case']["case_createBy_id"]);
		if($send_mail["status_response"]=="00"){
    ?>

		<script type="text/javascript" src="js/case.js"></script>
    	<script>
			parent.iziToast_func.success('ระบบการยุติข้อร้องเรียนเรียบร้อยแล้ว',function(){

			/* result is a boolean; true = OK, false = Cancel*/
				show_loading_feedback("hide","window_parent");
				window.parent.$("#model_close_case").modal("hide");
				<?php
				if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"dis_kpi_case")[3]==1){
					if($rs_case["case"]["case_disKPI_status"]=="0"){
						$datatimeGen_opencase = $caseDtl_cls->getDateTimeData(date("Y-m-d 00:00:00",strtotime($rs_case["case"]["case_opened_datetime"])),date("Y-m-d 00:00:00",strtotime($rs_case["case"]["case_close_datetime"])));
						if($datatimeGen_opencase["days"] > $rs_case["case"]["compType_duration"]){
							if(count($rs_case["case_assign"])>1){
								?>
								case_close = new case_close_class();
								case_close.openDiscreditCase("#model_discredit_kpi",null,"window_parent");
								<?php
							}else{
								foreach ($rs_case["case_assign"] as $case_assign_list) {
									$emp_id_assign = $case_assign_list["emp_id"];
								}
								header('Location: function.php?method=dis_kpi_case&ref=auto&case_id='.$response["last_case_id"].'&emp_id_assign='.$emp_id_assign);

							}
						}
					}else{
						?>
						window.parent.location.href="index.php?page=case_detail&caseId=<?php echo $response["last_case_id"] ?>";
						<?php
					}
				}else{
					?>
					window.parent.location.href="index.php?page=case_detail&caseId=<?php echo $response["last_case_id"] ?>";
					<?php
				}
				?>
			});
    	</script>
    <?php
		}
		exit();
	}else if($response["status_response"]=="01"){
    ?>
    <script>
			show_loading_feedback("hide","window_parent");
    	parent.iziToast_func.alert('ระบบการยุติข้อร้องเรียนเกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง',function(){
				$(".bootbox",window.parent.document).on("hidden.bs.modal",function(){
	        $('body',window.parent.document).addClass('modal-open');
	      });
			});
    </script>
    <?php
    exit();
  	}else if($response["status_response"]=="02"){
		?>
    <script>
			show_loading_feedback("hide","window_parent");
    	parent.iziToast_func.alert('<?php echo $response["status_response_text"] ?>',function(){
				$(".bootbox",window.parent.document).on("hidden.bs.modal",function(){
	        $('body',window.parent.document).addClass('modal-open');
	      });
			});
    </script>
    <?php
    exit();
	}

}

//-- บันทึกให้ KPI ติดลบ --//
if(isset($_REQUEST["method"]) && $_REQUEST["method"]=="dis_kpi_case"){

	if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"close_case")[3]!=1){
		?>
    <script>
		show_loading_feedback("hide","window_parent");
    parent.iziToast_func.alert('ขออภัย...ท่านไม่มีสิทธิ์ใช้งานส่วนนี้');
    </script>
    <?php
    exit();
	}

	$response = $caseDtl_cls->dis_kpi_case($_REQUEST);


  if($response["status_response"]=="00"){
    ?>
    <script>
		show_loading_feedback("hide","window_parent");
		<?php
		if($_REQUEST["ref"]=="auto"){
			?>
			parent.iziToast_func.success('ระบบได้คำนวน KPI อัตโนมัติให้ผู้รับผิดชอบเรียบร้อยแล้ว',function(){
				window.parent.location.href="index.php?page=case_detail&caseId=<?php echo $response["last_case_id"] ?>";
			});
			<?php
		}else{

		}
		?>
    parent.iziToast_func.success('ระบบคำนวน KPI เรียบร้อยแล้ว',function(){
	    window.parent.location.href="index.php?page=case_detail&caseId=<?php echo $response["last_case_id"] ?>";
		});
    </script>
    <?php
    exit();
  }else if($response["status_response"]=="01"){
    ?>
    <script>
		show_loading_feedback("hide","window_parent");
    parent.iziToast_func.alert('ระบบให้ KPI ติดลบเกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');
    </script>
    <?php
    exit();
  }else if($response["status_response"]=="02"){
		?>
    <script>
		show_loading_feedback("hide","window_parent");
    parent.iziToast_func.alert('<?php echo $response["status_response_text"] ?>');
    </script>
    <?php
    exit();
	}

}


if(isset($_REQUEST["method"]) && $_REQUEST["method"]=="getCaseList"){
	$post = array();
	$request_body = file_get_contents('php://input');
	$post = json_decode($request_body);
	$response = $caseLst_cls->getCaseList($post);
	echo $response;
}

if(isset($_REQUEST["method"]) && $_REQUEST["method"]=="getNotiList"){
	$post = array();
	$request_body = file_get_contents('php://input');
	$post = json_decode($request_body);
	$response = $noti_cls->getNotiList($post);
	echo $response;
}

if(isset($_REQUEST["method"]) && $_REQUEST["method"]=="getMsgBoxList"){
	$post = array();
	$request_body = file_get_contents('php://input');
	$post = json_decode($request_body);
	$response = $noti_cls->getMsgBoxList($post);
	echo $response;
}



//-- บันทึกการ Send Email --//
if(isset($_REQUEST["method"]) && $_REQUEST["method"]=="send_email"){
  include("../config/config.php");
  include("class/main.class.php");
  include("class/send_email.class.php");

	$mail = new email();
	$status_can_send = true;
  $sendMail = array();
 	$to_email = json_decode($_POST["to_email"]);

	if(!(((count($to_email)==1 && $to_email[0]!="") || (count($to_email)>1)) && $_POST["subject"]!="" && $_POST["message"]!="")){
		 $sendMail["status_response"] = "02";
		 $sendMail["status_response_text"] = "กรุณาระบุ Email address, หัวข้อ และรายละเอียด ให้ครบถ้วน !";
		 $status_can_send = false;
	}else{
		foreach ($to_email as $to_email_list) {
			if(!(filter_var($to_email_list, FILTER_VALIDATE_EMAIL))){
				$sendMail["status_response"] = "02";
	 		 	$sendMail["status_response_text"] = "รูปแบบ Email ไม่ถูกต้อง กรุณาระบุ Email ในรูปแบบที่ถูกต้องเช่น example@gmail.com";;
	 		  $status_can_send = false;
			}
		}

		if($status_can_send){
			$mail->to_email = json_decode($_POST["to_email"]);
			$mail->to_name = json_decode($_POST["to_name"]);
			$mail->subject = $_POST["subject"];
			$mail->message =  $_POST["message"];
			$sendMail = $mail->send_email($_POST,$_FILES);
		}

	}

	$response =   array(	'status_response' => $sendMail["status_response"],
												'status_response_text' => $sendMail["status_response_text"],
												'datetime' => $sendMail["datetime"],
												'count_to' => $to_email
											);
	// $response =   array(	'status_response' => "00",
	// 											'status_response_text' => "",
	// 											'datetime' => date('Y-m-d H:i:s',time())
	// 										);

	echo json_encode($response);
	exit();
}

//-- -บันทึกเข้าองค์ความรู้ --//
if(isset($_REQUEST["method"]) && $_REQUEST["method"]=="save_to_knowledge"){
	$response = null;
	if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"save_to_knowledge")[3]!=1){
		$response = "03";
	}
	if($response==null){
		$response = $caseDtl_cls->save_to_knowledge($_POST);
	}
  echo json_encode($response);
	exit();
}

//-- -บันทึก ข้อความใหม่ --//
if(isset($_REQUEST["method"]) && $_REQUEST["method"]=="create_msg"){
	if($_POST["msgBox_type"]==1){
		$type_message = "ข้อความ";
	}else{
		$type_message = "ข้อความตอบกลับ";
	}

  $response = $noti_cls->create_msg($_POST,$_FILES);
  if($response["status_response"]=="00"){
    ?>
    <script>
		show_loading_feedback("hide","window_parent");
    parent.iziToast_func.success('ระบบบันทึก<?php echo $type_message ?>เรียบร้อยแล้ว',function(){
    	window.parent.location.href="index.php?page=message_box_detail&msgId=<?php echo $response["last_msg_id"] ?>";
		});
    </script>
    <?php
    exit();
  }else if($response["status_response"]=="01"){
    ?>
    <script>
		show_loading_feedback("hide","window_parent");
    parent.iziToast_func.alert("บันทึก<?php echo $type_message ?>เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง");

    </script>
    <?php
    exit();
  }else if($response["status_response"]=="02"){
		?>
    <script>
		show_loading_feedback("hide","window_parent");
    parent.iziToast_func.alert('<?php echo $response["status_response_text"] ?>');
    </script>
    <?php
    exit();
	}
}

if(isset($_REQUEST["method"]) && $_REQUEST["method"]=="update_open_noti"){
	  $response = $noti_cls->update_open_noti();
		echo $response;
		exit();
}

if(isset($_REQUEST["method"]) && $_REQUEST["method"]=="remove_msg"){
	  $response = $noti_cls->remove_msg($_POST["msg_id"]);
		echo $response;
		exit();
}


if(isset($_GET["refpage"]) && $_GET["refpage"]=="update_read"){
	  $response = $noti_cls->update_read_noti($_GET);
}


if(isset($_REQUEST["method"]) && ($_REQUEST["method"]=="change_img_profile"||$_REQUEST["method"]=="change_img_profile_setting")){
		$response = $member_cls->emp_change_img_profile($_FILES);
				?>
		    <script>
					show_loading_feedback("hide","window_parent");
					<?php
					if($response["status_response"]!="00"){
						?>
						var old_img = window.parent.document.getElementById("img_profile_oldhid").value;
						window.parent.document.getElementById("img_profile_lg").setAttribute("src",old_img);
						window.parent.document.getElementById("img_profile_sm").setAttribute("src",old_img);
		    		alert("<?php echo $response["status_response_text"] ?>");
						<?php
					}else{
						?>
						var new_img = window.parent.document.getElementById("img_profile_lg").getAttribute("src");
						window.parent.document.getElementById("img_profile_oldhid").value = new_img;
						<?php
					}
					?>
		    </script>
		    <?php
		exit();
}

if(isset($_REQUEST["method"]) && $_REQUEST["method"]=="check_backlist"){
	$caseOpn_cls = new case_open();
	$complnt_trade_number = $caseOpn_cls->data_filter($_POST["complnt_trade_number"]);
	$complnt_name = $caseOpn_cls->data_filter($_POST["complnt_name"]);
	$response = $caseOpn_cls->checkBacklist($complnt_trade_number,$complnt_name);
	echo $response;
	exit();
}

if(isset($_REQUEST["method"]) && $_REQUEST["method"]=="get_detpartment_data"){
	$response = $caseDtl_cls->departmentList();
	echo json_encode($response);
}

if(isset($_REQUEST["method"]) && $_REQUEST["method"]=="get_check_blacklist_watchlist"){
	$caseOpn_cls = new case_open();
	$response = $caseOpn_cls->open_case_check_blacklist_watchlist($_POST);
	echo json_encode($response);
	exit();
	
}


function saveTransfer_Log(){

	global $conn;

	$date_time = date("Y-m-d H:i:s");
	if($_POST['case_id'] == ""){
		$output['check_error'] = "00";
	}elseif ($_POST['office'] == "") {
		$output['check_error'] = "01";
	}elseif ($_POST['transfer_detail'] == "") {
		$output['check_error'] = "02";
	}else {

		$sql_case = "SELECT * FROM `Case` WHERE case_id = '".$_POST['case_id']."' ";
		$query_case = $conn->query($sql_case);
		$res = $query_case->fetch_assoc();

		$sql = "INSERT INTO `case_transfer_log`
		(`transfer_detail`, `transfer_caseID`, `transfer_date`, `transfer_officeID_for`, `transfer_officeID_to`, `transfer_empID`)
		VALUES
		('".$_POST['transfer_detail']."','".$_POST['case_id']."','".$date_time."','".$res['office_id']."','".$_POST['office']."','".$_SESSION['admin']['empId']."')";
		$query = $conn->query($sql);

		$sql_case = "UPDATE `Case` SET office_id = '".$_POST['office']."' WHERE case_id = '".$_POST['case_id']."' ";
		$query_case = $conn->query($sql_case);

		$caseTransf_cls = new case_list();
		$text = " โอนเรื่องร้องเรียน - เรื่องร้องเรียนได้ถูกโอนจาก ".$caseTransf_cls->office_data($res['office_id'])["office_name_short"]." ไปยัง ".$caseTransf_cls->office_data($_POST['office'])["office_name_short"];
		$caseTransf_cls->save_log($type_log,$_POST['case_id'],null,$text);
		$output['check_error'] = "03";
	}

	header("content-type:application/json;charset=utf-8");

	echo json_encode( $output );

}

function set_officeType(){
	global $conn;
	$sql = "SELECT * FROM `Product_Type` WHERE prodType_id = '".$_POST['value_prod']."' ";
	$query = $conn->query($sql);
	$res = $query->fetch_assoc();
	$output['chkType'] = $res['office_id'];
	header("content-type:application/json;charset=utf-8");
	echo json_encode( $output );
	exit();
}


function prodTypeListMutiLv_rpt($lv,$ref_id,$value_office){
	global $conn;
	$prodTypeArrObj = array();

	if($value_office != 0){
		$office = " AND office_id = '$value_office' ";
	}

	$sql = "SELECT *
	FROM Product_Type
					WHERE prodType_level = '$lv'
					AND prodType_status = '0'
					AND prodType_enable = '1' ";
	if($lv >= 2){
		$sql .= $office ;
	}
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

function getProdType_rpt($lv,$ref_id,$ref_name,$value_office){
	global $conn;
	$i=0;
	foreach(prodTypeListMutiLv_rpt($lv,$ref_id,$value_office) as $prod_type){
		if($lv==1){
			$option .= '<optgroup>';
		}
		if($prod_type["prodType_sublist"]>0){
			$disabled = '';
		}else{
			$disabled = '';
		}
		if($lv==1 && $prod_type['prodType_other_flag']==0){
			$disabled = "disabled";
		}else{
			$disabled = '';
		}
		if($lv > 1){
			$arrow = '<i class=\'ditp-icon icon-ico-ditp-43\'></i>';
		}else {
			$arrow = '';
		}
		$ref_name_real = $ref_name."/".$prod_type["prodType_name"];
		$option .= '<option '.$disabled.' value="'.$prod_type["prodType_id"].'" rel="'.$prod_type["prodType_level"].'" data-content="<span class=\'txt\' style=\'padding-left:'.(20*($lv)).'px\'>'.$arrow.'<h style=\'display:none;\'>'.$ref_name_real.'</h>'.$prod_type["prodType_name"].'</span>" >
								'.$prod_type["prodType_name"].'
							</option>';
		if($prod_type["prodType_sublist"]>0){
			$n_lv = $lv+1;
			$option .= getProdType_rpt($n_lv,$prod_type["prodType_id"],$ref_name_real,$value_office);
		}
		if($lv==1){
			$option .= '</optgroup>';
		}
		$i++;

	}
	return $option;
}

	function set_prodType($value_office){
		$res = '<select class="selectpicker form-control select-product-type" data-live-search="true" name="prodType_id"  onchange="set_officeType_ofReport(this);">
<option value="">- ประเภทสินค้าทั้งหมด - </option>'.getProdType_rpt(1,null,null,$value_office).'</select>';
			return $res;
	}




?>
