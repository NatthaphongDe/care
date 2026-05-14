<?php
if(isset($_GET["method"]) && $_GET["method"]=="admin_function"){
   include("../../config/config.php");
    $post = array();
    $request_body = file_get_contents('php://input');
    $post = json_decode($request_body);
    $response = admin_function($post);
    echo $response;

    exit();
}

function admin_function($post){
  include("../../config/config.php");
  if($post->text == ""){
    $whereSearch = "";
  }else {
    $whereSearch = " AND (em.emp_firstname LIKE '%".$post->text."%' OR em.emp_lastname LIKE '%".$post->text."%')";
  }
  $caseCh_arr = array();
  $sql = "SELECT
          bl.feedback_list_by,
          em.emp_firstname,
          em.emp_lastname,
          em.office_id,
          ot.office_name,
          bl.feedback_list_datetime,
          bl.feedback_list_id
          FROM Feedback_Backend_List AS bl
          LEFT JOIN Employee AS em ON bl.feedback_list_by = em.emp_id
          LEFT JOIN office_type AS ot ON em.office_id = ot.office_id
          WHERE 1 $whereSearch ";
          if($post->sort=="id"){
            $sort_col = "em.emp_firstname";
          }
          if($post->sort=="name"){
            $sort_col = "em.emp_firstname";
          }
          if($post->sort=="office"){
            $sort_col = "ot.office_name";
          }

          if($post->sort=="date"){
            $sort_col = "bl.feedback_list_datetime";
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
            $caseCh_col_arr["name"] .= '<span class="txt_nol">'.$res['emp_firstname'].'&nbsp;&nbsp;'.$res['emp_lastname'].'</span>';

            if($res['office_name'] == ""){
              $office_name = "สำนักสารสนเทศและการบริการการค้าระหว่างประเทศ";
            }else {
              $office_name = $res['office_name'];
            }
            $caseCh_col_arr["office"] .= '<span class="txt_nol">'.$office_name.'</span>';
            $caseCh_col_arr["date"] .= '<span class="txt_nol">'.date("d/m/Y",strtotime($res['feedback_list_datetime'])).'</span>';
            $caseCh_col_arr["search"] .= '<button type="button" class="btn btn-default" onclick="show_detail('.$res['feedback_list_id'].');"><i class="fa fa-search" aria-hidden="true"></i></button>';

            array_push($caseCh_arr,$caseCh_col_arr);
          }

  $data_array = array('total'=>$num,'rows'=>$caseCh_arr);
  return json_encode($data_array);
}

?>
