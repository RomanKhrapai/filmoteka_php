<?php

namespace Palmo\Core\service;

use PDO;

class GenresService
{
    private $dbh;

    public function __construct(PDO $dbh)
    {

        $this->dbh = $dbh;
    }

    public function getGenres()
    {
        $stmt = $this->dbh->prepare("SELECT id, name FROM genres");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
