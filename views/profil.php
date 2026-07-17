<div class="account-page">

    <h1>Mon compte</h1>

    <div class="profil-wrapper">

        <!-- Bloc profil -->
        <div class="profil-card">

            <img src="<?= htmlspecialchars($user['avatar'] ?? 'assets/img/default.webp') ?>" 
                 alt="Photo de profil" class="profil-photo"> 

            <a href="#" class="profil-edit">modifier</a>
            <input type="file" id="avatar-input" name="avatar" accept="image/*">

            <div class="profil-separator"></div>

            <h2 class="profil-username"><?= htmlspecialchars($user['username']) ?></h2>

            <?php
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
            ?>

            <p class="profil-member">
                Membre depuis <?= $memberSince ?>
            </p>

            <p class="profil-library-title">BIBLIOTHEQUE</p>

            <p class="profil-library-count">
                <i class="fa-solid fa-book"></i>
                <?= count($books) ?> <?= count($books) < 2 ? 'livre' : 'livres' ?>
            </p>

        </div>

        <div class="info-card">

            <h3 class="info-title">Vos informations personnelles</h3>

            <form method="post" action="index.php?action=updateProfil" enctype="multipart/form-data">

                <label class="info-label">Adresse email</label>
                <input class="info-input" type="email" name="email" 
                       value="<?= htmlspecialchars($user['email']) ?>">

                <label class="info-label">Mot de passe</label>
                <input class="info-input" type="password" name="password">

                <label class="info-label">Pseudo</label>
                <input class="info-input" type="text" name="username" 
                       value="<?= htmlspecialchars($user['username']) ?>">

                <button class="info-button" type="submit">
                    <span class="info-button-text">Enregistrer</span>
                </button>

            </form>

        </div>

    </div>

    <div class="add-book-wrapper">
        <a href="index.php?action=add" class="add-book-button">
            <i class="fa-solid fa-plus"></i> Ajouter un livre
        </a>
    </div>

    <div class="library-block">

        <table class="library-table">
            <thead>
                <tr>
                    <th>PHOTO</th>
                    <th>TITRE</th>
                    <th>AUTEUR</th>
                    <th>DESCRIPTION</th>
                    <th>DISPONIBILITE</th>
                    <th>ACTION</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($books as $book): ?>
                    <tr>
                        <td>
                            <img class="library-img"
                                src="<?= htmlspecialchars($book['image'] ?: 'assets/img/default.webp') ?>"
                                alt="<?= htmlspecialchars($book['title'] ?? '') ?>">
                        </td>

                        <td class="library-title-cell">
                            <?= htmlspecialchars($book['title']) ?>
                        </td>

                        <td class="library-author-cell">
                            <?= htmlspecialchars($book['author']) ?>
                        </td>

                        <td class="library-desc-cell">
                            <em><?= htmlspecialchars(substr($book['description'] ?? '', 0, 92)) ?>...</em>

                        </td>

                        <td>
                            <?php if ($book['status'] === 'available'): ?>
                                <span class="badge-available">disponible</span>
                            <?php else: ?>
                                <span class="badge-unavailable">non dispo.</span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <a class="action-edit"
                               href="index.php?action=editBook&id=<?= $book['id'] ?>">Éditer</a>
                            
                            <a class="action-delete"
                               href="index.php?action=delete&id=<?= $book['id'] ?>">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>

</div>

<script src="scripts/avatar.js"></script>