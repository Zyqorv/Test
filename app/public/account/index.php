<?php
session_start();

if (!isset($_SESSION["email"])) {
    header("Location: /account/login");
    exit();
}

$email = $_SESSION["email"];

require __DIR__ . '/../../views/account/index.php';