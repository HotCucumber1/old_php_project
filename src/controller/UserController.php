<?php
namespace App\controller;

use App\model\UserTable;
use App\model\User;
use App\exception\DataBaseException;
use App\connection\ConnectionProvider;


class UserController
{
    private UserTable $table;

    public function __construct()
    {
        try {
            $connectionParams = ConnectionProvider::getConnectionParams();
            $connection = ConnectionProvider::connectDatabase($connectionParams);
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
                $this->redirectToPage($redirectUrl);
            }
        }
        catch (DataBaseException $e) {
            throw new DataBaseException($e);
        }
    }

    private function redirectToPage(string $redirectUrl): void
    {
        header('Location: ' . $redirectUrl, true, 303);
        die();
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
