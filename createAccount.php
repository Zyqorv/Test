<?php

if (!isset($_POST['email']) || !isset($_POST['password'])) {
    die("Missing fields");
}

$email = trim($_POST['email']);
$password = $_POST['password'];

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email format");
}

$passwordHash = password_hash($password, PASSWORD_BCRYPT);

require_once __DIR__ . "/accountMessage.php";

try {
    $response = sendInformation('register', $email, $passwordHash);

    if (isset($response["status"]) && $response["status"] == "duplicate") {
        die("User already exists.");
    }
    if (isset($response["status"]) && $response["status"] == "success") {
        echo "Account created successfully. <a href='login.php'>Login</a>";
    } else {
        echo "Registration failed";
    }

} catch (Throwable $e) {
    error_log("Registration error: " . $e->getMessage());
    echo "Registration failed due to server error.";
}