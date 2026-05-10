<h2 class="page-title">Changer mon mot de passe</h2>

<div class="form-card">
    <?php if (!empty($erreur)): ?>
        <div class="flash-msg error mb-3">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <?= htmlspecialchars($erreur) ?>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= BASE_URL ?>?controller=profil&action=changerMdp">
        <div class="mb-3">
            <label class="form-label">Ancien mot de passe</label>
            <input type="password" name="ancien" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Nouveau mot de passe</label>
            <input type="password" name="nouveau" class="form-control" required minlength="6">
        </div>
        <div class="mb-4">
            <label class="form-label">Confirmer le nouveau</label>
            <input type="password" name="confirmer" class="form-control" required minlength="6">
        </div>
        <div style="display:flex;gap:.75rem">
            <button type="submit" class="btn-r">
                <i class="bi bi-check-circle"></i> Modifier
            </button>
            <a href="<?= BASE_URL ?>?controller=profil&action=index" class="btn-g">Annuler</a>
        </div>
    </form>
</div>
