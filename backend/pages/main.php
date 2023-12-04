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



$dsn = 'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_USERNAME'] . '';
try {
    $pdo = new PDO($dsn,    $_ENV['DB_USERNAME'],     $_ENV['DB_PASSWORD']);
} catch (PDOException $e) {
    echo 'помилка підключення: ' . $e->getMessage();
}


$total = $pdo->query("SELECT COUNT(*) AS total_records
FROM (
    SELECT films.id
    FROM films
    JOIN film_genre ON films.id = film_genre.film_id
    JOIN genres ON film_genre.genre_id = genres.id
    GROUP BY films.id
) AS subquery;")->fetchAll(PDO::FETCH_ASSOC)[0]['total_records'];

$page = $query['page'] ?? 1;
$url = $params['url'];

$maxFillPage =  18;
$maxPage = ceil($total / $maxFillPage);



if ($maxPage < $page) {
    $page = $maxPage;
}

$startItem = $maxFillPage * ($page - 1);

$films = $pdo->query("SELECT
films.id,
films.title,
films.release_date,
films.backdrop_path,
CONCAT_WS(', ', GROUP_CONCAT(genres.name)) AS genres
FROM films
JOIN film_genre ON films.id = film_genre.film_id
JOIN genres ON film_genre.genre_id = genres.id
GROUP BY films.id
ORDER BY films.release_date DESC
LIMIT $maxFillPage OFFSET $startItem;")->fetchAll(PDO::FETCH_ASSOC);


echo '<br>params = "' . json_encode($params) . '"<br>';
echo '<br>query = "' . json_encode($query) . '"<br>';

// dd($films)
?>



<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Backend</title>
    <base href="/">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="./favicon.ico">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>


    <!-- Custom styles for this template -->
    <!-- <link href="css/form-validation.css" rel="stylesheet"> -->
    <link href="css/style_main.css" rel="stylesheet">
</head>

<body>
    <div class="page">
        <?php include 'components/header.php' ?>
        <!-- <h2>Головна сторінка</h2> -->

        <section class="section">
            <div class="container">
                <?php
                include 'components/gallery.php' ?>

                <?php
                include 'components/pagination.php' ?>
            </div>
        </section>

        <?php
        //  Вивід помилок
        // if (isset($_SESSION['error'])) {
        //     $error = $_SESSION['error'];
        //     echo "<p style='color:red;'>$error</p>";
        // }
        ?>

        <!-- <form method="POST" action="scripts/main.php">
            <label for="username">Логін:</label>
            <input type="text" id="username" name="username" required><br>

            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" required><br>

            <input type="submit" value="Увійти">
        </form> -->
    </div>

</body>

</html>