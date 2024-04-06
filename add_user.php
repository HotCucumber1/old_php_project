<?php
/*use controller\UserController;
require_once './src/controller/UserController.php';
require './data/exceptions/DataBaseException.php';*/
require_once __DIR__ . '/src/model/User.php';
require_once __DIR__ . '/src/model/UserTable.php';
require_once 'connection.php';
require_once __DIR__ . '/data/exceptions/DataBaseException.php';



try {
    $user = new User(
        null,
        $_POST['name'],
        $_POST['last_name'],
        $_POST['middle_name'],
        $_POST['gender'],
        $_POST['birth_date'],
        $_POST['email'],
        $_POST['phone'],
        $_POST['avatar_path']
    );

    $connectionParams = getConnectionParams();
    $connection = connectDatabase($connectionParams);

    $table = new UserTable($connection);
    $last = $table->addUser($user);

    if ($last) {
        $redirectUrl = "/show_user.php?user_id={$last}";
        header('Location: ' . $redirectUrl, true, 303);
        die();
    }
}
catch (DataBaseException $exception) {
    echo "ERROR: " . $exception->getMessage();
}


/*try {
    $controller = new UserController();
    $controller->addNewUser($_POST);

}
catch (DataBaseException $exception) {
     echo "ERROR: " . $exception->getMessage();
}*/
