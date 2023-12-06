<?php
require __DIR__ . '../../vendor/autoload.php';


use Palmo\Core\service\Db;

$db = new Db();
$dbh = $db->getHandler();
$stmt = $dbh->prepare("DELETE FROM `tokens` WHERE `token`= :token");
$stmt->bindParam(':token',  $_SESSION['token']);
$stmt->execute();
$stmt->fetch();

session_destroy();

header("Location: /");
exit();
