<?php
session_start();

if (isset($_SESSION['email'])) {
    header('Location: /account/');
    exit();
}

$statusMessage = $_GET['status_message'] ?? '';
$statusType = $_GET['status_type'] ?? 'success';

require __DIR__ . '/../../views/account/register.php';