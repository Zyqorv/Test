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
    <title>PreDictio &mdash; Profile</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <main class="auth-card">

        <div class="tiles" id="tiles" aria-label="PreDictio"></div>

        <p class="tagline">Update your account information.</p>

        <!--
            TODO (needs Nickita): updateProfile.php does not exist yet.
            This form currently has nowhere to submit to. Confirm expected
            field names (email) and response/redirect behavior once the
            backend endpoint exists.
        -->
        <form class="auth-form" action="updateProfile.php" method="POST">

            <div class="field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Update email</button>

        </form>

        <div class="divider">
            <span>or</span>
        </div>

        <!--
            TODO (needs Nickita): same as above, updatePassword.php
            (or a shared updateProfile.php action) does not exist yet.
        -->
        <form class="auth-form" action="updatePassword.php" method="POST">

            <div class="field">
                <label for="current-password">Current password</label>
                <input type="password" id="current-password" name="current_password" placeholder="Enter current password" required>
            </div>

            <div class="field">
                <label for="new-password">New password</label>
                <input type="password" id="new-password" name="new_password" placeholder="Enter new password" required minlength="8">
            </div>

            <button type="submit" class="btn btn-primary">Update password</button>

        </form>

        <a href="dashboard.php" class="forgot-link">Back to dashboard</a>

    </main>

    <script src="js/tiles.js"></script>
</body>
</html>