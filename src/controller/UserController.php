<?php
namespace App\controller;

use App\model\UserTable;
use App\model\User;
use App\exceptions\DataBaseException;
use App\connection\ConnectionProvider;
use http\Exception\RuntimeException;


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

    public function addNewUser(array $request, array $avatar): void
    {
        try {
            $avatarPath = is_null($request['avatar_path']) ? "" : $request['avatar_path'];
            $user = new User(
                null,
                $request['name'],
                $request['last_name'],
                $request['middle_name'],
                $request['gender'],
                $request['birth_date'],
                $request['email'],
                $request['phone'],
                $avatarPath
            );
            $last = $this->table->addUser($user);

            if ($last) {
                $this->saveAvatar($avatar, $last);
                $redirectUrl = "/show_user.php?user_id={$last}";
                $this->redirectToPage($redirectUrl);
            }
        }
        catch (\TypeError $e) {
            throw new \TypeError($e);
        }
        catch (RuntimeException $e) {
            throw new RuntimeException($e);
        }
        catch (DataBaseException $e) {
            throw new DataBaseException($e);
        }
    }

    public function updateUser(array $request, array $data, array $avatar): void
    {
        try
        {
            $id = $request['user_id'] ?? null;
            if ($id === null)
                throw new DataBaseException('Parameter userId is not defined');
            $avatarPath = is_null($data['avatar_path']) ? "" : $data['avatar_path'];
            $user = new User(
                null,
                $data['name'],
                $data['last_name'],
                $data['middle_name'],
                $data['gender'],
                $data['birth_date'],
                $data['email'],
                $data['phone'],
                $avatarPath
            );
            $this->table->updateUser($id, $user);
            $this->saveAvatar($avatar, $id);
            $user = $this->table->findUser($id);
            require './src/view/user_page.php';
        }
        catch (DataBaseException $e) {
            throw new DataBaseException($e);
        }
    }

    public function deleteUser(array $request): void
    {
        try
        {
            $id = $request['user_id'] ?? null;
            if ($id === null)
                throw new DataBaseException('Parameter userId is not defined');
            $this->table->deleteUser($id);

            $redirectUrl = "/delete_status.html";
            $this->redirectToPage($redirectUrl);
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

    private function saveAvatar(array $avatar, int $id): void
    {
        try {
            if ($avatar['tmp_name'] != "") {
                $avatarDir = "./uploads/";
                $avatarPath = $avatarDir . "{$id}" . basename($avatar['name']) ;
                if ($avatar['type'] === 'image/png' ||
                    $avatar['type'] === 'image/jpeg' ||
                    $avatar['type'] === 'image/gif')
                {
                    if (move_uploaded_file($avatar['tmp_name'], $avatarPath))
                    {
                        $this->table->saveAvatarPathToDB($avatarPath, $id);
                        return;
                    }
                    throw new RuntimeException('File was not saved');
                }
                else
                    throw new \TypeError("Wrong type of image");
            }
        }
        catch (\TypeError $e) {
            throw new \TypeError($e);
        }
        catch (RuntimeException $e) {
            throw new RuntimeException($e);
        }
        catch (\Exception $e) {
            throw new DataBaseException($e);
        }
    }


    public function showUser(array $request): void
    {
        try {
            $id = $request['user_id'] ?? null;
            if ($id === null)
                throw new DataBaseException('Parameter userId is not defined');
            $user = $this->table->findUser($id);
            require './src/view/user_page.php';
        }
        catch (DataBaseException $e) {
            throw new DataBaseException($e);
        }
    }
}
