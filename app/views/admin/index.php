<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Portal</title>
</head>
<body>

    <h2>Admin Portal</h2>

    <p>Currently logged in as: <?php echo htmlspecialchars($username); ?></p>

    <button onclick="window.location.href='/admin/database'">Database Query</button>
    <button onclick="window.location.href='/admin/logs'">View Logs</button>

    <br><br>

    <form action="/logout?redirect_to=/admin/login" method="POST">
        <button type="submit">Logout</button>
    </form>

</body>
</html>