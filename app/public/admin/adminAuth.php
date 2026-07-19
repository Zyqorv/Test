<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Invalid request method");
}

if (empty($_POST['username']) || empty($_POST['password'])) {
    die("Missing credentials");
}

$username = trim($_POST['username']);
$password = $_POST['password'];

require_once __DIR__ . "/accountMessage.php";

try {
    $response = sendInformation('admin_login', $username, $password);

    if (!is_array($response) || !isset($response["status"])) {
        die("Invalid response from server");
    }

    if ($response["status"] === "error") {
        die("Server error during authentication");
    }

    if ($response["status"] === "invalid") {
        die("Admin not found");
    }

    if (!isset($response["password_hash"])) {
        die("Malformed response from server");
    }

    $storedHash = $response["password_hash"];

    if (!password_verify($password, $storedHash)) {
        die("Invalid password");
    }

    $_SESSION["admin_username"] = $username;

    header("Location: adminPortal.php");
    exit();

} catch (Throwable $e) {
    error_log("Admin authentication error: " . $e->getMessage());
    die("Server error during admin login");
}
