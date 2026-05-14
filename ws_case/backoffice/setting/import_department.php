<?php
session_start();
$date_setting = date("Y-m-d h:i:sa");
$emp_id = $_SESSION["admin"]["empId"];
$emp_section = $_SESSION["admin"]["empSection"];
include('../../config/config.php');
require_once 'library/PHPExcel-1.8/Classes/PHPExcel.php';
include 'library/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';
$hospital_select = $_POST['hospital_id'];
$importsuccess = 0;
$updatesuccess = 0;
$loop = 0;
$importerror = 0;
$importerror_t = 0;
$ownererror = 0;
$error = 0;
$inputFileName = $_POST['excel_file'];
// exit();
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
$rowarr=0;

if ($highestRow<3) {
?>
<div class="setup-list">
	<div class="col-xs-12 col-xs-9  no-margin-padding">
		<div class="setup-text-list" style="color:#F00; text-align: center;">
			No data
		</div>
	</div>
	<div class="col-xs-12 col-xs-3  no-margin-padding text-right">
		<div class="countitem"  style="color:#F00;">
		</div>
	</div>
</div>
<?php
	exit();
}

//checkheader format
for ($row = 1; $row <= $highestRow; ++$row) {
	$dataRow = $objWorksheet->rangeToArray('A'.$row.':'.$highestColumn.$row,null, true, true, true);
	if ($row == 1) {
		if(	$dataRow[$row]['A'] != "ประเภท*"
				|| $dataRow[$row]['B'] != "ประเภทหน่วยงาน*"
				|| $dataRow[$row]['C'] != "ทวีป"
				|| $dataRow[$row]['D'] != "ประเทศ"
				|| $dataRow[$row]['E'] != "ชื่อหน่วยงาน*"
				|| $dataRow[$row]['F'] != "สังกัด"
				|| $dataRow[$row]['G'] != "ชื่อผู้อำนวยการ*"
				|| $dataRow[$row]['H'] != "ชื่อผู้ช่วย/ประสานงาน"
				|| $dataRow[$row]['I'] != "หมายเลขโทรศัพท์*"
				|| $dataRow[$row]['J'] != "หมายเลขแฟกซ์"
				|| $dataRow[$row]['K'] != "อีเมล์"
				|| $dataRow[$row]['L'] != "ที่อยู่"
				|| $dataRow[$row]['M'] != "ข้อความแจ้งเตือนกรณีเลือกหน่วยงาน (ไทย)"
				|| $dataRow[$row]['N'] != "ข้อความแจ้งเตือนกรณีเลือกหน่วยงาน (Eng)") {

			if ($dataRow[$row]['A'] != "ประเภท*"){ $errorcolumn .= $dataRow[$row]['A'].","; }
			if ($dataRow[$row]['B'] != "ประเภทหน่วยงาน*"){ $errorcolumn .= $dataRow[$row]['B'].","; }
			if ($dataRow[$row]['C'] != "ทวีป") { $errorcolumn .="C,"; }
			if ($dataRow[$row]['D'] != "ประเทศ") { $errorcolumn .="D,"; }
			if ($dataRow[$row]['E'] != "ชื่อหน่วยงาน*") { $errorcolumn .="E,"; }
			if ($dataRow[$row]['F'] != "สังกัด") { $errorcolumn .="F,"; }
			if ($dataRow[$row]['G'] != "ชื่อผู้อำนวยการ*") { $errorcolumn .="G,"; }
			if ($dataRow[$row]['H'] != "ชื่อผู้ช่วย/ประสานงาน") { $errorcolumn .="H,"; }
			if ($dataRow[$row]['I'] != "หมายเลขโทรศัพท์*") { $errorcolumn .="I,"; }
			if ($dataRow[$row]['J'] != "หมายเลขแฟกซ์") { $errorcolumn .="J,"; }
			if ($dataRow[$row]['K'] != "อีเมล์") { $errorcolumn .="K,"; }
			if ($dataRow[$row]['L'] != "ที่อยู่") { $errorcolumn .="L,"; }
			if ($dataRow[$row]['M'] != "ข้อความแจ้งเตือนกรณีเลือกหน่วยงาน (ไทย)") { $errorcolumn .="M,"; }
			if ($dataRow[$row]['N'] != "ข้อความแจ้งเตือนกรณีเลือกหน่วยงาน (Eng)") { $errorcolumn .="N,"; }

			?>
			<div class="setup-list">
				<div class="col-xs-12 col-xs-9  no-margin-padding">
					<div class="setup-text-list" style="color:#F00;">
						Excel file format error please try again. <?php echo substr($errorcolumn, 0, -1);?>
					</div>
				</div>
				<div class="col-xs-12 col-xs-3  no-margin-padding text-right">
					<div class="countitem"  style="color:#F00;">
					</div>
				</div>
			</div>
			<?php
			exit();
		}
	}
		++$r;
		$col=0;
		if ($row>=3) {
			foreach($headingsArray as $columnKey => $columnHeading) {
				$namedDataArray[$rowarr][$col] = trim(PHPExcel_Shared_String::SanitizeUTF8($dataRow[$row][$columnKey]));
				$col++;
			}
			$rowarr++;
		}
}

