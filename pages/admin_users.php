<?php

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/functions.php';
require_admin();

if (isset($_GET['toggle'])) {
    $id = (int)$_GET['toggle'];
    $pdo->prepare('UPDATE utilisateurs SET actif = 1 - actif WHERE id=:id')->execute([':id'=>$id]);
    flash('success','Statut modifié.');
    header('Location: admin_users.php'); exit;
}

$users = $pdo->query('SELECT * FROM utilisateurs ORDER BY id DESC')->fetchAll();

$page_title = 'Gestion des utilisateurs';
require_once __DIR__ . '/../includes/header.php';
?>
<div class="container py-4">
    <?php show_flash(); ?>
    <h2><i class="bi bi-people text-primary"></i> Utilisateurs (<?= count($users) ?>)</h2>
    <div class="card shadow-sm mt-3">
        <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead><tr><th>#</th><th>Login</th><th>Nom</th><th>Email</th><th>Rôle</th><th>Statut</th><th>Inscrit le</th><th></th></tr></thead>
            <tbody>
            <?php foreach ($users as $u): ?>
                <tr>
                    <td><?= $u['id'] ?></td>
                    <td><strong><?= e($u['login']) ?></strong></td>
                    <td><?= e($u['prenom'].' '.$u['nom']) ?></td>
                    <td><?= e($u['email']) ?></td>
                    <td><span class="badge bg-<?= $u['role']==='admin'?'danger':'primary' ?>"><?= e($u['role']) ?></span></td>
                    <td><?= $u['actif'] ? '<span class="text-success">Actif</span>' : '<span class="text-muted">Désactivé</span>' ?></td>
                    <td><?= e($u['created_at']) ?></td>
                    <td><a href="?toggle=<?= $u['id'] ?>" class="btn btn-sm btn-outline-secondary">Activer/Désactiver</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
