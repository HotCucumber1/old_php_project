<?php
require_once './src/controller/UserController.php';

try {
    $controller = new UserController();
    $controller->index();
}
catch (DataBaseException|Exception $e){
    echo "ERROR: " . $e->getMessage();
}
