<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\Controller\UserController;
use App\Exceptions\DataBaseException;


try {
    $controller = new UserController();
    $controller->index();
}
catch (DataBaseException|Exception $e){
    echo "ERROR: " . $e->getMessage();
}
