<?php include("../config/config.php");

function download_file( $fullPath, $fileName ){

  // Must be fresh start
  if( headers_sent() )
    die('Headers Sent');

  // Required for some browsers
  if(ini_get('zlib.output_compression'))
    ini_set('zlib.output_compression', 'Off');

  // File Exists?
  if( file_exists($fullPath) ){

    // Parse Info / Get Extension
    $fsize = filesize($fullPath);
    $path_parts = pathinfo($fullPath);
    $ext = strtolower($path_parts["extension"]);

    // Determine Content Type
    switch ($ext) {
      case "pdf": $ctype="application/pdf"; break;
      case "zip": $ctype="application/zip"; break;
      case "doc": $ctype="application/msword"; break;
      case "xls": $ctype="application/vnd.ms-excel"; break;
      case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
      case "gif": $ctype="image/gif"; break;
      case "png": $ctype="image/png"; break;
      case "jpeg":
      case "jpg": $ctype="image/jpg"; break;
      default: $ctype="application/force-download";
    }

    header("Pragma: public"); // required
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private",false); // required for certain browsers
    header("Content-Type: $ctype");
    header("Content-Disposition: attachment; filename=\"".basename($fullPath)."\";" );
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: ".$fsize);
    ob_clean();
    flush();
    readfile( $fullPath );

} else
    die('File Not Found');

}

$file_accept_img = array("jpg","jpeg","png");

if(isset($_GET["fileadrss"]) && $_GET["fileadrss"]!=""){
  $sql = "SELECT * FROM `Case_Attachfile` WHERE `caseAttach_id`='".$_GET["fileadrss"]."' AND `caseAttach_status`='0' ";
  $query = $conn->query($sql);
  $rs_fileCase = $query->fetch_assoc();

  $file_url = "../".$rs_fileCase["caseAttach_file_path"];
  // echo $file_url;
  // exit();
    download_file($file_url,$rs_fileCase["caseAttach_file_oldname"]);
  mysqli_close($conn);
  exit();
}

if(isset($_GET["fileadrss_msg"]) && $_GET["fileadrss_msg"]!=""){
  $sql = "SELECT * FROM `Message_Box_Attachfile` WHERE `msgBoxAttach_id`='".$_GET["fileadrss_msg"]."' AND `msgBoxAttach_status`='0' ";
  $query = $conn->query($sql);
  $rs_fileCase = $query->fetch_assoc();

  $file_url = "../".$rs_fileCase["msgBoxAttach_file_path"];
    download_file($file_url,$rs_fileCase["msgBoxAttach_file_oldname"]);
  mysqli_close($conn);
  exit();
}



if(isset($_GET["fileprocessmail"]) && $_GET["fileprocessmail"]!=""){
  $sql = "SELECT * FROM `procPropMail` WHERE `procPropMail_id`='".$_GET["fileprocessmail"]."' ";
  $query = $conn->query($sql);
  $rs_fileCase = $query->fetch_assoc();

  $file_url = "../".$rs_fileCase["procPropMail_file_path"];
    download_file($file_url,$rs_fileCase["procPropMail_file_oldname"]);
  mysqli_close($conn);
  exit();
}
if(isset($_GET["mailfileadrss"]) && $_GET["mailfileadrss"]!=""){
  $sql = "SELECT * FROM `Mail_Attachfile` WHERE `mailAttach_id`='".$_GET["mailfileadrss"]."' ";
  $query = $conn->query($sql);
  $rs_fileCase = $query->fetch_assoc();
  $file_url = "../".$rs_fileCase["mailAttach_file_path"];
    download_file($file_url,$rs_fileCase["mailAttach_file_oldname"]);
  mysqli_close($conn);
  exit();
}

if(isset($_GET["mailfileadrss_tmp"]) && $_GET["mailfileadrss_tmp"]!=""){

  $path_group = "mail_attach";
  $file_url = "../data/$path_group/tmp/".$_SESSION["admin"]["empId"]."/".$_GET["mailfileadrss_tmp"];
    download_file($file_url);
  mysqli_close($conn);
  exit();
}

if(isset($_GET["fileZip"]) && $_GET["fileZip"]!=""){
  $sql = "SELECT * FROM `Case_Attachfile` WHERE `case_id`='".$_GET["fileZip"]."' AND `caseAttach_status`='0' ";
  $query = $conn->query($sql);
  $files = array();
  $files_name = array();
  while($rs_fileCase = $query->fetch_assoc()){
     array_push($files,"../".$rs_fileCase["caseAttach_file_path"]);
      array_push($files_name,$rs_fileCase["caseAttach_file_name"]);
  }
  $zipname_full = 'all-file-attach.zip';
  $zipname = tempnam('tmp', 'zip');
  $zip = new ZipArchive;
  //$zip->open($zipname, ZipArchive::CREATE);
  $zip -> open($zipname, ZipArchive::OVERWRITE);
  $i=0;
  foreach ($files as $file) {
    $zip->addFile($file,$files_name[$i]);
    $i++;
  }

  $zip->close();

  header('Content-Type: application/zip');
  header('Content-disposition: attachment; filename='.$zipname_full);
  header('Content-Length: ' . filesize($zipname));
  readfile($zipname);
  unlink($zipname);
  mysqli_close($conn);
  exit();
}

if(isset($_POST["new_fileadrss"]) && $_POST["new_fileadrss"]!=""){

  $file_url = $_POST["filePreview"];
  header('Content-Type: application/octet-stream');
  header("Content-Transfer-Encoding: Binary");
  header("Content-disposition: nattachmet; filename=\"".$_POST["new_fileadrss"]."\"");
  readfile($file_url); // do the double-download-dance (dirty but worky)
  mysqli_close($conn);
  exit();
}
if(isset($_GET["reciveDoc"]) && $_GET["reciveDoc"]!=""){
  $sql = "SELECT * FROM `Case` WHERE `case_id`='".$_GET["reciveDoc"]."' ";
  $query = $conn->query($sql);
  $rs_fileCase = $query->fetch_assoc();

  $file_url = "../".$rs_fileCase["case_receivedoc_file_path"];
    download_file($file_url);

  mysqli_close($conn);
  exit();
}
?>
