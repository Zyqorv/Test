<?php
session_start();

$loadedTimestamp = date("Y-m-d H:i:s");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Session Info</title>
</head>
<body>

    <h2>Current Session Info</h2>

    <p>
        <strong>Page Loaded At:</strong>
        <?php echo htmlspecialchars($loadedTimestamp); ?>
    </p>

    <?php if (!empty($_SESSION)): ?>

        <ul>
            <?php foreach ($_SESSION as $key => $value): ?>
                <li>
                    <strong><?php echo htmlspecialchars($key); ?>:</strong>
                    <?php echo htmlspecialchars(print_r($value, true)); ?>
                </li>
            <?php endforeach; ?>
        </ul>

    <?php else: ?>

        <p>No active session data found.</p>

    <?php endif; ?>

</body>
</html>