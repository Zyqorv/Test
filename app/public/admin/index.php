<?php
session_start();

if (!isset($_SESSION["admin_email"])) {
    header("Location: /admin/login");
    exit();
}

$adminEmail = $_SESSION["admin_email"] ?? 'Admin';

require __DIR__ . '/../../views/admin/index.php';