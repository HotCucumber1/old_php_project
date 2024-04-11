<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\controller\UserController;
use App\exception\DataBaseException;


try {
    $controller = new UserController();
    $controller->index();
}
catch (DataBaseException|Exception $e){
    echo "ERROR: " . $e->getMessage();
}
