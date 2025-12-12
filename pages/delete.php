<?php
session_start();
if ($_SESSION['role'] === 'secretariat') {
    $_SESSION['flash_error'] = "Vous n'avez pas la permission d'accéder à cette page.";
    header("Location: ../index.php");
    exit;
}
if (!isset($_SESSION['user'])) {
    header("Location: pages/signIn.php");
    exit;
}

require_once __DIR__ . '/../config/database.php';

if (!isset($_GET['id_produit']) || !is_numeric($_GET['id_produit'])) {
    header("Location: ../index.php");
    exit;
}

$id_produit = (int) $_GET['id_produit'];

$stmt = $pdo->prepare("SELECT nom_produit FROM produit WHERE id_produit = :id");
$stmt->execute([':id' => $id_produit]);
$product = $stmt->fetch();

if (!$product) {
    $_SESSION['flash_error'] = "Produit introuvable.";
    header("Location: ../index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $delete = $pdo->prepare("DELETE FROM produit WHERE id_produit = :id");
    $delete->execute([':id' => $id_produit]);

    $_SESSION['flash_success'] = "Produit supprimé avec succès !";
    header("Location: ../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Supprimer Produit</title>
    <link rel="stylesheet" href="../styles/delete.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
      rel="stylesheet"
    />
</head>
<body>
    <div class="container">
        <h1>Supprimer Produit</h1>

        <p>Êtes-vous sûr de vouloir supprimer <strong><?= htmlspecialchars($product['nom_produit']) ?></strong> ?</p>

        <div class="actions">
            <form method="POST">
                <button type="submit" class="btn danger">Oui, Supprimer</button>
            </form>

            <a href="../index.php" class="btn primary">Annuler</a>
        </div>
    </div>
</body>
</html>
