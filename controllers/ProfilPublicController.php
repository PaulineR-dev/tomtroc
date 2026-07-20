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
        $user = $userModel->getPublicUserById($userId);

        if (!$user) {
            throw new Exception("Utilisateur introuvable.");
        }

        // Calcul du "Membre depuis"
        $memberSince = "date inconnue";

        if (!empty($user['created_at'])) {
            $created = new DateTime($user['created_at']);
            $now = new DateTime();
            $diff = $created->diff($now);

            if ($diff->y >= 1) {
                $memberSince = $diff->y . ' an' . ($diff->y > 1 ? 's' : '');
            } elseif ($diff->m >= 1) {
                $memberSince = $diff->m . ' mois';
            } else {
                $memberSince = $diff->d . ' jour' . ($diff->d > 1 ? 's' : '');
            }
        }

        // Récupérer ses livres
        $bookModel = new BookModel();
        $books = $bookModel->getBooksByUserId($userId);

        // Vue
        $view = new View("Profil public");
        $view->render("profilPublic", [
            'user' => $user,
            'books' => $books,
            'memberSince' => $memberSince
        ]);
    }
}
