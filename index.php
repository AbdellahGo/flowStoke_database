<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: pages/signIn.php");
  exit;
}

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/products.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="./styles/dashboard.css" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet" />
  <title>flowStock - Tableau de bord</title>
</head>

<body>
  <!-- Navbar -->
  <header class="navbar">
    <div class="nav-left">
      <div class="logo-container">
        <img src="./asets/blueLogo.svg" alt="logo" />
        <h2>flowStock</h2>
      </div>
      <nav>
        <ul>
          <li>
            <a href="index.php" class="active">
              <img src="./asets/home.svg" alt="home icon" />
              Accueil
            </a>
          </li>
          <li>
            <a href="pages/administrator.php">
              <img src="./asets/greyUser.svg" alt="user icon" />
              Administrator
            </a>
          </li>
        </ul>
      </nav>
    </div>
    <div class="nav-right">
      <div class="user-info">
        <div>
          <span class="user-name">Robert Lampion</span>
          <small>Secretary</small>
        </div>
        <span class="img-container">
          <img src="./asets/blueUser.svg" alt="" />
        </span>
      </div>
      <a class="logout-btn" href="logout.php">Déconnexion</a>
    </div>
  </header>
  <?php if (!empty($_SESSION['flash_error'])): ?>
    <div style="
    background:#ffcccc;
    color:#b20000;
    padding:12px;
    margin:20px;
    border-left:4px solid red;
    border-radius:6px;
    font-weight:bold;
    ">
      <?= $_SESSION['flash_error'];
      unset($_SESSION['flash_error']); ?>
    </div>
  <?php endif; ?>

  <!-- Main Content -->
  <main class="dashboard">
    <!-- Banner -->
    <section class="welcome-banner">
      <div class="banner-text">
        <?php if (isset($_SESSION['user'])): ?>
          <h1>Bonjour, <?= htmlspecialchars($_SESSION['user']); ?></h1>
        <?php else: ?>
          <p>Vous n'êtes pas connecté.</p>
        <?php endif; ?>
        <p>Bienvenue sur votre tableau de bord flowStock</p>
        <span class="role-badge">
          <img src="./asets/users.svg" alt="users icon" />
          Votre rôle est: <?= htmlspecialchars($_SESSION['role']) ?>
        </span>
      </div>
      <div class="banner-image">
        <img src="./asets/bannerImage.svg" alt="banner image" />
      </div>
    </section>

    <!-- Cards -->
    <section class="cards">
      <div class="card">
        <div>
          <h3>Total Produits</h3>
          <p class="card-value">20</p>
          <span>Produits en stock</span>
        </div>
        <div class="image-container">
          <img src="./asets/blueBox.svg" alt="blue box icon" />
        </div>
      </div>
      <div class="card">
        <div>
          <h3>Valeur Stock</h3>
          <p class="card-value">1 091,00 €</p>
          <span>Valeur totale</span>
        </div>
        <div class="image-container">
          <img src="./asets/money.svg" alt="money icon" />
        </div>
      </div>
      <div class="card">
        <div>
          <h3>Ventes du Mois</h3>
          <p class="card-value">24</p>
          <span>Articles vendus</span>
        </div>
        <div class="image-container">
          <img src="./asets/arrow.svg" alt="arrow icon" />
        </div>
      </div>
    </section>

    <!-- Recent Products -->
    <section class="recent-products">
      <div>
        <img src="./asets/blueBox.svg" alt="blue box" />
        <h2>Produits Récents</h2>
      </div>
      <p>Derniers produits ajoutés au stock</p>
      <ul class="product-list">
        <li>
          <div>
            <strong>Produit8</strong>
            <p>test60 Prénomtest60</p>
          </div>
          <div class="price-stock">
            <span class="price">45,25 €</span>
            <small>Stock: 06</small>
          </div>
        </li>
        <li>
          <div>
            <strong>Produit7</strong>
            <p>Lampion Robert</p>
          </div>
          <div class="price-stock">
            <span class="price">245,50 €</span>
            <small>Stock: 04</small>
          </div>
        </li>
        <li>
          <div>
            <strong>Produit6</strong>
            <p>Dalia Rosa François</p>
          </div>
          <div class="price-stock">
            <span class="price">150,25 €</span>
            <small>Stock: 02</small>
          </div>
        </li>
      </ul>
    </section>

    <!-- Title -->
    <section
      class="page-header"
      style="display: flex; align-items: end; justify-content: space-between">
      <div>
        <h1>
          <img
            style="width: 32px; height: 32px"
            src="./asets/blueBox.svg"
            alt="" />
          Listing des produits
        </h1>
        <p>Gestion et consultation des produits en stock</p>
      </div>
      <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'gestionnaire'): ?>
        <a
          href="./pages/create.php"
          style="font-size: 16px; padding: 6px 12px; background: var(--bg-text-secondary-blue); border-radius: 8px; color: var(--white);">
          Add Produit <i class="fa-solid fa-plus"></i>
        </a>
      <?php endif; ?>

    </section>

    <!-- Search -->
    <section class="search-bar">
      <input
        type="text"
        placeholder="Rechercher un produit, description ou propriétaire..." />
      <button class="filter-btn">
        <img src="./asets/fillter.svg" alt="fillter icon" />
        Filtres
      </button>
    </section>

    <!-- Table -->
    <section class="products-list">
      <div style="display: flex; justify-content: space-between">
        <h2>Produits (9)</h2>
        <div class="download-icons" style="display:flex; gap:10px; align-items:center; margin-bottom:12px;">
          <a class="btn pdf" href="./export/export_pdf.php" style="padding:6px; border-radius:6px; color: black; background:white;">
            <i class="fa-solid fa-file-pdf"></i> PDF
          </a>
          <a class="btn csv" href="./export/export_csv.php" style="padding:6px; border-radius:6px; color: black; background:white;">
            <i class="fa-solid fa-file-csv"></i> CSV
          </a>
        </div>

      </div>
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>Libellé Produit</th>
              <th>Description Produit</th>
              <th>Prix Produit</th>
              <th>Mise en vente le</th>
              <th>Stock Produit</th>
              <th>Propriétaire</th>
              <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'gestionnaire'): ?>
                <th>Actions</th>
              <?php endif; ?>

            </tr>
          </thead>
          <tbody>
            <?php foreach ($products as $product): ?>
              <tr>
                <td><?= htmlspecialchars($product['nom_produit']) ?></td>
                <td><?= htmlspecialchars($product['description_produit']) ?></td>
                <td><?= htmlspecialchars($product['prix_produit']) ?></td>
                <td><?= htmlspecialchars($product['mise_en_vente']) ?></td>
                <td>
                  <span class="stock <?= $product['stock_produit'] > 5 ? 'good' : ($product['stock_produit'] > 0 ? 'low' : 'out') ?>">
                    <?= $product['stock_produit'] ?>
                  </span>
                </td>
                <td><?= htmlspecialchars($product['proprietaire']) ?></td>
                <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'gestionnaire'): ?>
                  <td class="actions">
                    <a href="./pages/view.php?id_produit=<?= $product['id_produit'] ?>"><i class="fa-solid fa-eye"></i></a>
                    <a href="./pages/edit.php?id_produit=<?= $product['id_produit'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                    <a href="./pages/delete.php?id_produit=<?= $product['id_produit'] ?>"><i class="fa-solid fa-trash"></i></a>
                  </td>
                <?php endif; ?>

              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <!-- Footer -->
      <div class="table-footer">
        <p>Affichage de 1 à 9 sur 9 entrées</p>
        <div class="pagination">
          <button>Précédent</button>
          <button class="active">1</button>
          <button>Suivant</button>
        </div>
      </div>
    </section>


  </main>
</body>

</html>