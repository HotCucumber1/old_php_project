<?php
require_once 'User.php';
include 'connection.php';
include 'DataBaseException.php';

/**
 *  Добавляет пользователя в таблицу 'user' с помощью INSERT.
 *    Возвращает целочисленный ID добавленного пользователя.
 * @return int
 */
function saveUserToDatabase(PDO $pdo, User $user /*array $userParams*/): int
{
    try {
        $query = 'INSERT INTO 
                `user` (
                        `first_name`, 
                        `last_name`, 
                        `middle_name`, 
                        `gender`, 
                        `birth_date`, 
                        `email`, 
                        `phone`, 
                        `avatar_path`)
              VALUES (
                      :first_name, 
                      :last_name, 
                      :middle_name, 
                      :gender, 
                      :birth_date, 
                      :email, 
                      :phone, 
                      :avatar_path);';
        $request = $pdo -> prepare($query);

        /*$request -> execute([
            ':first_name' => $userParams['first_name'],
            ':last_name' => $userParams['last_name'],
            ':middle_name' => $userParams['middle_name'],
            ':gender' => $userParams['gender'],
            ':birth_date' => $userParams['birth_date'],
            ':email' => $userParams['email'],
            ':phone' => $userParams['phone'],
            ':avatar_path' => $userParams['avatar_path'],
        ]);*/

        $request -> execute([
            ':first_name' => $user->getFirstName(),
            ':last_name' => $user->getLastName(),
            ':middle_name' => $user->getMiddleName(),
            ':gender' => $user->getGender(),
            ':birth_date' => $user->getBirthDate(),
            ':email' => $user->getEmail(),
            ':phone' => $user->getPhone(),
            ':avatar_path' => $user->getAvatarPath(),
        ]);
        return (int)$pdo -> lastInsertId();
    }
    catch (Exception $exception) {
        throw new DataBaseException("{$exception}");
    }
}


/*$elonUser = [
    'first_name' => $_POST['name'],
    'last_name' => $_POST['last_name'],
    'middle_name' => $_POST['middle_name'],
    'gender' => $_POST['gender'],
    'birth_date' => $_POST['birth_date'],
    'email' => $_POST['email'],
    'phone' => $_POST['phone'],
    'avatar_path' => $_POST['avatar_path']
];*/


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
    $last = saveUserToDatabase($connection, $user);

    if ($last) {
        $redirectUrl = "/show_user.php?user_id={$last}";
        header('Location: ' . $redirectUrl, true, 303);
        die();
    }
}
catch (DataBaseException $exception) {
     echo "ERROR: " . $exception->getMessage();
}
