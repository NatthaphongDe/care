<?php
if(isset($_GET["method"]) && $_GET["method"]=="frontend_function"){
   include("../../config/config.php");
    $post = array();
    $request_body = file_get_contents('php://input');
    $post = json_decode($request_body);
    $response = frontend_function($post);
    echo $response;

    exit();
}

function frontend_function($post){
  include("../../config/config.php");
  if($post->text == ""){
    $whereSearch = "";
  }else {
    $whereSearch = " AND (mb.member_fname LIKE '%".$post->text."%' OR mb.member_lname LIKE '%".$post->text."%')";
  }
  $caseCh_arr = array();
  $sql = "SELECT
          fl.feedback_list_by,
          mb.member_fname,
          mb.member_lname,
          mb.member_email,
          fl.feedback_list_datetime,
          fl.feedback_list_id
          FROM Feedback_App_List AS fl
          LEFT JOIN Member AS mb ON fl.feedback_list_by = mb.member_id
          WHERE 1 $whereSearch ";
          if($post->sort=="id"){
            $sort_col = "mb.member_fname";
          }
          if($post->sort=="name"){
            $sort_col = "mb.member_fname";
          }

          $sql .= " ORDER BY $sort_col  $post->order ";
          $query = $conn->query($sql);
          $num = $query->num_rows;
          $sql .= " LIMIT $post->offset , $post->limit ";
          // echo $sql;
          $query_page = $conn->query($sql);

          $co_id = 0 ;
          while ($res = $query_page->fetch_assoc()) {
            $caseCh_col_arr = array();
            $co_id++ ;
            $num_page = $post->offset;
            $page = $co_id + $num_page;
            $caseCh_col_arr["id"] = '<span class="txt_nol">'.$page.'</span>';
            $caseCh_col_arr["name"] .= '<span class="txt_nol">'.$res['member_fname'].'&nbsp;&nbsp;'.$res['member_lname'].'</span>';
            $caseCh_col_arr["email"] .= '<span class="txt_nol">'.$res['member_email'].'</span>';
            $caseCh_col_arr["date"] .= '<span class="txt_nol">'.date("d/m/Y",strtotime($res['feedback_list_datetime'])).'</span>';
            $caseCh_col_arr["search"] .= '<button type="button" class="btn btn-default" onclick="show_detail('.$res['feedback_list_id'].');"><i class="fa fa-search" aria-hidden="true"></i></button>';

            array_push($caseCh_arr,$caseCh_col_arr);
          }

  $data_array = array('total'=>$num,'rows'=>$caseCh_arr);
  return json_encode($data_array);
}

?>
