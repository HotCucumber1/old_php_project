<?php

namespace App\Controller;

use App\Model\UserTable;
use App\Model\User;
use App\Exceptions\DataBaseException;
use App\Connection\ConnectionProvider;
use \RuntimeException;


class UserController
{
    const PNG = 'image/png';
    const JPEG = 'image/jpeg';
    const GIF = 'image/gif';
    const SAVE_DIR = "./uploads/";
    private UserTable $table;

    public function __construct()
    {
        $connectionParams = ConnectionProvider::getConnectionParams();
        $connection = ConnectionProvider::connectDatabase($connectionParams);
        $this->table = new UserTable($connection);
    }

    public function index(): void
    {
        require './src/View/add_user_form.php';
    }

    public function addNewUser(array $request, array $avatar): void
    {
        $user = new User(
            null,
            $request['name'],
            $request['last_name'],
            ($request['middle_name'] == '') ? null : $request['middle_name'],
            $request['gender'],
            $request['birth_date'],
            $request['email'],
            ($request['phone'] == '') ? null : $request['phone'] == '',
            ($request['avatar_path'] == '') ? null : $request['avatar_path'] == '',
        );
        $last = $this->table->addUser($user);
        if ($last) {
            $this->saveAvatar($avatar, $last);
            $redirectUrl = "/show_user.php?user_id={$last}";
            $this->redirectToPage($redirectUrl);
        }
    }

    public function updateUser(array $request, array $data, array $avatar): void
    {
        $id = $request['user_id'] ?? null;
        if ($id === null)
            throw new DataBaseException('Parameter userId is not defined');

        $user = $this->table->findUser($id);
        $this->changeUserData($user, $data);

        $this->table->updateUser($user);
        $this->saveAvatar($avatar, $id);
        $user = $this->table->findUser($id);
        if (!is_null($user))
            require './src/View/user_page.php';
        else
            echo "User not found";
    }

    private function changeUserData(User $user, array $data): void
    {
        $user->setFirstName($data['name']);
        $user->setLastName($data['last_name']);
        $user->setMiddleName(($data['middle_name'] == '') ? null : $data['middle_name']);
        $user->setGender($data['gender']);
        $user->setBirthDate($data['birth_date']);
        $user->setEmail($data['email']);
        $user->setPhone(($data['phone'] == '') ? null : $data['phone'] == '',);
        $user->setAvatarPath(($data['avatar_path'] == '') ? null : $data['avatar_path'] == '');
    }

    public function deleteUser(array $request): void
    {
        $id = $request['user_id'] ?? null;
        if ($id === null)
            throw new DataBaseException('Parameter userId is not defined');
        $this->table->deleteUser($id);

        $redirectUrl = "/src/View/delete_status.html";
        $this->redirectToPage($redirectUrl);
    }

    private function redirectToPage(string $redirectUrl): void
    {
        header('Location: ' . $redirectUrl, true, 303);
        die();
    }

    private function saveAvatar(array $avatar, int $id): void
    {
        if ($avatar['tmp_name'] != "") {
            $avatarPath = self::SAVE_DIR . "{$id}" . basename($avatar['name']);
            if ($avatar['type'] === self::PNG ||
                $avatar['type'] === self::JPEG ||
                $avatar['type'] === self::GIF) {
                if (move_uploaded_file($avatar['tmp_name'], $avatarPath)) {
                    $this->table->saveAvatarPathToDB($avatarPath, $id);
                    return;
                }
                throw new RuntimeException('File was not saved');
            } else
                throw new \TypeError("Wrong type of image");
        }
    }


    public function showUser(array $request): void
    {
        $id = $request['user_id'] ?? null;
        if ($id === null)
            throw new DataBaseException('Parameter userId is not defined');
        $user = $this->table->findUser($id);
        if (!is_null($user))
            require './src/View/user_page.php';
        else
            echo "User not found";
    }

    public function showAllUsers(): void
    {
        $users = $this->table->pullUsers();
        if ($users) {
            require './src/View/all_users_list.php';
        } else {
            echo "Users not found";
        }
    }
}
