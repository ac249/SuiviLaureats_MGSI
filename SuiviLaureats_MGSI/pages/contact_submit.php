<?php

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $stmt = $pdo->prepare('INSERT INTO messages_contact (nom,email,sujet,message) VALUES (:n,:e,:s,:m)');
    $stmt->execute([
        ':n'=>trim($_POST['nom']??''), ':e'=>trim($_POST['email']??''),
        ':s'=>trim($_POST['sujet']??''), ':m'=>trim($_POST['message']??'')
    ]);
    flash('success','Votre message a bien été envoyé. Merci !');
}
header('Location: ../index.php#contact'); exit;
