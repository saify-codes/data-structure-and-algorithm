<?php

/**
 * =========================
 * Storage Layer (Database Simulation)
 * =========================
 */
class StorageAdapter
{
    private array $data = [
        1 => ['id' => 1, 'username' => 'ali', 'email' => 'ali@mail.com'],
        2 => ['id' => 2, 'username' => 'ahmed', 'email' => 'ahmed@mail.com'],
    ];

    public function find(int $id): ?array
    {
        return $this->data[$id] ?? null;
    }
}

/**
 * =========================
 * Domain Object
 * =========================
 */
class User
{
    private int $id;
    private string $username;
    private string $email;

    private function __construct(int $id, string $username, string $email)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['username'],
            $data['email']
        );
    }

    public function getInfo(): string
    {
        return "User: {$this->username}, Email: {$this->email}";
    }
}

/**
 * =========================
 * Data Mapper
 * =========================
 */
class UserMapper
{
    private StorageAdapter $storage;

    public function __construct(StorageAdapter $storage)
    {
        $this->storage = $storage;
    }

    public function findById(int $id): User
    {
        $data = $this->storage->find($id);

        if ($data === null) {
            throw new Exception("User not found");
        }

        return User::fromArray($data);
    }
}

/**
 * =========================
 * Application Code
 * =========================
 */
try {
    $storage = new StorageAdapter();
    $mapper = new UserMapper($storage);

    $user = $mapper->findById(1);

    echo $user->getInfo();

} catch (Exception $e) {
    echo $e->getMessage();
}