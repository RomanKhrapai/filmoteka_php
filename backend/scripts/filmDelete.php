<?php

require __DIR__ . '../../vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: /404");
    exit();
}

use Palmo\Core\service\Db;
use Palmo\Core\service\Validation;
use Palmo\Core\service\FilmsService;
use Palmo\Core\service\AuthService;

$db = new Db();
$dbh = $db->getHandler();
$filmsService = new FilmsService($dbh);
$authService = new AuthService($dbh);

$id = $params['id'];
$password = $_POST['password'];

$_SESSION['errorsForm'] = [];

$errors['password'] =  Validation::validate('password', $_POST['password']);

foreach ($errors as $key => $error) {
    if ($error) {
        $_SESSION['errorsForm'][$key] = $error;
    }
}

if (!empty($_SESSION['errorsForm'])) {
    header("Location: /films/$id/delete");
    exit();
} else {
    unset($_SESSION['errorsForm']);
    unset($_SESSION['formData']);
}

$hashPassword = $authService->getPaswordById($_SESSION['user']['id']);

if (password_verify($password, $hashPassword)) {

    $filmsService->deleteFilm($id);
    header("Location: /");
    exit();
} else {

    $_SESSION['errorsForm']['password'] = "Invalid password";
    header("Location: /films/$id/delete");
    exit();
}
