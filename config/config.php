<?php

/**
 * Connexion avec la base de données 
 */
class Config
{
    public static function getPDO(): PDO
    {
        // Chargement du fichier avec les identifiants de connexion à la base de données
        $config = require __DIR__ . '/connexion.php';

        return new PDO(
            "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4",
            $config['user'],
            $config['password']
        );
    }
}