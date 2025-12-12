<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../pages/signIn.php");
    exit;
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../vendor/autoload.php';

use Dompdf\Dompdf;

$stmt = $pdo->query("SELECT * FROM produit ORDER BY id_produit ASC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$html = "
<!DOCTYPE html>
<html>
<head>
<meta charset='UTF-8'>
<style>
table {
    width: 100%;
    border-collapse: collapse;
    font-family: Arial;
}
th, td {
    border: 1px solid #ccc;
    padding: 8px;
    font-size: 12px;
}
th {
    background: #f4f4f4;
}
h2 { font-family: Arial; }
</style>
</head>
<body>
<h2>Liste des Produits</h2>
<table>
<thead>
<tr>
  <th>ID</th>
  <th>Nom</th>
  <th>Description</th>
  <th>Prix</th>
  <th>Mise en vente</th>
  <th>Stock</th>
  <th>Propriétaire</th>
</tr>
</thead>
<tbody>
";

foreach ($products as $p) {
    $html .= "
    <tr>
      <td>{$p['id_produit']}</td>
      <td>" . htmlspecialchars($p['nom_produit']) . "</td>
      <td>" . htmlspecialchars($p['description_produit']) . "</td>
      <td>{$p['prix_produit']}</td>
      <td>{$p['mise_en_vente']}</td>
      <td>{$p['stock_produit']}</td>
      <td>" . htmlspecialchars($p['proprietaire']) . "</td>
    </tr>";
}

$html .= "
</tbody>
</table>
</body>
</html>
";

// Generate PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("produits_" . date("Ymd_His") . ".pdf", ["Attachment" => true]);
exit;
