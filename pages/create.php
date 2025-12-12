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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom_produit = htmlspecialchars($_POST['nom_produit']);
    $description_produit = htmlspecialchars($_POST['description_produit']);
    $prix_produit = $_POST['prix_produit'];
    $stock_produit = $_POST['stock_produit'];
    $proprietaire = htmlspecialchars($_POST['proprietaire']);

    $stmt = $pdo->prepare("INSERT INTO produit (nom_produit, description_produit, prix_produit, stock_produit, proprietaire) VALUES (:nom_produit, :description_produit, :prix_produit, :stock_produit, :proprietaire)");
    $stmt->execute([
        ':nom_produit' => $nom_produit,
        ':description_produit' => $description_produit,
        ':prix_produit' => $prix_produit,
        ':stock_produit' => $stock_produit,
        ':proprietaire' => $proprietaire
    ]);

    header("Location: create.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Créer un produit - FlowStock</title>
  <link rel="stylesheet" href="../styles/create.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>
  <main class="container">
    <div class="page-header">
      <h1>Créer un produit</h1>
      <p>Ajoutez un nouveau produit dans votre stock.</p>
    </div>

    <form method="POST" class="product-form">
      <div class="form-group">
        <label for="nom_produit">Libellé Produit</label>
        <input type="text" name="nom_produit" id="nom_produit" required />
      </div>
      <div class="form-group">
        <label for="description_produit">Description Produit</label>
        <textarea name="description_produit" id="description_produit" required></textarea>
      </div>
      <div class="form-group">
        <label for="prix_produit">Prix (€)</label>
        <input type="number" name="prix_produit" id="prix_produit" step="0.01" required />
      </div>
      <div class="form-group">
        <label for="stock_produit">Quantité en stock</label>
        <input type="number" name="stock_produit" id="stock_produit" required />
      </div>
      <div class="form-group">
        <label for="proprietaire">Propriétaire</label>
        <input type="text" name="proprietaire" id="proprietaire" required />
      </div>

      <div class="form-actions">
        <button type="submit" class="btn primary"><i class="fa-solid fa-plus"></i> Créer le produit</button>
        <a href="../index.php" class="btn secondary">Annuler</a>
      </div>
    </form>
  </main>
</body>
</html>
