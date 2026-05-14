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

if ($highestRow<2) {
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
		if(	$dataRow[$row]['A'] != "ภาษาไทย"
				|| $dataRow[$row]['B'] != "ภาษาอังกฤษ") {

			if ($dataRow[$row]['A'] != "ภาษาไทย"){ $errorcolumn .= $dataRow[$row]['A'].","; }
			if ($dataRow[$row]['B'] != "ภาษาอังกฤษ"){ $errorcolumn .= $dataRow[$row]['B'].","; }

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
		if ($row>=2) {
			foreach($headingsArray as $columnKey => $columnHeading) {
				$namedDataArray[$rowarr][$col] = trim(PHPExcel_Shared_String::SanitizeUTF8($dataRow[$row][$columnKey]));
				$col++;
			}
			$rowarr++;
		}
}

for ($i=0;$i<$rowarr;$i++) {

  			if ( $namedDataArray[$i][0]!="" && $namedDataArray[$i][1]!="") {



				$sql_card  = " SELECT dept_id  FROM  Department where dept_name = '".$namedDataArray[$i][0]."'  AND dept_status = 0 ";
				$query_card = $conn->query($sql_card);
				if ($query_card->num_rows>0) {
		      while($result_card = $query_card->fetch_assoc())
		      {
		        $id_p = $result_card['dept_id'];
            $ti ="";
            $ti .= "Officers have contacted to ";
            $ti .= $namedDataArray[$i][1];
            $ti .= ".";
		       	$sql_edit = "UPDATE Department SET dept_message_noti_en = '$ti'
		                      where  dept_id = '$id_p'";
		            $query_edit = $conn->query($sql_edit);
								if($query_edit){
										$updatesuccess++;
										$loop++;
									}else{
										$importerror++;
										$error_row[$loop]=$i;
								}
                // echo $i."<br>";
		      }

				}else{
          echo  $namedDataArray[$i][1]."<br>";
            // echo "--".$i."--"."<br>";
          // echo "-------------";
          // echo $row;


// 					$sql_add = "INSERT INTO `Department`(`dept_name`, `dept_affiliation`, `dept_director`, `dept_tel`, `dept_fax`, `dept_address`, `dept_email`, `dept_assistant`, `country_id`, `dept_type`
// 																	,  `dept_section`,`dept_create_datetime`, `dept_createBy_id`,dept_enable,`dept_message_noti`,dept_message_noti_en)
// 											VALUES ('".$namedDataArray[$i][4]."'
// 															,'".$namedDataArray[$i][5]."'
// 															,'".$namedDataArray[$i][6]."'
// 															,'".$namedDataArray[$i][8]."'
// 															,'".$namedDataArray[$i][9]."'
// 															,'".$namedDataArray[$i][11]."'
// 															,'".$namedDataArray[$i][10]."'
// 															,'".$namedDataArray[$i][7]."'
// 															,'$country_id'
// 															,'".$namedDataArray[$i][1]."'
// 															,'$section'
// 															,'$date_setting'
// 															,'$emp_id'
// 															,'1'
// 															,'".$namedDataArray[$i][12]."'
// 															,'".$namedDataArray[$i][13]."')";
// 					$query_add = $conn->query($sql_add);
// // echo					$sql_add;
// 					if($query_add){
// 		          $importsuccess++;
// 		          $loop++;
// 		        }else{
// 		          $importerror++;
// 		          $error_row[$loop]=$i;
// 		      }

		    }
	}else {
		$error++;

?>
<div class="setup-list" style="">
<?php
	$errcolumn ="";
	$errcolumn ="";

	if ($namedDataArray[$i][0]=="") { $errcolumn .= " ภาษาไทย,"; }
	if ($namedDataArray[$i][1] =="") { $errcolumn .=" ภาษากฤษ,"; }

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
