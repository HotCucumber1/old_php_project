<?php
//require_once '../../data/exceptions/DataBaseException.php';


try {
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

