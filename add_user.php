<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\Controller\UserController;
use App\Exceptions\DataBaseException;


try {
    $controller = new UserController();
    $controller->addNewUser($_POST, $_FILES['avatar_path']);
}

catch (DataBaseException|\TypeError|\RuntimeException|\Exception $exception) {
    echo "ERROR: " . $exception->getMessage();
}
