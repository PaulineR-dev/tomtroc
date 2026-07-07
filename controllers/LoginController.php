<?php

require_once 'models/UserModel.php';

class LoginController
{
    /**
     * Affiche la page de connexion et gère l'authentification utilisateur
     */
    public function index(): void
    {
        // Vérifie si le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Récupération sécurisée des champs du formulaire
            $email    = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            // Vérifie que tous les champs sont remplis
            if (empty($email) || empty($password)) {
                $error = "Tous les champs sont obligatoires.";
                $view  = 'views/login.php';
                require 'views/layout.php';
                return;
            }

            // Instance du modèle utilisateur pour interagir avec la base de données
            $model = new UserModel();

            // Recherche de l'utilisateur par email
            $user = $model->findUserByEmail($email);

            // Vérifie si l'utilisateur existe et si le mot de passe est correct
            if ($user && password_verify($password, $user['password'])) {

                // Démarre la session et stocke les informations utilisateur
                session_start();
                $_SESSION['user']   = $user;
                $_SESSION['idUser'] = $user['id'];

                // Redirige vers la page profil après connexion réussie
                header('Location: index.php?action=profil');
                exit;
            }

            // Si la vérification échoue, affiche un message d’erreur
            $error = "Identifiants incorrects.";
            $view  = 'views/login.php';
            require 'views/layout.php';
            return;
        }

        // Si aucune soumission, affiche simplement la page de connexion
        $view = 'views/login.php';
        require 'views/layout.php';
    }
}