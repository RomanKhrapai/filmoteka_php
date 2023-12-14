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
    <title>Страниця авторизації</title>
</head>

<body>
    <div class="page">
        <?php include 'components/header.php' ?>


        <div class="container">
            <section class="auth-section">
                <div class="auth-container registration">
                    <h1 class="main-title registration__title">Sign up</h1>
                    <form class="auth__form form auth__form" method="POST" action="/scripts/signup">

                        <label class="custom-label form__input" autocomplete="username" placeholder="name" name="username">
                            Name
                            <input autocomplete='username' placeholder='Name' name='username' <?= (isset($_SESSION['formData']['username'])) ? "value = '{$_SESSION['formData']['username']}'" : "" ?> class='form__input custom-input  <?= (isset($_SESSION['errorsForm']['username'])) ? " error__input" : "" ?> '>
                            <?= (isset($_SESSION['errorsForm']['username'])) ? "<span class='auth-error'>{$_SESSION['errorsForm']['username']}</span>" : '' ?>
                        </label>

                        <?= (isset($_SESSION['errorsForm']['email'])) ? $_SESSION['errorsForm']['email'] : "" ?>
                        <label class="custom-label form__input" autocomplete="email" placeholder="email" name="email">
                            E-mail
                            "<input autocomplete='email' placeholder='E-mail' name='email' <?= (isset($_SESSION['formData']['email'])) ? "value = '{$_SESSION['formData']['email']}'" : "" ?> class='form__input custom-input  <?= (isset($_SESSION['errorsForm']['email'])) ? " error__input" : "" ?> '>
                            <?= (isset($_SESSION['errorsForm']['email'])) ? "<span class='auth-error'>{$_SESSION['errorsForm']['email']}</span>" : '' ?>
                        </label>

                        <label class="custom-label form__input" type="password" autocomplete="current-password" placeholder="password" name="password">
                            Password
                            <input type='password' autocomplete='current-password' placeholder='password' name='password' class='form__input custom-input <?= (isset($_SESSION['errorsForm']['password'])) ? " error__input" : "" ?> '>
                            <?= (isset($_SESSION['errorsForm']['password'])) ? "<span class='auth-error'>{$_SESSION['errorsForm']['password']}</span>" : '' ?>
                        </label>

                        <label class="custom-label form__input" type="password" autocomplete="current-password" placeholder="confirm password" name="confirm-password">
                            Confirm password
                            <input type='password' autocomplete='current-password' placeholder='confirm password' name='confirm-password' class='form__input custom-input <?= (isset($_SESSION['errorsForm']['confirmPassword'])) ? " error__input" : "" ?> '>
                            <?= (isset($_SESSION['errorsForm']['confirmPassword'])) ? "<span class='auth-error'>{$_SESSION['errorsForm']['confirmPassword']}</span>" : '' ?>
                        </label>

                        <label class="custom-label line__label  check-box__input" type="checkbox" name="rules">Agreement with the rules of the site
                            <input type='checkbox' name='rules' <?= (isset($_SESSION['errorsForm']['rules']) || !isset($_SESSION['errorsForm'])) ? "" : "checked" ?> class='form__input custom-input <?= (isset($_SESSION['errorsForm']['rules'])) ? " error__input" : "" ?> '>
                            <?= (isset($_SESSION['errorsForm']['rules'])) ? "<span class='auth-error'>{$_SESSION['errorsForm']['rules']}</span>" : '' ?>
                        </label>

                        <button class="form__btn btn" type="submit">
                            submit</button>
                    </form>
                    <a class="link"> Login</a>
                </div>
            </section>
        </div>
    </div>

</body>

</html>

<?php
unset($_SESSION['errorsForm']);
unset($_SESSION['formData']);
