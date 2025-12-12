<?php
require_once __DIR__ . '/config/database.php';

$stmt = $pdo->query("SELECT * FROM produit ORDER BY id_produit DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
