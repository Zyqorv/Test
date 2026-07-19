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

$currentPassword = $_POST['current_password'] ?? '';
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

if ($currentPassword === '') {
    redirectWithStatus('Please enter your current password.', 'error');
}

if ($newPassword === '') {
    redirectWithStatus('Please enter a new password.', 'error');
}

if ($newPassword !== $confirmPassword) {
    redirectWithStatus('The new password and confirmation password must match.', 'error');
}

require_once __DIR__ . '/authMessage.php';

try {
    $loginResponse = sendAuthMessage('login', $email);

    if (!is_array($loginResponse) || !isset($loginResponse['status'])) {
        redirectWithStatus('Invalid response from server.', 'error');
    }

    if ($loginResponse['status'] === 'error') {
        redirectWithStatus('Server error during authentication.', 'error');
    }

    if ($loginResponse['status'] === 'invalid') {
        redirectWithStatus('User not found.', 'error');
    }

    if (!isset($loginResponse['password_hash'])) {
        redirectWithStatus('Malformed response from server.', 'error');
    }

    if (!password_verify($currentPassword, $loginResponse['password_hash'])) {
        redirectWithStatus('The current password you entered is incorrect.', 'error');
    }

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
