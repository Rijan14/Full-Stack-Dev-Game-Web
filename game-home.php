<?php include "db-game.php"; ?>
<?php include "navigation.html"; ?>

<div class="container">
  <h2 class="mb-4">All Games</h2>

  <?php
  $stmt = $pdo->query("SELECT * FROM games ORDER BY title ASC");
  $games = $stmt->fetchAll(PDO::FETCH_ASSOC);
  ?>

  <div class="table-responsive">
    <table class="table table-striped table-bordered align-middle">
      <thead class="table-dark text-center">
        <tr>
          <th>Title</th>
          <th>Developer</th>
          <th>Genre</th>
          <th>Platform</th>
          <th>Year</th>
          <th>Details</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($games as $g): ?>
        <tr>
          <td><?= htmlspecialchars($g['title']); ?></td>
          <td><?= htmlspecialchars($g['developer']); ?></td>
          <td><?= htmlspecialchars($g['genre']); ?></td>
          <td><?= htmlspecialchars($g['platform']); ?></td>
          <td class="text-center"><?= htmlspecialchars($g['published_year']); ?></td>
          <td class="text-center">
            <a href="game-details.php?id=<?= $g['id']; ?>" class="btn btn-info btn-sm">View</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
