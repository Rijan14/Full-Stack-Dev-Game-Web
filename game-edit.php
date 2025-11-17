<?php include "db-game.php"; ?>
<?php include "navigation.html"; ?>

<?php
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT * FROM games WHERE id = ?");
$stmt->execute([$id]);
$g = $stmt->fetch();
if (!$g) { echo "<div class='container'><div class='alert alert-danger'>Game not found.</div></div>"; exit; }
?>

<div class="container col-md-8">
  <h2 class="mb-4">Edit Game</h2>
  <form method="POST" class="card p-4 shadow-sm">
    <input type="hidden" name="id" value="<?= $g['id']; ?>">

    <div class="mb-3"><input name="title" class="form-control" value="<?= htmlspecialchars($g['title']); ?>" required></div>
    <div class="mb-3"><input name="developer" class="form-control" value="<?= htmlspecialchars($g['developer']); ?>"></div>
    <div class="mb-3"><input name="genre" class="form-control" value="<?= htmlspecialchars($g['genre']); ?>"></div>
    <div class="mb-3"><input name="platform" class="form-control" value="<?= htmlspecialchars($g['platform']); ?>"></div>
    <div class="mb-3"><input name="published_year" type="number" class="form-control" value="<?= htmlspecialchars($g['published_year']); ?>"></div>
    <div class="mb-3"><textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($g['description']); ?></textarea></div>

    <button name="update" class="btn btn-primary">Save Changes</button>
  </form>
</div>

<?php
if (isset($_POST['update'])) {
    $stmt = $pdo->prepare("
      UPDATE games
      SET title = :title, developer = :dev, genre = :genre, platform = :platform, published_year = :year, description = :desc
      WHERE id = :id
    ");
    $stmt->execute([
      ':title'=>$_POST['title'],
      ':dev'=>$_POST['developer'],
      ':genre'=>$_POST['genre'],
      ':platform'=>$_POST['platform'],
      ':year'=>$_POST['published_year'],
      ':desc'=>$_POST['description'],
      ':id'=>$_POST['id']
    ]);

    header("Location: game-details.php?id=".$_POST['id']);
    exit;
}
?>
