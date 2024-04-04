<?php

class User
{
    /*private ?int $userId;
    private string $firstName;
    private string $lastName;
    private string $middleName;
    private string $gender;
    private string $birthDate;
    private string $email;
    private string $phone;
    private string $avatar_path;*/

    public function __construct(private ?int $userId,
                                private string $firstName,
                                private string $lastName,
                                private ?string $middleName,
                                private string $gender,
                                private string $birthDate,
                                private string $email,
                                private ?string $phone,
                                private ?string $avatar_path)
    {
        /*$this->userId = $userId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->middleName = $middleName;
        $this->gender = $gender;
        $this->birthDate = $birthDate;
        $this->email = $email;
        $this->phone = $phone;
        $this->avatar_path = $avatar_path;*/

    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getMiddleName(): string
    {
        return $this->middleName;
    }

    /**
     * @return string
     */
    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * @return string
     */
    public function getBirthDate(): string
    {
        return $this->birthDate;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getAvatarPath(): string
    {
        return $this->avatar_path;
    }
}
