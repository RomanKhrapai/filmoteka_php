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

$maxIdUser = $pdo->query("SELECT MAX(id) AS id FROM users")->fetchAll(PDO::FETCH_ASSOC)[0]['id'] ?? 0;

$saveFolderPath = '../storege/img/avatar/';
if (!file_exists($saveFolderPath)) {
    mkdir($saveFolderPath, 0777, true);
}

// for ($i = $maxIdUser + 1; $i < $maxIdUser + 26; $i++) {
for ($i = 0 + 1; $i < $maxIdUser; $i++) {
    $userName =  $faker->name();

    $arr = explode(" ", $userName);

    $nameAbbreviation =  $arr[0][0] . $arr[1][0];
    // $imgPath = $nameAbbreviation . "_$i.jpg";

    // $imgfileUrl = "https://via.placeholder.com/200x200.jpg/004464?text=$nameAbbreviation";
    // $imageData = file_get_contents($imgfileUrl);

    // if ($imageData === FALSE || $imgPath === '/default.jpg') {
    //     break;
    // }
    // $localImagePath = $saveFolderPath . str_replace("/", "", $imgPath);
    // file_put_contents($localImagePath,  $imageData);

    // $localImagePath = str_replace("../", "", $localImagePath);

    $userMail =  $faker->email();

    // $password = $faker->password(6, 10);
    // $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $faker->realText($faker->numberBetween(50, 200));

    // $sql = " INSERT INTO `users`(`id`, `username`, `password`, `email`, `url_img`,no_hash) 
    // VALUES (:i,:userName, :passwordHash,:userMail,:localImagePath,:password1);";

    // $query = $pdo->prepare($sql);
    // $query->bindParam(':i', $i);
    // $query->bindParam(':userName', $userName);
    // $query->bindParam(':passwordHash', $passwordHash);
    // $query->bindParam(':userMail', $userMail);
    // $query->bindParam(':localImagePath', $localImagePath);
    // $query->bindParam(':password1', $password);
    // $query->execute();
    // $user = $query->fetchAll(PDO::FETCH_ASSOC);

    // if ($user === false) {
    //     continue;
    // }

    for ($j = 0; $j < random_int(0, 50); $j++) {
        $mark = rand(0, 10);
        $film_Id = filmId();
        $pdo->query("INSERT INTO `vote`( `user_id`, `film_id`, `mark`) VALUES ('$i','$film_Id','$mark');")->fetchAll(PDO::FETCH_ASSOC);
    }

    for ($j = 0; $j < random_int(0, 10); $j++) {
        $film_Id = filmId();
        $pdo->query("INSERT INTO `pending`( `user_id`, `film_id`) VALUES ('$i','$film_Id'); ")->fetchAll(PDO::FETCH_ASSOC);
    }

    for ($j = 0; $j < random_int(-4, 10); $j++) {
        $film_Id = filmId();
        $pdo->query(" INSERT INTO `favirite`( `user_id`, `film_id`)  VALUES ('$i','$film_Id');")->fetchAll(PDO::FETCH_ASSOC);
    }
    for ($j = 0; $j < random_int(-4, 10); $j++) {
        $film_Id = filmId();
        $coment =  $faker->text();
        $date = $faker->dateTimeBetween('2020-01-01', 'now')->format('Y_m_d');
        $pdo->query("INSERT INTO `comments`( `user_id`, `film_id`, `text`, `create_date`) VALUES ('$i','$film_Id','$coment','$date')")->fetchAll(PDO::FETCH_ASSOC);
    }
}
//дублювання записів SELECT user_id,film_id, COUNT(*) FROM `vote` GROUP BY user_id,film_id HAVING COUNT(*)>1;