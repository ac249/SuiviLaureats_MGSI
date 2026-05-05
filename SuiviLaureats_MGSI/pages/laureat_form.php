<?php
/**
 * pages/laureat_form.php — Création / modification d'un lauréat (admin).
 */
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/functions.php';
require_admin();

$id = (int)($_GET['id'] ?? 0);
$l = $id ? get_laureat($pdo, $id) : null;
if ($id && !$l) { flash('error','Lauréat introuvable'); header('Location: laureats.php'); exit; }

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'nom'         => trim($_POST['nom'] ?? ''),
        'prenom'      => trim($_POST['prenom'] ?? ''),
        'email'       => trim($_POST['email'] ?? ''),
        'telephone'   => trim($_POST['telephone'] ?? ''),
        'promotion'   => (int)($_POST['promotion'] ?? 0),
        'poste_actuel'=> trim($_POST['poste_actuel'] ?? ''),
        'entreprise'  => trim($_POST['entreprise'] ?? ''),
        'secteur'     => trim($_POST['secteur'] ?? ''),
        'ville'       => trim($_POST['ville'] ?? ''),
        'pays'        => trim($_POST['pays'] ?? 'Maroc'),
        'linkedin'    => trim($_POST['linkedin'] ?? ''),
        'biographie'  => trim($_POST['biographie'] ?? ''),
    ];
    if (!$data['nom'] || !$data['prenom'] || !$data['email'] || !$data['promotion']) {
        $error = 'Nom, prénom, email et promotion sont obligatoires.';
    } else {
        if ($id) {
            $sql = 'UPDATE laureats SET nom=:nom,prenom=:prenom,email=:email,telephone=:telephone,promotion=:promotion,
                poste_actuel=:poste_actuel,entreprise=:entreprise,secteur=:secteur,ville=:ville,pays=:pays,
                linkedin=:linkedin,biographie=:biographie WHERE id=:id';
            $data[':id'] = $id;
            $stmt = $pdo->prepare($sql);
            foreach ($data as $k=>$v) { if ($k!==':id') $stmt->bindValue(":$k", $v); }
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            flash('success','Lauréat mis à jour.');
        } else {
            $sql = 'INSERT INTO laureats (nom,prenom,email,telephone,promotion,poste_actuel,entreprise,secteur,ville,pays,linkedin,biographie)
                    VALUES (:nom,:prenom,:email,:telephone,:promotion,:poste_actuel,:entreprise,:secteur,:ville,:pays,:linkedin,:biographie)';
            $stmt = $pdo->prepare($sql);
            foreach ($data as $k=>$v) $stmt->bindValue(":$k", $v);
            $stmt->execute();
            flash('success','Lauréat créé.');
        }
        header('Location: laureats.php'); exit;
    }
}

$page_title = $id ? 'Modifier lauréat' : 'Nouveau lauréat';
require_once __DIR__ . '/../includes/header.php';
?>
<div class="container py-4">
    <h2><i class="bi bi-person-vcard text-primary"></i> <?= e($page_title) ?></h2>
    <?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
    <form method="post" class="card p-4 shadow-sm needs-validation" novalidate>
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Nom *</label><input name="nom" class="form-control" required value="<?= e($l['nom'] ?? $_POST['nom'] ?? '') ?>"></div>
            <div class="col-md-6"><label class="form-label">Prénom *</label><input name="prenom" class="form-control" required value="<?= e($l['prenom'] ?? $_POST['prenom'] ?? '') ?>"></div>
            <div class="col-md-6"><label class="form-label">Email *</label><input type="email" name="email" class="form-control" required value="<?= e($l['email'] ?? $_POST['email'] ?? '') ?>"></div>
            <div class="col-md-6"><label class="form-label">Téléphone</label><input name="telephone" class="form-control" value="<?= e($l['telephone'] ?? '') ?>"></div>
            <div class="col-md-4"><label class="form-label">Promotion *</label><input type="number" name="promotion" min="2000" max="2030" class="form-control" required value="<?= e($l['promotion'] ?? date('Y')) ?>"></div>
            <div class="col-md-4"><label class="form-label">Poste actuel</label><input name="poste_actuel" class="form-control" value="<?= e($l['poste_actuel'] ?? '') ?>"></div>
            <div class="col-md-4"><label class="form-label">Entreprise</label><input name="entreprise" class="form-control" value="<?= e($l['entreprise'] ?? '') ?>"></div>
            <div class="col-md-4"><label class="form-label">Secteur</label>
                <input name="secteur" class="form-control" list="lst-secteurs" value="<?= e($l['secteur'] ?? '') ?>">
                <datalist id="lst-secteurs"><option>Informatique</option><option>Banque</option><option>Télécoms</option><option>Industrie</option><option>Conseil</option><option>Énergie</option><option>Éducation</option></datalist></div>
            <div class="col-md-4"><label class="form-label">Ville</label><input name="ville" class="form-control" value="<?= e($l['ville'] ?? '') ?>"></div>
            <div class="col-md-4"><label class="form-label">Pays</label><input name="pays" class="form-control" value="<?= e($l['pays'] ?? 'Maroc') ?>"></div>
            <div class="col-12"><label class="form-label">LinkedIn</label><input name="linkedin" class="form-control" value="<?= e($l['linkedin'] ?? '') ?>"></div>
            <div class="col-12"><label class="form-label">Biographie</label><textarea name="biographie" rows="3" class="form-control"><?= e($l['biographie'] ?? '') ?></textarea></div>
            <div class="col-12 text-end">
                <a href="laureats.php" class="btn btn-secondary">Annuler</a>
                <button class="btn btn-primary"><i class="bi bi-save"></i> Enregistrer</button>
            </div>
        </div>
    </form>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
