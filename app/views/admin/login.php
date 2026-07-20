<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PreDictio &mdash; Admin Login</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>

    <main class="auth-card">

        <div class="tiles" id="tiles" aria-label="PreDictio"></div>

        <p class="tagline">Admin Login</p>

        <?php if (!empty($statusMessage)): ?>
            <p class="status-message <?php echo $statusType === 'error' ? 'status-error' : 'status-success'; ?>">
                <?php echo htmlspecialchars($statusMessage); ?>
            </p>
        <?php endif; ?>

        <form class="auth-form" action="/admin/authenticate" method="POST">

            <div class="field">
                <label for="email">Admin Email</label>
                <input
                    type="email"
                    id="admin_email"
                    name="admin email"
                    placeholder="Enter admin email"
                    required
                >
            </div>

            <div class="field">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Enter admin password"
                    required
                >
            </div>

            <button type="submit" class="btn btn-primary">
                Log in
            </button>

            <div class="divider">
                <span>or</span>
            </div>

            <a href="/" class="btn btn-secondary">
                Return to Home Page
            </a>

        </form>

    </main>

    <script src="/js/tiles.js"></script>
</body>
</html>