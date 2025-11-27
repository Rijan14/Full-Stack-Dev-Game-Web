<?php include "db-game.php"; ?>
<?php include "navigation.html"; ?>

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar: Genre Filter -->
    <div class="col-md-3 mb-4">
      <div class="card p-3 shadow-sm">
        <h5 class="mb-3">Filter by Genre</h5>
        <select id="genreFilter" class="form-select">
          <option value="">All Genres</option>
          <?php
          $genres = $pdo->query("SELECT DISTINCT genre FROM games ORDER BY genre ASC")->fetchAll(PDO::FETCH_COLUMN);
          foreach ($genres as $genre) {
              echo "<option value=\"" . htmlspecialchars($genre) . "\">" . htmlspecialchars($genre) . "</option>";
          }
          ?>
        </select>
      </div>
    </div>

    <!-- Main Content: Games Table -->
    <div class="col-md-9">
      <h2 class="mb-4">All Games</h2>

      <?php
      $stmt = $pdo->query("SELECT * FROM games ORDER BY title ASC");
      $games = $stmt->fetchAll(PDO::FETCH_ASSOC);
      ?>

      <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle" id="gamesTable">
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
            <tr data-genre="<?= htmlspecialchars($g['genre']); ?>">
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
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById('genreFilter').addEventListener('change', function() {
    const genre = this.value;
    const rows = document.querySelectorAll('#gamesTable tbody tr');
    rows.forEach(row => {
        if (!genre || row.getAttribute('data-genre') === genre) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>
