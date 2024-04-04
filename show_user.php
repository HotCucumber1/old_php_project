<?php
require_once 'User.php';
include 'DataBaseException.php';
include 'connection.php';


/** Извлекает пользователя с заданным ID из базы данных
 *  с помощью SELECT.
 *  Возвращает ассоциативный массив либо null, если
 * пользователь не найден
 * @return ?array
 */
function findUserInDatabase(PDO $pdo, int $userId): ?User /*?array*/
{
    try {
        $query = "SELECT 
                    `user_id`,
                    `first_name`, 
                    `last_name`, 
                    `middle_name`, 
                    `gender`, 
                    `birth_date`, 
                    `email`, 
                    `phone`, 
                    `avatar_path`
                  FROM 
                      `user`
                  WHERE 
                      `user_id` = :user_id;";
        $request = $pdo->prepare($query);
        $request->execute([
            ':user_id' => $userId
        ]);

        $userData = $request->fetch(PDO::FETCH_ASSOC);
        $user = new User(
            $userData['user_id'],
            $userData['first_name'],
            $userData['last_name'],
            $userData['middle_name'],
            $userData['gender'],
            $userData['birth_date'],
            $userData['email'],
            $userData['phone'],
            $userData['avatar_path']
        );
        if (!$userData) {
            return null;
        }
        //return $user;
        return $user;
    }
    catch (Exception $exception) {
        throw new DataBaseException("{$exception}");
    }
}


try {
    $connectionParams = getConnectionParams();
    $connection = connectDatabase($connectionParams);
    $user = findUserInDatabase($connection, $_GET['user_id']);

    /*foreach ($user as $key => $value) {
        echo htmlspecialchars($key . ": " . $value . "<br>");
    }*/

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
}

