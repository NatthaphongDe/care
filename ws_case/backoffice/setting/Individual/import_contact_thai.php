<?php
session_start();
$date_setting = date("Y-m-d h:i:sa");
$emp_id = $_SESSION["admin"]["empId"];
$emp_section = $_SESSION["admin"]["empSection"];
include('../../../config/config.php');
require_once '../library/PHPExcel-1.8/Classes/PHPExcel.php';
include '../library/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';
$hospital_select = $_POST['hospital_id'];
$importsuccess = 0;
$updatesuccess = 0;
$loop = 0;
$importerror = 0;
$importerror_t = 0;
$ownererror = 0;
$error = 0;
// echo
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
		if(	$dataRow[$row]['A'] != "เลขบัตรประชาชน"
				|| $dataRow[$row]['B'] != "ชื่อ*"
				|| $dataRow[$row]['C'] != "นามสกุล*"
				|| $dataRow[$row]['D'] != "เลขนิติบุคคล"
				|| $dataRow[$row]['E'] != "ประเภทธุรกิจ*"
				|| $dataRow[$row]['F'] != "ตำแหน่ง"
				|| $dataRow[$row]['G'] != "เบอร์โทรศัพท์*"
				|| $dataRow[$row]['H'] != "เบอร์โทรศัพท์มือถือ"
				|| $dataRow[$row]['I'] != "E-mail*"
				|| $dataRow[$row]['J'] != "ที่อยู่ติดต่อ*"
				|| $dataRow[$row]['K'] != "จังหวัด"
				|| $dataRow[$row]['L'] != "รหัสไปรษณีย์" ) {

			if ($dataRow[$row]['A'] != "เลขบัตรประชาชน"){ $errorcolumn .= $dataRow[$row]['A'].","; }
			if ($dataRow[$row]['B'] != "ชื่อ*") { $errorcolumn .="B,"; }
			if ($dataRow[$row]['C'] != "นามสกุล*") { $errorcolumn .="C,"; }
			if ($dataRow[$row]['D'] != "เลขนิติบุคคล") { $errorcolumn .="D,"; }
			if ($dataRow[$row]['E'] != "ประเภทธุรกิจ*") { $errorcolumn .="H,"; }
			if ($dataRow[$row]['F'] != "ตำแหน่ง") { $errorcolumn .="H,"; }
			if ($dataRow[$row]['G'] != "เบอร์โทรศัพท์*") { $errorcolumn .="H,"; }
			if ($dataRow[$row]['H'] != "เบอร์โทรศัพท์มือถือ") { $errorcolumn .="H,"; }
			if ($dataRow[$row]['I'] != "E-mail*") { $errorcolumn .="I,"; }
			if ($dataRow[$row]['J'] != "ที่อยู่ติดต่อ*") { $errorcolumn .="J,"; }
			if ($dataRow[$row]['K'] != "จังหวัด") { $errorcolumn .="K,"; }
			if ($dataRow[$row]['L'] != "รหัสไปรษณีย์") { $errorcolumn .="L,"; }
			// ?>
			<div class="setup-list">
				<div class="col-xs-12 col-xs-9  no-margin-padding">
					<div class="setup-text-list" style="color:#F00;">
						Excel file format error please try again. <?php //echo substr($errorcolumn, 0, -1);?>
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
	// }


}

for ($i=0;$i<$rowarr;$i++) {
	$sql_card= "select prov_id,prov_name from Province where prov_name = '".$namedDataArray[$i][10]."' ";
	$query_card = $conn->query($sql_card);
	if ($query_card->num_rows>0) {
		while($result_card = $query_card->fetch_assoc()) {
			$prov_id = $result_card['prov_id'];
		}
	}else{
		$prov_id = 0;
	}

  if ( $namedDataArray[$i][1]!="" && $namedDataArray[$i][2]!="" && $namedDataArray[$i][4]!="" && $namedDataArray[$i][6]!="" && $namedDataArray[$i][8]!="" && $namedDataArray[$i][9]!="") {
				// if($namedDataArray[$i][4]==1){
				// 	$sex = 1;
				// }else if($namedDataArray[$i][4]==2){
				// 	$sex = 2;
				// }else{
				// 	$sex = 0;
				// }
				if($namedDataArray[$i][0]!=''){
					$sql_card= "select ct_id,ct_card from Contact_thai where ct_card = '".$namedDataArray[$i][0]."' AND ct_status = 0 AND ct_type = '1' AND ct_section='$emp_section' ";
				}else{
					$sql_card= "select ct_id,ct_card from Contact_thai
												where ct_firstname = '".$namedDataArray[$i][1]."' AND ct_lastname = '".$namedDataArray[$i][2]."' AND ct_card = ''
												AND ct_status = 0 AND ct_type = '1' AND ct_section='$emp_section' ";
				}
				$query_card = $conn->query($sql_card);
				if ($query_card->num_rows>0) {
		      while($result_card = $query_card->fetch_assoc())
		      {

		        $id_p = $result_card['ct_id'];
		        $sql_edit = "UPDATE Contact_thai SET
							ct_firstname   = '".$namedDataArray[$i][1]."'
							,ct_lastname = '".$namedDataArray[$i][2]."'
							,ct_numbertrade = '".$namedDataArray[$i][3]."'
							,ct_business_type = '".$namedDataArray[$i][4]."'
							,ct_career = '".$namedDataArray[$i][5]."'
							,ct_homephone = '".$namedDataArray[$i][6]."'
							,ct_cellphone = '".$namedDataArray[$i][7]."'
							,ct_email = '".$namedDataArray[$i][8]."'
							,ct_address = '".$namedDataArray[$i][9]."'
							,prov_id = '$prov_id'
							,ct_postcode = '".$namedDataArray[$i][11]."'
							,ct_import = '1'
							,ct_update_datetime =  '$date_setting'
							,ct_updateBy_id = '$emp_id'
		                      where  ct_id = '$id_p'";
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



					$sql_add = "INSERT INTO Contact_thai (ct_section,ct_type,ct_card,ct_firstname,ct_lastname,ct_numbertrade,ct_business_type,ct_career
																								,ct_homephone,ct_cellphone,ct_email,ct_address,prov_id,ct_postcode,ct_department,ct_import,ct_create_datetime,ct_createBy_id)
											VALUES ('$emp_section'
															,'1'
															,'".$namedDataArray[$i][0]."'
															,'".$namedDataArray[$i][1]."'
															,'".$namedDataArray[$i][2]."'
															,'".$namedDataArray[$i][3]."'
															,'".$namedDataArray[$i][4]."'
															,'".$namedDataArray[$i][5]."'
															,'".$namedDataArray[$i][6]."'
															,'".$namedDataArray[$i][7]."'
															,'".$namedDataArray[$i][8]."'
															,'".$namedDataArray[$i][9]."'
															,'$prov_id'
															,'".$namedDataArray[$i][11]."'
															,'1'
															,'$date_setting'
															,'$emp_id')";
					$query_add = $conn->query($sql_add);
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

			if ($namedDataArray[$i][1]=="") { $errcolumn .= " ชื่อ*,"; }
			if ($namedDataArray[$i][2] =="") { $errcolumn .=" นามสกุล*,"; }
			if ($namedDataArray[$i][6] =="") { $errcolumn .=" เบอร์โทรศัพท์*,"; }
			if ($namedDataArray[$i][8] =="") { $errcolumn .=" E-mail*,"; }
			if ($namedDataArray[$i][9] =="") { $errcolumn .=" ที่อยู่ติดต่อ*,"; }

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
