<?php

require __DIR__ . '../../vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: /404");
    exit();
}

use Palmo\Core\service\Db;
use Palmo\Core\service\UserService;

$db = new Db();
$dbh = $db->getHandler();
$userService = new UserService($dbh);

$vote = $_POST['rating'] ?? 0;
$id = $params['id'];
$user_id = $_SESSION['user']['id'] ?? null;

if (filter_var($vote, FILTER_VALIDATE_INT) && $vote < 0 && $vote > 10) {
    $vote = 0;
}
$userService->setVote($id, $user_id, $vote);

header("Location: /films/$id");
exit();
