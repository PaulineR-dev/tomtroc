<div class="edit-header">
    <a href="index.php?action=profil" class="edit-back">← retour</a>
    <h1 class="edit-title">Créer un livre</h1>
</div>

<div class="edit-container">

    <div class="edit-left">

        <span class="photo-label">Photo</span>

        <div class="photo-box">
            <img src="assets/img/default.webp"
                 alt="Aperçu du livre"
                 class="book-cover">

            <a href="#" class="edit-photo-link">Ajouter une photo</a>
            <input type="file" id="edit-image-input" name="image" accept="image/*" hidden>
        </div>

    </div>

    <div class="edit-right">

        <form action="index.php?action=add" method="POST" enctype="multipart/form-data" class="edit-form">

            <label class="edit-label">Titre</label>
            <input type="text" name="title" class="edit-input" placeholder="Titre du livre">

            <label class="edit-label">Auteur</label>
            <input type="text" name="author" class="edit-input" placeholder="Nom de l’auteur">

            <label class="edit-label">Commentaires</label>
            <textarea name="description" class="edit-textarea" placeholder="Description, résumé, notes..."></textarea>

            <label class="edit-label">Disponibilité</label>
            <select name="status" class="edit-input">
                <option value="available">Disponible</option>
                <option value="unavailable">Non disponible</option>
            </select>

            <button type="submit" class="edit-submit">Créer le livre</button>

        </form>

    </div>

</div>

<script src="scripts/edit.js"></script>
