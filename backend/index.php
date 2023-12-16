<?php

require_once 'vendor/autoload.php';

session_start();

use Palmo\Core\service\Db;

if (isset($_COOKIE['SES'])) {
    $dbh = (new Db())->getHandler();
    $token = $_COOKIE['SES'];

    $sql = "SELECT users.id, users.username,users.url_img FROM `tokens` 
    INNER JOIN  users ON users.id = tokens.user_id
    WHERE token = :token AND validUntil >= NOW() ;";
    $query = $dbh->prepare($sql);
    $query->bindParam(':token', $token);
    $query->execute();
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if (!empty($user)) {
        $_SESSION['user'] = $user;
        $_SESSION['token'] = $token;
    } else {
        $sql = "DELETE FROM tokens WHERE validUntil < NOW();";
        $query = $dbh->prepare($sql);
        $query->execute();
        $user = $query->fetch(PDO::FETCH_ASSOC);

        unset($_SESSION['user']);
        unset($_SESSION['token']);
        setcookie('SES', $token, time(), '/');
    }
}

require 'system/Routing.php';
$url = $_SERVER['REQUEST_URI'];

$r = new Router();
if (isset($_SESSION['user'])) {
    $r->addRoute('/library', 'pages/library.php');
    $r->addRoute('/auth/logout', 'scripts/logout.php');
    $r->addRoute('/user', 'pages/user.php');
    $r->addRoute('/addfilm', 'scripts/addfilm.php');
    $r->addRoute('/addfilm/$id', 'scripts/addfilm.php');
    $r->addRoute('/films/$id/$delete', 'pages/oneFilm.php');
    $r->addRoute('/uploadimg', 'scripts/uploadimg.php');
    $r->addRoute('/set/$id/$option', 'scripts/setParametr.php');
    $r->addRoute('/setvote/$id', 'scripts/setVote.php');
    $r->addRoute('/delete/$id', 'scripts/filmDelete.php');
} else {
    $r->addRoute('/auth/signup', 'pages/signUp.php');
    $r->addRoute('/auth/login', 'pages/logIn.php');
    $r->addRoute('/scripts/login', 'scripts/login.php');
    $r->addRoute('/scripts/signup', 'scripts/signup.php');
}
$r->addRoute('/', 'pages/main.php');
$r->addRoute('/films/$id', 'pages/oneFilm.php');
$r->addRoute('/films', 'pages/films.php');

$r->route($url);
