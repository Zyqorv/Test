<?php
session_start();

if (isset($_SESSION['admin_username'])) {
    header('Location: /admin/');
    exit();
}

$statusMessage = $_GET['status_message'] ?? '';
$statusType = $_GET['status_type'] ?? 'success';

require __DIR__ . '/../../views/admin/login.php';
