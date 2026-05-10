<h2 class="page-title">Modifier mon profil</h2>

<div class="form-card">
    <?php if (!empty($erreur)): ?>
        <div class="flash-msg error mb-3">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <?= htmlspecialchars($erreur) ?>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= BASE_URL ?>?controller=profil&action=edit">
        <div class="row g-3 mb-3">
            <div class="col-6">
                <label class="form-label">Nom *</label>
                <input type="text" name="nom" class="form-control" required
                       value="<?= htmlspecialchars($user['nom']) ?>">
            </div>
            <div class="col-6">
                <label class="form-label">Prenom *</label>
                <input type="text" name="prenom" class="form-control" required
                       value="<?= htmlspecialchars($user['prenom']) ?>">
            </div>
            <div class="col-6">
                <label class="form-label">Email *</label>
                <input type="email" name="email" class="form-control" required
                       value="<?= htmlspecialchars($user['email']) ?>">
            </div>
            <div class="col-6">
                <label class="form-label">Telephone</label>
                <input type="text" name="telephone" class="form-control"
                       value="<?= htmlspecialchars($user['telephone'] ?? '') ?>">
            </div>
        </div>
        <div style="display:flex;gap:.75rem">
            <button type="submit" class="btn-r">
                <i class="bi bi-check-circle"></i> Enregistrer
            </button>
            <a href="<?= BASE_URL ?>?controller=profil&action=index" class="btn-g">Annuler</a>
        </div>
    </form>
</div>
