<?php
require "db-game.php";
header("Content-Type: application/json; charset=utf-8");

// Build dynamic query
$q = isset($_GET['q']) ? "%".$_GET['q']."%" : "%";
$genre = isset($_GET['genre']) ? "%".$_GET['genre']."%" : "%";
$platform = isset($_GET['platform']) ? "%".$_GET['platform']."%" : "%";
$year = isset($_GET['year']) && $_GET['year'] !== "" ? (int)$_GET['year'] : null;

$sql = "SELECT id, title, genre, platform, published_year FROM games WHERE title LIKE :q AND genre LIKE :genre AND platform LIKE :platform";
$params = [':q'=>$q, ':genre'=>$genre, ':platform'=>$platform];

if ($year !== null) {
    $sql .= " AND published_year = :year";
    $params[':year'] = $year;
}

$sql .= " ORDER BY created_at DESC LIMIT 100";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($rows);
