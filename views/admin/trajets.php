<h2 class="page-title">Gestion des trajets</h2>

<p style="font-size:.88rem;color:var(--grey-text);margin-bottom:.75rem">
    <strong style="color:#111827"><?= count($trajets) ?></strong> trajet(s)
</p>

<div class="card">
    <div style="overflow-x:auto">
        <table class="tbl">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Conducteur</th>
                    <th>Trajet</th>
                    <th>Date</th>
                    <th>Prix</th>
                    <th>Places dispo</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($trajets as $t):
                    $stMap = [
                        'Disponible' => 'bdg-green',
                        'Complet'    => 'bdg-red',
                        'Annule'     => 'bdg-grey',
                        'Termine'    => 'bdg-purple',
                    ];
                    $stClass = $stMap[$t['statut']] ?? 'bdg-grey';
                ?>
                    <tr>
                        <td style="color:var(--grey-text);font-size:.82rem">#<?= $t['idTrajet'] ?></td>
                        <td><strong><?= htmlspecialchars($t['prenom'] . ' ' . $t['nom']) ?></strong></td>
                        <td style="font-weight:600">
                            <?= htmlspecialchars($t['villeDepart']) ?>
                            <i class="bi bi-arrow-right" style="color:var(--grey-text);font-size:.8rem"></i>
                            <?= htmlspecialchars($t['villeArrivee']) ?>
                        </td>
                        <td><?= date('d/m/Y H:i', strtotime($t['dateDepart'])) ?></td>
                        <td><strong style="color:var(--red)"><?= number_format($t['prixParPersonne'], 2) ?> DT</strong></td>
                        <td><?= $t['nbPlacesDisponibles'] ?></td>
                        <td><span class="bdg <?= $stClass ?>"><?= htmlspecialchars($t['statut']) ?></span></td>
                        <td style="display:flex;gap:.35rem">
                            <a href="<?= BASE_URL ?>?controller=trajet&action=show&id=<?= $t['idTrajet'] ?>"
                               class="btn-ic b" title="Voir"><i class="bi bi-eye"></i></a>
                            <a href="<?= BASE_URL ?>?controller=admin&action=deleteTrajet&id=<?= $t['idTrajet'] ?>"
                               class="btn-ic r" title="Supprimer"
                               onclick="return confirm('Supprimer ce trajet ?')">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
