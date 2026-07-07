<section class="register-page">
    <div class="register-form">
        <h1>Inscription</h1>

    <?php if (!empty($errors)) : ?>
        <div class="error" role="alert">
            <?php foreach ($errors as $error) : ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

        <form action="index.php?action=register" method="POST">

            <label for="pseudo">Pseudo</label>
            <input type="text" id="pseudo" name="pseudo" required>

            <label for="email">Adresse email</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" class="btn-primary">S’inscrire</button>

        </form>

        <p class="login-link">
            Déjà inscrit ? <a href="index.php?action=login">Connectez-vous</a>
        </p>

    </div>

    <div class="register-image">
        <img src="assets/img/connection.webp" alt="Pile de livres illustrant la page d'inscription">
    </div>

</section>