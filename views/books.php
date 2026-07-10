<!--
    Page : Nos livres à l'échange
    Affiche la liste des livres, avec barre de recherche
    Données reçues :
        - $books : tableau des livres disponibles ou filtrés
        - $search : recherche par l'utilisateur
-->

<div class="books-header">
    <h1>Nos livres à l'échange</h1>

    <form class="search-bar" method="get" action="index.php">
        <input type="hidden" name="action" value="books">

        <div class="search-wrapper">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" name="search" placeholder="Rechercher un livre..."
                   value="<?= htmlspecialchars($search) ?>">
        </div>
    </form>
</div>

<div class="books-list">
    <?php if (empty($books)): ?>
        <p>Aucun livre trouvé sous ce nom.</p>
    <?php else: ?>
        <?php foreach ($books as $book): ?>
            <div class="book-card">

                <?php if ($book['status'] !== 'available'): ?>
                    <div class="book-status-badge">non dispo.</div>
                <?php endif; ?>

                <?php if (!empty($book['image'])): ?>
                    <img src="<?= htmlspecialchars($book['image']) ?>" 
                         alt="<?= htmlspecialchars($book['description']) ?>">
                <?php endif; ?>

                <div class="book-description">
                    <h2><?= htmlspecialchars($book['title']) ?></h2>

                    <p class="book-author">
                        <?= htmlspecialchars($book['author']) ?>
                    </p>

                    <p class="book-seller">
                        Vendu par : <?= htmlspecialchars($book['seller']) ?>
                    </p>
                </div>

            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
