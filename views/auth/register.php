<div class="auth-page">
    <div class="auth-card" style="max-width:560px">
        <h2>Inscription</h2>
        <p class="sub">Creez votre compte en quelques secondes.</p>

        <?php if (!empty($erreur)): ?>
            <div class="flash-msg error mb-3">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <?= htmlspecialchars($erreur) ?>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= BASE_URL ?>?controller=auth&action=register">
            <div class="row g-3">
                <div class="col-6">
                    <label class="form-label fw-semibold" style="font-size:.875rem">Nom *</label>
                    <input type="text" name="nom" class="form-control" required>
                </div>
                <div class="col-6">
                    <label class="form-label fw-semibold" style="font-size:.875rem">Prenom *</label>
                    <input type="text" name="prenom" class="form-control" required>
                </div>
                <div class="col-6">
                    <label class="form-label fw-semibold" style="font-size:.875rem">Email *</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="col-6">
                    <label class="form-label fw-semibold" style="font-size:.875rem">Telephone</label>
                    <input type="text" name="telephone" class="form-control">
                </div>
                <div class="col-6">
                    <label class="form-label fw-semibold" style="font-size:.875rem">Mot de passe *</label>
                    <input type="password" name="motDepasse" class="form-control" required minlength="6">
                </div>
                <div class="col-6">
                    <label class="form-label fw-semibold" style="font-size:.875rem">Confirmer *</label>
                    <input type="password" name="confirmMdp" class="form-control" required minlength="6">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold" style="font-size:.875rem">Je m'inscris en tant que *</label>
                    <div style="display:flex;gap:1rem;margin-top:.35rem">
                        <label style="display:flex;align-items:center;gap:.4rem;cursor:pointer;font-size:.9rem">
                            <input type="radio" name="role" value="Passager" checked style="accent-color:var(--red)">
                            <i class="bi bi-person"></i> Passager
                        </label>
                        <label style="display:flex;align-items:center;gap:.4rem;cursor:pointer;font-size:.9rem">
                            <input type="radio" name="role" value="Conducteur" style="accent-color:var(--red)">
                            <i class="bi bi-car-front"></i> Conducteur
                        </label>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn-r mt-4" style="width:100%;justify-content:center">
                <i class="bi bi-check-circle"></i> Creer mon compte
            </button>
        </form>

        <div style="text-align:center;margin-top:1.1rem;font-size:.88rem;color:var(--grey-text)">
            Deja inscrit ?
            <a href="<?= BASE_URL ?>?controller=auth&action=login"
               style="color:var(--red);font-weight:600;text-decoration:none">Se connecter</a>
        </div>
    </div>
</div>
