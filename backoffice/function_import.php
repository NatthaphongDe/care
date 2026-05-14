<?php
require_once('../config/config.php');
include("class/main.class.php");
include("class/case.class.php");
$caseLst_cls = new case_list();

/** PHPExcel */
include 'class/PHPExcel-1.8/Classes/PHPExcel.php';

/** PHPExcel_IOFactory - Reader */
require_once 'class/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';

// function deleteDirectory($dirPath) {
// 	if (is_dir($dirPath)) {
// 		$objects = scandir($dirPath);
// 		foreach ($objects as $object) {
// 			if ($object != "." && $object !="..") {
// 				if (filetype($dirPath . DIRECTORY_SEPARATOR . $object) == "dir") {
// 					deleteDirectory($dirPath . DIRECTORY_SEPARATOR . $object);
// 				} else {
// 					unlink($dirPath . DIRECTORY_SEPARATOR . $object);
// 				}
// 			}
// 		}
// 	reset($objects);
// 	rmdir($dirPath);
// 	}
// }
//
//
//
//
// $file_ext_list = array("xls","xlsx");
// if($_FILES["import_file"]["name"]!=""){
//
//   //deleteDirectory("../data/tmp_import");
//
//
//   //$image = new ImageResize($_FILES["prodPic"]["tmp_name"]);
//   //$image->resizeToBestFit(500, 300);
//   $ext = pathinfo($_FILES["import_file"]["name"], PATHINFO_EXTENSION);
//   $new_file_name = 'prodMeasure_'.time().".".$ext;
//
//   if(!(in_array($ext,$file_ext_list))){
//
//   }
//
//   if (!is_dir("../data/tmp_import")){
//     mkdir("../data/tmp_import", 0777, true);
//   }
//   if(move_uploaded_file($_FILES["import_file"]["tmp_name"],"../data/tmp_import/$new_file_name")){
//
//   }
// }

//$inputFileName = "../data/tmp_report/report_1500561903.xlsx";
$inputFileName = "case_58_59_60.xlsx";
$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objReader->setReadDataOnly(true);
$objPHPExcel = $objReader->load($inputFileName);

$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
$highestRow = $objWorksheet->getHighestRow();
$highestColumn = $objWorksheet->getHighestColumn();

$headingsArray = $objWorksheet->rangeToArray('A1:'.$highestColumn.'1',null, true, true, true);
$headingsArray = $headingsArray[1];
$r = -1;
$namedDataArray = array();
//ทำการดึงข้อมูลในแต่ละแถว เก็บใว้ในตัวแปล array โดยมี Index เป็นชื่อของ Colum (แถวแรก)
// for ($row = $highestRow; $row >= 3; --$row) {}
for ($row = 3; $row <= $highestRow; ++$row) {
	$dataRow = $objWorksheet->rangeToArray('A'.$row.':'.$highestColumn.$row,null, true, true, true);
	if ((isset($dataRow[$row]['A'])) && ($dataRow[$row]['A'] > '')) {
		++$r;
		foreach($headingsArray as $columnKey => $columnHeading) {
			$namedDataArray[$r][$columnKey] = $dataRow[$row][$columnKey];
      // echo $columnKey."-";
      // echo $dataRow[$row][$columnKey];
      // echo "<br />";
		}
	}
}
//ทำการวนลูปเพื่อ Insert ข้อมูลลง MySQL
$insert_num = 0;
$update_num = 0;

$status_arr = array("อยู่ระหว่างดำเนินการ"=>2, "ยุติแล้ว"=>3);

$caseLst_cls->case_country = $caseLst_cls->countryList();
$countryList = array();
foreach($caseLst_cls->case_country as $case_country_list){
	$countryList[$case_country_list["name"]] = $case_country_list["id"];
}

$caseLst_cls->case_province = $caseLst_cls->provinceList();
$provinceList = array();
foreach($caseLst_cls->case_province as $case_province_list){
	$provinceList[$case_province_list["prov_name"]] = $case_province_list["prov_id"];
}

$caseLst_cls->case_channal = $caseLst_cls->caseChannelList();
foreach ($caseLst_cls->case_channal  as $key => $value) {
	$case_channal_list[$value] = $key;
}

