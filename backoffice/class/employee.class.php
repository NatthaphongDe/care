<?php
class member_base extends main{
  var $db;
  var $dbConn;
  var $member;
  var $pageId;
  var $file_accept_img;

  public function __construct(){
    global $db,$conn;
    $this->db = $db;
    $this->dbConn = $conn;
    $this->member = "";
    $this->file_accept_img = array("jpg","jpeg","png");

    $this->pageId = $this->page_list();
  }
  public function page_list(){
    $sql = "SELECT *
            FROM `Page` ";
    $query = $this->dbConn->query($sql);
    $page_read = array();
    $page_write = array();
    $page_enable = array();
    while($rs_page  =$query->fetch_assoc()){
      if($rs_page["page_permission"]==1){
        $page_read[$rs_page["page_id"]] = $rs_page["page_param_read"];
      }else if($rs_page["page_permission"]==2){
        $page_write[$rs_page["page_id"]] = $rs_page["page_param_write"];
      }else if($rs_page["page_permission"]==3){
        $page_enable[$rs_page["page_id"]] = $rs_page["page_param_enable"];
      }
    }
    $page_all = array("page_read"=>$page_read, "page_write"=>$page_write, "page_enable"=>$page_enable);
    return $page_all;
  }

  public function getEmployee(){
    $sql = "SELECT * FROM `Employee` WHERE emp_status = 0";
    $query = $this->dbConn->query($sql);
    return $query;
  }
  
  public function checkPrivilege($sectionGroup,$page){
    $pageId = null;
    foreach ($this->pageId["page_read"] as $key => $value) {
      $page_list = explode(",",$value);
      if(in_array($page,$page_list)){
        $pageId = $key;
      }
    }
    if($pageId==null){
      foreach ($this->pageId["page_write"] as $key => $value) {
        $page_list = explode(",",$value);
        if(in_array($page,$page_list)){
          $pageId = $key;
        }
      }
    }
    if($pageId==null){
      foreach ($this->pageId["page_enable"] as $key => $value) {
        $page_list = explode(",",$value);
        if(in_array($page,$page_list)){
          $pageId = $key;
        }
      }
    }

    $sql = "SELECT *
            FROM `Employee_Group_Permission` gp
            LEFT JOIN `Page` p ON (gp.page_id=p.page_id)
            WHERE gp.page_id='$pageId'
            AND gp.empGroup_id='$sectionGroup' ";
    $query = $this->dbConn->query($sql);
    $num_rows = $query->num_rows;
    $privilege = array();
    if($num_rows>0){
      while($rs_access = $query->fetch_assoc()){
        $privilege[$rs_access["page_permission"]] = 1;
      }
    }else{

    }
    return $privilege;
  }
  public function checkLoginSession(){
    if($_SESSION["admin"]!=""){
        return true;
    }else{
      return false;
    }
  }


