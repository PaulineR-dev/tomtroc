<?php
/*
    Gère toutes les actions liées aux livres :
    - exchange() : affichage des livres disponibles + recherche
    - add()      : ajout d’un livre
    - show()     : affichage d’un livre
    - edit()     : modification d’un livre
    - delete()   : suppression d'un livre
*/

require_once 'models/BookModel.php';
require_once 'views/View.php';

class BookController {

    public function exchange() {

        $bookModel = new BookModel();

        $search = isset($_GET['search']) ? trim($_GET['search']) : '';

        if (!empty($search)) {
            $books = $bookModel->searchByTitle($search);
        } else {
            $books = $bookModel->getAllBooks();
        }

        $view = new View("Nos livres à l'échange");

        $view->render("books", [
            "books"  => $books,
            "search" => $search
        ]);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $title = trim($_POST['title']);
            $author = trim($_POST['author']);
            $description = trim($_POST['description']);
            $status = trim($_POST['status']);
            $userId = $_SESSION['idUser'];

            $imagePath = null;

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {

                $tmpPath = $_FILES['image']['tmp_name'];
                $destination = 'assets/img/' . pathinfo($_FILES['image']['name'], PATHINFO_FILENAME) . '.webp';

                $imageType = exif_imagetype($tmpPath);
                switch ($imageType) {
                    case IMAGETYPE_JPEG:
                        $image = imagecreatefromjpeg($tmpPath);
                        break;
                    case IMAGETYPE_PNG:
                        $image = imagecreatefrompng($tmpPath);
                        break;
                    default:
                        throw new Exception("Format non supporté");
                }

                imagewebp($image, $destination, 80);
                imagedestroy($image);

                $imagePath = 'assets/img/' . basename($destination);
            }

            $bookModel = new BookModel();
            $bookModel->addBook($userId, $title, $author, $description, $status, $imagePath);

            header('Location: index.php?action=profil');
            exit;
        }

        $view = new View("Ajouter un livre");
        $view->render("add");
    }

    public function show()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            throw new Exception("Livre introuvable");
        }

        $bookModel = new BookModel();
        $book = $bookModel->getBookById($id);

        if (!$book) {
            throw new Exception("Livre introuvable");
        }

        // Charger le propriétaire du livre
        require_once 'models/UserModel.php';
        $userModel = new UserModel();
        $owner = $userModel->getUserById($book['user_id']);

        $view = new View("Détails du livre");
        $view->render("book", [
            'book'    => $book,
            'owner'   => $owner,
            'session' => $_SESSION
        ]);
    }

    public function edit()
    {
        $id = $_GET['id'];

        $bookModel = new BookModel();
        $book = $bookModel->getBookById($id);

        if ($book['user_id'] !== $_SESSION['idUser']) {
            throw new Exception("Accès interdit");
        }

        require_once 'models/UserModel.php';
        $userModel = new UserModel();
        $owner = $userModel->getUserById($book['user_id']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $title = trim($_POST['title']);
            $author = trim($_POST['author']);
            $description = trim($_POST['description']);
            $status = trim($_POST['status']);

            $imagePath = $book['image'];

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {

                $tmpPath = $_FILES['image']['tmp_name'];
                $destination = 'assets/img/' . pathinfo($_FILES['image']['name'], PATHINFO_FILENAME) . '.webp';

                $imageType = exif_imagetype($tmpPath);
                switch ($imageType) {
                    case IMAGETYPE_JPEG:
                        $image = imagecreatefromjpeg($tmpPath);
                        break;
                    case IMAGETYPE_PNG:
                        $image = imagecreatefrompng($tmpPath);
                        break;
                    default:
                        throw new Exception("Format non supporté");
                }

                imagewebp($image, $destination, 100);
                imagedestroy($image);

                $imagePath = $destination;
            }

            $bookModel->updateBook($id, $title, $author, $description, $status, $imagePath);

            header('Location: index.php?action=profil');
            exit;
        }

        $view = new View("Modifier un livre");
        $view->render("edit", [
            'book'  => $book,
            'owner' => $owner
        ]);
    }

    public function delete()
    {
        $id = $_GET['id'];

        $bookModel = new BookModel();
        $book = $bookModel->getBookById($id);

        if (!$book) {
            throw new Exception("Livre introuvable");
        }

        if ($book['user_id'] !== $_SESSION['idUser']) {
            throw new Exception("Accès interdit");
        }

        $bookModel->deleteBook($id);

        header('Location: index.php?action=profil');
        exit;
    }

}
