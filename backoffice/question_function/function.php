<?php
switch ($_POST['method']) {
  case "show_detailAW":
    echo show_detailAW();
  break;
  case "show_detailAWF":
    echo show_detailAWF();
  break;
  case "show_detailAPF":
    echo show_detailAPF();
  break;
}

function show_detailAW(){
  include("../../config/config.php");
  $sql = "SELECT
          ba.feedback_q_id,
          ba.feedback_a_result,
          bl.feedback_list_by,
          em.emp_firstname,
          em.emp_lastname,
          em.office_id,
          ot.office_name,
          bq.feedback_q_title
          FROM Feedback_Backend_Answers AS ba
          LEFT JOIN Feedback_Backend_List AS bl ON ba.feedback_list_id = bl.feedback_list_id
          LEFT JOIN Employee AS em ON bl.feedback_list_by = em.emp_id
          LEFT JOIN office_type AS ot ON em.office_id = ot.office_id
          LEFT JOIN Feedback_Backend_Question AS bq ON ba.feedback_q_id = bq.feedback_q_id
          WHERE bl.feedback_list_id = '".$_POST['id']."' ";
    $query = $conn->query($sql);
    $i = 1;
    $output_row = array();
    while ($res = $query->fetch_assoc()) {
      $output = array();
      $output['name_emp'] = '<div class="name_emp">'.$res['emp_firstname'].'&nbsp;&nbsp;'.$res['emp_lastname'].'</div>';
      $output['num'] .= '<td class="num" style="border-bottom: solid 1px #ddd;padding: 5px; text-align:center;">'.$i.'</td>';
      $output['feedback'] .= '<td class="feedback" style="border-bottom: solid 1px #ddd;padding: 5px;">'.$res['feedback_q_title'].'</td>';
      $output['result'] .= '<td class="result" style="border-bottom: solid 1px #ddd;padding: 5px;">'.$res['feedback_a_result'].'</td>';
      array_push($output_row,$output);
      $i++;
    }
  header("content-type:application/json;charset=utf-8");
  echo json_encode( $output_row );
}

function show_detailAWF(){
  include("../../config/config.php");
  $sql = "SELECT
          fa.feedback_q_id,
          fa.feedback_a_result,
          fl.feedback_list_by,
          mb.member_fname,
          mb.member_lname,
          mb.member_email,
          fq.feedback_q_title
          FROM Feedback_Frontend_Answers AS fa
          LEFT JOIN Feedback_Frontend_List AS fl ON fa.feedback_list_id = fl.feedback_list_id
          LEFT JOIN Member AS mb ON fl.feedback_list_by = mb.member_id
          LEFT JOIN Feedback_Frontend_Question AS fq ON fa.feedback_q_id = fq.feedback_q_id
          WHERE fl.feedback_list_id = '".$_POST['id']."' ";
    $query = $conn->query($sql);
    $i = 1;
    $output_row = array();
    while ($res = $query->fetch_assoc()) {
      $output = array();
      $output['name_emp'] = '<div class="name_emp">'.$res['member_fname'].'&nbsp;&nbsp;'.$res['member_lname'].'</div>';
      $output['num'] .= '<td class="num" style="border-bottom: solid 1px #ddd;padding: 5px; text-align:center;">'.$i.'</td>';
      $output['feedback'] .= '<td class="feedback" style="border-bottom: solid 1px #ddd;padding: 5px;">'.$res['feedback_q_title'].'</td>';
      $output['result'] .= '<td class="result" style="border-bottom: solid 1px #ddd;padding: 5px;">'.$res['feedback_a_result'].'</td>';
      array_push($output_row,$output);
      $i++;
    }
  header("content-type:application/json;charset=utf-8");
  echo json_encode( $output_row );
}

function show_detailAPF(){
  include("../../config/config.php");
  $sql = "SELECT
          fa.feedback_q_id,
          fa.feedback_a_result,
          fl.feedback_list_by,
          mb.member_fname,
          mb.member_lname,
          mb.member_email,
          fq.feedback_q_title
          FROM Feedback_App_Answers AS fa
          LEFT JOIN Feedback_App_List AS fl ON fa.feedback_list_id = fl.feedback_list_id
          LEFT JOIN Member AS mb ON fl.feedback_list_by = mb.member_id
          LEFT JOIN Feedback_App_Question AS fq ON fa.feedback_q_id = fq.feedback_q_id
          WHERE fl.feedback_list_id = '".$_POST['id']."' ";
    $query = $conn->query($sql);
    $i = 1;
    $output_row = array();
    while ($res = $query->fetch_assoc()) {
      $output = array();
      $output['name_emp'] = '<div class="name_emp">'.$res['member_fname'].'&nbsp;&nbsp;'.$res['member_lname'].'</div>';
      $output['num'] .= '<td class="num" style="border-bottom: solid 1px #ddd;padding: 5px; text-align:center;">'.$i.'</td>';
      $output['feedback'] .= '<td class="feedback" style="border-bottom: solid 1px #ddd;padding: 5px;">'.$res['feedback_q_title'].'</td>';
      $output['result'] .= '<td class="result" style="border-bottom: solid 1px #ddd;padding: 5px;">'.$res['feedback_a_result'].'</td>';
      array_push($output_row,$output);
      $i++;
    }
  header("content-type:application/json;charset=utf-8");
  echo json_encode( $output_row );
}
?>
