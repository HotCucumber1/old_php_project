<?php
use App\Controller\UserController;
use App\exception\DataBaseException;


try {
    $controller = new UserController();
    $controller->showUser($_GET);
}
catch (DataBaseException $exception) {
    echo "ERROR: " . $exception->getMessage();
}
