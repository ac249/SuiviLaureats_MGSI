<?php

if (!defined('APP_NAME')) {
    require_once __DIR__ . '/../config.php';
}
$page_title = $page_title ?? 'Accueil';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Système de suivi des lauréats de l'ENSIASDT — base de données des diplômés, réseau d'anciens, insertion professionnelle.">
    <meta name="keywords" content="ENSIASDT, lauréats, diplômés, alumni, insertion professionnelle">
    <meta name="author" content="Chliyah Youssef &amp; El Ghajdaoui Achraf">
    <title><?= e($page_title) ?> — <?= e(APP_NAME) ?></title>
    <link rel="stylesheet" href="<?= e(APP_URL) ?>/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= e(APP_URL) ?>/css/style.css">
</head>
<body>
<?php require_once __DIR__ . '/navbar.php'; ?>
<main class="main-content">
