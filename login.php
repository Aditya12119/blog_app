<?php
require 'db.php';
include 'header.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $password = $_POST['password'] ?? '';

  if ($username === '' || $password === '') {
    $errors[] = 'Username and password are required.';
  } else {
    $stmt = $pdo->prepare('SELECT id, password FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($password, $user['password'])) {
      $errors[] = 'Invalid username or password.';
    } else {
      $_SESSION['user'] = $username;
      $_SESSION['user_id'] = (int)$user['id'];
      header('Location: index.php');
      exit;
    }
  }
}
?>
<h2>Login</h2>
<?php foreach ($errors as $e): ?>
  <p class="error"><?php echo htmlspecialchars($e); ?></p>
<?php endforeach; ?>

<form method="post" autocomplete="off">
  <label>Username</label>
  <input type="text" name="username" required>
  <label>Password</label>
  <input type="password" name="password" required>
  <button type="submit">Login</button>
</form>
<?php include 'footer.php'; ?>