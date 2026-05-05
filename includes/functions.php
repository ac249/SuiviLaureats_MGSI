<?php
/**
 * functions.php — Fonctions utilitaires partagées.
 */

/**
 * Récupère un lauréat par ID.
 */
function get_laureat($pdo, $id) {
    $stmt = $pdo->prepare('SELECT * FROM laureats WHERE id = :id');
    $stmt->execute([':id' => $id]);
    return $stmt->fetch();
}

/**
 * Liste des promotions distinctes.
 */
function get_promotions($pdo) {
    return $pdo->query('SELECT DISTINCT promotion FROM laureats ORDER BY promotion DESC')->fetchAll(PDO::FETCH_COLUMN);
}

/**
 * Liste des secteurs distincts.
 */
function get_secteurs($pdo) {
    return $pdo->query('SELECT DISTINCT secteur FROM laureats WHERE secteur <> "" ORDER BY secteur')->fetchAll(PDO::FETCH_COLUMN);
}

/**
 * Génère un message flash (stocké en session).
 */
function flash($type, $msg) {
    $_SESSION['flash'] = ['type' => $type, 'msg' => $msg];
}

/**
 * Affiche le message flash (et le supprime).
 */
function show_flash() {
    if (!empty($_SESSION['flash'])) {
        $f = $_SESSION['flash'];
        unset($_SESSION['flash']);
        $cls = $f['type'] === 'success' ? 'success' : ($f['type'] === 'error' ? 'danger' : 'info');
        echo '<div class="alert alert-' . $cls . ' alert-dismissible fade show" role="alert">'
            . htmlspecialchars($f['msg'])
            . '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
    }
}
