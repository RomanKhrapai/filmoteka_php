<?php

require __DIR__ . '../../vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: /404");
    exit();
}

use Palmo\Core\service\Db;
use Palmo\Core\service\Validation;
use Palmo\Core\service\AuthService;


$db = new Db();
$dbh = $db->getHandler();
$authService = new AuthService($dbh);

$db = new Db();
$dbh = $db->getHandler();



$email = $_POST['email'];
$password = $_POST['password'];

$_SESSION['errorsForm'] = [];

$errors['email'] =  Validation::validate('email', $_POST['email']);
$errors['password'] =  Validation::validate('password', $_POST['password']);

foreach ($errors as $key => $error) {
    if ($error) {
        $_SESSION['errorsForm'][$key] = $error;
    }
}

if (!empty($_SESSION['errorsForm'])) {
    $_SESSION['formData']['email'] = $email;
    header("Location: /auth/login");

    exit();
} else {
    unset($_SESSION['errorsForm']);
    unset($_SESSION['formData']);
}


$user  = $authService->getUserByMail($email);

if (!empty($user)) {
    if (password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        $token = bin2hex(random_bytes(32));

        $validUntil = time() + (60 * 60  * 24);
        setcookie('SES', $token, $validUntil, '/');

        $authService->setToken($user['id'], $token, $validUntil);

        header("Location: /");
        exit();
    } else {

        $_SESSION['errorsForm']['password'] = "Invalid password";
        header("Location: /auth/login");
        exit();
    }
} else {

    $_SESSION['errorsForm']['email'] = "this mail is not in use. Sign up.";
    $_SESSION['formData']['email'] = $email;
    header("Location: /auth/login");
    exit();
}
