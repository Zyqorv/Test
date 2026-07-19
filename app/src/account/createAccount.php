<?php

function redirectWithStatus(string $target, string $message, string $type = 'success'): void
{
    $redirectUrl = $target . '?status_message=' . urlencode($message) . '&status_type=' . urlencode($type);
    header('Location: ' . $redirectUrl);
    exit();
}

if (!isset($_POST['email']) || !isset($_POST['password']) || trim((string) $_POST['email']) === '' || trim((string) $_POST['password']) === '') {
    redirectWithStatus('/account/register', 'Missing credentials', 'error');
}

$email = trim($_POST['email']);
$password = $_POST['password'];

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    redirectWithStatus('/account/register', 'Invalid email format', 'error');
}

$passwordHash = password_hash($password, PASSWORD_BCRYPT);

require_once __DIR__ . '/authMessage.php';

try {
    $message = [
        'email' => $email,
        'password_hash' => $passwordHash,
    ];

    $response = sendAuthMessage('register', $message);

    if (isset($response['status']) && $response['status'] === 'duplicate') {
        redirectWithStatus('/account/register', 'User already exists.', 'error');
    }

    if (isset($response['status']) && $response['status'] === 'success') {
        redirectWithStatus('/account/login', 'Account created successfully. Please log in.');
    }

    redirectWithStatus('/account/register', 'Registration failed', 'error');
} catch (Throwable $e) {
    error_log('Registration error: ' . $e->getMessage());
    redirectWithStatus('/account/register', 'Registration failed due to server error.', 'error');
}