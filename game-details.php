<?php include "db-game.php"; ?>
<?php include "navigation.html"; ?>

<?php
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT * FROM games WHERE id = ?");
$stmt->execute([$id]);
$g = $stmt->fetch();
if (!$g) {
  echo "<div class='container'><div class='alert alert-danger'>Game not found.</div></div>";
  exit;
}
?>

<div class="container">
  <div class="card p-4 shadow-sm">
    <div class="row">
      <div class="col-md-4">
        <!-- Placeholder image initially, will be replaced by JS -->
        <img id="gameCover" class="img-fluid rounded" 
             src="https://via.placeholder.com/300x400?text=Loading..."
             alt="<?= htmlspecialchars($g['title']); ?>">
      </div>
      <div class="col-md-8">
        <h2><?= htmlspecialchars($g['title']); ?></h2>
        <p><strong>Developer:</strong> <?= htmlspecialchars($g['developer']); ?></p>
        <p><strong>Genre:</strong> <?= htmlspecialchars($g['genre']); ?></p>
        <p><strong>Platform:</strong> <?= htmlspecialchars($g['platform']); ?></p>
        <p><strong>Year:</strong> <?= htmlspecialchars($g['published_year']); ?></p>
        <p><?= nl2br(htmlspecialchars($g['description'])); ?></p>

        <a href="game-edit.php?id=<?= $g['id']; ?>" class="btn btn-warning">Edit</a>
        <a href="game-delete.php?id=<?= $g['id']; ?>" class="btn btn-danger">Delete</a>
        <a href="game-home.php" class="btn btn-secondary">Back to list</a>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const img = document.getElementById('gameCover');
    const title = encodeURIComponent("<?= addslashes($g['title']); ?>");

    // Working image search API (free, no key required)
    fetch(`https://serpapi-proxy.onrender.com/search?q=${title}+game+cover&tbm=isch`)
    .then(res => res.json())
    .then(data => {
        if (data.images_results && data.images_results[0]?.thumbnail) {
            img.src = data.images_results[0].thumbnail;
        } else {
            img.src = 'https://via.placeholder.com/300x400?text=No+Image';
        }
    })
    .catch(() => {
        img.src = 'https://via.placeholder.com/300x400?text=No+Image';
    });
});
</script>
