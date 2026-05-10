<div class="auth-page">
    <div class="auth-card">
        <h2>Connexion</h2>
        <p class="sub">Bienvenue ! Connectez-vous a votre compte.</p>

        <?php if (!empty($erreur)): ?>
            <div class="flash-msg error mb-3">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <?= htmlspecialchars($erreur) ?>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= BASE_URL ?>?controller=auth&action=login">
            <div class="mb-3">
                <label class="form-label fw-semibold" style="font-size:.875rem">Email</label>
                <input type="email" name="email" class="form-control" required autofocus placeholder="vous@exemple.tn">
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold" style="font-size:.875rem">Mot de passe</label>
                <input type="password" name="motDepasse" class="form-control" required placeholder="•••••••">
            </div>
            <button type="submit" class="btn-r w-100 justify-content-center" style="width:100%">
                <i class="bi bi-box-arrow-in-right"></i> Se connecter
            </button>
        </form>

        <div style="text-align:center;margin-top:1.25rem;font-size:.88rem;color:var(--grey-text)">
            Pas encore de compte ?
            <a href="<?= BASE_URL ?>?controller=auth&action=register"
               style="color:var(--red);font-weight:600;text-decoration:none">S'inscrire</a>
        </div>

    </div>
</div>
