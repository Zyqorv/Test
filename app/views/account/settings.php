<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PreDictio &mdash; Profile</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>


    <main class="auth-card">


        <div class="tiles" id="tiles" aria-label="PreDictio"></div>


        <p class="tagline">Update your account information.</p>


        <?php if (!empty($statusMessage)): ?>
            <p style="color: <?php echo $statusType === 'error' ? 'red' : 'green'; ?>;">
                <?php echo htmlspecialchars($statusMessage); ?>
            </p>
        <?php endif; ?>


        <form class="auth-form" action="/account/changeEmail" method="POST">


            <div class="field">
                <label for="new_email">New Email</label>
                <input
                    type="email"
                    id="new_email"
                    name="new_email"
                    placeholder="Enter your new email"
                    required>
            </div>


            <button type="submit" class="btn btn-primary">
                Update Email
            </button>


        </form>


        <div class="divider">
            <span>or</span>
        </div>


        <!-- Change Password -->
        <form class="auth-form" action="/account/changePassword" method="POST">


            <div class="field">
                <label for="new_password">New Password</label>
                <input
                    type="password"
                    id="new_password"
                    name="new_password"
                    placeholder="Enter your new password"
                    required>
            </div>


            <div class="field">
                <label for="confirm_password">Confirm New Password</label>
                <input
                    type="password"
                    id="confirm_password"
                    name="confirm_password"
                    placeholder="Confirm your new password"
                    required>
            </div>


            <button type="submit" class="btn btn-primary">
                Update Password
            </button>


        </form>


        <a href="/account/" class="forgot-link">Back to Dashboard</a>


        <form action="/logout" method="POST" style="margin-top: 1rem;">
            <button type="submit" class="btn btn-secondary">
                Logout
            </button>
        </form>


    </main>


    <script src="/js/tiles.js"></script>


</body>
</html>