for ($i=0;$i<$rowarr;$i++) {
	$sql_card= "select id FROM `Country`  where continent_code = '".$namedDataArray[$i][2]."' AND  name = '".$namedDataArray[$i][3]."' AND country_status = '0'";
	$query_card = $conn->query($sql_card);
	if ($query_card->num_rows>0) {
			$result_card = $query_card->fetch_assoc();
			$country_id = $result_card['id'];
	}else{
		$country_id = 0;
	}

  			if ( $namedDataArray[$i][0]!="" && $namedDataArray[$i][1]!="" && $namedDataArray[$i][4]!="" && $namedDataArray[$i][6]!="" && $namedDataArray[$i][8]!=""){

				if($namedDataArray[$i][0]==1 || $namedDataArray[$i][0]==2 || $namedDataArray[$i][0]==3){
				  $section = $namedDataArray[$i][0]==1;
				}else{
				  $section = 0;
				}

				if($namedDataArray[$i][1]!=2){
					$namedDataArray[$i][5] = '';
				}

				if($namedDataArray[$i][1]==1){
					$namedDataArray[$i][11] = '';
				}


				$sql_card  = " SELECT dept_id  FROM  Department where dept_name = '".$namedDataArray[$i][4]."' AND dept_type = '".$namedDataArray[$i][1]."'  AND dept_status = 0 ";
				$query_card = $conn->query($sql_card);
				if ($query_card->num_rows>0) {
		      while($result_card = $query_card->fetch_assoc())
		      {
		        $id_p = $result_card['dept_id'];
		       	$sql_edit = "UPDATE Department SET
													dept_affiliation = '".$namedDataArray[$i][5]."'
		                      ,dept_director   = '".$namedDataArray[$i][6]."'
		                      ,dept_assistant = '".$namedDataArray[$i][7]."'
		                      ,dept_tel = '".$namedDataArray[$i][8]."'
		                      ,dept_fax =  '".$namedDataArray[$i][9]."'
		                      ,dept_email = '".$namedDataArray[$i][10]."'
		                      ,dept_address = '".$namedDataArray[$i][11]."'
		                      ,country_id = '$country_id'
													,dept_update_datetime =  '$date_setting'
													,dept_updateBy_id = '$emp_id'
													,dept_message_noti = '".$namedDataArray[$i][12]."'
													,dept_message_noti_en = '".$namedDataArray[$i][13]."'
		                      where  dept_id = '$id_p'";
		            $query_edit = $conn->query($sql_edit);
								if($query_edit){
										$updatesuccess++;
										$loop++;
									}else{
										$importerror++;
										$error_row[$loop]=$i;
								}
		      }

				}else{



					$sql_add = "INSERT INTO `Department`(`dept_name`, `dept_affiliation`, `dept_director`, `dept_tel`, `dept_fax`, `dept_address`, `dept_email`, `dept_assistant`, `country_id`, `dept_type`
																	,  `dept_section`,`dept_create_datetime`, `dept_createBy_id`,dept_enable,`dept_message_noti`,dept_message_noti_en)
											VALUES ('".$namedDataArray[$i][4]."'
															,'".$namedDataArray[$i][5]."'
															,'".$namedDataArray[$i][6]."'
															,'".$namedDataArray[$i][8]."'
															,'".$namedDataArray[$i][9]."'
															,'".$namedDataArray[$i][11]."'
															,'".$namedDataArray[$i][10]."'
															,'".$namedDataArray[$i][7]."'
															,'$country_id'
															,'".$namedDataArray[$i][1]."'
															,'$section'
															,'$date_setting'
															,'$emp_id'
															,'1'
															,'".$namedDataArray[$i][12]."'
															,'".$namedDataArray[$i][13]."')";
					$query_add = $conn->query($sql_add);
// echo					$sql_add;
					if($query_add){
		          $importsuccess++;
		          $loop++;
		        }else{
		          $importerror++;
		          $error_row[$loop]=$i;
		      }
		    }
	}else {
		$error++;

?>
<div class="setup-list" style="">
<?php
	$errcolumn ="";
	$errcolumn ="";

	if ($namedDataArray[$i][0]=="") { $errcolumn .= " หน่วยงาน*,"; }
	if ($namedDataArray[$i][1] =="") { $errcolumn .=" ประเภทหน่วยงาน*,"; }
	if ($namedDataArray[$i][4] =="") { $errcolumn .=" สำนักงานในต่างประเทศ*,"; }
	if ($namedDataArray[$i][6] =="") { $errcolumn .=" ชื่อผู้อำนวยการ*,"; }
	if ($namedDataArray[$i][8] =="") { $errcolumn .=" หมายเลขโทรศัพท์*,"; }

?>
	<div class="col-xs-12 col-xs-9  no-margin-padding">
		<div class="setup-text-list" style="color:#F00;">
		 Data Error in row --> <?php  echo $i+3;?> - Column (<?php echo substr($errcolumn, 0, -1); ?> )
		</div>
	</div>
	<div class="col-xs-12 col-xs-3  no-margin-padding text-right">
		<div class="countitem"  style="color:#F00;">

		</div>
	</div>
</div>
<?php
	}
}

