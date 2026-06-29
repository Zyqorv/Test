<?php
session_start();

if (!isset($_POST['email']) || !isset($_POST['password'])) {
    die("Missing credentials");
}

$email = trim($_POST['email']);
$password = $_POST['password'];

require_once __DIR__ . "/accountMessage.php";

try {
    $response = sendInformation('login', $email, $password);

    if (!$response || !isset($response["status"] || ($response["status"] == "error"))) {
        die("Invalid response from server");
    }
    else if ($response["status"] == "invalid") {
        die("User not found");
    }

    $storedHash = $data["password_hash"];

    if (password_verify($password, $storedHash)) {

        $_SESSION["email"] = $email;

        header("Location: dashboard.php");
        exit();

    } else {
        die("Invalid password");
    }

} catch (Throwable $e) {
    error_log("Authentication error: " . $e->getMessage());
    die("Server error during login");
}