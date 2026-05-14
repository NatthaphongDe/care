<?php include("../config/config.php"); ?>
<?php


// AND holiday_date_amount =
//       (	SELECT  holiday_date_amount
// 		FROM `PublicHoliday`
//
//       );
// echo
$sql = "  SELECT a.case_id
                ,a.case_opened_datetime as case_opened_datetime_org
                , DATE_FORMAT(case_opened_datetime, '%Y-%m-%d 00:00:00') as  case_opened_datetime
                ,a.case_close_datetime as case_close_datetime
                ,(SELECT case_compType_duration - SUM(  holiday_date_amount )
                  FROM `PublicHoliday` WHERE  holiday_date_start >= case_opened_datetime AND holiday_date_end  <= case_close_datetime )  as holiday

                ,a.case_compType_duration
          FROM `Case` AS a
          LEFT JOIN Complaint_Type AS b ON a.compType_id = b.compType_id
          WHERE `case_status` = 3
          AND    (case_opened_datetime) > case_close_datetime
          -- AND opened > case_close_datetime
          -- ORDER BY holiday DESC
           ";
$query = $conn->query($sql);
$num_holiday_public = $query->num_rows;
  while($result = $query->fetch_assoc()){
    echo "<pre>";
    print_r($result);
    echo "<pre>";
  }
 ?>
