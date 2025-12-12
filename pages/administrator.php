<?php
session_start();

if (!isset($_SESSION['user'])) {
  header("Location: signIn.php");
  exit;
}

if ($_SESSION['role'] !== 'admin') {
  $_SESSION['flash_error'] = "Vous n'avez pas l'autorisation d'accéder à cette page.";
  header("Location: ../index.php");
  exit;
}

require_once __DIR__ . '/../config/database.php';

$stmt = $pdo->query("SELECT * FROM users ORDER BY id_user DESC");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="../styles/secretary.css" />
  <title>flowStock - Admin</title>
</head>

<body>
  <?php include("../components/navBar.php") ?>

  <main class="secretary-dashboard">
    <!-- Banner -->
    <section class="welcome-banner">
      <div class="banner-text">
        <h1>Bonjour <?= htmlspecialchars($_SESSION['user']) ?></h1>
        <p>Espace de gestion des utilisateurs</p>
        <span class="role-badge">
          <img src="../asets/users.svg" alt="users icon" />
          Votre rôle est: <?= htmlspecialchars($_SESSION['role'] ?? '—') ?>
        </span>
      </div>
      <div class="banner-image">
        <img src="../asets/bannerImage.svg" alt="banner image" />
      </div>
    </section>

    <!-- Cards -->
    <?php include("../components/cards.php") ?>

    <!-- Title -->
    <section class="page-header" style="display: flex; align-items: end; justify-content: space-between">
      <div>
        <h1>
          <img style="width: 32px; height: 32px" src="../asets/blueBox.svg" alt="" />
          Gestion des utilisateurs
        </h1>
        <p>Administration complète des utilisateurs du système</p>
      </div>

      <a href="createUser.php" style="
          font-size: 16px;
          padding: 6px 12px;
          background: var(--bg-text-secondary-blue);
          border-radius: 8px;
          color: var(--white);
        ">
        Ajouter Utilisateur
        <i class="fa-solid fa-plus"></i>
      </a>
    </section>

    <section class="search-bar">
      <input type="text" placeholder="Rechercher un utilisateur par nom, email ou rôle..." />
      <button class="filter-btn">
        <img src="../asets/fillter.svg" alt="filter icon" />
        Filtres
      </button>
    </section>

    <section class="products-list">
      <div style="display: flex; justify-content: space-between">
        <h2>Liste des utilisateurs (<?= count($users) ?>)</h2>
      </div>

      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>Nom Complet</th>
              <th>Email</th>
              <th>Nom Utilisateur</th>
              <th>Rôle</th>
              <th>Date Création</th>
              <th>Actions</th>
            </tr>
          </thead>

          <tbody>
            <?php foreach ($users as $user): ?>
              <tr>
                <td><?= htmlspecialchars($user['prenom'] . " " . $user['nom']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td>
                  <span class="<?= $user['role'] === 'admin' ? 'role-admin' : ($user['role'] === 'secretariat' ? 'role-secretariat' : '') ?>">
                    <?= htmlspecialchars($user['role']) ?>
                  </span>
                </td>
                <td><?= htmlspecialchars($user['date_creation']) ?></td>

                <?php if ($_SESSION['role'] === 'admin'): ?>
<td class="actions">
    <a href="../pages/viewUser.php?id_user=<?= $user['id_user'] ?>"><i class="fa-solid fa-eye"></i></a>
    <a href="../pages/editUser.php?id_user=<?= $user['id_user'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
    <a href="../pages/deleteUser.php?id_user=<?= $user['id_user'] ?>"><i class="fa-solid fa-trash"></i></a>
</td>

                <?php endif; ?>

              </tr>
            <?php endforeach; ?>
          </tbody>

        </table>
      </div>
    </section>
  </main>
</body>

</html>