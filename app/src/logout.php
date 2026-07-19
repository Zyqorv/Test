<?php
session_start();

$_SESSION = [];

if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
}

session_destroy();

$redirectTo = $_GET['redirect_to'] ?? '/';
$statusMessage = $_GET['status_message'] ?? '';
$statusType = $_GET['status_type'] ?? 'success';

if (!is_string($redirectTo) || !preg_match('#^/[-A-Za-z0-9_./]*$#', $redirectTo)) {
    $redirectTo = '/';
}

if ($statusMessage !== '') {
    $redirectUrl = $redirectTo . '?status_message=' . urlencode($statusMessage) . '&status_type=' . urlencode($statusType);
} else {
    $redirectUrl = $redirectTo;
}

header('Location: ' . $redirectUrl);
exit();