<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PreDictio &mdash; Account</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>


    <main class="auth-card">


        <div class="tiles" id="tiles" aria-label="PreDictio"></div>


        <p class="tagline">Currently logged in as: <?php echo htmlspecialchars($email); ?>!</p>


        <div class="auth-form">


            <button onclick="window.location.href='/game'" class="btn btn-primary">To Game</button>


            <button onclick="window.location.href='/account/settings'" class="btn btn-secondary">Settings</button>


            <div class="divider">
                <span>or</span>
            </div>


            <form action="/logout" method="POST">
                <button type="submit" class="btn btn-secondary">Logout</button>
            </form>


        </div>


    </main>


    <script src="/js/tiles.js"></script>


</body>
</html>
