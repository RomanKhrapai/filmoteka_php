<?php

if (basename(__FILE__) == basename($_SERVER['PHP_SELF'])) {
    header("Location: /");
    exit;
}

require __DIR__ . '/../vendor/autoload.php';

use Palmo\Core\service\Db;
use Palmo\Core\service\Validation;

$db = new Db();
$dbh = $db->getHandler();

$stmt = $dbh->prepare("SELECT COUNT(*) AS total_records
FROM (
    SELECT films.id
    FROM films
    JOIN film_genre ON films.id = film_genre.film_id
    JOIN genres ON film_genre.genre_id = genres.id
    JOIN vote ON vote.film_id = films.id
    GROUP BY films.id
) AS subquery;");
// $stmt->bindParam(':token', $token);
// $stmt->bindParam(':userId', $user['id']);
// $stmt->bindParam(':validUntil', $validUntil);
$stmt->execute();
$total = $stmt->fetch()['total_records'];



$page = $_GET['page'] ?? 1;
$url = $params['url'];

$maxFillPage =  18;
$maxPage = ceil($total / $maxFillPage);



if ($maxPage < $page) {
    $page = $maxPage;
}

$startItem = $maxFillPage * ($page - 1);
// SELECT avg(*) FROM vote WHERE film_id = 1047925;
$stmt = $dbh->prepare("SELECT
films.id,
films.title,
films.release_date,
films.backdrop_path,
CONCAT_WS(', ', GROUP_CONCAT(DISTINCT genres.name)) AS genres,
AVG(vote.mark) AS vote,
count(vote.mark)AS votes
FROM films
JOIN film_genre ON films.id = film_genre.film_id
JOIN genres ON film_genre.genre_id = genres.id
JOIN vote ON vote.film_id = films.id
GROUP BY films.id

ORDER BY films.release_date DESC
LIMIT :maxFillPage OFFSET :startItem;");
$stmt->bindParam(':maxFillPage', $maxFillPage);
$stmt->bindParam(':startItem', $startItem);

$stmt->execute();
$films = $stmt->fetchAll();
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
        <?php

        include 'components/header.php' ?>

        <section class="section_min">
            <div class="container">
                <?php
                include 'components/hero.php'
                ?>

                <?php
                include 'components/gallery.php'
                ?>

                <?php
                include 'components/pagination.php'
                ?>
            </div>
        </section>


    </div>

</body>

</html>
<?php
dd($_GET);