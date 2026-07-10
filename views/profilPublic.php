<div class="public-profile">

    <div class="public-left">

        <img src="<?= htmlspecialchars($user['avatar'] ?? 'assets/img/default.webp') ?>"
             alt="Photo de profil"
             class="public-avatar">

             <div class="public-separator"></div>


        <h2 class="public-username"><?= htmlspecialchars($user['username']) ?></h2>

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

        <p class="public-member">Membre depuis <?= $memberSince ?></p>

        <p class="public-books-count">
            <i class="fa-solid fa-book"></i>
            <?= count($books) ?> <?= count($books) < 2 ? 'livre' : 'livres' ?>
        </p>

        <a href="index.php?action=message&id=<?= $user['id'] ?>" class="public-message-btn">
            Écrire un message
        </a>

    </div>

    <div class="public-right">

        <table class="public-books-table">
            <thead>
                <tr>
                    <th>PHOTO</th>
                    <th>TITRE</th>
                    <th>AUTEUR</th>
                    <th>DESCRIPTION</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($books as $book): ?>
                    <tr>
                        <td>
                            <img src="<?= htmlspecialchars($book['image']) ?>"
                                 alt="<?= htmlspecialchars($book['title']) ?>"
                                 class="public-book-img">
                        </td>

                        <td><?= htmlspecialchars($book['title']) ?></td>
                        <td><?= htmlspecialchars($book['author']) ?></td>

                        <td>
                            <em><?= htmlspecialchars(substr($book['description'], 0, 80)) ?>...</em>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>

</div>