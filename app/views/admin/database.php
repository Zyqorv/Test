<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PreDictio &mdash; Admin Database</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>


    <main class="game-card">


        <div class="tiles" id="tiles" aria-label="PreDictio"></div>


        <p class="tagline">Database Query</p>


        <form class="auth-form" action="/admin/query" method="POST">


            <div class="field">
                <label for="query">Query</label>
                <textarea id="query" name="query" rows="10" placeholder="Enter SQL query here..."></textarea>
            </div>


            <button type="submit" class="btn btn-primary">Submit</button>


        </form>


        <div class="field" style="margin-top: 16px;">
            <label for="response">Response</label>
            <textarea id="response" rows="8" readonly><?php echo htmlspecialchars($queryResult); ?></textarea>
        </div>


        <div class="auth-form" style="margin-top: 16px;">


            <button onclick="window.location.href='/admin'" class="btn btn-secondary">Back to Admin Portal</button>


            <form action="/logout?redirect_to=/admin/login" method="POST">
                <button type="submit" class="btn btn-secondary">Logout</button>
            </form>


        </div>


    </main>


    <script src="/js/tiles.js"></script>


</body>
</html>
