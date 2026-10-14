<?php
/**
 * Global Footer Component
 * EdTech Innovate - Online Course Website
 */
?>
</main>

<!-- Professional Site Footer -->
<footer class="site-footer mt-auto" role="contentinfo">
  <div class="container">
    <div class="row g-4 g-lg-5">
      <!-- Col 1: Brand Info -->
      <div class="col-lg-4">
        <div class="mb-3">
          <img src="<?php echo base_url('assets/images/logo.svg'); ?>" alt="<?php echo e(SITE_NAME); ?>" height="38" style="filter: brightness(0) invert(1);">
        </div>
        <p class="text-light-subtle small mb-4" style="max-width: 340px; color: #94a3b8;">
          Industry-focused practical education designed to equip you with real-world engineering, design, and cloud architecture capabilities.
        </p>
        <div class="d-flex gap-2">
          <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle text-white border-secondary" aria-label="LinkedIn" style="width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center;">
            <i class="bi bi-linkedin"></i>
          </a>
          <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle text-white border-secondary" aria-label="GitHub" style="width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center;">
            <i class="bi bi-github"></i>
          </a>
          <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle text-white border-secondary" aria-label="Twitter / X" style="width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center;">
            <i class="bi bi-twitter-x"></i>
          </a>
          <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle text-white border-secondary" aria-label="YouTube" style="width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center;">
            <i class="bi bi-youtube"></i>
          </a>
        </div>
      </div>

      <!-- Col 2: Quick Links -->
      <div class="col-6 col-lg-2">
        <h5 class="fw-bold">Platform</h5>
        <ul class="list-unstyled d-flex flex-column gap-2 small">
          <li><a href="<?php echo base_url(); ?>"><i class="bi bi-chevron-right me-1 small"></i> Home</a></li>
          <li><a href="<?php echo base_url('courses.php'); ?>"><i class="bi bi-chevron-right me-1 small"></i> All Courses</a></li>
          <li><a href="<?php echo base_url('about.php'); ?>"><i class="bi bi-chevron-right me-1 small"></i> About Platform</a></li>
          <li><a href="<?php echo base_url('contact.php'); ?>"><i class="bi bi-chevron-right me-1 small"></i> Contact Us</a></li>
        </ul>
      </div>

      <!-- Col 3: Popular Categories -->
      <div class="col-6 col-lg-3">
        <h5 class="fw-bold">Top Domains</h5>
        <ul class="list-unstyled d-flex flex-column gap-2 small">
          <li><a href="<?php echo base_url('courses.php?category=web-development'); ?>"><i class="bi bi-chevron-right me-1 small"></i> Web Development</a></li>
          <li><a href="<?php echo base_url('courses.php?category=data-science-ai'); ?>"><i class="bi bi-chevron-right me-1 small"></i> Data Science &amp; AI</a></li>
          <li><a href="<?php echo base_url('courses.php?category=ui-ux-design'); ?>"><i class="bi bi-chevron-right me-1 small"></i> UI/UX Design Systems</a></li>
          <li><a href="<?php echo base_url('courses.php?category=cloud-devops'); ?>"><i class="bi bi-chevron-right me-1 small"></i> Cloud Architecture</a></li>
          <li><a href="<?php echo base_url('courses.php?category=cybersecurity'); ?>"><i class="bi bi-chevron-right me-1 small"></i> Ethical Hacking</a></li>
        </ul>
      </div>

      <!-- Col 4: Contact & Support -->
      <div class="col-lg-3">
        <h5 class="fw-bold">Get In Touch</h5>
        <p class="small text-light-subtle mb-2" style="color: #94a3b8;">
          <i class="bi bi-geo-alt me-2 text-primary"></i> Tech Innovation Park, Sector 62, Noida
        </p>
        <p class="small text-light-subtle mb-2" style="color: #94a3b8;">
          <i class="bi bi-envelope me-2 text-primary"></i> admissions@edtechinnovate.com
        </p>
        <p class="small text-light-subtle mb-3" style="color: #94a3b8;">
          <i class="bi bi-telephone me-2 text-primary"></i> +91 (120) 456-7890
        </p>
        <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2">
          <i class="bi bi-check-circle-fill me-1"></i> Admissions Open for 2026
        </span>
      </div>
    </div>

    <!-- Bottom Copyright -->
    <div class="footer-bottom d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
      <div>
        &copy; <?php echo date('Y'); ?> <?php echo e(SITE_NAME); ?> Pvt Ltd. All rights reserved. Built with Core PHP, MySQL &amp; Bootstrap 5.
      </div>
      <div class="d-flex gap-4">
        <a href="<?php echo base_url('about.php'); ?>">Privacy Policy</a>
        <a href="<?php echo base_url('about.php'); ?>">Terms of Service</a>
        <a href="<?php echo base_url('contact.php'); ?>">Support</a>
      </div>
    </div>
  </div>
</footer>

<!-- Bootstrap 5.3 JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<!-- Master Client JavaScript -->
<script src="<?php echo base_url('assets/js/main.js'); ?>"></script>
</body>
</html>
