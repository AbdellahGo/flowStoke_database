<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../pages/signIn.php");
    exit;
}

require_once __DIR__ . '/../config/database.php';

if (!isset($_GET['id_user']) || !is_numeric($_GET['id_user'])) {
    header("Location: administrator.php");
    exit;
}

$id_user = (int) $_GET['id_user'];

$stmt = $pdo->prepare("SELECT * FROM users WHERE id_user = :id");
$stmt->execute([':id' => $id_user]);
$user = $stmt->fetch();

if (!$user) {
    header("Location: administrator.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Voir Utilisateur</title>
  <link rel="stylesheet" href="../styles/secretary.css">
  <link rel="stylesheet" href="../styles/userForm.css">
</head>

<body>
  <main class="secretary-dashboard">

    <h1 style="margin-bottom: 20px;">Détails de l'utilisateur</h1>

    <div class="form-container" style="max-width:420px;">

      <p><strong>Prénom:</strong> <?= htmlspecialchars($user['prenom']) ?></p>
      <p><strong>Nom:</strong> <?= htmlspecialchars($user['nom']) ?></p>
      <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
      <p><strong>Nom utilisateur:</strong> <?= htmlspecialchars($user['username']) ?></p>
      <p><strong>Rôle:</strong> <?= htmlspecialchars($user['role']) ?></p>
      <p><strong>Date création:</strong> <?= htmlspecialchars($user['date_creation']) ?></p>

      <a href="administrator.php" class="submit-btn" style="text-align:center; margin-top:10px;">Retour</a>

    </div>

  </main>
</body>

</html>
