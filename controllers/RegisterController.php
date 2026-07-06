<?php

require_once 'models/UserModel.php';

class RegisterController
{
    public function index(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $pseudo   = $_POST['pseudo'] ?? '';
            $email    = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($pseudo) || empty($email) || empty($password)) {
                $error = "Tous les champs sont obligatoires.";
                $view  = 'views/register.php';
                require 'views/layout.php';
                return;
            }

            $model = new UserModel();

            // Vérification si l'email existe déjà
            $existingUser = $model->findUserByEmail($email);

            if ($existingUser) {
                $error = "Cet email est déjà utilisé.";
                $view  = 'views/register.php';
                require 'views/layout.php';
                return;
            }

            // Création de l'utilisateur
            $model->createUser($pseudo, $email, $password);

            header('Location: index.php?action=login');
            exit;
        }

        $view = 'views/register.php';
        require 'views/layout.php';
    }
}