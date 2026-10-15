<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';

$categories = get_all_categories();
$featuredCourses = get_featured_courses(6);

$pageTitle = SITE_NAME . ' | ' . SITE_TAGLINE;
$pageDescription = 'Advance your career with industry-focused online courses in Web Development, Cloud Computing, Data Science, AI, and Cybersecurity.';
$canonicalUrl = base_url();
$currentRoute = 'index.php';

include __DIR__ . '/includes/header.php';
?>

<section class="hero-section">
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-lg-6">
        <div class="hero-badge mb-3">
          <i class="bi bi-stars text-warning"></i>
          <span>Industry-Aligned Tech Education</span>
        </div>

        <h1 class="hero-title">
          Master Modern Tech Skills with <span class="text-gradient">Real-World Projects</span>
        </h1>

        <p class="hero-subtitle">
          Learn high-demand programming, cloud architecture, and product design from experienced practitioners. Build verified production systems that stand out to top engineering teams.
        </p>

        <div class="d-flex flex-wrap gap-3 mb-4">
          <a href="<?php echo base_url('courses.php'); ?>" class="btn btn-primary btn-lg rounded-pill px-4">
            <i class="bi bi-grid-fill me-2"></i> Explore Courses
          </a>
          <a href="#browse-categories" class="btn btn-outline-primary btn-lg rounded-pill px-4">
            <i class="bi bi-collection me-2"></i> Browse Domains
          </a>
        </div>

        <div class="d-flex align-items-center gap-3 pt-2">
          <div class="d-flex text-warning fs-6">
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-half"></i>
          </div>
          <span class="small text-secondary fw-semibold">
            Rated <strong>4.9/5</strong> by 15,000+ engineers worldwide
          </span>
        </div>
      </div>

      <div class="col-lg-6 text-center">
        <div class="position-relative">
          <img 
            src="<?php echo base_url('assets/images/hero-illustration.svg'); ?>" 
            alt="Interactive Online Learning Platform Illustration" 
            class="img-fluid"
            style="max-height: 480px;"
          >
        </div>
      </div>
    </div>
  </div>
</section>

<section class="hero-stats-strip">
  <div class="container">
    <div class="row g-4 text-center">
      <div class="col-6 col-md-3">
        <div class="stat-item">
          <h3>15,000+</h3>
          <p>Active Learners</p>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="stat-item">
          <h3>98.4%</h3>
          <p>Course Satisfaction</p>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="stat-item">
          <h3>50+</h3>
          <p>Production Projects</p>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="stat-item">
          <h3>100%</h3>
          <p>Verified Credentials</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="py-5" id="browse-categories">
  <div class="container py-lg-4">
    <div class="text-center mb-5">
      <span class="text-primary fw-bold text-uppercase small letter-spacing-1">Popular Tracks</span>
      <h2 class="display-6 fw-bold mb-3">Explore In-Demand Categories</h2>
      <p class="text-secondary mx-auto" style="max-width: 600px;">
        Choose from specialized learning paths meticulously crafted to deliver relevant industry capabilities.
      </p>
    </div>

    <?php if (!empty($categories)): ?>
      <div class="row g-4">
        <?php foreach ($categories as $cat): ?>
          <div class="col-md-6 col-lg-4">
            <a href="<?php echo base_url('courses.php?category=' . rawurlencode($cat['slug'])); ?>" class="category-card h-100">
              <div class="category-icon-box">
                <i class="bi <?php echo e($cat['icon'] ?: 'bi-collection'); ?>"></i>
              </div>
              <div class="flex-grow-1">
                <h3 class="h6 fw-bold mb-1"><?php echo e($cat['name']); ?></h3>
                <span class="text-muted small d-block mb-1">
                  <?php echo (int)$cat['course_count']; ?> <?php echo (int)$cat['course_count'] === 1 ? 'Program' : 'Programs'; ?>
                </span>
                <p class="text-secondary small mb-0 line-clamp-1" style="font-size: 0.8rem;">
                  <?php echo truncate_text($cat['description'] ?? '', 60); ?>
                </p>
              </div>
              <div class="text-muted">
                <i class="bi bi-chevron-right"></i>
              </div>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="empty-state p-4 bg-white">
        <p class="text-muted mb-0">No categories currently configured in MySQL.</p>
      </div>
    <?php endif; ?>
  </div>
</section>

