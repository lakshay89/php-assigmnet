<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';

http_response_code(404);

$pageTitle = 'Page Not Found (404) | ' . SITE_NAME;
$pageDescription = 'The requested course or page could not be located. Browse our course catalog to find relevant programs.';

include __DIR__ . '/includes/header.php';
?>

<div class="container py-5 my-md-5">
  <div class="row justify-content-center">
    <div class="col-md-8 col-lg-6 text-center">
      <div class="empty-state p-5 shadow-sm border-0 bg-white rounded-4">
        <div class="mb-3 text-warning">
          <i class="bi bi-exclamation-triangle-fill display-1 text-warning"></i>
        </div>
        <h1 class="h2 fw-bold mb-3">Course or Page Not Found</h1>
        <p class="text-secondary mb-4">
          The course you are looking for might have been unpublished, renamed, or is temporarily unavailable.
        </p>

        <div class="d-flex justify-content-center gap-3">
          <a href="<?php echo base_url('courses.php'); ?>" class="btn btn-primary rounded-pill px-4">
            <i class="bi bi-grid me-1"></i> Browse All Courses
          </a>
          <a href="<?php echo base_url(); ?>" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="bi bi-house me-1"></i> Return Home
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
