<?php

class UserModel
{
    public function createUser(string $pseudo, string $email, string $password): void
    {
        // Connexion via Config
        $pdo = Config::getPDO();

        // Hash du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Requête préparée
        $statement = $pdo->prepare("
            INSERT INTO users (username, email, password)
            VALUES (:username, :email, :password)
        ");

        $statement->execute([
            ':username' => $pseudo,
            ':email' => $email,
            ':password' => $hashedPassword
        ]);
    }

    public function findUserByEmail(string $email): array|false
    {
        $pdo = Config::getPDO();

        $statement = $pdo->prepare("
            SELECT * FROM users WHERE email = :email
        ");

        $statement->execute([':email' => $email]);

        return $statement->fetch();
    }

    public function findUserByUsername(string $username): array|false
    {
        $pdo = Config::getPDO();

        $statement = $pdo->prepare("
            SELECT * FROM users WHERE username = :username
        ");

        $statement->execute([':username' => $username]);

        return $statement->fetch();
    }

    public function updateUser(int $id, ?string $email, ?string $username, ?string $hashedPassword): void
    {
        $pdo = Config::getPDO();

        $fields = [];
        $params = [':id' => $id];

        if (!empty($email)) {
            $fields[] = "email = :email";
            $params[':email'] = $email;
        }

        if (!empty($username)) {
            $fields[] = "username = :username";
            $params[':username'] = $username;
        }

        if (!empty($hashedPassword)) {
            $fields[] = "password = :password";
            $params[':password'] = $hashedPassword;
        }

        if (empty($fields)) {
            return; // rien à mettre à jour
        }

        $sql = "UPDATE users SET " . implode(", ", $fields) . " WHERE id = :id";

        $statement = $pdo->prepare($sql);
        $statement->execute($params);
    }

    public function updateAvatar($userId, $avatarPath)
    {
        $pdo = Config::getPDO();

        $statement = $pdo->prepare("UPDATE users SET avatar = :avatar WHERE id = :id");
        $statement->bindValue(':avatar', $avatarPath);
        $statement->bindValue(':id', $userId);
        $statement->execute();
    }

    public function getUserById(int $id): ?array
    {
        $pdo = Config::getPDO();

        $statement = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $statement->execute([$id]);

        return $statement->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}