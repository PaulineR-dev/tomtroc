<?php
/*
    Rôle :
        - Point d'entrée principal du site
        - Initialise la session
        - Charge la configuration et le moteur de vues
        - Router : redirige vers le bon contrôleur selon l'action demandée
*/

session_start();

define('MAIN_VIEW_PATH', 'views/layout.php');
define('TEMPLATE_VIEW_PATH', 'views/');
require_once 'views/View.php';
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
            session_destroy();
            header('Location: index.php?action=login');
            exit;

        // Page profil utilisateur Mon compte
        case 'profil':
            require_once 'controllers/ProfilController.php';
            $controller = new ProfilController();
            $controller->index();
            break;
   
        // Page : Nos livres à l'échange
        case 'books':
            require_once 'controllers/BookController.php';
            $controller = new BookController();
            $controller->exchange();
            break;

        // Page : Ajouter un livre
        case 'add':
            require_once 'controllers/BookController.php';
            $controller = new BookController();
            $controller->add();
            break;
    
        // Page : Détails d'un livre
        case 'book':
            require_once 'controllers/BookController.php';
            $controller = new BookController();
            $controller->show();
            break;

        // Page : Modifier un livre
        case 'editBook':
            require_once 'controllers/BookController.php';
            $controller = new BookController();
            $controller->edit();
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