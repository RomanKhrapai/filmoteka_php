<?php

if (basename(__FILE__) == basename($_SERVER['PHP_SELF'])) {
    header("Location: /");
    exit;
}

require __DIR__ . '/../vendor/autoload.php';

use Palmo\Core\service\Db;
use Palmo\Core\service\FilmsService;
use Palmo\Core\service\UserService;

$db = new Db();
$dbh = $db->getHandler();
$filmsService = new FilmsService($dbh);
$userService = new UserService($dbh);

$id = $params['id'];
$isDelete = $params['delete'] ?? '' === 'delete';

$user_id = $_SESSION['user']['id'] ?? null;

$result = $filmsService->setPopularity($id, $user_id);

$film = $filmsService->getFilm($id);

$isPending =  !empty($userService->getPending($id, $user_id));
$isFavirite = !empty($userService->getFavirite($id, $user_id));

$vote = $userService->getMyVote($id, $user_id)['mark'] ?? false;

$comments = $filmsService->getComents($id);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Backend</title>
    <base href="/">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="./favicon.ico">

    <link href="css/style_main.css" rel="stylesheet">
    <link href="css/style_form.css" rel="stylesheet">
</head>

<body>
    <div class="page">
        <?php include 'components/header.php' ?>
        <section class="section">
            <div class="container">
                <h1 class="visually-hidden">Film</h1>
                <?php
                empty($film) ? include 'components/noFilm.php' : include 'components/filmMain.php'
                ?>


            </div>
        </section>
    </div>

</body>

</html>