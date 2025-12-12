<?php
if (!isset($_SESSION)) session_start();
?>

<header class="navbar">
  <div class="nav-left">
    <div class="logo-container">
      <img src="../asets/blueLogo.svg" alt="logo" />
      <h2>flowStock</h2>
    </div>

    <nav>
      <ul>
        <li>
          <a href="/flowStok/index.php" class="<?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : '' ?>">
            <img src="../asets/home.svg" alt="home icon" />
            Accueil
          </a>
        </li>

        <?php if ($_SESSION['role'] === 'admin'): ?>
          <li>
            <a href="/flowStok/pages/administrator.php" class="<?= basename($_SERVER['PHP_SELF']) === 'administrator.php' ? 'active' : '' ?>">
              <img src="../asets/greyUser.svg" alt="user icon" />
              Administrator
            </a>
          </li>
        <?php endif; ?>
      </ul>
    </nav>
  </div>

  <div class="nav-right">
    <div class="user-info">
      <div>
        <span class="user-name"><?= htmlspecialchars($_SESSION['user']) ?></span>
        <small><?= htmlspecialchars($_SESSION['role']) ?></small>
      </div>
      <span class="img-container">
        <img src="../asets/blueUser.svg" alt="" />
      </span>
    </div>

    <a class="logout-btn" href="/flowStok/logout.php">Déconnexion</a>
  </div>
</header>