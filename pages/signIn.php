<?php
session_start();
require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = strtolower(trim($_POST['email']));
  $password = $_POST['password'];

  $stmt = $pdo->prepare("SELECT id_user, prenom, nom, password, role FROM users WHERE email = :email LIMIT 1");
  $stmt->execute([':email' => $email]);
  $user = $stmt->fetch();

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user'] = $user['prenom'] . ' ' . $user['nom'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['id_user'] = $user['id_user'];
    header("Location: ../index.php");
    exit;
  } else {
    $error = "Identifiants invalides !";
  }
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../styles/signIn.css" />
  <title>flowStock - Connexion</title>
</head>

<body>
  <main>
    <div class="sign-in-container">
      <div class="brand-container">
        <div class="logo-container">
          <img src="../asets/logo.svg" alt="logo" />
        </div>
        <h1 class="brand">flowStock</h1>
        <p>Portail d'identification</p>
      </div>
      <div class="form-container">
        <div class="form-head">
          <h2>Authentification</h2>
          <p>Veuillez vous connecter</p>
        </div>

        <?php if (!empty($error)): ?>
          <p style="color:red; text-align:center;"><?= $error ?></p>
        <?php endif; ?>

        <form method="POST" class="signin-form">
          <div class="input-container">
            <span>Email</span>
            <input
              required
              type="email"
              name="email"
              placeholder="Entrez votre identifiant" />
          </div>
          <div class="input-container">
            <span>Mot de passe</span>
            <input
              min="12"
              required
              type="password"
              name="password"
              placeholder="Entrez votre mot de passe" />
          </div>
          <button type="submit" class="submit-button">Se connecter</button>
        </form>
        <a class="create-account-b" href="signUp.php">
          Créer un compte ?
        </a>
      </div>
    </div>
  </main>
</body>

</html>