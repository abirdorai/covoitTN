<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card p-4">
            <h3 class="mb-4"><i class="bi bi-pencil"></i> Modifier le trajet</h3>

            <?php if (!empty($erreur)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($erreur) ?></div>
            <?php endif; ?>

            <form method="post" action="<?= BASE_URL ?>?controller=trajet&action=edit&id=<?= $trajet['idTrajet'] ?>">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Ville de depart *</label>
                        <input type="text" name="villeDepart" class="form-control" required
                               value="<?= htmlspecialchars($trajet['villeDepart']) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Ville d'arrivee *</label>
                        <input type="text" name="villeArrivee" class="form-control" required
                               value="<?= htmlspecialchars($trajet['villeArrivee']) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Date et heure de depart *</label>
                        <input type="datetime-local" name="dateDepart" class="form-control" required
                               value="<?= date('Y-m-d\TH:i', strtotime($trajet['dateDepart'])) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Prix par personne (DT) *</label>
                        <input type="number" name="prix" step="0.01" min="0" class="form-control" required
                               value="<?= htmlspecialchars($trajet['prixParPersonne']) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Statut</label>
                        <select name="statut" class="form-select">
                            <?php foreach (['Actif', 'Complet', 'Annule', 'Termine'] as $s): ?>
                                <option value="<?= $s ?>" <?= $trajet['statut'] === $s ? 'selected' : '' ?>>
                                    <?= $s ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <hr>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Enregistrer
                    </button>
                    <a href="<?= BASE_URL ?>?controller=trajet&action=mesTrajets" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
