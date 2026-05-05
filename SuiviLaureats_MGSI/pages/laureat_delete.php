<?php
/**
 * pages/laureat_delete.php — Suppression d'un lauréat (admin).
 */
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/functions.php';
require_admin();

$id = (int)($_GET['id'] ?? 0);
if ($id) {
    $stmt = $pdo->prepare('DELETE FROM laureats WHERE id = :id');
    $stmt->execute([':id' => $id]);
    flash('success','Lauréat supprimé.');
}
header('Location: laureats.php');
exit;
