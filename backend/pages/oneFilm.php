<?php

if (basename(__FILE__) == basename($_SERVER['PHP_SELF'])) {
    header("Location: /");
    exit;
}

require __DIR__ . '/../vendor/autoload.php';
session_start();
// session_destroy();
// Перевірка, чи користувач вже авторизований
if (isset($_SESSION['user_id'])) {
    header("Location: scripts/dashboard.php");
    exit();
}


// dd($_ENV, $_SESSION);
// echo 'My username is ' . $_ENV["USER"] . '!';

$dsn = 'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_USERNAME'] . '';
try {
    $pdo = new PDO($dsn,    $_ENV['DB_USERNAME'],     $_ENV['DB_PASSWORD']);
} catch (PDOException $e) {
    echo 'помилка підключення: ' . $e->getMessage();
}
$id = $params['id'];
$result = $pdo->query("SELECT films.*, CONCAT_WS(', ', GROUP_CONCAT(genres.name)) AS genres 
FROM films JOIN film_genre ON films.id = film_genre.film_id JOIN genres ON film_genre.genre_id = genres.id 
WHERE films.id = '$id' GROUP BY films.id;")->fetchAll(PDO::FETCH_ASSOC);
// echo '<br>params = "' . json_encode($params) . '"<br>';
// echo '<br>query = "' . json_encode($query) . '"<br>';
$film = $result[0];

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
                    <img class="modal__img" src="<?php echo $film['backdrop_path']; ?>" alt="<?php echo $film['title']; ?>">

                    <div class="film__info">
                        <h2 class="modal__title">
                            <?php echo $film['title']; ?>
                        </h2>
                        <div class="film__info-list">
                            <span class="film__property vote">Vote / Votes</span>
                            <div class="film__stat">
                                <span class="film__stat-vote">{{this.vote_average}}</span>/ <span class="film__stat-vote film__stat-votes">{{this.vote_count}}</span>
                            </div>
                        </div>

                        <div class="film__info-list">
                            <span class="film__property popularity">Popularity</span>
                            <span class="film__stat">{{this.popularity}}</span>
                        </div>

                        <div class="film__info-list">
                            <span class="film__property original-title">Original Title</span>
                            <span class="film__stat">{{this.original_title}}</span>
                        </div>

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

            </div>
        </section>
    </div>

</body>

</html>