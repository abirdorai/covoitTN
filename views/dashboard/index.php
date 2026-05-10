<?php $role = $_SESSION['user']['role']; ?>

<h2 class="page-title">
    Bonjour
    <span style="color:var(--red)"><?= htmlspecialchars($_SESSION['user']['prenom']) ?></span>,
    bienvenue sur votre espace
</h2>

<!-- ===== STAT CARDS ===== -->
<div class="stat-cards-row">

    <?php if ($role === 'Conducteur'): ?>
        <!-- Mes trajets -->
        <div class="stat-card-new">
            <div class="stat-card-icon icon-red"></div>
            <div class="stat-card-body">
                <div class="stat-num"><?= $mesTrajets ?></div>
                <div class="stat-lbl">Mes trajets</div>
            </div>
        </div>
        <!-- Mes reservations recues -->
        <div class="stat-card-new">
            <div class="stat-card-icon icon-blue"></div>
            <div class="stat-card-body">
                <div class="stat-num"><?= $mesResas ?></div>
                <div class="stat-lbl">Mes reservations</div>
            </div>
        </div>
        <!-- Trajets disponibles -->
        <div class="stat-card-new">
            <div class="stat-card-icon icon-green"></div>
            <div class="stat-card-body">
                <div class="stat-num"><?= $disponibes ?></div>
                <div class="stat-lbl">Trajets disponibles</div>
            </div>
        </div>
        <!-- Note moyenne -->
        <div class="stat-card-new">
            <div class="stat-card-icon icon-amber"></div>
            <div class="stat-card-body">
                <div class="stat-num"><?= $noteMoyenne ?></div>
                <div class="stat-lbl">Note moyenne</div>
            </div>
        </div>

    <?php elseif ($role === 'Passager'): ?>
        <!-- Mes reservations -->
        <div class="stat-card-new">
            <div class="stat-card-icon icon-red"></div>
            <div class="stat-card-body">
                <div class="stat-num"><?= $mesResas ?></div>
                <div class="stat-lbl">Mes reservations</div>
            </div>
        </div>
        <!-- Trajets disponibles -->
        <div class="stat-card-new">
            <div class="stat-card-icon icon-blue"></div>
            <div class="stat-card-body">
                <div class="stat-num"><?= $disponibes ?></div>
                <div class="stat-lbl">Trajets disponibles</div>
            </div>
        </div>
        <!-- Placeholder -->
        <div class="stat-card-new">
            <div class="stat-card-icon icon-green"></div>
            <div class="stat-card-body">
                <div class="stat-num">—</div>
                <div class="stat-lbl">Trajets a venir</div>
            </div>
        </div>
        <!-- Note moyenne -->
        <div class="stat-card-new">
            <div class="stat-card-icon icon-amber"></div>
            <div class="stat-card-body">
                <div class="stat-num"><?= $noteMoyenne ?></div>
                <div class="stat-lbl">Note moyenne</div>
            </div>
        </div>

    <?php else: /* Admin */ ?>
        <div class="stat-card-new">
            <div class="stat-card-icon icon-red"></div>
            <div class="stat-card-body">
                <div class="stat-num"><?= $disponibes ?></div>
                <div class="stat-lbl">Trajets disponibles</div>
            </div>
        </div>
        <div class="stat-card-new">
            <div class="stat-card-icon icon-blue"></div>
            <div class="stat-card-body">
                <div class="stat-num">—</div>
                <div class="stat-lbl">Mes reservations</div>
            </div>
        </div>
        <div class="stat-card-new">
            <div class="stat-card-icon icon-green"></div>
            <div class="stat-card-body">
                <div class="stat-num">—</div>
                <div class="stat-lbl">Trajets</div>
            </div>
        </div>
        <div class="stat-card-new">
            <div class="stat-card-icon icon-amber"></div>
            <div class="stat-card-body">
                <div class="stat-num"><?= $noteMoyenne ?></div>
                <div class="stat-lbl">Note moyenne</div>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- ===== DERNIERS TRAJETS DISPONIBLES ===== -->
