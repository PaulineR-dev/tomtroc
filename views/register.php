<?php
// views/register.php

?>

<section class="register-page">
    <div class="register-form">
        <h1>Inscription</h1>

        <form action="index.php?action=register" method="POST">

            <label for="pseudo">Pseudo</label>
            <input type="text" id="pseudo" name="pseudo" required>

            <label for="email">Adresse email</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" class="btn-primary">S’inscrire</button>

        </form>

        <?php if (!empty($error)) : ?>
            <p class="error" role="alert"><?= $error ?></p>
        <?php endif; ?>

        <p class="login-link">
            Déjà inscrit ? <a href="index.php?action=login">Connectez-vous</a>
        </p>

    </div>

    <div class="register-image">
        <img src="assets/img/connection.webp" alt="Pile de livres illustrant la page d'inscription">
    </div>

</div>
