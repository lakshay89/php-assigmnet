<?php
/**
 * Dynamic Course Details Template
 * EdTech Innovate - Online Course Website
 * 
 * Scope variables:
 * - array $course
 * - array $relatedCourses
 */

if (!isset($course) || empty($course)) {
    return;
}

$courseName    = $course['name'];
$categoryName  = $course['category_name'] ?? 'Tech Programs';
$categorySlug  = $course['category_slug'] ?? '';
$price         = $course['price'];
$duration      = $course['duration'];
$level         = $course['level'] ?? 'All Levels';
$shortDesc     = $course['short_description'];
$fullDesc      = $course['full_description'];
$imageSrc      = !empty($course['image']) ? base_url($course['image']) : base_url('assets/images/courses/web-dev.svg');
$altText       = e($courseName) . ' course banner and curriculum cover';
?>

<!-- Course Details Hero Banner -->
<section class="course-details-hero">
  <div class="container">
    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb" class="mb-3">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><i class="bi bi-house-door me-1"></i>Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo base_url('courses.php'); ?>">Courses</a></li>
        <?php if (!empty($categorySlug)): ?>
          <li class="breadcrumb-item"><a href="<?php echo base_url('courses.php?category=' . rawurlencode($categorySlug)); ?>"><?php echo e($categoryName); ?></a></li>
        <?php endif; ?>
        <li class="breadcrumb-item active" aria-current="page"><?php echo e($courseName); ?></li>
      </ol>
    </nav>

    <div class="row align-items-center">
      <div class="col-lg-8">
        <div class="d-flex flex-wrap gap-2 mb-3">
          <span class="badge bg-primary px-3 py-2 fw-semibold">
            <i class="bi bi-tag-fill me-1"></i> <?php echo e($categoryName); ?>
          </span>
          <span class="badge bg-secondary-subtle text-white border border-light-subtle px-3 py-2">
            <i class="bi bi-bar-chart-fill me-1"></i> Level: <?php echo e($level); ?>
          </span>
          <span class="badge bg-info-subtle text-white border border-light-subtle px-3 py-2">
            <i class="bi bi-patch-check-fill me-1"></i> Certified Curriculum
          </span>
        </div>

        <!-- Dynamic H1 Heading -->
        <h1 class="fw-bold mb-3"><?php echo e($courseName); ?></h1>

        <p class="lead text-light-subtle mb-4" style="color: #cbd5e1; font-size: 1.15rem;">
          <?php echo e($shortDesc); ?>
        </p>

        <!-- Course Meta Strip -->
        <div class="d-flex flex-wrap gap-4 text-light-subtle small border-top border-secondary pt-3" style="color: #94a3b8;">
          <div><i class="bi bi-clock-history me-1 text-info"></i> Duration: <strong class="text-white"><?php echo e($duration); ?></strong></div>
          <div><i class="bi bi-translate me-1 text-info"></i> Language: <strong class="text-white">English</strong></div>
          <div><i class="bi bi-calendar3 me-1 text-info"></i> Last Updated: <strong class="text-white"><?php echo date('M Y', strtotime($course['updated_at'] ?? 'now')); ?></strong></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Course Main Content & Sticky Enrollment Sidebar -->
