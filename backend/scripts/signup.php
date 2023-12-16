<?php
require __DIR__ . '../../vendor/autoload.php';


use Palmo\Core\service\Db;
use Palmo\Core\service\Validation;

$db = new Db();
$dbh = $db->getHandler();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: /404");
    exit();
}

$email = strip_tags($_POST['email']);
$username = strip_tags($_POST['username']);
$password = $_POST['password'];
$confirmPassword = $_POST['confirm-password'];
$rules = isset($_POST['rules']);
$urlImg = '/storege/default_avatar.jpg';

$_SESSION['errorsForm'] = [];
$errors['email'] =  Validation::validate('email', $email);
$errors['username'] =  Validation::validate('username', $username);
$errors['password'] =  Validation::validate('password', $password);
$errors['rules'] =  Validation::validate('rules', $rules);
$errors['confirmPassword'] =  Validation::validate('confirmPassword', [$confirmPassword, $password]);

foreach ($errors as $key => $error) {
    if ($error) {
        $_SESSION['errorsForm'][$key] = $error;
    }
}

if (!empty($_SESSION['errorsForm'])) {
    $_SESSION['formData']['username'] = $username;
    $_SESSION['formData']['email'] = $email;
    $_SESSION['formData']['rules'] = $rules;
    header("Location: /auth/signup");
    exit();
} else {
    unset($_SESSION['errorsForm']);
    unset($_SESSION['formData']);
}

$stmt = $dbh->prepare("SELECT * FROM users WHERE email = :email");
$stmt->bindParam(':email', $email);
$stmt->execute();
$user = $stmt->fetch();


if (empty($user)) {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $dbh->prepare("INSERT INTO `users`( `username`, `password`, `email`, `url_img`, `no_hash`) VALUES 
         (:username,:hashPassword,:email,:urlImg,:passwordText)");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':passwordText', $password);
    $stmt->bindParam(':hashPassword', $hash);
    $stmt->bindParam(':urlImg', $urlImg);
    $stmt->execute();
    $result = $stmt->fetch();

    $stmt = $dbh->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch();

    if (!empty($user)) {

        $_SESSION['user'] = $user;
        $token = bin2hex(random_bytes(32));

        $validUntil = time() + (60 * 60  * 24);
        setcookie('SES', $token, $validUntil, '/');

        $stmt = $dbh->prepare("INSERT INTO `tokens`( `token`, `user_id`, `validUntil`)  VALUES (:token,:userId,FROM_UNIXTIME(:validUntil))");
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':userId', $user['id']);
        $stmt->bindParam(':validUntil', $validUntil);
        $stmt->execute();
        $stmt->fetch();

        header("Location: /");
        exit();
    }
} else {
    $_SESSION['errorsForm']['email'] = 'this mail is already in use';

    $_SESSION['formData']['username'] = $username;
    $_SESSION['formData']['email'] = $email;
    $_SESSION['formData']['rules'] = $rules;

    header("Location: /auth/signup");

    exit();
}
