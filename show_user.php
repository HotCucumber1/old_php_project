<?php
require_once './src/controller/UserController.php';
require_once './data/exceptions/DataBaseException.php';  //exception
require_once './src/model/User.php';
require_once './src/model/UserTable.php';
require_once './connection.php';
require_once './data/exceptions/DataBaseException.php';


/*try {
    $connectionParams = getConnectionParams();
    $connection = connectDatabase($connectionParams);
    $table = new UserTable($connection);
    $user = $table->findUser($_GET['user_id']);

    echo htmlentities($user->getUserId()) . "<br>";
    echo htmlentities($user->getFirstName()) . "<br>";
    echo htmlentities($user->getLastName()) . "<br>";
    echo htmlentities($user->getMiddleName()) . "<br>";
    echo htmlentities($user->getGender()) . "<br>";
    echo htmlentities($user->getBirthDate()) . "<br>";
    echo htmlentities($user->getEmail()) . "<br>";
    echo htmlentities($user->getPhone()) . "<br>";
    echo htmlentities($user->getAvatarPath()) . "<br>";
}
catch (DataBaseException $exception) {
    echo "ERROR: " . $exception->getMessage();
}*/



try {
    $controller = new UserController();
    $controller->showUser($_GET);

}
catch (DataBaseException $exception) {
    echo "ERROR: " . $exception->getMessage();
}
