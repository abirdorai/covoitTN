<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card p-4">
            <h3 class="mb-4"><i class="bi bi-star"></i> Laisser un avis</h3>

            <?php if (!empty($erreur)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($erreur) ?></div>
            <?php endif; ?>

            <div class="alert alert-info">
                Trajet : <strong><?= htmlspecialchars($resa['villeDepart']) ?>
                <i class="bi bi-arrow-right"></i>
                <?= htmlspecialchars($resa['villeArrivee']) ?></strong>
            </div>

            <form method="post" action="<?= BASE_URL ?>?controller=avis&action=create&idReservation=<?= $resa['idReservation'] ?>">
                <div class="mb-3">
                    <label class="form-label">Note *</label>
                    <select name="note" class="form-select" required>
                        <option value="">-- Choisir une note --</option>
                        <?php for ($i = 5; $i >= 1; $i--): ?>
                            <option value="<?= $i ?>"><?= str_repeat('★', $i) ?> (<?= $i ?>/5)</option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Commentaire</label>
                    <textarea name="commentaire" class="form-control" rows="4"
                              placeholder="Partagez votre experience..."></textarea>
                </div>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle"></i> Publier mon avis
                </button>
                <a href="<?= BASE_URL ?>?controller=reservation&action=mesReservations" class="btn btn-secondary">
                    Annuler
                </a>
            </form>
        </div>
    </div>
</div>
