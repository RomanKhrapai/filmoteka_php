<?php

require __DIR__ . '../../vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: /404");
    exit();
}

use Palmo\Core\service\Db;
use Palmo\Core\service\Validation;

$db = new Db();
$dbh = $db->getHandler();

$title = strip_tags($_POST['title']);
$date = strip_tags($_POST['date']);
$file = $_FILES['img'];
$genres = $_POST['genres'];
$about = strip_tags($_POST['about']);

$_SESSION['errorsForm'] = [];

$errors['title'] =  Validation::validate('title', $title);
$errors['date'] =  Validation::validate('date', $date);
$errors['img'] =  Validation::validate('image', $file);
$errors['genres'] =  Validation::validate('genres', $genres);
$errors['about'] =  Validation::validate('about', $about);



dd($errors, $file, $_POST);

foreach ($errors as $key => $error) {
    if ($error) {
        $_SESSION['errorsForm'][$key] = $error;
    }
}

if (!empty($_SESSION['errorsForm'])) {
    $_SESSION['formData']['title'] = $title;
    $_SESSION['formData']['date'] = $date;
    $_SESSION['formData']['genres'] = $genres;
    $_SESSION['formData']['img'] = $img;
    $_SESSION['formData']['about'] = $about;
    header("Location: /user?addfilm");

    exit();
} else {
    unset($_SESSION['errorsForm']);
    unset($_SESSION['formData']);
}

// $stmt = $dbh->prepare("SELECT * FROM users WHERE email = :email");
// $stmt->bindParam(':email', $email);
// $stmt->execute();
// $user = $stmt->fetch();


// if (!empty($user)) {
//     if (password_verify($password, $user['password'])) {
//         $_SESSION['user'] = $user;
//         $token = bin2hex(random_bytes(32));

//         $validUntil = time() + (60 * 60  * 24);
//         setcookie('SES', $token, $validUntil, '/');

//         $stmt = $dbh->prepare("INSERT INTO `tokens`( `token`, `user_id`, `validUntil`)  VALUES (:token,:userId,FROM_UNIXTIME(:validUntil))");
//         $stmt->bindParam(':token', $token);
//         $stmt->bindParam(':userId', $user['id']);
//         $stmt->bindParam(':validUntil', $validUntil);
//         $stmt->execute();
//         $result = $stmt->fetch();

//         header("Location: /");
//         exit();
//     } else {

//         $_SESSION['errorsForm']['password'] = "Invalid password";
//         header("Location: /auth/login");
//         exit();
//     }
// } else {

//     $_SESSION['errorsForm']['email'] = "this mail is not in use. Sign up.";
//     $_SESSION['formData']['email'] = $email;
//     header("Location: /auth/login");
//     exit();
// }
