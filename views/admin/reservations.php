<h2 class="page-title">Toutes les reservations</h2>

<p style="font-size:.88rem;color:var(--grey-text);margin-bottom:.75rem">
    <strong style="color:#111827"><?= count($reservations) ?></strong> reservation(s)
</p>

<div class="card">
    <div style="overflow-x:auto">
        <table class="tbl">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Passager</th>
                    <th>Conducteur</th>
                    <th>Trajet</th>
                    <th>Date</th>
                    <th>Places</th>
                    <th>Total</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $r):
                    $stMap = [
                        'En attente' => 'bdg-amber',
                        'Confirme'   => 'bdg-green',
                        'Annule'     => 'bdg-grey',
                        'Termine'    => 'bdg-purple',
                    ];
                    $stClass = $stMap[$r['statut']] ?? 'bdg-grey';
                ?>
                    <tr>
                        <td style="color:var(--grey-text);font-size:.82rem">#<?= $r['idReservation'] ?></td>
                        <td><strong><?= htmlspecialchars($r['prenomPassager'] . ' ' . $r['nomPassager']) ?></strong></td>
                        <td><?= htmlspecialchars($r['prenomConducteur'] . ' ' . $r['nomConducteur']) ?></td>
                        <td style="font-weight:600">
                            <?= htmlspecialchars($r['villeDepart']) ?>
                            <i class="bi bi-arrow-right" style="color:var(--grey-text);font-size:.8rem"></i>
                            <?= htmlspecialchars($r['villeArrivee']) ?>
                        </td>
                        <td><?= date('d/m/Y', strtotime($r['dateDepart'])) ?></td>
                        <td><?= $r['nbPlacesReservees'] ?></td>
                        <td><strong style="color:var(--red)"><?= number_format($r['prixParPersonne'] * $r['nbPlacesReservees'], 2) ?> DT</strong></td>
                        <td><span class="bdg <?= $stClass ?>"><?= htmlspecialchars($r['statut']) ?></span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
