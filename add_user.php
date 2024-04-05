<?php
use controller\UserController;
require_once './src/controller/UserController.php';
require './data/exceptions/DataBaseException.php';


try {
    $controller = new UserController();
    $controller->addNewUser($_POST);

}
catch (DataBaseException $exception) {
     echo "ERROR: " . $exception->getMessage();
}
