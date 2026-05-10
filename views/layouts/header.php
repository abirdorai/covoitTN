<?php
$user       = $_SESSION['user'] ?? null;
$ctrl       = $_GET['controller'] ?? 'home';
$action     = $_GET['action']     ?? 'index';
$hasSidebar = ($user !== null);
$isHero     = (!$user && $ctrl === 'home' && $action === 'index');

// Fonction helper : est-ce la page active ?
$active = function($c, $a = null) use ($ctrl, $action) {
    if ($ctrl !== $c) return '';
    if ($a !== null && $action !== $a) return '';
    return 'active';
};
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Covoit TN - Le covoiturage en Tunisie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>

<!-- ===== NAVBAR ===== -->
<nav class="navbar-covoit">
    <a class="navbar-brand" href="<?= BASE_URL ?>">
        <span>Covoit</span>&nbsp;<span class="brand-tn">TN</span>
    </a>

    <button class="navbar-toggler-custom" id="navToggle" type="button">
        <i class="bi bi-list fs-4"></i>
    </button>

    <div class="nav-spacer"></div>

    <div class="nav-links" id="navLinks">
        <a href="<?= BASE_URL ?>" class="nav-link-item">Accueil</a>
        <a href="<?= BASE_URL ?>?controller=trajet&action=index" class="nav-link-item">Trajets</a>

        <?php if ($user): ?>
            <div class="dd-parent" style="margin-left:.5rem">
                <a href="#" class="btn-monespace" id="ddUser"
                   style="display:inline-flex;align-items:center;gap:.35rem">
                    <i class="bi bi-person-circle"></i>
                    Mon espace
                    <i class="bi bi-chevron-down" style="font-size:.7rem"></i>
                </a>
                <div class="dd-menu" id="ddUserMenu">
                    <a class="dd-item" href="<?= BASE_URL ?>?controller=profil&action=dashboard">
                        <i class="bi bi-speedometer2"></i> Tableau de bord
                    </a>
                    <a class="dd-item" href="<?= BASE_URL ?>?controller=profil&action=index">
                        <i class="bi bi-person"></i> Mon profil
                    </a>
                    <a class="dd-item" href="<?= BASE_URL ?>?controller=profil&action=notifications">
                        <i class="bi bi-bell"></i> Notifications
                    </a>
                    <?php if ($user['role'] === 'Admin'): ?>
                        <div class="dd-sep"></div>
                        <a class="dd-item" href="<?= BASE_URL ?>?controller=admin&action=dashboard">
                            <i class="bi bi-shield-lock"></i> Administration
                        </a>
                        <a class="dd-item" href="<?= BASE_URL ?>?controller=statistique&action=index">
                            <i class="bi bi-bar-chart"></i> Statistiques
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <a href="<?= BASE_URL ?>?controller=auth&action=logout" class="btn-red" style="margin-left:.5rem">
                <i class="bi bi-box-arrow-right"></i> Deconnexion
            </a>
        <?php else: ?>
            <a href="<?= BASE_URL ?>?controller=auth&action=login" class="nav-link-item">Connexion</a>
            <a href="<?= BASE_URL ?>?controller=auth&action=register" class="btn-red" style="margin-left:.25rem">
                S'inscrire
            </a>
        <?php endif; ?>
    </div>
</nav>

<!-- ===== FLASH MESSAGES ===== -->
<div class="flash-wrapper">
    <?php if (!empty($_SESSION['flash_success'])): ?>
        <div class="flash-msg success">
            <i class="bi bi-check-circle-fill"></i>
            <?= htmlspecialchars($_SESSION['flash_success']) ?>
        </div>
        <?php unset($_SESSION['flash_success']); ?>
    <?php endif; ?>
    <?php if (!empty($_SESSION['flash_error'])): ?>
        <div class="flash-msg error">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <?= htmlspecialchars($_SESSION['flash_error']) ?>
        </div>
        <?php unset($_SESSION['flash_error']); ?>
    <?php endif; ?>
</div>

