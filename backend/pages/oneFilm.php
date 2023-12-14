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

$id = $params['id'];
// $stmt = $dbh->prepare((empty($_SESSION['user']['id'])) ?
//     "INSERT INTO `popularity`( `film_id`) VALUES  (:id);"
//     :
//     "INSERT INTO `popularity`( `film_id`, `user_id`) VALUES (:id,:user_id);
//    ");

// $stmt->bindParam(':id', $id);

// if (!empty($_SESSION['user']['id'])) {
//     $stmt->bindParam(':user_id', $_SESSION['user']['id']);
// }

// $stmt->execute();
$user_id = $_SESSION['user']['id'] ?? null;
$result = $filmsService->setPopularity($id, $user_id);

// $stmt = $dbh->prepare("SELECT 
// films.id AS film_id,
// films.title,
// films.release_date,
// films.backdrop_path,
// overview,
// CONCAT_WS(', ', GROUP_CONCAT(DISTINCT genres.name)) AS genres,
// AVG(vote.mark) AS vote,
// COUNT(DISTINCT vote.id)  AS votes,
//  COUNT(DISTINCT popularity.id) AS popularity
// FROM 
// films
// JOIN 
// film_genre ON films.id = film_genre.film_id
// JOIN 
// genres ON film_genre.genre_id = genres.id
// JOIN 
// vote ON vote.film_id = films.id
// JOIN 
// popularity ON popularity.film_id = films.id
// WHERE 
// films.id = :id
// GROUP BY 
// films.id, films.title, films.release_date, films.backdrop_path, overview;
// ");
// $stmt->bindParam(':id', $id);

// $stmt->execute();
$film = $filmsService->getFilm($id);

// $stmt = $dbh->prepare("SELECT 
// comments.id, comments.user_id, comments.text, create_date, users.url_img, users.username FROM
// comments
// JOIN 
// users ON comments.user_id = users.id
//  WHERE film_id=:id  
// ORDER BY `comments`.`create_date` DESC
//   ;");
// $stmt->bindParam(':id', $id);

// $stmt->execute();
$comments = $filmsService->getComents($id);

//dd($comments, $film, $result);

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
                <h1 class="visually-hidden">Film</h1>
                <?php
                empty($film) ? include 'components/noFilm.php' : include 'components/filmMain.php'
                ?>

            </div>
        </section>
    </div>

</body>

</html>