<?php
/**
 * pages/dashboard.php — Tableau de bord d'insertion professionnelle.
 */
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/functions.php';
require_login();

// KPIs
$total       = (int)$pdo->query('SELECT COUNT(*) FROM laureats')->fetchColumn();
$en_emploi   = (int)$pdo->query('SELECT COUNT(*) FROM laureats WHERE poste_actuel<>""')->fetchColumn();
$en_recherche= $total - $en_emploi;
$entreprises = (int)$pdo->query('SELECT COUNT(DISTINCT entreprise) FROM laureats WHERE entreprise<>""')->fetchColumn();
$tx_insertion= $total ? round($en_emploi * 100 / $total, 1) : 0;

// Répartition par secteur
$secteurs = $pdo->query('SELECT secteur, COUNT(*) c FROM laureats WHERE secteur<>"" GROUP BY secteur ORDER BY c DESC')->fetchAll();
// Répartition par promotion
$promos   = $pdo->query('SELECT promotion, COUNT(*) c FROM laureats GROUP BY promotion ORDER BY promotion DESC')->fetchAll();
// Top entreprises
$top_ent  = $pdo->query('SELECT entreprise, COUNT(*) c FROM laureats WHERE entreprise<>"" GROUP BY entreprise ORDER BY c DESC LIMIT 5')->fetchAll();

$page_title = 'Tableau de bord';
require_once __DIR__ . '/../includes/header.php';
?>
<div class="container py-4">
    <?php show_flash(); ?>
    <h2 class="mb-4"><i class="bi bi-speedometer2 text-primary"></i> Tableau de bord d'insertion professionnelle</h2>

    <div class="row g-3 mb-4">
        <div class="col-md-3"><div class="card dashboard-card p-3"><small class="text-muted">Total lauréats</small><h3 class="m-0"><?= $total ?></h3></div></div>
        <div class="col-md-3"><div class="card dashboard-card success p-3"><small class="text-muted">En emploi</small><h3 class="m-0 text-success"><?= $en_emploi ?></h3></div></div>
        <div class="col-md-3"><div class="card dashboard-card warning p-3"><small class="text-muted">En recherche</small><h3 class="m-0 text-warning"><?= $en_recherche ?></h3></div></div>
        <div class="col-md-3"><div class="card dashboard-card p-3"><small class="text-muted">Taux d'insertion</small><h3 class="m-0 text-primary"><?= $tx_insertion ?>%</h3></div></div>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white"><i class="bi bi-pie-chart"></i> Répartition par secteur</div>
                <div class="card-body"><canvas id="chartSecteur" height="220"></canvas></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white"><i class="bi bi-bar-chart"></i> Lauréats par promotion</div>
                <div class="card-body"><canvas id="chartPromo" height="220"></canvas></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white"><i class="bi bi-buildings"></i> Top entreprises</div>
                <ul class="list-group list-group-flush">
                    <?php foreach ($top_ent as $t): ?>
                        <li class="list-group-item d-flex justify-content-between"><?= e($t['entreprise']) ?><span class="badge bg-primary"><?= $t['c'] ?></span></li>
                    <?php endforeach; ?>
                    <?php if (!$top_ent): ?><li class="list-group-item text-muted">Aucune donnée</li><?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white"><i class="bi bi-link-45deg"></i> Accès rapides</div>
                <div class="card-body d-grid gap-2">
                    <a href="laureats.php" class="btn btn-outline-primary"><i class="bi bi-people"></i> Annuaire des lauréats</a>
                    <a href="profil.php" class="btn btn-outline-primary"><i class="bi bi-person-gear"></i> Mettre à jour mon profil</a>
                    <a href="reseau.php" class="btn btn-outline-primary"><i class="bi bi-diagram-3"></i> Réseau d'anciens</a>
                    <?php if (($_SESSION['role']??'')==='admin'): ?>
                        <a href="laureat_form.php" class="btn btn-outline-success"><i class="bi bi-plus-circle"></i> Ajouter un lauréat</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const sect = <?= json_encode($secteurs) ?>;
const prm  = <?= json_encode($promos) ?>;
new Chart(document.getElementById('chartSecteur'), {
    type:'doughnut',
    data:{ labels: sect.map(s=>s.secteur), datasets:[{ data: sect.map(s=>s.c),
        backgroundColor:['#1e3a8a','#3b82f6','#f59e0b','#10b981','#ef4444','#8b5cf6','#06b6d4'] }] }
});
new Chart(document.getElementById('chartPromo'), {
    type:'bar',
    data:{ labels: prm.map(p=>p.promotion), datasets:[{ label:'Lauréats', data: prm.map(p=>p.c), backgroundColor:'#1e3a8a' }] },
    options:{ scales:{y:{beginAtZero:true, ticks:{stepSize:1}}} }
});
</script>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
