<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/functions.php';
$page_title = 'Mentions légales';
require_once __DIR__ . '/../includes/header.php';
?>
<div class="container py-5">
    <h1>Mentions légales &amp; Politique de confidentialité</h1>
    <h3 class="mt-4">Éditeur</h3>
    <p>Plateforme « Suivi des Lauréats ENSIASDT » réalisée dans le cadre du mini-projet de Développement Web — Filière MGSI, Groupe N°46.<br>
    Auteurs : Chliyah Youssef &amp; El Ghajdaoui Achraf.</p>
    <h3>Hébergement</h3><p>Application déployée à des fins pédagogiques (serveur Apache/MySQL).</p>
    <h3>Données personnelles</h3>
    <p>Les données collectées (nom, email, parcours professionnel) sont utilisées uniquement pour le suivi des lauréats et le réseau d'anciens. Les mots de passe sont stockés sous forme hachée (bcrypt). Conformément à la législation, vous disposez d'un droit d'accès, de rectification et de suppression de vos données.</p>
    <h3>Cookies</h3><p>Le site utilise uniquement des cookies de session pour l'authentification.</p>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
