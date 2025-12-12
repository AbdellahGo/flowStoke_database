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

$id_produit = $_GET['id_produit'] ?? null;

if (!$id_produit) {
  die('Erreur: ID du produit non spécifié.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nom_produit = htmlspecialchars($_POST['nom_produit']);
  $description_produit = htmlspecialchars($_POST['description_produit']);
  $prix_produit = $_POST['prix_produit'];
  $stock_produit = $_POST['stock_produit'];
  $proprietaire = htmlspecialchars($_POST['proprietaire']);

  $stmt = $pdo->prepare("UPDATE produit SET nom_produit = :nom_produit, description_produit = :description_produit, prix_produit = :prix_produit, stock_produit = :stock_produit, proprietaire = :proprietaire WHERE id_produit = :id_produit");
  $stmt->execute([
    ':nom_produit' => $nom_produit,
    ':description_produit' => $description_produit,
    ':prix_produit' => $prix_produit,
    ':stock_produit' => $stock_produit,
    ':proprietaire' => $proprietaire,
    ':id_produit' => $id_produit
  ]);

    header("Location: ../index.php");
  exit;
}

$stmt = $pdo->prepare("SELECT * FROM produit WHERE id_produit = :id_produit");
$stmt->execute([':id_produit' => $id_produit]);
$product = $stmt->fetch();

if (!$product) {
  die('Produit non trouvé.');
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <title>Modifier Produit</title>
  <link rel="stylesheet" href="../styles/edit.css" />
</head>

<body>
  <div class="container">
    <h1>Modifier Produit</h1>
    <form method="POST">
      <label>Nom du produit</label>
      <input type="text" name="nom_produit" value="<?= htmlspecialchars($product['nom_produit']) ?>" required />

      <label>Description</label>
      <textarea name="description_produit" required><?= htmlspecialchars($product['description_produit']) ?></textarea>

      <label>Prix (€)</label>
      <input type="number" name="prix_produit" value="<?= $product['prix_produit'] ?>" step="0.01" required />

      <label>Stock</label>
      <input type="number" name="stock_produit" value="<?= $product['stock_produit'] ?>" required />

      <label>Propriétaire</label>
      <input type="text" name="proprietaire" value="<?= htmlspecialchars($product['proprietaire']) ?>" required />

      <button type="submit" class="btn">Enregistrer</button>
      <a href="../index.php" class="btn cancel">Annuler</a>
    </form>
  </div>
</body>

</html>