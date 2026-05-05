<?php
/**
 * pages/register.php — Inscription d'un nouveau lauréat.
 */
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/functions.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom     = trim($_POST['nom'] ?? '');
    $prenom  = trim($_POST['prenom'] ?? '');
    $login   = trim($_POST['login'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $password= $_POST['password'] ?? '';
    $confirm = $_POST['password_confirm'] ?? '';
    $promo   = (int)($_POST['promotion'] ?? 0);

    if (!$nom || !$prenom || !$login || !$email || !$password) {
        $error = 'Tous les champs obligatoires doivent être remplis.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email invalide.';
    } elseif (strlen($password) < 8) {
        $error = 'Le mot de passe doit faire au moins 8 caractères.';
    } elseif ($password !== $confirm) {
        $error = 'Les mots de passe ne correspondent pas.';
    } else {
        // Vérifier l'unicité
        $check = $pdo->prepare('SELECT id FROM utilisateurs WHERE login=:l OR email=:e');
        $check->execute([':l' => $login, ':e' => $email]);
        if ($check->fetch()) {
            $error = 'Login ou email déjà utilisé.';
        } else {
            $pdo->beginTransaction();
            try {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $ins = $pdo->prepare('INSERT INTO utilisateurs (login, email, mot_de_passe, nom, prenom, role) VALUES (:l, :e, :p, :n, :pr, "laureat")');
                $ins->execute([':l'=>$login, ':e'=>$email, ':p'=>$hash, ':n'=>$nom, ':pr'=>$prenom]);
                $uid = (int)$pdo->lastInsertId();

                // Créer la fiche lauréat associée
                $insL = $pdo->prepare('INSERT INTO laureats (utilisateur_id, nom, prenom, email, promotion, poste_actuel, entreprise, secteur, ville) VALUES (:u,:n,:p,:e,:pr,"","","","")');
                $insL->execute([':u'=>$uid, ':n'=>$nom, ':p'=>$prenom, ':e'=>$email, ':pr'=>$promo ?: date('Y')]);
                $pdo->commit();
                flash('success', 'Inscription réussie ! Vous pouvez vous connecter.');
                header('Location: login.php'); exit;
            } catch (Exception $ex) {
                $pdo->rollBack();
                $error = 'Erreur : ' . $ex->getMessage();
            }
        }
    }
}

$page_title = 'Inscription';
require_once __DIR__ . '/../includes/header.php';
?>
<div class="container">
    <div class="card auth-card" style="max-width:600px;">
        <div class="card-header">
            <h3 class="m-0"><i class="bi bi-person-plus"></i> Inscription</h3>
            <small>Rejoignez le réseau ENSIASDT Alumni</small>
        </div>
        <div class="card-body p-4">
            <?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
            <form method="post" class="needs-validation" novalidate>
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label">Nom *</label>
                        <input name="nom" class="form-control" required value="<?= e($_POST['nom'] ?? '') ?>"></div>
                    <div class="col-md-6"><label class="form-label">Prénom *</label>
                        <input name="prenom" class="form-control" required value="<?= e($_POST['prenom'] ?? '') ?>"></div>
                    <div class="col-md-6"><label class="form-label">Login *</label>
                        <input name="login" class="form-control" required value="<?= e($_POST['login'] ?? '') ?>"></div>
                    <div class="col-md-6"><label class="form-label">Email *</label>
                        <input type="email" name="email" class="form-control" required value="<?= e($_POST['email'] ?? '') ?>"></div>
                    <div class="col-md-6"><label class="form-label">Année de promotion</label>
                        <input type="number" name="promotion" class="form-control" min="2000" max="2030" value="<?= e($_POST['promotion'] ?? date('Y')) ?>"></div>
                    <div class="col-md-6"></div>
                    <div class="col-md-6"><label class="form-label">Mot de passe *</label>
                        <input type="password" id="password" name="password" class="form-control" required minlength="8">
                        <div id="pwd-strength" class="password-strength"></div>
                        <small class="text-muted">8 caractères min, majuscule, chiffre recommandés.</small></div>
                    <div class="col-md-6"><label class="form-label">Confirmer *</label>
                        <input type="password" id="password_confirm" name="password_confirm" class="form-control" required></div>
                    <div class="col-12 form-check">
                        <input type="checkbox" id="cgu" class="form-check-input" required>
                        <label for="cgu" class="form-check-label small">J'accepte la <a href="mentions.php">politique de confidentialité</a>.</label>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary w-100">Créer mon compte</button>
                    </div>
                </div>
            </form>
            <p class="text-center small mt-3 mb-0">Déjà inscrit ? <a href="login.php">Se connecter</a></p>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
