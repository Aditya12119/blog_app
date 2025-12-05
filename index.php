<?php
require 'db.php';
include 'header.php';

// ---------------- CONFIG ----------------
$limit = 5; // posts per page
$page = max(1, (int)($_GET['page'] ?? 1));
$offset = ($page - 1) * $limit;

// ---------------- SEARCH ----------------
$search = trim($_GET['q'] ?? '');
$where = '';
$params = [];

if ($search !== '') {
  $where = 'WHERE title LIKE ? OR content LIKE ?';
  $params[] = "%$search%";
  $params[] = "%$search%";
}

// ---------------- COUNT POSTS ----------------
$countSql = "SELECT COUNT(*) FROM posts $where";
$countStmt = $pdo->prepare($countSql);
$countStmt->execute($params);
$total = (int)$countStmt->fetchColumn();
$totalPages = max(1, (int)ceil($total / $limit));

// ---------------- FETCH POSTS ----------------
$listSql = "SELECT * FROM posts $where ORDER BY created_at DESC LIMIT ? OFFSET ?";
$listStmt = $pdo->prepare($listSql);

// bind search params first
$i = 1;
foreach ($params as $p) {
  $listStmt->bindValue($i++, $p, PDO::PARAM_STR);
}
$listStmt->bindValue($i++, $limit, PDO::PARAM_INT);
$listStmt->bindValue($i++, $offset, PDO::PARAM_INT);

$listStmt->execute();
$posts = $listStmt->fetchAll();
?>

<h2>All Posts</h2>

<!-- Search bar -->
<form method="get" action="index.php">
  <input type="text" name="q" placeholder="Search posts..." 
         value="<?php echo htmlspecialchars($search); ?>">
  <button type="submit">Search</button>
  <?php if ($search !== ''): ?>
    <a href="index.php">Clear</a>
  <?php endif; ?>
</form>

<?php if (empty($posts)): ?>
  <p>No posts<?php echo $search ? ' found for “' . htmlspecialchars($search) . '”' : ''; ?>.</p>
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

<!-- Pagination -->
<?php if ($totalPages > 1): ?>
  <div class="pagination">
    <?php
      $qParam = $search !== '' ? '&q=' . urlencode($search) : '';

      // Previous link
      if ($page > 1) {
        echo "<a href='index.php?page=" . ($page-1) . "$qParam'>&laquo; Prev</a> ";
      }

      // Page numbers
      for ($i = 1; $i <= $totalPages; $i++) {
        if ($i == $page) {
          echo "<strong>$i</strong> ";
        } else {
          echo "<a href='index.php?page=$i$qParam'>$i</a> ";
        }
      }

      // Next link
      if ($page < $totalPages) {
        echo "<a href='index.php?page=" . ($page+1) . "$qParam'>Next &raquo;</a>";
      }
    ?>
  </div>
<?php endif; ?>

<?php include 'footer.php'; ?>