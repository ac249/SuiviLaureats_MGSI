<?php
/**
 * pages/profil.php — Mise à jour du profil par l'utilisateur connecté.
 */
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/functions.php';
require_login();

$uid = (int)$_SESSION['user_id'];
$stmt = $pdo->prepare('SELECT * FROM laureats WHERE utilisateur_id = :u');
$stmt->execute([':u' => $uid]);
$l = $stmt->fetch();

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $l) {
    $sql = 'UPDATE laureats SET telephone=:t, poste_actuel=:p, entreprise=:e, secteur=:s, ville=:v, pays=:pa, linkedin=:li, biographie=:b WHERE id=:id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':t'=>trim($_POST['telephone']??''), ':p'=>trim($_POST['poste_actuel']??''),
        ':e'=>trim($_POST['entreprise']??''), ':s'=>trim($_POST['secteur']??''),
        ':v'=>trim($_POST['ville']??''), ':pa'=>trim($_POST['pays']??'Maroc'),
        ':li'=>trim($_POST['linkedin']??''), ':b'=>trim($_POST['biographie']??''),
        ':id'=>$l['id']
    ]);
    flash('success','Profil mis à jour avec succès.');
    header('Location: profil.php'); exit;
}

$page_title = 'Mon profil';
require_once __DIR__ . '/../includes/header.php';
?>
<div class="container py-4">
    <?php show_flash(); ?>
    <h2><i class="bi bi-person-gear text-primary"></i> Mon profil</h2>
    <?php if (!$l): ?>
        <div class="alert alert-warning">Aucune fiche lauréat liée à ce compte.</div>
    <?php else: ?>
    <form method="post" class="card p-4 shadow-sm">
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Nom complet</label>
                <input class="form-control" disabled value="<?= e($l['prenom'].' '.$l['nom']) ?>"></div>
            <div class="col-md-3"><label class="form-label">Promotion</label>
                <input class="form-control" disabled value="<?= e($l['promotion']) ?>"></div>
            <div class="col-md-3"><label class="form-label">Email</label>
                <input class="form-control" disabled value="<?= e($l['email']) ?>"></div>
            <div class="col-md-6"><label class="form-label">Téléphone</label><input name="telephone" class="form-control" value="<?= e($l['telephone']) ?>"></div>
            <div class="col-md-6"><label class="form-label">Poste actuel</label><input name="poste_actuel" class="form-control" value="<?= e($l['poste_actuel']) ?>"></div>
            <div class="col-md-6"><label class="form-label">Entreprise</label><input name="entreprise" class="form-control" value="<?= e($l['entreprise']) ?>"></div>
            <div class="col-md-6"><label class="form-label">Secteur</label>
                <input name="secteur" class="form-control" list="lst-sec" value="<?= e($l['secteur']) ?>">
                <datalist id="lst-sec"><option>Informatique</option><option>Banque</option><option>Télécoms</option><option>Industrie</option><option>Conseil</option><option>Énergie</option></datalist></div>
            <div class="col-md-6"><label class="form-label">Ville</label><input name="ville" class="form-control" value="<?= e($l['ville']) ?>"></div>
            <div class="col-md-6"><label class="form-label">Pays</label><input name="pays" class="form-control" value="<?= e($l['pays']) ?>"></div>
            <div class="col-12"><label class="form-label">LinkedIn</label><input name="linkedin" class="form-control" value="<?= e($l['linkedin']) ?>"></div>
            <div class="col-12"><label class="form-label">Biographie</label><textarea name="biographie" rows="3" class="form-control"><?= e($l['biographie']) ?></textarea></div>
            <div class="col-12 text-end"><button class="btn btn-primary"><i class="bi bi-save"></i> Mettre à jour</button></div>
        </div>
    </form>
    <?php endif; ?>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
