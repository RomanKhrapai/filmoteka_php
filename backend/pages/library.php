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

$user_id = $_SESSION['user']['id'] ?? null;

$grup = $_GET['grup'] ?? '';

$total = $userService->getTotalFilmsCount($user_id, $grup);

$page = $query['page'] ?? 1;
$url = $params['url'];

$maxFillPage =  18;
$maxPage = ceil($total / $maxFillPage);

if ($maxPage < $page) {
    $page = $maxPage;
}

$startItem = $maxFillPage * ($page - 1);

$films =  $userService->getLibraryFilms($user_id, $grup, $maxFillPage, $startItem);
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

        <section class="section_min">
            <div class="container">

                <div class="main__btn_box">
                    <a class="main__link" href="/library?grup=pending"> <?= $grup === 'pending' ? 'PANDING' : "SHOW PANDING" ?></a>
                    <a class="main__link" href="/library?grup=favirite"> <?= $grup === 'favirite' ? 'FAVIRITE' : "SHOW FAVIRITE" ?></a>
                    <a class="main__link" href="/library"> <?= $grup !== 'favirite' && $grup !== 'pending' ? 'ALL' : "SHOW ALL" ?></a>
                </div>

                <?php include 'components/gallery.php' ?>

                <?php include 'components/pagination.php' ?>
            </div>
        </section>
    </div>

</body>

</html>