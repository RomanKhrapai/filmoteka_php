<?php

require __DIR__ . '/../vendor/autoload.php';

if (basename(__FILE__) == basename($_SERVER['PHP_SELF'])) {
    header("Location: /");
    exit;
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/style_main.css" rel="stylesheet">
    <link href="../css/style_auth.css" rel="stylesheet">
    <title>log in</title>
</head>

<body>
    <div class="page">
        <?php include 'components/header.php' ?>

        <div class="container">
            <h2>User page </h2>
            <div class="tabs">
                <a href="/user?addfilm"> <button class="tab-btn" name="tab" value="tab1">add film</button></a>
                <a href="/user?change-user-data"> <button class="tab-btn" name="tab" value="tab2">Вкладка 2</button></a>

            </div>

            <?php
            // if (isset($_GET['addfilm'])) {
            //     include 'components/addFilm.php';
            // }

            match (true) {
                isset($_GET['addfilm']) => include 'components/addFilm.php',
                isset($_GET['change-user-data']) => include 'components/addFilm.php',
                default => include 'components/addFilm.php'
            }

            ?>




        </div>
    </div>
</body>

</html>