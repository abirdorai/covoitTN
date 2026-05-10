<div class="row">
    <div class="col-md-8">
        <div class="card p-4">
            <div class="d-flex justify-content-between mb-3">
                <h3>
                    <i class="bi bi-geo-alt-fill text-primary"></i>
                    <?= htmlspecialchars($trajet['villeDepart']) ?>
                    <i class="bi bi-arrow-right"></i>
                    <?= htmlspecialchars($trajet['villeArrivee']) ?>
                </h3>
                <span class="badge badge-statut-<?= htmlspecialchars($trajet['statut']) ?> fs-6">
                    <?= htmlspecialchars($trajet['statut']) ?>
                </span>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-6">
                    <p><strong><i class="bi bi-calendar"></i> Date de depart :</strong><br>
                        <?= date('l d F Y a H:i', strtotime($trajet['dateDepart'])) ?>
                    </p>
                    <p><strong><i class="bi bi-cash"></i> Prix par personne :</strong><br>
                        <span class="fs-3 text-success"><?= number_format($trajet['prixParPersonne'], 2) ?> DT</span>
                    </p>
                </div>
                <div class="col-md-6">
                    <p><strong><i class="bi bi-people"></i> Places reservees :</strong><br>
                        <?= $placesReservees ?> place(s)
                    </p>
                </div>
            </div>

            <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'Passager' && $trajet['statut'] === 'Actif'): ?>
                <hr>
                <a href="<?= BASE_URL ?>?controller=reservation&action=create&idTrajet=<?= $trajet['idTrajet'] ?>"
                   class="btn btn-success btn-lg">
                    <i class="bi bi-bookmark-plus"></i> Reserver ce trajet
                </a>
            <?php elseif (!isset($_SESSION['user'])): ?>
                <hr>
                <div class="alert alert-warning mb-0">
                    <i class="bi bi-info-circle"></i>
                    <a href="<?= BASE_URL ?>?controller=auth&action=login">Connectez-vous</a>
                    en tant que passager pour reserver ce trajet.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-4">
            <h5><i class="bi bi-person-vcard"></i> Conducteur</h5>
            <hr>
            <div class="text-center mb-3">
                <div class="avatar-circle mx-auto mb-2">
                    <?= strtoupper(substr($trajet['prenom'], 0, 1) . substr($trajet['nom'], 0, 1)) ?>
                </div>
                <h5 class="mb-0">
                    <?= htmlspecialchars($trajet['prenom'] . ' ' . $trajet['nom']) ?>
                </h5>
                <p class="stars mb-1">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <i class="bi bi-star<?= $i <= round($trajet['noteMoyenne']) ? '-fill' : '' ?>"></i>
                    <?php endfor; ?>
                    <span class="text-muted small">(<?= $trajet['noteMoyenne'] ?>/5)</span>
                </p>
                <?php if ($trajet['permisValide']): ?>
                    <span class="badge bg-success"><i class="bi bi-check-circle"></i> Permis valide</span>
                <?php else: ?>
                    <span class="badge bg-warning"><i class="bi bi-exclamation-circle"></i> Permis non valide</span>
                <?php endif; ?>
            </div>
            <?php if (isset($_SESSION['user'])): ?>
                <ul class="list-unstyled small">
                    <li><i class="bi bi-envelope"></i> <?= htmlspecialchars($trajet['email']) ?></li>
                    <li><i class="bi bi-telephone"></i> <?= htmlspecialchars($trajet['telephone']) ?></li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="<?= BASE_URL ?>?controller=trajet&action=index" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Retour aux trajets
    </a>
</div>
