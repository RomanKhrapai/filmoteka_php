<?php

namespace Palmo\Core\service;

use PDO;
use Palmo\Core\service\Films;

class FilmsService extends Films
{
    private $dbh;

    public function __construct(PDO $dbh)
    {

        $this->dbh = $dbh;
    }

    public function getTotalFilmsCount($search, $genresFiltre)
    {
        $stmt = $this->dbh->prepare("SELECT COUNT(*) AS total_records
            FROM (
                SELECT films.id
                FROM films
                JOIN film_genre ON films.id = film_genre.film_id
                JOIN genres ON film_genre.genre_id = genres.id
                LEFT JOIN vote ON vote.film_id = films.id
                WHERE films.title LIKE CONCAT('%', :search, '%') $genresFiltre
                GROUP BY films.id
            ) AS subquery;");
        $stmt->bindParam(':search', $search);
        $stmt->execute();
        return $stmt->fetch()['total_records'];
    }

    public function getFilms($search, $genresFiltre, $switchSort, $maxFillPage, $startItem)
    {
        $stmt = $this->dbh->prepare("SELECT
            films.id,
            films.title AS title,
            films.release_date AS release_date,
            films.backdrop_path,
            CONCAT_WS(', ', GROUP_CONCAT(DISTINCT genres.name)) AS genres,
            AVG(vote.mark) AS vote,
            COUNT(DISTINCT vote.id) AS votes,
            COUNT(DISTINCT popularity.id) AS popularity
            FROM films
            JOIN film_genre ON films.id = film_genre.film_id
            JOIN genres ON film_genre.genre_id = genres.id
            LEFT JOIN vote ON vote.film_id = films.id
            LEFT JOIN popularity ON popularity.film_id = films.id
            WHERE films.title LIKE CONCAT('%', :search, '%') $genresFiltre
            GROUP BY films.id
            ORDER BY $switchSort
            LIMIT :maxFillPage OFFSET :startItem;");
        $stmt->bindParam(':search', $search);
        $stmt->bindParam(':maxFillPage', $maxFillPage);
        $stmt->bindParam(':startItem', $startItem);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getLastId()
    {
        $stmt = $this->dbh->prepare("SELECT MAX(`id`) AS id FROM `films`;");

        $stmt->execute();
        return $stmt->fetch()['id'];
    }

    public function getFilm($id)
    {
        try {
            $stmt = $this->dbh->prepare("SELECT 
        films.id AS film_id,
        films.title,
        films.release_date,
        films.backdrop_path,
        overview,
        CONCAT_WS(', ', GROUP_CONCAT(DISTINCT genres.name)) AS genres,
        AVG(vote.mark) AS vote,
        COUNT(DISTINCT vote.id)  AS votes,
         COUNT(DISTINCT popularity.id) AS popularity
        FROM 
        films
        JOIN 
        film_genre ON films.id = film_genre.film_id
         JOIN
        genres ON film_genre.genre_id = genres.id
        LEFT JOIN
        vote ON vote.film_id = films.id
        LEFT JOIN
        popularity ON popularity.film_id = films.id
        WHERE 
        films.id = :id
        GROUP BY 
        films.id, films.title, films.release_date, films.backdrop_path, overview;
        ");
            $stmt->bindParam(':id', $id);

            $stmt->execute();
            return $stmt->fetch();
        } catch (\PDOException $e) {
            // echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function getComents($id)
    {
        try {
            $stmt = $this->dbh->prepare("SELECT 
        comments.id, comments.user_id, comments.text, create_date, users.url_img, users.username FROM
        comments
        JOIN 
        users ON comments.user_id = users.id
         WHERE film_id=:id  
        ORDER BY `comments`.`create_date` DESC
          ;");
            $stmt->bindParam(':id', $id);

            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            // echo "Error: " . $e->getMessage();
            return false;
        }
    }




    public function setPopularity($id, $user_id)
    {
        try {
            $stmt = $this->dbh->prepare((!$user_id) ?
                "INSERT INTO `popularity`( `film_id`) VALUES  (:id);"
                :
                "INSERT INTO `popularity`( `film_id`, `user_id`) VALUES (:id,:user_id);
       ");

            $stmt->bindParam(':id', $id);

            if ($user_id) {
                $stmt->bindParam(':user_id', $user_id);
            }

            $stmt->execute();
            $stmt->fetch();
            return true;
        } catch (\PDOException $e) {
            // echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function addFilm($id, $title, $date, $genres, $img_url, $about)
    {
        $arrGenres = [];
        foreach ($genres as $value) {
            $arrGenres[] = "('$id ','$value')";
        }

        try {
            $stmt = $this->dbh->prepare("
            INSERT INTO `films` (`id`, `title`, `backdrop_path`, `overview`, `release_date`)
         VALUES (:id, :title, :img_url, :about, :release_date);
        ");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':release_date', $date);
            $stmt->bindParam(':img_url', $img_url);
            $stmt->bindParam(':about',  $about);
            $stmt->execute();
            $stmt->fetch();

            $stmt = $this->dbh->prepare("
        INSERT INTO `film_genre`(`film_id`, `genre_id`) VALUES
        " . implode(",", $arrGenres) . ";
        ");
            $stmt->execute();
            $stmt->fetch();

            return true;
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
