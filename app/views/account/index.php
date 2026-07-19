<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>

    <h2>Dashboard</h2>

    <p>Welcome, <?php echo htmlspecialchars($email); ?>!</p>

    <form action="/logout" method="POST">
        <button type="submit">Logout</button>
    </form>

    <br>

    <button onclick="window.location.href='/account/settings'">Settings</button>

</body>
</html>
