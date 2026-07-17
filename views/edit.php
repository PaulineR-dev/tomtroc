<div class="edit-header">
    <a href="index.php?action=books" class="edit-back">← retour</a>
    <h1 class="edit-title">Modifier les informations</h1>
</div>

<div class="edit-container">

    <div class="edit-left">

        <span class="photo-label">Photo</span>

        <div class="photo-box">
            <img src="<?= htmlspecialchars($book['image'] ?: 'assets/img/default.webp') ?>"
                 alt="<?= htmlspecialchars($book['title']) ?>"
                 class="book-cover">

            <a href="#" class="edit-photo-link">Modifier la photo</a>
            <input type="file" id="edit-image-input" name="image" accept="image/*" hidden>

        </div>

    </div>

    <div class="edit-right">

        <form action="index.php?action=editBook&id=<?= $book['id'] ?>" 
              method="POST" enctype="multipart/form-data"
              class="edit-form">

            <label class="edit-label">Titre</label>
            <input type="text" name="title" value="<?= htmlspecialchars($book['title']) ?>" class="edit-input">

            <label class="edit-label">Auteur</label>
            <input type="text" name="author" value="<?= htmlspecialchars($book['author']) ?>" class="edit-input">

            <label class="edit-label">Commentaires</label>
            <textarea name="description" class="edit-textarea"><?= htmlspecialchars($book['description'] ?? '') ?></textarea>

            <label class="edit-label">Disponibilité</label>
            <select name="status" class="edit-input">
                <option value="available" <?= $book['status'] === 'available' ? 'selected' : '' ?>>Disponible</option>
                <option value="unavailable" <?= $book['status'] === 'unavailable' ? 'selected' : '' ?>>Non disponible</option>
            </select>

            <button type="submit" class="edit-submit">Valider</button>

        </form>

    </div>

</div>


<script src="scripts/edit.js"></script>
