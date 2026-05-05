<?php
/**
 * navbar.php — Barre de navigation Bootstrap responsive.
 */
$logged = !empty($_SESSION['user_id']);
$role   = $_SESSION['role'] ?? '';
$nom    = $_SESSION['nom']  ?? '';
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= e(APP_URL) ?>/index.php">
            <i class="bi bi-mortarboard-fill me-2"></i>ENSIASDT Alumni
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="<?= e(APP_URL) ?>/index.php">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= e(APP_URL) ?>/index.php#services">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= e(APP_URL) ?>/index.php#about">À propos</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= e(APP_URL) ?>/index.php#contact">Contact</a></li>
                <?php if ($logged): ?>
                    <li class="nav-item"><a class="nav-link" href="<?= e(APP_URL) ?>/pages/dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= e(APP_URL) ?>/pages/laureats.php">Lauréats</a></li>
                    <?php if ($role === 'admin'): ?>
                        <li class="nav-item"><a class="nav-link" href="<?= e(APP_URL) ?>/pages/admin_users.php">Utilisateurs</a></li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav">
                <?php if ($logged): ?>
                    <li class="nav-item"><a class="nav-link" href="<?= e(APP_URL) ?>/pages/profil.php"><i class="bi bi-person-circle"></i> <?= e($nom) ?></a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= e(APP_URL) ?>/pages/logout.php"><i class="bi bi-box-arrow-right"></i> Déconnexion</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="<?= e(APP_URL) ?>/pages/login.php">Connexion</a></li>
                    <li class="nav-item"><a class="btn btn-light text-primary fw-semibold ms-2" href="<?= e(APP_URL) ?>/pages/register.php">Inscription</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
