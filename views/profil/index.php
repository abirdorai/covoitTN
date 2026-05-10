<h2 class="page-title">Mon profil</h2>

<div style="display:grid;grid-template-columns:280px 1fr;gap:1.5rem;align-items:start">
    <!-- Info card -->
    <div class="card card-body-pad" style="text-align:center">
        <div style="width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,var(--red),#f76c7c);display:flex;align-items:center;justify-content:center;font-size:1.8rem;font-weight:800;color:white;margin:0 auto 1rem">
            <?= strtoupper(substr($user['prenom'], 0, 1) . substr($user['nom'], 0, 1)) ?>
        </div>
        <h5 style="font-weight:700;margin-bottom:.25rem"><?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?></h5>
        <div style="margin-bottom:1rem">
            <?php
            $rClass = ['Admin'=>'bdg-red','Conducteur'=>'bdg-blue','Passager'=>'bdg-grey'][$user['role']] ?? 'bdg-grey';
            ?>
            <span class="bdg <?= $rClass ?>"><?= htmlspecialchars($user['role']) ?></span>
        </div>
        <div style="text-align:left;font-size:.88rem;color:#374151;line-height:2.1">
            <div><i class="bi bi-envelope" style="color:var(--red);width:18px"></i> <?= htmlspecialchars($user['email']) ?></div>
            <div><i class="bi bi-telephone" style="color:var(--red);width:18px"></i> <?= htmlspecialchars($user['telephone'] ?? '-') ?></div>
        </div>
        <div style="display:flex;flex-direction:column;gap:.5rem;margin-top:1.25rem">
            <a href="<?= BASE_URL ?>?controller=profil&action=edit" class="btn-r justify-content-center">
                <i class="bi bi-pencil"></i> Modifier le profil
            </a>
            <a href="<?= BASE_URL ?>?controller=profil&action=changerMdp" class="btn-g justify-content-center">
                <i class="bi bi-key"></i> Mot de passe
            </a>
        </div>
    </div>

    <!-- Notifications -->
    <div class="card card-body-pad">
        <h5 class="section-title"><i class="bi bi-bell"></i> Notifications</h5>
        <?php if (empty($notifications)): ?>
            <div class="empty-state">
                <i class="bi bi-bell-slash"></i>
                <p>Aucune notification.</p>
            </div>
        <?php else: ?>
            <div style="display:flex;flex-direction:column;gap:.75rem">
                <?php foreach ($notifications as $n): ?>
                    <div style="border-left:3px solid var(--red);padding:.75rem 1rem;background:#fff5f6;border-radius:0 8px 8px 0">
                        <div style="display:flex;justify-content:space-between;margin-bottom:.25rem">
                            <strong style="font-size:.88rem"><?= htmlspecialchars($n['typeNotif']) ?></strong>
                            <span style="font-size:.78rem;color:var(--grey-text)"><?= date('d/m/Y H:i', strtotime($n['dateEnvoi'])) ?></span>
                        </div>
                        <p style="margin:0;font-size:.88rem;color:#374151"><?= htmlspecialchars($n['contenu']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
