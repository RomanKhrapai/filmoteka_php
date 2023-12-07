<?php

require __DIR__ . '/../vendor/autoload.php';

$faker = Faker\Factory::create();

$dsn = 'mysql:host=db;dbname=php_course';
$username = 'root';
$password = '1234';

try {
    $pdo = new PDO($dsn,    $username,    $password);
} catch (PDOException $e) {
    echo 'помилка підключення: ' . $e->getMessage();
}

$films = $pdo->query("SELECT id FROM `films`")->fetchAll(PDO::FETCH_ASSOC);

$arrFilmsId = array_map(fn ($item) => $item['id'], $films);

function filmId()
{
    global $films;
    return $films[rand(0, count($films) - 1)]['id'];
}


$COUNT_ITERATE = 50;
for ($k = 0; $k < 20; $k++) {


    $users = $pdo->query("SELECT id FROM `users` ORDER BY RAND() LIMIT $COUNT_ITERATE;")->fetchAll(PDO::FETCH_ASSOC);
    // dd($users[1]['id'], $users);

    for ($i = 0; $i < $COUNT_ITERATE; $i++) {
        $film_Id = filmId();
        $user_id = $users[$i]['id'];
        //$date = $faker->dateTimeBetween('2020-01-01', 'now')->format('Y_m_d');
        $date = $faker->dateTimeBetween('2020-01-01', 'now');
        $dateString = $date->format('Y-m-d H:i:s');
        //dd($date . '');
        $pdo->query("INSERT INTO `popularity`( `film_id`, `user_id`, `date_create`) VALUES  ('$film_Id',' $user_id','$dateString')")->fetchAll(PDO::FETCH_ASSOC);


        // INSERT INTO `popularity`(`id`, `film_id`, `user_id`, `date_create`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]')
    }
}
