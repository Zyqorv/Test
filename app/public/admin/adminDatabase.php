<?php
session_start();

if (!isset($_SESSION["admin_username"])) {
    header("Location: adminLogin.php");
    exit();
}

$queryResult = $_SESSION["admin_query_result"] ?? "Query results will appear here.";
unset($_SESSION["admin_query_result"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Database</title>
</head>
<body>

    <h2>Database Query</h2>

    <form action="adminQuery.php" method="POST">
        <textarea name="query" rows="10" cols="60" placeholder="Enter SQL query here..."></textarea><br><br>
        <button type="submit">Submit</button>
    </form>

    <br>

    <label for="response">Response:</label><br>
    <textarea id="response" rows="8" cols="60" readonly><?php echo htmlspecialchars($queryResult); ?></textarea><br><br>

    <button onclick="window.location.href='adminPortal.php'">Back to Admin Portal</button>

</body>
</html>
