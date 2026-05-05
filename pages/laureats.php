<?php
/**
 * pages/laureats.php — Annuaire avec recherche / filtrage par promotion, poste, secteur.
 */
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/functions.php';
require_login();

$q       = trim($_GET['q'] ?? '');
$promo   = trim($_GET['promotion'] ?? '');
$secteur = trim($_GET['secteur'] ?? '');

$sql = 'SELECT * FROM laureats WHERE 1=1';
$params = [];
if ($q !== '')      { $sql .= ' AND (nom LIKE :q OR prenom LIKE :q OR poste_actuel LIKE :q OR entreprise LIKE :q)'; $params[':q'] = "%$q%"; }
if ($promo !== '')  { $sql .= ' AND promotion = :pr'; $params[':pr'] = $promo; }
if ($secteur !== ''){ $sql .= ' AND secteur = :s'; $params[':s'] = $secteur; }
$sql .= ' ORDER BY promotion DESC, nom ASC';

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetchAll();

$promotions = get_promotions($pdo);
$secteurs   = get_secteurs($pdo);

$page_title = 'Annuaire des lauréats';
require_once __DIR__ . '/../includes/header.php';
?>
<div class="container py-4">
    <?php show_flash(); ?>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2><i class="bi bi-people-fill text-primary"></i> Annuaire des lauréats</h2>
        <?php if (($_SESSION['role']??'')==='admin'): ?>
            <a href="laureat_form.php" class="btn btn-success"><i class="bi bi-plus-circle"></i> Nouveau lauréat</a>
        <?php endif; ?>
    </div>

    <form class="card p-3 mb-4 shadow-sm" method="get">
        <div class="row g-2">
            <div class="col-md-5"><input type="text" name="q" value="<?= e($q) ?>" class="form-control" placeholder="Recherche : nom, poste, entreprise..."></div>
            <div class="col-md-3"><select name="promotion" class="form-select"><option value="">Toutes promotions</option>
                <?php foreach ($promotions as $p): ?><option <?= $p==$promo?'selected':'' ?>><?= e($p) ?></option><?php endforeach; ?>
            </select></div>
            <div class="col-md-3"><select name="secteur" class="form-select"><option value="">Tous secteurs</option>
                <?php foreach ($secteurs as $s): ?><option <?= $s==$secteur?'selected':'' ?>><?= e($s) ?></option><?php endforeach; ?>
            </select></div>
            <div class="col-md-1 d-grid"><button class="btn btn-primary"><i class="bi bi-search"></i></button></div>
        </div>
    </form>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead><tr>
                    <th>Nom complet</th><th>Promotion</th><th>Poste actuel</th><th>Entreprise</th><th>Secteur</th><th>Ville</th><th class="text-end">Actions</th>
                </tr></thead>
                <tbody>
                <?php foreach ($rows as $l): ?>
                    <tr>
                        <td><strong><?= e($l['nom']) ?> <?= e($l['prenom']) ?></strong><br><small class="text-muted"><?= e($l['email']) ?></small></td>
                        <td><span class="badge bg-warning text-dark"><?= e($l['promotion']) ?></span></td>
                        <td><?= e($l['poste_actuel'] ?: '—') ?></td>
                        <td><?= e($l['entreprise'] ?: '—') ?></td>
                        <td><?= e($l['secteur'] ?: '—') ?></td>
                        <td><?= e($l['ville'] ?: '—') ?></td>
                        <td class="text-end">
                            <a href="laureat_view.php?id=<?= $l['id'] ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
                            <?php if (($_SESSION['role']??'')==='admin'): ?>
                                <a href="laureat_form.php?id=<?= $l['id'] ?>" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                                <a href="laureat_delete.php?id=<?= $l['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer ce lauréat ?')"><i class="bi bi-trash"></i></a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (!$rows): ?><tr><td colspan="7" class="text-center text-muted py-4">Aucun lauréat trouvé.</td></tr><?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer text-muted small"><?= count($rows) ?> résultat(s)</div>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
