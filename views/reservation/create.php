<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card p-4">
            <h3 class="mb-4"><i class="bi bi-bookmark-plus"></i> Reserver le trajet</h3>

            <?php if (!empty($erreur)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($erreur) ?></div>
            <?php endif; ?>

            <div class="alert alert-info">
                <strong><?= htmlspecialchars($trajet['villeDepart']) ?></strong>
                <i class="bi bi-arrow-right"></i>
                <strong><?= htmlspecialchars($trajet['villeArrivee']) ?></strong><br>
                <i class="bi bi-calendar"></i> <?= date('d/m/Y H:i', strtotime($trajet['dateDepart'])) ?><br>
                <i class="bi bi-cash"></i> <?= number_format($trajet['prixParPersonne'], 2) ?> DT par personne
            </div>

            <form method="post" action="<?= BASE_URL ?>?controller=reservation&action=create&idTrajet=<?= $trajet['idTrajet'] ?>">
                <div class="mb-3">
                    <label class="form-label">Nombre de places</label>
                    <input type="number" name="nbPlaces" class="form-control" min="1" max="10" value="1" required>
                </div>

                <button type="submit" class="btn btn-success w-100">
                    <i class="bi bi-check-circle"></i> Confirmer la reservation
                </button>
                <a href="<?= BASE_URL ?>?controller=trajet&action=show&id=<?= $trajet['idTrajet'] ?>"
                   class="btn btn-outline-secondary w-100 mt-2">
                    <i class="bi bi-x-circle"></i> Annuler
                </a>
            </form>
        </div>
    </div>
</div>
