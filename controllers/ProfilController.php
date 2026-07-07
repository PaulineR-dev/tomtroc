<?php

class ProfilController
{
    /**
     * Affiche la page profil (Mon compte) si l'utilisateur est connecté.
     */
    public function index(): void
    {
        // Démarre la session pour accéder aux données utilisateur
        session_start();

        // Vérifie si l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            // Redirige vers la page de connexion si la session est absente
            header('Location: index.php?action=login');
            exit;
        }

        // Récupère les informations de l'utilisateur depuis la session
        $user = $_SESSION['user'];

        // Définit la vue à afficher et charge le layout global
        $view = 'views/profil.php';
        require 'views/layout.php';
    }
}
