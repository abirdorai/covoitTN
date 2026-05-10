<h2 class="section-title"><i class="bi bi-star"></i> Avis des passagers</h2>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-number"><?= $moyenne ?>/5</div>
            <div class="stat-label">Note moyenne globale</div>
            <div class="stars mt-2">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <i class="bi bi-star<?= $i <= round($moyenne) ? '-fill' : '' ?>"></i>
                <?php endfor; ?>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card p-4 h-100">
            <h5>Repartition des notes</h5>
            <?php
                $total = array_sum(array_column($repart, 'total'));
                $byNote = [];
                foreach ($repart as $r) { $byNote[$r['note']] = $r['total']; }
                for ($n = 5; $n >= 1; $n--):
                    $cnt = $byNote[$n] ?? 0;
                    $pct = $total > 0 ? round($cnt * 100 / $total) : 0;
            ?>
                <div class="bar-chart-row">
                    <div class="bar-chart-label">
                        <?= $n ?> <i class="bi bi-star-fill text-warning"></i>
                    </div>
                    <div class="bar-chart-bar">
                        <div class="bar-chart-fill" style="width: <?= max($pct, 5) ?>%;">
                            <?= $cnt ?>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </div>
</div>

<h4 class="mb-3">Tous les avis</h4>

<?php if (empty($avis)): ?>
    <div class="alert alert-info">Aucun avis pour le moment.</div>
<?php else: ?>
    <div class="row g-3">
        <?php foreach ($avis as $a): ?>
            <div class="col-md-6">
                <div class="card p-3">
                    <div class="d-flex justify-content-between mb-2">
                        <strong>
                            <i class="bi bi-person-circle"></i>
                            <?= htmlspecialchars($a['prenomPassager'] . ' ' . $a['nomPassager']) ?>
                        </strong>
                        <span class="stars">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class="bi bi-star<?= $i <= $a['note'] ? '-fill' : '' ?>"></i>
                            <?php endfor; ?>
                        </span>
                    </div>
                    <p class="text-muted small mb-2">
                        Trajet : <?= htmlspecialchars($a['villeDepart']) ?>
                        <i class="bi bi-arrow-right"></i>
                        <?= htmlspecialchars($a['villeArrivee']) ?>
                        - Conducteur : <?= htmlspecialchars($a['prenomConducteur'] . ' ' . $a['nomConducteur']) ?>
                    </p>
                    <p class="mb-1">
                        <i class="bi bi-quote"></i>
                        <?= htmlspecialchars($a['commentaire']) ?>
                    </p>
                    <p class="text-muted small mb-0">
                        <?= date('d/m/Y', strtotime($a['dateAvis'])) ?>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
