<?php
session_start();

/*
    Protected page check:
    If user is not logged in, redirect to login page.
*/
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION["email"] ?? "User";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>

    <h2>Dashboard</h2>

    <p>Welcome, <?php echo htmlspecialchars($email); ?>!</p>

    <form action="logout.php" method="POST">
        <button type="submit">Logout</button>
    </form>

</body>
</html>