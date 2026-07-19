<?php
session_start();

if (isset($_SESSION['email'])) {
    header('Location: /game/');
    exit();
}

require __DIR__ . '/../views/index.php';