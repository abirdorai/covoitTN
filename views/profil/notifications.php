<h2 class="page-title"><i class="bi bi-bell"></i> Mes notifications</h2>

<?php if (empty($notifications)): ?>
    <div class="empty-state">
        <i class="bi bi-bell-slash"></i>
        <p>Vous n'avez aucune notification pour l'instant.</p>
        <a href="<?= BASE_URL ?>?controller=profil&action=dashboard" class="btn-g">
            <i class="bi bi-arrow-left"></i> Retour au tableau de bord
        </a>
    </div>
<?php else: ?>
    <p style="font-size:.88rem;color:var(--grey-text);margin-bottom:1rem">
        <strong style="color:#111827"><?= count($notifications) ?></strong> notification(s)
    </p>

    <div style="display:flex;flex-direction:column;gap:.75rem">
        <?php foreach ($notifications as $n):
            $icons = [
                'Reservation' => ['icon' => 'bi-bookmark-check',  'color' => '#1e40af', 'bg' => '#dbeafe'],
                'Annulation'  => ['icon' => 'bi-x-circle',         'color' => '#991b1b', 'bg' => '#fee2e2'],
                'Confirmation'=> ['icon' => 'bi-check-circle',      'color' => '#065f46', 'bg' => '#d1fae5'],
                'Avis'        => ['icon' => 'bi-star',              'color' => '#92400e', 'bg' => '#fef3c7'],
            ];
            $ic = $icons[$n['typeNotif']] ?? ['icon' => 'bi-info-circle', 'color' => '#374151', 'bg' => '#f3f4f6'];
        ?>
            <div style="background:white;border-radius:12px;padding:1rem 1.25rem;
                        border:1.5px solid var(--border);display:flex;align-items:flex-start;gap:1rem;
                        box-shadow:0 1px 4px rgba(0,0,0,.04)">
                <!-- Icone -->
                <div style="width:42px;height:42px;border-radius:10px;background:<?= $ic['bg'] ?>;
                            display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <i class="bi <?= $ic['icon'] ?>" style="color:<?= $ic['color'] ?>;font-size:1.1rem"></i>
                </div>
                <!-- Contenu -->
                <div style="flex:1;min-width:0">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:.25rem;gap:.5rem">
                        <span style="font-weight:700;font-size:.9rem;color:#111827">
                            <?= htmlspecialchars($n['typeNotif']) ?>
                        </span>
                        <span style="font-size:.75rem;color:var(--grey-text);white-space:nowrap">
                            <i class="bi bi-clock"></i>
                            <?= date('d/m/Y a H:i', strtotime($n['dateEnvoi'])) ?>
                        </span>
                    </div>
                    <p style="margin:0;font-size:.88rem;color:#374151;line-height:1.5">
                        <?= htmlspecialchars($n['contenu']) ?>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div style="margin-top:1.25rem">
        <a href="<?= BASE_URL ?>?controller=profil&action=dashboard" class="btn-g">
            <i class="bi bi-arrow-left"></i> Retour au tableau de bord
        </a>
    </div>
<?php endif; ?>
