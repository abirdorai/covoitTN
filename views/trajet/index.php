<h2 class="page-title">Recherche de trajets</h2>

<!-- Filtres -->
<div class="card mb-4">
    <div style="padding:1.25rem 1.5rem">
        <form method="get" action="<?= BASE_URL ?>">
            <input type="hidden" name="controller" value="trajet">
            <input type="hidden" name="action" value="index">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="field-label">Ville de depart</label>
                    <input type="text" name="villeDepart" class="form-control"
                           value="<?= htmlspecialchars($vd) ?>" placeholder="Ex: Tunis"
                           style="border:1.5px solid var(--border);border-radius:8px;padding:.6rem .85rem">
                </div>
                <div class="col-md-4">
                    <label class="field-label">Ville d'arrivee</label>
                    <input type="text" name="villeArrivee" class="form-control"
                           value="<?= htmlspecialchars($va) ?>" placeholder="Ex: Sousse"
                           style="border:1.5px solid var(--border);border-radius:8px;padding:.6rem .85rem">
                </div>
                <div class="col-md-3">
                    <label class="field-label">Date</label>
                    <input type="date" name="date" class="form-control"
                           value="<?= htmlspecialchars($date) ?>"
                           style="border:1.5px solid var(--border);border-radius:8px;padding:.6rem .85rem">
                </div>
                <div class="col-md-1" style="min-width:120px">
                    <button type="submit" class="btn-r w-100 justify-content-center">
                        <i class="bi bi-search"></i> Filtrer
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<p style="font-size:.88rem;color:var(--grey-text);margin-bottom:1rem">
    <strong style="color:#111827"><?= count($trajets) ?></strong> trajet(s) trouve(s)
</p>

<?php if (empty($trajets)): ?>
    <div class="empty-state">
        <i class="bi bi-signpost-2"></i>
        <p>Aucun trajet ne correspond a votre recherche.</p>
    </div>
<?php else: ?>
    <div style="display:flex;flex-direction:column;gap:.75rem">
        <?php foreach ($trajets as $t): ?>
            <div class="trajet-card">
                <div style="flex:1;min-width:0">
                    <div class="trajet-route">
                        <i class="bi bi-geo-alt-fill" style="color:var(--red);font-size:.9rem"></i>
                        <?= htmlspecialchars($t['villeDepart']) ?>
                        <i class="bi bi-arrow-right" style="font-size:.85rem;color:var(--grey-text)"></i>
                        <?= htmlspecialchars($t['villeArrivee']) ?>
                        <span style="margin-left:.5rem">
                            <?php
                            $stMap = [
                                'Disponible' => 'bdg-green',
                                'Complet'    => 'bdg-red',
                                'Annule'     => 'bdg-grey',
                                'Termine'    => 'bdg-purple',
                            ];
                            $stClass = $stMap[$t['statut']] ?? 'bdg-grey';
                            ?>
                            <span class="bdg <?= $stClass ?>"><?= htmlspecialchars($t['statut']) ?></span>
                        </span>
                    </div>
                    <div class="trajet-meta">
                        <span><i class="bi bi-calendar3"></i> <?= date('d/m/Y a H:i', strtotime($t['dateDepart'])) ?></span>
                        <span><i class="bi bi-person-circle"></i>
                            <?= htmlspecialchars($t['prenom'] . ' ' . $t['nom']) ?>
                            <span class="stars ms-1">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="bi bi-star<?= $i <= round($t['noteMoyenne']) ? '-fill' : '' ?>"></i>
                                <?php endfor; ?>
                            </span>
                        </span>
                        <span><i class="bi bi-people"></i> <?= $t['PlacesDisponibles'] ?> place(s)</span>
                    </div>
                </div>
                <div style="display:flex;align-items:center;gap:.75rem;flex-shrink:0">
                    <div class="trajet-price"><?= number_format($t['prixParPersonne'], 2) ?> DT</div>
                    <a href="<?= BASE_URL ?>?controller=trajet&action=show&id=<?= $t['idTrajet'] ?>" class="btn-o">
                        <i class="bi bi-eye"></i> Detail
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
