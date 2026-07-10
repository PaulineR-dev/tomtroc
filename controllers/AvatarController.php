<?php

require_once 'models/UserModel.php';

class AvatarController
{
    public function upload()
    {
        // Vérifie que l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            http_response_code(403);
            echo json_encode(['error' => 'not_logged']);
            return;
        }

        // Vérifie qu'un fichier a été envoyé
        if (!isset($_FILES['avatar'])) {
            http_response_code(400);
            echo json_encode(['error' => 'no_file']);
            return;
        }

        // Récupère l'ID utilisateur
        $userId = $_SESSION['user']['id'];

        // Nom fixe basé sur l'ID utilisateur pour remplacer l'avatar 
        $fileName = 'avatar_' . $userId . '.webp';
        $destination = 'assets/img/profil/' . $fileName;

        // Conversion WebP
        $tmp = $_FILES['avatar']['tmp_name'];
        $image = imagecreatefromstring(file_get_contents($tmp));
        imagewebp($image, $destination, 80);
        imagedestroy($image);

        // Mise à jour BDD
        $userModel = new UserModel();
        $userModel->updateAvatar($userId, $destination);

        // Mise à jour session
        $_SESSION['user']['avatar'] = $destination;

        // Réponse JSON pour le JS
        echo json_encode([
            'success' => true,
            'avatar' => $destination
        ]);
    }
}
