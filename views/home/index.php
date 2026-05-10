<!-- ===== HERO ===== -->
<section class="hero-section">
    <h1>
        Voyagez <span class="accent">ensemble</span>,<br>
        depensez moins
    </h1>
    <p class="hero-sub">
        La plateforme de covoiturage tunisienne. Trouvez ou proposez<br>
        un trajet en quelques clics.
    </p>

    <!-- Search Card -->
    <div class="hero-search-card">
        <form method="get" action="<?= BASE_URL ?>">
            <input type="hidden" name="controller" value="trajet">
            <input type="hidden" name="action" value="index">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="field-label">Depart</label>
                    <input type="text" name="villeDepart" class="form-control" placeholder="Ex: Tunis">
                </div>
                <div class="col-md-4">
                    <label class="field-label">Arrivee</label>
                    <input type="text" name="villeArrivee" class="form-control" placeholder="Ex: Sfax">
                </div>
                <div class="col-md-3">
                    <label class="field-label">Date</label>
                    <input type="date" name="date" class="form-control">
                </div>
                <div class="col-md-1" style="min-width:120px">
                    <button type="submit" class="btn-search">Rechercher</button>
                </div>
            </div>
        </form>
    </div>
</section>

<!-- ===== STATS ===== -->
<div class="page-container" style="padding-top:2.5rem">
    <div class="stat-cards-row" style="grid-template-columns:repeat(3,1fr);max-width:620px;margin:0 auto 2.5rem">
        <div class="stat-card-new">
            <div class="stat-card-icon icon-red"></div>
            <div class="stat-card-body">
                <div class="stat-num"><?= $totalTrajets ?></div>
                <div class="stat-lbl">Trajets</div>
            </div>
        </div>
        <div class="stat-card-new">
            <div class="stat-card-icon icon-blue"></div>
            <div class="stat-card-body">
                <div class="stat-num"><?= count($trajets) ?></div>
                <div class="stat-lbl">A venir</div>
            </div>
        </div>
        <div class="stat-card-new">
            <div class="stat-card-icon icon-amber"></div>
            <div class="stat-card-body">
                <div class="stat-num"><?= $noteMoyenne ?>/5</div>
                <div class="stat-lbl">Note moy.</div>
            </div>
        </div>
    </div>

    <!-- ===== PROCHAINS TRAJETS ===== -->
    <h2 class="section-title">Prochains trajets disponibles</h2>

    <?php if (empty($trajets)): ?>
        <div class="empty-state">
            <i class="bi bi-signpost-2"></i>
            <p>Aucun trajet disponible pour le moment.</p>
        </div>
    <?php else: ?>
        <div style="display:flex;flex-direction:column;gap:.75rem">
            <?php foreach (array_slice($trajets, 0, 6) as $t): ?>
                <div class="trajet-card">
                    <div style="flex:1;min-width:0">
                        <div class="trajet-route">
                            <i class="bi bi-geo-alt-fill" style="color:var(--red);font-size:.9rem"></i>
                            <?= htmlspecialchars($t['villeDepart']) ?>
                            <i class="bi bi-arrow-right" style="font-size:.85rem;color:var(--grey-text)"></i>
                            <?= htmlspecialchars($t['villeArrivee']) ?>
                        </div>
                        <div class="trajet-meta">
                            <span><i class="bi bi-calendar3"></i> <?= date('d/m/Y H:i', strtotime($t['dateDepart'])) ?></span>
                            <span><i class="bi bi-person-circle"></i>
                                <?= htmlspecialchars($t['prenom'] . ' ' . $t['nom']) ?>
                                <span class="stars ms-1">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="bi bi-star<?= $i <= round($t['noteMoyenne']) ? '-fill' : '' ?>"></i>
                                    <?php endfor; ?>
                                </span>
                            </span>
                            <span><i class="bi bi-people"></i> <?= $t['nbPlacesDisponibles'] ?> place(s)</span>
                        </div>
                    </div>
                    <div style="display:flex;align-items:center;gap:.75rem;flex-shrink:0">
                        <div class="trajet-price"><?= number_format($t['prixParPersonne'], 2) ?> DT</div>
                        <a href="<?= BASE_URL ?>?controller=trajet&action=show&id=<?= $t['idTrajet'] ?>"
                           class="btn-o" style="white-space:nowrap">
                            <i class="bi bi-eye"></i> Detail
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div style="text-align:center;margin-top:1.5rem">
            <a href="<?= BASE_URL ?>?controller=trajet&action=index" class="btn-r">
                Voir tous les trajets <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    <?php endif; ?>
</div>
