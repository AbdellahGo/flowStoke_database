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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $delete = $pdo->prepare("DELETE FROM users WHERE id_user = :id");
    $delete->execute([':id' => $id_user]);

    header("Location: administrator.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Supprimer Utilisateur</title>
  <link rel="stylesheet" href="../styles/secretary.css">
</head>

<body>
  <main class="secretary-dashboard">

    <h1>Supprimer Utilisateur</h1>

    <p>Voulez-vous vraiment supprimer :
      <strong><?= htmlspecialchars($user['prenom'] . " " . $user['nom']) ?></strong> ?
    </p>

    <form method="POST" style="margin-top: 20px;">
      <button type="submit" style="
          padding: 10px 16px;
          background: var(--danger-red);
          color: white;
          border-radius: 8px;
          cursor: pointer;">
        Oui, supprimer
      </button>

      <a href="administrator.php"
        style="padding: 10px 16px; margin-left: 10px; background: #ccc; border-radius: 6px; color:black;">
        Annuler
      </a>
    </form>

  </main>
</body>

</html>
