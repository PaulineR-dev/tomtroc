<?php

class HelloModel
{
    public function getMessage(): string
    {
        // Connexion à la base de données via la classe Config
        $pdo = Config::getPDO();
        // Exécution de la requête : sélection colonne "message"
        $statement = $pdo->query("SELECT message FROM hello");

        return $statement->fetch()['message'];
    }
}