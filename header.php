<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Blog App</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<nav>
  <a href="index.php">Home</a>
  <?php if(isset($_SESSION['user'])): ?>
    <a href="create.php">New Post</a>
    <span class="who">Logged in as: <?php echo htmlspecialchars($_SESSION['user']); ?></span>
    <a href="logout.php">Logout</a>
  <?php else: ?>
    <a href="register.php">Register</a>
    <a href="login.php">Login</a>
  <?php endif; ?>
</nav>
<hr>