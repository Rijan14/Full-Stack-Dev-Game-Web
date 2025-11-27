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

    // Use Google Images or placeholder API simulation
    fetch(`https://www.googleapis.com/books/v1/volumes?q=intitle:${title}`)
    .then(res => res.json())
    .then(data => {
        if (data.items && data.items[0]?.volumeInfo?.imageLinks?.thumbnail) {
            img.src = data.items[0].volumeInfo.imageLinks.thumbnail.replace(/^http:\/\//i, 'https://');
        } else {
            // fallback placeholder
            img.src = 'https://via.placeholder.com/300x400?text=No+Image';
        }
    })
    .catch(() => {
        img.src = 'https://via.placeholder.com/300x400?text=No+Image';
    });
});
</script>