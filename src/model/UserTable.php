<?php
namespace App\model;

use App\exceptions\DataBaseException;


// require_once 'User.php';


class UserTable
{
    private const MYSQL_DATETIME_FORMAT = "Y-m-d H:i:s";

    public function __construct(private \PDO $connection)
    {
    }

    public function addUser(User $user): int
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
            $request = $this->connection->prepare($query);

            $request->execute([
                ':first_name' => $user->getFirstName(),
                ':last_name' => $user->getLastName(),
                ':middle_name' => $user->getMiddleName(),
                ':gender' => $user->getGender(),
                ':birth_date' => $user->getBirthDate(),
                ':email' => $user->getEmail(),
                ':phone' => $user->getPhone(),
                ':avatar_path' => $user->getAvatarPath(),
            ]);
            return (int)$this->connection->lastInsertId();
        }
        catch (\Exception $exception) {
            throw new DataBaseException($exception->getMessage());
        }
    }

    public function findUser(int $userId): ?User
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
            $request = $this->connection->prepare($query);
            $request->execute([
                ':user_id' => $userId
            ]);

            $userData = $request->fetch(\PDO::FETCH_ASSOC);
            if ($userData) {
                return $this->createUser($userData);
            }
            return null;
        }
        catch (\Exception $exception) {
            throw new DataBaseException("{$exception}");
        }
    }

    public function updateUser(int $id, User $user): void
    {
        try {
            $query = "UPDATE
                        user
                      SET
                        first_name = :first_name,
                        last_name = :last_name,
                        middle_name = :middle_name,
                        gender = :gender,
                        birth_date = :birth_date,
                        email = :email,
                        phone = :phone
                      WHERE
                        user_id = :user_id;";
            $request = $this->connection->prepare($query);
            $request->execute([
                ':first_name' => $user->getFirstName(),
                ':last_name' => $user->getLastName(),
                ':middle_name' => $user->getMiddleName(),
                ':gender' => $user->getGender(),
                ':birth_date' => $user->getBirthDate(),
                ':email' => $user->getEmail(),
                ':phone' => $user->getPhone(),
                ':user_id' => $id
            ]);
        }
        catch (\Exception $e) {
            throw new DataBaseException($e);
        }
    }

    public function saveAvatarPathToDB(string $avatar, int $id): void
    {
        $query = "UPDATE
                    user
                  SET
                    avatar_path = :avatar
                  WHERE
                    user_id = :id;";
        $request = $this->connection->prepare($query);
        $request->execute([
            ':avatar' => $avatar,
            ':id' => $id,
        ]);
    }

    private function createUser(array $user): User
    {
        return new User(
            $user['user_id'],
            $user['first_name'],
            $user['last_name'],
            $user['middle_name'],
            $user['gender'],
            $user['birth_date'],
            $user['email'],
            $user['phone'],
            $user['avatar_path']
        );
    }

    /*private function parseStringToDateTime(string $date): DateTimeImmutable
    {
        $result = DateTimeImmutable::createFromFormat(self::MYSQL_DATETIME_FORMAT, $date);
        if (!$result) {
            throw new InvalidArgumentException("Invalid datetime value '$date'");
        }
        return $result;
    }

    private function parseDateTimeToString(DateTimeImmutable $date): ?string
    {
        return $date?->format(self::MYSQL_DATETIME_FORMAT);
    }*/
}
