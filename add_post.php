<?php
require_once 'auth.php';
requireLogin(); // any logged-in user can add posts

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');

    if ($title === '' || strlen($title) < 3) {
        $error = 'Title too short.';
    } elseif ($content === '' || strlen($content) < 5) {
        $error = 'Content too short.';
    } else {
        $stmt = $pdo->prepare('INSERT INTO posts (title, content, created_at) VALUES (?, ?, NOW())');
        $stmt->execute([$title, $content]);
        header('Location: index.php?msg=created');
        exit;
    }
}
?>
<!-- Bootstrap form here -->