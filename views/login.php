<?php
// views/login.php
?>

<section class="login-page">
    <div class="login-form">
        <h1>Connexion</h1>

        <form action="index.php?action=login" method="POST">

            <label for="email">Adresse email</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" class="btn-primary">Se connecter</button>

        </form>

        <?php if (!empty($error)) : ?>
            <p class="error" role="alert"><?= $error ?></p>
        <?php endif; ?>

        <p class="login-link">
            Pas de compte ? <a href="index.php?action=register">Inscrivez-vous</a>
        </p>
    </div>

    <div class="login-image">
        <img src="assets/img/connection.webp" alt="Pile de livres illustrant la page de connexion">
    </div>
</section>
