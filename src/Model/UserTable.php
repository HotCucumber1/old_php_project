<?php
namespace App\Model;


class UserTable
{
    private const MYSQL_DATETIME_FORMAT = "Y-m-d H:i:s";

    public function __construct(private \PDO $connection)
    {
    }

    public function addUser(User $user): int
    {
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

    public function findUser(int $userId): ?User
    {
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

    public function pullUsers(): array // change
    {
        $usersArray = [];
        $query = "SELECT * FROM user";
        $request = $this->connection->query($query);
        $users = $request->fetch(\PDO::FETCH_ASSOC);
        /*foreach ($users as $user) {

        }*/
        return [];
    }

    public function updateUser(User $user): void
    {
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
            ':user_id' => $user->getUserId()
        ]);
    }

    public function deleteUser(int $id): void
    {
        $query = "DELETE FROM
                          user
                      WHERE
                          user_id = :user_id";
        $request = $this->connection->prepare($query);
        $request->execute([
            ':user_id' => $id
        ]);
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

    private function createUser(array $user): User  // добавить валидацию
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
