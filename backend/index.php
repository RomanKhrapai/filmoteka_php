<?php
require_once 'vendor/autoload.php';
require 'system/Routing.php';
$url = $_SERVER['REQUEST_URI'];

$r = new Router();
$r->addRoute('/', 'main.php');
$r->addRoute('/film/$id', 'oneFilm.php');
$r->addRoute('/films', 'films.php');
$r->addRoute('/library', 'library.php');
$r->addRoute('/library/favorite', 'favorite.php');
$r->addRoute('/auth/singup', 'signUp.php');
$r->addRoute('/auth/login', 'logIn.php');

$r->route($url);

// // use the factory to create a Faker\Generator instance
// $faker = Faker\Factory::create();
// // generate data by calling methods
// echo '<br>';
// echo $faker->name();
// // 'Vince Sporer'
// echo '<br>';
// echo $faker->email();
// // 'walter.sophia@hotmail.com'
// echo '<br>';
// $password = $faker->password();
// echo $password;

// $hash =  password_hash($password, PASSWORD_DEFAULT);
// echo '<br>';
// dd($hash);
// echo 'password = ' . $hash;
// echo '<br>';
// echo 'password check = ' . password_verify($password, $hash);
