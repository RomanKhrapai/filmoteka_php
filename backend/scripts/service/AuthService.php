<?php

namespace Palmo\Core\service;

use PDO;

class AuthService
{
    private $dbh;

    public function __construct(PDO $dbh)
    {

        $this->dbh = $dbh;
    }

    public function getPaswordById($id)
    {
        try {
            $stmt = $this->dbh->prepare("SELECT password FROM users WHERE `id` = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return  $stmt->fetch()['password'];
        } catch (\PDOException $e) {
            // echo "Error: " . $e->getMessage();
            return false;
        }
    }
    public function getUserByMail($mail)
    {
        try {
            $stmt = $this->dbh->prepare("SELECT * FROM users WHERE email = :mail");
            $stmt->bindParam(':mail', $mail);
            $stmt->execute();
            return  $stmt->fetch();
        } catch (\PDOException $e) {
            // echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function setToken($user_id, $token, $validUntil)
    {
        try {
            $stmt = $this->dbh->prepare("INSERT INTO `tokens`( `token`, `user_id`, `validUntil`)  VALUES (:token,:userId,FROM_UNIXTIME(:validUntil))");
            $stmt->bindParam(':token', $token);
            $stmt->bindParam(':userId', $user_id);
            $stmt->bindParam(':validUntil', $validUntil);
            $stmt->execute();
            return $stmt->fetch();
        } catch (\PDOException $e) {
            // echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