<div class="container py-5">
  <div class="row g-4 g-lg-5">
    <!-- Left Column: Detailed Overview & Curriculum -->
    <div class="col-lg-8">
      <!-- Media Banner on Mobile & Content Preview -->
      <div class="card border-0 rounded-4 overflow-hidden shadow-sm mb-4">
        <img 
          src="<?php echo $imageSrc; ?>" 
          alt="<?php echo $altText; ?>" 
          class="img-fluid w-100"
          style="max-height: 400px; object-fit: cover;"
        >
      </div>

      <!-- What You Will Learn Card -->
      <div class="card border-0 rounded-4 shadow-sm p-4 p-md-5 mb-4 bg-white">
        <h2 class="h4 fw-bold mb-3"><i class="bi bi-check2-circle text-primary me-2"></i>What You Will Master</h2>
        <div class="row g-3">
          <div class="col-md-6">
            <div class="d-flex gap-2">
              <i class="bi bi-check-lg text-success fs-5"></i>
              <span class="small text-secondary">Hands-on architecture and clean coding design patterns.</span>
            </div>
          </div>
          <div class="col-md-6">
            <div class="d-flex gap-2">
              <i class="bi bi-check-lg text-success fs-5"></i>
              <span class="small text-secondary">Real-world production projects ready for your technical portfolio.</span>
            </div>
          </div>
          <div class="col-md-6">
            <div class="d-flex gap-2">
              <i class="bi bi-check-lg text-success fs-5"></i>
              <span class="small text-secondary">Security hardening, OWASP defense, and PDO prepared statements.</span>
            </div>
          </div>
          <div class="col-md-6">
            <div class="d-flex gap-2">
              <i class="bi bi-check-lg text-success fs-5"></i>
              <span class="small text-secondary">Industry certificate of completion verified by hiring partners.</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Full Syllabus / Description -->
      <div class="course-curriculum-box shadow-sm bg-white">
        <h2 class="h4 fw-bold mb-4"><i class="bi bi-journal-code text-primary me-2"></i>Detailed Course Curriculum</h2>
        <div class="course-rich-content">
          <?php 
          // Render rich formatted description safely allowing sanitized tags
          echo $fullDesc; 
          ?>
        </div>
      </div>

      <!-- Prerequisites -->
      <div class="card border-0 rounded-4 shadow-sm p-4 bg-white">
        <h3 class="h5 fw-bold mb-2"><i class="bi bi-info-circle text-primary me-2"></i>Prerequisites &amp; Requirements</h3>
        <p class="text-secondary small mb-2">
          A computer with internet access and basic familiarity with using a web browser and code editor (e.g., VS Code). No prior enterprise engineering background is required for beginner courses.
        </p>
        <p class="text-secondary small mb-0">
          All required tools, local software (PHP, MySQL, Apache/XAMPP), and project assets are fully covered step-by-step.
        </p>
      </div>
    </div>

    <!-- Right Column: Sticky Enrollment Sidebar -->
    <div class="col-lg-4">
      <aside class="course-sidebar-card" aria-label="Course Enrollment Box">
        <div class="course-sidebar-body">
          <div class="d-flex align-items-baseline justify-content-between mb-3">
            <div>
              <span class="text-muted small text-uppercase fw-bold">Enrollment Fee</span>
              <div class="course-sidebar-price">
                <?php echo format_price($price, true); ?>
              </div>
            </div>
            <?php if ((float)$price > 0): ?>
              <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">Limited Seats</span>
            <?php endif; ?>
          </div>

          <div class="d-grid gap-2 mb-4">
            <a href="<?php echo base_url('contact.php?subject=' . urlencode('Enrollment Inquiry: ' . $courseName)); ?>" class="btn btn-primary btn-lg rounded-pill fw-bold">
              <i class="bi bi-mortarboard-fill me-2"></i> Enroll Now
            </a>
            <a href="<?php echo base_url('contact.php?subject=' . urlencode('Syllabus Request: ' . $courseName)); ?>" class="btn btn-outline-secondary rounded-pill">
              <i class="bi bi-file-earmark-arrow-down me-1"></i> Request Syllabus
            </a>
          </div>

          <!-- Highlights List -->
          <h4 class="h6 fw-bold mb-3">This course includes:</h4>
          <ul class="list-unstyled d-flex flex-column gap-2 small text-secondary mb-4">
            <li><i class="bi bi-play-circle text-primary me-2"></i> On-demand video lectures &amp; guided labs</li>
            <li><i class="bi bi-clock text-primary me-2"></i> <?php echo e($duration); ?> of curriculum</li>
            <li><i class="bi bi-infinity text-primary me-2"></i> Full lifetime access to updates</li>
            <li><i class="bi bi-code-slash text-primary me-2"></i> Complete downloadable source code</li>
            <li><i class="bi bi-award text-primary me-2"></i> Shareable Certificate of Completion</li>
          </ul>

          <div class="p-3 bg-light rounded-3 text-center border">
            <span class="text-muted small d-block mb-1"><i class="bi bi-shield-check text-success me-1"></i> 30-Day Money-Back Guarantee</span>
            <span class="text-muted" style="font-size: 0.75rem;">100% risk-free trial for every enrolled student.</span>
          </div>
        </div>
      </aside>
    </div>
  </div>

  <!-- Related Courses Section -->
  <?php if (!empty($relatedCourses)): ?>
    <section class="mt-5 pt-4 border-top">
      <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
          <span class="text-primary fw-bold text-uppercase small">Keep Exploring</span>
          <h2 class="h3 fw-bold mb-0">Related Courses in <?php echo e($categoryName); ?></h2>
        </div>
        <a href="<?php echo base_url('courses.php?category=' . rawurlencode($categorySlug)); ?>" class="btn btn-outline-primary btn-sm rounded-pill d-none d-sm-inline-flex">
          View All <i class="bi bi-arrow-right ms-1"></i>
        </a>
      </div>

      <div class="row g-4">
        <?php 
        $parentCourse = $course;
        foreach ($relatedCourses as $relatedCourse): 
            $course = $relatedCourse;
            include __DIR__ . '/course-card.php'; 
        endforeach; 
        $course = $parentCourse;
        ?>
      </div>
    </section>
  <?php endif; ?>
</div>
