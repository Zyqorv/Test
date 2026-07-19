<?php
session_start();

// Use only for testing pages that require login when RMQ and DB VMs are unavailable

$_SESSION['email'] = 'test';
