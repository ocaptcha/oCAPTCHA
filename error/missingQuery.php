<?php
header('Content-Type: application/json');
http_response_code(400);

$error = array(
    'code' => 400,
    'error' => 'Missing required query: '.$_GET['query']
);

echo json_encode($error);

die();
?>