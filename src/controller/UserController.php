<?php
require_once './src/model/UserTable.php';
require_once './connection.php';
require_once './data/exceptions/DataBaseException.php';

class UserController
{
    private UserTable $table;

    public function __construct()
    {
        try {
            $connectionParams = getConnectionParams();
            $connection = connectDatabase($connectionParams);
            $this->table = new UserTable($connection);
        }
        catch (DataBaseException $e) {
            throw new DataBaseException($e);
        }
    }
    public function index(): void
    {
        require './src/view/add_user_form.php';
    }

    public function addNewUser(array $request): void
    {
        try {
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
            $last = $this->table->addUser($user);

            if ($last) {
                $redirectUrl = "/show_user.php?user_id={$last}";
                header('Location: ' . $redirectUrl, true, 303);
                die();
            }
        }
        catch (DataBaseException $e) {
            throw new DataBaseException($e);
        }
    }

    public function showUser(array $request): void
    {
        try {
            $id = $request['user_id'] ?? null;
            if ($id === null)
                throw new DataBaseException('Parameter userId is not defined');
            $user = $this->table->findUser($_GET['user_id']);
            require './src/view/show_user_info.php';
        }
        catch (DataBaseException $e) {
            throw new DataBaseException($e);
        }
    }
}
