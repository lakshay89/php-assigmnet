<?php
/**
 * Dynamic Courses Listing Page & Category Filter
 * EdTech Innovate - Online Course Website
 * 
 * Fetches published courses from MySQL with real-time category filtering.
 * Safe allowlisting and prepared statements for all parameters.
 */

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';

// 1. Fetch all active categories from MySQL
$categories = get_all_categories();

// 2. Handle category filter safely
$selectedCategorySlug = trim($_GET['category'] ?? '');
$selectedCategory = null;
$categoryId = null;
$invalidCategoryNotice = false;

if ($selectedCategorySlug !== '' && $selectedCategorySlug !== 'all') {
    $selectedCategory = get_category_by_slug($selectedCategorySlug);
    if ($selectedCategory) {
        $categoryId = (int)$selectedCategory['id'];
    } else {
        // Safe handling for invalid category slug in query string
        $invalidCategoryNotice = true;
    }
}

// 3. Fetch published courses
$courses = get_published_courses($categoryId);
$totalPublishedCount = count($courses);

// 4. Set Dynamic SEO Metadata
if ($selectedCategory) {
    $pageTitle = $selectedCategory['name'] . ' Courses & Certifications | ' . SITE_NAME;
    $pageDescription = !empty($selectedCategory['description']) 
        ? $selectedCategory['description'] 
        : ('Explore our top-rated ' . $selectedCategory['name'] . ' courses, bootcamps, and career certifications.');
} else {
    $pageTitle = 'Explore In-Demand Tech Courses & Programs | ' . SITE_NAME;
    $pageDescription = 'Browse our industry-curated online course catalog across Web Development, Data Science, AI, Cloud Computing, and Cybersecurity.';
}

$canonicalUrl = base_url('courses.php' . ($selectedCategorySlug ? '?category=' . rawurlencode($selectedCategorySlug) : ''));
$currentRoute = 'courses.php';

include __DIR__ . '/includes/header.php';
?>

<!-- Courses Catalog Header Banner -->
<section class="bg-white border-bottom py-5">
  <div class="container">
    <nav aria-label="breadcrumb" class="mb-2">
      <ol class="breadcrumb small">
        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><i class="bi bi-house-door me-1"></i>Home</a></li>
        <li class="breadcrumb-item <?php echo $selectedCategory ? '' : 'active'; ?>" <?php echo $selectedCategory ? '' : 'aria-current="page"'; ?>>
          <a href="<?php echo base_url('courses.php'); ?>">Courses</a>
        </li>
        <?php if ($selectedCategory): ?>
          <li class="breadcrumb-item active" aria-current="page"><?php echo e($selectedCategory['name']); ?></li>
        <?php endif; ?>
      </ol>
    </nav>

    <div class="row align-items-center">
      <div class="col-lg-8">
        <h1 class="display-6 fw-bold mb-2">
          <?php if ($selectedCategory): ?>
            <?php echo e($selectedCategory['name']); ?> Courses
          <?php else: ?>
            Explore All Tech Courses
          <?php endif; ?>
        </h1>
        <p class="text-secondary lead mb-0" style="font-size: 1.05rem;">
          <?php if ($selectedCategory && !empty($selectedCategory['description'])): ?>
            <?php echo e($selectedCategory['description']); ?>
          <?php else: ?>
            Gain practical, job-ready capabilities with industry-designed curriculums and live mentorship.
          <?php endif; ?>
        </p>
      </div>
      <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 fs-6">
          <i class="bi bi-mortarboard-fill me-1"></i> <strong><?php echo $totalPublishedCount; ?></strong> <?php echo $totalPublishedCount === 1 ? 'Program' : 'Programs'; ?> Available
        </span>
      </div>
    </div>
  </div>
</section>

<!-- Main Course Directory & Filter Controls -->
<section class="py-5">
  <div class="container">

    <!-- Invalid Category Alert Feedback -->
    <?php if ($invalidCategoryNotice): ?>
      <div class="alert alert-warning alert-dismissible fade show rounded-3 mb-4 d-flex align-items-center" role="alert">
        <i class="bi bi-exclamation-triangle-fill fs-4 me-3 text-warning"></i>
        <div>
          The requested category <code><?php echo e($selectedCategorySlug); ?></code> does not exist. Displaying all available courses below.
        </div>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>

    <!-- Category Filter Bar -->
    <div class="mb-4">
      <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 pb-3 border-bottom">
        <div class="d-flex flex-wrap align-items-center gap-2">
          <span class="fw-bold small text-secondary me-2"><i class="bi bi-funnel-fill me-1"></i> Filter By:</span>
          
          <!-- All Categories Pill -->
          <a href="<?php echo base_url('courses.php'); ?>" class="filter-pill <?php echo (!$selectedCategory && !$invalidCategoryNotice) ? 'active' : ''; ?>">
            All Domains
          </a>

          <!-- Dynamic Category Pills from MySQL -->
          <?php foreach ($categories as $cat): ?>
            <?php 
              $isActive = ($selectedCategory && $selectedCategory['slug'] === $cat['slug']);
              $filterUrl = base_url('courses.php?category=' . rawurlencode($cat['slug']));
            ?>
            <a href="<?php echo $filterUrl; ?>" class="filter-pill <?php echo $isActive ? 'active' : ''; ?>">
              <?php echo e($cat['name']); ?>
              <span class="badge rounded-pill bg-light text-dark small ms-1"><?php echo (int)$cat['course_count']; ?></span>
            </a>
          <?php endforeach; ?>
        </div>

        <?php if ($selectedCategory): ?>
          <a href="<?php echo base_url('courses.php'); ?>" class="btn btn-sm btn-outline-secondary rounded-pill">
            <i class="bi bi-x-circle me-1"></i> Clear Filter
          </a>
        <?php endif; ?>
      </div>
    </div>

    <!-- Courses Grid -->
    <?php if (!empty($courses)): ?>
      <div class="row g-4">
        <?php foreach ($courses as $course): ?>
          <?php include __DIR__ . '/templates/course-card.php'; ?>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <!-- Empty State -->
      <div class="row justify-content-center py-4">
        <div class="col-md-8 col-lg-6">
          <div class="empty-state p-5 bg-white shadow-sm">
            <div class="empty-state-icon">
              <i class="bi bi-inbox-fill"></i>
            </div>
            <h3 class="h4 fw-bold mb-2">No Courses Found</h3>
            <p class="text-secondary small mb-4">
              <?php if ($selectedCategory): ?>
                There are currently no published courses under <strong><?php echo e($selectedCategory['name']); ?></strong>. Please check back soon or browse our other learning tracks.
              <?php else: ?>
                No published courses are currently available in the database.
              <?php endif; ?>
            </p>
            <a href="<?php echo base_url('courses.php'); ?>" class="btn btn-primary rounded-pill px-4">
              <i class="bi bi-arrow-repeat me-1"></i> View All Courses
            </a>
          </div>
        </div>
      </div>
    <?php endif; ?>

  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
