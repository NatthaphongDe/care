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
$inputFileName = $_POST['excel_file'];

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
		<div class="col-xs-12 col-xs-12  no-margin-padding">
			<div class="setup-text-list" style="color:#F00;text-align: center;">
				No data
			</div>
		</div>
		<!-- <div class="col-xs-12 col-xs-3  no-margin-padding text-right">
		<div class="countitem"  style="color:#F00;">
	</div>
</div> -->
</div>
<?php
exit();
}

//checkheader format
for ($row = 1; $row <= $highestRow; ++$row) {
	$dataRow = $objWorksheet->rangeToArray('A'.$row.':'.$highestColumn.$row,null, true, true, true);
	if ($row == 1) {
		if(	$dataRow[$row]['A'] != "เลขนิติบุคคล (13 หลัก)"
		|| $dataRow[$row]['B'] != "ชื่อบริษัทที่จดทะเบียน*"
		|| $dataRow[$row]['C'] != "สาขา"
		|| $dataRow[$row]['D'] != "เบอร์โทรศัพท์*"
		|| $dataRow[$row]['E'] != "Website"
		|| $dataRow[$row]['F'] != "ที่อยู่ติดต่อ*"
		|| $dataRow[$row]['G'] != "จังหวัด"
		|| $dataRow[$row]['H'] != "รหัสไปรษณีย์"
		|| $dataRow[$row]['I'] != "สมาชิกกรม*"
		|| $dataRow[$row]['J'] != "ผู้ติดต่อ"
		|| $dataRow[$row]['K'] != "ประเภทธุรกิจ*"
		|| $dataRow[$row]['L'] != "สถานะบริษัท*"

	) {

			// if ($dataRow[$row]['A'] != "หมายเลขทะเบียนการค้า"){ $errorcolumn .="A,"; }
			// if ($dataRow[$row]['B'] != "ชื่อบริษัทที่จดทะเบียน") { $errorcolumn .="B,"; }
			// if ($dataRow[$row]['C'] != "สาขา") { $errorcolumn .="C,"; }
			// if ($dataRow[$row]['E'] != "เบอร์แฟกซ์") { $errorcolumn .="E,"; }
			// if ($dataRow[$row]['G'] != "ที่อยู่ติดต่อ") { $errorcolumn .="G,"; }
			// if ($dataRow[$row]['H'] != "จังหวัด") { $errorcolumn .="H,"; }
			// if ($dataRow[$row]['I'] != "รหัสไปรษณีย์") { $errorcolumn .="I,"; }
			// if ($dataRow[$row]['J'] != "สมาชิกกรม") { $errorcolumn .="j,"; }
			// if ($dataRow[$row]['K'] != "ชื่อผู้ติดต่อ") { $errorcolumn .="k,"; }
			// if ($dataRow[$row]['K'] != "ประเภทธุรกิจ*") { $errorcolumn .="k,"; }

			//if ($dataRow[$row]['L'] != "ผู้ติดต่อ(นามสกุล)") { $errorcolumn .="K,"; }


			?>
			<div class="setup-list">
				<div class="col-xs-12 col-xs-9  no-margin-padding">
					<div class="setup-text-list" style="color:#F00;">
						Excel file format error please try again.<?php //echo substr($errorcolumn, 0, -1);?>
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

	$sql_card= "select prov_id,prov_name from Province where prov_name = '".$namedDataArray[$i][7]."' ";
	$query_card = $conn->query($sql_card);
	if ($query_card->num_rows>0) {
		$error_mail=true;
		while($result_card = $query_card->fetch_assoc()) {
			$prov_id = $result_card['prov_id'];
		}
	}else{
		$prov_id = 0;
	}

	if ($namedDataArray[$i][1]!="" && $namedDataArray[$i][3]!=""&& $namedDataArray[$i][5]!="" && $namedDataArray[$i][8]!="" && $namedDataArray[$i][10]!=""  && $namedDataArray[$i][11]!="" ) {


		if($namedDataArray[$i][0]!=''){
			$sql_card= "SELECT cpr_id from Corporate where cpr_numbertrade = '".$namedDataArray[$i][0]."' AND cpr_status = 0 AND cpr_type = '1' AND cpr_section='$emp_section' ";
			$up = " `cpr_companyname`='".$namedDataArray[$i][1]."', ";
		}else{
			$sql_card= "SELECT cpr_id from Corporate where cpr_companyname = '".$namedDataArray[$i][1]."' AND cpr_status = 0 AND cpr_type = '1'
									AND cpr_numbertrade = '' AND cpr_section='$emp_section' ";
			$up = '';
		}


		$query_card = $conn->query($sql_card);
		if ($query_card->num_rows>0) {
			$error_mail=true;
			while($result_card = $query_card->fetch_assoc())
			{
				$id_p = $result_card['cpr_id'];
				$sql_edit = "UPDATE Corporate SET
				$up
				`cpr_branch`= '".$namedDataArray[$i][2]."'
				,`cpr_telephone`= '".$namedDataArray[$i][3]."'
				,`cpr_web`= '".$namedDataArray[$i][4]."'
				,`cpr_address`= '".$namedDataArray[$i][5]."'
				,`prov_id`= '".$namedDataArray[$i][6]."'
				,`cpr_zipcode`= '".$prov_id."'
				,`cpr_department`= '".$namedDataArray[$i][8]."'
				,`cpr_contact_person`= '".$namedDataArray[$i][9]."'
				,`cpr_type_import_export`= '".$namedDataArray[$i][10]."'
				,`cpr_reliable`= '".$namedDataArray[$i][11]."'
				,cpr_import = '1'
				,cpr_update_datetime =  '$date_setting'
				,cpr_updateBy_id = '$emp_id'
				where  cpr_id = '$id_p'";
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
			$sql_add = "INSERT INTO Corporate (`cpr_section`, `cpr_type`, `cpr_numbertrade`, `cpr_companyname`, `cpr_branch`, `cpr_telephone`, `cpr_web`, `cpr_address`, `prov_id`,
				`cpr_zipcode`, `cpr_department`, `cpr_contact_person`, `cpr_type_import_export` ,cpr_import,cpr_create_datetime,cpr_createBy_id,`cpr_reliable`)
				VALUES ('$emp_section'
					,'1'
					,'".$namedDataArray[$i][0]."'
					,'".$namedDataArray[$i][1]."'
					,'".$namedDataArray[$i][2]."'
					,'".$namedDataArray[$i][3]."'
					,'".$namedDataArray[$i][4]."'
					,'".$namedDataArray[$i][5]."'
					,'".$namedDataArray[$i][6]."'
					,'".$prov_id."'
					,'".$namedDataArray[$i][8]."'
					,'".$namedDataArray[$i][9]."'
					,'".$namedDataArray[$i][10]."'
					,'1'
					,'$date_setting'
					,'$emp_id'
					,'".$namedDataArray[$i][11]."' )";
					$query_add = $conn->query($sql_add);
					if($query_add){
						$importsuccess++;
						$loop++;
					}else{
						$importerror++;
						$error_row[$loop]=$i;
					}
				}
			}
			else {
				$error++;
				if($namedDataArray[$i][0] != '') {

					?>
					<div class="setup-list" style="">
						<?php
						$errcolumn ="";
						$errcolumn ="";
						if ($namedDataArray[$i][1]=="") { $errcolumn .= " ชื่อบริษัทที่จดทะเบียน*,"; }
						if ($namedDataArray[$i][3] =="") { $errcolumn .=" เบอร์โทรศัพท์*,"; }
						if ($namedDataArray[$i][5] =="") { $errcolumn .=" ที่อยู่ติดต่อ*,"; }
						if ($namedDataArray[$i][6] =="") { $errcolumn .=" จังหวัด,"; }
						if ($namedDataArray[$i][9] =="") { $errcolumn .=" ผู้ติดต่อ,"; }
						if ($namedDataArray[$i][11] =="") { $errcolumn .=" สถานะบริษัท*,"; }
	
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
			<div class="setup-list">
				<div class="col-xs-9 col-xs-9  no-margin-padding">
					<div class="setup-text-list" style="color:#F00;">
						<!-- Data Error -->
					</div>
				</div>
				<div class="col-xs-3 col-xs-3  no-margin-padding text-right">
					<div class="countitem"  style="color:#F00;">
						<?php //echo $error; ?>
						<!-- Record -->
					</div>
				</div>
			</div>
			<?php
		}else{
			?>
			<div class="setup-list">
				<div class="col-xs-9 col-xs-9  no-margin-padding">
					<div class="setup-text-list" style="color:#F00;">
						<!-- Data Error -->
					</div>
				</div>
				<div class="col-xs-3 col-xs-3  no-margin-padding text-right">
					<div class="countitem"  style="color:#F00;">
						<?php //echo 0; ?>
						<!-- Record -->
					</div>
				</div>
			</div>
			<?php
		}
		?>
		<?
		if ($importerror!=0) {
			?>
			<div class="setup-list">
				<div class="col-xs-9 col-xs-9  no-margin-padding">
					<div class="setup-text-list" style="color:#F00;">
						<!-- Import Error -->
					</div>
				</div>
				<div class="col-xs-3 col-xs-3  no-margin-padding text-right">
					<div class="countitem"  style="color:#F00;">
						<?php //echo $error; ?>
						<!-- Record -->
					</div>
				</div>
			</div>
			<?php
		}else{
			?>
			<div class="setup-list">
				<div class="col-xs-9 col-xs-9  no-margin-padding">
					<div class="setup-text-list" style="color:#F00;">
						<!-- Import Error -->
					</div>
				</div>
				<div class="col-xs-3 col-xs-3  no-margin-padding text-right">
					<div class="countitem"  style="color:#F00;">
						<?php// echo 0; ?>
						<!-- Record -->
					</div>
				</div>
			</div>
			<?php
		}
		?>
