<?php
require_once 'vendor/autoload.php';
require 'system/Routing.php';
$url = $_SERVER['REQUEST_URI'];

$r = new Router();
$r->addRoute('/', 'main.php');
$r->addRoute('/film/$id', 'oneFilm.php');
$r->addRoute('/films', 'main.php');
$r->addRoute('/films/serials', 'main.php');
$r->addRoute('/library', 'main.php');
$r->addRoute('/library/favorite', 'main.php');
$r->addRoute('/auth/registration', 'main.php');
$r->addRoute('/auth/login', 'main.php');

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
