<?php
require('CreateImage.php');

function generateSolution(int $length): string {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

    $solution = '';
    for ($i = 0; $i < $length; $i++) {
        $solution .= $characters[random_int(0, strlen($characters) - 1)];
    }

    return $solution;
}

function generateId(string $solution): string {
    $id = $solution.floor(microtime(true) * 1000);
    return hash('sha256', $id);
}

$solution = generateSolution(6);
$id = generateId($solution);
$filename = '../challenges/'.$id.'-'.$solution;
$captcha = new CreateImage($solution);
$captcha = $captcha->create();

imagepng($captcha, $filename);
imagedestroy($captcha);

header('Content-Type: application/json');

$response = array(
    'code' => 200,
    'error' => false,
    'id' => $id
);

echo json_encode($response);
?>