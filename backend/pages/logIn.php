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
    <title>log in</title>
</head>

<body>
    <div class="page">
        <?php include 'components/header.php' ?>

        <div class="container">
            <section class="auth-section">
                <div class="auth-container registration">
                    <h1 class="main-title registration__title">Login</h1>
                    <form class=" form auth__form" method="POST" action="/scripts/login">
                        <label class="custom-label form__input" autocomplete="email" placeholder="email" name="email">
                            E-mail
                            <?php
                            echo (isset($_SESSION['errorsForm']['email'])) ?
                                "<input autocomplete='email' placeholder='E-mail' name='email' value = '{$_SESSION['formData']['email']}'
                                 class='form__input custom-input error__input'> 
                             <span class='auth-error'>{$_SESSION['errorsForm']['email']}</span>"
                                : " <input autocomplete='email' placeholder='E-mail' name='email' class='form__input custom-input'>";
                            ?>

                        </label>
                        <label class="custom-label form__input" type="password" autocomplete="current-password" placeholder="password" name="password">
                            Password
                            <?php
                            echo (isset($_SESSION['errorsForm']['password'])) ?
                                "<input type='password' autocomplete='current-password' placeholder='password' name='password'
                                 class='form__input custom-input error__input' >
                             <span class='auth-error'>{$_SESSION['errorsForm']['password']}</span>"
                                : "<input type='password' autocomplete='current-password' placeholder='password' name='password'
                                class='form__input custom-input' >";
                            // dd($_SESSION['errorsForm']);
                            ?>
                            <!-- <input type="password" autocomplete="current-password" placeholder="password" name="password" class="form__input custom-input"> -->
                        </label>
                        <button class="form__btn btn form__btn" type="submit">
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
<?php unset($_SESSION['errorsForm']);
unset($_SESSION['formData']);
