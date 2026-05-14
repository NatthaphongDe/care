<?php

class DbHandler {

    private $conn,$func;
    function __construct() {
        require_once dirname(__FILE__) . '/DbConnect.php';
        $db = new DbConnect();
        $this->conn = $db->connect();
        require_once dirname(__FILE__) . '/DbFunction2.php';
        $this->func = new DbFunction();
        require_once 'PassHash.php';

        header('Content-Type: application/json; charset=utf-8');
        $headers = apache_request_headers();
        if( (empty($headers['Authorization']) || $headers['Authorization'] != 'FGYTGVCDRTYJ') && (empty($headers['authorization']) || $headers['authorization'] != 'FGYTGVCDRTYJ')){
            echo json_encode([
                'res_status' => 'fail',
                'res_result' => 'Authorization not found'
            ]);
            exit;
        }
        
    }
    public function DateThai($strDate)
	{
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strHour= date("H",strtotime($strDate));
		$strMinute= date("i",strtotime($strDate));
		$strSeconds= date("s",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return $strMonthThai." ".substr($strYear,2);
	}
    public function DateThai_Full($strDate)
    {
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));
        $strHour= date("H",strtotime($strDate));
        $strMinute= date("i",strtotime($strDate));
        $strSeconds= date("s",strtotime($strDate));
        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        $strMonthThai=$strMonthCut[$strMonth];
        return $strDay." ".$strMonthThai." ".substr($strYear,2);
    }
    public function country() {
        if(empty($_POST['date_start']) || empty($_POST['date_end'])){
            return [
                'res_code' => '400',
                'res_status' => 'fail',
                'res_result' => 'date_start or date_end not found'
            ];
        }
        if(strtotime($_POST['date_start']) > strtotime($_POST['date_end'])){
            return [
                'res_code' => '400',
                'res_text' => 'Bad Request',
                'res_result' => 'date_start or date_end not found'
            ];
        }       
        $sql = 'SELECT co.id ,co.name_th,  co.name, co.flag_128  ,COUNT(c.applnt_country_id) as country_num
        FROM `Case` as c
        LEFT JOIN Country as co ON co.id = c.applnt_country_id
        WHERE 1 AND co.id IS NOT NULL AND c.case_receivedoc_date >= "'.$_POST['date_start'].'" 
        AND c.case_receivedoc_date <= "'.$_POST['date_end'].'"
        GROUP BY applnt_country_id
        ORDER BY country_num DESC
        LIMIT '.$_POST['offset'].' , '.$_POST['limit'].'
        ';
        $result = $this->conn->query($sql);
        $arr = [];
        if($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $arr[] = [
                    "country_id" => $row['id'],
                    "country_name_th" => $row['name_th'],
                    "country_name_en" => $row['name'],
                    "flags" => 'https://care.ditp.go.th/backoffice/img/flags/'.$row['flag_128'],
                    "num" => $row['country_num'],
                ];
            }
        } 
        return [
            'res_code' => '200',
            'res_status' => 'success',
            'res_result' => $arr
        ];
    }

    public function complnt_country() {
        if(empty($_POST['date_start']) || empty($_POST['date_end'])){
            return [
                'res_status' => 'fail',
                'res_result' => 'date_start or date_end not found'
            ];
        }
        if(strtotime($_POST['date_start']) > strtotime($_POST['date_end'])){
            return [
                'res_code' => '400',
                'res_text' => 'Bad Request',
                'res_result' => 'date_start or date_end not found'
            ];
        }          
        $sql = 'SELECT co.id ,co.name_th,  co.name, co.flag_128  ,COUNT(c.complnt_country_id) as country_num
        FROM `Case` as c
        LEFT JOIN Country as co ON co.id = c.complnt_country_id
        WHERE 1 AND co.id IS NOT NULL  AND c.case_receivedoc_date >= "'.$_POST['date_start'].'" 
        AND c.case_receivedoc_date <= "'.$_POST['date_end'].'"
        GROUP BY complnt_country_id
        ORDER BY country_num DESC
        LIMIT '.$_POST['offset'].' , '.$_POST['limit'].'
        ';
        $result = $this->conn->query($sql);
        $arr = [];
        if($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $arr[] = [
                    "country_id" => $row['id'],
                    "country_name_th" => $row['name_th'],
                    "country_name_en" => $row['name'],
                    "flags" => 'https://care.ditp.go.th/backoffice/img/flags/'.$row['flag_128'],
                    "num" => $row['country_num']
                ];
            }
        } 
        return [
            'res_code' => '200',
            'res_status' => 'success',
            'res_result' => $arr
        ];
    }

    public function product() {
        if(empty($_POST['date_start']) || empty($_POST['date_end'])){
            return [
                'res_status' => 'fail',
                'res_result' => 'date_start or date_end not found'
            ];
        }
        if(strtotime($_POST['date_start']) > strtotime($_POST['date_end'])){
            return [
                'res_code' => '400',
                'res_text' => 'Bad Request',
                'res_result' => 'date_start or date_end not found'
            ];
        }        
        $sql_num = 'SELECT COUNT( case_id ) AS num FROM `Case` WHERE 1 AND case_receivedoc_date >= "'.$_POST['date_start'].'" 
        AND case_receivedoc_date <= "'.$_POST['date_end'].'"';
        $result_num = $this->conn->query($sql_num);
        $num = $result_num->fetch_assoc()['num'];
        
        $sql = 'SELECT p.prodType_id, p.prodType_name, p.prodType_name_en, COUNT( c.prodType_id ) as num_case
        FROM `Case` as c
        LEFT JOIN Product_Type as p USING(prodType_id)
        WHERE 1 AND c.prodType_id <> 0 AND c.case_receivedoc_date >= "'.$_POST['date_start'].'" 
        AND c.case_receivedoc_date <= "'.$_POST['date_end'].'"
        GROUP BY c.prodType_id
        ORDER BY num_case DESC
        LIMIT '.$_POST['offset'].' , '.$_POST['limit'].'
        ';
        $result = $this->conn->query($sql);
        $arr = [];
        if($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $arr[] = [
                    "product_id" => $row['prodType_id'],
                    "product_name_th" => $row['prodType_name'],
                    "product_name_en" => $row['prodType_name_en'],
                    "percent" => number_format(($row['num_case'] * 100 ) / $num).'%'
                ];
            }
        } 
        return [
            'res_code' => '200',
            'res_status' => 'success',
            'res_result' => $arr
        ];
    }

    public function case_type() {
        if(empty($_POST['date_start']) || empty($_POST['date_end'])){
            return [
                'res_status' => 'fail',
                'res_result' => 'date_start or date_end not found'
            ];
        }
        if(strtotime($_POST['date_start']) > strtotime($_POST['date_end'])){
            return [
                'res_code' => '400',
                'res_text' => 'Bad Request',
                'res_result' => 'date_start or date_end not found'
            ];
        }  
        $sql = 'SELECT co.compTypeSub2_name, co.compTypeSub2_name_en,compTypeSub2_id, COUNT( c.compTypeSub2_id ) as num_case
        FROM `Case` as c
        LEFT JOIN Complaint_Type_Sub2 as co USING(compTypeSub2_id)
        WHERE c.case_receivedoc_date >= "'.$_POST['date_start'].'" 
        AND c.case_receivedoc_date <= "'.$_POST['date_end'].'"
        GROUP BY c.compTypeSub2_id
        ORDER BY num_case DESC
        LIMIT '.$_POST['offset'].' , '.$_POST['limit'].'
        ';
        $result = $this->conn->query($sql);
        $arr = [];
        if($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                if(is_null($row['compTypeSub2_name'])){
                    $row['compTypeSub2_name'] = 'อื่นๆ';
                    $row['compTypeSub2_name_en'] = 'Other';
                }

                $arr[] = [
                    "case_type_id" => $row['compTypeSub2_id'],
                    "caseType_name_th" => $row['compTypeSub2_name'],
                    "caseType_name_en" => $row['compTypeSub2_name_en'],
                    "num" => $row['num_case']
                ];
            }
        } 
        return [
            'res_code' => '200',
            'res_status' => 'success',
            'res_result' => $arr
        ];
    }

    public function case_list() {
        $sql = 'SELECT case_id, caseDtl_title, p.prodType_name, p.prodType_name_en, co.name, co.name_th, of.office_name_short, case_status, case_receivedoc_date
        FROM `Case`
        LEFT JOIN Product_Type as p USING(prodType_id)
        LEFT JOIN Country as co ON co.id = Case.applnt_country_id
        LEFT JOIN office_type as of ON of.office_id = Case.office_id 
        WHERE 1  AND  case_status != "3"
        ';
        $where = '';
        if(!empty($_POST['search'])){
            $where = ' AND case_status != "3" AND ( caseDtl_title LIKE "%'.$_POST['search'].'%"
            OR case_receivedoc_date LIKE "%'.date('Y-m-d', strtotime($_POST['search'])).'%"
            OR co.name LIKE "%'.$_POST['search'].'%"
            OR p.prodType_name LIKE "%'.$_POST['search'].'%"
            OR of.office_name LIKE "%'.$_POST['search'].'%" 
            OR of.office_name_short LIKE "%'.$_POST['search'].'%" 
            ) 
            '; 
        }
        $sql = $sql.$where;
        $sql = $sql.' ORDER BY case_id DESC
        LIMIT '.$_POST['offset'].' , '.$_POST['limit'].' ';
        $result = $this->conn->query($sql);
        $arr = [];
        // echo $sql;
        if($result->num_rows > 0) {
            // output data of each row
            $status = ['รอดำเดินการ', 'รับเรื่องแล้ว', 'กำลังดำเนินการ', 'ดำเนินการเรียบร้อย'];
            while($row = $result->fetch_assoc()) {
                 // var_dump($row);
                $arr[] = [
                    "case_id" => $row['case_id'],
                    "receivedoc_date" => $this->DateThai_Full($row['case_receivedoc_date']),
                    "case_title" => $row['caseDtl_title'],
                    "product_name_th" => $row['prodType_name'],
                    "product_name_en" => $row['prodType_name_en'],
                    "country_name_th" => $row['name'],
                    "country_name_en" => $row['name_th'],
                    "office_name_short" => $row['office_name_short'],
                    "status" => $status[$row['case_status']]
                ];
            }
        } 
        return [
            'res_code' => '200',
            'res_status' => 'success',
            'res_result' => $arr
        ];
    }

    public function num_case() {
        if(empty($_POST['date_start']) || empty($_POST['date_end'])){
            return [
                'res_status' => 'fail',
                'res_result' => 'date_start or date_end not found'
            ];
        }
        if(strtotime($_POST['date_start']) > strtotime($_POST['date_end'])){
            return [
                'res_code' => '400',
                'res_text' => 'Bad Request',
                'res_result' => 'date_start or date_end not found'
            ];
        }  
        // $sql = 'SELECT COUNT( case_id ) AS num 
        // FROM `Case` 
        // WHERE case_receivedoc_date BETWEEN "'.$_POST['date_start'].'" AND "'.$_POST['date_end'].'"
        // ';
        $sql = 'SELECT COUNT( case_id ) AS num 
        FROM `Case` 
        WHERE case_receivedoc_date BETWEEN "'.$_POST['date_start'].'" AND "'.$_POST['date_end'].'"
        ';
        $sql2 = 'SELECT case_receivedoc_date, COUNT( case_id ) AS num 
        FROM `Case` 
        WHERE case_receivedoc_date BETWEEN "'.$_POST['date_start'].'" AND "'.$_POST['date_end'].'" 
        GROUP BY DATE_FORMAT(case_receivedoc_date, "%Y%m") order by case_receivedoc_date asc';
        $result = $this->conn->query($sql);
        $result2 = $this->conn->query($sql2);
        $arr2 = [];
        if($result2->num_rows > 0) {
            // output data of each row
            while($row = $result2->fetch_assoc()) {
                // echo $row['num'];
                $arr2[] = [
                    "num" => $row['num'],
                    "date_text" => $this->DateThai($row['case_receivedoc_date'])
                 ];
            }
        } 
        $arr = [];
        if($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $arr[] = [
                    "num" => $row['num'],
                    "date_text" => $this->DateThai($_POST['date_start'])." - ".$this->DateThai($_POST['date_end'])
                ];
            }
        } 
        return [
            'res_code' => '200',
            'res_status' => 'success',
            'res_result' => $arr,   
            'res_result_detail' => $arr2
        ];
    }

    public function case_close() {
        if(empty($_POST['date_start']) || empty($_POST['date_end'])){
            return [
                'res_status' => 'fail',
                'res_result' => 'date_start or date_end not found'
            ];
        }
        if(strtotime($_POST['date_start']) > strtotime($_POST['date_end'])){
            return [
                'res_code' => '400',
                'res_text' => 'Bad Request',
                'res_result' => 'date_start or date_end not found'
            ];
        }        
        $sql_all = 'SELECT COUNT( case_id ) AS num ,
            (SELECT COUNT( case_id ) AS num_close 
                FROM `Case` 
                WHERE case_status = 3
                AND case_receivedoc_date BETWEEN "'.$_POST['date_start'].'" AND "'.$_POST['date_end'].'"
            ) as num_close
        FROM `Case` 
        WHERE case_receivedoc_date BETWEEN "'.$_POST['date_start'].'" AND "'.$_POST['date_end'].'"
        ';
        $result_all = $this->conn->query($sql_all);
        $arr = [];

        $date1=date_create($_POST['date_start']);
        $date2=date_create($_POST['date_end']);
        $diff=date_diff($date1,$date2);
        $day = $diff->format("%a");

        if($result_all->num_rows > 0) {
            // output data of each row
            while($row = $result_all->fetch_assoc()) {
                $arr[] = [
                    "num_all" => $row['num'],
                    "num_close" => $row['num_close'],
                    "percent_close" => number_format(($row['num_close'] * 100 ) / $row['num']).'%',
                    "day_close" => number_format($day/$row['num_close'])
                ];
            }
        } 
        return [
            'res_code' => '200',
            'res_status' => 'success',
            'res_result' => $arr
        ];
    }   

}