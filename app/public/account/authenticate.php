<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /');
    exit();
}

require_once __DIR__ . '/../../src/account/authenticate.php';
