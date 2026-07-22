<?php
session_start();

$email = $_SESSION["email"] ?? "Guest";

require __DIR__ . '/../../views/game/index.php';