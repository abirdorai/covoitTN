<h2 class="page-title">
    Bonjour <span style="color:var(--red)"><?= htmlspecialchars($_SESSION['user']['prenom']) ?></span>,
    bienvenue sur votre espace
</h2>

<!-- Stat cards -->
<div class="stat-cards-row">
    <div class="stat-card-new">
        <div class="stat-card-icon icon-red"></div>
        <div class="stat-card-body">
            <div class="stat-num"><?= $totalUtilisateurs ?></div>
            <div class="stat-lbl">Utilisateurs</div>
        </div>
    </div>
    <div class="stat-card-new">
        <div class="stat-card-icon icon-blue"></div>
        <div class="stat-card-body">
            <div class="stat-num"><?= $totalTrajets ?></div>
            <div class="stat-lbl">Trajets</div>
        </div>
    </div>
    <div class="stat-card-new">
        <div class="stat-card-icon icon-green"></div>
        <div class="stat-card-body">
            <div class="stat-num"><?= $totalReservations ?></div>
            <div class="stat-lbl">Reservations</div>
        </div>
    </div>
    <div class="stat-card-new">
        <div class="stat-card-icon icon-amber"></div>
        <div class="stat-card-body">
            <div class="stat-num"><?= $noteMoyenne ?>/5</div>
            <div class="stat-lbl">Note moyenne</div>
        </div>
    </div>
</div>

<!-- Chiffre d'affaires -->
<div class="card mb-4">
    <div class="card-body-pad" style="display:flex;align-items:center;gap:1.25rem">
        <div style="background:#d1fae5;border-radius:12px;width:52px;height:52px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
            <i class="bi bi-cash-coin" style="color:#065f46;font-size:1.4rem"></i>
        </div>
        <div>
            <div style="font-size:.8rem;font-weight:700;color:var(--grey-text);text-transform:uppercase;letter-spacing:.5px">
                Chiffre d'affaires total estime
            </div>
            <div style="font-size:2rem;font-weight:900;color:#065f46;line-height:1.2">
                <?= number_format($chiffreAffaires, 2) ?> <span style="font-size:1.1rem;font-weight:600">DT</span>
            </div>
            <div style="font-size:.78rem;color:var(--grey-text)">Reservations confirmees et terminees</div>
        </div>
    </div>
</div>

<!-- Quick actions -->
<h2 class="section-title">Acces rapides</h2>
<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(170px,1fr));gap:.75rem">
    <?php
    $links = [
        ['url' => '?controller=admin&action=utilisateurs', 'icon' => 'bi-people-fill',    'label' => 'Utilisateurs'],
        ['url' => '?controller=admin&action=conducteurs',  'icon' => 'bi-person-vcard',    'label' => 'Conducteurs'],
        ['url' => '?controller=admin&action=trajets',      'icon' => 'bi-signpost-2-fill', 'label' => 'Trajets'],
        ['url' => '?controller=admin&action=reservations', 'icon' => 'bi-bookmark-fill',   'label' => 'Reservations'],
        ['url' => '?controller=statistique&action=index',  'icon' => 'bi-bar-chart-fill',  'label' => 'Statistiques'],
    ];
    foreach ($links as $l):
    ?>
        <a href="<?= BASE_URL . $l['url'] ?>" class="card card-body-pad text-decoration-none"
           style="text-align:center;transition:box-shadow .15s;display:flex;flex-direction:column;align-items:center;gap:.5rem"
           onmouseover="this.style.boxShadow='0 4px 16px rgba(224,54,75,.2)'"
           onmouseout="this.style.boxShadow=''">
            <i class="bi <?= $l['icon'] ?>" style="color:var(--red);font-size:1.75rem"></i>
            <span style="font-size:.88rem;font-weight:600;color:#111827"><?= $l['label'] ?></span>
        </a>
    <?php endforeach; ?>
</div>
