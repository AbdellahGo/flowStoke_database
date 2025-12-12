<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: ../pages/signIn.php");
  exit;
}

require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $prenom = trim($_POST['prenom']);
  $nom = trim($_POST['nom']);
  $email = trim($_POST['email']);
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);
  $role = trim($_POST['role']);

  $passwordValid = preg_match('/[A-Z]/', $password) &&  // capital letter
    preg_match('/[a-z]/', $password) &&  // small letter
    preg_match('/[0-9]/', $password) &&  // number
    preg_match('/[\W]/', $password) &&   // special character
    strlen($password) >= 12;

  if (!$passwordValid) {
    $error = "Le mot de passe doit contenir au moins 12 caractères, une majuscule, une minuscule, un chiffre et un symbole.";
  } else if ($prenom && $nom && $email && $username && $role) {

    $stmt = $pdo->prepare("
            INSERT INTO users (prenom, nom, email, username, password, role)
            VALUES (:prenom, :nom, :email, :username, :password, :role)
        ");

    $stmt->execute([
      ':prenom' => $prenom,
      ':nom' => $nom,
      ':email' => $email,
      ':username' => $username,
      ':password' => $password,
      ':role' => $role
    ]);

    header("Location: administrator.php");
    exit;
  } else {
    $error = "Veuillez remplir tous les champs.";
  }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Créer Utilisateur</title>
  <link rel="stylesheet" href="../styles/secretary.css">
  <link rel="stylesheet" href="../styles/userForm.css">
</head>

<body>
  <main class="secretary-dashboard">

    <h1 style="margin-bottom: 20px;">Créer un nouvel utilisateur</h1>

    <?php if (!empty($error)): ?>
      <p style="color:red;"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST" class="form-container">

      <label>Prénom</label>
      <input type="text" name="prenom" required>

      <label>Nom</label>
      <input type="text" name="nom" required>

      <label>Email</label>
      <input type="email" name="email" required>

      <label>Nom d'utilisateur</label>
      <input type="text" name="username" required>

      <label>Mot de passe</label>
      <input type="password" name="password"
        required
        minlength="12"
        pattern="(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W]).{12,}">

      <label>Rôle</label>
      <select name="role" required>
        <option value="secretariat">Secrétariat</option>
        <option value="gestionnaire">Gestionnaire</option>
      </select>

      <button type="submit" class="submit-btn">Créer l'utilisateur</button>

    </form>

  </main>
</body>

</html>