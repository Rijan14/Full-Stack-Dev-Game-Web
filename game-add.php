<?php include "db-game.php"; ?>
<?php include "navigation.html"; ?>

<div class="container col-md-8">
  <h2 class="mb-4">Add New Game</h2>
  <form action="game-add-form.php" method="POST" class="card p-4 shadow-sm">
    <div class="mb-3"><input name="title" class="form-control" placeholder="Game Title" required></div>
    <div class="mb-3"><input name="developer" class="form-control" placeholder="Developer"></div>
    <div class="mb-3"><input name="genre" class="form-control" placeholder="Genre"></div>
    <div class="mb-3"><input name="platform" class="form-control" placeholder="Platform"></div>
    <div class="mb-3"><input name="published_year" type="number" class="form-control" placeholder="Published Year"></div>
    <div class="mb-3"><textarea name="description" class="form-control" rows="4" placeholder="Description"></textarea></div>

    <button class="btn btn-success">Add Game</button>
  </form>
</div>
