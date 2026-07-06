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
}