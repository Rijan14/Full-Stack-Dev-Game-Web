<?php
require "db-game.php";

$id = intval($_GET['id']);

$stmt = $pdo->prepare("UPDATE games SET title=?, developer=?, genre=?, platform=?, published_year=?, description=? WHERE id=?");

$stmt->execute([
    $_POST['title'],
    $_POST['developer'],
    $_POST['genre'],
    $_POST['platform'],
    $_POST['published_year'],
    $_POST['description'],
    $id
]);

header("Location: game-details.php?id=$id");
exit;
?>
