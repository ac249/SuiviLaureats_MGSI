<?php

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/functions.php';

$nb_laureats = (int)$pdo->query('SELECT COUNT(*) FROM laureats')->fetchColumn();
$nb_promos   = (int)$pdo->query('SELECT COUNT(DISTINCT promotion) FROM laureats')->fetchColumn();
$nb_secteurs = (int)$pdo->query('SELECT COUNT(DISTINCT secteur) FROM laureats WHERE secteur<>""')->fetchColumn();
$nb_entreprises = (int)$pdo->query('SELECT COUNT(DISTINCT entreprise) FROM laureats WHERE entreprise<>""')->fetchColumn();

$page_title = 'Accueil';
require_once __DIR__ . '/includes/header.php';
?>

<!-- HERO SECTION -->
<section class="hero">
    <div class="container text-center fade-up">
        <h1>Suivi des Lauréats <span class="text-warning">ENSIASDT</span></h1>
        <p class="lead mt-3 mx-auto" style="max-width:720px;">
            Plateforme officielle qui réunit les diplômés de l'ENSIASDT, facilite le réseautage entre anciens
            et permet à l'école de suivre l'insertion professionnelle de ses lauréats.
        </p>
        <div class="mt-4">
            <a href="pages/register.php" class="btn btn-accent btn-lg me-2"><i class="bi bi-rocket-takeoff"></i> Commencer</a>
            <a href="#services" class="btn btn-outline-light btn-lg">En savoir plus</a>
        </div>
    </div>
</section>

<!-- STATISTIQUES -->
<section class="bg-white">
    <div class="container">
        <h2 class="section-title">Notre communauté en chiffres</h2>
        <div class="row g-4">
            <div class="col-md-3 col-6"><div class="stat-card"><div class="num counter" data-target="<?= $nb_laureats ?>">0</div><div class="text-muted">Lauréats</div></div></div>
            <div class="col-md-3 col-6"><div class="stat-card"><div class="num counter" data-target="<?= $nb_promos ?>">0</div><div class="text-muted">Promotions</div></div></div>
            <div class="col-md-3 col-6"><div class="stat-card"><div class="num counter" data-target="<?= $nb_entreprises ?>">0</div><div class="text-muted">Entreprises</div></div></div>
            <div class="col-md-3 col-6"><div class="stat-card"><div class="num counter" data-target="<?= $nb_secteurs ?>">0</div><div class="text-muted">Secteurs</div></div></div>
        </div>
    </div>
</section>

<!-- SERVICES -->
<section id="services" class="bg-light">
    <div class="container">
        <h2 class="section-title">Nos services</h2>
        <div class="row g-4">
            <div class="col-md-4"><div class="card feature-card p-4"><div class="feature-icon"><i class="bi bi-database-fill"></i></div>
                <h5>Base de données des lauréats</h5><p class="text-muted">Profil professionnel complet : poste actuel, entreprise, secteur, promotion.</p></div></div>
            <div class="col-md-4"><div class="card feature-card p-4"><div class="feature-icon"><i class="bi bi-pencil-square"></i></div>
                <h5>Mise à jour du profil</h5><p class="text-muted">Chaque ancien étudiant met à jour ses informations professionnelles à tout moment.</p></div></div>
            <div class="col-md-4"><div class="card feature-card p-4"><div class="feature-icon"><i class="bi bi-search"></i></div>
                <h5>Recherche avancée</h5><p class="text-muted">Filtrage par promotion, poste, secteur d'activité ou entreprise.</p></div></div>
            <div class="col-md-4"><div class="card feature-card p-4"><div class="feature-icon"><i class="bi bi-people-fill"></i></div>
                <h5>Réseau d'anciens</h5><p class="text-muted">Connectez-vous avec d'autres lauréats pour échanger opportunités et expériences.</p></div></div>
            <div class="col-md-4"><div class="card feature-card p-4"><div class="feature-icon"><i class="bi bi-graph-up"></i></div>
                <h5>Tableau de bord</h5><p class="text-muted">Indicateurs clés sur l'insertion professionnelle des diplômés.</p></div></div>
            <div class="col-md-4"><div class="card feature-card p-4"><div class="feature-icon"><i class="bi bi-shield-check"></i></div>
                <h5>Sécurité des données</h5><p class="text-muted">Authentification sécurisée, mots de passe hachés, requêtes préparées (PDO).</p></div></div>
        </div>
    </div>
</section>

<!-- À PROPOS -->
<section id="about">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-md-6">
                <h2 class="fw-bold text-primary">À propos du projet</h2>
                <p class="lead">L'ENSIASDT forme chaque année des ingénieurs et data scientists qui rejoignent des entreprises de premier plan.</p>
                <p>Cette plateforme centralise les informations des lauréats afin de :</p>
                <ul>
                    <li>Faciliter le <strong>suivi de l'insertion professionnelle</strong></li>
                    <li>Renforcer le <strong>réseau d'anciens élèves</strong></li>
                    <li>Aider les <strong>nouveaux diplômés</strong> à préparer leur carrière</li>
                    <li>Permettre à l'école de <strong>mesurer l'impact</strong> de ses formations</li>
                </ul>
            </div>
            <div class="col-md-6">
                <div class="ratio ratio-16x9 rounded shadow">
                    <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded">
                        <i class="bi bi-mortarboard-fill" style="font-size:6rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- TÉMOIGNAGES -->
<section class="bg-light">
    <div class="container">
        <h2 class="section-title">Ils témoignent</h2>
        <div class="row g-4">
            <div class="col-md-4"><div class="card testimonial-card p-4">
                <p class="fst-italic">« Grâce au réseau alumni, j'ai décroché un stage de fin d'études chez OCP en moins de 3 semaines. »</p>
                <div class="d-flex align-items-center"><div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width:48px;height:48px;">SA</div>
                    <div class="ms-3"><strong>Sara Amrani</strong><br><small class="text-muted">Promo 2023 — Data Engineer</small></div></div></div></div>
            <div class="col-md-4"><div class="card testimonial-card p-4">
                <p class="fst-italic">« La plateforme me permet de garder le contact avec mes camarades partout dans le monde. »</p>
                <div class="d-flex align-items-center"><div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width:48px;height:48px;">YM</div>
                    <div class="ms-3"><strong>Youssef Mansouri</strong><br><small class="text-muted">Promo 2021 — Consultant SI</small></div></div></div></div>
            <div class="col-md-4"><div class="card testimonial-card p-4">
                <p class="fst-italic">« Outil indispensable pour suivre l'évolution professionnelle de nos diplômés. »</p>
                <div class="d-flex align-items-center"><div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width:48px;height:48px;">PR</div>
                    <div class="ms-3"><strong>Pr. Karim Bennani</strong><br><small class="text-muted">Directeur ENSIASDT</small></div></div></div></div>
        </div>
    </div>
</section>

<!-- CONTACT -->
<section id="contact">
    <div class="container">
        <h2 class="section-title">Contactez-nous</h2>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="pages/contact_submit.php" method="post" class="needs-validation card p-4 shadow-sm" novalidate>
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">Nom complet</label>
                            <input type="text" name="nom" class="form-control" required minlength="2"></div>
                        <div class="col-md-6"><label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required></div>
                        <div class="col-12"><label class="form-label">Sujet</label>
                            <input type="text" name="sujet" class="form-control" required></div>
                        <div class="col-12"><label class="form-label">Message</label>
                            <textarea name="message" rows="4" class="form-control" required minlength="10"></textarea></div>
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-send"></i> Envoyer</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
