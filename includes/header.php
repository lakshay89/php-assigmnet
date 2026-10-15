<?php
require_once __DIR__ . '/functions.php';

$pageTitle = $pageTitle ?? (SITE_NAME . ' | ' . SITE_TAGLINE);
$pageDescription = $pageDescription ?? 'Learn in-demand tech skills with EdTech Innovate. Dynamic online courses in Web Development, Data Science, Cloud, UI/UX, and Cybersecurity.';
$canonicalUrl = $canonicalUrl ?? (isset($_SERVER['REQUEST_SCHEME'], $_SERVER['HTTP_HOST'], $_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] : '');
$currentRoute = $currentRoute ?? basename($_SERVER['SCRIPT_NAME'] ?? '');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <title><?php echo e($pageTitle); ?></title>
  <meta name="title" content="<?php echo e($pageTitle); ?>">
  <meta name="description" content="<?php echo e($pageDescription); ?>">
  <meta name="robots" content="index, follow">
  <?php if (!empty($canonicalUrl)): ?>
    <link rel="canonical" href="<?php echo e($canonicalUrl); ?>">
  <?php endif; ?>

  <meta property="og:type" content="website">
  <meta property="og:title" content="<?php echo e($pageTitle); ?>">
  <meta property="og:description" content="<?php echo e($pageDescription); ?>">
  <?php if (!empty($canonicalUrl)): ?>
    <meta property="og:url" content="<?php echo e($canonicalUrl); ?>">
  <?php endif; ?>
  <meta property="og:site_name" content="<?php echo e(SITE_NAME); ?>">

  <link rel="icon" type="image/svg+xml" href="<?php echo base_url('assets/images/logo.svg'); ?>">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
</head>
<body>

<header class="sticky-top">
  <nav class="navbar navbar-expand-lg site-navbar py-2 py-lg-3" aria-label="Main Navigation">
    <div class="container">
      <a class="navbar-brand" href="<?php echo base_url(); ?>">
        <img src="<?php echo base_url('assets/images/logo.svg'); ?>" alt="<?php echo e(SITE_NAME); ?> Logo" height="42">
      </a>

      <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#primaryNavbar" aria-controls="primaryNavbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="primaryNavbar">
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-lg-2">
          <li class="nav-item">
            <a class="nav-link <?php echo ($currentRoute === 'index.php' || $currentRoute === '') ? 'active' : ''; ?>" href="<?php echo base_url(); ?>">
              Home
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo ($currentRoute === 'courses.php' || $currentRoute === 'course-details.php') ? 'active' : ''; ?>" href="<?php echo base_url('courses.php'); ?>">
              Courses
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo ($currentRoute === 'about.php') ? 'active' : ''; ?>" href="<?php echo base_url('about.php'); ?>">
              About
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo ($currentRoute === 'contact.php') ? 'active' : ''; ?>" href="<?php echo base_url('contact.php'); ?>">
              Contact
            </a>
          </li>
        </ul>

        <div class="d-flex align-items-center gap-2">
          <a href="<?php echo base_url('courses.php'); ?>" class="btn btn-primary rounded-pill px-4">
            <i class="bi bi-compass me-1"></i> Explore Courses
          </a>
        </div>
      </div>
    </div>
  </nav>
</header>

<main id="main-content">

