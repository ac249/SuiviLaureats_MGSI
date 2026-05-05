<?php
/**
 * pages/login.php — Connexion utilisateur.
 */
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/functions.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login    = trim($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($login === '' || $password === '') {
        $error = 'Veuillez renseigner tous les champs.';
    } else {
        // Recherche par login OU email (requête préparée)
        $stmt = $pdo->prepare('SELECT * FROM utilisateurs WHERE login = ? OR email = ? LIMIT 1');
$stmt->execute([$login, $login]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['mot_de_passe'])) {
            $_SESSION['user_id'] = (int)$user['id'];
            $_SESSION['login']   = $user['login'];
            $_SESSION['nom']     = $user['nom'] . ' ' . $user['prenom'];
            $_SESSION['role']    = $user['role'];
            flash('success', 'Bienvenue ' . $user['prenom'] . ' !');
            header('Location: dashboard.php'); exit;
        } else {
            $error = 'Identifiants incorrects.';
        }
    }
}

$page_title = 'Connexion';
require_once __DIR__ . '/../includes/header.php';
?>
<div class="container">
    <div class="card auth-card">
        <div class="card-header">
            <h3 class="m-0"><i class="bi bi-box-arrow-in-right"></i> Connexion</h3>
            <small>Accédez à votre espace lauréat</small>
        </div>
        <div class="card-body p-4">
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= e($error) ?></div>
            <?php endif; ?>
            <form method="post" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label class="form-label">Login ou email</label>
                    <input type="text" name="login" class="form-control" required autofocus value="<?= e($_POST['login'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-box-arrow-in-right"></i> Se connecter</button>
            </form>
            <hr>
            <p class="text-center small mb-0">Pas encore de compte ? <a href="register.php">Inscrivez-vous</a></p>
            <p class="text-center small text-muted mt-2">Compte test admin : <code>ENSIASD</code> / <code>ENSIASD2026</code></p>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
