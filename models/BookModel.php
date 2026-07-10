<?php
/*
    Gère toutes les opérations liées aux livres :
    - Récupération de tous les livres
    - Recherche par titre
    - Ajout d’un livre
    - Récupération d’un livre par ID
    - Mise à jour d’un livre
    - Récupération des livres d’un utilisateur
*/

class BookModel {

    private PDO $databaseConnection;

    public function __construct() {
        $this->databaseConnection = Config::getPDO();
    }

    public function getAllBooks() {
        $query = "SELECT books.*, users.username AS seller
                FROM books
                INNER JOIN users ON books.user_id = users.id
                ORDER BY books.title ASC";

        $statement = $this->databaseConnection->prepare($query);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchByTitle($title)
    {
        $sql = "SELECT books.*, users.username AS seller
                FROM books
                INNER JOIN users ON books.user_id = users.id
                WHERE books.title LIKE :title
                ORDER BY books.title ASC";

        $stmt = $this->databaseConnection->prepare($sql);
        $stmt->execute(['title' => '%' . $title . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addBook(int $userId, string $title, string $author, string $description, ?string $imagePath): void {
        $query = "INSERT INTO books (user_id, title, author, description, image, status, created_at, updated_at)
                  VALUES (:user_id, :title, :author, :description, :image, 'available', NOW(), NOW())";

        $statement = $this->databaseConnection->prepare($query);
        $statement->execute([
            ':user_id'     => $userId,
            ':title'       => $title,
            ':author'      => $author,
            ':description' => $description,
            ':image'       => $imagePath
        ]);
    }

    public function getBookById($id) {
        $sql = "SELECT * FROM books WHERE id = :id";
        $stmt = $this->databaseConnection->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateBook($id, $title, $author, $description, $imagePath) {
        $sql = "UPDATE books 
                SET title = :title, author = :author, description = :description, image = :image
                WHERE id = :id";

        $stmt = $this->databaseConnection->prepare($sql);
        $stmt->bindValue(':title', $title, PDO::PARAM_STR);
        $stmt->bindValue(':author', $author, PDO::PARAM_STR);
        $stmt->bindValue(':description', $description, PDO::PARAM_STR);
        $stmt->bindValue(':image', $imagePath, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function getBooksByUserId(int $userId): array {
        $query = "SELECT books.*, users.username AS seller
                  FROM books
                  INNER JOIN users ON books.user_id = users.id
                  WHERE books.user_id = :user_id
                  ORDER BY books.created_at DESC";

        $statement = $this->databaseConnection->prepare($query);
        $statement->execute([':user_id' => $userId]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
