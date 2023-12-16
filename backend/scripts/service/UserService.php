<?php

namespace Palmo\Core\service;

use PDO;

class UserService
{
    private $dbh;

    public function __construct(PDO $dbh)
    {

        $this->dbh = $dbh;
    }


    public function getPending($film_id, $user_id)
    {
        try {
            $stmt = $this->dbh->prepare("
            SELECT id FROM `pending`  WHERE `pending`.`film_id` = :film_id AND `pending`.`user_id` = :user_id;
            ");
            $stmt->bindParam(':film_id', $film_id);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            return $stmt->fetch();
        } catch (\PDOException $e) {
            // echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function getPendings($user_id)
    {
        try {
            $stmt = $this->dbh->prepare("
            SELECT * FROM `pending`  WHERE `pending`.`user_id` = :user_id;
            ");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            return $stmt->fetch();
        } catch (\PDOException $e) {
            // echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function removePending($film_id, $user_id)
    {
        try {
            $stmt = $this->dbh->prepare("
            DELETE FROM 
                pending 
            WHERE `pending`.`film_id` = :film_id AND `pending`.`user_id` = :user_id;
            ");
            $stmt->bindParam(':film_id', $film_id);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            return $stmt->fetch();
        } catch (\PDOException $e) {
            // echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function addPending($film_id, $user_id)
    {
        try {
            $stmt = $this->dbh->prepare("
            INSERT INTO `pending`(`user_id`, `film_id`) VALUES (:user_id , :film_id)
            ");
            $stmt->bindParam(':film_id', $film_id);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            return $stmt->fetch();
        } catch (\PDOException $e) {
            // echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function getFavirite($film_id, $user_id)
    {
        try {
            $stmt = $this->dbh->prepare("
            SELECT id FROM `favirite`  WHERE `favirite`.`film_id` = :film_id AND `favirite`.`user_id` = :user_id;
            ");
            $stmt->bindParam(':film_id', $film_id);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            return $stmt->fetch();
        } catch (\PDOException $e) {
            // echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function getFavirites($user_id)
    {
        try {
            $stmt = $this->dbh->prepare("
            SELECT * FROM `favirite`  WHERE `favirite`.`user_id` = :user_id;
            ");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            return $stmt->fetch();
        } catch (\PDOException $e) {
            // echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function removeFavirite($film_id, $user_id)
    {
        try {
            $stmt = $this->dbh->prepare("
            DELETE FROM 
                favirite 
            WHERE `favirite`.`film_id` = :film_id AND `favirite`.`user_id` = :user_id;
            ");
            $stmt->bindParam(':film_id', $film_id);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            return $stmt->fetch();
        } catch (\PDOException $e) {
            // echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function addFavirite($film_id, $user_id)
    {
        try {
            $stmt = $this->dbh->prepare("
            INSERT INTO `favirite`(`user_id`, `film_id`) VALUES (:user_id , :film_id)
            ");
            $stmt->bindParam(':film_id', $film_id);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            return $stmt->fetch();
        } catch (\PDOException $e) {
            // echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function setVote($film_id, $user_id, $mark)
    {
        try {
            $checkStmt = $this->dbh->prepare("SELECT 1 FROM vote WHERE user_id = :user_id AND film_id = :film_id");
            $checkStmt->bindParam(':user_id', $user_id);
            $checkStmt->bindParam(':film_id', $film_id);
            $checkStmt->execute();

            if ($checkStmt->fetchColumn()) {
                $updateStmt = $this->dbh->prepare("UPDATE vote SET mark = :mark WHERE user_id = :user_id AND film_id = :film_id");
                $updateStmt->bindParam(':user_id', $user_id);
                $updateStmt->bindParam(':film_id', $film_id);
                $updateStmt->bindParam(':mark', $mark);
                $updateStmt->execute();
                return $updateStmt->fetch();
            } else {
                $insertStmt = $this->dbh->prepare("INSERT INTO vote (user_id, film_id, mark) VALUES (:user_id, :film_id, :mark)");
                $insertStmt->bindParam(':user_id', $user_id);
                $insertStmt->bindParam(':film_id', $film_id);
                $insertStmt->bindParam(':mark', $mark);
                $insertStmt->execute();
                return $insertStmt->fetch();
            }
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function getMyVote($film_id, $user_id)
    {
        try {
            $stmt = $this->dbh->prepare("
            SELECT mark FROM `vote`  WHERE `vote`.`film_id` = :film_id AND `vote`.`user_id` = :user_id;
            ");
            $stmt->bindParam(':film_id', $film_id);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            return $stmt->fetch();
        } catch (\PDOException $e) {
            // echo "Error: " . $e->getMessage();
            return false;
        }
    }


    private function grupParameter($grup, $user_id)
    {
        return  match ($grup) {
            'favirite' => "JOIN favirite ON favirite.film_id = films.id 
            WHERE $user_id = 	favirite.user_id",
            'pending' => "JOIN pending ON pending.film_id = films.id 
            WHERE $user_id = 	pending.user_id",
            default => "LEFT JOIN pending ON pending.film_id = films.id
             LEFT JOIN favirite ON favirite.film_id = films.id
             WHERE $user_id = favirite.user_id OR $user_id = pending.user_id
             ",
        };
    }
    public function getTotalFilmsCount($user_id, $grup)
    {

        try {
            $stmt = $this->dbh->prepare("SELECT COUNT(*) AS total_records
            FROM (
                SELECT films.id
                FROM films
                JOIN film_genre ON films.id = film_genre.film_id
                JOIN genres ON film_genre.genre_id = genres.id
                {$this->grupParameter($grup,$user_id)}
                GROUP BY films.id
            ) AS subquery;");
            $stmt->execute();
            return $stmt->fetch()['total_records'];
        } catch (\PDOException $e) {
            // echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function getLibraryFilms($user_id, $grup, $maxFillPage, $startItem)
    {
        try {
            $stmt = $this->dbh->prepare("SELECT
            films.id,
            films.title,
            films.release_date,
            films.backdrop_path,
            CONCAT_WS(', ', GROUP_CONCAT(DISTINCT genres.name)) AS genres
            FROM films
            JOIN film_genre ON films.id = film_genre.film_id
            JOIN genres ON film_genre.genre_id = genres.id
            {$this->grupParameter($grup,$user_id)}
            GROUP BY films.id
            ORDER BY films.release_date DESC
            LIMIT :maxFillPage OFFSET :startItem;");

            $stmt->bindParam(':maxFillPage', $maxFillPage);
            $stmt->bindParam(':startItem', $startItem);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            // echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
