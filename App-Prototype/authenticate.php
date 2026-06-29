<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Invalid request method");
}

if (empty($_POST['email']) || empty($_POST['password'])) {
    die("Missing credentials");
}

$email = trim($_POST['email']);
$password = $_POST['password'];

require_once __DIR__ . "/accountMessage.php";

try {
    $response = sendInformation('login', $email, $password);

    if (!is_array($response) || !isset($response["status"])) {
        die("Invalid response from server");
    }

    if ($response["status"] === "error") {
        die("Server error during authentication");
    }

    if ($response["status"] === "invalid") {
        die("User not found");
    }

    if (!isset($response["password_hash"])) {
        die("Malformed response from server");
    }

    $storedHash = $response["password_hash"];

    if (!password_verify($password, $storedHash)) {
        die("Invalid password");
    }

    session_regenerate_id(true);

    $_SESSION["email"] = $email;

    header("Location: dashboard.php");
    exit();

} catch (Throwable $e) {
    error_log("Authentication error: " . $e->getMessage());
    die("Server error during login");
}