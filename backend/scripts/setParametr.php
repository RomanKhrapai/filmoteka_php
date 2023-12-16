<?php

require __DIR__ . '../../vendor/autoload.php';

use Palmo\Core\service\Db;
use Palmo\Core\service\Validation;
use Palmo\Core\service\FilmsService;
use Palmo\Core\service\UserService;

$db = new Db();
$dbh = $db->getHandler();
$filmsService = new FilmsService($dbh);
$userService = new UserService($dbh);

$id = $params['id'];
$option = $params['option'];
$user_id = $_SESSION['user']['id'] ?? null;

switch ($option) {
    case 'PANDING':

        $isPending =  !empty($userService->getPending($id, $user_id));
        $isPending ? $userService->removePending($id, $user_id) : $userService->addPending($id, $user_id);

        break;
    case 'FAVIRITE':
        $isFavirite = !empty($userService->getFavirite($id, $user_id));
        $isFavirite ? $userService->removeFavirite($id, $user_id) : $userService->addFavirite($id, $user_id);
        break;
    default:
        break;
}
header("Location: /films/$id");
exit();
