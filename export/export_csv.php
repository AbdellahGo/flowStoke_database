<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../pages/signIn.php");
    exit;
}

require_once __DIR__ . '/../config/database.php';

header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="produits_' . date('Ymd_His') . '.csv"');

echo "\xEF\xBB\xBF";

$out = fopen('php://output', 'w');

fputcsv($out, ['ID', 'Nom', 'Description', 'Prix', 'Mise en vente', 'Stock', 'Propriétaire'], ';');

$stmt = $pdo->query("SELECT * FROM produit ORDER BY id_produit ASC");

while ($p = $stmt->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($out, [
        $p['id_produit'],
        $p['nom_produit'],
        $p['description_produit'],
        $p['prix_produit'],
        $p['mise_en_vente'],
        $p['stock_produit'],
        $p['proprietaire']
    ], ';');
}

fclose($out);
exit;
