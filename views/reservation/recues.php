<h2 class="section-title"><i class="bi bi-bell"></i> Reservations recues</h2>

<?php if (empty($reservations)): ?>
    <div class="alert alert-info">Aucune reservation pour le moment.</div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-hover bg-white">
            <thead>
                <tr>
                    <th>Passager</th>
                    <th>Trajet</th>
                    <th>Date depart</th>
                    <th>Places</th>
                    <th>Telephone</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $r): ?>
                    <tr>
                        <td>
                            <i class="bi bi-person"></i>
                            <?= htmlspecialchars($r['prenomPassager'] . ' ' . $r['nomPassager']) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($r['villeDepart']) ?>
                            <i class="bi bi-arrow-right"></i>
                            <?= htmlspecialchars($r['villeArrivee']) ?>
                        </td>
                        <td><?= date('d/m/Y H:i', strtotime($r['dateDepart'])) ?></td>
                        <td><?= $r['nbPlacesReservees'] ?></td>
                        <td><?= htmlspecialchars($r['telephone']) ?></td>
                        <td>
                            <span class="badge badge-statut-<?= str_replace(' ', '', $r['statut']) ?>">
                                <?= htmlspecialchars($r['statut']) ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($r['statut'] === 'En attente'): ?>
                                <a href="<?= BASE_URL ?>?controller=reservation&action=confirmer&id=<?= $r['idReservation'] ?>"
                                   class="btn btn-sm btn-success"
                                   onclick="return confirm('Confirmer cette reservation ?')">
                                    <i class="bi bi-check-circle"></i> Confirmer
                                </a>
                            <?php endif; ?>
                            <?php if ($r['statut'] === 'Confirmee'): ?>
                                <a href="<?= BASE_URL ?>?controller=reservation&action=terminer&id=<?= $r['idReservation'] ?>"
                                   class="btn btn-sm btn-secondary"
                                   onclick="return confirm('Marquer comme terminee ?')">
                                    <i class="bi bi-flag"></i> Terminer
                                </a>
                            <?php endif; ?>
                            <?php if ($r['statut'] !== 'Annulee' && $r['statut'] !== 'Terminee'): ?>
                                <a href="<?= BASE_URL ?>?controller=reservation&action=annuler&id=<?= $r['idReservation'] ?>"
                                   class="btn btn-sm btn-outline-danger"
                                   onclick="return confirm('Annuler la reservation ?')">
                                    <i class="bi bi-x-circle"></i>
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
