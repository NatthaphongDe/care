<?php
$arr = array("book"=>array(

    array(
      "id"=> 1,
      "title"=>"Angels & Demons",
      "price"=>9.68,
      "authorId"=>1
    ),
    array(
      "id"=>2,
      "title"=>"The Da Vinci Code",
      "price"=>17.97,
      "authorId"=>1
    ),
    array(
      "id"=>3,
      "title"=>"It",
      "price"=>13.16,
      "authorId"=>2
    ),
    array(
      "id"=>4,
      "title"=>"A Game of Thrones (A Song of Ice and Fire, Book 1)",
      "price"=>10.33,
      "authorId"=>3
    )
));
echo json_encode($arr);
?>
