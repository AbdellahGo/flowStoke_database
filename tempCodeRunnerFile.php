<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: pages/signIn.php");
    exit;
}
require_once __DIR__ . '/config/database.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="./styles/dashboard.css" />
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
            <a href="pages/secretary.php">
              <img src="./asets/greyUser.svg" alt="user icon" />
              Secrétaire
            </a>
          </li>
          <li>
            <a href="pages/gastonner.php">
              <img src="./asets/greyUser.svg" alt="user icon" />
              Gastonner
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
          Votre rôle est: Secretary
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
  </main>
</body>

</html>