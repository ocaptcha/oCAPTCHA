<?php
function getSolution(string $id, string $path): string | false {
    $captchas = scandir($path);

    for ($i = 0; $i < sizeof($captchas); $i++) {
        $found = explode('-', $captchas[$i])[0];
        if ($found == $id) {
            $solution = explode('-', $captchas[$i])[1];
            return explode('.', $solution)[0];
        }
    }

    return false;
}

function scoreSolution(string $solution): float {
    $try = $_GET['solution'];

    // Highest possible score
    $possibleScore = 5 * strlen($solution);
    $score = 0;

    for ($i = 0; $i < strlen($try); $i++) {
        // Exact same solution gives 5 points per character
        if ($try[$i] == $solution[$i]) {
            $score += 5;
        }

        // Confused character-cases give 3 points
        elseif (strtolower($try[$i]) == strtolower($solution[$i])) {
            $score += 3;
        }

        else {
            $score += 1;
        }

    }

    return (100 / $possibleScore) * $score;
}

if (!isset($_GET['id'])) {
    header('Location: /error/missingQuery.php?query=id');
    die();
}

if (!isset($_GET['solution'])) {
    header('Location: /error/missingQuery.php?query=solution');
    die();
}

$solution = getSolution($_GET['id'], '../challenges/');

if (!$solution) {
    header('Location: /error/notFound.php?item='.$_GET['id']);
    die();
}

header('Content-Type: application/json');

$response = array(
    'code' => 200,
    'error' => false,
    'score' => scoreSolution($solution)
);

echo json_encode($response);
?>