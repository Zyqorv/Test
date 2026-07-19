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
$newEmail = trim($_POST['new_email'] ?? '');
$oldEmail = trim($_SESSION['email']);

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

if ($newEmail === '') {
    redirectWithStatus('Please enter a new email address.', 'error');
}

if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
    redirectWithStatus('Please enter a valid email address.', 'error');
}

if ($newEmail === $oldEmail) {
    redirectWithStatus('The new email must be different from your current email.', 'error');
}

require_once __DIR__ . '/authMessage.php';

try {
    $loginResponse = sendAuthMessage('login', $oldEmail);

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

    $message = [
        'old_email' => $oldEmail,
        'new_email' => $newEmail,
    ];

    $response = sendAuthMessage('change_email', $message);

    if (isset($response['status']) && $response['status'] === 'success') {
        redirectToLogout('Email changed successfully. Please log in again.');
    }

    if (isset($response['status']) && $response['status'] === 'duplicate') {
        redirectWithStatus('Email already exists.', 'error');
    }

    redirectWithStatus('Email change failed.', 'error');
} catch (Throwable $e) {
    error_log('Email change error: ' . $e->getMessage());
    redirectWithStatus('Server error during email change.', 'error');
}
