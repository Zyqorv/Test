<?php
session_start();

function redirectWithStatus(string $target, string $message, string $type = 'success'): void
{
    $redirectUrl = $target . '?status_message=' . urlencode($message) . '&status_type=' . urlencode($type);
    header('Location: ' . $redirectUrl);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirectWithStatus('/account/login', 'Invalid request method', 'error');
}

if (empty($_POST['email']) || empty($_POST['password'])) {
    redirectWithStatus('/account/login', 'Missing credentials', 'error');
}

$email = trim($_POST['email']);
$password = $_POST['password'];

require_once __DIR__ . '/authMessage.php';

try {

    $message = [
        'email' => $email,
    ];

    $response = sendAuthMessage('login', $message);

    if (!is_array($response) || !isset($response['status'])) {
        redirectWithStatus('/account/login', 'Invalid response from server', 'error');
    }

    if ($response['status'] === 'error') {
        $message = $response['message'] ?? 'Server error during authentication';
        redirectWithStatus('/account/login', $message, 'error');
    }

    if ($response['status'] === 'invalid') {
        redirectWithStatus('/account/login', 'User not found', 'error');
    }

    if (!isset($response['password_hash'])) {
        redirectWithStatus('/account/login', 'Malformed response from server', 'error');
    }

    $storedHash = $response['password_hash'];

    if (!password_verify($password, $storedHash)) {
        redirectWithStatus('/account/login', 'Invalid password', 'error');
    }

    $_SESSION['email'] = $email;

    $redirectTo = $_POST['redirect_to'] ?? '/account/';
    if (!is_string($redirectTo) || !preg_match('#^/[-A-Za-z0-9_./]*$#', $redirectTo)) {
        $redirectTo = '/account/';
    }

    redirectWithStatus($redirectTo, 'Login successful.');
} catch (Throwable $e) {
    error_log('Authentication error: ' . $e->getMessage());
    redirectWithStatus('/account/login', 'Server error during login', 'error');
}