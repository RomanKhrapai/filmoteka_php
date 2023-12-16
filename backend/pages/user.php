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
    <link href="../css/style_form.css" rel="stylesheet">
    <link href="../css/addfilm.css" rel="stylesheet">
    <title>log in</title>
</head>

<body>
    <div class="page">
        <?php include 'components/header.php' ?>

        <div class="container">
            <h2>User page </h2>

            <?php
            include 'components/addFilm.php'
            ?>
        </div>
    </div>
</body>

</html>