<?php
use App\controller\UserController;
use App\exception\DataBaseException;


try {
    $controller = new UserController();
    $controller->addNewUser($_POST);
}
catch (DataBaseException $exception) {
     echo "ERROR: " . $exception->getMessage();
}
