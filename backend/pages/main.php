<?php

if (basename(__FILE__) == basename($_SERVER['PHP_SELF'])) {
    header("Location: /");
    exit;
}

require __DIR__ . '/../vendor/autoload.php';

use Palmo\Core\service\Db;
use Palmo\Core\service\FilmsService;

$db = new Db();
$dbh = $db->getHandler();

$filmsService = new FilmsService($dbh);
$films = $filmsService->getLastFilms();

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
</head>

<body>
    <div class="page">
        <?php include 'components/header.php' ?>

        <section class="section">
            <div class="container">
                <?php
                include 'components/gallery.php' ?>

            </div>
        </section>

    </div>

</body>

</html>