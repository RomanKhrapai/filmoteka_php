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


$id = $params['id'];
$stmt = $dbh->prepare((empty($_SESSION['user']['id'])) ?
    "INSERT INTO `popularity`( `film_id`) VALUES  (:id);"
    :
    "INSERT INTO `popularity`( `film_id`, `user_id`) VALUES (:id,:user_id);
   ");

$stmt->bindParam(':id', $id);

if (!empty($_SESSION['user']['id'])) {
    $stmt->bindParam(':user_id', $_SESSION['user']['id']);
}

$stmt->execute();
$film = $stmt->fetch();

$stmt = $dbh->prepare("SELECT 
films.id AS film_id,
films.title,
films.release_date,
films.backdrop_path,
overview,
CONCAT_WS(', ', GROUP_CONCAT(DISTINCT genres.name)) AS genres,
AVG(vote.mark) AS vote,
COUNT(DISTINCT vote.id)  AS votes,
 COUNT(DISTINCT popularity.id) AS popularity
FROM 
films
JOIN 
film_genre ON films.id = film_genre.film_id
JOIN 
genres ON film_genre.genre_id = genres.id
JOIN 
vote ON vote.film_id = films.id
JOIN 
popularity ON popularity.film_id = films.id
WHERE 
films.id = :id
GROUP BY 
films.id, films.title, films.release_date, films.backdrop_path, overview;
");
$stmt->bindParam(':id', $id);

$stmt->execute();
$film = $stmt->fetch();

$stmt = $dbh->prepare("SELECT 
comments.id, comments.user_id, comments.text, create_date, users.url_img, users.username FROM
comments
JOIN 
users ON comments.user_id = users.id
 WHERE film_id=:id  
ORDER BY `comments`.`create_date` DESC
  ;");
$stmt->bindParam(':id', $id);

$stmt->execute();
$comments = $stmt->fetchAll();



// dd($film)
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
                <div class="data-modal-clear">
                    <img class="modal__img" src="<?= $film['backdrop_path']; ?>" alt="<?= $film['title']; ?>">

                    <div class="film__info">
                        <h2 class="modal__title">
                            <?= $film['title']; ?>
                        </h2>
                        <div class="film__info-list">
                            <span class="film__property vote">Vote / Votes</span>
                            <div class="film__stat">
                                <span class="film__stat-vote"><?= round($film['vote'], 1); ?></span>/ <span class="film__stat-vote film__stat-votes"><?= $film['votes']; ?></span>
                            </div>
                        </div>

                        <div class="film__info-list">
                            <span class="film__property popularity">Popularity</span>
                            <span class="film__stat"><?= round($film['popularity']); ?></span>
                        </div>

                        <!-- <div class="film__info-list">
                            <span class="film__property original-title">Original Title</span>
                            <span class="film__stat">{{this.original_title}}</span>
                        </div> -->

                        <div class="film__info-list">
                            <span class="film__property genre">Genre</span>
                            <span class="film__stat">
                                <?php echo $film['genres']; ?>
                            </span>
                        </div>

                        <div class="about">
                            <h3 class="about-title">
                                ABOUT
                            </h3>
                            <p class="about-text">
                                <?php echo $film['overview']; ?>

                            </p>
                        </div>
                        <div class="main__btn-modal">

                            <button type="button" id="btn__watched" class="main__btn " data-action="add">
                                ADD TO WATCHED
                            </button>
                            <button type="button" id="btn__queue" class="main__btn" data-action="add">

                                ADD TO QUEUE
                            </button>
                            <button type="button" id="btn__trailer" class="main__btn main__btn-margin" disabled="true">
                                OPEN TRAILER
                            </button>
                        </div>
                    </div>
                </div>
                <div id="show-video">
                </div>
                <?php include 'components/reviews.php' ?>
            </div>
        </section>
    </div>

</body>

</html>