<div class="auth-container">
    <div class="auth-box">
        <h1>Inscription</h1>

        <?php if (isset($errors) && !empty($errors)): ?>
            <div class="alert alert-error">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="/mini_mvc/public/register">
            <div class="form-group">
                <label for="nom">Nom complet *</label>
                <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($nom ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe * (min. 6 caractères)</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="password_confirm">Confirmer le mot de passe *</label>
                <input type="password" id="password_confirm" name="password_confirm" required>
            </div>

            <div class="form-group">
                <label for="adresse">Adresse</label>
                <textarea id="adresse" name="adresse" rows="3"><?= htmlspecialchars($adresse ?? '') ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary btn-block">S'inscrire</button>
        </form>

        <p class="auth-link">
            Déjà un compte ? <a href="/mini_mvc/public/login">Se connecter</a>
        </p>
    </div>
</div>
