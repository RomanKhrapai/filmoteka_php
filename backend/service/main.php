<?php
$dsn = 'mysql:host=db;dbname=php_course';
$username = 'root';
$password = '1234';

// require_once 'vendor/autoload.php';
// $faker = Faker\Factory::create();
// echo $faker->name();
// echo $faker->email();
// echo $faker->text();

try {
    $pdo = new PDO($dsn,    $username,    $password);
} catch (PDOException $e) {
    echo 'помилка підключення: ' . $e->getMessage();
}

$users = $pdo->query('SELECT * FROM users')->fetchAll(PDO::FETCH_ASSOC);

print_r($users);
