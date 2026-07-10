<?php

require_once 'views/View.php';
require_once 'models/BookModel.php';

class ProfilController
{
    /**
     * Affiche la page profil (Mon compte) si l'utilisateur est connecté
     */
    public function index(): void
    {
        try {
            // Vérifie si l'utilisateur est connecté
            if (!isset($_SESSION['user'])) {
                header("Location: index.php?action=login");
                exit;
            }

            // Récupère les informations de l'utilisateur depuis la session
            $user = $_SESSION['user'];

            // Récupère les livres de l'utilisateur
            $bookModel = new BookModel();
            $books = $bookModel->getBooksByUserId($user['id']);

            // Affiche la vue
            $view = new View("Profil");
            $view->render("profil", [
                'user' => $user,
                'books' => $books
            ]);

        } catch (Exception $exception) {
            $errorView = new View("Erreur");
            $errorView->render("errorPage", [
                'errorMessage' => $exception->getMessage()
            ]);
        }
    }

    public function updateProfil(): void
    {
        try {
            if (!isset($_SESSION['user'])) {
                header("Location: index.php?action=login");
                exit;
            }

            $user = $_SESSION['user'];
            $userId = $user['id'];

            $email = trim($_POST['email']);
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            $userModel = new UserModel();

            // Préparation des valeurs à mettre à jour
            $newEmail = $email !== $user['email'] ? $email : null;
            $newUsername = $username !== $user['username'] ? $username : null;
            $newPassword = !empty($password) ? password_hash($password, PASSWORD_DEFAULT) : null;

            // Mise à jour BDD
            $userModel->updateUser($userId, $newEmail, $newUsername, $newPassword);

            // Mise à jour session
            if ($newEmail !== null) {
                $_SESSION['user']['email'] = $newEmail;
            }

            if ($newUsername !== null) {
                $_SESSION['user']['username'] = $newUsername;
            }

            // UPLOAD AVATAR
            if (!empty($_FILES['profile_image']['name'])) {

                $tmp = $_FILES['profile_image']['tmp_name'];

                $fileName = 'avatar_' . $userId . '.webp';
                $destination = 'assets/img/profil/' . $fileName;

                $image = imagecreatefromstring(file_get_contents($tmp));
                imagewebp($image, $destination, 80);
                imagedestroy($image);

                $userModel->updateAvatar($userId, $destination);

                $_SESSION['user']['avatar'] = $destination;
            }

            $_SESSION['success'] = "Profil mis à jour avec succès.";
            header("Location: index.php?action=profil");
            exit;

        } catch (Exception $exception) {
            $errorView = new View("Erreur");
            $errorView->render("errorPage", [
                'errorMessage' => $exception->getMessage()
            ]);
        }
    }
}
