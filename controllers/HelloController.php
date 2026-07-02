<?php

require_once 'models/HelloModel.php';

class HelloController {

    // Affiche la page Hello World
    public function index() : void
    {
        // On récupère le message via le modèle.
        $model = new HelloModel();
        $message = $model->getMessage();

        require 'views/helloworld.php';
    }
}