<section class="py-5 bg-light-subtle">
  <div class="container py-lg-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-5">
      <div>
        <span class="text-primary fw-bold text-uppercase small">Curated Programs</span>
        <h2 class="display-6 fw-bold mb-2">Featured Courses</h2>
        <p class="text-secondary mb-0">Directly retrieved from our verified MySQL catalog.</p>
      </div>
      <a href="<?php echo base_url('courses.php'); ?>" class="btn btn-outline-primary rounded-pill mt-3 mt-md-0">
        Browse All Courses <i class="bi bi-arrow-right ms-1"></i>
      </a>
    </div>

    <?php if (!empty($featuredCourses)): ?>
      <div class="row g-4">
        <?php foreach ($featuredCourses as $course): ?>
          <?php include __DIR__ . '/templates/course-card.php'; ?>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="empty-state p-5 bg-white">
        <i class="bi bi-mortarboard text-secondary fs-1 mb-3 d-block"></i>
        <h3 class="h5 fw-bold mb-2">No Featured Courses Available</h3>
        <p class="text-secondary small mb-3">Check back soon for new featured bootcamp curriculums.</p>
        <a href="<?php echo base_url('courses.php'); ?>" class="btn btn-primary rounded-pill px-4">Browse Catalog</a>
      </div>
    <?php endif; ?>
  </div>
</section>

<section class="py-5">
  <div class="container py-lg-5">
    <div class="text-center mb-5">
      <span class="text-primary fw-bold text-uppercase small">Educational Advantage</span>
      <h2 class="display-6 fw-bold mb-3">Why Learn With EdTech Innovate</h2>
      <p class="text-secondary mx-auto" style="max-width: 620px;">
        Designed specifically to bridge the divide between theoretical textbook concepts and day-to-day engineering deliverables.
      </p>
    </div>

    <div class="row g-4 g-lg-5">
      <div class="col-md-6 col-lg-3">
        <div class="card border-0 rounded-4 shadow-sm p-4 h-100 bg-white">
          <div class="mb-3 text-primary fs-2">
            <i class="bi bi-laptop"></i>
          </div>
          <h3 class="h5 fw-bold mb-2">Project-First Curriculum</h3>
          <p class="text-secondary small mb-0">
            Build actual full-stack platforms, database schemas, and microservices instead of trivial isolated code snippets.
          </p>
        </div>
      </div>

      <div class="col-md-6 col-lg-3">
        <div class="card border-0 rounded-4 shadow-sm p-4 h-100 bg-white">
          <div class="mb-3 text-primary fs-2">
            <i class="bi bi-shield-check"></i>
          </div>
          <h3 class="h5 fw-bold mb-2">Secure Engineering</h3>
          <p class="text-secondary small mb-0">
            Learn security best practices including PDO prepared statements, XSS defense, CSRF protection, and OWASP guidelines.
          </p>
        </div>
      </div>

      <div class="col-md-6 col-lg-3">
        <div class="card border-0 rounded-4 shadow-sm p-4 h-100 bg-white">
          <div class="mb-3 text-primary fs-2">
            <i class="bi bi-patch-check"></i>
          </div>
          <h3 class="h5 fw-bold mb-2">Verified Certificates</h3>
          <p class="text-secondary small mb-0">
            Earn shareable certificates of achievement that showcase project links, code commits, and verified skills.
          </p>
        </div>
      </div>

      <div class="col-md-6 col-lg-3">
        <div class="card border-0 rounded-4 shadow-sm p-4 h-100 bg-white">
          <div class="mb-3 text-primary fs-2">
            <i class="bi bi-people"></i>
          </div>
          <h3 class="h5 fw-bold mb-2">Mentor Feedback</h3>
          <p class="text-secondary small mb-0">
            Receive actionable pull-request reviews, design advice, and continuous guidance from experienced technical leads.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="py-5" style="background: var(--hero-gradient); color: #ffffff;">
  <div class="container py-4 text-center">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <span class="badge bg-light text-primary px-3 py-2 fw-semibold mb-3">Start Your Tech Journey</span>
        <h2 class="display-6 fw-bold mb-3 text-white">Ready to Transform Your Career?</h2>
        <p class="lead mb-4" style="color: #cbd5e1; font-size: 1.15rem;">
          Enroll in our dynamic courses today and gain access to comprehensive curriculums, mentor support, and real portfolio projects.
        </p>
        <div class="d-flex justify-content-center flex-wrap gap-3">
          <a href="<?php echo base_url('courses.php'); ?>" class="btn btn-primary btn-lg rounded-pill px-4">
            <i class="bi bi-arrow-right-circle-fill me-2"></i> Explore Course Catalog
          </a>
          <a href="<?php echo base_url('contact.php'); ?>" class="btn btn-outline-light btn-lg rounded-pill px-4">
            <i class="bi bi-chat-dots me-2"></i> Talk to an Advisor
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
