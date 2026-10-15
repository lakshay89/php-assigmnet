<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';

$slug = trim($_GET['slug'] ?? '');

if ($slug === '' || !preg_match('/^[a-zA-Z0-9\-_]+$/', $slug)) {
    require __DIR__ . '/404.php';
    exit;
}

$course = get_course_by_slug($slug);

if (!$course) {
    require __DIR__ . '/404.php';
    exit;
}

$pageTitle = !empty($course['meta_title']) 
    ? $course['meta_title'] 
    : ($course['name'] . ' | ' . SITE_NAME);

$pageDescription = !empty($course['meta_description']) 
    ? $course['meta_description'] 
    : $course['short_description'];

$canonicalUrl = course_url($course['slug']);
$currentRoute = 'course-details.php';

$relatedCourses = [];
if (!empty($course['category_id'])) {
    $relatedCourses = get_related_courses((int)$course['category_id'], (int)$course['id'], 3);
}

include __DIR__ . '/includes/header.php';
include __DIR__ . '/templates/course-details-template.php';
include __DIR__ . '/includes/footer.php';

