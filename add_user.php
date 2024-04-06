<?php
require_once './src/controller/UserController.php';

/*try {
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
}*/

try {
    $controller = new UserController();
    $controller->addNewUser($_POST);
}
catch (DataBaseException $exception) {
     echo "ERROR: " . $exception->getMessage();
}
