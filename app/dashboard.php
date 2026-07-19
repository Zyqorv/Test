<?php
session_start();

if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION["email"] ?? "User";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PreDictio &mdash; Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <main class="auth-card">

        <div class="tiles" id="tiles" aria-label="PreDictio"></div>

        <p class="tagline">Welcome, <?php echo htmlspecialchars($email); ?>!</p>

        <div class="auth-form">

            <a href="#" class="btn btn-primary">Play today's word</a>

            <a href="profile.php" class="btn btn-secondary">View profile</a>

            <div class="divider">
                <span>or</span>
            </div>

            <form action="logout.php" method="POST">
                <button type="submit" class="btn btn-secondary">Logout</button>
            </form>

        </div>

    </main>

    <script src="js/tiles.js"></script>
</body>
</html>