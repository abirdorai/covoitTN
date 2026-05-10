<h2 class="page-title"><i class="bi bi-bar-chart"></i> Rapport de statistiques</h2>

<!-- KPI row -->
<div class="stat-cards-row" style="grid-template-columns:repeat(3,1fr);margin-bottom:2rem">
    <div class="stat-card-new">
        <div class="stat-card-icon icon-green"></div>
        <div class="stat-card-body">
            <div class="stat-num"><?= number_format($chiffreAffaires, 0) ?></div>
            <div class="stat-lbl">DT - Chiffre d'affaires</div>
        </div>
    </div>
    <div class="stat-card-new">
        <div class="stat-card-icon icon-amber"></div>
        <div class="stat-card-body">
            <div class="stat-num"><?= $noteMoyenne ?>/5</div>
            <div class="stat-lbl">Note moyenne globale</div>
        </div>
    </div>
    <div class="stat-card-new">
        <div class="stat-card-icon icon-blue"></div>
        <div class="stat-card-body">
            <div class="stat-num"><?= count($topPassagers) ?></div>
            <div class="stat-lbl">Passagers actifs (top 5)</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Utilisateurs par role -->
    <div class="col-md-6">
        <div class="card card-body-pad">
            <h5 class="section-title"><i class="bi bi-people"></i> Utilisateurs par role</h5>
            <?php $totalU = array_sum(array_column($usersParRole, 'total')); ?>
            <?php foreach ($usersParRole as $u): ?>
                <?php $pct = $totalU > 0 ? round($u['total']*100/$totalU) : 0; ?>
                <div class="bar-row">
                    <div class="bar-label"><?= htmlspecialchars($u['role']) ?></div>
                    <div class="bar-track">
                        <div class="bar-fill" style="width:<?= max($pct,6) ?>%">
                            <?= $u['total'] ?> (<?= $pct ?>%)
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Trajets par statut -->
    <div class="col-md-6">
        <div class="card card-body-pad">
            <h5 class="section-title"><i class="bi bi-signpost-2"></i> Trajets par statut</h5>
            <?php $totalT = array_sum(array_column($trajetsParStatut, 'total')); ?>
            <?php foreach ($trajetsParStatut as $t): ?>
                <?php $pct = $totalT > 0 ? round($t['total']*100/$totalT) : 0; ?>
                <div class="bar-row">
                    <div class="bar-label"><?= htmlspecialchars($t['statut']) ?></div>
                    <div class="bar-track">
                        <div class="bar-fill" style="width:<?= max($pct,6) ?>%"><?= $t['total'] ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Reservations par statut -->
    <div class="col-md-6">
        <div class="card card-body-pad">
            <h5 class="section-title"><i class="bi bi-bookmark"></i> Reservations par statut</h5>
            <?php $totalR = array_sum(array_column($resaParStatut, 'total')); ?>
            <?php foreach ($resaParStatut as $r): ?>
                <?php $pct = $totalR > 0 ? round($r['total']*100/$totalR) : 0; ?>
                <div class="bar-row">
                    <div class="bar-label"><?= htmlspecialchars($r['statut']) ?></div>
                    <div class="bar-track">
                        <div class="bar-fill" style="width:<?= max($pct,6) ?>%"><?= $r['total'] ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Top villes de depart -->
    <div class="col-md-6">
        <div class="card card-body-pad">
            <h5 class="section-title"><i class="bi bi-geo-alt"></i> Top villes de depart</h5>
            <?php $maxV = max(array_column($trajetsParVille, 'total') ?: [1]); ?>
            <?php foreach ($trajetsParVille as $v): ?>
                <?php $pct = round($v['total']*100/$maxV); ?>
                <div class="bar-row">
                    <div class="bar-label"><?= htmlspecialchars($v['villeDepart']) ?></div>
                    <div class="bar-track">
                        <div class="bar-fill" style="width:<?= max($pct,6) ?>%"><?= $v['total'] ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Top passagers -->
    <div class="col-md-6">
        <div class="card card-body-pad">
            <h5 class="section-title"><i class="bi bi-trophy"></i> Top 5 passagers actifs</h5>
            <table class="tbl">
                <thead>
                    <tr>
                        <th>Rang</th>
                        <th>Nom</th>
                        <th style="text-align:right">Reservations</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($topPassagers as $i => $p): ?>
                        <tr>
                            <td>
                                <?php if ($i === 0): ?>
                                    <i class="bi bi-trophy-fill" style="color:#f59e0b"></i>
                                <?php else: ?>
                                    <?= $i + 1 ?>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($p['prenom'] . ' ' . $p['nom']) ?></td>
                            <td style="text-align:right">
                                <strong><?= $p['nbReservations'] ?></strong>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Repartition des notes -->
    <div class="col-md-6">
        <div class="card card-body-pad">
            <h5 class="section-title"><i class="bi bi-star"></i> Repartition des notes</h5>
            <?php $totalN = array_sum(array_column($repartitionNotes, 'total')); ?>
            <?php for ($n = 5; $n >= 1; $n--):
                $cnt = 0;
                foreach ($repartitionNotes as $rn) {
                    if ((int)$rn['note'] === $n) { $cnt = $rn['total']; break; }
                }
                $pct = $totalN > 0 ? round($cnt*100/$totalN) : 0;
            ?>
                <div class="bar-row">
                    <div class="bar-label" style="color:#f59e0b">
                        <?= str_repeat('★', $n) ?><span style="color:var(--grey-text)"> (<?= $n ?>)</span>
                    </div>
                    <div class="bar-track">
                        <div class="bar-fill" style="width:<?= max($pct,4) ?>%;background:linear-gradient(90deg,#f59e0b,#fcd34d)">
                            <?= $cnt ?>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </div>
</div>

<div style="text-align:center;margin:2rem 0">
    <button onclick="window.print()" class="btn-g">
        <i class="bi bi-printer"></i> Imprimer le rapport
    </button>
</div>
