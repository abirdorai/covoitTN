<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card p-4">
            <h3 class="mb-4"><i class="bi bi-plus-circle"></i> Ajouter une voiture</h3>

            <?php if (!empty($erreur)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($erreur) ?></div>
            <?php endif; ?>

            <form method="post" action="<?= BASE_URL ?>?controller=voiture&action=create">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Marque *</label>
                        <input type="text" name="marque" class="form-control" required placeholder="Ex: Peugeot">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Modele</label>
                        <input type="text" name="modele" class="form-control" placeholder="Ex: 208">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Plaque d'immatriculation *</label>
                        <input type="text" name="plaque" class="form-control" required placeholder="Ex: 123 TUN 4567">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Places disponibles *</label>
                        <input type="number" name="places" class="form-control" min="1" max="10" value="4" required>
                    </div>
                </div>
                <hr>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle"></i> Ajouter
                </button>
                <a href="<?= BASE_URL ?>?controller=voiture&action=index" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Annuler
                </a>
            </form>
        </div>
    </div>
</div>
