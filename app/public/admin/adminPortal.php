<?php
session_start();

if (!isset($_SESSION["admin_username"])) {
    header("Location: adminLogin.php");
    exit();
}

$username = $_SESSION["admin_username"] ?? "Admin";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Portal</title>
</head>
<body>

    <h2>Admin Portal</h2>

    <p>Currently logged in as: <?php echo htmlspecialchars($username); ?></p>

    <button onclick="window.location.href='adminDatabase.php'">Database Query</button>
    <button onclick="window.location.href='adminLogs.php'">View Logs</button>

    <br><br>

    <form action="logout.php" method="POST">
        <button type="submit">Logout</button>
    </form>

</body>
</html>
