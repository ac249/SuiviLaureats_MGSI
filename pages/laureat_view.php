<?php
/**
 * pages/laureat_view.php — Détails d'un lauréat.
 */
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/functions.php';
require_login();

$id = (int)($_GET['id'] ?? 0);
$l = get_laureat($pdo, $id);
if (!$l) { flash('error','Lauréat introuvable'); header('Location: laureats.php'); exit; }

$page_title = $l['nom'].' '.$l['prenom'];
require_once __DIR__ . '/../includes/header.php';
?>
<div class="container py-4">
    <a href="laureats.php" class="btn btn-link mb-2"><i class="bi bi-arrow-left"></i> Retour à l'annuaire</a>
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="d-flex align-items-center mb-4">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width:80px;height:80px;font-size:2rem;">
                    <?= e(strtoupper(substr($l['prenom'],0,1).substr($l['nom'],0,1))) ?>
                </div>
                <div>
                    <h3 class="mb-0"><?= e($l['prenom']) ?> <?= e($l['nom']) ?></h3>
                    <p class="mb-0 text-muted"><?= e($l['poste_actuel'] ?: 'Poste non renseigné') ?> — <?= e($l['entreprise'] ?: 'Entreprise non renseignée') ?></p>
                    <span class="badge bg-warning text-dark mt-1">Promotion <?= e($l['promotion']) ?></span>
                </div>
            </div>
            <div class="row g-3">
                <div class="col-md-6"><strong><i class="bi bi-envelope"></i> Email :</strong> <?= e($l['email']) ?></div>
                <div class="col-md-6"><strong><i class="bi bi-telephone"></i> Téléphone :</strong> <?= e($l['telephone'] ?: '—') ?></div>
                <div class="col-md-6"><strong><i class="bi bi-briefcase"></i> Secteur :</strong> <?= e($l['secteur'] ?: '—') ?></div>
                <div class="col-md-6"><strong><i class="bi bi-geo-alt"></i> Localisation :</strong> <?= e(trim($l['ville'].', '.$l['pays'], ', ')) ?></div>
                <?php if ($l['linkedin']): ?>
                <div class="col-12"><strong><i class="bi bi-linkedin"></i> LinkedIn :</strong> <a href="<?= e($l['linkedin']) ?>" target="_blank"><?= e($l['linkedin']) ?></a></div>
                <?php endif; ?>
                <?php if ($l['biographie']): ?>
                <div class="col-12"><hr><h5>Biographie</h5><p><?= nl2br(e($l['biographie'])) ?></p></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