<?php if ($hasSidebar): ?>
<!-- ===== LAYOUT AVEC SIDEBAR ===== -->
<div class="app-layout">

    <aside class="sidebar">
        <div class="sidebar-inner">
            <div class="sidebar-nav-label">Navigation</div>

            <?php if ($user['role'] === 'Conducteur'): ?>

                <a href="<?= BASE_URL ?>?controller=profil&action=dashboard"
                   class="sidebar-link <?= $active('profil','dashboard') ?>">
                    <i class="bi bi-speedometer2"></i> Tableau de bord
                </a>
                <a href="<?= BASE_URL ?>?controller=trajet&action=mesTrajets"
                   class="sidebar-link <?= $active('trajet','mesTrajets') ?>">
                    <i class="bi bi-signpost-2"></i> Mes trajets
                </a>
                <a href="<?= BASE_URL ?>?controller=trajet&action=create"
                   class="sidebar-link <?= $active('trajet','create') ?>">
                    <i class="bi bi-plus-circle"></i> Ajouter un trajet
                </a>
                <a href="<?= BASE_URL ?>?controller=trajet&action=index"
                   class="sidebar-link <?= $active('trajet','index') ?>">
                    <i class="bi bi-search"></i> Chercher un trajet
                </a>
                <a href="<?= BASE_URL ?>?controller=voiture&action=index"
                   class="sidebar-link <?= $active('voiture') ?>">
                    <i class="bi bi-car-front"></i> Mes voitures
                </a>
                <a href="<?= BASE_URL ?>?controller=reservation&action=reservationsRecues"
                   class="sidebar-link <?= $active('reservation','reservationsRecues') ?>">
                    <i class="bi bi-inbox"></i> Reservations recues
                </a>
                <a href="<?= BASE_URL ?>?controller=profil&action=notifications"
                   class="sidebar-link <?= $active('profil','notifications') ?>">
                    <i class="bi bi-bell"></i> Mes Notifications
                </a>

            <?php elseif ($user['role'] === 'Passager'): ?>

                <a href="<?= BASE_URL ?>?controller=profil&action=dashboard"
                   class="sidebar-link <?= $active('profil','dashboard') ?>">
                    <i class="bi bi-speedometer2"></i> Tableau de bord
                </a>
                <a href="<?= BASE_URL ?>?controller=trajet&action=index"
                   class="sidebar-link <?= $active('trajet','index') ?>">
                    <i class="bi bi-search"></i> Chercher un trajet
                </a>
                <a href="<?= BASE_URL ?>?controller=reservation&action=mesReservations"
                   class="sidebar-link <?= $active('reservation','mesReservations') ?>">
                    <i class="bi bi-bookmark-check"></i> Mes reservations
                </a>
                <a href="<?= BASE_URL ?>?controller=avis&action=index"
                   class="sidebar-link <?= $active('avis') ?>">
                    <i class="bi bi-star"></i> Les avis
                </a>
                <a href="<?= BASE_URL ?>?controller=profil&action=notifications"
                   class="sidebar-link <?= $active('profil','notifications') ?>">
                    <i class="bi bi-bell"></i> Mes Notifications
                </a>

            <?php elseif ($user['role'] === 'Admin'): ?>

                <a href="<?= BASE_URL ?>?controller=admin&action=dashboard"
                   class="sidebar-link <?= $active('admin','dashboard') ?>">
                    <i class="bi bi-speedometer2"></i> Tableau de bord
                </a>
                <a href="<?= BASE_URL ?>?controller=admin&action=utilisateurs"
                   class="sidebar-link <?= $active('admin','utilisateurs') ?>">
                    <i class="bi bi-people"></i> Utilisateurs
                </a>
                <a href="<?= BASE_URL ?>?controller=admin&action=conducteurs"
                   class="sidebar-link <?= $active('admin','conducteurs') ?>">
                    <i class="bi bi-person-vcard"></i> Conducteurs
                </a>
                <a href="<?= BASE_URL ?>?controller=admin&action=trajets"
                   class="sidebar-link <?= $active('admin','trajets') ?>">
                    <i class="bi bi-signpost"></i> Trajets
                </a>
                <a href="<?= BASE_URL ?>?controller=admin&action=reservations"
                   class="sidebar-link <?= $active('admin','reservations') ?>">
                    <i class="bi bi-bookmark"></i> Reservations
                </a>
                <a href="<?= BASE_URL ?>?controller=statistique&action=index"
                   class="sidebar-link <?= $active('statistique') ?>">
                    <i class="bi bi-bar-chart"></i> Statistiques
                </a>
                <a href="<?= BASE_URL ?>?controller=profil&action=notifications"
                   class="sidebar-link <?= $active('profil','notifications') ?>">
                    <i class="bi bi-bell"></i> Mes Notifications
                </a>

            <?php endif; ?>

            <div class="sidebar-spacer"></div>
        </div>

        <a href="<?= BASE_URL ?>?controller=auth&action=logout" class="sidebar-logout">
            <i class="bi bi-box-arrow-right"></i> Deconnexion
        </a>
    </aside>

    <!-- Contenu principal -->
    <main class="app-main">

<?php elseif ($isHero): ?>
<!-- ===== PAGE ACCUEIL (hero plein ecran) ===== -->
<main>

<?php else: ?>
<!-- ===== PAGES PUBLIQUES (avec container) ===== -->
<main>
<div class="page-container">

<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Auto-dismiss flash messages
    setTimeout(function () {
        document.querySelectorAll('.flash-msg').forEach(function (el) {
            el.style.transition = 'opacity .4s';
            el.style.opacity = '0';
            setTimeout(function () { el.remove(); }, 400);
        });
    }, 4000);

    // Mobile navbar toggle
    var toggle = document.getElementById('navToggle');
    var links  = document.getElementById('navLinks');
    if (toggle && links) {
        toggle.addEventListener('click', function () {
            links.classList.toggle('open');
        });
    }

    // Mon espace dropdown
    var ddBtn  = document.getElementById('ddUser');
    var ddMenu = document.getElementById('ddUserMenu');
    if (ddBtn && ddMenu) {
        ddBtn.addEventListener('click', function (e) {
            e.preventDefault();
            ddMenu.classList.toggle('open');
        });
        document.addEventListener('click', function (e) {
            if (!ddBtn.contains(e.target) && !ddMenu.contains(e.target)) {
                ddMenu.classList.remove('open');
            }
        });
    }
});
</script>
