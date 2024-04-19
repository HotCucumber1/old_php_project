<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\Controller\UserController;
use App\Exceptions\DataBaseException;


try {
    $controller = new UserController();
    $controller->deleteUser($_GET);
}
catch (DataBaseException|\TypeError|\RuntimeException|\Exception $exception) {
    echo "ERROR: " . $exception->getMessage();
}
