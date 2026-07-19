<?php
session_start();

if (!isset($_SESSION["admin_username"])) {
    header("Location: /admin/login");
    exit();
}

$username = $_SESSION["admin_username"] ?? 'Admin';

require __DIR__ . '/../../views/admin/index.php';