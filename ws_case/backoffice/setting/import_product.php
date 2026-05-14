<?php
session_start();
$date_setting = date("Y-m-d h:i:sa");
$emp_id = $_SESSION["admin"]["empId"];
include('../../config/config.php');
require_once 'library/PHPExcel-1.8/Classes/PHPExcel.php';
include 'library/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';
$hospital_select = $_POST['hospital_id'];
$importsuccess = 0;
$importsuccess_t = 0;
$updatesuccess = 0;
$loop = 0;
$importerror = 0;
$importerror_t = 0;
$ownererror = 0;
$lv_1 = 0;
$lv_2 = 0;
$lv_3 = 0;
$lv_4 = 0;
$lv_5 = 0;
$lv_up_1 = 0;
$lv_up_2 = 0;
$lv_up_3 = 0;
$lv_up_4 = 0;
$lv_up_5 = 0;

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
if ($highestRow<2) {
?>
<div class="setup-list">
	<div class="col-xs-12 col-xs-9  no-margin-padding">
		<div class="setup-text-list" style="color:#F00;text-align:center">
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

		if($dataRow[$row]['A'] != "Th Descriptions L1*"
		|| $dataRow[$row]['B'] != "En Descriptions L1*"
		|| $dataRow[$row]['C'] != "Th Descriptions L2"
		|| $dataRow[$row]['D'] != "En Descriptions L2"
		|| $dataRow[$row]['E'] != "Th Descriptions L3"
		|| $dataRow[$row]['F'] != "En Descriptions L3"
		|| $dataRow[$row]['G'] != "Th Descriptions L4"
		|| $dataRow[$row]['H'] != "En Descriptions L4"
		|| $dataRow[$row]['I'] != "Th Descriptions L5"
		|| $dataRow[$row]['J'] != "En Descriptions L5") {

			if ($dataRow[$row]['A'] != "Th Descriptions L1*"){ $errorcolumn .="A,"; }
			if ($dataRow[$row]['B'] != "En Descriptions L1*") { $errorcolumn .="B,"; }
			if ($dataRow[$row]['C'] != "Th Descriptions L2") { $errorcolumn .="C,"; }
			if ($dataRow[$row]['D'] != "En Descriptions L2") { $errorcolumn .="D,"; }
			if ($dataRow[$row]['E'] != "Th Descriptions L3") { $errorcolumn .="E,"; }
			if ($dataRow[$row]['F'] != "En Descriptions L3"){ $errorcolumn .="F,"; }
			if ($dataRow[$row]['G'] != "Th Descriptions L4") { $errorcolumn .="G,"; }
			if ($dataRow[$row]['H'] != "En Descriptions L4") { $errorcolumn .="H,"; }
			if ($dataRow[$row]['I'] != "Th Descriptions L5") { $errorcolumn .="I,"; }
			if ($dataRow[$row]['J'] != "En Descriptions L5") { $errorcolumn .="J,"; }

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
$namedDataArray[$i][0] = data_filter($namedDataArray[$i][0]);
$namedDataArray[$i][1] = data_filter($namedDataArray[$i][1]);
$namedDataArray[$i][2] = data_filter($namedDataArray[$i][2]);
$namedDataArray[$i][3] = data_filter($namedDataArray[$i][3]);
$namedDataArray[$i][4] = data_filter($namedDataArray[$i][4]);
$namedDataArray[$i][5] = data_filter($namedDataArray[$i][5]);
$namedDataArray[$i][6] = data_filter($namedDataArray[$i][6]);
$namedDataArray[$i][7] = data_filter($namedDataArray[$i][7]);
$namedDataArray[$i][8] = data_filter($namedDataArray[$i][8]);
$namedDataArray[$i][9] = data_filter($namedDataArray[$i][9]);



  if (trim($namedDataArray[$i][0]) != "" && trim($namedDataArray[$i][1]) != "") {
		$inset_product = " prodType_level,prodType_ref_id,prodType_name,prodType_name_en,prodType_enable ";


		$sql_check_product= "select * from Product_Type where  prodType_name = '".trim($namedDataArray[$i][0])."' AND prodType_status = 0 AND prodType_level = '1' ";
		$query_check_product = $conn->query($sql_check_product);
		if ($query_check_product->num_rows>0) {
      while($result_check_product = $query_check_product->fetch_assoc())
      {
				$id_p = $result_check_product['prodType_id'];
				// update lv 1 (eng)
				$sql_eng = "	UPDATE `Product_Type` SET `prodType_name_en` = '".trim($namedDataArray[$i][1])."' WHERE prodType_id = '$id_p' ";
				$query_eng = $conn->query($sql_eng);
				if($query_eng){
						$lv_up_1++;
						$loop++;
						insert_update('2',$id_p);
				}


				// insert lv 2
				if(trim($namedDataArray[$i][2])!='' && trim($namedDataArray[$i][3]) != ""){

	        $sql_check_product_t= "select * from Product_Type where  prodType_name = '".trim($namedDataArray[$i][2])."' AND prodType_ref_id = '$id_p'  AND prodType_status = '0' AND prodType_level = '2' ";
	    		$query_check_product_t = $conn->query($sql_check_product_t);

					$re_lv2 =	$query_check_product_t->fetch_assoc();
					$prodType_id = $re_lv2['prodType_id'];
					$prodType_level = $re_lv2['prodType_level'];

	    		if ($query_check_product_t->num_rows < 1) {
	          $sql = "INSERT INTO Product_Type ($inset_product)
	          VALUES ( '2', '$id_p','".trim($namedDataArray[$i][2])."','".trim($namedDataArray[$i][3])."','1')";
	          $query_insert = $conn->query($sql);
						$id_pro_last =  $conn->insert_id;
	          if($query_insert){
	              $lv_2++;
	              $loop++;
								insert_update('1',$id_pro_last);
	          }

						if(trim($namedDataArray[$i][4])!='' && trim($namedDataArray[$i][5]) != ""){
							// insert lv 3
							$sql_t = "INSERT INTO Product_Type ($inset_product)
							VALUES ( '3','$id_pro_last','".trim($namedDataArray[$i][4])."','".trim($namedDataArray[$i][5])."','1')";
							$query_insert_t = $conn->query($sql_t);
								$id_pro_last =  $conn->insert_id;
							if($query_insert_t){
									$lv_3++;
									$loop++;
									insert_update('1',$id_pro_last);
							}

							if(trim($namedDataArray[$i][6])!='' && trim($namedDataArray[$i][7]) != ""){
								// insert lv 4
								$sql_t = "INSERT INTO Product_Type ($inset_product)
								VALUES ( '4','$id_pro_last','".trim($namedDataArray[$i][6])."','".trim($namedDataArray[$i][7])."','1')";
								$query_insert_t = $conn->query($sql_t);
									$id_pro_last =  $conn->insert_id;
								if($query_insert_t){
										$lv_4++;
										$loop++;
										insert_update('1',$id_pro_last);
								}
								if(trim($namedDataArray[$i][8])!='' && trim($namedDataArray[$i][9]) != ""){
									// insert lv 5
									$sql_t = "INSERT INTO Product_Type ($inset_product)
									VALUES ( '5','$id_pro_last','".trim($namedDataArray[$i][8])."','".trim($namedDataArray[$i][9])."','1')";
									$query_insert_t = $conn->query($sql_t);
									$id_pro_last =  $conn->insert_id;
									if($query_insert_t){
											$lv_5++;
											$loop++;
											insert_update('1',$id_pro_last);
									}
								}
							}
						}
					}else{

						// update lv 2 (eng)
						$sql_eng = "	UPDATE `Product_Type` SET `prodType_name_en` = '".trim($namedDataArray[$i][3])."' WHERE prodType_id = '$prodType_id' ";
						$query_eng = $conn->query($sql_eng);
						if($query_eng){
								$lv_up_2++;
								$loop++;
								insert_update('2',$prodType_id);
						}

						$sql_check_product_lv3 = "select * from Product_Type where  prodType_name = '".trim($namedDataArray[$i][4])."' AND prodType_status = 0 AND prodType_level = '3' ";
						$query_check_product_lv3 = $conn->query($sql_check_product_lv3);
						$re_lv3 =	$query_check_product_lv3->fetch_assoc();
						 $prodType_id_lv3 = $re_lv3['prodType_id'];
						 $prodType_level_lv3 = $re_lv3['prodType_level'];

						if ($query_check_product_lv3->num_rows<1) {

							if(trim($namedDataArray[$i][4])!='' && trim($namedDataArray[$i][5]) != ""){
								// insert lv 3
								$sql_t = "INSERT INTO Product_Type ($inset_product)
								VALUES ( '3','$prodType_id','".trim($namedDataArray[$i][4])."', '".trim($namedDataArray[$i][5])."','1')";
								$query_insert_t = $conn->query($sql_t);
								$id_pro_last =  $conn->insert_id;
								if($query_insert_t){
										$lv_3++;
										$loop++;
										insert_update('1',$id_pro_last);
								}
								if(trim($namedDataArray[$i][6])!='' && trim($namedDataArray[$i][7]) != ""){
									// insert lv 4
									$sql_t = "INSERT INTO Product_Type ($inset_product)
									VALUES ( '4','$id_pro_last','".trim($namedDataArray[$i][6])."','".trim($namedDataArray[$i][7])."','1')";
									$query_insert_t = $conn->query($sql_t);
									$id_pro_last =  $conn->insert_id;
									if($query_insert_t){
											$lv_4++;
											$loop++;
											insert_update('1',$id_pro_last);
									}
									if(trim($namedDataArray[$i][8])!='' && trim($namedDataArray[$i][9]) != ""){
										// insert lv 5
										$sql_t = "INSERT INTO Product_Type ($inset_product)
										VALUES ( '5','$id_pro_last','".trim($namedDataArray[$i][8])."','".trim($namedDataArray[$i][9])."','1')";
										$query_insert_t = $conn->query($sql_t);
										$id_pro_last =  $conn->insert_id;
										if($query_insert_t){
												$lv_5++;
												$loop++;
												insert_update('1',$id_pro_last);
										}
									}
								}
							}
						}else{

							// update lv 3 (eng)
							$sql_eng = "	UPDATE `Product_Type` SET `prodType_name_en` = '".trim($namedDataArray[$i][5])."' WHERE prodType_id = '$prodType_id_lv3' ";
							$query_eng = $conn->query($sql_eng);
							if($query_eng){
									$lv_up_3++;
									$loop++;
									insert_update('2',$prodType_id_lv3);
							}

							$sql_check_product_lv4 = "select * from Product_Type where  prodType_name = '".trim($namedDataArray[$i][6])."' AND prodType_status = 0 AND prodType_level = '4' ";
							$query_check_product_lv4 = $conn->query($sql_check_product_lv4);
							$re_lv4 =	$query_check_product_lv4->fetch_assoc();
							 $prodType_id_lv4 = $re_lv4['prodType_id'];
							 $prodType_level_lv4 = $re_lv4['prodType_level'];

							if ($query_check_product_lv4->num_rows<1) {

							if(trim($namedDataArray[$i][6])!='' && trim($namedDataArray[$i][7]) != ""){
								// insert lv 4
								$sql_t = "INSERT INTO Product_Type ($inset_product)
								VALUES ( '4','$prodType_id_lv3','".trim($namedDataArray[$i][6])."','".trim($namedDataArray[$i][7])."','1')";
								$query_insert_t = $conn->query($sql_t);
								$id_pro_last =  $conn->insert_id;
								if($query_insert_t){
										$lv_4++;
										$loop++;
										insert_update('1',$id_pro_last);

								}
									if(trim($namedDataArray[$i][8])!='' && trim($namedDataArray[$i][9]) != ""){
										// insert lv 5
										$sql_t = "INSERT INTO Product_Type ($inset_product)
										VALUES ( '5','$id_pro_last','".trim($namedDataArray[$i][8])."','".trim($namedDataArray[$i][9])."','1')";
										$query_insert_t = $conn->query($sql_t);
										$id_pro_last =  $conn->insert_id;
										if($query_insert_t){
												$lv_5++;
												$loop++;
												insert_update('1',$id_pro_last);

										}
									}
								}
							}else{

								// update lv 4 (eng)
								$sql_eng = "	UPDATE `Product_Type` SET `prodType_name_en` = '".trim($namedDataArray[$i][7])."' WHERE prodType_id = '$prodType_id_lv4' ";
								$query_eng = $conn->query($sql_eng);
								if($query_eng){
										$lv_up_4++;
										$loop++;
										insert_update('2',$prodType_id_lv4);

								}

								$sql_check_product_lv5 = "select * from Product_Type where  prodType_name = '".trim($namedDataArray[$i][8])."' AND prodType_status = 0 AND prodType_level = '5' ";
								$query_check_product_lv5 = $conn->query($sql_check_product_lv5);
								$re_lv5 =	$query_check_product_lv5->fetch_assoc();
								 $prodType_id_lv5 = $re_lv5['prodType_id'];
								 $prodType_level_lv5 = $re_lv5['prodType_level'];

								if ($query_check_product_lv5->num_rows<1) {
									if(trim($namedDataArray[$i][8])!='' && trim($namedDataArray[$i][9]) != ""){
										// insert lv 5
										$sql_t = "INSERT INTO Product_Type ($inset_product)
										VALUES ( '5','$prodType_id_lv4','".trim($namedDataArray[$i][8])."','".trim($namedDataArray[$i][9])."','1')";
										$query_insert_t = $conn->query($sql_t);
										$id_pro_last =  $conn->insert_id;
										if($query_insert_t){
												$lv_5++;
												$loop++;
												insert_update('1',$id_pro_last);
										}
									}
								}else{
									// update lv 5 (eng)
									$sql_eng = "	UPDATE `Product_Type` SET `prodType_name_en` = '".trim($namedDataArray[$i][9])."' WHERE prodType_id = '$prodType_id_lv5' ";
									$query_eng = $conn->query($sql_eng);
									if($query_eng){
											$lv_up_5++;
											$loop++;
											insert_update('2',$prodType_id_lv5);
									}
								}
							}
						}
					}
	      }
      }
		}else{

			// insert lv 1
      $sql = "INSERT INTO Product_Type (prodType_level,prodType_name,prodType_name_en,prodType_enable)
      VALUES ('1','".trim($namedDataArray[$i][0])."','".trim($namedDataArray[$i][1])."','1')";
      $query_insert = $conn->query($sql);
      $id_pro_last =  $conn->insert_id;
      if($query_insert){
          $lv_1++;
          $loop++;
					insert_update('1',$id_pro_last);
      }

			if(trim($namedDataArray[$i][2])!='' && trim($namedDataArray[$i][3])!=''){
			// insert lv 2
			$sql_t = "INSERT INTO Product_Type ($inset_product)
			VALUES ( '2','$id_pro_last','".trim($namedDataArray[$i][2])."','".trim($namedDataArray[$i][3])."','1')";
			$query_insert_t = $conn->query($sql_t);
			$id_pro_last =  $conn->insert_id;
			if($query_insert_t){
					$lv_2++;
					$loop++;
					insert_update('1',$id_pro_last);
			}

			if(trim($namedDataArray[$i][4])!=''  && trim($namedDataArray[$i][5])!=''){
				// insert lv 3
				$sql_t = "INSERT INTO Product_Type ($inset_product)
				VALUES ( '3','$id_pro_last','".trim($namedDataArray[$i][4])."','".trim($namedDataArray[$i][5])."','1')";
				$query_insert_t = $conn->query($sql_t);
				$id_pro_last =  $conn->insert_id;
				if($query_insert_t){
						$lv_3++;
						$loop++;
						insert_update('1',$id_pro_last);
				}

				if(trim($namedDataArray[$i][6])!=''  && trim($namedDataArray[$i][7])!=''){
					// insert lv 4
					$sql_t = "INSERT INTO Product_Type ($inset_product)
					VALUES ( '4','$id_pro_last','".trim($namedDataArray[$i][6])."','".trim($namedDataArray[$i][7])."','1')";
					$query_insert_t = $conn->query($sql_t);
					$id_pro_last =  $conn->insert_id;
					if($query_insert_t){
							$lv_4++;
							$loop++;
							insert_update('1',$id_pro_last);
					}
					if(trim($namedDataArray[$i][8])!=''  && trim($namedDataArray[$i][9])!=''){
						// insert lv 5
						$sql_t = "INSERT INTO Product_Type ($inset_product)
						VALUES ( '5','$id_pro_last','".trim($namedDataArray[$i][8])."','".trim($namedDataArray[$i][9])."','1')";
						$query_insert_t = $conn->query($sql_t);
						$id_pro_last =  $conn->insert_id;
						if($query_insert_t){
								$lv_5++;
								$loop++;
								insert_update('1',$id_pro_last);
						}
					}
				}
			}
		}
  }
}else{

?>
<div class="setup-list" style="">
<?php
	$errcolumn ="";
	$errcolumn ="";
	if (trim($namedDataArray[$i][0])=="") { $errcolumn .= "Th Descriptions L1*"; }
	if (trim($namedDataArray[$i][1])=="") { $errcolumn .= "En Descriptions L1*"; }

?>
	<div class="col-xs-12 col-xs-9  no-margin-padding">
		<div class="setup-text-list" style="color:#F00;">
			Data Error in row <?php echo $i+2;?> - Column ( <?php echo substr($errcolumn, 0, -1); ?> )
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

if ($lv_1!=0) {
?>
<div class="setup-list">
	<div class="col-xs-9 col-xs-9  no-margin-padding">
		<div class="setup-text-list" style="color:#090;">
  		Import Success  Th Descriptions L1
		</div>
	</div>
	<div class="col-xs-3 col-xs-3  no-margin-padding text-right">
		<div class="countitem"  style="color:#090;">
			<?php echo $lv_1; ?> Record
		</div>
	</div>
</div>
<?php
}else{
  ?>
  <div class="setup-list">
  	<div class="col-xs-9 col-xs-9  no-margin-padding">
  		<div class="setup-text-list" style="color:#090;">
  			Import Success  Th Descriptions L1
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
<?php if($lv_up_1 > 0){ ?>
<div class="setup-list">
	<div class="col-xs-9 col-xs-9  no-margin-padding">
		<div class="setup-text-list" style="color:#090;">
  		Update Success  Th Descriptions L1
		</div>
	</div>
	<div class="col-xs-3 col-xs-3  no-margin-padding text-right">
		<div class="countitem"  style="color:#090;">
			<?php echo $lv_up_1; ?> Record
		</div>
	</div>
</div>
<?php } ?>

<?
if ($lv_2!=0) {
?>
<div class="setup-list">
	<div class="col-xs-9 col-xs-9  no-margin-padding">
		<div class="setup-text-list" style="color:#090;">
			  			Import Success  Th Descriptions L2
		</div>
	</div>
	<div class="col-xs-3 col-xs-3  no-margin-padding text-right">
		<div class="countitem"  style="color:#090;">
			<?php echo $lv_2; ?> Record
		</div>
	</div>
</div>
<?php
}else{
  ?>
  <div class="setup-list">
  	<div class="col-xs-9 col-xs-9  no-margin-padding">
  		<div class="setup-text-list" style="color:#090;">
				Import Success  Th Descriptions L2
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
<?php if($lv_up_2 > 0){ ?>
<div class="setup-list">
	<div class="col-xs-9 col-xs-9  no-margin-padding">
		<div class="setup-text-list" style="color:#090;">
  		Update Success  Th Descriptions L2
		</div>
	</div>
	<div class="col-xs-3 col-xs-3  no-margin-padding text-right">
		<div class="countitem"  style="color:#090;">
			<?php echo $lv_up_2; ?> Record
		</div>
	</div>
</div>
<?php } ?>

<?
if ($lv_3!=0) {
?>
<div class="setup-list">
	<div class="col-xs-9 col-xs-9  no-margin-padding">
		<div class="setup-text-list" style="color:#090;">
			  			Import Success  Th Descriptions L3
		</div>
	</div>
	<div class="col-xs-3 col-xs-3  no-margin-padding text-right">
		<div class="countitem"  style="color:#090;">
			<?php echo $lv_3; ?> Record
		</div>
	</div>
</div>
<?php
}else{
  ?>
  <div class="setup-list">
  	<div class="col-xs-9 col-xs-9  no-margin-padding">
  		<div class="setup-text-list" style="color:#090;">
				Import Success  Th Descriptions L3
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
<?php if($lv_up_3!=0){ ?>

<div class="setup-list">
	<div class="col-xs-9 col-xs-9  no-margin-padding">
		<div class="setup-text-list" style="color:#090;">
  		Update Success  Th Descriptions L3
		</div>
	</div>
	<div class="col-xs-3 col-xs-3  no-margin-padding text-right">
		<div class="countitem"  style="color:#090;">
			<?php echo $lv_up_3; ?> Record
		</div>
	</div>
</div>
<?php } ?>

<?
if ($lv_4!=0) {
?>
<div class="setup-list">
	<div class="col-xs-9 col-xs-9  no-margin-padding">
		<div class="setup-text-list" style="color:#090;">
			  			Import Success  Th Descriptions L4
		</div>
	</div>
	<div class="col-xs-3 col-xs-3  no-margin-padding text-right">
		<div class="countitem"  style="color:#090;">
			<?php echo $lv_4; ?> Record
		</div>
	</div>
</div>
<?php
}else{
  ?>
  <div class="setup-list">
  	<div class="col-xs-9 col-xs-9  no-margin-padding">
  		<div class="setup-text-list" style="color:#090;">
				Import Success  Th Descriptions L4
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
<?php if($lv_up_4!=0){ ?>
<div class="setup-list">
	<div class="col-xs-9 col-xs-9  no-margin-padding">
		<div class="setup-text-list" style="color:#090;">
  		Update Success  Th Descriptions L4
		</div>
	</div>
	<div class="col-xs-3 col-xs-3  no-margin-padding text-right">
		<div class="countitem"  style="color:#090;">
			<?php echo $lv_up_4; ?> Record
		</div>
	</div>
</div>
<?php } ?>

<?
if ($lv_5!=0) {
?>
<div class="setup-list">
	<div class="col-xs-9 col-xs-9  no-margin-padding">
		<div class="setup-text-list" style="color:#090;">
			  			Import Success  Th Descriptions L5
		</div>
	</div>
	<div class="col-xs-3 col-xs-3  no-margin-padding text-right">
		<div class="countitem"  style="color:#090;">
			<?php echo $lv_5; ?> Record
		</div>
	</div>
</div>
<?php
}else{
  ?>
  <div class="setup-list">
  	<div class="col-xs-9 col-xs-9  no-margin-padding">
  		<div class="setup-text-list" style="color:#090;">
				Import Success  Th Descriptions L5
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
<?php if($lv_up_5!=0){ ?>
<div class="setup-list">
	<div class="col-xs-9 col-xs-9  no-margin-padding">
		<div class="setup-text-list" style="color:#090;">
  		Update Success  Th Descriptions L5
		</div>
	</div>
	<div class="col-xs-3 col-xs-3  no-margin-padding text-right">
		<div class="countitem"  style="color:#090;">
			<?php echo $lv_up_5; ?> Record
		</div>
	</div>
</div>
<?php } ?>

<?php

 function insert_update($ty,$id){
	global $conn;
	global $date_setting;
	global $emp_id;

	if($ty==1){
		$sql_log = "UPDATE `Product_Type` SET `prodType_create_datetime`= '$date_setting',`prodType_createBy_id`='$emp_id' WHERE prodType_id = '$id'";
	}else{
		$sql_log = "UPDATE `Product_Type` SET `prodType_update_datetime`='$date_setting',`prodType_updateBy_idateBy_id`='$emp_id' WHERE prodType_id = '$id'";
	}
		$query_insert_t = $conn->query($sql_log);
}

function data_filter($value) {
    global $conn;
    $newVal = trim($value);
    $newVal = htmlspecialchars($newVal);
    $newVal = mysqli_real_escape_string($conn,$newVal);
    return $newVal;
}
?>
