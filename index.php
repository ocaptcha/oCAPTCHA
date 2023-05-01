<?php
function find(string $captcha, string $path): string | false {
    $captchas = scandir($path);

    for ($i = 2; $i < sizeof($captchas); $i++) {
        $found = explode('-', $captchas[$i])[0];

        if ($found == $captcha) {
            return $path.$captchas[$i];
        }
    }

    return false;
}

if (!isset($_GET['id'])) {
    header('Location: /error/missingQuery.php?query=id');
    die();
}

$captcha = find($_GET['id'], './challenges/');

if (!$captcha) {
    header('Location: /error/notFound.php?item='.$_GET['id']);
    die();
}

header('Content-Type: image/png');
$captchaBytes = fopen($captcha, 'rb');
fpassthru($captchaBytes);
?>