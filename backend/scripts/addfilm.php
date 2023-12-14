<?php

require __DIR__ . '../../vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: /404");
    exit();
}

use Palmo\Core\service\Db;
use Palmo\Core\service\Validation;
use Palmo\Core\service\FilmsService;

$db = new Db();
$dbh = $db->getHandler();
$filmsService = new FilmsService($dbh);

$title = trim(strip_tags($_POST['title']));
$date = trim(strip_tags($_POST['date']));
$genres = $_POST['genres'] ?? [];
$about = trim(strip_tags($_POST['about']));

$_SESSION['errorsForm'] = [];

$errors['title'] =  Validation::validate('title', $title);
$errors['date'] =  Validation::validate('date', $date);
$errors['genres'] =  Validation::validate('genres', $genres);
$errors['about'] =  Validation::validate('about', $about);
$errors['img'] = $_SESSION['errorImg'] ?? null;

$targetFile = 'storege/img/temp/' . $_SESSION['user']['id'] . '.jpg';
if (!file_exists($targetFile)) {
    $_SESSION['errorImg'] = 'load image';
    $errors['img'] = true;
}

foreach ($errors as $key => $error) {
    if ($error) {
        $_SESSION['errorsForm'][$key] = $error;
    }
}

if (empty($_SESSION['errorsForm'])) {

    $newId = $filmsService->getLastId() + 1;
    $posterUrl = 'storege/img/' . $newId . '.jpg';
    if (rename($targetFile, $posterUrl)) {
        $result = $filmsService->addFilm($newId, $title, $date, $genres, $posterUrl, $about);
        if ($result) {

            unset($_SESSION['errorsForm']);
            unset($_SESSION['formData']);
            $_SESSION['success'] = true;
            header("Location: /user?addfilm");

            exit();
        }
    }
    rename($posterUrl, $targetFile);
}
$_SESSION['formData']['title'] = $title;
$_SESSION['formData']['date'] = $date;
$_SESSION['formData']['genres'] = $genres;
$_SESSION['formData']['about'] = $about;

header("Location: /user?addfilm");

exit();
