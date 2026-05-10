<h2 class="page-title">Gestion des conducteurs</h2>

<div class="card">
    <div style="overflow-x:auto">
        <table class="tbl">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Conducteur</th>
                    <th>Email</th>
                    <th>Telephone</th>
                    <th>Note</th>
                    <th>Permis</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($conducteurs as $c): ?>
                    <tr>
                        <td style="color:var(--grey-text);font-size:.82rem">#<?= $c['idConducteur'] ?></td>
                        <td><strong><?= htmlspecialchars($c['prenom'] . ' ' . $c['nom']) ?></strong></td>
                        <td><?= htmlspecialchars($c['email']) ?></td>
                        <td><?= htmlspecialchars($c['telephone'] ?? '-') ?></td>
                        <td>
                            <span class="stars">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="bi bi-star<?= $i <= round($c['noteMoyenne']) ? '-fill' : '' ?>"></i>
                                <?php endfor; ?>
                            </span>
                            <span style="font-size:.8rem;color:var(--grey-text);margin-left:.25rem">
                                <?= number_format($c['noteMoyenne'], 1) ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($c['permisValide']): ?>
                                <span class="bdg bdg-green"><i class="bi bi-check-circle"></i> Valide</span>
                            <?php else: ?>
                                <span class="bdg bdg-amber"><i class="bi bi-clock"></i> En attente</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!$c['permisValide']): ?>
                                <a href="<?= BASE_URL ?>?controller=admin&action=validerPermis&id=<?= $c['idConducteur'] ?>"
                                   class="btn-ic g" title="Valider le permis"
                                   onclick="return confirm('Valider le permis de ce conducteur ?')">
                                    <i class="bi bi-check-circle"></i>
                                </a>
                            <?php else: ?>
                                <span style="font-size:.8rem;color:var(--grey-text)">Validé</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
