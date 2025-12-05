<?php
require 'db.php';
include 'header.php';

$stmt = $pdo->query('SELECT * FROM posts ORDER BY created_at DESC');
$posts = $stmt->fetchAll();
?>
<h2>All Posts</h2>
<?php if (empty($posts)): ?>
  <p>No posts yet.</p>
<?php endif; ?>

<?php foreach ($posts as $p): ?>
  <div class="post">
    <h3><?php echo htmlspecialchars($p['title']); ?></h3>
    <p><?php echo nl2br(htmlspecialchars($p['content'])); ?></p>
    <small>Created at: <?php echo htmlspecialchars($p['created_at']); ?></small>
    <?php if (isset($_SESSION['user'])): ?>
      <div class="actions">
        <a href="edit.php?id=<?php echo (int)$p['id']; ?>">Edit</a>
        <a href="delete.php?id=<?php echo (int)$p['id']; ?>" onclick="return confirm('Delete this post?');">Delete</a>
      </div>
    <?php endif; ?>
  </div>
<?php endforeach; ?>
<?php include 'footer.php'; ?>