if ($importsuccess!=0) {
?>
<div class="setup-list">
	<div class="col-xs-9 col-xs-9  no-margin-padding">
		<div class="setup-text-list" style="color:#090;">
			Import Success
		</div>
	</div>
	<div class="col-xs-3 col-xs-3  no-margin-padding text-right">
		<div class="countitem"  style="color:#090;">
			<?php echo $importsuccess; ?> Record
		</div>
	</div>
</div>
<?php
}else{
  ?>
  <div class="setup-list">
  	<div class="col-xs-9 col-xs-9  no-margin-padding">
  		<div class="setup-text-list" style="color:#090;">
  			Import Success
  		</div>
  	</div>
  	<div class="col-xs-3 col-xs-3  no-margin-padding text-right">
  		<div class="countitem"  style="color:#090;">
  			<?php echo 0; ?> Record
  		</div>
  	</div>
  </div>
<?php
}
?>

<?
if ($updatesuccess!=0) {
?>
<div class="setup-list">
	<div class="col-xs-9 col-xs-9  no-margin-padding">
		<div class="setup-text-list" style="color:#090;">
			Update Success
		</div>
	</div>
	<div class="col-xs-3 col-xs-3  no-margin-padding text-right">
		<div class="countitem"  style="color:#090;">
			<?php echo $updatesuccess; ?> Record
		</div>
	</div>
</div>
<?php
}else{
  ?>
  <div class="setup-list">
  	<div class="col-xs-9 col-xs-9  no-margin-padding">
  		<div class="setup-text-list" style="color:#090;">
  			Update Success
  		</div>
  	</div>
  	<div class="col-xs-3 col-xs-3  no-margin-padding text-right">
  		<div class="countitem"  style="color:#090;">
  			<?php echo 0; ?> Record
  		</div>
  	</div>
  </div>
<?php
}
?>
<?
if ($updatesuccess!=0) {
?>
<div class="setup-list"  style="display:none">
	<div class="col-xs-9 col-xs-9  no-margin-padding">
		<div class="setup-text-list" style="color:#F00;">
			Data Error
		</div>
	</div>
	<div class="col-xs-3 col-xs-3  no-margin-padding text-right">
		<div class="countitem"  style="color:#F00;">
			<?php echo $error; ?> Record
		</div>
	</div>
</div>
<?php
}else{
  ?>
  <div class="setup-list" style="display:none">
  	<div class="col-xs-9 col-xs-9  no-margin-padding">
  		<div class="setup-text-list" style="color:#F00;">
  			Data Error
  		</div>
  	</div>
  	<div class="col-xs-3 col-xs-3  no-margin-padding text-right">
  		<div class="countitem"  style="color:#F00;">
  			<?php echo 0; ?> Record
  		</div>
  	</div>
  </div>
<?php
}
?>
