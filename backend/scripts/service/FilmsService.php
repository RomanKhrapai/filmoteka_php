<?php

namespace Palmo\Core\service;

use PDO;

class FilmsService
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
                JOIN vote ON vote.film_id = films.id
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
            JOIN vote ON vote.film_id = films.id
            JOIN popularity ON popularity.film_id = films.id
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
}
