<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="section-title mb-0"><i class="bi bi-signpost-2"></i> Mes trajets</h2>
    <a href="<?= BASE_URL ?>?controller=trajet&action=create" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nouveau trajet
    </a>
</div>

<?php if (empty($trajets)): ?>
    <div class="alert alert-info">
        Vous n'avez pas encore propose de trajet.
        <a href="<?= BASE_URL ?>?controller=trajet&action=create">Proposer mon premier trajet</a>
    </div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-hover bg-white">
            <thead>
                <tr>
                    <th>Trajet</th>
                    <th>Date</th>
                    <th>Prix</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($trajets as $t): ?>
                    <tr>
                        <td>
                            <i class="bi bi-geo-alt-fill text-primary"></i>
                            <?= htmlspecialchars($t['villeDepart']) ?>
                            <i class="bi bi-arrow-right"></i>
                            <?= htmlspecialchars($t['villeArrivee']) ?>
                        </td>
                        <td><?= date('d/m/Y H:i', strtotime($t['dateDepart'])) ?></td>
                        <td><?= number_format($t['prixParPersonne'], 2) ?> DT</td>
                        <td>
                            <span class="badge badge-statut-<?= htmlspecialchars($t['statut']) ?>">
                                <?= htmlspecialchars($t['statut']) ?>
                            </span>
                        </td>
                        <td>
                            <a href="<?= BASE_URL ?>?controller=trajet&action=show&id=<?= $t['idTrajet'] ?>"
                               class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
                            <a href="<?= BASE_URL ?>?controller=trajet&action=edit&id=<?= $t['idTrajet'] ?>"
                               class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                            <a href="<?= BASE_URL ?>?controller=trajet&action=delete&id=<?= $t['idTrajet'] ?>"
                               class="btn btn-sm btn-outline-danger"
                               onclick="return confirm('Supprimer ce trajet ?')"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
