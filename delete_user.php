<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\controller\UserController;
use App\exceptions\DataBaseException;


try {
    $controller = new UserController();
    $controller->deleteUser($_GET);
}
catch (DataBaseException|\TypeError|\RuntimeException|\Exception $exception) {
    echo "ERROR: " . $exception->getMessage();
}
