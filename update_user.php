<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\controller\UserController;
use App\exceptions\DataBaseException;


try {
    $controller = new UserController();
    $controller->updateUser($_GET, $_POST, $_FILES['avatar_path']);
}
catch (DataBaseException|\TypeError|\RuntimeException|\Exception $exception) {
    echo "ERROR: " . $exception->getMessage();
}
