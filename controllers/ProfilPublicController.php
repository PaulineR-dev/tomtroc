<?php

require_once 'views/View.php';
require_once 'models/UserModel.php';
require_once 'models/BookModel.php';

class ProfilPublicController
{
    public function index(): void
    {
        if (!isset($_GET['id'])) {
            throw new Exception("Utilisateur introuvable.");
        }

        $userId = (int) $_GET['id'];

        // Récupérer l'utilisateur
        $userModel = new UserModel();
        $user = $userModel->getUserById($userId);

        if (!$user) {
            throw new Exception("Utilisateur introuvable.");
        }

        // Récupérer ses livres
        $bookModel = new BookModel();
        $books = $bookModel->getBooksByUserId($userId);

        // Vue
        $view = new View("Profil public");
        $view->render("profilPublic", [
            'user' => $user,
            'books' => $books
        ]);
    }
}
