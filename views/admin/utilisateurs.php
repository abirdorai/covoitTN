<h2 class="page-title">Gestion des utilisateurs</h2>

<!-- Recherche multi-criteres -->
<div class="card mb-4">
    <div style="padding:1.25rem 1.5rem">
        <form method="get" action="<?= BASE_URL ?>" class="row g-3 align-items-end">
            <input type="hidden" name="controller" value="admin">
            <input type="hidden" name="action" value="utilisateurs">
            <div class="col-md-4">
                <label class="field-label">Nom ou prenom</label>
                <input type="text" name="nom" class="form-control" style="border:1.5px solid var(--border);border-radius:8px;padding:.6rem .85rem"
                       value="<?= htmlspecialchars($nom) ?>" placeholder="Rechercher...">
            </div>
            <div class="col-md-4">
                <label class="field-label">Email</label>
                <input type="text" name="email" class="form-control" style="border:1.5px solid var(--border);border-radius:8px;padding:.6rem .85rem"
                       value="<?= htmlspecialchars($email) ?>" placeholder="Email...">
            </div>
            <div class="col-md-2">
                <label class="field-label">Role</label>
                <select name="role" class="form-select" style="border:1.5px solid var(--border);border-radius:8px;padding:.6rem .85rem">
                    <option value="">Tous les roles</option>
                    <?php foreach (['Admin', 'Conducteur', 'Passager'] as $r): ?>
                        <option value="<?= $r ?>" <?= $role === $r ? 'selected' : '' ?>><?= $r ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn-r w-100 justify-content-center">
                    <i class="bi bi-search"></i> Filtrer
                </button>
            </div>
        </form>
    </div>
</div>

<p style="font-size:.88rem;color:var(--grey-text);margin-bottom:.75rem">
    <strong style="color:#111827"><?= count($users) ?></strong> utilisateur(s)
</p>

<div class="card">
    <div style="overflow-x:auto">
        <table class="tbl">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Email</th>
                    <th>Telephone</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                    <?php
                    $roleClass = [
                        'Admin'      => 'bdg-red',
                        'Conducteur' => 'bdg-blue',
                        'Passager'   => 'bdg-grey',
                    ][$u['role']] ?? 'bdg-grey';
                    ?>
                    <tr>
                        <td style="color:var(--grey-text);font-size:.82rem">#<?= $u['idUtilisateur'] ?></td>
                        <td><strong><?= htmlspecialchars($u['nom']) ?></strong></td>
                        <td><?= htmlspecialchars($u['prenom']) ?></td>
                        <td><?= htmlspecialchars($u['email']) ?></td>
                        <td><?= htmlspecialchars($u['telephone'] ?? '-') ?></td>
                        <td><span class="bdg <?= $roleClass ?>"><?= htmlspecialchars($u['role']) ?></span></td>
                        <td>
                            <a href="<?= BASE_URL ?>?controller=admin&action=deleteUser&id=<?= $u['idUtilisateur'] ?>"
                               class="btn-ic r"
                               onclick="return confirm('Supprimer cet utilisateur ?')">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
