<?php

require_once 'views/View.php';
require_once 'models/HelloModel.php';

class HelloController {

    /**
     * Affiche la page Hello World
     */
    public function index() : void
    {
        try {
            // On récupère le message via le modèle
            $model   = new HelloModel();
            $message = $model->getMessage();

            // On affiche la vue
            $view = new View("Hello World");
            $view->render("helloworld", [
                'message' => $message
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