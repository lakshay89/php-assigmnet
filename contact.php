<?php
/**
 * Contact Us Page & Inquiries Handler
 * EdTech Innovate - Online Course Website
 * 
 * Features:
 * - Server-side validation with strict email and length filters
 * - Client-side validation (Bootstrap 5 needs-validation)
 * - CSRF token generation and validation
 * - POST/Redirect/GET pattern to prevent accidental duplicate submission
 * - Persistent storage in MySQL (contact_messages table) with prepared statements
 */

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';

// Handle Form Submission (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrfToken = $_POST['csrf_token'] ?? '';
    
    // 1. Verify CSRF Token
    if (!verify_csrf_token($csrfToken)) {
        set_flash('danger', 'Security validation failed (Invalid CSRF token). Please refresh and submit again.');
        header('Location: ' . base_url('contact.php'));
        exit;
    }

    // 2. Sanitize and Extract Input
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    $errors = [];

    // 3. Server-Side Validation Rules
    if ($name === '') {
        $errors['name'] = 'Full name is required.';
    } elseif (mb_strlen($name) < 2 || mb_strlen($name) > 100) {
        $errors['name'] = 'Name must be between 2 and 100 characters.';
    }

    if ($email === '') {
        $errors['email'] = 'Email address is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid, well-formed email address.';
    } elseif (mb_strlen($email) > 190) {
        $errors['email'] = 'Email address is too long (maximum 190 characters).';
    }

    if ($subject === '') {
        $errors['subject'] = 'Subject is required.';
    } elseif (mb_strlen($subject) < 3 || mb_strlen($subject) > 200) {
        $errors['subject'] = 'Subject must be between 3 and 200 characters.';
    }

    if ($message === '') {
        $errors['message'] = 'Message content is required.';
    } elseif (mb_strlen($message) < 10) {
        $errors['message'] = 'Please provide more details (minimum 10 characters).';
    } elseif (mb_strlen($message) > 3000) {
        $errors['message'] = 'Message is too long (maximum 3,000 characters).';
    }

    // 4. Handle Validation Failures
    if (!empty($errors)) {
        $_SESSION['form_errors'] = $errors;
        $_SESSION['form_old'] = [
            'name'    => $name,
            'email'   => $email,
            'subject' => $subject,
            'message' => $message
        ];
        set_flash('danger', 'Please correct the validation errors below and re-submit.');
        header('Location: ' . base_url('contact.php'));
        exit;
    }

    // 5. Persist to Database via Prepared Statements
    try {
        $saved = save_contact_message([
            'name'    => $name,
            'email'   => $email,
            'subject' => $subject,
            'message' => $message
        ]);

        if ($saved) {
            set_flash('success', 'Thank you, ' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '! Your inquiry has been securely recorded. Our admissions team will get back to you shortly.');
        } else {
            set_flash('danger', 'Unable to record your inquiry at this moment. Please try again later.');
        }
    } catch (Exception $e) {
        error_log('Contact Submission Error: ' . $e->getMessage());
        set_flash('danger', 'A database error occurred while saving your message. Please try again later.');
    }

    // 6. POST/Redirect/GET completion
    header('Location: ' . base_url('contact.php'));
    exit;
}

// Retrieve Flash Messages & Form Old Input
$flashSuccess = get_flash('success');
$flashDanger  = get_flash('danger');
$formErrors   = $_SESSION['form_errors'] ?? [];
$formOld      = $_SESSION['form_old'] ?? [];
unset($_SESSION['form_errors'], $_SESSION['form_old']);

// Pre-fill subject if passed via GET query parameter (e.g. from Course Details)
$prefillSubject = trim($_GET['subject'] ?? ($formOld['subject'] ?? ''));

$pageTitle = 'Contact Admissions & Support | ' . SITE_NAME;
$pageDescription = 'Reach out to our academic advisors, course mentors, and support team. We are here to help you accelerate your technical career.';
$canonicalUrl = base_url('contact.php');
$currentRoute = 'contact.php';

include __DIR__ . '/includes/header.php';
?>

