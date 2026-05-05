<?php


// Affichage des erreurs en développement
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Constantes globales
define('APP_NAME', 'Suivi des Lauréats ENSIASDT');
define('APP_URL', 'http://localhost/SuiviLaureats_MGSI');
define('APP_VERSION', '1.0.0');

// Paramètres de connexion à la base de données MySQL
define('DB_HOST', 'localhost');
define('DB_NAME', 'suivi_laureats_ensiasdt');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Connexion PDO (requêtes préparées partout)
try {
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    die('Erreur de connexion à la base de données : ' . htmlspecialchars($e->getMessage()));
}

// Démarrage de la session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Vérifie si l'utilisateur est connecté, sinon redirige vers login.
 */
function require_login() {
    if (empty($_SESSION['user_id'])) {
        header('Location: ' . APP_URL . '/pages/login.php');
        exit;
    }
}

/**
 * Vérifie le rôle administrateur.
 */
function require_admin() {
    require_login();
    if (($_SESSION['role'] ?? '') !== 'admin') {
        header('Location: ' . APP_URL . '/pages/dashboard.php');
        exit;
    }
}

/**
 * Échappe les caractères pour affichage HTML.
 */
function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
