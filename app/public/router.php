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

// Prevent direct access to the root index route only
if ($route === 'index') {
    http_response_code(404);
    echo "404 Not Found";
    exit;
}

// Redirect /game/index/, /account/index/, /admin/index/ to their clean URLs
$indexRedirects = [
    'game/index'    => '/game/',
    'account/index' => '/account/',
    'admin/index'   => '/admin/',
];

if (isset($indexRedirects[$route])) {
    header('Location: ' . $indexRedirects[$route], true, 301);
    exit;
}

// Internally map clean URLs to their index.php files
$indexRoutes = [
    'game'    => 'game/index',
    'account' => 'account/index',
    'admin'   => 'admin/index',
];

if (isset($indexRoutes[$route])) {
    $route = $indexRoutes[$route];
}

// Map clean URL to PHP file
$file = __DIR__ . '/' . $route . '.php';

if (is_file($file)) {
    require $file;
    exit;
}

http_response_code(404);
echo "404 Not Found";