$caseLst_cls->prod_type = $caseLst_cls->prodTypeList();
foreach ($caseLst_cls->case_channal  as $key => $value) {
	$product_list[$value] = $key;
}

$priority_list_css = $caseLst_cls->prioritySelectList("all");
foreach ($priority_list_css  as $key => $value) {
	$priority_list[$value] = $key;
}
$caseLst_cls->dbConn->begin_transaction();
foreach ($namedDataArray as $result) {
  //print_r($result);
  $col = array();

	$result["A"] = PHPExcel_Style_NumberFormat::toFormattedString($result["A"],PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
	if($result["A"]!=""){
		$date_a = explode("/", $result["A"]);
		if($date_a[2]<2000){
			$date_a[2] = "20".$date_a[2];
		}
		$result_date_a = $date_a[2]."-".sprintf("%02d",$date_a[1])."-".sprintf("%02d",$date_a[0]);
	}else{
		$result_date_a = null;
	}


	$result["B"] = PHPExcel_Style_NumberFormat::toFormattedString($result["B"],PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);

	if($result["B"]!=""){
		$date_b = explode("/", $result["B"]);
		if($date_b[2]<2000){
			$date_b[2] = "20".$date_b[2];
		}
		$result_date_b = $date_b[2]."-".sprintf("%02d",$date_b[1])."-".sprintf("%02d",$date_b[0]);
	}else{
		$result_date_b = null;
	}


	$result["AB"] = PHPExcel_Style_NumberFormat::toFormattedString($result["AB"],PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
	if($result["AB"]!=""){
		$date_ab = explode("/", $result["AB"]);
		if($date_ab[2]<2000){
			$date_ab[2] = "20".$date_ab[2];
		}
		$result_date_ab = $date_ab[2]."-".sprintf("%02d",$date_ab[1])."-".sprintf("%02d",$date_ab[0]);
	}else{
		$result_date_ab = null;
	}



	$col["case_create_datetime"] = $result_date_a!=null?$result_date_a." 08:00:00":'NULL';
	$col["case_lastSave_datetime"] = $result_date_a!=null?$result_date_a." 08:00:00":'NULL';
	$col["case_notice_applnt_datetime"] = $result_date_a!=null?$result_date_a." 08:00:00":'NULL';
	$col["case_setsubject_datetime"] = $result_date_a!=null?$result_date_a." 08:00:00":'NULL';
	$col["case_opened_datetime"] = $result_date_a!=null?$result_date_a." 08:00:00":'NULL';
	$col["case_open_date"] = $result_date_a!=null?$result_date_a:'NULL';

	$col["case_receivedoc_number"] = $caseLst_cls->data_filter($result["C"]);
	$col["case_receivedoc_date"] = $result_date_b;
	$col["case_receivedoc_real_datetime"] = $result_date_b;

	$caseCh_name = $case_channal_list[$result["D"]];
	$col["caseCh_id"] = $caseCh_name;
	$col["compType_id"] = substr(trim($result["E"]), 0, 1);
	$col["compTypeSub1_id"] = substr(trim($result["F"]), 0, 1);
	if($col["compType_id"]=="1" && $col["compTypeSub1_id"]=="1"){
		$col["compTypeSub2_id"] = substr(trim($result["G"]), 0, 1);
	}
	if($col["compType_id"]=="1" && $col["compTypeSub1_id"]=="2"){
			$col["compTypeSub2_id"] = substr(trim($result["G"]), 0, 1);
			$col["compTypeSub2_id"] = 4+(int)$col["compTypeSub2_id"];
	}


	if($col["compType_id"]=="2"){
		$col["compType_id"]="4";
		$itm_compType_oth_old = array("(", ")");
		$itm_compType_oth_new = array("", "");
		$col["compType_other"] = trim(str_replace($itm_compType_oth_old, $itm_compType_oth_new, substr($result["E"],1)));
	}else{
		$col["compType_other"] = "";
	}


	$comp_type_data = $caseLst_cls->compTypeDetail($col["compType_id"]);
	if($comp_type_data["compType_other_flag"]=="1"){
		$col["compTypeSub1_id"] = "0";
		$col["compTypeSub2_id"] = "0";
	}

	$col["case_priority"] = $result["H"];
	$col["caseDtl_title"] = $caseLst_cls->data_filter($result["U"]);
	$col["prodType_id"] = $caseLst_cls->data_filter($result["V"]);

	if($product_list[$col["prodType_id"]]!=""){
		$prodType_id = $product_list[$col["prodType_id"]];
		$prodType_other = "";
	}else{
		$prodType_id = "1251";
		$prodType_other = $col["prodType_id"];
		$col["prodType_id"] = $prodType_id;
		$col["prodType_other"] = $prodType_other;
	}

	$col["caseDtl_complnt_need"] = $caseLst_cls->data_filter($result["W"]);
	$col["caseDtl_damage_val"] = str_replace($result["X"],",","");
	$col["curren_id"] = $caseLst_cls->data_filter($result["Y"]);
	$col["case_status"] = $status_arr[$result["AA"]];


	if($status_arr[$result["AA"]]==3){
		$col["caseClose_id"] = 2;
		$col["case_close_datetime"] = $result_date_ab!=null?$result_date_ab." 08:00:00":'NULL';
		$col["case_close_resultProcess"] = $caseLst_cls->data_filter($result["AC"]);
	}

	$col["applnt_firstname"] = $caseLst_cls->data_filter($result["I"]);
	$col["applntOrg_name"] = $caseLst_cls->data_filter($result["I"]);
	$col["applntOrg_trade_number"] = $caseLst_cls->data_filter($result["J"]);
	$col["applntOrg_import_export"] = $caseLst_cls->data_filter($result["K"]);
	$col["applnt_tel"] = $caseLst_cls->data_filter($result["L"]);
	$col["applntOrg_tel"] = $caseLst_cls->data_filter($result["L"]);
	$col["applnt_address"] = $caseLst_cls->data_filter($result["M"]);
	$col["applntOrg_address"] = $caseLst_cls->data_filter($result["M"]);
	foreach ($caseLst_cls->case_channal  as $key => $value) {
		if (strpos($result["M"], $value) !== false) {
			$col["applnt_prov_id"] = $provinceList[$value];
			$col["applntOrg_prov_id"] = $provinceLis[$value];
		}else{
			$col["applnt_prov_id"] = "";
			$col["applntOrg_prov_id"] = "";
		}
	}

	// $col["applnt_prov_id"] = $provinceList[$result["V"]];
	// $col["applntOrg_prov_id"] = $provinceLis[$result["V"]];
	$col["applnt_country_id"] = $countryList[$caseLst_cls->data_filter($result["N"])];
	$col["applntOrg_country_id"] = $countryList[$caseLst_cls->data_filter($result["N"])];
	$col["applnt_type"] = 1;
	$col["applnt_status"] = 0;


	$col["complnt_firstname"] = $caseLst_cls->data_filter($result["O"]);
	$col["complntOrg_name"] = $caseLst_cls->data_filter($result["O"]);
	$col["complntOrg_trade_number"] = $caseLst_cls->data_filter($result["P"]);
	$col["complntOrg_import_export"] = $caseLst_cls->data_filter($result["Q"]);
	$col["complnt_tel"] = $caseLst_cls->data_filter($result["R"]);
	$col["complntOrg_tel"] = $caseLst_cls->data_filter($result["R"]);
	$col["complnt_address"] = $caseLst_cls->data_filter($result["S"]);
	$col["complntOrg_address"] = $caseLst_cls->data_filter($result["S"]);
	foreach ($caseLst_cls->case_channal  as $key => $value) {
		if (strpos($result["S"], $value) !== false) {
			$col["complnt_prov_id"] = $provinceList[$value];
			$col["complntOrg_prov_id"] = $provinceLis[$value];
		}else{
			$col["complnt_prov_id"] = "";
			$col["complntOrg_prov_id"] = "";
		}
	}
	$col["complnt_country_id"] = $countryList[$caseLst_cls->data_filter($result["T"])];
	$col["complntOrg_country_id"] = $countryList[$caseLst_cls->data_filter($result["T"])];
	$col["complnt_type"] = 1;
	$col["complnt_status"] = 0;


	if($result["AE"]!=""){
		$sql_emp_assign = "SELECT *FROM Employee WHERE emp_firstname LIKE '%".$result["AE"]."' AND emp_status=0 AND emp_id>=14 ";
		$query_emp_assign = $caseLst_cls->dbConn->query($sql_emp_assign);
		$count_emp_assign = $query_emp_assign->num_rows;
		if($count_emp_assign>0){
			$col["case_assign_status"] = 1;
		}else{
			$col["case_assign_status"] = 0;
		}
	}else{
		$col["case_assign_status"] = 0;
	}


	$status_ins = true;
		$sql_case = "INSERT
							    INTO
							      `Case`(
											`compType_id`,
											`compTypeSub1_id`,
											`compTypeSub2_id`,
											`compType_other`,
											`case_status`,
											`case_assign_status`,
											`caseCh_id`,
											`case_priority`,
											`case_compType_duration`,
											`case_open_date`,
											`case_receivedoc_date`,
											`case_receivedoc_real_datetime`,
											`case_receivedoc_number`,
											`case_close_datetime`,
											`case_close_createBy_id`,
											`caseClose_id`,
											`case_close_resultProcess`,
											`caseDtl_title`,
											`prodType_id`,
											`prodType_other`,
											`caseDtl_derivation`,
											`caseDtl_damage_val`,
											`curren_id`,
											`applntOrg_trade_number`,
											`applntOrg_name`,
											`applnt_ident`,
											`applnt_firstname`,
											`applnt_lastname`,
											`applnt_type`,
											`applnt_ident_valid`,
											`applnt_status`,
											`complntOrg_trade_number`,
											`complntOrg_name`,
											`complnt_ident`,
											`complnt_firstname`,
											`complnt_lastname`,
											`complnt_type`,
											`complnt_ident_valid`,
											`complnt_status`,
											`applnt_trade_number`,
											`applnt_name`,
											`complnt_trade_number`,
											`complnt_name`,
											`applnt_country_id`,
											`complnt_country_id`,
											`applntOrg_country_id`,
											`case_create_datetime`,
											`case_createBy_id`,
											`case_lastSave_datetime`,
											`case_lastSave_id`,
											`case_notice_applnt_datetime`,
											`case_notice_applnt_createBy_id`,
											`case_setsubject_datetime`,
											`case_setsubject_createBy_id`,
											`case_opened_datetime`,
											`case_opened_createBy_id`,
											`case_step_noti`
							      )
							VALUES(
								'".$col["compType_id"]."',
								'".$col["compTypeSub1_id"]."',
								'".$col["compTypeSub2_id"]."',
								'".$col["compType_other"]."',
								'".$col["case_status"]."',
								'".$col["case_assign_status"]."',
								'".$col["caseCh_id"]."',
								'".$col["case_priority"]."',
								'".$comp_type_data["compType_duration"]."',
								".($col["case_open_date"]!=null?"'".$col["case_open_date"]."'":'NULL').",
								".($col["case_receivedoc_date"]!=null?"'".$col["case_receivedoc_date"]."'":'NULL').",
								".($col["case_receivedoc_real_datetime"]!=null?"'".$col["case_receivedoc_real_datetime"]."'":'NULL').",
								'".$col["case_receivedoc_number"]."',
								".($col["case_close_datetime"]!=null?"'".$col["case_close_datetime"]."'":'NULL').",
								'".$col["case_close_createBy_id"]."',
								'".$col["caseClose_id"]."',
								'".$col["case_close_resultProcess"]."',
								'".$col["caseDtl_title"]."',
								'".$prodType_id."',
								'".$prodType_other."',
								'".$col["caseDtl_derivation"]."',
								'".$col["caseDtl_damage_val"]."',
								'".$col["curren_id"]."',
								'".$col["applntOrg_trade_number"]."',
								'".$col["applntOrg_name"]."',
								'".$col["applnt_ident"]."',
								'".$col["applnt_firstname"]."',
								'".$col["applnt_lastname"]."',
								'".$col["applnt_type"]."',
								'".$col["applnt_ident_valid"]."',
								'".$col["applnt_status"]."',
								'".$col["complntOrg_trade_number"]."',
								'".$col["complntOrg_name"]."',
								'".$col["complnt_ident"]."',
								'".$col["complnt_firstname"]."',
								'".$col["complnt_lastname"]."',
								'".$col["complnt_type"]."',
								'".$col["complnt_ident_valid"]."',
								'".$col["complnt_status"]."',
								'".$col["applnt_trade_number"]."',
								'".$col["applnt_name"]."',
								'".$col["complnt_trade_number"]."',
								'".$col["complnt_name"]."',
								'".$col["applnt_country_id"]."',
								'".$col["complnt_country_id"]."',
								'".$col["applntOrg_country_id"]."',
								".($col["case_create_datetime"]!=null?"'".$col["case_create_datetime"]."'":'NULL').",
								'1',
								".($col["case_lastSave_datetime"]!=null?"'".$col["case_lastSave_datetime"]."'":'NULL').",
								'1',
								".($col["case_notice_applnt_datetime"]!=null?"'".$col["case_notice_applnt_datetime"]."'":'NULL').",
								'1',
								".($col["case_setsubject_datetime"]!=null?"'".$col["case_setsubject_datetime"]."'":'NULL').",
								'1',
								".($col["case_opened_datetime"]!=null?"'".$col["case_opened_datetime"]."'":'NULL').",
								'1',
								'4'
							)";
	  $qr_ins_case = $caseLst_cls->dbConn->query($sql_case);

	  if($qr_ins_case){

			$last_case_id = $caseLst_cls->dbConn->insert_id;;

			$frm_arr = array();
			if($comp_type_data["compType_other_flag"]==0){
				$sql_frmSet = "SELECT * FROM `Form_Link_Complaint_Type` WHERE `compType_id`='".$col["compType_id"]."' AND `compTypeSub1_id`='".$col["compTypeSub1_id"]."' AND `compTypeSub2_id`='0' ";
			}else if($comp_type_data["compType_other_flag"]==1){
				$sql_frmSet = "SELECT * FROM `Form_Link_Complaint_Type` WHERE `compType_id`='".$col["compType_id"]."' AND `compTypeSub1_id`='0' AND `compTypeSub2_id`='0' ";
			}
			//echo $sql_frmSet;
			$qr_frmSet = $caseLst_cls->dbConn->query($sql_frmSet);
			while($rs_frmSet = $qr_frmSet->fetch_assoc()){
				array_push($frm_arr,$rs_frmSet["frmset_id"]);
			}
			// echo $comp_type_data["compType_other_flag"];
			// print_r($frm_arr);
			// echo "<hr />";

			$sql_field = "SELECT * FROM `Field_Set` WHERE `frmset_id`='".$frm_arr[0]."' OR `frmset_id`='".$frm_arr[1]."' OR `frmset_id`='".$frm_arr[2]."' ";
			$qr_field = $caseLst_cls->dbConn->query($sql_field);
			while($rs_field = $qr_field->fetch_assoc()){
				foreach ($col as $key => $value) {
					if($rs_field["fieldset_name"]==$key){
						// echo $key."---".$rs_field["fieldset_name"]."---".$value;
						// echo "<br />";
						$sql_ins_field = "INSERT INTO `Field_Values`(`case_id`, `fieldset_id`, `fieldset_value`)
															VALUE (
																'$last_case_id', '".$rs_field["fieldset_id"]."', '$value'
															)";
						$qr_ins_field = $caseLst_cls->dbConn->query($sql_ins_field);
						if(!$qr_ins_field){
							echo $sql_ins_field;
							// echo "<br />";
							// echo "<br />";
							$status_ins = false;
						}

					}
				}
			}


			if($result["Z"]!=""){

				$process_type_dt = $caseLst_cls->caseProcessTypeList("all",$caseLst_cls->admin_section,"process_type_duration");
	      $process_type_duration = $process_type_dt[1]; //ระยะเวลา
	      $date_over_init = date('Y-m-d', strtotime('+'.$process_type_duration.' day', time()));
	      $day_over_subholiday = (int)$caseLst_cls->getHoliday($col["case_create_datetime"],$date_over_init);
	      $date_over_result = date('Y-m-d H:i:s', strtotime('+'.($process_type_duration+$day_over_subholiday).' day', time()));

				if($result["Z"]==4){
						$dept_type_dt = $caseLst_cls->caseProcessTypeList("all",$caseLst_cls->admin_section,"dept_type");
						foreach ($dept_type_dt as $key => $value) {
							$dept_type_list[$value] = $key;
						}

						if($dept_type_list[$result["D"]]==-1 || $dept_type_list[$result["D"]]==""){
								$dept_id = "";
						}else{
								$dept_id = $dept_type_list[$result["D"]];
						}

				}else{
					$dept_id = "";
				}
				$sql_ins_process1 = "INSERT
								INTO
									`Process`(
										`case_id`,
										`process_status`,
										`process_type_id`,
										`dept_id`,
										`process_type_duration`,
										`process_save_datetime`,
										`process_complete_datetime`,
										`process_over_datetime`,
										`process_create_datetime`,
										`process_createBy_id`
									)
								VALUES(
									'$last_case_id',
									'1',
									'".$result["Z"]."',
									'".$dept_id."',
									'$process_type_duration',
									".($col["case_create_datetime"]!=null?"'".$col["case_create_datetime"]."'":'NULL').",
									".($col["case_create_datetime"]!=null?"'".$col["case_create_datetime"]."'":'NULL').",
									UNIX_TIMESTAMP('$date_over_result'),
									".($col["case_create_datetime"]!=null?"'".$col["case_create_datetime"]."'":'NULL').",
									'".$caseLst_cls->admin_id."'
								)";
				$qr_ins_process1 = $caseLst_cls->dbConn->query($sql_ins_process1);
				if(!$qr_ins_process1){
						echo $sql_ins_process1;
						echo "<br />";
						echo "<br />";
					$status_ins = false;
				}

			}

			if($result["AE"]!=""){

				$sql_emp_assign = "SELECT *FROM Employee WHERE emp_firstname LIKE '%".$result["AE"]."' AND emp_status=0 AND emp_id>=14 ";
		    $query_emp_assign = $caseLst_cls->dbConn->query($sql_emp_assign);
		    $count_emp_assign = $query_emp_assign->num_rows;
				if($count_emp_assign>0){
					$rs_emp_assign = $query_emp_assign->fetch_assoc();
					//-- บันทึก ข้อมูล Assign Case --//
					$sql_ins_assign = "INSERT
															INTO
																`Case_Assign`(
																	`case_id`,
																	`caseAsign_status`,
																	`emp_id`,
																	`caseAsign_disKPI`,
																	`caseAsign_create_datetime`,
																	`caseAsign_createBy_id`
																)
															VALUES(
																'$last_case_id',
																'0',
																'".$rs_emp_assign["emp_id"]."',
																'0',
																NOW(),
																'".$caseLst_cls->admin_id."'
															) ";

					$qr_ins_assign = $caseLst_cls->dbConn->query($sql_ins_assign);
					if(!$qr_ins_assign){
								echo $sql_ins_assign;
								echo "<br />";
								echo "<br />";
						$status_ins = false;
					}
				}

			}
    }else{
			echo $sql_case;
			echo "<br />";
			echo "<br />";
			$status_ins = false;
		}

	if(!$status_ins){
		echo "<hr />";
		$caseLst_cls->dbConn->rollback();
	}else{
		$insert_num++;
		$caseLst_cls->dbConn->commit();
	}
}

echo "เพิ่มเรื่องร้องเรียนทั้งหมดทั้งหมด $insert_num รายการ";
?>
<!-- <script>
	var text_alert = "";
	text_alert +=  '<?php echo "เพิ่มเรื่องร้องเรียนทั้งหมดทั้งหมด $insert_num รายการ" ?>" ?>';
	<?php


	?>
  alert(text_alert);
  window.parent.location.reload();
</script> -->
