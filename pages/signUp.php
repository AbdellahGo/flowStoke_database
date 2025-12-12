<?php
require_once __DIR__ . '/../config/database.php';
session_start();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prenom   = trim($_POST['prenom']);
    $nom      = trim($_POST['nom']);
    $email    = strtolower(trim($_POST['email']));
    $username = trim($_POST['username']);
    $role     = trim($_POST['role']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm'];

    if ($password !== $confirm) {
        $message = "<p style='color:red;'>Les mots de passe ne correspondent pas.</p>";
    } elseif (strlen($password) < 12 ||
              !preg_match('/[0-9]/', $password) ||
              !preg_match('/[\W_]/', $password)) {
        $message = "<p style='color:red;'>Le mot de passe doit contenir au moins 12 caractères, un chiffre et un caractère spécial.</p>";
    } else {
        $stmt = $pdo->prepare("SELECT id_user FROM users WHERE email = :email OR username = :username LIMIT 1");
        $stmt->execute([':email' => $email, ':username' => $username]);
        if ($stmt->fetch()) {
            $message = "<p style='color:red;'>Email ou nom d'utilisateur déjà utilisé.</p>";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $ins = $pdo->prepare("INSERT INTO users (prenom, nom, email, username, password, role) VALUES (:prenom, :nom, :email, :username, :password, :role)");
            $ins->execute([
                ':prenom' => $prenom,
                ':nom' => $nom,
                ':email' => $email,
                ':username' => $username,
                ':password' => $hash,
                ':role' => $role
            ]);
            $message = "<p style='color:green;'>Compte créé avec succès pour $prenom $nom ($email)</p>";
            header("Location: ../index.php");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../styles/signUp.css">
    <title>flowStock - Créer un compte</title>
  </head>

  <body>
    <main>
      <div class="register-container">
        <div class="brand-container">
          <div class="logo-container">
            <img src="../asets/logo.svg" alt="logo" />
          </div>
          <h1 class="brand">flowStock</h1>
          <p>Création de compte</p>
        </div>

        <div class="form-container">
          <div class="form-head">
            <h2>Créer un compte</h2>
            <p>Rejoignez notre plateforme de gestion de stock</p>
          </div>

          <?php if (!empty($message)) echo $message; ?>

          <form method="POST" class="register-form">
            <div class="input-row">
              <div class="input-container">
                <span>Prénom *</span>
                <input type="text" name="prenom" placeholder="Votre prénom" required />
              </div>
              <div class="input-container">
                <span>Nom *</span>
                <input type="text" name="nom" placeholder="Votre nom" required />
              </div>
            </div>

            <div class="input-container">
              <span>Email *</span>
              <input type="email" name="email" placeholder="votre.email@exemple.com" required />
            </div>

            <div class="input-container">
              <span>Nom d'utilisateur *</span>
              <input type="text" name="username" placeholder="Choisissez un nom d'utilisateur" required />
            </div>

            <div class="input-container">
              <span>Rôle demandé *</span>
              <select name="role" required>
                <option value="">Sélectionnez votre rôle</option>
                <option value="admin">Administrateur</option>
                <option value="gestionnaire">Gestionnaire</option>
                <option value="secretariat">Secrétariat</option>
              </select>
            </div>

            <div class="input-row">
              <div class="input-container">
                <span>Mot de passe *</span>
                <input type="password" name="password" placeholder="Minimum 6 caractères" minlength="12" required />
              </div>
              <div class="input-container">
                <span>Confirmer le mot de passe *</span>
                <input type="password" name="confirm" placeholder="Confirmez votre mot de passe" required />
              </div>
            </div>
            <button type="submit" class="submit-button">Créer mon compte</button>
          </form>

          <a href="signIn.php" class="return-login">← Retour à la connexion</a>
        </div>
      </div>
    </main>
  </body>
</html>
