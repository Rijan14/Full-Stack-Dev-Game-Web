<?php include "db-game.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("
        INSERT INTO games (title, developer, genre, platform, published_year, description)
        VALUES (:title, :developer, :genre, :platform, :year, :desc)
    ");
    $stmt->execute([
      ':title'=>$_POST['title'],
      ':developer'=>$_POST['developer'],
      ':genre'=>$_POST['genre'],
      ':platform'=>$_POST['platform'],
      ':year'=>$_POST['published_year'],
      ':desc'=>$_POST['description']
    ]);

    header("Location: game-home.php");
    exit;
}
?>
