<section class="profil-page">
    <h1>Mon profil - version test du fonctionnement de la page</h1>

    <p><strong>Pseudo :</strong> <?= htmlspecialchars($user['username']) ?></p>
    <p><strong>Email :</strong> <?= htmlspecialchars($user['email']) ?></p>

    <p><a href="index.php?action=logout">Se déconnecter</a></p>
</section>
