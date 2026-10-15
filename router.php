<?php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (file_exists(__DIR__ . $uri) && !is_dir(__DIR__ . $uri)) {
    return false;
}

if (preg_match('#^/courses/([a-zA-Z0-9\-_]+)/?$#', $uri, $matches)) {
    $_GET['slug'] = $matches[1];
    require __DIR__ . '/course-details.php';
    return true;
}

if (preg_match('#^/courses/?$#', $uri)) {
    require __DIR__ . '/courses.php';
    return true;
}

if (preg_match('#^/about/?$#', $uri)) {
    require __DIR__ . '/about.php';
    return true;
}

if (preg_match('#^/contact/?$#', $uri)) {
    require __DIR__ . '/contact.php';
    return true;
}

if ($uri === '/' || $uri === '/index.php') {
    require __DIR__ . '/index.php';
    return true;
}

if (file_exists(__DIR__ . $uri) && is_file(__DIR__ . $uri)) {
    require __DIR__ . $uri;
    return true;
}

if (file_exists(__DIR__ . $uri . '.php')) {
    require __DIR__ . $uri . '.php';
    return true;
}

require __DIR__ . '/404.php';
return true;

