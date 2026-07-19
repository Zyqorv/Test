<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account</title>
</head>
<body>

    <h2>Account</h2>

    <p>Currently logged in as: <?php echo htmlspecialchars($email); ?>!</p>

    <form action="/logout" method="POST">
        <button type="submit">Logout</button>
    </form>

    <br>

    <button onclick="window.location.href='/account/settings'">Settings</button>

</body>
</html>
