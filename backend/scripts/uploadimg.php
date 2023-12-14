<?php

require __DIR__ . '../../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /404");
    exit();
}

$saveFolderPath = 'storege/img/temp/';
if (!file_exists($saveFolderPath)) {
    mkdir($saveFolderPath, 0777, true);
}

$targetFile = $saveFolderPath . $_SESSION['user']['id'] . '.jpg';

use Palmo\Core\service\Validation;


if (isset($_POST['size'])) {
    $_SESSION['errorImg'] = 'file too large, use a file smaller than 2Mb';

    if (file_exists($targetFile)) {
        unlink($targetFile);
    }
    include 'components/uploadImage.php';
    exit();
}

$file = $_FILES['file'] ?? null;
$error =  Validation::validate('image', $file);

if (!$error && move_uploaded_file($file['tmp_name'], $targetFile)) {
    unset($_SESSION['errorImg']);
} else {
    $_SESSION['errorImg'] = $error;
    if (file_exists($targetFile)) {
        unlink($targetFile);
    }
}

include 'components/uploadImage.php';
