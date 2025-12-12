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

$id_produit = isset($_GET['id_produit']) ? $_GET['id_produit'] : null;

if ($id_produit === null || !is_numeric($id_produit)) {
    header("Location: ../index.php");
    exit;
}

$id_produit = (int) $id_produit;

$stmt = $pdo->prepare("SELECT * FROM produit WHERE id_produit = :id_produit");
$stmt->execute([':id_produit' => $id_produit]);
$product = $stmt->fetch();

if (!$product) {
    $_SESSION['flash_error'] = "Produit introuvable.";
    header("Location: ../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails du Produit</title>
    <link rel="stylesheet" href="../styles/view.css">
</head>
<body>
    <div class="container">
        <h1>Détails du Produit</h1>

        <div class="product-card">
            <p><strong>Nom :</strong> <?= htmlspecialchars($product['nom_produit']) ?></p>
            <p><strong>Description :</strong> <?= nl2br(htmlspecialchars($product['description_produit'])) ?></p>
            <p><strong>Prix :</strong> <?= number_format((float)$product['prix_produit'], 2, ',', ' ') ?> €</p>
            <p><strong>Mise en vente :</strong> <?= htmlspecialchars($product['mise_en_vente'] ?? '—') ?></p>
            <p><strong>Stock :</strong> <?= (int) $product['stock_produit'] ?></p>
            <p><strong>Propriétaire :</strong> <?= htmlspecialchars($product['proprietaire'] ?? '—') ?></p>
        </div>

        <a href="../index.php" class="btn">Retour</a>
    </div>
</body>
</html>
