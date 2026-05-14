<?php
session_start();
$_SESSION["visited_popup"] = 1;
$return = [
    'res_code' => '00',
    'res_text' => 'success !'
];

echo json_encode($return);
?>
