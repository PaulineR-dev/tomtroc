<?php

require_once 'views/View.php';
require_once 'models/UserModel.php';

class RegisterController
{
    public function index(): void
    {
        try {

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $pseudo   = $_POST['pseudo'] ?? '';
                $email    = $_POST['email'] ?? '';
                $password = $_POST['password'] ?? '';

                // Tableau pour stocker toutes les erreurs
                $errors = [];

                // Vérification des champs vides
                if (empty($pseudo) || empty($email) || empty($password)) {
                    $errors[] = "Tous les champs sont obligatoires.";
                }

                // Instance du modèle utilisateur
                $model = new UserModel();

                // Vérification pseudo déjà pris
                $existingPseudo = $model->findUserByUsername($pseudo);
                if ($existingPseudo) {
                    $errors[] = "Ce pseudo est déjà utilisé.";
                }

                // Vérification email déjà pris
                $existingUser = $model->findUserByEmail($email);
                if ($existingUser) {
                    $errors[] = "Cet email est déjà utilisé.";
                }

                // S'il y a des erreurs, on les affiche toutes
                if (!empty($errors)) {
                    $view = new View("Inscription");
                    $view->render("register", [
                        'errors' => $errors
                    ]);
                    return;
                }

                // Création de l'utilisateur
                $model->createUser($pseudo, $email, $password);

                // Redirection vers la page de connexion
                header("Location: index.php?action=login");
                exit;
            }

            // Affichage simple de la page
            $view = new View("Inscription");
            $view->render("register");

        } catch (Exception $exception) {

            $errorView = new View("Erreur");
            $errorView->render("errorPage", [
                'errorMessage' => $exception->getMessage()
            ]);
        }
    }
}