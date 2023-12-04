<?php
$dsn = 'mysql:host=db;dbname=php_course';
$username = 'root';
$password = '1234';
try {
    $pdo = new PDO($dsn,    $username,    $password);
} catch (PDOException $e) {
    echo 'помилка підключення: ' . $e->getMessage();
}

$genres = $pdo->query("SELECT * FROM `genres`")->fetchAll(PDO::FETCH_ASSOC);

$arr = [];
foreach ($genres as $item) {
    $arr[$item['name']] = $item['id'];
};

$arr1 = [
    '28' => "Action",
    '12' => "Adventure",
    '16' => "Animation",
    '35' => "Comedy",
    '80' => "Crime",
    '99' => "Documentary",
    '18' => "Drama",
    '10751' => "Family",
    '14' => "Fantasy",
    '36' => "History",
    '27' => "Horror",
    '10402' => "Music",
    '9648' => "Mystery",
    '10749' => "Romance",
    '878' => "Science Fiction",
    '10770' => "TV Movie",
    '53' => "Thriller",
    '10752' => "War",
    '37' => "Western"
];

function fakeFilms($page)
{
    $url = 'https://api.themoviedb.org/3/movie/popular?language=en-US&page=' . $page;

    $options = [
        'http' => [
            'header' => "Authorization: Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI5NjdjNmYxNGRhY2IwY2ExMGYxMTc1Zjc4NTFhNTg2OSIsInN1YiI6IjYxZGZmZjFmMGI1ZmQ2MDA4ZGU0NTExYyIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.to0M1Np8gt9R68wSMglemCH_SCtPNCPFtQHirAE-g2o",
            'method' => 'GET',
        ],
    ];

    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    if ($response === FALSE) {
        die('Виникла помилка під час отримання даних');
    }


    $response = json_decode($response, true);
    $page = $response['page'];


    foreach ($response['results'] as $item) {
        $imgPath = $item["poster_path"] ?? '/default.jpg';
        $imageUrl = "https://image.tmdb.org/t/p/w342" . $imgPath;
        $imageData = file_get_contents($imageUrl);

        if ($imageData === FALSE || $imgPath === '/default.jpg') {
            break;
        }
        $saveFolderPath = 'storege/img/';
        if (!file_exists($saveFolderPath)) {
            mkdir($saveFolderPath, 0777, true);
        }
        $localImagePath = $saveFolderPath . str_replace("/", "", $imgPath);
        file_put_contents($localImagePath,  $imageData);

        echo '<br>111111"' . $item['id'] . '"<br>';
        global $pdo;
        $id = $item['id'];
        $title = $item['title'];
        $backdrop_path = $localImagePath;
        $overview = $item['overview'];
        $release_date = $item['release_date'];
        $genres = ($item['genre_ids']);

        $arrGenres = [];
        foreach ($genres as $value) {
            global $arr;
            global $arr1;

            $arrGenres[] = "('$id ','" . $arr[$arr1[$value]] . "')";
        }

        $users = $pdo->query("START TRANSACTION;

        INSERT INTO `films`
        (`id`, `title`,  `backdrop_path`, `overview`, `release_date`)   
         VALUES 
         ('$id','$title','$backdrop_path','$overview','$release_date');

         INSERT INTO `film_genre`(`film_id`, `genre_id`) VALUES
         " . implode(",", $arrGenres) . ";

        COMMIT;
        
        ROLLBACK;
        ")->fetchAll(PDO::FETCH_ASSOC);
    }



    $results = $response['results'];

    return $results;
}
for ($i = 53; $i < 100; $i++) {
    echo '<br>111111"' . $i . '"<br>';
    // fakeFilms($i);
}
