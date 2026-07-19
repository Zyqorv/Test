<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PreDictio &mdash; Log in</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <main class="auth-card">

        <div class="tiles" id="tiles" aria-label="PreDictio"></div>

        <p class="tagline">Test your vocabulary, one word at a time.</p>

        <form class="auth-form" action="authenticate.php" method="POST">

            <div class="field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="name@email.com" required>
            </div>

            <div class="field">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>

            <button type="submit" class="btn btn-primary">Log in</button>

            <div class="divider">
                <span>or</span>
            </div>

            <a href="register.php" class="btn btn-secondary">Create account</a>

        </form>

    </main>

    <script src="js/tiles.js"></script>
</body>
</html>