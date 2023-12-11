<?php

if (basename(__FILE__) == basename($_SERVER['PHP_SELF'])) {
    header("Location: /");
    exit;
}

use Palmo\Core\service\Db;
use Palmo\Core\service\FilmsService;


$db = new Db();
$dbh = $db->getHandler();

$filmsService = new FilmsService($dbh);

$page = $_GET['page'] ?? 1;
$search = $_GET['search'] ?? '';
$sort = $_GET['sort'] ?? '';
$isMore = $_GET['more'] ?? false;
$genresArr = isset($_GET['genres']) ? $_GET['genres'] : [];

$genreSelectors = [];
foreach ($genresArr as $idStr) {
    $id = (int)$idStr;
    if (is_int($id) && $id !== 0) {
        $genreSelectors[] = "'$id' = film_genre.genre_id ";
    }
}
$genresString = implode(' OR ', $genreSelectors);

$countGenres = count($genreSelectors);
$genresFiltre = $countGenres > 0 ? "AND films.id IN (SELECT film_genre.film_id
FROM film_genre
WHERE $genresString
GROUP BY film_genre.film_id
HAVING COUNT(film_genre.genre_id)= '$countGenres')
" : '';

$url = $params['url'];

$switchSort = match ($sort) {
    "popularity.desc" => "popularity desc",
    "popularity.asc" => "popularity asc",
    "vote.desc" => "vote desc",
    "vote.asc" => "vote asc",
    "release_date.desc" => "release_date desc",
    "release_date.asc" => "release_date asc",
    "title.asc" => "title asc",
    "title.desc" => "title desc",
    default => "release_date desc"
};

$total = $filmsService->getTotalFilmsCount($search, $genresFiltre);

$maxFillPage =  18;
$maxPage = ceil($total / $maxFillPage);

if ($maxPage < $page || $page < 1) {
    $page = $maxPage;
}

$startItem = $maxFillPage * ($page - 1);

$films = $filmsService->getFilms($search, $genresFiltre, $switchSort, $maxFillPage, $startItem);

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
