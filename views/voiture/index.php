<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="section-title mb-0"><i class="bi bi-car-front"></i> Mes voitures</h2>
    <a href="<?= BASE_URL ?>?controller=voiture&action=create" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Ajouter une voiture
    </a>
</div>

<?php if (empty($voitures)): ?>
    <div class="alert alert-info">
        Vous n'avez pas encore enregistre de voiture.
        <a href="<?= BASE_URL ?>?controller=voiture&action=create">Ajouter ma premiere voiture</a>
    </div>
<?php else: ?>
    <div class="row g-3">
        <?php foreach ($voitures as $v): ?>
            <div class="col-md-4">
                <div class="card p-3">
                    <div class="d-flex justify-content-between mb-2">
                        <h5 class="mb-0">
                            <i class="bi bi-car-front-fill text-primary"></i>
                            <?= htmlspecialchars($v['marque']) ?>
                        </h5>
                        <span class="badge bg-secondary"><?= $v['placesDisponibles'] ?> places</span>
                    </div>
                    <p class="mb-1"><strong>Modele :</strong> <?= htmlspecialchars($v['modele']) ?></p>
                    <p class="mb-3"><strong>Plaque :</strong> <?= htmlspecialchars($v['plaque']) ?></p>
                    <div class="d-flex gap-2">
                        <a href="<?= BASE_URL ?>?controller=voiture&action=edit&id=<?= $v['idVoiture'] ?>"
                           class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i> Modifier</a>
                        <a href="<?= BASE_URL ?>?controller=voiture&action=delete&id=<?= $v['idVoiture'] ?>"
                           class="btn btn-sm btn-outline-danger"
                           onclick="return confirm('Supprimer cette voiture ?')">
                            <i class="bi bi-trash"></i> Supprimer
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
