<h2 class="page-title">Mes reservations</h2>

<?php if (empty($reservations)): ?>
    <div class="empty-state">
        <i class="bi bi-bookmark"></i>
        <p>Vous n'avez encore effectue aucune reservation.</p>
        <a href="<?= BASE_URL ?>?controller=trajet&action=index" class="btn-r">
            <i class="bi bi-search"></i> Chercher un trajet
        </a>
    </div>
<?php else: ?>
    <div class="card">
        <div style="overflow-x:auto">
            <table class="tbl">
                <thead>
                    <tr>
                        <th>Trajet</th>
                        <th>Date</th>
                        <th>Conducteur</th>
                        <th>Places</th>
                        <th>Total</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservations as $r):
                        $stMap = [
                            'En attente' => 'bdg-amber',
                            'Confirme'   => 'bdg-green',
                            'Annule'     => 'bdg-grey',
                            'Terminee'   => 'bdg-purple',
                            'Confirmee'  => 'bdg-green',
                        ];
                        $stClass = $stMap[$r['statut']] ?? 'bdg-grey';
                    ?>
                        <tr>
                            <td style="font-weight:600">
                                <?= htmlspecialchars($r['villeDepart']) ?>
                                <i class="bi bi-arrow-right" style="color:var(--grey-text);font-size:.8rem"></i>
                                <?= htmlspecialchars($r['villeArrivee']) ?>
                            </td>
                            <td><?= date('d/m/Y H:i', strtotime($r['dateDepart'])) ?></td>
                            <td><?= htmlspecialchars($r['prenomConducteur'] . ' ' . $r['nomConducteur']) ?></td>
                            <td><?= $r['nbPlacesReservees'] ?></td>
                            <td><strong style="color:var(--red)"><?= number_format($r['prixParPersonne'] * $r['nbPlacesReservees'], 2) ?> DT</strong></td>
                            <td><span class="bdg <?= $stClass ?>"><?= htmlspecialchars($r['statut']) ?></span></td>
                            <td style="display:flex;gap:.35rem">
                                <?php if ($r['statut'] === 'En attente' || $r['statut'] === 'Confirmee' || $r['statut'] === 'Confirme'): ?>
                                    <a href="<?= BASE_URL ?>?controller=reservation&action=annuler&id=<?= $r['idReservation'] ?>"
                                       class="btn-ic r" title="Annuler"
                                       onclick="return confirm('Annuler la reservation ?')">
                                        <i class="bi bi-x-circle"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if ($r['statut'] === 'Terminee'): ?>
                                    <a href="<?= BASE_URL ?>?controller=avis&action=create&idReservation=<?= $r['idReservation'] ?>"
                                       class="btn-ic g" title="Laisser un avis">
                                        <i class="bi bi-star"></i>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>
