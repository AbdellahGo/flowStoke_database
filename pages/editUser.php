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

    $prenom = trim($_POST['prenom']);
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $role = trim($_POST['role']);
    $newPassword = trim($_POST['password']);

    if ($prenom && $nom && $email && $username && $role) {

        if (!empty($newPassword)) {

            $passwordValid = preg_match('/[A-Z]/', $newPassword) &&
                             preg_match('/[a-z]/', $newPassword) &&
                             preg_match('/[0-9]/', $newPassword) &&
                             preg_match('/[\W]/', $newPassword) &&
                             strlen($newPassword) >= 12;

            if (!$passwordValid) {
                $error = "Le mot de passe doit contenir 12 caractères minimum, 1 majuscule, 1 minuscule, 1 chiffre et 1 symbole.";
            } else {

                $update = $pdo->prepare("
                    UPDATE users 
                    SET prenom = :prenom, nom = :nom, email = :email,
                        username = :username, role = :role, password = :password
                    WHERE id_user = :id
                ");

                $update->execute([
                    ':prenom' => $prenom,
                    ':nom' => $nom,
                    ':email' => $email,
                    ':username' => $username,
                    ':password' => $newPassword,
                    ':role' => $role,
                    ':id' => $id_user
                ]);

                header("Location: admin.php");
                exit;
            }

        } else {

            // Update without password
            $update = $pdo->prepare("
                UPDATE users 
                SET prenom = :prenom, nom = :nom, email = :email,
                    username = :username, role = :role
                WHERE id_user = :id
            ");

            $update->execute([
                ':prenom' => $prenom,
                ':nom' => $nom,
                ':email' => $email,
                ':username' => $username,
                ':role' => $role,
                ':id' => $id_user
            ]);

            header("Location: administrator.php");
            exit;
        }

    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Modifier Utilisateur</title>
  <link rel="stylesheet" href="../styles/secretary.css">
  <link rel="stylesheet" href="../styles/userForm.css">
</head>

<body>
  <main class="secretary-dashboard">

    <h1 style="margin-bottom: 20px;">Modifier l'utilisateur</h1>

    <?php if (!empty($error)): ?>
      <p style="color:red;"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST" class="form-container">

      <label>Prénom</label>
      <input type="text" name="prenom" value="<?= htmlspecialchars($user['prenom']) ?>" required>

      <label>Nom</label>
      <input type="text" name="nom" value="<?= htmlspecialchars($user['nom']) ?>" required>

      <label>Email</label>
      <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

      <label>Nom d’utilisateur</label>
      <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>

      <label>Nouveau mot de passe (facultatif)</label>
      <input type="password" name="password"
        minlength="12"
        pattern="(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W]).{12,}">
      <small style="color:gray;">Laissez vide pour ne pas changer.</small>

      <label>Rôle</label>
      <select name="role">
        <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
        <option value="secretariat" <?= $user['role'] === 'secretariat' ? 'selected' : '' ?>>Secrétariat</option>
        <option value="gestionnaire" <?= $user['role'] === 'gestionnaire' ? 'selected' : '' ?>>Gestionnaire</option>
      </select>

      <button type="submit" class="submit-btn">Enregistrer</button>

    </form>

  </main>
</body>

</html>
