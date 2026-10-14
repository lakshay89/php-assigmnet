<?php
/**
 * PHP Built-In Web Server Router
 * EdTech Innovate - Online Course Website
 * 
 * Usage:
 * php -S localhost:8000 router.php
 * 
 * Provides clean URL routing without requiring Apache mod_rewrite for local CLI development.
 */

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Serve static assets (CSS, JS, SVG, images) directly
if (file_exists(__DIR__ . $uri) && !is_dir(__DIR__ . $uri)) {
    return false;
}

// 1. Clean Course Details Route: /courses/{slug}
if (preg_match('#^/courses/([a-zA-Z0-9\-_]+)/?$#', $uri, $matches)) {
    $_GET['slug'] = $matches[1];
    require __DIR__ . '/course-details.php';
    return true;
}

// 2. Clean Course Listing Route: /courses
if (preg_match('#^/courses/?$#', $uri)) {
    require __DIR__ . '/courses.php';
    return true;
}

// 3. Clean Static Pages: /about, /contact
if (preg_match('#^/about/?$#', $uri)) {
    require __DIR__ . '/about.php';
    return true;
}

if (preg_match('#^/contact/?$#', $uri)) {
    require __DIR__ . '/contact.php';
    return true;
}

// 4. Root Home Page
if ($uri === '/' || $uri === '/index.php') {
    require __DIR__ . '/index.php';
    return true;
}

// 5. Direct PHP files (courses.php, about.php, contact.php, course-details.php)
if (file_exists(__DIR__ . $uri) && is_file(__DIR__ . $uri)) {
    require __DIR__ . $uri;
    return true;
}

// 6. Direct PHP files without extension
if (file_exists(__DIR__ . $uri . '.php')) {
    require __DIR__ . $uri . '.php';
    return true;
}

// 7. Not found
require __DIR__ . '/404.php';
return true;
