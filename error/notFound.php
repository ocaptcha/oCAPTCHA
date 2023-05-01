<?php
header('Content-Type: application/json');
http_response_code(404);

$error = array(
    'code' => 404,
    'error' => 'Cannot not find captcha: '.$_GET['item']
);

echo json_encode($error);
die();
?>