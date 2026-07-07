<?php

require_once 'views/View.php';

class ProfilController
{
    /**
     * Affiche la page profil (Mon compte) si l'utilisateur est connecté.
     */
    public function index(): void
    {
        try {
            // Démarre la session pour accéder aux données utilisateur
            session_start();

            // Vérifie si l'utilisateur est connecté
            if (!isset($_SESSION['user'])) {
                // Redirige vers la page de connexion si la session est absente
                header("Location: index.php?action=login");
                exit;
            }

            // Récupère les informations de l'utilisateur depuis la session
            $user = $_SESSION['user'];

            // Affiche la vue
            $view = new View("Profil");
            $view->render("profil", [
                'user' => $user
            ]);

        } catch (Exception $exception) {

            // En cas d’erreur, on affiche la page d’erreur
            $errorView = new View("Erreur");
            $errorView->render("errorPage", [
                'errorMessage' => $exception->getMessage()
            ]);
        }
    }
}