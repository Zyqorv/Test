<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /account/settings');
    exit();
}

if (!isset($_SESSION['email'])) {
    header('Location: /account/login');
    exit();
}

$newPassword = $_POST['new_password'] ?? '';
$confirmPassword = $_POST['confirm_password'] ?? '';
$email = trim($_SESSION['email']);

function redirectWithStatus(string $message, string $type = 'success'): void
{
    $redirectUrl = '/account/settings?status_message=' . urlencode($message) . '&status_type=' . urlencode($type);
    header('Location: ' . $redirectUrl);
    exit();
}

function redirectToLogout(string $message, string $type = 'success'): void
{
    $redirectUrl = '/src/logout.php?redirect_to=/account/login&status_message=' . urlencode($message) . '&status_type=' . urlencode($type);
    header('Location: ' . $redirectUrl);
    exit();
}

if ($newPassword === '') {
    redirectWithStatus('Please enter a new password.', 'error');
}

if ($newPassword !== $confirmPassword) {
    redirectWithStatus('The new password and confirmation password must match.', 'error');
}

require_once __DIR__ . '/authMessage.php';

try {

    $passwordHash = password_hash($newPassword, PASSWORD_BCRYPT);

    $message = [
        'email' => $email,
        'new_password' => $passwordHash,
    ];

    $response = sendAuthMessage('change_password', $message);

    if (isset($response['status']) && $response['status'] === 'success') {
        redirectToLogout('Password changed successfully. Please log in again.');
    }

    redirectWithStatus('Password change failed.', 'error');
} catch (Throwable $e) {
    error_log('Password change error: ' . $e->getMessage());
    redirectWithStatus('Server error during password change.', 'error');
}
