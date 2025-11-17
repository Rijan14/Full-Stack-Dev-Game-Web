<?php
include "db-game.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id) {
  $stmt = $pdo->prepare("DELETE FROM games WHERE id = ?");
  $stmt->execute([$id]);
}

header("Location: game-home.php");
exit;
?>
