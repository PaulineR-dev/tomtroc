<?php

require_once 'config/config.php';

// Action demandée par l'utilisateur
$action = $_GET['action'] ?? 'helloworld';

// Try et catch global pour gérer les erreurs
try {
    // Pour chaque action, on appelle le bon contrôleur et la bonne méthode.
    switch ($action) {
        // Pages d'accueil Hello World
        case 'helloworld':
            require_once 'controllers/HelloController.php';
            $controller = new HelloController();
            $controller->index();
            break;

        // Page d'inscription
       case 'register':
            require_once 'controllers/RegisterController.php';
            $controller = new RegisterController();
            $controller->index();
            break;

        // Page de connexion
        case 'login':
            require_once 'controllers/LoginController.php';
            $controller = new LoginController();
            $controller->index();
            break;

        // Déconnexion
        case 'logout':
            session_start();
            session_destroy();
            header('Location: index.php?action=login');
            exit;

        // Page profil utilisateur Mon compte
        case 'profil':
            require_once 'controllers/ProfilController.php';
            $controller = new ProfilController();
            $controller->index();
            break;

        // Action inconnue
        default:
            throw new Exception("La page demandée n'existe pas.");
    }

} catch (Exception $exception) {
    // Gestion des erreurs globales
    $errorMessage = $exception->getMessage();
    require 'views/errorPage.php';
}