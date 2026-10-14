<?php
/**
 * Reusable Course Card Component
 * EdTech Innovate - Online Course Website
 * 
 * Expected scope variable: array $course
 */

if (!isset($course) || !is_array($course)) {
    return;
}

$courseSlug  = $course['slug'] ?? '';
$courseName  = $course['name'] ?? 'Untitled Course';
$catName     = $course['category_name'] ?? 'General';
$catSlug     = $course['category_slug'] ?? '';
$price       = $course['price'] ?? 0;
$duration    = $course['duration'] ?? 'Self-paced';
$level       = $course['level'] ?? 'All Levels';
$shortDesc   = $course['short_description'] ?? '';
$courseImage = !empty($course['image']) ? base_url($course['image']) : base_url('assets/images/courses/web-dev.svg');
$detailsUrl  = course_url($courseSlug);
?>

<div class="col-md-6 col-lg-4 d-flex align-items-stretch">
  <article class="course-card w-100" id="course-card-<?php echo e($course['id'] ?? 'item'); ?>">
    <!-- Thumbnail Media -->
    <div class="course-card-thumb-wrapper">
      <a href="<?php echo $detailsUrl; ?>" tabindex="-1" aria-hidden="true">
        <img 
          src="<?php echo $courseImage; ?>" 
          alt="<?php echo e($courseName); ?> course thumbnail"
          class="course-card-thumb"
          loading="lazy"
          onerror="this.onerror=null; this.src='<?php echo base_url('assets/images/courses/web-dev.svg'); ?>';"
        >
      </a>

      <!-- Category Badge on Card -->
      <div class="course-card-badge-top">
        <span class="badge bg-white text-dark shadow-sm border px-2.5 py-1.5 fw-semibold small">
          <i class="bi bi-tag-fill text-primary me-1"></i><?php echo e($catName); ?>
        </span>
      </div>
    </div>

    <!-- Card Content -->
    <div class="course-card-body">
      <div class="d-flex justify-content-between align-items-center mb-1">
        <span class="course-card-category"><?php echo e($catName); ?></span>
        <span class="badge bg-light text-secondary border small"><?php echo e($level); ?></span>
      </div>

      <h3 class="course-card-title">
        <a href="<?php echo $detailsUrl; ?>">
          <?php echo e($courseName); ?>
        </a>
      </h3>

      <p class="course-card-desc">
        <?php echo e($shortDesc); ?>
      </p>

      <!-- Metadata Strip -->
      <div class="course-card-meta">
        <span><i class="bi bi-clock me-1 text-primary"></i><?php echo e($duration); ?></span>
        <span><i class="bi bi-mortarboard me-1 text-primary"></i>Certificate</span>
      </div>

      <!-- Footer & Action -->
      <div class="course-card-footer">
        <div class="course-card-price">
          <?php echo format_price($price, true); ?>
        </div>

        <a href="<?php echo $detailsUrl; ?>" class="btn btn-outline-primary btn-sm px-3 py-1.5 rounded-pill">
          View Course <i class="bi bi-arrow-right ms-1"></i>
        </a>
      </div>
    </div>
  </article>
</div>
