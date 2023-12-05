<?php

require __DIR__ . '/../vendor/autoload.php';

if (basename(__FILE__) == basename($_SERVER['PHP_SELF'])) {
    header("Location: /");
    exit;
}

session_start();
// session_destroy();
// Перевірка, чи користувач вже авторизований
if (isset($_SESSION['user_id'])) {
    header("Location: scripts/dashboard.php");
    exit();
}




?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/style_main.css" rel="stylesheet">
    <link href="../css/style_logIn.css" rel="stylesheet">
    <title>Страниця авторизації</title>
</head>

<body>
    <div class="page">
        <?php include 'components/header.php' ?>

        <div class="container">
            <section class="auth-section">
                <div class="auth-container registration">
                    <h1 class="main-title registration__title">Login</h1>
                    <form class="login__form form login__form">
                        <label class="custom-label login__input" autocomplete="email" placeholder="mail" name="email">
                            E-mail
                            <input autocomplete="email" placeholder="E-mail" name="email" class="login__input custom-input">
                        </label><label class="custom-label login__input" type="password" autocomplete="current-password" placeholder="password" name="password">
                            Password
                            <input type="password" autocomplete="current-password" placeholder="password" name="password" class="login__input custom-input">
                        </label>
                        <button class="login__btn btn login__btn" type="submit">
                            submit</button>
                    </form>
                    <a class="link"> Sign up</a>
                </div>
            </section>
        </div>

    </div>
    <!-- <div class="container">
        <form class="login-form">
            <h2>Вхід</h2>
            <label for="username">Логін:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Увійти</button>
        </form>
    </div> -->
</body>

</html>