<?php
//namespace controller;
use http\Exception\InvalidArgumentException;
/*use UserTable;
use User;*/

require_once '../model/UserTable.php';
require_once '../model/User.php';
require_once 'connection.php';
require_once '../../data/exceptions/DataBaseException.php';

class UserController
{
    private UserTable $table;
    public function __construct()
    {
        $connectionParams = getConnectionParams();
        $connection = connectDatabase($connectionParams);
        $this->table = new UserTable($connection);
    }
    public function index(): void
    {
        require '../view/add_user_form.php';
    }

    public function addNewUser(array $request): void
    {
        $user = new User(
            null,
            $request['name'],
            $request['last_name'],
            $request['middle_name'],
            $request['gender'],
            $request['birth_date'],
            $request['email'],
            $request['phone'],
            $request['avatar_path']
        );
        $this->last = $this->table->addUser($user);

        if ($this->last) {
            $redirectUrl = "/show_user.php?user_id={$this->last}";
            header('Location: ' . $redirectUrl, true, 303);
            die();
        }
    }

    public function showUser(array $request): void
    {
        $id = $request['id'] ?? null;
        if ($id === null)
            throw new InvalidArgumentException('Parameter id is not defined');
        $user = $this->table->findUser($_GET['user_id']);
        require '../view/show_user_info.php';
    }
}
