<?php

require_once 'views/View.php';
require_once 'models/UserModel.php';

class LoginController
{
    /**
     * Affiche la page de connexion et gère l'authentification utilisateur
     */
    public function index(): void
    {
        try {

            // Si le formulaire est soumis
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                // Récupération sécurisée des champs du formulaire
                $email    = $_POST['email'] ?? '';
                $password = $_POST['password'] ?? '';

                // Vérifie que tous les champs sont remplis
                if (empty($email) || empty($password)) {
                    $view = new View("Connexion");
                    $view->render("login", [
                        'error' => "Tous les champs sont obligatoires."
                    ]);
                    return;
                }

                // Instance du modèle utilisateur
                $model = new UserModel();

                // Recherche de l'utilisateur par email
                $user = $model->findUserByEmail($email);

                // Vérifie si l'utilisateur existe et si le mot de passe est correct
                if ($user && password_verify($password, $user['password'])) {

                    // Démarre la session et stocke les informations utilisateur
                    session_start();
                    $_SESSION['user']   = $user;
                    $_SESSION['idUser'] = $user['id'];

                    // Redirection vers la page profil après connexion réussie
                    header("Location: index.php?action=profil");
                    exit;
                }

                // Si la vérification échoue
                $view = new View("Connexion");
                $view->render("login", [
                    'error' => "Identifiants incorrects."
                ]);
                return;
            }

            // Si aucune soumission, affiche simplement la page de connexion
            $view = new View("Connexion");
            $view->render("login");

        } catch (Exception $exception) {

            // Affichage de la page d'erreur
            $errorView = new View("Erreur");
            $errorView->render("errorPage", [
                'errorMessage' => $exception->getMessage()
            ]);
        }
    }
}