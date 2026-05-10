<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card p-4">
            <h3 class="mb-4"><i class="bi bi-pencil"></i> Modifier la voiture</h3>

            <?php if (!empty($erreur)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($erreur) ?></div>
            <?php endif; ?>

            <form method="post" action="<?= BASE_URL ?>?controller=voiture&action=edit&id=<?= $voiture['idVoiture'] ?>">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Marque *</label>
                        <input type="text" name="marque" class="form-control" required
                               value="<?= htmlspecialchars($voiture['marque']) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Modele</label>
                        <input type="text" name="modele" class="form-control"
                               value="<?= htmlspecialchars($voiture['modele']) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Plaque *</label>
                        <input type="text" name="plaque" class="form-control" required
                               value="<?= htmlspecialchars($voiture['plaque']) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Places disponibles *</label>
                        <input type="number" name="places" class="form-control" min="1" max="10" required
                               value="<?= htmlspecialchars($voiture['placesDisponibles']) ?>">
                    </div>
                </div>
                <hr>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle"></i> Enregistrer
                </button>
                <a href="<?= BASE_URL ?>?controller=voiture&action=index" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Annuler
                </a>
            </form>
        </div>
    </div>
</div>