<!-- Contact Header Banner -->
<section class="bg-white border-bottom py-5">
  <div class="container py-lg-3">
    <div class="row align-items-center">
      <div class="col-lg-8">
        <nav aria-label="breadcrumb" class="mb-2">
          <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><i class="bi bi-house-door me-1"></i>Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Contact</li>
          </ol>
        </nav>
        <h1 class="display-6 fw-bold mb-2">Get in Touch with Our Team</h1>
        <p class="text-secondary lead mb-0" style="font-size: 1.05rem;">
          Have questions regarding syllabus details, enrollment fees, or prerequisite tracks? We are here to help.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- Main Contact Section -->
<section class="py-5">
  <div class="container">
    <div class="row g-4 g-lg-5">

      <!-- Left Column: Contact Form -->
      <div class="col-lg-7">
        <div class="card border-0 rounded-4 shadow-sm p-4 p-md-5 bg-white">
          <h2 class="h4 fw-bold mb-2">Send an Inquiry</h2>
          <p class="text-secondary small mb-4">
            Fill in the details below. All submissions are validated server-side and recorded securely.
          </p>

          <!-- Flash Notification Banners -->
          <?php if ($flashSuccess): ?>
            <div class="alert alert-success alert-dismissible fade show rounded-3 d-flex align-items-start mb-4" role="alert">
              <i class="bi bi-check-circle-fill fs-4 me-3 text-success"></i>
              <div>
                <strong>Submission Received!</strong><br>
                <?php echo e($flashSuccess); ?>
              </div>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>

          <?php if ($flashDanger): ?>
            <div class="alert alert-danger alert-dismissible fade show rounded-3 d-flex align-items-start mb-4" role="alert">
              <i class="bi bi-exclamation-triangle-fill fs-4 me-3 text-danger"></i>
              <div>
                <strong>Action Needed:</strong><br>
                <?php echo e($flashDanger); ?>
              </div>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>

          <!-- Contact Form with POST / Redirect / GET & CSRF -->
          <form action="<?php echo base_url('contact.php'); ?>" method="POST" class="needs-validation" novalidate id="contact-form">
            <!-- CSRF Protection Token -->
            <input type="hidden" name="csrf_token" value="<?php echo e(get_csrf_token()); ?>">

            <div class="row g-3">
              <!-- Name Field -->
              <div class="col-md-6">
                <label for="contact-name" class="form-label fw-semibold small">Your Full Name <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text bg-light text-muted"><i class="bi bi-person"></i></span>
                  <input 
                    type="text" 
                    class="form-control <?php echo isset($formErrors['name']) ? 'is-invalid' : ''; ?>" 
                    id="contact-name" 
                    name="name" 
                    placeholder="e.g. John Doe"
                    value="<?php echo e($formOld['name'] ?? ''); ?>" 
                    required 
                    minlength="2" 
                    maxlength="100"
                    autocomplete="name"
                  >
                  <div class="invalid-feedback">
                    <?php echo e($formErrors['name'] ?? 'Please enter your full name (at least 2 characters).'); ?>
                  </div>
                </div>
              </div>

              <!-- Email Field -->
              <div class="col-md-6">
                <label for="contact-email" class="form-label fw-semibold small">Email Address <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text bg-light text-muted"><i class="bi bi-envelope"></i></span>
                  <input 
                    type="email" 
                    class="form-control <?php echo isset($formErrors['email']) ? 'is-invalid' : ''; ?>" 
                    id="contact-email" 
                    name="email" 
                    placeholder="name@example.com"
                    value="<?php echo e($formOld['email'] ?? ''); ?>" 
                    required 
                    maxlength="190"
                    autocomplete="email"
                  >
                  <div class="invalid-feedback">
                    <?php echo e($formErrors['email'] ?? 'Please enter a valid email address.'); ?>
                  </div>
                </div>
              </div>

              <!-- Subject Field -->
              <div class="col-12">
                <label for="contact-subject" class="form-label fw-semibold small">Subject <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text bg-light text-muted"><i class="bi bi-chat-left-text"></i></span>
                  <input 
                    type="text" 
                    class="form-control <?php echo isset($formErrors['subject']) ? 'is-invalid' : ''; ?>" 
                    id="contact-subject" 
                    name="subject" 
                    placeholder="e.g. Question about Web Development Bootcamp"
                    value="<?php echo e($prefillSubject); ?>" 
                    required 
                    minlength="3" 
                    maxlength="200"
                  >
                  <div class="invalid-feedback">
                    <?php echo e($formErrors['subject'] ?? 'Please provide a subject line (at least 3 characters).'); ?>
                  </div>
                </div>
              </div>

              <!-- Message Field -->
              <div class="col-12">
                <label for="contact-message" class="form-label fw-semibold small">Message Content <span class="text-danger">*</span></label>
                <textarea 
                  class="form-control <?php echo isset($formErrors['message']) ? 'is-invalid' : ''; ?>" 
                  id="contact-message" 
                  name="message" 
                  rows="5" 
                  placeholder="Share details of your inquiry or career goals..."
                  required 
                  minlength="10" 
                  maxlength="3000"
                ><?php echo e($formOld['message'] ?? ''); ?></textarea>
                <div class="invalid-feedback">
                  <?php echo e($formErrors['message'] ?? 'Please enter your message (at least 10 characters).'); ?>
                </div>
                <div class="form-text small text-muted">
                  Max 3,000 characters. Your message is safely stored in our MySQL inquiry log.
                </div>
              </div>

              <!-- Submit Button -->
              <div class="col-12 mt-4">
                <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold">
                  <i class="bi bi-send-fill me-2"></i> Submit Inquiry
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- Right Column: Contact Details & Info Cards -->
      <div class="col-lg-5">
        <div class="d-flex flex-column gap-4">
          <!-- Card 1: Direct Support -->
          <div class="card border-0 rounded-4 shadow-sm p-4 bg-white">
            <div class="d-flex align-items-center gap-3 mb-3">
              <div class="category-icon-box" style="width: 48px; height: 48px; font-size: 1.3rem;">
                <i class="bi bi-envelope-at"></i>
              </div>
              <div>
                <h3 class="h6 fw-bold mb-0">Admissions &amp; Academic Help</h3>
                <span class="text-muted small">Response time: Within 24 Hours</span>
              </div>
            </div>
            <p class="text-secondary small mb-1">
              General Inquiries: <a href="mailto:admissions@edtechinnovate.com" class="text-primary fw-semibold">admissions@edtechinnovate.com</a>
            </p>
            <p class="text-secondary small mb-0">
              Technical Support: <a href="mailto:support@edtechinnovate.com" class="text-primary fw-semibold">support@edtechinnovate.com</a>
            </p>
          </div>

          <!-- Card 2: Campus Location -->
          <div class="card border-0 rounded-4 shadow-sm p-4 bg-white">
            <div class="d-flex align-items-center gap-3 mb-3">
              <div class="category-icon-box" style="width: 48px; height: 48px; font-size: 1.3rem;">
                <i class="bi bi-building"></i>
              </div>
              <div>
                <h3 class="h6 fw-bold mb-0">Innovation Campus</h3>
                <span class="text-muted small">Visit Our Training Center</span>
              </div>
            </div>
            <p class="text-secondary small mb-2">
              EdTech Innovate Pvt Ltd.<br>
              Building 4, Sector 62, Electronic City,<br>
              Noida, Uttar Pradesh 201309, India
            </p>
            <p class="text-secondary small mb-0">
              <i class="bi bi-telephone-fill me-1 text-primary"></i> Phone: +91 (120) 456-7890
            </p>
          </div>

          <!-- Card 3: Operating Hours -->
          <div class="card border-0 rounded-4 shadow-sm p-4 bg-white">
            <div class="d-flex align-items-center gap-3 mb-3">
              <div class="category-icon-box" style="width: 48px; height: 48px; font-size: 1.3rem;">
                <i class="bi bi-clock-history"></i>
              </div>
              <div>
                <h3 class="h6 fw-bold mb-0">Operating Hours</h3>
                <span class="text-muted small">Admissions Open 6 Days a Week</span>
              </div>
            </div>
            <ul class="list-unstyled small text-secondary mb-0 d-flex flex-column gap-1">
              <li class="d-flex justify-content-between">
                <span>Monday – Friday:</span>
                <strong>9:00 AM – 7:00 PM IST</strong>
              </li>
              <li class="d-flex justify-content-between">
                <span>Saturday:</span>
                <strong>10:00 AM – 4:00 PM IST</strong>
              </li>
              <li class="d-flex justify-content-between text-muted">
                <span>Sunday:</span>
                <span>Closed (Online Portal Active)</span>
              </li>
            </ul>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