<div class="card">
    <div class="card-body-pad">
        <h5 class="section-title">Derniers trajets disponibles</h5>

        <?php if (empty($derniersTrajets)): ?>
            <div class="empty-state">
                <i class="bi bi-signpost-2"></i>
                <p>Aucun trajet disponible pour le moment.</p>
            </div>
        <?php else: ?>
            <table class="tbl">
                <thead>
                    <tr>
                        <th>Trajet</th>
                        <th>Date</th>
                        <th>Conducteur</th>
                        <th>Places</th>
                        <th>Prix</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($derniersTrajets as $t): ?>
                        <tr>
                            <td style="font-weight:700">
                                <i class="bi bi-geo-alt-fill" style="color:var(--red);margin-right:.3rem"></i>
                                <?= htmlspecialchars($t['villeDepart']) ?>
                                <i class="bi bi-arrow-right" style="color:var(--grey-text);font-size:.8rem;margin:0 .25rem"></i>
                                <?= htmlspecialchars($t['villeArrivee']) ?>
                            </td>
                            <td><?= date('d/m/Y H:i', strtotime($t['dateDepart'])) ?></td>
                            <td>
                                <?= htmlspecialchars($t['prenom'] . ' ' . $t['nom']) ?>
                                <span class="stars ms-1">
                                    <?php $n = round($t['noteConducteur']); for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="bi bi-star<?= $i <= $n ? '-fill' : '' ?>"></i>
                                    <?php endfor; ?>
                                </span>
                            </td>
                            <td><?= $t['nbPlacesDisponibles'] ?></td>
                            <td><strong style="color:var(--red)"><?= number_format($t['prixParPersonne'], 2) ?> DT</strong></td>
                            <td>
                                <a href="<?= BASE_URL ?>?controller=trajet&action=show&id=<?= $t['idTrajet'] ?>"
                                   class="btn-o" style="padding:.35rem .8rem;font-size:.82rem">
                                    <i class="bi bi-eye"></i> Voir
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div style="margin-top:1rem">
                <a href="<?= BASE_URL ?>?controller=trajet&action=index" class="btn-r">
                    Voir tous les trajets <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- ===== ACTIONS RAPIDES ===== -->
<div style="margin-top:1.5rem">
    <h5 class="section-title">Actions rapides</h5>
    <div style="display:flex;gap:.75rem;flex-wrap:wrap">
        <?php if ($role === 'Conducteur'): ?>
            <a href="<?= BASE_URL ?>?controller=trajet&action=create" class="btn-r">
                <i class="bi bi-plus-circle"></i> Proposer un trajet
            </a>
            <a href="<?= BASE_URL ?>?controller=voiture&action=create" class="btn-g">
                <i class="bi bi-car-front"></i> Ajouter une voiture
            </a>
            <a href="<?= BASE_URL ?>?controller=reservation&action=reservationsRecues" class="btn-g">
                <i class="bi bi-inbox"></i> Reservations recues
            </a>
        <?php elseif ($role === 'Passager'): ?>
            <a href="<?= BASE_URL ?>?controller=trajet&action=index" class="btn-r">
                <i class="bi bi-search"></i> Chercher un trajet
            </a>
            <a href="<?= BASE_URL ?>?controller=reservation&action=mesReservations" class="btn-g">
                <i class="bi bi-bookmark-check"></i> Mes reservations
            </a>
        <?php elseif ($role === 'Admin'): ?>
            <a href="<?= BASE_URL ?>?controller=admin&action=dashboard" class="btn-r">
                <i class="bi bi-speedometer2"></i> Administration
            </a>
            <a href="<?= BASE_URL ?>?controller=statistique&action=index" class="btn-g">
                <i class="bi bi-bar-chart"></i> Statistiques
            </a>
        <?php endif; ?>
        <a href="<?= BASE_URL ?>?controller=profil&action=notifications" class="btn-g">
            <i class="bi bi-bell"></i> Mes notifications
        </a>
    </div>
</div>
