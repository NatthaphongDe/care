<?php

class DbHandler {

    private $conn,$func;
    function __construct() {
        require_once dirname(__FILE__) . '/DbConnect.php';
        $db = new DbConnect();
        $this->conn = $db->connect();
        require_once dirname(__FILE__) . '/DbFunction.php';
        $this->func = new DbFunction();
        require_once 'PassHash.php';
    }

    /******* ดึงข้อมูล Watchlist */

    public function getWatchlist2($limit,$offset){

      $limitsql  = $this->func->limit_sql($limit,$offset);

      print_r('------------------>');
      $stmt = $this->conn->prepare("
      SELECT *
FROM `Field_Values` a
LEFT JOIN `Field_Set` b ON ( a.fieldset_id = b.fieldset_id )

      ");

      $stmt->execute();
      $result = $stmt->get_result();
      if($result->num_rows > 0){
        $stmt->close();
        return $result;
      }else{
        $stmt->close();
        return NULL;
      }

    }

    
    /******* ดึงข้อมูล Watchlist2 */

    public function getWatchlist($limit,$offset){

      $limitsql  = $this->func->limit_sql($limit,$offset);


      $stmt = $this->conn->prepare("
      SELECT `cpr_type` , `cpr_type` , `cpr_numbertrade` , `cpr_companyname` , `cpr_type_import_export` , `cpr_branch` , `cpr_telephone` , `cpr_fax` , `cpr_email` , `cpr_address` , `cpr_zipcode` , `cpr_contact_person` , b.caseDtl_title, b.caseDtl_derivation,CASE
      WHEN c.complnt_trade_number='' or c.complnt_trade_number=''is null THEN ''
      ELSE 'Backlist'
        END AS chk_blacklist
      FROM `Corporate` a
      LEFT JOIN `Case` b ON a.cpr_companyname = b.complnt_name
LEFT JOIN Backlist_Complnt c ON c.complnt_trade_number = b.complnt_trade_number
      WHERE a.cpr_comp_type =2
      AND a.`cpr_ststus` =0
ORDER BY `a`.`cpr_type` ASC
      LIMIT $offset , $limit
      ");

      $stmt->execute();
      $result = $stmt->get_result();
      if($result->num_rows > 0){
        $stmt->close();
        return $result;
      }else{
        $stmt->close();
        return NULL;
      }

    }
 /******* ดึงข้อมูล Watchlist2 */

 public function getWatchlistByID($trade_id){

  


  $stmt = $this->conn->prepare("
  SELECT `cpr_type` , `cpr_type` , `cpr_numbertrade` , `cpr_companyname` , `cpr_type_import_export` , `cpr_branch` , `cpr_telephone` , `cpr_fax` , `cpr_email` , `cpr_address` , `cpr_zipcode` , `cpr_contact_person` , b.caseDtl_title, b.caseDtl_derivation,CASE
  WHEN c.complnt_trade_number='' or c.complnt_trade_number=''is null THEN ''
  ELSE 'Backlist'
    END AS chk_blacklist
  FROM `Corporate` a
  LEFT JOIN `Case` b ON a.cpr_companyname = b.complnt_name
LEFT JOIN Backlist_Complnt c ON c.complnt_trade_number = b.complnt_trade_number
  WHERE a.cpr_comp_type =2 AND a.cpr_type =1 
  AND a.`cpr_ststus` =0 AND b.case_status = 3 
AND cpr_numbertrade LIKE('%$trade_id%')
ORDER BY `a`.`cpr_numbertrade`  DESC
  ");

  $stmt->execute();
  $result = $stmt->get_result();
  if($result->num_rows > 0){
    $stmt->close();
    return $result;
  }else{
    $stmt->close();
    return NULL;
  }

}



    /*** รายการองค์ความรู้ ***/
    public function getKnowledge($limit,$offset,$filter,$sort) {

        $filtersql = $this->func->filter_sql($filter);
        $limitsql  = $this->func->limit_sql($limit,$offset);
        $sortsql   = $this->func->sort_sql($sort);

        // $stmt = $this->conn->prepare("SELECT case_id,caseDtl_title,prodType_name,compType_name FROM `Case` a
        //   LEFT JOIN Product_Type b ON a.prodType_id = b.prodType_id
        //   LEFT JOIN Complaint_Type c ON a.compType_id = c.compType_id
        //   WHERE case_knowledge_type = '1' and ".$filtersql.$sortsql.$limitsql);

        $stmt = $this->conn->prepare("select case_id,caseDtl_title,b.prodType_name,compType_name,d.incType_id,d.incType_name,d.incType_name_en from Case_Knowledge a
        left JOIN Product_Type b on a.prodType_id=b.prodType_id
        left JOIN Complaint_Type c on a.compType_id = c.compType_id
        left JOIN Incorrect_Type d on a.incType_id = d.incType_id
        where caseKnlg_status = '1' and caseKnlg_enable='1' ".$filtersql.$sortsql.$limitsql);

        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
          $stmt->close();
          return $result;
        }else{
          $stmt->close();
          return NULL;
        }
    }




    /*** ประเภทเรื่องร้องเรียน ***/
    public function getTypeComplaint() {
        $stmt = $this->conn->prepare("SELECT * FROM Complaint_Type WHERE compType_status = '0' ");
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){

          while($res = $result->fetch_assoc())
  				{
            $response = array(
  						"compType_id" => $res['compType_id'],
              "compType_name" => $res['compType_name'],
              "compType_name_en" => $res['compType_name_en'],
              "levelmenu" => 1
  					);
  					$output[]=$response;
  					$id[]= $res['compType_id'];
  				}
          $response = array();
          foreach ($output as $key => $product) {
            $stmt = $this->conn->prepare("SELECT * FROM Complaint_Type_Sub1 WHERE compType_id ='$id[$key]' and compTypeSub1_status = '0' ");
            $stmt->execute();
            $result2 = $stmt->get_result();
  					while($res2 = $result2->fetch_assoc())
  					{
    					$response = array(
    						"compTypeSub1_id" => $res2['compTypeSub1_id'],
                "compTypeSub1_name" => $res2['compTypeSub1_name'],
                "compTypeSub1_name_en" => $res2['compTypeSub1_name_en'],
    					);
    					$output3[]=$response;
              $id2[]= $res2['compTypeSub1_id'];
    					$output[$key]['compType_Sub1'] = $output3 ;
              $output[$key]['levelmenu']=2;
  					}
  					$output3 = array();
            $response = array();
            foreach ($output[$key]['compType_Sub1'] as $key2 => $product) {
              $stmt = $this->conn->prepare("SELECT * FROM Complaint_Type_Sub2 WHERE compTypeSub1_id ='$id[$key]' and compTypeSub2_status = '0' ");
              $stmt->execute();
              $result3 = $stmt->get_result();
    					while($res3 = $result3->fetch_assoc())
    					{
      					$response = array(
      						"compTypeSub2_id" => $res3['compTypeSub2_id'],
                  "compTypeSub2_name" => $res3['compTypeSub2_name'],
                  "compTypeSub2_name_en" => $res3['compTypeSub2_name_en'],
      					);
      					$output4[]=$response;
      					$output[$key]['compType_Sub1'][$key2]['compType_Sub2'] = $output4 ;
                $output[$key]['levelmenu']=3;
    					}
    					$output4 = array();
    				}

  				}
          $stmt->close();
          return $output;
        }else{
          $stmt->close();
          return NULL;
        }
    }




}

?>
