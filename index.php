<?php

require_once 'config/config.php';

// Action demandée par l'utilisateur
$action = $_GET['action'] ?? 'helloworld';

// Try et catch global pour gérer les erreurs
try {
    // Pour chaque action, on appelle le bon contrôleur et la bonne méthode.
    switch ($action) {
        // Pages accessibles à tous (uniquement test hello world pour le moment)
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

        default:
            throw new Exception("La page demandée n'existe pas.");
    }

} catch (Exception $exception) {
    $errorMessage = $exception->getMessage();
    require 'views/errorPage.php';
}