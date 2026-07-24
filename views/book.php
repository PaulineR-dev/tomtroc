<div class="breadcrumb">
    <a href="index.php?action=books">Nos livres ></a>
    <span><?= htmlspecialchars($book['title']) ?></span>
</div>

<div class="book-page">

    <!-- Colonne gauche : image -->
    <div class="book-left">
        <img src="<?= htmlspecialchars($book['image'] ?: 'assets/img/default.webp') ?>"
             alt="<?= htmlspecialchars($book['title']) ?>"
             class="book-image">
    </div>

    <!-- Colonne droite : infos -->
    <div class="book-right">

        <!-- Titre -->
        <h1 class="book-title"><?= htmlspecialchars($book['title']) ?></h1>

        <!-- Auteur -->
        <p class="book-author">par <?= htmlspecialchars($book['author']) ?></p>

        <!-- Trait -->
        <div class="book-separator"></div>

        <!-- DESCRIPTION -->
        <p class="book-section-label">DESCRIPTION</p>

        <p class="book-description">
            <?= nl2br(htmlspecialchars($book['description'])) ?>
        </p>

        <!-- PROPRIÉTAIRE -->
        <p class="book-section-label">PROPRIÉTAIRE</p>

        <a href="index.php?action=profilPublic&id=<?= $book['user_id'] ?>" class="book-owner-link">
            <div class="book-owner-box">
                <img src="<?= htmlspecialchars($owner['avatar'] ?? 'assets/img/default.webp') ?>"
                    alt="Avatar"
                    class="book-owner-avatar">

                <span class="book-owner-name">
                    <?= htmlspecialchars($owner['username'] ?? 'Utilisateur inconnu') ?>
                </span>
            </div>
        </a>

        <!-- Bouton message -->
        <a href="index.php?action=messages&to=<?= $book['user_id'] ?>" class="book-message-btn">
            Envoyer un message
        </a>

    </div>

</div>
