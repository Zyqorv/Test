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

        <div class="stats">
            <p>Total Guesses: <span id="total-guesses">Loading...</span></p>
            <p>Total Wins: <span id="total-wins">Loading...</span></p>
            <p>Total Losses: <span id="total-losses">Loading...</span></p>
            <p>Current Streak: <span id="current-streak">Loading...</span></p>
        </div>

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

    <script>
    async function loadStats() {
        try {
            const response = await fetch('/account/getStats', {
                method: 'POST'
            });

            if (!response.ok) {
                throw new Error("Failed to load stats");
            }

            const stats = await response.json();

            document.getElementById('total-guesses').textContent = stats.total_guesses;
            document.getElementById('total-wins').textContent = stats.total_wins;
            document.getElementById('total-losses').textContent = stats.total_losses;
            document.getElementById('current-streak').textContent = stats.current_streak;

        } catch (error) {
            console.error(error);
        }
    }

    loadStats();
    </script>
</body>
</html>
