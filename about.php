<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';

$pageTitle = 'About Us | ' . SITE_NAME;
$pageDescription = 'Discover the mission and learning methodology behind EdTech Innovate. Practical full-stack engineering, cloud architecture, and modern tech skills.';
$canonicalUrl = base_url('about.php');
$currentRoute = 'about.php';

include __DIR__ . '/includes/header.php';
?>

<section class="bg-white border-bottom py-5">
  <div class="container py-lg-4">
    <div class="row align-items-center g-5">
      <div class="col-lg-7">
        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 fw-semibold mb-3">
          Our Educational Philosophy
        </span>
        <h1 class="display-5 fw-bold mb-3">Empowering Tech Learners with Applied Engineering</h1>
        <p class="lead text-secondary mb-4" style="font-size: 1.15rem;">
          At <strong><?php echo e(SITE_NAME); ?></strong>, we believe mastery is built by writing code, designing normalized relational schemas, and deploying real systems—not by passively memorizing slides.
        </p>
        <div class="d-flex flex-wrap gap-3">
          <a href="<?php echo base_url('courses.php'); ?>" class="btn btn-primary rounded-pill px-4">
            <i class="bi bi-grid-fill me-1"></i> Explore Our Courses
          </a>
          <a href="<?php echo base_url('contact.php'); ?>" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="bi bi-envelope me-1"></i> Contact Admissions
          </a>
        </div>
      </div>
      <div class="col-lg-5">
        <div class="card border-0 rounded-4 shadow-sm p-4 p-md-5 bg-light-subtle">
          <h2 class="h5 fw-bold mb-3 text-primary"><i class="bi bi-bullseye me-2"></i>Our Mission</h2>
          <p class="text-secondary small mb-4">
            To provide transparent, project-centered technical education that enables aspiring developers, designers, and systems architects to transition into high-impact engineering roles.
          </p>
          <h2 class="h5 fw-bold mb-3 text-primary"><i class="bi bi-eye me-2"></i>Our Vision</h2>
          <p class="text-secondary small mb-0">
            A global community where modern technical skills are accessible, rigorous, and directly mapped to enterprise standards.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="py-5">
  <div class="container py-lg-4">
    <div class="text-center mb-5">
      <span class="text-primary fw-bold text-uppercase small">Methodology</span>
      <h2 class="display-6 fw-bold mb-2">Our Three Core Learning Pillars</h2>
      <p class="text-secondary mx-auto" style="max-width: 600px;">
        Every course in our catalog is built around these fundamental standards.
      </p>
    </div>

    <div class="row g-4">
      <div class="col-md-4">
        <div class="card border-0 rounded-4 shadow-sm p-4 h-100 bg-white">
          <div class="mb-3 text-primary fs-1">
            <i class="bi bi-code-square"></i>
          </div>
          <h3 class="h5 fw-bold mb-2">1. Applied Production Labs</h3>
          <p class="text-secondary small mb-0">
            Students build complete web applications featuring semantic HTML5 markup, responsive Bootstrap 5 grids, server-side Core PHP routing, and normalized MySQL schemas with PDO prepared statements.
          </p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card border-0 rounded-4 shadow-sm p-4 h-100 bg-white">
          <div class="mb-3 text-primary fs-1">
            <i class="bi bi-shield-lock"></i>
          </div>
          <h3 class="h5 fw-bold mb-2">2. Security by Default</h3>
          <p class="text-secondary small mb-0">
            Defensive engineering is taught from lesson one: XSS mitigation with <code>htmlspecialchars</code>, SQL injection prevention through parameterized queries, CSRF token validation, and strict input allowlisting.
          </p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card border-0 rounded-4 shadow-sm p-4 h-100 bg-white">
          <div class="mb-3 text-primary fs-1">
            <i class="bi bi-graph-up-arrow"></i>
          </div>
          <h3 class="h5 fw-bold mb-2">3. Measurable Progression</h3>
          <p class="text-secondary small mb-0">
            Each module culminates in a milestone deliverable evaluated against comprehensive technical rubrics, simulating real code-review cycles and agile sprints.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="py-5 bg-light-subtle border-top border-bottom">
  <div class="container py-lg-4">
    <div class="row align-items-center g-5">
      <div class="col-lg-6">
        <span class="text-primary fw-bold text-uppercase small">Clean &amp; Maintainable</span>
        <h2 class="display-6 fw-bold mb-3">Architected with Core Web Standards</h2>
        <p class="text-secondary mb-4">
          This platform is proudly engineered with foundational, robust web technologies without bloat:
        </p>
        <ul class="list-unstyled d-flex flex-column gap-3">
          <li class="d-flex align-items-start gap-3">
            <i class="bi bi-check-circle-fill text-success fs-5 mt-1"></i>
            <div>
              <strong>HTML5 &amp; Bootstrap 5</strong>
              <div class="text-secondary small">Responsive layouts, mobile-first fluid grids, and accessible ARIA attributes.</div>
            </div>
          </li>
          <li class="d-flex align-items-start gap-3">
            <i class="bi bi-check-circle-fill text-success fs-5 mt-1"></i>
            <div>
              <strong>Core PHP 8+ Server Architecture</strong>
              <div class="text-secondary small">Fast server-side rendering, centralized routing, CSRF token protection, and reusable templates.</div>
            </div>
          </li>
          <li class="d-flex align-items-start gap-3">
            <i class="bi bi-check-circle-fill text-success fs-5 mt-1"></i>
            <div>
              <strong>MySQL &amp; PDO Security</strong>
              <div class="text-secondary small">Relational data persistence, indexed slugs, foreign keys, and 100% prepared statement coverage.</div>
            </div>
          </li>
        </ul>
      </div>
      <div class="col-lg-6">
        <div class="p-4 bg-dark text-white rounded-4 shadow font-monospace small">
          <div class="text-muted pb-2 border-bottom border-secondary mb-3">
            // Architecture Principles
          </div>
          <div class="text-success">// 1. Zero SQL concatenation</div>
          <div class="text-light">$stmt = $db-&gt;prepare("SELECT * FROM courses WHERE slug = :slug");</div>
          <div class="text-light">$stmt-&gt;execute([':slug' =&gt; $slug]);</div>
          <br>
          <div class="text-success">// 2. Dynamic SEO generation</div>
          <div class="text-light">&lt;title&gt;&lt;?= e($course['name']) ?&gt; | EdTech Innovate&lt;/title&gt;</div>
          <br>
          <div class="text-success">// 3. Reusable template component</div>
          <div class="text-light">include __DIR__ . '/templates/course-card.php';</div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="py-5 text-center">
  <div class="container py-3">
    <h2 class="display-6 fw-bold mb-3">Start Building Your Skills Today</h2>
    <p class="text-secondary mb-4 mx-auto" style="max-width: 500px;">
      Explore our published curriculum or get in touch with our admissions team.
    </p>
    <a href="<?php echo base_url('courses.php'); ?>" class="btn btn-primary rounded-pill px-4 me-2">Browse All Courses</a>
    <a href="<?php echo base_url('contact.php'); ?>" class="btn btn-outline-secondary rounded-pill px-4">Contact Us</a>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
