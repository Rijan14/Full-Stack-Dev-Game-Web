<?php
session_start();
include "../db-game.php"; // adjust path if needed

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $captcha = trim($_POST['captcha'] ?? '');

    if (!$username || !$password || !$captcha) {
        $message = "All fields are required.";
    } elseif ($captcha != $_SESSION['captcha_result']) {
        $message = "Incorrect CAPTCHA answer.";
    } else {
        // Check if username exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->rowCount() > 0) {
            $message = "Username already exists.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            if ($stmt->execute([$username, $hash])) {
                $_SESSION['user'] = $username;
                header("Location: ../game-home.php");
                exit;
            } else {
                $message = "Error creating account.";
            }
        }
    }
}

// Generate simple math CAPTCHA
$num1 = rand(1, 9);
$num2 = rand(1, 9);
$_SESSION['captcha_result'] = $num1 + $num2;
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Signup</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5" style="max-width:400px;">
<h2 class="mb-4">Sign Up</h2>

<?php if($message) echo "<div class='alert alert-danger'>$message</div>"; ?>

<form method="POST">
    <div class="mb-3">
        <label>Username</label>
        <input type="text" name="username" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>CAPTCHA: <?= $num1 ?> + <?= $num2 ?> = ?</label>
        <input type="number" name="captcha" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Sign Up</button>
</form>
<p class="mt-3">Already have an account? <a href="login.php">Login</a></p>
</div>
</body>
</html>
