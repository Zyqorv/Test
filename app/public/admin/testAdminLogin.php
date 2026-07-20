<?php
session_start();

// Use only for testing pages that require admin login when RMQ and DB VMs are unavailable

$_SESSION['admin_email'] = 'admin@test.com';