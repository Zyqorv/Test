<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings</title>
</head>
<body>
    <h2>Account Settings</h2>

    <?php if (!empty($statusMessage)): ?>
        <p style="color: <?php echo $statusType === 'error' ? 'red' : 'green'; ?>;">
            <?php echo htmlspecialchars($statusMessage); ?>
        </p>
    <?php endif; ?>

    <form action="/account/changeEmail" method="POST">
        <fieldset>
            <legend>Change Email</legend>

            <label for="current_password_email">Current Password:</label><br>
            <input type="password" id="current_password_email" name="current_password" required><br><br>

            <label for="new_email">New Email:</label><br>
            <input type="email" id="new_email" name="new_email" required><br><br>

            <button type="submit">Change Email</button>
        </fieldset>
    </form>

    <br>

    <form action="/account/changePassword" method="POST">
        <fieldset>
            <legend>Change Password</legend>

            <label for="current_password_password">Current Password:</label><br>
            <input type="password" id="current_password_password" name="current_password" required><br><br>

            <label for="new_password">New Password:</label><br>
            <input type="password" id="new_password" name="new_password" required><br><br>

            <label for="confirm_password">Confirm New Password:</label><br>
            <input type="password" id="confirm_password" name="confirm_password" required><br><br>

            <button type="submit">Change Password</button>
        </fieldset>
    </form>

    <br>

    <button onclick="window.location.href='/account/'">Back to Dashboard</button>
</body>
</html>