  public function emp_list_assign($post){
    $text_search = $this->data_filter($post["txt_search"]);
    $emp_list_arr = array();
    if($text_search!=""){
      $sql_extend = "AND (emp.emp_real_id LIKE '%$text_search%'
          OR emp.emp_firstname LIKE '%$text_search%'
          OR emp.emp_lastname LIKE '%$text_search%') ";
    }
    // echo 
    $sql = "SELECT *
    FROM Employee emp
    INNER JOIN Employee_Group empGp ON (emp.empGroup_id=empGp.empGroup_id)
    WHERE emp.emp_id!='".$_SESSION["admin"]["empId"]."'
    AND emp.office_id='".$_SESSION["admin"]["office"]."'
    $sql_extend
    AND emp.emp_status='0'
    -- AND empGp.empGroup_level!='1' AND empGp.empGroup_id!='3'
    AND empGp.empGroup_section='".$_SESSION["admin"]["empSection"]."' ";
    $query = $this->dbConn->query($sql);
    // echo $sql;
    while($rs_mem = $query->fetch_assoc()){
      $rs_mem_arr = array();
      $rs_mem_arr["data"] = $rs_mem["emp_id"];
      $rs_mem_arr["value"] = $rs_mem["emp_real_id"]." - ".$rs_mem["emp_firstname"]." ".$rs_mem["emp_lastname"];
      array_push($emp_list_arr,$rs_mem_arr);
    }
    return $emp_list_arr;
  }

  public function emp_list_assign_all(){
    $emp_list_arr = array();
    $sql = "SELECT *
    FROM Employee emp
    INNER JOIN Employee_Group empGp ON (emp.empGroup_id=empGp.empGroup_id)
    WHERE emp.emp_status='0' AND empGp.empGroup_level!='1' AND empGp.empGroup_section='".$_SESSION["admin"]["empSection"]."' ";
    $query = $this->dbConn->query($sql);
    while($rs_mem = $query->fetch_assoc()){
      $rs_mem_arr = array();
      $rs_mem_arr["data"] = $rs_mem["emp_id"];
      $rs_mem_arr["value"] = $rs_mem["emp_real_id"]." - ".$rs_mem["emp_firstname"]." ".$rs_mem["emp_lastname"];
      array_push($emp_list_arr,$rs_mem_arr);
    }
    return $emp_list_arr;
  }


  public function emp_get_detail($empId){
    $emp_list_arr = array();
    $sql = "SELECT * FROM Employee emp
            LEFT JOIN Employee_Group em_pg ON (emp.empGroup_id=em_pg.empGroup_id)
            LEFT JOIN office_type em_off ON (emp.office_id=em_off.office_id)
            WHERE emp.emp_id='$empId'
            AND emp.emp_status='0' ";
    $query = $this->dbConn->query($sql);
    $rs_mem = $query->fetch_assoc();
    $emp_list_arr = $rs_mem;
    if(count(glob("../".$rs_mem["emp_img_path_s"]))==0 || $rs_mem["emp_img_path_s"] == '') {
      $emp_list_arr["emp_img_path_s"] = "setting/img/profile_emp-01.svg";
        $emp_list_arr["emp_img_path_assign"] = "setting/img/profile_emp-01.svg";
    }else{
      $emp_list_arr["emp_img_path_s"] = "../".$rs_mem["emp_img_path_s"];
        $emp_list_arr["emp_img_path_assign"] = "../../".$rs_mem["emp_img_path_s"];
    }

    return $emp_list_arr;
  }


  public function emp_get_detail_setting($empId){
    $emp_list_arr = array();
    $sql = "SELECT * FROM Employee emp
            LEFT JOIN Employee_Group em_pg ON (emp.empGroup_id=em_pg.empGroup_id)
            WHERE emp.emp_id='$empId'
            AND emp.emp_status='0' ";
    $query = $this->dbConn->query($sql);
    $rs_mem = $query->fetch_assoc();
    $emp_list_arr = $rs_mem;
    if(!file_exists("../../".$rs_mem["emp_img_path_s"]) || $rs_mem["emp_img_path_s"] == '') {
      $emp_list_arr["emp_img_path_s"] = "setting/img/profile_emp-01.svg";
        $emp_list_arr["emp_img_path_assign"] = "setting/img/profile_emp-01.svg";
    }else{
      $emp_list_arr["emp_img_path_s"] = "../".$rs_mem["emp_img_path_s"];
        $emp_list_arr["emp_img_path_assign"] = "../../".$rs_mem["emp_img_path_s"];
    }

    return $emp_list_arr;
  }

  public function resize_image($images,$file_size_s,$file_size_l,$image_set_type,$new_images){
        $image_l_size=800;
        $image_s_size=320;

         //$size = GetimageSize($images);
         list($w, $h) = GetimageSize($images);
         $extension = $image_set_type;
         if($extension=="jpg" || $extension=="jpeg"){
           $images_orig = imagecreatefromjpeg($images);
           $images_origs = imagecreatefromjpeg($images);
         }

         if($extension=="png"){

           $images_orig = imagecreatefrompng($images);
           $images_origs = imagecreatefrompng($images);
         }
         if ($extension=="gif"){
           $images_orig = imagecreatefromgif($images);
           $images_origs = imagecreatefromgif($images);
         }


         //---- l size -- //


           // $height=round($image_l_size*$h/$w);
           if($w > $h){
               $height=round($image_l_size);
               $width=round($image_l_size*$w/$h);
             }else {
               $height=round($image_l_size*$h/$w);
               $width=round($image_l_size);
             }

           $photoX = ImagesX($images_orig);
           $photoY = ImagesY($images_orig);
           $images_fin = ImageCreateTrueColor($width, $height);



         // แก้พื้นหลังสีดำ
         imagealphablending($images_fin, false);
         imagesavealpha($images_fin, true);
         // แก้พื้นหลังสีดำ

           ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width+1, $height+1, $photoX, $photoY);

         if($extension=="jpeg" || $extension=="jpg" )
         {
            ImageJPEG($images_fin,$file_size_l.$new_images);
         }
         if($extension=="png")
         {
           ImagePNG($images_fin,$file_size_l.$new_images);
         }
         if($extension=="gif")
         {
           ImageGIF($images_fin,$file_size_l.$new_images);
         }
         ImageDestroy($images_orig);
         ImageDestroy($images_fin);

         //---- s size -- //
         // $heights=round($image_s_size*$h/$w);

         if($w > $h){
             $heights=round($image_s_size);
             $widths=round($image_s_size*$w/$h);
           }else {
             $heights=round($image_s_size*$h/$w);
             $widths=round($image_s_size);
           }


         $photoXs = ImagesX($images_origs);
         $photoYs = ImagesY($images_origs);
         $images_fins = ImageCreateTrueColor($widths, $heights);
         // แก้พื้นหลังสีดำ
         imagealphablending($images_fins, false);
         imagesavealpha($images_fins, true);
         // แก้พื้นหลังสีดำ
         ImageCopyResampled($images_fins, $images_origs, 0, 0, 0, 0, $widths+1, $heights+1, $photoXs, $photoYs);
         if($extension=="jpeg" || $extension=="jpg" )
         {
           ImageJPEG($images_fins,$file_size_s.$new_images);
         }
         if($extension=="png")
         {
           ImagePNG($images_fins,$file_size_s.$new_images);
         }
         if($extension=="gif")
         {
           ImageGIF($images_fins,$file_size_s.$new_images);
         }
         ImageDestroy($images_origs);
         ImageDestroy($images_fins);

         return true;
  }

  public function emp_change_img_profile($file){
     $status_response = "00";


    if($file["img_profile"]["name"]!=""){
      $ext = pathinfo($file["img_profile"]["name"], PATHINFO_EXTENSION);
      $new_filename = "emp_images_".$_SESSION["admin"]["empId"]."_".time().".".$ext;
      $new_filepath = "data/emp_images/".$_SESSION["admin"]["empId"]."/$new_filename";
      $new_path_l = "data/emp_images/".$_SESSION["admin"]["empId"]."/l/";
      $new_path_s = "data/emp_images/".$_SESSION["admin"]["empId"]."/s/";

       if(!in_array($ext,$this->file_accept_img)){
           $status_response = "02";
           $status_response_text = "กรุณาอัพโหลดไฟล์รูปภาพประเภท jpg, jpge และ png !";
       }else{
         $size=getimagesize($file["img_profile"]["name"]);
         if ($size[0]<800 || $size[1]<800)
         {
           $status_response = "02";
           $status_response_text = "กรุณาอัพโหลดไฟล์รูปภาพที่มีขนาดความสูงและความกว้าง 800 Pixels ขึ้นไปเท่านั้น !";
         }else{
           $this->deleteDirectory($path_outter."../data/emp_images/".$_SESSION["admin"]["empId"]);

           if(!is_dir($path_outter."../data/emp_images")){
             mkdir($path_outter."../data/emp_images", 0775, true);
           }
           if(!is_dir($path_outter."../data/emp_images/".$_SESSION["admin"]["empId"])){
             mkdir($path_outter."../data/emp_images/".$_SESSION["admin"]["empId"], 0775, true);
           }
           if(!is_dir($path_outter."../data/emp_images/".$_SESSION["admin"]["empId"]."/l")){
             mkdir($path_outter."../data/emp_images/".$_SESSION["admin"]["empId"]."/l", 0775, true);
           }
           if(!is_dir($path_outter."../data/emp_images/".$_SESSION["admin"]["empId"]."/s")){
             mkdir($path_outter."../data/emp_images/".$_SESSION["admin"]["empId"]."/s", 0775, true);
           }

           if(!(move_uploaded_file($file["img_profile"]["tmp_name"],$path_outter."../".$new_filepath))){
               $status_response = "02";
               $status_response_text = "Error Upload!";
           }else{
             $this->resize_image("../".$new_filepath,"../".$new_path_s,"../".$new_path_l,$ext,$new_filename);
             $sql_upd_emp= "UPDATE `Employee`
                                       SET `emp_img_path`='$new_path_l"."$new_filename'
                                       , `emp_img_path_s`='$new_path_s"."$new_filename'
                                       , `emp_img_name`='$new_filename'
                                       , `emp_img_ext`='$ext'
                                       WHERE `emp_id`='".$_SESSION["admin"]["empId"]."' ";
             $qr_upd_emp= $this->dbConn->query($sql_upd_emp);

             if(!$qr_upd_emp){
               $status_response = "01";
               $status_response_text = "Error SQL!";
             }
           }
         }


      }
    }
    mysqli_close($this->dbConn);
    return array('status_response' => $status_response,'status_response_text' => $status_response_text);


  }
}
?>
