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
	<div class="col-xs-12 col-xs-9  no-margin-padding">
		<div class="setup-text-list" style="color:#F00;">
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
		if($dataRow[$row]['A'] != "Category"
		|| $dataRow[$row]['B'] != "Sub Category") {
			if ($dataRow[$row]['A'] != "Category"){ $errorcolumn .="A,"; }
			if ($dataRow[$row]['B'] != "Sub Category") { $errorcolumn .="B,"; }

			?>
			<div class="setup-list">
				<div class="col-xs-12 col-xs-9  no-margin-padding">
					<div class="setup-text-list" style="color:#F00;">
						Excel file format error please try again.<?php echo substr($errorcolumn, 0, -1);?>
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
	// if ((isset($dataRow[$row]['A'])) && ($dataRow[$row]['A'] > '')) {
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

  if ($namedDataArray[$i][0]!="" && $namedDataArray[$i][1]!="" ) {

	//Add product
  $error_mail=false;
		$sql_check_product= "select * from Product_Type where  prodType_name = '".$namedDataArray[$i][0]."' AND prodType_status = 0 AND prodType_level = '1' ";
		$query_check_product = $conn->query($sql_check_product);
		if ($query_check_product->num_rows>0) {
			$error_mail=true;
      while($result_check_product = $query_check_product->fetch_assoc())
      {
        $id_p = $result_check_product['prodType_id'];
        $sql_check_product_t= "select * from Product_Type where  prodType_name = '".$namedDataArray[$i][1]."' AND prodType_ref_id = '$id_p'  AND prodType_status = '0' AND prodType_level = '2' ";
    		$query_check_product_t = $conn->query($sql_check_product_t);
    		if ($query_check_product_t->num_rows < 1) {
    			$error_mail=true;
                $sql = "INSERT INTO Product_Type (prodType_level, prodType_ref_id, prodType_name ,prodType_enable,prodType_create_datetime,prodType_createBy_id)
                VALUES ( '2', '$id_p','".$namedDataArray[$i][1]."','1','$date_setting','$emp_id')";
                $query_insert = $conn->query($sql);
                if($query_insert){
                    $importsuccess_t++;
                    $loop++;
                  }else{
                    $importerror_t++;
                    $error_row[$loop]=$i;
                }
        }
      }
		}else{

      $sql = "INSERT INTO Product_Type (prodType_level,prodType_name,prodType_enable,prodType_create_datetime,prodType_createBy_id)
      VALUES ('1','".$namedDataArray[$i][0]."','1','$date_setting','$emp_id')";
      $query_insert = $conn->query($sql);
      $id_pro_last =  $conn->insert_id;
      if($query_insert){
          $importsuccess++;
          $loop++;
        }else{
          $importerror++;
          $error_row[$loop]=$i;
      }



      $sql_t = "INSERT INTO Product_Type (prodType_level, prodType_ref_id, prodType_name ,prodType_enable,prodType_create_datetime,prodType_createBy_id)
      VALUES ( '2','$id_pro_last','".$namedDataArray[$i][1]."','1','$date_setting','$emp_id')";
      $query_insert_t = $conn->query($sql_t);
      if($query_insert_t){
          $importsuccess_t++;
          $loop++;
        }else{
          $importerror_t++;
          $error_row[$loop]=$i;
      }



    }
// exit();


	}
	else {

?>
<div class="setup-list" style="">
<?php
	$errcolumn ="";
	$errcolumn ="";
	if ($namedDataArray[$i][0]=="") { $errcolumn .= " Category,"; }
	if ($namedDataArray[$i][1]=="") { $errcolumn .= " Sub Category,"; }

?>
	<div class="col-xs-12 col-xs-9  no-margin-padding">
		<div class="setup-text-list" style="color:#F00;">
			Data Error in row <?php echo $i+3;?> - Column ( <?php echo substr($errcolumn, 0, -1); ?> )
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
			Import Success Product
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
  			Import Success  Product
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
if ($importsuccess_t!=0) {
?>
<div class="setup-list">
	<div class="col-xs-9 col-xs-9  no-margin-padding">
		<div class="setup-text-list" style="color:#090;">
			Import Success Product Type
		</div>
	</div>
	<div class="col-xs-3 col-xs-3  no-margin-padding text-right">
		<div class="countitem"  style="color:#090;">
			<?php echo $importsuccess_t; ?> Record
		</div>
	</div>
</div>
<?php
}else{
  ?>
  <div class="setup-list">
  	<div class="col-xs-9 col-xs-9  no-margin-padding">
  		<div class="setup-text-list" style="color:#090;">
  			Import Success Product Type
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
