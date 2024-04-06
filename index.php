<?php

require_once './src/controller/UserController.php';
require_once './data/exceptions/DataBaseException.php';  //exception
require_once './src/model/User.php';
require_once './src/model/UserTable.php';
require_once './connection.php';
require_once './data/exceptions/DataBaseException.php';

try {
    $controller = new UserController();
    $controller->index();
}
catch (DataBaseException $exception) {
    echo "ERROR: " . $exception->getMessage();
}
catch (Exception $e) {
    echo "ERROR: " . $e->getMessage();
}