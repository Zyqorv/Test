<?php

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$query = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

// Block direct PHP access
if (preg_match('#\.php(?:/|$)#', $path)) {
    http_response_code(404);
    echo "404 Not Found";
    exit;
}

/*
 * Allow static files to be served normally.
 * This prevents the router from trying to find:
 * css/style.css.php
 * js/tiles.js.php
 */
$staticExtensions = [
    'css',
    'js',
    'png',
    'jpg',
    'jpeg',
    'gif',
    'svg',
    'ico',
    'webp'
];

$extension = pathinfo($path, PATHINFO_EXTENSION);

if (in_array($extension, $staticExtensions)) {
    $file = __DIR__ . $path;

    if (is_file($file)) {
        return false; // Let the web server serve it
    }

    http_response_code(404);
    echo "404 Not Found";
    exit;
}


// Force trailing slash on GET/HEAD requests only
if ($method !== 'POST' && $path !== '/' && !str_ends_with($path, '/')) {
    $redirectTarget = $path . '/';

    if ($query !== null && $query !== '') {
        $redirectTarget .= '?' . $query;
    }

    header("Location: " . $redirectTarget, true, 301);
    exit;
}


// Remove trailing slash internally for file lookup
$route = trim($path, '/');


// Homepage
if ($route === '') {
    require __DIR__ . '/index.php';
    exit;
}


// Prevent index routes
if ($route === 'index') {
    http_response_code(404);
    echo "404 Not Found";
    exit;
}


// Map clean URL to PHP file
$file = __DIR__ . '/' . $route . '.php';

if (is_file($file)) {
    require $file;
    exit;
}


http_response_code(404);
echo "404 Not Found";